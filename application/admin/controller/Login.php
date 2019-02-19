<?php
/**
 * 后台登录.
 * User: fukunari<fukunari@163.com>
 * Date: 2018-10-09
 */

namespace app\admin\controller;


use think\captcha\Captcha;
use think\Controller;

class Login extends Controller {
    /**
     * 登录
     * @return array|\think\response\View
     */
    public function index() {
        if(session('?admin_user')) {
            $this->redirect(url('admin/index/index'));
        }

        if (request()->isAjax()) {
            $param = request()->only(['username', 'password', 'vercode']);

            if (!captcha_check($param['vercode'])) {
                return [
                    'code' => -1,
                    'msg' => '验证码错误',
                ];
            }

            // 开始登陆
            $user = db('admin_user')->where(['user_username' => $param['username'], 'user_status' => [0, 1]])
                    ->field(['user_id', 'user_username', 'user_password', 'user_nickname', 'user_group', 'user_status'])->find();
            if ($user) {
                if ($user['user_password'] != md5($param['password'])) {
                    return [
                        'code' => -1,
                        'msg' => '密码错误',
                    ];
                } elseif($user['user_status'] != 1) {
                    return [
                        'code' => -1,
                        'msg' => '用户被冻结',
                    ];
                } else {
                    // 密码不需要保存到session
                    unset($user['user_password']);
                    // 保存到session
                    session('admin_user', json_encode($user));

                    // 更新一下数据
                    $updataData = [
                        'user_login_ip' => request()->ip(),
                        'user_login_time' => time(),
                    ];
                    db('admin_user')->where(['user_id' => $user['user_id']])->update($updataData);

                    return [
                        'code' => 0
                    ];
                }
            } else {
                return [
                    'code' => -1,
                    'msg' => '用户不存在',
                ];
            }
        } else {
            return view();
        }
    }

    /**
     * 生成验证码
     * @return mixed
     */
    public function vercode() {
        $config =    [
            // 验证码位数
            'length'      =>    4,
            // 关闭验证码杂点
            'useCurve'    =>    false,
        ];
        $captcha = new Captcha($config);
        return $captcha->entry();
    }

    /**
     * 退出登录
     */
    public function logout() {
        session('admin_user', null);
        $this->redirect('admin/login/index');
    }
}