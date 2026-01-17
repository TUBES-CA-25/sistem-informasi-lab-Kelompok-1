<?php

/**
 * ICLABS - Lab Problem Model (Fixed Version)
 */
class LabProblemModel extends Model
{
    protected $table = 'lab_problems';

    // 1. Ambil semua masalah dengan detail lengkap (Admin & Koordinator)
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

    // 2. KHUSUS JOBDESK: Ambil masalah yang ditugaskan ke User ID tertentu (Asisten)
    public function getTasksByAssignee($userId)
    {
        $sql = "SELECT p.*, 
                       l.lab_name, 
                       u.name as reporter_name,
                       pj.name as pj_name
                FROM lab_problems p 
                JOIN laboratories l ON p.laboratory_id = l.id 
                JOIN users u ON p.reported_by = u.id 
                LEFT JOIN users pj ON p.assigned_to = pj.id
                WHERE p.assigned_to = ?
                ORDER BY p.status ASC, p.reported_at DESC";
        return $this->query($sql, [$userId]);
    }

    // 3. Ambil masalah berdasarkan Pelapor (Dashboard Asisten)
    public function getProblemsByReporter($userId)
    {
        $sql = "SELECT p.*, l.lab_name 
                FROM lab_problems p 
                JOIN laboratories l ON p.laboratory_id = l.id 
                WHERE p.reported_by = ? 
                ORDER BY p.reported_at DESC";
        return $this->query($sql, [$userId]);
    }

    // 4. Ambil Detail Masalah per ID
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

    // 5. Filter Masalah berdasarkan Status
    public function getProblemsByStatus($status)
    {
        $sql = "SELECT p.*, l.lab_name, u.name as reporter_name 
                FROM lab_problems p 
                JOIN laboratories l ON p.laboratory_id = l.id 
                JOIN users u ON p.reported_by = u.id 
                WHERE p.status = ? 
                ORDER BY p.reported_at DESC";
        return $this->query($sql, [$status]);
    }

    // 6. Helper: Hitung Masalah Pending (Untuk Dashboard)
    public function getPendingProblems()
    {
        $sql = "SELECT COUNT(*) as total FROM lab_problems WHERE status = 'reported'";
        $result = $this->queryOne($sql);
        return $result['total'];
    }

    // 7. Helper: Hitung Masalah by Status (Untuk Admin)
    public function countByStatus($status)
    {
        // Menggunakan method count bawaan Model framework Anda jika ada,
        // atau gunakan query manual:
        $sql = "SELECT COUNT(*) as total FROM lab_problems WHERE status = ?";
        $result = $this->queryOne($sql, [$status]);
        return $result['total'];
    }

    // 8. Statistik Lengkap
    public function getStatistics()
    {
        $sql = "SELECT COUNT(*) as total, SUM(CASE WHEN status = 'reported' THEN 1 ELSE 0 END) as reported, SUM(CASE WHEN status = 'in_progress' THEN 1 ELSE 0 END) as in_progress, SUM(CASE WHEN status = 'resolved' THEN 1 ELSE 0 END) as resolved FROM lab_problems";
        return $this->queryOne($sql);
    }

    // CRUD Operations
    public function createProblem($data)
    {
        $data['reported_by'] = getUserId();
        $data['reported_at'] = date('Y-m-d H:i:s');
        $data['status'] = 'reported';
        return $this->insert($data);
    }

    public function updateProblem($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteProblem($id)
    {
        return $this->delete($id);
    }

    public function updateTaskProgress($id, $status)
    {
        $data = ['status' => $status];
        if ($status == 'in_progress') {
            $data['started_at'] = date('Y-m-d H:i:s');
        } elseif ($status == 'resolved') {
            $data['completed_at'] = date('Y-m-d H:i:s');
        }
        return $this->update($id, $data);
    }
}
