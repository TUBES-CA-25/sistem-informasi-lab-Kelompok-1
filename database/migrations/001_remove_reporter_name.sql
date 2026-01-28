-- Migration: Remove unused reporter_name column
-- Date: 2026-01-28
-- Reason: Field tidak digunakan, data reporter sudah ada di reported_by (FK ke users)

USE iclabs;

-- Hapus kolom reporter_name dari tabel lab_problems
ALTER TABLE lab_problems 
DROP COLUMN reporter_name;

-- Verify: Show columns after migration
-- SHOW COLUMNS FROM lab_problems;
