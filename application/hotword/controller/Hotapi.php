<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/12/25
 * Time: 15:56
 */

namespace app\hotword\controller;


use app\common\controller\Api;
use think\Db;

class Hotapi extends Api
{
	/**
	 * 返回热搜词
	 * @return array
	 */
	public function hotList()
	{
		$param = input('param.data');
//		$param['media_id'] = 1;
		$list  = db("hot_word")->where("hot_media_id","=",$param['media_id'])->field("hot_id,hot_title,hot_url")->order("hot_sort","asc")->select();
		$this->response['response'] = $list;
//		dump($this->response);exit();
		return $this->response;
	}

	/**
	 * 返回搜索结果
	 * @return array
	 * @throws \think\Exception
	 */
	public function hotGoods()
	{
		$param = input('param.data');
//		$param = [
//			'type' => '',
//			'key' => '羽绒服',
//			'page' => 2,
//			'min' => 0,
//			'max' => 100,
//			'istmall' => ''
//		];
		$where = [];
		//搜索关键词
		if (isset($param['key'])){
			$where[] = ['title','like',$param['key']];
		}
		//筛选
		if (isset($param['istmall'])){
			$where[] = ['istmall','=',1];
		}
		if (isset($param['min']) && empty($param['max'])){
			$where[] = ['price','>=',intval($param['min'])];
		}elseif (isset($param['max']) && empty($param['min'])){
			$where[] = ['price','<=',intval($param['max'])];
		}elseif (isset($param['min']) && !empty($param['max'])){
			if ($param['min'] > $param['max']){
				$where[] = ['price','>=',intval($param['min'])];
			}else{
				$where[] = ['price','between',[intval($param['min']),intval($param['max'])]];
			}
		}
		$field = "sales_num";
		$order = "desc";
		if (isset($param['type']) && !empty($param['type'])){
			switch ($param['type']){
				case 1:
					$field = "sales_num";
					$order = "desc";
					break;
				case 2:
					$field = "price";
					$order = "asc";
					break;
				case 3:
					$field = "price";
					$order = "desc";
					break;
			}
		}
		$page = isset($param['page'])?$param['page']:1;
		$goods = Db::connect("mongodb")->name("total")->where($where)->order($field,$order)->limit(($page-1)*20,20)->select();
		foreach ($goods as $key => $value){
			$goods[$key]['type'] = 'baoyou';
		}
		$this->response['response'] = $goods;
		return $this->response;
//		dump($this->response);exit();
	}

}