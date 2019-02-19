<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/12/26
 * Time: 15:44
 */

namespace app\activity\controller;


use app\common\controller\Api;

class Activityapi extends Api
{

	public function index()
	{
		$param = input("param.");

		$activity_id = 1;

		$this->response['response'] = db("activity")->where("activity_id","=",$activity_id)->find();

		return $this->response;
	}

	//奖品信息
	public function reward()
	{
		$reward = db("reward")->field("reward_id,reward_title,reward_url,reward_img")->select();
		if (!empty($reward)){
			$list['reward'] = $reward[count($reward)-1];
		}
		dump($list);exit();
	}


	public function userReward()
	{

	}

}