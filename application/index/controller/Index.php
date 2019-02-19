<?php
namespace app\index\controller;

use app\common\controller\Api;
use fuk\DataCrypt;
use think\facade\Cache;
use think\Db;

class Index extends Api
{
    public function index()
    {
        dump(input('param.'));
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:) </h1><p> ThinkPHP V5.1<br/><span style="font-size:30px">12载初心不改（2006-2018） - 你值得信赖的PHP框架</span></p></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=64890268" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="eab4b9f840753f8e7"></think>';
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }

    public function abc() {
        /*$data = '8tDLyCqqeoumpCAJ0r7ndQKhQAe0Ui8MYhANKgvz8xXppBfwHJjxeghua1Vt+JEx';
        $abc = DataCrypt::decrypt($data, config('app.crypt.key'), config('app.crypt.iv'));
        return $abc;*/
        $data = [
            'ident' => 'whtx',
            'keyword' => '裤衩',
            'priceRange' => '10_100',
            'order' => 'price',
            'direction' => 'asc',
            'goodsId' => 'search_1200', // media_1 search_1 topall_1
            'columnId' => 1,
        ];
        $sign = md5(http_build_query($data).'&openId='.config('app.crypt.opendId'));
        //$data['sign'] = $sign;
        $aa = DataCrypt::encrypt($data, config('app.crypt.key'), config('app.crypt.iv'));
        echo $aa.'<br />';
    }

    public function a() {
        if (request()->isAjax()) {
            return [1,2,3,4,5,'我收'];
        } else {
            return view();
        }
    }

	//加解密
	public function en() {
		$param = input('param.');
		$data = $param;
		/*$data = [
			'articleId' => 1,
		];*/
		$sign = md5(http_build_query($data).'&openId='.config('app.crypt.opendId'));
		$data['sign'] = $sign;

		return DataCrypt::encrypt(json_encode($data), config('app.crypt.key'), config('app.crypt.iv'));
	}

	public function de() {
		$param = request()->only('data');
		$data = $param['data'];
		//$data = 'AdsuCsC/YfYZ0SH/H2IApVNwJk8Jhep7UzladsBaz3W2RlL/t+gHdIO2w5nTGqOWyGMclW+j8OPSjDTH+/yPdEnM+PAzXsNuOuRNLod+iWt4mp6VYit/eTNqGL/XelbGr/9NPOCOYeZUPpOS9PqU4TvOAHvlh06upUAyhoqGuG0nFP4+Q7dby/yvjlWOGZpD6lRqREASsstO7UuKhuem8bd2TmSiLyYqZ8ec0ceqhsthlxn/Bc8Lj2WLoG+Y5WOv';
		return DataCrypt::decrypt($data, config('app.crypt.key'), config('app.crypt.iv'));
	}



    /*
     * mongodb 数据库连接
     */
    public function cs()
	{
		$data = Db::connect('mongodb')->name('topall')->limit(20,20)->select();
		dump($data);exit;
	}

	public function mongoD()
	{
//		$data = Db::connect('mongodbData')->name('topall')->limit(20,20)->select();
//		dump($data);exit;
		$param = input('param.data');
		$page = $param?$param:1;

		$field = "dsr";
		$order = "desc";

		$goods = Db::connect('mongodb')->name('total')->order($field,$order)->limit(($page-1)*20,20)->select();
		foreach ($goods as $k => $v){
			$goods[$k]['type'] = 'baoyou';
		}
		dump($goods);exit();



	}

	//获取缓存
	public function getCache()
	{
		$param = input('param.id');
		$res = Cache::get("column_jrms_data_".$param);
		dump(json_decode($res,true));
	}


	/***************************************************************************首页接口********************************************************************/

	/**
	 * 首页商品接口
	 * @throws \think\Exception
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function mall()
	{
		$param = input('param.data');
		$media_id = $param['media_id'];
		$sex      = $param['sex'];

		//table分类
		$table_column = $this->column($media_id,$sex);
		array_unshift($table_column,['column_id'=>0,'column_title'=>'精选']);

		//icon
		$icon = $this->icon();
		//获取今日秒杀
		$spike = $this->spike($media_id,$sex);
		//专场的商品列表
		$column = $this->list($media_id,$sex);
		//广告
		$banner = $this->banner($media_id,$sex);

		$mall = [
			'table'  => 	$table_column,
			'banner' =>     $banner,
			'icon'   => 	$icon,
			'spike'  => 	$spike,
			'column' => 	$column,
		];
		$this->response = [
			'code' => 'success',
			'msg'  => '',
			'response' => $mall
		];
//		dump($mall);exit();
		return $this->response;
	}

	/**
	 *  table分类列表
	 * @param $media_id 媒体id
	 * @return mixed
	 */
	public function column($media_id,$sex=2)
	{
		$a = 1;
		if ($sex == 1){
			$a = 2;
		}
		$column = db("column")->field("column_id,column_title")
					->where("column_media_id",['=',0],['=',$media_id],'or')
					->where("column_status","<>",-1)
					->where("column_sex","<>",$a)
					->where("column_type","=",0)
				    ->order("column_media_id desc,column_sort asc")->select();
		return $column;
	}

	/**
	 * icon 列表
	 * @return mixed
	 */
	public function icon()
	{
		$icon = db("icon")->where("icon_status","<>",-1)->order("icon_sort asc")->select();
		return $icon;
	}

	/**
	 * 专场分类
	 * @param $media_id 媒体id
	 * @param $sex  性别
	 * @return mixed
	 */
	public function list($media_id,$sex=2)
	{
		$column = db("column")->field("column_id,column_title,column_image")
					->where("column_media_id","=",$media_id)
					->where("column_status","<>",-1)
					->where("column_sex","=",$sex)
					->where("column_type","=",0)
					->order("column_sort asc")
					->select();
		foreach ($column as $key => $value){
			$column[$key]['goods'] = $this->listGoods($value['column_id'],1,3);
		}
		return $column;
	}

	/**
	 * 今日秒杀活动
	 * @param $media_id  媒体id
	 * @param $sex  性别
	 * @return mixed
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function spike($media_id,$sex)
	{
		$spike = db("column")
					->where("column_media_id","=",$media_id)
					->where("column_status","<>",-1)->where("column_sex","=",$sex)
					->where("column_type","=",1)
					->field("column_id,column_thumb,column_create_time")
					->find();
		$result =[
			'time'  => '',
			'start' => '',
			'end'   => '',
			'goods' => [],
		];
		if (!empty($spike)){
			$goods = $this->listGoods($spike['column_id']);
			//循环时间
			$data = Cache::get("column_jrms_data_".$spike['column_id']);
			//json转码
			$result = json_decode($data,true);
			if (!is_array($result)){
				//计算时间存缓存
				//缓存配置数据
				$dtime = explode(':',$spike['column_thumb']);
				$result['time']  = intval($dtime[0])*3600 + intval($dtime[1])*60 + intval($dtime[2]);
				$result['start'] = time();
				$result['end']   = time()+ $result['time'];
				Cache::set("column_jrms_data_".$spike['column_id'],json_encode($result,true));
			}else{
				if ($result['end'] < time()){
					$result['start'] = time();
					$result['end']   = time()+ $result['time'];
					Cache::set("column_jrms_data_".$spike['column_id'],json_encode($result,true));
				}else{
					$result['start'] = time();
				}
			}
			//商品展示
			$arr = [];
			foreach ($goods as $key => $value){
				if ($key%3 == 0){
					$arr[$key][] = $goods[$key];
					if ($key+1 <= count($goods) && isset($goods[$key+1])){
						$arr[$key][] = $goods[$key+1];
					}
					if ($key+2 <= count($goods) && isset($goods[$key+2])){
						$arr[$key][] = $goods[$key+2];
					}
				}
			}
			$result['goods'] = array_values($arr);
		}
		return $result;
	}

	/**
	 * 分类商品列表
	 * @param array $column 栏目id
	 * @param int $page 页码
	 * @param int $limit 步长
	 * @return array
	 */
	public function listGoods($column,$page=1,$limit=20)
	{
		$goods_arr = db("bind_column_goods")->alias("b")
					 ->leftJoin("goods g","b.bind_goods_id = g.goods_id")
					 ->where("bind_column_id","=",$column)
					 ->where("bind_status","<>",-1)
					 ->order("b.bind_sort asc")
					 ->page($page,$limit)->select();
		foreach ($goods_arr as $k => $v){
			$goods_arr[$k]['type'] = 'goods';
		}
		return $goods_arr;
	}

	/**
	 * 广告列表
	 * @return mixed
	 */
	public function banner($media_id,$sex=2)
	{
		if ($sex == 1){
			$where[] = ["banner_sex","<>",2];
		}else{
			$where[] = ["banner_sex","<>",1];
		}
		$where[] = ["banner_status","<>",-1];
		$where[] = ["banner_media_id","=",$media_id];
		$banner = db("banner")->where($where)->order("banner_sort")->select();
		return $banner;
	}

	/**
	 * 精选1000列表
	 * @return array
	 * @throws \think\Exception
	 */
	public function top()
	{
		$param = input('param.data');
		$page = $param['page']?$param['page']:1;
		$goods = Db::connect('mongodb')->name('total')->limit(($page-1)*20,20)->select();
		foreach ($goods as $k => $v){
			$goods[$k]['type'] = 'baoyou';
		}
		$arr = [];
		//判断是否第一页  后台可上传添加商品
		if ($page <= 1){
			$where[] = ["top_status","<>",-1];
			$where[] = ["top_is_show","=",1];
			$where[] = ["top_sex","=",$param['sex']];
			$list = db("top_bind_goods")->where($where)->limit(3)->select();
			if (!empty($list)){
				foreach ($list as $key => $value){
					$arr[$key] = db("goods")->where("goods_id","=",$value['top_goodsid'])->find();
					if (empty($arr[$key])){
						unset($arr[$key]);
					}else{
						$arr[$key]['type'] = 'goods';
					}
				}
				$new_goods = array_merge(array_values($arr),$goods);
			}else{
				$new_goods = $goods;
			}
			$this->response['response'] = $new_goods;
		}else{
			$this->response['response'] = $goods;
		}
//		dump($this->response);exit();
		return $this->response ;
	}



	public function getData()
	{
		$param = input('param.data');
		$data = $this->spike($param['media_id'],$param['sex']);
		dump($data);exit();
	}

}
