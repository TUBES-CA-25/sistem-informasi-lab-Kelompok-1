<?php
/**
 * ICLABS - Koordinator Controller
 * Handles koordinator role operations
 */

class KoordinatorController extends Controller {
    
    public function __construct() {
        $this->requireRole('koordinator');
    }
    
    /**
     * Koordinator dashboard
     */
    public function dashboard() {
        $problemModel = $this->model('LabProblemModel');
        
        $statistics = $problemModel->getStatistics();
        
        $data = [
            'statistics' => $statistics,
            'pendingProblems' => $problemModel->getPendingProblems(),
            'userName' => getUserName()
        ];
        
        $this->view('koordinator/dashboard', $data);
    }
    
    /**
     * List all problems
     */
    public function listProblems() {
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
    
    /**
     * View problem detail
     */
    public function viewProblem($id) {
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
    
    /**
     * Update problem status
     */
    public function updateProblemStatus($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/koordinator/problems/' . $id);
        }
        
        $status = sanitize($this->getPost('status'));
        $note = sanitize($this->getPost('note'));
        
        if (empty($status)) {
            setFlash('danger', 'Status is required');
            $this->redirect('/koordinator/problems/' . $id);
        }
        
        // Update problem status
        $problemModel = $this->model('LabProblemModel');
        $problemModel->updateProblem($id, ['status' => $status]);
        
        // Add to history
        $historyModel = $this->model('ProblemHistoryModel');
        $historyModel->addHistory($id, $status, $note);
        
        setFlash('success', 'Problem status updated successfully');
        $this->redirect('/koordinator/problems/' . $id);
    }
}
