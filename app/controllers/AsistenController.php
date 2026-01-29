<?php

/**
 * ICLABS - Asisten Controller (Updated)
 * Features: Dashboard, Jobdesk, Problems CRUD, Schedules
 */

class AsistenController extends Controller
{

    /**
     * Constructor - Ensure only asisten can access this controller
     */
    public function __construct()
    {
        $this->requireRole('asisten');
    }

    /**
     * Dashboard redirect to jobdesk page
     * 
     * Redirects asisten directly to their main work page (jobdesk)
     * 
     * @return void
     */
    public function dashboard()
    {
        // Redirect ke jobdesk agar Asisten langsung fokus kerja
        $this->redirect('/asisten/jobdesk');
    }

    // ==========================================
    // PAGE 1: JOBDESK SAYA (Tugas Maintenance)
    // ==========================================

    /**
     * Display asisten's assigned tasks (jobdesk)
     * 
     * Shows problems assigned to current asisten for maintenance
     * 
     * @return void
     */
    public function jobdesk()
    {
        $problemModel = $this->model('LabProblemModel');
        $userId = getUserId();

        $data = [
            'myTasks' => $problemModel->getTasksByAssignee($userId)
        ];

        $this->view('asisten/jobdesk/index', $data);
    }

    /**
     * Display form for editing task status
     * 
     * Loads task details for status update
     * 
     * @param int $id Task (problem) ID
     * @return void
     */
    public function editTaskForm($id)
{
    $problemModel = $this->model('LabProblemModel');
    
    $task = $problemModel->getProblemWithDetails($id);

    if (!$task) {
        setFlash('danger', 'Task tidak ditemukan.');
        $this->redirect('/asisten/jobdesk');
    }

    $data = [
        'task' => $task
    ];

    $this->view('asisten/jobdesk/edit', $data);
}

