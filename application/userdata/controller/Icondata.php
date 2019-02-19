<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/1/15
 * Time: 11:38
 */

namespace app\userdata\controller;


use app\admin\controller\Base;
use fuk\Excel;
use think\Controller;
use think\Db;

class Icondata extends Controller
{
	/**
	 * 数据首页
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
						$info = $this->getIndexData($data,$day,$i*18);
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
	 * 数据获取
	 * @param array $data 数据集
	 * @param string $day 查询表
	 * @param int $i  循环数
	 * @return mixed
	 */
	public function getIndexData($data=[],$day="",$i=0)
	{
		$home = $home_icon = $home_footer = $home_column = $home_column_goods = $home_quan = $home_sex = $home_banner = $home_spike = $home_detail = [];
		$home_list = $icon_list = $footer_list = $column_list = $column_goods_list = $quan_list = $sex_list = $banner_list = $spike_list = $detail_list = [];
		$count_pv = $home_pv = $icon_pv = $footer_pv = $column_pv = $column_goods_pv =$quan_pv = $sex_pv = $banner_pv = $spike_pv = $detail_pv = 0;
		$count_uv = $home_uv = $icon_uv = $footer_uv = $column_uv = $column_goods_uv =$quan_uv = $sex_uv = $banner_uv = $spike_uv = $detail_uv = 0;
		$home_lose = 0;
		$count_time = $home_time = $icon_time = $footer_time = $column_time = $column_goods_time = $quan_time = $banner_time = $spike_time = $detail_time = 0;
		$homeTimeCount = $homeIconTimeCount = $homeFooterTimeCount = $homeColumnTimeCount = $homeColumnGoodsTimeCount = $homeQuanTimeCount = $homeBannerTimeCount = $homeSpikeTimeCount = $homeDetailTimeCount = 0;

		//新写的
		foreach ($data as $m => $n){
			if (strpos($n['type'],"index") !== false){ //首页汇总
				$home[] = $n;
				$homeTimeCount += $n['timer'];
			}
			if ($n['type'] == 'index_icon'){   //首页icon点击汇总
				$home_icon[] = $n;
				$homeIconTimeCount += $n['timer'];
			}
			if (strpos($n['type'],"index_footer_") !== false){//底部按钮点击
				$home_footer[] = $n;
				$homeFooterTimeCount += $n['timer'];
			}
			if ($n['type'] == "index_column" && strpos($n['clickid'],"_") == false){ //首页模块(模块更多)
				$home_column[] = $n;
				$homeColumnTimeCount += $n['timer'];
			}
			if ($n['type'] == "index_column" && strpos($n['clickid'],"_") !== false){ //首页模块(模块商品)
				$home_column_goods[] = $n;
				$homeColumnGoodsTimeCount += $n['timer'];
			}
			if ($n['type'] == "index_guide"){ //领券指南
				$home_quan[] = $n;
				$homeQuanTimeCount += $n['timer'];
			}
			if ($n['type'] == "index_sex"){ //性别切换
				$home_sex[] = $n;
			}
			if ($n['type'] == "index_banner"){ //首页banner
				$home_banner[] = $n;
			}
			if ($n['type'] == "Index_spike"){ //今日秒杀
				$home_spike[] = $n;
			}
			if ($n['type'] == "Index_detail"){ //精选商品
				$home_detail[] = $n;
			}
		}
		//首页点击
		if (!empty($home)){
			foreach ($home as $k => $v){
				$home_list[] = $v['userunique'];
				$homeTimeCount += $v['timer'];
			}
			$home_pv  = count($home_list);
			$home_uv  = count(array_count_values($home_list));
			$home_time = $home_uv?sprintf("%.2f",($homeTimeCount/$home_uv)):0;
		}
		//icon点击
		$icon_list_tmall_time = $icon_list_brand_time = $icon_list_jhs_time = $icon_list_baoyou_time = 0;
		$icon_list_tmall = $icon_list_brand = $icon_list_jhs = $icon_list_baoyou = [];
		$icon_tmall_pv = $icon_brand_pv = $icon_jhs_pv = $icon_baoyou_pv = 0;
		$icon_tmall_uv = $icon_brand_uv = $icon_jhs_uv = $icon_baoyou_uv = 0;
		$icon_tmall_time = $icon_brand_time = $icon_jhs_time = $icon_baoyou_time = 0;
		if (!empty($home_icon)){
			foreach ($home_icon as $k_i => $v_i){
				$icon_list[] = $v_i['userunique'];  //总数据
				$homeIconTimeCount += $v_i['timer'];
				if ($v_i['clickid'] == 1){          //天猫点击
					$icon_list_tmall[] = $v_i['userunique'];
					$icon_list_tmall_time += $v_i['timer'];
				}elseif ($v_i['clickid'] == 2){     //品牌馆点击
					$icon_list_brand[] = $v_i['userunique'];
					$icon_list_brand_time += $v_i['timer'];
				}elseif ($v_i['clickid'] == 3){     //聚划算点击
					$icon_list_jhs[] = $v_i['userunique'];
					$icon_list_jhs_time += $v_i['timer'];
				}elseif ($v_i['clickid'] == 4){     //包邮点击
					$icon_list_baoyou[] = $v_i['userunique'];
					$icon_list_baoyou_time += $v_i['timer'];
				}
			}
			//总的
			$icon_pv  = count($icon_list);
			$icon_uv  = count(array_count_values($icon_list));
			$icon_time = $icon_uv?sprintf("%.2f",($homeIconTimeCount/$icon_uv)):0;
			//天猫
			$icon_tmall_pv = count($icon_list_tmall);
			$icon_tmall_uv = count(array_count_values($icon_list_tmall));
			$icon_tmall_time = $icon_tmall_uv?sprintf("%.2f",($icon_list_tmall_time/$icon_tmall_uv)):0;
			//品牌馆
			$icon_brand_pv = count($icon_list_brand);
			$icon_brand_uv = count(array_count_values($icon_list_brand));
			$icon_brand_time = $icon_brand_uv?sprintf("%.2f",($icon_list_brand_time/$icon_brand_uv)):0;
			//聚划算
			$icon_jhs_pv = count($icon_list_jhs);
			$icon_jhs_uv = count(array_count_values($icon_list_jhs));
			$icon_jhs_time = $icon_jhs_uv?sprintf("%.2f",($icon_list_jhs_time/$icon_jhs_uv)):0;
			//9.9包邮
			$icon_baoyou_pv = count($icon_list_baoyou);
			$icon_baoyou_uv = count(array_count_values($icon_list_baoyou));
			$icon_baoyou_time = $icon_baoyou_uv?sprintf("%.2f",($icon_list_baoyou_time/$icon_baoyou_uv)):0;
		}
		//底部按钮
		$footer_list_index = $footer_list_top = $footer_list_money = [];
		$footer_list_index_time = $footer_list_top_time = $footer_list_money_time = 0;
		$footer_index_pv = $footer_top_pv = $footer_money_pv = 0;
		$footer_index_uv = $footer_top_uv = $footer_money_uv = 0;
		$footer_index_time = $footer_top_time = $footer_money_time = 0;
		if (!empty($home_footer)){
			foreach ($home_footer as $k_f => $v_f){
				$footer_list[] = $v_f['userunique'];             //总数据
				$homeFooterTimeCount += $v_f['timer'];
				if ($v_f['type'] == "index_footer_index"){       //首页
					$footer_list_index[] = $v_f['userunique'];
					$footer_list_index_time += $v_f['timer'];
				}elseif ($v_f['type'] == "index_footer_top"){    //top
					$footer_list_top[] = $v_f['userunique'];
					$footer_list_top_time += $v_f['timer'];
				}elseif ($v_f['type'] == "index_footer_money"){  //包邮
					$footer_list_money[] = $v_f['userunique'];
					$footer_list_money_time += $v_f['timer'];
				}
			}
			$footer_pv  = count($footer_list);
			$footer_uv  = count(array_count_values($footer_list));
			$footer_time = $footer_uv?sprintf("%.2f",($homeFooterTimeCount/$footer_uv)):0;
			//首页
			$footer_index_pv = count($footer_list_index);
			$footer_index_uv = count(array_count_values($footer_list_index));
			$footer_index_time = $footer_index_uv?sprintf("%.2f",($footer_list_index_time/$footer_index_uv)):0;
			//top
			$footer_top_pv = count($footer_list_top);
			$footer_top_uv = count(array_count_values($footer_list_top));
			$footer_top_time = $footer_top_uv?sprintf("%.2f",($footer_list_top_time/$footer_top_uv)):0;
			//包邮
			$footer_money_pv = count($footer_list_money);
			$footer_money_uv = count(array_count_values($footer_list_money));
			$footer_money_time = $footer_money_uv?sprintf("%.2f",($footer_list_money_time/$footer_money_uv)):0;
		}
		//首页模块(更多)
		/*$media_id = db("media")->where("media_ident","=","csmt")->value("media_id");
		$media_id = 3;
		$map = [
			['column_media_id',"=",$media_id],
			['column_status',"=",1],
		];
		$column = db("column")->where($map)->column("column_id");*/
		if (!empty($home_column)){
			foreach ($home_column as $k_c => $v_c){
				$column_list[] = $v_c['userunique'];
				$homeColumnTimeCount += $v_c['timer'];
				/*if (!empty($column)){
					foreach ($column as $k_cc => $v_cc){
						if ($v_c['clickid'] == $v_cc){
							
						}
					}
				}*/
			}
			$column_pv  = count($column_list);
			$column_uv  = count(array_count_values($column_list));
			$column_time = $column_uv?sprintf("%.2f",($homeColumnTimeCount/$column_uv)):0;
		}
		//首页模块(商品)
		if (!empty($home_column_goods)){
			foreach ($home_column_goods as $k_c_g => $v_c_g){
				$column_goods_list[] = $v_c_g['userunique'];
				$homeColumnGoodsTimeCount += $v_c_g['timer'];
			}
			$column_goods_pv = count($column_goods_list);
			$column_goods_uv = count(array_count_values($column_goods_list));
			$column_goods_time = $column_goods_uv?sprintf("%.2f",($homeColumnGoodsTimeCount/$column_goods_uv)):0;
		}
		//领券指南(新手引导)
		if (!empty($home_quan)){
			foreach ($home_quan as $k_q => $v_q){
				$quan_list[] = $v_q['userunique'];
				$homeQuanTimeCount += $v_q['timer'];
			}
			$quan_pv = count($quan_list);
			$quan_uv = count(array_count_values($quan_list));
			$quan_time = $quan_uv?sprintf("%.2f",($homeQuanTimeCount/$quan_uv)):0;
		}
		//性别切换
		if (!empty($home_sex)){
			foreach ($home_sex as $k_s => $v_s){
				$sex_list[] = $v_s['userunique'];
			}
			$sex_pv = count($sex_list);
			$sex_pv = count(array_count_values($sex_list));
		}
		//首页广告
		if (!empty($home_banner)){
			foreach ($home_banner as $k_b => $v_b){
				$banner_list[] = $v_b['userunique'];
				$homeBannerTimeCount += $v_b['timer'];
			}
			$banner_pv = count($banner_list);
			$banner_uv = count(array_count_values($banner_list));
			$banner_time = $banner_uv?sprintf("%.2f",($homeBannerTimeCount/$banner_uv)):0;
		}
		//今日秒杀
		if (!empty($home_spike)){
			foreach ($home_spike as $k_s_j => $v_s_j){
				$spike_list[] = $v_s_j['userunique'];
				$homeSpikeTimeCount += $v_s_j['timer'];
			}
			$spike_pv = count($spike_list);
			$spike_uv = count(array_count_values($spike_list));
			$spike_time = $spike_uv?sprintf("%.2f",($homeSpikeTimeCount/$spike_uv)):0;
		}
		//精选商品
		if (!empty($home_detail)){
			foreach ($home_detail as $k_d => $v_d){
				$detail_list[] = $v_d['userunique'];
				$homeDetailTimeCount += $v_d['timer'];
			}
			$detail_pv = count($detail_list);
			$detail_uv = count(array_count_values($detail_list));
			$detail_time = $detail_uv?sprintf("%.2f",($homeDetailTimeCount/$detail_uv)):0;
		}

		//首页点击汇总
		$count_pv = $icon_pv + $footer_pv + $column_pv + $column_goods_pv + $quan_pv + $sex_pv + $banner_pv + $spike_pv + $detail_pv;
		$count_uv = max($icon_uv,$footer_uv,$column_uv,$column_goods_uv,$quan_uv,$sex_uv,$banner_pv,$spike_uv,$detail_uv);
		$count_time = $icon_time + $footer_time + $column_time + $column_goods_time + $quan_time + $banner_time + $spike_time + $detail_time;
		/*********************************************************删除**************************************************/
		//数据汇总(导出excel)
		if ($i < 0){
			$info['home_pv'] = $home_pv;  //触达pv
			$info['home_uv'] = $home_uv;  //触达uv
			$info['home_time'] = $home_time; //触达停留时长
			$info['count_pv'] = $count_pv;  //点击pv
			$info['count_uv'] = $count_uv;  //点击uv
			$info['count_time'] = $count_time; //点击停留时长
			$info['icon_pv'] = $icon_pv;  //ICON点击pv
			$info['icon_uv'] = $icon_uv;  //ICON点击uv
			$info['icon_time'] = $icon_time; //ICON停留时长
			$info['icon_tmall_pv'] = $icon_tmall_pv; //ICON_tmall点击pv
			$info['icon_tmall_uv'] = $icon_tmall_uv; //ICON_tmall点击uv
			$info['icon_tmall_time'] = $icon_tmall_time; //ICON_tmall停留时长
			$info['icon_brand_pv'] = $icon_brand_pv; //ICON_品牌馆点击pv
			$info['icon_brand_uv'] = $icon_brand_uv; //ICON_品牌馆点击uv
			$info['icon_brand_time'] = $icon_brand_time; //ICON_品牌馆停留时长
			$info['icon_jhs_pv'] = $icon_jhs_pv; //ICON_聚划算点击pv
			$info['icon_jhs_uv'] = $icon_jhs_uv; //ICON_聚划算点击uv
			$info['icon_jhs_time'] = $icon_jhs_time; //ICON_聚划算停留时长
			$info['icon_baoyou_pv'] = $icon_baoyou_pv; //ICON_包邮点击pv
			$info['icon_baoyou_uv'] = $icon_baoyou_uv; //ICON_包邮点击uv
			$info['icon_baoyou_time'] = $icon_baoyou_time; //ICON_包邮停留时长
			$info['footer_pv'] = $footer_pv; //底部按钮点击pv
			$info['footer_uv'] = $footer_uv; //底部按钮点击uv
			$info['footer_time'] = $footer_time; //底部按钮停留时长
			$info['footer_index_pv'] = $footer_index_pv; //底部_首页按钮点击pv
			$info['footer_index_uv'] = $footer_index_uv; //底部_首页按钮点击pv
			$info['footer_index_time'] = $footer_index_time; //底部_首页按钮停留时长
			$info['footer_top_pv'] = $footer_top_pv; //底部_top100按钮点击pv
			$info['footer_top_uv'] = $footer_top_uv; //底部_top100按钮点击pv
			$info['footer_top_time'] = $footer_top_time; //底部_top100按钮停留时长
			$info['footer_money_pv'] = $footer_money_pv; //底部_包邮按钮点击pv
			$info['footer_money_uv'] = $footer_money_uv; //底部_包邮按钮点击pv
			$info['footer_money_time'] = $footer_money_time; //底部_包邮按钮停留时长
			$info['column_pv'] = $column_pv; //首页模块更多
			$info['column_uv'] = $column_uv;
			$info['column_time'] = $column_time;
			$info['column_goods_pv'] = $column_goods_pv; //首页模块商品
			$info['column_goods_uv'] = $column_goods_uv;
			$info['column_goods_time'] = $column_goods_time;
			$info['quan_pv'] = $quan_pv; //新手引导
			$info['quan_uv'] = $quan_uv;
			$info['quan_time'] = $quan_time;
			$info['sex_pv'] = $sex_pv; //性别切换
			$info['sex_uv'] = $sex_uv;
			$info['banner_pv'] = $banner_pv; //首页广告
			$info['banner_uv'] = $banner_uv;
			$info['banner_time'] = $banner_time;
			$info['spike_pv'] = $spike_pv; //首页今日秒杀
			$info['spike_uv'] = $spike_uv;
			$info['spike_time'] = $spike_time;
			$info['detail_pv'] = $detail_pv; //首页精选商品
			$info['detail_uv'] = $detail_uv;
			$info['detail_time'] = $detail_time;

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
					'name' => "触达点击数据",
					'id'   => $i+2,
					'pid'  => $i+1,
					'PV'   => $count_pv,
					'UV'   => $count_uv,
					'vogTime' => $count_time
				],
				[
					'name' => "icon点击",
					'id'   => $i+3,
					'pid'  => $i+1,
					'PV'   => $icon_pv,
					'UV'   => $icon_uv,
					'vogTime' => $icon_time
				],
				[
					'name' => "icon_天猫国际",
					'id'   => $i+4,
					'pid'  => $i+3,
					'PV'   => $icon_tmall_pv,
					'UV'   => $icon_tmall_uv,
					'vogTime' => $icon_tmall_time
				],
				[
					'name' => "icon_品牌馆",
					'id'   => $i+5,
					'pid'  => $i+3,
					'PV'   => $icon_brand_pv,
					'UV'   => $icon_brand_uv,
					'vogTime' => $icon_brand_time
				],
				[
					'name' => "icon_聚划算",
					'id'   => $i+6,
					'pid'  => $i+3,
					'PV'   => $icon_jhs_pv,
					'UV'   => $icon_jhs_uv,
					'vogTime' => $icon_jhs_time
				],
				[
					'name' => "icon_9.9包邮",
					'id'   => $i+7,
					'pid'  => $i+3,
					'PV'   => $icon_baoyou_pv,
					'UV'   => $icon_baoyou_uv,
					'vogTime' => $icon_baoyou_time
				],
				[
					'name' => "底部按钮",
					'id'   => $i+8,
					'pid'  => $i+1,
					'PV'   => $footer_pv,
					'UV'   => $footer_uv,
					'vogTime' => $footer_time
				],
				[
					'name' => "footer_首页",
					'id'   => $i+9,
					'pid'  => $i+8,
					'PV'   => $footer_index_pv,
					'UV'   => $footer_index_uv,
					'vogTime' => $footer_index_time
				],
				[
					'name' => "footer_9.9包邮",
					'id'   => $i+10,
					'pid'  => $i+8,
					'PV'   => $footer_money_pv,
					'UV'   => $footer_money_uv,
					'vogTime' => $footer_money_time
				],
				[
					'name' => "footer_top100",
					'id'   => $i+11,
					'pid'  => $i+8,
					'PV'   => $footer_top_pv,
					'UV'   => $footer_top_uv,
					'vogTime' => $footer_top_time
				],
				[
					'name' => "领券指南",
					'id'   => $i+12,
					'pid'  => $i+1,
					'PV'   => $quan_pv,
					'UV'   => $quan_uv,
					'vogTime' => $quan_time
				],
				[
					'name' => "性别切换",
					'id'   => $i+13,
					'pid'  => $i+1,
					'PV'   => $sex_pv,
					'UV'   => $sex_pv,
					'vogTime' => "-"
				],
				[
					'name' => "首页广告",
					'id'   => $i+14,
					'pid'  => $i+1,
					'PV'   => $banner_pv,
					'UV'   => $banner_uv,
					'vogTime' => $banner_time
				],
				[
					'name' => "首页模块(商品)",
					'id'   => $i+15,
					'pid'  => $i+1,
					'PV'   => $column_goods_pv,
					'UV'   => $column_goods_uv,
					'vogTime' => $column_goods_time
				],
				[
					'name' => "首页模块(更多)",
					'id'   => $i+16,
					'pid'  => $i+1,
					'PV'   => $column_pv,
					'UV'   => $column_uv,
					'vogTime' => $column_time
				],
				[
					'name' => "首页秒杀商品点击",
					'id'   => $i+17,
					'pid'  => $i+1,
					'PV'   => $spike_pv,
					'UV'   => $spike_uv,
					'vogTime' => $spike_time
				],
				[
					'name' => "首页精选商品点击",
					'id'   => $i+18,
					'pid'  => $i+1,
					'PV'   => $detail_pv,
					'UV'   => $detail_uv,
					'vogTime' => $detail_time
				],
			];
		}
		return $info;
	}

	/**
	 * 导出excel
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
			["type","like","index"],
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
					$info = $this->getIndexData($data,$day,-1);
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
			["触达pv",'home_pv'],
			["触达uv",'home_uv'],
			["触达停留时长",'home_time'],
			["触达点击pv",'count_pv'],
			["触达点击uv",'count_uv'],
			["触达点击停留时长",'count_time'],
			["ICON点击pv",'icon_pv'],
			["ICON点击uv",'icon_uv'],
			["ICON停留时长",'icon_time'],
			["ICON_tmall点击pv",'icon_tmall_pv'],
			["ICON_tmall点击uv",'icon_tmall_uv'],
			["ICON_tmall停留时长",'icon_tmall_time'],
			["ICON_品牌馆点击pv",'icon_brand_pv'],
			["ICON_品牌馆点击uv",'icon_brand_uv'],
			["ICON_品牌馆停留时长",'icon_brand_time'],
			["ICON_聚划算点击pv",'icon_jhs_pv'],
			["ICON_聚划算点击uv",'icon_jhs_uv'],
			["ICON_聚划算停留时长",'icon_jhs_time'],
			["ICON_包邮点击pv",'icon_baoyou_pv'],
			["ICON_包邮点击uv",'icon_baoyou_uv'],
			["ICON_包邮停留时长",'icon_baoyou_time'],
			["底部按钮点击pv",'footer_pv'],
			["底部按钮点击uv",'footer_uv'],
			["底部按钮停留时长",'footer_time'],
			["底部_首页按钮点击pv",'footer_index_pv'],
			["底部_首页按钮点击uv",'footer_index_uv'],
			["底部_首页按钮停留时长",'footer_index_time'],
			["底部_top100按钮点击pv",'footer_top_pv'],
			["底部_top100按钮点击uv",'footer_top_uv'],
			["底部_top100按钮停留时长",'footer_top_time'],
			["底部_包邮按钮点击pv",'footer_money_pv'],
			["底部_包邮按钮点击uv",'footer_money_uv'],
			["底部_包邮按钮停留时长",'footer_money_time'],
			["首页模块更多PV",'column_pv'],
			["首页模块更多UV",'column_uv'],
			["首页模块更多停留时长",'column_time'],
			["首页模块商品pv",'column_goods_pv'],
			["首页模块商品uv",'column_goods_uv'],
			["首页模块商品停留时长",'column_goods_time'],
			["新手引导pv",'quan_pv'],
			["新手引导uv",'quan_uv'],
			["新手引导停留时长",'quan_time'],
			["性别切换pv",'sex_pv'],
			["性别切换uv",'sex_uv'],
			["首页广告pv",'banner_pv'],
			["首页广告uv",'banner_uv'],
			["首页广告停留时长",'banner_time'],
			["首页今日秒杀pv",'spike_pv'],
			["首页今日秒杀uv",'spike_uv'],
			["首页今日秒杀停留时长",'spike_time'],
			["首页精选商品pv",'detail_pv'],
			["首页精选商品uv",'detail_uv'],
			["首页精选商品停留时长",'detail_time']
		];
		$phpExcel = new Excel();
		$phpExcel->daoChu($list,$name);
	}

}