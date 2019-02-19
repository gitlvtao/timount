<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/12/26
 * Time: 11:37
 */

namespace app\goods\controller;


use ali\Tkl;
use app\common\controller\Api;
use app\common\Logic\Taobao;
use app\index\controller\Index;
use think\Db;
use think\facade\Cache;

class Goodsapi extends Api
{
	//分类商品列表
	public function goodsList()
	{
		$param = input("param.data");
		$column_id = $param['column_id'];
		$page = $param['page']?$param['page']:1;
		$field = "sales_num";
		$order = "desc";
		$where = [];
		if (isset($param['type']) && !empty($param['type'])){
			switch ($param['type']){
				case 1:
					$field = "sales_num";
					$order = "desc";
					break;
				case 2:
					$field = "price";
					$order = "desc";
					break;
				case 3:
					$field = "price";
					$order = "asc";
					break;
				case 4:
					$field = "quan_receive";
					$order = "desc";
					break;
				default;
					$field = "bind_sort";
					$order = "asc";
					break;
			}
		}
		$this->response['response']['banner'] = db("column")->where("column_id","=",$column_id)->value("column_pic");
		if ($column_id <= 14){
			if (isset($param['mold']) && !empty($param['mold'])){
				$where[] = ['price',"between",[0,10]];
			}
			//淘客分类
			$goods = Db::connect("mongodb")->name("total")->where("cid","=",intval($column_id))->where($where)->order($field,$order)->limit(($page-1)*20,20)->select();
			foreach ($goods as $key => $value){
				$goods[$key]['type'] = 'baoyou';
			}
		}else{
			$where[] = ['g.status',"=",1];
			if (isset($param['mold']) && !empty($param['mold'])){
				$where[] = ['g.price',"between",[0,10]];
			}
			//自定义分类
			$goods = db("bind_column_goods")->alias("b")
					->join("goods g","b.bind_goods_id = g.goods_id")
					->where("b.bind_column_id","=",$column_id)
					->where($where)
					->order($field,$order)->limit(($page-1)*20,20)
					->select();
			foreach ($goods as $k => $v){
				$goods[$k]['type'] = 'goods';
			}
		}
		$this->response['response']['goods'] = $goods;
		return $this->response;
	}

	//icon商品列表
	public function icon()
	{
		$param = input('param.data');
		$media_id = $param['media_id'];
		$sex = $param['sex'];
		$icon_id = $param['icon_id'];
		$page = $param['page']?$param['page']:1;
		$where = [];
		switch ($icon_id){
			case 1:
				$db = "haitao";
				break;
			case 2:
				$sexType = 1;
				if ($sex == 1){
					$sexType = 2;
				}
				$this->response['response'] = db("column")->field("column_id,column_title")
												->where("column_media_id",['=',0],['=',$media_id],'or')
												->where("column_status","<>",-1)
												->where("column_sex","<>",$sexType)
												->where("column_type","=",0)
												->order("column_media_id desc,column_sort asc")->select();
				break;
			case 3:
				$db = "jhs";
				break;
			case 4:
				$db = "total";
				$where[] = ['price','<',10];
				break;
			case 5:
				//精选100（top100）
				$db = "topall";
				break;
		}
		if ($icon_id != 2){
			$index = new Index();
			$spike = $index->spike($media_id,$sex);
			$goods = Db::connect("mongodb")->name($db)->where($where)->limit(($page-1)*20,20)->select();
			$type = 'all';
			switch ($db){
				case 'haitao':
					$type = 'haitao';
					break;
				case 'jhs':
					$type = 'jhs';
					break;
				case 'total':
					$type = 'baoyou';
					break;
				case 'topall':
					$type = 'top100';
					break;
			}
			foreach ($goods as $key => $value){
				$goods[$key]['type'] = $type;
			}
			$this->response['response'] = [
				'spike' => $spike,
				'goods' => $goods
			];
		}
		return $this->response;
	}

