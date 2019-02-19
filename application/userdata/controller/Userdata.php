<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/1/14
 * Time: 10:09
 */

namespace app\userdata\controller;


use app\admin\controller\Base;
use think\Db;

class Userdata extends Base
{

	public function index()
	{

	}




	public function getUserData()
	{
		$day  = date("Ymd");  //数据集合表 (起始日期)

		$data = Db::connect("mongodbData")->name($day)->select();

		$userCount = $countUser = $pageCount = $countPage = [];

		if (!empty($data)){
			foreach ($data as $key => $value){
				if ($value['type'] == "index"){
					$userCount[] = $value ;  //统计UV
				}
				if (stripos($value['type'],"index_") !== false){
					$pageCount[] = $value ;  //统计PV
				}
			}
		}

		dump($data);exit();


	}



}