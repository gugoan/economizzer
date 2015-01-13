-- phpMyAdmin SQL Dump
-- version 4.2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 12-Jan-2015 às 03:53
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
  `category_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `value` float NOT NULL,
  `description` varchar(45) DEFAULT NULL,
  `date` date NOT NULL,
  `is_pending` tinyint(1) NOT NULL DEFAULT '0',
  `attachment` varchar(255) DEFAULT NULL,
  `inc_datetime` datetime DEFAULT NULL COMMENT 'insert date',
  `edit_datetime` datetime DEFAULT NULL COMMENT 'edit date'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Control financial movement' AUTO_INCREMENT=148 ;

--
-- Extraindo dados da tabela `tb_cashbook`
--

INSERT INTO `tb_cashbook` (`id`, `category_id`, `type_id`, `value`, `description`, `date`, `is_pending`, `attachment`, `inc_datetime`, `edit_datetime`) VALUES
(4, 2, 2, -112, 'referente a jan 2014', '2014-01-24', 0, NULL, NULL, '2014-02-25 09:57:36'),
(6, 1, 1, 1357.36, 'jan 2014', '2014-01-03', 0, NULL, NULL, '2014-02-25 09:56:35'),
(31, 10, 2, -35, 'jan 2014', '2014-01-13', 0, NULL, '2014-02-25 09:58:11', '2014-02-25 09:58:11'),
(32, 6, 2, -100, 'Emprestimo Valdeilton', '2014-01-17', 0, NULL, '2014-02-25 09:58:46', '2014-02-25 09:58:46'),
(33, 6, 1, 100, 'Pag emprest Valdeilton', '2014-01-24', 0, NULL, '2014-02-25 09:59:22', '2014-02-25 09:59:22'),
(34, 11, 2, -13.72, 'Jan 2014 (desconto off)', '2014-01-24', 0, NULL, '2014-02-25 10:00:23', '2014-02-25 10:00:23'),
(35, 12, 2, -49.9, 'jan 2014', '2014-01-24', 0, NULL, '2014-02-25 10:00:51', '2014-02-25 10:00:51'),
(36, 13, 2, -330.2, 'jan 2014', '2014-01-27', 0, NULL, '2014-02-25 10:01:25', '2014-02-25 10:01:25'),
(37, 9, 2, -350, 'Parcela casa ', '2014-01-29', 0, NULL, '2014-02-25 10:02:01', '2014-02-25 10:02:01'),
(38, 8, 2, -25, 'jan 2014', '2014-01-28', 0, NULL, '2014-02-25 10:09:54', '2014-02-25 10:09:54'),
(39, 8, 2, -26.67, 'referente a JAN 2014', '2014-02-27', 0, NULL, '2014-02-27 10:08:22', '2014-02-27 12:34:52'),
(40, 2, 2, 105.52, 'referente a FEV 2014', '2014-02-27', 0, NULL, '2014-02-27 10:08:45', '2014-02-27 20:50:23'),
(42, 12, 2, -49.9, 'referente a FEV 2014', '2014-02-27', 0, NULL, '2014-02-27 10:09:28', '2014-02-27 12:42:40'),
(43, 11, 2, -54.9, 'referente a FEV 2014', '2014-02-27', 0, NULL, '2014-02-27 10:09:52', '2014-02-27 12:38:30'),
(44, 13, 2, -254.01, 'referente a FEV 2014', '2014-02-27', 0, NULL, '2014-02-27 10:10:11', '2014-02-27 12:47:15'),
(45, 14, 2, -12.2, 'referente a FEV 2014', '2014-02-27', 0, NULL, '2014-02-27 12:48:21', '2014-02-27 12:48:21'),
(46, 15, 1, 2500, 'Website Sicoob Credivale', '2014-02-21', 0, NULL, '2014-02-27 13:23:49', '2014-02-27 13:23:49'),
(47, 1, 1, 1571.15, 'referente a JAN 2014', '2014-02-04', 0, NULL, '2014-02-27 13:24:56', '2014-02-27 13:24:56'),
(48, 2, 2, -91.91, 'CEMIG pendencia NOV 2013', '2014-02-11', 0, NULL, '2014-02-27 13:26:18', '2014-02-27 13:26:32'),
(49, 6, 2, -116.64, 'Taxa Lixo 2014', '2014-02-10', 0, NULL, '2014-02-27 13:27:24', '2014-02-27 13:27:24'),
(50, 7, 2, -77.79, 'CONV-PLANO SAUD', '2014-02-12', 0, NULL, '2014-02-27 13:28:19', '2014-02-27 13:28:19'),
(51, 10, 2, -38.7, 'referente a FEV 2014', '2014-02-14', 0, NULL, '2014-02-27 13:29:43', '2014-02-27 13:29:43'),
(52, 9, 2, 220, 'minha parte, possui  220', '2014-03-20', 0, NULL, '2014-02-27 20:43:25', '2014-03-12 20:53:19'),
(53, 9, 2, -280, '(parte ref a Fev 2014)', '2014-02-27', 0, 'comprovante_caixa_fev2014.pdf', '2014-02-27 20:52:19', '2014-02-27 20:52:19'),
(54, 6, 2, -80, 'Concurso UFJF', '2014-03-05', 0, NULL, '2014-03-05 16:56:35', '2014-03-05 16:56:35'),
(55, 6, 2, -350, 'Emplacamento', '2014-03-12', 0, NULL, '2014-03-12 20:13:21', '2014-03-12 20:13:21'),
(56, 10, 2, -38.7, 'Mês Referência 03/2014', '2014-03-12', 0, NULL, '2014-03-12 20:21:33', '2014-03-12 20:21:33'),
(57, 1, 1, 202.28, 'CRÉD.FOLHA PAGTO-FUNCION', '2014-03-06', 0, NULL, '2014-03-12 20:27:10', '2014-03-12 20:27:10'),
(58, 14, 2, -12.2, 'ref mar 2014', '2014-03-24', 0, 'cabal mar2014.pdf', '2014-03-22 10:19:00', '2014-03-22 10:19:00'),
(59, 8, 2, -26.67, 'ref fev 2014', '2014-03-24', 0, 'comprovante_saae_fev2014.pdf', '2014-03-24 16:32:07', '2014-03-24 16:32:07'),
(60, 6, 2, 14.45, 'UOLHOST ', '2014-03-31', 0, NULL, '2014-03-31 10:27:15', '2014-03-31 10:27:15'),
(61, 14, 2, -12.2, 'vencimento 07/04/2014', '2014-03-04', 0, NULL, '2014-04-02 21:20:07', '2014-04-02 21:20:07'),
(62, 13, 2, -906, 'Fatura de ABRIL', '2014-05-04', 0, 'Comprovante_Fatura de ABRIL_Mastercard.pdf', '2014-04-02 21:26:11', '2014-04-02 21:26:11'),
(63, 11, 2, 0, 'Pago pela Ju 49,90', '2014-03-27', 0, NULL, '2014-04-02 21:28:51', '2014-04-02 21:28:51'),
(64, 12, 2, 0, 'Pago pela Ju 54,90', '2014-03-27', 0, NULL, '2014-04-02 21:29:14', '2014-04-02 21:29:14'),
(65, 16, 2, 399, 'Parcela 01/60', '2014-04-11', 1, NULL, '2014-04-02 21:47:40', '2014-04-02 21:49:13'),
(66, 6, 2, -26.04, 'IPTU - 1a Parcela', '2014-03-28', 0, NULL, '2014-04-02 22:00:02', '2014-04-02 22:00:02'),
(67, 2, 2, -136, 'ref 04/2014 Pag pela ju', '2014-04-07', 0, NULL, '2014-04-07 21:55:01', '2014-04-07 21:55:01'),
(68, 16, 2, -399, '01/60 (pago pela ju)', '2014-04-09', 0, NULL, '2014-04-09 21:24:44', '2014-04-09 21:24:44'),
(69, 10, 2, -38.7, 'ref abril 2014', '2014-04-22', 0, 'comprovante_vivo_2014.pdf', '2014-04-19 15:35:06', '2014-04-19 15:35:06'),
(70, 8, 2, -26.67, 'Ref MAR 2014', '2014-04-29', 0, NULL, '2014-04-29 13:50:47', '2014-04-29 13:50:47'),
(71, 13, 2, 98, 'Ref Maio 2014', '2014-05-07', 0, 'comrpovante_mastercard_maio2014.pdf', '2014-05-07 19:24:07', '2014-05-07 19:24:07'),
(72, 16, 2, -399, 'Parcela 02/60', '2014-05-07', 0, 'comprovante_carro_02_de_60.pdf', '2014-05-07 19:28:08', '2014-05-07 19:28:08'),
(73, 6, 2, -168, 'Emprestimo 01/04', '2014-05-10', 0, NULL, '2014-05-07 19:31:13', '2014-05-07 19:31:13'),
(74, 1, 1, 1570, 'CRÉD.FOLHA PAGTO-FUNC', '2014-05-04', 0, NULL, '2014-05-07 19:31:55', '2014-05-07 19:31:55'),
(75, 6, 2, -336, '3a Parcela IPVA Carro', '2014-05-07', 0, 'Comprovante_3a_parcela_ipva_carro.pdf', '2014-05-07 19:39:29', '2014-05-07 19:39:29'),
(76, 2, 2, -109, 'Pago pela Ju -Ref 05/2014', '2014-05-07', 0, NULL, '2014-05-07 20:44:20', '2014-05-07 20:44:20'),
(77, 6, 2, -184, 'Revisão Moto (troca oleo)', '2014-05-16', 0, NULL, '2014-05-16 12:01:13', '2014-05-16 12:01:13'),
(78, 10, 2, -38.7, 'Ref Maio 2014', '2014-05-16', 0, 'comprovante_vivo_maio2014.pdf', '2014-05-16 20:23:04', '2014-05-16 20:23:04'),
(79, 6, 2, -26.04, 'IPTU 02/08', '2014-05-20', 0, 'comprovante_IPTU_02de08.pdf', '2014-05-20 19:57:11', '2014-05-20 19:57:11'),
(80, 8, 2, -26.67, 'Referente a abril 2014', '2014-05-28', 0, 'comprovante_saae_maio2014_refabril_2014.pdf', '2014-05-28 20:48:38', '2014-05-28 20:48:38'),
(81, 6, 2, -26.04, 'IPTU 3a Parcela', '2014-06-09', 0, 'comprovante_iptu_3a_parcela.pdf', '2014-06-09 20:05:12', '2014-06-09 20:05:12'),
(82, 16, 2, -399, 'Parcela 03/60', '2014-06-09', 0, 'comprovante_carro_3a_parcela.pdf', '2014-06-09 20:06:13', '2014-06-09 20:06:13'),
(83, 2, 2, -100.75, 'Ref Maio 2014', '2014-06-10', 0, 'comprovante_cemig_ref_maio2014.pdf', '2014-06-09 20:07:02', '2014-06-09 20:07:02'),
(84, 1, 1, 1571.15, 'Ref Maio 2014', '2014-06-03', 0, NULL, '2014-06-09 20:07:55', '2014-06-09 20:07:55'),
(85, 13, 2, -293.55, 'ref maio/jun 2014', '2014-07-02', 0, 'comprovante_mastercard_refmaio2014.pdf', '2014-07-02 13:40:23', '2014-07-02 13:40:23'),
(86, 11, 2, -54.9, 'ref jun 2014 pago pela ju', '2014-07-05', 0, NULL, '2014-07-05 21:04:12', '2014-07-05 21:04:12'),
(87, 2, 2, -112.95, 'Ref a Junho 2014', '2014-07-07', 0, 'comprovante_cemig_jun2014.pdf', '2014-07-07 21:03:19', '2014-07-07 21:03:19'),
(88, 16, 2, -399, 'Parcela 04 / 60', '2014-07-08', 0, 'comprovante_carro_04_de_60.pdf', '2014-07-07 21:07:04', '2014-07-07 21:07:04'),
(89, 6, 2, -26.04, 'Parcela 04 de 08 iptu ', '2014-07-09', 0, 'comprovante_Parc04de08iptu .pdf', '2014-07-09 21:09:43', '2014-07-09 21:09:43'),
(90, 8, 2, -26.67, 'ref maio/jun 2014', '2014-07-14', 0, 'comprovante_saae_maio2014.pdf', '2014-07-14 12:41:32', '2014-07-14 12:41:32'),
(91, 6, 2, -42.56, 'Multa (transf p celinho)', '2014-07-14', 0, 'Comprovante_transf_celinho_multa_zazul.pdf', '2014-07-14 12:44:53', '2014-07-14 12:44:53'),
(92, 1, 1, 1571, 'Junho 2014', '2014-07-02', 0, NULL, '2014-07-14 12:45:42', '2014-07-14 12:45:42'),
(93, 10, 2, -38.7, 'Ref a Julho 2014', '2014-07-18', 0, 'comprovante_vivo_julho2014.pdf', '2014-07-18 15:24:42', '2014-07-18 15:24:42'),
(94, 8, 2, -28.59, 'Ref a Junho 14 - Pg Ju', '2014-07-21', 0, NULL, '2014-07-21 19:08:32', '2014-07-21 19:08:32'),
(95, 12, 2, -49.9, 'Ref a Julho 2014 - PG ju', '2014-07-21', 0, NULL, '2014-07-21 19:09:52', '2014-07-21 19:09:52'),
(96, 6, 1, 500, 'Emprest Sicoob Txs Detran', '2014-07-24', 0, 'comprovante_emprestimo500_jul2014.pdf', '2014-07-24 13:22:48', '2014-07-24 13:22:48'),
(97, 6, 2, -40.35, 'IPVA 2014 Parcela 1', '2014-07-24', 0, 'Comprovantes Parcelas IPVA.pdf', '2014-07-24 13:28:39', '2014-07-24 13:28:39'),
(98, 6, 2, -40.04, 'IPVA 2014 Parcela 2', '2014-07-24', 0, 'Comprovantes Parcelas IPVA.pdf', '2014-07-24 13:29:11', '2014-07-24 13:29:11'),
(99, 6, 2, -39.75, 'IPVA 2014 Parcela 3', '2014-07-24', 0, 'Comprovantes Parcelas IPVA.pdf', '2014-07-24 13:29:33', '2014-07-24 13:29:33'),
(100, 6, 2, -87.17, 'TRLAV 2014 Parcela Unica', '2014-07-24', 0, 'Comprovante DPVAT e TRLAV 2014.pdf', '2014-07-24 13:30:24', '2014-07-24 13:30:24'),
(101, 6, 2, -292, 'DPVAT 2014 Parcela Unica', '2014-07-24', 0, 'Comprovante DPVAT e TRLAV 2014.pdf', '2014-07-24 13:30:56', '2014-07-24 13:30:56'),
(102, 13, 2, -225.36, 'Ref a Julho/ago 2014', '2014-07-24', 0, 'comprovante_mastercard_07-2014.pdf', '2014-07-24 15:07:13', '2014-07-24 15:07:13'),
(103, 6, 2, 80, 'Tenis Polyana 1a parte', '2014-08-10', 1, NULL, '2014-08-03 16:23:21', '2014-08-09 20:13:50'),
(104, 16, 2, -399, 'Parcela 05/60', '2014-08-07', 0, 'comprovante_carro_parcela05.pdf', '2014-08-07 20:39:19', '2014-08-07 20:39:19'),
(105, 1, 1, 1571, 'CRÉD.FOLHA PAGT04/08/2014', '2014-08-04', 0, NULL, '2014-08-07 20:41:19', '2014-08-07 20:41:19'),
(106, 2, 2, 106, 'Pago pela Ju', '2014-08-22', 0, NULL, '2014-08-07 20:43:58', '2014-08-20 18:26:02'),
(107, 6, 2, -600, 'Emprestimo Igor', '2014-08-04', 0, NULL, '2014-08-07 20:45:43', '2014-08-07 20:45:43'),
(108, 6, 2, 26, 'IPTU Parcela 5', '2014-08-11', 0, NULL, '2014-08-10 16:44:45', '2014-08-10 16:45:01'),
(109, 10, 2, -38.7, 'Ref Ago 2014', '2014-08-15', 0, 'comprovante_vivo_ago2014.pdf', '2014-08-15 10:10:48', '2014-08-15 10:10:48'),
(110, 1, 1, 518, 'Parcial de 30% do PL', '2014-08-25', 0, NULL, '2014-08-24 16:48:52', '2014-08-24 16:48:52'),
(111, 6, 2, -282, 'Seguro Parcela 1 de 4', '2014-08-25', 0, NULL, '2014-08-24 16:50:01', '2014-08-24 16:50:01'),
(112, 8, 2, -26, 'Ref a Julho 2014', '2014-08-25', 0, 'comprovante_saae_jul2014.pdf', '2014-08-26 08:57:17', '2014-08-26 08:57:17'),
(113, 13, 2, -85.37, 'Vencimento 03/09/2014', '2014-09-01', 0, 'comprovante_mastercard_ago2014.pdf', '2014-09-01 15:01:44', '2014-09-01 15:01:44'),
(114, 1, 1, 1536, 'set 2014', '2014-09-02', 0, NULL, '2014-09-02 13:19:28', '2014-09-02 13:19:28'),
(115, 6, 2, 200, 'Moto 479 = 200+279 em 2x', '2014-09-02', 0, 'nf_motomol_conserto_02-09-2014.pdf', '2014-09-02 13:23:52', '2014-09-02 13:24:08'),
(116, 2, 2, -105.69, 'Ref AGO/2014', '2014-09-02', 0, 'comprovante_cemig_AGO-2014.pdf', '2014-09-02 21:58:23', '2014-09-02 21:58:23'),
(117, 6, 2, -52, 'Torneira para Pia do banh', '2014-09-05', 0, NULL, '2014-09-06 16:36:50', '2014-09-06 16:36:50'),
(118, 16, 2, -399, 'Parcela 06 de 60', '2014-09-08', 0, 'comprovante_carro_parcela_6.pdf', '2014-09-08 18:55:31', '2014-09-08 18:55:31'),
(119, 6, 2, -80, 'Tenis Polyana 2a parcela', '2014-09-08', 1, NULL, '2014-09-08 18:56:01', '2014-09-08 18:56:01'),
(120, 6, 2, -26, 'IPTU 2014 Parcela 6 de 8', '2014-09-08', 0, 'comprovante_iptu_2014_parcela6.pdf', '2014-09-08 19:00:13', '2014-09-08 19:00:13'),
(121, 8, 2, -26.67, 'Ref Ago 2014', '2014-09-17', 0, 'comprovante_saae_ago2014.pdf', '2014-09-18 16:37:35', '2014-09-18 16:37:35'),
(122, 10, 2, -38, 'Ref a Set 2014', '2014-10-01', 0, 'comprovante_vivo_set2014.pdf', '2014-10-01 19:20:25', '2014-10-01 19:20:25'),
(123, 13, 2, -483, 'Ref Set 2014', '2014-10-02', 0, 'comprovante_mastercard_set2014.pdf', '2014-10-02 19:19:33', '2014-10-02 19:19:33'),
(124, 1, 1, 1524, '', '2014-10-02', 0, NULL, '2014-10-02 19:20:07', '2014-10-02 19:20:07'),
(125, 16, 2, -399, 'Parcela 07 de 60', '2014-10-05', 0, 'comprovante_carro_parcela07.pdf', '2014-10-05 18:04:33', '2014-10-05 18:04:33'),
(126, 6, 2, -26, 'IPTU casa parcela 8', '2014-10-13', 0, 'comprovante_iptu_parcela8.pdf', '2014-10-13 20:59:01', '2014-10-13 20:59:01'),
(127, 2, 2, -105.88, 'Pago pelaju', '2014-10-14', 0, NULL, '2014-10-14 21:43:43', '2014-10-14 21:43:43'),
(128, 6, 2, 30, 'Dominio CdX', '2014-10-17', 0, NULL, '2014-10-17 13:11:01', '2014-10-17 13:14:54'),
(129, 10, 2, -39.6, 'Mes Referencia 10/2014', '2014-10-17', 0, 'comprovante_vivo_out2014.pdf', '2014-10-17 13:23:28', '2014-10-17 13:23:28'),
(130, 6, 2, -275, 'Parcela seguro carro', '2014-10-18', 0, NULL, '2014-10-20 13:51:39', '2014-10-20 13:51:39'),
(131, 8, 2, -26.67, 'Referente a Set 2014', '2014-10-23', 0, 'comprovante_vivo_out2014.pdf', '2014-10-23 12:37:00', '2014-10-23 12:37:00'),
(132, 13, 2, -433, 'Nov 2014', '2014-11-04', 0, 'comprovante_mastercard_nov2014.pdf', '2014-11-04 19:58:01', '2014-11-04 19:58:01'),
(133, 1, 1, 1502, 'Nov 2014', '2014-11-04', 0, NULL, '2014-11-04 19:58:47', '2014-11-04 19:58:47'),
(134, 16, 2, -399, 'Parcela 08/60', '2014-11-05', 0, 'comprovante_carro_parcela8.pdf', '2014-11-05 22:06:29', '2014-11-05 22:06:29'),
(135, 6, 1, 200, 'Parcela emprestimo igor', '2014-11-07', 0, NULL, '2014-11-10 21:44:34', '2014-11-10 21:44:34'),
(136, 8, 2, -26, 'Ref Out de 2014', '2014-11-18', 0, 'comprovante_saae_out2014.pdf', '2014-11-18 19:48:05', '2014-11-18 19:48:05'),
(137, 2, 2, -143, 'Pago pela Ju', '2014-11-18', 0, NULL, '2014-11-19 20:51:26', '2014-11-19 20:51:26'),
(138, 6, 1, 300, 'Juliana', '2014-11-20', 0, 'comprovante_300_juliana_p_gustavo.pdf', '2014-11-20 13:16:40', '2014-11-20 13:16:40'),
(139, 10, 2, -38, 'Ref nov 2014', '2014-11-21', 0, 'comprovante_vivo_nov2014.pdf', '2014-11-21 09:54:03', '2014-11-21 09:54:03'),
(140, 6, 2, -273, 'Seg Carro (Pag JU)', '2014-11-20', 0, NULL, '2014-11-21 09:55:25', '2014-11-21 09:55:25'),
(141, 6, 2, -380, 'Solar das Hort - Entrada', '2014-11-17', 0, NULL, '2014-11-21 09:56:27', '2014-11-21 09:56:27'),
(142, 6, 2, -197, 'Gabinete X-Trike V9', '2014-12-02', 0, 'comprovante_pagamento_boleto.pdf', '2014-12-02 10:22:55', '2014-12-02 10:22:55'),
(143, 1, 1, 1641, 'dez 2014', '2014-12-02', 0, NULL, '2014-12-02 10:25:25', '2014-12-02 10:25:25'),
(144, 13, 2, -69, 'dez 2014', '2014-12-02', 0, 'comprovante_mastercard_dez2014.pdf', '2014-12-02 10:29:10', '2014-12-02 10:29:10'),
(145, 16, 2, -399, 'Parcela 09 / 60', '2014-12-04', 0, 'comprovante_carro_parcela09de60.pdf', '2014-12-04 21:06:26', '2014-12-04 21:06:26'),
(146, 2, 2, -118, 'Ref a NOVEMBRO 2014', '2014-12-04', 0, 'comprovante_cemig_dez2014.pdf', '2014-12-04 21:11:46', '2014-12-04 21:11:46'),
(147, 6, 2, -30, 'gustavoandrade.net.br', '2014-12-04', 0, 'comprovante_dominio_gus2014.pdf', '2014-12-04 21:16:48', '2014-12-04 21:16:48');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_category`
--

