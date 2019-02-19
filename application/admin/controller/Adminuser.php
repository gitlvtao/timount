<?php
/**
 * Created by PhpStorm.
 * User: fukunari<fukunari@163.com>
 * Date: 2018-10-09
 */

namespace app\admin\controller;


use app\common\model\AdminRole;
use app\common\model\AdminUser as FukAdminUser;

class Adminuser extends Base {
    /**
     * 管理员列表
     * @return array|\think\response\View
     */
    public function index() {
        if (request()->isAjax()) {
            $param = input('param.');
            $queryWhere[] = ['user_status', '>=', 0];
            if(isset($param['nickname']) && !empty($param['nickname'])) {
                $queryWhere[] = ['user_nickname', 'like', '%'.$param['nickname'].'%'];
            }
            if(isset($param['username']) && !empty($param['username'])) {
                $queryWhere[] = ['user_username', 'like', '%'.$param['username'].'%'];
            }
            if(isset($param['status']) && $param['status'] != '') {
                $queryWhere[] = ['user_status', '=', $param['status']];;
            }
            $this->response['count'] = db('admin_user')->where($queryWhere)->count();
            $data = db('admin_user')->where($queryWhere)->page($param['page'])->limit($param['limit'])->order('user_id', 'desc')->select();

            $admin = json_decode(session('admin_user'), true);
            $adminRole = explode(',', $admin['user_group']);

            // 获取角色
            $role = new AdminRole();
            $roleList = $role->getRole(0);
            foreach ($data as $key => $item) {
                if (strpos($item['user_group'], ',')) {
                    $userGroup = explode(',', $item['user_group']);
                    foreach ($userGroup as $roleItem) {
                        $roleString[] = $roleList[$roleItem];
                    }
                    $item['user_role_string'] = implode(',', $roleString);
                } else {
                    $item['user_role_string'] = $roleList[$item['user_group']];
                }

                // 这里处理一下关于不是超级管理员，不能修改超级管理员密码
                if ($item['user_id'] == 1 && !in_array('1', $adminRole)) {
                    unset($data[$key]);
                    continue;
                }

                $data[$key] = $item;
            }

            $this->response['data'] = $data;
            return $this->response;
        } else {
            return view();
        }
    }

    /**
     * 管理员编辑/添加
     * @return \think\response\View
     */
    public function updateAdd() {
        $param = input('param.');
        if (request()->isAjax()) {
            $saveData = $saveWhere = [];
            // 编辑、删除都可以修改的数据
            $user = new FukAdminUser;
            $saveData = [
                'user_username' => $param['username'],
                'user_nickname' => $param['nickname'],
                'user_group' => $param['roleIds'],
            ];

            // 如果是添加就要单独处理了
            if (isset($param['uid']) && !empty($param['uid'])) {
                $saveWhere['user_id'] = $param['uid'];
            } else {
                $saveData['user_password'] = md5($param['password']);
                $saveData['user_create_time'] = time();
            }

            $result = $user->allowField(true)->save($saveData, $saveWhere);

            if (!$result) {
                $this->response['code'] = -1;
                $this->response['msg'] = '操作失败';
            }

            return $this->response;
        } else {
            $info = [];
            if (isset($param['uid'])) {
                $info = db('admin_user')->where(['user_id' => $param['uid']])->find();
            }

            $role  = new AdminRole();
            $roleList = $role->getRole();
            // 拼接吧
            $roleData = [];
            foreach ($roleList as $key => $item) {
                $roleData[] = '{"role_id":'.$item['role_id'].',"role_name":"'.$item['role_name'].'"}';
            }
            return view('', [
                'info' => $info,
                'role' => '['.implode(',', $roleData).']',
            ]);
        }
    }

    /**
     * 修改管理员状态
     * @return array
     */
    public function status() {
        if (request()->isAjax()) {
            $param = input('param.');
            $data = [];
            switch ($param['type']) {
                case 'reuse': $data['user_status'] = 1; break;
                case 'forbid': $data['user_status'] = 0; break;
                case 'del': $data['user_status'] = -1; break;
                default: break;
            }
            db('admin_user')->where(['user_id' => $param['uid']])->update($data);
            return $this->response;
        }
    }

    /**
     * 修改管理员密码
     * @return array
     */
    public function resetpwd() {
        if (request()->isAjax()) {
            $param = input('param.');
            db('admin_user')->where(['user_id' => $param['uid']])->update(['user_password' => md5($param['newPwd'])]);
            return $this->response;
        }
    }
}