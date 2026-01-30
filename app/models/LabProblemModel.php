<?php

/**
 * ICLABS - Lab Problem Model (Fixed Version)
 */
class LabProblemModel extends Model
{
    protected $table = 'lab_problems';

    // 1. Ambil semua masalah dengan detail lengkap (Admin & Koordinator)
    // Cari method getAllWithDetails
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
                       assigned.name as assigned_to_name
                FROM lab_problems p 
                JOIN laboratories l ON p.laboratory_id = l.id 
                JOIN users u ON p.reported_by = u.id 
                LEFT JOIN users assigned ON p.assigned_to = assigned.id
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
                       assigned.name as assigned_to_name
                FROM lab_problems p 
                JOIN laboratories l ON p.laboratory_id = l.id 
                JOIN users u ON p.reported_by = u.id 
                LEFT JOIN users assigned ON p.assigned_to = assigned.id
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

    /**
     * Get filtered and paginated problems
     * 
     * @param string $statusFilter - 'all', 'active', 'reported', 'in_progress', 'resolved'
     * @param string $search - search keyword
     * @param int $page - current page number
     * @param int $perPage - items per page (default: 10)
     * @return array
     */
    public function getFilteredProblems($statusFilter = 'active', $search = '', $page = 1, $perPage = 10)
    {
        $offset = ($page - 1) * $perPage;
        $searchTerm = '%' . $search . '%';

        // Build WHERE clause and params
        list($whereStatus, $statusParams) = $this->buildStatusFilter($statusFilter);

        // Build search WHERE clause - use 3 different placeholders
        $searchWhere = '';
        $searchParams = [];
        if (!empty($search)) {
            $searchWhere = " AND (u.name LIKE :searchName OR p.pc_number LIKE :searchPC OR l.lab_name LIKE :searchLab)";
            $searchParams[':searchName'] = $searchTerm;
            $searchParams[':searchPC'] = $searchTerm;
            $searchParams[':searchLab'] = $searchTerm;
        }

        // Merge all params
        $countParams = array_merge($statusParams, $searchParams);

        // Count total records
        $countSql = "SELECT COUNT(*) as total
                     FROM lab_problems p
                     JOIN laboratories l ON p.laboratory_id = l.id
                     JOIN users u ON p.reported_by = u.id
                     WHERE {$whereStatus}{$searchWhere}";

        $countResult = $this->queryOne($countSql, $countParams);
        $total = $countResult['total'];

        // Get paginated data
        $dataSql = "SELECT 
                        p.id,
                        p.pc_number,
                        p.problem_type,
                        p.description,
                        p.status,
                        p.reported_at,
                        p.reported_by,
                        p.assigned_to,
                        l.lab_name,
                        u.name as reporter_name,
                        u.email as reporter_email,
                        u.name as reported_by_name,
                        assigned.name as assigned_to_name
                    FROM lab_problems p
                    JOIN laboratories l ON p.laboratory_id = l.id
                    JOIN users u ON p.reported_by = u.id
                    LEFT JOIN users assigned ON p.assigned_to = assigned.id
                    WHERE {$whereStatus}{$searchWhere}
                    ORDER BY p.reported_at DESC
                    LIMIT :limit OFFSET :offset";

        $dataParams = array_merge($statusParams, $searchParams);
        $dataParams[':limit'] = (int)$perPage;
        $dataParams[':offset'] = (int)$offset;

        $data = $this->query($dataSql, $dataParams);

        return [
            'data' => $data,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => ceil($total / $perPage)
        ];
    }

    /**
     * Build status filter WHERE clause
     * @return array [sql_string, params_array]
     */
    private function buildStatusFilter($statusFilter)
    {
        switch ($statusFilter) {
            case 'all':
                return ['1=1', []]; // No filter
            case 'active':
                return ["p.status IN ('reported', 'in_progress')", []];
            case 'reported':
                return ["p.status = :filterStatus", [':filterStatus' => 'reported']];
            case 'in_progress':
                return ["p.status = :filterStatus", [':filterStatus' => 'in_progress']];
            case 'resolved':
                return ["p.status = :filterStatus", [':filterStatus' => 'resolved']];
            default:
                return ["p.status IN ('reported', 'in_progress')", []]; // Default to active
        }
    }

    /**
     * Delete problem with cascading history deletion
     * 
     * @param int $problemId Problem ID to delete
     * @param object $historyModel ProblemHistoryModel instance
     * @return bool True on success, false on failure
     */
    public function deleteProblemWithHistory($problemId, $historyModel = null)
    {
        // Delete histories if model provided
        if ($historyModel !== null) {
            try {
                $histories = $historyModel->getHistoryByProblem($problemId);
                foreach ($histories as $history) {
                    $historyModel->delete($history['id']);
                }
            } catch (Exception $e) {
                // History table doesn't exist or error, skip
            }
        }
        
        // Delete problem
        return $this->deleteProblem($problemId);
    }
}