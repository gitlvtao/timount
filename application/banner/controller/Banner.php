<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/12/20
 * Time: 16:58
 */

namespace app\banner\controller;


use app\admin\controller\Base;

class Banner extends Base
{
	/**
	 * 列表
	 * @return array|\think\response\View
	 */
	public function index()
	{
		if (request()->isPost()){
			$media_id = input('param.media_id');

			$keys =  input('post.key');
			$page =input('page')?input('page'):1;
			$pageSize =input('limit')?input('limit'):config('pageSize');
			$list =  db("banner")
				->where("banner_status","<>",-1)
				->where("banner_media_id","=",$media_id)
				->where("banner_title","like","%".$keys."%")
				->paginate(array('list_rows'=>$pageSize,'page'=>$page))
				->toArray();
			return ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];exit();
		}
		$media = db("media")->where("media_status",'<>',-1)->field("media_id,media_title")->select();
		return view('index',['media'=>$media]);
	}

	/**
	 * 新增
	 * @return array|\think\response\View
	 */
	public function add()
	{
		if (request()->isPost()){
			$param = input('param.');
			$saveData = [
				'banner_media_id'    => $param['media_id'],
				'banner_title'       => $param['banner_title'],
				'banner_img'         => $param['banner_img'],
				'banner_url'         => $param['banner_url'],
				'banner_sex'         => $param['banner_sex'],
				'banner_create_time' => time(),
			];
			$res = db("banner")->insert($saveData);
			if ($res){
				return ['code'=>1,'msg'=>'添加成功!','url'=>url('index')];
			}else{
				return ['code'=>0,'msg'=>'添加失败!'];
			}
		}
		$media_id = input('param.media_id');
		return view('add',['media_id'=>$media_id]);
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
				'banner_title'       => $param['banner_title'],
				'banner_img'         => $param['banner_img'],
				'banner_url'         => $param['banner_url'],
				'banner_sex'         => $param['banner_sex']
			];
			$res = db("banner")->where("banner_id",'=',$param['banner_id'])->update($updateData);
			if ($res){
				return ['code'=>1,'msg'=>'编辑成功!','url'=>url('index')];
			}else{
				return ['code'=>0,'msg'=>'编辑失败!'];
			}
		}
		$banner = db("banner")->where("banner_id",'=',input('param.id'))->find();
		return view('add',['banner'=>$banner]);
	}

	/**
	 * 删除
	 * @return array
	 * @throws \think\Exception
	 * @throws \think\exception\PDOException
	 */
	public function del()
	{
		$res = db("banner")->where("banner_id",'=',input('param.id'))->update(['banner_status'=>-1]);
		if ($res){
			return ['code'=>1,'msg'=>'删除成功!'];
		}else{
			return ['code'=>0,'msg'=>'删除失败!'];
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
		$res = db("banner")->where("banner_id",'=',$param['banner_id'])->update(['banner_sort'=>$param['sort']]);
		if ($res){
			return ['code'=>1,'msg'=>'操作成功!'];
		}else{
			return ['code'=>0,'msg'=>'操作失败!'];
		}
	}

}