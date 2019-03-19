<?php
namespace app\index\controller;
use think\Db;

/**
 *
 */
header("Access-Control-Allow-Origin: *");
class Lottery {

    public function zhifu(){

        $appid = '2018040702515757';
        $pubkey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAqmW/rfenxAiwBNXus8DA9lX/VMAytQ9OsD3jbUhs7D/AqFngpVihPMdO+SauHeH8vaafi9EP/IEtJgGHLmx18tzHvr5iRezi5auKbKEOtH44DA8a4DUyJZIg5+ZqsXajllZGpuBdRuc3ImmyPXW3gsUFs8ezmIX8KJXmgYJkFp9dg/6uDzk3wfxzjjmAlW9yjZ+/F54rBmhB7hY5uWhaO44Ewfu9Z57H+cTP5v7cSxYq0LdfYJt0jX8fZ6lk/dgy7FwbCeEuT2xmJ+NuZfVQrOSobObTBLZJnL2VclEwmbL8Z0rriN2KYrkH+6UTqbLw14PL42GGcjWMYmmE2vQceQIDAQAB';
        $prikey = 'MIIEowIBAAKCAQEAuH689KYcDm/XUhlP2ndGMMStbToS2cGSojH4q2u6n0QVXJla4aNz8MfmcwDxFAVxGysQ7v3oNUk6Ymmfgfmz2TuroVb4RUb2f/8i04Ccotzhf3ZEwnqXjWxcwauAXtbtR2N/p+HYKa9DIpkOzOAzomgXQQaWspLLqUugaRqu6OD30X5w5j12skIWsD41SIrx5faSSvqBrLTXyN5TcSFeyf0MwJtpqJOdHvOT8z8Q0t2KAMdwi0OxR8CdlVQFYvzYjqbZQhszOVpdWh3FpZKWrAOa16a84vbg+Qufp6/RgyugV/b0X4FLKTjz7TLkfmGD4dbHuIksUhPQHTHj0v73lQIDAQABAoIBAF87pIPQfqkBGC9bu3l0mfmwfCjmkjZvEibBDrBFooZ1mWU8D8prGfzO4ui4Mrj3+iNg/pOu4r8mtol4JgrsfuaCQ5y7jNoNwE3fv/VW7QOwaoHl5aZRq4snxVV/FnteDAsOlCVvkaoqusfQI/CjRmPtwRsisIUq+w+/ZuT6DhFMthhBTXq0dqAH95uqU9BFMvvPjr6Yb7s2GIrDLn2aCAya7f3fgKkc73Z87zXWVn9RXTg2GyTND8IdMjoJwtptRL8feyeOmGmH8HnBDOBhoEziOVR820KfGcN9dRIIihbsb0JKWK/NwNbG1r7gMtgO5GjQWFV9RTWit4KFqajz9T0CgYEA6OqkZlRAGM0ofS5xc8xA3fSlgADw/w0jgbuqYYWmDh6ROF3NrJDTIuZjTBoYJxYWCLqDL+JJJCpnPRiEp0gtnioXe3arrmkTrvJolTi8fg4N29qv5kPIBvej8yFAtp00hhI5FfjLXZ6VcA4lx1eLvuzxH/V6tqN6sKELMo0p9qcCgYEAyseWZc28PwYBprzdS2+dHxT2g87E7HzCN1/GEDqtzOR1GGOE0m+bDzqUw0xTJHLO7qKeGTYn6fs4XXGSioRMkwrzrb6mAyycmi/oqIhkq3PQDvSvGcOtnnPcfw5ZR5DKFRVOJnzhSN6Ojo0YjtncV4pwk+3JEXlqHN1kUCHOY2MCgYAFqG2F7tX/xDwPjmlDHtsUiTTb/ynbiD4skJp68/wsq6FrdRvh7UKzvlT7LEcZ6/dtDtrQ9vY/4qfPXCEczywMg4k+fot9GSBZR5oyxcYOadj8VjufpFXflXRuG4iu5vK3rwmj9v85rviCWFWimgXTBX52AEiS1zXLxJ25BKTYUQKBgQCYZq6zLo/HchU1ooZTFryoypGHeJRqBE3XXkS2l9NdxWn3/XuqyLRqGqYJrchjAWJi2Zcm7ZvL78JqAFyZfFssvDNuJnYQtquv+kfKuk+myDDbvKwJGhbXms5iM3+IGNq4Q73rkTmkEZhkrMiDPFus82Au3aybVHwa241z6CR8bwKBgAKoP+m/F5JNZByLfMfqAUqlh0EzdayfAM3E3kgN1zR0jzvv+zrUDtTN/zLljelkKGwVcl9XF0Vt1pFXbpZ6s6E0wfPqI5tte2QLOTD8pkTILFnOL11cswLPbtSkkxPBhoy4zFTlOLDOfGUvurT3atVCCeROKDJxrRrtJ4HUq87f';
        $config = [
            'app_id' => $appid,
//            'notify_url' => Yii::$app->request->hostInfo.'/api/amoy/search/notify',//'http://yansongda.cn/notify.php',//通知地址
//            'return_url' => Yii::$app->request->hostInfo.'/api/amoy/search/notify',//返回地址
            //公钥
            'ali_public_key' => $pubkey,
            // 加密方式： **RSA2**
            //私钥
            'private_key' => $prikey,
            'log' => [ // optional
                'file' => './logs/alipay.log',
                'level' => 'info', // 建议生产环境等级调整为info，开发环境为 debug
                'type' => 'single', // optional, 可选 daily.
                'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
            ],
        ];

//        print_r($config);
//        exit;

        $order = [
            'out_trade_no' => time(),
            'total_amount' => '0.01',//支付金额
            'subject' => '充值',
        ];
// 将返回字符串，供后续 APP 调用，调用方式不在本文档讨论范围内，请参考官方文档。
        $result = \Yansongda\Pay\Pay::alipay($config)->app($order);//对,就是这么简单

        return $result;
    }




	public function jiekou() {
		$src = 'http://c.apiplus.net/newly.do?token=tede7fadc05516f95k&code=cqssc&format=json';
		$html = file_get_contents($src);
		$array = json_decode($html, true);
		return $array;
		// echo "<pre>";
		// print_r($array);
	}
	public function index() {
		$jk = $this->jiekou(); //调用接口方法
		if (is_array($jk)) {
			unset($jk['rows']);
			unset($jk['code']);
			unset($jk['remain']);
			foreach ($jk as $key => $value) {
				$vv = $value['0'];
			}
		} else {

		}
		$num = $vv['opencode'];
		$result = $this->result($num);
		$sfkj = $this->sfkj($num);
		$num = str_replace(',', ' ', $num);

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

			if ($res) {
				return json_encode($lottery);
			} else {
				return json_encode('456');
			}
		} else {
			return '数据已存在';
		}
	}
	function result($num) {

		if (substr($num, 0, 1) > substr($num, -1, 1)) {
			return '0'; //龙
		} elseif (substr($num, 0, 1) < substr($num, -1, 1)) {
			return '1'; //虎
		} else {
			return '2'; //和
		}
	}
	function sfkj($num) {
		if (!empty($num)) {
			return '已开奖';
		}
	}

}