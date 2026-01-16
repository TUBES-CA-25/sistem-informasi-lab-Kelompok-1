<?php

/**
 * ICLABS - Koordinator Controller
 * Full Features: Dashboard, Piket, Lab Data, Activities, Problems
 */

class KoordinatorController extends Controller
{

    public function __construct()
    {
        $this->requireRole('koordinator');
    }

    // --- DASHBOARD ---
    public function dashboard()
    {
        $problemModel = $this->model('LabProblemModel');
        $statistics = $problemModel->getStatistics();

        $data = [
            'statistics' => $statistics,
            'pendingProblems' => $problemModel->getPendingProblems(), // Ini yang tadi error
            'userName' => getUserName()
        ];
        $this->view('koordinator/dashboard', $data);
    }

    // --- MENU 1: JADWAL PIKET ---
    public function listAssistantSchedules()
    {
        $scheduleModel = $this->model('AssistantScheduleModel');
        $data = [
            'schedules' => $scheduleModel->getAllWithDetails()
        ];
        $this->view('koordinator/assistant-schedules', $data);
    }

    // --- MENU 2: DATA LAB ---
    public function listLaboratories()
    {
        $labModel = $this->model('LaboratoryModel');
        $data = [
            'laboratories' => $labModel->getAllLaboratories()
        ];
        $this->view('koordinator/laboratories', $data);
    }

    // --- MENU 3: PERMASALAHAN ---
    public function listProblems()
    {
        $problemModel = $this->model('LabProblemModel');
        $status = $this->getQuery('status');

        if ($status) {
            $problems = $problemModel->getProblemsByStatus($status);
        } else {
            $problems = $problemModel->getAllWithDetails();
        }

        $data = [
            'problems' => $problems,
            'currentStatus' => $status
        ];
        $this->view('koordinator/problems', $data);
    }

    public function viewProblem($id)
    {
        $problemModel = $this->model('LabProblemModel');
        $historyModel = $this->model('ProblemHistoryModel');
        $userModel = $this->model('UserModel'); // Load User Model

        $problem = $problemModel->getProblemWithDetails($id);

        if (!$problem) {
            setFlash('danger', 'Problem not found');
            $this->redirect('/koordinator/problems');
        }

        // Ambil daftar user dengan role 'asisten' untuk dropdown assignment
        // Kita asumsikan role_id 3 adalah asisten (sesuai seed database Anda)
        $assistants = $userModel->getUsersByRole(3);

        $data = [
            'problem' => $problem,
            'histories' => $historyModel->getHistoryByProblem($id),
            'assistants' => $assistants // Kirim data asisten ke view
        ];

        $this->view('koordinator/problem-detail', $data);
    }

    public function updateProblemStatus($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/koordinator/problems/' . $id);
        }

        $status = sanitize($this->getPost('status'));
        $note = sanitize($this->getPost('note'));

        $this->model('LabProblemModel')->updateProblem($id, ['status' => $status]);
        $this->model('ProblemHistoryModel')->addHistory($id, $status, $note);

        setFlash('success', 'Problem status updated successfully');
        $this->redirect('/koordinator/problems/' . $id);
    }

    // --- MENU 4: KEGIATAN ---
    public function listActivities()
    {
        $activityModel = $this->model('LabActivityModel');
        $data = [
            'activities' => $activityModel->getAllActivities()
        ];
        $this->view('koordinator/activities', $data);
    }

    // --- MENU 5: LAPORAN (Placeholder) ---
    public function reports()
    {
        // Anda bisa buat view sederhana untuk ini nanti
        echo "Halaman Laporan Bulanan (Coming Soon)";
    }

    public function assignProblem($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/koordinator/problems/' . $id);
        }

        $assignedTo = sanitize($this->getPost('assigned_to'));

        // Update kolom assigned_to
        $this->model('LabProblemModel')->updateProblem($id, ['assigned_to' => $assignedTo]);

        // Catat di history
        $assigneeName = $this->model('UserModel')->find($assignedTo)['name'];
        $this->model('ProblemHistoryModel')->addHistory($id, 'reported', "Ditugaskan kepada: " . $assigneeName);

        setFlash('success', 'Tugas berhasil diberikan kepada asisten.');
        $this->redirect('/koordinator/problems/' . $id);
    }
}
