<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/1/8
 * Time: 13:41
 */

namespace app\goods\controller;


use app\admin\controller\Base;

class Goodsmanage extends Base
{
	/**
	 * 列表
	 * @return array|\think\response\View
	 */
	public function index()
	{
		if (request()->isPost()){
			$param = input('param.');

			$db = "bind_column_goods";
			$where = [];
			$where[] = ["b.bind_status","<>",-1];
			if (empty($param['column'])){
				return ['code'=>1,'msg'=>'暂无数据'];exit();
			}
			if (!empty($param['brand']) && !empty($param['brandColumn']) && $param['brand'] == 2){//品牌馆
				$db = "bind_brand_goods";
				$where[] = ["b.bind_column_id","=",$param['brandColumn']];
			}elseif (!empty($param['brand']) && $param['brand'] == 1){
				$where[] = ["b.bind_column_id","=",$param['column']];
			}
			$list = db($db)->alias("b")
					->leftJoin("goods g","b.bind_goods_id = g.goods_id")
					->where($where)
					->field("g.*,b.bind_id,b.bind_sort")
					->paginate(array('list_rows'=>$param['limit'],'page'=>$param['page']))
					->toArray();
			return ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];
		}
		$media = db("media")->where("media_status","<>",-1)->field("media_id,media_title")->select();
		return view('index',['media'=>$media]);
	}

	/**
	 * 媒体切换获取分类
	 * @return mixed
	 */
	public function get_media_column()
	{
		$param = input('param.');
		$where = [];
		$where[] = ["column_media_id","=",$param['media_id']];
		$where[] = ["column_sex","=",$param['sex']];
		$where[] = ["column_status","=",1];
		$column = db("column")->where($where)->field("column_id,column_title")->select();
		$option = "<option value=''>请选择分类</option>";
		foreach($column as $key => $value){
			$option .= "<option value=".$value['column_id'].">".$value['column_title']."</option>";
		}
		$result['code'] = 1;
		$result['msg']  = $option;
		return $result;
	}

	/**
	 * 获取品牌
	 * @return mixed
	 */
	public function getBrand()
	{
		$param = input('param.');
		$brand = db("brand")->where("brand_column_id","=",$param['column_id'])->field("brand_id,brand_title")->select();
		$option = "<option value=''>请选择分类</option>";
		foreach($brand as $key => $value){
			$option .= "<option value=".$value['brand_id'].">".$value['brand_title']."</option>";
		}
		$result['code'] = 1;
		$result['msg']  = $option;
		return $result;
	}

	/**
	 * 删除
	 * @return array
	 * @throws \think\Exception
	 * @throws \think\exception\PDOException
	 */
	public function del()
	{
		$param = input('param.');
		$db = "bind_column_goods";
		if ($param['brand'] == 2){
			$db = "bind_brand_goods";
		}
		$res = db($db)->where("bind_id","=",$param['id'])->update(['bind_status'=>-1]);
		if ($res){
			return ['code'=>1,'msg'=>'删除成功!'];exit();
		}else{
			return ['code'=>-1,'msg'=>'删除失败!'];exit();
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
		$db = "bind_column_goods";
		if ($param['brand'] == 2){
			$db = "bind_brand_goods";
		}
		$res = db($db)->where("bind_id","=",$param['id'])->update(['bind_sort'=>$param['sort']]);
		if ($res){
			return ['code'=>1,'msg'=>'操作成功!'];exit();
		}else{
			return ['code'=>-1,'msg'=>'操作失败!'];exit();
		}
	}

}