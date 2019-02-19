<?php
/**
 * 自定义配置.
 * User: fukunari<fukunari@163.com>
 * Date: 2018-10-11
 */

return [
    'admin_auth' => [
        // 不需要验证权限的规则
        'not_check_rule' => [
            'admin/index/index',
            'admin/index/console',
        ],
    ],
];