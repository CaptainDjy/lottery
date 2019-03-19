<?php
namespace app\index\command;
use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Db;

header("Access-Control-Allow-Origin: *");
class Test extends Command {

	protected function configure() {

		$this->setName('test')->setDescription('it is a test ');

	}

	protected function execute(Input $input, Output $output) {
		for ($i = 0; $i > -1; $i++) {
			//php指令无限循环
			sleep(3);
			$this->add();
			// echo $i;
		}
	}
	function add() {
		$jk = $this->jiekou(); //调用接口方法
		if (is_array($jk)) {
			//销毁接口多余数据
			unset($jk['rows']);
			unset($jk['code']);
			unset($jk['remain']);
			foreach ($jk as $key => $value) {
				$vv = $value['0'];
			}
		}
		$num = $vv['opencode'];
		$result = $this->result($num);
		$sfkj = $this->sfkj($num);
		$num = str_replace(',', ' ', $num);
		$db = Db::table('lottery');
		//截取字符串
		$w = substr($num, 0, 1);
		$q = substr($num, 2, 1);
		$b = substr($num, 4, 1);
		$s = substr($num, 6, 1);
		$g = substr($num, 8, 1);
		$v = substr($vv['opentime'], 0, 10);

		$last = db('lottery')->where('issue', 'eq', $vv['expect'])->count();
		if ($last == 0) {
			//判断是否存在重复数据，重复就不插入
			$lottery = [
				'issue' => $vv['expect'],
				'number' => $num,
				'dateline' => $v,
				'result' => $result,
				'state' => $sfkj,
				'w' => $w,
				'q' => $q,
				'b' => $b,
				's' => $s,
				'g' => $g,
			];
			$res = db('lottery')->insert($lottery);
		}
	}

	function result($num) {
		if (!empty($num)) {
			//对比万位和个位数字判断开奖结果
			if (substr($num, 0, 1) > substr($num, -1, 1)) {
				return '0';
			} elseif (substr($num, 0, 1) < substr($num, -1, 1)) {
				return '1';
			} else {
				return '2';
			}
		}
	}
	function sfkj($num) {
		//判断开奖号码是否存在
		if (!empty($num)) {
			return '已开奖';
		}
	}

	//接收接口数据
	function jiekou() {

		$src = 'http://c.apiplus.net/newly.do?token=tede7fadc05516f95k&code=cqssc&format=json';
		$html = file_get_contents($src);
		$array = json_decode($html, true);
		return $array;
	}
}