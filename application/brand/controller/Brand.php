<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/12/24
 * Time: 9:32
 */

namespace app\brand\controller;


use app\admin\controller\Base;
use think\Db;

class Brand extends Base
{

	public function index()
	{
		if (request()->isPost()){
			$page =input('page')?input('page'):1;
			$pageSize =input('limit')?input('limit'):config('pageSize');
			$param = input('param.');
			if (empty($param['column_id'])){
				return ['code'=>0,'msg'=>'获取成功!','data'=>[],'count'=>0,'rel'=>1];exit();
			}
			$list =  db("brand")
				->where("brand_column_id","=",$param['column_id'])
				->paginate(array('list_rows'=>$pageSize,'page'=>$page))
				->toArray();
			return ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];exit();
		}
		$media = db("media")->where("media_status",'<>',-1)->field("media_id,media_title")->select();
		return view("index",['media'=>$media]);
	}

	public function add()
	{
		$column_id = input('param.column_id');
		if (request()->isPost()){
			$param = input('param.');
			$saveData = [
				'brand_column_id' => $param['column_id'],
				'brand_title'     => $param['brand_title'],
				'brand_logo'      => $param['brand_logo'],
				'brand_create_time' => time()
			];
			$res = db("brand")->insert($saveData);
			if ($res){
				return ['code'=>1,'msg'=>'添加成功!'];
			}else{
				return ['code'=>-1,'msg'=>'添加失败!'];
			}
		}
		return view('add',['column_id'=>$column_id]);
	}

	public function edit()
	{
		$param = input('param.');
		if (request()->isPost()){
			$param = input('param.');
			$updateData = [
				'brand_title'     => $param['brand_title'],
				'brand_logo'      => $param['brand_logo'],
			];
			$res = db("brand")->where("brand_id","=",$param['brand_id'])->update($updateData);
			if ($res){
				return ['code'=>1,'msg'=>'编辑成功!'];
			}else{
				return ['code'=>-1,'msg'=>'编辑失败!'];
			}
		}
		$brand = db("brand")->where("brand_id","=",$param['id'])->find();
		return view("add",['brand'=>$brand,'column_id'=>$brand['brand_column_id']]);
	}

	public function del()
	{
		$res = db("brand")->where("brand_id","=",input('param.id'))->delete();
		if ($res){
			return ['code'=>1,'msg'=>'删除成功!'];
		}else{
			return ['code'=>-1,'msg'=>'删除失败!'];
		}
	}


	/**
	 * 媒体下拉分类切换
	 * @return mixed
	 */
	public function get_media_column()
	{
		$param = input('param.');
		$where = [
			['column_media_id',"=",$param['media_id']],
			['column_sex',"=",$param['sex']],
			['column_status',"<>",-1],
			['column_type',"=",0]
		];
		$column = db("column")->where($where)->field("column_id,column_title")->select();
		$option = "<option value=''>请选择分类</option>";
		foreach($column as $key => $value){
			$option .= "<option value=".$value['column_id'].">".$value['column_title']."</option>";
		}
		$result['code'] = 1;
		$result['msg']  = $option;
		return $result;
	}

}