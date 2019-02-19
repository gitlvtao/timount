<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * 发送get和post的请求方式
 * @param $url
 * @param string $method
 * @param null $data
 * @param bool $https
 * @return mixed
 */
function curlRequest($url, $method = 'get', $data=null, $https=true){
	//1.初识化curl
	$ch = curl_init($url);
	//2.根据实际请求需求进行参数封装
	//返回数据不直接输出
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	//如果是https请求
	if($https === true){
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.1 Safari/537.11');
	}
	//如果是post请求
	if($method === 'post'){
		//开启发送post请求选项
		curl_setopt($ch,CURLOPT_POST,true);
		//发送post的数据
		curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
	}
	//3.发送请求
	$result = curl_exec($ch);
	//4.返回返回值，关闭连接
	curl_close($ch);
	return $result;
}