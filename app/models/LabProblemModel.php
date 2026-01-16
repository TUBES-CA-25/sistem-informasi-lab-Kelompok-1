<?php
class LabProblemModel extends Model
{
    protected $table = 'lab_problems';

    // Ambil semua masalah dengan detail lengkap (Untuk Page Permasalahan Lab)
    public function getAllWithDetails()
    {
        $sql = "SELECT p.*, 
                       l.lab_name, 
                       u.name as reporter_name,
                       u.email as reporter_email,
                       pj.name as pj_name
                FROM lab_problems p 
                JOIN laboratories l ON p.laboratory_id = l.id 
                JOIN users u ON p.reported_by = u.id 
                LEFT JOIN users pj ON p.assigned_to = pj.id
                ORDER BY p.reported_at DESC";
        return $this->query($sql);
    }

    // KHUSUS JOBDESK: Ambil masalah yang ditugaskan ke User ID tertentu
    public function getTasksByAssignee($userId)
    {
        $sql = "SELECT p.*, 
                       l.lab_name, 
                       u.name as reporter_name,
                       pj.name as pj_name
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

    public function getProblemWithDetails($id)
    {
        $sql = "SELECT p.*, 
                       l.lab_name, l.location,
                       u.name as reporter_name,
                       u.email as reporter_email,
                       pj.name as pj_name
                FROM lab_problems p 
                JOIN laboratories l ON p.laboratory_id = l.id 
                JOIN users u ON p.reported_by = u.id 
                LEFT JOIN users pj ON p.assigned_to = pj.id
                WHERE p.id = ?";
        return $this->queryOne($sql, [$id]);
    }

    // CRUD Create
    public function createProblem($data)
    {
        $data['reported_by'] = getUserId();
        $data['reported_at'] = date('Y-m-d H:i:s');
        $data['status'] = 'reported';
        return $this->insert($data);
    }

    // CRUD Update
    public function updateProblem($id, $data)
    {
        return $this->update($id, $data);
    }

    // CRUD Delete
    public function deleteProblem($id)
    {
        return $this->delete($id);
    }

    // Update Status Jobdesk (Start/Complete) dengan Timestamp Otomatis
    public function updateTaskProgress($id, $status)
    {
        $data = ['status' => $status];

        // Logika otomatis isi tanggal
        if ($status == 'in_progress') {
            $data['started_at'] = date('Y-m-d H:i:s');
        } elseif ($status == 'resolved') {
            $data['completed_at'] = date('Y-m-d H:i:s');
        }

        return $this->update($id, $data);
    }

    public function getProblemsByReporter($userId)
    {
        $sql = "SELECT p.*, l.lab_name FROM lab_problems p JOIN laboratories l ON p.laboratory_id = l.id WHERE p.reported_by = ? ORDER BY p.reported_at DESC";
        return $this->query($sql, [$userId]);
    }

    public function getProblemsByStatus($status)
    {
        $sql = "SELECT p.*, l.lab_name, u.name as reporter_name FROM lab_problems p JOIN laboratories l ON p.laboratory_id = l.id JOIN users u ON p.reported_by = u.id WHERE p.status = ? ORDER BY p.reported_at DESC";
        return $this->query($sql, [$status]);
    }

    public function getStatistics()
    {
        $sql = "SELECT COUNT(*) as total, SUM(CASE WHEN status = 'reported' THEN 1 ELSE 0 END) as reported, SUM(CASE WHEN status = 'in_progress' THEN 1 ELSE 0 END) as in_progress, SUM(CASE WHEN status = 'resolved' THEN 1 ELSE 0 END) as resolved FROM lab_problems";
        return $this->queryOne($sql);
    }
}
