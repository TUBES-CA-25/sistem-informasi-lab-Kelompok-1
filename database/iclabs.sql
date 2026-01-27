-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: iclabs
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `app_settings`
--

DROP TABLE IF EXISTS `app_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_settings` (
  `setting_key` varchar(50) NOT NULL,
  `setting_value` text DEFAULT NULL,
  PRIMARY KEY (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_settings`
--

LOCK TABLES `app_settings` WRITE;
/*!40000 ALTER TABLE `app_settings` DISABLE KEYS */;
INSERT INTO `app_settings` VALUES ('job_putra','Angkat Galon, Buang Sampah, Beli Lauk'),('job_putri','Membersihkan Area Lab, Memasak, Cuci Piring');
/*!40000 ALTER TABLE `app_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assistant_schedules`
--

DROP TABLE IF EXISTS `assistant_schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assistant_schedules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `group_type` enum('putra','putri') NOT NULL DEFAULT 'putra',
  `day` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `job_role` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `assistant_schedules_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assistant_schedules`
--

LOCK TABLES `assistant_schedules` WRITE;
/*!40000 ALTER TABLE `assistant_schedules` DISABLE KEYS */;
INSERT INTO `assistant_schedules` VALUES (26,10,'putra','Wednesday','Putra'),(27,3,'putra','Tuesday','Putra'),(28,4,'putra','Monday','Putra'),(29,4,'putra','Tuesday','Putra'),(30,4,'putra','Wednesday','Putri');
/*!40000 ALTER TABLE `assistant_schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_plans`
--

DROP TABLE IF EXISTS `course_plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_plans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `laboratory_id` int(11) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `program_study` varchar(100) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `class_code` varchar(20) DEFAULT NULL,
  `lecturer_name` varchar(100) NOT NULL,
  `lecturer_photo` varchar(255) DEFAULT NULL,
  `assistant_1_name` varchar(100) DEFAULT NULL,
  `assistant_1_photo` varchar(255) DEFAULT NULL,
  `assistant_2_name` varchar(100) DEFAULT NULL,
  `assistant_2_photo` varchar(255) DEFAULT NULL,
  `day` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `total_meetings` int(11) DEFAULT 14,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `laboratory_id` (`laboratory_id`),
  CONSTRAINT `course_plans_ibfk_1` FOREIGN KEY (`laboratory_id`) REFERENCES `laboratories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_plans`
--

LOCK TABLES `course_plans` WRITE;
/*!40000 ALTER TABLE `course_plans` DISABLE KEYS */;
INSERT INTO `course_plans` VALUES (2,14,'ALGORITMA PEMROGRAMAN','TEKNIK INFORMATIKA',4,'A1','WINDA','http://localhost/iclabs/public/uploads/lecturers/69703714563f4_1768961812.jpg','FRANCO','http://localhost/iclabs/public/uploads/assistants/6970371456c81_1768961812.jpg','BASUDARA','http://localhost/iclabs/public/uploads/assistants/6970371457440_1768961812.jpg','Wednesday','10:20:00','00:00:00',5,'BAPAK','2026-01-21 02:16:52'),(3,15,'Alpro bapak','ti',1,'b1','uceng','http://localhost/iclabs/public/uploads/lecturers/6970503a0e8f7_1768968250.jpg','basudara','http://localhost/iclabs/public/uploads/assistants/6970503a1027f_1768968250.jpg','windah','http://localhost/iclabs/public/uploads/assistants/6970503a10ef9_1768968250.jpg','Thursday','09:40:00','12:10:00',6,'bapak','2026-01-21 04:04:10'),(4,13,'Machine Learning','Teknik Informatika',8,'A6','Ir. Huzain Azis, S.Kom., M.Cs., MTA.',NULL,'Ahmad Mufly Ramadhan','http://localhost/iclabs/public/uploads/assistants/6973e53ebb47d_1769203006.png','Nahwa Kaka Saputra Anggareksa','http://localhost/iclabs/public/uploads/assistants/6973e53ebcf86_1769203006.png','Saturday','07:00:00','09:40:00',10,'Melajar Untuk mengolah data, dalam kalsifikasi data sederhana','2026-01-23 21:16:46');
/*!40000 ALTER TABLE `course_plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `head_laboran`
--

DROP TABLE IF EXISTS `head_laboran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `head_laboran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `position` varchar(100) DEFAULT 'Laboran',
  `photo` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `location` varchar(100) DEFAULT NULL,
  `return_time` datetime DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `time_in` time DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `head_laboran_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `head_laboran`
--

LOCK TABLES `head_laboran` WRITE;
/*!40000 ALTER TABLE `head_laboran` DISABLE KEYS */;
INSERT INTO `head_laboran` VALUES (1,2,NULL,'Kepala Lab Komputer Dasar','','active','Lab Komputer 1',NULL,'Standby di ruangan A201','08:00:00','2026-01-16 03:50:50'),(2,6,NULL,'Kepala Lab Multimedia',NULL,'inactive','Luar Kota','2026-01-05 08:00:00','Sedang Dinas Luar di Jakarta',NULL,'2026-01-16 03:50:50'),(3,7,NULL,'Kepala Lab Jaringan',NULL,'active','Lab Jaringan B1',NULL,'Siap melayani konsultasi','07:30:00','2026-01-16 03:50:50'),(4,8,NULL,'Staff Laboran',NULL,'active','Ruang Server',NULL,'Maintenance Server Rutin','08:00:00','2026-01-16 03:50:50');
/*!40000 ALTER TABLE `head_laboran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_presets`
--

DROP TABLE IF EXISTS `job_presets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_presets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` enum('Putra','Putri') NOT NULL,
  `task_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_presets`
--

LOCK TABLES `job_presets` WRITE;
/*!40000 ALTER TABLE `job_presets` DISABLE KEYS */;
INSERT INTO `job_presets` VALUES (1,'Putri','Membersihkan Area Lab'),(2,'Putri','Memasak Nasi & Lauk'),(3,'Putri','Mencuci Piring & Gelas'),(4,'Putra','Membuang Sampah'),(5,'Putra','Membeli Lauk Pauk'),(6,'Putra','Mengangkat Galon Air'),(7,'Putra','Membeli Lauk Pauk, Membuang Sampah, Mengangkat Galon Air'),(8,'Putra','Membeli Lauk Pauk, Membeli Lauk Pauk, Membuang Sampah, Mengangkat Galon Air, Membuang Sampah, Mengangkat Galon Air');
/*!40000 ALTER TABLE `job_presets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lab_activities`
--

DROP TABLE IF EXISTS `lab_activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lab_activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `image_cover` varchar(255) DEFAULT NULL,
  `activity_type` enum('praktikum','workshop','seminar','maintenance','other') NOT NULL,
  `activity_date` date NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `status` enum('draft','published','cancelled') DEFAULT 'draft',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `idx_lab_activities_date` (`activity_date`),
  CONSTRAINT `lab_activities_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab_activities`
--

LOCK TABLES `lab_activities` WRITE;
/*!40000 ALTER TABLE `lab_activities` DISABLE KEYS */;
INSERT INTO `lab_activities` VALUES (1,'Workshop Python Programming','/uploads/activities/activity_6978549d293a5.png','workshop','2025-01-15','Lab Komputer 1','Workshop pemrograman Python untuk pemula','','published',1,'2026-01-16 03:50:50'),(2,'Maintenance Rutin Lab','https://placehold.co/600x400/10b981/FFF?text=Maintenance','maintenance','2025-01-10','Semua Lab','Maintenance dan pembersihan rutin semua laboratorium',NULL,'published',1,'2026-01-16 03:50:50'),(3,'Seminar Keamanan Siber','/uploads/activities/activity_69788f41f3f4f.png','seminar','2025-01-20','Lab Jaringan','Seminar tentang keamanan siber dan ethical hacking','https://komikindo.ch/','published',1,'2026-01-16 03:50:50'),(4,'Praktikum Database Lanjut','https://placehold.co/600x400/ef4444/FFF?text=Database','praktikum','2025-01-08','Lab Komputer 2','Praktikum database management sistem lanjutan',NULL,'published',1,'2026-01-16 03:50:50');
/*!40000 ALTER TABLE `lab_activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lab_photos`
--

DROP TABLE IF EXISTS `lab_photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lab_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `laboratory_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `laboratory_id` (`laboratory_id`),
  CONSTRAINT `lab_photos_ibfk_1` FOREIGN KEY (`laboratory_id`) REFERENCES `laboratories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab_photos`
--

LOCK TABLES `lab_photos` WRITE;
/*!40000 ALTER TABLE `lab_photos` DISABLE KEYS */;
/*!40000 ALTER TABLE `lab_photos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lab_problems`
--

DROP TABLE IF EXISTS `lab_problems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lab_problems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `laboratory_id` int(11) NOT NULL,
  `pc_number` varchar(50) DEFAULT NULL,
  `problem_type` enum('hardware','software','network','other') NOT NULL,
  `description` text NOT NULL,
  `status` enum('reported','in_progress','resolved') DEFAULT 'reported',
  `reported_by` int(11) NOT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `reported_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `started_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reported_by` (`reported_by`),
  KEY `idx_lab_problems_status` (`status`),
  KEY `idx_lab_problems_lab` (`laboratory_id`),
  KEY `fk_lab_problems_assigned` (`assigned_to`),
  CONSTRAINT `fk_lab_problems_assigned` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `lab_problems_ibfk_1` FOREIGN KEY (`laboratory_id`) REFERENCES `laboratories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `lab_problems_ibfk_2` FOREIGN KEY (`reported_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab_problems`
--

LOCK TABLES `lab_problems` WRITE;
/*!40000 ALTER TABLE `lab_problems` DISABLE KEYS */;
INSERT INTO `lab_problems` VALUES (5,15,'02','hardware','meledak pcnya','in_progress',2,3,'2026-01-27 09:36:59','2026-01-27 17:58:09','2026-01-27 17:57:48'),(6,13,'05','software','MELEKADJJJ LAGI','resolved',2,3,'2026-01-27 09:38:54',NULL,'2026-01-27 17:46:15'),(7,15,'01','network','jaringan jelekkk','reported',3,NULL,'2026-01-27 09:46:47',NULL,NULL),(8,15,'01','hardware','MELEDAKK PCNYA','reported',3,4,'2026-01-27 09:58:58',NULL,NULL);
/*!40000 ALTER TABLE `lab_problems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lab_schedules_old`
--

DROP TABLE IF EXISTS `lab_schedules_old`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lab_schedules_old` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `laboratory_id` int(11) NOT NULL,
  `day` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `course` varchar(100) NOT NULL,
  `program_study` varchar(100) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `class_code` varchar(20) DEFAULT NULL,
  `frequency` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `lecturer` varchar(100) DEFAULT NULL,
  `lecturer_photo` varchar(255) DEFAULT NULL,
  `assistant` varchar(100) DEFAULT NULL,
  `assistant_photo` varchar(255) DEFAULT NULL,
  `assistant_2` varchar(100) DEFAULT NULL,
  `assistant2_photo` varchar(255) DEFAULT NULL,
  `participant_count` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `laboratory_id` (`laboratory_id`),
  KEY `idx_lab_schedules_day` (`day`),
  CONSTRAINT `lab_schedules_old_ibfk_1` FOREIGN KEY (`laboratory_id`) REFERENCES `laboratories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab_schedules_old`
--

LOCK TABLES `lab_schedules_old` WRITE;
/*!40000 ALTER TABLE `lab_schedules_old` DISABLE KEYS */;
/*!40000 ALTER TABLE `lab_schedules_old` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `laboratories`
--

DROP TABLE IF EXISTS `laboratories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `laboratories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lab_name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `pc_count` int(11) DEFAULT 0,
  `tv_count` int(11) DEFAULT 0,
  `capacity` int(11) DEFAULT 0,
  `status` enum('active','maintenance','inactive') DEFAULT 'active',
  `location` varchar(100) DEFAULT NULL,
  `building` varchar(50) DEFAULT NULL,
  `floor` varchar(10) DEFAULT NULL,
  `room_number` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `laboratories`
--

LOCK TABLES `laboratories` WRITE;
/*!40000 ALTER TABLE `laboratories` DISABLE KEYS */;
INSERT INTO `laboratories` VALUES (13,'Multimedia','http://localhost/iclabs/public/uploads/laboratories/69701d042bdf2_1768955140.jpg','...',26,1,25,'active','2nd Floor','afag','',''),(14,'DS','http://localhost/iclabs/public/uploads/laboratories/6970369fe20b6_1768961695.jpg','BAPAK',26,1,0,'active','FIKOM LT2',NULL,NULL,NULL),(15,'IoT','http://localhost/iclabs/public/uploads/laboratories/69704fb108e98_1768968113.jpg','bapak',26,2,0,'active','2nd floor',NULL,NULL,NULL),(18,'da[ddava',NULL,'.dsmfaldLL',213,0,23,'active','','','','');
/*!40000 ALTER TABLE `laboratories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `problem_histories`
--

DROP TABLE IF EXISTS `problem_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `problem_histories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `problem_id` int(11) NOT NULL,
  `status` enum('reported','in_progress','resolved') NOT NULL,
  `note` text DEFAULT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `problem_id` (`problem_id`),
  KEY `updated_by` (`updated_by`),
  CONSTRAINT `problem_histories_ibfk_1` FOREIGN KEY (`problem_id`) REFERENCES `lab_problems` (`id`) ON DELETE CASCADE,
  CONSTRAINT `problem_histories_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `problem_histories`
--

LOCK TABLES `problem_histories` WRITE;
/*!40000 ALTER TABLE `problem_histories` DISABLE KEYS */;
INSERT INTO `problem_histories` VALUES (14,5,'reported','Laporan dibuat oleh Koordinator',2,'2026-01-27 09:36:59'),(15,5,'reported','Ditugaskan kepada: Asisten 2',2,'2026-01-27 09:37:31'),(16,6,'reported','Laporan dibuat oleh Koordinator',2,'2026-01-27 09:38:54'),(17,6,'reported','Problem updated by Koordinator',2,'2026-01-27 09:38:58'),(18,6,'reported','Ditugaskan kepada: Asisten 1',2,'2026-01-27 09:39:01'),(19,6,'resolved','Update Jobdesk: sudah melakukan perbaikan pada komponen',3,'2026-01-27 09:46:01'),(20,6,'reported','Status updated by assignee',3,'2026-01-27 09:46:08'),(21,6,'resolved','Update Jobdesk: done',3,'2026-01-27 09:46:15'),(22,7,'reported','Laporan baru dibuat oleh Asisten',3,'2026-01-27 09:46:47'),(23,5,'reported','Ditugaskan kepada: Asisten 1',2,'2026-01-27 09:51:16'),(24,5,'resolved','Update Jobdesk: SUDAH fixx',3,'2026-01-27 09:57:48'),(25,5,'in_progress','Update Jobdesk: masih maintannce',3,'2026-01-27 09:58:09'),(26,8,'reported','Laporan baru dibuat oleh Asisten',3,'2026-01-27 09:58:58'),(27,8,'reported','Ditugaskan kepada: MUHAMMAD RIFKY SAPUTRA SCANIA',2,'2026-01-27 09:59:41'),(28,8,'reported','Ditugaskan kepada: Asisten 2',2,'2026-01-27 09:59:55');
/*!40000 ALTER TABLE `problem_histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_name` (`role_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','2026-01-16 03:50:50'),(2,'koordinator','2026-01-16 03:50:50'),(3,'asisten','2026-01-16 03:50:50');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedule_sessions`
--

DROP TABLE IF EXISTS `schedule_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_plan_id` int(11) NOT NULL,
  `meeting_number` int(11) NOT NULL,
  `session_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `topic` varchar(255) DEFAULT NULL,
  `status` enum('scheduled','ongoing','completed','cancelled','rescheduled') DEFAULT 'scheduled',
  `is_replacement` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `course_plan_id` (`course_plan_id`),
  KEY `idx_session_date` (`session_date`),
  KEY `idx_session_time` (`start_time`,`end_time`),
  CONSTRAINT `schedule_sessions_ibfk_1` FOREIGN KEY (`course_plan_id`) REFERENCES `course_plans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedule_sessions`
--

LOCK TABLES `schedule_sessions` WRITE;
/*!40000 ALTER TABLE `schedule_sessions` DISABLE KEYS */;
INSERT INTO `schedule_sessions` VALUES (3,2,1,'2026-01-21','10:20:00','00:00:00',NULL,'scheduled',0),(4,2,2,'2026-01-28','10:20:00','00:00:00',NULL,'scheduled',0),(5,2,3,'2026-02-04','10:20:00','00:00:00',NULL,'scheduled',0),(6,2,4,'2026-02-11','10:20:00','00:00:00',NULL,'scheduled',0),(7,2,5,'2026-02-18','10:20:00','00:00:00',NULL,'scheduled',0),(8,3,1,'2026-01-22','09:40:00','12:10:00',NULL,'scheduled',0),(9,3,2,'2026-01-29','09:40:00','12:10:00',NULL,'scheduled',0),(10,3,3,'2026-02-05','09:40:00','12:10:00',NULL,'scheduled',0),(11,3,4,'2026-02-12','09:40:00','12:10:00',NULL,'scheduled',0),(12,3,5,'2026-02-19','09:40:00','12:10:00',NULL,'scheduled',0),(13,3,6,'2026-02-26','09:40:00','12:10:00',NULL,'scheduled',0),(14,4,1,'2026-01-24','07:00:00','09:40:00',NULL,'scheduled',0),(15,4,2,'2026-01-31','07:00:00','09:40:00',NULL,'scheduled',0),(16,4,3,'2026-02-07','07:00:00','09:40:00',NULL,'scheduled',0),(17,4,4,'2026-02-14','07:00:00','09:40:00',NULL,'scheduled',0),(18,4,5,'2026-02-21','07:00:00','09:40:00',NULL,'scheduled',0),(19,4,6,'2026-02-28','07:00:00','09:40:00',NULL,'scheduled',0),(20,4,7,'2026-03-07','07:00:00','09:40:00',NULL,'scheduled',0),(21,4,8,'2026-03-14','07:00:00','09:40:00',NULL,'scheduled',0),(22,4,9,'2026-03-21','07:00:00','09:40:00',NULL,'scheduled',0),(23,4,10,'2026-03-28','07:00:00','09:40:00',NULL,'scheduled',0);
/*!40000 ALTER TABLE `schedule_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_users_email` (`email`),
  KEY `idx_users_role` (`role_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin User','admin@iclabs.com','6281234567890','$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u',1,'active','2026-01-16 03:50:50'),(2,'Koordinator Lab','koordinator@iclabs.com','6281234567890','$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u',2,'active','2026-01-16 03:50:50'),(3,'Asisten 1','asisten1@iclabs.com',NULL,'$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u',3,'active','2026-01-16 03:50:50'),(4,'Asisten 2','asisten2@iclabs.com',NULL,'$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u',3,'active','2026-01-16 03:50:50'),(5,'Asisten 3','asisten3@iclabs.com',NULL,'$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u',3,'active','2026-01-16 03:50:50'),(6,'Budi (KaLab Multimedia)','kalab2@iclabs.com','6281234567890','$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u',2,'active','2026-01-16 03:50:50'),(7,'Siti (KaLab Jaringan)','kalab3@iclabs.com','6281234567890','$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u',2,'active','2026-01-16 03:50:50'),(8,'Joko (Laboran Teknis)','laboran@iclabs.com','6281234567890','$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u',2,'active','2026-01-16 03:50:50'),(10,'MUHAMMAD RIFKY SAPUTRA SCANIA','rifky020504@gmail.com',NULL,'$2y$10$hQcLcLfg2enXMREWGBzFzuIks8GpW/iqoru5Bu3tFx00./SjqT84S',3,'active','2026-01-19 19:48:31');
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

-- Dump completed on 2026-01-27 18:26:51
