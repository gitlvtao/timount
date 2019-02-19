<?php
/**
 * Created by PhpStorm.
 * User: fukunari<fukunari@163.com>
 * Date: 2018-10-09
 */

namespace app\admin\controller;

use think\Controller;

class Base extends Controller {
    // 后台json返回统一格式
    public $response = [
        'code' => 0,
        'count' => 0,
        'data' => '',
        'msg' => ''
    ];

    public function initialize() {
        if(session('?admin_user')) {
            // 验证权限 TODO 还需要优化
            /*if (!$this->checkAuth()) {
                $this->error('没有权限', url('admin/index/index'));
            }*/
        } else {
            $this->redirect(url('admin/login/index'));
        }
    }

    /**
     * 获取管理员权限列表
     * @param $user
     * @return array
     */
    public function getRole($user) {
        $role = explode(',', $user['user_group']);
        // 管理员不需要验证
        if (in_array(1, $role)) {
            return false;
        } else {
            $auth = db('admin_role')->where(['role_id' => $role])->field('role_auth')->select();
            $roleAuth = [];
            foreach ($auth as $key => $item) {
                $roleArr = explode(',', $item['role_auth']);
                foreach ($roleArr as $roleItem) {
                    $roleAuth[] = $roleItem;
                }
            }
            return array_unique($roleAuth);
        }
    }

    /**
     * 获取菜单
     * @param $auth
     * @return array
     */
    public function getMenu($auth){
        $queryWhere = [];
        // 超级管理员无视一切规则
        if ($auth) {
            $queryWhere['auth_id'] = $auth;
            $queryWhere['auth_menu_status'] = 1; // 如果不是管理员就需要处理一下菜单显示的问题
        }

        $auth = db('admin_auth')->where($queryWhere)->order('auth_sort')->select();
        $authData = [];
        foreach ($auth as $key => $item) {
            if ($item['auth_pid'] == 0) {
                $authData[$item['auth_id']] = $item;
                foreach ($auth as $sonKey => $sonItem) {
                    if ($sonItem['auth_pid'] == $item['auth_id']) {
                        $authData[$item['auth_id']]['child'][] = $sonItem;
                    }
                }
            }
        }
        return $authData;
    }

    /**
     * 检查用户的权限
     * @return bool
     */
    public function checkAuth() {
        // 获取登录
        $user = json_decode(session('admin_user'), true);
        $auth = \think\facade\Cache::remember('auth_user_'.$user['user_id'], function() use ($user) {
            $role = $this->getRole($user);

            if ($role === false) return false;

            $queryWhere = [
                ['auth_id', 'in', $role],
                ['auth_status', '=', 1],
            ];
            $auth = db('admin_auth')->where($queryWhere)->column('auth_url');
            return $auth;
        });
        if ($auth == false) {
            return true;
        } else {
            $nowurl = strtolower(request()->module() . '/' . request()->controller() . '/' . request()->action());

            // 如果是控制台都可以看的
            if (in_array($nowurl, config('app.admin_auth.not_check_rule'))) {
                return true;
            }
            return in_array($nowurl, $auth);
        }
    }
}