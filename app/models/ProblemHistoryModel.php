<?php
/**
 * ICLABS - Problem History Model
 */

class ProblemHistoryModel extends Model {
    protected $table = 'problem_histories';
    
    /**
     * Get history by problem
     */
    public function getHistoryByProblem($problemId) {
        $sql = "SELECT h.*, u.name as updater_name, u.email as updater_email 
                FROM problem_histories h 
                JOIN users u ON h.updated_by = u.id 
                WHERE h.problem_id = ? 
                ORDER BY h.updated_at DESC";
        return $this->query($sql, [$problemId]);
    }
    
    /**
     * Add history entry
     */
    public function addHistory($problemId, $status, $note = '') {
        $data = [
            'problem_id' => $problemId,
            'status' => $status,
            'note' => $note,
            'updated_by' => getUserId(),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        return $this->insert($data);
    }
    
    /**
     * Get latest history for problem
     */
    public function getLatestHistory($problemId) {
        $sql = "SELECT h.*, u.name as updater_name 
                FROM problem_histories h 
                JOIN users u ON h.updated_by = u.id 
                WHERE h.problem_id = ? 
                ORDER BY h.updated_at DESC 
                LIMIT 1";
        return $this->queryOne($sql, [$problemId]);
    }
}
