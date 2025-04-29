-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07-Jan-2025 às 16:41
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

--
-- Extraindo dados da tabela `bancos`
--

INSERT INTO `bancos` (`id_bancos`, `nome`, `descricao`, `data_inicio_cartao`, `data_fechamento_cartao`, `data_registro`, `user_id`) VALUES
(2, 'Nubank', 'as', '2024-10-07', '2024-11-06', '2024-10-30', 3),
(4, 'Inter', 'sla', '2024-11-04', '2024-12-04', '2024-11-01', 3),
(5, 'Xp', 'carato xp', '2024-10-18', '2024-11-17', '2024-11-01', 3),
(8, 'Nubank', 'Cartoes nubank', '2024-11-07', '2024-12-06', '2024-11-29', 160),
(9, 'xp', 'Cartões Xp', '2024-11-18', '2024-12-17', '2024-11-29', 160),
(10, 'Inter', 'Cartoes inter', '2024-11-05', '2024-12-04', '2024-11-29', 160),
(11, 'Aninha', 'faturas da ana\r\n', '2024-11-01', '2024-11-30', '2024-11-29', 160);

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

--
-- Extraindo dados da tabela `cashbook`
--

INSERT INTO `cashbook` (`id`, `value`, `description`, `date`, `is_pending`, `attachment`, `inc_datetime`, `edit_datetime`, `user_id`, `category_id`, `type_id`, `note`, `segment_id`) VALUES
(2218, '-160.00', 'Transferência Pix enviada ANA CAROLINA FERREIRA COELHO FREIRE ', '2024-09-01', 0, NULL, '2024-10-24 04:51:55', '2024-10-24 04:51:55', 3, 1013, 2, NULL, NULL),
(2219, '0.20', 'Rendimentos', '2024-09-02', 0, NULL, '2024-10-24 04:51:55', '2024-10-24 04:51:55', 3, 1016, 1, NULL, NULL),
(2220, '0.14', 'Rendimentos', '2024-09-03', 0, NULL, '2024-10-24 04:51:55', '2024-10-24 04:51:55', 3, 1016, 1, NULL, NULL),
(2221, '0.15', 'Rendimentos', '2024-09-04', 0, NULL, '2024-10-24 04:51:55', '2024-10-24 04:51:55', 3, 1016, 1, NULL, NULL),
(2222, '0.14', 'Rendimentos', '2024-09-05', 0, NULL, '2024-10-24 04:51:55', '2024-10-24 04:51:55', 3, 1016, 1, NULL, NULL),
(2223, '0.15', 'Rendimentos', '2024-09-06', 0, NULL, '2024-10-24 04:51:55', '2024-10-24 04:51:55', 3, 1016, 1, NULL, NULL),
(2224, '1710.00', 'Transferência Pix recebida MARCO ANTONIO BUBOLA ', '2024-09-08', 0, NULL, '2024-10-24 04:51:55', '2024-10-24 04:51:55', 3, 1013, 1, NULL, NULL),
(2225, '0.15', 'Rendimentos', '2024-09-09', 0, NULL, '2024-10-24 04:51:55', '2024-10-24 04:51:55', 3, 1016, 1, NULL, NULL),
(2226, '0.69', 'Rendimentos', '2024-09-10', 0, NULL, '2024-10-24 04:51:55', '2024-10-24 04:51:55', 3, 1016, 1, NULL, NULL),
(2227, '-89.90', 'Pagamento de contas Banco Inter S.A.', '2024-09-10', 0, NULL, '2024-10-24 04:51:55', '2024-10-24 04:51:55', 3, 1015, 2, NULL, NULL),
(2228, '0.68', 'Rendimentos', '2024-09-11', 0, NULL, '2024-10-24 04:51:55', '2024-10-24 04:51:55', 3, 1016, 1, NULL, NULL),
(2229, '0.67', 'Rendimentos', '2024-09-12', 0, NULL, '2024-10-24 04:51:55', '2024-10-24 04:51:55', 3, 1016, 1, NULL, NULL),
(2230, '0.68', 'Rendimentos', '2024-09-13', 0, NULL, '2024-10-24 04:51:55', '2024-10-24 04:51:55', 3, 1016, 1, NULL, NULL),
(2231, '-737.23', 'Transferência Pix enviada Marco Antonio Bubola ', '2024-09-13', 0, NULL, '2024-10-24 04:51:55', '2024-10-24 04:51:55', 3, 1013, 2, NULL, NULL),
(2232, '0.43', 'Rendimentos', '2024-09-16', 0, NULL, '2024-10-24 04:51:55', '2024-10-24 04:51:55', 3, 1016, 1, NULL, NULL),
(2233, '0.43', 'Rendimentos', '2024-09-17', 0, NULL, '2024-10-24 04:51:55', '2024-10-24 04:51:55', 3, 1016, 1, NULL, NULL),
(2234, '234.00', 'Transferência Pix recebida Marco Antonio Bubola ', '2024-09-17', 0, NULL, '2024-10-24 04:51:55', '2024-10-24 04:51:55', 3, 1013, 1, NULL, NULL),
(2235, '0.52', 'Rendimentos', '2024-09-18', 0, NULL, '2024-10-24 04:51:55', '2024-10-24 04:51:55', 3, 1016, 1, NULL, NULL),
(2236, '0.51', 'Rendimentos', '2024-09-19', 0, NULL, '2024-10-24 04:51:55', '2024-10-24 04:51:55', 3, 1016, 1, NULL, NULL),
(2237, '0.52', 'Rendimentos', '2024-09-20', 0, NULL, '2024-10-24 04:51:55', '2024-10-24 04:51:55', 3, 1016, 1, NULL, NULL),
(2238, '-176.03', 'Pagamento com QR Pix CAIXA ECONOMICA FEDERAL ', '2024-09-20', 0, NULL, '2024-10-24 04:51:55', '2024-10-24 04:51:55', 3, 1013, 2, NULL, NULL),
(2239, '176.03', 'Transferência Pix recebida MARCO ANTONIO BUBOLA ', '2024-09-20', 0, NULL, '2024-10-24 04:51:55', '2024-10-24 04:51:55', 3, 1013, 1, NULL, NULL),
(2240, '0.52', 'Rendimentos', '2024-09-23', 0, NULL, '2024-10-24 04:51:55', '2024-10-24 04:51:55', 3, 1016, 1, NULL, NULL),
(2241, '0.51', 'Rendimentos', '2024-09-24', 0, NULL, '2024-10-24 04:51:55', '2024-10-24 04:51:55', 3, 1016, 1, NULL, NULL),
(2242, '800.00', 'Transferência Pix recebida Marco Antonio Bubola ', '2024-09-24', 0, NULL, '2024-10-24 04:51:55', '2024-10-24 04:51:55', 3, 1013, 1, NULL, NULL),
(2243, '0.80', 'Rendimentos', '2024-09-25', 0, NULL, '2024-10-24 04:51:55', '2024-10-24 04:51:55', 3, 1016, 1, NULL, NULL),
(2244, '-1848.52', 'Pagamento de contas Banco Santander (Brasil) S. A. ', '2024-09-25', 0, NULL, '2024-10-24 04:51:55', '2024-10-24 04:51:55', 3, 1014, 2, NULL, NULL),
(2245, '0.17', 'Rendimentos', '2024-09-26', 0, NULL, '2024-10-24 04:51:55', '2024-10-24 04:51:55', 3, 1016, 1, NULL, NULL),
(2246, '0.18', 'Rendimentos', '2024-09-27', 0, NULL, '2024-10-24 04:51:55', '2024-10-24 04:51:55', 3, 1016, 1, NULL, NULL),
(2247, '0.17', 'Rendimentos', '2024-09-30', 0, NULL, '2024-10-24 04:51:55', '2024-10-24 04:51:55', 3, 1016, 1, NULL, NULL),
(2248, '-55.00', 'Transferência enviada Caua Araujo Vaz De Lima ', '2024-09-30', 0, NULL, '2024-10-24 04:51:55', '2024-10-24 04:51:55', 3, 1013, 2, NULL, NULL),
(2258, '1.00', 'teste', '2024-10-24', 0, '6sYYdgEIxzVk3sCCgCBLVP5mkF9e1qyw.pdf', '2024-10-25 19:26:36', '2024-10-25 19:27:32', 3, 1014, 1, NULL, NULL),
(2260, '0.17', 'ana', '2024-12-04', 0, NULL, '2024-12-04 02:38:42', NULL, 160, 1013, 1, NULL, NULL),
(2261, '0.17', 'ana', '2024-12-04', 0, NULL, '2024-12-04 02:38:42', NULL, 160, 1013, 1, NULL, NULL);

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

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `user_id`, `data_registro`, `edit_datetime`, `descricao`, `parcelas`, `category_id`) VALUES
(1, 'marco a', 3, '2024-10-26 14:04:11', '2024-11-14 19:36:46', '90+90', 3, 1013),
(6, 'ana', 3, '2024-10-29 02:00:33', '2024-10-29 14:50:25', '0', 8, 1013),
(8, 'ana', 160, '2024-12-04 15:17:30', '2024-12-04 12:17:30', '', 3, NULL);

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

