<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

Route::post('en', 'index/index/en');
Route::post('de', 'index/index/de');

Route::post('test', 'index/index/getData');


Route::group('api',[
	'index' => 'index/index/mall', //首页
	'tops'   => 'index/index/top', //精选分类
	'column' => 'media/columnapi/index', // 下拉分类

	'hotworld'   => 'hotword/Hotapi/hotList',     //热搜词列表
	'screenList' => 'hotword/Hotapi/hotGoods',     //搜索结果列表

	'columnList' => 'goods/Goodsapi/goodsList',   //分类商品列表
	'icon'       => 'goods/Goodsapi/icon' ,    //icon商品列表

	'brandList'  => 'goods/Goodsapi/brand' ,    //品牌馆分类列表
	'brandGoods' => 'brand/Brandapi/goodsList',  //品牌分类商品列表

	'goodsInfo'  => 'goods/Goodsapi/goodsInfo',   //商品详情

	'getUser'    => "reward/rewardapi/getUser",   //生成用户标识
	'rewardInfo' => "reward/rewardapi/index",    //活动详情
	'activity'   => 'reward/rewardapi/getReward',  //砸蛋活动
	'listReward' => 'reward/rewardapi/rewardList',  //用户优惠券列表

])->middleware('aes');

return [

];