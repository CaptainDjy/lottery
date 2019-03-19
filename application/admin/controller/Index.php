<?php
namespace app\admin\controller;
use app\common\controller\Admin;
use think\Controller;

/**
 *
 */
class Index extends Admin {

	public function index() {
		return $this->fetch();
	}
}