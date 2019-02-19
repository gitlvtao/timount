<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/2/12
 * Time: 13:41
 */

namespace app\userdata\controller;

use fuk\Excel;
use think\Controller;
use think\Db;

class Goods extends Controller
{
	/**
	 * 首页
	 * @return array|\think\response\View
	 * @throws \think\Exception
	 */
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
				["type","like","detail"],
			];
			$count = ceil(($endTime - $startTime)/86400);
			$list = [];
			$times = $endTime;
			for ($i=0;$i<=$count;$i++){
				if ($times >= $startTime){
					$day = date("Ymd",$times);
					$data= Db::connect("mongodbData")->name($day)->where($where)->select();
					if (!empty($data)){
						$info = $this->getData($data,$day,$i*15000);
						if (!empty($info)){
							foreach ($info as $kk){
								array_push($list,$kk);
							}
						}
					}
					$times = $times - 86400;
				}
			}
			if (!$list){
				return ['code'=>0,'msg'=>'获取成功!','data'=>[],'count'=>0,'rel'=>1];exit();
			}
			return ['code'=>0,'msg'=>'获取成功!','data'=>$list,'count'=>1,'rel'=>1];exit();
		}
		$media = db("media")->where("media_status",'<>',-1)->field("media_ident,media_title")->select();
		return view("index",['media'=>$media]);
	}

	/**
	 * 数据处理
	 * @param array $data 数据源
	 * @param string $day 集合名
	 * @param int $i 基数
	 * @return array
	 * @throws \think\Exception
	 */
	public function getData($data=[],$day="",$i=0)
	{
		$home = [];
		foreach ($data as $key => $value){
			if ($value['type'] != "null_detail" ){
				$k = $value['clickid'];
				array_push($home,$k);
				$goodsData[$k]['user'][] = $value['userunique'];
				$goodsData[$k]['time'][] = $value['timer'];
				if ($value['type'] == "detail_copy"){
					$goodsData[$k]['copy'][] = $value['userunique'];
				}
				if ($value['type'] == "detail_ticket"){
					$goodsData[$k]['ticket'][] = $value['userunique'];
				}
				if ($value['type'] == "detail_share"){
					$goodsData[$k]['share'][] = $value['userunique'];
				}
				if ($value['type'] == "detail_buy"){
					$goodsData[$k]['buy'][] = $value['userunique'];
				}
				$dataData[$k]['PV'] = isset($goodsData[$k]['user'])?count($goodsData[$k]['user']):0;
				$dataData[$k]['UV'] = isset($goodsData[$k]['user'])?count(array_count_values($goodsData[$k]['user'])):0;
				$dataData[$k]['time'] = $dataData[$k]['UV']?sprintf("%.2f",(array_sum($goodsData[$k]['time'])/$dataData[$k]['UV'])):0;
				$dataData[$k]['copy_pv'] = isset($goodsData[$k]['copy'])?count($goodsData[$k]['copy']):0;
				$dataData[$k]['copy_uv'] = isset($goodsData[$k]['copy'])?count(array_count_values($goodsData[$k]['copy'])):0;
				$dataData[$k]['ticket_pv'] = isset($goodsData[$k]['ticket'])?count($goodsData[$k]['ticket']):0;
				$dataData[$k]['ticket_uv'] = isset($goodsData[$k]['ticket'])?count(array_count_values($goodsData[$k]['ticket'])):0;
				$dataData[$k]['share_pv'] = isset($goodsData[$k]['share'])?count($goodsData[$k]['share']):0;
				$dataData[$k]['share_uv'] = isset($goodsData[$k]['share'])?count(array_count_values($goodsData[$k]['share'])):0;
				$dataData[$k]['buy_pv'] = isset($goodsData[$k]['buy'])?count($goodsData[$k]['buy']):0;
				$dataData[$k]['buy_uv'] = isset($goodsData[$k]['buy'])?count(array_count_values($goodsData[$k]['buy'])):0;
			}
		}
		$name_1 = Db::connect("mongodb")->name("total")->where("goodsid","in",$home)->field("goodsid,d_title")->select();
		$name_2 = db("goods")->where([['id',"=",0],['goodsid',"in",$home]])->field("goodsid,d_title")->select();
		$j = 1;
		foreach ($dataData as $m => $n){
			$dataData[$m]['id'] = $i + 1 + $j;
			$dataData[$m]['pid'] = $i +1;
			$dataData[$m]['name'] = $m;
			if (!empty($name_1)){
				foreach ($name_1 as $v1){
					if ($m = $v1['goodsid']){
						$dataData[$m]['name'] = mb_convert_encoding(substr($v1['d_title'],0,36), 'UTF-8', 'UTF-8');
					}
				}
			}
			if ($dataData[$m]['name'] == $m && !empty($name_2)){
				foreach ($name_2 as $v2){
					if ($m = $v2['goodsid']){
						$dataData[$m]['name'] = mb_convert_encoding(substr($v2['d_title'],0,36), 'UTF-8', 'UTF-8');
					}
				}
			}
			$j++;
		}
		$dataData[0]['name'] = $day;
		$dataData[0]['id'] = $i + 1;
		$dataData[0]['pid'] = 0;
		$dataData[0]['PV'] = "-";
		$dataData[0]['UV'] = "-";
		$dataData[0]['time'] = "-";
		$dataData[0]['copy_pv'] = "-";
		$dataData[0]['copy_uv'] = "-";
		$dataData[0]['ticket_pv'] = "-";
		$dataData[0]['ticket_uv'] = "-";
		$dataData[0]['share_pv'] = "-";
		$dataData[0]['share_uv'] = "-";
		$dataData[0]['buy_pv'] = "-";
		$dataData[0]['buy_uv'] = "-";
		return array_values($dataData);
	}

	/**
	 * 导出数据表格
	 * @throws \think\Exception
	 */
	public function phpExcel()
	{
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
			["type","like","detail"],
		];
		$count = ceil(($endTime - $startTime)/86400);

		$list = $dataData = [];
		$times = $endTime;
		for ($i=0;$i<=$count;$i++){
			if ($times >= $startTime){
				$day = date("Ymd",$times);
				$data= Db::connect("mongodbData")->name($day)->where($where)->select();
				if (!empty($data)){
					$info = $this->getData($data,$day,$i*15000);
					if (!empty($info)){
						foreach ($info as $k => $v){
							if ($v['pid'] != 0){
								$list[$k]['timeName'] = $day;
								$list[$k]["name"] = $v['name'];
								$list[$k]["PV"] = $v['PV'];
								$list[$k]["UV"] = $v['UV'];
								$list[$k]["time"] = $v['time'];
								$list[$k]["copy_pv"] = $v['copy_pv'];
								$list[$k]["copy_uv"] = $v['copy_uv'];
								$list[$k]["ticket_pv"] = $v['ticket_pv'];
								$list[$k]["ticket_uv"] = $v['ticket_uv'];
								$list[$k]["share_pv"] = $v['share_pv'];
								$list[$k]["share_uv"] = $v['share_uv'];
								$list[$k]["buy_pv"] = $v['buy_pv'];
								$list[$k]["buy_uv"] = $v['buy_uv'];
								array_push($dataData,$list[$k]);
							}
						}
					}
				}
				$times = $times - 86400;
			}
		}
		$name = [
			["日期",'timeName'],
			["商品名称",'name'],
			["商品点击pv",'PV'],
			["商品点击uv",'UV'],
			["停留时长",'time'],
			["一键复制点击pv",'copy_pv'],
			["一键复制点击uv",'copy_uv'],
			["领券购买点击pv",'ticket_pv'],
			["领券购买点击uv",'ticket_uv'],
			["分享点击pv",'share_pv'],
			["分享点击uv",'share_uv'],
			["不领券购买点击pv",'buy_pv'],
			["不领券购买点击uv",'buy_uv']
		];
		$phpExcel = new Excel();
		$phpExcel->daoChu($dataData,$name);
	}


}