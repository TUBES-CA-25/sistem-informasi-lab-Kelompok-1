-- Migration: Add default users for development
-- Run this after fresh database setup

-- Insert Asisten users
INSERT INTO users (name, email, password, role_id, created_at) VALUES
('Asisten 1', 'asisten1@iclabs.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 3, NOW()),
('Asisten 2', 'asisten2@iclabs.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 3, NOW()),
('Asisten 3', 'asisten3@iclabs.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 3, NOW()),
('wawan', 'wawan@iclabs.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 3, NOW());

-- Default password for all users: password
