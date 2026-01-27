<?php

/**
 * ICLABS - Asisten Controller (Updated)
 * Features: Dashboard, Jobdesk, Problems CRUD, Schedules
 */

class AsistenController extends Controller
{

    public function __construct()
    {
        $this->requireRole('asisten');
    }

    public function dashboard()
    {
        // Redirect ke jobdesk agar Asisten langsung fokus kerja
        $this->redirect('/asisten/jobdesk');
    }

    // ==========================================
    // PAGE 1: JOBDESK SAYA (Tugas Maintenance)
    // ==========================================

    public function jobdesk()
    {
        $problemModel = $this->model('LabProblemModel');
        $userId = getUserId();

        $data = [
            'myTasks' => $problemModel->getTasksByAssignee($userId)
        ];

        $this->view('asisten/jobdesk/index', $data);
    }

    public function editTaskForm($id)
    {
        $problemModel = $this->model('LabProblemModel');
        $task = $problemModel->findWithDetails($id);

        if (!$task) {
            setFlash('danger', 'Task tidak ditemukan.');
            $this->redirect('/asisten/jobdesk');
        }

        $data = [
            'task' => $task
        ];

        $this->view('asisten/jobdesk/edit', $data);
    }

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

    public function problems()
    {
        $problemModel = $this->model('LabProblemModel');
        $laboratoryModel = $this->model('LaboratoryModel');

        // Get filter parameters
        $statusFilter = $this->getQuery('status') ?? 'active';
        $search = $this->getQuery('search') ?? '';
        $page = (int)($this->getQuery('page') ?? 1);

        // Validate
        $validStatuses = ['all', 'active', 'reported', 'in_progress', 'resolved'];
        if (!in_array($statusFilter, $validStatuses)) {
            $statusFilter = 'active';
        }
        if ($page < 1) {
            $page = 1;
        }

        // Get filtered data
        $result = $problemModel->getFilteredProblems($statusFilter, $search, $page, 10);

        $data = [
            'problems' => $result['data'],
            'pagination' => [
                'current' => $result['page'],
                'total' => $result['totalPages'],
                'perPage' => $result['perPage'],
                'totalRecords' => $result['total']
            ],
            'filters' => [
                'status' => $statusFilter,
                'search' => $search
            ],
            'laboratories' => $laboratoryModel->getAllLaboratories()
        ];

        $this->view('asisten/reports/index', $data);
    }

    public function createProblemForm()
    {
        $laboratoryModel = $this->model('LaboratoryModel');
        
        $data = [
            'laboratories' => $laboratoryModel->getAllLaboratories()
        ];

        $this->view('asisten/reports/create', $data);
    }

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

            if (empty($data['laboratory_id']) || empty($data['description'])) {
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

    public function deleteProblem($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Optional: Tambahkan pengecekan apakah laporan ini milik user yg login
            $this->model('LabProblemModel')->deleteProblem($id);
            setFlash('success', 'Laporan masalah dihapus.');
            $this->redirect('/asisten/problems');
        }
    }

    // ==========================================
    // PAGE 3: JADWAL PIKET
    // ==========================================

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
