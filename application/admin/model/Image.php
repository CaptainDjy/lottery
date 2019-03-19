<?php
namespace app\admin\Model;

use think\Model;

class Image extends Model {
//时间字段的自动完成
	protected $autoWriteTimestamp = true;
	protected $updateTime = 'updated';
	protected $createTime = 'created';
	protected $auto = [];
}