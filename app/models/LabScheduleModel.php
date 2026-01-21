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
        $sql = "SELECT cp.*, l.lab_name 
                FROM course_plans cp 
                JOIN laboratories l ON cp.laboratory_id = l.id 
                ORDER BY cp.created_at DESC";
        return $this->query($sql);
    }

    public function getScheduleDetail($id)
    {
        $sql = "SELECT cp.*, l.lab_name 
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
                       l.lab_name, cp.lecturer_photo, cp.laboratory_id 
                FROM schedule_sessions ss
                JOIN course_plans cp ON ss.course_plan_id = cp.id
                JOIN laboratories l ON cp.laboratory_id = l.id
                WHERE ss.session_date = ? 
                AND ss.status != 'cancelled'
                ORDER BY ss.start_time ASC";
        return $this->query($sql, [$today]);
    }
}