    /**
     * Update task progress status
     * 
     * Updates task status and adds history entry with notes
     * 
     * @param int $id Task (problem) ID
     * @return void Redirects to jobdesk
     */
    public function updateTaskStatus($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = sanitize($this->getPost('status'));
            $note = sanitize($this->getPost('note'));

            $problemModel = $this->model('LabProblemModel');
            $historyModel = $this->model('ProblemHistoryModel');

            // Update status and timestamp
            $problemModel->updateTaskProgress($id, $status);

            // Catat history
            $historyLog = !empty($note) ? "Update Jobdesk: " . $note : "Status updated by assignee";
            $historyModel->addHistory($id, $status, $historyLog);

            setFlash('success', 'Status pekerjaan berhasil diperbarui.');
            $this->redirect('/asisten/jobdesk');
        }
    }

    // ==========================================
    // PAGE 2: PERMASALAHAN LAB (Lapor Masalah)
    // ==========================================

    /**
     * Display paginated list of problem reports
     * 
     * Shows all lab problems with filtering capability
     * Uses helper functions for validation and pagination
     * 
     * @return void
     */
    public function problems()
    {
        $problemModel = $this->model('LabProblemModel');
        $laboratoryModel = $this->model('LaboratoryModel');

        // Validate filters using helper
        $filters = validateListFilters([
            'status' => $this->getQuery('status'),
            'search' => $this->getQuery('search'),
            'page' => $this->getQuery('page')
        ]);

        // Get filtered data
        $result = $problemModel->getFilteredProblems(
            $filters['status'], 
            $filters['search'], 
            $filters['page'], 
            10
        );

        $data = [
            'problems' => $result['data'],
            'pagination' => buildPaginationData($result),
            'filters' => [
                'status' => $filters['status'],
                'search' => $filters['search']
            ],
            'laboratories' => $laboratoryModel->getAllLaboratories()
        ];

        $this->view('asisten/reports/index', $data);
    }

    /**
     * Display form for creating new problem report
     * 
     * Loads laboratory list for dropdown selection
     * 
     * @return void
     */
    public function createProblemForm()
    {
        $laboratoryModel = $this->model('LaboratoryModel');
        
        $data = [
            'laboratories' => $laboratoryModel->getAllLaboratories()
        ];

        $this->view('asisten/reports/create', $data);
    }

    /**
     * Process and store new problem report
     * 
     * Validates required fields, creates problem record,
     * and adds initial history entry
     * 
     * @return void Redirects to problems list
     */
    public function createProblem()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'laboratory_id' => sanitize($this->getPost('laboratory_id')),
                'pc_number' => sanitize($this->getPost('pc_number')),
                'problem_type' => sanitize($this->getPost('problem_type')),
                'description' => sanitize($this->getPost('description')),
                'reported_by' => getUserId()
            ];

            if (!validateRequired($data, ['laboratory_id', 'description'])) {
                setFlash('danger', 'Mohon lengkapi data laporan.');
                $this->redirect('/asisten/problems/create');
            }

            $problemModel = $this->model('LabProblemModel');
            $problemId = $problemModel->createProblem($data);

            // Add history awal
            $this->model('ProblemHistoryModel')->addHistory($problemId, 'reported', 'Laporan baru dibuat oleh Asisten');

            setFlash('success', 'Laporan masalah berhasil ditambahkan.');
            $this->redirect('/asisten/problems');
        }
    }

    /**
     * Delete problem report
     * 
     * Validates ID and existence before deletion
     * Asisten can only delete their own reports
     * 
     * @param int $id Problem ID
     * @return void Redirects to problems list
     */
    public function deleteProblem($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/asisten/problems');
            return;
        }

        // Validate ID using helper
        if (!validateId($id)) {
            setFlash('danger', 'ID permasalahan tidak valid.');
            $this->redirect('/asisten/problems');
            return;
        }

        $problemModel = $this->model('LabProblemModel');
        
        // Cek apakah problem exists
        $problem = $problemModel->find($id);
        if (!$problem) {
            setFlash('danger', 'Laporan tidak ditemukan.');
            $this->redirect('/asisten/problems');
            return;
        }

        // Delete problem
        $result = $problemModel->deleteProblem($id);
        
        if ($result) {
            setFlash('success', 'Laporan masalah berhasil dihapus.');
        } else {
            setFlash('danger', 'Gagal menghapus laporan masalah.');
        }
        
        $this->redirect('/asisten/problems');
    }

    /**
     * Display detailed view of a specific problem
     * 
     * Shows problem details and history
     * 
     * @param int $id Problem ID
     * @return void
     */
    public function viewProblem($id)
    {
        $problemModel = $this->model('LabProblemModel');
        $historyModel = $this->model('ProblemHistoryModel'); 
        
        $problem = $problemModel->getProblemWithDetails($id);

        if (!$problem) {
            setFlash('danger', 'Laporan tidak ditemukan.');
            $this->redirect('/asisten/problems');
        }

        $data = [
            'problem' => $problem,
            'histories' => $historyModel->getHistoryByProblem($id) 
        ];

        $this->view('asisten/reports/detail', $data);
    }

    // ==========================================
    // PAGE 3: JADWAL PIKET
    // ==========================================

    /**
     * Display current asisten's schedule
     * 
     * Shows weekly schedule for logged-in asisten only
     * 
     * @return void
     */
    public function listAssistantSchedules()
    {
        $scheduleModel = $this->model('AssistantScheduleModel');
        $settingsModel = $this->model('SettingsModel');

        // 1. Ambil Semua Data Jadwal
        $rawSchedules = $scheduleModel->getAllWithUser();

        // 2. Ambil Jobdesk Global (Read Only)
        $masterJob = [
            'Putri' => $settingsModel->get('job_putri', 'Belum diatur'),
            'Putra' => $settingsModel->get('job_putra', 'Belum diatur')
        ];

        // 3. Susun Data Matriks
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $matrix = [
            'Putri' => array_fill_keys($days, []),
            'Putra' => array_fill_keys($days, [])
        ];

        foreach ($rawSchedules as $row) {
            $role = $row['job_role'];
            $day  = $row['day'];

            if (isset($matrix[$role][$day])) {
                $matrix[$role][$day][] = $row;
            }
        }

        $data = [
            'matrix' => $matrix,
            'masterJob' => $masterJob,
            'days' => $days,
            'currentUserId' => $_SESSION['user_id'] ?? 0 // Untuk highlighting
        ];

        // Pastikan folder view sesuai: views/asisten/schedules/index.php
        $this->view('asisten/schedules/index', $data);
    }

    // Form Edit Masalah
    /**
     * Display form for editing existing problem
     * 
     * Validates ownership and status before allowing edit
     * Asisten can only edit their own unresolved reports
     * 
     * @param int $id Problem ID
     * @return void
     */
    public function editProblemForm($id)
    {
        $problemModel = $this->model('LabProblemModel');
        $problem = $problemModel->find($id);

        // Validasi: Cek apakah data ada
        if (!$problem) {
            setFlash('danger', 'Laporan tidak ditemukan.');
            $this->redirect('/asisten/problems');
        }

        // Validasi: Pastikan yang mengedit adalah pemilik laporan
        if ($problem['reported_by'] != getUserId()) {
            setFlash('danger', 'Anda hanya bisa mengedit laporan Anda sendiri.');
            $this->redirect('/asisten/problems');
        }

        // Validasi Opsional: Jika status sudah resolved, tidak boleh edit
        if ($problem['status'] == 'resolved') {
            setFlash('warning', 'Laporan yang sudah selesai tidak dapat diedit.');
            $this->redirect('/asisten/problems');
        }

        $laboratoryModel = $this->model('LaboratoryModel');

        $data = [
            'problem' => $problem,
            'laboratories' => $laboratoryModel->getAllLaboratories()
        ];

        $this->view('asisten/reports/edit', $data);
    }

    // Proses Update Masalah
    /**
     * Process problem update and save changes
     * 
     * Updates problem data and adds history entry
     * 
     * @param int $id Problem ID
     * @return void Redirects to problems list
     */
    public function updateProblem($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/asisten/problems');
        }

        // Cek kepemilikan lagi untuk keamanan
        $problemModel = $this->model('LabProblemModel');
        $problem = $problemModel->find($id);
        if ($problem['reported_by'] != getUserId()) {
            $this->redirect('/asisten/problems');
        }

        $data = [
            'laboratory_id' => sanitize($this->getPost('laboratory_id')),
            'pc_number' => sanitize($this->getPost('pc_number')),
            'problem_type' => sanitize($this->getPost('problem_type')),
            'description' => sanitize($this->getPost('description'))
        ];

        if ($problemModel->updateProblem($id, $data)) {
            setFlash('success', 'Laporan berhasil diperbarui.');
        } else {
            setFlash('danger', 'Gagal memperbarui laporan.');
        }

        $this->redirect('/asisten/problems');
    }
}
