<?php
namespace app\common\controller;
use think\Controller;

/**
 *
 */
class Ajax extends Controller {
	function ajaxReturn($data, $type = 'JSON', $json_option = 0) {
		switch (strtoupper($type)) {
		case 'JSON':
			// 返回JSON数据格式到客户端 包含状态信息
			header('Content-Type:application/json; charset=utf-8');
			$data = json_encode($data, $json_option);
			break;
		case 'JSONP':
			// 返回JSON数据格式到客户端 包含状态信息
			header('Content-Type:application/json; charset=utf-8');
			$handler = isset($_GET[C('VAR_JSONP_HANDLER')]) ? $_GET[C('VAR_JSONP_HANDLER')] : C('DEFAULT_JSONP_HANDLER');
			$data = $handler . '(' . json_encode($data, $json_option) . ');';
			break;
		case 'EVAL':
			// 返回可执行的js脚本
			header('Content-Type:text/html; charset=utf-8');
			break;
		}
		exit($data);
	}
}