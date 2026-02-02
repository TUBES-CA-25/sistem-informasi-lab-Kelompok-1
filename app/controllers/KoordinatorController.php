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

        if ($problemId) {
            // Add history
            $historyModel = $this->model('ProblemHistoryModel');
            $historyModel->addHistory($problemId, 'reported', 'Laporan dibuat oleh Koordinator');

            setFlash('success', 'Laporan masalah berhasil ditambahkan.');
        } else {
            setFlash('danger', 'Gagal menambahkan laporan masalah.');
        }

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

        if ($problemModel->updateProblem($id, $data)) {
            // Add history
            $historyModel = $this->model('ProblemHistoryModel');
            $historyModel->addHistory($id, $data['status'], 'Problem updated by Koordinator');

            setFlash('success', 'Data masalah berhasil diperbarui.');
        } else {
            setFlash('danger', 'Gagal memperbarui data masalah.');
        }

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

        // Delete problem with cascading history (moved to model)
        $historyModel = $this->model('ProblemHistoryModel');
        $result = $problemModel->deleteProblemWithHistory($id, $historyModel);

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

        // 3. Build matrix using model method
        $matrix = $scheduleModel->buildScheduleMatrix($rawSchedules);
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

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
        $result = $scheduleModel->createSchedule($data);

        if ($result) {
            setFlash('success', 'Jadwal piket berhasil ditambahkan.');
        } else {
            setFlash('danger', 'Gagal menambahkan jadwal piket.');
        }

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

        if ($scheduleModel->updateSchedule($id, $data)) {
            setFlash('success', 'Jadwal piket berhasil diperbarui.');
        } else {
            setFlash('danger', 'Gagal memperbarui jadwal piket.');
        }

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
            return;
        }

        // Validate ID
        if (!validateId($id)) {
            setFlash('danger', 'ID jadwal tidak valid.');
            $this->redirect('/koordinator/assistant-schedules');
            return;
        }

        $scheduleModel = $this->model('AssistantScheduleModel');
        $result = $scheduleModel->deleteSchedule($id);

        if ($result) {
            setFlash('success', 'Jadwal piket berhasil dihapus.');
        } else {
            setFlash('danger', 'Gagal menghapus jadwal piket.');
        }

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
    /**
     * Menampilkan Form Tambah Laboratorium (GET)
     */
    public function createLaboratoryForm()
    {
        $this->view('koordinator/laboratories/create');
    }

    /**
     * Menampilkan Form Edit Laboratorium (GET)
     */
    public function editLaboratoryForm($id)
    {
        $labModel = $this->model('LaboratoryModel');
        $lab = $labModel->find($id);

        if (!$lab) {
            setFlash('danger', 'Laboratorium tidak ditemukan.');
            $this->redirect('/koordinator/laboratories');
            return;
        }

        $this->view('koordinator/laboratories/edit', ['laboratory' => $lab]);
    }

