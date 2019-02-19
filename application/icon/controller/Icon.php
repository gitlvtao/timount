<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/12/24
 * Time: 10:19
 */

namespace app\icon\controller;


use app\admin\controller\Base;

class Icon extends Base
{
	/**
	 * icon列表
	 * @return array|\think\response\View
	 */
	public function index()
	{
		if (request()->isPost()){
			$keys =  input('post.key');
			$page =input('page')?input('page'):1;
			$pageSize =input('limit')?input('limit'):config('pageSize');
			$list =  db("icon")
				->where("icon_status","<>",-1)
				->where("icon_title","like","%".$keys."%")
				->paginate(array('list_rows'=>$pageSize,'page'=>$page))
				->toArray();
			return ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];exit();
		}
		return view();
	}

	/**
	 * 添加
	 * @return array|\think\response\View
	 */
	public function add()
	{
		if (request()->isPost()){
			$param = input('param.');
			$saveData = [
				'icon_title' => $param['title'],
				'icon_img'   => $param['thumb'],
				'icon_create_time' => time()
			];
			$res = db("icon")->insert($saveData);
			if ($res){
				return ['code'=>1,'msg'=>'添加成功'];
			}else{
				return ['code'=>-1,'msg'=>'添加失败'];
			}
		}
		return view();
	}

	/**
	 * 编辑
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
				'icon_title' => $param['title'],
				'icon_img'   => $param['thumb']
			];
			$res = db("icon")->where("icon_id",'=',$param['icon_id'])->update($updateData);
			if ($res){
				return ['code'=>1,'msg'=>'编辑成功'];
			}else{
				return ['code'=>-1,'msg'=>'编辑失败'];
			}
		}
		$icon = db("icon")->where("icon_id",'=',input('param.id'))->find();
		return view('add',['icon'=>$icon]);
	}

	/**
	 * 删除
	 * @return array
	 * @throws \think\Exception
	 * @throws \think\exception\PDOException
	 */
	public function del()
	{
		$res = db("icon")->where("icon_id",'=',input('param.id'))->update(['icon_status'=>-1]);
		if ($res){
			return ['code'=>1,'msg'=>'删除成功'];
		}else{
			return ['code'=>-1,'msg'=>'删除失败'];
		}
	}

	/**
	 * 排序
	 * @return array
	 * @throws \think\Exception
	 * @throws \think\exception\PDOException
	 */
	public function sort()
	{
		$param = input('param.');
		$res = db("icon")->where("icon_id",'=',$param['icon_id'])->update(['icon_sort'=>$param['sort']]);
		if ($res){
			return ['code'=>1,'msg'=>'操作成功'];
		}else{
			return ['code'=>-1,'msg'=>'操作失败'];
		}
	}

}