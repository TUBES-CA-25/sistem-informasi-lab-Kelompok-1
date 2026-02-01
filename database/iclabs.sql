-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 01, 2026 at 05:16 AM
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
  `job_role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assistant_schedules`
--

INSERT INTO `assistant_schedules` (`id`, `user_id`, `group_type`, `day`, `job_role`) VALUES
(29, 10, 'putra', 'Monday', 'Putra');

-- --------------------------------------------------------

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
  `lecturer_id` int(11) DEFAULT NULL,
  `lecturer_photo` varchar(255) DEFAULT NULL,
  `assistant_1_name` varchar(100) DEFAULT NULL,
  `assistant_1_id` int(11) DEFAULT NULL,
  `assistant_1_photo` varchar(255) DEFAULT NULL,
  `assistant_2_name` varchar(100) DEFAULT NULL,
  `assistant_2_id` int(11) DEFAULT NULL,
  `assistant_2_photo` varchar(255) DEFAULT NULL,
  `day` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `total_meetings` int(11) DEFAULT 14,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_plans`
--

INSERT INTO `course_plans` (`id`, `laboratory_id`, `course_name`, `program_study`, `semester`, `class_code`, `lecturer_name`, `lecturer_id`, `lecturer_photo`, `assistant_1_name`, `assistant_1_id`, `assistant_1_photo`, `assistant_2_name`, `assistant_2_id`, `assistant_2_photo`, `day`, `start_time`, `end_time`, `total_meetings`, `description`, `created_at`) VALUES
(5, 13, 'Pmerograman Web', 'Teknik Informatika', 1, 'TI-A3', 'Ir. Huzain Azis, S.Kom., M.Cs., MTA.', 12, 'http://localhost/iclabs/public/uploads/profiles/file_697ecf66614ae.png', 'MUHAMMAD RIFKY SAPUTRA SCANIA', 10, 'http://localhost/iclabs/public/uploads/profiles/file_697ecf8c833cc.jpeg', 'MUHAMMAD RIFKY SAPUTRA SCANIA', 10, 'http://localhost/iclabs/public/uploads/profiles/file_697ecf8c833cc.jpeg', 'Sunday', '09:40:00', '00:10:00', 14, '', '2026-02-01 01:17:38');

-- --------------------------------------------------------

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `head_laboran`
--

INSERT INTO `head_laboran` (`id`, `user_id`, `phone`, `position`, `category`, `photo`, `status`, `location`, `return_time`, `notes`, `time_in`, `created_at`) VALUES
(5, 11, '81355196209', 'Kepala Lab 1', 'head', 'http://localhost/iclabs/public/uploads/profiles/6979dec82cc88_1769594568.png', 'active', 'Ruangan Kepala Lab 1', '0000-00-00 00:00:00', 'Silahkan di hubungi melalui What\'sApp terlebih dahulu sebelum konsultasi.', '07:30:00', '2026-01-28 10:01:31'),
(6, 12, '8114484875', 'Kepala Lab 2', 'head', 'http://localhost/iclabs/public/uploads/profiles/6979df0bb265e_1769594635.png', 'active', 'Ruangan Kepala Lab 2', '0000-00-00 00:00:00', 'Silahkan di hubungi melalui What\'sApp terlebih dahulu sebelum konsultasi.', '07:30:00', '2026-01-28 10:03:55'),
(7, 13, '81355801732', 'Kepala Lab 3', 'head', 'http://localhost/iclabs/public/uploads/profiles/6979df5b8b348_1769594715.png', 'active', 'Ruangan Riset', '0000-00-00 00:00:00', 'Silahkan di hubungi melalui What\'sApp terlebih dahulu sebelum konsultasi.', '07:30:00', '2026-01-28 10:05:15'),
(8, 14, '85341864970', 'Laboran', 'staff', 'http://localhost/iclabs/public/uploads/profiles/6979e3a880b5b_1769595816.jpg', 'active', 'Ruang Laboran', '0000-00-00 00:00:00', 'Silahkan di hubungi melalui What\'sApp terlebih dahulu jika ingin bertemu.', '07:30:00', '2026-01-28 10:23:10'),
(9, 15, '85341864970', 'Koordinator Lab', 'staff', 'http://localhost/iclabs/public/uploads/profiles/6979e4d19a998_1769596113.jpeg', 'active', 'Ruang Asisten', '0000-00-00 00:00:00', 'Silahkan di hubungi melalui What\'sApp terlebih dahulu sebelum ingin bertemu.', '07:30:00', '2026-01-28 10:27:49');

-- --------------------------------------------------------

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lab_activities`
--

