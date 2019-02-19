<?php
/**
 * 解密Api数据.
 * User: fukunari<fukunari@163.com>
 * Date: 2018-10-08
 */

namespace app\http\middleware;


use fuk\DataCrypt;

class DecryptRequestData {
    /**
     * @param $request
     * @param \Closure $next
     * @return mixed|\think\Response
     */
    public function handle($request, \Closure $next) {
        $data = $request->param('data', '');

        // 判断是否有数据
        if(!$data || empty($data) || !isset($data)) {
            return $this->returnResponse(['code' => 47000, 'msg' => '非法访问']);
        }

        // 解密
        $requestData = DataCrypt::decrypt($data, config('app.crypt.key'), config('app.crypt.iv'));

        if(!$requestData || empty($requestData) || !isset($requestData)) {
            return $this->returnResponse(['code' => 47001, 'msg' => '解密失败']);
        }

        // 解密后还原数据
        $requestData = json_decode($requestData, true);
        if (!is_array($requestData) || empty($requestData)) {
            return $this->returnResponse(['code' => 47002, 'msg' => '数据异常']);
        }

        // 判断密钥是否存在
        if(!key_exists('sign', $requestData)) {
            return $this->returnResponse(['code' => 47003, 'msg' => 'sign缺失']);
        }
        if(!$requestData['sign'] || empty($requestData['sign']) || !isset($requestData['sign'])) {
            return $this->returnResponse(['code' => 47003, 'msg' => 'singn缺失']);
        }

        // 处理密钥
        $sign = $requestData['sign'];
        unset($requestData['sign']);

        // 服务端生成密钥
        $httpUrlString = http_build_query($requestData,'','&',PHP_QUERY_RFC3986);

        // 如果没有参数只需要对sign加密
        $httpUrlString = $httpUrlString ? $httpUrlString . '&' : '';

        $requestSign = md5($httpUrlString . "openId=".config("app.crypt.opendId"));

        // 对比密钥
        if($requestSign != $sign) {
            return $this->returnResponse(['code' => 47004, 'msg' => 'sign错误']);
        }

        // 数据重构
        $request->data = $requestData;
        return $next($request);
    }


    /**
     * @param $data
     * @return \think\response\Json
     */
    public function returnResponse($data) {
        // 加密数据
        $returnRestult = DataCrypt::encrypt($data, config('app.crypt.key'), config('app.crypt.iv'));

        return json(['code' => 200, 'response' => $returnRestult]);
    }
}