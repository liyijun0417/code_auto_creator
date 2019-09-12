/*
Navicat MySQL Data Transfer

Source Server         : 测试环境数据库
Source Server Version : 50723
Source Host           : 118.190.156.160:3306
Source Database       : pdd_platform

Target Server Type    : MYSQL
Target Server Version : 50723
File Encoding         : 65001

Date: 2019-01-14 11:34:09
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `sys_user_info`
-- ----------------------------
DROP TABLE IF EXISTS `sys_user_info`;
CREATE TABLE `sys_user_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1：正常；2：禁用',
  `role` int(11) NOT NULL DEFAULT '0' COMMENT '角色',
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `last_login_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of sys_user_info
-- ----------------------------
INSERT INTO `sys_user_info` VALUES ('2', 'xiaoxiao', '48058e0c99bf7d689ce71c360699a14ce2f99774', '1', '1', '2018-08-08 11:24:41', '2018-08-21 16:38:58', '1970-01-01 00:00:00');
INSERT INTO `sys_user_info` VALUES ('3', 'miss', '48058e0c99bf7d689ce71c360699a14ce2f99774', '1', '6', '2018-08-08 11:28:56', '2018-08-21 18:43:49', '2019-01-10 09:55:08');
INSERT INTO `sys_user_info` VALUES ('4', 'sissixiao', '7c4a8d09ca3762af61e59520943dc26494f8941b', '1', '6', '2018-08-09 14:52:53', '2018-08-21 18:43:13', '1970-01-01 00:00:00');
INSERT INTO `sys_user_info` VALUES ('5', 'chenging', 'ae25b7bc18ba6691e93ad26f02c4136c90668798', '1', '0', '2018-08-13 18:59:24', '2018-08-13 18:59:24', '1970-01-01 00:00:00');
INSERT INTO `sys_user_info` VALUES ('6', 'daming', '8f02325782c8b3f1b071c412cefc3ed93d4aba28', '1', '6', '2018-10-19 17:10:14', '2018-10-19 17:10:14', '1970-01-01 00:00:00');