INSERT INTO `lab_activities` (`id`, `title`, `image_cover`, `activity_type`, `activity_date`, `location`, `description`, `link_url`, `status`, `created_by`, `created_at`) VALUES
(3, 'Seminar Keamanan Siber', 'http://localhost/iclabs/public/uploads/activities/6974b16c3827c_1769255276.png', 'seminar', '2025-01-20', 'Lab Jaringan', 'Seminar tentang keamanan siber dan ethical hacking', 'https://komikindo.ch/', 'published', 1, '2026-01-16 03:50:50'),
(5, 'bpk', 'http://localhost/iclabs/public/uploads/activities/697a961678afd_1769641494.jpeg', '', '2026-01-30', NULL, '.', 'https://bpkad.makassarkota.go.id/', 'draft', 1, '2026-01-28 23:04:54');

-- --------------------------------------------------------

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
  `completed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lab_problems`
--

INSERT INTO `lab_problems` (`id`, `laboratory_id`, `pc_number`, `problem_type`, `description`, `reporter_name`, `status`, `reported_by`, `assigned_to`, `reported_at`, `started_at`, `completed_at`) VALUES
(5, 13, 'pc no 5', 'hardware', 'bapak e', NULL, 'reported', 1, NULL, '2026-01-27 04:42:27', NULL, NULL);

-- --------------------------------------------------------

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

-- --------------------------------------------------------

--
-- Table structure for table `problem_histories`
--

