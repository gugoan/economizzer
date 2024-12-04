-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 04-Dez-2024 às 14:02
-- Versão do servidor: 9.0.1
-- versão do PHP: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `economizzer`
--
CREATE DATABASE IF NOT EXISTS `economizzer` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `economizzer`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `bancos`
--

CREATE TABLE `bancos` (
  `id_bancos` int NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_inicio_cartao` date DEFAULT NULL,
  `data_fechamento_cartao` date DEFAULT NULL,
  `data_registro` date NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cashbook`
--

CREATE TABLE `cashbook` (
  `id` int NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `is_pending` tinyint(1) NOT NULL DEFAULT '0',
  `attachment` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `inc_datetime` datetime DEFAULT NULL COMMENT 'insert date',
  `edit_datetime` datetime DEFAULT NULL COMMENT 'edit date',
  `user_id` int NOT NULL,
  `category_id` int NOT NULL,
  `type_id` int NOT NULL,
  `note` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `segment_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci COMMENT='Control financial movement';

-- --------------------------------------------------------

--
-- Estrutura da tabela `category`
--

CREATE TABLE `category` (
  `id_category` int NOT NULL,
  `parent_id` int DEFAULT NULL,
  `desc_category` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `hexcolor_category` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `icone` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `descricao_detalhada` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `tipo` enum('gasto','receita','ambos') COLLATE utf8mb3_unicode_ci DEFAULT 'ambos',
  `limite_orcamento` decimal(10,2) DEFAULT NULL,
  `compartilhavel` tinyint(1) DEFAULT '0',
  `tags` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `regras_auto_categorizacao` json DEFAULT NULL,
  `id_bancos` int DEFAULT NULL,
  `id_clientes` int DEFAULT NULL,
  `id_produtos_clientes` int DEFAULT NULL,
  `historico_alteracoes` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `is_active` int NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci COMMENT='Categories of entries: Water, light, card, etc.';

--
-- Extraindo dados da tabela `category`
--

INSERT INTO `category` (`id_category`, `parent_id`, `desc_category`, `hexcolor_category`, `icone`, `descricao_detalhada`, `tipo`, `limite_orcamento`, `compartilhavel`, `tags`, `regras_auto_categorizacao`, `id_bancos`, `id_clientes`, `id_produtos_clientes`, `historico_alteracoes`, `is_active`, `user_id`) VALUES
(1010, 1017, 'Nubank', '#9900ff', NULL, NULL, 'ambos', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 160),
(1011, NULL, 'Salario', '#8e7cc3', NULL, NULL, 'ambos', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 160),
(1012, NULL, 'Pagamento', '#ff0000', '', NULL, 'ambos', NULL, 0, '', '\"\"', NULL, NULL, NULL, '\nAtualizado em: 2024-10-31 21:34:17 por marco', 1, 160),
(1013, 1012, 'Pix', '#9900ff', NULL, NULL, 'ambos', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 160),
(1014, NULL, 'Xp', '#000000', '', NULL, 'receita', NULL, 0, '', '\"\"', 5, NULL, NULL, '\nAtualizado em: 2024-11-13 03:19:25 por marco', 1, 160),
(1015, 1017, 'Inter', '#ff9900', NULL, NULL, 'ambos', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 160),
(1016, 1012, 'Rendimento', '#93c47d', NULL, NULL, 'ambos', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 160),
(1018, 1020, 'Bares e Restaurantes', '#0000ff', '', NULL, 'gasto', NULL, 0, '', '\"\"', NULL, NULL, NULL, '\nAtualizado em: 2024-11-12 17:53:10 por marco', 1, 160),
(1019, 1020, 'Compras e Beleza', '#ef0bc7', '', NULL, 'gasto', NULL, 0, '', '\"\"', NULL, NULL, NULL, '\nAtualizado em: 2024-11-12 17:52:05 por marco', 1, 160),
(1020, NULL, 'Cartao', '#ffff00', '', NULL, 'gasto', NULL, NULL, '', '\"\"', NULL, NULL, NULL, 'Categoria criada em: 2024-11-07 03:03:00 por marco', 1, 160),
(1021, 1020, 'Supermercados e Alimentação', '#00ff00', '', NULL, 'gasto', NULL, NULL, '', NULL, NULL, NULL, NULL, 'Categoria criada em: 2024-11-12 17:54:04 por marco', 1, 160),
(1022, 1020, 'Combustíveis e Postos', '#ffff00', '', NULL, 'gasto', NULL, NULL, '', NULL, NULL, NULL, NULL, 'Categoria criada em: 2024-11-12 17:55:05 por marco', 1, 160),
(1023, 1020, 'Farmácias e Saúde', '#ff9900', '', NULL, 'gasto', NULL, NULL, '', NULL, NULL, NULL, NULL, 'Categoria criada em: 2024-11-12 17:55:44 por marco', 1, 160),
(1024, 1020, 'Compras Online', '#45818e', '', NULL, 'gasto', NULL, NULL, '', NULL, NULL, NULL, NULL, 'Categoria criada em: 2024-11-12 17:56:25 por marco', 1, 160),
(1025, 1020, 'Transferências e Pagamentos', '#f6b26b', '', NULL, 'gasto', NULL, NULL, '', NULL, NULL, NULL, NULL, 'Categoria criada em: 2024-11-12 17:57:07 por marco', 1, 160),
(1026, 1020, 'Outros', '#f6b26b', '', NULL, 'gasto', NULL, NULL, '', NULL, NULL, NULL, NULL, 'Categoria criada em: 2024-11-12 17:57:47 por marco', 1, 160),
(1027, 1020, 'Hospedagem e Viagens', '#9fc5e8', '', NULL, 'gasto', NULL, NULL, '', NULL, NULL, NULL, NULL, 'Categoria criada em: 2024-11-12 18:09:03 por marco', 1, 160),
(1028, 1020, 'Academia', '#ff0000', '', NULL, 'gasto', NULL, NULL, '', '\"\"', NULL, NULL, NULL, 'Categoria criada em: 2024-11-29 15:42:42 por marco a\nAtualizado em: 2024-11-29 15:50:53 por marco a', 1, 160),
(1029, 1020, 'streaming', '#a2c4c9', '', NULL, 'gasto', NULL, NULL, '', NULL, NULL, NULL, NULL, 'Categoria criada em: 2024-11-29 15:51:52 por marco a', 1, 160),
(1030, 1020, 'Mecânico', '#00ffff', '', NULL, 'gasto', NULL, NULL, '', NULL, NULL, NULL, NULL, 'Categoria criada em: 2024-11-29 16:23:11 por marco a', 1, 160),
(1031, 1020, 'Drop', '#00ff00', '', NULL, 'gasto', NULL, NULL, '', NULL, NULL, NULL, NULL, 'Categoria criada em: 2024-11-29 16:33:12 por marco a', 1, 160);

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int NOT NULL,
  `nome` varchar(100) NOT NULL,
  `user_id` int DEFAULT NULL,
  `data_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `edit_datetime` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `descricao` varchar(255) DEFAULT NULL,
  `parcelas` int DEFAULT NULL,
  `category_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `faturas`
--

CREATE TABLE `faturas` (
  `id_fatura` int NOT NULL,
  `id_bancos` int NOT NULL,
  `data` date NOT NULL,
  `descricao` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parcelas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `user_id` int NOT NULL,
  `category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1729523474),
('m160320_200425_initial', 1729523485);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos_clientes`
--

CREATE TABLE `produtos_clientes` (
  `id` int NOT NULL,
  `cliente_id` int NOT NULL,
  `data` date DEFAULT NULL,
  `data_entrega` date DEFAULT NULL,
  `produto` varchar(255) NOT NULL,
  `quantidade` int DEFAULT '1',
  `valor_cliente` decimal(10,2) NOT NULL,
  `valor_pagamento` decimal(10,2) DEFAULT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `profile`
--

CREATE TABLE `profile` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `full_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `language` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'en',
  `startpage` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'cashbook/index',
  `currencycode` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'USD',
  `decimalseparator` varchar(1) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `profile`
--

INSERT INTO `profile` (`id`, `user_id`, `create_time`, `update_time`, `full_name`, `language`, `startpage`, `currencycode`, `decimalseparator`) VALUES
(1, 1, '2015-01-25 05:53:12', NULL, 'the one', 'en', 'cashbook/index', 'USD', '.'),
(3, 3, '2015-02-14 06:03:28', '2024-11-14 01:32:40', 'Marco antonio bubola', 'pt', 'dashboard/overview', 'R$', '.'),
(158, 158, '2024-11-29 16:53:50', NULL, NULL, 'en', 'cashbook/index', 'USD', '.'),
(159, 159, '2024-11-29 16:54:15', NULL, NULL, 'en', 'cashbook/index', 'USD', '.'),
(160, 160, '2024-11-29 17:25:27', '2024-11-29 17:30:41', 'Marco antonio bubola', 'pt', 'cashbook/index', 'R$', '.');

-- --------------------------------------------------------

--
-- Estrutura da tabela `role`
--

CREATE TABLE `role` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `can_admin` smallint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `role`
--

INSERT INTO `role` (`id`, `name`, `create_time`, `update_time`, `can_admin`) VALUES
(1, 'Admin', '2015-01-25 05:53:11', NULL, 1),
(2, 'User', '2015-01-25 05:53:11', NULL, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `segment`
--

CREATE TABLE `segment` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `category_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `targets`
--

CREATE TABLE `targets` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT 'Default Title',
  `target_date` date DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `value` decimal(10,2) DEFAULT NULL,
  `is_completed` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `type`
--

CREATE TABLE `type` (
  `id_type` int NOT NULL,
  `desc_type` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `hexcolor_type` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `icon_type` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci COMMENT='Movement Type: Debit, Credit';

--
-- Extraindo dados da tabela `type`
--

INSERT INTO `type` (`id_type`, `desc_type`, `hexcolor_type`, `icon_type`) VALUES
(1, 'Revenue', '#18bc9c', ''),
(2, 'Expense', '#e74c3c', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `role_id` int NOT NULL,
  `status` smallint NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `new_email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `auth_key` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `api_key` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `login_ip` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `login_time` timestamp NULL DEFAULT NULL,
  `create_ip` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `ban_time` timestamp NULL DEFAULT NULL,
  `ban_reason` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id`, `role_id`, `status`, `email`, `new_email`, `username`, `password`, `auth_key`, `api_key`, `login_ip`, `login_time`, `create_ip`, `create_time`, `update_time`, `ban_time`, `ban_reason`) VALUES
(1, 1, 1, 'neo@neo.com', NULL, 'administrador', '$2y$13$cRwqEDU2Elh6KLYfPzLVkuoGwNlUvi8JEUSHXc.0gMQ1fd4IqQSFm', 'ub1TTuSVSATn3NXbuVh4bhR-m2EXgVT0', 'Ahc7a0TXH6Gqe_8GTi1UlZEWVxHsOLcv', '189.3.54.36', '2015-10-23 04:13:36', NULL, '2015-01-25 05:53:12', '2015-10-06 09:24:53', NULL, NULL),
(3, 2, 2, 'joe@mymail.com', 'marcobubola@hotmail.com', 'marco', '$2y$13$B2K6a2EAlcpkpN80Bnu8b.tjuw3DfAZnHAppiAW3jnB3P.RdP8BF2', 'qA_US4c8xUCucUDWXyYC-SA1qcxCiGTV', 'GWQuKuPFhAJTjE8GL5w2tvaveKs1Bvno', '::1', '2024-11-29 16:51:03', '127.0.0.1', '2015-02-14 06:03:28', '2024-10-21 20:20:38', NULL, NULL),
(158, 2, 0, 'a@hotmail.com', NULL, NULL, '$2y$13$PmUHcNVpLKGqbqVUi9qalelhQin3nsTr2W1ms9.V6nYHx5Se/mV06', 'aicORpMcufJdC5ZA-rG_XrMOPN0CRsHP', 'ZQk5WMAwB8rLKzmRL3dyLDGMhZezyZbA', NULL, NULL, '::1', '2024-11-29 16:53:50', NULL, NULL, NULL),
(159, 2, 0, 'm@hotmail.com', NULL, NULL, '$2y$13$IFouGlVAay99ENWTBX8bhe6tSNwc5WLkcHmpdeEt1l3/X9Be2dyfy', 'NxhMvyOsP-jwIM81E8ESieR29lRbVETX', 'wPXEF14DPbmFEf-VHR3VYX73Rk9xYMLC', NULL, NULL, '::1', '2024-11-29 16:54:15', NULL, NULL, NULL),
(160, 1, 1, 'marcobubola@hotmail.com', NULL, 'marco a', '$2y$13$kGsJ9A68ie6ubYO.QGyV2.9hIQ99lrxUDUTdfYeNHf.yW3PSivfUu', 'mNWBnejX49pBYbbV3MdoOiwxIHUKbpsF', 'qHW42MF9vgub5ZK9ACwS-zgmjPf3gV0o', '::1', '2024-12-04 05:32:48', '::1', '2024-11-29 17:25:27', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_auth`
--

CREATE TABLE `user_auth` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `provider` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `provider_id` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `provider_attributes` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_key`
--

CREATE TABLE `user_key` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `type` smallint NOT NULL,
  `key_value` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `consume_time` timestamp NULL DEFAULT NULL,
  `expire_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `user_key`
--

INSERT INTO `user_key` (`id`, `user_id`, `type`, `key_value`, `create_time`, `consume_time`, `expire_time`) VALUES
(1, 3, 1, 'fgX4vB8x1UW8uGdCaKQTj9kKo7Kfbltp', '2015-02-14 06:03:28', NULL, NULL),
(3, 3, 2, 'jkApCoj4zQ1osBGZ6gEwIJ9zgLeiOFxb', '2015-04-21 22:15:00', NULL, '2015-10-09 20:05:45'),
(135, 3, 2, '-9u98ZL9GUvu1ZvKChYmM5l1mcHfCfFC', '2024-10-21 20:20:37', NULL, NULL),
(136, 158, 1, '3FISmh-tJHoNhpeoRdmK1kUsdmhZdreu', '2024-11-29 16:53:50', NULL, NULL),
(137, 159, 1, 'NXBrNPJj2REjVPz7tsXFALq95KvgdzwX', '2024-11-29 16:54:15', NULL, NULL),
(138, 160, 1, '_Gcycxn-wbYo5YubFgi5QnSSprEuuYF1', '2024-11-29 17:26:09', NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `bancos`
--
ALTER TABLE `bancos`
  ADD PRIMARY KEY (`id_bancos`),
  ADD KEY `fk_tb_bancos_tb_user1_idx` (`user_id`);

--
-- Índices para tabela `cashbook`
--
ALTER TABLE `cashbook`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tb_cashbook_tb_user1_idx` (`user_id`),
  ADD KEY `fk_tb_cashbook_tb_category1_idx` (`category_id`),
  ADD KEY `fk_tb_cashbook_tb_type1_idx` (`type_id`),
  ADD KEY `fk_segment` (`segment_id`);

--
-- Índices para tabela `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`),
  ADD KEY `fk_tb_category_tb_user1_idx` (`user_id`),
  ADD KEY `fk_category_bancos` (`id_bancos`),
  ADD KEY `fk_category_clientes_idx` (`id_clientes`),
  ADD KEY `fk_category_produtos_clientes_idx` (`id_produtos_clientes`);

--
-- Índices para tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `clientes_ibfk_1_idx` (`category_id`);

--
-- Índices para tabela `faturas`
--
ALTER TABLE `faturas`
  ADD PRIMARY KEY (`id_fatura`),
  ADD KEY `id_bancos` (`id_bancos`),
  ADD KEY `fk_tb_faturas_tb_user1_idx` (`user_id`),
  ADD KEY `fk_tb_faturas_tb_category1_idx` (`category_id`);

--
-- Índices para tabela `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Índices para tabela `produtos_clientes`
--
ALTER TABLE `produtos_clientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices para tabela `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_profile_user_id` (`user_id`) USING BTREE;

--
-- Índices para tabela `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `segment`
--
ALTER TABLE `segment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices para tabela `targets`
--
ALTER TABLE `targets`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id_type`);

--
-- Índices para tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tb_user_email` (`email`) USING BTREE,
  ADD UNIQUE KEY `tb_user_username` (`username`) USING BTREE,
  ADD KEY `tb_user_role_id` (`role_id`) USING BTREE;

--
-- Índices para tabela `user_auth`
--
ALTER TABLE `user_auth`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_user_auth_provider_id` (`provider_id`) USING BTREE,
  ADD KEY `tb_user_auth_user_id` (`user_id`) USING BTREE;

--
-- Índices para tabela `user_key`
--
ALTER TABLE `user_key`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tb_user_key_key` (`key_value`) USING BTREE,
  ADD KEY `tb_user_key_user_id` (`user_id`) USING BTREE;

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `bancos`
--
ALTER TABLE `bancos`
  MODIFY `id_bancos` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `cashbook`
--
ALTER TABLE `cashbook`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1032;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `faturas`
--
ALTER TABLE `faturas`
  MODIFY `id_fatura` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produtos_clientes`
--
ALTER TABLE `produtos_clientes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT de tabela `role`
--
ALTER TABLE `role`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `segment`
--
ALTER TABLE `segment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `targets`
--
ALTER TABLE `targets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `type`
--
ALTER TABLE `type`
  MODIFY `id_type` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT de tabela `user_auth`
--
ALTER TABLE `user_auth`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `user_key`
--
ALTER TABLE `user_key`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `bancos`
--
ALTER TABLE `bancos`
  ADD CONSTRAINT `fk_tb_bancos_tb_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Limitadores para a tabela `cashbook`
--
ALTER TABLE `cashbook`
  ADD CONSTRAINT `fk_segment` FOREIGN KEY (`segment_id`) REFERENCES `segment` (`id`),
  ADD CONSTRAINT `fk_tb_cashbook_tb_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id_category`),
  ADD CONSTRAINT `fk_tb_cashbook_tb_type1` FOREIGN KEY (`type_id`) REFERENCES `type` (`id_type`),
  ADD CONSTRAINT `fk_tb_cashbook_tb_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Limitadores para a tabela `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `fk_category_bancos` FOREIGN KEY (`id_bancos`) REFERENCES `bancos` (`id_bancos`),
  ADD CONSTRAINT `fk_category_clientes` FOREIGN KEY (`id_clientes`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `fk_category_produtos_clientes` FOREIGN KEY (`id_produtos_clientes`) REFERENCES `produtos_clientes` (`id`),
  ADD CONSTRAINT `fk_tb_category_tb_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Limitadores para a tabela `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `faturas`
--
ALTER TABLE `faturas`
  ADD CONSTRAINT `faturas_ibfk_1` FOREIGN KEY (`id_bancos`) REFERENCES `bancos` (`id_bancos`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_faturas_tb_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id_category`),
  ADD CONSTRAINT `fk_tb_faturas_tb_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Limitadores para a tabela `produtos_clientes`
--
ALTER TABLE `produtos_clientes`
  ADD CONSTRAINT `produtos_clientes_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`);

--
-- Limitadores para a tabela `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Limitadores para a tabela `segment`
--
ALTER TABLE `segment`
  ADD CONSTRAINT `segment_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id_category`) ON DELETE CASCADE,
  ADD CONSTRAINT `segment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);

--
-- Limitadores para a tabela `user_auth`
--
ALTER TABLE `user_auth`
  ADD CONSTRAINT `user_auth_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Limitadores para a tabela `user_key`
--
ALTER TABLE `user_key`
  ADD CONSTRAINT `user_key_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
