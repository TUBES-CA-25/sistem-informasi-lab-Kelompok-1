<?php
/**
 * ICLABS - Lab Activity Model
 */

class LabActivityModel extends Model {
    protected $table = 'lab_activities';
    
    /**
     * Get all activities with creator info
     */
    public function getAllWithCreator() {
        $sql = "SELECT a.*, u.name as creator_name 
                FROM lab_activities a 
                JOIN users u ON a.created_by = u.id 
                ORDER BY a.activity_date DESC, a.created_at DESC";
        return $this->query($sql);
    }
    
    /**
     * Get public activities (for landing page)
     */
    public function getPublicActivities($limit = 10) {
        $sql = "SELECT a.*, u.name as creator_name 
                FROM lab_activities a 
                JOIN users u ON a.created_by = u.id 
                WHERE a.status = 'published' 
                ORDER BY a.activity_date DESC 
                LIMIT ?";
        return $this->query($sql, [$limit]);
    }
    
    /**
     * Get upcoming activities
     */
    public function getUpcomingActivities() {
        $sql = "SELECT a.*, u.name as creator_name 
                FROM lab_activities a 
                JOIN users u ON a.created_by = u.id 
                WHERE a.activity_date >= CURDATE() AND a.status = 'published' 
                ORDER BY a.activity_date ASC";
        return $this->query($sql);
    }
    
    /**
     * Get activities by type
     */
    public function getActivitiesByType($type) {
        $sql = "SELECT a.*, u.name as creator_name 
                FROM lab_activities a 
                JOIN users u ON a.created_by = u.id 
                WHERE a.activity_type = ? 
                ORDER BY a.activity_date DESC";
        return $this->query($sql, [$type]);
    }
    
    /**
     * Create activity
     */
    public function createActivity($data) {
        $data['created_by'] = getUserId();
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['status'] = $data['status'] ?? 'draft';
        
        return $this->insert($data);
    }
    
    /**
     * Update activity
     */
    public function updateActivity($id, $data) {
        return $this->update($id, $data);
    }
    
    /**
     * Delete activity
     */
    public function deleteActivity($id) {
        return $this->delete($id);
    }
    
    /**
     * Count activities
     */
    public function countActivities() {
        return $this->count();
    }
    
    /**
     * Count upcoming activities
     */
    public function countUpcoming() {
        $sql = "SELECT COUNT(*) as count FROM lab_activities 
                WHERE activity_date >= CURDATE() AND status = 'published'";
        $result = $this->queryOne($sql);
        return (int) $result['count'];
    }
}
