-- ==========================================
-- ICLABS - Laboratory Information System
-- Database Schema & Seed Data
-- ==========================================

-- Create Database
CREATE DATABASE IF NOT EXISTS iclabs CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE iclabs;

-- ==========================================
-- DROP TABLES (if exist, for fresh install)
-- ==========================================
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS problem_histories;
DROP TABLE IF EXISTS lab_problems;
DROP TABLE IF EXISTS lab_activities;
DROP TABLE IF EXISTS head_laboran;
DROP TABLE IF EXISTS assistant_schedules;
DROP TABLE IF EXISTS lab_schedules;
DROP TABLE IF EXISTS laboratories;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS roles;
SET FOREIGN_KEY_CHECKS = 1;

-- ==========================================
-- TABLE: roles
-- ==========================================
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(50) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- TABLE: users
-- ==========================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role_id INT NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- TABLE: laboratories
-- ==========================================
CREATE TABLE laboratories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lab_name VARCHAR(100) NOT NULL,
    description TEXT,
    location VARCHAR(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- TABLE: lab_schedules
-- ==========================================
CREATE TABLE lab_schedules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    laboratory_id INT NOT NULL,
    day ENUM('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday') NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    course VARCHAR(100) NOT NULL,
    lecturer VARCHAR(100),
    assistant VARCHAR(100),
    participant_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (laboratory_id) REFERENCES laboratories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- TABLE: assistant_schedules
-- ==========================================
CREATE TABLE assistant_schedules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    day ENUM('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday') NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    status ENUM('scheduled', 'completed', 'cancelled') DEFAULT 'scheduled',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- TABLE: head_laboran
-- ==========================================
CREATE TABLE head_laboran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    photo VARCHAR(255),
    status ENUM('active', 'inactive') DEFAULT 'active',
    location VARCHAR(100),
    time_in TIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- TABLE: lab_activities
-- ==========================================
CREATE TABLE lab_activities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    activity_type ENUM('praktikum', 'workshop', 'seminar', 'maintenance', 'other') NOT NULL,
    activity_date DATE NOT NULL,
    location VARCHAR(100),
    description TEXT,
    status ENUM('draft', 'published', 'cancelled') DEFAULT 'draft',
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- TABLE: lab_problems
-- ==========================================
CREATE TABLE lab_problems (
    id INT AUTO_INCREMENT PRIMARY KEY,
    laboratory_id INT NOT NULL,
    pc_number VARCHAR(50),
    problem_type ENUM('hardware', 'software', 'network', 'other') NOT NULL,
    description TEXT NOT NULL,
    status ENUM('reported', 'in_progress', 'resolved') DEFAULT 'reported',
    reported_by INT NOT NULL,
    reported_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (laboratory_id) REFERENCES laboratories(id) ON DELETE CASCADE,
    FOREIGN KEY (reported_by) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- TABLE: problem_histories
-- ==========================================
CREATE TABLE problem_histories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    problem_id INT NOT NULL,
    status ENUM('reported', 'in_progress', 'resolved') NOT NULL,
    note TEXT,
    updated_by INT NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (problem_id) REFERENCES lab_problems(id) ON DELETE CASCADE,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- SEED DATA
-- ==========================================

-- Insert Roles
INSERT INTO roles (role_name) VALUES 
('admin'),
('koordinator'),
('asisten');

-- Insert Users (password: password123)
INSERT INTO users (name, email, password, role_id, status) VALUES 
('Admin User', 'admin@iclabs.com', '$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u', 1, 'active'),
('Koordinator Lab', 'koordinator@iclabs.com', '$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u', 2, 'active'),
('Asisten 1', 'asisten1@iclabs.com', '$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u', 3, 'active'),
('Asisten 2', 'asisten2@iclabs.com', '$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u', 3, 'active'),
('Asisten 3', 'asisten3@iclabs.com', '$2y$10$UX7tq8QgvaFqYJEDrkqLwebWJKFRcwJw6KilsVOiuLeVQY.26594u', 3, 'active');

-- Insert Laboratories
INSERT INTO laboratories (lab_name, description, location) VALUES 
('Lab Komputer 1', 'Laboratorium komputer untuk praktikum pemrograman dasar', 'Gedung A - Lantai 2'),
('Lab Komputer 2', 'Laboratorium komputer untuk praktikum web programming', 'Gedung A - Lantai 3'),
('Lab Jaringan', 'Laboratorium khusus untuk praktikum jaringan komputer', 'Gedung B - Lantai 1'),
('Lab Multimedia', 'Laboratorium untuk praktikum desain grafis dan multimedia', 'Gedung B - Lantai 2');

-- Insert Lab Schedules
INSERT INTO lab_schedules (laboratory_id, day, start_time, end_time, course, lecturer, assistant, participant_count) VALUES 
(1, 'Monday', '08:00:00', '10:00:00', 'Pemrograman Dasar', 'Dr. Ahmad Fauzi', 'Asisten 1', 30),
(1, 'Monday', '10:00:00', '12:00:00', 'Algoritma Pemrograman', 'Prof. Siti Nurhaliza', 'Asisten 2', 35),
(2, 'Tuesday', '08:00:00', '11:00:00', 'Web Programming', 'Ir. Budi Santoso', 'Asisten 3', 32),
(2, 'Wednesday', '13:00:00', '15:00:00', 'Database Management', 'Dr. Dewi Sartika', 'Asisten 1', 28),
(3, 'Thursday', '08:00:00', '10:00:00', 'Jaringan Komputer', 'M. Yusuf, M.T.', 'Asisten 2', 25),
(3, 'Friday', '10:00:00', '12:00:00', 'Keamanan Jaringan', 'Dr. Rina Wijaya', 'Asisten 3', 30),
(4, 'Friday', '13:00:00', '16:00:00', 'Desain Grafis', 'Drs. Hendra Kusuma', 'Asisten 1', 20);

-- Insert Assistant Schedules (Piket)
INSERT INTO assistant_schedules (user_id, day, start_time, end_time, status) VALUES 
(3, 'Monday', '08:00:00', '16:00:00', 'scheduled'),
(4, 'Tuesday', '08:00:00', '16:00:00', 'scheduled'),
(5, 'Wednesday', '08:00:00', '16:00:00', 'scheduled'),
(3, 'Thursday', '08:00:00', '16:00:00', 'scheduled'),
(4, 'Friday', '08:00:00', '16:00:00', 'scheduled');

-- Insert Head Laboran
INSERT INTO head_laboran (user_id, photo, status, location, time_in) VALUES 
(2, '', 'active', 'Lab Komputer 1', '08:00:00');

-- Insert Lab Activities
INSERT INTO lab_activities (title, activity_type, activity_date, location, description, status, created_by) VALUES 
('Workshop Python Programming', 'workshop', '2025-01-15', 'Lab Komputer 1', 'Workshop pemrograman Python untuk pemula', 'published', 1),
('Maintenance Rutin Lab', 'maintenance', '2025-01-10', 'Semua Lab', 'Maintenance dan pembersihan rutin semua laboratorium', 'published', 1),
('Seminar Keamanan Siber', 'seminar', '2025-01-20', 'Lab Jaringan', 'Seminar tentang keamanan siber dan ethical hacking', 'published', 1),
('Praktikum Database Lanjut', 'praktikum', '2025-01-08', 'Lab Komputer 2', 'Praktikum database management sistem lanjutan', 'published', 1);

-- Insert Lab Problems (Sample)
INSERT INTO lab_problems (laboratory_id, pc_number, problem_type, description, status, reported_by) VALUES 
(1, 'PC-05', 'hardware', 'Monitor tidak menyala, kemungkinan kabel VGA rusak', 'reported', 3),
(1, 'PC-12', 'software', 'Microsoft Office tidak bisa dibuka, perlu install ulang', 'in_progress', 4),
(2, 'PC-08', 'network', 'Tidak bisa connect ke internet, IP conflict', 'resolved', 5),
(3, 'PC-03', 'hardware', 'Keyboard beberapa tombol tidak berfungsi', 'reported', 3);

-- Insert Problem Histories
INSERT INTO problem_histories (problem_id, status, note, updated_by) VALUES 
(1, 'reported', 'Problem dilaporkan oleh asisten', 3),
(2, 'reported', 'Problem dilaporkan oleh asisten', 4),
(2, 'in_progress', 'Sedang dalam proses perbaikan oleh koordinator', 2),
(3, 'reported', 'Problem dilaporkan oleh asisten', 5),
(3, 'in_progress', 'Sedang dicek oleh teknisi', 2),
(3, 'resolved', 'Kabel VGA sudah diganti dan monitor normal', 2),
(4, 'reported', 'Problem dilaporkan oleh asisten', 3);

-- ==========================================
-- CREATE INDEXES for better performance
-- ==========================================
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_role ON users(role_id);
CREATE INDEX idx_lab_schedules_day ON lab_schedules(day);
CREATE INDEX idx_lab_problems_status ON lab_problems(status);
CREATE INDEX idx_lab_problems_lab ON lab_problems(laboratory_id);
CREATE INDEX idx_lab_activities_date ON lab_activities(activity_date);

-- ==========================================
-- DONE
-- ==========================================
-- Database ICLABS berhasil dibuat dengan:
-- - 9 Tabel sesuai spesifikasi
-- - 3 Role (admin, koordinator, asisten)
-- - 5 User (1 admin, 1 koordinator, 3 asisten)
-- - 4 Laboratories
-- - 7 Lab Schedules
-- - 5 Assistant Schedules
-- - 1 Head Laboran
-- - 4 Lab Activities
-- - 4 Lab Problems dengan histories
-- 
-- Default Login:
-- Admin: admin@iclabs.com / password123
-- Koordinator: koordinator@iclabs.com / password123
-- Asisten1: asisten1@iclabs.com / password123
-- ==========================================
