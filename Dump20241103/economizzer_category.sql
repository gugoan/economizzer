-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: localhost    Database: economizzer
-- ------------------------------------------------------
-- Server version	9.0.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category` (
  `id_category` int NOT NULL AUTO_INCREMENT,
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
  `user_id` int NOT NULL,
  PRIMARY KEY (`id_category`),
  KEY `fk_tb_category_tb_user1_idx` (`user_id`),
  KEY `fk_category_bancos` (`id_bancos`),
  KEY `fk_category_clientes_idx` (`id_clientes`),
  KEY `fk_category_produtos_clientes_idx` (`id_produtos_clientes`),
  CONSTRAINT `fk_category_bancos` FOREIGN KEY (`id_bancos`) REFERENCES `bancos` (`id_bancos`),
  CONSTRAINT `fk_category_clientes` FOREIGN KEY (`id_clientes`) REFERENCES `clientes` (`id`),
  CONSTRAINT `fk_category_produtos_clientes` FOREIGN KEY (`id_produtos_clientes`) REFERENCES `produtos_clientes` (`id`),
  CONSTRAINT `fk_tb_category_tb_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1020 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci COMMENT='Categories of entries: Water, light, card, etc.';
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-03 11:28:56