CREATE TABLE `problem_histories` (
  `id` int(11) NOT NULL,
  `problem_id` int(11) NOT NULL,
  `status` enum('reported','in_progress','resolved') NOT NULL,
  `note` text DEFAULT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `problem_histories`
--

INSERT INTO `problem_histories` (`id`, `problem_id`, `status`, `note`, `updated_by`, `updated_at`) VALUES
(14, 5, 'reported', 'Laporan dibuat oleh Admin', 1, '2026-01-27 04:42:27');

-- --------------------------------------------------------

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
(3, 'asisten', '2026-01-16 03:50:50'),
(4, 'dosen', '2026-01-31 22:02:01');

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
  `is_replacement` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schedule_sessions`
--

INSERT INTO `schedule_sessions` (`id`, `course_plan_id`, `meeting_number`, `session_date`, `start_time`, `end_time`, `topic`, `status`, `is_replacement`) VALUES
(24, 5, 1, '2026-02-01', '09:40:00', '00:10:00', NULL, 'scheduled', 0),
(25, 5, 2, '2026-02-08', '09:40:00', '00:10:00', NULL, 'scheduled', 0),
(26, 5, 3, '2026-02-15', '09:40:00', '00:10:00', NULL, 'scheduled', 0),
(27, 5, 4, '2026-02-22', '09:40:00', '00:10:00', NULL, 'scheduled', 0),
(28, 5, 5, '2026-03-01', '09:40:00', '00:10:00', NULL, 'scheduled', 0),
(29, 5, 6, '2026-03-08', '09:40:00', '00:10:00', NULL, 'scheduled', 0),
(30, 5, 7, '2026-03-15', '09:40:00', '00:10:00', NULL, 'scheduled', 0),
(31, 5, 8, '2026-03-22', '09:40:00', '00:10:00', NULL, 'scheduled', 0),
(32, 5, 9, '2026-03-29', '09:40:00', '00:10:00', NULL, 'scheduled', 0),
(33, 5, 10, '2026-04-05', '09:40:00', '00:10:00', NULL, 'scheduled', 0),
(34, 5, 11, '2026-04-12', '09:40:00', '00:10:00', NULL, 'scheduled', 0),
(35, 5, 12, '2026-04-19', '09:40:00', '00:10:00', NULL, 'scheduled', 0),
(36, 5, 13, '2026-04-26', '09:40:00', '00:10:00', NULL, 'scheduled', 0),
(37, 5, 14, '2026-05-03', '09:40:00', '00:10:00', NULL, 'scheduled', 0);

-- --------------------------------------------------------

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
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `role_id`, `status`, `image`, `created_at`) VALUES
(1, 'Admin User', 'admin@iclabs.com', '6281234567890', '$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u', 1, 'active', NULL, '2026-01-16 03:50:50'),
(2, 'Koordinator Lab', 'koordinator@iclabs.com', '6281234567890', '$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u', 2, 'active', 'http://localhost/iclabs/public/uploads/profiles/file_697ecf97602d4.jpeg', '2026-01-16 03:50:50'),
(10, 'MUHAMMAD RIFKY SAPUTRA SCANIA', 'rifky020504@gmail.com', NULL, '$2y$10$hQcLcLfg2enXMREWGBzFzuIks8GpW/iqoru5Bu3tFx00./SjqT84S', 3, 'active', 'http://localhost/iclabs/public/uploads/profiles/file_697ecf8c833cc.jpeg', '2026-01-19 19:48:31'),
(11, 'Ir. Abdul Rachman Manga’, S.Kom., MT.,MTA', 'abdulrachman.manga@umi.ac.id', NULL, '$2y$10$Wxx6KApsb477HnylJ6nck..9BcsHEq1HfNEB8IUKhZZ0jsO5ZNEFi', 1, 'active', 'http://localhost/iclabs/public/uploads/profiles/file_697ecf7e2d3f0.png', '2026-01-28 09:51:18'),
(12, 'Ir. Huzain Azis, S.Kom., M.Cs., MTA.', 'huzain.azis@umi.ac.id', NULL, '$2y$10$oeV5vrVDWeS/ugYR.3Mqvellfi.zFZjfxh0i/6f1ScsEVz6HV/iDG', 1, 'active', 'http://localhost/iclabs/public/uploads/profiles/file_697ecf66614ae.png', '2026-01-28 09:52:56'),
(13, 'Herdianti, S.Si., M.Eng., MTA.', 'herdianti.darwis@umi.ac.id', NULL, '$2y$10$EzTQyeRgBH2HxCUGksbOOOHuQxCL9Nbi.5K1toPK0ACcKkqw0OBdK', 1, 'active', 'http://localhost/iclabs/public/uploads/profiles/file_697ecf7756322.png', '2026-01-28 09:59:05'),
(14, 'Fatimah AR. Tuasamu, S.Kom., MTA, MCF.', 'fatima.tuasamu@umi.ac.id', NULL, '$2y$10$CaybG4ErgABDMaKV42mdQ.zCagrZ8nOSEMJWHNt8iCerZaYw81tUy', 1, 'active', 'http://localhost/iclabs/public/uploads/profiles/file_697ecf7177170.jpg', '2026-01-28 10:21:50'),
(15, 'Adam Adnan, S.Kom.', 'adam.adnan@umi.ac.id', NULL, '$2y$10$1MLmAPrTDle6syKYbb/eKe0W4hecEmUP4sB32Vs16jWSD2HNwqfAO', 2, 'active', 'http://localhost/iclabs/public/uploads/profiles/file_697ecf6c5d409.jpeg', '2026-01-28 10:25:55'),
(16, 'Dr. Ir. Dolly Indra, M.M.SI., MTA', 'dolly.indra@umi.ac.id', NULL, '$2y$10$E0GXC2oE3zVhmlm0Ui1ZnOyTVxjF5378u8W77Bk/t2ZVPRTkCTXUS', 4, 'active', 'http://localhost/iclabs/public/uploads/profiles/file_697ecfe0db924.png', '2026-02-01 00:07:15');

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
  ADD KEY `laboratory_id` (`laboratory_id`),
  ADD KEY `fk_course_lecturer` (`lecturer_id`),
  ADD KEY `fk_course_asst1` (`assistant_1_id`),
  ADD KEY `fk_course_asst2` (`assistant_2_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `course_plans`
--
ALTER TABLE `course_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `head_laboran`
--
ALTER TABLE `head_laboran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `schedule_sessions`
--
ALTER TABLE `schedule_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
  ADD CONSTRAINT `course_plans_ibfk_1` FOREIGN KEY (`laboratory_id`) REFERENCES `laboratories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_course_asst1` FOREIGN KEY (`assistant_1_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_course_asst2` FOREIGN KEY (`assistant_2_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_course_lecturer` FOREIGN KEY (`lecturer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

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
