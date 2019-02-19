<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/12/20
 * Time: 10:21
 */

return [
	'upload_path' => env('root_path') . 'public/uploads/',

	// 七牛云配置
	'qiniu' => [
		// 七牛云配置
		'accesskey' => '1QCjVsSW3unUCzzGBTCCDXMqpBxTyIuVnBVDMLiE', // 你的accessKey
		'secretkey' => 'IbYQo_n9P_3wx2gGOxJ7ilr5JZRjS9t3a6vZ9RZ7', // 你的secretKey
		'bucket' => 'mall', //上传的空间
		'domain' => 'http://static.mall.bangwoya.com/', // 空间绑定的域名
	],

	// 淘宝客
	'taobaoke' => [
		'appkey' => '24560437',
		'secretKey' => '24a2f2219b96189c552486180e58eacf',
		'userId' => '13553468',
	],

];