// ==========================================================
    // MODULE: LABORATORIES (MANAJEMEN LAB + FOTO)
    // ==========================================================

    /**
     * Menampilkan daftar laboratorium
     */
    public function laboratories()
    {
        $labModel = $this->model('LaboratoryModel');
        $keyword = isset($_GET['q']) ? trim($_GET['q']) : null;

        if ($keyword) {
            // Filter manual berdasarkan nama atau lokasi
            $allLabs = $labModel->getAllLaboratories();
            $data['laboratories'] = array_filter($allLabs, function ($lab) use ($keyword) {
                return stripos($lab['lab_name'], $keyword) !== false ||
                    stripos($lab['location'], $keyword) !== false;
            });
        } else {
            $data['laboratories'] = $labModel->getAllLaboratories();
        }

        $this->view('koordinator/laboratories/index', $data);
    }

    /**
     * Menambah laboratorium baru (dengan Upload Gambar)
     */
    public function createLaboratory()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $labModel = $this->model('LaboratoryModel');

            // 1. Ambil Data Teks (Sesuai kolom database iclabs.sql)
            $data = [
                'lab_name'    => $_POST['lab_name'],
                'description' => $_POST['description'],
                'location'    => $_POST['location'],
                'pc_count'    => $_POST['pc_count'],
                'tv_count'    => $_POST['tv_count'],
                'image'       => null // Default null jika tidak ada foto
            ];

            // 2. Handle Upload Gambar
            if (!empty($_FILES['image']['name'])) {
                $upload = $this->handleUpload($_FILES['image']);
                if ($upload['success']) {
                    $data['image'] = $upload['path'];
                } else {
                    setFlash('danger', 'Gagal upload foto: ' . $upload['message']);
                    $this->view('koordinator/laboratories/create');
                    return;
                }
            }

            // 3. Simpan ke Database
            if ($labModel->createLaboratory($data)) {
                setFlash('success', 'Laboratorium berhasil ditambahkan.');
                $this->redirect('/koordinator/laboratories');
                return;
            } else {
                setFlash('danger', 'Gagal menyimpan data ke database.');
            }
        }

        $this->view('koordinator/laboratories/create');
    }

    /**
     * Mengedit laboratorium (dengan Update Gambar)
     */
    public function updateLaboratory($id)
    {
        $labModel = $this->model('LaboratoryModel');
        $lab = $labModel->find($id); // Pastikan Model punya method find()

        if (!$lab) {
            setFlash('danger', 'Laboratorium tidak ditemukan.');
            $this->redirect('/koordinator/laboratories');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // 1. Ambil Data Teks
            $data = [
                'lab_name'    => $_POST['lab_name'],
                'description' => $_POST['description'],
                'location'    => $_POST['location'],
                'pc_count'    => $_POST['pc_count'],
                'tv_count'    => $_POST['tv_count']
                // Jangan set 'image' di sini agar foto lama tidak tertimpa null
            ];

            // 2. Handle Upload Gambar Baru (Jika user upload file baru)
            if (!empty($_FILES['image']['name'])) {
                $upload = $this->handleUpload($_FILES['image']);
                if ($upload['success']) {
                    $data['image'] = $upload['path']; // Update path gambar baru
                } else {
                    setFlash('danger', 'Gagal upload foto: ' . $upload['message']);
                    $this->view('koordinator/laboratories/edit', ['laboratory' => $lab]);
                    return;
                }
            }

            // 3. Update Database
            if ($labModel->updateLaboratory($id, $data)) {
                setFlash('success', 'Data laboratorium berhasil diperbarui.');
                $this->redirect('/koordinator/laboratories');
                return;
            } else {
                setFlash('danger', 'Gagal memperbarui data.');
            }
        }

        $this->view('koordinator/laboratories/edit', ['laboratory' => $lab]);
    }

    /**
     * Menghapus laboratorium
     */
    public function deleteLaboratory($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $labModel = $this->model('LaboratoryModel');

            if ($labModel->deleteLaboratory($id)) {
                setFlash('success', 'Laboratorium berhasil dihapus.');
            } else {
                setFlash('danger', 'Gagal menghapus laboratorium.');
            }
            $this->redirect('/koordinator/laboratories');
        }
    }

    /**
     * HELPER: Fungsi Upload Gambar
     * (Wajib ada agar create/update tidak error "Call to undefined method")
     */
    private function handleUpload($file)
    {
        // Tentukan folder tujuan (pastikan folder ini ada/writable)
        $targetDir = PUBLIC_PATH . '/uploads/laboratories/';

        // Buat folder otomatis jika belum ada
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Validasi Ekstensi File
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($fileExt, $allowedTypes)) {
            return ['success' => false, 'message' => 'Format file harus JPG, PNG, atau GIF.'];
        }

        // Generate Nama File Unik (agar tidak bentrok)
        $fileName = uniqid() . '_' . time() . '.' . $fileExt;
        $targetFile = $targetDir . $fileName;

        // Pindahkan file dari temp ke folder tujuan
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            // Sukses: Kembalikan URL lengkap
            $webUrl = defined('BASE_URL') ? BASE_URL : 'http://localhost/iclabs/public';
            return [
                'success' => true,
                'path' => $webUrl . '/uploads/laboratories/' . $fileName
            ];
        }

        return ['success' => false, 'message' => 'Gagal memindahkan file upload.'];
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
            $imagePath = uploadFile($_FILES['image_cover'], UPLOAD_DIR_ACTIVITIES, null, MAX_UPLOAD_SIZE, 'activity');
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
            $newImagePath = uploadFile($_FILES['image_cover'], UPLOAD_DIR_ACTIVITIES, null, MAX_UPLOAD_SIZE, 'activity');
            if ($newImagePath) {
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

        if ($activityModel->updateActivityWithImageCleanup($id, $data)) {
            setFlash('success', 'Kegiatan "' . $data['title'] . '" berhasil diperbarui.');
        } else {
            setFlash('danger', 'Gagal memperbarui kegiatan.');
        }

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

        // 3. Build matrix using model method
        $matrix = $scheduleModel->buildScheduleMatrix($rawSchedules);
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

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
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/koordinator/assistant-schedules');
            return;
        }

        // Validate ID
        if (!validateId($id)) {
            setFlash('danger', 'ID jadwal tidak valid.');
            $this->redirect('/koordinator/assistant-schedules');
            return;
        }

        $scheduleModel = $this->model('AssistantScheduleModel');
        $result = $scheduleModel->deleteSchedule($id);

        if ($result) {
            setFlash('success', 'Jadwal asisten berhasil dihapus.');
        } else {
            setFlash('danger', 'Gagal menghapus jadwal asisten.');
        }

        $this->redirect('/koordinator/assistant-schedules');
    }
}
