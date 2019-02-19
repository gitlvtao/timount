<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/1/14
 * Time: 16:44
 */

namespace app\userdata\controller;


use app\admin\controller\Base;
use fuk\Excel;
use think\Db;

class Hotdata extends Base
{
	/**
	 * 数据展示
	 * @return array|\think\response\View
	 * @throws \think\Exception
	 */
	public function index()
	{
		if (request()->isPost()){
			$param = input('param.');
			$info = $this->getData($param);
			if (!$info){
				return ['code'=>0,'msg'=>'获取成功!','data'=>[],'count'=>0,'rel'=>1];exit();
			}
			return ['code'=>0,'msg'=>'获取成功!','data'=>$info,'count'=>count($info),'rel'=>1];exit();
		}
		$media = db("media")->where("media_status",'<>',-1)->field("media_ident,media_title")->select();
		return view("index",['media'=>$media]);
	}

	/**
	 * 导出excel
	 * @throws \think\Exception
	 */
	public function phpExcel()
	{
		$param = input('param.');
		$data = $this->getData($param);
		$name = [
			['热搜词','title'],
			['搜索次数','num']
		];
		$phpExcel = new Excel();
		$phpExcel->daoChu($data,$name);
	}

	/**
	 * 数据获取处理
	 * @param array $param 数据来源
	 * @return array|bool
	 * @throws \think\Exception
	 */
	public function getData($param=[])
	{
		if (empty($param)){
			return false;exit();
		}
		if (!empty($param['time'])){
			$startTime = strtotime(trim(explode("/",$param['time'])[0]));
			$endTime   = strtotime(trim(explode("/",$param['time'])[1]));
		}else{
			$startTime = strtotime(date("Ymd"));
			$endTime   = $startTime + 86400;
		}
		$count = ceil(($endTime - $startTime)/86400);
		$where = [
			["type","like","search_"],
			["ident","=",$param['media_id']],
		];
		$list = $arr_search = $info = [];
		$times = $endTime;
		for ($i=0;$i<=$count;$i++){
			if ($times >= $startTime){
				$day = date("Ymd",$times);
				$data= Db::connect("mongodbData")->name($day)->where($where)->select();
				if (!empty($data)){
					$list = array_merge($list,$data);
				}
				$times = $times - 86400;
			}
		}
		if (!empty($list)){
			foreach ($list as $key => $value){
				$arr_search[] = $value['clickid'];
			}
		}
		$arr_value = array_values(array_count_values($arr_search));
		$arr_key   = array_keys(array_count_values($arr_search));
		for ($j=0;$j<count($arr_value);$j++){
			$info[$j]['num']   = $arr_value[$j];
			$info[$j]['title'] = $arr_key[$j];
		}
		rsort($info);
		return $info;
	}
}