	/**
	 * 品牌馆----分类
	 * @return array
	 * @throws \think\Exception
	 */
	public function brand()
	{
		$param = input('param.data');
		$column_id = $param['column_id'];
		$sex       = $param['sex'];

		if ($column_id <= 14){
			//采集
			$this->response['response'] = Db::connect("mongodb")->name("brand")->where("cid","=",$column_id)->select();
		}else{
			//自主添加
			$this->response['response'] = db("brand")->alias("b")
				->leftJoin("column c","c.column_id = b.brand_column_id")
				->where("c.column_id","=",$column_id)
				->field("b.brand_column_id as cid,b.brand_title as title,b.brand_logo as logo")
				->where("c.column_status","<>",-1)->where("c.column_sex","=",$sex)
				->where("c.column_type","=",0)
				->select();
		}
		return $this->response;
	}

	/**
	 * 商品详情
	 * @return array
	 * @throws \think\Exception
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 * @throws \think\exception\PDOException
	 */
	public function goodsInfo()
	{
		$param = input("param.data");
		$a = explode("_",$param['goodsid']);
		$goodsid = $a[1];
		$type    = $a[0];
		switch ($type){
			case 'goods':
				$goodsInfo = db("goods")->where("goodsid","=",$goodsid)->find();
				break;
			case 'jhs':
				$goodsInfo = Db::connect('mongodb')->name("jhs")->where("goodsid","=",$goodsid)->find();
				break;
			case 'haitao':
				$goodsInfo = Db::connect('mongodb')->name("haitao")->where("goodsid","=",$goodsid)->find();
				break;
			case 'baoyou':
				$goodsInfo = Db::connect('mongodb')->name("total")->where("goodsid","=",$goodsid)->find();
				break;
			case 'top100':
				$goodsInfo = Db::connect('mongodb')->name("topall")->where("goodsid","=",$goodsid)->find();
				break;
			default;
				$this->response['code'] = "error";
				$this->response['msg']  = "数据缺失";
				return $this->response;
		}
		if ($goodsInfo['istmall']){
			$goodsInfo['jump_url'] = "https://detail.m.tmall.com/item.htm?pid=mm_13553468_13270601_20304900450&id=".$goodsInfo['goodsid'];
		}else{
			$goodsInfo['jump_url'] = 'https://h5.m.taobao.com/awp/core/detail.htm?mm_13553468_13270601_20304900450&id='.$goodsInfo['goodsid'];
		}

		$goodsInfo['quan_link'] = "https://uland.taobao.com/coupon/edetail?activityId=".$goodsInfo['quan_id']."&pid=mm_13553468_13270601_20304900450&itemId=".$goodsInfo['goodsid']."&src=qhkj_dtkp&dx=";

		//优惠券过期
		$goodsInfo['expire'] = "on";
		if (strtotime($goodsInfo['quan_time']) < time()){
			$goodsInfo['expire'] = "off";
		}
		//获取淘口令
		$goodsInfo['tbkTkl'] = $this->getTkl($goodsInfo,$param['media_id']);
		//获取店铺信息
		$taobao = new Taobao();
		$shop = $taobao->seller($goodsInfo['sellerid'],$goodsInfo['goodsid']);
		$shops = [];
		if (!empty($shop)){
			$shops['shopName'] = $shop['shopName'];
			$shops['shopIcon'] = $shop['shopIcon'];
			if (!empty($shop['evaluates'])){
				foreach ($shop['evaluates'] as $kk => $vv){
					$shops['evaluates'][$kk]['title'] = $vv['title'];
					$shops['evaluates'][$kk]['score'] = $vv['score'];
					if ($vv['levelText'] == '高'){
						$shops['evaluates'][$kk]['img'] = "http://static.bangwoya.com/mall/public/seller_up.png";
						$shops['evaluates'][$kk]['color'] = "#FF0000";
					}elseif ($vv['levelText'] == '平'){
						$shops['evaluates'][$kk]['img'] = "http://static.bangwoya.com/mall/public/seller_equal.png";
						$shops['evaluates'][$kk]['color'] = "#1193CE";
					}else{
						$shops['evaluates'][$kk]['img'] = "http://static.bangwoya.com/mall/public/seller_down.png";
						$shops['evaluates'][$kk]['color'] = "#008B8B";
					}
				}
			}
		}
		//获取推荐信息
		if ($type == 'goods'){
			$count = db("goods")->where("status","<>",-1)->count();
			$offset = rand(0,ceil($count/6)-1)*6;
			$tuijian = db("goods")->where("status","<>",-1)->limit($offset,6)->select();
			//修改数据库店铺数据
			if (!empty($shop) && ($goodsInfo['cid'] == 0)){
				db("goods")->where("goodsid","=",$goodsid)->update(['sellerid'=>$shop['shopId']]);
			}
		}elseif($type == 'baoyou'){
			$count = Db::connect('mongodb')->name("total")->count();
			$offset = rand(0,ceil($count/6))*6;
			$tuijian = Db::connect("mongodb")->name("total")->limit($offset,6)->select();
		}elseif($type == 'top100'){
			$count = Db::connect('mongodb')->name("topall")->count();
			$offset = rand(0,ceil($count/6))*6;
			$tuijian = Db::connect("mongodb")->name("topall")->limit($offset,6)->select();
		}else{
			$count = Db::connect('mongodb')->name($type)->count();
			$offset = rand(0,ceil($count/6))*6;
			$tuijian = Db::connect("mongodb")->name($type)->limit($offset,6)->select();
		}

		$arr = [];
		if (!empty($tuijian)){
			foreach ($tuijian as $key => $value){
				$tuijian[$key]['type'] = $type;
				if ($key%3 == 0){
					$arr[$key][] = $tuijian[$key];
					if ($key+1 <= count($tuijian) && isset($tuijian[$key+1])){
						$tuijian[$key+1]['type'] = $type;
						$arr[$key][] = $tuijian[$key+1];
					}
					if ($key+2 <= count($tuijian) && isset($tuijian[$key+2])){
						$tuijian[$key+2]['type'] = $type;
						$arr[$key][] = $tuijian[$key+2];
					}
				}
			}
		}
		$this->response['response']['goodsInfo'] = $goodsInfo;
		$this->response['response']['shop']      = $shops;
		$this->response['response']['tuijian']   = array_values($arr);
//		dump($this->response);exit();
		return $this->response;
	}

