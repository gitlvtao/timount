<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/12/25
 * Time: 16:10
 */

namespace app\common\controller;


use think\Controller;

class Api extends Controller
{
	// api接口返回格式
	protected $response = [
		'code' => 'success',
		'msg' => '',
		// 'response' => []
	];
}