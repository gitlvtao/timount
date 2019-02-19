<?php
/**
 * Created by PhpStorm.
 * User: fukunari<fukunari@163.com>
 * Date: 2018-11-09
 */

namespace fuk;


use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class Qiniu {
    /**
     * 上传图片到七牛云
     * @param $filepath 要上传文件的本地路径
     * @param string $filename 上传到七牛后保存的文件名
     * @return bool|string
     */
    public function upload($filepath, $filename = '')
    {
        // 上传到七牛后保存的文件名
        $key = $filename;

        // 需要填写你的 Access Key 和 Secret Key
        $accessKey = config('tmy.qiniu.accesskey');
        $secretKey = config('tmy.qiniu.secretkey');
        $bucket = config('tmy.qiniu.bucket');

        // 构建鉴权对象
        $auth = new Auth($accessKey, $secretKey);

        // 生成上传 Token
        $token = $auth->uploadToken($bucket);

        // 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new UploadManager();

        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($result, $error) = $uploadMgr->putFile($token, $key, $filepath);
        if ($error !== null) {
            return false;
        } else {
            return config('tmy.qiniu.domain').$result['key'];
        }
    }
}