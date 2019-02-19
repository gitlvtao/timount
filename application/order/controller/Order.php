<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/1/9
 * Time: 14:46
 */

namespace app\order\controller;


use app\admin\controller\Base;
use think\Controller;
use think\Db;

class Order extends Base
{

	public function index()
	{
		if (request()->isAjax()){
			$param = input('param.');
			if (!empty($param['time'])){
				$startTime = strtotime(trim(explode("/",$param['time'])[0]));
				$endTime   = strtotime(trim(explode("/",$param['time'])[1]));
			}else{
				$startTime = strtotime(date("Ymd"));
				$endTime   = $startTime + 86400;
			}
			$where = [
				["ident","=",$param['media_id']],
				["type","=","index"]
			];

			$count = ceil(($endTime - $startTime)/86400);
			$info = [];
			$list = [
				'men' => 0,
				'women' => 0
			];
			$times = $endTime;
			for ($i=0;$i<=$count;$i++){
				if ($times >= $startTime){
					$day = date("Ymd",$times);
					$data = Db::connect("mongodbData")->name($day)->where($where)->select();
					if (!empty($data)){
						foreach ($data as $value){
							$info[$value['userunique']] = $value;
						}
					}
					$times = $times - 86400;
				}
			}
			if (!empty($info)){
				foreach ($info as $m => $n){
					if ($n['sex'] == 1){
						$list['men'] += 1;
					}elseif ($n['sex'] == 2){
						$list['women'] +=1;
					}
				}
			}
			return array("code" => 1, "msg" => "","data" =>$list);
		}
		$media = db("media")->where("media_status",'<>',-1)->field("media_ident,media_title")->select();
		return view("index",['media'=>$media]);
	}

	public function sexChoose()
	{
		if (request()->isAjax()){
			$param = input('param.');
			if (!empty($param['time'])){
				$startTime = strtotime(trim(explode("/",$param['time'])[0]));
				$endTime   = strtotime(trim(explode("/",$param['time'])[1]));
			}else{
				$startTime = strtotime(date("Ymd"));
				$endTime   = $startTime + 86400;
			}
			$where = [
				["ident","=",$param['media_id']],
				["type","=","index"]
			];

			$count = ceil(($endTime - $startTime)/86400);
			$info = [];
			$list = [
				'men' => 0,
				'women' => 0
			];
			$times = $endTime;
			for ($i=0;$i<=$count;$i++){
				if ($times >= $startTime){
					$day = date("Ymd",$times);
					$data = Db::connect("mongodbData")->name($day)->where($where)->select();
					if (!empty($data)){
						foreach ($data as $value){
							$info[$value['userunique']] = $value;
						}
					}
					$times = $times - 86400;
				}
			}
			if (!empty($info)){
				foreach ($info as $m => $n){
					if ($n['sex'] == 1){
						$list['men'] += 1;
					}elseif ($n['sex'] == 2){
						$list['women'] +=1;
					}
				}
			}
			return array("code" => 1, "msg" => "","data" =>$list);
		}
		$media = db("media")->where("media_status",'<>',-1)->field("media_ident,media_title")->select();
		return view("index",['media'=>$media]);
	}





	public function orderData()
	{
		$sendData = [
			"apkey"     => "0fa2e1b4-8c6c-06d8-7885-3cf7e2063121",
			"starttime" => date("Y-m-d H:i:s",strtotime("-1 day")),  //查询开始时间
			"span"      => 1200,    //查询日期间隔
			"page"      => 1,		//开始页码  1-100
			"pagesize"  => 100,   //每页条数 1-100
			"tkstatus"  => 1,    //订单状态，1: 全部订单，3：订单结算，12：订单付款， 13：订单失效，14：订单成功； 订单查询类型为‘结算时间’时，只能查订单结算状态
			"ordertype" => "create_time",  //订单查询类型，创建时间“create_time”，或结算时间“settle_time”
			"tbname"    => "wsy19880526",
		];
		$sendData = http_build_query($sendData);
		$url = "https://api.open.21ds.cn/apiv1/gettkorder?".$sendData;
//		$data = file_get_contents($url);
//		$list = json_decode($data, true);
		var_dump($url);exit();

	}


	public function userData()
	{

		if (request()->isAjax()){
			$param = input('param.');





		}

		return view("userdata");
	}


}