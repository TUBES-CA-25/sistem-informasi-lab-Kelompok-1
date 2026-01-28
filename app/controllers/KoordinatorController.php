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

    /**
     * Koordinator dashboard
     */
    public function dashboard()
    {
        $problemModel = $this->model('LabProblemModel');
        $data = [
            'statistics' => $problemModel->getStatistics(),
            'pendingProblems' => $problemModel->getPendingProblems(),
            'userName' => getUserName()
        ];
        // Sesuai gambar: dashboard.php ada di luar folder schedules (langsung di koordinator)
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

        $this->view('koordinator/problems/index', $data);
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

        $this->view('koordinator/problems/create', $data);
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
            'problem_type' => sanitize($this->getPost('problem_type')),
            'description' => sanitize($this->getPost('description')),
            'reported_by' => getUserId()
        ];

        if (empty($data['laboratory_id']) || empty($data['description'])) {
            setFlash('danger', '⚠️ Mohon lengkapi data laporan dengan benar!');
            $this->redirect('/koordinator/problems/create');
        }

        $problemModel = $this->model('LabProblemModel');
        $problemId = $problemModel->createProblem($data);

        // Add history
        $historyModel = $this->model('ProblemHistoryModel');
        $historyModel->addHistory($problemId, 'reported', 'Laporan dibuat oleh Koordinator');

        setFlash('success', '✅ Laporan masalah berhasil ditambahkan ke sistem!');
        $this->redirect('/koordinator/problems');
    }

    /**
     * View problem detail
     */
    public function viewProblem($id)
    {
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

        $this->view('koordinator/problems/detail', $data);
    }

    /**
     * Update problem status
     */
    public function updateProblemStatus($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/koordinator/problems/' . $id);
        }

        $status = sanitize($this->getPost('status'));
        $note = sanitize($this->getPost('note'));

        if (empty($status)) {
            setFlash('danger', '⚠️ Status wajib dipilih!');
            $this->redirect('/koordinator/problems/' . $id);
        }

        // Update problem status
        $problemModel = $this->model('LabProblemModel');
        $problemModel->updateProblem($id, ['status' => $status]);

        // Add to history
        $historyModel = $this->model('ProblemHistoryModel');
        $historyModel->addHistory($id, $status, $note);

        setFlash('success', '✅ Status masalah berhasil diperbarui!');
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
            setFlash('danger', '❌ Data masalah tidak ditemukan!');
            $this->redirect('/koordinator/problems');
        }

        $data = [
            'problem' => $problem,
            'laboratories' => $laboratoryModel->getAllLaboratories()
        ];

        $this->view('koordinator/problems/edit', $data);
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

        setFlash('success', '✅ Data masalah berhasil diperbarui!');
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

        // Validasi ID
        if (empty($id) || !is_numeric($id)) {
            setFlash('danger', '❌ ID permasalahan tidak valid!');
            $this->redirect('/koordinator/problems');
        }

        $problemModel = $this->model('LabProblemModel');
        
        // Cek apakah problem exists
        $problem = $problemModel->find($id);
        if (!$problem) {
            setFlash('danger', '❌ Data masalah tidak ditemukan!');
            $this->redirect('/koordinator/problems');
        }

        // Delete histories jika tabel ada
        try {
            $historyModel = $this->model('ProblemHistoryModel');
            $histories = $historyModel->getHistoryByProblem($id);
            foreach ($histories as $history) {
                $historyModel->delete($history['id']);
            }
        } catch (Exception $e) {
            // Tabel history tidak ada atau error, skip
        }

        // Delete problem
        $result = $problemModel->deleteProblem($id);
        
        if ($result) {
            setFlash('success', '🗑️ Data masalah berhasil dihapus!');
        } else {
            setFlash('danger', '❌ Gagal menghapus data masalah!');
        }
        
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
            setFlash('danger', '⚠️ Silakan pilih asisten terlebih dahulu!');
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

        setFlash('success', '👤 Tugas berhasil diberikan kepada ' . $assignee['name'] . '!');
        $this->redirect('/koordinator/problems/' . $id);
    }

    /**
     * List all assistant schedules with grid view & filter
     */
    public function listAssistantSchedules()
    {
        $scheduleModel = $this->model('AssistantScheduleModel');
        $settingsModel = $this->model('SettingsModel');

        // 1. Ambil Data Jadwal
        $rawSchedules = $scheduleModel->getAllWithUser();

        // 2. Ambil Jobdesk Global
        $masterJob = [
            'Putri' => $settingsModel->get('job_putri', 'Belum diatur'),
            'Putra' => $settingsModel->get('job_putra', 'Belum diatur')
        ];

        // 3. Buat Matriks Data
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
            'days' => $days
        ];

        // PATH YANG BENAR: 'schedules' (bukan 'assistant-schedules')
        $this->view('koordinator/schedules/index', $data);
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
        
        $this->view('koordinator/assistant-schedules/create', $data);
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
            'status' => sanitize($this->getPost('status')) ?: 'scheduled'
        ];

        if (empty($data['user_id']) || empty($data['day']) || empty($data['start_time']) || empty($data['end_time'])) {
            setFlash('danger', '⚠️ Mohon lengkapi semua field yang wajib diisi!');
            $this->redirect('/koordinator/assistant-schedules/create');
        }

        $scheduleModel = $this->model('AssistantScheduleModel');
        $scheduleModel->createSchedule($data);

        setFlash('success', '📅 Jadwal piket berhasil ditambahkan!');
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
            setFlash('danger', '❌ Jadwal tidak ditemukan!');
            $this->redirect('/koordinator/assistant-schedules');
        }

        $data = [
            'schedule' => $schedule,
            'assistants' => $userModel->getUsersByRoleName('asisten')
        ];
        
        $this->view('koordinator/assistant-schedules/edit', $data);
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
            'status' => sanitize($this->getPost('status'))
        ];

        $scheduleModel = $this->model('AssistantScheduleModel');
        $scheduleModel->updateSchedule($id, $data);

        setFlash('success', '✅ Jadwal piket berhasil diperbarui!');
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

        setFlash('success', '🗑️ Jadwal piket berhasil dihapus!');
        $this->redirect('/koordinator/assistant-schedules');
    }

    /**
     * List all laboratories with enhanced view
     */
    public function listLaboratories()
    {
        $data = ['laboratories' => $this->model('LaboratoryModel')->getAllLaboratories()];
        $this->view('koordinator/laboratories/index', $data);
    }

    /**
     * Show create laboratory form
     */
    public function createLaboratoryForm()
    {
        $this->view('koordinator/laboratories/create');
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
            setFlash('danger', '⚠️ Nama laboratorium wajib diisi!');
            $this->redirect('/koordinator/laboratories/create');
        }

        $laboratoryModel = $this->model('LaboratoryModel');
        $laboratoryModel->createLaboratory($data);

        setFlash('success', '🏢 Laboratorium "' . $data['lab_name'] . '" berhasil ditambahkan!');
        $this->redirect('/koordinator/laboratories');
    }

    /**
     * Show edit laboratory form
     */
    public function editLaboratoryForm($id)
    {
        $laboratoryModel = $this->model('LaboratoryModel');

        $lab = $laboratoryModel->find($id);

        if (!$lab) {
            setFlash('danger', '❌ Laboratorium tidak ditemukan!');
            $this->redirect('/koordinator/laboratories');
        }

        $data = ['laboratory' => $lab];

        $this->view('koordinator/laboratories/edit', $data);
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
            'capacity' => (int)sanitize($this->getPost('capacity')),
            'pc_count' => (int)sanitize($this->getPost('pc_count')),
            'tv_count' => (int)sanitize($this->getPost('tv_count')),
            'status' => sanitize($this->getPost('status'))
        ];

        $laboratoryModel = $this->model('LaboratoryModel');
        $laboratoryModel->updateLaboratory($id, $data);

        setFlash('success', '✅ Data laboratorium "' . $data['lab_name'] . '" berhasil diperbarui!');
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

        setFlash('success', '🗑️ Laboratorium berhasil dihapus dari sistem!');
        $this->redirect('/koordinator/laboratories');
    }

    /**
     * List all lab activities with CRUD
     */
    public function listActivities()
    {
        $activityModel = $this->model('LabActivityModel');

        $data = [
            'activities' => $activityModel->getAllActivities()
        ];

        $this->view('koordinator/activities/index', $data);
    }

    /**
     * Show create activity form
     */
    public function createActivityForm()
    {
        $this->view('koordinator/activities/create');
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
                setFlash('danger', '❌ Gagal upload gambar! Pastikan format dan ukuran file sudah sesuai.');
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

        setFlash('success', '📸 Kegiatan "' . $data['title'] . '" berhasil ditambahkan!');
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
            setFlash('danger', '❌ Kegiatan tidak ditemukan!');
            $this->redirect('/koordinator/activities');
        }

        $data = ['activity' => $activity];
        $this->view('koordinator/activities/edit', $data);
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
            setFlash('danger', '❌ Kegiatan tidak ditemukan!');
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

        setFlash('success', '✅ Kegiatan "' . $data['title'] . '" berhasil diperbarui!');
        $this->redirect('/koordinator/activities');
    }

    /**
     * Delete activity and its image
     */
    public function deleteActivity($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/koordinator/activities');
            return;
        }

        $activityModel = $this->model('LabActivityModel');
        $activity = $activityModel->find($id);

        if (!$activity) {
            setFlash('danger', '❌ Kegiatan tidak ditemukan!');
            $this->redirect('/koordinator/activities');
            return;
        }

        // Delete via model (akan hapus file juga jika ada)
        $result = $activityModel->deleteActivity($id);
        
        if ($result) {
            setFlash('success', '🗑️ Kegiatan "' . $activity['title'] . '" berhasil dihapus!');
        } else {
            setFlash('danger', '❌ Gagal menghapus kegiatan!');
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







    public function assistantSchedules()
    {
        $scheduleModel = $this->model('AssistantScheduleModel');
        $settingsModel = $this->model('SettingsModel');

        // 1. Ambil Data Jadwal
        $rawSchedules = $scheduleModel->getAllWithUser();

        // 2. Ambil Jobdesk Global
        $masterJob = [
            'Putri' => $settingsModel->get('job_putri', 'Belum diatur'),
            'Putra' => $settingsModel->get('job_putra', 'Belum diatur')
        ];

        // 3. Buat Matriks Data
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
            'days' => $days
        ];

        // PATH: koordinator/schedules (file yang match dengan database)
        $this->view('koordinator/schedules/index', $data);
    }


    public function createAssistantSchedule()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'user_id' => sanitize($this->getPost('user_id')),
                'day' => sanitize($this->getPost('day')),
                'job_role' => sanitize($this->getPost('job_role'))
            ];
            $this->model('AssistantScheduleModel')->createSchedule($data);
            setFlash('success', '📅 Jadwal asisten berhasil ditambahkan!');
            $this->redirect('/koordinator/assistant-schedules');
            return;
        }

        $userModel = $this->model('UserModel');
        $roleModel = $this->model('RoleModel');
        $asistenRole = $roleModel->getByName('asisten');

        $data = ['assistants' => $userModel->getActiveUsersByRole($asistenRole['id'])];

        // PATH: koordinator/schedules (file yang match dengan database)
        $this->view('koordinator/schedules/create', $data);
    }


    public function editAssistantSchedule($id)
    {
        $scheduleModel = $this->model('AssistantScheduleModel');
        $schedule = $scheduleModel->find($id);

        if (!$schedule) $this->redirect('/koordinator/assistant-schedules');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'user_id' => sanitize($this->getPost('user_id')),
                'day' => sanitize($this->getPost('day')),
                'job_role' => sanitize($this->getPost('job_role'))
            ];
            $scheduleModel->updateSchedule($id, $data);
            setFlash('success', '✅ Jadwal asisten berhasil diperbarui!');
            $this->redirect('/koordinator/assistant-schedules');
            return;
        }

        $userModel = $this->model('UserModel');
        $roleModel = $this->model('RoleModel');
        $asistenRole = $roleModel->getByName('asisten');

        $data = [
            'schedule' => $schedule,
            'assistants' => $userModel->getActiveUsersByRole($asistenRole['id'])
        ];

        // PATH: koordinator/schedules (file yang match dengan database)
        $this->view('koordinator/schedules/edit', $data);
    }


    public function updateJobdesk()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $role = sanitize($this->getPost('role'));
            $content = sanitize($this->getPost('content'));
            $key = ($role == 'Putra') ? 'job_putra' : 'job_putri';

            $this->model('SettingsModel')->save($key, $content);
            setFlash('success', "📝 Jobdesk $role berhasil diperbarui!");
            $this->redirect('/koordinator/assistant-schedules');
        }
    }

    public function deleteAssistantSchedule($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model('AssistantScheduleModel')->deleteSchedule($id);
            setFlash('success', '🗑️ Jadwal asisten berhasil dihapus!');
            $this->redirect('/koordinator/assistant-schedules');
        }
    }
}