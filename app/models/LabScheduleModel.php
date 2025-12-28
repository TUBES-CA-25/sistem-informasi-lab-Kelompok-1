<?php
/**
 * ICLABS - Lab Schedule Model
 */

class LabScheduleModel extends Model {
    protected $table = 'lab_schedules';
    
    /**
     * Get all schedules with laboratory info
     */
    public function getAllWithLaboratory() {
        $sql = "SELECT ls.*, l.lab_name, l.location 
                FROM lab_schedules ls 
                JOIN laboratories l ON ls.laboratory_id = l.id 
                ORDER BY 
                    FIELD(ls.day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'),
                    ls.start_time ASC";
        return $this->query($sql);
    }
    
    /**
     * Get schedules by laboratory
     */
    public function getSchedulesByLaboratory($laboratoryId) {
        $sql = "SELECT * FROM lab_schedules 
                WHERE laboratory_id = ? 
                ORDER BY 
                    FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'),
                    start_time ASC";
        return $this->query($sql, [$laboratoryId]);
    }
    
    /**
     * Get schedules by day
     */
    public function getSchedulesByDay($day) {
        $sql = "SELECT ls.*, l.lab_name, l.location 
                FROM lab_schedules ls 
                JOIN laboratories l ON ls.laboratory_id = l.id 
                WHERE ls.day = ? 
                ORDER BY ls.start_time ASC";
        return $this->query($sql, [$day]);
    }
    
    /**
     * Get today's schedules
     */
    public function getTodaySchedules() {
        $today = date('l'); // Monday, Tuesday, etc.
        return $this->getSchedulesByDay($today);
    }
    
    /**
     * Create schedule
     */
    public function createSchedule($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
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
    
    /**
     * Count schedules
     */
    public function countSchedules() {
        return $this->count();
    }
}
