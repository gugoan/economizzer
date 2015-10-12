-- phpMyAdmin SQL Dump
-- version 4.2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 21-Abr-2015 às 19:26
-- Versão do servidor: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `economizzer`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_cashbook`
--

CREATE TABLE IF NOT EXISTS `tb_cashbook` (
`id` int(11) NOT NULL,
  `value` float NOT NULL,
  `description` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `is_pending` tinyint(1) NOT NULL DEFAULT '0',
  `attachment` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `inc_datetime` datetime DEFAULT NULL COMMENT 'insert date',
  `edit_datetime` datetime DEFAULT NULL COMMENT 'edit date',
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Control financial movement' AUTO_INCREMENT=198 ;

--
-- Extraindo dados da tabela `tb_cashbook`
--

INSERT INTO `tb_cashbook` (`id`, `value`, `description`, `date`, `is_pending`, `attachment`, `inc_datetime`, `edit_datetime`, `user_id`, `category_id`, `type_id`) VALUES
(181, -355, 'Test', '2015-02-13', 1, NULL, '2015-02-14 03:28:16', '2015-02-14 03:29:31', 3, 17, 2),
(182, 2200, 'teste', '2015-02-11', 0, NULL, '2015-02-14 03:30:33', NULL, 3, 18, 1),
(183, 1200, 'test', '2015-02-23', 0, NULL, '2015-02-24 18:05:13', '2015-03-03 21:30:57', 3, 20, 1),
(184, -189.8, 'Included medical consultation', '2015-03-01', 0, NULL, '2015-03-05 02:10:37', '2015-03-05 02:11:44', 3, 19, 2),
(185, 2850, 'add bonus', '2015-03-03', 0, 'gFKffgkWmStCeqqCTmitq9LiilqpD5nd.jpg', '2015-03-05 02:11:36', '2015-03-05 02:18:18', 3, 22, 1),
(186, 1800, '', '2015-03-01', 1, NULL, '2015-03-05 02:12:08', '2015-03-07 23:19:26', 3, 20, 1),
(187, -950, 'Add previous month', '2015-03-03', 0, NULL, '2015-03-05 02:13:14', NULL, 3, 17, 2),
(188, 1900, '', '2015-03-05', 0, NULL, '2015-03-05 02:13:58', NULL, 3, 18, 1),
(189, -300, '', '2015-03-10', 0, NULL, '2015-03-05 02:14:28', '2015-03-05 02:16:45', 3, 21, 2),
(190, -150, 'Online purchase..', '2015-03-11', 0, NULL, '2015-03-05 02:15:22', NULL, 3, 23, 2),
(191, -125.59, 'Shopping for party :)', '2015-02-18', 0, NULL, '2015-03-05 02:16:28', '2015-03-30 02:02:58', 3, 21, 2),
(192, -49.95, 'Attach', '2015-03-10', 0, 'u3bxLcAnrib3Mz-7TyssKTN7jAExz0Qi.pdf', '2015-03-05 04:04:02', NULL, 3, 23, 2),
(193, -500, 'Lie day!!', '2015-04-01', 0, NULL, '2015-03-30 01:04:23', NULL, 3, 19, 2),
(194, 800, 'test chart', '2015-04-08', 0, NULL, '2015-03-31 03:29:56', '2015-03-31 03:30:27', 3, 18, 1),
(197, 1700, 'Huh, just a test! ', '2015-01-14', 0, NULL, '2015-04-07 03:04:06', NULL, 3, 18, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_category`
--

