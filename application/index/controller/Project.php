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
class Project extends Controller {
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
		$ress = db('project')->order('Id desc')->find(); //查询最新一条文字分析

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
	}
}