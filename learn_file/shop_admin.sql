/*
 Navicat Premium Data Transfer

 Source Server         : 本机3306
 Source Server Type    : MySQL
 Source Server Version : 100410
 Source Host           : localhost:3306
 Source Schema         : test

 Target Server Type    : MySQL
 Target Server Version : 100410
 File Encoding         : 65001

 Date: 20/04/2020 19:38:59
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for shop_admin
-- ----------------------------
DROP TABLE IF EXISTS `shop_admin`;
CREATE TABLE `shop_admin`  (
  `uid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `account` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '账户',
  `password` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '密码',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '姓名',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态 1开启 2关闭',
  `add_time` int(10) UNSIGNED NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`uid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '后台管理员' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of shop_admin
-- ----------------------------
INSERT INTO `shop_admin` VALUES (1, 'ouyangke', 'e10adc3949ba59abbe56e057f20f883e', '欧阳克', 1, 1576080000);

-- ----------------------------
-- Table structure for shop_cat
-- ----------------------------
DROP TABLE IF EXISTS `shop_cat`;
CREATE TABLE `shop_cat`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '分类名',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态 1开启 2关闭',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '分类表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of shop_cat
-- ----------------------------
INSERT INTO `shop_cat` VALUES (1, '女装', 1);
INSERT INTO `shop_cat` VALUES (2, '男装', 1);
INSERT INTO `shop_cat` VALUES (3, '孕产', 1);
INSERT INTO `shop_cat` VALUES (4, '童装', 1);
INSERT INTO `shop_cat` VALUES (5, '电视', 1);
INSERT INTO `shop_cat` VALUES (6, '手机', 1);
INSERT INTO `shop_cat` VALUES (7, '电脑', 1);

-- ----------------------------
-- Table structure for shop_goods
-- ----------------------------
DROP TABLE IF EXISTS `shop_goods`;
CREATE TABLE `shop_goods`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT ' 商品ID',
  `cat` int(10) UNSIGNED NOT NULL DEFAULT 1 COMMENT '分类ID',
  `title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '商品标题',
  `price` double(10, 2) UNSIGNED NOT NULL COMMENT '价格',
  `discount` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '折扣',
  `stock` int(10) UNSIGNED NOT NULL DEFAULT 1 COMMENT '库存',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态 1开启 2关闭 3删除',
  `add_time` int(10) UNSIGNED NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '商品表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of shop_goods
-- ----------------------------
INSERT INTO `shop_goods` VALUES (1, 1, '云朵般轻盈的仙女裙 高级钉珠收腰长裙 气质无袖连衣裙', 279.99, 0, 1100, 1, 1576080000);
INSERT INTO `shop_goods` VALUES (2, 1, '高冷御姐风灯芯绒a字连衣裙女秋冬2019年新款收腰显瘦复古裙子', 255.90, 0, 100, 1, 1576080000);

-- ----------------------------
-- Table structure for shop_menu
-- ----------------------------
DROP TABLE IF EXISTS `shop_menu`;
CREATE TABLE `shop_menu`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '菜单名',
  `fid` int(10) NOT NULL COMMENT '父ID',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态 1开启 2关闭',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '左侧菜单表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of shop_menu
-- ----------------------------
INSERT INTO `shop_menu` VALUES (1, '商品管理', 0, 1);
INSERT INTO `shop_menu` VALUES (2, '商品列表', 1, 1);
INSERT INTO `shop_menu` VALUES (3, '商品分类', 1, 1);
INSERT INTO `shop_menu` VALUES (4, '用户管理', 0, 1);
INSERT INTO `shop_menu` VALUES (5, '用户列表', 4, 1);
INSERT INTO `shop_menu` VALUES (6, '购物车', 4, 1);
INSERT INTO `shop_menu` VALUES (7, '用户地址', 4, 1);
INSERT INTO `shop_menu` VALUES (8, '订单管理', 4, 1);
INSERT INTO `shop_menu` VALUES (9, '后台管理', 0, 1);
INSERT INTO `shop_menu` VALUES (10, '管理员列表', 9, 1);
INSERT INTO `shop_menu` VALUES (11, '个人中心', 9, 1);
INSERT INTO `shop_menu` VALUES (12, '左侧菜单', 9, 1);

SET FOREIGN_KEY_CHECKS = 1;
