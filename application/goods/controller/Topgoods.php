<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/1/2
 * Time: 17:21
 */

namespace app\goods\controller;

use app\admin\controller\Base;
use think\Db;

class Topgoods extends Base
{
	/**
	 * 精选商品列表
	 * @return array|\think\response\View
	 */
	public function topGoods()
	{
		if (request()->isPost()){
			$param = input('param.');
			$sex  = $param['sex'];
			$keys = $param['key'];
			$page =input('page')?input('page'):1;
			$pageSize =input('limit')?input('limit'):config('pageSize');
			$list =  db("top_bind_goods")->alias("t")
					->leftJoin("goods g","t.top_goodsid = g.goods_id")
					->where("g.d_title|g.title","like","%".$keys."%")
					->where("t.top_sex","=",$sex)
					->paginate(array('list_rows'=>$pageSize,'page'=>$page))
					->toArray();
			foreach ($list['data'] as $key => $value){
				$list['data'][$key]['create_time'] = date("Y-m-d H:i:s",$value['create_time']);
			}
			return ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];exit();
		}
		return view("index");
	}

	/**
	 * 删除 下架商品
	 * @return array
	 * @throws \think\Exception
	 * @throws \think\exception\PDOException
	 */
	public function del()
	{
		$param = input('param.');
		$type = 1;
		if ($param['type'] == 1){
			$type = -1;
		}
		$res = db("top_bind_goods")->where("top_id","=",$param['id'])->update(['top_status'=>$type]);
		if ($res){
			return ['code'=>1,'msg'=>'操作成功!'];
		}else{
			return ['code'=>-1,'msg'=>'操作失败!'];
		}
	}

	/**
	 * 选品库
	 * @return array|\think\response\View
	 * @throws \think\Exception
	 * @throws \think\exception\DbException
	 */
	public function listTop()
	{
		if (request()->isPost()){
			$param = input('param.');
			$page =input('page')?input('page'):1;
			$pageSize =input('limit')?input('limit'):config('pageSize');
			if ($param['type'] == 1){
				$list = db("goods")
						->where("status","<>",-1)
						->paginate(array('list_rows'=>$pageSize,'page'=>$page))
						->toArray();
			}else{
				$list['data'] = Db::connect("mongodb")->name("total")->limit(($page-1)*$pageSize,$pageSize)->select();
				$list['total'] = Db::connect("mongodb")->name("total")->count();
			}
			return ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];exit();
		}
		return view("list");
	}

	/**
	 * 加入精选库操作
	 * @return array
	 * @throws \think\Exception
	 */
	public function addTop()
	{
		$param = input('param.');
		if ($param['type'] == 2){
			//采集
			//存储去重
			$arr = db("goods")->column("goodsid");
			if (!empty($arr)){
				$repeat = array_values(array_diff($param['data'],$arr));
			}else{
				$repeat = $param['data'];
			}
			$data = Db::connect('mongodb')->name("total")->where("goodsid","in",$repeat)->select();
			$addAll = $saveData = [];
			foreach ($data as $key => $value){
				$addAll[$key]['id']                 = $value['id'];
				$addAll[$key]['cid']                = $value['cid'];
				$addAll[$key]['goodsid']            = $value['goodsid'];
				$addAll[$key]['title']              = $value['title'];
				$addAll[$key]['d_title']            = $value['d_title'];
				$addAll[$key]['pic']                = $value['pic'];
				$addAll[$key]['org_price']          = $value['org_price'];
				$addAll[$key]['price']              = $value['price'];
				$addAll[$key]['istmall']            = $value['istmall'];
				$addAll[$key]['sales_num']          = $value['sales_num'];
				$addAll[$key]['sellerid']          = $value['sellerid'];
				$addAll[$key]['commission_jihua']   = $value['commission_jihua'];
				$addAll[$key]['commission_queqiao'] = $value['commission_queqiao'];
				$addAll[$key]['jihua_link']         = $value['jihua_link'];
				$addAll[$key]['jihua_shenhe']       = $value['jihua_shenhe'];
				$addAll[$key]['introduce']          = $value['introduce'];
				$addAll[$key]['quan_id']            = $value['quan_id'];
				$addAll[$key]['quan_price']         = $value['quan_price'];
				$addAll[$key]['quan_time']          = $value['quan_time'];
				$addAll[$key]['quan_surplus']       = $value['quan_surplus'];
				$addAll[$key]['quan_receive']       = $value['quan_receive'];
				$addAll[$key]['quan_condition']     = $value['quan_condition'];
				$addAll[$key]['quan_link']          = $value['quan_link'];
				$addAll[$key]['create_time']        = time();
			}
			db("goods")->insertAll($addAll);
			//处理加入top商品库
			$goods_arr = db("goods")->where("goodsid",'in',$param['data'])->column("goods_id");
			$res = $this->binTop($goods_arr,$param['sex']);
		}else{
			$goods_arr = db("goods")->where("goodsid",'in',$param['data'])->column("goods_id");
			$res = $this->binTop($goods_arr,$param['sex']);
		}
		if ($res){
			return ['code'=>1,'msg'=>'操作成功!'];
		}else{
			return ['code'=>-1,'msg'=>'操作失败!'];
		}
	}

	/**
	 * 入库
	 * @param array $goods 商品集
	 * @param int $sex 性别
	 * @return bool|int|string
	 */
	public function binTop($goods=[],$sex=2)
	{
		if (empty($goods)){
			return false;
		}
		//去重
		$arr = db("top_bind_goods")->where("top_sex","=",$sex)->column("top_goodsid");
		$new_arr = array_diff($goods,$arr);
		if (!empty($new_arr)){
			foreach ($new_arr as $key => $value){
				$addData[$key]['top_goodsid'] = $value;
				$addData[$key]['top_sex']     = $sex;
				$addData[$key]['top_create_time'] = time();
			}
		}
		$reg = db("top_bind_goods")->insertAll($addData);
		return $reg;
	}

}