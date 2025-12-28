<?php
/**
 * ICLABS - Lab Problem Model
 */

class LabProblemModel extends Model {
    protected $table = 'lab_problems';
    
    /**
     * Get all problems with details
     */
    public function getAllWithDetails() {
        $sql = "SELECT p.*, 
                       l.lab_name, 
                       u.name as reporter_name,
                       u.email as reporter_email
                FROM lab_problems p 
                JOIN laboratories l ON p.laboratory_id = l.id 
                JOIN users u ON p.reported_by = u.id 
                ORDER BY p.reported_at DESC";
        return $this->query($sql);
    }
    
    /**
     * Get problem by ID with details
     */
    public function getProblemWithDetails($id) {
        $sql = "SELECT p.*, 
                       l.lab_name, l.location,
                       u.name as reporter_name,
                       u.email as reporter_email
                FROM lab_problems p 
                JOIN laboratories l ON p.laboratory_id = l.id 
                JOIN users u ON p.reported_by = u.id 
                WHERE p.id = ?";
        return $this->queryOne($sql, [$id]);
    }
    
    /**
     * Get problems by reporter
     */
    public function getProblemsByReporter($userId) {
        $sql = "SELECT p.*, l.lab_name 
                FROM lab_problems p 
                JOIN laboratories l ON p.laboratory_id = l.id 
                WHERE p.reported_by = ? 
                ORDER BY p.reported_at DESC";
        return $this->query($sql, [$userId]);
    }
    
    /**
     * Get problems by status
     */
    public function getProblemsByStatus($status) {
        $sql = "SELECT p.*, l.lab_name, u.name as reporter_name 
                FROM lab_problems p 
                JOIN laboratories l ON p.laboratory_id = l.id 
                JOIN users u ON p.reported_by = u.id 
                WHERE p.status = ? 
                ORDER BY p.reported_at DESC";
        return $this->query($sql, [$status]);
    }
    
    /**
     * Get pending problems
     */
    public function getPendingProblems() {
        return $this->getProblemsByStatus('reported');
    }
    
    /**
     * Create problem report
     */
    public function createProblem($data) {
        $data['reported_by'] = getUserId();
        $data['reported_at'] = date('Y-m-d H:i:s');
        $data['status'] = 'reported';
        
        return $this->insert($data);
    }
    
    /**
     * Update problem
     */
    public function updateProblem($id, $data) {
        return $this->update($id, $data);
    }
    
    /**
     * Delete problem
     */
    public function deleteProblem($id) {
        return $this->delete($id);
    }
    
    /**
     * Count problems by status
     */
    public function countByStatus($status) {
        return $this->count(['status' => $status]);
    }
    
    /**
     * Get problem statistics
     */
    public function getStatistics() {
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'reported' THEN 1 ELSE 0 END) as reported,
                    SUM(CASE WHEN status = 'in_progress' THEN 1 ELSE 0 END) as in_progress,
                    SUM(CASE WHEN status = 'resolved' THEN 1 ELSE 0 END) as resolved
                FROM lab_problems";
        return $this->queryOne($sql);
    }
}
