<?php

/**
 * ICLABS - Assistant Schedule Model
 */

class AssistantScheduleModel extends Model
{
    protected $table = 'assistant_schedules';

    /**
     * Ambil semua jadwal dengan detail user (nama asisten)
     * Digunakan oleh: Admin & Koordinator
     */
    public function getAllWithDetails()
    {
        $sql = "SELECT s.*, u.name as assistant_name, u.email 
                FROM assistant_schedules s 
                JOIN users u ON s.user_id = u.id 
                ORDER BY FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), s.start_time";
        return $this->query($sql);
    }

    /**
     * Ambil jadwal spesifik user
     * Digunakan oleh: Asisten (Jadwal Saya)
     */
    public function getSchedulesByUser($userId)
    {
        $sql = "SELECT s.* FROM assistant_schedules s 
                WHERE s.user_id = ? 
                ORDER BY FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), s.start_time";
        return $this->query($sql, [$userId]);
    }

    /**
     * CRUD Operations
     */
    public function createSchedule($data)
    {
        return $this->insert($data);
    }

    public function updateSchedule($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteSchedule($id)
    {
        return $this->delete($id);
    }

    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->queryOne($sql, [$id]);
    }
}
