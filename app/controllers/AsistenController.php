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

        $this->view('asisten/jobdesk', $data);
    }

    public function updateTaskStatus($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = sanitize($this->getPost('status'));
            $note = sanitize($this->getPost('note'));

            $problemModel = $this->model('LabProblemModel');
            $historyModel = $this->model('ProblemHistoryModel');

            // Update status & timestamp
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

        $data = [
            'problems' => $problemModel->getAllWithDetails(),
            'laboratories' => $laboratoryModel->getAllLaboratories()
        ];

        $this->view('asisten/problems', $data);
    }

    public function createProblem()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'laboratory_id' => sanitize($this->getPost('laboratory_id')),
                'pc_number' => sanitize($this->getPost('pc_number')),
                'problem_type' => sanitize($this->getPost('problem_type')),
                'description' => sanitize($this->getPost('description'))
            ];

            if (empty($data['laboratory_id']) || empty($data['description'])) {
                setFlash('danger', 'Mohon lengkapi data laporan.');
                $this->redirect('/asisten/problems');
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
        $userId = getUserId();

        $data = [
            'mySchedules' => $scheduleModel->getSchedulesByUser($userId)
        ];

        $this->view('asisten/assistant-schedules', $data);
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

        $this->view('asisten/edit-problem', $data);
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
