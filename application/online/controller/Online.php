<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/12/27
 * Time: 17:30
 */

namespace app\online\controller;


use app\admin\controller\Base;
use think\Db;

class Online extends Base
{
	/**
	 * 列表
	 * @return array|\think\response\View
	 * @throws \think\Exception
	 */
	public function index()
	{
		if (request()->isPost()){
			$param = input('param.');
			$is_form = $param['is_form'];
			$page = $param['page']?$param['page']:1;
			$limit = $param['limit']?$param['limit']:20;
			$key_arr = [];
			$where = $map = [];
			$field = "";
			$order = "";
			if (isset($param['key']) && !empty($param['key'])){
				$key_arr = explode(",",$param['key']);
			}
			//查询关键字
			if (!empty($key_arr)){
				$where[] = ['goodsid',"in",$key_arr];
			}
			//筛选
			if (isset($param['min']) && !empty($param['min'])){
				$map[] = ['price','>=',intval($param['min'])];
			}
			if (isset($param['max']) && !empty($param['max'])){
				$map[] = ['price','<=',intval($param['max'])];
			}
			if (isset($param['price']) && !empty($param['price'])){
				$map[] = ['quan_price','>=',intval($param['price'])];
			}
			if (isset($param['commission']) && !empty($param['commission'])){
				$map[] = ['commission_jihua','>=',intval($param['commission'])];
			}
			if (isset($param['sales']) && !empty($param['sales'])){
				$map[] = ['sales_num','>=',intval($param['sales'])];
			}
			if ($is_form == 1){
				//采集
				//大淘客分类
				if (isset($param['category'])){
					if ($param['category'] != 0){
						$where[] = ['cid',"=",intval($param['category'])];
					}else{
						$where[] = ['cid',"<>",0];
					}
				}
				//排序
				if (isset($param['sortChoose'])){
					switch ($param['sortChoose']){
						case 1:
							$field = "sales_num";
							$order = "desc";
							break;
						case 2:
							$field = "sales_num";
							$order = "desc";
							break;
						case 3:
							$field = "quan_receive";
							$order = "desc";
							break;
						case 4:
							$field = "commission_jihua";
							$order = "desc";
							break;
						case 5:
							$field = "price";
							$order = "asc";
							break;
						case 6:
							$field = "price";
							$order = "desc";
							break;
					}
				}
				$list['data'] = Db::connect("mongodb")->name("total")->where($where)->where($map)->order($field,$order)->limit(($page-1)*$limit,$limit)->select();
				$list['total'] = Db::connect("mongodb")->name("total")->where($where)->where($map)->count();
			}else{
				//数据库
				$where[] = ['cid',"=",0];
				//排序
				if (isset($param['sortChoose'])){
					switch ($param['sortChoose']){
						case 1:
							$order = "goods_id desc";
							break;
						case 2:
							$order = "sales_num desc";
							break;
						case 3:
							$order = "quan_receive desc";
							break;
						case 4:
							$order = "commission_jihua desc";
							break;
						case 5:
							$order = "price asc";
							break;
						case 6:
							$order = "price desc";
							break;
					}
				}
				$list = db("goods")->where($where)->where($map)->order($order)->paginate(array('list_rows'=>$limit,'page'=>$page))->toArray();
			}
			return ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];
		}
		$media = db("media")->where("media_status","<>",-1)->field("media_id,media_title")->select();
		return view('index',['media'=>$media]);
	}

	/**
	 * 加入操作
	 * @return array
	 * @throws \think\Exception
	 */
	public function addAll()
	{
		$param = input('param.');
		$is_form = $param['is_form'];
		$column_id = $param['column'];
		$repeat = [];
		if ($is_form == 1){
			//采集
			//存储去重
			$arr = db("goods")->column("goodsid");
			if (!empty($arr)){
				$repeat = array_values(array_diff($param['data'],$arr));
			}else{
				$repeat = $param['data'];
			}
			//商品入库(本地)
			$this->addGoods($repeat);

			$goods_arr = db("goods")->where("goodsid",'in',$param['data'])->column("goods_id");
			if ($param['brand'] ==1){
				//绑定商品分类库
				$db = "bind_column_goods";
				$res = $this->bind($db,$column_id,$goods_arr,1);
			}else{
				//绑定商品品牌馆
				$column_id = $param['brandColumn'];
				$db = "bind_brand_goods";
				$res = $this->bind($db,$column_id,$goods_arr,2);
			}
		}else{
			//自主添加
			$goods_arr = db("goods")->where("goodsid",'in',$param['data'])->column("goods_id");
			if ($param['brand'] == 1){
				//绑定商品分类库
				$db = "bind_column_goods";
				$res = $this->bind($db,$column_id,$goods_arr,1);
			}else{
				//绑定商品品牌馆
				$column_id = $param['brandColumn'];
				$db = "bind_brand_goods";
				$res = $this->bind($db,$column_id,$goods_arr,2);
			}
		}
		if ($res){
			return ['code'=>1,'msg'=>'操作成功!'];
		}else{
			return ['code'=>-1,'msg'=>'操作失败!'];
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
			['column_status',"<>",-1]
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

	/**
	 * 品牌馆分类切换
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
	 * 数据入库
	 * @param string $db 数据表名
	 * @param $column_id	栏目id
	 * @param array $data	加入的商品id
	 * @param int $type		类型  1-商品  2-品牌
	 * @return bool|int|string
	 */
	public function bind($db='',$column_id,$data=[],$type=1){
		if (empty($db) || empty($column_id) || empty($data)){
			return false;
		}
		//去重
		if ($type == 1){
			//商品分类列表
			$column_arr = db("bind_column_goods")->where("bind_column_id","=",$column_id)->column("bind_goods_id");
			if (!empty($column_arr)){
				$column = array_values(array_diff($data,$column_arr));  //差集
				$diff = array_values(array_intersect($data,$column_arr)); //交集
				$map = [
					['bind_column_id',"=",$column_id],
					['bind_goods_id',"in",$diff]
				];
				db("bind_column_goods")->where($map)->update(['bind_status'=>1]);
			}else{
				$column = $data;
			}
		}else{
			//品牌馆列表
			$column_arr = db("bind_brand_goods")->where("bind_column_id","=",$column_id)->column("bind_goods_id");
			if (!empty($column_arr)){
				$column = array_values(array_diff($data,$column_arr));
				$diff = array_values(array_intersect($data,$column_arr)); //交集
				$map = [
					['bind_column_id',"=",$column_id],
					['bind_goods_id',"in",$diff]
				];
				db("bind_brand_goods")->where($map)->update(['bind_status'=>1]);
			}else{
				$column = $data;
			}
		}
		$reg = true;
		if (!empty($column)){
			foreach ($column as $k=>$v){
				$saveData[$k]['bind_column_id'] = $column_id;
				$saveData[$k]['bind_goods_id']  = $v;
				$saveData[$k]['bind_create_time'] = time();
			}
			$reg = db($db)->insertAll($saveData);
		}
		return $reg;
	}

	/**
	 * 添加奖品库
	 * @return array
	 * @throws \think\Exception
	 */
	public function addReward()
	{
		$param = input('param.');
		if (empty($param['reward']) || !isset($param['reward'])  || empty($param['is_form']) || !isset($param['is_form'])){
			return ['code'=>-1,'msg'=>'请求操作失败!'];
		}
		if ($param['is_form'] == 1){
			$repeat = [];
			//存储去重
			$arr = db("goods")->column("goodsid");
			if (!empty($arr)){
				$repeat = array_values(array_diff($param['reward'],$arr));
			}else{
				$repeat = $param['reward'];
			}
			//商品入库(本地)
			$this->addGoods($repeat);
		}
		$goods_arr = db("goods")->where("goodsid",'in',$param['reward'])->column("goods_id");

		//数据去重
		$rewardArr = db("bind_reward_goods")->where("")->column("bind_goods_id");
		if (!empty($rewardArr)){
			$column = array_values(array_diff($goods_arr,$rewardArr));  //差集
			$diff = array_values(array_intersect($goods_arr,$rewardArr)); //交集
			$map = [
				['bind_goodsid',"in",$diff]
			];
			db("bind_reward_goods")->where($map)->update(['bind_status'=>1]);
		}

		$res = false;
		if (!empty($column)){
			$addData = [];
			foreach ($column as $k => $v){
				$addData[$k]['bind_goodsid']     = $v;
				$addData[$k]['bind_create_time'] = time();
			}
			$res = db("bind_reward_goods")->insertAll($addData);
		}
		if ($res){
			return ['code'=>1,'msg'=>'操作成功!'];
		}else{
			return ['code'=>-1,'msg'=>'操作失败!'];
		}
	}

	/**
	 * 商品加入本地数据库
	 * @param array $goods 商品id
	 * @return bool
	 * @throws \think\Exception
	 */
	public function addGoods($goods=[])
	{
		if (empty($goods) || !is_array($goods)){
			return false;exit();
		}
		$data = Db::connect('mongodb')->name("total")->where("goodsid","in",$goods)->select();
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
		return true;exit();
	}

}