CREATE TABLE IF NOT EXISTS `tb_category` (
`id_category` int(11) NOT NULL,
  `desc_category` varchar(45) NOT NULL,
  `hexcolor_category` varchar(45) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Categories of entries: Water, light, card, etc.' AUTO_INCREMENT=17 ;

--
-- Extraindo dados da tabela `tb_category`
--

INSERT INTO `tb_category` (`id_category`, `desc_category`, `hexcolor_category`) VALUES
(1, 'SALÁRIO', ''),
(2, 'CEMIG', ''),
(5, 'POS', ''),
(6, 'OUTRO', ''),
(7, 'VIVAMED', ''),
(8, 'SAAE', NULL),
(9, 'FINAN CASA', NULL),
(10, 'VIVO', NULL),
(11, 'INTERNET', NULL),
(12, 'TV CABO', NULL),
(13, 'MASTERCARD', NULL),
(14, 'CABAL', NULL),
(15, 'FREELA', NULL),
(16, 'FINANC CARRO', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_type`
--

CREATE TABLE IF NOT EXISTS `tb_type` (
`id_type` int(11) NOT NULL,
  `desc_type` varchar(45) NOT NULL,
  `hexcolor_type` varchar(45) DEFAULT NULL,
  `icon_type` varchar(45) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Movement Type: Debit, Credit' AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `tb_type`
--

INSERT INTO `tb_type` (`id_type`, `desc_type`, `hexcolor_type`, `icon_type`) VALUES
(1, 'Receita', '003300', ''),
(2, 'Despesa', 'CC0000', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_cashbook`
--
ALTER TABLE `tb_cashbook`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_fin_movimento_fin_cat_idx` (`category_id`), ADD KEY `fk_fin_movimento_fin_tipo1_idx` (`type_id`);

--
-- Indexes for table `tb_category`
--
ALTER TABLE `tb_category`
 ADD PRIMARY KEY (`id_category`);

--
-- Indexes for table `tb_type`
--
ALTER TABLE `tb_type`
 ADD PRIMARY KEY (`id_type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_cashbook`
--
ALTER TABLE `tb_cashbook`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=148;
--
-- AUTO_INCREMENT for table `tb_category`
--
ALTER TABLE `tb_category`
MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `tb_type`
--
ALTER TABLE `tb_type`
MODIFY `id_type` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
