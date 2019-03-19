<?php
namespace app\common\controller;
use think\Controller;

/**
 *
 */
class IndexBase extends Controller {
	public function _initialize() {
		$cs = model('category')->where('recommend=1')->select();
		$this->assign('cs', $cs);
	}
}