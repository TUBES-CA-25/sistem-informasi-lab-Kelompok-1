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
        // TAMBAHKAN 'ss.course_plan_id' DI SELECT
        $sql = "SELECT ss.id, ss.course_plan_id, ss.session_date, ss.start_time, ss.end_time, 
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

    public function getPaginatedSchedules($limit = 20, $offset = 0, $search = '')
    {
        $sql = "SELECT cp.*, l.lab_name, l.location 
                FROM course_plans cp 
                JOIN laboratories l ON cp.laboratory_id = l.id
                WHERE 1=1";

        $params = [];
        if (!empty($search)) {
            $sql .= " AND (cp.course_name LIKE ? OR cp.lecturer_name LIKE ? OR l.lab_name LIKE ? OR cp.class_code LIKE ?)";
            $searchTerm = "%$search%";
            $params = [$searchTerm, $searchTerm, $searchTerm, $searchTerm];
        }

        // Urutkan berdasarkan Hari dan Jam
        $sql .= " ORDER BY FIELD(cp.day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), cp.start_time ASC 
                  LIMIT $limit OFFSET $offset";

        return $this->query($sql, $params);
    }

    public function countAllSchedules($search = '')
    {
        $sql = "SELECT COUNT(*) as total 
                FROM course_plans cp 
                JOIN laboratories l ON cp.laboratory_id = l.id
                WHERE 1=1";

        $params = [];
        if (!empty($search)) {
            $sql .= " AND (cp.course_name LIKE ? OR cp.lecturer_name LIKE ? OR l.lab_name LIKE ? OR cp.class_code LIKE ?)";
            $searchTerm = "%$search%";
            $params = [$searchTerm, $searchTerm, $searchTerm, $searchTerm];
        }

        $result = $this->queryOne($sql, $params);
        return $result['total'];
    }

    public function getPublicSchedules($limit = 20, $offset = 0, $search = '')
    {
        $sql = "SELECT cp.*, l.lab_name, l.location 
                FROM course_plans cp 
                JOIN laboratories l ON cp.laboratory_id = l.id
                WHERE 1=1";

        $params = [];
        if (!empty($search)) {
            $sql .= " AND (cp.course_name LIKE ? OR cp.lecturer_name LIKE ? OR l.lab_name LIKE ? OR cp.class_code LIKE ?)";
            $searchTerm = "%$search%";
            $params = [$searchTerm, $searchTerm, $searchTerm, $searchTerm];
        }

        // Urutkan: Hari (Senin-Minggu) lalu Jam Mulai
        $sql .= " ORDER BY FIELD(cp.day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), cp.start_time ASC 
                  LIMIT $limit OFFSET $offset";

        return $this->query($sql, $params);
    }

    public function countPublicSchedules($search = '')
    {
        $sql = "SELECT COUNT(*) as total 
                FROM course_plans cp 
                JOIN laboratories l ON cp.laboratory_id = l.id
                WHERE 1=1";

        $params = [];
        if (!empty($search)) {
            $sql .= " AND (cp.course_name LIKE ? OR cp.lecturer_name LIKE ? OR l.lab_name LIKE ? OR cp.class_code LIKE ?)";
            $searchTerm = "%$search%";
            $params = [$searchTerm, $searchTerm, $searchTerm, $searchTerm];
        }

        $result = $this->queryOne($sql, $params);
        return $result['total'];
    }

    public function getMasterPlans($limit = 20, $offset = 0, $search = '')
    {
        $sql = "SELECT cp.*, l.lab_name, 
                       (SELECT COUNT(*) FROM schedule_sessions WHERE course_plan_id = cp.id) as total_generated
                FROM course_plans cp 
                JOIN laboratories l ON cp.laboratory_id = l.id
                WHERE 1=1";

        $params = [];
        if (!empty($search)) {
            $sql .= " AND (cp.course_name LIKE ? OR cp.lecturer_name LIKE ?)";
            $searchTerm = "%$search%";
            $params = [$searchTerm, $searchTerm];
        }

        $sql .= " ORDER BY cp.created_at DESC LIMIT $limit OFFSET $offset";
        return $this->query($sql, $params);
    }

    public function countMasterPlans($search = '')
    {
        $sql = "SELECT COUNT(*) as total FROM course_plans cp WHERE 1=1";
        $params = [];
        if (!empty($search)) {
            $sql .= " AND (cp.course_name LIKE ? OR cp.lecturer_name LIKE ?)";
            $params = ["%$search%", "%$search%"];
        }
        $result = $this->queryOne($sql, $params);
        return $result['total'];
    }

    public function getSessionsByPlanId($planId)
    {
        $sql = "SELECT ss.*, cp.course_name, l.lab_name 
                FROM schedule_sessions ss
                JOIN course_plans cp ON ss.course_plan_id = cp.id
                JOIN laboratories l ON cp.laboratory_id = l.id
                WHERE ss.course_plan_id = ?
                ORDER BY ss.meeting_number ASC, ss.session_date ASC";
        return $this->query($sql, [$planId]);
    }

    public function getSessionDetail($sessionId)
    {
        $sql = "SELECT ss.*, cp.course_name, cp.class_code, cp.lecturer_name, cp.lecturer_photo,
                       cp.assistant_1_name, cp.assistant_1_photo, cp.assistant_2_name, cp.assistant_2_photo,
                       l.lab_name, l.location
                FROM schedule_sessions ss
                JOIN course_plans cp ON ss.course_plan_id = cp.id
                JOIN laboratories l ON cp.laboratory_id = l.id
                WHERE ss.id = ?";
        return $this->queryOne($sql, [$sessionId]);
    }

    public function getLastSessionDate($planId)
    {
        $sql = "SELECT session_date, meeting_number FROM schedule_sessions 
                WHERE course_plan_id = ? 
                ORDER BY meeting_number DESC LIMIT 1";
        return $this->queryOne($sql, [$planId]);
    }

    public function countSessions($planId)
    {
        $sql = "SELECT COUNT(*) as total FROM schedule_sessions WHERE course_plan_id = ?";
        $result = $this->queryOne($sql, [$planId]);
        return $result['total'];
    }

    public function deleteSessionsFromEnd($planId, $limit)
    {
        // Hapus N sesi dengan meeting_number terbesar
        $sql = "DELETE FROM schedule_sessions 
                WHERE course_plan_id = ? 
                ORDER BY meeting_number DESC LIMIT $limit";
        return $this->query($sql, [$planId]);
        // Catatan: LIMIT di DELETE butuh driver DB yang support, MySQL support.
    }

    public function updateAllSessionsTime($planId, $startTime, $endTime)
    {
        $sql = "UPDATE schedule_sessions 
                SET start_time = ?, end_time = ? 
                WHERE course_plan_id = ? AND status != 'resolved'";
        return $this->query($sql, [$startTime, $endTime, $planId]);
    }
    public function updateSession($id, $data)
    {
        $this->table = 'schedule_sessions';
        return $this->update($id, $data);
    }

    public function isSlotOccupiedForEdit($labId, $date, $startTime, $endTime, $excludeSessionId)
    {
        $sql = "SELECT COUNT(*) as count 
                FROM schedule_sessions ss
                JOIN course_plans cp ON ss.course_plan_id = cp.id
                WHERE cp.laboratory_id = ? 
                AND ss.session_date = ? 
                AND ss.status != 'cancelled'
                AND ss.id != ?  -- Abaikan sesi ini sendiri
                AND (ss.start_time < ? AND ss.end_time > ?)";

        $result = $this->queryOne($sql, [$labId, $date, $excludeSessionId, $endTime, $startTime]);
        return $result['count'] > 0;
    }

    // ==========================================
    // TAMBAHAN UNTUK EXPORT JADWAL
    // ==========================================

    public function getAllPlans()
    {
        $sql = "SELECT cp.*, 
                       l.lab_name, 
                       u.name as lecturer_real_name
                FROM course_plans cp
                JOIN laboratories l ON cp.laboratory_id = l.id
                LEFT JOIN users u ON cp.lecturer_id = u.id
                ORDER BY FIELD(cp.day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), 
                         cp.start_time ASC";

        return $this->query($sql);
    }












    // --- STATISTIK DASHBOARD ---

    // 1. Ambil Jadwal Hari Ini (Real-time)
    public function getTodaySchedule()
    {
        $today = date('Y-m-d');
        $sql = "SELECT s.*, cp.course_name, cp.class_code, cp.lecturer_name, l.lab_name 
                FROM schedule_sessions s
                JOIN course_plans cp ON s.course_plan_id = cp.id
                JOIN laboratories l ON cp.laboratory_id = l.id
                WHERE s.session_date = :today
                ORDER BY s.start_time ASC";
        return $this->query($sql, ['today' => $today]);
    }

    // 2. Statistik Kesibukan Lab (Untuk Grafik Bar)
    public function getLabUtilizationStats()
    {
        $sql = "SELECT l.lab_name, COUNT(cp.id) as total_courses
                FROM laboratories l
                LEFT JOIN course_plans cp ON l.id = cp.laboratory_id
                GROUP BY l.id
                ORDER BY total_courses DESC
                LIMIT 5";
        return $this->query($sql);
    }

    // 3. Statistik Beban Harian (Untuk Grafik Line/Area)
    public function getDailyLoadStats()
    {
        // Menghitung jumlah kelas per hari
        $sql = "SELECT day, COUNT(id) as total 
                FROM course_plans 
                GROUP BY day 
                ORDER BY FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')";
        return $this->query($sql);
    }
}