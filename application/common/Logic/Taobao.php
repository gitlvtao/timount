<?php
/**
 * Created by PhpStorm.
 * User: fukunari<fukunari@163.com>
 * Date: 2018-12-25
 */

namespace app\common\Logic;


use think\Db;

class Taobao {
    /**
     * 获取卖家基本信息
     * @param string $seller
     * @return array
     */
    public function seller($sellerid = 0, $taobaoid = 0) {
        $seller = [];
        try {
            // 首先查询数据库中是否有卖家的信息
			$result = Db::connect('mongodb')->name('seller')->where('userId', $sellerid)->find();
            if (is_null($result)) {
                $requestData = [
                    'jsv' => '2.5.0',
                    'appKey' => '12574478',
                    't' => time() + 1000,
                    'api' => 'mtop.taobao.detail.getdetail',
                    'v' => '6.0',
                    'dataType' => 'json',
                    'data' => '{"itemNumId":"'.$taobaoid.'"}',
                ];
                $requestUrl = 'https://h5api.m.taobao.com/h5/mtop.taobao.detail.getdetail/6.0/?'.http_build_query($requestData);
                $responseData = curlRequest($requestUrl);
                $responseData = json_decode($responseData, true);
                if (isset($responseData['data']['seller'])) {
                    $sellerInfo = $responseData['data']['seller'];
                    $saveData = [
                        'userId' => $sellerInfo['userId'],
                        'shopId' => $sellerInfo['shopId'],
                        'shopName' => $sellerInfo['shopName'],
                        'shopUrl' => $sellerInfo['shopUrl'],
                        'shopIcon' => $sellerInfo['shopIcon'],
                        'evaluates' => $sellerInfo['evaluates'],
                    ];
                    Db::connect('mongodb')->name('seller')->insert($saveData);
                    $seller = $saveData;
                }
            } else {
                $seller = $result;
            }
        } catch (\Exception $e) {
            dump($e->getMessage());
        }
        return $seller;
    }

}