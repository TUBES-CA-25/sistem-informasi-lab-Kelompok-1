<?php

/**
 * ICLABS - Koordinator Controller
 * Handles koordinator role operations
 */

class KoordinatorController extends Controller
{

    public function __construct()
    {
        $this->requireRole('koordinator');
    }

    // ==========================================
    // DASHBOARD
    // ==========================================
    public function dashboard()
    {
        $problemModel = $this->model('LabProblemModel');
        $statistics = $problemModel->getStatistics();

        $data = [
            'statistics' => $statistics,
            'pendingProblems' => $problemModel->getPendingProblems(),
            'userName' => getUserName()
        ];

        $this->view('koordinator/dashboard', $data);
    }

    // ==========================================
    // JADWAL PIKET (Assistant Schedules)
    // ==========================================
    public function listAssistantSchedules()
    {
        $scheduleModel = $this->model('AssistantScheduleModel');

        $data = [
            'schedules' => $scheduleModel->getAllWithDetails() // Method ini yang tadi error
        ];

        // Kita gunakan view yang sama dengan admin atau buat view khusus koordinator
        // Disini saya arahkan ke view koordinator (kita buat di langkah 3)
        $this->view('koordinator/assistant-schedules', $data);
    }

    // ==========================================
    // DATA LABORATORIUM
    // ==========================================
    public function listLaboratories()
    {
        $labModel = $this->model('LaboratoryModel');
        $data = [
            'laboratories' => $labModel->getAllLaboratories()
        ];
        $this->view('koordinator/laboratories', $data);
    }

    // ==========================================
    // KEGIATAN LAB (Activities)
    // ==========================================
    public function listActivities()
    {
        $activityModel = $this->model('LabActivityModel');
        $data = [
            'activities' => $activityModel->getAllActivities()
        ];
        $this->view('koordinator/activities', $data);
    }

    // ==========================================
    // PERMASALAHAN LAB (Problems)
    // ==========================================
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
        $problem = $problemModel->getProblemWithDetails($id);

        if (!$problem) {
            setFlash('danger', 'Problem not found');
            $this->redirect('/koordinator/problems');
        }

        $data = [
            'problem' => $problem,
            'histories' => $historyModel->getHistoryByProblem($id)
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

        // Update problem status
        $this->model('LabProblemModel')->updateProblem($id, ['status' => $status]);
        // Add to history
        $this->model('ProblemHistoryModel')->addHistory($id, $status, $note);

        setFlash('success', 'Problem status updated successfully');
        $this->redirect('/koordinator/problems/' . $id);
    }

    // ==========================================
    // LAPORAN (Reports) - Placeholder
    // ==========================================
    public function reports()
    {
        // Logika laporan bulanan (bisa dikembangkan nanti)
        $this->view('koordinator/reports');
    }
}
