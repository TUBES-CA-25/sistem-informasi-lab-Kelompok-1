<?php

/**
 * ICLABS - Lab Schedule Model (Cleaned)
 * Handles Scheduling Logic Only
 */
class LabScheduleModel extends Model
{
    protected $table = 'course_plans';

    public function countSchedules()
    {
        $sql = "SELECT COUNT(*) as total FROM course_plans";
        $result = $this->queryOne($sql);
        return $result['total'];
    }

    public function isSlotOccupied($labId, $date, $startTime, $endTime)
    {
        $sql = "SELECT COUNT(*) as count 
                FROM schedule_sessions ss
                JOIN course_plans cp ON ss.course_plan_id = cp.id
                WHERE cp.laboratory_id = ? 
                AND ss.session_date = ? 
                AND ss.status != 'cancelled'
                AND (ss.start_time < ? AND ss.end_time > ?)";
        $result = $this->queryOne($sql, [$labId, $date, $endTime, $startTime]);
        return $result['count'] > 0;
    }

    public function createCoursePlan($data)
    {
        $this->table = 'course_plans';
        return $this->insert($data);
    }

    public function createSession($data)
    {
        $this->table = 'schedule_sessions';
        return $this->insert($data);
    }

    // Ambil semua jadwal (untuk halaman Admin List Schedule)
    public function getAllWithLaboratory()
    {
        // Kita ambil data dari tabel SESSION, lalu join ke PLAN dan LAB
        // ss.id kita pakai sebagai ID utama baris
        // cp.id kita ambil sebagai 'plan_id' untuk keperluan Edit Master
        $sql = "SELECT ss.id, ss.session_date, ss.start_time, ss.end_time, 
                       cp.id as plan_id, cp.course_name, cp.class_code, cp.semester, cp.program_study,
                       cp.lecturer_name, cp.lecturer_photo,
                       cp.assistant_1_name, cp.assistant_1_photo,
                       cp.assistant_2_name, cp.assistant_2_photo,
                       l.lab_name, l.location
                FROM schedule_sessions ss
                JOIN course_plans cp ON ss.course_plan_id = cp.id
                JOIN laboratories l ON cp.laboratory_id = l.id
                WHERE ss.status != 'cancelled'
                ORDER BY ss.session_date ASC, ss.start_time ASC";
        return $this->query($sql);
    }

    public function getScheduleDetail($id)
    {
        $sql = "SELECT cp.*, l.lab_name, l.location 
                FROM course_plans cp 
                JOIN laboratories l ON cp.laboratory_id = l.id 
                WHERE cp.id = ?";
        return $this->queryOne($sql, [$id]);
    }

    public function deleteSchedule($id)
    {
        $this->table = 'course_plans';
        return $this->delete($id);
    }

    public function updateSchedule($id, $data)
    {
        $this->table = 'course_plans';
        return $this->update($id, $data);
    }

    public function getCalendarEvents($labId = null)
    {
        $sql = "SELECT ss.id, ss.session_date, ss.start_time, ss.end_time, 
                       cp.course_name, cp.class_code, cp.lecturer_name,
                       l.lab_name
                FROM schedule_sessions ss
                JOIN course_plans cp ON ss.course_plan_id = cp.id
                JOIN laboratories l ON cp.laboratory_id = l.id
                WHERE ss.status != 'cancelled'";
        $params = [];
        if ($labId) {
            $sql .= " AND cp.laboratory_id = ?";
            $params[] = $labId;
        }
        return $this->query($sql, $params);
    }

    public function getTodaySchedules()
    {
        $today = date('Y-m-d');
        $sql = "SELECT ss.*, cp.course_name, cp.lecturer_name, cp.class_code, 
                       l.lab_name, l.location, cp.lecturer_photo, cp.laboratory_id 
                FROM schedule_sessions ss
                JOIN course_plans cp ON ss.course_plan_id = cp.id
                JOIN laboratories l ON cp.laboratory_id = l.id
                WHERE ss.session_date = ? 
                AND ss.status != 'cancelled'
                ORDER BY ss.start_time ASC";
        return $this->query($sql, [$today]);
    }

    public function deleteByDate($date, $labId = null)
    {
        $sql = "DELETE FROM schedule_sessions WHERE session_date = ?";
        $params = [$date];
        if ($labId) {
            // Join ke course_plans untuk filter by Lab
            $sql = "DELETE ss FROM schedule_sessions ss 
                JOIN course_plans cp ON ss.course_plan_id = cp.id 
                WHERE ss.session_date = ? AND cp.laboratory_id = ?";
            $params[] = $labId;
        }
        return $this->query($sql, $params);
    }

    public function deleteSession($id)
    {
        $this->table = 'schedule_sessions';
        return $this->delete($id);
    }

    public function getFilteredSchedules($filters = [], $limit = 20, $offset = 0)
    {
        $params = [];
        $sql = "SELECT ss.id, ss.session_date, ss.start_time, ss.end_time, 
                       cp.id as plan_id, cp.course_name, cp.class_code, cp.semester, cp.program_study,
                       cp.lecturer_name, cp.lecturer_photo,
                       cp.assistant_1_name, cp.assistant_1_photo,
                       cp.assistant_2_name, cp.assistant_2_photo,
                       l.lab_name, l.location
                FROM schedule_sessions ss
                JOIN course_plans cp ON ss.course_plan_id = cp.id
                JOIN laboratories l ON cp.laboratory_id = l.id
                WHERE ss.status != 'cancelled'";

        // 1. Filter Search (Matkul, Dosen, Kelas)
        if (!empty($filters['search'])) {
            $sql .= " AND (cp.course_name LIKE ? OR cp.lecturer_name LIKE ? OR cp.class_code LIKE ?)";
            $searchTerm = "%" . $filters['search'] . "%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }

        // 2. Filter Laboratorium
        if (!empty($filters['lab_id'])) {
            $sql .= " AND cp.laboratory_id = ?";
            $params[] = $filters['lab_id'];
        }

        // Order & Limit
        $sql .= " ORDER BY ss.session_date ASC, ss.start_time ASC LIMIT ? OFFSET ?";
        $params[] = (int)$limit;
        $params[] = (int)$offset;

        return $this->query($sql, $params);
    }

    public function countFilteredSchedules($filters = [])
    {
        $params = [];
        $sql = "SELECT COUNT(*) as total 
                FROM schedule_sessions ss
                JOIN course_plans cp ON ss.course_plan_id = cp.id
                WHERE ss.status != 'cancelled'";

        if (!empty($filters['search'])) {
            $sql .= " AND (cp.course_name LIKE ? OR cp.lecturer_name LIKE ? OR cp.class_code LIKE ?)";
            $searchTerm = "%" . $filters['search'] . "%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }

        if (!empty($filters['lab_id'])) {
            $sql .= " AND cp.laboratory_id = ?";
            $params[] = $filters['lab_id'];
        }

        $result = $this->queryOne($sql, $params);
        return $result['total'];
    }
}