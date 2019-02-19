<?php
/**
 * 用户组管理.
 * User: fukunari<fukunari@163.com>
 * Date: 2018-10-10
 */

namespace app\admin\controller;

use app\common\model\AdminRole as FukAdminRole;

class Adminrole extends Base {
    public function index() {
        if (request()->isAjax()) {
            $param = input('param.');
            $queryWhere = [];
            if(isset($param['name']) && !empty($param['name'])) {
                $queryWhere[] = ['role_name', 'like', '%'.$param['name'].'%'];
            }
            $this->response['count'] = db('admin_role')->where($queryWhere)->count();
            $data = db('admin_role')->where($queryWhere)->page($param['page'])->limit($param['limit'])->order('role_id', 'desc')->select();
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
            if (strpos($param['funIds'], '_')) {
                $funIds = explode('_', $param['funIds']);
                $funIds = $funIds[0];
            } else {
                $funIds = $param['funIds'];
            }

            $saveData = $saveWhere = [];
            // 编辑、删除都可以修改的数据
            $role = new FukAdminRole;
            $saveData = [
                'role_name' => $param['name'],
                'role_describe' => $param['description'],
                'role_auth' => $funIds,
            ];

            // 如果是添加就要单独处理了
            if (isset($param['rid']) && !empty($param['rid'])) {
                $saveWhere['role_id'] = $param['rid'];
            } else {
                $saveData['role_create_time'] = time();
            }

            $result = $role->allowField(true)->save($saveData, $saveWhere);

            if (!$result) {
                $this->response['code'] = -1;
                $this->response['msg'] = '操作失败';
            }

            return $this->response;
        } else {
            $info = [];
            if (isset($param['rid'])) {
                $info = db('admin_role')->where(['role_id' => $param['rid']])->find();
            }

            return view('', [
                'info' => $info
            ]);
        }
    }

    /**
     * 删除用户组
     * @return array
     */
    public function delete() {
        if (request()->isAjax()) {
            $param = request()->only('rid');
            db('admin_role')->where(['role_id' => $param['rid']])->delete();
            return $this->response;
        }
    }
}