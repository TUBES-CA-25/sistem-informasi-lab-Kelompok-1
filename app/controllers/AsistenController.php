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
        
        $data = [
            'myReports' => $problemModel->getProblemsByReporter($userId),
            'mySchedules' => $scheduleModel->getSchedulesByUser($userId),
            'userName' => getUserName()
        ];
        
        $this->view('asisten/dashboard', $data);
    }
    
    /**
     * Show report problem form
     */
    public function reportProblemForm() {
        $laboratoryModel = $this->model('LaboratoryModel');
        
        $data = [
            'laboratories' => $laboratoryModel->getAllLaboratories()
        ];
        
        $this->view('asisten/report-problem', $data);
    }
    
    /**
     * Submit problem report
     */
    public function reportProblem() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/asisten/report-problem');
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
            $this->redirect('/asisten/report-problem');
        }
        
        // Create problem report
        $problemModel = $this->model('LabProblemModel');
        $problemId = $problemModel->createProblem($data);
        
        // Add to history
        $historyModel = $this->model('ProblemHistoryModel');
        $historyModel->addHistory($problemId, 'reported', 'Problem reported by asisten');
        
        setFlash('success', 'Problem reported successfully');
        $this->redirect('/asisten/dashboard');
    }
    
    /**
     * View my reports
     */
    public function myReports() {
        $problemModel = $this->model('LabProblemModel');
        
        $data = [
            'reports' => $problemModel->getProblemsByReporter(getUserId())
        ];
        
        $this->view('asisten/my-reports', $data);
    }
}
