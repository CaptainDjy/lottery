<?php
namespace app\admin\controller;
use app\common\controller\Admin;
use think\Controller;
use think\Db;

/**
 *
 */
class Lottery extends Admin {

	public function watch() {
		$res = db('lottery')->order('Id desc')->paginate(10);
		$this->assign('lottery', $res);
		return $this->fetch();
	}
	public function delete($id) {
		$data = request()->param();
		$res = db('lottery')->delete($id);
		if ($res) {
			return $this->redirect(url('admin/lottery/watch'));
		} else {
			return $this->error('删除失败');
		}
	}

	public function delall() {
		$data = request()->param()['test'];
		$a = implode(",", $data);
		$res = db('lottery')->delete($a);
		if ($res) {
			return $this->redirect(url('admin/lottery/watch'));
		} else {
			return $this->error('删除失败');
		}
	}
}