CREATE TABLE IF NOT EXISTS `tb_category` (
`id_category` int(11) NOT NULL,
  `desc_category` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `hexcolor_category` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Categories of entries: Water, light, card, etc.' AUTO_INCREMENT=24 ;

--
-- Extraindo dados da tabela `tb_category`
--

INSERT INTO `tb_category` (`id_category`, `desc_category`, `hexcolor_category`, `user_id`) VALUES
(17, 'Rent Apartment', '#274e13', 3),
(18, 'Retirement', '#cc4125', 3),
(19, 'Health Plan', '#a61c00', 3),
(20, 'Pension', '#6aa84f', 3),
(21, 'Supermarket', '#e06666', 3),
(22, 'Employment Fixed', '#3c78d8', 3),
(23, 'Others', '#674ea7', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_migration`
--

CREATE TABLE IF NOT EXISTS `tb_migration` (
  `version` varchar(180) CHARACTER SET latin1 NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tb_migration`
--

INSERT INTO `tb_migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1422150778),
('m140524_153638_init_user', 1422150792),
('m140524_153642_init_user_auth', 1422150793);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_profile`
--

CREATE TABLE IF NOT EXISTS `tb_profile` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `language` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `tb_profile`
--

INSERT INTO `tb_profile` (`id`, `user_id`, `create_time`, `update_time`, `full_name`, `language`) VALUES
(1, 1, '2015-01-25 04:53:12', NULL, 'the one', 'en'),
(3, 3, '2015-02-14 05:03:28', '2015-04-21 22:18:29', 'Joe Mac', 'en');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_role`
--

CREATE TABLE IF NOT EXISTS `tb_role` (
`id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `can_admin` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `tb_role`
--

INSERT INTO `tb_role` (`id`, `name`, `create_time`, `update_time`, `can_admin`) VALUES
(1, 'Admin', '2015-01-25 04:53:11', NULL, 1),
(2, 'User', '2015-01-25 04:53:11', NULL, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_type`
--

CREATE TABLE IF NOT EXISTS `tb_type` (
`id_type` int(11) NOT NULL,
  `desc_type` varchar(45) CHARACTER SET latin1 NOT NULL,
  `hexcolor_type` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `icon_type` varchar(45) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Movement Type: Debit, Credit' AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `tb_type`
--

INSERT INTO `tb_type` (`id_type`, `desc_type`, `hexcolor_type`, `icon_type`) VALUES
(1, 'Revenue', '#18bc9c', ''),
(2, 'Expense', '#e74c3c', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_user`
--

CREATE TABLE IF NOT EXISTS `tb_user` (
`id` int(11) NOT NULL,
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
  `ban_reason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `tb_user`
--

INSERT INTO `tb_user` (`id`, `role_id`, `status`, `email`, `new_email`, `username`, `password`, `auth_key`, `api_key`, `login_ip`, `login_time`, `create_ip`, `create_time`, `update_time`, `ban_time`, `ban_reason`) VALUES
(1, 1, 1, 'neo@neo.com', NULL, 'neo', '$2y$10$WYB666j7MmxuW6b.kFTOde/eGCLijWa6BFSjAAiiRbSAqpC1HCmrC', 'ub1TTuSVSATn3NXbuVh4bhR-m2EXgVT0', 'Ahc7a0TXH6Gqe_8GTi1UlZEWVxHsOLcv', '127.0.0.1', '2015-04-21 22:16:04', NULL, '2015-01-25 04:53:12', NULL, NULL, NULL),
(3, 2, 1, 'joe@mymail.com', 'joe@mymail.com', 'joe', '$2y$13$zwUBF5Nf04I1h93p4c/pXeS/TjjaVTnspL281DeVBtk.YJfCSY4Za', 'qA_US4c8xUCucUDWXyYC-SA1qcxCiGTV', 'GWQuKuPFhAJTjE8GL5w2tvaveKs1Bvno', '127.0.0.1', '2015-04-21 22:15:18', '127.0.0.1', '2015-02-14 05:03:28', '2015-04-21 22:18:29', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_user_auth`
--

CREATE TABLE IF NOT EXISTS `tb_user_auth` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `provider_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `provider_attributes` text COLLATE utf8_unicode_ci NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_user_key`
--

CREATE TABLE IF NOT EXISTS `tb_user_key` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  `key_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `consume_time` timestamp NULL DEFAULT NULL,
  `expire_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `tb_user_key`
--

INSERT INTO `tb_user_key` (`id`, `user_id`, `type`, `key_value`, `create_time`, `consume_time`, `expire_time`) VALUES
(1, 3, 1, 'fgX4vB8x1UW8uGdCaKQTj9kKo7Kfbltp', '2015-02-14 05:03:28', NULL, NULL),
(3, 3, 2, 'jkApCoj4zQ1osBGZ6gEwIJ9zgLeiOFxb', '2015-04-21 22:15:00', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_cashbook`
--
ALTER TABLE `tb_cashbook`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_tb_cashbook_tb_user1_idx` (`user_id`), ADD KEY `fk_tb_cashbook_tb_category1_idx` (`category_id`), ADD KEY `fk_tb_cashbook_tb_type1_idx` (`type_id`);

--
-- Indexes for table `tb_category`
--
ALTER TABLE `tb_category`
 ADD PRIMARY KEY (`id_category`), ADD KEY `fk_tb_category_tb_user1_idx` (`user_id`);

--
-- Indexes for table `tb_migration`
--
ALTER TABLE `tb_migration`
 ADD PRIMARY KEY (`version`);

--
-- Indexes for table `tb_profile`
--
ALTER TABLE `tb_profile`
 ADD PRIMARY KEY (`id`), ADD KEY `tb_profile_user_id` (`user_id`) USING BTREE;

--
-- Indexes for table `tb_role`
--
ALTER TABLE `tb_role`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_type`
--
ALTER TABLE `tb_type`
 ADD PRIMARY KEY (`id_type`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `tb_user_email` (`email`) USING BTREE, ADD UNIQUE KEY `tb_user_username` (`username`) USING BTREE, ADD KEY `tb_user_role_id` (`role_id`) USING BTREE;

--
-- Indexes for table `tb_user_auth`
--
ALTER TABLE `tb_user_auth`
 ADD PRIMARY KEY (`id`), ADD KEY `tb_user_auth_provider_id` (`provider_id`) USING BTREE, ADD KEY `tb_user_auth_user_id` (`user_id`) USING BTREE;

--
-- Indexes for table `tb_user_key`
--
ALTER TABLE `tb_user_key`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `tb_user_key_key` (`key_value`) USING BTREE, ADD KEY `tb_user_key_user_id` (`user_id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_cashbook`
--
ALTER TABLE `tb_cashbook`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=198;
--
-- AUTO_INCREMENT for table `tb_category`
--
ALTER TABLE `tb_category`
MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `tb_profile`
--
ALTER TABLE `tb_profile`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tb_role`
--
ALTER TABLE `tb_role`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tb_type`
--
ALTER TABLE `tb_type`
MODIFY `id_type` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tb_user_auth`
--
ALTER TABLE `tb_user_auth`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tb_user_key`
--
ALTER TABLE `tb_user_key`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `tb_cashbook`
--
ALTER TABLE `tb_cashbook`
ADD CONSTRAINT `fk_tb_cashbook_tb_category1` FOREIGN KEY (`category_id`) REFERENCES `tb_category` (`id_category`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_tb_cashbook_tb_type1` FOREIGN KEY (`type_id`) REFERENCES `tb_type` (`id_type`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_tb_cashbook_tb_user1` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_category`
--
ALTER TABLE `tb_category`
ADD CONSTRAINT `fk_tb_category_tb_user1` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_profile`
--
ALTER TABLE `tb_profile`
ADD CONSTRAINT `tb_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`id`);

--
-- Limitadores para a tabela `tb_user`
--
ALTER TABLE `tb_user`
ADD CONSTRAINT `tb_user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `tb_role` (`id`);

--
-- Limitadores para a tabela `tb_user_auth`
--
ALTER TABLE `tb_user_auth`
ADD CONSTRAINT `tb_user_auth_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`id`);

--
-- Limitadores para a tabela `tb_user_key`
--
ALTER TABLE `tb_user_key`
ADD CONSTRAINT `tb_user_key_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
