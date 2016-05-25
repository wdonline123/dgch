/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : dinhgiacanho

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2015-08-31 21:47:45
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for accounts
-- ----------------------------
DROP TABLE IF EXISTS `accounts`;
CREATE TABLE `accounts` (
  `account_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fullname` varchar(100) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `modify_date` datetime DEFAULT NULL,
  `isactive` tinyint(1) DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL COMMENT '1:Male, 2:Female',
  `birthday` date DEFAULT NULL,
  `facebook_id` int(11) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `interests` varchar(200) DEFAULT NULL,
  `introduction` varchar(4000) DEFAULT NULL,
  `mobile` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for admin_user
-- ----------------------------
DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE `admin_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `isactive` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for apartment
-- ----------------------------
DROP TABLE IF EXISTS `apartment`;
CREATE TABLE `apartment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `name_url` varchar(200) DEFAULT NULL,
  `picture` varchar(100) DEFAULT NULL,
  `isactive` tinyint(1) DEFAULT '0',
  `user_admin` int(11) DEFAULT '0',
  `number_view` int(11) DEFAULT '0',
  `number_like` int(11) DEFAULT '0',
  `number_comment` int(11) DEFAULT '0',
  `city` int(11) DEFAULT NULL,
  `district` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `modify_date` datetime DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL COMMENT 'Vị trí, địa chỉ',
  `introduction` text,
  `utility` text,
  `min_price` decimal(10,0) DEFAULT NULL,
  `max_price` decimal(10,0) DEFAULT NULL,
  `folder` varchar(100) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for comments
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `comment_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `comment_content` varchar(4000) DEFAULT NULL,
  `comment_parent` int(11) DEFAULT '0',
  `create_date` datetime DEFAULT NULL,
  `isactive` tinyint(1) DEFAULT '0',
  `account_id` int(11) DEFAULT NULL,
  `fullname` varchar(200) DEFAULT NULL,
  `avatar` varchar(200) DEFAULT NULL,
  `object_id` int(11) DEFAULT NULL,
  `object_type` tinyint(1) DEFAULT '0' COMMENT '1:Article, 2:Product, 3:Group',
  `number_like` int(11) DEFAULT '0',
  `number_comment` int(11) DEFAULT '0',
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=282 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for likes
-- ----------------------------
DROP TABLE IF EXISTS `likes`;
CREATE TABLE `likes` (
  `like_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `fullname` varchar(200) DEFAULT NULL,
  `avatar` varchar(200) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `object_id` int(11) DEFAULT NULL,
  `comment_id` int(11) DEFAULT '0',
  `object_type` tinyint(1) DEFAULT '0' COMMENT '1:Article, 2:Product, 3:Group',
  PRIMARY KEY (`like_id`)
) ENGINE=MyISAM AUTO_INCREMENT=324 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for location
-- ----------------------------
DROP TABLE IF EXISTS `location`;
CREATE TABLE `location` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `parent` int(11) DEFAULT '0',
  `isactive` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
