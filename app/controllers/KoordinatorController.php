<?php

/**
 * ICLABS - Koordinator Controller
 * Handles koordinator role operations
 */

class KoordinatorController extends Controller
{

    /**
     * Constructor - Ensure only koordinator can access this controller
     */
    public function __construct()
    {
        $this->requireRole('koordinator');
    }

    /**
     * Display koordinator dashboard with statistics and pending problems
     * 
     * @return void
     */
    public function dashboard()
    {
        $problemModel = $this->model('LabProblemModel');
        $data = [
            'statistics' => $problemModel->getStatistics(),
            'pendingProblems' => $problemModel->getPendingProblems(),
            'userName' => getUserName()
        ];
        $this->view('koordinator/dashboard', $data);
    }

    /**
     * Display paginated list of lab problems with filtering
     * 
     * Supports filtering by status and search query
     * Uses helper functions for validation and pagination
     * 
     * @return void
     */
    public function listProblems()
    {
        $problemModel = $this->model('LabProblemModel');

        // Validate filters using helper
        $filters = validateListFilters([
            'status' => $this->getQuery('status'),
            'search' => $this->getQuery('search'),
            'page' => $this->getQuery('page')
        ]);

        // Get filtered data
        $result = $problemModel->getFilteredProblems(
            $filters['status'], 
            $filters['search'], 
            $filters['page'], 
            10
        );

        $data = [
            'problems' => $result['data'],
            'pagination' => buildPaginationData($result),
            'filters' => [
                'status' => $filters['status'],
                'search' => $filters['search']
            ]
        ];

        $this->view('koordinator/problems/index', $data);
    }

    /**
     * Display form for creating new problem report
     * 
     * Loads laboratory list for dropdown selection
     * 
     * @return void
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
     * Process and store new problem report
     * 
     * Validates required fields, creates problem record,
     * and adds initial history entry
     * 
     * @return void Redirects to problems list with flash message
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

        if (!validateRequired($data, ['laboratory_id', 'description'])) {
            setFlash('danger', 'Mohon lengkapi data laporan dengan benar.');
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
     * Display detailed view of a specific problem
     * 
     * Shows problem details, history, and available assistants for assignment
     * 
     * @param int $id Problem ID
     * @return void
     */
    public function viewProblem($id)
    {
        $problemModel = $this->model('LabProblemModel');
        $historyModel = $this->model('ProblemHistoryModel');
        $userModel = $this->model('UserModel');

        $problem = $problemModel->getProblemWithDetails($id);

        if (!$problem) {
            setFlash('danger', 'Data masalah tidak ditemukan.');
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
     * Update problem status and add history entry
     * 
     * Updates problem status (reported/in_progress/resolved)
     * and logs the change with optional notes
     * 
     * @param int $id Problem ID
     * @return void Redirects to problem detail
     */
    public function updateProblemStatus($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/koordinator/problems/' . $id);
        }

        $status = sanitize($this->getPost('status'));
        $note = sanitize($this->getPost('note'));

        if (empty($status)) {
            setFlash('danger', 'Status wajib dipilih.');
            $this->redirect('/koordinator/problems/' . $id);
        }

        // Update problem status
        $problemModel = $this->model('LabProblemModel');
        $problemModel->updateProblem($id, ['status' => $status]);

        // Add to history
        $historyModel = $this->model('ProblemHistoryModel');
        $historyModel->addHistory($id, $status, $note);

        setFlash('success', 'Status masalah berhasil diperbarui.');
        $this->redirect('/koordinator/problems/' . $id);
    }

    /**
     * Display form for editing existing problem
     * 
     * Loads problem data and laboratory list
     * 
     * @param int $id Problem ID
     * @return void
     */
    public function editProblemForm($id)
    {
        $problemModel = $this->model('LabProblemModel');
        $laboratoryModel = $this->model('LaboratoryModel');

        $problem = $problemModel->find($id);

        if (!$problem) {
            setFlash('danger', 'Data masalah tidak ditemukan.');
            $this->redirect('/koordinator/problems');
        }

        $data = [
            'problem' => $problem,
            'laboratories' => $laboratoryModel->getAllLaboratories()
        ];

        $this->view('koordinator/problems/edit', $data);
    }

    /**
     * Process problem update and save changes
     * 
     * Updates problem data and adds history entry
     * 
     * @param int $id Problem ID
     * @return void Redirects to problem detail
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

        setFlash('success', 'Data masalah berhasil diperbarui.');
        $this->redirect('/koordinator/problems/' . $id);
    }

    /**
     * Delete problem and its associated history
     * 
     * Validates ID, checks existence, deletes history entries,
     * then removes the problem record
     * 
     * @param int $id Problem ID
     * @return void Redirects to problems list
     */
    public function deleteProblem($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/koordinator/problems');
        }

        // Validate ID using helper
        if (!validateId($id)) {
            setFlash('danger', 'ID permasalahan tidak valid.');
            $this->redirect('/koordinator/problems');
        }

        $problemModel = $this->model('LabProblemModel');
        
        // Cek apakah problem exists
        $problem = $problemModel->find($id);
        if (!$problem) {
            setFlash('danger', 'Data masalah tidak ditemukan.');
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
            setFlash('success', 'Data masalah berhasil dihapus.');
        } else {
            setFlash('danger', 'Gagal menghapus data masalah.');
        }
        
        $this->redirect('/koordinator/problems');
    }

    /**
     * Assign problem to an assistant
     * 
     * Updates assigned_to field and creates history entry
     * 
     * @param int $id Problem ID
     * @return void Redirects to problem detail
     */
    public function assignProblem($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/koordinator/problems/' . $id);
        }

