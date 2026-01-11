<?php
class AsistenController extends Controller
{

    public function __construct()
    {
        $this->requireRole('asisten');
    }

    public function dashboard()
    {
        // Redirect dashboard ke jobdesk agar lebih fokus
        $this->redirect('/asisten/jobdesk');
    }

    // ==========================================
    // PAGE 1: JOBDESK SAYA (Tugas Asisten)
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
            $note = sanitize($this->getPost('note')); // Keterangan tambahan

            $problemModel = $this->model('LabProblemModel');
            $historyModel = $this->model('ProblemHistoryModel');

            // 1. Update Status & Tanggal di Tabel Masalah
            $problemModel->updateTaskProgress($id, $status);

            // 2. Catat di History (Keterangan masuk sini)
            if (!empty($note)) {
                $historyModel->addHistory($id, $status, "Update Jobdesk: " . $note);
            } else {
                $historyModel->addHistory($id, $status, "Status updated by assignee");
            }

            setFlash('success', 'Status pekerjaan berhasil diperbarui.');
            $this->redirect('/asisten/jobdesk');
        }
    }

    // ==========================================
    // PAGE 2: PERMASALAHAN LAB (CRUD)
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

            // Validasi sederhana
            if (empty($data['laboratory_id']) || empty($data['description'])) {
                setFlash('danger', 'Mohon lengkapi data laporan.');
                $this->redirect('/asisten/problems');
            }

            $this->model('LabProblemModel')->createProblem($data);
            setFlash('success', 'Laporan masalah berhasil ditambahkan.');
            $this->redirect('/asisten/problems');
        }
    }

    public function deleteProblem($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Optional: Cek apakah ini laporan milik sendiri sebelum hapus
            $this->model('LabProblemModel')->deleteProblem($id);
            setFlash('success', 'Laporan masalah dihapus.');
            $this->redirect('/asisten/problems');
        }
    }

    // Method Piket
    public function listAssistantSchedules()
    {
        // Logic untuk jadwal piket (bisa diambil dari controller sebelumnya jika ada)
        $this->redirect('/schedule'); // Placeholder jika belum ada view khusus
    }
}
