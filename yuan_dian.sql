/*
Navicat MySQL Data Transfer

Source Server         : ubuntuDoc
Source Server Version : 50559
Source Host           : 192.168.182.147:3306
Source Database       : yuan_dian

Target Server Type    : MYSQL
Target Server Version : 50559
File Encoding         : 65001

Date: 2019-03-12 14:14:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for yy_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `yy_admin_user`;
CREATE TABLE `yy_admin_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `username` varchar(255) NOT NULL COMMENT '用户名',
  `nickname` varchar(127) NOT NULL,
  `auth_key` varchar(32) NOT NULL COMMENT '自动登录key',
  `password_hash` varchar(255) NOT NULL COMMENT '加密密码',
  `head_img` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL COMMENT '重置密码token',
  `email` varchar(255) NOT NULL COMMENT '邮箱',
  `role` smallint(6) NOT NULL DEFAULT '30' COMMENT '角色等级10 超级30 为一般',
  `status` smallint(6) NOT NULL DEFAULT '10' COMMENT '状态',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) NOT NULL COMMENT '更新时间',
  `last_login_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of yy_admin_user
-- ----------------------------
INSERT INTO `yy_admin_user` VALUES ('1', 'fengahan', '冯阿含', 'HP187Mvq7Mmm3CTU80dLkGmni_FUH_lR', '$2y$13$EjaPFBnZOQsHdGuHI.xvhuDp1fHpo8hKRSk6yshqa9c5EG8s3C3lO', 'https://www.yiichina.com/uploads/avatar/000/02/90/86_avatar_small.jpg', 'ExzkCOaYc1L8IOBs4wdTGGbgNiG3Wz1I_1402312317', 'nicole.paucek@schultz.info', '10', '10', '1402312317', '1552371146', '1552371146');
INSERT INTO `yy_admin_user` VALUES ('2', 'zhangshan', 'zhangshan', 'DITUOiGgKIlrvp9SR0evg2Oci0lJ0lM9', '$2y$13$S59h.0Q1.GcXLnaz8YWkAePErnyKYl6KeMhLrHdZhxLcbBCwk9HfO', '', null, '544976880@qq.com', '10', '0', '1552319483', '1552366383', '0');
INSERT INTO `yy_admin_user` VALUES ('3', 'lisige', '李四哥哥', 'j2BjkzEMOfkNyKeAjYm3PKBExpn6-tko', '$2y$13$12XQmdF8p0nPz.WMxUwz6O/cw7CbuMwtwDACINnOPKzfH/rdaIhp2', '', null, '544976880@qq.com', '30', '10', '1552366992', '1552368687', '1552368687');

-- ----------------------------
-- Table structure for yy_auth_assignment
-- ----------------------------
DROP TABLE IF EXISTS `yy_auth_assignment`;
CREATE TABLE `yy_auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `yy_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `yy_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色和用户对应表';

-- ----------------------------
-- Records of yy_auth_assignment
-- ----------------------------
INSERT INTO `yy_auth_assignment` VALUES ('新的测试', '1', '1552318717');
INSERT INTO `yy_auth_assignment` VALUES ('新的测试', '14', '1545986840');
INSERT INTO `yy_auth_assignment` VALUES ('新的测试', '2', '1552319483');
INSERT INTO `yy_auth_assignment` VALUES ('新的测试', '3', '1552366992');
INSERT INTO `yy_auth_assignment` VALUES ('新的测试修改', '1', '1552318717');
INSERT INTO `yy_auth_assignment` VALUES ('新的测试修改', '2', '1552319483');
INSERT INTO `yy_auth_assignment` VALUES ('新的测试修改', '3', '1552366993');
INSERT INTO `yy_auth_assignment` VALUES ('新的测试的子类3', '1', '1552318717');
INSERT INTO `yy_auth_assignment` VALUES ('新的测试的子类3', '14', '1545986840');
INSERT INTO `yy_auth_assignment` VALUES ('新的测试的子类3', '2', '1552319483');
INSERT INTO `yy_auth_assignment` VALUES ('新的测试的子类3', '3', '1552366993');
INSERT INTO `yy_auth_assignment` VALUES ('权限Ao', '1', '1552318717');
INSERT INTO `yy_auth_assignment` VALUES ('权限Ao', '14', '1545984164');
INSERT INTO `yy_auth_assignment` VALUES ('权限Ao', '2', '1552319483');
INSERT INTO `yy_auth_assignment` VALUES ('权限Ao', '3', '1552366993');
INSERT INTO `yy_auth_assignment` VALUES ('校草', '1', '1545992226');
INSERT INTO `yy_auth_assignment` VALUES ('校草', '14', '1545984163');
INSERT INTO `yy_auth_assignment` VALUES ('校草', '2', '1552319483');
INSERT INTO `yy_auth_assignment` VALUES ('校草', '3', '1552366993');

-- ----------------------------
-- Table structure for yy_auth_item
-- ----------------------------
DROP TABLE IF EXISTS `yy_auth_item`;
CREATE TABLE `yy_auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `type` (`type`),
  CONSTRAINT `yy_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `yy_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='路由表和角色表';

-- ----------------------------
-- Records of yy_auth_item
-- ----------------------------
INSERT INTO `yy_auth_item` VALUES ('/*', '2', null, null, 'a:2:{s:10:\"route_name\";s:0:\"\";s:17:\"route_description\";s:0:\"\";}', '1546063462', '1546063462');
INSERT INTO `yy_auth_item` VALUES ('/admin-user/*', '2', null, null, 'a:2:{s:10:\"route_name\";s:0:\"\";s:17:\"route_description\";s:0:\"\";}', '1546063459', '1546063459');
INSERT INTO `yy_auth_item` VALUES ('/admin-user/create', '2', null, null, 'a:2:{s:10:\"route_name\";s:15:\"创建管理员\";s:17:\"route_description\";s:21:\"创建新的管理员\";}', '1546063459', '1546063459');
INSERT INTO `yy_auth_item` VALUES ('/admin-user/delete', '2', null, null, 'a:2:{s:10:\"route_name\";s:15:\"删除管理员\";s:17:\"route_description\";s:21:\"删除指定管理员\";}', '1546063459', '1546063459');
INSERT INTO `yy_auth_item` VALUES ('/admin-user/index', '2', null, null, 'a:2:{s:10:\"route_name\";s:15:\"管理员管理\";s:17:\"route_description\";s:15:\"管理员管理\";}', '1546063458', '1546063458');
INSERT INTO `yy_auth_item` VALUES ('/admin-user/list', '2', null, null, 'a:2:{s:10:\"route_name\";s:15:\"管理员列表\";s:17:\"route_description\";s:15:\"管理员列表\";}', '1546063459', '1546063459');
INSERT INTO `yy_auth_item` VALUES ('/admin-user/update', '2', null, null, 'a:2:{s:10:\"route_name\";s:15:\"更新管理员\";s:17:\"route_description\";s:21:\"更新管理员信息\";}', '1546063459', '1546063459');
INSERT INTO `yy_auth_item` VALUES ('/admin-user/update-status', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"更新状态\";s:17:\"route_description\";s:12:\"更新状态\";}', '1546063459', '1546063459');
INSERT INTO `yy_auth_item` VALUES ('/admin-user/upload-head-img', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"上传头像\";s:17:\"route_description\";s:12:\"上传头像\";}', '1546063459', '1546063459');
INSERT INTO `yy_auth_item` VALUES ('/menu/*', '2', null, null, 'a:2:{s:10:\"route_name\";s:0:\"\";s:17:\"route_description\";s:0:\"\";}', '1546063459', '1546063459');
INSERT INTO `yy_auth_item` VALUES ('/menu/create', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"添加菜单\";s:17:\"route_description\";s:18:\"添加新的菜单\";}', '1546063459', '1546063459');
INSERT INTO `yy_auth_item` VALUES ('/menu/delete', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"删除菜单\";s:17:\"route_description\";s:12:\"删除菜单\";}', '1546063459', '1546063459');
INSERT INTO `yy_auth_item` VALUES ('/menu/index', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"菜单管理\";s:17:\"route_description\";s:0:\"\";}', '1546063459', '1546063459');
INSERT INTO `yy_auth_item` VALUES ('/menu/menu-list', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"菜单列表\";s:17:\"route_description\";s:12:\"菜单列表\";}', '1546063459', '1546063459');
INSERT INTO `yy_auth_item` VALUES ('/menu/update', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"更新菜单\";s:17:\"route_description\";s:18:\"更新菜单详情\";}', '1546063459', '1546063459');
INSERT INTO `yy_auth_item` VALUES ('/menu/view', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"菜单详情\";s:17:\"route_description\";s:18:\"获取菜单详情\";}', '1546063459', '1546063459');
INSERT INTO `yy_auth_item` VALUES ('/permission/*', '2', null, null, 'a:2:{s:10:\"route_name\";s:0:\"\";s:17:\"route_description\";s:0:\"\";}', '1546063460', '1546063460');
INSERT INTO `yy_auth_item` VALUES ('/permission/assign', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"分配路由\";s:17:\"route_description\";s:21:\"分配路由到权限\";}', '1546063460', '1546063460');
INSERT INTO `yy_auth_item` VALUES ('/permission/create', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"创建权限\";s:17:\"route_description\";s:21:\"创建管理员权限\";}', '1546063460', '1546063460');
INSERT INTO `yy_auth_item` VALUES ('/permission/delete', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"删除权限\";s:17:\"route_description\";s:18:\"删除指定权限\";}', '1546063460', '1546063460');
INSERT INTO `yy_auth_item` VALUES ('/permission/index', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"权限管理\";s:17:\"route_description\";s:12:\"权限管理\";}', '1546063460', '1546063460');
INSERT INTO `yy_auth_item` VALUES ('/permission/list', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"权限列表\";s:17:\"route_description\";s:12:\"所有权限\";}', '1546063460', '1546063460');
INSERT INTO `yy_auth_item` VALUES ('/permission/permission-all', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"所有权限\";s:17:\"route_description\";s:27:\"所有可以分配到权限\";}', '1546063460', '1546063460');
INSERT INTO `yy_auth_item` VALUES ('/permission/permission-ass', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"已有权限\";s:17:\"route_description\";s:24:\"所拥有的权限列表\";}', '1546063460', '1546063460');
INSERT INTO `yy_auth_item` VALUES ('/permission/remove', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"移除权限\";s:17:\"route_description\";s:39:\"移除权限的其他权限或者路由\";}', '1546063460', '1546063460');
INSERT INTO `yy_auth_item` VALUES ('/permission/update', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"更新权限\";s:17:\"route_description\";s:12:\"更新权限\";}', '1546063460', '1546063460');
INSERT INTO `yy_auth_item` VALUES ('/permission/view', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"查看权限\";s:17:\"route_description\";s:18:\"查看权限详情\";}', '1546063460', '1546063460');
INSERT INTO `yy_auth_item` VALUES ('/role/*', '2', null, null, 'a:2:{s:10:\"route_name\";s:0:\"\";s:17:\"route_description\";s:0:\"\";}', '1546063461', '1546063461');
INSERT INTO `yy_auth_item` VALUES ('/role/assign', '2', null, null, 'a:2:{s:10:\"route_name\";s:21:\"分配路由或权限\";s:17:\"route_description\";s:21:\"分配路由到角色\";}', '1546063461', '1546063461');
INSERT INTO `yy_auth_item` VALUES ('/role/create', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"创建角色\";s:17:\"route_description\";s:21:\"创建管理员角色\";}', '1546063460', '1546063460');
INSERT INTO `yy_auth_item` VALUES ('/role/delete', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"删除角色\";s:17:\"route_description\";s:18:\"删除指定角色\";}', '1546063460', '1546063460');
INSERT INTO `yy_auth_item` VALUES ('/role/index', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"角色管理\";s:17:\"route_description\";s:12:\"角色管理\";}', '1546063460', '1546063460');
INSERT INTO `yy_auth_item` VALUES ('/role/list', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"角色列表\";s:17:\"route_description\";s:12:\"角色列表\";}', '1546063460', '1546063460');
INSERT INTO `yy_auth_item` VALUES ('/role/permission-all', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"所有权限\";s:17:\"route_description\";s:27:\"所有可以分配到权限\";}', '1546063461', '1546063461');
INSERT INTO `yy_auth_item` VALUES ('/role/permission-ass', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"已有权限\";s:17:\"route_description\";s:24:\"所拥有的权限列表\";}', '1546063461', '1546063461');
INSERT INTO `yy_auth_item` VALUES ('/role/remove', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"移除权限\";s:17:\"route_description\";s:39:\"移除权限的其他权限或者路由\";}', '1546063461', '1546063461');
INSERT INTO `yy_auth_item` VALUES ('/role/update', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"更新角色\";s:17:\"route_description\";s:24:\"更新指定角色信息\";}', '1546063460', '1546063460');
INSERT INTO `yy_auth_item` VALUES ('/role/view', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"查看角色\";s:17:\"route_description\";s:18:\"查看角色详情\";}', '1546063461', '1546063461');
INSERT INTO `yy_auth_item` VALUES ('/route/*', '2', null, null, 'a:2:{s:10:\"route_name\";s:0:\"\";s:17:\"route_description\";s:0:\"\";}', '1546063462', '1546063462');
INSERT INTO `yy_auth_item` VALUES ('/route/as-index', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"路由管理\";s:17:\"route_description\";s:24:\"获取已有路由列表\";}', '1546063461', '1546063461');
INSERT INTO `yy_auth_item` VALUES ('/route/assign-route', '2', null, null, 'a:2:{s:10:\"route_name\";s:21:\"添加路由到可用\";s:17:\"route_description\";s:21:\"添加路由到可用\";}', '1546063461', '1546063461');
INSERT INTO `yy_auth_item` VALUES ('/route/assigned-list', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"路由列表\";s:17:\"route_description\";s:30:\"获得当前数据库的路由\";}', '1546063461', '1546063461');
INSERT INTO `yy_auth_item` VALUES ('/route/av-index', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"路由管理\";s:17:\"route_description\";s:24:\"获取已有路由列表\";}', '1546063461', '1546063461');
INSERT INTO `yy_auth_item` VALUES ('/route/available-list', '2', null, null, 'a:2:{s:10:\"route_name\";s:21:\"可添加路由列表\";s:17:\"route_description\";s:33:\"获取当前项目支持的路由\";}', '1546063461', '1546063461');
INSERT INTO `yy_auth_item` VALUES ('/route/create', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"添加路由\";s:17:\"route_description\";s:15:\"添加新路由\";}', '1546063461', '1546063461');
INSERT INTO `yy_auth_item` VALUES ('/route/remove-route', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"移出路由\";s:17:\"route_description\";s:27:\"从可用路由列表移除\";}', '1546063461', '1546063461');
INSERT INTO `yy_auth_item` VALUES ('/route/update', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"更新路由\";s:17:\"route_description\";s:18:\"更新路由详情\";}', '1546063461', '1546063461');
INSERT INTO `yy_auth_item` VALUES ('/route/view', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"路由详情\";s:17:\"route_description\";s:18:\"获取路由详情\";}', '1546063461', '1546063461');
INSERT INTO `yy_auth_item` VALUES ('/rule/*', '2', null, null, 'a:2:{s:10:\"route_name\";s:0:\"\";s:17:\"route_description\";s:0:\"\";}', '1546063462', '1546063462');
INSERT INTO `yy_auth_item` VALUES ('/rule/create', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"创建规则\";s:17:\"route_description\";s:18:\"创建访问规则\";}', '1546063462', '1546063462');
INSERT INTO `yy_auth_item` VALUES ('/rule/delete', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"删除规则\";s:17:\"route_description\";s:18:\"删除指定规则\";}', '1546063462', '1546063462');
INSERT INTO `yy_auth_item` VALUES ('/rule/index', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"规则管理\";s:17:\"route_description\";s:12:\"规则管理\";}', '1546063462', '1546063462');
INSERT INTO `yy_auth_item` VALUES ('/rule/list', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"规则列表\";s:17:\"route_description\";s:12:\"规则列表\";}', '1546063462', '1546063462');
INSERT INTO `yy_auth_item` VALUES ('/rule/update', '2', null, null, 'a:2:{s:10:\"route_name\";s:12:\"更新规则\";s:17:\"route_description\";s:24:\"更新指定规则信息\";}', '1546063462', '1546063462');
INSERT INTO `yy_auth_item` VALUES ('/site/*', '2', null, null, 'a:2:{s:10:\"route_name\";s:0:\"\";s:17:\"route_description\";s:0:\"\";}', '1546063462', '1546063462');
INSERT INTO `yy_auth_item` VALUES ('/site/index', '2', null, null, 'a:2:{s:10:\"route_name\";s:0:\"\";s:17:\"route_description\";s:0:\"\";}', '1546063462', '1546063462');
INSERT INTO `yy_auth_item` VALUES ('/site/left-nav', '2', null, null, 'a:2:{s:10:\"route_name\";s:0:\"\";s:17:\"route_description\";s:0:\"\";}', '1552317535', '1552317535');
INSERT INTO `yy_auth_item` VALUES ('/site/login', '2', null, null, 'a:2:{s:10:\"route_name\";s:0:\"\";s:17:\"route_description\";s:0:\"\";}', '1546063462', '1546063462');
INSERT INTO `yy_auth_item` VALUES ('/site/logout', '2', null, null, 'a:2:{s:10:\"route_name\";s:0:\"\";s:17:\"route_description\";s:0:\"\";}', '1546063462', '1546063462');
INSERT INTO `yy_auth_item` VALUES ('/site/main', '2', null, null, 'a:2:{s:10:\"route_name\";s:0:\"\";s:17:\"route_description\";s:0:\"\";}', '1546063462', '1546063462');
INSERT INTO `yy_auth_item` VALUES ('/site/menu', '2', null, null, 'a:2:{s:10:\"route_name\";s:0:\"\";s:17:\"route_description\";s:0:\"\";}', '1546063462', '1546063462');
INSERT INTO `yy_auth_item` VALUES ('/site/nav', '2', null, null, 'a:2:{s:10:\"route_name\";s:0:\"\";s:17:\"route_description\";s:0:\"\";}', '1546063462', '1546063462');
INSERT INTO `yy_auth_item` VALUES ('新的测试', '1', '新的测试角色', null, null, '1545806711', '1545806711');
INSERT INTO `yy_auth_item` VALUES ('新的测试修改', '2', '新的测试2修改', null, null, '1545576515', '1545576584');
INSERT INTO `yy_auth_item` VALUES ('新的测试的子类3', '2', '测试权限ch测试权限ch', '测试规则A', null, '1545815699', '1545992504');
INSERT INTO `yy_auth_item` VALUES ('权限Ao', '2', '权限Ao2', null, null, '1545576911', '1545740136');
INSERT INTO `yy_auth_item` VALUES ('校草', '1', '校草', null, null, '1545808590', '1545808590');

-- ----------------------------
-- Table structure for yy_auth_item_child
-- ----------------------------
DROP TABLE IF EXISTS `yy_auth_item_child`;
CREATE TABLE `yy_auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `yy_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `yy_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yy_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `yy_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色 和 权限对应表';

-- ----------------------------
-- Records of yy_auth_item_child
-- ----------------------------
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/*');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/admin-user/*');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/admin-user/create');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/admin-user/delete');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/admin-user/index');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/admin-user/list');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/admin-user/update');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/admin-user/update-status');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/admin-user/upload-head-img');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/menu/*');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/menu/create');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/menu/delete');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/menu/index');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/menu/menu-list');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/menu/update');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/menu/view');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/permission/*');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/permission/assign');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/permission/create');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/permission/delete');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/permission/index');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/permission/list');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/permission/permission-all');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/permission/permission-ass');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/permission/remove');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/permission/update');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/permission/view');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/role/*');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/role/assign');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/role/create');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/role/delete');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/role/index');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/role/list');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/role/permission-all');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/role/permission-ass');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/role/remove');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/role/update');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/role/view');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/route/*');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/route/as-index');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/route/assign-route');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/route/assigned-list');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/route/av-index');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/route/available-list');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/route/create');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/route/remove-route');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/route/update');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/route/view');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/rule/*');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/rule/create');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/rule/delete');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/rule/index');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/rule/list');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/rule/update');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/site/*');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/site/index');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/site/login');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/site/logout');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/site/main');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/site/menu');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '/site/nav');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '新的测试修改');
INSERT INTO `yy_auth_item_child` VALUES ('权限Ao', '新的测试的子类3');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '新的测试的子类3');
INSERT INTO `yy_auth_item_child` VALUES ('校草', '权限Ao');

-- ----------------------------
-- Table structure for yy_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `yy_auth_rule`;
CREATE TABLE `yy_auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yy_auth_rule
-- ----------------------------
INSERT INTO `yy_auth_rule` VALUES ('route_rule', 'O:30:\"mdm\\admin\\components\\RouteRule\":3:{s:4:\"name\";s:10:\"route_rule\";s:9:\"createdAt\";i:1544611865;s:9:\"updatedAt\";i:1544611865;}', '1544611865', '1544611865');
INSERT INTO `yy_auth_rule` VALUES ('测试规则A', 'O:32:\"backend\\components\\rbac\\BugsRule\":4:{s:4:\"name\";s:13:\"测试规则A\";s:5:\"model\";N;s:9:\"createdAt\";i:1545817537;s:9:\"updatedAt\";i:1545992125;}', '1545817537', '1545992125');

-- ----------------------------
-- Table structure for yy_menu
-- ----------------------------
DROP TABLE IF EXISTS `yy_menu`;
CREATE TABLE `yy_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(256) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  CONSTRAINT `yy_menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `yy_menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yy_menu
-- ----------------------------
INSERT INTO `yy_menu` VALUES ('41', '权限管理', null, '/*', null, '{\"icon\":\"layui-icon-female\"}');
INSERT INTO `yy_menu` VALUES ('42', '管理员列表', '41', '/admin-user/index', null, '{\"icon\":\"layui-icon-camera\"}');
INSERT INTO `yy_menu` VALUES ('43', '权限列表', '41', '/permission/index', null, '{\"icon\":\"layui-icon-diamond\"}');
INSERT INTO `yy_menu` VALUES ('44', '菜单管理', '41', '/menu/index', null, '{\"icon\":\"layui-icon-more\"}');
INSERT INTO `yy_menu` VALUES ('45', '角色列表', '41', '/role/index', null, '{\"icon\":\"layui-icon-star-fill\"}');
INSERT INTO `yy_menu` VALUES ('47', '会员列表', null, '/admin-user/index', null, '{\"icon\":\"layui-icon-play\"}');
INSERT INTO `yy_menu` VALUES ('50', '已有路由', '41', '/route/av-index', null, '{\"icon\":\"layui-icon-more\"}');
INSERT INTO `yy_menu` VALUES ('51', '路由管理', '41', '/route/as-index', null, '{\"icon\":\"layui-icon-engine\"}');
