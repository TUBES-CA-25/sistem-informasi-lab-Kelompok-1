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
        return $this->queryOne("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
    }

    // Ambil semua preset dikelompokkan (untuk dikirim ke View)
    public function getAllPresets()
    {
        $sql = "SELECT * FROM job_presets ORDER BY task_name ASC";
        $results = $this->query($sql);

        $grouped = [
            'Putra' => [],
            'Putri' => []
        ];

        foreach ($results as $row) {
            $grouped[$row['category']][] = $row['task_name'];
        }

        return $grouped;
    }

    // Fungsi Pintar: Cek apakah tugas sudah ada? Jika belum, simpan!
    public function saveNewPresets($category, $jobRoleString)
    {
        // Pecah string "Sapu, Pel, Masak" menjadi array
        $tasks = array_map('trim', explode(',', $jobRoleString));

        foreach ($tasks as $task) {
            if (empty($task)) continue;

            // Cek apakah sudah ada di database?
            $check = $this->queryOne("SELECT id FROM job_presets WHERE category = ? AND task_name = ?", [$category, $task]);

            // Jika BELUM ADA, Simpan!
            if (!$check) {
                $this->db->prepare("INSERT INTO job_presets (category, task_name) VALUES (?, ?)")
                    ->execute([$category, $task]);
            }
        }
    }

    /**
     * Build schedule matrix for view display
     * 
     * Transforms flat schedule array into matrix grouped by role and day
     * 
     * @param array $rawSchedules Raw schedule data from getAllWithUser()
     * @return array Matrix indexed by [role][day]
     */
    public function buildScheduleMatrix($rawSchedules)
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $matrix = [
            'Putri' => array_fill_keys($days, []),
            'Putra' => array_fill_keys($days, [])
        ];

        foreach ($rawSchedules as $row) {
            $role = $row['job_role'];
            $day = $row['day'];
            if (isset($matrix[$role][$day])) {
                $matrix[$role][$day][] = $row;
            }
        }

        return $matrix;
    }
}
