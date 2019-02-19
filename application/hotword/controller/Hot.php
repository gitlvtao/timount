<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/12/20
 * Time: 14:07
 */

namespace app\hotword\controller;


use app\admin\controller\Base;

class Hot extends Base
{
	public function index()
	{
		if (request()->isPost()){
			$media_id = input('param.media_id');
			$keys =  input('post.key');
			$page =input('page')?input('page'):1;
			$pageSize =input('limit')?input('limit'):config('pageSize');
			$list =  db("hot_word")
				->where("hot_media_id","=",$media_id)
				->where("hot_title","like","%".$keys."%")
				->paginate(array('list_rows'=>$pageSize,'page'=>$page))
				->toArray();
			return ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];exit();
		}
		$media = db("media")->where("media_status",'<>',-1)->field("media_id,media_title")->select();
		return view("index",['media'=>$media]);
	}


	public function add()
	{
		if (request()->isPost()){
			$param = input('param.');
			$saveData = [
				'hot_title'       => $param['hot_title'],
				'hot_url'         => $param['hot_url'],
				'hot_media_id'    => $param['media_id'],
				'hot_create_time' => time(),
			];
			$res = db("hot_word")->insert($saveData);
			if ($res){
				return ['code'=>1,'msg'=>'添加成功!','url'=>url('index')];
			}else{
				return ['code'=>0,'msg'=>'添加失败!'];
			}
		}
		$media_id = input('param.media_id');
		return view('add',['media_id'=>$media_id]);
	}


	public function edit()
	{
		if (request()->isPost()){
			$param = input('param.');
			$updateData = [
				'hot_title'       => $param['hot_title'],
				'hot_url'         => $param['hot_url']
			];
			$res = db("hot_word")->where("hot_id",'=',$param['hot_id'])->update($updateData);
			if ($res){
				return ['code'=>1,'msg'=>'编辑成功!','url'=>url('index')];
			}else{
				return ['code'=>0,'msg'=>'编辑失败!'];
			}
		}
		$hot = db("hot_word")->where("hot_id","=",input("param.id"))->find();
		return view('add',['hot'=>$hot]);
	}


	public function del()
	{
		$res = db("hot_word")->where("hot_id","=",input("param.id"))->delete();
		if ($res){
			return ['code'=>1,'msg'=>'删除成功!'];
		}else{
			return ['code'=>0,'msg'=>'删除失败!'];
		}
	}


	public function sort()
	{
		$param = input('param.');
		$res = db("hot_word")->where("hot_id","=",$param['hot_id'])->update(['hot_sort'=>$param['hot_sort']]);
		if ($res){
			return ['code'=>1,'msg'=>'操作成功!'];
		}else{
			return ['code'=>0,'msg'=>'操作失败!'];
		}
	}

}