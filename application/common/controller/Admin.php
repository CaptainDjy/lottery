<?php
namespace app\common\controller;
use think\Controller;

/*管理后台的控制器基类*/

class Admin extends Controller {

	// 初始方法_initialize()
	public function _initialize() {
		// 校验用户的登录状态
		if (!session('?admin')) {
			$this->redirect(url('admin/user/login'));
		}
	}
}