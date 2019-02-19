<?php
/**
 * Created by PhpStorm.
 * User: fukunari<fukunari@163.com>
 * Date: 2018-10-08
 */

namespace app\http\middleware;


use app\common\model\Media;
use fuk\DataCrypt;
use think\facade\Cache;

class VerifyMedia {
    public function handle($request, \Closure $next) {
        $data = $request->param('data', '');

        // 判断是否有数据
        if(!$data || empty($data) || !isset($data)) {
            return  $this->returnResponse(['code' => 47000, 'msg' => '非法访问']);
        }

        // 媒体标识是否为空
        if(!key_exists('ident', $data) || !key_exists('ident', $data)) {
            return $this->returnResponse(['code' => 47004, 'msg' => '媒体标识缺失']);
        }

        // 判断媒体是否存在
        $queryWhere = [
            'media_status' => 1,
            'media_ident' => $data['ident'],
        ];
        $mediaData = Cache::remember('media_'.$data['ident'], function() use ($queryWhere) {
            $media = new Media();
            return $media->where($queryWhere)->find();
        }, 1440);
        if (!$mediaData || empty($mediaData)) {
            return $this->returnResponse(['code' => 47005, 'msg' => '没有找到媒体']);
        }

        // 处理密钥
        unset($data['ident']);
        $data['media_id'] = $mediaData->media_id;

        // 数据重构
        $request->data = $data;
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