<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/12/24
 * Time: 17:46
 */

namespace app\reward\controller;


use app\admin\controller\Base;

class Reward extends Base
{
	/**
	 * 列表
	 * @return array|\think\response\View
	 */
	public function index()
	{
		if (request()->isPost()){
			$keys =  input('post.key');
			$page =input('page')?input('page'):1;
			$pageSize =input('limit')?input('limit'):config('pageSize');
			$list =  db("reward")->alias("r")->join("media a","a.media_id = r.reward_media_id")
				->field("r.*,a.media_title")
				->where("reward_status","<>",-1)
				->where("a.media_status","<>",-1)
				->where("reward_title","like","%".$keys."%")
				->paginate(array('list_rows'=>$pageSize,'page'=>$page))
				->toArray();

			foreach ($list['data'] as $key => $value){
				$list['data'][$key]['time'] = date("Y-m-d H:i:s",$value['reward_create_time']);
			}
			return ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];exit();
		}
		return view();
	}

	/**
	 * 添加奖励
	 * @return array|\think\response\View
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function add()
	{
		if (request()->isPost()){
			$param = input('param.');
			$saveData = [
				'reward_title'    => $param['reward_title'],
				'reward_media_id' => $param['reward_media_id'],
				'reward_url'      => $param['reward_url'],
				'reward_img'      => $param['reward_img'],
				'reward_create_time' => time()
			];
			$res = db("reward")->insert($saveData);
			if ($res){
				return ['code'=>1,'msg'=>'添加成功!'];
			}else{
				return ['code'=>-1,'msg'=>'添加失败!'];
			}
		}
		$media = db("media")->where("media_status","<>",-1)->select();
		return view('add',['media'=>$media]);
	}

	/**
	 * 编辑奖励
	 * @return array|\think\response\View
	 * @throws \think\Exception
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 * @throws \think\exception\PDOException
	 */
	public function edit()
	{
		if (request()->isPost()){
			$param = input('param.');
			$updateData = [
				'reward_title'    => $param['reward_title'],
				'reward_media_id' => $param['reward_media_id'],
				'reward_url'      => $param['reward_url'],
				'reward_img'      => $param['reward_img'],
			];
			$res = db("reward")->where("reward_id","=",$param['reward_id'])->update($updateData);
			if ($res){
				return ['code'=>1,'msg'=>'编辑成功!'];
			}else{
				return ['code'=>-1,'msg'=>'编辑失败!'];
			}
		}
		$reward = db("reward")->where("reward_id","=",input('param.id'))->find();
		$media = db("media")->where("media_status","<>",-1)->select();
		return view('add',['reward'=>$reward,'media'=>$media]);
	}

	/**
	 * 删除奖励
	 * @return array
	 * @throws \think\Exception
	 * @throws \think\exception\PDOException
	 */
	public function del()
	{
		$res = db("reward")->where("reward_id","=",input("param.id"))->update(['reard_status'=>-1]);
		if ($res){
			return ['code'=>1,'msg'=>'删除成功!'];
		}else{
			return ['code'=>-1,'msg'=>'删除失败!'];
		}
	}

	/**
	 * 上下架操作
	 * @return array
	 * @throws \think\Exception
	 * @throws \think\exception\PDOException
	 */
	public function sale()
	{
		$param = input('param.');
		switch ($param['type']){
			case 1:
				$res = db("reward")->where("reward_id",'=',$param['id'])->update(['reward_status'=>2]);
				break;
			case 2:
				$res = db("reward")->where("reward_id",'=',$param['id'])->update(['reward_status'=>1]);
				break;
		}
		if ($res){
			return ['code'=>1 ,'msg'=>'操作成功!'];
		}else{
			return ['code'=>-1 ,'msg'=>'操作失败!'];
		}
	}

	/**
	 * 奖品库列表
	 * @return array|\think\response\View
	 */
	public function rewardGoods()
	{
		if (request()->isPost()){
			$page =input('page')?input('page'):1;
			$pageSize =input('limit')?input('limit'):config('pageSize');
			$list =  db("bind_reward_goods")->alias("b")->join("goods g","b.bind_goodsid = g.goods_id")
				->field("g.*,b.bind_id,b.bind_status,b.bind_create_time")
				->where("b.bind_status","<>",-1)
				->paginate(array('list_rows'=>$pageSize,'page'=>$page))
				->toArray();
			foreach ($list['data'] as $key => $value){
				$list['data'][$key]['time'] = date("Y-m-d H:i:s",$value['bind_create_time']);
			}
			return ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];exit();
		}
		return view("reward");
	}

	/**
	 * 删除操作
	 * @return array
	 * @throws \think\Exception
	 * @throws \think\exception\PDOException
	 */
	public function delReward()
	{
		$res = db("bind_reward_goods")->where("bind_id","=",input('param.id'))->update(['bind_status'=>-1]);
		if ($res){
			return ['code'=>1 ,'msg'=>'操作成功!'];
		}else{
			return ['code'=>-1 ,'msg'=>'操作失败!'];
		}
	}

}