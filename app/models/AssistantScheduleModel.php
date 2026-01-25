<?php

/**
 * ICLABS - Assistant Schedule Model
 * Updated: Menghapus referensi start_time/end_time sesuai struktur DB baru
 */

class AssistantScheduleModel extends Model
{
    protected $table = 'assistant_schedules';

    /**
     * Ambil semua jadwal dengan detail user (nama asisten)
     * Digunakan oleh: AdminController (listAssistantSchedules)
     */
    public function getAllWithUser()
    {
        // HAPUS: s.start_time dari ORDER BY
        $sql = "SELECT s.*, u.name as assistant_name, u.email 
                FROM assistant_schedules s 
                JOIN users u ON s.user_id = u.id 
                ORDER BY FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')";
        return $this->query($sql);
    }

    /**
     * Alias method untuk kompatibilitas
     * Digunakan oleh: KoordinatorController (listAssistantSchedules)
     */
    public function getAllWithDetails()
    {
        return $this->getAllWithUser();
    }

    /**
     * Ambil jadwal spesifik user
     * Digunakan oleh: AsistenController (listAssistantSchedules)
     */
    public function getSchedulesByUser($userId)
    {
        // HAPUS: s.start_time dari ORDER BY
        $sql = "SELECT s.* FROM assistant_schedules s 
                WHERE s.user_id = ? 
                ORDER BY FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')";
        return $this->query($sql, [$userId]);
    }

    /**
     * Get schedules by specific day
     */
    public function getSchedulesByDay($day)
    {
        // GANTI ORDER BY: Dari start_time menjadi nama asisten (u.name)
        $sql = "SELECT s.*, u.name as assistant_name, u.email 
                FROM assistant_schedules s 
                JOIN users u ON s.user_id = u.id 
                WHERE s.day = ?
                ORDER BY u.name ASC";
        return $this->query($sql, [$day]);
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
