<?php
namespace app\index\controller;
use app\common\controller\Ajax;
use think\Controller;
use think\Db;

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: HEAD, GET, POST, DELETE, PUT, OPTIONS");
/*
 *
 *查询倍投计划表数据
 */
class Plan extends Controller {
	public function watch() {

		$plan = db::query('select * from plan left join lottery on plan.abort=lottery.issue'); //联合查询计划表和开奖数据表

		foreach ($plan as $key => $value) {

			if (!empty($plan)) {
				//如果开奖表数据存在

				if ($value['forecast'] == $value['result']) {
					//如果开奖表的结果和计划表中的结果一样

					$vv = [
						'pres' => 1, //中奖
					];
					$ress = db('plan')->where('abort', $value['issue'])->update($vv);
				} else {

					$vv = [
						'pres' => 0, //不中奖
					];
					$ress = db('plan')->where('abort', $value['issue'])->update($vv);
				}

			}

		}

		// $total = count(db::query('select  * from plan')); //数据总数
		// $num = 10; //每页显示条数
		// $pagenum = ceil($total / $num); //总页数
		// //$cpage = isset($_GET["page"]) ? $_GET["page"] : 1; //当前页
		// $cpage = $_POST["page"];
		// $offset = ($cpage - 1) * $num; //开始取数据的位置

		//$res = db::query("select * from plan limit {$offset},{$num}"); //分页查询
		$res = db('plan')->order('Id desc')->select();
		$ress = db('plan')->order('Id desc')->find(); //查询最新一条文字分析
		//$start = $offset + 1; //开始记录页
		//$end = ($cpage == $pagenum) ? $total : ($cpage * $num); //结束记录页
		//$next = ($cpage == $pagenum) ? 0 : ($cpage + 1); //下一页
		//$prev = ($cpage == 1) ? 0 : ($cpage - 1); //前一页
		// echo "<pre>";
		$result = array();
		if ($ress) {
			$result["code"] = 1;
			$result['analyze'] = $ress['analyze'];
			$result["result"] = $res;

		} else {
			$result["code"] = 0;
			$result["msg"] = "暂无数据";
		}
		// return json_encode($result);
		$c = new Ajax();
		$c->ajaxReturn($result);
		// $this->assign('plan', $res);
		// return $this->fetch();

	}
}