--
-- Extraindo dados da tabela `faturas`
--

INSERT INTO `faturas` (`id_fatura`, `id_bancos`, `data`, `descricao`, `parcelas`, `valor`, `user_id`, `category_id`) VALUES
(4, 2, '2024-09-06', 'Lojaehcases -', '7/10', '55.00', 3, 1019),
(5, 2, '2024-09-07', 'Mp *Melimais', '1/1', '27.99', 3, 1019),
(9, 2, '2024-09-13', 'Saldo restante da fatura anterior', '1/1', '0.00', 3, 1019),
(10, 2, '2024-09-17', 'Auto Posto Arena de I', '1/1', '51.57', 3, 1019),
(11, 2, '2024-09-22', 'Estorno de \"Amazonprimebr\"	-', '1/1', '59.50', 3, 1019),
(12, 2, '2024-09-22', 'Zeferinoltda', '1/1', '128.89', 3, 1019),
(13, 2, '2024-09-22', 'Superm Penha Center', '1/1', '1.79', 3, 1019),
(14, 2, '2024-09-25', 'Dm *Spotify', '1/1', '11.90', 3, 1019),
(15, 2, '2024-09-28', 'Rofatto Supermercados', '1/1', '38.57', 3, 1019),
(16, 2, '2024-09-28', 'Tabacaria Jb', '1/1', '32.90', 3, 1019),
(17, 2, '2024-09-28', 'Auto Posto Arena de I', '1/1', '51.00', 3, 1019),
(18, 2, '2024-09-29', 'Sosbeer', '1/1', '14.25', 3, 1019),
(19, 2, '2024-09-30', 'Mp *Clienteconsumidor', '1/1', '93.00', 3, 1019),
(20, 2, '2024-09-30', '55.607.092 Michael Ant', '1/1', '6.00', 3, 1019),
(21, 2, '2024-09-30', 'Divino Gelato', '1/1', '30.00', 3, 1019),
(22, 2, '2024-09-30', 'Auto Posto N. R.', '1/1', '40.00', 3, 1019),
(23, 5, '2024-07-01', 'HNA BOTICARIO', '3 de 3', '167.24', 3, 1019),
(24, 5, '2024-09-01', 'PG *TON CENTRAL BEER', '1/1', '7.50', 3, 1018),
(25, 5, '2024-09-02', '1A99', '1/1', '10.98', 3, 1021),
(26, 5, '2024-09-02', 'AUTO POSTO ARENA', '1/1', '48.45', 3, 1022),
(27, 5, '2024-09-02', 'AUTO POSTO N. R.', '1/1', '40.00', 3, 1022),
(28, 5, '2024-09-03', 'ROFATTO SUPERMERCADOS', '1/1', '18.98', 3, 1021),
(29, 5, '2024-09-03', 'CLARO  *19984122111', '1/1', '49.90', 3, 1023),
(30, 5, '2024-09-04', 'AUTO CENTER PENHA', '1/1', '30.00', 3, 1023),
(31, 5, '2024-09-04', 'R E R PHARMA', '1/1', '48.00', 3, 1023),
(32, 5, '2024-09-05', 'DROGARIA SAO PAULO SA', '1/1', '18.69', 3, 1023),
(33, 5, '2024-06-06', 'PARC=104 AIRBNB * HMDXRN5', '4 de 4', '163.67', 3, 1027),
(34, 5, '2024-09-07', 'SOSBEER', '1/1', '15.00', 3, 1018),
(35, 5, '2024-09-07', 'BURGER KING', '1/1', '118.20', 3, 1018),
(36, 5, '2024-09-07', 'ITAPIRENSE COMBUSTIVEI', '1/1', '50.00', 3, 1022),
(37, 5, '2024-09-08', 'MP*JOSE', '1/1', '25.00', 3, 1025),
(38, 5, '2024-09-08', 'FABIOLUIZDAGNONI', '1/1', '32.00', 3, 1026),
(39, 5, '2024-09-09', 'SUPERMERCADO PENHA CEN', '1/1', '37.44', 3, 1021),
(40, 5, '2024-09-10', 'AUTO CENTER PENHA', '1/1', '50.00', 3, 1023),
(41, 5, '2024-09-14', 'CLEUSA DOS SANTOS LEME', '1/1', '34.00', 3, 1021),
(42, 5, '2024-06-20', 'SHOPEE *MARSTARSHOES', '3 de 3', '51.60', 3, 1024),
(43, 5, '2024-06-21', 'NATURA PAY*NATURA', '3 de 3', '129.30', 3, 1019),
(44, 5, '2024-08-24', 'RESTAURANTE E PANIFICAD', '1/1', '15.95', 3, 1018),
(45, 5, '2024-08-24', 'ZEFERINOLTDA', '1/1', '129.50', 3, 1026),
(46, 5, '2024-08-26', 'SUPERMERCADO PENHA CEN', '1/1', '8.74', 3, 1021),
(47, 5, '2024-08-29', 'PANDULANCHES', '1/1', '7.00', 3, 1021),
(48, 5, '2024-08-29', 'SUPERMERCADO PENHA CEN', '1/1', '11.43', 3, 1021),
(49, 5, '2024-08-30', 'JOSE ROBERTO FERNANDES', '1/1', '158.40', 3, 1026),
(50, 5, '2024-08-30', 'LUCIANO DE ANDRADE COSTA', '1 de 2', '63.90', 3, 1026),
(51, 5, '2024-08-31', 'ZEFERINOLTDA', '1/1', '38.96', 3, 1026),
(52, 5, '2024-08-31', 'SHOPEE *JCMOTOPEAS', '1 de 2', '76.74', 3, 1024),
(53, 5, '2024-08-31', 'DAVID BARBOZA SUPERMERC', '1/1', '26.99', 3, 1021),
(54, 5, '2024-08-31', 'A POSTO PANORAMA LTDA', '1/1', '30.00', 3, 1022),
(55, 5, '2024-08-31', '1A99', '1/1', '20.96', 3, 1021),
(56, 5, '2024-08-31', 'CASARAO DO GUI', '1/1', '114.00', 3, 1021),
(58, 4, '2024-09-02', 'AUTO POSTO ARENA', '1/1', '48.45', 3, 1022),
(59, 8, '2024-08-07', 'Skyfit Itapira -', '11/12', '89.90', 160, 1028),
(60, 8, '2024-08-07', 'Hna Boticari*Eudora -', '2/2', '161.87', 160, 1019),
(61, 8, '2024-08-07', 'Lojaehcases -', '6/10', '55.00', 160, 1024),
(62, 8, '2024-08-08', 'Mp *Melimais', '-', '17.99', 160, 1025),
(63, 8, '2024-08-08', 'Agro Cubatao', '-', '20.50', 160, 1021),
(64, 8, '2024-08-11', 'Amazon Prime Aluguel', '-', '29.90', 160, 1029),
(65, 8, '2024-08-11', 'Pg *Ton Central Beer', '-', '23.00', 160, 1018),
(66, 8, '2024-08-14', 'Multa de atraso Referente ao valor em aberto de  de 16/08/2024 (Valor original: R$ 732,97)', '-', '14.65', 160, 1025),
(67, 8, '2024-08-14', 'IOF de atraso Referente ao valor em aberto de  de 16/08/2024 (Valor original: R$ 732,97)', '-', '2.85', 160, 1025),
(68, 8, '2024-08-14', 'Tabacaria Jb', '-', '29.90', 160, 1018),
(69, 8, '2024-08-17', 'Pag*Zeferinoltda', '-', '82.89', 160, 1023),
(70, 8, '2024-08-18', 'Supermercado Jardim P', '-', '48.72', 160, 1021),
(71, 8, '2024-08-19', 'Fabioluizdagnoni', '-', '26.00', 160, 1026),
(72, 8, '2024-08-19', 'Auto Posto N. R.', '-', '20.00', 160, 1022),
(73, 8, '2024-08-20', 'Tabacaria Jb', '-', '8.00', 160, 1018),
(74, 8, '2024-08-21', 'Dm*Spotify', '-', '11.90', 160, 1029),
(75, 8, '2024-08-22', 'Pandulanches', '-', '7.00', 160, 1021),
(76, 8, '2024-08-23', 'Auto Posto Arena de I', '-', '48.00', 160, 1022),
(77, 8, '2024-08-24', 'sem Parar 5 de 6 MARCO ANTONIO BUBOLA', '-', '11.90', 160, 1025),
(78, 8, '2024-08-24', 'Zeferinoltda', '-', '23.86', 160, 1023),
(79, 8, '2024-08-25', 'Superm Penha Center', '-', '3.39', 160, 1021),
(80, 8, '2024-09-07', 'Skyfit Itapira -', '12/12', '89.90', 160, 1028),
(81, 8, '2024-09-07', 'Lojaehcases -', '7/10', '55.00', 160, 1024),
(82, 8, '2024-09-07', 'Mp *Melimais', '-', '27.99', 160, 1025),
(83, 8, '2024-09-17', 'Auto Posto Arena de I', '-', '51.57', 160, 1022),
(84, 8, '2024-09-22', 'Zeferinoltda', '-', '128.89', 160, 1023),
(85, 8, '2024-09-22', 'Superm Penha Center', '-', '1.79', 160, 1021),
(86, 8, '2024-09-25', 'Dm *Spotify', '-', '11.90', 160, 1029),
(87, 8, '2024-09-28', 'Rofatto Supermercados', '-', '38.57', 160, 1021),
(88, 8, '2024-09-28', 'Tabacaria Jb', '-', '32.90', 160, 1018),
(89, 8, '2024-09-28', 'Auto Posto Arena de I', '-', '51.00', 160, 1022),
(90, 8, '2024-09-29', 'Sosbeer', '-', '14.25', 160, 1018),
(91, 8, '2024-09-30', 'Mp *Clienteconsumidor', '-', '93.00', 160, 1026),
(92, 8, '2024-09-30', '55.607.092 Michael Ant', '-', '6.00', 160, 1026),
(93, 8, '2024-09-30', 'Divino Gelato', '-', '30.00', 160, 1021),
(94, 8, '2024-09-30', 'Auto Posto N. R.', '-', '40.00', 160, 1022),
(95, 8, '2024-10-02', 'Pg *Ton Central Beer ', '-', '10.00', 160, 1018),
(96, 8, '2024-10-07', 'Lojaehcases -', '8/10', '55.00', 160, 1024),
(97, 8, '2024-10-08', 'Mp *Melimais', '-', '27.99', 160, 1025),
(98, 8, '2024-10-09', 'Claro *19984122111', '-', '49.90', 160, 1029),
(99, 8, '2024-10-15', 'Skyfit Itapira -', '1/12', '99.90', 160, 1028),
(100, 8, '2024-10-21', 'Dm*Spotify', '-', '11.90', 160, 1029),
(101, 9, '2024-08-01', 'HNA BOTICARIO', '2 de 3', '167.24', 160, 1019),
(102, 9, '2024-08-01', 'PG *TON 55027322 JOS', '-', '4.00', 160, 1018),
(103, 9, '2024-08-03', 'A98  - Compra ShellBox', '-', '30.00', 160, 1022),
(104, 9, '2024-08-03', 'SUPERMERCADO MIX CENTE', '-', '7.20', 160, 1021),
(105, 9, '2024-08-03', 'PG *TON AGUINALDO LU', '-', '25.00', 160, 1018),
(106, 9, '2024-08-03', 'CLARO  *19984122111', '-', '49.90', 160, 1029),
(107, 9, '2024-08-03', 'FARMALIDER FRANCI', '-', '3.99', 160, 1023),
(108, 9, '2024-08-03', 'ANTONELLI SUPERMERCA', '-', '34.74', 160, 1021),
(109, 9, '2024-08-05', 'SOSBEER', '-', '7.00', 160, 1018),
(110, 9, '2024-08-05', 'AUTO POSTO ARENA', '-', '50.01', 160, 1022),
(111, 9, '2024-08-06', 'AIRBNB ', '3 de 4', '163.67', 160, 1027),
(112, 9, '2024-08-11', 'Compra ShellBox', '-', '20.00', 160, 1022),
(113, 9, '2024-08-12', 'MERCADO LIVRE', '3 de 3', '20.99', 160, 1024),
(114, 9, '2024-07-18', 'PAG*SOSBEER', '-', '11.00', 160, 1018),
(115, 9, '2024-07-20', 'SHOPEE *MARSTARSHOES', '2 de 3', '51.60', 160, 1024),
(116, 9, '2024-07-20', '1A99', '-', '26.96', 160, 1021),
(117, 9, '2024-07-20', 'FACEBK *7WBSB8LBG2', '-', '57.17', 160, 1031),
(118, 9, '2024-07-20', 'MP*JARDIMSABORES', '-', '16.00', 160, 1026),
(119, 9, '2024-07-20', 'AMAZONAS SUCOS BOULEVA', '-', '15.00', 160, 1021),
(120, 9, '2024-07-20', 'YOLAKIAN', '-', '84.50', 160, 1026),
(121, 9, '2024-07-21', 'NATURA PAY*NATURA', '2 de 3', '129.30', 160, 1019),
(122, 9, '2024-07-21', 'HNA BOTICARI*EUDORA', '-', '299.82', 160, 1019),
(123, 9, '2024-07-24', 'FACEBK *WY8M58QAG2', '-', '57.65', 160, 1031),
(124, 9, '2024-07-25', 'BYMA E8PU', '-', '260.00', 160, 1027),
(125, 9, '2024-07-25', 'SHOPIFY* 255692222', '-', '112.40', 160, 1031),
(126, 9, '2024-07-25', 'SHOPIFY* 255692222', '-', '4.92', 160, 1031),
(127, 9, '2024-07-25', 'DAVID BARBOZA SUPERMERC', '-', '22.97', 160, 1021),
(128, 9, '2024-07-26', 'PAG*CAWBOYDONORTE', '-', '6.00', 160, 1026),
(129, 9, '2024-07-26', 'DAVID BARBOZA SUPERMERC', '-', '17.98', 160, 1021),
(130, 9, '2024-07-26', 'PAG*APARECIDOIVANDE', '-', '10.00', 160, 1026),
(131, 9, '2024-07-26', 'PAG*54966834KLEBER', '-', '28.00', 160, 1026),
(132, 9, '2024-07-26', 'TABACARIA JB 05', '-', '13.90', 160, 1018),
(133, 9, '2024-07-27', 'MP*SMARTLANCE', '6 de 6', '33.36', 160, 1026),
(134, 9, '2024-07-27', 'PARC=102BF *MEGA MOTOS', '2 de 2', '65.00', 160, 1030),
(135, 9, '2024-07-27', 'MP*VELOXTICKETS', '-', '53.76', 160, 1026),
(136, 9, '2024-07-27', 'AUTO POSTO ARENA', '-', '30.00', 160, 1022),
(137, 9, '2024-07-27', 'LOJA EDILENE', '-', '24.90', 160, 1026),
(138, 9, '2024-07-27', 'PAG*PIZZARIA', '-', '59.30', 160, 1021),
(139, 9, '2024-07-27', '1A99', '-', '31.94', 160, 1021),
(140, 9, '2024-07-27', 'RAFAEL FERNANDES PEREIRA', '-', '33.70', 160, 1026),
(141, 9, '2024-07-27', 'MP*VELOXTICKETS', '-', '42.56', 160, 1026),
(142, 9, '2024-07-28', 'MP*ACAIMONTANHAS', '-', '34.14', 160, 1026),
(143, 9, '2024-07-29', 'AUTO POSTO N. R.', '-', '15.00', 160, 1022),
(144, 9, '2024-07-29', 'PAG*ZEFERINOLTDA', '-', '60.96', 160, 1023),
(145, 9, '2024-07-29', 'FACEBK *62H4E8QAG2', '-', '75.01', 160, 1031),
(146, 9, '2024-07-30', 'TABACARIA JB 05', '-', '18.90', 160, 1018),
(147, 9, '2024-09-01', 'HNA BOTICARIO', '3 de 3', '167.24', 160, 1019),
(148, 9, '2024-09-01', 'PG *TON CENTRAL BEER', '-', '7.50', 160, 1018),
(149, 9, '2024-09-02', '1A99', '-', '10.98', 160, 1021),
(150, 9, '2024-09-02', 'AUTO POSTO ARENA', '-', '48.45', 160, 1022),
(151, 9, '2024-09-02', 'AUTO POSTO N. R.', '-', '40.00', 160, 1022),
(152, 9, '2024-09-03', 'ROFATTO SUPERMERCADOS', '-', '18.98', 160, 1021),
(153, 9, '2024-09-03', 'CLARO  *19984122111', '-', '49.90', 160, 1029),
(154, 9, '2024-09-04', 'AUTO CENTER PENHA', '-', '30.00', 160, 1021),
(155, 9, '2024-09-04', 'R E R PHARMA', '-', '48.00', 160, 1023),
(156, 9, '2024-09-05', 'DROGARIA SAO PAULO SA', '-', '18.69', 160, 1023),
(157, 9, '2024-09-06', 'AIRBNB ', '4 de 4', '163.67', 160, 1027),
(158, 9, '2024-09-07', 'SOSBEER', '-', '15.00', 160, 1018),
(159, 9, '2024-09-07', 'BURGER KING', '-', '118.20', 160, 1018),
(160, 9, '2024-09-07', 'ITAPIRENSE COMBUSTIVEI', '-', '50.00', 160, 1022),
(161, 9, '2024-09-08', 'MP*JOSE', '-', '25.00', 160, 1025),
(162, 9, '2024-09-08', 'FABIOLUIZDAGNONI', '-', '32.00', 160, 1026),
(163, 9, '2024-09-09', 'SUPERMERCADO PENHA CEN', '-', '37.44', 160, 1021),
(164, 9, '2024-09-10', 'AUTO CENTER PENHA', '-', '50.00', 160, 1021),
(165, 9, '2024-09-14', 'CLEUSA DOS SANTOS LEME', '-', '34.00', 160, 1021),
(166, 9, '2024-08-20', 'SHOPEE *MARSTARSHOES', '3 de 3', '51.60', 160, 1024),
(167, 9, '2024-08-21', 'NATURA PAY*NATURA', '3 de 3', '129.30', 160, 1019),
(168, 9, '2024-08-24', 'RESTAURANTE E PANIFICAD', '-', '15.95', 160, 1018),
(169, 9, '2024-08-24', 'ZEFERINOLTDA', '-', '129.50', 160, 1023),
(170, 9, '2024-08-26', 'SUPERMERCADO PENHA CEN', '-', '8.74', 160, 1021),
(171, 9, '2024-08-29', 'PANDULANCHES', '-', '7.00', 160, 1021),
(172, 9, '2024-08-29', 'SUPERMERCADO PENHA CEN', '-', '11.43', 160, 1021),
(173, 9, '2024-08-30', 'JOSE ROBERTO FERNANDES', '-', '158.40', 160, 1026),
(174, 9, '2024-08-30', 'LUCIANO DE ANDRADE COSTA', '1 de 2', '63.90', 160, 1026),
(175, 9, '2024-08-31', 'ZEFERINOLTDA', '-', '38.96', 160, 1023),
(176, 9, '2024-08-31', 'SHOPEE *JCMOTOPEAS', '1 de 2', '76.74', 160, 1024),
(177, 9, '2024-08-31', 'DAVID BARBOZA SUPERMERC', '-', '26.99', 160, 1021),
(178, 9, '2024-08-31', 'A POSTO PANORAMA LTDA', '-', '30.00', 160, 1022),
(179, 9, '2024-08-31', '1A99', '-', '20.96', 160, 1021),
(180, 9, '2024-08-31', 'CASARAO DO GUI', '-', '114.00', 160, 1021),
(181, 9, '2024-10-04', 'ARMAZEM DA TERRA', '1 de 2', '60.00', 160, 1026),
(182, 9, '2024-10-05', 'SOSBEER', '-', '28.00', 160, 1018),
(183, 9, '2024-10-05', 'JANAINAMENEZESBAR', '-', '75.00', 160, 1018),
(184, 9, '2024-10-06', 'MIX REAL', '-', '14.00', 160, 1021),
(185, 9, '2024-10-06', 'SMASH BURGER', '-', '86.00', 160, 1018),
(186, 9, '2024-10-07', 'SUPERMERCADO JARD', '-', '3.86', 160, 1021),
(187, 9, '2024-10-07', 'AUTO POSTO N. R.', '-', '30.00', 160, 1022),
(188, 9, '2024-10-08', 'ATACADAO 0945 AS', '-', '139.52', 160, 1021),
(189, 9, '2024-09-27', 'POSTO PANORAMA', '-', '20.00', 160, 1022),
(190, 9, '2024-09-27', '1A99', '-', '30.25', 160, 1021),
(191, 9, '2024-09-27', 'CLEUSA DOS SANTOS LEME', '-', '28.00', 160, 1018),
(192, 9, '2024-09-27', 'JAPONESA COSMETIC', '-', '45.96', 160, 1019),
(193, 9, '2024-09-27', 'SUPERMERCADO JARD', '-', '16.99', 160, 1021),
(194, 9, '2024-09-28', 'SILVANA B GONCALVES', '-', '6.90', 160, 1026),
(195, 9, '2024-09-28', 'CHEN WENZHOU', '-', '8.00', 160, 1026),
(196, 9, '2024-09-30', 'LUCIANO DE ANDRADE COSTA', '2 de 2', '63.89', 160, 1026),
(197, 9, '2024-09-30', 'SHOPEE *JCMOTOPEAS', '2 de 2', '76.74', 160, 1024),
(198, 9, '2024-11-01', 'SILVANA B GONCALVES', '-', '59.38', 160, 1026),
(199, 9, '2024-11-02', 'AUTO POSTO N. R.', '-', '30.00', 160, 1022),
(200, 9, '2024-11-04', 'ARMAZEM DA TERRA', '2 de 2', '60.00', 160, 1026),
(201, 9, '2024-11-04', 'AUTO POSTO N. R.', '-', '30.00', 160, 1022),
(202, 9, '2024-11-12', 'ATACADAO 0945 AS', '-', '165.16', 160, 1021),
(203, 9, '2024-10-24', 'AUTO POSTO N. R.', '-', '30.00', 160, 1022),
(204, 9, '2024-10-24', 'SOSBEER', '-', '7.50', 160, 1018),
(205, 9, '2024-10-25', 'SUPERMERCADO JARD', '-', '22.97', 160, 1021),
(206, 9, '2024-10-25', 'SUPERMERCADO JARD', '-', '7.99', 160, 1021),
(207, 9, '2024-10-25', 'AUTO POSTO N. R.', '-', '50.00', 160, 1022),
(208, 9, '2024-10-25', 'ALEM DA MAKE', '-', '70.00', 160, 1019),
(209, 9, '2024-10-29', 'MP *FISIOLC', '-', '80.00', 160, 1026),
(210, 10, '2024-10-02', ' SUPERM PENHA CENTER	-	', '-', '13.34', 160, 1021),
(211, 10, '2024-10-02', ' SosBeer	-	', '-', '20.00', 160, 1018),
(212, 10, '2024-09-11', ' SKYFIT ITAPIRA (ParcelaI	-	', '12 de 12', '89.90', 160, 1028),
(213, 10, '2024-10-05', ' PAROQUIA NOSSA SENHORA	-	', '-', '37.00', 160, 1018),
(214, 10, '2024-10-05', ' MayraGrazieleDa	-	', '-', '17.68', 160, 1026),
(215, 10, '2024-10-10', ' AGRO CUBATAO	-	', '-', '40.88', 160, 1021),
(216, 10, '2024-10-11', ' AUTO POSTO ARENA DE I	-	', '-', '48.71', 160, 1022),
(217, 10, '2024-10-12', ' PIZZARIA LEVITA\'S DE	-	', '-', '67.00', 160, 1021),
(218, 10, '2024-10-12', ' Zeferinoltda	-	', '-', '43.96', 160, 1023),
(219, 10, '2024-10-13', ' SUPERMERCADO POPULAR D	-	', '-', '10.99', 160, 1021),
(220, 10, '2024-10-14', ' TABACARIA JB 05	-	', '-', '26.90', 160, 1018),
(221, 10, '2024-10-14', ' SHOPEE *vivarosa	-	', '-', '65.59', 160, 1024),
(222, 10, '2024-10-17', ' SUPERM PENHA CENTER	-	', '-', '28.32', 160, 1021),
(223, 10, '2024-10-17', ' SHOPEE *MariaLizCosmti	-	', '-', '42.97', 160, 1024),
(224, 10, '2024-10-19', ' Pizzaria	-	', '-', '39.20', 160, 1021),
(225, 10, '2024-10-19', ' SUPERMERCADO GELAIN DE	-	', '-', '11.99', 160, 1021),
(226, 10, '2024-10-19', ' MP *CLIENTECONSUMIDOR	-	', '-', '16.00', 160, 1026),
(227, 10, '2024-10-19', ' MP *SUCHINAITAPIR	-	', '-', '80.90', 160, 1026),
(228, 10, '2024-10-25', ' CLEUSA DOS SANTOS LEME	-	', '-', '25.00', 160, 1018),
(229, 10, '2024-10-26', ' RAIA246	-	', '-', '11.31', 160, 1023),
(230, 10, '2024-10-26', ' ABAST SHELL BOX	-	', '-', '50.00', 160, 1022),
(231, 10, '2024-10-27', ' Zeferinoltda	-	', '-', '53.09', 160, 1023),
(232, 10, '2024-11-02', ' MOG BURGUER	-	', '-', '56.00', 160, 1018),
(233, 10, '2024-11-02', ' RogerioFirmino	-	', '-', '51.90', 160, 1026),
(234, 10, '2024-10-24', ' AUTO POSTO N. R.	-	', '-', '42.32', 160, 1022),
(235, 10, '2024-10-30', ' TABACARIA JB 05	-	', '-', '22.90', 160, 1018),
(236, 10, '2024-08-11', ' SKYFIT ITAPIRA (ParcelaI	-	', '11 de 12', '89.90', 160, 1028),
(241, 10, '2024-07-11', ' SKYFIT ITAPIRA (ParcelaI	-	', '10 de 12', '89.90', 160, 1028),
(243, 11, '2024-09-22', 'Zeferinoltda', '-', '64.44', 160, 1023),
(244, 11, '2024-09-30', 'Divino Gelato', '-', '15.00', 160, 1021),
(246, 11, '2024-09-30', 'Auto Posto N. R.', '-', '40.00', 160, 1022),
(247, 11, '2024-10-04', 'ARMAZEM DA TERRA', '1 de 2', '60.00', 160, 1026),
(248, 11, '2024-10-05', 'JANAINAMENEZESBAR', '-', '75.00', 160, 1018),
(249, 11, '2024-10-06', 'SMASH BURGER', '-', '43.00', 160, 1018),
(250, 11, '2024-10-06', 'MIX REAL', '-', '14.00', 160, 1021),
(251, 11, '2024-10-07', 'SUPERMERCADO JARD', '-', '3.86', 160, 1021),
(253, 11, '2024-10-07', 'AUTO POSTO N. R.', '-', '30.00', 160, 1022),
(254, 11, '2024-10-08', 'ATACADAO 0945 AS', '-', '69.76', 160, 1021),
(256, 11, '2024-09-27', 'POSTO PANORAMA', '-', '20.00', 160, 1022),
(258, 11, '2024-09-27', 'JAPONESA COSMETIC', '-', '45.96', 160, 1019),
(259, 11, '2024-09-27', 'SUPERMERCADO JARD', '-', '16.99', 160, 1021),
(261, 11, '2024-09-28', 'SILVANA B GONCALVES', '-', '6.90', 160, 1026),
(264, 11, '2024-11-01', 'SILVANA B GONCALVES', '-', '59.38', 160, 1026),
(265, 11, '2024-11-02', 'AUTO POSTO N. R.', '-', '30.00', 160, 1022),
(266, 11, '2024-11-04', 'ARMAZEM DA TERRA', '2 de 2', '60.00', 160, 1026),
(267, 11, '2024-11-12', 'ATACADAO 0945 AS', '-', '82.98', 160, 1021),
(268, 11, '2024-10-25', 'SUPERMERCADO JARD', '-', '22.97', 160, 1021),
(269, 11, '2024-10-25', 'AUTO POSTO N. R.', '-', '25.00', 160, 1022),
(271, 11, '2024-10-25', 'ALEM DA MAKE', '-', '70.00', 160, 1019),
(272, 11, '2024-10-29', 'MP *FISIOLC', '-', '80.00', 160, 1026),
(274, 11, '2024-10-05', ' PAROQUIA NOSSA SENHORA	-	', '-', '18.50', 160, 1018),
(275, 11, '2024-10-05', ' MayraGrazieleDa	-	', '-', '17.68', 160, 1026),
(277, 11, '2024-10-12', ' PIZZARIA LEVITA\'S DE	-	', '-', '33.50', 160, 1021),
(278, 11, '2024-10-12', ' Zeferinoltda	-	', '-', '21.98', 160, 1023),
(279, 11, '2024-10-13', ' SUPERMERCADO POPULAR D	-	', '-', '10.99', 160, 1021),
(280, 11, '2024-10-19', ' SUPERMERCADO GELAIN DE	-	', '-', '11.99', 160, 1021),
(281, 11, '2024-10-19', ' MP *SUCHINAITAPIR	-	', '-', '80.90', 160, 1026),
(283, 11, '2024-10-26', ' ABAST SHELL BOX	-	', '-', '25.00', 160, 1022),
(284, 11, '2024-10-27', ' Zeferinoltda	-	', '-', '26.54', 160, 1023),
(285, 11, '2024-11-02', ' RogerioFirmino	-	', '-', '25.95', 160, 1026),
(287, 11, '2024-08-30', 'LUCIANO DE ANDRADE COSTA', '1 de 2', '63.90', 160, 1026);

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

