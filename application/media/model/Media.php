<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/1/4
 * Time: 11:31
 */

namespace app\media\model;


use think\Model;

class Media extends Model
{
	// 指定数据库链接
	protected $connection = 'mysql';
	// 指定数据表
	protected $table = 'media';
	// 指定主键
	protected $primaryKey= 'media_id';

}