<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/1/7
 * Time: 10:23
 */

namespace ali;

use think\facade\Cache;
use ali\top\request\TbkTpwdCreateRequest;
use ali\top\TopClient;


class Tkl
{

	public function getTklPwd($goods,$media_pid,$mediaId)
	{
		// 因为变动太大，直接放入缓存当中，不需要记录下来
		$pwd = Cache::get('mall'.$mediaId.'_tbkpwd_'.$goods['goodsid']);
		if (!$pwd){
			$client = new TopClient();
			$client->appkey = config('tmy.taobaoke.appkey');
			$client->secretKey = config('tmy.taobaoke.secretKey');
			$request = new TbkTpwdCreateRequest();
			$request->setUserId(config('tmy.taobaoke.userId'));
			$request->setText($goods['introduce']);
			$request->setUrl('https://uland.taobao.com/coupon/edetail?activityId='.$goods['quan_id'].'&pid='.$media_pid.'&itemId='.$goods['goodsid']);
			$request->setLogo($goods['pic']);
			$request->setExt("{}");
			$amoy = $client->execute($request);
			$amoy = get_object_vars($amoy->data);
			if (!isset($amoy['model'])){
				$amoy['model'] = '';
			}
			$pwd = $amoy['model'];
			Cache::set('mall'.$mediaId.'_tbkpwd_'.$goods['goodsid'],$pwd,86400);
		}
		return $pwd;
	}

}