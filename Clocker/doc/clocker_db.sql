-- MySQL dump 10.13  Distrib 8.0.18, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: clocker_db
-- ------------------------------------------------------
-- Server version	5.5.5-10.5.9-MariaDB

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
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES (1,10,'Test_klient_db'),(5,3,'Klient 1'),(6,3,'Klient 2'),(7,3,'Klient 3'),(11,3,'Klient 4'),(13,10,'Klient 5'),(14,10,'Klient 1'),(15,3,'Klient 5');
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (11,NULL,10,'Task 1',29.11),(12,NULL,10,'Projekt 1',NULL),(13,1,10,'Projekt_update_v2 3',NULL),(14,NULL,10,'Projekt 2',NULL),(16,NULL,13,'Projekt 1',NULL),(17,6,3,'Projekt 1',NULL),(18,5,3,'Projekt 2',NULL),(19,NULL,10,'Projekt 3',NULL),(20,1,10,'Projekt 4',NULL),(21,7,3,'Projekt 3',NULL),(22,1,10,'ABC',39.99);
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `start` datetime NOT NULL,
  `stop` datetime DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` VALUES (1,10,11,'Zmieniona nazwa','2022-01-16 16:07:27','2022-01-16 18:46:09',NULL),(2,10,NULL,'Task 1','2022-01-16 16:09:12',NULL,NULL),(11,10,11,'Task 3','2022-01-16 18:54:35',NULL,29.99),(12,10,11,'Task 4\r\n ','2022-01-16 18:55:15',NULL,NULL),(13,13,16,'Task 1','2022-01-21 17:18:26',NULL,NULL),(14,13,16,'Task 2','2022-01-21 17:18:26',NULL,NULL),(17,3,NULL,'Task 2<br>','2022-01-23 22:40:11','2022-01-23 22:40:37',NULL),(18,3,NULL,'Task 1','2022-01-23 22:46:02','2022-01-23 22:48:53',NULL),(19,3,17,'Task 2','2022-01-23 23:41:30','2022-01-23 23:42:18',NULL),(20,3,17,'Task 2','2022-01-23 23:44:29','2022-01-23 23:44:30',NULL),(21,3,17,'Task 1','2022-01-23 23:45:33','2022-01-23 23:45:40',NULL),(22,3,17,'124','2022-01-23 23:48:12','2022-01-23 23:49:29',NULL),(23,3,18,'asdas','2022-01-24 08:32:49','2022-01-24 08:52:14',NULL),(24,3,18,'asdasdasdasd','2022-01-24 08:52:29','2022-01-24 08:52:39',NULL),(26,3,17,'asdasd','2022-01-24 10:38:09','2022-01-24 10:38:15',NULL),(27,3,17,'task 1','2022-01-24 11:12:22','2022-01-24 11:12:58',NULL),(28,10,11,'TEST_28_01_2022_15_37','2022-01-28 15:40:22',NULL,23.24),(29,10,11,'TEST_28_01_2022_15_37','2022-01-28 15:41:06',NULL,23.24);
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1483A5E9AA08CB10` (`login`),
  UNIQUE KEY `UNIQ_1483A5E9E7927C74` (`email`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'anowak2','12345','anowak2@onet.pl',0),(2,'test_user_1','1234','test_user_1@gamil.com',0),(3,'test_1234','1234','abc@gmail.com',0),(4,'test-4321','4321','test_4321@gmail.com',0),(6,'123','123','123',0),(10,'ppgorka','gp46518','gp46518@zut.edu.pl',1),(11,'wfirlag','fw46508','fw46508@zut.edu.pl',1),(12,'dfigas','fd46507','fd46507@zut.edu.pl',1),(13,'zstasiak','sz46650','sz46650@zut.edu.pl',1),(27,'abndasiubdasiudbasiu','123','abndasiubdasiudbasiu@gmail.com',0),(28,'saefedaf','123','saefedaf@gmail.com',0),(29,'test_09012022,','124','124@gmail.com',0),(33,'test_21412412','000','123123@gmail.com',0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-28 21:20:26
