/*
Navicat MySQL Data Transfer

Source Server         : 测试环境数据库
Source Server Version : 50723
Source Host           : 118.190.156.160:3306
Source Database       : pdd_platform

Target Server Type    : MYSQL
Target Server Version : 50723
File Encoding         : 65001

Date: 2019-01-14 11:34:23
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `sys_node`
-- ----------------------------
DROP TABLE IF EXISTS `sys_node`;
CREATE TABLE `sys_node` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '节点名称',
  `title` varchar(150) NOT NULL COMMENT '名称说明',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否激活 1:是 2：没',
  `level` tinyint(1) NOT NULL COMMENT '节点等级',
  `module` varchar(255) NOT NULL DEFAULT 'App',
  `controller` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `code` char(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of sys_node
-- ----------------------------
INSERT INTO `sys_node` VALUES ('1', 'Admin-MpInfo', '媒体管理', '1', '2', 'Admin', 'MpInfo', null, '408902f2452978589b8ad922e853ce60');
INSERT INTO `sys_node` VALUES ('2', 'Admin-MpInfo-add', '添加媒体', '1', '3', 'Admin', 'MpInfo', 'add', 'a8a5b6a72e42beaa61bc2f54ecf6551e');
INSERT INTO `sys_node` VALUES ('3', 'Admin-adxDeliveryRule', '推广管理', '1', '2', 'Admin', 'adxDeliveryRule', null, 'fedee966277bb2e061d4e87c39e9b456');
INSERT INTO `sys_node` VALUES ('4', 'Admin-adxDeliveryRule-add', '添加推广', '1', '3', 'Admin', 'adxDeliveryRule', 'add', '1f22b9dd6a84d4edd850b6d5307932f8');
INSERT INTO `sys_node` VALUES ('5', 'Admin-MpInfo-all', '媒体列表', '1', '3', 'Admin', 'MpInfo', 'all', '1677b36d480706c9900aade2b2adeae8');
INSERT INTO `sys_node` VALUES ('6', 'Admin-adxDeliveryRule-all', '推广列表', '1', '3', 'Admin', 'adxDeliveryRule', 'all', '2c7f194cd5547f3d6a0630bb1e65fb1f');
INSERT INTO `sys_node` VALUES ('7', 'Admin-adxDeliveryRule-infoType', '推广状态管理', '1', '3', 'Admin', 'adxDeliveryRule', 'infoType', '137ea601d2532e361b476904c3222255');
INSERT INTO `sys_node` VALUES ('8', 'Admin-adxDeliveryRule-edit', '修改推广', '1', '3', 'Admin', 'adxDeliveryRule', 'edit', 'bc2435ccf375db14b2e68e73fc68dad8');
INSERT INTO `sys_node` VALUES ('9', 'Admin-adxDeliveryRule-delete', '删除推广', '1', '3', 'Admin', 'adxDeliveryRule', 'delete', '4b5acbe38540e65020652d8f95a6ecf5');
INSERT INTO `sys_node` VALUES ('10', 'Admin-MpInfo-edit', '修改媒体', '1', '3', 'Admin', 'MpInfo', 'edit', 'dbfa0b5b4c3b003cdd2382a2586e98d1');
INSERT INTO `sys_node` VALUES ('11', 'Admin-MpInfo-setStatus', '设置广告位状态', '1', '3', 'Admin', 'MpInfo', 'setStatus', '1deee5ff8faed76d4f52d59165166ef8');
INSERT INTO `sys_node` VALUES ('12', 'Admin-MpInfo-delete', '删除媒体', '1', '3', 'Admin', 'MpInfo', 'delete', '01c8bd4fd04ed346c4c712a2bac3ec5b');
INSERT INTO `sys_node` VALUES ('13', 'Admin-total', '数据报表', '1', '2', 'Admin', 'total', null, 'bd98ce0b462a5fb1226c90d98b16282e');
INSERT INTO `sys_node` VALUES ('14', 'Admin-total-all', '推广数据', '1', '3', 'Admin', 'total', 'all', 'cc191af8b21b6e1322cd687dade49945');
INSERT INTO `sys_node` VALUES ('15', 'Admin-total-adunit', '广告位数据', '1', '3', 'Admin', 'total', 'adunit', 'c54eaca45f1907b1c427055583d70f26');
INSERT INTO `sys_node` VALUES ('16', 'Admin-total-downloadExcel', '导出Excel(推广数据)', '1', '3', 'Admin', 'total', 'downloadExcel', '23d844c0336f2ee2d98b6486ca23c085');
INSERT INTO `sys_node` VALUES ('17', 'Admin-total-totalTime', '推广数据(按日期查看)', '1', '3', 'Admin', 'total', 'totalTime', 'b8e439b2d5c2cc2e7f08389f93a000d3');
INSERT INTO `sys_node` VALUES ('18', 'Admin-total-totalMp', '推广数据(按媒体查看)', '1', '3', 'Admin', 'total', 'totalMp', '8ccb297e2ea636b58c893690a1741e7b');
INSERT INTO `sys_node` VALUES ('19', 'Admin-total-downloadExcelByDate', '导出Excel(推广数据-日期查看)', '1', '3', 'Admin', 'total', 'downloadExcelByDate', '43d6e2573bf8105c68f45de6aa1ca76b');
INSERT INTO `sys_node` VALUES ('20', 'Admin-total-downloadExcelByMp', '导出Excel(推广数据-媒体查看)', '1', '3', 'Admin', 'total', 'downloadExcelByMp', '2eaf658b25b0c07f76052971d9d8d04d');
INSERT INTO `sys_node` VALUES ('21', 'Admin-total-adunitByTime', '广告位数据(按日期查看)', '1', '3', 'Admin', 'total', 'adunitByTime', '0db5c9b2ecc9145bd5a8f16ff4cfa098');
INSERT INTO `sys_node` VALUES ('22', 'Admin-total-adunitByMp', '广告位数据(按推广查看)', '1', '3', 'Admin', 'total', 'adunitByMp', 'f24bd18613ffddec2be577ba3fb0e062');
INSERT INTO `sys_node` VALUES ('23', 'Admin-total-downloadExcelByAdunit', '导出Excel(广告位数据)', '1', '3', 'Admin', 'total', 'downloadExcelByAdunit', '669004f882d587c0f492939ef2045081');
INSERT INTO `sys_node` VALUES ('24', 'Admin-total-adunitByDate', '导出Excel(广告位数据-按日期查看)', '1', '3', 'Admin', 'total', 'adunitByDate', '7b3440c1d63ac2023dd5e2dd148c1338');
INSERT INTO `sys_node` VALUES ('25', 'Admin-total-adunitExcelByMp', '导出Excel(广告位数据-按推广查看)', '1', '3', 'Admin', 'total', 'adunitExcelByMp', 'dba46cfbd261737e5005734fcd735c88');
INSERT INTO `sys_node` VALUES ('26', 'Admin-SysMpCategory', '分类管理', '1', '2', 'Admin', 'SysMpCategory', null, 'bc4ecc45cbdfb9d71b8687ecf4ed0df3');
INSERT INTO `sys_node` VALUES ('27', 'Admin-SysMpCategory-all', '分类列表', '1', '3', 'Admin', 'SysMpCategory', 'all', '051de86255d9bf1fece79a5b7e4b04c5');
INSERT INTO `sys_node` VALUES ('28', 'Admin-SysMpCategory-add', '新增分类', '1', '3', 'Admin', 'SysMpCategory', 'add', '3775706aa7e1044bd36815fba04b4d03');
INSERT INTO `sys_node` VALUES ('29', 'Admin-SysMpCategory-edit', '编辑分类', '1', '3', 'Admin', 'SysMpCategory', 'edit', '7574a9ff33632592b76f6f03ae36c01c');
INSERT INTO `sys_node` VALUES ('30', 'Admin-SysMpCategory-delete', '删除分类', '1', '3', 'Admin', 'SysMpCategory', 'delete', '1db74109df7fae30f3837bbba2e409ef');
INSERT INTO `sys_node` VALUES ('31', 'Admin-SysMpLevel', '分级管理', '1', '2', 'Admin', 'SysMpLevel', null, '4a67d2a629b2bc3a5b8671d7176f727f');
INSERT INTO `sys_node` VALUES ('32', 'Admin-SysMpLevel-all', '分级列表', '1', '3', 'Admin', 'SysMpLevel', 'all', '21d33299c624cb4cd90ea3a2e866d2eb');
INSERT INTO `sys_node` VALUES ('33', 'Admin-SysMpLevel-add', '新增分级', '1', '3', 'Admin', 'SysMpLevel', 'add', '9de4571a607d67e614434fd2c23c7351');
INSERT INTO `sys_node` VALUES ('34', 'Admin-SysMpLevel-edit', '编辑分级', '1', '3', 'Admin', 'SysMpLevel', 'edit', 'e38e175b15f6e37d6358e319c4d5bec6');
INSERT INTO `sys_node` VALUES ('35', 'Admin-SysMpLevel-delete', '删除分级', '1', '3', 'Admin', 'SysMpLevel', 'delete', '56b1e2944561a97f77b9e369cdd984ac');
INSERT INTO `sys_node` VALUES ('36', 'Admin-SysUserInfo', '账号管理', '1', '2', 'Admin', 'SysUserInfo', null, '1ba5b2e8fd16df7116b488888b742d19');
INSERT INTO `sys_node` VALUES ('37', 'Admin-SysUserInfo-all', '用户列表', '1', '3', 'Admin', 'SysUserInfo', 'all', '9e90bf4a9d9b50130b473b74dbbd93d3');
INSERT INTO `sys_node` VALUES ('38', 'Admin-SysUserInfo-add', '新增账号', '1', '3', 'Admin', 'SysUserInfo', 'add', 'eb9154bc3e9efc43b098570a9b93526d');
INSERT INTO `sys_node` VALUES ('39', 'Admin-SysUserInfo-edit', '编辑账号', '1', '3', 'Admin', 'SysUserInfo', 'edit', '771899015298d6b409edfa293c5c7958');
INSERT INTO `sys_node` VALUES ('40', 'Admin-SysUserInfo-delete', '删除账号', '1', '3', 'Admin', 'SysUserInfo', 'delete', '881699a25f013f65c2048dbdb2bbd8e4');
INSERT INTO `sys_node` VALUES ('41', 'Admin-SysUserInfo-userType', '开启/禁用 账号', '1', '3', 'Admin', 'SysUserInfo', 'userType', '4e64e2b83987d03fe98680be684dcf55');
INSERT INTO `sys_node` VALUES ('42', 'Admin-SysRole', '角色权限管理', '1', '2', 'Admin', 'SysRole', null, 'f7285ff4a5586a9236c8656f0481128f');
INSERT INTO `sys_node` VALUES ('43', 'Admin-SysRole-all', '角色列表', '1', '3', 'Admin', 'SysRole', 'all', '0689c84f7af862991b2855e8faf4b174');
INSERT INTO `sys_node` VALUES ('44', 'Admin-SysRole-add', '新增角色', '1', '3', 'Admin', 'SysRole', 'add', 'f6ee6add2db866918da7a360fa2d130d');
INSERT INTO `sys_node` VALUES ('45', 'Admin-SysRole-access', '权限分配', '1', '3', 'Admin', 'SysRole', 'access', 'a47d96ddac9176907ba4605ac049d0ac');
INSERT INTO `sys_node` VALUES ('46', 'Admin-SysRole-setAccess', '为角色指定权限', '1', '3', 'Admin', 'SysRole', 'setAccess', '6f2faa4f03c8dac43c9a7552ab1f1a8d');
INSERT INTO `sys_node` VALUES ('47', 'Admin-SysRole-node', '添加权限节点', '1', '3', 'Admin', 'SysRole', 'node', 'a55515085d4e46ca6fc777e3b3d77a72');
INSERT INTO `sys_node` VALUES ('48', 'Admin-SysRole-delete', '删除角色', '1', '3', 'Admin', 'SysRole', 'delete', '822fed3e3572bcd7d0a7d7dd156a233f');
