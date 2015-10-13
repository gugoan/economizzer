# ************************************************************
# Sequel Pro SQL dump
# Version 4499
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 10.0.21-MariaDB)
# Database: economizzer_export
# Generation Time: 2015-10-13 15:43:03 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table tb_account
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tb_account`;

CREATE TABLE `tb_account` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL,
  `currency_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `currency_id` (`currency_id`),
  CONSTRAINT `tb_account_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tb_account_ibfk_2` FOREIGN KEY (`currency_id`) REFERENCES `tb_currency` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table tb_cashbook
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tb_cashbook`;

CREATE TABLE `tb_cashbook` (
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
  CONSTRAINT `fk_tb_cashbook_tb_category1` FOREIGN KEY (`category_id`) REFERENCES `tb_category` (`id_category`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_cashbook_tb_type1` FOREIGN KEY (`type_id`) REFERENCES `tb_type` (`id_type`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_cashbook_tb_user1` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Control financial movement';

LOCK TABLES `tb_cashbook` WRITE;
/*!40000 ALTER TABLE `tb_cashbook` DISABLE KEYS */;

INSERT INTO `tb_cashbook` (`id`, `value`, `description`, `date`, `is_pending`, `attachment`, `inc_datetime`, `edit_datetime`, `user_id`, `category_id`, `type_id`)
VALUES
	(181,-355,'Test','2015-02-13',1,NULL,'2015-02-14 03:28:16','2015-02-14 03:29:31',3,17,2),
	(182,2200,'teste','2015-02-11',0,NULL,'2015-02-14 03:30:33',NULL,3,18,1),
	(183,1200,'test','2015-02-23',0,NULL,'2015-02-24 18:05:13','2015-03-03 21:30:57',3,20,1),
	(184,-189.8,'Included medical consultation','2015-03-01',0,NULL,'2015-03-05 02:10:37','2015-03-05 02:11:44',3,19,2),
	(185,2850,'add bonus','2015-03-03',0,'gFKffgkWmStCeqqCTmitq9LiilqpD5nd.jpg','2015-03-05 02:11:36','2015-03-05 02:18:18',3,22,1),
	(186,1800,'','2015-03-01',1,NULL,'2015-03-05 02:12:08','2015-03-07 23:19:26',3,20,1),
	(187,-950,'Add previous month','2015-03-03',0,NULL,'2015-03-05 02:13:14',NULL,3,17,2),
	(188,1900,'','2015-03-05',0,NULL,'2015-03-05 02:13:58',NULL,3,18,1),
	(189,-300,'','2015-03-10',0,NULL,'2015-03-05 02:14:28','2015-03-05 02:16:45',3,21,2),
	(190,-150,'Online purchase..','2015-03-11',0,NULL,'2015-03-05 02:15:22',NULL,3,23,2),
	(191,-125.59,'Shopping for party :)','2015-02-18',0,NULL,'2015-03-05 02:16:28','2015-03-30 02:02:58',3,21,2),
	(192,-49.95,'Attach','2015-03-10',0,'u3bxLcAnrib3Mz-7TyssKTN7jAExz0Qi.pdf','2015-03-05 04:04:02',NULL,3,23,2),
	(193,-500,'Lie day!!','2015-04-01',0,NULL,'2015-03-30 01:04:23',NULL,3,19,2),
	(194,800,'test chart','2015-04-08',0,NULL,'2015-03-31 03:29:56','2015-03-31 03:30:27',3,18,1),
	(197,1700,'Huh, just a test! ','2015-01-14',0,NULL,'2015-04-07 03:04:06',NULL,3,18,1);

/*!40000 ALTER TABLE `tb_cashbook` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tb_category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tb_category`;

CREATE TABLE `tb_category` (
  `id_category` int(11) NOT NULL AUTO_INCREMENT,
  `desc_category` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `hexcolor_category` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id_category`),
  KEY `fk_tb_category_tb_user1_idx` (`user_id`),
  CONSTRAINT `fk_tb_category_tb_user1` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Categories of entries: Water, light, card, etc.';

LOCK TABLES `tb_category` WRITE;
/*!40000 ALTER TABLE `tb_category` DISABLE KEYS */;

INSERT INTO `tb_category` (`id_category`, `desc_category`, `hexcolor_category`, `user_id`)
VALUES
	(17,'Rent Apartment','#274e13',3),
	(18,'Retirement','#cc4125',3),
	(19,'Health Plan','#a61c00',3),
	(20,'Pension','#6aa84f',3),
	(21,'Supermarket','#e06666',3),
	(22,'Employment Fixed','#3c78d8',3),
	(23,'Others','#674ea7',3);

/*!40000 ALTER TABLE `tb_category` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tb_currency
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tb_currency`;

CREATE TABLE `tb_currency` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `short_name` varchar(10) DEFAULT NULL,
  `iso_code` varchar(3) NOT NULL DEFAULT '',
  `currency_rate` decimal(10,0) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `tb_currency_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table tb_migration
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tb_migration`;

CREATE TABLE `tb_migration` (
  `version` varchar(180) CHARACTER SET latin1 NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `tb_migration` WRITE;
/*!40000 ALTER TABLE `tb_migration` DISABLE KEYS */;

INSERT INTO `tb_migration` (`version`, `apply_time`)
VALUES
	('m000000_000000_base',1422150778),
	('m140524_153638_init_user',1422150792),
	('m140524_153642_init_user_auth',1422150793);

/*!40000 ALTER TABLE `tb_migration` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tb_profile
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tb_profile`;

CREATE TABLE `tb_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `language` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en',
  PRIMARY KEY (`id`),
  KEY `tb_profile_user_id` (`user_id`) USING BTREE,
  CONSTRAINT `tb_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `tb_profile` WRITE;
/*!40000 ALTER TABLE `tb_profile` DISABLE KEYS */;

INSERT INTO `tb_profile` (`id`, `user_id`, `create_time`, `update_time`, `full_name`, `language`)
VALUES
	(1,1,'2015-01-25 04:53:12',NULL,'the one','en'),
	(3,3,'2015-02-14 05:03:28','2015-04-21 22:18:29','Joe Mac','en');

/*!40000 ALTER TABLE `tb_profile` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tb_role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tb_role`;

CREATE TABLE `tb_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `can_admin` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `tb_role` WRITE;
/*!40000 ALTER TABLE `tb_role` DISABLE KEYS */;

INSERT INTO `tb_role` (`id`, `name`, `create_time`, `update_time`, `can_admin`)
VALUES
	(1,'Admin','2015-01-25 04:53:11',NULL,1),
	(2,'User','2015-01-25 04:53:11',NULL,0);

/*!40000 ALTER TABLE `tb_role` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tb_type
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tb_type`;

CREATE TABLE `tb_type` (
  `id_type` int(11) NOT NULL AUTO_INCREMENT,
  `desc_type` varchar(45) CHARACTER SET latin1 NOT NULL,
  `hexcolor_type` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `icon_type` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Movement Type: Debit, Credit';

LOCK TABLES `tb_type` WRITE;
/*!40000 ALTER TABLE `tb_type` DISABLE KEYS */;

INSERT INTO `tb_type` (`id_type`, `desc_type`, `hexcolor_type`, `icon_type`)
VALUES
	(1,'Revenue','#18bc9c',''),
	(2,'Expense','#e74c3c','');

/*!40000 ALTER TABLE `tb_type` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tb_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tb_user`;

CREATE TABLE `tb_user` (
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
  CONSTRAINT `tb_user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `tb_role` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `tb_user` WRITE;
/*!40000 ALTER TABLE `tb_user` DISABLE KEYS */;

INSERT INTO `tb_user` (`id`, `role_id`, `status`, `email`, `new_email`, `username`, `password`, `auth_key`, `api_key`, `login_ip`, `login_time`, `create_ip`, `create_time`, `update_time`, `ban_time`, `ban_reason`)
VALUES
	(1,1,1,'neo@neo.com',NULL,'neo','$2y$10$WYB666j7MmxuW6b.kFTOde/eGCLijWa6BFSjAAiiRbSAqpC1HCmrC','ub1TTuSVSATn3NXbuVh4bhR-m2EXgVT0','Ahc7a0TXH6Gqe_8GTi1UlZEWVxHsOLcv','127.0.0.1','2015-04-21 22:16:04',NULL,'2015-01-25 04:53:12',NULL,NULL,NULL),
	(3,2,1,'joe@mymail.com','joe@mymail.com','joe','$2y$13$zwUBF5Nf04I1h93p4c/pXeS/TjjaVTnspL281DeVBtk.YJfCSY4Za','qA_US4c8xUCucUDWXyYC-SA1qcxCiGTV','GWQuKuPFhAJTjE8GL5w2tvaveKs1Bvno','127.0.0.1','2015-04-21 22:15:18','127.0.0.1','2015-02-14 05:03:28','2015-04-21 22:18:29',NULL,NULL);

/*!40000 ALTER TABLE `tb_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tb_user_auth
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tb_user_auth`;

CREATE TABLE `tb_user_auth` (
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
  CONSTRAINT `tb_user_auth_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table tb_user_key
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tb_user_key`;

CREATE TABLE `tb_user_key` (
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
  CONSTRAINT `tb_user_key_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `tb_user_key` WRITE;
/*!40000 ALTER TABLE `tb_user_key` DISABLE KEYS */;

INSERT INTO `tb_user_key` (`id`, `user_id`, `type`, `key_value`, `create_time`, `consume_time`, `expire_time`)
VALUES
	(1,3,1,'fgX4vB8x1UW8uGdCaKQTj9kKo7Kfbltp','2015-02-14 05:03:28',NULL,NULL),
	(3,3,2,'jkApCoj4zQ1osBGZ6gEwIJ9zgLeiOFxb','2015-04-21 22:15:00',NULL,NULL);

/*!40000 ALTER TABLE `tb_user_key` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