--
-- Extraindo dados da tabela `produtos_clientes`
--

INSERT INTO `produtos_clientes` (`id`, `cliente_id`, `data`, `data_entrega`, `produto`, `quantidade`, `valor_cliente`, `valor_pagamento`, `user_id`) VALUES
(16, 1, '2024-10-22', '2024-10-25', 'caneta', 11, '11.00', '7.00', 3),
(17, 1, '2024-10-28', '2024-10-23', 'caneta', 4, '44.00', '33.00', 3),
(18, 1, '2024-10-21', '2024-10-11', 'caneta', 2, '20.00', '10.00', 3),
(19, 1, '2024-10-28', '2024-10-26', 'caneta 02', 4, '23.00', '14.00', 3),
(21, 1, '2024-10-28', '2024-10-26', 'caneta', 3, '90.00', '23.00', 3),
(22, 1, '2024-10-23', NULL, 'caneta', 2, '23.00', '12.00', 3),
(23, 1, '2024-10-28', NULL, 'caneta 2', 43, '2.00', '1.00', 3),
(27, 6, '2024-10-22', '2024-10-25', 'caneta', 11, '11.00', '7.00', 3),
(28, 6, '2024-10-23', NULL, 'caneta', 2, '23.00', '12.00', 3),
(29, 8, '2024-12-04', NULL, 'caneta', 2, '10.00', '5.00', 160);

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
(160, 1, 1, 'marcobubola@hotmail.com', NULL, 'marco a', '$2y$13$kGsJ9A68ie6ubYO.QGyV2.9hIQ99lrxUDUTdfYeNHf.yW3PSivfUu', 'mNWBnejX49pBYbbV3MdoOiwxIHUKbpsF', 'qHW42MF9vgub5ZK9ACwS-zgmjPf3gV0o', '::1', '2024-12-15 18:38:25', '::1', '2024-11-29 17:25:27', NULL, NULL, NULL);

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
  MODIFY `id_bancos` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `cashbook`
--
ALTER TABLE `cashbook`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2262;

--
-- AUTO_INCREMENT de tabela `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1032;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `faturas`
--
ALTER TABLE `faturas`
  MODIFY `id_fatura` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=288;

--
-- AUTO_INCREMENT de tabela `produtos_clientes`
--
ALTER TABLE `produtos_clientes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

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
