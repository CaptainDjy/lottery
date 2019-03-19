<?php
namespace app\admin\model;

use think\Model;

/**
 * 后台用户模型
 */
class User extends Model {
	// 时间字段的自动完成
	protected $autoWriteTimestamp = true;
	protected $updateTime = "updated";
	protected $createTime = "created";
	protected $auto = [];

	public function getList() {
		$where = [];
		$list = $this->where($where)->order('created DESC')->paginate();
		return $list;
	}
}