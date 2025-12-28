<?php
/**
 * ICLABS - Assistant Schedule Model
 */

class AssistantScheduleModel extends Model {
    protected $table = 'assistant_schedules';
    
    /**
     * Get all schedules with user info
     */
    public function getAllWithUser() {
        $sql = "SELECT a.*, u.name as assistant_name, u.email 
                FROM assistant_schedules a 
                JOIN users u ON a.user_id = u.id 
                ORDER BY 
                    FIELD(a.day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'),
                    a.start_time ASC";
        return $this->query($sql);
    }
    
    /**
     * Get schedules by user
     */
    public function getSchedulesByUser($userId) {
        return $this->where('user_id', $userId);
    }
    
    /**
     * Get schedules by day
     */
    public function getSchedulesByDay($day) {
        $sql = "SELECT a.*, u.name as assistant_name 
                FROM assistant_schedules a 
                JOIN users u ON a.user_id = u.id 
                WHERE a.day = ? 
                ORDER BY a.start_time ASC";
        return $this->query($sql, [$day]);
    }
    
    /**
     * Get today's schedules
     */
    public function getTodaySchedules() {
        $today = date('l');
        return $this->getSchedulesByDay($today);
    }
    
    /**
     * Create schedule
     */
    public function createSchedule($data) {
        $data['status'] = $data['status'] ?? 'scheduled';
        return $this->insert($data);
    }
    
    /**
     * Update schedule
     */
    public function updateSchedule($id, $data) {
        return $this->update($id, $data);
    }
    
    /**
     * Delete schedule
     */
    public function deleteSchedule($id) {
        return $this->delete($id);
    }
}
