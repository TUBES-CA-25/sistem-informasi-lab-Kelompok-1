-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: iclabs
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin User','admin@iclabs.com','$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u',1,'active','2026-01-10 05:53:16'),(2,'Koordinator Lab','koordinator@iclabs.com','$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u',2,'active','2026-01-10 05:53:16'),(3,'Asisten 1','asisten1@iclabs.com','$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u',3,'active','2026-01-10 05:53:16'),(4,'Asisten 2','asisten2@iclabs.com','$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u',3,'active','2026-01-10 05:53:16'),(5,'Asisten 3','asisten3@iclabs.com','$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u',3,'active','2026-01-10 05:53:16'),(6,'Budi (KaLab Multimedia)','kalab2@iclabs.com','$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u',2,'active','2026-01-10 05:53:16'),(7,'Siti (KaLab Jaringan)','kalab3@iclabs.com','$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u',2,'active','2026-01-10 05:53:16'),(8,'Joko (Laboran Teknis)','laboran@iclabs.com','$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u',2,'active','2026-01-10 05:53:16'),(9,'wawanmks','wawan@iclabs.com','$2y$10$ppPpJi/uCKputwj.vEetUejqPVhYEWUfnMktOtzvWVLRG4/6WdpHq',3,'active','2026-01-17 16:00:52');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-01-18 19:20:34
