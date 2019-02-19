<?php
/**
 * Created by PhpStorm.
 * User: fukunari<fukunari@163.com>
 * Date: 2018-08-31
 */

namespace app\other\controller;


use app\admin\controller\Base;
use fuk\Qiniu;

class Upload extends Base {

    public function image() {
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');
        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->validate(['size'=>10485760])->move('uploads');
        if($info){
            $qiniu = new Qiniu();
            $path = $qiniu->upload(config('tmy.upload_path').$info->getSaveName(), date('Ymd').'_'.$info->getFilename());
            // 成功上传后 获取上传信息
            if ($path) {
                $this->response['data'] = $path;
            } else {
                $this->response['data'] = request()->domain().'/uploads/'.$info->getSaveName();
            }
        }else{
            $this->response['code'] = -1;
            $this->response['msg'] = $file->getError();
        }
        return $this->response;
    }

}