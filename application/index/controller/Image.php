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
class Image extends Controller {
	public function watch() {
		$slide = db('image')->field('id,title,image')->where('image', 'neq', '')->order('created DESC')->limit(5)->select();

		foreach ($slide as $key => $value) {
			$array[$key]['id'] = $value['id'];
			$array[$key]['title'] = $value['title'];
			$array[$key]['image'] = $_SERVER['HTTP_HOST'] . '/static/uploads/' . $value['image'];
		}

		$result = array();

		if ($slide) {
			$result["code"] = 1;
			$result["result"] = $array;

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