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

class Indexdata extends Controller
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
//				["type","like","index"],
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
						$info = $this->getIndexData($data,$day,$i*5);
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
		$list_one = $list_two = $list_three = $list_four = $list_five = [];
		$arr_list_one = $arr_list_two = $arr_list_three = $arr_list_four = $arr_list_five =[];
		$timeCount = 0;
		foreach ($data as $m => $n){
			//首页触达
			if ($n['type'] == "index"){
				$list_one[] = $n;
				$timeCount += $n['timer'];
			}
			//首页点击
			if (strpos($n['type'],"index_") !== false){
				$list_two[] = $n;
			}
			//首页性别切换
			if ($n['type'] == "index_sex"){
				$list_three[] = $n;
			}
			//首页新手引导
			if ($n['type'] == "index_guide"){
				$list_four[] = $n;
			}
			//搜索词
			if (strpos($n['type'],"search_") !== false){
				$list_five[] = $n;
			}

		}
		/**************************************************************************************/
		//页面触达数据
		if (!empty($list_one)){
			foreach ($list_one as $key => $value){
				$arr_list_one[$key] = $value['userunique'];
			}
		}
		$userData_one = array_count_values($arr_list_one);
		$pv = count($list_one);            //触达pv
		$uv = count($userData_one);        //触达uv
		/*************************************************************************************/
		//首页点击数据
		if (!empty($list_two)){
			foreach ($list_two as $k => $v){
				$arr_list_two[$k] = $v['userunique'];
			}
		}
		$userData_two = array_count_values($arr_list_two);
		$PV = count($list_two);         //首页点击pv
		$UV = count($userData_two);     //首页uv
		/************************************************************************************/
		//男女按钮点击
		if (!empty($list_three)){
			foreach ($list_three as $k => $v){
				$arr_list_three[$k] = $v['userunique'];
			}
		}
		$userData_three = array_count_values($arr_list_three);
		$pv_sex = count($list_three);
		$uv_sex = count($userData_three);
		/************************************************************************************/
		//新手引导点击
		if (!empty($list_four)){
			foreach ($list_four as $k => $v){
				$arr_list_four[$k] = $v['userunique'];
			}
		}
		$userData_four = array_count_values($arr_list_four);
		$pv_new = count($list_four);
		$uv_new = count($userData_four);
		/************************************************************************************/
		//搜索
		if (!empty($list_five)){
			foreach ($list_five as $k => $v){
				$arr_list_five[$k] = $v['userunique'];
			}
		}
		$userData_five = array_count_values($arr_list_five);
		$pv_search = count($list_five);
		$uv_search = count($userData_five);
		/************************************************************************************/
		//搜索


		//数据汇总
		if ($i < 0){
			$info['vogTime'] = ($uv?sprintf("%.2f",($timeCount/$uv)):0)."s" ;     //平均停留时常
			$info['pv'] = $pv;  //首页触达pv
			$info['uv'] = $uv;  //首页触达uv
			$info['PV'] = $PV;  //首页点击pv
			$info['UV'] = $UV;  //首页点击uv
			$info['pv_sex'] = $pv_sex;  //男女切换pv
			$info['uv_sex'] = $uv_sex;  //男女切换uv
			$info['pv_new'] = $pv_new;  //新手引导pv
			$info['uv_new'] = $uv_new;  //新手引导pv
			$info['lose']   = (($uv?sprintf("%.2f",(1 - ($UV/$uv))):0)*100)."%"; //首页跳出
		}else{
			$info = [
				[
					'name' => $day,
					'id'   => $i+1,
					'pid'  => 0,
					'PV'   => '',
					'UV'   => '',
					'vogTime' => $uv?sprintf("%.2f",($timeCount/$uv)):0,
					'lose'    => $uv?sprintf("%.2f",(1 - ($UV/$uv))):0
				],
				[
					'name' => "首页触达",
					'id'   => $i+2,
					'pid'  => $i+1,
					'PV'   => $pv,
					'UV'   => $uv,
					'vogTime' => "-",
					'lose'    => "-",
				],
				[
					'name' => "首页点击",
					'id'   => $i+3,
					'pid'  => $i+1,
					'PV'   => $PV,
					'UV'   => $UV,
					'vogTime' => "-",
					'lose'    => "-",
				],
				[
					'name' => "男女切换",
					'id'   => $i+4,
					'pid'  => $i+1,
					'PV'   => $pv_sex,
					'UV'   => $uv_sex,
					'vogTime' => "-",
					'lose'    => "-",
				],
				[
					'name' => "新手引导",
					'id'   => $i+5,
					'pid'  => $i+1,
					'PV'   => $pv_new,
					'UV'   => $uv_new,
					'vogTime' => "-",
					'lose'    => "-",
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

		//固定参数（数据库本地）
		$param['media_id'] = "csmt";

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
			["首页跳出率",'lose'],
			["平均停留时长",'vogTime'],
			["首页触达pv",'pv'],
			["首页触达uv",'uv'],
			["首页点击pv",'PV'],
			["首页点击uv",'UV'],
			["男女切换pv",'pv_sex'],
			["男女切换uv",'uv_sex'],
			["新手引导pv",'pv_new'],
			["新手引导uv",'uv_new']
		];

		$phpExcel = new Excel();
		$phpExcel->daoChu($list,$name);
	}

}