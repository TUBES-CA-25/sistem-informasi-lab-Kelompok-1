-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2026 at 05:06 AM
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
-- Table structure for table `assistant_schedules`
--

CREATE TABLE `assistant_schedules` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `day` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` enum('scheduled','completed','cancelled') DEFAULT 'scheduled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assistant_schedules`
--

INSERT INTO `assistant_schedules` (`id`, `user_id`, `day`, `start_time`, `end_time`, `status`) VALUES
(1, 3, 'Monday', '08:00:00', '16:00:00', 'scheduled'),
(2, 4, 'Tuesday', '08:00:00', '16:00:00', 'scheduled'),
(3, 5, 'Wednesday', '08:00:00', '16:00:00', 'scheduled'),
(4, 3, 'Thursday', '08:00:00', '16:00:00', 'scheduled'),
(5, 4, 'Friday', '08:00:00', '16:00:00', 'scheduled');

-- --------------------------------------------------------

--
-- Table structure for table `head_laboran`
--

CREATE TABLE `head_laboran` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `position` varchar(100) DEFAULT 'Laboran',
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

INSERT INTO `head_laboran` (`id`, `user_id`, `position`, `photo`, `status`, `location`, `return_time`, `notes`, `time_in`, `created_at`) VALUES
(1, 2, 'Kepala Lab Komputer Dasar', '', 'active', 'Lab Komputer 1', NULL, 'Standby di ruangan A201', '08:00:00', '2026-01-16 03:50:50'),
(2, 6, 'Kepala Lab Multimedia', NULL, 'inactive', 'Luar Kota', '2026-01-05 08:00:00', 'Sedang Dinas Luar di Jakarta', NULL, '2026-01-16 03:50:50'),
(3, 7, 'Kepala Lab Jaringan', NULL, 'active', 'Lab Jaringan B1', NULL, 'Siap melayani konsultasi', '07:30:00', '2026-01-16 03:50:50'),
(4, 8, 'Staff Laboran', NULL, 'active', 'Ruang Server', NULL, 'Maintenance Server Rutin', '08:00:00', '2026-01-16 03:50:50');

-- --------------------------------------------------------

--
-- Table structure for table `laboratories`
--

