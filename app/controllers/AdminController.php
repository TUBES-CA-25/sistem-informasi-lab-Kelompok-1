<?php
/**
 * ICLABS - Admin Controller
 * Handles all admin operations (FULL CRUD)
 */

class AdminController extends Controller {
    
    public function __construct() {
        $this->requireRole('admin');
    }
    
    // ==========================================
    // DASHBOARD
    // ==========================================
    
    public function dashboard() {
        $userModel = $this->model('UserModel');
        $laboratoryModel = $this->model('LaboratoryModel');
        $scheduleModel = $this->model('LabScheduleModel');
        $problemModel = $this->model('LabProblemModel');
        $activityModel = $this->model('LabActivityModel');
        
        $roleModel = $this->model('RoleModel');
        $roles = $roleModel->getAllRoles();
        
        $statistics = [
            'total_users' => $userModel->count(),
            'total_laboratories' => $laboratoryModel->countLaboratories(),
            'total_schedules' => $scheduleModel->countSchedules(),
            'total_problems' => $problemModel->count(),
            'pending_problems' => $problemModel->countByStatus('reported'),
            'upcoming_activities' => $activityModel->countUpcoming(),
        ];
        
        // Count users by role
        foreach ($roles as $role) {
            $statistics['users_' . $role['role_name']] = $userModel->countByRole($role['id']);
        }
        
        $data = [
            'statistics' => $statistics,
            'recentProblems' => $problemModel->getAllWithDetails(),
            'userName' => getUserName()
        ];
        
        $this->view('admin/dashboard', $data);
    }
    
    // ==========================================
    // USER MANAGEMENT
    // ==========================================
    
    public function listUsers() {
        $userModel = $this->model('UserModel');
        
        $data = [
            'users' => $userModel->getAllWithRoles()
        ];
        
        $this->view('admin/users/list', $data);
    }
    
    public function createUserForm() {
        $roleModel = $this->model('RoleModel');
        
        $data = [
            'roles' => $roleModel->getAllRoles()
        ];
        
        $this->view('admin/users/create', $data);
    }
    
