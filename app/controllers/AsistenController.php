<?php
/**
 * ICLABS - Asisten Controller
 * Handles asisten role operations
 */

class AsistenController extends Controller {
    
    public function __construct() {
        $this->requireRole('asisten');
    }
    
    /**
     * Asisten dashboard
     */
    public function dashboard() {
        $problemModel = $this->model('LabProblemModel');
        $scheduleModel = $this->model('AssistantScheduleModel');
        
        $userId = getUserId();
        
        // Get my reports
        $myReports = $problemModel->getProblemsByReporter($userId);
        
        // Count pending reports
        $myPending = 0;
        foreach ($myReports as $report) {
            if ($report['status'] === 'reported' || $report['status'] === 'in_progress') {
                $myPending++;
            }
        }
        
        // Get my schedules
        $mySchedules = $scheduleModel->getSchedulesByUser($userId);
        
        $statistics = [
            'my_reports' => count($myReports),
            'my_pending' => $myPending,
            'my_schedules' => count($mySchedules)
        ];
        
        $data = [
            'myReports' => array_slice($myReports, 0, 10), // Latest 10
            'recentProblems' => array_slice($myReports, 0, 10), // For table
            'statistics' => $statistics,
            'userName' => getUserName()
        ];
        
        $this->view('asisten/dashboard', $data);
    }
    
    /**
     * Submit problem report
     */
    public function reportProblem() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/asisten/problems?tab=lapor');
        }
        
        $data = [
            'laboratory_id' => sanitize($this->getPost('laboratory_id')),
            'pc_number' => sanitize($this->getPost('pc_number')),
            'problem_type' => sanitize($this->getPost('problem_type')),
            'description' => sanitize($this->getPost('description'))
        ];
        
        // Validate
        $errors = $this->validate($data, [
            'laboratory_id' => 'required',
            'problem_type' => 'required',
            'description' => 'required|min:10'
        ]);
        
        if (!empty($errors)) {
            setFlash('danger', 'Please fill all required fields correctly');
            $this->redirect('/asisten/problems?tab=lapor');
        }
        
        // Create problem report
        $problemModel = $this->model('LabProblemModel');
        $problemId = $problemModel->createProblem($data);
        
        // Add to history
        $historyModel = $this->model('ProblemHistoryModel');
        $historyModel->addHistory($problemId, 'reported', 'Problem reported by asisten');
        
        setFlash('success', 'Problem reported successfully');
        $this->redirect('/asisten/problems?tab=saya');
    }
    
    /**
     * List all problems (read-only for asisten)
     */
    public function listProblems() {
        $problemModel = $this->model('LabProblemModel');
        $laboratoryModel = $this->model('LaboratoryModel');
        
        $userId = getUserId();
        
        // Get filter if any
        $status = isset($_GET['status']) ? sanitize($_GET['status']) : null;
        
        if ($status) {
            $problems = $problemModel->getProblemsByStatus($status);
        } else {
            $problems = $problemModel->getAllWithDetails();
        }
        
        // Get my reports
        $myReports = $problemModel->getProblemsByReporter($userId);
        
        // Statistics
        $statistics = [
            'total' => $problemModel->count(),
            'reported' => $problemModel->countByStatus('reported'),
            'in_progress' => $problemModel->countByStatus('in_progress'),
            'resolved' => $problemModel->countByStatus('resolved')
        ];
        
        $data = [
            'problems' => $problems,
            'myReports' => $myReports,
            'statistics' => $statistics,
            'laboratories' => $laboratoryModel->getAllLaboratories()
        ];
        
        $this->view('asisten/problems', $data);
    }
}
