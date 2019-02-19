<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/1/15
 * Time: 14:44
 */

namespace app\wechart\controller;


use think\Controller;
use think\Db;

class Wechart extends Controller
{
	private $appid = 'wxf4b3dc820bc1517a ';                 //微信公众号APPID
	private $appsecret = 'e68cf8a7ea000555f7703fd0e2f6d8fb';             //密匙
	private $url = 'http://admin.mall.bangwoya.com/wechart/Wechart/login';       //微信回调地址 (登录)自己设置

	//微信访问跳转
	public function index()
	{
		//换成自己的接口信息
		$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $this->appid . '&redirect_uri=' . urlencode($this->url) . '&response_type=code&scope=snsapi_userinfo&state=state#wechat_redirect';

		header('location:' . $url);
	}


	/**
	 * 获取授权token 用户openid
	 * @param $code
	 * @return bool|string
	 */
	private function getUserAccessToken($code)
	{
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$this->appid&secret=$this->appsecret&code=$code&grant_type=authorization_code";

//		$res = file_get_contents($url);
		$res = $this->curlGet($url);
		dump($res);exit();



		return json_decode($res);
	}

	/**
	 * 获取用户信息
	 * @param $accessToken
	 * @return mixed
	 */
	private function getUserInfo($accessToken)
	{
		$url = "https://api.weixin.qq.com/sns/userinfo?access_token=$accessToken->access_token&openid=$accessToken->openid&lang=zh_CN";
		$UserInfo = file_get_contents($url);
		return json_decode($UserInfo, true);
	}


	public function login()
	{
//		$code = $_GET['code'];

		$code = "023UHbkG12fqV803GPjG1kEokG1UHbkB";

		$access_token = $this->getUserAccessToken($code);  //获取网页授权access_token 返回参数 包含标识用户的openid
		$UserInfo = $this->getUserInfo($access_token);

		dump($UserInfo);exit();

	}



	public function curlGet($url)
	{
		$curl = curl_init();
		//设置抓取的url
		curl_setopt($curl, CURLOPT_URL, $url);
		//设置头文件的信息作为数据流输出
		 curl_setopt($curl, CURLOPT_HEADER, 1);
		//设置获取的信息以文件流的形式返回，而不是直接输出。
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		//执行命令
		 $data = curl_exec($curl);
		 //关闭URL请求
		 curl_close($curl);
		//显示获得的数据
		return $data;
	}


	public function getOpenid()
	{
		$url = "https://api.weixin.qq.com/sns/jscode2session?appid=APPID&secret=SECRET&js_code=JSCODE&grant_type=authorization_code";
	}


	/****************************************************************接口*****************************************************************/

	public function Add()
	{
		$param = input("param.");
		$callback = isset($_GET['callback']) ? trim($_GET['callback']) : ''; //jsonp回调参数，必需
		if (empty($param)){
			$reg = $callback . '(' . json_encode(['code'=>-1,'msg'=>"参数缺失!"]) .')';
			return $reg;exit();
		}
		$user = Db::connect("mongodbData")->name("user")->where("openid","=",$param['openid'])->find();
		if ($user){
			$reg = $callback . '(' . json_encode(['code'=>-1,'msg'=>"重复登录!"]) .')';
			return $reg;exit();
		}
		$res = Db::connect("mongodbData")->name("user")->insert($param);
		if ($res){
			$reg = $callback . '(' . json_encode(['code'=>1,"msg"=>'ok']) .')';
			return $reg;exit();
		}else{
			$reg = $callback . '(' . json_encode(['code'=>-1,"msg"=>'error']) .')';
			return $reg;exit();
		}
	}

	public function list()
	{
		$list = Db::connect("mongodbData")->name("user")->select();
		$callback = isset($_GET['callback']) ? trim($_GET['callback']) : ''; //jsonp回调参数，必需
		$reg = $callback . '(' . json_encode(['code'=>1,"msg"=>'ok','data'=>$list]) .')';
		return $reg;exit();
	}


	public function sendData()
	{
		$param = input('param.');
		/*$param = [
			'openid' => '',
			'data'   => '',
			'headerpic' => ''
		];*/
		$res = Db::connect("mongodbData")->name("userData")->insert($param);
		if ($res){
			return json_encode(['code'=>1,'msg'=>'ok']);exit();
		}else{
			return json_encode(['code'=>-1,'msg'=>'error']);exit();
		}

	}


	public function getData()
	{

	}


	/*public function addlist()
	{
		$arr = [];
		for ($i=0;$i<50;$i++){
			$arr[$i] = [
				'openid' => "oyHA65CJcBfV4TGQvAq0jqUr_F_k",
				'username' => "追风筝的人".($i+1),
				'headerpic' => "https://wx.qlogo.cn/mmopen/vi_32/6vmbmqfProicrkf0RDMTozmVWm9yw6dua5HMUicKofJVbQwJ3Dptz0Y0OlFm4taujlen9ib1hicx1SsGnvTMNJJ8zA/132",
				'permission' => "0",
			];
		}

		$res = Db::connect("mongodbData")->name("user")->insertAll($arr);

		dump($res);exit();

	}*/

}