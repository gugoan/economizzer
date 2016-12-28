
SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `cashbook`
-- ----------------------------
DROP TABLE IF EXISTS `cashbook`;
CREATE TABLE `cashbook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` float NOT NULL,
  `description` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `is_pending` tinyint(1) NOT NULL DEFAULT '0',
  `attachment` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `inc_datetime` datetime DEFAULT NULL COMMENT 'insert date',
  `edit_datetime` datetime DEFAULT NULL COMMENT 'edit date',
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tb_cashbook_tb_user1_idx` (`user_id`),
  KEY `fk_tb_cashbook_tb_category1_idx` (`category_id`),
  KEY `fk_tb_cashbook_tb_type1_idx` (`type_id`),
  CONSTRAINT `fk_tb_cashbook_tb_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id_category`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_cashbook_tb_type1` FOREIGN KEY (`type_id`) REFERENCES `type` (`id_type`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_cashbook_tb_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=611 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Control financial movement';


-- ----------------------------
-- Table structure for `category`
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id_category` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `desc_category` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `hexcolor_category` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_active` int(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id_category`),
  KEY `fk_tb_category_tb_user1_idx` (`user_id`),
  CONSTRAINT `fk_tb_category_tb_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1010 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Categories of entries: Water, light, card, etc.';


-- ----------------------------
-- Table structure for `profile`
-- ----------------------------
DROP TABLE IF EXISTS `profile`;
CREATE TABLE `profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `language` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en',
  `startpage` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'cashbook/index',
  `currencycode` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'USD',
  `decimalseparator` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '.',
  PRIMARY KEY (`id`),
  KEY `tb_profile_user_id` (`user_id`) USING BTREE,
  CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=158 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of profile
-- ----------------------------
INSERT INTO `profile` VALUES ('1', '1', '2015-01-25 02:53:12', null, 'the one', 'en', 'cashbook/index','USD','.');
INSERT INTO `profile` VALUES ('3', '3', '2015-02-14 03:03:28', '2015-12-24 19:55:40', 'Joe Mac', 'pt', 'cashbook/index','USD','.');

-- ----------------------------
-- Table structure for `role`
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `can_admin` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES ('1', 'Admin', '2015-01-25 02:53:11', null, '1');
INSERT INTO `role` VALUES ('2', 'User', '2015-01-25 02:53:11', null, '0');

-- ----------------------------
-- Table structure for `type`
-- ----------------------------
DROP TABLE IF EXISTS `type`;
CREATE TABLE `type` (
  `id_type` int(11) NOT NULL AUTO_INCREMENT,
  `desc_type` varchar(45) CHARACTER SET latin1 NOT NULL,
  `hexcolor_type` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `icon_type` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id_type`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Movement Type: Debit, Credit';

-- ----------------------------
-- Records of type
-- ----------------------------
INSERT INTO `type` VALUES ('1', 'Revenue', '#18bc9c', '');
INSERT INTO `type` VALUES ('2', 'Expense', '#e74c3c', '');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `status` smallint(6) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `new_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `api_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `login_ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `login_time` timestamp NULL DEFAULT NULL,
  `create_ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `ban_time` timestamp NULL DEFAULT NULL,
  `ban_reason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tb_user_email` (`email`) USING BTREE,
  UNIQUE KEY `tb_user_username` (`username`) USING BTREE,
  KEY `tb_user_role_id` (`role_id`) USING BTREE,
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=158 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', '1', '1', 'neo@neo.com', null, 'administrador', '$2y$13$cRwqEDU2Elh6KLYfPzLVkuoGwNlUvi8JEUSHXc.0gMQ1fd4IqQSFm', 'ub1TTuSVSATn3NXbuVh4bhR-m2EXgVT0', 'Ahc7a0TXH6Gqe_8GTi1UlZEWVxHsOLcv', '189.3.54.36', '2015-10-23 01:13:36', null, '2015-01-25 02:53:12', '2015-10-06 06:24:53', null, null);
INSERT INTO `user` VALUES ('3', '2', '1', 'joe@mymail.com', null, 'joe', '$2y$13$35B0rxLTERV8nMkmL613oeCHbOs7/2dAhCd3UhIrw44tWmcQKOE9C', 'qA_US4c8xUCucUDWXyYC-SA1qcxCiGTV', 'GWQuKuPFhAJTjE8GL5w2tvaveKs1Bvno', '127.0.0.1', '2015-12-26 20:37:20', '127.0.0.1', '2015-02-14 03:03:28', '2015-10-09 17:05:45', null, null);

-- ----------------------------
-- Table structure for `user_auth`
-- ----------------------------
DROP TABLE IF EXISTS `user_auth`;
CREATE TABLE `user_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `provider_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `provider_attributes` text COLLATE utf8_unicode_ci NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tb_user_auth_provider_id` (`provider_id`) USING BTREE,
  KEY `tb_user_auth_user_id` (`user_id`) USING BTREE,
  CONSTRAINT `user_auth_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for `user_key`
-- ----------------------------
DROP TABLE IF EXISTS `user_key`;
CREATE TABLE `user_key` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  `key_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `consume_time` timestamp NULL DEFAULT NULL,
  `expire_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tb_user_key_key` (`key_value`) USING BTREE,
  KEY `tb_user_key_user_id` (`user_id`) USING BTREE,
  CONSTRAINT `user_key_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of user_key
-- ----------------------------
INSERT INTO `user_key` VALUES ('1', '3', '1', 'fgX4vB8x1UW8uGdCaKQTj9kKo7Kfbltp', '2015-02-14 03:03:28', null, null);
INSERT INTO `user_key` VALUES ('3', '3', '2', 'jkApCoj4zQ1osBGZ6gEwIJ9zgLeiOFxb', '2015-04-21 19:15:00', null, '2015-10-09 17:05:45');
