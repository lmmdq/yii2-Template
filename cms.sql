/*
 Navicat Premium Data Transfer

 Source Server         : my
 Source Server Type    : MySQL
 Source Server Version : 50713
 Source Host           : localhost
 Source Database       : cms

 Target Server Type    : MySQL
 Target Server Version : 50713
 File Encoding         : utf-8

 Date: 02/26/2018 16:04:29 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `t_admin`
-- ----------------------------
DROP TABLE IF EXISTS `t_admin`;
CREATE TABLE `t_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password_hash` varchar(60) DEFAULT NULL,
  `state` tinyint(11) DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `google_auth` tinyint(4) DEFAULT '0',
  `google_auth_secret` varchar(255) DEFAULT NULL,
  `city_id` int(13) DEFAULT NULL COMMENT '所属城市',
  `region` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '所属区局',
  `auth_key` varchar(255) DEFAULT NULL,
  `province_id` int(13) DEFAULT NULL,
  `type` tinyint(4) DEFAULT '0' COMMENT '账号类型  0  普通管理  1  专家   2教育机构  3 公益机构',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_unique_username` (`username`),
  UNIQUE KEY `user_unique_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `t_admin`
-- ----------------------------
BEGIN;
INSERT INTO `t_admin` VALUES ('6', 'admin', 'admin@admin.com', '$2y$13$SDQMeSoybuCaPpIwA9aKKeXn42asMCOD8IAwt2CT.qeo5vvzujNly', '0', '1486447147', '1511255261', '0', null, null, null, 'SYjqt-iZBRGORyZY54fey6QZHcU-iDHI', null, '0'), ('19', 'adminZhuanjia', '2@2.com', '$2y$13$xpRJIX9aqdL/c6PV0UO41OFs.k/0DWWgwom5utygnwIqeSSo5qZ.u', '0', '1510881362', '1510991906', '0', null, null, null, 'KQV9qMbcolx2t4G1bFmMh8fsDSgbM_ps', null, '1'), ('21', 'jiaoyu', '3@3.com', '$2y$13$QB9//lVtWbuTGYj9DV/8CeaHzAf1hJ7TsTUkgbj3WS/iALHouUvyK', '0', '1510992786', '1510992786', '0', null, null, null, '6IiemIQwVp28InZ0WjDO9ue09A9BqlwH', null, '2'), ('22', 'gongyiAdmin', '4@3.com', '$2y$13$aAxM4gnTJReNqzXF1gSQ9ehe5J.Z.FxiUFu7dzGXrMyAJj4QLk0DS', '0', '1511066971', '1511066971', '0', null, null, null, 'njD6LX3twh64rIPBm_UAuZbOd0FjcNT2', null, '3'), ('23', 'zhuanjia2', '111@11.com', '$2y$13$KQashjAl9kw.69HDVjvG/uhclJRSHquziI20iUYcu6OduIoIRugWe', '0', '1511488761', '1511488761', '0', null, null, null, 'z8bSbXu7-AVn71WvWsLacgQBWjOTKySd', null, '1');
COMMIT;

-- ----------------------------
--  Table structure for `t_auth_assignment`
-- ----------------------------
DROP TABLE IF EXISTS `t_auth_assignment`;
CREATE TABLE `t_auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `master` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `t_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `t_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `t_auth_assignment`
-- ----------------------------
BEGIN;
INSERT INTO `t_auth_assignment` VALUES ('admin', '13', '1495454836', '0'), ('admin', '18', '1495771985', '0'), ('admin', '7', '1495442029', '0'), ('super-admin', '1', '1455959445', '0'), ('super-admin', '6', '1486517931', '0');
COMMIT;

-- ----------------------------
--  Table structure for `t_auth_item`
-- ----------------------------
DROP TABLE IF EXISTS `t_auth_item`;
CREATE TABLE `t_auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `t_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `t_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `t_auth_item`
-- ----------------------------
BEGIN;
INSERT INTO `t_auth_item` VALUES ('/admin-account/*', '2', null, null, null, '1486518139', '1486518139'), ('/admin-account/assignment', '2', null, null, null, '1457585361', '1457585361'), ('/admin-account/create', '2', null, null, null, '1457583324', '1457583324'), ('/admin-account/delete', '2', null, null, null, '1457583324', '1457583324'), ('/admin-account/index', '2', null, null, null, '1457583324', '1457583324'), ('/admin-account/info', '2', null, null, null, '1510991813', '1510991813'), ('/admin-account/site', '2', null, null, null, '1497101114', '1497101114'), ('/admin-account/update', '2', null, null, null, '1457583324', '1457583324'), ('/admin-account/view', '2', null, null, null, '1486447579', '1486447579'), ('/admin/*', '2', null, null, null, '1486518139', '1486518139'), ('/admin/assignment/*', '2', null, null, null, '1486518139', '1486518139'), ('/admin/assignment/assign', '2', null, null, null, '1457583466', '1457583466'), ('/admin/assignment/index', '2', null, null, null, '1457583466', '1457583466'), ('/admin/assignment/revoke', '2', null, null, null, '1459054495', '1459054495'), ('/admin/assignment/search', '2', null, null, null, '1457583466', '1457583466'), ('/admin/assignment/view', '2', null, null, null, '1457583466', '1457583466'), ('/admin/default/*', '2', null, null, null, '1486518139', '1486518139'), ('/admin/default/index', '2', null, null, null, '1486518139', '1486518139'), ('/admin/menu/*', '2', null, null, null, '1486518139', '1486518139'), ('/admin/menu/create', '2', null, null, null, '1457583474', '1457583474'), ('/admin/menu/delete', '2', null, null, null, '1457583474', '1457583474'), ('/admin/menu/index', '2', null, null, null, '1457583474', '1457583474'), ('/admin/menu/update', '2', null, null, null, '1457583474', '1457583474'), ('/admin/menu/view', '2', null, null, null, '1457583474', '1457583474'), ('/admin/permission/*', '2', null, null, null, '1486518139', '1486518139'), ('/admin/permission/assign', '2', null, null, null, '1457583479', '1457583479'), ('/admin/permission/create', '2', null, null, null, '1457583479', '1457583479'), ('/admin/permission/delete', '2', null, null, null, '1457583479', '1457583479'), ('/admin/permission/index', '2', null, null, null, '1457583479', '1457583479'), ('/admin/permission/remove', '2', null, null, null, '1459054495', '1459054495'), ('/admin/permission/search', '2', null, null, null, '1457583479', '1457583479'), ('/admin/permission/update', '2', null, null, null, '1457583479', '1457583479'), ('/admin/permission/view', '2', null, null, null, '1457583479', '1457583479'), ('/admin/role/*', '2', null, null, null, '1486518139', '1486518139'), ('/admin/role/assign', '2', null, null, null, '1457583485', '1457583485'), ('/admin/role/create', '2', null, null, null, '1457583485', '1457583485'), ('/admin/role/delete', '2', null, null, null, '1457583485', '1457583485'), ('/admin/role/index', '2', null, null, null, '1457583485', '1457583485'), ('/admin/role/remove', '2', null, null, null, '1459054495', '1459054495'), ('/admin/role/search', '2', null, null, null, '1457583485', '1457583485'), ('/admin/role/update', '2', null, null, null, '1457583485', '1457583485'), ('/admin/role/view', '2', null, null, null, '1457583485', '1457583485'), ('/admin/route/*', '2', null, null, null, '1486518139', '1486518139'), ('/admin/route/assign', '2', null, null, null, '1457583489', '1457583489'), ('/admin/route/create', '2', null, null, null, '1457583489', '1457583489'), ('/admin/route/index', '2', null, null, null, '1457583489', '1457583489'), ('/admin/route/refresh', '2', null, null, null, '1459054495', '1459054495'), ('/admin/route/remove', '2', null, null, null, '1459054495', '1459054495'), ('/admin/route/search', '2', null, null, null, '1457583489', '1457583489'), ('/admin/rule/*', '2', null, null, null, '1486518139', '1486518139'), ('/admin/rule/create', '2', null, null, null, '1457583493', '1457583493'), ('/admin/rule/delete', '2', null, null, null, '1457583493', '1457583493'), ('/admin/rule/index', '2', null, null, null, '1457583493', '1457583493'), ('/admin/rule/update', '2', null, null, null, '1457583493', '1457583493'), ('/admin/rule/view', '2', null, null, null, '1457583493', '1457583493'), ('/admin/user/*', '2', null, null, null, '1486518139', '1486518139'), ('/admin/user/activate', '2', null, null, null, '1486518139', '1486518139'), ('/admin/user/change-password', '2', null, null, null, '1486518139', '1486518139'), ('/admin/user/delete', '2', null, null, null, '1486518139', '1486518139'), ('/admin/user/index', '2', null, null, null, '1486518139', '1486518139'), ('/admin/user/login', '2', null, null, null, '1486518139', '1486518139'), ('/admin/user/logout', '2', null, null, null, '1486518139', '1486518139'), ('/admin/user/request-password-reset', '2', null, null, null, '1486518139', '1486518139'), ('/admin/user/reset-password', '2', null, null, null, '1486518139', '1486518139'), ('/admin/user/signup', '2', null, null, null, '1486518139', '1486518139'), ('/admin/user/view', '2', null, null, null, '1486518139', '1486518139'), ('/site/alert', '2', null, null, null, '1519629286', '1519629286'), ('/site/change-password', '2', null, null, null, '1519629286', '1519629286'), ('/site/error', '2', null, null, null, '1519629286', '1519629286'), ('/site/index', '2', null, null, null, '1519629286', '1519629286'), ('/site/login', '2', null, null, null, '1519629286', '1519629286'), ('/site/logout', '2', null, null, null, '1519629286', '1519629286'), ('/site/notice', '2', null, null, null, '1519629286', '1519629286'), ('admin', '1', '普通管理员', null, null, '1495438233', '1510976785'), ('base_all', '2', '基础权限', null, null, '1457585764', '1519629306'), ('super-admin', '1', '超级管理员', null, null, '1455958941', '1510981461'), ('system-admin_all', '2', '系统管理', null, null, '1457762209', '1511742959');
COMMIT;

-- ----------------------------
--  Table structure for `t_auth_item_child`
-- ----------------------------
DROP TABLE IF EXISTS `t_auth_item_child`;
CREATE TABLE `t_auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `t_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `t_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `t_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `t_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `t_auth_item_child`
-- ----------------------------
BEGIN;
INSERT INTO `t_auth_item_child` VALUES ('system-admin_all', '/admin-account/assignment'), ('system-admin_all', '/admin-account/create'), ('system-admin_all', '/admin-account/delete'), ('system-admin_all', '/admin-account/index'), ('system-admin_all', '/admin-account/info'), ('system-admin_all', '/admin-account/site'), ('system-admin_all', '/admin-account/update'), ('system-admin_all', '/admin-account/view'), ('system-admin_all', '/admin/assignment/assign'), ('system-admin_all', '/admin/assignment/index'), ('system-admin_all', '/admin/assignment/revoke'), ('system-admin_all', '/admin/assignment/search'), ('system-admin_all', '/admin/assignment/view'), ('system-admin_all', '/admin/menu/create'), ('system-admin_all', '/admin/menu/delete'), ('system-admin_all', '/admin/menu/index'), ('system-admin_all', '/admin/menu/update'), ('system-admin_all', '/admin/menu/view'), ('system-admin_all', '/admin/permission/assign'), ('system-admin_all', '/admin/permission/create'), ('system-admin_all', '/admin/permission/delete'), ('system-admin_all', '/admin/permission/index'), ('system-admin_all', '/admin/permission/remove'), ('system-admin_all', '/admin/permission/search'), ('system-admin_all', '/admin/permission/update'), ('system-admin_all', '/admin/permission/view'), ('system-admin_all', '/admin/role/assign'), ('system-admin_all', '/admin/role/create'), ('system-admin_all', '/admin/role/delete'), ('system-admin_all', '/admin/role/index'), ('system-admin_all', '/admin/role/remove'), ('system-admin_all', '/admin/role/search'), ('system-admin_all', '/admin/role/update'), ('system-admin_all', '/admin/role/view'), ('system-admin_all', '/admin/route/assign'), ('system-admin_all', '/admin/route/create'), ('system-admin_all', '/admin/route/index'), ('system-admin_all', '/admin/route/refresh'), ('system-admin_all', '/admin/route/remove'), ('system-admin_all', '/admin/route/search'), ('system-admin_all', '/admin/rule/create'), ('system-admin_all', '/admin/rule/delete'), ('system-admin_all', '/admin/rule/index'), ('system-admin_all', '/admin/rule/update'), ('system-admin_all', '/admin/rule/view'), ('base_all', '/site/alert'), ('base_all', '/site/change-password'), ('base_all', '/site/error'), ('base_all', '/site/index'), ('base_all', '/site/login'), ('base_all', '/site/logout'), ('base_all', '/site/notice'), ('admin', 'base_all'), ('super-admin', 'base_all'), ('system-admin_all', 'base_all'), ('super-admin', 'system-admin_all');
COMMIT;

-- ----------------------------
--  Table structure for `t_auth_rule`
-- ----------------------------
DROP TABLE IF EXISTS `t_auth_rule`;
CREATE TABLE `t_auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `t_menu`
-- ----------------------------
DROP TABLE IF EXISTS `t_menu`;
CREATE TABLE `t_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(256) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  CONSTRAINT `t_menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `t_menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=250 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `t_menu`
-- ----------------------------
BEGIN;
INSERT INTO `t_menu` VALUES ('101', '系统管理', null, null, '11', null), ('104', '权限列表', '101', '/admin/permission/index', '2', null), ('105', '角色列表', '101', '/admin/role/index', '3', null), ('106', '菜单列表', '101', '/admin/menu/index', '4', null), ('221', '路由管理', '101', '/admin/route/index', null, null);
COMMIT;

-- ----------------------------
--  Table structure for `t_user`
-- ----------------------------
DROP TABLE IF EXISTS `t_user`;
CREATE TABLE `t_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `role` smallint(6) NOT NULL DEFAULT '10',
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `no` varchar(200) DEFAULT NULL,
  `shenFen` tinyint(4) DEFAULT NULL,
  `touXiang` varchar(200) DEFAULT NULL,
  `login_at` int(13) DEFAULT NULL,
  `custody` int(13) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
