<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/12/27
 * Time: 14:14
 */

namespace app\media\controller;


use app\common\controller\Api;

class Columnapi extends Api
{
	/**
	 * 下拉分类
	 * @return array
	 */
	public function index()
	{
		$param = input('param.data');
		$media_id = $param['media_id'];
		$sex      = $param['sex'];

		$a = 1;
		if ($sex == 1){
			$a = 2;
		}
		$column = db("column")->field("column_id,column_title,column_media_id,column_thumb")
			->where("column_media_id",['=',0],['=',$media_id],'or')
			->where("column_status","<>",-1)
			->where("column_sex","<>",$a)
			->where("column_type","=",0)
			->order("column_media_id desc,column_sort asc")->select();
		$arr = [
			[
				'title'  => '热门分类',
				'column' => []
			],
			[
				'title'  => '专属分类',
				'column' => []
			]
		];
		foreach ($column as $key => $value){
			if ($value['column_media_id'] == 0){
				$arr[1]['column'][] = $value;
			}else{
				$arr[0]['column'][] = $value;
			}
		}
		$this->response['response'] = $arr;
		return $this->response;
	}




}