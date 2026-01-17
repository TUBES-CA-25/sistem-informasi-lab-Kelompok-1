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
     * List all problems with filter & pagination
     */
    public function listProblems()
    {
        $problemModel = $this->model('LabProblemModel');
        
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
            ]
        ];
        
        $this->view('koordinator/problems', $data);
    }
    
    /**
     * Show create problem form
     */
    public function createProblemForm()
    {
        $laboratoryModel = $this->model('LaboratoryModel');
        
        $data = [
            'laboratories' => $laboratoryModel->getAllLaboratories()
        ];
        
        $this->view('koordinator/create-problem', $data);
    }
    
    /**
     * Store new problem
     */
    public function createProblem()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/koordinator/problems/create');
        }
        
        $data = [
            'laboratory_id' => sanitize($this->getPost('laboratory_id')),
            'pc_number' => sanitize($this->getPost('pc_number')),
            'reporter_name' => sanitize($this->getPost('reporter_name')),
            'problem_type' => sanitize($this->getPost('problem_type')),
            'description' => sanitize($this->getPost('description'))
        ];
        
        if (empty($data['laboratory_id']) || empty($data['description']) || empty($data['reporter_name'])) {
            setFlash('danger', 'Mohon lengkapi data laporan.');
            $this->redirect('/koordinator/problems/create');
        }
        
        $problemModel = $this->model('LabProblemModel');
        $problemId = $problemModel->createProblem($data);
        
        // Add history
        $historyModel = $this->model('ProblemHistoryModel');
        $historyModel->addHistory($problemId, 'reported', 'Laporan dibuat oleh Koordinator');
        
        setFlash('success', 'Laporan masalah berhasil ditambahkan.');
        $this->redirect('/koordinator/problems');
    }
    
    /**
     * View problem detail
     */
    public function viewProblem($id) {
        $problemModel = $this->model('LabProblemModel');
        $historyModel = $this->model('ProblemHistoryModel');
        $userModel = $this->model('UserModel');
        
        $problem = $problemModel->getProblemWithDetails($id);
        
        if (!$problem) {
            setFlash('danger', 'Problem not found');
            $this->redirect('/koordinator/problems');
        }
        
        $data = [
            'problem' => $problem,
            'histories' => $historyModel->getHistoryByProblem($id),
            'assistants' => $userModel->getUsersByRoleName('asisten')
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
    
    /**
     * Show edit problem form
     */
    public function editProblemForm($id)
    {
        $problemModel = $this->model('LabProblemModel');
        $laboratoryModel = $this->model('LaboratoryModel');
        
        $problem = $problemModel->find($id);
        
        if (!$problem) {
            setFlash('danger', 'Problem not found');
            $this->redirect('/koordinator/problems');
        }
        
        $data = [
            'problem' => $problem,
            'laboratories' => $laboratoryModel->getAllLaboratories()
        ];
        
        $this->view('koordinator/edit-problem', $data);
    }
    
    /**
     * Update problem data
     */
    public function updateProblem($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/koordinator/problems/' . $id . '/edit');
        }
        
        $data = [
            'laboratory_id' => sanitize($this->getPost('laboratory_id')),
            'pc_number' => sanitize($this->getPost('pc_number')),
            'problem_type' => sanitize($this->getPost('problem_type')),
            'description' => sanitize($this->getPost('description')),
            'status' => sanitize($this->getPost('status'))
        ];
        
        $problemModel = $this->model('LabProblemModel');
        $problemModel->updateProblem($id, $data);
        
        // Add history
        $historyModel = $this->model('ProblemHistoryModel');
        $historyModel->addHistory($id, $data['status'], 'Problem updated by Koordinator');
        
        setFlash('success', 'Problem updated successfully');
        $this->redirect('/koordinator/problems/' . $id);
    }
    
    /**
     * Delete problem
     */
    public function deleteProblem($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/koordinator/problems');
        }
        
        $problemModel = $this->model('LabProblemModel');
        $problemModel->deleteProblem($id);
        
        setFlash('success', 'Problem deleted successfully');
        $this->redirect('/koordinator/problems');
    }
    
    /**
     * Assign problem to assistant
     */
    public function assignProblem($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/koordinator/problems/' . $id);
        }
        
        $assignedTo = sanitize($this->getPost('assigned_to'));
        
        if (empty($assignedTo)) {
            setFlash('danger', 'Please select an assistant');
            $this->redirect('/koordinator/problems/' . $id);
        }
        
        // Update assigned_to
        $problemModel = $this->model('LabProblemModel');
        $problemModel->updateProblem($id, ['assigned_to' => $assignedTo]);
        
        // Get assignee name
        $userModel = $this->model('UserModel');
        $assignee = $userModel->find($assignedTo);
        
        // Add to history
        $historyModel = $this->model('ProblemHistoryModel');
        $historyModel->addHistory($id, 'reported', 'Ditugaskan kepada: ' . $assignee['name']);
        
        setFlash('success', 'Task berhasil diberikan kepada asisten.');
        $this->redirect('/koordinator/problems/' . $id);
    }
    
    /**
     * List all assistant schedules with grid view & filter
     */
    public function listAssistantSchedules() {
        $scheduleModel = $this->model('AssistantScheduleModel');
        $userModel = $this->model('UserModel');
        
        // Get filter
        $view = $this->getQuery('view') ?? 'grid';
        $filter = $this->getQuery('filter') ?? 'all';
        
        // Get schedules based on filter
        if ($filter == 'today') {
            $schedules = $scheduleModel->getSchedulesByDay(date('l'));
        } else {
            $schedules = $scheduleModel->getAllWithUser();
        }
        
        // Get assistants for filters/forms
        $assistants = $userModel->getUsersByRoleName('asisten');
        
        // Transform to grid format if needed
        $gridData = [];
        if ($view == 'grid') {
            $gridData = $this->transformToGrid($schedules);
        }
        
        $data = [
            'schedules' => $schedules,
            'gridData' => $gridData,
            'assistants' => $assistants,
            'currentView' => $view,
            'currentFilter' => $filter
        ];
        
        $this->view('koordinator/assistant-schedules', $data);
    }
    
    /**
     * Transform schedules to grid format (tasks × days)
     */
    private function transformToGrid($schedules) {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $grid = [];
        
        // Group by task
        foreach ($schedules as $schedule) {
            $taskKey = $schedule['start_time'] . '-' . $schedule['end_time'];
            if (!isset($grid[$taskKey])) {
                $grid[$taskKey] = [
                    'time' => $schedule['start_time'] . ' - ' . $schedule['end_time'],
                    'days' => array_fill_keys($days, null)
                ];
            }
            $grid[$taskKey]['days'][$schedule['day']] = $schedule;
        }
        
        return $grid;
    }
    
    /**
     * Show create schedule form
     */
    public function createScheduleForm()
    {
        $userModel = $this->model('UserModel');
        
        $data = [
            'assistants' => $userModel->getUsersByRoleName('asisten')
        ];
        
        $this->view('koordinator/create-schedule', $data);
    }
    
    /**
     * Store new schedule
     */
    public function createSchedule()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/koordinator/assistant-schedules');
        }
        
        $data = [
            'user_id' => sanitize($this->getPost('user_id')),
            'day' => sanitize($this->getPost('day')),
            'start_time' => sanitize($this->getPost('start_time')),
            'end_time' => sanitize($this->getPost('end_time')),
            'task_description' => sanitize($this->getPost('task_description'))
        ];
        
        if (empty($data['user_id']) || empty($data['day']) || empty($data['start_time']) || empty($data['end_time'])) {
            setFlash('danger', 'Mohon lengkapi semua field yang wajib diisi.');
            $this->redirect('/koordinator/assistant-schedules/create');
        }
        
        $scheduleModel = $this->model('AssistantScheduleModel');
        $scheduleModel->createSchedule($data);
        
        setFlash('success', 'Jadwal piket berhasil ditambahkan.');
        $this->redirect('/koordinator/assistant-schedules');
    }
    
    /**
     * Show edit schedule form
     */
    public function editScheduleForm($id)
    {
        $scheduleModel = $this->model('AssistantScheduleModel');
        $userModel = $this->model('UserModel');
        
        $schedule = $scheduleModel->find($id);
        
        if (!$schedule) {
            setFlash('danger', 'Jadwal tidak ditemukan');
            $this->redirect('/koordinator/assistant-schedules');
        }
        
        $data = [
            'schedule' => $schedule,
            'assistants' => $userModel->getUsersByRoleName('asisten')
        ];
        
        $this->view('koordinator/edit-schedule', $data);
    }
    
    /**
     * Update schedule
     */
    public function updateSchedule($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/koordinator/assistant-schedules');
        }
        
        $data = [
            'user_id' => sanitize($this->getPost('user_id')),
            'day' => sanitize($this->getPost('day')),
            'start_time' => sanitize($this->getPost('start_time')),
            'end_time' => sanitize($this->getPost('end_time')),
            'task_description' => sanitize($this->getPost('task_description'))
        ];
        
        $scheduleModel = $this->model('AssistantScheduleModel');
        $scheduleModel->updateSchedule($id, $data);
        
        setFlash('success', 'Jadwal piket berhasil diupdate.');
        $this->redirect('/koordinator/assistant-schedules');
    }
    
    /**
     * Delete schedule
     */
    public function deleteSchedule($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/koordinator/assistant-schedules');
        }
        
        $scheduleModel = $this->model('AssistantScheduleModel');
        $scheduleModel->deleteSchedule($id);
        
        setFlash('success', 'Jadwal piket berhasil dihapus.');
        $this->redirect('/koordinator/assistant-schedules');
    }
    
    /**
     * List all laboratories with enhanced view
     */
    public function listLaboratories() {
        $laboratoryModel = $this->model('LaboratoryModel');
        
        $data = [
            'laboratories' => $laboratoryModel->getAllLaboratories()
        ];
        
        $this->view('koordinator/laboratories', $data);
    }
    
    /**
     * Show create laboratory form
     */
    public function createLaboratoryForm()
    {
        $this->view('koordinator/create-laboratory');
    }
    
    /**
     * Store new laboratory
     */
    public function createLaboratory()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/koordinator/laboratories');
        }
        
        $data = [
            'lab_name' => sanitize($this->getPost('lab_name')),
            'description' => sanitize($this->getPost('description')),
            'location' => sanitize($this->getPost('location')),
            'building' => sanitize($this->getPost('building')),
            'floor' => sanitize($this->getPost('floor')),
            'room_number' => sanitize($this->getPost('room_number')),
            'pc_count' => (int)sanitize($this->getPost('pc_count')),
            'capacity' => (int)sanitize($this->getPost('capacity')),
            'status' => sanitize($this->getPost('status'))
        ];
        
        if (empty($data['lab_name'])) {
            setFlash('danger', 'Nama laboratorium harus diisi.');
            $this->redirect('/koordinator/laboratories/create');
        }
        
        $laboratoryModel = $this->model('LaboratoryModel');
        $laboratoryModel->createLaboratory($data);
        
        setFlash('success', 'Laboratorium berhasil ditambahkan.');
        $this->redirect('/koordinator/laboratories');
    }
    
    /**
     * Show edit laboratory form
     */
    public function editLaboratoryForm($id)
    {
        $laboratoryModel = $this->model('LaboratoryModel');
        
        $lab = $laboratoryModel->getLaboratory($id);
        
        if (!$lab) {
            setFlash('danger', 'Laboratorium tidak ditemukan');
            $this->redirect('/koordinator/laboratories');
        }
        
        $data = ['laboratory' => $lab];
        
        $this->view('koordinator/edit-laboratory', $data);
    }
    
    /**
     * Update laboratory
     */
    public function updateLaboratory($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/koordinator/laboratories');
        }
        
        $data = [
            'lab_name' => sanitize($this->getPost('lab_name')),
            'description' => sanitize($this->getPost('description')),
            'location' => sanitize($this->getPost('location')),
            'building' => sanitize($this->getPost('building')),
            'floor' => sanitize($this->getPost('floor')),
            'room_number' => sanitize($this->getPost('room_number')),
            'pc_count' => (int)sanitize($this->getPost('pc_count')),
            'capacity' => (int)sanitize($this->getPost('capacity')),
            'status' => sanitize($this->getPost('status'))
        ];
        
        $laboratoryModel = $this->model('LaboratoryModel');
        $laboratoryModel->updateLaboratory($id, $data);
        
        setFlash('success', 'Laboratorium berhasil diupdate.');
        $this->redirect('/koordinator/laboratories');
    }
    
    /**
     * Delete laboratory
     */
    public function deleteLaboratory($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/koordinator/laboratories');
        }
        
        $laboratoryModel = $this->model('LaboratoryModel');
        $laboratoryModel->deleteLaboratory($id);
        
        setFlash('success', 'Laboratorium berhasil dihapus.');
        $this->redirect('/koordinator/laboratories');
    }
    
    /**
     * List all lab activities with CRUD
     */
    public function listActivities() {
        $activityModel = $this->model('LabActivityModel');
        
        $data = [
            'activities' => $activityModel->getAllActivities()
        ];
        
        $this->view('koordinator/activities', $data);
    }
    
    /**
     * Show create activity form
     */
    public function createActivityForm()
    {
        $this->view('koordinator/create-activity');
    }
    
    /**
     * Create new activity with image upload
     */
    public function createActivity()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/koordinator/activities');
        }
        
        $activityModel = $this->model('LabActivityModel');
        
        // Handle image upload
        $imagePath = null;
        if (isset($_FILES['image_cover']) && $_FILES['image_cover']['error'] === UPLOAD_ERR_OK) {
            $imagePath = $this->uploadActivityImage($_FILES['image_cover']);
            if (!$imagePath) {
                setFlash('error', 'Gagal upload gambar.');
                $this->redirect('/koordinator/activities/create');
            }
        }
        
        $data = [
            'title' => $_POST['title'] ?? '',
            'activity_type' => $_POST['activity_type'] ?? 'other',
            'activity_date' => $_POST['activity_date'] ?? date('Y-m-d'),
            'location' => $_POST['location'] ?? null,
            'description' => $_POST['description'] ?? null,
            'link_url' => $_POST['link_url'] ?? null,
            'status' => $_POST['status'] ?? 'draft',
            'image_cover' => $imagePath
        ];
        
        $activityModel->createActivity($data);
        
        setFlash('success', 'Kegiatan berhasil ditambahkan.');
        $this->redirect('/koordinator/activities');
    }
    
    /**
     * Show edit activity form
     */
    public function editActivityForm($id)
    {
        $activityModel = $this->model('LabActivityModel');
        $activity = $activityModel->find($id);
        
        if (!$activity) {
            setFlash('error', 'Kegiatan tidak ditemukan.');
            $this->redirect('/koordinator/activities');
        }
        
        $data = ['activity' => $activity];
        $this->view('koordinator/edit-activity', $data);
    }
    
    /**
     * Update activity with optional new image
     */
    public function updateActivity($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/koordinator/activities');
        }
        
        $activityModel = $this->model('LabActivityModel');
        $activity = $activityModel->find($id);
        
        if (!$activity) {
            setFlash('error', 'Kegiatan tidak ditemukan.');
            $this->redirect('/koordinator/activities');
        }
        
        // Handle image upload
        $imagePath = $activity['image_cover']; // Keep existing image
        if (isset($_FILES['image_cover']) && $_FILES['image_cover']['error'] === UPLOAD_ERR_OK) {
            $newImagePath = $this->uploadActivityImage($_FILES['image_cover']);
            if ($newImagePath) {
                // Delete old image if exists
                if ($imagePath && file_exists(PUBLIC_PATH . $imagePath)) {
                    unlink(PUBLIC_PATH . $imagePath);
                }
                $imagePath = $newImagePath;
            }
        }
        
        $data = [
            'title' => $_POST['title'] ?? $activity['title'],
            'activity_type' => $_POST['activity_type'] ?? $activity['activity_type'],
            'activity_date' => $_POST['activity_date'] ?? $activity['activity_date'],
            'location' => $_POST['location'] ?? $activity['location'],
            'description' => $_POST['description'] ?? $activity['description'],
            'link_url' => $_POST['link_url'] ?? $activity['link_url'],
            'status' => $_POST['status'] ?? $activity['status'],
            'image_cover' => $imagePath
        ];
        
        $activityModel->updateActivity($id, $data);
        
        setFlash('success', 'Kegiatan berhasil diupdate.');
        $this->redirect('/koordinator/activities');
    }
    
    /**
     * Delete activity and its image
     */
    public function deleteActivity($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/koordinator/activities');
        }
        
        $activityModel = $this->model('LabActivityModel');
        $activity = $activityModel->find($id);
        
        if ($activity) {
            // Delete image file if exists
            if ($activity['image_cover'] && file_exists(PUBLIC_PATH . $activity['image_cover'])) {
                unlink(PUBLIC_PATH . $activity['image_cover']);
            }
            
            $activityModel->deleteActivity($id);
            setFlash('success', 'Kegiatan berhasil dihapus.');
        } else {
            setFlash('error', 'Kegiatan tidak ditemukan.');
        }
        
        $this->redirect('/koordinator/activities');
    }
    
    /**
     * Upload activity image
     */
    private function uploadActivityImage($file)
    {
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $maxSize = 5 * 1024 * 1024; // 5MB
        
        // Validate file type
        if (!in_array($file['type'], $allowedTypes)) {
            return false;
        }
        
        // Validate file size
        if ($file['size'] > $maxSize) {
            return false;
        }
        
        // Create upload directory if not exists
        $uploadDir = PUBLIC_PATH . '/uploads/activities/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('activity_') . '.' . $extension;
        $filepath = $uploadDir . $filename;
        
        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            return '/uploads/activities/' . $filename;
        }
        
        return false;
    }
}
