<?php
namespace app\admin\Model;
use think\Model;

/**
 *
 */
class Project extends Model {

	protected $autoWriteTimestamp = true;
	protected $updateTime = 'updated';
	protected $createTime = 'created';
}