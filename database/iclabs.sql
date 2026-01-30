-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2026 at 10:41 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iclabs`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_settings`
--

CREATE TABLE `app_settings` (
  `setting_key` varchar(50) NOT NULL,
  `setting_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `app_settings`
--

INSERT INTO `app_settings` (`setting_key`, `setting_value`) VALUES
('job_putra', 'Angkat Galon, Buang Sampah, Beli Lauk'),
('job_putri', 'Membersihkan Area Lab, Memasak, Cuci Piring');

-- --------------------------------------------------------

--
-- Table structure for table `assistant_schedules`
--

CREATE TABLE `assistant_schedules` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_type` enum('putra','putri') NOT NULL DEFAULT 'putra',
  `day` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `job_role` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `assistant_schedules_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assistant_schedules`
--

LOCK TABLES `assistant_schedules` WRITE;
/*!40000 ALTER TABLE `assistant_schedules` DISABLE KEYS */;
INSERT INTO `assistant_schedules` VALUES (26,10,'putra','Wednesday','Putra'),(27,3,'putra','Tuesday','Putra'),(28,4,'putra','Monday','Putra'),(29,4,'putra','Tuesday','Putra'),(30,4,'putra','Wednesday','Putra'),(31,3,'putri','Thursday','Angkat kursi'),(32,5,'putra','Sunday','Putra'),(33,3,'putra','Tuesday','Putra'),(34,4,'putra','Tuesday','Putra'),(35,5,'putra','Thursday','Putra'),(36,4,'putra','Tuesday','Putra');
/*!40000 ALTER TABLE `assistant_schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_plans`
--

CREATE TABLE `course_plans` (
  `id` int(11) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_plans`
--

LOCK TABLES `course_plans` WRITE;
/*!40000 ALTER TABLE `course_plans` DISABLE KEYS */;
INSERT INTO `course_plans` VALUES (2,14,'ALGORITMA PEMROGRAMAN','TEKNIK INFORMATIKA',4,'A1','WINDA','http://localhost/iclabs/public/uploads/lecturers/69703714563f4_1768961812.jpg','FRANCO','http://localhost/iclabs/public/uploads/assistants/6970371456c81_1768961812.jpg','BASUDARA','http://localhost/iclabs/public/uploads/assistants/6970371457440_1768961812.jpg','Wednesday','10:20:00','00:00:00',5,'BAPAK','2026-01-21 02:16:52'),(3,15,'Alpro bapak','ti',1,'b1','uceng','http://localhost/iclabs/public/uploads/lecturers/6970503a0e8f7_1768968250.jpg','basudara','http://localhost/iclabs/public/uploads/assistants/6970503a1027f_1768968250.jpg','windah','http://localhost/iclabs/public/uploads/assistants/6970503a10ef9_1768968250.jpg','Thursday','09:40:00','12:10:00',6,'bapak','2026-01-21 04:04:10'),(4,13,'Machine Learning','Teknik Informatika',8,'A6','Ir. Huzain Azis, S.Kom., M.Cs., MTA.',NULL,'Ahmad Mufly Ramadhan','http://localhost/iclabs/public/uploads/assistants/6973e53ebb47d_1769203006.png','Nahwa Kaka Saputra Anggareksa','http://localhost/iclabs/public/uploads/assistants/6973e53ebcf86_1769203006.png','Saturday','07:00:00','09:40:00',10,'Melajar Untuk mengolah data, dalam kalsifikasi data sederhana','2026-01-23 21:16:46'),(5,14,'IOT','Tekni',12,'fla','dapok[vaf',NULL,'dafa',NULL,'faklfk',NULL,'Friday','09:54:00','02:02:00',14,'lkfkwmf','2026-01-29 01:52:42');
/*!40000 ALTER TABLE `course_plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `head_laboran`
--

CREATE TABLE `head_laboran` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `position` varchar(100) DEFAULT 'Laboran',
  `category` enum('head','staff') DEFAULT 'staff',
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `head_laboran`
--

LOCK TABLES `head_laboran` WRITE;
/*!40000 ALTER TABLE `head_laboran` DISABLE KEYS */;
INSERT INTO `head_laboran` VALUES (1,2,NULL,'Kepala Lab Komputer Dasar','staff','','active','Lab Komputer 1',NULL,'Standby di ruangan A201','08:00:00','2026-01-16 03:50:50'),(2,6,NULL,'Kepala Lab Multimedia','staff',NULL,'inactive','Luar Kota','2026-01-05 08:00:00','Sedang Dinas Luar di Jakarta',NULL,'2026-01-16 03:50:50'),(3,7,NULL,'Kepala Lab Jaringan','staff',NULL,'active','Lab Jaringan B1',NULL,'Siap melayani konsultasi','07:30:00','2026-01-16 03:50:50'),(4,8,NULL,'Staff Laboran','staff',NULL,'active','Ruang Server',NULL,'Maintenance Server Rutin','08:00:00','2026-01-16 03:50:50'),(5,1,'82258198784','Kepala lab 1','head',NULL,'active','da','0000-00-00 00:00:00','daopalf[a;dla','23:12:00','2026-01-29 02:58:05');
/*!40000 ALTER TABLE `head_laboran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_presets`
--

CREATE TABLE `job_presets` (
  `id` int(11) NOT NULL,
  `category` enum('Putra','Putri') NOT NULL,
  `task_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_presets`
--

INSERT INTO `job_presets` (`id`, `category`, `task_name`) VALUES
(1, 'Putri', 'Membersihkan Area Lab'),
(2, 'Putri', 'Memasak Nasi & Lauk'),
(3, 'Putri', 'Mencuci Piring & Gelas'),
(4, 'Putra', 'Membuang Sampah'),
(5, 'Putra', 'Membeli Lauk Pauk'),
(6, 'Putra', 'Mengangkat Galon Air'),
(7, 'Putra', 'Membeli Lauk Pauk, Membuang Sampah, Mengangkat Galon Air'),
(8, 'Putra', 'Membeli Lauk Pauk, Membeli Lauk Pauk, Membuang Sampah, Mengangkat Galon Air, Membuang Sampah, Mengangkat Galon Air');

-- --------------------------------------------------------

--
-- Table structure for table `laboratories`
--

CREATE TABLE `laboratories` (
  `id` int(11) NOT NULL,
  `lab_name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `pc_count` int(11) DEFAULT 0,
  `tv_count` int(11) DEFAULT 0,
  `location` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laboratories`
--

INSERT INTO `laboratories` (`id`, `lab_name`, `image`, `description`, `pc_count`, `tv_count`, `location`) VALUES
(13, 'Multimedia', 'http://localhost/iclabs/public/uploads/laboratories/69701d042bdf2_1768955140.jpg', '...', 24, 1, '2nd Floor'),
(14, 'DS', 'http://localhost/iclabs/public/uploads/laboratories/6970369fe20b6_1768961695.jpg', 'BAPAK', 26, 1, 'FIKOM LT2'),
(15, 'IoT', 'http://localhost/iclabs/public/uploads/laboratories/69704fb108e98_1768968113.jpg', 'bapak', 26, 2, '2nd floor'),
(16, 'Komputer Network', 'http://localhost/iclabs/public/uploads/laboratories/69741cd30283d_1769217235.png', '...', 14, 1, '2nd Floor Fikom');

-- --------------------------------------------------------

--
-- Table structure for table `lab_activities`
--

CREATE TABLE `lab_activities` (
  `id` int(11) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab_activities`
--

LOCK TABLES `lab_activities` WRITE;
/*!40000 ALTER TABLE `lab_activities` DISABLE KEYS */;
INSERT INTO `lab_activities` VALUES (3,'Seminar Keamanan Siber','/uploads/activities/activity_69788f41f3f4f.png','seminar','2025-01-20','Lab Jaringa','Seminar tentang keamanan siber dan ethical hacking','https://komikindo.ch/','published',1,'2026-01-16 03:50:50'),(6,'dakmkmafa','http://localhost/iclabs/public/uploads/activities/697ac118755c2_1769652504.png','','2005-01-25',NULL,'singkat kali','https://www.bing.com/search?pglt=299&q=john+fitzpatrick+dan+timnya+dari+stochholm+university+serta+manchester+university+NHS+foundation+Trust+tentang+sperm&cvid=1142110f38ca41349bdf78615713feed&gs_lcrp=EgRlZGdlKgYIABBFGDkyBggAEEUYOTIHCAEQ6wcYQNIBCTU2ODA4a','published',1,'2026-01-29 02:08:24');
/*!40000 ALTER TABLE `lab_activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lab_photos`
--

CREATE TABLE `lab_photos` (
  `id` int(11) NOT NULL,
  `laboratory_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lab_problems`
--

CREATE TABLE `lab_problems` (
  `id` int(11) NOT NULL,
  `laboratory_id` int(11) NOT NULL,
  `pc_number` varchar(50) DEFAULT NULL,
  `problem_type` enum('hardware','software','network','other') NOT NULL,
  `description` text NOT NULL,
  `reporter_name` varchar(100) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab_problems`
--

LOCK TABLES `lab_problems` WRITE;
/*!40000 ALTER TABLE `lab_problems` DISABLE KEYS */;
INSERT INTO `lab_problems` VALUES (9,15,'01','network','MELEKDAA lagi','resolved',2,10,'2026-01-28 11:50:22',NULL,NULL),(12,14,'04','network','dapokfoafa','reported',3,3,'2026-01-29 01:08:18',NULL,NULL),(13,15,'25','hardware','apfkalfa','reported',3,4,'2026-01-29 01:22:30',NULL,NULL);
/*!40000 ALTER TABLE `lab_problems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lab_schedules_old`
--

CREATE TABLE `lab_schedules_old` (
  `id` int(11) NOT NULL,
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
INSERT INTO `laboratories` VALUES (13,'Multimedia','http://localhost/iclabs/public/uploads/laboratories/69701d042bdf2_1768955140.jpg','...',22,1,25,'active','2nd Floor','ald;adad','',''),(14,'DS','http://localhost/iclabs/public/uploads/laboratories/6970369fe20b6_1768961695.jpg','akjdlaa&#039;fa',26,1,0,'active','FIKOM LT2','','',''),(15,'IoT','http://localhost/iclabs/public/uploads/laboratories/69704fb108e98_1768968113.jpg','bapak',26,2,0,'active','2nd floor',NULL,NULL,NULL),(18,'da[ddava',NULL,'.dsmfaldLL',213,0,23,'active','','','','');
/*!40000 ALTER TABLE `laboratories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `problem_histories`
--

CREATE TABLE `problem_histories` (
  `id` int(11) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `problem_histories`
--

LOCK TABLES `problem_histories` WRITE;
/*!40000 ALTER TABLE `problem_histories` DISABLE KEYS */;
INSERT INTO `problem_histories` VALUES (30,9,'reported','Laporan dibuat oleh Koordinator',2,'2026-01-28 11:50:22'),(33,12,'reported','Laporan baru dibuat oleh Asisten',3,'2026-01-29 01:08:18'),(34,13,'reported','Laporan baru dibuat oleh Asisten',3,'2026-01-29 01:22:30'),(35,13,'reported','Problem updated by Koordinator',2,'2026-01-29 02:32:56'),(36,13,'reported','',2,'2026-01-29 02:33:04'),(37,13,'reported','Ditugaskan kepada: Asisten 2',2,'2026-01-29 02:33:13'),(38,12,'reported','Ditugaskan kepada: Asisten 1',2,'2026-01-29 02:33:28'),(39,9,'reported','Ditugaskan kepada: MUHAMMAD RIFKY SAPUTRA SCANIA',2,'2026-01-29 02:33:40'),(40,9,'resolved','',2,'2026-01-29 02:33:46');
/*!40000 ALTER TABLE `problem_histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `created_at`) VALUES
(1, 'admin', '2026-01-16 03:50:50'),
(2, 'koordinator', '2026-01-16 03:50:50'),
(3, 'asisten', '2026-01-16 03:50:50');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_sessions`
--

CREATE TABLE `schedule_sessions` (
  `id` int(11) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedule_sessions`
--

LOCK TABLES `schedule_sessions` WRITE;
/*!40000 ALTER TABLE `schedule_sessions` DISABLE KEYS */;
INSERT INTO `schedule_sessions` VALUES (3,2,1,'2026-01-21','10:20:00','00:00:00',NULL,'scheduled',0),(4,2,2,'2026-01-28','10:20:00','00:00:00',NULL,'scheduled',0),(5,2,3,'2026-02-04','10:20:00','00:00:00',NULL,'scheduled',0),(6,2,4,'2026-02-11','10:20:00','00:00:00',NULL,'scheduled',0),(7,2,5,'2026-02-18','10:20:00','00:00:00',NULL,'scheduled',0),(8,3,1,'2026-01-22','09:40:00','12:10:00',NULL,'scheduled',0),(9,3,2,'2026-01-29','09:40:00','12:10:00',NULL,'scheduled',0),(10,3,3,'2026-02-05','09:40:00','12:10:00',NULL,'scheduled',0),(11,3,4,'2026-02-12','09:40:00','12:10:00',NULL,'scheduled',0),(12,3,5,'2026-02-19','09:40:00','12:10:00',NULL,'scheduled',0),(13,3,6,'2026-02-26','09:40:00','12:10:00',NULL,'scheduled',0),(14,4,1,'2026-01-24','07:00:00','09:40:00',NULL,'scheduled',0),(15,4,2,'2026-01-31','07:00:00','09:40:00',NULL,'scheduled',0),(16,4,3,'2026-02-07','07:00:00','09:40:00',NULL,'scheduled',0),(17,4,4,'2026-02-14','07:00:00','09:40:00',NULL,'scheduled',0),(18,4,5,'2026-02-21','07:00:00','09:40:00',NULL,'scheduled',0),(19,4,6,'2026-02-28','07:00:00','09:40:00',NULL,'scheduled',0),(20,4,7,'2026-03-07','07:00:00','09:40:00',NULL,'scheduled',0),(21,4,8,'2026-03-14','07:00:00','09:40:00',NULL,'scheduled',0),(22,4,9,'2026-03-21','07:00:00','09:40:00',NULL,'scheduled',0),(23,4,10,'2026-03-28','07:00:00','09:40:00',NULL,'scheduled',0),(24,5,1,'2003-01-24','09:54:00','02:02:00',NULL,'scheduled',0),(25,5,2,'2003-01-31','09:54:00','02:02:00',NULL,'scheduled',0),(26,5,3,'2003-02-07','09:54:00','02:02:00',NULL,'scheduled',0),(27,5,4,'2003-02-14','09:54:00','02:02:00',NULL,'scheduled',0),(28,5,5,'2003-02-21','09:54:00','02:02:00',NULL,'scheduled',0),(29,5,6,'2003-02-28','09:54:00','02:02:00',NULL,'scheduled',0),(30,5,7,'2003-03-07','09:54:00','02:02:00',NULL,'scheduled',0),(31,5,8,'2003-03-14','09:54:00','02:02:00',NULL,'scheduled',0),(32,5,9,'2003-03-21','09:54:00','02:02:00',NULL,'scheduled',0),(33,5,10,'2003-03-28','09:54:00','02:02:00',NULL,'scheduled',0),(34,5,11,'2003-04-04','09:54:00','02:02:00',NULL,'scheduled',0),(35,5,12,'2003-04-11','09:54:00','02:02:00',NULL,'scheduled',0),(36,5,13,'2003-04-18','09:54:00','02:02:00',NULL,'scheduled',0),(37,5,14,'2003-04-25','09:54:00','02:02:00',NULL,'scheduled',0);
/*!40000 ALTER TABLE `schedule_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `role_id`, `status`, `created_at`) VALUES
(1, 'Admin User', 'admin@iclabs.com', '6281234567890', '$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u', 1, 'active', '2026-01-16 03:50:50'),
(2, 'Koordinator Lab', 'koordinator@iclabs.com', '6281234567890', '$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u', 2, 'active', '2026-01-16 03:50:50'),
(3, 'Asisten 1', 'asisten1@iclabs.com', NULL, '$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u', 3, 'active', '2026-01-16 03:50:50'),
(4, 'Asisten 2', 'asisten2@iclabs.com', NULL, '$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u', 3, 'active', '2026-01-16 03:50:50'),
(5, 'Asisten 3', 'asisten3@iclabs.com', NULL, '$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u', 3, 'active', '2026-01-16 03:50:50'),
(10, 'MUHAMMAD RIFKY SAPUTRA SCANIA', 'rifky020504@gmail.com', NULL, '$2y$10$hQcLcLfg2enXMREWGBzFzuIks8GpW/iqoru5Bu3tFx00./SjqT84S', 3, 'active', '2026-01-19 19:48:31'),
(11, 'Ir. Abdul Rachman Manga’, S.Kom., MT.,MTA', 'abdulrachman.manga@umi.ac.id', NULL, '$2y$10$Wxx6KApsb477HnylJ6nck..9BcsHEq1HfNEB8IUKhZZ0jsO5ZNEFi', 1, 'active', '2026-01-28 09:51:18'),
(12, 'Ir. Huzain Azis, S.Kom., M.Cs., MTA.', 'huzain.azis@umi.ac.id', NULL, '$2y$10$oeV5vrVDWeS/ugYR.3Mqvellfi.zFZjfxh0i/6f1ScsEVz6HV/iDG', 1, 'active', '2026-01-28 09:52:56'),
(13, 'Herdianti, S.Si., M.Eng., MTA.', 'herdianti.darwis@umi.ac.id', NULL, '$2y$10$EzTQyeRgBH2HxCUGksbOOOHuQxCL9Nbi.5K1toPK0ACcKkqw0OBdK', 1, 'active', '2026-01-28 09:59:05'),
(14, 'Fatimah AR. Tuasamu, S.Kom., MTA, MCF.', 'fatima.tuasamu@umi.ac.id', NULL, '$2y$10$CaybG4ErgABDMaKV42mdQ.zCagrZ8nOSEMJWHNt8iCerZaYw81tUy', 1, 'active', '2026-01-28 10:21:50'),
(15, 'Adam Adnan, S.Kom.', 'adam.adnan@umi.ac.id', NULL, '$2y$10$1MLmAPrTDle6syKYbb/eKe0W4hecEmUP4sB32Vs16jWSD2HNwqfAO', 2, 'active', '2026-01-28 10:25:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_settings`
--
ALTER TABLE `app_settings`
  ADD PRIMARY KEY (`setting_key`);

--
-- Indexes for table `assistant_schedules`
--
ALTER TABLE `assistant_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `course_plans`
--
ALTER TABLE `course_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laboratory_id` (`laboratory_id`);

--
-- Indexes for table `head_laboran`
--
ALTER TABLE `head_laboran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `job_presets`
--
ALTER TABLE `job_presets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laboratories`
--
ALTER TABLE `laboratories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lab_activities`
--
ALTER TABLE `lab_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `idx_lab_activities_date` (`activity_date`);

--
-- Indexes for table `lab_photos`
--
ALTER TABLE `lab_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laboratory_id` (`laboratory_id`);

--
-- Indexes for table `lab_problems`
--
ALTER TABLE `lab_problems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reported_by` (`reported_by`),
  ADD KEY `idx_lab_problems_status` (`status`),
  ADD KEY `idx_lab_problems_lab` (`laboratory_id`),
  ADD KEY `fk_lab_problems_assigned` (`assigned_to`);

--
-- Indexes for table `lab_schedules_old`
--
ALTER TABLE `lab_schedules_old`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laboratory_id` (`laboratory_id`),
  ADD KEY `idx_lab_schedules_day` (`day`);

--
-- Indexes for table `problem_histories`
--
ALTER TABLE `problem_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `problem_id` (`problem_id`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `schedule_sessions`
--
ALTER TABLE `schedule_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_plan_id` (`course_plan_id`),
  ADD KEY `idx_session_date` (`session_date`),
  ADD KEY `idx_session_time` (`start_time`,`end_time`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_users_email` (`email`),
  ADD KEY `idx_users_role` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assistant_schedules`
--
ALTER TABLE `assistant_schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `course_plans`
--
ALTER TABLE `course_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `head_laboran`
--
ALTER TABLE `head_laboran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `job_presets`
--
ALTER TABLE `job_presets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `laboratories`
--
ALTER TABLE `laboratories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `lab_activities`
--
ALTER TABLE `lab_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lab_photos`
--
ALTER TABLE `lab_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lab_problems`
--
ALTER TABLE `lab_problems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `lab_schedules_old`
--
ALTER TABLE `lab_schedules_old`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `problem_histories`
--
ALTER TABLE `problem_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `schedule_sessions`
--
ALTER TABLE `schedule_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assistant_schedules`
--
ALTER TABLE `assistant_schedules`
  ADD CONSTRAINT `assistant_schedules_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_plans`
--
ALTER TABLE `course_plans`
  ADD CONSTRAINT `course_plans_ibfk_1` FOREIGN KEY (`laboratory_id`) REFERENCES `laboratories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `head_laboran`
--
ALTER TABLE `head_laboran`
  ADD CONSTRAINT `head_laboran_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lab_activities`
--
ALTER TABLE `lab_activities`
  ADD CONSTRAINT `lab_activities_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lab_photos`
--
ALTER TABLE `lab_photos`
  ADD CONSTRAINT `lab_photos_ibfk_1` FOREIGN KEY (`laboratory_id`) REFERENCES `laboratories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lab_problems`
--
ALTER TABLE `lab_problems`
  ADD CONSTRAINT `fk_lab_problems_assigned` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `lab_problems_ibfk_1` FOREIGN KEY (`laboratory_id`) REFERENCES `laboratories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lab_problems_ibfk_2` FOREIGN KEY (`reported_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lab_schedules_old`
--
ALTER TABLE `lab_schedules_old`
  ADD CONSTRAINT `lab_schedules_old_ibfk_1` FOREIGN KEY (`laboratory_id`) REFERENCES `laboratories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `problem_histories`
--
ALTER TABLE `problem_histories`
  ADD CONSTRAINT `problem_histories_ibfk_1` FOREIGN KEY (`problem_id`) REFERENCES `lab_problems` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `problem_histories_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `schedule_sessions`
--
ALTER TABLE `schedule_sessions`
  ADD CONSTRAINT `schedule_sessions_ibfk_1` FOREIGN KEY (`course_plan_id`) REFERENCES `course_plans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-01-29 11:02:46