	/**
	 * 获取淘口令
	 * @param $mediaId
	 * @param $goods
	 * @return mixed
	 */
	public function getTkl($goods,$mediaId)
	{
		$pwd = Cache::get('mall_'.$mediaId.'_tbkpwd_'.$goods['goodsid']);
		if (!$pwd){
			// 获取媒体pid
			$pid = db("media")->where(['media_id' => $mediaId])->value('media_pid');
			// 首先访问接口
//			$res = $this->getYqmTbkPwd($pid, $goods['goodsid']);
			$res['code'] =1;
			if ($res['code'] == 200) {
				$pwd=  $res['result']['data']['tpwd'];
			} else {
				$ali = new Tkl();
				$pwd = $ali->getTklPwd($goods,$pid,$mediaId);
			}
			Cache::set('mall_'.$mediaId.'_tbkpwd_'.$goods['goodsid'],$pwd,86400);
		}
		return $pwd;
	}

	/**
	 * 喵有券获取淘口令
	 * @param $pid
	 * @param $taobaoId
	 * @return mixed
	 */
	protected function getYqmTbkPwd($pid, $taobaoId) {
		$url = "https://api.open.21ds.cn/apiv1/getitemgyurl?apkey=0fa2e1b4-8c6c-06d8-7885-3cf7e2063121&itemid=".$taobaoId."&pid=".$pid."&tbname=wsy19880526&tpwd=1";
		$data = file_get_contents($url);
		return json_decode($data, true);
	}


	public function clear()
	{
		$mediaId = 1;
		$goods['goodsid'] = "566377167172";
		$res =  Cache::rm('mall_'.$mediaId.'_tbkpwd_'.$goods['goodsid']);
		dump($res);
	}

}


