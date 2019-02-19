<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/2/11
 * Time: 11:00
 */

namespace app\userdata\controller;

use fuk\Excel;
use think\Controller;
use think\Db;

class Goodsdetail extends Controller
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
			];
			$count = ceil(($endTime - $startTime)/86400);
			$list = [];
			$times = $endTime;
			for ($i=0;$i<=$count;$i++){
				if ($times >= $startTime){
					$day = date("Ymd",$times);
					$data= Db::connect("mongodbData")->name($day)->where($where)->select();
					if (!empty($data)){
						$info = $this->getData($data,$day,$i*16);
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
	 * @param array $data 数据源
	 * @param string $day 日期时间
	 * @param int $i 基数
	 * @return array
	 */
	public function getData($data=[],$day="",$i=0)
	{
		$home = $tmall = $jhs = $money = $top = $search = $specialty = $brand = [];
		$homeTimeCount = $tmallTimeCount = $jhsTimeCount = $moneyTimeCount = $topTimeCount = $searchTimeCount = $specialtyTimeCount = $brandTimeCount = 0;
		$home_list = $tmall_list = $jhs_list = $money_list = $top_list = $search_list = $specialty_list = $brand_list = [];
		$home_pv = $tmall_pv = $jhs_pv = $money_pv = $top_pv = $search_pv = $specialty_pv = $brand_pv = 0;
		$home_uv = $tmall_uv = $jhs_uv = $money_uv = $top_uv = $search_uv = $specialty_uv = $brand_uv = 0;
		$home_time = $tmall_time = $jhs_time = $money_time = $top_time = $search_time = $specialty_time = $brand_time = 0;
		foreach ($data as $key => $value){
			if (in_array($value['type'],['Tmall_spike','Tmall_detail'])){ //天猫列表商品点击
				$tmall[] = $value;
				array_push($home,$value);
			}
			if (in_array($value['type'],['Ju_spike','Ju_detail'])){ //聚划算列表商品点击
				$jhs[] = $value;
				array_push($home,$value);
			}
			if (in_array($value['type'],['Money_spike','Money_detail'])){ //聚划算列表商品点击
				$money[] = $value;
				array_push($home,$value);
			}
			if (in_array($value['type'],['Top_spike','Top_detail'])){ //top100商品点击
				$top[] = $value;
				array_push($home,$value);
			}
			if ($value['type'] == "Result_detail"){ //搜索商品
				$search[] = $value;
				array_push($home,$value);
			}
			if ($value['type'] == "Specialty_detail"){ //分类专场
				$specialty[] = $value;
				array_push($home,$value);
			}
			if ($value['type'] == "Projects_detail"){ //品牌馆
				$brand[] = $value;
				array_push($home,$value);
			}
		}
		//天猫列表商品点击
		$tmall_list_list = $tmall_spike_list = [];
		$tmall_list_time = $tmall_spike_time = 0;
		$tmall_list_pv = $tmall_spike_pv = 0;
		$tmall_list_uv = $tmall_spike_uv = 0;
		$tmallListTimeCount = $tmallSpikeTimeCount = 0;
		if (!empty($tmall)){
			foreach ($tmall as $k_t => $v_t){
				$tmall_list[] = $v_t['userunique'];
				$tmallTimeCount += $v_t['timer'];
				if ($v_t['type'] == "Tmall_detail"){ //列表点击
					$tmall_list_list[] = $v_t['userunique'];
					$tmallListTimeCount += $v_t['timer'];
				}elseif ($v_t['type'] == "Tmall_spike"){ //今日秒杀
					$tmall_spike_list[] = $v_t['userunique'];
					$tmallSpikeTimeCount += $v_t['timer'];
				}
			}
			//总数
			$tmall_pv = count($tmall_list);
			$tmall_uv = count(array_count_values($tmall_list));
			$tmall_time = $tmall_uv?sprintf("%.2f",($tmallTimeCount/$tmall_uv)):0;
			//今日秒杀
			$tmall_spike_pv = count($tmall_spike_list);
			$tmall_spike_uv = count(array_count_values($tmall_spike_list));
			$tmall_spike_time = $tmall_spike_uv?sprintf("%.2f",($tmallSpikeTimeCount/$tmall_spike_uv)):0;
			//列表
			$tmall_list_pv = count($tmall_list_list);
			$tmall_list_uv = count(array_count_values($tmall_list_list));
			$tmall_list_time = $tmall_list_uv?sprintf("%.2f",($tmallListTimeCount/$tmall_list_uv)):0;
		}
		//聚划算商品点击
		$jhs_list_list = $jhs_spike_list = [];
		$jhs_list_time = $jhs_spike_time = 0;
		$jhs_list_pv = $jhs_spike_pv = 0;
		$jhs_list_uv = $jhs_spike_uv = 0;
		$jhsListTimeCount = $jhsSpikeTimeCount = 0;
		if (!empty($jhs)){
			foreach ($jhs as $k_j => $v_j){
				$jhs_list[] = $v_j['userunique'];
				$jhsTimeCount += $v_j['timer'];
				if ($v_j['type'] == "Ju_detail"){ //聚划算列表
					$jhs_list_list[] = $v_j['userunique'];
					$jhsListTimeCount += $v_j['timer'];
				}elseif ($v_j['type'] == "Ju_spike"){ //聚划算今日秒杀
					$jhs_spike_list[] = $v_j['userunique'];
					$jhsSpikeTimeCount += $v_j['timer'];
				}
			}
			//聚划算总点击
			$jhs_pv = count($jhs_list);
			$jhs_uv = count(array_count_values($jhs_list));
			$jhs_time = $jhs_uv?sprintf("%.2f",($jhsTimeCount/$jhs_uv)):0;
			//聚划算今日秒杀
			$jhs_spike_pv = count($jhs_spike_list);
			$jhs_spike_uv = count(array_count_values($jhs_spike_list));
			$jhs_spike_time = $jhs_spike_uv?sprintf("%.2f",($jhsSpikeTimeCount/$jhs_spike_uv)):0;
			//聚划算列表
			$jhs_list_pv = count($jhs_list_list);
			$jhs_list_uv = count(array_count_values($jhs_list_list));
			$jhs_list_time = $jhs_list_uv?sprintf("%.2f",($jhsListTimeCount/$jhs_list_uv)):0;
		}
		//包邮商品点击
		$money_list_list = $money_spike_list = [];
		$money_list_time = $money_spike_time = 0;
		$money_list_pv = $money_spike_pv = 0;
		$money_list_uv = $money_spike_uv = 0;
		$moneyListTimeCount = $moneySpikeTimeCount = 0;
		if (!empty($money)){
			foreach ($money as $k_m => $v_m){
				$money_list[] = $v_m['userunique'];
				$moneyTimeCount += $v_m['timer'];
				if ($v_m['type'] == "Money_spike"){	//今日秒杀
					$money_spike_list[] = $v_m['userunique'];
					$moneySpikeTimeCount += $v_m['timer'];
				}elseif ($v_m['type'] == "Money_detail"){ //商品列表
					$money_list_list[] = $v_m['userunique'];
					$moneyListTimeCount += $v_m['timer'];
				}
			}
			//总数据
			$money_pv = count($money_list);
			$money_uv = count(array_count_values($money_list));
			$money_time = $money_uv?sprintf("%.2f",($moneyTimeCount/$money_uv)):0;
			//今日秒杀
			$money_spike_pv = count($money_spike_list);
			$money_spike_uv = count(array_count_values($money_spike_list));
			$money_spike_time = $money_spike_uv?sprintf("%.2f",($moneySpikeTimeCount/$money_spike_uv)):0;
			//包邮列表
			$money_list_pv = count($money_list_list);
			$money_list_uv = count(array_count_values($money_list_list));
			$money_list_time = $money_list_uv?sprintf("%.2f",($moneyListTimeCount/$money_list_uv)):0;
		}
		//top100商品点击
		$top_list_list = $top_spike_list = [];
		$top_list_pv = $top_spike_pv = 0;
		$top_list_uv = $top_spike_uv = 0;
		$top_list_time = $top_spike_time = 0;
		$topListTimeCount = $topSpikeTimeCount= 0;
		if (!empty($top)){
			foreach ($top as $k_tp => $v_tp){
				$top_list[] = $v_tp['userunique'];
				$topTimeCount += $v_tp['timer'];
				if ($v_tp['type'] == "Top_spike"){
					$top_spike_list[] = $v_tp['userunique'];
					$topSpikeTimeCount += $v_tp['timer'];
				}elseif ($v_tp['type'] == "Top_detail"){
					$top_list_list[] = $v_tp['userunique'];
					$topListTimeCount += $v_tp['timer'];
				}
			}
			//总数据
			$top_pv = count($top_list);
			$top_uv = count(array_count_values($top_list));
			$top_time = $top_uv?sprintf("%.2f",($topTimeCount/$top_uv)):0;
			//top100今日秒杀
			$top_spike_pv = count($top_spike_list);
			$top_spike_uv = count(array_count_values($top_spike_list));
			$top_spike_time = $top_spike_uv?sprintf("%.2f",($topSpikeTimeCount/$top_spike_uv)):0;
			//top100商品列表
			$top_list_pv = count($top_list_list);
			$top_list_uv = count(array_count_values($top_list_list));
			$top_list_time = $top_list_uv?sprintf("%.2f",($topListTimeCount/$top_list_uv)):0;
		}
		//搜索商品点击
		if (!empty($search)){
			foreach ($search as $k_s => $v_s){
				$search_list[] = $v_s['userunique'];
				$searchTimeCount += $v_s['timer'];
			}
			$search_pv = count($search_list);
			$search_uv = count(array_count_values($search_list));
			$search_time = $search_uv?sprintf("%.2f",($searchTimeCount/$search_uv)):0;
		}
		//分类专场
		if (!empty($specialty)){
			foreach ($specialty as $k_ss => $v_ss){
				$specialty_list[] = $v_ss['userunique'];
				$searchTimeCount += $v_ss['timer'];
			}
			$specialty_pv = count($specialty_list);
			$specialty_uv = count(array_count_values($specialty_list));
			$specialty_time = $specialty_uv?sprintf("%.2f",($searchTimeCount/$specialty_uv)):0;
		}
		//品牌馆
		if (!empty($brand)){
			foreach ($brand as $k_b => $v_b){
				$brand_list[] = $v_b['userunique'];
				$brandTimeCount += $v_b['timer'];
			}
			$brand_pv = count($brand_list);
			$brand_uv = count(array_count_values($brand_list));
			$brand_time = $brand_uv?sprintf("%.2f",($brandTimeCount/$brand_uv)):0;
		}
		//总数据
		if (!empty($home)){
			foreach ($home as $k_h => $v_h){
				$home_list[] = $v_h['userunique'];
				$homeTimeCount += $v_h['timer'];
			}
			$home_pv = count($home_list);
			$home_uv = count(array_count_values($home_list));
			$home_time = $home_uv?sprintf("%.2f",($homeTimeCount/$home_uv)):0;
		}
		//数据汇总

		if ($i < 0){
			$info['home_pv'] = $home_pv; //商品点击pv
			$info['home_uv'] = $home_uv; //商品点击uv
			$info['home_time'] = $home_time; //商品点击停留时长
			$info['tmall_pv'] = $tmall_pv; //天猫商品点击pv
			$info['tmall_uv'] = $tmall_uv;
			$info['tmall_time'] = $tmall_time;
			$info['tmall_spike_pv'] = $tmall_spike_pv; //天猫_今日秒杀商品点击pv
			$info['tmall_spike_uv'] = $tmall_spike_uv;
			$info['tmall_spike_time'] = $tmall_spike_time;
			$info['tmall_list_pv'] = $tmall_list_pv; //天猫_列表商品点击pv
			$info['tmall_list_uv'] = $tmall_list_uv;
			$info['tmall_list_time'] = $tmall_list_time;
			$info['jhs_pv'] = $jhs_pv; //聚划算总点击
			$info['jhs_uv'] = $jhs_uv;
			$info['jhs_time'] = $jhs_time;
			$info['jhs_spike_pv'] = $jhs_spike_pv; //聚划算今日秒杀
			$info['jhs_spike_uv'] = $jhs_spike_uv;
			$info['jhs_spike_time'] = $jhs_spike_time;
			$info['jhs_list_pv'] = $jhs_list_pv; //聚划算列表
			$info['jhs_list_uv'] = $jhs_list_uv;
			$info['jhs_list_time'] = $jhs_list_time;
			$info['money_pv'] = $money_pv; //包邮总数据
			$info['money_uv'] = $money_uv;
			$info['money_time'] = $money_time;
			$info['money_spike_pv'] = $money_spike_pv; //包邮今日秒杀
			$info['money_spike_uv'] = $money_spike_uv;
			$info['money_spike_time'] = $money_spike_time;
			$info['money_list_pv'] = $money_list_pv; //包邮商品列表
			$info['money_list_uv'] = $money_list_uv;
			$info['money_list_time'] = $money_list_time;
			$info['top_pv'] = $top_pv; //top100总数
			$info['top_uv'] = $top_uv;
			$info['top_time'] = $top_time;
			$info['top_spike_pv'] = $top_spike_pv; //top100今日秒杀
			$info['top_spike_uv'] = $top_spike_uv;
			$info['top_spike_time'] = $top_spike_time;
			$info['top_list_pv'] = $top_list_pv; //top100商品列表
			$info['top_list_uv'] = $top_list_uv;
			$info['top_list_time'] = $top_list_time;
			$info['search_pv'] = $search_pv; //搜索商品点击
			$info['search_uv'] = $search_uv;
			$info['search_time'] = $search_time;
			$info['specialty_pv'] = $specialty_pv; //分类专场
			$info['specialty_uv'] = $specialty_uv;
			$info['specialty_time'] = $specialty_time;
			$info['brand_pv'] = $brand_pv; //品牌馆
			$info['brand_uv'] = $brand_uv;
			$info['brand_time'] = $brand_time;
		}else{
			$info = [
				[
					'name' => $day,
					'id'   => $i+1,
					'pid'  => 0,
					'PV'   => $home_pv,
					'UV'   => $home_uv,
					'vogTime' => $home_time
				],
				[
					'name' => "天猫国际点击",
					'id'   => $i+2,
					'pid'  => $i+1,
					'PV'   => $tmall_pv,
					'UV'   => $tmall_uv,
					'vogTime' => $tmall_time
				],
				[
					'name' => "天猫国际_今日秒杀",
					'id'   => $i+3,
					'pid'  => $i+2,
					'PV'   => $tmall_spike_pv,
					'UV'   => $tmall_spike_uv,
					'vogTime' => $tmall_spike_time
				],
				[
					'name' => "天猫国际_商品列表",
					'id'   => $i+4,
					'pid'  => $i+2,
					'PV'   => $tmall_list_pv,
					'UV'   => $tmall_list_uv,
					'vogTime' => $tmall_list_time
				],
				[
					'name' => "聚划算点击",
					'id'   => $i+5,
					'pid'  => $i+1,
					'PV'   => $jhs_pv,
					'UV'   => $jhs_uv,
					'vogTime' => $jhs_time
				],
				[
					'name' => "聚划算_今日秒杀",
					'id'   => $i+6,
					'pid'  => $i+5,
					'PV'   => $jhs_spike_pv,
					'UV'   => $jhs_spike_uv,
					'vogTime' => $jhs_spike_time
				],
				[
					'name' => "聚划算_商品列表",
					'id'   => $i+7,
					'pid'  => $i+5,
					'PV'   => $jhs_list_pv,
					'UV'   => $jhs_list_uv,
					'vogTime' => $jhs_list_time
				],
				[
					'name' => "9.9包邮点击",
					'id'   => $i+8,
					'pid'  => $i+1,
					'PV'   => $money_pv,
					'UV'   => $money_uv,
					'vogTime' => $money_time
				],
				[
					'name' => "9.9包邮_今日秒杀",
					'id'   => $i+9,
					'pid'  => $i+8,
					'PV'   => $money_spike_pv,
					'UV'   => $money_spike_uv,
					'vogTime' => $money_spike_time
				],
				[
					'name' => "9.9包邮_商品列表",
					'id'   => $i+10,
					'pid'  => $i+8,
					'PV'   => $money_list_pv,
					'UV'   => $money_list_uv,
					'vogTime' => $money_list_time
				],
				[
					'name' => "TOP100点击",
					'id'   => $i+11,
					'pid'  => $i+1,
					'PV'   => $top_pv,
					'UV'   => $top_uv,
					'vogTime' => $top_time
				],
				[
					'name' => "TOP100_今日秒杀",
					'id'   => $i+12,
					'pid'  => $i+11,
					'PV'   => $top_spike_pv,
					'UV'   => $top_spike_uv,
					'vogTime' => $top_spike_time
				],
				[
					'name' => "TOP100_商品列表",
					'id'   => $i+13,
					'pid'  => $i+11,
					'PV'   => $top_list_pv,
					'UV'   => $top_list_uv,
					'vogTime' => $top_list_time
				],
				[
					'name' => "搜索商品点击",
					'id'   => $i+14,
					'pid'  => $i+1,
					'PV'   => $search_pv,
					'UV'   => $search_uv,
					'vogTime' => $search_time
				],
				[
					'name' => "分类商品点击",
					'id'   => $i+15,
					'pid'  => $i+1,
					'PV'   => $specialty_pv,
					'UV'   => $specialty_uv,
					'vogTime' => $specialty_time
				],
				[
					'name' => "品牌馆商品点击",
					'id'   => $i+16,
					'pid'  => $i+1,
					'PV'   => $brand_pv,
					'UV'   => $brand_uv,
					'vogTime' => $brand_time
				],
			];
		}

		return $info;
	}

	/**
	 * 导出数据
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
		];
		$count = ceil(($endTime - $startTime)/86400);
		$list = [];
		$times = $endTime;
		for ($i=0;$i<=$count;$i++){
			if ($times >= $startTime){
				$day = date("Ymd",$times);
				$data= Db::connect("mongodbData")->name($day)->where($where)->select();
				if (!empty($data)){
					$info = $this->getData($data,$day,-1);
					if (!empty($info)){
						$info['timeName'] = $day;
						$list[] = $info;
					}
				}
				$times = $times - 86400;
			}
		}
		$name = [
			["日期",'timeName'],
			["商品触达pv",'home_pv'],
			["商品触达uv",'home_uv'],
			["商品触达停留时长",'home_time'],
			["天猫商品点击pv",'tmall_pv'],
			["天猫商品点击uv",'tmall_uv'],
			["天猫商品停留时长",'tmall_time'],
			["天猫_今日秒杀商品点击pv",'tmall_spike_pv'],
			["天猫_今日秒杀商品点击uv",'tmall_spike_uv'],
			["天猫_今日秒杀商品停留时长",'tmall_spike_time'],
			["天猫_列表商品点击pv",'tmall_list_pv'],
			["天猫_列表商品点击uv",'tmall_list_uv'],
			["天猫_列表商品停留时长",'tmall_list_time'],
			["聚划算商品点击pv",'jhs_pv'],
			["聚划算商品点击uv",'jhs_uv'],
			["聚划算商品停留时长",'jhs_time'],
			["聚划算今日秒杀点击pv",'jhs_spike_pv'],
			["聚划算今日秒杀点击uv",'jhs_spike_uv'],
			["聚划算今日秒杀停留时长",'jhs_spike_time'],
			["聚划算列表点击pv",'jhs_list_pv'],
			["聚划算列表点击uv",'jhs_list_uv'],
			["聚划算列表停留时长",'jhs_list_time'],
			["包邮商品点击pv",'money_pv'],
			["包邮商品点击uv",'money_uv'],
			["包邮商品停留时长",'money_time'],
			["包邮今日秒杀商品pv",'money_spike_pv'],
			["包邮今日秒杀商品uv",'money_spike_uv'],
			["包邮今日秒杀商品停留时长",'money_spike_time'],
			["包邮列表商品pv",'money_list_pv'],
			["包邮列表商品uv",'money_list_uv'],
			["包邮列表商品停留时长",'money_list_time'],
			["top100商品点击pv",'top_pv'],
			["top100商品点击uv",'top_uv'],
			["top100商品点击停留时长",'top_time'],
			["top100今日秒杀pv",'top_spike_pv'],
			["top100今日秒杀uv",'top_spike_uv'],
			["top100今日秒杀停留时长",'top_spike_time'],
			["top100商品列表pv",'top_list_pv'],
			["top100商品列表uv",'top_list_uv'],
			["top100商品列表停留时长",'top_list_time'],
			["搜索商品点击pv",'search_pv'],
			["搜索商品点击uv",'search_uv'],
			["搜索商品点击停留时长",'search_time'],
			["分类专场商品pv",'specialty_pv'],
			["分类专场商品uv",'specialty_uv'],
			["分类专场商品停留时长",'specialty_time'],
			["品牌馆商品点击pv",'brand_pv'],
			["品牌馆商品点击uv",'brand_uv'],
			["品牌馆商品停留时长",'brand_time'],
		];
		$phpExcel = new Excel();
		$phpExcel->daoChu($list,$name);
	}


}