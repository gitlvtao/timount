<?php
/**
 * Created by PhpStorm.
 * User: fukunari<fukunari@163.com>
 * Date: 2018-10-08
 */

namespace app\http\middleware;


use fuk\DataCrypt;

class EncryptResponseData {
    public function handle($request, \Closure $next) {
        $response = $next($request);

        // 加密数据
        $returnRestult = DataCrypt::encrypt($response->getData(), config('app.crypt.key'), config('app.crypt.iv'));
		$data = ['code' => 200, 'response' => $returnRestult];
		$response->data(json_encode($data));

        // 执行动作
        return $response;
    }
}