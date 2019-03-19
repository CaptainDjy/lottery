<?php
namespace app\index\controller;
use app\common\controller\Ajax;
use think\Controller;
use think\Db;

/**
 *
 */
header("Access-Control-Allow-Origin: *");
// 响应头设置
header('Access-Control-Allow-Headers:x-requested-with,content-type');
class Index extends Controller {

	public function index() {

		$db = Db::table('lottery');
		//最近是和一期
		$hq = db('lottery')
			->where('result', '=', '2')
			->order('issue DESC')
			->limit(1)
			->find();
		//最近一期
		$b = db('lottery')
			->order('issue DESC')
			->limit(1)
			->find();
		//两者相减距离上次开和的期数
		$a = $b['Id'] - $hq['Id'];
		//分页查询
		// $total = count(db::query('select  * from lottery')); //数据总数
		// $num = 20; //每页显示条数
		// $pagenum = ceil($total / $num); //总页数
		// $cpage = $_POST["page"]; //当前页
		// $offset = ($cpage - 1) * $num; //开始去数据的位置

		// $res = db::query("select * from lottery order by Id DESC limit {$offset},{$num}"); //分页查询
		$res = db('lottery')->order('Id desc')->select();
		$result = array();
		if ($res) {
			$result["code"] = 1;
			$result['hq'] = $a;
			$result["result"] = $res;

		} else {
			$result["code"] = 0;
			$result["msg"] = "暂无数据";
		}
		// return json_encode();
		$c = new AJax();
		$c->ajaxReturn($result);

		// return $result;
		// $this->assign('res', $res);
		// $this->assign('root', $a);
		// return $this->fetch();
	}

	public function three() {
		$res = db('lottery')->order('Id desc')->limit(300)->select();

		$result = array();
		if ($res) {
			$result["code"] = 1;
			$result["result"] = $res;

		} else {
			$result["code"] = 0;
			$result["msg"] = "暂无数据";
		}
		// return json_encode($result);
		$c = new AJax();
		$c->ajaxReturn($result);
	}
}