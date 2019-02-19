<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/1/2
 * Time: 11:48
 */

namespace app\brand\controller;


use app\common\controller\Api;
use think\Db;

class Brandapi extends Api
{
	/**
	 * 品牌馆商品列表
	 * @return array
	 * @throws \think\Exception
	 */
	public function goodsList()
	{
		$param = input('param.data');
		$where = [];
		if ($param['id'] <= 14 ){
			//采集的
			$img = Db::connect("mongodb")->name("brand")->where("title","=",$param['title'])->value("logo");
			$title = explode("(",$param['title'])[0];
			$where[] = ["title","like",$title];
			$goods = Db::connect("mongodb")->name("total")->where($where)->limit(($param['page']-1)*20,20)->select();
			foreach ($goods as $key => $value){
				$goods[$key]['type'] = 'baoyou';
			}
			$list['img'] = $img;
		}else{
			//自主添加的
			$where[] = ["brand_column_id","=",intval($param['id'])];
			$where[] = ["brand_title","=",$param['title']];
			$brand = db("brand")->where($where)->field("brand_id,brand_logo")->find();
			$goods = db("bind_brand_goods")->alias("b")
					->leftJoin("goods g","b.bind_goods_id = g.goods_id")
					->field("g.*")
					->where("b.bind_column_id","=",$brand['brand_id'])->where("g.status","<>",-1)
					->order("b.bind_sort asc")
					->limit(($param['page']-1)*20,20)->select();
			foreach ($goods as $k => $v){
				$goods[$k]['type'] = 'goods';
			}
			$list['img'] = $brand['brand_logo'];
		}
		$list['goods'] = $goods;
		$this->response['response'] = $list;
		return $this->response;
	}



}