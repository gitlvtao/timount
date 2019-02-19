<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/1/3
 * Time: 17:47
 */

namespace app\reward\controller;


use app\common\controller\Api;
use think\Db;
use think\facade\Log;

class Rewardapi extends Api
{
	/**
	 * 生成用户标识
	 * @return array
	 */
	public function getUser()
	{
		$param = input('param.data');
		//新生成一个
		$user = md5($param['id'] . time());
		$addData = [
			'cookie' => $param['id'],
			'user_ident' => $user,
			'create_time' => time()
		];
		$uid = db("user")->insertGetId($addData);
		$this->response['response'] = $uid;
		return $this->response;
	}

	/**
	 * 活动详情
	 * @return array
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function index()
	{
		$param = input('param.data');
		$reward = db("activity")->where("activity_status", "=", 1)->find();
		$start = strtotime(date("Y-m-d"));
		$end = $start + 86400;
		$where = [];
		$where[] = ['bind_uid', "=", $param['uid']];
		$where[] = ['bind_type', "=", 1];
		$where[] = ['bind_create_time', "between", [intval($start), intval($end)]];
		$count = db("bind_user_reward")->where($where)->count();
		$this->response['response'] = [
			'info' => $reward?$reward:"",
			'count' => (3 - $count)
		];
		return $this->response;
	}

	/**
	 * 砸蛋活动接口
	 * @return array
	 */
	public function getReward()
	{
		$param = input("param.data");
		$c = db("bind_reward_goods")->where("bind_status","=",1)->count();
		$offset = rand(0,$c-1);
		$goods = db("bind_reward_goods")->field("bind_goodsid")->where("bind_status","=",1)->limit($offset,2)->select();
		$goods_id = $goods[0]['bind_goodsid'];
		$reward = db("goods")
				    ->where("goods_id","=",$goods_id)
					->field("goodsid,d_title,quan_price,pic,quan_link")->find();
		$reward_2 = db("reward")->where("reward_media_id", "=", $param['media_id'])->where("reward_status", "=", 1)->field("reward_img,reward_url")->find();
		$start = strtotime(date("Y-m-d"));
		$end = $start + 86400;
		$where = [];
		$where[] = ['bind_uid', "=", $param['uid']];
		$where[] = ['bind_type', "=", 1];
		$where[] = ['bind_create_time', "between", [intval($start), intval($end)]];
		$count = db("bind_user_reward")->where($where)->count();
		if ($count < 3){
			$addData = [
				[
					'bind_uid' => $param['uid'],
					'bind_reward' => json_encode($reward),
					'bind_type' => 1,
					'bind_create_time' => time(),
				]
			];
			if (!empty($reward_2)) {
				$addData = [
					[
						'bind_uid' => $param['uid'],
						'bind_reward' => json_encode($reward),
						'bind_type' => 1,
						'bind_create_time' => time(),
					],
					[
						'bind_uid' => $param['uid'],
						'bind_reward' => json_encode($reward_2),
						'bind_type' => 2,
						'bind_create_time' => time(),
					]
				];
			}
			db("bind_user_reward")->insertAll($addData);
			$this->response['response']['reward'] = $reward;
			$this->response['response']['rewards'] = $reward_2?$reward_2:"";
			return $this->response;exit();
		}
		$this->response['code'] = 'error';
		$this->response['msg'] = '参数错误!';
		return $this->response;exit();
	}

	/**
	 * 奖励列表
	 * @return array
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function rewardList()
	{
		$param = input('param.data');
		$start = strtotime(date("Y-m-d"));
		$end = $start + 86400;
		$where = [];
		$where[] = ['bind_uid', "=", $param['uid']];
		$where[] = ['bind_create_time', "between", [intval($start), intval($end)]];
		$list = db("bind_user_reward")->where($where)->select();
		$arr = [];
		foreach ($list as $key => $value){
			if ($value['bind_type'] == 1){
				$arr['reward'][] = json_decode($value['bind_reward']);
			}else{
				$arr['rewards'][] = json_decode($value['bind_reward']);
			}
		}
		$this->response['response'] = $arr;
//		dump($this->response);exit();
		return $this->response;
	}


}