        $assignedTo = sanitize($this->getPost('assigned_to'));

        if (empty($assignedTo)) {
            setFlash('danger', 'Silakan pilih asisten terlebih dahulu.');
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

        setFlash('success', 'Tugas berhasil diberikan kepada ' . $assignee['name'] . '.');
        $this->redirect('/koordinator/problems/' . $id);
    }

    /**
     * Display list of assistant schedules grouped by day
     * 
     * Shows weekly schedule with assistant assignments and jobdesk settings
     * Supports grid view with day grouping
     * 
     * @return void
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
    /**
     * Display form for creating new assistant schedule
     * 
     * Loads list of assistants for dropdown selection
     * 
     * @return void
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
    /**
     * Process and store new assistant schedule
     * 
     * Validates required fields (user_id, day, time)
     * Creates schedule record
     * 
     * @return void Redirects to schedules list
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

        if (!validateRequired($data, ['user_id', 'day', 'start_time', 'end_time'])) {
            setFlash('danger', 'Mohon lengkapi semua field yang wajib diisi.');
            $this->redirect('/koordinator/assistant-schedules/create');
        }

        $scheduleModel = $this->model('AssistantScheduleModel');
        $scheduleModel->createSchedule($data);

        setFlash('success', 'Jadwal piket berhasil ditambahkan.');
        $this->redirect('/koordinator/assistant-schedules');
    }

    /**
     * Display form for editing existing assistant schedule
     * 
     * Loads schedule data and assistant list
     * 
     * @param int $id Schedule ID
     * @return void
     */
    public function editScheduleForm($id)
    {
        $scheduleModel = $this->model('AssistantScheduleModel');
        $userModel = $this->model('UserModel');

        $schedule = $scheduleModel->find($id);

        if (!$schedule) {
            setFlash('danger', 'Jadwal tidak ditemukan.');
            $this->redirect('/koordinator/assistant-schedules');
        }

        $data = [
            'schedule' => $schedule,
            'assistants' => $userModel->getUsersByRoleName('asisten')
        ];
        
        $this->view('koordinator/assistant-schedules/edit', $data);
    }

    /**
     * Process schedule update and save changes
     * 
     * Updates schedule data (user, day, time, status)
     * 
     * @param int $id Schedule ID
     * @return void Redirects to schedules list
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

        setFlash('success', 'Jadwal piket berhasil diperbarui.');
        $this->redirect('/koordinator/assistant-schedules');
    }

    /**
     * Delete assistant schedule
     * 
     * Removes schedule record from database
     * 
     * @param int $id Schedule ID
     * @return void Redirects to schedules list
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
    /**
     * Display list of all laboratories
     * 
     * Shows laboratory data with PC and TV counts
     * 
     * @return void
     */
    public function listLaboratories()
    {
        $data = ['laboratories' => $this->model('LaboratoryModel')->getAllLaboratories()];
        $this->view('koordinator/laboratories/index', $data);
    }

    /**
     * Show create laboratory form
     */
    /**
     * Display form for creating new laboratory
     * 
     * @return void
     */
    public function createLaboratoryForm()
    {
        $this->view('koordinator/laboratories/create');
    }

    /**
     * Store new laboratory
     */
    /**
     * Process and store new laboratory
     * 
     * Validates lab name requirement
     * Creates laboratory record with specs
     * 
     * @return void Redirects to laboratories list
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

        if (!validateRequired($data, ['lab_name'])) {
            setFlash('danger', 'Nama laboratorium wajib diisi.');
            $this->redirect('/koordinator/laboratories/create');
        }

        $laboratoryModel = $this->model('LaboratoryModel');
        $laboratoryModel->createLaboratory($data);

        setFlash('success', 'Laboratorium "' . $data['lab_name'] . '" berhasil ditambahkan.');
        $this->redirect('/koordinator/laboratories');
    }

    /**
     * Show edit laboratory form
     */
    /**
     * Display form for editing existing laboratory
     * 
     * Loads laboratory data
     * 
     * @param int $id Laboratory ID
     * @return void
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

        setFlash('success', 'Data laboratorium "' . $data['lab_name'] . '" berhasil diperbarui.');
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

        setFlash('success', 'Laboratorium berhasil dihapus dari sistem.');
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
                setFlash('danger', 'Gagal upload gambar. Pastikan format dan ukuran file sudah sesuai.');
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

        setFlash('success', 'Kegiatan "' . $data['title'] . '" berhasil ditambahkan.');
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
            setFlash('danger', 'Kegiatan tidak ditemukan.');
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
            setFlash('danger', 'Kegiatan tidak ditemukan.');
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

        setFlash('success', 'Kegiatan "' . $data['title'] . '" berhasil diperbarui.');
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
            setFlash('danger', 'Kegiatan tidak ditemukan.');
            $this->redirect('/koordinator/activities');
            return;
        }

        // Delete via model (akan hapus file juga jika ada)
        $result = $activityModel->deleteActivity($id);
        
        if ($result) {
            setFlash('success', 'Kegiatan "' . $activity['title'] . '" berhasil dihapus.');
        } else {
            setFlash('danger', 'Gagal menghapus kegiatan.');
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
            setFlash('success', 'Jadwal asisten berhasil ditambahkan.');
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
            setFlash('success', 'Jadwal asisten berhasil diperbarui.');
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
            setFlash('success', "Jobdesk $role berhasil diperbarui.");
            $this->redirect('/koordinator/assistant-schedules');
        }
    }

    public function deleteAssistantSchedule($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model('AssistantScheduleModel')->deleteSchedule($id);
            setFlash('success', 'Jadwal asisten berhasil dihapus.');
            $this->redirect('/koordinator/assistant-schedules');
        }
    }
}