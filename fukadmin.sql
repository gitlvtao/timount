# Host: 127.0.0.1  (Version 5.5.53)
# Date: 2018-10-10 15:42:40
# Generator: MySQL-Front 6.0  (Build 3.3)


#
# Structure for table "mall_admin_auth"
#

DROP TABLE IF EXISTS `mall_admin_auth`;
CREATE TABLE `mall_admin_auth` (
  `auth_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '权限id',
  `auth_pid` int(11) DEFAULT '0' COMMENT '上级权限id',
  `auth_name` varchar(20) NOT NULL DEFAULT '' COMMENT '权限名称',
  `auth_url` varchar(255) DEFAULT NULL COMMENT '权限地址',
  `auth_icon` varchar(50) DEFAULT NULL COMMENT '权限图标',
  `auth_sort` smallint(2) DEFAULT '99' COMMENT '排序',
  `auth_menu_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '菜单状态 1 显示 0 隐藏',
  `auth_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '权限状态 1 整除 0 禁用',
  `auth_create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`auth_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理权限节点表';

#
# Data for table "mall_admin_auth"
#

/*!40000 ALTER TABLE `mall_admin_auth` DISABLE KEYS */;
INSERT INTO `mall_admin_auth` VALUES (1,0,'权限管理','','layui-icon-template-1',99,1,1,0),(2,1,'管理员列表','admin/adminuser/index','',99,1,1,0),(3,1,'用户组列表','admin/adminrole/index','',99,1,1,0),(4,1,'权限列表','admin/adminauth/index','',99,0,1,0);
/*!40000 ALTER TABLE `mall_admin_auth` ENABLE KEYS */;

#
# Structure for table "mall_admin_role"
#

DROP TABLE IF EXISTS `mall_admin_role`;
CREATE TABLE `mall_admin_role` (
  `role_id` tinyint(3) NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `role_name` varchar(20) DEFAULT NULL COMMENT '角色名称',
  `role_describe` varchar(255) DEFAULT NULL COMMENT '角色描述',
  `role_auth` varchar(255) DEFAULT NULL COMMENT '权限列表',
  `role_create_time` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='管理员角色表';

#
# Data for table "mall_admin_role"
#

/*!40000 ALTER TABLE `mall_admin_role` DISABLE KEYS */;
INSERT INTO `mall_admin_role` VALUES (1,'超级管理员','超级管理员',NULL,1539072772);
/*!40000 ALTER TABLE `mall_admin_role` ENABLE KEYS */;

#
# Structure for table "mall_admin_user"
#

DROP TABLE IF EXISTS `mall_admin_user`;
CREATE TABLE `mall_admin_user` (
  `user_id` mediumint(8) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `user_username` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `user_password` varchar(50) NOT NULL DEFAULT '' COMMENT '用户密码',
  `user_nickname` varchar(20) DEFAULT '' COMMENT '用户昵称',
  `user_group` varchar(20) DEFAULT NULL COMMENT '用户分组',
  `user_create_time` int(10) NOT NULL DEFAULT '0' COMMENT '注册时间',
  `user_login_ip` varchar(20) DEFAULT NULL COMMENT '最后一次登录ip',
  `user_login_time` int(10) DEFAULT NULL COMMENT '最后一次登录时间',
  `user_status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '用户状态',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='管理员表';

#
# Data for table "mall_admin_user"
#

/*!40000 ALTER TABLE `mall_admin_user` DISABLE KEYS */;
INSERT INTO `mall_admin_user` VALUES (1,'admin','e10adc3949ba59abbe56e057f20f883e','天芒云','1',1539070264,'192.168.1.123',1539151060,1);
/*!40000 ALTER TABLE `mall_admin_user` ENABLE KEYS */;
