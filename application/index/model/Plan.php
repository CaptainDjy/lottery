<?php
namespace app\admin\Model;
use think\Model;

/**
 *
 */
class Plan extends Model {

	protected $autoWriteTimestamp = true;
	protected $updateTime = 'updated';
	protected $createTime = 'created';
}