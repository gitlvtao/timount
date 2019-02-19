/*
Navicat MySQL Data Transfer

Source Server         : 正式
Source Server Version : 50554
Source Host           : 61.183.254.94:3306
Source Database       : mall

Target Server Type    : MYSQL
Target Server Version : 50554
File Encoding         : 65001

Date: 2019-01-11 09:52:15
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for mall_activity
-- ----------------------------
DROP TABLE IF EXISTS `mall_activity`;
CREATE TABLE `mall_activity` (
  `activity_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `activity_title` varchar(255) DEFAULT NULL COMMENT '活动标题',
  `activity_img` varchar(255) DEFAULT '' COMMENT '活动首页图标',
  `activity_banner` varchar(255) DEFAULT '' COMMENT '链接',
  `activity_content` text COMMENT '活动规则说明',
  `activity_chance` float(3,2) DEFAULT NULL COMMENT '中奖概率',
  `activity_status` tinyint(2) DEFAULT '1' COMMENT '活动状态',
  `activity_create_time` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`activity_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mall_activity
-- ----------------------------
INSERT INTO `mall_activity` VALUES ('1', '砸金蛋赢优惠券', 'http://static.mall.bangwoya.com/20181224_d5d934f6b6d2945f088c0632fb1737a3.png', 'http://static.mall.bangwoya.com/20181224_4cd2e60f91089c7a1ccae8f64d8ac711.png', '<p>1、每人每天可砸蛋三次</p><p>2、中奖几率100%，奖品仅限当天使用</p><p><br></p>', '1.00', '1', '1545640752');

-- ----------------------------
-- Table structure for mall_admin_auth
-- ----------------------------
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
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='管理权限节点表';

-- ----------------------------
-- Records of mall_admin_auth
-- ----------------------------
INSERT INTO `mall_admin_auth` VALUES ('1', '0', '权限管理', '', 'layui-icon-template-1', '1', '1', '1', '0');
INSERT INTO `mall_admin_auth` VALUES ('2', '1', '管理员列表', 'admin/adminuser/index', '', '99', '1', '1', '0');
INSERT INTO `mall_admin_auth` VALUES ('3', '1', '用户组列表', 'admin/adminrole/index', '', '99', '1', '1', '0');
INSERT INTO `mall_admin_auth` VALUES ('4', '1', '权限列表', 'admin/adminauth/index', '', '99', '0', '1', '0');
INSERT INTO `mall_admin_auth` VALUES ('5', '6', '媒体管理', 'media/media/index', '', '1', '1', '1', '0');
INSERT INTO `mall_admin_auth` VALUES ('6', '0', '媒体中心', '', 'layui-icon-app', '2', '1', '1', '0');
INSERT INTO `mall_admin_auth` VALUES ('7', '6', '栏目管理', 'media/column/index', '', '2', '1', '1', '0');
INSERT INTO `mall_admin_auth` VALUES ('8', '0', '功能模块管理', '', 'layui-icon-template-1', '3', '1', '1', '0');
INSERT INTO `mall_admin_auth` VALUES ('9', '8', '热搜词管理', 'hotword/hot/index', '', '1', '1', '1', '0');
INSERT INTO `mall_admin_auth` VALUES ('10', '8', '广告管理', 'banner/banner/index', '', '2', '1', '1', '0');
INSERT INTO `mall_admin_auth` VALUES ('11', '0', '商品管理', '', 'layui-icon-form', '4', '1', '1', '0');
INSERT INTO `mall_admin_auth` VALUES ('12', '11', '商品列表', 'goods/goods/index', '', '1', '1', '1', '0');
INSERT INTO `mall_admin_auth` VALUES ('13', '0', 'icon管理', '', 'layui-icon-set-sm', '99', '1', '1', '0');
INSERT INTO `mall_admin_auth` VALUES ('14', '13', 'icon列表', 'icon/icon/index', '', '99', '1', '1', '0');
INSERT INTO `mall_admin_auth` VALUES ('15', '8', '淘客分类', 'media/column/taoColumn', '', '99', '1', '1', '0');
INSERT INTO `mall_admin_auth` VALUES ('16', '0', '活动奖励管理', '', 'layui-icon-chart-screen', '99', '1', '1', '0');
INSERT INTO `mall_admin_auth` VALUES ('17', '16', '活动列表', 'activity/activity/index', '', '99', '1', '1', '0');
INSERT INTO `mall_admin_auth` VALUES ('18', '16', '福利礼包列表', 'reward/reward/index', '', '99', '1', '1', '0');
INSERT INTO `mall_admin_auth` VALUES ('19', '0', '电商资源管理', '', 'layui-icon-tabs', '99', '1', '1', '0');
INSERT INTO `mall_admin_auth` VALUES ('20', '19', '资源中心', 'online/online/index', '', '99', '1', '1', '0');
INSERT INTO `mall_admin_auth` VALUES ('21', '19', '品牌馆', 'brand/brand/index', '', '99', '1', '1', '0');
INSERT INTO `mall_admin_auth` VALUES ('22', '11', 'top精选', 'goods/Topgoods/topGoods', '', '99', '1', '1', '0');
INSERT INTO `mall_admin_auth` VALUES ('23', '11', '商品管理', 'goods/goodsmanage/index', '', '99', '1', '1', '0');
INSERT INTO `mall_admin_auth` VALUES ('24', '16', '奖品库管理', 'reward/reward/rewardGoods', '', '99', '1', '1', '0');

-- ----------------------------
-- Table structure for mall_admin_role
-- ----------------------------
DROP TABLE IF EXISTS `mall_admin_role`;
CREATE TABLE `mall_admin_role` (
  `role_id` tinyint(3) NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `role_name` varchar(20) DEFAULT NULL COMMENT '角色名称',
  `role_describe` varchar(255) DEFAULT NULL COMMENT '角色描述',
  `role_auth` varchar(255) DEFAULT NULL COMMENT '权限列表',
  `role_create_time` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='管理员角色表';

-- ----------------------------
-- Records of mall_admin_role
-- ----------------------------
INSERT INTO `mall_admin_role` VALUES ('1', '超级管理员', '超级管理员', null, '1539072772');

-- ----------------------------
-- Table structure for mall_admin_user
-- ----------------------------
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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of mall_admin_user
-- ----------------------------
INSERT INTO `mall_admin_user` VALUES ('1', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '天芒云', '1', '1539070264', '219.140.154.36', '1547169309', '1');
INSERT INTO `mall_admin_user` VALUES ('2', 'manage', 'e10adc3949ba59abbe56e057f20f883e', '电商管理员', '2', '1546938452', '111.172.28.134', '1546938473', '-1');

-- ----------------------------
-- Table structure for mall_banner
-- ----------------------------
DROP TABLE IF EXISTS `mall_banner`;
CREATE TABLE `mall_banner` (
  `banner_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `banner_media_id` int(10) unsigned DEFAULT '0' COMMENT '媒体id',
  `banner_title` varchar(255) DEFAULT '' COMMENT '广告位标题',
  `banner_img` varchar(255) DEFAULT '' COMMENT '图片地址',
  `banner_url` varchar(255) DEFAULT '' COMMENT '图片链接',
  `banner_sort` tinyint(2) unsigned DEFAULT '99' COMMENT '排序',
  `banner_sex` tinyint(1) unsigned DEFAULT '0' COMMENT '默认全部  1-男 2-女',
  `banner_create_time` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  `banner_status` tinyint(2) DEFAULT '1' COMMENT '广告状态',
  PRIMARY KEY (`banner_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mall_banner
-- ----------------------------
INSERT INTO `mall_banner` VALUES ('1', '2', '首页活动', 'http://static.mall.bangwoya.com/20181220_fa21eae491e6ea89adb8c54537806f4a.png', 'http://www.baidu.com', '1', '2', '1545298643', '1');
INSERT INTO `mall_banner` VALUES ('2', '1', 'assa', 'http://static.mall.bangwoya.com/20181227_638002057782f4539e874ba97fa09bf3.png', 'http://www.baidu.com', '99', '0', '1545893045', '1');
INSERT INTO `mall_banner` VALUES ('3', '3', '1', 'http://static.mall.bangwoya.com/20190110_672daa756f81eb1d79a80e7906e8b974.jpg', '#', '2', '1', '1547023449', '1');
INSERT INTO `mall_banner` VALUES ('4', '3', 'test', 'http://static.mall.bangwoya.com/20190109_eed02d13262f3114e2eea6a439904558.png', 'test', '1', '1', '1547024025', '1');
INSERT INTO `mall_banner` VALUES ('5', '3', '测试', 'http://static.mall.bangwoya.com/20190110_47238bbf30b5bce986c95eb6add05d61.jpg', '1', '1', '2', '1547103609', '1');
INSERT INTO `mall_banner` VALUES ('6', '3', '测试', 'http://static.mall.bangwoya.com/20190110_7ca7e02daba5e0f38ec785ca3b826514.png', '1', '2', '2', '1547103624', '1');

-- ----------------------------
-- Table structure for mall_bind_brand_goods
-- ----------------------------
DROP TABLE IF EXISTS `mall_bind_brand_goods`;
CREATE TABLE `mall_bind_brand_goods` (
  `bind_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bind_column_id` int(10) unsigned NOT NULL COMMENT '栏目id',
  `bind_goods_id` int(10) unsigned NOT NULL COMMENT '商品id',
  `bind_sort` tinyint(2) unsigned DEFAULT '99' COMMENT '排序',
  `bind_status` tinyint(2) DEFAULT '1' COMMENT '状态',
  `bind_create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`bind_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mall_bind_brand_goods
-- ----------------------------
INSERT INTO `mall_bind_brand_goods` VALUES ('9', '4', '56', '99', '1', '1547085165');
INSERT INTO `mall_bind_brand_goods` VALUES ('10', '4', '57', '99', '1', '1547085165');
INSERT INTO `mall_bind_brand_goods` VALUES ('11', '4', '58', '99', '1', '1547085165');
INSERT INTO `mall_bind_brand_goods` VALUES ('12', '4', '59', '99', '1', '1547085165');
INSERT INTO `mall_bind_brand_goods` VALUES ('13', '4', '60', '99', '1', '1547092006');
INSERT INTO `mall_bind_brand_goods` VALUES ('14', '4', '61', '99', '1', '1547092077');
INSERT INTO `mall_bind_brand_goods` VALUES ('15', '4', '62', '99', '1', '1547092077');
INSERT INTO `mall_bind_brand_goods` VALUES ('16', '4', '63', '99', '1', '1547092077');
INSERT INTO `mall_bind_brand_goods` VALUES ('17', '4', '64', '99', '1', '1547092085');
INSERT INTO `mall_bind_brand_goods` VALUES ('18', '5', '48', '99', '1', '1547093253');
INSERT INTO `mall_bind_brand_goods` VALUES ('19', '5', '49', '99', '1', '1547093253');
INSERT INTO `mall_bind_brand_goods` VALUES ('20', '5', '52', '99', '1', '1547093253');
INSERT INTO `mall_bind_brand_goods` VALUES ('21', '5', '53', '99', '1', '1547093253');
INSERT INTO `mall_bind_brand_goods` VALUES ('22', '5', '54', '99', '1', '1547093253');
INSERT INTO `mall_bind_brand_goods` VALUES ('23', '4', '29', '99', '1', '1547104493');

-- ----------------------------
-- Table structure for mall_bind_column_goods
-- ----------------------------
DROP TABLE IF EXISTS `mall_bind_column_goods`;
CREATE TABLE `mall_bind_column_goods` (
  `bind_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bind_column_id` int(10) unsigned NOT NULL COMMENT '栏目id',
  `bind_goods_id` int(10) unsigned NOT NULL COMMENT '商品id',
  `bind_sort` tinyint(2) unsigned DEFAULT '99' COMMENT '排序',
  `bind_status` tinyint(2) DEFAULT '1' COMMENT '状态',
  `bind_create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`bind_id`)
) ENGINE=MyISAM AUTO_INCREMENT=121 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mall_bind_column_goods
-- ----------------------------
INSERT INTO `mall_bind_column_goods` VALUES ('16', '21', '18', '99', '-1', '1546920250');
INSERT INTO `mall_bind_column_goods` VALUES ('17', '21', '19', '99', '-1', '1546920250');
INSERT INTO `mall_bind_column_goods` VALUES ('18', '21', '20', '99', '-1', '1546920250');
INSERT INTO `mall_bind_column_goods` VALUES ('19', '21', '21', '99', '-1', '1546920250');
INSERT INTO `mall_bind_column_goods` VALUES ('20', '21', '22', '99', '-1', '1546920250');
INSERT INTO `mall_bind_column_goods` VALUES ('21', '21', '23', '99', '-1', '1546920250');
INSERT INTO `mall_bind_column_goods` VALUES ('22', '21', '24', '99', '-1', '1546920250');
INSERT INTO `mall_bind_column_goods` VALUES ('23', '21', '25', '99', '-1', '1546920250');
INSERT INTO `mall_bind_column_goods` VALUES ('24', '21', '26', '99', '-1', '1546920250');
INSERT INTO `mall_bind_column_goods` VALUES ('25', '22', '27', '99', '1', '1547084612');
INSERT INTO `mall_bind_column_goods` VALUES ('26', '22', '28', '99', '1', '1547084612');
INSERT INTO `mall_bind_column_goods` VALUES ('27', '22', '29', '99', '1', '1547084612');
INSERT INTO `mall_bind_column_goods` VALUES ('28', '22', '30', '99', '1', '1547084612');
INSERT INTO `mall_bind_column_goods` VALUES ('29', '22', '31', '99', '1', '1547084612');
INSERT INTO `mall_bind_column_goods` VALUES ('30', '22', '32', '99', '1', '1547084612');
INSERT INTO `mall_bind_column_goods` VALUES ('31', '22', '33', '99', '1', '1547084612');
INSERT INTO `mall_bind_column_goods` VALUES ('32', '22', '34', '99', '1', '1547084612');
INSERT INTO `mall_bind_column_goods` VALUES ('33', '22', '35', '99', '1', '1547084612');
INSERT INTO `mall_bind_column_goods` VALUES ('34', '22', '36', '99', '1', '1547084612');
INSERT INTO `mall_bind_column_goods` VALUES ('35', '22', '37', '99', '1', '1547084612');
INSERT INTO `mall_bind_column_goods` VALUES ('36', '22', '38', '99', '1', '1547084612');
INSERT INTO `mall_bind_column_goods` VALUES ('37', '22', '39', '99', '1', '1547084612');
INSERT INTO `mall_bind_column_goods` VALUES ('38', '22', '40', '99', '1', '1547084612');
INSERT INTO `mall_bind_column_goods` VALUES ('39', '22', '41', '99', '1', '1547084612');
INSERT INTO `mall_bind_column_goods` VALUES ('40', '22', '42', '99', '1', '1547084612');
INSERT INTO `mall_bind_column_goods` VALUES ('41', '22', '43', '99', '1', '1547084612');
INSERT INTO `mall_bind_column_goods` VALUES ('42', '22', '44', '99', '1', '1547084612');
INSERT INTO `mall_bind_column_goods` VALUES ('43', '22', '45', '99', '1', '1547084612');
INSERT INTO `mall_bind_column_goods` VALUES ('44', '22', '46', '99', '1', '1547084612');
INSERT INTO `mall_bind_column_goods` VALUES ('45', '23', '47', '99', '-1', '1547084757');
INSERT INTO `mall_bind_column_goods` VALUES ('46', '23', '48', '99', '-1', '1547084757');
INSERT INTO `mall_bind_column_goods` VALUES ('47', '23', '49', '99', '-1', '1547084757');
INSERT INTO `mall_bind_column_goods` VALUES ('48', '23', '50', '99', '-1', '1547084757');
INSERT INTO `mall_bind_column_goods` VALUES ('49', '23', '51', '99', '-1', '1547084757');
INSERT INTO `mall_bind_column_goods` VALUES ('50', '23', '52', '99', '-1', '1547084757');
INSERT INTO `mall_bind_column_goods` VALUES ('51', '23', '53', '99', '-1', '1547084757');
INSERT INTO `mall_bind_column_goods` VALUES ('52', '23', '54', '99', '-1', '1547084757');
INSERT INTO `mall_bind_column_goods` VALUES ('53', '23', '55', '99', '-1', '1547084757');
INSERT INTO `mall_bind_column_goods` VALUES ('54', '21', '65', '99', '-1', '1547092918');
INSERT INTO `mall_bind_column_goods` VALUES ('55', '21', '66', '99', '-1', '1547092918');
INSERT INTO `mall_bind_column_goods` VALUES ('56', '21', '67', '99', '-1', '1547092918');
INSERT INTO `mall_bind_column_goods` VALUES ('57', '21', '68', '99', '-1', '1547092918');
INSERT INTO `mall_bind_column_goods` VALUES ('58', '21', '69', '99', '-1', '1547092918');
INSERT INTO `mall_bind_column_goods` VALUES ('59', '21', '70', '99', '-1', '1547092918');
INSERT INTO `mall_bind_column_goods` VALUES ('60', '21', '71', '99', '-1', '1547092918');
INSERT INTO `mall_bind_column_goods` VALUES ('61', '21', '72', '99', '-1', '1547092918');
INSERT INTO `mall_bind_column_goods` VALUES ('62', '25', '93', '99', '1', '1547100785');
INSERT INTO `mall_bind_column_goods` VALUES ('63', '25', '94', '99', '1', '1547100785');
INSERT INTO `mall_bind_column_goods` VALUES ('64', '25', '95', '99', '1', '1547100785');
INSERT INTO `mall_bind_column_goods` VALUES ('65', '21', '96', '99', '-1', '1547102375');
INSERT INTO `mall_bind_column_goods` VALUES ('66', '21', '97', '99', '-1', '1547102375');
INSERT INTO `mall_bind_column_goods` VALUES ('67', '21', '98', '99', '-1', '1547102375');
INSERT INTO `mall_bind_column_goods` VALUES ('68', '21', '99', '99', '-1', '1547102375');
INSERT INTO `mall_bind_column_goods` VALUES ('69', '21', '100', '99', '-1', '1547102375');
INSERT INTO `mall_bind_column_goods` VALUES ('70', '21', '101', '99', '-1', '1547102375');
INSERT INTO `mall_bind_column_goods` VALUES ('71', '21', '102', '99', '-1', '1547102375');
INSERT INTO `mall_bind_column_goods` VALUES ('72', '21', '30', '99', '-1', '1547102820');
INSERT INTO `mall_bind_column_goods` VALUES ('73', '21', '32', '99', '1', '1547102820');
INSERT INTO `mall_bind_column_goods` VALUES ('74', '21', '43', '99', '-1', '1547102820');
INSERT INTO `mall_bind_column_goods` VALUES ('75', '21', '93', '99', '-1', '1547102955');
INSERT INTO `mall_bind_column_goods` VALUES ('76', '21', '103', '99', '-1', '1547102955');
INSERT INTO `mall_bind_column_goods` VALUES ('77', '21', '104', '99', '-1', '1547102955');
INSERT INTO `mall_bind_column_goods` VALUES ('78', '21', '105', '99', '-1', '1547102955');
INSERT INTO `mall_bind_column_goods` VALUES ('79', '21', '106', '99', '1', '1547102955');
INSERT INTO `mall_bind_column_goods` VALUES ('80', '21', '49', '99', '1', '1547104001');
INSERT INTO `mall_bind_column_goods` VALUES ('81', '21', '52', '99', '1', '1547104001');
INSERT INTO `mall_bind_column_goods` VALUES ('82', '21', '53', '99', '1', '1547104001');
INSERT INTO `mall_bind_column_goods` VALUES ('83', '21', '54', '99', '1', '1547104001');
INSERT INTO `mall_bind_column_goods` VALUES ('84', '24', '49', '99', '1', '1547104408');
INSERT INTO `mall_bind_column_goods` VALUES ('85', '24', '53', '99', '1', '1547104408');
INSERT INTO `mall_bind_column_goods` VALUES ('86', '24', '54', '99', '1', '1547104408');
INSERT INTO `mall_bind_column_goods` VALUES ('87', '22', '107', '99', '1', '1547105375');
INSERT INTO `mall_bind_column_goods` VALUES ('88', '22', '108', '99', '1', '1547105375');
INSERT INTO `mall_bind_column_goods` VALUES ('89', '26', '107', '99', '-1', '1547105381');
INSERT INTO `mall_bind_column_goods` VALUES ('90', '26', '108', '99', '1', '1547105381');
INSERT INTO `mall_bind_column_goods` VALUES ('91', '22', '109', '99', '1', '1547105953');
INSERT INTO `mall_bind_column_goods` VALUES ('92', '22', '110', '99', '1', '1547105953');
INSERT INTO `mall_bind_column_goods` VALUES ('93', '22', '111', '99', '1', '1547105953');
INSERT INTO `mall_bind_column_goods` VALUES ('94', '22', '112', '99', '1', '1547105953');
INSERT INTO `mall_bind_column_goods` VALUES ('95', '26', '111', '99', '1', '1547105963');
INSERT INTO `mall_bind_column_goods` VALUES ('96', '21', '113', '99', '1', '1547107702');
INSERT INTO `mall_bind_column_goods` VALUES ('97', '21', '114', '99', '1', '1547107702');
INSERT INTO `mall_bind_column_goods` VALUES ('98', '21', '115', '99', '1', '1547107702');
INSERT INTO `mall_bind_column_goods` VALUES ('99', '21', '116', '99', '1', '1547107702');
INSERT INTO `mall_bind_column_goods` VALUES ('100', '21', '117', '99', '1', '1547107702');
INSERT INTO `mall_bind_column_goods` VALUES ('101', '25', '30', '99', '1', '1547109720');
INSERT INTO `mall_bind_column_goods` VALUES ('102', '25', '32', '99', '1', '1547109720');
INSERT INTO `mall_bind_column_goods` VALUES ('103', '23', '30', '99', '1', '1547109853');
INSERT INTO `mall_bind_column_goods` VALUES ('104', '23', '32', '99', '1', '1547109853');
INSERT INTO `mall_bind_column_goods` VALUES ('105', '23', '43', '99', '1', '1547109853');
INSERT INTO `mall_bind_column_goods` VALUES ('106', '22', '59', '99', '1', '1547110300');
INSERT INTO `mall_bind_column_goods` VALUES ('107', '22', '118', '99', '1', '1547110300');
INSERT INTO `mall_bind_column_goods` VALUES ('108', '22', '119', '99', '1', '1547110300');
INSERT INTO `mall_bind_column_goods` VALUES ('109', '22', '120', '99', '1', '1547110300');
INSERT INTO `mall_bind_column_goods` VALUES ('110', '22', '121', '99', '1', '1547110300');
INSERT INTO `mall_bind_column_goods` VALUES ('111', '22', '122', '99', '1', '1547110300');
INSERT INTO `mall_bind_column_goods` VALUES ('112', '22', '123', '99', '1', '1547110300');
INSERT INTO `mall_bind_column_goods` VALUES ('113', '22', '124', '99', '1', '1547110300');
INSERT INTO `mall_bind_column_goods` VALUES ('114', '22', '125', '99', '1', '1547110320');
INSERT INTO `mall_bind_column_goods` VALUES ('115', '22', '126', '99', '1', '1547110320');
INSERT INTO `mall_bind_column_goods` VALUES ('116', '22', '127', '99', '1', '1547110320');
INSERT INTO `mall_bind_column_goods` VALUES ('117', '22', '128', '99', '1', '1547110320');
INSERT INTO `mall_bind_column_goods` VALUES ('118', '22', '129', '99', '1', '1547110320');
INSERT INTO `mall_bind_column_goods` VALUES ('119', '22', '130', '99', '1', '1547110320');
INSERT INTO `mall_bind_column_goods` VALUES ('120', '22', '131', '99', '1', '1547110320');

-- ----------------------------
-- Table structure for mall_bind_reward_goods
-- ----------------------------
DROP TABLE IF EXISTS `mall_bind_reward_goods`;
CREATE TABLE `mall_bind_reward_goods` (
  `bind_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bind_goodsid` char(50) DEFAULT NULL COMMENT '大淘客商品id',
  `bind_status` tinyint(2) DEFAULT '1' COMMENT '状态',
  `bind_create_time` int(10) DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`bind_id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mall_bind_reward_goods
-- ----------------------------
INSERT INTO `mall_bind_reward_goods` VALUES ('21', '73', '1', '1547099300');
INSERT INTO `mall_bind_reward_goods` VALUES ('22', '74', '1', '1547099300');
INSERT INTO `mall_bind_reward_goods` VALUES ('23', '75', '1', '1547099300');
INSERT INTO `mall_bind_reward_goods` VALUES ('24', '76', '1', '1547099300');
INSERT INTO `mall_bind_reward_goods` VALUES ('25', '77', '1', '1547099300');
INSERT INTO `mall_bind_reward_goods` VALUES ('26', '78', '1', '1547099300');
INSERT INTO `mall_bind_reward_goods` VALUES ('27', '79', '1', '1547099300');
INSERT INTO `mall_bind_reward_goods` VALUES ('28', '80', '1', '1547099300');
INSERT INTO `mall_bind_reward_goods` VALUES ('29', '81', '1', '1547099300');
INSERT INTO `mall_bind_reward_goods` VALUES ('30', '82', '1', '1547099300');
INSERT INTO `mall_bind_reward_goods` VALUES ('31', '83', '1', '1547099300');
INSERT INTO `mall_bind_reward_goods` VALUES ('32', '84', '1', '1547099300');
INSERT INTO `mall_bind_reward_goods` VALUES ('33', '85', '1', '1547099300');
INSERT INTO `mall_bind_reward_goods` VALUES ('34', '86', '1', '1547099300');
INSERT INTO `mall_bind_reward_goods` VALUES ('35', '87', '1', '1547099300');
INSERT INTO `mall_bind_reward_goods` VALUES ('36', '88', '1', '1547099300');
INSERT INTO `mall_bind_reward_goods` VALUES ('37', '89', '1', '1547099300');
INSERT INTO `mall_bind_reward_goods` VALUES ('38', '90', '1', '1547099300');
INSERT INTO `mall_bind_reward_goods` VALUES ('39', '91', '1', '1547099300');
INSERT INTO `mall_bind_reward_goods` VALUES ('40', '92', '1', '1547099300');

-- ----------------------------
-- Table structure for mall_bind_user_reward
-- ----------------------------
DROP TABLE IF EXISTS `mall_bind_user_reward`;
CREATE TABLE `mall_bind_user_reward` (
  `bind_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bind_uid` int(10) unsigned NOT NULL COMMENT '用户id',
  `bind_reward` text COMMENT '奖励信息',
  `bind_type` tinyint(1) unsigned DEFAULT '1' COMMENT '1-优惠券   2-第三方礼包',
  `bind_create_time` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`bind_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mall_bind_user_reward
-- ----------------------------
INSERT INTO `mall_bind_user_reward` VALUES ('1', '34', '{\"goodsid\":\"580531118055\",\"d_title\":\"\\u5927\\u773c\\u6a59\\u529e\\u516c\\u5bb6\\u7528\\u624b\\u673a3D\\u9ad8\\u6e05\\u6295\\u5f71\\u4eea\",\"quan_price\":300,\"pic\":\"https:\\/\\/img.alicdn.com\\/imgextra\\/i2\\/3369193590\\/O1CN01iz7OMc1cOGMVSxjQk_!!3369193590.jpg\",\"quan_link\":\"https:\\/\\/uland.taobao.com\\/quan\\/detail?sellerId=3369193590&activityId=cba482e39f164df691ff318ec9444d01\"}', '1', '1547125221');
INSERT INTO `mall_bind_user_reward` VALUES ('2', '34', '{\"reward_img\":\"http:\\/\\/static.mall.bangwoya.com\\/20190110_3b302a043487b5a74c42a417d20e6d1e.jpg\",\"reward_url\":\"http:\\/\\/www.baidu.com\"}', '2', '1547125221');
INSERT INTO `mall_bind_user_reward` VALUES ('3', '34', '{\"goodsid\":\"17549147572\",\"d_title\":\"\\u592a\\u6e56\\u96ea\\u52a0\\u539a\\u4fdd\\u6696\\u6625\\u79cb\\u624b\\u5de5\\u88ab\\u82af\",\"quan_price\":600,\"pic\":\"https:\\/\\/img.alicdn.com\\/imgextra\\/i1\\/735965542\\/TB2.8F8azZnyKJjSZFLXXXWqpXa_!!735965542.jpg\",\"quan_link\":\"https:\\/\\/uland.taobao.com\\/quan\\/detail?sellerId=735965542&activityId=759f8007e53b4db383f3dc164b8172af\"}', '1', '1547125400');
INSERT INTO `mall_bind_user_reward` VALUES ('4', '34', '{\"reward_img\":\"http:\\/\\/static.mall.bangwoya.com\\/20190110_3b302a043487b5a74c42a417d20e6d1e.jpg\",\"reward_url\":\"http:\\/\\/www.baidu.com\"}', '2', '1547125400');
INSERT INTO `mall_bind_user_reward` VALUES ('5', '34', '{\"goodsid\":\"577068023465\",\"d_title\":\"\\u6a21\\u536155\\u540b4K\\u667a\\u80fd\\u5168\\u9762\\u5c4f\\u66f2\\u9762\\u7535\\u89c6\",\"quan_price\":400,\"pic\":\"https:\\/\\/img.alicdn.com\\/imgextra\\/i4\\/2389586717\\/O1CN01BnADvC1zUQrapIhrH_!!2389586717.jpg\",\"quan_link\":\"https:\\/\\/uland.taobao.com\\/quan\\/detail?sellerId=2248149301&activityId=b36191a36b694807afc0521619a1668a\"}', '1', '1547125426');
INSERT INTO `mall_bind_user_reward` VALUES ('6', '34', '{\"reward_img\":\"http:\\/\\/static.mall.bangwoya.com\\/20190110_3b302a043487b5a74c42a417d20e6d1e.jpg\",\"reward_url\":\"http:\\/\\/www.baidu.com\"}', '2', '1547125426');
INSERT INTO `mall_bind_user_reward` VALUES ('7', '20', '{\"goodsid\":\"575704139683\",\"d_title\":\"\\u677f\\u5ddd\\u5c1a\\u6d3e\\u96c6\\u6210\\u7076\\u4e00\\u4f53\\u7076\\u81ea\\u52a8\\u6e05\\u6d17\\u6d88\\u6bd2\",\"quan_price\":800,\"pic\":\"https:\\/\\/img.alicdn.com\\/imgextra\\/i1\\/878393178\\/O1CN01BGFdsF1ZLZB6QO4FV_!!878393178.jpg\",\"quan_link\":\"https:\\/\\/uland.taobao.com\\/quan\\/detail?sellerId=2781180165&activityId=13f39d7f1add40b18ba3b0d11d234695\"}', '1', '1547125581');
INSERT INTO `mall_bind_user_reward` VALUES ('8', '20', '{\"reward_img\":\"http:\\/\\/static.mall.bangwoya.com\\/20190110_3b302a043487b5a74c42a417d20e6d1e.jpg\",\"reward_url\":\"http:\\/\\/www.baidu.com\"}', '2', '1547125581');
INSERT INTO `mall_bind_user_reward` VALUES ('9', '20', '{\"goodsid\":\"576182313631\",\"d_title\":\"\\u3010\\u534e\\u5e1d\\u3011\\u4fa7\\u5438\\u5f0f\\u6cb9\\u70df\\u673a\\u71c3\\u6c14\\u7076\\u5957\\u88c5\\u7ec4\\u5408\",\"quan_price\":500,\"pic\":\"https:\\/\\/img.alicdn.com\\/imgextra\\/i4\\/3868255650\\/O1CN01CvjeLI1rbkGDWmMIs_!!3868255650.jpg\",\"quan_link\":\"https:\\/\\/uland.taobao.com\\/quan\\/detail?sellerId=2095854107&activityId=d8f482c141b74498b6b667c789a7d0d4\"}', '1', '1547125629');
INSERT INTO `mall_bind_user_reward` VALUES ('10', '20', '{\"reward_img\":\"http:\\/\\/static.mall.bangwoya.com\\/20190110_3b302a043487b5a74c42a417d20e6d1e.jpg\",\"reward_url\":\"http:\\/\\/www.baidu.com\"}', '2', '1547125629');

-- ----------------------------
-- Table structure for mall_brand
-- ----------------------------
DROP TABLE IF EXISTS `mall_brand`;
CREATE TABLE `mall_brand` (
  `brand_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `brand_column_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '栏目id',
  `brand_title` varchar(50) NOT NULL DEFAULT '' COMMENT '品牌名',
  `brand_logo` varchar(255) NOT NULL DEFAULT '' COMMENT '品牌图片地址',
  `brand_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`brand_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='品牌';

-- ----------------------------
-- Records of mall_brand
-- ----------------------------
INSERT INTO `mall_brand` VALUES ('4', '22', '相宜本草', 'http://static.mall.bangwoya.com/20190110_b6009ab8e760f096db711b20e9f744fa.png', '1547085120');
INSERT INTO `mall_brand` VALUES ('5', '24', '男装', 'http://static.mall.bangwoya.com/20190110_c914a61f81d214bdd53830eba7df452f.png', '1547093216');

-- ----------------------------
-- Table structure for mall_column
-- ----------------------------
DROP TABLE IF EXISTS `mall_column`;
CREATE TABLE `mall_column` (
  `column_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `column_title` varchar(100) NOT NULL DEFAULT '' COMMENT '栏目名称',
  `column_media_id` tinyint(3) unsigned DEFAULT '0' COMMENT '媒体id',
  `column_thumb` varchar(255) DEFAULT NULL COMMENT '栏目缩略图',
  `column_pic` varchar(255) DEFAULT '' COMMENT '专栏底图',
  `column_image` varchar(255) DEFAULT '' COMMENT '列表图',
  `column_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `column_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '栏目类型   0-普通  1-专场',
  `column_sex` tinyint(1) unsigned DEFAULT '2' COMMENT '性别   1-男  2-女',
  `column_status` tinyint(2) DEFAULT '1' COMMENT '状态',
  `column_sort` tinyint(2) unsigned NOT NULL DEFAULT '99' COMMENT '排序',
  PRIMARY KEY (`column_id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='媒体栏目表';

-- ----------------------------
-- Records of mall_column
-- ----------------------------
INSERT INTO `mall_column` VALUES ('1', '女装', '0', 'http://static.mall.bangwoya.com/20181226_d1cc83d7e6b2d2cfb21385c9235aa603.png', '', '', '1544839424', '0', '0', '1', '99');
INSERT INTO `mall_column` VALUES ('2', '母婴', '0', 'http://static.mall.bangwoya.com/20181227_9427b98403e00af422144915bfc77d17.png', '', '', '1544839424', '0', '0', '1', '99');
INSERT INTO `mall_column` VALUES ('3', '美妆', '0', 'http://static.mall.bangwoya.com/20181227_60789e064b327bb74f8f163559de3090.png', '', '', '1544839424', '0', '0', '1', '99');
INSERT INTO `mall_column` VALUES ('4', '居家日用', '0', 'http://static.mall.bangwoya.com/20181227_8b1b0dc8f889fb4391bf4e8d7adbdc33.png', '', '', '1544839424', '0', '0', '1', '99');
INSERT INTO `mall_column` VALUES ('5', '鞋品', '0', 'http://static.mall.bangwoya.com/20181227_54b96dd0ead38b4845b3a56eacf5ef95.png', '', '', '1544839424', '0', '0', '1', '99');
INSERT INTO `mall_column` VALUES ('6', '美食', '0', 'http://static.mall.bangwoya.com/20181227_9a02afdc033f88e9232eecf103f155f1.png', '', '', '1544839424', '0', '0', '1', '99');
INSERT INTO `mall_column` VALUES ('7', '文娱车品', '0', 'http://static.mall.bangwoya.com/20181227_2fd44b6f24580973fe3faae1037851c5.png', '', '', '1544839424', '0', '0', '1', '99');
INSERT INTO `mall_column` VALUES ('8', '数码家电', '0', 'http://static.mall.bangwoya.com/20181227_42ee5150cbe438c095ae6eb7fddc5896.png', '', '', '1544839424', '0', '0', '1', '99');
INSERT INTO `mall_column` VALUES ('9', '男装', '0', 'http://static.mall.bangwoya.com/20181227_8dc32160608344d1682731a4224de2b5.png', '', '', '1544839424', '0', '0', '1', '99');
INSERT INTO `mall_column` VALUES ('10', '内衣', '0', 'http://static.mall.bangwoya.com/20181227_1367f0c5c3e9d2305c411d29f96ffd0c.png', '', '', '1544839424', '0', '0', '1', '99');
INSERT INTO `mall_column` VALUES ('11', '箱包', '0', 'http://static.mall.bangwoya.com/20181227_e1faf0db21386232b528ece06ef488d1.png', '', '', '1544839424', '0', '0', '1', '99');
INSERT INTO `mall_column` VALUES ('12', '配饰', '0', 'http://static.mall.bangwoya.com/20181227_53c72a3ff45642b2e6e5589de1ffcb4b.png', '', '', '1544839424', '0', '0', '1', '99');
INSERT INTO `mall_column` VALUES ('13', '户外运动', '0', 'http://static.mall.bangwoya.com/20181227_b5f7746777aee23e3b51fbdbe2c9e79a.png', '', '', '1544839424', '0', '0', '1', '99');
INSERT INTO `mall_column` VALUES ('14', '家装家纺', '0', 'http://static.mall.bangwoya.com/20181227_99f40e8c12749800c57d77765f0dc711.png', '', '', '1544839424', '0', '0', '1', '99');
INSERT INTO `mall_column` VALUES ('21', '今日秒杀', '3', '03:00:00', '', '', '1546920104', '1', '2', '1', '99');
INSERT INTO `mall_column` VALUES ('22', '美妆', '3', 'http://static.mall.bangwoya.com/20190110_9489f050943b4faf0cfb95dd645d881a.png', 'http://static.mall.bangwoya.com/20190110_2bdd76415484fc8d7c759bf419f6167f.png', 'http://static.mall.bangwoya.com/20190110_2f7b55b3cd5e9341f51b0bc1f4f56a0a.png', '1547084521', '0', '2', '1', '99');
INSERT INTO `mall_column` VALUES ('23', '今日秒杀', '3', '06:00:00', '', '', '1547084711', '1', '1', '1', '99');
INSERT INTO `mall_column` VALUES ('24', '男装', '3', '02:52:12', '', '', '1547093182', '1', '1', '1', '99');
INSERT INTO `mall_column` VALUES ('26', '女男', '3', '', '', '', '1547104720', '0', '2', '1', '99');
INSERT INTO `mall_column` VALUES ('25', '南潮', '3', 'http://static.mall.bangwoya.com/20190110_ddabe10e1383528a36a3811bd6f8c9a7.png', 'http://static.mall.bangwoya.com/20190110_c5fcaa6efa511fbb78e5e19acb393776.png', 'http://static.mall.bangwoya.com/20190110_2ad2fbf19a320dbd878c78027cbdfed8.png', '1547100738', '0', '1', '1', '99');

-- ----------------------------
-- Table structure for mall_goods
-- ----------------------------
DROP TABLE IF EXISTS `mall_goods`;
CREATE TABLE `mall_goods` (
  `goods_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `id` varchar(20) NOT NULL COMMENT '大淘客商品id',
  `cid` tinyint(2) NOT NULL,
  `goodsid` varchar(20) NOT NULL COMMENT '商品淘宝id',
  `title` varchar(255) NOT NULL COMMENT '商品标题',
  `d_title` varchar(100) NOT NULL COMMENT '商品短标题',
  `pic` varchar(255) NOT NULL COMMENT '商品主图',
  `org_price` float(10,2) DEFAULT NULL COMMENT '正常售价',
  `price` float(10,2) NOT NULL COMMENT '券后价',
  `istmall` tinyint(1) unsigned zerofill NOT NULL COMMENT '是否天猫',
  `sales_num` int(10) unsigned NOT NULL COMMENT '商品销量',
  `sellerid` varchar(20) NOT NULL DEFAULT '0' COMMENT '卖家id',
  `commission_jihua` float(10,2) NOT NULL COMMENT '计划(通用)佣金比例',
  `commission_queqiao` float(10,2) NOT NULL COMMENT '高佣鹊桥佣金比例',
  `jihua_link` varchar(255) NOT NULL COMMENT '计划链接',
  `jihua_shenhe` tinyint(1) NOT NULL COMMENT '计划审核状态',
  `introduce` varchar(255) NOT NULL COMMENT '商品文案',
  `quan_id` varchar(32) NOT NULL COMMENT '优惠券ID',
  `quan_price` float(10,2) NOT NULL COMMENT '优惠券金额',
  `quan_time` varchar(20) NOT NULL COMMENT '优惠券结束时间',
  `quan_surplus` int(10) NOT NULL COMMENT '优惠券剩余数量',
  `quan_receive` int(10) NOT NULL COMMENT '已领券数量',
  `quan_condition` varchar(255) NOT NULL COMMENT '优惠券使用条件',
  `quan_link` varchar(255) NOT NULL COMMENT '手机券链接',
  `create_time` int(10) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '1' COMMENT '状态  -1 删除',
  PRIMARY KEY (`goods_id`),
  KEY `istmall` (`istmall`),
  KEY `price` (`price`),
  FULLTEXT KEY `title` (`title`)
) ENGINE=MyISAM AUTO_INCREMENT=132 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品表';

-- ----------------------------
-- Records of mall_goods
-- ----------------------------
INSERT INTO `mall_goods` VALUES ('18', '17817060', '1', '583320769017', '（第二件0元）明星同款光腿神器打底裤加绒显瘦修身保暖踩脚连裤', '第二件0元光腿神器打底裤加绒保暖踩脚连裤', 'https://img.alicdn.com/imgextra/i3/224713064/O1CN01AUBgGF1YVM28mLOaW_!!224713064.jpg', '209.99', '9.99', '0', '606', '2630581698', '30.00', '0.00', '', '0', '光腿神器！双层分类，任意剪，不勾丝，内绒细腻柔滑，裤体超强弹性，舒适透气，抗起球牛货，超厚防风保暖一件保过冬，再冷都不怕！【赠送运费险】', 'd58a7b8898c04d69a1990c8607c303a2', '200.00', '2018-12-31 23:59:59', '100000', '0', '208', 'https://uland.taobao.com/quan/detail?sellerId=2630581698&activityId=d58a7b8898c04d69a1990c8607c303a2', '1546920250', '1');
INSERT INTO `mall_goods` VALUES ('19', '17800464', '1', '576664220175', '2018秋冬季休闲打底裤女外穿高弹高腰显瘦黑色加绒加厚保暖裤子女', '【加绒疯抢中】休闲仿牛仔打底裤', 'https://img.alicdn.com/imgextra/i4/2879913302/O1CN01FdGYEx1aGMHfaWoFb_!!2879913302.jpg', '129.90', '19.90', '1', '6649', '2879913302', '20.00', '0.00', '', '0', '【天猫旗舰店】加绒牛仔打底裤！马上进入冬季，卖家亏本冲量2万条，要买的MM们趁早入手！', '2a6b9fd1f0044fdfaed325448d69ed33', '110.00', '2018-12-31 23:59:59', '49500', '500', '115', 'https://uland.taobao.com/quan/detail?sellerId=2879913302&activityId=2a6b9fd1f0044fdfaed325448d69ed33', '1546920250', '1');
INSERT INTO `mall_goods` VALUES ('20', '17800640', '1', '27239876378', '女士羽绒棉裤外穿高腰加厚白鸭绒户外秋冬季修身显瘦保暖小脚长裤', '女士高腰加厚白鸭绒保暖裤', 'https://img.alicdn.com/imgextra/i4/1023136999/TB2RcNubFXXXXbCXXXXXXXXXXXX_!!1023136999.jpg', '149.00', '29.00', '1', '160', '1023136999', '30.00', '0.00', '', '0', '【90%白鸭绒】加绒加厚面料，保暖舒适，显瘦拉长腿型，提臀收腰瘦腿，不勒腰，不钻毛，不跑绒，款式新潮修身百搭【赠运费险】', 'd7f285374f494187a770280ac04a85b5', '120.00', '2018-12-27 23:59:59', '9900', '100', '149', 'https://uland.taobao.com/quan/detail?sellerId=1023136999&activityId=d7f285374f494187a770280ac04a85b5', '1546920250', '1');
INSERT INTO `mall_goods` VALUES ('21', '17798070', '1', '580694716269', '加绒加厚打底裤女外穿2018秋冬季新款保暖黑色小脚铅笔魔术棉裤子', '秋冬季新款保暖黑色小脚铅笔魔术棉裤子', 'https://img.alicdn.com/imgextra/i3/1935371611/O1CN01Y7cHAW1NlsXo2zPcI_!!1935371611.jpg', '119.90', '19.90', '0', '2306', '2934603388', '30.00', '0.00', '', '0', '【女神必备】不显瘦不要钱！！舒适外穿，不易起球，不抽丝，弹性收腹，拉长腿部线条，时尚百搭，高腰收腹，提臀修身，伸展自如，弹力无限，一条女神必备的魔术裤！', '689f08c60e7246aaacfc21673d57a82e', '100.00', '2018-12-29 23:59:59', '98587', '1413', '119', 'https://uland.taobao.com/quan/detail?sellerId=2934603388&activityId=689f08c60e7246aaacfc21673d57a82e', '1546920250', '1');
INSERT INTO `mall_goods` VALUES ('22', '17785296', '1', '581957033393', '【亏本清仓】欲购从速牛奶衣保暖内衣美肤衣秋衣秋裤套装', '【亏本清仓】买两件更划算牛奶衣', 'https://gd1.alicdn.com/imgextra/i1/1015215994/O1CN01HoGlms1u9IUi2SM6E-1015215994.jpg', '176.90', '26.90', '0', '17726', '1015215994', '30.00', '0.00', '', '0', '【历史新低！！】可以穿的“化妆品”！日本进口黑科技内衣！富含人体有益的17种维生素，含天然保湿因子，越穿皮肤越滑，皱纹也能减少，保暖又美肤~', '8432a6d9b3d044caa62f46530acf3c4d', '150.00', '2018-12-26 23:59:59', '95000', '5000', '151', 'https://uland.taobao.com/quan/detail?sellerId=1015215994&activityId=8432a6d9b3d044caa62f46530acf3c4d', '1546920250', '1');
INSERT INTO `mall_goods` VALUES ('23', '17770690', '1', '581007142626', '打底裤女外穿2018秋冬新款魔术小脚铅笔棉裤子保暖黑色裤', '秋冬新款魔术小脚打底裤女', 'https://gd2.alicdn.com/imgextra/i2/2934603388/O1CN01FrI8eq1atkLQuwODI_!!2934603388.jpg', '119.90', '19.90', '0', '1506', '2934603388', '30.00', '0.00', '', '0', '精选优质面料，健康海岛绒，抵御寒风，恒温保暖，百搭简约时尚，收腹提臀，舒适有型，保暖显瘦二合一，冬季女神必备款！【赠运费险】', 'b88b01e5d4a2416b82edc7c733bd933a', '100.00', '2018-12-28 23:59:59', '100000', '1', '119', 'https://uland.taobao.com/quan/detail?sellerId=2934603388&activityId=b88b01e5d4a2416b82edc7c733bd933a', '1546920250', '1');
INSERT INTO `mall_goods` VALUES ('24', '17772990', '1', '539039903778', '新款秋冬装羽绒袖打底衫拼接女修身保暖妈妈装加厚羽绒服反季清仓', '新款秋冬装羽绒袖加厚保暖妈妈装打底衫', 'https://img.alicdn.com/imgextra/i3/2508034519/TB2.5KCfS_I8KJjy0FoXXaFnVXa_!!2508034519.jpg', '169.00', '29.00', '1', '62', '720818037', '30.00', '0.00', '', '0', '秋装新时尚，双面珊瑚绒，8年老品牌，线下实体店遍布58个城市！秋装新款，细腻抓绒，双面绒双面穿，穿着更舒适！', '4279b1eb3bb54c02a3f1cf52d3dd8dbe', '140.00', '2018-12-26 23:59:59', '99930', '70', '169', 'https://uland.taobao.com/quan/detail?sellerId=720818037&activityId=4279b1eb3bb54c02a3f1cf52d3dd8dbe', '1546920250', '1');
INSERT INTO `mall_goods` VALUES ('25', '17771704', '1', '553057896190', '欧诗曼锦黑色半身裙小黑裙短裙裤裙打底裙潮不含腰带', '欧诗曼锦半身裙小黑裙短裙裤裙打底裙潮', 'https://img.alicdn.com/imgextra/i3/TB1BYrCRFXXXXXzaXXXXXXXXXXX_!!0-item_pic.jpg', '209.90', '9.90', '1', '230', '848001452', '30.00', '0.00', '', '0', '欧诗曼锦短裙，精选舒适亲肤面料，手感柔软，修身显瘦版型，不挑身材，优雅女人味，现在买超级划算。', '68d0199c4b2345498620bab4cb0f41de', '200.00', '2018-12-29 23:59:59', '98978', '1022', '209', 'https://uland.taobao.com/quan/detail?sellerId=848001452&activityId=68d0199c4b2345498620bab4cb0f41de', '1546920250', '1');
INSERT INTO `mall_goods` VALUES ('26', '17724152', '1', '567603478195', '拼蔻2018秋冬新款韩版女装针织衫打底衫中长款圆领套头百搭线衣女', '韩版时尚女装针织衫长款圆领百搭线衣女', 'https://img.alicdn.com/imgextra/i3/3878029830/O1CN012MUBnJqGSEFquaw_!!3878029830.jpg', '149.90', '24.90', '1', '735', '3878029830', '30.00', '0.00', '', '0', '精选优质面料，透气亲肤，宽松版型设计，显瘦显高，时尚气质爆款，气质优雅而不失甜美，实穿又好看！多色可选，秋季女神必备~【赠运费险】', '33816a12e5db44548e97938c5e904fbe', '125.00', '2018-12-26 23:59:59', '98599', '1401', '140', 'https://uland.taobao.com/quan/detail?sellerId=3878029830&activityId=33816a12e5db44548e97938c5e904fbe', '1546920250', '1');
INSERT INTO `mall_goods` VALUES ('27', '18009450', '6', '558519042985', '【锦食阁】俄罗斯进口紫皮混合装巧克力喜糖果500g年货零食品礼包', '【第二件半价】俄罗斯进口巧克力紫皮糖1斤', 'https://gd2.alicdn.com/imgextra/i2/2498370535/TB2Y1brXjuhSKJjSspdXXc11XXa_!!2498370535.jpg', '22.80', '17.80', '0', '492852', '2498370535', '20.00', '0.00', '', '0', '【第二件半价】多种口味可选，俄罗斯原装进口，浓浓巧克力+碎扁桃仁夹心，香浓幼滑，层层酥脆，香甜美味，每一颗都让你享受俄罗斯风情！【赠运费险】', 'f439f08805e54536bdcd984f99ec2c36', '5.00', '2019-01-09 23:59:59', '51000', '49000', '20', 'https://uland.taobao.com/quan/detail?sellerId=2498370535&activityId=f439f08805e54536bdcd984f99ec2c36', '1547084612', '1');
INSERT INTO `mall_goods` VALUES ('28', '18007416', '6', '560315534686', '笨笨狗膨化食品粗粮夹心米果 能量棒糙米卷 早餐饼干休闲零食54支', '拍3件【笨笨狗】粗粮米果能量棒54支装', 'https://img.alicdn.com/imgextra/i3/2459610361/O1CN017gLvai1EXNSjeFxQJ_!!2459610361.jpg', '22.80', '12.80', '1', '728139', '2651174814', '30.00', '0.00', '', '0', '从小吃到大的笨笨狗大品牌【第二件9.9元，第三件6元，拍3件162支，够吃仨月】月销48万，52万4.9近满分高评，9种粗粮+12种谷物精制，香浓夹心，酥脆可口，咸香美味，老少都爱吃。', 'e46196524573419a942b94fccc85a106', '10.00', '2019-01-09 23:59:59', '93000', '7000', '22', 'https://uland.taobao.com/quan/detail?sellerId=2651174814&activityId=e46196524573419a942b94fccc85a106', '1547084612', '1');
INSERT INTO `mall_goods` VALUES ('29', '18006053', '4', '560280718756', '吉登电动牙刷男女成人款家用非充电式软毛全自动防水情侣声波牙刷', '【吉登】声波电动牙刷免充电', 'https://img.alicdn.com/imgextra/i2/792165646/O1CN018XNkd41rZueyHjt6Q_!!792165646.jpg', '119.90', '9.90', '1', '775530', '2261963735', '30.00', '0.00', '', '0', '全身水洗，IPX7级防水/3档调节/智能提醒，美国杜邦刷毛，低耗能免充电，360度清洁口腔无死角，美白防蛀防口臭，送家人首选！', 'ea14853623fa4dafa39a30542986dcbb', '110.00', '2019-01-11 23:59:59', '99989', '11', '119', 'https://uland.taobao.com/quan/detail?sellerId=2261963735&activityId=ea14853623fa4dafa39a30542986dcbb', '1547084612', '1');
INSERT INTO `mall_goods` VALUES ('30', '18005763', '7', '21874571976', '新年大红塑纸节日小灯笼挂饰结婚场景布置喜庆宫灯室内春节装饰用', '【NO.1】春节大红灯笼喜庆节日装饰品', 'https://img.alicdn.com/imgextra/i3/387100192/O1CN01bM50nG1DHyX3hPvDi_!!387100192.jpg', '4.50', '3.50', '0', '1154922', '929443759', '30.00', '0.00', '', '0', '【中国商品联合会】小红灯笼挂饰，防水，抗压，防冻，室内，户外阳台，中式场景布置，新年装饰，结婚装饰，漂亮美观，缤纷色彩哦【赠运费险】', 'c6207c4f5cbb47148ee49deea46d1d34', '1.00', '2019-01-09 23:59:59', '99995', '5', '4', 'https://uland.taobao.com/quan/detail?sellerId=929443759&activityId=c6207c4f5cbb47148ee49deea46d1d34', '1547084612', '1');
INSERT INTO `mall_goods` VALUES ('31', '18004150', '6', '541089966583', '嘻螺会广西螺蛳粉柳州特产正宗螺丝粉方便面米线螺狮粉速食酸辣粉', '【买1送1】嘻螺会广西柳州特产正宗螺蛳粉', 'https://img.alicdn.com/imgextra/i2/3023094052/TB2yM7UeYtlpuFjSspfXXXLUpXa_!!3023094052.jpg', '13.26', '10.26', '1', '407746', '3023094052', '20.01', '0.00', '', '0', '精选食材，配料齐全，酸辣鲜爽，Q弹劲道，爽滑入味，健康营养，舌尖上的中国特别推荐美食，让你回味无穷，买一包送一包！', '11b11a8fcc25440d858a3daf38e15ce8', '3.00', '2019-01-12 23:59:59', '48500', '1500', '13', 'https://uland.taobao.com/quan/detail?sellerId=3023094052&activityId=11b11a8fcc25440d858a3daf38e15ce8', '1547084612', '1');
INSERT INTO `mall_goods` VALUES ('32', '18003265', '6', '535615570326', '百草味坚果大礼包1380g/8袋 过年送礼干果礼盒年货零食每日混合装', '百草味坚果大礼包1612g', 'https://img.alicdn.com/imgextra/i4/628189716/O1CN01lk9SZy2Ldyf9fV7DA_!!628189716.jpg', '78.00', '68.00', '1', '1362209', '628189716', '15.00', '0.00', '', '0', '【超值1612g礼盒装】来自百草味旗舰店的坚果组合大礼包，年味礼盒，佳节必备，精挑细选都是人气好货，颗颗坚果，饱含心意，送亲友最佳选择~【赠运费险】', '798e5d0da8b44d0588f39824ebe7527e', '10.00', '2019-01-09 23:59:59', '222000', '78000', '88', 'https://uland.taobao.com/quan/detail?sellerId=628189716&activityId=798e5d0da8b44d0588f39824ebe7527e', '1547084612', '1');
INSERT INTO `mall_goods` VALUES ('33', '18000357', '10', '535852860208', '袜子男士中筒袜长袜男袜潮纯棉冬天秋冬季加绒加厚毛巾长筒保暖袜', '秋冬款加绒加厚毛圈袜【10双】', 'https://img.alicdn.com/bao/uploaded/TB1UwSUqFooBKNjSZFPwu0a2XXa.png', '29.90', '26.90', '1', '404043', '2083262904', '20.00', '0.00', '', '0', '款式超多样，清新简约、新潮个性、商务休闲、时尚堆堆袜，男女48款可选，应有尽有！', '7009d33d7cbc44b1bc78ba74c701914d', '3.00', '2019-01-10 23:59:59', '49999', '1', '29', 'https://uland.taobao.com/quan/detail?sellerId=2083262904&activityId=7009d33d7cbc44b1bc78ba74c701914d', '1547084612', '1');
INSERT INTO `mall_goods` VALUES ('34', '17995763', '7', '521325249475', '车载手机架支架汽车车用吸盘式万能通用导航驾支撑车内车上卡扣式', '【索瑞尔】车载手机支架', 'https://img.alicdn.com/imgextra/i3/3012913363/TB2ciX4IH5YBuNjSspoXXbeNFXa_!!3012913363.jpg', '18.00', '8.00', '1', '341704', '475437642', '30.10', '0.00', '', '0', '18倍稳固超强吸力，无损安装，360°旋转，可用于仪表盘，出风口各种场景，车载家用均可，让你解放双手安全出行～', '9132154451c44b64bbce1b703157366b', '10.00', '2019-01-10 23:59:59', '99000', '1000', '18', 'https://uland.taobao.com/quan/detail?sellerId=475437642&activityId=9132154451c44b64bbce1b703157366b', '1547084612', '1');
INSERT INTO `mall_goods` VALUES ('35', '18000088', '8', '568240400765', 'iPhone6数据线苹果6s充电线器5s手机7Plus加长5快充se单头8X短iphonex冲电P平板电脑适用ipad原裝正品古尚古', '2条装古尚古苹果原装正品数据线', 'https://img.alicdn.com/imgextra/i3/2077109539/TB2mZ60uKuSBuNjSsziXXbq8pXa_!!2077109539.jpg', '24.00', '14.00', '1', '382675', '2077109539', '30.00', '0.00', '', '0', '进口芯片，天猫正品，提速50%，闪电快充实力派，充电传输两不误，激活电池更耐用，黑科技不忘粗芯，只能快充，不伤机，数据线中的精品贵族', '7d152f6f1fea4cf99cafadf4fa93019a', '10.00', '2019-01-14 23:59:59', '97000', '3000', '24', 'https://uland.taobao.com/quan/detail?sellerId=2077109539&activityId=7d152f6f1fea4cf99cafadf4fa93019a', '1547084612', '1');
INSERT INTO `mall_goods` VALUES ('36', '17991042', '4', '524630951876', '口罩一次性透气男女秋冬可爱个性女神韩版黑潮薄款防晒50只装加厚', '爆售666万盒【买2送1】口罩加厚50只', 'https://img.alicdn.com/imgextra/i2/116043003/O1CN011Y3PqDlUvkXWnYO_!!116043003.jpg', '6.10', '5.10', '0', '330951', '116043003', '21.01', '0.00', '', '0', '血亏玩命抢！！迎新大促，全网领军【爆售666万盒+100万好评】10年专注防护品牌，品质保证，销量证明一切，全新无纺布！透气无异味，3mm弹力耳带，双筋记忆鼻梁条，高效过滤，精选之作！', '71be8615ffae40b78470265165da3720', '1.00', '2019-01-09 23:59:59', '95000', '5000', '6', 'https://uland.taobao.com/quan/detail?sellerId=116043003&activityId=71be8615ffae40b78470265165da3720', '1547084612', '1');
INSERT INTO `mall_goods` VALUES ('37', '17988626', '6', '581353384372', '红心柚子10斤大果当季新鲜孕妇水果现摘现发福建琯溪平和红肉蜜柚', '福建琯溪红柚10斤现摘', '//img.alicdn.com/imgextra/i2/4021294429/O1CN01Kmn9Y41iaWeKL1pHn_!!4021294429.jpg', '26.80', '16.80', '1', '420563', '4021294429', '20.01', '0.00', '', '0', '清新爽口，新鲜现摘现发，叶酸天堂，含多种维生素C，氨基酸，孕期佳品，柚子太好吃了！又大又甜！皮薄肉多~【坏果包赔】', '46cdf4461aa340b79b4855319948e9cd', '10.00', '2019-01-10 23:59:59', '82000', '18000', '25', 'https://uland.taobao.com/quan/detail?sellerId=4021294429&activityId=46cdf4461aa340b79b4855319948e9cd', '1547084612', '1');
INSERT INTO `mall_goods` VALUES ('38', '17986359', '4', '19136892670', '羽绒服干洗剂免水洗家用衣物清洗喷雾去污渍油渍衣服免洗清洁神器', '【买1份送毛巾+刷子】羽绒服去污干洗剂', 'https://img.alicdn.com/imgextra/i3/849441921/O1CN011Q3rJEA6dc3lYI3_!!849441921.jpg', '19.80', '14.80', '1', '387249', '849441921', '20.00', '0.00', '', '0', '券后【14.8元】包邮秒杀！买1份送毛巾+刷子\r\n【推荐理由】绒服泡沫干洗剂，快速浓缩型，可挤出2000ml泡沫，去污提升不伤衣，自制喷头设计，轻轻一喷洁净如新，可谓是冬天必备！拍下不允许改地址', '3df363717abe47f6b76bcccb07cc945f', '5.00', '2019-01-10 23:59:59', '77000', '23000', '14', 'https://uland.taobao.com/quan/detail?sellerId=849441921&activityId=3df363717abe47f6b76bcccb07cc945f', '1547084612', '1');
INSERT INTO `mall_goods` VALUES ('39', '17986008', '4', '575067356395', '口罩一次性防尘透气雾霾易呼吸男女秋冬季加厚防晒50只装女神黑', '网红代盐！防雾霾透气口罩50只/盒', 'https://img.alicdn.com/imgextra/i3/717309111/O1CN01dSSies2HAt2PNME7I_!!717309111.jpg', '6.10', '5.10', '1', '360086', '3077220568', '20.00', '0.00', '', '0', '【真正滴~全网口罩销量冠军】优选医用级无纺布！【50只/1盒】3D裁剪の舒适不勒耳设计，高效过滤~防霾透气精选之作！防尘透气，多层净化，透气舒适，多色可选，炫彩出行！【警惕高仿品，认准天猫旗舰店】', '3d12f42edc874a8aad8c649928e7b8bf', '1.00', '2019-01-12 23:59:59', '58674', '7992', '6', 'https://uland.taobao.com/quan/detail?sellerId=3077220568&activityId=3d12f42edc874a8aad8c649928e7b8bf', '1547084612', '1');
INSERT INTO `mall_goods` VALUES ('40', '17985951', '4', '579837973670', '张记垃圾袋家用加厚一次性宿舍黑色手提背心式拉圾塑料袋中号大号', '5卷100只【加厚抗撕拉】垃圾袋', 'https://img.alicdn.com/imgextra/i3/721690846/O1CN01zY3Fhi1I7VYuCpAPi_!!721690846.jpg', '6.90', '5.90', '1', '339576', '4217952040', '30.00', '0.00', '', '0', '高强度，可承重20斤，质地厚实，抗拉伸，超强韧性，材质环保安全，绚烂彩色跟黑色可选，居家必备！', '0c674e4c7bf64da3acd372e1505caa07', '1.00', '2019-01-10 23:59:59', '90000', '10000', '6', 'https://uland.taobao.com/quan/detail?sellerId=4217952040&activityId=0c674e4c7bf64da3acd372e1505caa07', '1547084612', '1');
INSERT INTO `mall_goods` VALUES ('41', '17984028', '4', '42140606741', '靓涤加厚垃圾袋家用一次性批发黑色手提背心式厨房塑料袋中大号', '【靓涤】加厚卷装垃圾袋10卷200只', 'https://img.alicdn.com/imgextra/i4/527252170/TB2rD0EsVXXXXcTXpXXXXXXXXXX_!!527252170.jpg', '12.80', '10.80', '1', '361569', '527252170', '20.00', '0.00', '', '0', '靓涤10卷（共200只）精选新料，环保无异味，光泽度好，韧性十足，加大加厚不漏水，承重可达20斤，断点设计，方便快捷，超实用，居家必备~', '9cf031f23e404c6eba5606c9aaac4419', '2.00', '2019-01-09 23:59:59', '10000', '10000', '12', 'https://uland.taobao.com/quan/detail?sellerId=527252170&activityId=9cf031f23e404c6eba5606c9aaac4419', '1547084612', '1');
INSERT INTO `mall_goods` VALUES ('42', '17984681', '3', '577650594133', 'Miss face玻尿酸原液正品保湿补水面部精华液女紧致修复肌底液', 'missface玻尿酸补水保湿原液', 'https://img.alicdn.com/imgextra/i2/651729294/O1CN01jXW9fD2IWhWigqEkf_!!651729294.jpg', '129.90', '19.90', '1', '336657', '1029624918', '30.00', '0.00', '', '0', 'missface旗舰店玻尿酸补水保湿原液。专柜均有在售，由法国著名嘉法狮提供的原料及配方更值得信赖！补水保湿，淡化细纹，一步到位，让你的肌肤弹润嫩。重返18岁！', 'f4f0161ebcc64df49b3af947c00107c8', '110.00', '2019-01-09 23:59:59', '69000', '31000', '129', 'https://uland.taobao.com/quan/detail?sellerId=1029624918&activityId=f4f0161ebcc64df49b3af947c00107c8', '1547084612', '1');
INSERT INTO `mall_goods` VALUES ('43', '17977883', '4', '576259193520', '缘点卷纸批发本色14卷家用卫生纸家庭装手纸厕纸卷筒纸巾实惠装', '拍2份27.2元 本色卷纸送8包共36卷', 'https://img.alicdn.com/imgextra/i1/279515528/O1CN01XA2Qr61qhrwLSqmR3_!!279515528.jpg', '30.20', '27.20', '1', '983934', '3246773875', '20.00', '0.00', '', '0', '【拍2份在送8卷，共36券】月销139万+，可以吃的原生木浆纸、少了添加，多了安心，高温处理、密韧纤维，湿水不破，竹琨抑菌，居家生活必备的，趁活动速抢！', '13208f9e8b8349eba55a2e7234c8bf73', '3.00', '2019-01-08 23:59:59', '37500', '12500', '30', 'https://uland.taobao.com/quan/detail?sellerId=3246773875&activityId=13208f9e8b8349eba55a2e7234c8bf73', '1547084612', '1');
INSERT INTO `mall_goods` VALUES ('44', '17971366', '2', '559680679226', '碧c婴儿湿巾纸巾婴幼儿新生宝宝手口屁专用80抽5包大包装特价家用', '【碧C】手口屁专用湿巾80抽*5包', 'https://img.alicdn.com/imgextra/i1/3087060159/TB2ydpoe6ihSKJjy0FlXXadEXXa_!!3087060159.jpg', '18.90', '13.90', '1', '336045', '3087060159', '20.00', '0.00', '', '0', '【全网热销碧C大品牌】源自英国，亲肤柔棉，无荧光无香精，温和水润，抑菌洁净，安全到可以“吃”的湿巾，全网热销~！', '572e20f4dd0a4cb49a5765ba5465dc9a', '5.00', '2019-01-11 23:59:59', '78000', '22000', '18', 'https://uland.taobao.com/quan/detail?sellerId=3087060159&activityId=572e20f4dd0a4cb49a5765ba5465dc9a', '1547084612', '1');
INSERT INTO `mall_goods` VALUES ('45', '17965563', '4', '580794557704', '好吉利卫生纸批发16卷纸巾家用厕纸实惠家庭装整箱无芯厕所卷筒纸', '新券【好吉利】本色无芯卷纸16卷', 'https://img.alicdn.com/imgextra/i4/3087155153/O1CN011nw7OkTejCltV8h_!!3087155153.jpg', '15.10', '12.10', '1', '359007', '3087155153', '20.00', '0.00', '', '0', '一提16卷，福建知名品牌！精选原生竹浆！不漂白无光，湿水不易破，柔韧厚实，无屑无渣，母婴皆可用！', '6f2f2e32076a48f2a60922dd4476688b', '3.00', '2019-01-11 23:59:59', '30000', '30000', '15', 'https://uland.taobao.com/quan/detail?sellerId=3087155153&activityId=6f2f2e32076a48f2a60922dd4476688b', '1547084612', '1');
INSERT INTO `mall_goods` VALUES ('46', '17954494', '7', '15913177712', '洗照片包邮 塑封送相册3/4/5/6寸照片冲印打印冲洗相片手机照晒刷', '100张【洗照片】冲洗相片手机照片', 'https://gd1.alicdn.com/imgextra/i1/842047185/O1CN01GgfFsl22wmDYhc4HK_!!842047185.jpg', '11.00', '8.00', '0', '513655', '842047185', '20.00', '0.00', '', '0', '【满11-3】100张仅8元！包邮高清冲印，色彩艳丽，长时间保存不易褪色，定格美好，记录点滴，留不住时间，但是我们能定格美好的瞬间！', '2d74f4d5b09b4339a2ba757c4076ea84', '3.00', '2019-01-10 23:59:59', '15000', '5000', '11', 'https://uland.taobao.com/quan/detail?sellerId=842047185&activityId=2d74f4d5b09b4339a2ba757c4076ea84', '1547084612', '1');
INSERT INTO `mall_goods` VALUES ('47', '18006987', '9', '577476306584', '棉衣男潮棉袄男2018新款冬装男冬天外套男羽绒棉服男中长款冬季', '冬季加厚中长款修身棉衣羽绒棉服', 'https://img.alicdn.com/imgextra/i4/1974914404/TB2KkPPbQzoK1RjSZFlXXai4VXa_!!1974914404-0-item_pic.jpg', '298.00', '168.00', '1', '38579', '1974914404', '20.00', '0.00', '', '0', '继续疯抢！！火到爆炸的款，时尚界永远不过时的经典。精选优质面料，好到连一条多余的线条都没有！超级百搭，彰显优雅气质，中长款棉服，保暖舒适，防风防寒，显高显瘦，时尚感爆棚，迷倒无数小姐姐！', '0f6e7d612293455abe4521e805427492', '130.00', '2019-01-10 23:59:59', '89000', '11000', '298', 'https://uland.taobao.com/quan/detail?sellerId=1974914404&activityId=0f6e7d612293455abe4521e805427492', '1547084757', '1');
INSERT INTO `mall_goods` VALUES ('48', '17997078', '9', '577929472014', '加绒运动裤男秋冬款宽松加厚卫裤收口束脚裤子男韩版潮流休闲小脚', '秋冬男士加绒加厚运动裤休闲束脚裤', 'https://img.alicdn.com/imgextra/i3/2989423074/TB244w8cYrpK1RjSZTEXXcWAVXa_!!2989423074-0-item_pic.jpg', '79.00', '39.00', '1', '49256', '2989423074', '20.00', '0.00', '', '0', '为自由而生，舒适面料属性，棉弹舒适面料，精湛的技术，缔造品质舒适面料，用舒适的面料，做透气的裤子，立体裁剪质感体现，量身定制般舒适享受，时尚的H版型，显瘦显高，彰显男士魅力！', 'e8ac36b3620f4ce8acf97c6226ac1930', '40.00', '2019-01-15 23:59:59', '99000', '1000', '79', 'https://uland.taobao.com/quan/detail?sellerId=2989423074&activityId=e8ac36b3620f4ce8acf97c6226ac1930', '1547084757', '1');
INSERT INTO `mall_goods` VALUES ('49', '17994819', '9', '577094468204', '秋冬季男士长袖加绒加厚保暖衬衫男修身格子印花商务休闲男装衬衣', '【升级黄金绒】加绒加厚休闲保暖衬衫', 'https://img.alicdn.com/imgextra/i4/914963957/O1CN011f6LhXAci6l39eI_!!914963957.jpg', '49.80', '24.80', '1', '101999', '914963957', '30.00', '0.00', '', '0', '【30款颜色可选】！专注衬衫生产20年，品质保障，升级版黄金绒！一件抵三件，复合一体面料，面料柔软，360°全方位保暖，加绒加厚双层呵护，天冷就不是这个价啦！速度抢！【送运费险】', '6f34c375e4d34be6b28ba1e1f4f777b9', '25.00', '2019-01-11 23:59:59', '85000', '15000', '48', 'https://uland.taobao.com/quan/detail?sellerId=914963957&activityId=6f34c375e4d34be6b28ba1e1f4f777b9', '1547084757', '1');
INSERT INTO `mall_goods` VALUES ('50', '17998234', '9', '44162259823', '牧鹿男士保暖衬衫男长袖格子加绒加厚修身秋冬季中年衬衣寸衫男装', '【价格至低】加厚加绒保暖衬衫男装衬衣', 'https://img.alicdn.com/imgextra/i2/192579350/O1CN01O72cQ12IwLhFGcenX_!!192579350.jpg', '59.90', '39.90', '1', '37201', '1743363291', '30.00', '0.00', '', '0', '爆卖88万件，足厚足暖钻石绒，360°全身加绒，高密度防风面料，隔绝冷空气，抗皱舒适亲肤，修身显瘦，有温度有风度【M~5XL，多款可选】', 'd5130ea55ed143f892a23e3aead4211d', '20.00', '2019-01-14 23:59:59', '99000', '1000', '59', 'https://uland.taobao.com/quan/detail?sellerId=1743363291&activityId=d5130ea55ed143f892a23e3aead4211d', '1547084757', '1');
INSERT INTO `mall_goods` VALUES ('51', '17977858', '9', '576836912806', '雅鹿秋冬季格子保暖衬衫男加绒加厚男士宽松青年修身中年长袖衬衣', '【雅鹿大牌】加绒加厚格子保暖衬衫', 'https://img.alicdn.com/imgextra/i3/192579350/O1CN01FosZbx2IwLhFFt4MT_!!192579350.jpg', '69.90', '49.90', '1', '44839', '192579350', '20.00', '0.00', '', '0', '专柜同款，大牌雅鹿，十几种款式，加绒加厚内里，一体绒成型技术，37°C恒温保暖，微弹贴身显瘦，胜任各种身材，男人穿出去有面子！【赠运费险', '8c823b28cd914783b2691614f353c22b', '20.00', '2019-01-12 23:59:59', '84000', '16000', '59', 'https://uland.taobao.com/quan/detail?sellerId=192579350&activityId=8c823b28cd914783b2691614f353c22b', '1547084757', '1');
INSERT INTO `mall_goods` VALUES ('52', '17976586', '9', '578222919085', '秋冬加绒牛仔裤男宽松直筒休闲弹力大码冬季保暖加厚男士长裤子', '冬季加绒加厚 弹力牛仔裤男', 'https://img.alicdn.com/imgextra/i3/1741450787/O1CN01r2AoKw1HgUBhMxYBU_!!1741450787.jpg', '169.00', '59.00', '0', '53284', '1741450787', '21.00', '0.00', '', '0', '推荐柔和厚实海岛绒，加厚保暖，为您的体温+5°C。弹力舒适不紧绷。不臃肿。专注细节制作，简约时尚，潮流百搭，放心购买。【赠运费险】', '1a6e5c1707a847b4a1e923cb1f6d0872', '110.00', '2019-01-12 23:59:59', '82000', '18000', '150', 'https://uland.taobao.com/quan/detail?sellerId=1741450787&activityId=1a6e5c1707a847b4a1e923cb1f6d0872', '1547084757', '1');
INSERT INTO `mall_goods` VALUES ('53', '17973896', '9', '573452754314', '秋冬季运动裤男士休闲裤加绒加厚宽松裤子男韩版潮流束脚裤哈伦裤', '超值两件装~韩版百搭休闲哈伦裤', 'https://img.alicdn.com/imgextra/i1/3820966635/TB2ezH1DuGSBuNjSspbXXciipXa_!!3820966635-0-item_pic.jpg', '69.00', '59.00', '1', '121486', '3820966635', '20.00', '0.00', '', '0', '【类目NO.1】【18W的评价，4.8的高评分你还有见过比这个更skr的裤子吗？】免费试穿~30天无理由退换~优质弹力面料！不起球不变形【赠运费险】', '745b08eea9e44987866b7dfdc628f998', '10.00', '2019-01-08 23:59:59', '82000', '18000', '60', 'https://uland.taobao.com/quan/detail?sellerId=3820966635&activityId=745b08eea9e44987866b7dfdc628f998', '1547084757', '1');
INSERT INTO `mall_goods` VALUES ('54', '17964643', '9', '576904357385', '雅鹿秋冬季男士毛衣韩版加绒加厚保暖针织衫线衣高领毛衫打底衫潮', '【雅鹿大牌】加绒加厚毛衣针织衫男', 'https://img.alicdn.com/imgextra/i1/192579350/O1CN01ykxuHC2IwLhGaOFdX_!!192579350.jpg', '59.90', '39.90', '1', '81356', '192579350', '20.00', '0.00', '', '0', '【已疯抢160000+，L~5XL全尺码，十几种款式】升级加厚240g保暖绒，超细腻亲肤，保暖到你无法想象，马上就要大幅度降温，抓紧备上【赠运费险】', '8c823b28cd914783b2691614f353c22b', '20.00', '2019-01-12 23:59:59', '84000', '16000', '59', 'https://uland.taobao.com/quan/detail?sellerId=192579350&activityId=8c823b28cd914783b2691614f353c22b', '1547084757', '1');
INSERT INTO `mall_goods` VALUES ('55', '17963875', '9', '583441671018', '新款冬季时尚棉衣男士棉服外套韩版修身潮流帅气短款男装羽绒棉袄', '莱克茜冬季男士羽绒棉衣外套潮', 'https://img.alicdn.com/imgextra/i3/2241544189/O1CN01DeK37s1gobbHqjwTe_!!0-item_pic.jpg', '1080.00', '380.00', '1', '47422', '2241544189', '20.00', '0.00', '', '0', '【lakecy莱克茜】舒适保暖，时尚潮流，多色可选，做工精细，商务休闲，彰显奢华【赠运费险】', 'a4a54d3f00534c15813de1e09825c4c8', '700.00', '2019-01-11 23:59:59', '7128', '1760', '710', 'https://uland.taobao.com/quan/detail?sellerId=2241544189&activityId=a4a54d3f00534c15813de1e09825c4c8', '1547084757', '1');
INSERT INTO `mall_goods` VALUES ('56', '17993785', '3', '579538364771', 'ARR丝绒口红女学生持久保湿防水不脱色唇膏斩男色【秋冬定制款】', '漏冻~拍5件！臻致凝彩丝绒口红5支', 'https://img.alicdn.com/imgextra/i4/1882809736/O1CN01rwgDKK2Ln8aJAKUxO_!!1882809736.jpg', '199.50', '29.50', '1', '175605', '3703659349', '40.00', '0.00', '', '0', '【漏冻！！拍5件！第2，第3，第4，第5支，0元抢】快！！快！！\r\narr臻致丝绒口红，6色可选，持久保湿，防水不易脱色，不易沾杯，提升气质，显色撩人，完美女神值得拥有~【赠运费险】', 'c54745d7a84144a2a6e242cdbc786270', '170.00', '2019-01-10 23:59:59', '91000', '9000', '199', 'https://uland.taobao.com/quan/detail?sellerId=3703659349&activityId=c54745d7a84144a2a6e242cdbc786270', '1547085165', '1');
INSERT INTO `mall_goods` VALUES ('57', '17999018', '3', '562288923947', '[3瓶11.6元]美甲指甲油可剥无毒持久可撕拉套装快干组合12色非胶', '拍3瓶9.6元~无毒可撕拉指甲油美甲油', 'https://img.alicdn.com/imgextra/i1/806509182/O1CN012HhP8QL7VwKfy8z_!!806509182.jpg', '5.80', '3.80', '1', '168207', '896610243', '30.00', '0.00', '', '0', '【拍3瓶9.6元~买就送指甲锉+分指器+香包】采用树脂原料，安全无毒，孕妇宝妈都可用，轻松卸一剥即可，60秒快干，40种颜色可选，16.7万+销量，63万+好评，天猫最底价~速度抢购！！！', 'da1bbc0b72934d36b207a90304a8f395', '2.00', '2019-01-10 23:59:59', '29100', '900', '5', 'https://uland.taobao.com/quan/detail?sellerId=896610243&activityId=da1bbc0b72934d36b207a90304a8f395', '1547085165', '1');
INSERT INTO `mall_goods` VALUES ('58', '17983908', '3', '577471844282', '气垫bb霜网红cc棒水光遮瑕保湿隔离光感男女提亮肤色粉底液送美白', '韩婵气垫bb霜爆款网红水光遮瑕保湿', 'https://img.alicdn.com/imgextra/i4/3091470685/O1CN01yitjyM1GvlnDgtTHN_!!3091470685.jpg', '59.90', '9.90', '1', '214639', '3121904393', '20.00', '0.00', '', '0', '【月销27万件~超人气爆款】《美丽俏佳人》力荐，全新升级，富含多种保湿护肤成分，更遮瑕巨保湿，持久水润服帖不脱妆裸妆无死角。赶快选购吧！', '52c0d920fdf5437a8a532adddef33eba', '50.00', '2019-01-09 23:59:59', '28000', '22000', '59', 'https://uland.taobao.com/quan/detail?sellerId=3121904393&activityId=52c0d920fdf5437a8a532adddef33eba', '1547085165', '1');
INSERT INTO `mall_goods` VALUES ('59', '17958587', '3', '17650469914', '南美姿色纯棉一次性洗脸巾女美容院洗面巾纸卸妆洁面巾毛巾化妆棉', '【双金冠店铺】超大卷-纯棉断点式洁面巾', 'https://gd3.alicdn.com/imgextra/i3/390540205/TB21n1_i8nTBKNjSZPfXXbf1XXa_!!390540205.jpg', '8.50', '7.50', '0', '184996', '390540205', '20.00', '0.00', '', '0', '爆款返场！！【双金冠店铺，累计销量180万+】超大卷-全棉柔软防过敏，不掉屑不变形，抽取式更加便捷卫生，纯天然无刺激宝宝也适用哦~', 'eee6cc83d39441738a4f570b1448c3f9', '1.00', '2019-01-11 23:59:59', '25500', '4500', '8', 'https://uland.taobao.com/quan/detail?sellerId=390540205&activityId=eee6cc83d39441738a4f570b1448c3f9', '1547085165', '1');
INSERT INTO `mall_goods` VALUES ('60', '18008756', '3', '576841533146', '组合装玫瑰滋润口红持久不易脱色豆沙色西柚色哑光唇膏唇彩咬唇妆', '玫倩莱 玫瑰滋润天然口红', 'https://img.alicdn.com/imgextra/i2/3393205475/O1CN011qJauphoPYgA1B9_!!3393205475.jpg', '159.99', '9.99', '1', '158672', '2835082096', '30.00', '0.00', '', '0', '独有的玫瑰花提取物，天然成分，安全到孕妈咪都可以用。丝滑细腻质地，滋润度满分，显色度高，持久不沾杯，轻松勾勒魅惑双唇~涂上特别有气场，女王范十足~还有3支的礼盒装，送女友和闺蜜也很不错~', '1ab6e836e3524bec9cac91aec7ba3eca', '150.00', '2019-01-10 23:59:59', '98000', '2000', '159', 'https://uland.taobao.com/quan/detail?sellerId=2835082096&activityId=1ab6e836e3524bec9cac91aec7ba3eca', '1547091997', '1');
INSERT INTO `mall_goods` VALUES ('61', '17970307', '3', '44274260607', '美宝莲巨遮瑕BB霜 巨柔雾巨光感持久滋润保湿裸妆粉底液隔离霜', '美宝莲旗舰店 巨遮瑕BB霜', 'https://img.alicdn.com/bao/uploaded/TB14vqIjMHqK1RjSZFkXXX.WFXa.png', '109.00', '79.00', '1', '12053', '743750137', '25.00', '0.00', '', '0', '【送fitme粉底液5ml随机色，手快整点有赠品，页面为准】天猫旗舰店100%正品！全新升级，添加高遮瑕成分，轻薄服帖+妆感自然+巨强遮瑕力，打造自然光感美肌！【赠运费险+过敏包退】专柜119元', '6c6444e05ed44942852e0aaf40baaf3f', '30.00', '2019-01-10 23:59:59', '52500', '97500', '109', 'https://uland.taobao.com/quan/detail?sellerId=743750137&activityId=6c6444e05ed44942852e0aaf40baaf3f', '1547092077', '1');
INSERT INTO `mall_goods` VALUES ('62', '17992374', '3', '585187943342', '珈蓝之谜B系列知否同款 萝卜丁女王权杖口红持久护唇滋润易上色', '【买一送一】珈蓝之谜B系列口红', 'https://img.alicdn.com/imgextra/i1/1603372607/O1CN01ESq5L71V832FeFR1y_!!1603372607.jpg', '549.90', '29.90', '1', '39708', '2200581173471', '20.00', '0.00', '', '0', '【口红界的“劳斯莱斯”】《知否》电视剧~明兰同款，6款潮流唇色，重新定义高端时尚彩妆，丝滑柔润质感，保湿润泽，显色靓丽，一抹性感魅惑，尽现女王风采【随机赠送一支，共两支】', '842a5a5f1e0f495e9e087801b47e1178', '520.00', '2019-01-08 23:59:59', '43000', '57000', '530', 'https://uland.taobao.com/quan/detail?sellerId=2200581173471&activityId=842a5a5f1e0f495e9e087801b47e1178', '1547092077', '1');
INSERT INTO `mall_goods` VALUES ('63', '17980743', '3', '578243377318', '佰草世家素颜面霜正品 女男士保湿补水学生裸妆遮瑕 送美白护肤品', '佰草世家2瓶素颜霜', 'https://img.alicdn.com/imgextra/i4/1055530397/O1CN011EnrhQtZr6fvljy_!!1055530397-0-item_pic.jpg', '46.00', '6.00', '1', '158538', '1055530397', '50.00', '0.00', '', '0', '超级强大的多功能懒人霜！一瓶顶替bb霜、脸霜，还能全身防护，当美白润肤身体乳用！\r\n提亮肤色，代替底妆，补水保湿，代替面霜，懒得卸妆，就用素颜霜。', '12ef542eae6247319f809e9697b10abe', '40.00', '2019-01-10 23:59:59', '18000', '82000', '41', 'https://uland.taobao.com/quan/detail?sellerId=1055530397&activityId=12ef542eae6247319f809e9697b10abe', '1547092077', '1');
INSERT INTO `mall_goods` VALUES ('64', '17997206', '3', '563058625805', '化妆刷套装初学者套刷化妆工具全套眼影刷眉刷散粉刷腮红刷刷子', '【卓尔雅】初学者化妆套刷工具7支', '//img.alicdn.com/imgextra/i2/784497909/TB26ln6aOjQBKNjSZFnXXa_DpXa_!!784497909.jpg', '19.90', '9.90', '1', '33380', '784497909', '0.00', '20.00', '', '0', '7支化妆刷便携套装，刷毛丰富，触感柔软，不刺激，不易掉毛，加厚铝管，耐用耐磨，原木手柄，手感舒适，小巧便于携带，多种颜色可选，限时特惠！', '62a25ed6d35244489f6b712bd2bc35c9', '10.00', '2019-01-08 23:59:59', '40200', '19800', '19', 'https://uland.taobao.com/quan/detail?sellerId=784497909&activityId=62a25ed6d35244489f6b712bd2bc35c9', '1547092085', '1');
INSERT INTO `mall_goods` VALUES ('65', '17998544', '9', '576646058124', '棉衣男士加厚外套冬季2018新款冬装羽绒棉服韩版短款棉袄潮流男装', '超帅！冬季韩版加厚棉衣外套', '//img.alicdn.com/imgextra/i3/1588802848/O1CN01NiYskb1WuQUHOd8Uc_!!1588802848.jpg', '79.90', '29.90', '1', '26542', '1588802848', '30.00', '0.00', '', '0', '质量好！版型好！无敌的价格！韩版修身款型，年轻又时尚，万年百搭色！多色多款任意选，现在买正好穿~必须定换号抢！换号抢！', '3519747a3dea40a6bb1de10aef571fcd', '50.00', '2019-01-10 23:59:59', '62000', '38000', '79', 'https://uland.taobao.com/quan/detail?sellerId=1588802848&activityId=3519747a3dea40a6bb1de10aef571fcd', '1547092918', '1');
INSERT INTO `mall_goods` VALUES ('66', '17995792', '9', '579117041834', '羽绒服男士加厚中长款时尚潮流2018冬季新款学生帅气韩版男装外套', '【佐努】青年男中长款连帽羽绒服', '//img.alicdn.com/imgextra/i3/2261867204/O1CN01235Tihsa4YcumiF_!!2261867204.jpg', '699.00', '129.00', '1', '10420', '2957472451', '30.00', '0.00', '', '0', '爆款羽绒服！冬天一件足够温暖，齐膝中长款，帅气值5星，优质白鸭绒填充，舒适保暖，3D定制防绒内胆，严密缝合，价格实惠，买到赚到，赠送运费险。', '937d321fd120450487ce192bd8878e0a', '570.00', '2019-01-10 23:59:59', '66000', '34000', '640', 'https://uland.taobao.com/quan/detail?sellerId=2957472451&activityId=937d321fd120450487ce192bd8878e0a', '1547092918', '1');
INSERT INTO `mall_goods` VALUES ('67', '17985630', '9', '584966213234', '【厂家直销】秋冬高领毛衣男士羊毛衫宽松大码毛衣套头针织打底衫', '【羊毛含量40%】男士高领羊毛衫', 'https://img.alicdn.com/imgextra/i1/4017813583/O1CN01V1ra181cL3aomA57U_!!0-item_pic.jpg', '199.00', '69.00', '1', '16913', '4017813583', '30.00', '0.00', '', '0', '【亏本走量】高质量羊毛衫！我们不比价格，我们比质量，羊毛含量高，手感舒适，贴身穿不扎，限领限购！！赶紧抢！！品质好货~', '4f7072aa48224633bcfa4bb8df36802d', '130.00', '2019-01-08 23:59:59', '73000', '27000', '199', 'https://uland.taobao.com/quan/detail?sellerId=4017813583&activityId=4f7072aa48224633bcfa4bb8df36802d', '1547092918', '1');
INSERT INTO `mall_goods` VALUES ('68', '17977949', '9', '583663417704', '过膝长款加厚白鸭绒羽绒服男连帽2018冬季新款韩版修身帅气外套', '青年男中长款连帽羽绒服', 'https://img.alicdn.com/imgextra/i1/3695661607/O1CN01V2eWFv1Nk2xfWYmA3_!!0-item_pic.jpg', '1128.00', '128.00', '1', '24543', '3695661607', '30.00', '0.00', '', '0', '【热销爆款】优质白鸭绒，时尚界永远不过时的经典。精选优质面料，超级百搭，时尚设计，彰显优雅气质，中长款羽绒服，保暖舒适，防风防寒，显高显瘦，时尚感爆棚，迷倒无数小姐姐！', '06d214fa7bd647ebac033c64b9b0913e', '1000.00', '2019-01-09 23:59:59', '59000', '41000', '1128', 'https://uland.taobao.com/quan/detail?sellerId=3695661607&activityId=06d214fa7bd647ebac033c64b9b0913e', '1547092918', '1');
INSERT INTO `mall_goods` VALUES ('69', '17978330', '9', '583550125440', '白鸭绒羽绒服男可脱卸帽短款2018新款冬季加厚青少年修身潮流外套', '短款白鸭绒修身羽绒服男女', '//img.alicdn.com/imgextra/i3/2957472451/O1CN01SDaint1TybFGcZh3Q_!!2957472451.jpg', '649.00', '79.00', '1', '15217', '2957472451', '30.00', '0.00', '', '0', '【佐努轻盈】保暖羽绒，铂金级白鸭绒，高蓬速防寒，轻暖易携带，轻盈又保暖，情侣出行旅游非常合适，赠送运费险！', '937d321fd120450487ce192bd8878e0a', '570.00', '2019-01-10 23:59:59', '66000', '34000', '640', 'https://uland.taobao.com/quan/detail?sellerId=2957472451&activityId=937d321fd120450487ce192bd8878e0a', '1547092918', '1');
INSERT INTO `mall_goods` VALUES ('70', '17969692', '9', '537216986919', '骆驼男装 羽绒服男短款修身男士冬季收口袖外套 白鸭绒轻薄羽绒衣', '假一赔十！【骆驼男装】超暖轻尚修身羽绒衣', 'https://img.alicdn.com/imgextra/i2/2051040164/O1CN01LrZkyu1D59RjikTNs_!!2051040164.jpg', '258.00', '158.00', '1', '29924', '839919086', '20.00', '0.00', '', '0', '顶级大牌【骆驼轻盈】时尚帅气保暖羽绒，铂金级白鸭绒，高蓬速防寒，轻暖易携带，轻盈又保暖！【有任何问题找客服60天包退换】', 'd281f24a0e754463bb0cf447ba44616e', '100.00', '2019-01-09 23:59:59', '16500', '33500', '258', 'https://uland.taobao.com/quan/detail?sellerId=839919086&activityId=d281f24a0e754463bb0cf447ba44616e', '1547092918', '1');
INSERT INTO `mall_goods` VALUES ('71', '17969276', '9', '557590347635', '森马企业店港风牛仔裤男冬季休闲潮男士韩版帅气青少年', '【森马官方店】男士冬季新款休闲牛仔裤', 'https://gd3.alicdn.com/imgextra/i3/2775671785/O1CN01eRmacd1P3ZSudPra9_!!2775671785.jpg', '129.90', '29.90', '0', '8412', '2775671785', '25.00', '0.00', '', '0', '【爆款来袭】2W多好评的牛仔裤！！100元券速度撸！精选优等纯棉牛仔面料~精工细作，每一处细节都无可挑剔！高品质牛仔，必有一款适合您！', 'e3ac9ff0bd3f4d9d913cc1bb98beca66', '100.00', '2019-01-09 23:59:59', '102000', '48000', '129', 'https://uland.taobao.com/quan/detail?sellerId=2775671785&activityId=e3ac9ff0bd3f4d9d913cc1bb98beca66', '1547092918', '1');
INSERT INTO `mall_goods` VALUES ('72', '17966911', '9', '574728164427', '金丝绒裤男冬季加绒加厚韩版潮流青年休闲运动裤束脚长裤哈伦卫裤', '【加绒加厚】秋冬男士金丝绒休闲束脚裤', 'https://img.alicdn.com/imgextra/i4/792241300/O1CN01kpK1kh1LTRNPxjeml-792241300.jpg', '59.00', '39.00', '1', '4378', '3945569134', '30.00', '0.00', '', '0', '高密高织保暖抗寒面料，时尚保暖。为自由而生，立体裁剪，修身不臃肿。舒适加绒内里，冬天也有温暖般的享受~冬季也可以有风度有温度！', '1df4429fe04e4097ac5e3c36a0d1ccc0', '20.00', '2019-01-09 23:59:59', '68398', '31602', '39', 'https://uland.taobao.com/quan/detail?sellerId=3945569134&activityId=1df4429fe04e4097ac5e3c36a0d1ccc0', '1547092918', '1');
INSERT INTO `mall_goods` VALUES ('73', '18010503', '7', '580531118055', '2018新款手机投影仪一体机大眼橙V8家用办公小型wifi无线3D家庭影院便携式高清1080p投影机4K智能无屏电视K歌', '大眼橙办公家用手机3D高清投影仪', 'https://img.alicdn.com/imgextra/i2/3369193590/O1CN01iz7OMc1cOGMVSxjQk_!!3369193590.jpg', '3799.00', '3499.00', '1', '194', '3369193590', '5.30', '0.00', '', '0', '评价4.9分的品质，3D高清家用，一机多功能，机身小巧便携，操作方便，高清大屏幕看直播才够爽，快来造你的家庭私人小影院~', 'cba482e39f164df691ff318ec9444d01', '300.00', '2019-01-13 23:59:59', '10000', '0', '3799', 'https://uland.taobao.com/quan/detail?sellerId=3369193590&activityId=cba482e39f164df691ff318ec9444d01', '1547099300', '1');
INSERT INTO `mall_goods` VALUES ('74', '18004364', '8', '577850705537', 'MOOKA/模卡 U65A5M 65英寸4K智能网络语音液晶电视60 70', 'MOOKA/模卡65英寸4K智能液晶电视', 'https://img.alicdn.com/imgextra/i2/2248149301/O1CN013LKej52IZuI9nYZyC_!!2248149301.jpg', '3799.00', '3399.00', '1', '50', '2248149301', '10.00', '0.00', '', '0', '【mooka模卡官方旗舰店】65英寸4K智能网络语音液晶电视，大屏影院，丰富资源，一键缓存，环绕音效，高颜值外观，震撼音效【\r\n赠保价险】', 'b36191a36b694807afc0521619a1668a', '400.00', '2019-01-08 23:59:59', '9800', '200', '2599', 'https://uland.taobao.com/quan/detail?sellerId=2248149301&activityId=b36191a36b694807afc0521619a1668a', '1547099300', '1');
INSERT INTO `mall_goods` VALUES ('75', '18007084', '8', '578485093476', '老板26A7+30B3/32B1欧式侧吸式大吸力抽油烟机燃气灶套装家用厨房', '【Robam/老板】油烟机+煤气灶套装', 'https://img.alicdn.com/imgextra/i2/207244664/O1CN01efR7D81kK9jtbCxiz_!!207244664.jpg', '3999.00', '3699.00', '1', '16', '4179083009', '8.32', '0.00', '', '0', '【送厨房五件套】穹顶大吸力油烟机+黑晶防爆玻璃煤气灶，天然气/液化气，优质电力18m3/min超强风量，大腔体智能排烟不跑烟，能耗1级免拆洗免换网，智能仿生物学静音，让下厨更有幸福感，控制油烟不外溢！', '98d17c4718ba448580d0e27902cb63fa', '300.00', '2019-01-15 23:59:59', '10000', '0', '3000', 'https://uland.taobao.com/quan/detail?sellerId=4179083009&activityId=98d17c4718ba448580d0e27902cb63fa', '1547099300', '1');
INSERT INTO `mall_goods` VALUES ('76', '17995614', '8', '576182313631', '华帝i11083+i10039A抽油烟机家用侧吸式抽油烟机燃气灶套装组合', '【华帝】侧吸式油烟机燃气灶套装组合', 'https://img.alicdn.com/imgextra/i4/3868255650/O1CN01CvjeLI1rbkGDWmMIs_!!3868255650.jpg', '3499.00', '2999.00', '1', '29', '2095854107', '8.30', '0.00', '', '0', '简约大气尽显品质，两种安装方式随心选，精选高品质不锈钢，一擦即净高配置高性能低分贝静享厨房美味。送装入户，店铺限量钜惠领劵立省500元！全国联保！【顺丰直达】', 'd8f482c141b74498b6b667c789a7d0d4', '500.00', '2019-01-15 23:59:59', '1000', '0', '3499', 'https://uland.taobao.com/quan/detail?sellerId=2095854107&activityId=d8f482c141b74498b6b667c789a7d0d4', '1547099300', '1');
INSERT INTO `mall_goods` VALUES ('77', '17992941', '1', '580386320203', '2018冬季新款海宁狐狸毛皮草外套水貂袖大衣中长款欧洲站羊皮女装', '海宁狐狸毛皮草外套水貂袖大衣', '//img.alicdn.com/imgextra/i4/2140426737/O1CN011zdalY8O4B6VPOP_!!2140426737.jpg', '5480.00', '4980.00', '1', '105', '2140426737', '7.54', '0.00', '', '0', '优质狐狸毛，水貂毛袖子，加棉保暖，暖洋洋不显臃肿', '2b61439e2aa14caca017129707cb1a26', '500.00', '2019-01-12 23:59:59', '1960', '40', '5000', 'https://uland.taobao.com/quan/detail?sellerId=2140426737&activityId=2b61439e2aa14caca017129707cb1a26', '1547099300', '1');
INSERT INTO `mall_goods` VALUES ('78', '17990896', '8', '566114598255', '科大讯飞阿尔法大蛋智能机器人视频通话儿童学习早教人工智能礼物', '科大讯飞阿尔法大蛋智能机器人礼物', 'https://img.alicdn.com/imgextra/i3/2951173011/O1CN01IGYcRZ1Y752lPZfG3_!!2951173011.jpg', '2999.00', '2899.00', '1', '48', '2951173011', '20.10', '0.00', '', '0', '【高端机器人】全球智能机器人金奖！语英数理化多科学习助手，远程视频通话，中英互译，百科问答等功能，陪伴孩子学习的神器！给孩子最好的新年礼物~快快抢购！【赠运费险】', 'a01f9c86666e44bd8529b2f5822ee054', '100.00', '2019-01-10 23:59:59', '480', '20', '2999', 'https://uland.taobao.com/quan/detail?sellerId=2951173011&activityId=a01f9c86666e44bd8529b2f5822ee054', '1547099300', '1');
INSERT INTO `mall_goods` VALUES ('79', '17988311', '8', '577068023465', 'MOOKA/模卡 Q55X31M 55吋4K曲面人工智能语音网络全面屏电视50 65', '模卡55吋4K智能全面屏曲面电视', 'https://img.alicdn.com/imgextra/i4/2389586717/O1CN01BnADvC1zUQrapIhrH_!!2389586717.jpg', '3199.00', '2799.00', '1', '28', '2248149301', '8.30', '0.00', '', '0', '新年焕新季，星品放肆购。AL全面屏，视无界限。人工智能，应答如流。想看就说，一秒即播。轻薄似曲，优雅璀璨。', 'b36191a36b694807afc0521619a1668a', '400.00', '2019-01-08 23:59:59', '9800', '200', '2599', 'https://uland.taobao.com/quan/detail?sellerId=2248149301&activityId=b36191a36b694807afc0521619a1668a', '1547099300', '1');
INSERT INTO `mall_goods` VALUES ('80', '17986532', '8', '17734733454', '汉斯顿净水器家用直饮厨房自来水纯水机ro反渗透净水机HSD-75G-07', '【汉斯顿】净水器家用自来水反渗透净水机', '//img.alicdn.com/imgextra/i2/1971854101/O1CN01LRxoE11gAIkdZcev8_!!1971854101.jpg', '3680.00', '3180.00', '1', '429', '1624766852', '20.00', '0.00', '', '0', '汉斯顿，大品牌，值得信赖！我们日常50%的饮用水存在安全隐患，那么，为了家人的健康您需要一台净水器，汉斯顿净水器，五重过滤，水电分离，智能控制，呵护您的健康！【赠运费险】', 'd8b1e9b66d4b41e5b0e5ea1ebcf0cc3a', '500.00', '2019-01-10 23:59:59', '99992', '8', '3670', 'https://uland.taobao.com/quan/detail?sellerId=1624766852&activityId=d8b1e9b66d4b41e5b0e5ea1ebcf0cc3a', '1547099300', '1');
INSERT INTO `mall_goods` VALUES ('81', '17971574', '3', '578572564755', '雅萌bloom射频美容仪瘦脸 V脸神器 提拉脸部紧致 提升按摩仪', '雅萌频射脸部提拉紧致嫩肤美容仪', 'https://img.alicdn.com/imgextra/i1/752065808/O1CN01v7e79G1sm6pDHBbx4-752065808.jpg', '3599.00', '3149.00', '1', '58', '3898012560', '10.00', '0.00', '', '0', '【周冬雨倾情代言】日本YAMAN频射美容仪，6分钟提拉紧致淡化细纹，深层温热，有效焕活肌肤胶原蛋白，每天6分钟做紧致猪猪女孩！', '5aecfa3c33224949b6d85041356cd777', '450.00', '2019-01-11 23:59:59', '1986', '14', '1599', 'https://uland.taobao.com/quan/detail?sellerId=3898012560&activityId=5aecfa3c33224949b6d85041356cd777', '1547099300', '1');
INSERT INTO `mall_goods` VALUES ('82', '17972079', '7', '43216874613', '音乐通练琴达人钢琴陪练机钢琴学习机智能电钢练琴神器考级伴奏机', '钢琴陪练机智能电钢练琴神器', 'https://img.alicdn.com/imgextra/i1/2343446020/O1CN01V3iPe01uLCnuAz0lt_!!2343446020.jpg', '3260.00', '3060.00', '1', '111', '2343446020', '5.51', '0.00', '', '0', '专为学习钢琴零烦恼诞生，实时纠错，增加练琴兴趣，提高节奏感，乐感，海量曲库（实时更新）专业的钢琴陪练达人。', '37f5c40b97c147cf9e4ed98e2ccbb1a7', '200.00', '2019-01-11 23:59:59', '956', '44', '3000', 'https://uland.taobao.com/quan/detail?sellerId=2343446020&activityId=37f5c40b97c147cf9e4ed98e2ccbb1a7', '1547099300', '1');
INSERT INTO `mall_goods` VALUES ('83', '17956434', '13', '574758409934', '舒华X6跑步机家用款电动折叠减震超静音健身房专用器材SH-6700', '舒华X6跑步机家用款健身房专用器材', 'https://img.alicdn.com/imgextra/i3/2758130838/O1CN01827cw81I3qO8TMqBt_!!2758130838.jpg', '15999.00', '14999.00', '1', '35', '4010680394', '7.00', '0.00', '', '0', '液晶显示屏，无线心率测试，静音缓震，简易折叠式不占地，操作简单，全家都能用，劳逸结合给身体充电~【送货上门+全国联保】', '71f8636d594a4d1aa36dceac56b565d2', '1000.00', '2019-01-10 23:59:59', '4987', '13', '10000', 'https://uland.taobao.com/quan/detail?sellerId=4010680394&activityId=71f8636d594a4d1aa36dceac56b565d2', '1547099300', '1');
INSERT INTO `mall_goods` VALUES ('84', '17956100', '13', '574601440919', '舒华A5智能跑步机家用款小型电动超静音折叠式健身器材T5500', '舒华A5智能跑步机家用款', 'https://img.alicdn.com/imgextra/i4/2758130838/O1CN01WFN6vp1I3qO71F5rr_!!2758130838.jpg', '5499.00', '4699.00', '1', '33', '4010680394', '5.00', '0.00', '', '0', '静音缓震，简易折叠式不占地，操作简单，全家都能用，劳逸结合给身体充电~【送货上门+全国联保】', 'ee2a059b58004810aabaf8947c82e448', '800.00', '2019-01-10 23:59:59', '4981', '19', '5000', 'https://uland.taobao.com/quan/detail?sellerId=4010680394&activityId=ee2a059b58004810aabaf8947c82e448', '1547099300', '1');
INSERT INTO `mall_goods` VALUES ('85', '17953174', '8', '578498361971', '汉斯顿家用直饮自来水过滤ro反渗透净水无桶双水大流量净水器1601', '【汉斯顿】超强过滤净水器', 'https://img.alicdn.com/imgextra/i1/1975957334/O1CN01FLcwVp2431DjSKeoc_!!1975957334.jpg', '3780.00', '3180.00', '1', '535', '1624766852', '18.00', '0.00', '', '0', '汉斯顿，大品牌，超低折扣，超大优惠。专家级净水器，用着安心，喝着放心，为了家人的健康，您值得拥有【赠运费险】', 'a373e8d6703c4d788213251a735fdee1', '600.00', '2019-01-08 23:59:59', '99961', '39', '3779', 'https://uland.taobao.com/quan/detail?sellerId=1624766852&activityId=a373e8d6703c4d788213251a735fdee1', '1547099300', '1');
INSERT INTO `mall_goods` VALUES ('86', '17950500', '7', '521066795895', '美得理DP320电钢琴88键重锤专业成人家用台式儿童数码电子钢琴', '美得理DP320电钢琴88键重锤', 'https://img.alicdn.com/imgextra/i1/2509131624/O1CN011NrpfUCcOv6o6lH_!!2509131624.jpg', '3480.00', '3080.00', '1', '209', '2509131624', '6.50', '0.00', '', '0', '美得理DP320电子钢琴88键重锤专业智能数码钢琴，欧式时尚外观重锤键盘新品上市，专业考级教学钢琴，跨越新声，智为所爱，538种音色，邂逅多种乐器，时尚大气，恰到豪处，致力于让声音的艺术传遍全世界！', '992a1a4f07b6456b881c6ee93cc88c0d', '400.00', '2019-01-10 23:59:59', '987', '13', '3480', 'https://uland.taobao.com/quan/detail?sellerId=2509131624&activityId=992a1a4f07b6456b881c6ee93cc88c0d', '1547099300', '1');
INSERT INTO `mall_goods` VALUES ('87', '17949465', '8', '575704139683', '板川尚派集成灶一体灶家用侧吸下排烟燃气灶自动清洗消毒', '板川尚派集成灶一体灶自动清洗消毒', 'https://img.alicdn.com/imgextra/i1/878393178/O1CN01BGFdsF1ZLZB6QO4FV_!!878393178.jpg', '6719.00', '5919.00', '1', '58', '2781180165', '10.00', '0.00', '', '0', '简约的造型，内涵丰富。从工艺到科技，均以高标准进行，它是厨房的侍卫，以安全出发，为健康守护。它是厨房的贴心管家，让您烹饪顺心顺手。油烟机燃气灶消毒橱柜三合一，清爽厨房拒绝一丝油腻。', '13f39d7f1add40b18ba3b0d11d234695', '800.00', '2019-01-11 23:59:59', '9976', '24', '5000', 'https://uland.taobao.com/quan/detail?sellerId=2781180165&activityId=13f39d7f1add40b18ba3b0d11d234695', '1547099300', '1');
INSERT INTO `mall_goods` VALUES ('88', '17948008', '14', '17549147572', '太湖雪100%桑蚕长丝被子母被加厚保暖冬被春秋手工被芯 雅柔2+4斤', '太湖雪加厚保暖春秋手工被芯', 'https://img.alicdn.com/imgextra/i1/735965542/TB2.8F8azZnyKJjSZFLXXXWqpXa_!!735965542.jpg', '3368.00', '2768.00', '1', '44', '735965542', '10.00', '0.00', '', '0', '100%优质双宫茧桑蚕长丝填充，60支全棉提花面料，均匀丝厚，韧性强，舒适透气，柔软贴身，减少压迫，四季通用，给你温暖的睡眠！', '759f8007e53b4db383f3dc164b8172af', '600.00', '2019-01-10 23:59:59', '9962', '38', '3000', 'https://uland.taobao.com/quan/detail?sellerId=735965542&activityId=759f8007e53b4db383f3dc164b8172af', '1547099300', '1');
INSERT INTO `mall_goods` VALUES ('89', '17947139', '14', '35282566559', '太湖雪100%桑蚕丝被子双宫茧长丝子母被春秋冬保暖被芯 馨柔2+4斤', '太湖雪100%桑蚕丝被子双宫茧长丝子母被', 'https://img.alicdn.com/imgextra/i4/735965542/TB2gHMYvYplpuFjSspiXXcdfFXa_!!735965542.jpg', '3980.00', '3380.00', '1', '85', '735965542', '10.00', '0.00', '', '0', '精选100%双宫茧桑蚕长丝填充，均匀丝厚，韧性强，天然调温，柔软透气，贴身，减少压迫，春秋冬季使用，给你温暖的睡眠！', '759f8007e53b4db383f3dc164b8172af', '600.00', '2019-01-10 23:59:59', '9962', '38', '3000', 'https://uland.taobao.com/quan/detail?sellerId=735965542&activityId=759f8007e53b4db383f3dc164b8172af', '1547099300', '1');
INSERT INTO `mall_goods` VALUES ('90', '17941708', '8', '548540336563', 'TIPON德国汉朗空气净化器家用除甲醛雾霾pm2.5除烟除尘负离子氧吧', '汉朗家用除烟除尘除甲醛空气净化器', 'https://img.alicdn.com/imgextra/i2/2131732822/TB2vzWrpf6H8KJjy0FjXXaXepXa_!!2131732822.jpg', '3590.00', '2890.00', '1', '273', '2131732822', '12.24', '0.00', '', '0', '【晒单送50元现金】TIPON德国汉朗空气净化器，四维立体净化，高速除甲醛，我们免费试用15天~除菌率达99.70%甲醛去除率达97.60%给家人孩子一个清新的坏境【赠送运费险】', '029b59cc1db0428f959ee785563bd7b6', '700.00', '2019-01-09 23:59:59', '99886', '114', '1700', 'https://uland.taobao.com/quan/detail?sellerId=2131732822&activityId=029b59cc1db0428f959ee785563bd7b6', '1547099300', '1');
INSERT INTO `mall_goods` VALUES ('91', '17941626', '14', '578385189255', '太湖雪宽幅无缝拼接真丝四件套 100%桑蚕丝床上用品套件 2018新款', '太湖雪宽幅无缝拼接真丝四件套', '//img.alicdn.com/imgextra/i1/735965542/O1CN011qoHSUhA0Z0vPy8_!!735965542.jpg', '4480.00', '3880.00', '1', '27', '735965542', '10.00', '0.00', '', '0', '蚕丝面料，手感丝滑，触感柔软，舒适美观，天然健康，冬暖夏凉，柔滑亲肤，活性印染，精致花纹，气质优雅，各种款式可选，让你拥有一款温暖而舒心的床单！', '759f8007e53b4db383f3dc164b8172af', '600.00', '2019-01-10 23:59:59', '9962', '38', '3000', 'https://uland.taobao.com/quan/detail?sellerId=735965542&activityId=759f8007e53b4db383f3dc164b8172af', '1547099300', '1');
INSERT INTO `mall_goods` VALUES ('92', '17941459', '14', '36632442402', '太湖雪100%桑蚕长丝被春秋冬被子母被芯加厚保暖双宫 沁柔3+5斤', '太湖雪秋冬加厚保暖桑蚕长丝被', 'https://img.alicdn.com/imgextra/i4/735965542/TB232DUaTIlyKJjSZFMXXXvVXXa_!!735965542.jpg', '3588.00', '2988.00', '1', '29', '735965542', '10.00', '0.00', '', '0', '双宫茧桑蚕长丝，精选优质层，独立桑蚕园，21年专注桑蚕产业。百家高端实体店，柔软贴身，减少压迫。', '759f8007e53b4db383f3dc164b8172af', '600.00', '2019-01-10 23:59:59', '9962', '38', '3000', 'https://uland.taobao.com/quan/detail?sellerId=735965542&activityId=759f8007e53b4db383f3dc164b8172af', '1547099300', '1');
INSERT INTO `mall_goods` VALUES ('93', '17991256', '9', '574782920804', 'LAKECY/莱克茜冬季新款毛衣男士圆领韩版时尚针织衫毛线衣打底衫', '冬季时尚毛衣男士圆领加厚打底针织衫', '//img.alicdn.com/imgextra/i3/2241544189/O1CN01EJiqc61gobbEE2NfT_!!2241544189.jpg', '388.00', '88.00', '1', '32536', '2241544189', '20.00', '0.00', '', '0', '【lakecy莱克茜】手感柔软，，贴身穿，不扎人，多色可选，做工精细，商务休闲，彰显奢华【赠运费险】', '6c786e84ac174ce593e713714160787f', '300.00', '2019-01-14 23:59:59', '99936', '64', '310', 'https://uland.taobao.com/quan/detail?sellerId=2241544189&activityId=6c786e84ac174ce593e713714160787f', '1547100785', '1');
INSERT INTO `mall_goods` VALUES ('94', '17979699', '9', '577627650223', '冬季高领毛衣男士针织衫韩版2018新款加绒加厚打底线衣修身潮外套', '【加绒加厚】高领保暖毛衣男', 'https://img.alicdn.com/imgextra/i3/2144108326/O1CN01HAi5gn2BNM8RlR6n9_!!2144108326.jpg', '49.90', '29.90', '1', '35357', '4127657202', '20.00', '0.00', '', '0', '【爆款秒杀，内里整件毛绒，】360度全面保暖，还可以祼穿，高密度，防漏风，复合一体绒，绒面合一，好面料，质量绝不输任何大牌，做的就是口碑，多款多色，赶紧选购吧！', 'e8141f74c8344409988992fa0fef770f', '20.00', '2019-01-09 23:59:59', '96000', '4000', '49', 'https://uland.taobao.com/quan/detail?sellerId=4127657202&activityId=e8141f74c8344409988992fa0fef770f', '1547100785', '1');
INSERT INTO `mall_goods` VALUES ('95', '17979870', '9', '557352798644', '冬季新款中老年人加绒加厚皮衣男装大码爸爸外套中年男士皮夹克男', '【依中漫舞】年前送礼中老年加绒保暖皮衣', 'https://img.alicdn.com/imgextra/i1/2456388114/TB2wOG5xbZnBKNjSZFGXXbt3FXa_!!2456388114-0-item_pic.jpg', '469.00', '69.00', '1', '36084', '2456388114', '30.00', '0.00', '', '0', '【年前送礼咯！】天猫秋冬高品质加绒加厚皮衣！靓丽纹理，质地柔软，保暖呵护，加绒皮毛一体皮夹克，穿出气质，穿出男人品味！寒潮来袭，送爸爸和老公温暖贴心的礼物！', 'fa27d7494ea64c3c81157e221f99c4a0', '400.00', '2019-01-12 23:59:59', '6900', '3100', '460', 'https://uland.taobao.com/quan/detail?sellerId=2456388114&activityId=fa27d7494ea64c3c81157e221f99c4a0', '1547100785', '1');
INSERT INTO `mall_goods` VALUES ('96', '17999223', '1', '543626745567', '加绒魔术黑色九分打底裤女外穿小脚秋冬2018新款高腰显瘦铅笔黑裤', '【冬朵】秋季九分魔术黑色修身裤', 'https://img.alicdn.com/imgextra/i1/2604381166/O1CN01EGMu751KU4I0BLcf7_!!2604381166.jpg', '68.00', '58.00', '1', '288253', '2193547442', '20.00', '0.00', '', '0', '累计销售120万件，30万高分评价，十年穿坏免费换新，透气舒适面料、高弹力、适合各种身材、一秒变瘦、勾勒高挑身材！【赠运费险】', '126ce9ebee414572851c6cab5806946a', '10.00', '2019-01-12 23:59:59', '99978', '22', '68', 'https://uland.taobao.com/quan/detail?sellerId=2193547442&activityId=126ce9ebee414572851c6cab5806946a', '1547102375', '1');
INSERT INTO `mall_goods` VALUES ('97', '17986585', '1', '583002266866', '每人限2件！多拍不发货！秋冬季加绒踩脚女士打底裤袜外穿压力裤', '【第二件0元】光腿冬天神器冬季加绒踩脚', 'https://img.alicdn.com/imgextra/i2/3108582780/O1CN011WPHXEMPTW2DShB_!!3108582780.jpg', '109.00', '79.00', '1', '296469', '3108582780', '20.00', '0.00', '', '0', '【第二件0元】自发热，优质水貂绒，细密柔软里绒，保暖加倍，加绒加厚，摆脱冰凉触感，牢牢锁住热量，穿着舒适，柔软亲肤，保暖实力派~', '2e4d0f197b9f4bde9022c5f1db4e0973', '30.00', '2019-01-13 23:59:59', '49500', '500', '70', 'https://uland.taobao.com/quan/detail?sellerId=3108582780&activityId=2e4d0f197b9f4bde9022c5f1db4e0973', '1547102375', '1');
INSERT INTO `mall_goods` VALUES ('98', '17978998', '1', '580119223233', '400g石墨烯量子磁疗暖宫养生裤加绒加厚打底裤女士高腰外穿保暖裤', '【抖音爆款】石墨稀量子芯片养生裤', 'https://img.alicdn.com/imgextra/i3/3839748824/O1CN012F3RLtfptTwLNKc_!!3839748824.jpg', '298.00', '98.00', '1', '97983', '3839748824', '0.00', '30.00', '', '0', '集养生保健保暖于一体，前部量子芯片磁疗暖宫，改善宫寒，体寒.后部石墨稀导电技术改善微循环，增强免疫力.面料高密度锦纶，不起球，不抽丝，保暖蓄热抗寒-20度，真正的一条过冬，轻轻松松', '8a8ec91255cd4a579f254b47d525bd21', '200.00', '2019-01-09 23:59:59', '92000', '8000', '260', 'https://uland.taobao.com/quan/detail?sellerId=3839748824&activityId=8a8ec91255cd4a579f254b47d525bd21', '1547102375', '1');
INSERT INTO `mall_goods` VALUES ('99', '17978994', '1', '580069443336', '350克秋冬加厚假透肉打底裤真透肤踩脚丝袜女加绒无缝一体连裤袜', '【超级爆款】真透肤加绒打底裤', 'https://img.alicdn.com/imgextra/i1/3839748824/O1CN0140m9Zj2F3RNAX9HvX_!!3839748824.jpg', '269.90', '69.90', '1', '93617', '3839748824', '0.00', '30.00', '', '0', '【爆款】工厂直营店，十年加工经验，加绒打底裤，显瘦又好看。不易起球，不易抽丝，超柔绒，御寒保暖，美腿美肌，妹子喜爱的光腿神器，穿起来与肌肤融为一体，颜色自然，穿了等于没穿~，女神必备光腿神器', '8a8ec91255cd4a579f254b47d525bd21', '200.00', '2019-01-09 23:59:59', '92000', '8000', '260', 'https://uland.taobao.com/quan/detail?sellerId=3839748824&activityId=8a8ec91255cd4a579f254b47d525bd21', '1547102375', '1');
INSERT INTO `mall_goods` VALUES ('100', '17978987', '1', '579704856080', '秋冬纯棉竖条纹打底裤女加绒加厚外穿显瘦女士踩连脚保暖裤380克', '【抖音爆款】精梳棉条纹打底裤加绒', 'https://img.alicdn.com/imgextra/i1/3839748824/O1CN012F3RM2w2o1iFPUE_!!3839748824.jpg', '269.90', '69.90', '1', '90762', '3839748824', '0.00', '30.00', '', '0', '工厂直营店，十年加工经验，采用新疆优质长绒棉，高腰不紧绷，立体裁剪，修身显瘦，保证不起球，不抽丝，不掉挡。优质加绒面料，柔软舒适，抗寒-10度，条纹尽显女神长腿，限购一件，手慢无！', '8a8ec91255cd4a579f254b47d525bd21', '200.00', '2019-01-09 23:59:59', '92000', '8000', '260', 'https://uland.taobao.com/quan/detail?sellerId=3839748824&activityId=8a8ec91255cd4a579f254b47d525bd21', '1547102375', '1');
INSERT INTO `mall_goods` VALUES ('101', '17978974', '1', '579859806230', '300克500克肤色光腿打底裤女加绒加厚肉色踩连脚美腿神器保暖裤', '【抖音爆款】光腿神器加绒打底裤', 'https://img.alicdn.com/imgextra/i3/3839748824/O1CN012F3RLsCnqFXCJb0_!!3839748824.jpg', '269.90', '69.90', '1', '92535', '3839748824', '0.00', '30.00', '', '0', '工厂直营店，十年加工经验，加绒打底裤，显瘦又好看。不易起球，不易抽丝，超柔绒，御寒保暖，美腿美肌，妹子最爱的光腿神器，穿起来与肌肤融为一体，颜色自然，穿了等于没穿~，女神必备光腿神器', '8a8ec91255cd4a579f254b47d525bd21', '200.00', '2019-01-09 23:59:59', '92000', '8000', '260', 'https://uland.taobao.com/quan/detail?sellerId=3839748824&activityId=8a8ec91255cd4a579f254b47d525bd21', '1547102375', '1');
INSERT INTO `mall_goods` VALUES ('102', '17978970', '1', '567779143333', '魔术裤秋冬打底裤女外穿2018新款小脚裤弹力紧身铅笔裤子显瘦加绒', '【抖音爆款】精品魔术裤加绒加厚修身', 'https://img.alicdn.com/imgextra/i1/3839748824/TB2uaH_hv6TBKNjSZJiXXbKVFXa_!!3839748824.jpg', '279.90', '79.90', '1', '88551', '3839748824', '0.00', '30.00', '', '0', '此款外层是钻石纹面料，不抽丝，不褪色，不缩水！弹力非常棒，零束缚！内里复合牛奶丝绒，保暖的同时又不显的臃肿，而且牛奶丝，比其他的绒更容易清洗，更亲肤，穿起来很顺滑！商家亏本，限购一条，', '8a8ec91255cd4a579f254b47d525bd21', '200.00', '2019-01-09 23:59:59', '92000', '8000', '260', 'https://uland.taobao.com/quan/detail?sellerId=3839748824&activityId=8a8ec91255cd4a579f254b47d525bd21', '1547102375', '1');
INSERT INTO `mall_goods` VALUES ('103', '18005559', '9', '579812328550', '南极人保暖衬衫男士长袖加绒加厚冬季衬衣修身格子中年爸爸衣服寸', '【南极人】加绒加厚男士保暖衬衫', 'https://img.alicdn.com/imgextra/i4/748376657/O1CN011z2x52HzqLgVgHb_!!748376657.jpg', '69.00', '49.00', '1', '26029', '1040467644', '30.00', '0.00', '', '0', '【七年老店，4.8高分】加绒加厚，绒面一体，蓄热锁温，360度持续保暖，不起绒不掉色不缩水，款式多尺码全，送爸爸送男友都可以~【赠送运费险】', 'cc21cc8206214968816b0a280019fdd6', '20.00', '2019-01-09 23:59:59', '99000', '1000', '68', 'https://uland.taobao.com/quan/detail?sellerId=1040467644&activityId=cc21cc8206214968816b0a280019fdd6', '1547102955', '1');
INSERT INTO `mall_goods` VALUES ('104', '17984533', '9', '533908509584', '秋季男士长袖t恤纯棉白色体恤男装打底衫上衣服韩版潮流秋衣秋冬', 'lroztn秋冬纯棉长袖T恤男', '//img.alicdn.com/imgextra/i3/1115375914/TB2jXJeXAPoK1RjSZKbXXX1IXXa_!!1115375914.jpg', '25.90', '15.90', '1', '25913', '1115375914', '20.00', '0.00', '', '0', '【百元品质の情侣款T恤】不只是纯棉，更是精梳优质全棉，不起球，不掉色，不缩水，不变形，柔软透气，外穿内搭都可以，22个款式，男女都有码，秋天都要有一件的！', 'a86332d769fa41f8ba2627398ab4b178', '10.00', '2019-01-12 23:59:59', '49500', '500', '25', 'https://uland.taobao.com/quan/detail?sellerId=1115375914&activityId=a86332d769fa41f8ba2627398ab4b178', '1547102955', '1');
INSERT INTO `mall_goods` VALUES ('105', '17954679', '9', '545038308339', '男士短袖t恤新款圆领宽松衣服夏季韩版潮流纯棉大码夏装体恤男装', '100%纯棉【男士潮流】短袖T恤', 'https://img.alicdn.com/imgextra/i4/TB1mugTbNSYBuNjSspjYXF73VXa_M2.SS2', '29.90', '14.90', '1', '29412', '2270438858', '30.00', '0.00', '', '0', '反季促销，100%纯棉，高品质纯棉面料，潮流百搭，多道工序磨毛处理。质量绝对不输大牌！月销量20万的大爆款啊，累计32万好评，商家为了拉好评，劲爆价格突袭【赠运费险】', '1b24cb0e1c394cd292edba856be94fa0', '15.00', '2019-01-08 23:59:59', '97778', '2222', '28', 'https://uland.taobao.com/quan/detail?sellerId=2270438858&activityId=1b24cb0e1c394cd292edba856be94fa0', '1547102955', '1');
INSERT INTO `mall_goods` VALUES ('106', '17956827', '9', '556711936232', '羽绒棉马甲男士秋冬季外套青年修身韩版潮流帅气保暖坎肩背心马夹', '秋冬季羽绒棉马甲男士外套', 'https://img.alicdn.com/bao/uploaded/TB2UyBqcS3PL1JjSZPcXXcQgpXa_!!3345988510.png', '78.00', '68.00', '1', '31064', '3345988510', '20.00', '0.00', '', '0', '羽绒棉马甲，男士秋冬季外套，青年修身，韩版潮流，帅气保暖，坎肩背心，马夹羽绒棉，更保暖更轻薄，送运费险', 'cd9efdf2b4704d168695c432959464ae', '10.00', '2019-01-11 23:59:59', '99847', '153', '78', 'https://uland.taobao.com/quan/detail?sellerId=3345988510&activityId=cd9efdf2b4704d168695c432959464ae', '1547102955', '1');
INSERT INTO `mall_goods` VALUES ('107', '18008852', '12', '571730433116', '男士围巾商务真丝拉绒纯色桑蚕丝围巾男冬季韩版学生百搭年轻人', '男士围巾商务真丝拉绒纯色桑蚕丝', 'https://img.alicdn.com/imgextra/i4/3220519006/O1CN012GOnQkyKXJYFo9L_!!3220519006.jpg', '76.00', '46.00', '1', '1195', '3220519006', '30.10', '0.00', '', '0', '经典男士围巾，桑蚕丝冬季百搭，面料柔软舒适无静电，保暖性好，采用别致色调，带来如冬日阳光般的温暖。', 'ac8a66a931c74928aff49972fe836788', '30.00', '2019-01-14 23:59:59', '1960', '40', '70', 'https://uland.taobao.com/quan/detail?sellerId=3220519006&activityId=ac8a66a931c74928aff49972fe836788', '1547105375', '1');
INSERT INTO `mall_goods` VALUES ('108', '17979500', '8', '566477369580', '飞利浦插排多孔家用电源1.8米8位拖线板插线板排插插座插板', '飞利浦多孔1.8米8位插线板', 'https://img.alicdn.com/imgextra/i2/722930722/O1CN01Mufw6v1HCiRrmhUQy_!!722930722.jpg', '64.90', '34.90', '1', '1195', '699463067', '20.01', '0.00', '', '0', '飞利浦大品牌多位孔插座，高阻燃，50mm大间距，适用多种大插头，儿童安全保护门，防尘防误插，把危险拒之门外，节能一体芯结构，导电好，发热小，从内“芯”保证用电安全，做你的家居好伴侣', '97f8604bbd134d0eac5310b6694600e7', '30.00', '2019-01-08 23:59:59', '2280', '720', '30.01', 'https://uland.taobao.com/quan/detail?sellerId=699463067&activityId=97f8604bbd134d0eac5310b6694600e7', '1547105375', '1');
INSERT INTO `mall_goods` VALUES ('109', '18008545', '3', '568121248176', '网红cc棒水光提亮肤色保湿遮瑕光感气垫防水粉底液女持久补水正品', '【莹纯】抖音同款水光气垫cc棒', 'https://img.alicdn.com/imgextra/i4/3012913363/O1CN019Atedv1aiISIDHVIb_!!3012913363.jpg', '59.90', '9.90', '1', '274737', '1055023663', '30.00', '0.00', '', '0', '光感遮瑕，自然润肤，8大护肤精华，滋养补水，持久保湿不脱妆，让你的肌肤吹弹可破~【赠运费险】', '4ad81238df3b48b3af1806000c306dfe', '50.00', '2019-01-09 23:59:59', '83000', '17000', '59', 'https://uland.taobao.com/quan/detail?sellerId=1055023663&activityId=4ad81238df3b48b3af1806000c306dfe', '1547105953', '1');
INSERT INTO `mall_goods` VALUES ('110', '17983570', '3', '577457216946', '限拍1份!超高好评 玻尿酸面膜补水保湿提亮肤色收缩毛孔护肤品', '限拍1份！高好评玻尿酸原液面膜10片', 'https://img.alicdn.com/imgextra/i2/461949708/O1CN012LaJTyPTMiZqdCH_!!461949708.jpg', '229.90', '29.90', '1', '231044', '3301614508', '20.00', '0.00', '', '0', '小分子玻尿酸成分+透明质酸钠，天然温和补水美白，持续锁水保湿！脆弱肌都可以安心使用！【赠运费险】', '1335fad83a174b83802116a25ef023a0', '200.00', '2019-01-13 23:59:59', '49000', '1000', '220', 'https://uland.taobao.com/quan/detail?sellerId=3301614508&activityId=1335fad83a174b83802116a25ef023a0', '1547105953', '1');
INSERT INTO `mall_goods` VALUES ('111', '17980952', '3', '574105660726', '222片化妆棉卸妆棉女卸妆用脸部纯棉厚款一次性盒装1000片屈臣氏', '买2送1！化妆棉卸妆棉222片/包', 'https://img.alicdn.com/imgextra/i3/717309111/O1CN01yMd65P2HAt2Pd4vx8_!!717309111.jpg', '9.80', '8.80', '1', '314397', '717309111', '20.00', '0.00', '', '0', '【拍2件更划算，到手3包，共666片，仅需18.6】选新疆精梳棉！【双面222片】3层加厚双面双效，吸水性释水性都棒棒哒~关键不掉棉絮，柔软亲肤，拉绳设计携带方便，做小面膜、补水卸妆等均可，速选吧！', '6239d07449cc4e24ac915bc96f8206c6', '1.00', '2019-01-12 23:59:59', '24600', '5400', '9', 'https://uland.taobao.com/quan/detail?sellerId=717309111&activityId=6239d07449cc4e24ac915bc96f8206c6', '1547105953', '1');
INSERT INTO `mall_goods` VALUES ('112', '17977225', '3', '41919276717', '蒙丽丝一次性洗脸巾女纯棉美容院专用面巾纸卷卸妆棉洁面巾化妆棉', '【蒙丽丝】一次性洗脸巾洁面巾', 'https://img.alicdn.com/imgextra/i2/1063264201/O1CN011gu6KLlHxiBGqaP_!!1063264201.jpg', '8.50', '7.50', '0', '242375', '788071536', '20.00', '0.00', '', '0', '【买三送一】多买多送，适用于美容洗脸，卸妆等，卫生干净，易清理，秒速吸水，去污显著，韧性强，不掉毛屑，纯棉压制，柔软亲肤，特别适用妇幼肤质，无刺激不过敏！', 'aba68d4a3d34445fa67f1ef03db2d9a7', '1.00', '2019-01-12 23:59:59', '96822', '3178', '8', 'https://uland.taobao.com/quan/detail?sellerId=788071536&activityId=aba68d4a3d34445fa67f1ef03db2d9a7', '1547105953', '1');
INSERT INTO `mall_goods` VALUES ('113', '18003786', '9', '559715416865', 'VGO男款太空银色羽绒服金属亮面中长款白鸭绒加厚韩版潮流羽绒服', 'VGO男款太空银色羽绒服中长款', 'https://img.alicdn.com/imgextra/i4/2177991073/O1CN011JnTRggNoqDeKS9_!!0-item_pic.jpg', '799.00', '699.00', '1', '71', '2177991073', '20.10', '0.00', '', '0', '甄选高含90%白鸭绒，蓬松锁暖，耐磨抗皱面料，做工精细，版型干练，内置胆布不钻绒，优质好货，先抢先得！', '7e50f0b31cc24e7f9800c7b0f1015a2e', '100.00', '2019-01-14 23:59:59', '5000', '0', '599', 'https://uland.taobao.com/quan/detail?sellerId=2177991073&activityId=7e50f0b31cc24e7f9800c7b0f1015a2e', '1547107702', '1');
INSERT INTO `mall_goods` VALUES ('114', '17988063', '9', '577586383725', '波司登羽绒服男 新款鹅绒冬季加厚修身长款保暖毛领外套B80142153', '波司登羽绒服新款鹅绒男毛领外套', '//img.alicdn.com/imgextra/i3/1746350566/O1CN011G3GdaPxpqlXDCS_!!1746350566.jpg', '2599.00', '2399.00', '1', '17', '1746350566', '15.00', '0.00', '', '0', '大品牌，冬季经典款，白鹅绒含绒量90%，防水面料，耐磨，无异味，御寒神器，轻薄蓬松保暖，立体3D裁剪，精致走线锁绒，多色可选', '5e4b7fed5d5948f5b42359174009f4be', '200.00', '2019-01-12 23:59:59', '99899', '101', '2000', 'https://uland.taobao.com/quan/detail?sellerId=1746350566&activityId=5e4b7fed5d5948f5b42359174009f4be', '1547107702', '1');
INSERT INTO `mall_goods` VALUES ('115', '17986904', '9', '575726716746', '波司登男羽绒服短款2018新款冬装可拆帽青年男士品牌加厚修身外套', '【波司登】2018新款加厚短款羽绒服', 'https://img.alicdn.com/bao/uploaded/TB1R98YcOrpK1RjSZFhwu0SdXXa.png', '799.00', '719.00', '1', '148', '1698146817', '15.00', '0.00', '', '0', '【波司登】品质保障，轻盈舒适！保暖型极佳，防静电，舒适不臃肿，帽子可脱卸【赠运费险】', 'f725a4a1517848c592eb2eac777b68e9', '80.00', '2019-01-08 23:59:59', '99535', '465', '600', 'https://uland.taobao.com/quan/detail?sellerId=1698146817&activityId=f725a4a1517848c592eb2eac777b68e9', '1547107702', '1');
INSERT INTO `mall_goods` VALUES ('116', '17985903', '9', '577472050618', '波司登羽绒服男 2018新款加厚短款鹅绒连帽冬季保暖外套B80142141', '波司登2018新款加厚短款鹅绒羽绒服', '//img.alicdn.com/imgextra/i1/1746350566/O1CN011G3Gdb4V1cYxEE0_!!1746350566.jpg', '1799.00', '1649.00', '1', '40', '1746350566', '15.00', '0.00', '', '0', '大品牌，冬季经典款，白鹅绒含绒量90%，防水面料，耐磨，无异味，御寒神器，轻薄蓬松保暖，立体3D裁剪，精致走线锁绒，多色可选', 'e66487b253fa4cb4b681519e5e6571f4', '150.00', '2019-01-12 23:59:59', '99838', '162', '1500', 'https://uland.taobao.com/quan/detail?sellerId=1746350566&activityId=e66487b253fa4cb4b681519e5e6571f4', '1547107702', '1');
INSERT INTO `mall_goods` VALUES ('117', '17981276', '9', '535846250835', '雅仕洛真皮皮衣男 薄款修身短款立领海宁绵羊皮 拉链机车皮夹克潮', '【雅仕洛】 男士修身短款海宁真皮皮衣', 'https://img.alicdn.com/imgextra/i4/TB123TJNXXXXXc1aXXXXXXXXXXX_!!0-item_pic.jpg', '1180.00', '880.00', '1', '15', '2928042853', '15.00', '0.00', '', '0', '品质保证，绵羊皮，夹克拉链，立领有型，时尚潮流。', '9fe835bd990c4707ba926c0430a93783', '300.00', '2019-01-13 23:59:59', '988', '12', '1180', 'https://uland.taobao.com/quan/detail?sellerId=2928042853&activityId=9fe835bd990c4707ba926c0430a93783', '1547107702', '1');
INSERT INTO `mall_goods` VALUES ('118', '18003015', '4', '578407820899', '管道疏通剂强力通卫生间马桶地漏厨房下水道油污堵塞厕所除臭神器', '强力管道疏通剂厕所除臭神器', 'https://img.alicdn.com/imgextra/i4/1950971205/O1CN01q9GqOI1KlvjNeiIAB_!!1950971205.png', '39.90', '14.90', '1', '180590', '1950971205', '30.00', '0.00', '', '0', '强力配方，快速疏通，简易操作，清洁除臭，管道保养。有效激泡溶解，倒一倒，轻松解决下水管道、马桶拥堵，居家必备！', '8b856ba7e12544d2837bcb905c726560', '25.00', '2019-01-10 23:59:59', '19800', '200', '39', 'https://uland.taobao.com/quan/detail?sellerId=1950971205&activityId=8b856ba7e12544d2837bcb905c726560', '1547110300', '1');
INSERT INTO `mall_goods` VALUES ('119', '18006770', '12', '576293222102', '花花公子触屏毛线手套男士冬季保暖加厚防滑开车女户外全指手套秋', '逆天价！花花公子 情侣款触屏保暖手套', 'https://img.alicdn.com/imgextra/i1/1935371611/O1CN01IfTTkB1NlsXnytNWl_!!1935371611.jpg', '19.90', '9.90', '1', '180310', '1751100520', '20.00', '0.00', '', '0', '【大牌~花花公子】现在买肯定是赚了呀！！！可触屏设计，带着手套也能玩手机！不用脱手套接打电话，手机iPai灵活用，玩游戏不冻手，开车不滑方向盘！【赠运费险】', 'ddb10f5bdb174c3eb47e9c2e101674cd', '10.00', '2019-01-08 23:59:59', '98000', '2000', '19', 'https://uland.taobao.com/quan/detail?sellerId=1751100520&activityId=ddb10f5bdb174c3eb47e9c2e101674cd', '1547110300', '1');
INSERT INTO `mall_goods` VALUES ('120', '18003551', '3', '546753873205', '修正去痘印淡化膏痘痘坑非祛痘疤修复凹洞芦荟胶正品面霜产品女男', '【修正】祛痘印修复淡化膏芦荟胶', 'https://img.alicdn.com/imgextra/i4/385522832/TB2yEPmXUgQMeJjy0FfXXbddXXa_!!385522832.jpg', '66.90', '16.90', '1', '177509', '3189385723', '30.00', '0.00', '', '0', '累计300万销量，专门为痘痘肌肤研制，有效平衡油脂分泌，解决痘痘，粉刺困扰，祛痘去坑疤，舒缓快速修复，温和淡印，控油减重，深层护理，修护受损肌肤，平衡紧致纹理。过敏包退，【赠运费险】', '8de6236a274c47a7aff8a8182fdb8c1e', '50.00', '2019-01-09 23:59:59', '98560', '1440', '65', 'https://uland.taobao.com/quan/detail?sellerId=3189385723&activityId=8de6236a274c47a7aff8a8182fdb8c1e', '1547110300', '1');
INSERT INTO `mall_goods` VALUES ('121', '17986747', '4', '538537328464', '圣洁康洗衣机槽清洗剂清洁剂家用全自动滚筒波轮除垢剂非杀菌消毒', '圣洁康 洗衣机槽杀菌除垢清洁剂【4袋装】', 'https://img.alicdn.com/imgextra/i4/861548801/O1CN01V0RObh2EsuG3I7CWr_!!861548801.jpg', '9.90', '6.90', '1', '204011', '2777313824', '20.00', '0.00', '', '0', '全新升级，科学配方，强力深层清洁洗衣机槽、内筒、夹层的顽固污垢，迅速瓦解，杀菌消毒，防止衣物的二次污染，清新祛味，适用所有机型，是家家必备的清洁神器！', '2e0669d441b941d3adc19378d281697c', '3.00', '2019-01-09 23:59:59', '98000', '2000', '9', 'https://uland.taobao.com/quan/detail?sellerId=2777313824&activityId=2e0669d441b941d3adc19378d281697c', '1547110300', '1');
INSERT INTO `mall_goods` VALUES ('122', '17981644', '4', '558117949971', '保暖鞋垫男女士冬季透气吸汗防臭加绒加厚手工羊毛鞋垫棉软毛毛绒', '【买一送一】男女冬季加绒加厚保暖鞋垫', 'https://img.alicdn.com/imgextra/i4/2264984274/TB2QHA0XcyYBuNkSnfoXXcWgVXa_!!2264984274.jpg', '9.90', '7.90', '1', '178624', '2264984274', '20.00', '0.00', '', '0', '【2双装】羊绒毛质厚实细密，加厚羊毛毡底，抗菌除臭，吸湿排汗，干爽透气，黄金茧工艺设计，品质保证、柔软，蓄热锁暖，保暖舒适，暖暖过秋冬！', 'b9b1b92e37074465b39d2173102682b6', '2.00', '2019-01-13 23:59:59', '46000', '4000', '9', 'https://uland.taobao.com/quan/detail?sellerId=2264984274&activityId=b9b1b92e37074465b39d2173102682b6', '1547110300', '1');
INSERT INTO `mall_goods` VALUES ('123', '17971287', '4', '543539887067', '伊芳妮蒸汽眼罩睡眠热敷舒缓眼疲劳 遮光透气睡觉男女发热护眼', '【漏冻！拍3件】伊芳妮敷蒸汽眼罩30片', 'https://img.alicdn.com/imgextra/i4/1994102692/TB2szXYX1KAUKJjSZFzXXXdQFXa_!!1994102692.jpg', '149.70', '39.70', '1', '181399', '1690420968', '20.00', '0.00', '', '0', '【拍3件30片】4.9超高分，精油热蒸，保护视力，缓解眼疲劳，滋润眼球，安神舒缓，给眼睛做个SPA，安神入眠，长时间看电脑、看手机，熬夜，追剧，出差旅途必备款哦~【赠运费险】', '92d991c0d3f1456089e684c022668d56', '110.00', '2019-01-09 23:59:59', '82000', '18000', '149', 'https://uland.taobao.com/quan/detail?sellerId=1690420968&activityId=92d991c0d3f1456089e684c022668d56', '1547110300', '1');
INSERT INTO `mall_goods` VALUES ('124', '17952989', '3', '567709756551', '缤肌蜗牛原液清洁面膜补水保湿正品提亮肤色收缩毛孔男女士送美白', '【缤肌旗舰店】蜗牛原液补水美白面膜15片', 'https://img.alicdn.com/imgextra/i2/650413329/TB1QDmsvfuSBuNkHFqDXXXfhVXa_!!0-item_pic.jpg', '9.90', '8.90', '1', '190919', '650413329', '20.00', '0.00', '', '0', '【升级版蜗牛精华原液面膜15片】过敏包退！新升级蜗牛面膜，补水提亮效果翻倍哦，缺水起皮的干燥肌肤真的敷一敷立竿见影！你可以看得到的水嫩柔滑，补水滋润，嫩滑提亮就是这么简单【赠运费险】', 'a5c844bec5dd4e81baeacbf835adc58c', '1.00', '2019-01-10 23:59:59', '44000', '6000', '9', 'https://uland.taobao.com/quan/detail?sellerId=650413329&activityId=a5c844bec5dd4e81baeacbf835adc58c', '1547110300', '1');
INSERT INTO `mall_goods` VALUES ('125', '18005242', '4', '558843565468', '竹炭牙刷软毛成人家用批发价超细软牙刷抑菌20支家庭装男女士小头', '【情梳万缕】竹炭软毛牙刷20支+2杯子', 'https://img.alicdn.com/imgextra/i4/1046772954/O1CN01OBo0M71XgySMpclKz_!!1046772954.jpg', '16.90', '11.90', '1', '162902', '1046772954', '30.00', '0.00', '', '0', '天猫月销14万+，4.8好评，累计销售超93W+件！值得信赖的好牙刷，小巧刷头，细丝软毛，灵活清洁，不伤口腔~超值家庭旅行装20支，还送2个杯子，不买亏啦~【赠运费险】', '6e446fcf28d2433695e2184f3b624db9', '5.00', '2019-01-09 23:59:59', '24600', '5400', '16', 'https://uland.taobao.com/quan/detail?sellerId=1046772954&activityId=6e446fcf28d2433695e2184f3b624db9', '1547110320', '1');
INSERT INTO `mall_goods` VALUES ('126', '17979481', '4', '42966407474', '珍视明蒸汽热敷眼罩睡眠 发热加热护眼缓解眼疲劳眼贴近视黑眼圈', '珍视明  蒸汽热敷眼罩10片', 'https://img.alicdn.com/imgextra/i1/3012913363/TB2ZyrIelLN8KJjSZFPXXXoLXXa_!!3012913363.jpg', '49.00', '39.00', '1', '162300', '822280525', '30.00', '0.00', '', '0', '珍视明累积评价67万＋精油热蒸，保护视力，缓解眼疲劳，滋润眼球，安神舒缓，深层滋养，给眼睛做个SPA，长时间看电脑，看手机熬夜，追剧，出差旅途必备款哦【赠运费险】可领2张', 'b5f9e1a46a0b4d2cae018b7c81eeaf69', '10.00', '2019-01-08 23:59:59', '47000', '3000', '49', 'https://uland.taobao.com/quan/detail?sellerId=822280525&activityId=b5f9e1a46a0b4d2cae018b7c81eeaf69', '1547110320', '1');
INSERT INTO `mall_goods` VALUES ('127', '17985370', '4', '576684961013', '热水袋充电防爆新款煖宝宝电暖宝毛绒可爱韩版女注水暖水袋暖手宝', '贝美家 防爆充电式仿兔毛热水袋', 'https://img.alicdn.com/imgextra/i4/739868911/O1CN019EJnuG2FhHpFGcalp_!!739868911.jpg', '32.80', '22.80', '1', '168590', '2898766520', '20.02', '0.00', '', '0', '【三年质保，一年免费换新】品质好货经得起考验，4.9超高评分！市场价至少三四十，今天超值抢购！智能防爆，长效保温，精仿兔绒毛，超好的毛绒手感，温暖加倍，给你秋冬最贴心的暖~', 'e98f52ae64d542d9b19d719719984bae', '10.00', '2019-01-09 23:59:59', '45000', '5000', '30', 'https://uland.taobao.com/quan/detail?sellerId=2898766520&activityId=e98f52ae64d542d9b19d719719984bae', '1547110320', '1');
INSERT INTO `mall_goods` VALUES ('128', '17975383', '8', '562283777568', '原裝正品行行行 安卓数据线手机高速快充闪充usb充电器线适用oppo华为三星小米vivo通用加长单头2米充电宝短', '两条装！升级版3A快充安卓数据线', 'https://img.alicdn.com/imgextra/i2/3012913363/O1CN01oZuppZ1aiISOnEo41_!!3012913363.png', '8.00', '5.00', '1', '165555', '2044237984', '40.00', '0.00', '', '0', '【超值2条装】加粗耐磨材质，高效稳定，柔韧抗拉，铝材外壳，安全快充不发烫，边充电边玩游戏都毫无压力！', '84777af83aaf45e1a5bb15e2dfa5cf0b', '3.00', '2019-01-13 23:59:59', '94000', '6000', '8', 'https://uland.taobao.com/quan/detail?sellerId=2044237984&activityId=84777af83aaf45e1a5bb15e2dfa5cf0b', '1547110320', '1');
INSERT INTO `mall_goods` VALUES ('129', '17973343', '4', '559841824302', '韩版可爱袖套女长款成人男工作办公套袖儿童手袖头学生短款秋冬季', '【买一送一】韩版可爱袖套女长款秋冬季', '//img.alicdn.com/imgextra/i4/1739091528/TB2.OPOnaagSKJjy0FgXXcRqFXa_!!1739091528.jpg', '11.90', '9.90', '1', '170026', '1739091528', '20.00', '0.00', '', '0', '多色可选，精致刺绣，透气舒适，办公、学习、做家务都能佩戴，随时保持袖口干净，防尘抗污好帮手！居家必抢', 'f4e26f51e7484051bf6a0ac1bef4360a', '2.00', '2019-01-08 23:59:59', '18000', '12000', '11', 'https://uland.taobao.com/quan/detail?sellerId=1739091528&activityId=f4e26f51e7484051bf6a0ac1bef4360a', '1547110320', '1');
INSERT INTO `mall_goods` VALUES ('130', '17934154', '3', '583060209974', '拍4瓶！仙蒂奈儿24k黄金玻尿酸小金瓶原液', '【拍4瓶29！】韩国24K黄金精华液', 'https://img.alicdn.com/imgextra/i3/1952819637/O1CN01aleGui2L3nNHFqu8k_!!1952819637.jpg', '329.00', '29.00', '1', '171250', '2400758027', '40.00', '0.00', '', '0', '【天猫大牌仙蒂奈儿！第2件、第3件、第4件0元，拍4件只要29元】一定要拍4件！众多美妆达人推荐！秋冬补水王，高浓缩小分子补水，适合各种肌肤，随时补水，专柜热卖329！咱们只要29！！速度抢！', '7a6f5edd6a7e4557bf37ac0bccc560d8', '300.00', '2019-01-08 23:59:59', '75968', '24032', '329', 'https://uland.taobao.com/quan/detail?sellerId=2400758027&activityId=7a6f5edd6a7e4557bf37ac0bccc560d8', '1547110320', '1');
INSERT INTO `mall_goods` VALUES ('131', '17943570', '8', '41006014012', '古尚古iphone6钢化膜苹果6s抗蓝光6plus全屏3D全覆盖水凝6p手机贴膜4.7前后膜全包边防指纹适用6sp保护膜', '苹果6/7/8通用钢化膜【2片装】', '//img.alicdn.com/imgextra/i3/2024058652/TB2MoEZfXXXXXbBXpXXXXXXXXXX_!!2024058652.jpg', '11.60', '6.60', '1', '163345', '2024058652', '41.00', '0.00', '', '0', '真机开模，买弧边升级版，送贴膜神器，3秒速贴，不会贴歪，给您的爱机多一份保护从这里开始', '542515203b8b449f8b72aabb0060f9a6', '5.00', '2019-01-09 23:59:59', '87994', '12006', '11', 'https://uland.taobao.com/quan/detail?sellerId=2024058652&activityId=542515203b8b449f8b72aabb0060f9a6', '1547110320', '1');

-- ----------------------------
-- Table structure for mall_hot_word
-- ----------------------------
DROP TABLE IF EXISTS `mall_hot_word`;
CREATE TABLE `mall_hot_word` (
  `hot_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hot_title` varchar(50) NOT NULL DEFAULT '' COMMENT '热搜词',
  `hot_url` varchar(255) NOT NULL DEFAULT '' COMMENT '词链接',
  `hot_sort` tinyint(2) NOT NULL DEFAULT '99' COMMENT '排序',
  `hot_media_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '媒体id',
  `hot_create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`hot_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mall_hot_word
-- ----------------------------
INSERT INTO `mall_hot_word` VALUES ('11', '美妆', 'http://www.baidu.com', '1', '3', '1547084839');
INSERT INTO `mall_hot_word` VALUES ('12', '太阳伞', 'www.com', '3', '3', '1547101326');
INSERT INTO `mall_hot_word` VALUES ('13', '雨伞', 'www.com', '3', '3', '1547101405');

-- ----------------------------
-- Table structure for mall_icon
-- ----------------------------
DROP TABLE IF EXISTS `mall_icon`;
CREATE TABLE `mall_icon` (
  `icon_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `icon_title` varchar(255) DEFAULT '' COMMENT '标题',
  `icon_img` varchar(255) DEFAULT '' COMMENT '图片',
  `icon_sort` tinyint(2) unsigned NOT NULL DEFAULT '99' COMMENT '排序',
  `icon_create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `icon_status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`icon_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mall_icon
-- ----------------------------
INSERT INTO `mall_icon` VALUES ('1', '天猫国际', 'http://static.mall.bangwoya.com/20181227_686d31806443d5adf93b2b9ddbfabee3.png', '1', '1545619595', '1');
INSERT INTO `mall_icon` VALUES ('2', '品牌馆', 'http://static.mall.bangwoya.com/20181227_11c46c908bc9ae06d05c762ac3ce723b.png', '2', '1545620402', '1');
INSERT INTO `mall_icon` VALUES ('3', '聚划算', 'http://static.mall.bangwoya.com/20181227_1f78d531d2cbcfe1a1fd3ed5e295e3fe.png', '99', '1545899270', '1');
INSERT INTO `mall_icon` VALUES ('4', '9.9包邮', 'http://static.mall.bangwoya.com/20181227_c2d72651bfc98342d3aee0b67f3f47ee.png', '99', '1545899285', '1');
INSERT INTO `mall_icon` VALUES ('5', '天猫国际', 'http://static.mall.bangwoya.com/20190110_0f7b4a4f4bead1a50b8152bd277c89ca.png', '1', '1547109118', '-1');

-- ----------------------------
-- Table structure for mall_media
-- ----------------------------
DROP TABLE IF EXISTS `mall_media`;
CREATE TABLE `mall_media` (
  `media_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT '媒体id',
  `media_title` varchar(100) NOT NULL DEFAULT '' COMMENT '媒体名称',
  `media_ident` varchar(10) NOT NULL DEFAULT '' COMMENT '媒体标识',
  `media_pid` varchar(50) NOT NULL DEFAULT '' COMMENT '媒体淘宝联盟推广位PID',
  `media_divided_into` float(5,2) DEFAULT '0.00' COMMENT '媒体分成比率',
  `media_service_fee` float(5,2) DEFAULT '0.00' COMMENT '技术服务费比率',
  `media_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `media_status` tinyint(2) DEFAULT '1' COMMENT '媒体状态',
  PRIMARY KEY (`media_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='媒体表';

-- ----------------------------
-- Records of mall_media
-- ----------------------------
INSERT INTO `mall_media` VALUES ('3', '测试媒体', 'csmt', 'mm_13553468_81700226_45154700002', '0.11', '0.11', '1546853246', '1');

-- ----------------------------
-- Table structure for mall_reward
-- ----------------------------
DROP TABLE IF EXISTS `mall_reward`;
CREATE TABLE `mall_reward` (
  `reward_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reward_media_id` int(10) unsigned NOT NULL COMMENT '来源媒体',
  `reward_title` varchar(255) DEFAULT '' COMMENT '奖品名称',
  `reward_url` varchar(255) DEFAULT '' COMMENT '跳转链接',
  `reward_img` varchar(255) DEFAULT '' COMMENT '礼包静态图',
  `reward_create_time` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  `reward_status` tinyint(2) unsigned DEFAULT '1' COMMENT '状态 ',
  PRIMARY KEY (`reward_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mall_reward
-- ----------------------------
INSERT INTO `mall_reward` VALUES ('1', '2', '抢金券', 'http://www.baidu.com', 'http://static.mall.bangwoya.com/20181225_542e643e35580e654910bd0404eea952.png', '1545707422', '1');
INSERT INTO `mall_reward` VALUES ('2', '1', '下单送好礼', 'http://www.baidu.com', 'http://static.mall.bangwoya.com/20190104_f18490cd72020a724fb8358d4f79f40a.jpg', '0', '1');
INSERT INTO `mall_reward` VALUES ('3', '3', '平安保险', 'http://www.baidu.com', 'http://static.mall.bangwoya.com/20190110_3b302a043487b5a74c42a417d20e6d1e.jpg', '1547085552', '1');

-- ----------------------------
-- Table structure for mall_top_bind_goods
-- ----------------------------
DROP TABLE IF EXISTS `mall_top_bind_goods`;
CREATE TABLE `mall_top_bind_goods` (
  `top_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `top_goodsid` char(30) DEFAULT NULL COMMENT '商品goodsid',
  `top_sex` tinyint(1) unsigned DEFAULT '2' COMMENT '1-男  2-女',
  `top_status` tinyint(2) DEFAULT '1' COMMENT '状态',
  `top_is_show` tinyint(1) unsigned DEFAULT '1' COMMENT '是否显示  1显示 2不显示',
  `top_create_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`top_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mall_top_bind_goods
-- ----------------------------

-- ----------------------------
-- Table structure for mall_user
-- ----------------------------
DROP TABLE IF EXISTS `mall_user`;
CREATE TABLE `mall_user` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cookie` varchar(255) DEFAULT NULL,
  `user_ident` char(50) DEFAULT NULL,
  `create_time` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mall_user
-- ----------------------------
INSERT INTO `mall_user` VALUES ('1', '', '599a1a68d2b7716898eacbd575561a97', '1547024330');
INSERT INTO `mall_user` VALUES ('2', '', '9db4c5e27ba11f77f1f9ddb160a10140', '1547025394');
INSERT INTO `mall_user` VALUES ('3', '', 'd58c4a34d9f27af959bb6802df88a4d8', '1547025439');
INSERT INTO `mall_user` VALUES ('4', '', 'e036240d9f9bce7588503e060a1a7fdc', '1547025652');
INSERT INTO `mall_user` VALUES ('5', '', '90932409fff308f7a810800455d3dad8', '1547030177');
INSERT INTO `mall_user` VALUES ('6', '', '702e5e493283b4ae4295c2877e25fd75', '1547030485');
INSERT INTO `mall_user` VALUES ('7', '', 'c2d8f9498d238f58bae6e913a182b599', '1547030680');
INSERT INTO `mall_user` VALUES ('8', '', 'f21403a74e67ab69f58c2391caa1ec11', '1547030743');
INSERT INTO `mall_user` VALUES ('9', '', '03248dcd640df7615f6db823a862b492', '1547030780');
INSERT INTO `mall_user` VALUES ('10', '', 'f326aed17478418fd5725a41ee469b81', '1547030986');
INSERT INTO `mall_user` VALUES ('11', '', 'b7fb4b59fe81c21dd99fc910cf1dfd7f', '1547031167');
INSERT INTO `mall_user` VALUES ('12', '', '6c840cb8e771904ecea990bf5096158d', '1547031292');
INSERT INTO `mall_user` VALUES ('13', '', 'aa42ce6e112b278b1fa1d7afa5039a9b', '1547031570');
INSERT INTO `mall_user` VALUES ('14', '', '23c25b6e145147259131533c2a7b7457', '1547031601');
INSERT INTO `mall_user` VALUES ('15', '', '1439a5a7ddb6019246c180d153e0a5bc', '1547031955');
INSERT INTO `mall_user` VALUES ('16', '', 'a15cd6a4fca7b261e14a72bdbb1cb123', '1547083750');
INSERT INTO `mall_user` VALUES ('17', '', 'e76358afcddad15fb9849bad6946e9a4', '1547083812');
INSERT INTO `mall_user` VALUES ('18', '', 'c5a9205cb153ecf56a66f14effc82c1a', '1547083847');
INSERT INTO `mall_user` VALUES ('19', '', '8398855939ca35ae65d2e1d2c8448b0f', '1547084114');
INSERT INTO `mall_user` VALUES ('20', '', '04113c547d582cc57650bf3e3efb9919', '1547091282');
INSERT INTO `mall_user` VALUES ('21', '', 'f7ea7c7a49bc50e6bc32e574925368b7', '1547091706');
INSERT INTO `mall_user` VALUES ('22', '', '9bedc63058bd386057b62432fd0d5e45', '1547092255');
INSERT INTO `mall_user` VALUES ('23', '', '7e64e49368990b130f4fd9178771bed3', '1547092294');
INSERT INTO `mall_user` VALUES ('24', '', '33391e5065914c57f9ab4050f0869534', '1547092440');
INSERT INTO `mall_user` VALUES ('25', '', 'eecb42209eb5b34aed42be58e9b84770', '1547092521');
INSERT INTO `mall_user` VALUES ('26', '', '16c61a36fd961c4ed980204b68adaf4b', '1547100568');
INSERT INTO `mall_user` VALUES ('27', '', 'bf102d07d6ccd8ee9f84d7e7023e30f9', '1547101601');
INSERT INTO `mall_user` VALUES ('28', '', '2a335e2da0094271e0aeb38002547b77', '1547103374');
INSERT INTO `mall_user` VALUES ('29', '', '1cb869b467c099824d57d6c6d0eba86c', '1547104182');
INSERT INTO `mall_user` VALUES ('30', '', 'e014fae005e3ffff11c28ed4866957f0', '1547104232');
INSERT INTO `mall_user` VALUES ('31', '', '0b57f10839bb7879a2a985729c0cf6e3', '1547104355');
INSERT INTO `mall_user` VALUES ('32', '', 'ddf622cb5f77585dc84d16a4628d0716', '1547104419');
INSERT INTO `mall_user` VALUES ('33', '', '341690b7c7583608defe1bca3eabe7bd', '1547105131');
INSERT INTO `mall_user` VALUES ('34', '', 'a6cafc27c1fe6b0e64b8f21444871bda', '1547110430');
INSERT INTO `mall_user` VALUES ('35', '', '36c797cc75b90792ef25f3523b7672b9', '1547120578');
INSERT INTO `mall_user` VALUES ('36', '', '3cc51a3dafe23aa88c1162ec44b907b6', '1547121981');
INSERT INTO `mall_user` VALUES ('37', '', '2f67c158879f2ec39191c639099e69f9', '1547122252');
INSERT INTO `mall_user` VALUES ('38', '', '5c20d85975b861216c8f043d3df93bb5', '1547122253');
