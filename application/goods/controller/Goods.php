<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/12/21
 * Time: 9:30
 */

namespace app\goods\controller;


use app\admin\controller\Base;

class Goods extends Base
{
	/**
	 * 列表
	 * @return array|\think\response\View
	 * @throws \think\exception\DbException
	 */
	public function index()
	{
		if (request()->isPost()){
			$keys =  input('post.key');
			$page =input('page')?input('page'):1;
			$pageSize =input('limit')?input('limit'):config('pageSize');
			$list =  db("goods")
				->where("d_title|title","like","%".$keys."%")
				->where("cid","=",0)
				->paginate(array('list_rows'=>$pageSize,'page'=>$page))
				->toArray();
			foreach ($list['data'] as $key => $value){
				$list['data'][$key]['create_time'] = date("Y-m-d H:i:s",$value['create_time']);
			}
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
				'id'  => 0,
				'cid'  => 0,
				'goodsid'  => $param['taobao_id'],
				'd_title'  => $param['d_title'],
				'title'  => $param['title'],
				'pic'  => $param['pic'],
				'istmall'  => $param['istmall'],
				'quan_time'  => $param['quan_time'],
				'quan_surplus'  => $param['quan_surplus'],
				'quan_receive'  => $param['quan_receive'],
				'commission_jihua'  => $param['commission_jihua'],
				'commission_queqiao'  => $param['commission_queqiao'],
				'quan_price'  => $param['quan_price'],
				'price'  => $param['price'],
				'org_price'  => $param['org_price'],
				'sales_num'  => $param['sales_num'],
				'quan_id'  => $param['quan_id'],
				'quan_condition'  => $param['quan_condition'],
				'introduce'  => $param['introduce'],
				'create_time'  => time(),
			];
			$goods_id = db("goods")->insertGetId($saveData);
			if ($goods_id){
				return ['code'=>1,'msg'=>'添加成功!'];
			}else{
				return ['code'=>1,'msg'=>'添加失败!'];
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
				'goodsid'  => $param['taobao_id'],
				'd_title'  => $param['d_title'],
				'title'  => $param['title'],
				'pic'  => $param['pic'],
				'istmall'  => $param['istmall'],
				'quan_time'  => $param['quan_time'],
				'quan_surplus'  => $param['quan_surplus'],
				'quan_receive'  => $param['quan_receive'],
				'commission_jihua'  => $param['commission_jihua'],
				'commission_queqiao'  => $param['commission_queqiao'],
				'quan_price'  => $param['quan_price'],
				'price'  => $param['price'],
				'org_price'  => $param['org_price'],
				'sales_num'  => $param['sales_num'],
				'quan_id'  => $param['quan_id'],
				'quan_condition'  => $param['quan_condition'],
				'introduce'  => $param['introduce'],
			];
			$res= db("goods")->where("goods_id","=",$param['goods_id'])->update($updateData);
			if ($res){
				return ['code'=>1,'msg'=>'编辑成功!'];
			}else{
				return ['code'=>1,'msg'=>'编辑失败!'];
			}
		}
		$goods = db("goods")->where("goods_id","=",input("param.id"))->find();
		return view("add",['goods'=>$goods]);
	}

	/**
	 * 删除（上下架）
	 * @return array
	 * @throws \think\Exception
	 * @throws \think\exception\PDOException
	 */
	public function del()
	{
		$type = 0;
		if (input('param.type') == 0){
			$type = 1;
		}
		$res = db("goods")->where("goods_id",'=',input("param.id"))->update(['status'=>$type]);
		if ($res){
			return ['code'=>1,'msg'=>'操作成功!'];
		}else{
			return ['code'=>0,'msg'=>'操作失败!'];
		}
	}


}