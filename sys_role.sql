/*
Navicat MySQL Data Transfer

Source Server         : 测试环境数据库
Source Server Version : 50723
Source Host           : 118.190.156.160:3306
Source Database       : pdd_platform

Target Server Type    : MYSQL
Target Server Version : 50723
File Encoding         : 65001

Date: 2019-01-14 11:34:17
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `sys_role`
-- ----------------------------
DROP TABLE IF EXISTS `sys_role`;
CREATE TABLE `sys_role` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `status` tinyint(1) unsigned DEFAULT '1' COMMENT '是否激活 1：是 0：否',
  `authstr` longtext COMMENT '权限明文',
  `authcode` longtext COMMENT '权限密文',
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of sys_role
-- ----------------------------
INSERT INTO `sys_role` VALUES ('1', '测试角色1', '1', '添加推广,媒体列表,推广列表', '1677b36d480706c9900aade2b2adeae8,1f22b9dd6a84d4edd850b6d5307932f8,2c7f194cd5547f3d6a0630bb1e65fb1f', '2018-08-21 18:12:57');
INSERT INTO `sys_role` VALUES ('5', '测试角色2', '1', '媒体列表', '1677b36d480706c9900aade2b2adeae8', '2018-08-21 16:17:19');
INSERT INTO `sys_role` VALUES ('6', '超级管理员', '1', '添加媒体,添加推广,媒体列表,推广列表,推广状态管理,修改推广,删除推广,修改媒体,设置广告位状态,删除媒体,推广数据,广告位数据,导出Excel(推广数据),推广数据(按日期查看),推广数据(按媒体查看),导出Excel(推广数据-日期查看),导出Excel(推广数据-媒体查看),广告位数据(按日期查看),广告位数据(按推广查看),导出Excel(广告位数据),导出Excel(广告位数据-按日期查看),导出Excel(广告位数据-按推广查看),分类列表,新增分类,编辑分类,删除分类,分级列表,新增分级,编辑分级,删除分级,用户列表,新增账号,编辑账号,删除账号,开启/禁用 账号,角色列表,新增角色,权限分配,为角色指定权限,添加权限节点,删除角色', 'a8a5b6a72e42beaa61bc2f54ecf6551e,1677b36d480706c9900aade2b2adeae8,dbfa0b5b4c3b003cdd2382a2586e98d1,1deee5ff8faed76d4f52d59165166ef8,01c8bd4fd04ed346c4c712a2bac3ec5b,1f22b9dd6a84d4edd850b6d5307932f8,2c7f194cd5547f3d6a0630bb1e65fb1f,137ea601d2532e361b476904c3222255,bc2435ccf375db14b2e68e73fc68dad8,4b5acbe38540e65020652d8f95a6ecf5,cc191af8b21b6e1322cd687dade49945,c54eaca45f1907b1c427055583d70f26,23d844c0336f2ee2d98b6486ca23c085,b8e439b2d5c2cc2e7f08389f93a000d3,8ccb297e2ea636b58c893690a1741e7b,43d6e2573bf8105c68f45de6aa1ca76b,2eaf658b25b0c07f76052971d9d8d04d,0db5c9b2ecc9145bd5a8f16ff4cfa098,f24bd18613ffddec2be577ba3fb0e062,669004f882d587c0f492939ef2045081,7b3440c1d63ac2023dd5e2dd148c1338,dba46cfbd261737e5005734fcd735c88,051de86255d9bf1fece79a5b7e4b04c5,3775706aa7e1044bd36815fba04b4d03,7574a9ff33632592b76f6f03ae36c01c,1db74109df7fae30f3837bbba2e409ef,21d33299c624cb4cd90ea3a2e866d2eb,9de4571a607d67e614434fd2c23c7351,e38e175b15f6e37d6358e319c4d5bec6,56b1e2944561a97f77b9e369cdd984ac,9e90bf4a9d9b50130b473b74dbbd93d3,eb9154bc3e9efc43b098570a9b93526d,771899015298d6b409edfa293c5c7958,881699a25f013f65c2048dbdb2bbd8e4,4e64e2b83987d03fe98680be684dcf55,0689c84f7af862991b2855e8faf4b174,f6ee6add2db866918da7a360fa2d130d,a47d96ddac9176907ba4605ac049d0ac,6f2faa4f03c8dac43c9a7552ab1f1a8d,a55515085d4e46ca6fc777e3b3d77a72,822fed3e3572bcd7d0a7d7dd156a233f', '2018-08-21 18:42:45');
