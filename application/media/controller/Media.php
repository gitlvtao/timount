<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/12/18
 * Time: 14:37
 */

namespace app\media\controller;


use app\admin\controller\Base;

class Media extends Base
{
	/**
	 * 媒体列表
	 * @return array|\think\response\View
	 */
	public function index()
	{
		if (request()->isPost()){
			$keys =  input('post.key');
			$page =input('page')?input('page'):1;
			$pageSize =input('limit')?input('limit'):config('pageSize');
			$list =  db("media")
				->where("media_title|media_ident",'like',"%".$keys."%")
				->where("media_status","<>",-1)
				->paginate(array('list_rows'=>$pageSize,'page'=>$page))
				->toArray();
			foreach ($list['data'] as $key => $value){
				$list['data'][$key]['media_create_time'] = date("Y-m-d H:i:s",$value['media_create_time']);
				$list['data'][$key]['media_getUrl'] = "http://mall.bangwoya.com/sex/".$value['media_ident'];
			}
			return ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];exit();
		}
		return view();

	}

	/**
	 * 添加媒体
	 * @return array|\think\response\View
	 */
	public function add()
	{
		if (request()->isPost()){
			$param = input('param.');
			$saveData = [
				'media_title' => $param['media_title'],
				'media_ident' => $param['media_ident'],
				'media_pid' => $param['media_pid'],
				'media_divided_into' => $param['media_divided_into'],
				'media_service_fee' => $param['media_service_fee'],
				'media_create_time' => time()
			];
			$res = db("media")->insert($saveData);
			if ($res){
				return ['code'=>1,'msg'=>'添加成功','url'=>url('index')];exit();
			}else{
				return ['code'=>-1,'msg'=>'添加失败'];
			}
		}
		return view();
	}

	/**
	 * 编辑媒体
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
			$saveData = [
				'media_title' => $param['media_title'],
				'media_ident' => $param['media_ident'],
				'media_pid' => $param['media_pid'],
				'media_divided_into' => $param['media_divided_into'],
				'media_service_fee' => $param['media_service_fee']
			];
			$res = db("media")->where("media_id",$param['media_id'])->update($saveData);
			if ($res){
				return ['code'=>1,'msg'=>'编辑成功','url'=>url('index')];exit();
			}else{
				return ['code'=>-1,'msg'=>'编辑失败'];
			}
		}
		$id = input('param.id');
		$media = db('media')->where("media_id",$id)->find();
		return view('add',['media'=>$media]);
	}

	/**
	 * 删除媒体
	 * @return array
	 * @throws \think\Exception
	 * @throws \think\exception\PDOException
	 */
	public function del()
	{
		$res = db("media")->where("media_id",input('param.id'))->update(['media_status'=>-1]);
		if ($res){
			return ['code'=>1,'msg'=>'操作成功!'];
		}else{
			return ['code'=>-1,'msg'=>'操作失败!'];
		}
	}

}