    public function createUser() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/users/create');
        }
        
        $data = [
            'name' => sanitize($this->getPost('name')),
            'email' => sanitize($this->getPost('email')),
            'password' => $this->getPost('password'),
            'role_id' => sanitize($this->getPost('role_id')),
            'status' => sanitize($this->getPost('status', 'active'))
        ];
        
        $errors = $this->validate($data, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'role_id' => 'required'
        ]);
        
        if (!empty($errors)) {
            setFlash('danger', 'Please fill all required fields correctly');
            $this->redirect('/admin/users/create');
        }
        
        // Check if email exists
        $userModel = $this->model('UserModel');
        if ($userModel->getByEmail($data['email'])) {
            setFlash('danger', 'Email already exists');
            $this->redirect('/admin/users/create');
        }
        
        $userModel->createUser($data);
        
        setFlash('success', 'User created successfully');
        $this->redirect('/admin/users');
    }
    
    public function editUserForm($id) {
        $userModel = $this->model('UserModel');
        $roleModel = $this->model('RoleModel');
        
        $user = $userModel->find($id);
        
        if (!$user) {
            setFlash('danger', 'User not found');
            $this->redirect('/admin/users');
        }
        
        $data = [
            'user' => $user,
            'roles' => $roleModel->getAllRoles()
        ];
        
        $this->view('admin/users/edit', $data);
    }
    
    public function editUser($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/users/' . $id . '/edit');
        }
        
        $data = [
            'name' => sanitize($this->getPost('name')),
            'email' => sanitize($this->getPost('email')),
            'role_id' => sanitize($this->getPost('role_id')),
            'status' => sanitize($this->getPost('status'))
        ];
        
        // Only update password if provided
        $password = $this->getPost('password');
        if (!empty($password)) {
            $data['password'] = $password;
        }
        
        $userModel = $this->model('UserModel');
        $userModel->updateUser($id, $data);
        
        setFlash('success', 'User updated successfully');
        $this->redirect('/admin/users');
    }
    
    public function deleteUser($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/users');
        }
        
        // Don't allow deleting yourself
        if ($id == getUserId()) {
            setFlash('danger', 'You cannot delete your own account');
            $this->redirect('/admin/users');
        }
        
        $userModel = $this->model('UserModel');
        $userModel->delete($id);
        
        setFlash('success', 'User deleted successfully');
        $this->redirect('/admin/users');
    }
    
    // ==========================================
    // LABORATORY MANAGEMENT
    // ==========================================
    
    public function listLaboratories() {
        $laboratoryModel = $this->model('LaboratoryModel');
        
        $data = [
            'laboratories' => $laboratoryModel->getAllLaboratories()
        ];
        
        $this->view('admin/laboratories/list', $data);
    }
    
    public function createLaboratoryForm() {
        $this->view('admin/laboratories/create');
    }
    
    public function createLaboratory() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/laboratories/create');
        }
        
        $data = [
            'lab_name' => sanitize($this->getPost('lab_name')),
            'description' => sanitize($this->getPost('description')),
            'location' => sanitize($this->getPost('location'))
        ];
        
        $laboratoryModel = $this->model('LaboratoryModel');
        $laboratoryModel->createLaboratory($data);
        
        setFlash('success', 'Laboratory created successfully');
        $this->redirect('/admin/laboratories');
    }
    
    public function editLaboratoryForm($id) {
        $laboratoryModel = $this->model('LaboratoryModel');
        $laboratory = $laboratoryModel->find($id);
        
        if (!$laboratory) {
            setFlash('danger', 'Laboratory not found');
            $this->redirect('/admin/laboratories');
        }
        
        $data = ['laboratory' => $laboratory];
        $this->view('admin/laboratories/edit', $data);
    }
    
    public function editLaboratory($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/laboratories/' . $id . '/edit');
        }
        
        $data = [
            'lab_name' => sanitize($this->getPost('lab_name')),
            'description' => sanitize($this->getPost('description')),
            'location' => sanitize($this->getPost('location'))
        ];
        
        $laboratoryModel = $this->model('LaboratoryModel');
        $laboratoryModel->updateLaboratory($id, $data);
        
        setFlash('success', 'Laboratory updated successfully');
        $this->redirect('/admin/laboratories');
    }
    
    public function deleteLaboratory($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/laboratories');
        }
        
        $laboratoryModel = $this->model('LaboratoryModel');
        $laboratoryModel->deleteLaboratory($id);
        
        setFlash('success', 'Laboratory deleted successfully');
        $this->redirect('/admin/laboratories');
    }
    
    // ==========================================
    // LAB SCHEDULES MANAGEMENT
    // ==========================================
    
    public function listSchedules() {
        $scheduleModel = $this->model('LabScheduleModel');
        
        $data = [
            'schedules' => $scheduleModel->getAllWithLaboratory()
        ];
        
        $this->view('admin/schedules/list', $data);
    }
    
    public function createScheduleForm() {
        $laboratoryModel = $this->model('LaboratoryModel');
        
        $data = [
            'laboratories' => $laboratoryModel->getAllLaboratories()
        ];
        
        $this->view('admin/schedules/create', $data);
    }
    
    public function createSchedule() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/schedules/create');
        }
        
        $data = [
            'laboratory_id' => sanitize($this->getPost('laboratory_id')),
            'day' => sanitize($this->getPost('day')),
            'start_time' => sanitize($this->getPost('start_time')),
            'end_time' => sanitize($this->getPost('end_time')),
            'course' => sanitize($this->getPost('course')),
            'lecturer' => sanitize($this->getPost('lecturer')),
            'assistant' => sanitize($this->getPost('assistant')),
            'participant_count' => sanitize($this->getPost('participant_count'))
        ];
        
        $scheduleModel = $this->model('LabScheduleModel');
        $scheduleModel->createSchedule($data);
        
        setFlash('success', 'Schedule created successfully');
        $this->redirect('/admin/schedules');
    }
    
    public function editScheduleForm($id) {
        $scheduleModel = $this->model('LabScheduleModel');
        $laboratoryModel = $this->model('LaboratoryModel');
        
        $schedule = $scheduleModel->find($id);
        
        if (!$schedule) {
            setFlash('danger', 'Schedule not found');
            $this->redirect('/admin/schedules');
        }
        
        $data = [
            'schedule' => $schedule,
            'laboratories' => $laboratoryModel->getAllLaboratories()
        ];
        
        $this->view('admin/schedules/edit', $data);
    }
    
    public function editSchedule($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/schedules/' . $id . '/edit');
        }
        
        $data = [
            'laboratory_id' => sanitize($this->getPost('laboratory_id')),
            'day' => sanitize($this->getPost('day')),
            'start_time' => sanitize($this->getPost('start_time')),
            'end_time' => sanitize($this->getPost('end_time')),
            'course' => sanitize($this->getPost('course')),
            'lecturer' => sanitize($this->getPost('lecturer')),
            'assistant' => sanitize($this->getPost('assistant')),
            'participant_count' => sanitize($this->getPost('participant_count'))
        ];
        
        $scheduleModel = $this->model('LabScheduleModel');
        $scheduleModel->updateSchedule($id, $data);
        
        setFlash('success', 'Schedule updated successfully');
        $this->redirect('/admin/schedules');
    }
    
    public function deleteSchedule($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/schedules');
        }
        
        $scheduleModel = $this->model('LabScheduleModel');
        $scheduleModel->deleteSchedule($id);
        
        setFlash('success', 'Schedule deleted successfully');
        $this->redirect('/admin/schedules');
    }
    
    // ==========================================
    // ASSISTANT SCHEDULES (PIKET) MANAGEMENT
    // ==========================================
    
    public function listAssistantSchedules() {
        $scheduleModel = $this->model('AssistantScheduleModel');
        
        $data = [
            'schedules' => $scheduleModel->getAllWithUser()
        ];
        
        $this->view('admin/assistant-schedules/list', $data);
    }
    
    public function createAssistantScheduleForm() {
        $userModel = $this->model('UserModel');
        $roleModel = $this->model('RoleModel');
        
        // Get asisten role
        $asistenRole = $roleModel->getByName('asisten');
        $assistants = $userModel->getActiveUsersByRole($asistenRole['id']);
        
        $data = [
            'assistants' => $assistants
        ];
        
        $this->view('admin/assistant-schedules/create', $data);
    }
    
    public function createAssistantSchedule() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/assistant-schedules/create');
        }
        
        $data = [
            'user_id' => sanitize($this->getPost('user_id')),
            'day' => sanitize($this->getPost('day')),
            'start_time' => sanitize($this->getPost('start_time')),
            'end_time' => sanitize($this->getPost('end_time')),
            'status' => sanitize($this->getPost('status', 'scheduled'))
        ];
        
        $scheduleModel = $this->model('AssistantScheduleModel');
        $scheduleModel->createSchedule($data);
        
        setFlash('success', 'Assistant schedule created successfully');
        $this->redirect('/admin/assistant-schedules');
    }
    
    public function editAssistantScheduleForm($id) {
        $scheduleModel = $this->model('AssistantScheduleModel');
        $userModel = $this->model('UserModel');
        $roleModel = $this->model('RoleModel');
        
        $schedule = $scheduleModel->find($id);
        
        if (!$schedule) {
            setFlash('danger', 'Schedule not found');
            $this->redirect('/admin/assistant-schedules');
        }
        
        $asistenRole = $roleModel->getByName('asisten');
        $assistants = $userModel->getActiveUsersByRole($asistenRole['id']);
        
        $data = [
            'schedule' => $schedule,
            'assistants' => $assistants
        ];
        
        $this->view('admin/assistant-schedules/edit', $data);
    }
    
    public function editAssistantSchedule($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/assistant-schedules/' . $id . '/edit');
        }
        
        $data = [
            'user_id' => sanitize($this->getPost('user_id')),
            'day' => sanitize($this->getPost('day')),
            'start_time' => sanitize($this->getPost('start_time')),
            'end_time' => sanitize($this->getPost('end_time')),
            'status' => sanitize($this->getPost('status'))
        ];
        
        $scheduleModel = $this->model('AssistantScheduleModel');
        $scheduleModel->updateSchedule($id, $data);
        
        setFlash('success', 'Assistant schedule updated successfully');
        $this->redirect('/admin/assistant-schedules');
    }
    
    public function deleteAssistantSchedule($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/assistant-schedules');
        }
        
        $scheduleModel = $this->model('AssistantScheduleModel');
        $scheduleModel->deleteSchedule($id);
        
        setFlash('success', 'Assistant schedule deleted successfully');
        $this->redirect('/admin/assistant-schedules');
    }
    
    // ==========================================
    // HEAD LABORAN MANAGEMENT
    // ==========================================
    
    public function listHeadLaboran() {
        $headLaboranModel = $this->model('HeadLaboranModel');
        
        $data = [
            'headLaboran' => $headLaboranModel->getAllWithUser()
        ];
        
        $this->view('admin/head-laboran/list', $data);
    }
    
    public function createHeadLaboranForm() {
        $userModel = $this->model('UserModel');
        
        $data = [
            'users' => $userModel->getAllWithRoles()
        ];
        
        $this->view('admin/head-laboran/create', $data);
    }
    
    public function createHeadLaboran() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/head-laboran/create');
        }
        
        $userId = sanitize($this->getPost('user_id'));
        
        // Check if user is already head laboran
        $headLaboranModel = $this->model('HeadLaboranModel');
        if ($headLaboranModel->isHeadLaboran($userId)) {
            setFlash('danger', 'User is already a head laboran');
            $this->redirect('/admin/head-laboran/create');
        }
        
        $data = [
            'user_id' => $userId,
            'photo' => '',
            'status' => sanitize($this->getPost('status', 'active')),
            'location' => sanitize($this->getPost('location')),
            'time_in' => sanitize($this->getPost('time_in'))
        ];
        
        // Handle photo upload
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $upload = uploadFile($_FILES['photo'], 'uploads/head-laboran/');
            if ($upload['success']) {
                $data['photo'] = $upload['path'];
            }
        }
        
        $headLaboranModel->createHeadLaboran($data);
        
        setFlash('success', 'Head laboran created successfully');
        $this->redirect('/admin/head-laboran');
    }
    
    public function editHeadLaboranForm($id) {
        $headLaboranModel = $this->model('HeadLaboranModel');
        $userModel = $this->model('UserModel');
        
        $headLaboran = $headLaboranModel->find($id);
        
        if (!$headLaboran) {
            setFlash('danger', 'Head laboran not found');
            $this->redirect('/admin/head-laboran');
        }
        
        $data = [
            'headLaboran' => $headLaboran,
            'users' => $userModel->getAllWithRoles()
        ];
        
        $this->view('admin/head-laboran/edit', $data);
    }
    
    public function editHeadLaboran($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/head-laboran/' . $id . '/edit');
        }
        
        $headLaboranModel = $this->model('HeadLaboranModel');
        $current = $headLaboranModel->find($id);
        
        $data = [
            'status' => sanitize($this->getPost('status')),
            'location' => sanitize($this->getPost('location')),
            'time_in' => sanitize($this->getPost('time_in'))
        ];
        
        // Handle photo upload
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $upload = uploadFile($_FILES['photo'], 'uploads/head-laboran/');
            if ($upload['success']) {
                // Delete old photo
                if (!empty($current['photo'])) {
                    deleteFile($current['photo']);
                }
                $data['photo'] = $upload['path'];
            }
        }
        
        $headLaboranModel->updateHeadLaboran($id, $data);
        
        setFlash('success', 'Head laboran updated successfully');
        $this->redirect('/admin/head-laboran');
    }
    
    public function deleteHeadLaboran($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/head-laboran');
        }
        
        $headLaboranModel = $this->model('HeadLaboranModel');
        $headLaboran = $headLaboranModel->find($id);
        
        if ($headLaboran && !empty($headLaboran['photo'])) {
            deleteFile($headLaboran['photo']);
        }
        
        $headLaboranModel->deleteHeadLaboran($id);
        
        setFlash('success', 'Head laboran deleted successfully');
        $this->redirect('/admin/head-laboran');
    }
    
    // ==========================================
    // LAB ACTIVITIES MANAGEMENT
    // ==========================================
    
    public function listActivities() {
        $activityModel = $this->model('LabActivityModel');
        
        $data = [
            'activities' => $activityModel->getAllWithCreator()
        ];
        
        $this->view('admin/activities/list', $data);
    }
    
    public function createActivityForm() {
        $this->view('admin/activities/create');
    }
    
    public function createActivity() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/activities/create');
        }
        
        $data = [
            'title' => sanitize($this->getPost('title')),
            'activity_type' => sanitize($this->getPost('activity_type')),
            'activity_date' => sanitize($this->getPost('activity_date')),
            'location' => sanitize($this->getPost('location')),
            'description' => sanitize($this->getPost('description')),
            'status' => sanitize($this->getPost('status', 'draft'))
        ];
        
        $activityModel = $this->model('LabActivityModel');
        $activityModel->createActivity($data);
        
        setFlash('success', 'Activity created successfully');
        $this->redirect('/admin/activities');
    }
    
    public function editActivityForm($id) {
        $activityModel = $this->model('LabActivityModel');
        $activity = $activityModel->find($id);
        
        if (!$activity) {
            setFlash('danger', 'Activity not found');
            $this->redirect('/admin/activities');
        }
        
        $data = ['activity' => $activity];
        $this->view('admin/activities/edit', $data);
    }
    
    public function editActivity($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/activities/' . $id . '/edit');
        }
        
        $data = [
            'title' => sanitize($this->getPost('title')),
            'activity_type' => sanitize($this->getPost('activity_type')),
            'activity_date' => sanitize($this->getPost('activity_date')),
            'location' => sanitize($this->getPost('location')),
            'description' => sanitize($this->getPost('description')),
            'status' => sanitize($this->getPost('status'))
        ];
        
        $activityModel = $this->model('LabActivityModel');
        $activityModel->updateActivity($id, $data);
        
        setFlash('success', 'Activity updated successfully');
        $this->redirect('/admin/activities');
    }
    
    public function deleteActivity($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/activities');
        }
        
        $activityModel = $this->model('LabActivityModel');
        $activityModel->deleteActivity($id);
        
        setFlash('success', 'Activity deleted successfully');
        $this->redirect('/admin/activities');
    }
    
    // ==========================================
    // PROBLEMS MANAGEMENT
    // ==========================================
    
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
            'currentStatus' => $status,
            'statistics' => $problemModel->getStatistics()
        ];
        
        $this->view('admin/problems/list', $data);
    }
    
    public function viewProblem($id) {
        $problemModel = $this->model('LabProblemModel');
        $historyModel = $this->model('ProblemHistoryModel');
        
        $problem = $problemModel->getProblemWithDetails($id);
        
        if (!$problem) {
            setFlash('danger', 'Problem not found');
            $this->redirect('/admin/problems');
        }
        
        $data = [
            'problem' => $problem,
            'histories' => $historyModel->getHistoryByProblem($id)
        ];
        
        $this->view('admin/problems/detail', $data);
    }
    
    public function updateProblemStatus($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/problems/' . $id);
        }
        
        $status = sanitize($this->getPost('status'));
        $note = sanitize($this->getPost('note'));
        
        // Update problem status
        $problemModel = $this->model('LabProblemModel');
        $problemModel->updateProblem($id, ['status' => $status]);
        
        // Add to history
        $historyModel = $this->model('ProblemHistoryModel');
        $historyModel->addHistory($id, $status, $note);
        
        setFlash('success', 'Problem status updated successfully');
        $this->redirect('/admin/problems/' . $id);
    }
    
    public function deleteProblem($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/problems');
        }
        
        // Delete histories first
        $historyModel = $this->model('ProblemHistoryModel');
        $histories = $historyModel->getHistoryByProblem($id);
        foreach ($histories as $history) {
            $historyModel->delete($history['id']);
        }
        
        // Delete problem
        $problemModel = $this->model('LabProblemModel');
        $problemModel->deleteProblem($id);
        
        setFlash('success', 'Problem deleted successfully');
        $this->redirect('/admin/problems');
    }
}
