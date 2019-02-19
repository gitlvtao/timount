<?php
/**
 * 权限管理.
 * User: fukunari<fukunari@163.com>
 * Date: 2018-10-09
 */

namespace app\admin\controller;

use app\common\model\AdminAuth as  FukAdminAuth;

class Adminauth extends Base {
    /**
     * 权限列表
     * @return array|\think\response\View
     */
    public function index() {
        if (request()->isAjax()) {
            $data = [];
            $menu = db('admin_auth')->order('auth_sort')->select();
            foreach ($menu as $key => $item) {
                $data[] = [
                    'icon' => $item['auth_icon'],
                    'id' => $item['auth_id'],
                    'pid' => $item['auth_pid'] ? : -1,
                    'name' => $item['auth_name'],
                    'url' => $item['auth_url'],
                    'status' => $item['auth_status'],
                    'auth_menu_status' => $item['auth_menu_status'],
                    'orderIndex' => $item['auth_sort'],
                    'project' => null,
                ];
            }
            $this->response['count'] = db('admin_auth')->count();
            $this->response['data'] = $data;

            return $this->response;
        } else {
            return view('index');
        }
    }

    /**
     * 权限添加、更新
     * @return array|\think\response\View
     */
    public function addUpdate() {
        $param = input('param.');
        $auth = new FukAdminAuth();
        if (request()->isAjax()) {
            $upwhere = [];
            $data = [
                'auth_name' => $param['name'],
                'auth_url' => $param['url'],
                'auth_pid' => $param['pid'],
                'auth_menu_status' => $param['type'],
                'auth_icon' => $param['icon'],
                'auth_sort' => $param['orderIndex'],
            ];
            if ($param['id']) {
                $upwhere = ['auth_id' => $param['id']];
            }
            $auth->save($data, $upwhere);
            return $this->response;
        } else {
            $info = [];
            $father = $auth->where('auth_pid', 0)->field(['auth_id', 'auth_name'])->select();
            if (isset($param['aid'])) {
                $info = FukAdminAuth::get($param['aid']);
            }
            return view('addupdate', [
                'info' => $info,
                'father' => $father,
            ]);
        }
    }

    /**
     * 修改权限状态
     * @return array
     */
    public function status() {
        if (request()->isAjax()) {
            $param = request()->only(['aid', 'status', 'type']);
            if ($param['status'] == -1) {
                db('admin_auth')->where(['auth_id' => $param['aid']])->delete();
            } else {
                $updateData = [];
                switch ($param['type']) {
                    case 'menu':
                        $updateData['auth_menu_status'] = $param['status'];
                        break;
                    case 'auth':
                        $updateData['auth_status'] = $param['status'];
                        break;
                    default: break;
                }
                db('admin_auth')->where(['auth_id' => $param['aid']])->update($updateData);
            }
            return $this->response;
        }

    }

    /**
     * 获取用户组菜单权限
     * @return array
     */
    public function auth() {
        if (request()->isAjax()) {
            $parem = request()->only('auth');
            $authArr = [];
            if (isset($parem['auth'])) {
                $authArr = explode(',', $parem['auth']);
            }

            $auth = db('admin_auth')->where(['auth_status' => 1])->order('auth_pid')->select();
            $data = [];
            foreach ($auth as $key => $item) {
                $data[$key] = [
                    'id' => (string)$item['auth_id'],
                    'parent' => $item['auth_pid'] ? (string)$item['auth_pid'] : '#',
                    'text' => $item['auth_name'],
                    'icon' => 'fa fa-folder',
                    'li_attr' => [],
                    'a_attr' => [],
                    'state' => [
                        'opened' => true,
                    ],
                ];
                if (in_array($item['auth_id'], $authArr) && $item['auth_pid'] != 0) {
                    $data[$key]['state']['selected'] = true;
                }
            }
            return $data;
        }
    }

    /**
     * 设置排序
     * @return array
     */
    public function sort() {
        if (request()->isAjax()) {
            $param = request()->only(['aid', 'sort']);
            db('admin_auth')->where(['auth_id' => $param['aid']])->update(['auth_sort' => $param['sort']]);
            return $this->response;
        }
    }
}