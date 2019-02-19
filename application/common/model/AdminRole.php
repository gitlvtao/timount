<?php
/**
 * Created by PhpStorm.
 * User: fukunari<fukunari@163.com>
 * Date: 2018-10-09
 */

namespace app\common\model;


use think\Model;

class AdminRole extends Model {

    /**
     * 获取角色列表
     * @param int $type 是否返回原始数据
     * @return array|\PDOStatement|string|\think\Collection
     */
    public function getRole($type = 1) {
        $role = $this->field(['role_id', 'role_name'])->select();

        // 获取原始数据直接返回
        if ($type) {
            return $role;
        }

        // 整理一下
        $roleData = [];
        foreach ($role as $roleKey => $roleItem) {
            $roleData[$roleItem['role_id']] = $roleItem['role_name'];
        }
        return $roleData;
    }
}