CREATE TABLE `laboratories` (
  `id` int(11) NOT NULL,
  `lab_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laboratories`
--

INSERT INTO `laboratories` (`id`, `lab_name`, `description`, `location`) VALUES
(1, 'Lab Komputer 1', 'Laboratorium komputer untuk praktikum pemrograman dasar', 'Gedung A - Lantai 2'),
(2, 'Lab Komputer 2', 'Laboratorium komputer untuk praktikum web programming', 'Gedung A - Lantai 3'),
(3, 'Lab Jaringan', 'Laboratorium khusus untuk praktikum jaringan komputer', 'Gedung B - Lantai 1'),
(4, 'Lab Multimedia', 'Laboratorium untuk praktikum desain grafis dan multimedia', 'Gedung B - Lantai 2');

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
  `status` enum('draft','published','cancelled') DEFAULT 'draft',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lab_activities`
--

INSERT INTO `lab_activities` (`id`, `title`, `image_cover`, `activity_type`, `activity_date`, `location`, `description`, `status`, `created_by`, `created_at`) VALUES
(1, 'Workshop Python Programming', 'https://placehold.co/600x400/2563eb/FFF?text=Workshop+Python', 'workshop', '2025-01-15', 'Lab Komputer 1', 'Workshop pemrograman Python untuk pemula', 'published', 1, '2026-01-16 03:50:50'),
(2, 'Maintenance Rutin Lab', 'https://placehold.co/600x400/10b981/FFF?text=Maintenance', 'maintenance', '2025-01-10', 'Semua Lab', 'Maintenance dan pembersihan rutin semua laboratorium', 'published', 1, '2026-01-16 03:50:50'),
(3, 'Seminar Keamanan Siber', 'https://placehold.co/600x400/f59e0b/FFF?text=Seminar+Security', 'seminar', '2025-01-20', 'Lab Jaringan', 'Seminar tentang keamanan siber dan ethical hacking', 'published', 1, '2026-01-16 03:50:50'),
(4, 'Praktikum Database Lanjut', 'https://placehold.co/600x400/ef4444/FFF?text=Database', 'praktikum', '2025-01-08', 'Lab Komputer 2', 'Praktikum database management sistem lanjutan', 'published', 1, '2026-01-16 03:50:50');

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

INSERT INTO `lab_problems` (`id`, `laboratory_id`, `pc_number`, `problem_type`, `description`, `status`, `reported_by`, `assigned_to`, `reported_at`, `started_at`, `completed_at`) VALUES
(1, 1, 'PC-05', 'hardware', 'Monitor tidak menyala, kemungkinan kabel VGA rusak', 'reported', 3, NULL, '2026-01-16 03:50:50', NULL, NULL),
(2, 1, 'PC-12', 'software', 'Microsoft Office tidak bisa dibuka, perlu install ulang', 'in_progress', 4, NULL, '2026-01-16 03:50:50', NULL, NULL),
(3, 2, 'PC-08', 'network', 'Tidak bisa connect ke internet, IP conflict', 'resolved', 5, NULL, '2026-01-16 03:50:50', NULL, NULL),
(4, 3, 'PC-03', 'hardware', 'Keyboard beberapa tombol tidak berfungsi', 'reported', 3, NULL, '2026-01-16 03:50:50', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lab_schedules`
--

CREATE TABLE `lab_schedules` (
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
-- Dumping data for table `lab_schedules`
--

INSERT INTO `lab_schedules` (`id`, `laboratory_id`, `day`, `start_time`, `end_time`, `course`, `program_study`, `semester`, `class_code`, `frequency`, `description`, `lecturer`, `lecturer_photo`, `assistant`, `assistant_photo`, `assistant_2`, `assistant2_photo`, `participant_count`, `created_at`) VALUES
(1, 1, 'Monday', '08:00:00', '10:00:00', 'Pemrograman Dasar', 'Teknik Informatika', 1, 'A1', 'Mingguan', 'Praktikum ini berfokus pada penerapan algoritma Machine Learning dasar menggunakan Python.', 'Dr. Ahmad Fauzi', 'https://ui-avatars.com/api/?name=Dosen+A&background=random&size=200', 'Asisten 1', 'https://ui-avatars.com/api/?name=Asisten+1&background=0D8ABC&color=fff&size=200', 'Asisten Magang', 'https://ui-avatars.com/api/?name=Asisten+2&background=random&size=200', 30, '2026-01-16 03:50:50'),
(2, 1, 'Monday', '10:00:00', '12:00:00', 'Algoritma Pemrograman', 'Sistem Informasi', 3, 'B2', 'Mingguan', 'Praktikum ini berfokus pada penerapan algoritma Machine Learning dasar menggunakan Python.', 'Prof. Siti Nurhaliza', 'https://ui-avatars.com/api/?name=Dosen+A&background=random&size=200', 'Asisten 2', 'https://ui-avatars.com/api/?name=Asisten+1&background=0D8ABC&color=fff&size=200', 'Asisten Senior', 'https://ui-avatars.com/api/?name=Asisten+2&background=random&size=200', 35, '2026-01-16 03:50:50'),
(3, 2, 'Tuesday', '08:00:00', '11:00:00', 'Web Programming', 'Teknik Informatika', 5, 'C1', '2 Minggu Sekali', 'Praktikum ini berfokus pada penerapan algoritma Machine Learning dasar menggunakan Python.', 'Ir. Budi Santoso', 'https://ui-avatars.com/api/?name=Dosen+A&background=random&size=200', 'Asisten 3', 'https://ui-avatars.com/api/?name=Asisten+1&background=0D8ABC&color=fff&size=200', '-', 'https://ui-avatars.com/api/?name=Asisten+2&background=random&size=200', 32, '2026-01-16 03:50:50'),
(4, 2, 'Wednesday', '13:00:00', '15:00:00', 'Database Management', NULL, NULL, NULL, NULL, 'Praktikum ini berfokus pada penerapan algoritma Machine Learning dasar menggunakan Python.', 'Dr. Dewi Sartika', 'https://ui-avatars.com/api/?name=Dosen+A&background=random&size=200', 'Asisten 1', 'https://ui-avatars.com/api/?name=Asisten+1&background=0D8ABC&color=fff&size=200', NULL, 'https://ui-avatars.com/api/?name=Asisten+2&background=random&size=200', 28, '2026-01-16 03:50:50'),
(5, 3, 'Thursday', '08:00:00', '10:00:00', 'Jaringan Komputer', NULL, NULL, NULL, NULL, 'Praktikum ini berfokus pada penerapan algoritma Machine Learning dasar menggunakan Python.', 'M. Yusuf, M.T.', 'https://ui-avatars.com/api/?name=Dosen+A&background=random&size=200', 'Asisten 2', 'https://ui-avatars.com/api/?name=Asisten+1&background=0D8ABC&color=fff&size=200', NULL, 'https://ui-avatars.com/api/?name=Asisten+2&background=random&size=200', 25, '2026-01-16 03:50:50'),
(6, 3, 'Friday', '10:00:00', '12:00:00', 'Keamanan Jaringan', NULL, NULL, NULL, NULL, 'Praktikum ini berfokus pada penerapan algoritma Machine Learning dasar menggunakan Python.', 'Dr. Rina Wijaya', 'https://ui-avatars.com/api/?name=Dosen+A&background=random&size=200', 'Asisten 3', 'https://ui-avatars.com/api/?name=Asisten+1&background=0D8ABC&color=fff&size=200', NULL, 'https://ui-avatars.com/api/?name=Asisten+2&background=random&size=200', 30, '2026-01-16 03:50:50'),
(7, 4, 'Friday', '13:00:00', '16:00:00', 'Desain Grafis', NULL, NULL, NULL, NULL, 'Praktikum ini berfokus pada penerapan algoritma Machine Learning dasar menggunakan Python.', 'Drs. Hendra Kusuma', 'https://ui-avatars.com/api/?name=Dosen+A&background=random&size=200', 'Asisten 1', 'https://ui-avatars.com/api/?name=Asisten+1&background=0D8ABC&color=fff&size=200', NULL, 'https://ui-avatars.com/api/?name=Asisten+2&background=random&size=200', 20, '2026-01-16 03:50:50'),
(8, 2, 'Wednesday', '08:00:00', '11:00:00', 'Kecerdasan Buatan', 'Teknik Informatika', 5, 'IF-5-A', 'Mingguan', 'Praktikum ini berfokus pada penerapan algoritma Machine Learning dasar menggunakan Python.', 'Prof. Dr. AI Expert', 'https://ui-avatars.com/api/?name=Dosen+A&background=random&size=200', 'Asisten 1', 'https://ui-avatars.com/api/?name=Asisten+1&background=0D8ABC&color=fff&size=200', 'Asisten 3', 'https://ui-avatars.com/api/?name=Asisten+2&background=random&size=200', 40, '2026-01-16 03:50:50');

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
(1, 1, 'reported', 'Problem dilaporkan oleh asisten', 3, '2026-01-16 03:50:50'),
(2, 2, 'reported', 'Problem dilaporkan oleh asisten', 4, '2026-01-16 03:50:50'),
(3, 2, 'in_progress', 'Sedang dalam proses perbaikan oleh koordinator', 2, '2026-01-16 03:50:50'),
(4, 3, 'reported', 'Problem dilaporkan oleh asisten', 5, '2026-01-16 03:50:50'),
(5, 3, 'in_progress', 'Sedang dicek oleh teknisi', 2, '2026-01-16 03:50:50'),
(6, 3, 'resolved', 'Kabel VGA sudah diganti dan monitor normal', 2, '2026-01-16 03:50:50'),
(7, 4, 'reported', 'Problem dilaporkan oleh asisten', 3, '2026-01-16 03:50:50');

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
(3, 'asisten', '2026-01-16 03:50:50');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role_id`, `status`, `created_at`) VALUES
(1, 'Admin User', 'admin@iclabs.com', '$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u', 1, 'active', '2026-01-16 03:50:50'),
(2, 'Koordinator Lab', 'koordinator@iclabs.com', '$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u', 2, 'active', '2026-01-16 03:50:50'),
(3, 'Asisten 1', 'asisten1@iclabs.com', '$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u', 3, 'active', '2026-01-16 03:50:50'),
(4, 'Asisten 2', 'asisten2@iclabs.com', '$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u', 3, 'active', '2026-01-16 03:50:50'),
(5, 'Asisten 3', 'asisten3@iclabs.com', '$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u', 3, 'active', '2026-01-16 03:50:50'),
(6, 'Budi (KaLab Multimedia)', 'kalab2@iclabs.com', '$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u', 2, 'active', '2026-01-16 03:50:50'),
(7, 'Siti (KaLab Jaringan)', 'kalab3@iclabs.com', '$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u', 2, 'active', '2026-01-16 03:50:50'),
(8, 'Joko (Laboran Teknis)', 'laboran@iclabs.com', '$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u', 2, 'active', '2026-01-16 03:50:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assistant_schedules`
--
ALTER TABLE `assistant_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `head_laboran`
--
ALTER TABLE `head_laboran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

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
-- Indexes for table `lab_problems`
--
ALTER TABLE `lab_problems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reported_by` (`reported_by`),
  ADD KEY `idx_lab_problems_status` (`status`),
  ADD KEY `idx_lab_problems_lab` (`laboratory_id`),
  ADD KEY `fk_lab_problems_assigned` (`assigned_to`);

--
-- Indexes for table `lab_schedules`
--
ALTER TABLE `lab_schedules`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `head_laboran`
--
ALTER TABLE `head_laboran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `laboratories`
--
ALTER TABLE `laboratories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lab_activities`
--
ALTER TABLE `lab_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lab_problems`
--
ALTER TABLE `lab_problems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lab_schedules`
--
ALTER TABLE `lab_schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `problem_histories`
--
ALTER TABLE `problem_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assistant_schedules`
--
ALTER TABLE `assistant_schedules`
  ADD CONSTRAINT `assistant_schedules_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `lab_problems`
--
ALTER TABLE `lab_problems`
  ADD CONSTRAINT `fk_lab_problems_assigned` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `lab_problems_ibfk_1` FOREIGN KEY (`laboratory_id`) REFERENCES `laboratories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lab_problems_ibfk_2` FOREIGN KEY (`reported_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lab_schedules`
--
ALTER TABLE `lab_schedules`
  ADD CONSTRAINT `lab_schedules_ibfk_1` FOREIGN KEY (`laboratory_id`) REFERENCES `laboratories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `problem_histories`
--
ALTER TABLE `problem_histories`
  ADD CONSTRAINT `problem_histories_ibfk_1` FOREIGN KEY (`problem_id`) REFERENCES `lab_problems` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `problem_histories_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
