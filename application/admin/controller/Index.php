<?php
/**
 * Created by PhpStorm.
 * User: fukunari<fukunari@163.com>
 * Date: 2018-10-10
 */

namespace app\admin\controller;


class Index extends Base {
    public function index() {
        // 生成菜单
        $user = json_decode(session('admin_user'), true);
        $menu = $this->getMenu($this->getRole($user));
        return view('', [
            'menu' => $menu,
            'user' => $user,
        ]);
    }

    public function console() {
        return '控制台';
    }
}