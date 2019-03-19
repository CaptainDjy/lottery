<?php
namespace app\admin\Model;
use think\Model;

/**
 *
 */
class Plan extends Model {

	protected $autoWriteTimestamp = false;
	protected $updateTime = 'updated';
	protected $createTime = 'created';
	protected $auto = [];
}