<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/12/24
 * Time: 15:04
 */

namespace app\activity\controller;


use app\admin\controller\Base;

class Activity extends Base
{
	public function index()
	{
		if (request()->isPost()){
			$keys =  input('post.key');
			$page =input('page')?input('page'):1;
			$pageSize =input('limit')?input('limit'):config('pageSize');
			$list =  db("activity")
				->where("activity_status","<>",-1)
				->where("activity_title","like","%".$keys."%")
				->paginate(array('list_rows'=>$pageSize,'page'=>$page))
				->toArray();
			foreach ($list['data'] as $key => $value){
				$list['data'][$key]['activity_create_time'] = date("Y-m-d H:i:s",$value['activity_create_time']);
			}
			return ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];exit();
		}
		return view();
	}


	public function add()
	{
		if (request()->isPost()){
			$param = input('param.');
			$saveData = [
				'activity_title'   => $param['activity_title'],
				'activity_img'     => $param['activity_img'],
				'activity_banner'  => $param['activity_banner'],
				'activity_content' => $param['activity_content'],
				'activity_chance'  => $param['activity_chance'],
				'activity_create_time' => time()
			];
			$res = db("activity")->insert($saveData);
			if ($res){
				return ['code'=>1 ,'msg'=>'添加成功!'];
			}else{
				return ['code'=>-1 ,'msg'=>'添加失败!'];
			}
		}
		return view();
	}

	public function edit()
	{
		if (request()->isPost()){
			$param = input('param.');
			$updateData = [
				'activity_title'   => $param['activity_title'],
				'activity_img'     => $param['activity_img'],
				'activity_banner'  => $param['activity_banner'],
				'activity_content' => $param['activity_content'],
				'activity_chance'  => $param['activity_chance']
			];
			$res = db("activity")->where("activity_id","=",$param['activity_id'])->update($updateData);
			if ($res){
				return ['code'=>1 ,'msg'=>'编辑成功!'];
			}else{
				return ['code'=>-1 ,'msg'=>'编辑失败!'];
			}
		}
		$activity = db("activity")->where("activity_id",'=',input('param.id'))->find();
		return view('add',['activity'=>$activity]);
	}

	public function del()
	{
		$res = db("activity")->where("activity_id",'=',input('param.id'))->update(['activity_status'=>-1]);
		if ($res){
			return ['code'=>1 ,'msg'=>'删除成功!'];
		}else{
			return ['code'=>-1 ,'msg'=>'删除失败!'];
		}
	}


	public function sale()
	{
		$param = input('param.');
		switch ($param['type']){
			case 1:
				$res = db("activity")->where("activity_id",'=',$param['id'])->update(['activity_status'=>2]);
				break;
			case 2:
				$res = db("activity")->where("activity_id",'=',$param['id'])->update(['activity_status'=>1]);
				break;
		}
		if ($res){
			return ['code'=>1 ,'msg'=>'操作成功!'];
		}else{
			return ['code'=>-1 ,'msg'=>'操作失败!'];
		}
	}

}