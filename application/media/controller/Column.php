<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/12/18
 * Time: 17:16
 */

namespace app\media\controller;


use app\admin\controller\Base;
use think\facade\Cache;

class Column extends Base
{
	/**
	 * 列表
	 * @return array|\think\response\View
	 */
	public function index()
	{
		if (request()->isPost()){

			$media_id = input('param.media_id');
			$sex = input('param.sex');
			$keys =  input('post.key');
			$page =input('page')?input('page'):1;
			$pageSize =input('limit')?input('limit'):config('pageSize');

			$list = $this->columnList($media_id,$keys,$page,$pageSize,$sex);
			return ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];exit();
		}
		$media = db("media")->where("media_status",'<>',-1)->field("media_id,media_title")->select();
		return view("index",['media'=>$media]);
	}

	/**
	 * 添加栏目
	 * @return array|\think\response\View
	 */
	public function add()
	{
		if (request()->isPost()){
			$param = input('param.');
			$saveDate = [
				'column_title'       => $param['column_title'],
				'column_media_id'    => $param['media_id'],
				'column_thumb'       => $param['column_thumb'],
				'column_pic'         => $param['column_pic'],
				'column_image'       => $param['column_image'],
				'column_type'        => $param['column_type'],
				'column_sex'         => $param['column_sex'],
				'column_create_time' => time(),
			];
			if ($param['column_type'] == 1){
				$saveDate['column_thumb'] = $param['column_time'];
				$saveDate['column_image'] = '';
			}
			$res = db("column")->insert($saveDate);
			if ($res){
				return ['code'=>1,'msg'=>'添加成功!','url'=>url('index')];
			}else{
				return ['code'=>0,'msg'=>'添加失败!'];
			}
		}
		$media_id = input('param.media_id');
		return view("add",['media_id'=>$media_id,'type'=>'']);
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
				'column_title' => $param['column_title'],
				'column_thumb' => $param['column_thumb'],
				'column_pic'   => $param['column_pic'],
				'column_image' => $param['column_image'],
				'column_type'  => $param['column_type'],
				'column_sex'   => $param['column_sex']
			];
			if ($param['column_type'] == 1){
				$updateData['column_thumb'] = $param['column_time'];
				$updateData['column_image'] = '';
			}
			$res = db("column")->where("column_id","=",$param['column_id'])->update($updateData);

			//缓存配置数据删除
			Cache::rm("column_jrms_data_".$param['column_id']);

			if ($res){
				return ['code'=>1,'msg'=>'编辑成功!','url'=>url('index')];
			}else{
				return ['code'=>0,'msg'=>'编辑失败!'];
			}
		}
		$column_id = input('param.id');
		$column = db("column")->where("column_id","=",$column_id)->find();
		return view('add',['column'=>$column,'type'=>$column['column_type']]);
	}

	/**
	 * 删除
	 * @return array
	 * @throws \think\Exception
	 * @throws \think\exception\PDOException
	 */
	public function del()
	{
		$res = db("column")->where("column_id","=",input('param.id'))->update(['column_status'=>-1]);
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
		$res = db("column")->where("column_id","=",$param['column_id'])->update(['column_sort'=>$param['column_sort']]);
		if ($res){
			return ['code'=>1,'msg'=>'操作成功!'];
		}else{
			return ['code'=>0,'msg'=>'操作!'];
		}
	}

	/**
	 * 大淘客栏目列表
	 * @return array|\think\response\View
	 */
	public function taoColumn()
	{
		if (request()->isPost()){
			$keys =  input('post.key');
			$page =input('page')?input('page'):1;
			$pageSize =input('limit')?input('limit'):config('pageSize');

			$list = $this->columnList(0,$keys,$page,$pageSize,0);
			return ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];exit();
		}
		return view("list");
	}

	/**
	 * 栏目列表方法
	 * @param $media_id 媒体id
	 * @param $keys 搜索关键词
	 * @param $page 页码
	 * @param $pageSize 条数
	 * @return mixed
	 */
	public function columnList($media_id,$keys,$page,$pageSize,$sex=2)
	{
		$list = db("column")
			->where("column_status","<>",-1)
			->where("column_media_id","=",$media_id)
			->where("column_sex","=",$sex)
			->where("column_title","like","%".$keys."%")
			->paginate(array('list_rows'=>$pageSize,'page'=>$page))
			->toArray();
		return $list;
	}


}