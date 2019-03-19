<?php
namespace app\admin\controller;
use app\common\controller\Admin;
use think\Controller;
use think\Db;
use think\Request;

/**
 *
 */
class Project extends Admin {

	//计划列表
	public function watch() {
		$project = db::query('select * from project left join lottery on project.abort=lottery.issue'); //联合查询计划表和开奖数据表
		foreach ($project as $key => $value) {
			if (!empty($project)) {
				//如果开奖表数据存在
				if ($value['forecast'] == $value['result']) {
					//如果开奖表的结果和计划表中的结果一样
					$vv = [
						'pres' => 1, //中奖
					];
					$ress = db('project')->where('abort', $value['issue'])->update($vv);
				} else {

					$vv = [
						'pres' => 0, //不中奖
					];
					$ress = db('project')->where('abort', $value['issue'])->update($vv);
				}

			}

		}
		$res = db('project')->order('Id desc')->select();
		$ress = db('project')->order('Id desc')->find(); //查询最新的一条
		$this->assign(['project' => $res, 'analyze' => $ress]);
		return $this->fetch();

	}

	//跳转添加计划
	public function add() {
		return $this->fetch();
	}
	//执行添加计划
	public function addproject() {
		$data = request()->param(); //接收表单数据
		// print_r($data['analyze']);
		// exit;
		$str = $data['period']; //计划期间
		$strint = preg_replace('/\D/s', '', $str); //计划期间取数字
		$abort = str_pad($data['abort'], 3, "0", STR_PAD_LEFT);
		$issue = $strint . $abort; //拼接上最终截止期数

		$result = db('lottery')->where('issue', $issue)->select(); //根据期数查询开奖表中数据

		$res = db('project')->select(); //计划表中数据
		//判断如果预测期数已存在无法添加
		foreach ($res as $key => $value) {
			if ($issue == $value['abort']) {
				return $this->error('预测的期数已存在');
			}
		}

		if ($data['forecast'] == '龙') {
			$data['forecast'] = 0;
		} elseif ($data['forecast'] == '虎') {
			$data['forecast'] = 1;
		} elseif ($data['forecast'] == '和') {
			$data['forecast'] = 2;
		} else {
			$this->error('当前预测值输入错误');
		}
		//如果从开奖表查到数据,并和预测结果一样,则是中奖($a=1),否则不中($a=0),没查到数据未开奖($a=2)
		if (!empty($result)) {

			if ($result['0']['result'] == $data['forecast']) {
				$a = 1;
			} else {
				$a = 0;
			}
			$value = [
				'period' => $data['period'], //预测期间
				'abort' => $issue, //预测期数
				'forecast' => $data['forecast'], //预测值
				'pres' => $a, //计划结果
				'analyze' => $data['analyze'], //文字分析
			];
			$res = db('project')->insert($value);

		} else {
			$a = 2;
			$value = [
				'period' => $data['period'],
				'abort' => $issue,
				'pres' => $a,
				'forecast' => $data['forecast'],
				'analyze' => $data['analyze'], //文字分析
			];

			$res = db('project')->insert($value); //奖判断结果插入数据表
		}
		return $this->redirect(url('admin/project/watch'));
	}

	//删除计划  根据id删除计划如果成功返回当前页,失败则返回删除失败
	public function deleteproject($id) {
		$res = db('project')->delete($id);
		if ($res) {
			return $this->redirect(url('admin/project/watch'));
		} else {
			return $this->error('删除失败');
		}
	}
	//修改计划页面  获取ID查询当前id的内容  前端获取内容
	public function amend() {
		$id = request()->param()['id'];
		$data = db('project')->find($id);
		$this->assign('data', $data);
		return $this->fetch();
	}
	//修改计划  获取要修改的ID 接收表单数据 重新赋值 添加到数据库
	public function updateproject(Request $request) {
		$data = request()->param();
		$id = $data['id'];

		$str = $data['period']; //计划期间
		$strint = preg_replace('/\D/s', '', $str); //计划期间取数字
		$abort = str_pad($data['abort'], 3, "0", STR_PAD_LEFT);
		$issue = $strint . $abort; //拼接上最终截止期数
		$result = db('lottery')->where('issue', $issue)->select(); //根据期数查询开奖表中数据
		$res = db('project')->select(); //计划表中数据

		if ($data['forecast'] == '龙') {
			$data['forecast'] = 0;
		} elseif ($data['forecast'] == '虎') {
			$data['forecast'] = 1;
		} elseif ($data['forecast'] == '和') {
			$data['forecast'] = 2;
		} else {
			$this->error('当前预测值输入错误');
		}

		if (!empty($result)) {

			if ($result['0']['result'] == $data['forecast']) {
				$a = 1;
			} else {
				$a = 0;
			}
			$value = [
				'period' => $data['period'],
				'abort' => $issue,
				'pres' => $a,
				'forecast' => $data['forecast'],
				'analyze' => $data['analyze'],
			];
			// $res = db('project')->insert($value);

		} else {
			$a = 2;
			$value = [
				'period' => $data['period'],
				'abort' => $issue,
				'pres' => $a,
				'forecast' => $data['forecast'],
				'analyze' => $data['analyze'],
			];
		}

		if ($value) {
			$res = db('project')->where('id', $id)->update($value);
			return $this->redirect(url('admin/project/watch'));
		} else {
			return '0';
		}
	}

}