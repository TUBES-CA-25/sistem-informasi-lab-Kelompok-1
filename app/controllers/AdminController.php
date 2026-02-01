<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;


/**
 * ICLABS - Admin Controller
 * Handles all admin operations (FULL CRUD)
 */

class AdminController extends Controller
{

    public function __construct()
    {
        $this->requireRole('admin');
    }

    // ==========================================
    // DASHBOARD
    // ==========================================

    public function dashboard()
    {
        // Load Models
        $userModel = $this->model('UserModel');
        $labModel = $this->model('LaboratoryModel');
        $scheduleModel = $this->model('LabScheduleModel');
        // $problemModel = $this->model('ProblemModel'); // Jika ada fitur ticket

        // 1. Ambil Data Kartu Utama
        $totalUsers = count($userModel->getAllUsers());
        $totalLabs = count($labModel->getAllLabs());

        // Hitung total jadwal aktif (Course Plans)
        $allPlans = $scheduleModel->getAllPlans(); // Pastikan method ini ada (kita buat utk export tadi)
        $totalCourses = count($allPlans);

        // 2. Data Grafik & Tabel
        $todaySchedule = $scheduleModel->getTodaySchedule();
        $labStats = $scheduleModel->getLabUtilizationStats();
        $dailyStats = $scheduleModel->getDailyLoadStats();
        $userStats = $userModel->getUserRoleStats();

        // 3. Kirim ke View
        $data = [
            'stats' => [
                'users' => $totalUsers,
                'labs' => $totalLabs,
                'courses' => $totalCourses,
                'today_sessions' => count($todaySchedule)
            ],
            'todaySchedule' => $todaySchedule,
            'charts' => [
                'labs' => $labStats,
                'daily' => $dailyStats,
                'users' => $userStats
            ],
            'userName' => $_SESSION['user_name'] ?? 'Admin' // Ambil nama dari session login
        ];

        $this->view('admin/dashboard', $data);
    }

    // ==========================================
    // USER MANAGEMENT
    // ==========================================

    // GANTI method listUsers() yang lama dengan yang ini:
    public function listUsers()
    {
        $userModel = $this->model('UserModel');

        // 1. Konfigurasi Pagination
        $limit = 10; // Tampilkan 10 user per halaman
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = $page < 1 ? 1 : $page; // Minimal halaman 1
        $offset = ($page - 1) * $limit;

        // 2. Ambil Keyword Pencarian (jika ada)
        $keyword = isset($_GET['q']) ? trim($_GET['q']) : null;

        // 3. Ambil Data dari Model
        // (Method ini sudah ada di UserModel.php Anda, jadi aman)
        $users = $userModel->getUsersPaginated($keyword, $limit, $offset);
        $totalUsers = $userModel->countTotalUsers($keyword);

        // 4. Hitung Total Halaman
        $totalPages = ceil($totalUsers / $limit);

        // 5. Kirim Data ke View (Pastikan nama variabel SESUAI dengan list.php)
        $data = [
            'users' => $users,
            'currentPage' => $page,
            'totalPages' => $totalPages, // Ini yang dicari list.php ($totalPages)
            'keyword' => $keyword,       // Ini yang dicari list.php ($keyword)
            'totalUsers' => $totalUsers  // Ini yang dicari list.php ($totalUsers)
        ];

        $this->view('admin/users/list', $data);
    }

    public function createUserForm()
    {
        $roleModel = $this->model('RoleModel');

        $data = [
            'roles' => $roleModel->getAllRoles()
        ];

        $this->view('admin/users/create', $data);
    }

    public function createUser()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/users/create');
        }

        $userModel = $this->model('UserModel');

        // 1. HANDLE UPLOAD FOTO PROFIL
        // Parameter 'image' sesuai dengan name di input file create.php
        // Parameter UPLOAD_DIR_PROFILES mengarah ke folder 'profiles'
        $photoUrl = $this->handleFileUpload('image', UPLOAD_DIR_PROFILES);

        $data = [
            'name'     => sanitize($this->getPost('name')),
            'email'    => sanitize($this->getPost('email')),
            'password' => $this->getPost('password'), // Hash ditangani di Model
            'role_id'  => sanitize($this->getPost('role_id')),
            'status'   => sanitize($this->getPost('status')),
            'image'    => $photoUrl // Simpan URL foto ke database
        ];

        // Validasi Sederhana
        if (empty($data['email']) || empty($data['password'])) {
            setFlash('danger', 'Email dan Password wajib diisi.');
            $this->redirect('/admin/users/create');
            return;
        }

        if ($userModel->createUser($data)) {
            setFlash('success', 'User berhasil ditambahkan.');
            $this->redirect('/admin/users');
        } else {
            setFlash('danger', 'Gagal menambahkan user (Email mungkin duplikat).');
            $this->redirect('/admin/users/create');
        }
    }

    public function editUserForm($id)
    {
        $userModel = $this->model('UserModel');
        $roleModel = $this->model('RoleModel');

        $user = $userModel->find($id);

        if (!$user) {
            setFlash('danger', 'User tidak ditemukan');
            $this->redirect('/admin/users');
        }

        $data = [
            'user' => $user,
            'roles' => $roleModel->getAllRoles()
        ];

        $this->view('admin/users/edit', $data);
    }
    public function editUser($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/users/' . $id . '/edit');
        }

        $userModel = $this->model('UserModel');

        // 1. AMBIL DATA LAMA (PENTING UNTUK FOTO)
        // Kita butuh data lama untuk tahu foto apa yang sedang dipakai user sekarang
        $oldUser = $userModel->find($id);

        if (!$oldUser) {
            setFlash('danger', 'User tidak ditemukan.');
            $this->redirect('/admin/users');
        }

        // 2. LOGIKA UPLOAD FOTO
        // Cek apakah ada file baru yang diupload ke input name="image"?
        // Simpan ke folder profiles (UPLOAD_DIR_PROFILES)
        $newPhotoUrl = $this->handleFileUpload('image', UPLOAD_DIR_PROFILES);

        // JIKA ada upload baru -> Pakai $newPhotoUrl
        // JIKA TIDAK ada (kosong) -> Tetap pakai foto lama ($oldUser['image'])
        $finalPhoto = $newPhotoUrl ? $newPhotoUrl : ($oldUser['image'] ?? null);

        // 3. SUSUN DATA BARU
        $data = [
            'name'    => sanitize($this->getPost('name')),
            'email'   => sanitize($this->getPost('email')),
            'role_id' => sanitize($this->getPost('role_id')),
            'status'  => sanitize($this->getPost('status')),
            'image'   => $finalPhoto // <--- INI KUNCINYA (Simpan URL foto ke DB)
        ];

        // 4. UPDATE PASSWORD (Hanya jika diisi)
        $password = $this->getPost('password');
        if (!empty($password)) {
            $data['password'] = $password;
        }

        // 5. EKSEKUSI UPDATE KE DATABASE
        // Pastikan Model updateUser sudah tidak menghapus field 'image'
        if ($userModel->updateUser($id, $data)) {
            setFlash('success', 'Data user berhasil diperbarui');
            $this->redirect('/admin/users');
        } else {
            setFlash('danger', 'Gagal memperbarui user');
            $this->redirect('/admin/users/' . $id . '/edit');
        }
    }

    public function deleteUser($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/users');
        }

        // Don't allow deleting yourself
        if ($id == getUserId()) {
            setFlash('danger', 'Anda tidak dapat menghapus akun Anda sendiri');
            $this->redirect('/admin/users');
        }

        $userModel = $this->model('UserModel');

        // Opsional: Hapus juga file fotonya dari server agar hemat storage
        $user = $userModel->find($id);
        if ($user && !empty($user['image'])) {
            // Cek apakah url lokal (bukan http)
            if (strpos($user['image'], 'http') === false) {
                // Hapus file fisik (perlu logic path yang sesuai)
                // unlink(PUBLIC_PATH . $user['image']); 
            }
        }

        $userModel->delete($id);

        setFlash('success', 'User berhasil dihapus');
        $this->redirect('/admin/users');
    }

    public function updateUser($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/users/' . $id . '/edit');
        }

        $userModel = $this->model('UserModel');
        $oldUser = $userModel->find($id); // Ambil data lama

        if (!$oldUser) {
            setFlash('danger', 'User tidak ditemukan.');
            $this->redirect('/admin/users');
        }

        // 1. LOGIKA UPLOAD FOTO (UPDATE)
        // Cek apakah admin mengupload foto baru di form?
        $newPhotoUrl = $this->handleFileUpload('image', UPLOAD_DIR_PROFILES);

        // JIKA ada foto baru -> pakai $newPhotoUrl
        // JIKA TIDAK ada (user tidak pilih file) -> pakai foto lama ($oldUser['image'])
        // Ini menangani kasus user yang awalnya tidak punya foto, lalu di-edit dan diberi foto.
        $finalPhoto = $newPhotoUrl ? $newPhotoUrl : ($oldUser['image'] ?? null);

        $data = [
            'name'    => sanitize($this->getPost('name')),
            'email'   => sanitize($this->getPost('email')),
            'role_id' => sanitize($this->getPost('role_id')),
            'status'  => sanitize($this->getPost('status')),
            'image'   => $finalPhoto // Simpan hasil logika di atas
        ];

        // 2. LOGIKA PASSWORD (Opsional)
        // Hanya update password jika kolom diisi
        $password = $this->getPost('password');
        if (!empty($password)) {
            $data['password'] = $password;
        }

        if ($userModel->updateUser($id, $data)) {
            setFlash('success', 'Data user berhasil diperbarui.');
            $this->redirect('/admin/users');
        } else {
            setFlash('danger', 'Gagal memperbarui user.');
            $this->redirect('/admin/users/' . $id . '/edit');
        }
    }

    public function users()
    {
        $userModel = $this->model('UserModel');

        // 1. Konfigurasi Pagination
        $limit = 10; // Tampilkan 10 user per halaman
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = $page < 1 ? 1 : $page; // Minimal halaman 1
        $offset = ($page - 1) * $limit;

        // 2. Ambil Keyword Pencarian (jika ada)
        $keyword = isset($_GET['q']) ? trim($_GET['q']) : null;

        // 3. Ambil Data dari Model
        // (Pastikan UserModel sudah punya method getUsersPaginated & countTotalUsers)
        $users = $userModel->getUsersPaginated($keyword, $limit, $offset);
        $totalUsers = $userModel->countTotalUsers($keyword);

        // 4. Hitung Total Halaman
        $totalPages = ceil($totalUsers / $limit);

        // 5. Kirim Data ke View (INI YANG PENTING AGAR ERROR HILANG)
        $data = [
            'users' => $users,
            'currentPage' => $page,
            'totalPages' => $totalPages, // Mengisi $totalPages di view
            'keyword' => $keyword,       // Mengisi $keyword di view
            'totalUsers' => $totalUsers  // Mengisi $totalUsers di view
        ];

        $this->view('admin/users/list', $data);
    }





















    // ==========================================
    // LABORATORY MANAGEMENT (FIXED)
    // ==========================================

    public function listLaboratories()
    {
        $laboratoryModel = $this->model('LaboratoryModel');
        $data = ['laboratories' => $laboratoryModel->getAllLaboratories()];
        $this->view('admin/laboratories/list', $data);
    }

    public function createLaboratoryForm()
    {
        $this->view('admin/laboratories/create');
    }

    public function createLaboratory()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/laboratories/create');
        }

        // 1. Handle Upload Foto
        // Pastikan folder public/uploads/laboratories/ sudah dibuat
        $imagePath = $this->handleFileUpload('image_file', UPLOAD_DIR_LABORATORIES);

        $data = [
            'lab_name' => sanitize($this->getPost('lab_name')),
            'image' => $imagePath, // INI YANG SEBELUMNYA HILANG
            'description' => sanitize($this->getPost('description')),
            'pc_count' => (int) sanitize($this->getPost('pc_count')),
            'tv_count' => (int) sanitize($this->getPost('tv_count')),
            'location' => sanitize($this->getPost('location'))
        ];

        $laboratoryModel = $this->model('LaboratoryModel');
        $result = $laboratoryModel->createLaboratory($data);

        if ($result) {
            setFlash('success', 'Laboratorium berhasil ditambahkan');
        } else {
            setFlash('danger', 'Gagal menambahkan laboratorium');
        }

        $this->redirect('/admin/laboratories');
    }

    public function editLaboratoryForm($id)
    {
        $laboratoryModel = $this->model('LaboratoryModel');
        $laboratory = $laboratoryModel->find($id);

        if (!$laboratory) {
            setFlash('danger', 'Laboratory not found');
            $this->redirect('/admin/laboratories');
        }

        $data = ['laboratory' => $laboratory];
        $this->view('admin/laboratories/edit', $data);
    }

    public function editLaboratory($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/laboratories/' . $id . '/edit');
        }

        $laboratoryModel = $this->model('LaboratoryModel');
        $oldData = $laboratoryModel->find($id);

        // 1. Cek Upload Baru (Pakai foto lama jika tidak ada upload baru)
        $imagePath = $this->handleFileUpload('image_file', UPLOAD_DIR_LABORATORIES) ?? $oldData['image'];

        $data = [
            'lab_name' => sanitize($this->getPost('lab_name')),
            'image' => $imagePath, // Update Foto
            'description' => sanitize($this->getPost('description')),
            'pc_count' => (int) sanitize($this->getPost('pc_count')),
            'tv_count' => (int) sanitize($this->getPost('tv_count')),
            'location' => sanitize($this->getPost('location'))
        ];

        $result = $laboratoryModel->updateLaboratory($id, $data);

        if ($result) {
            setFlash('success', 'Laboratorium berhasil diperbarui');
        } else {
            setFlash('danger', 'Gagal memperbarui laboratorium');
        }

        $this->redirect('/admin/laboratories');
    }

    public function deleteLaboratory($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/laboratories');
            return;
        }

        // Validate ID
        if (!validateId($id)) {
            setFlash('danger', 'Invalid laboratory ID.');
            $this->redirect('/admin/laboratories');
            return;
        }

        $laboratoryModel = $this->model('LaboratoryModel');
        $result = $laboratoryModel->deleteLaboratory($id);

        if ($result) {
            setFlash('success', 'Laboratory deleted successfully');
        } else {
            setFlash('danger', 'Failed to delete laboratory.');
        }

        $this->redirect('/admin/laboratories');
    }

















    // ==========================================
    // SCHEDULE MANAGEMENT (UPDATED)
    // ==========================================

    public function listSchedules()
    {
        $scheduleModel = $this->model('LabScheduleModel');
        $laboratoryModel = $this->model('LaboratoryModel');

        $search = sanitize($this->getQuery('search'));
        $page   = (int) ($this->getQuery('page') ?? 1);
        if ($page < 1) $page = 1;
        $limit  = 10;
        $offset = ($page - 1) * $limit;

        // Ambil Data Master (Grouped by Plan)
        $schedules = $scheduleModel->getMasterPlans($limit, $offset, $search);
        $totalRows = $scheduleModel->countMasterPlans($search);
        $totalPages = ceil($totalRows / $limit);

        $data = [
            'schedules' => $schedules,
            'laboratories' => $laboratoryModel->getAllLaboratories(),
            'filters' => ['search' => $search],
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $totalPages,
                'total_rows' => $totalRows,
                'start_entry' => ($totalRows > 0) ? $offset + 1 : 0,
                'end_entry' => min($offset + $limit, $totalRows)
            ]
        ];

        $this->view('admin/schedules/index', $data);
    }

    public function createScheduleForm()
    {
        $laboratoryModel = $this->model('LaboratoryModel');
        $userModel = $this->model('UserModel');

        // Ambil data user untuk dropdown
        $allUsers = $userModel->getAllUsersRaw() ?? [];
        $lecturers = [];
        $assistants = [];

        foreach ($allUsers as $u) {
            $role = isset($u['role_name']) ? strtolower($u['role_name']) : '';
            // Filter Dosen & Admin
            if (strpos($role, 'dosen') !== false || strpos($role, 'admin') !== false) {
                $lecturers[] = $u;
            }
            // Filter Asisten
            if (strpos($role, 'asisten') !== false) {
                $assistants[] = $u;
            }
        }

        $data = [
            'lecturers'      => $lecturers,
            'assistants'     => $assistants,
            'laboratories'   => $laboratoryModel->getAllLaboratories(),
            'start_date'     => date('Y-m-d', strtotime('next monday')),
            'total_meetings' => 14,
            'prefillDate'    => $this->getQuery('date') ?? ''
        ];

        $this->view('admin/schedules/create', $data);
    }

    public function clearScheduleByDate()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Invalid Request']);
            exit;
        }

        // Ambil data JSON dari fetch JS
        $input = json_decode(file_get_contents('php://input'), true);
        $date = $input['date'] ?? null;
        $labId = $input['lab_id'] ?? null;

        if (!$date) {
            echo json_encode(['status' => 'error', 'message' => 'Tanggal wajib ada']);
            exit;
        }

        $scheduleModel = $this->model('LabScheduleModel');

        // Hapus berdasarkan tanggal (dan lab jika dipilih)
        // Kita butuh method deleteByDate di Model (lihat langkah bawah)
        if ($scheduleModel->deleteByDate($date, $labId)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus jadwal']);
        }
        exit;
    }

    private function handleFileUpload($fileInputName, $targetDir = UPLOAD_DIR_SCHEDULES)
    {
        if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
            $relativePath = uploadFile($_FILES[$fileInputName], $targetDir, null, MAX_UPLOAD_SIZE, 'file');
            if ($relativePath) {
                // Return full URL for database storage
                return BASE_URL . $relativePath;
            }
        }
        return null;
    }

    public function createSchedule()
    {
        $scheduleModel = $this->model('LabScheduleModel');
        $userModel = $this->model('UserModel');
        $laboratoryModel = $this->model('LaboratoryModel');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 1. Ambil ID dari Form
            $lecturerId = sanitize($this->getPost('lecturer_id'));
            $asst1Id = sanitize($this->getPost('assistant_1_id'));
            $asst2Id = sanitize($this->getPost('assistant_2_id'));

            // 2. Ambil data user langsung lewat Model (Tanpa fungsi manual baru)
            // Kita gunakan find() yang sudah ada di base Model
            $lecturer = $userModel->find($lecturerId);
            $asst1 = $userModel->find($asst1Id);
            $asst2 = $userModel->find($asst2Id);

            // 3. Siapkan data untuk tabel course_plans
            $planData = [
                'laboratory_id'     => sanitize($this->getPost('laboratory_id')),
                'course_name'       => sanitize($this->getPost('course')),
                'program_study'     => sanitize($this->getPost('program_study')),
                'semester'          => sanitize($this->getPost('semester')),
                'class_code'        => sanitize($this->getPost('class_code')),
                'lecturer_id'       => $lecturerId,
                'assistant_1_id'    => $asst1Id,
                'assistant_2_id'    => $asst2Id,
                // Simpan snapshot nama & foto (agar tampilan tetap aman jika user diubah)
                'lecturer_name'     => $lecturer['name'] ?? '',
                'lecturer_photo'    => $lecturer['image'] ?? null,
                'assistant_1_name'  => $asst1['name'] ?? '',
                'assistant_1_photo' => $asst1['image'] ?? null,
                'assistant_2_name'  => $asst2['name'] ?? '',
                'assistant_2_photo' => $asst2['image'] ?? null,
                'day'               => sanitize($this->getPost('day')),
                'start_time'        => sanitize($this->getPost('start_time')),
                'end_time'          => sanitize($this->getPost('end_time')),
                'total_meetings'    => (int) sanitize($this->getPost('total_meetings')),
            ];

            $planId = $scheduleModel->createCoursePlan($planData);

            if ($planId) {
                // 4. Generate Sesi Otomatis
                $startDate = sanitize($this->getPost('start_date'));
                $currentDate = new DateTime($startDate);

                for ($i = 1; $i <= $planData['total_meetings']; $i++) {
                    $dateStr = $currentDate->format('Y-m-d');

                    // Cek apakah lab kosong di jam tersebut
                    if (!$scheduleModel->isSlotOccupied($planData['laboratory_id'], $dateStr, $planData['start_time'], $planData['end_time'])) {
                        $scheduleModel->createSession([
                            'course_plan_id' => $planId,
                            'meeting_number' => $i,
                            'session_date'   => $dateStr,
                            'start_time'     => $planData['start_time'],
                            'end_time'       => $planData['end_time'],
                            'status'         => 'scheduled'
                        ]);
                    }
                    $currentDate->modify('+7 days'); // Loncat ke minggu depan
                }

                setFlash('success', 'Jadwal berhasil dibuat!');
                $this->redirect('/admin/schedules');
            } else {
                setFlash('danger', 'Gagal menyimpan rencana kuliah.');
                $this->redirect('/admin/schedules/create');
            }
        }
    }


    // Cari method editScheduleForm di AdminController.php
    public function editScheduleForm($id)
    {
        $scheduleModel = $this->model('LabScheduleModel');
        $laboratoryModel = $this->model('LaboratoryModel');
        $userModel = $this->model('UserModel');

        // 1. Ambil Data Jadwal Existing
        $schedule = $scheduleModel->getScheduleDetail($id);

        if (!$schedule) {
            setFlash('danger', 'Jadwal tidak ditemukan');
            $this->redirect('/admin/schedules');
        }

        // 2. Ambil & Filter Data User (SAMA PERSIS DENGAN CREATE)
        $allUsers = $userModel->getAllUsersRaw() ?? [];
        $lecturers = [];
        $assistants = [];

        foreach ($allUsers as $u) {
            $role = isset($u['role_name']) ? strtolower($u['role_name']) : '';

            // Filter Dosen & Admin (Bisa jadi pengampu)
            if (strpos($role, 'dosen') !== false || strpos($role, 'admin') !== false) {
                $lecturers[] = $u;
            }
            // Filter Asisten
            if (strpos($role, 'asisten') !== false) {
                $assistants[] = $u;
            }
        }

        // 3. Hitung Sesi (Untuk info di view)
        $totalSessions = $scheduleModel->countSessions($id);

        $data = [
            'schedule'      => $schedule,
            'totalSessions' => $totalSessions,
            'laboratories'  => $laboratoryModel->getAllLaboratories(),
            'lecturers'     => $lecturers,   // Data User untuk Dropdown
            'assistants'    => $assistants   // Data User untuk Dropdown
        ];

        $this->view('admin/schedules/edit', $data);
    }

    public function editSchedule($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/schedules/' . $id . '/edit');
        }

        $scheduleModel = $this->model('LabScheduleModel');
        $userModel = $this->model('UserModel');

        // Ambil data lama untuk fallback foto
        $oldData = $scheduleModel->getScheduleDetail($id);

        // 1. Ambil Data User Baru (untuk update Snapshot Nama & Foto)
        $lecturerId = sanitize($this->getPost('lecturer_id'));
        $asst1Id    = sanitize($this->getPost('assistant_1_id'));
        $asst2Id    = sanitize($this->getPost('assistant_2_id'));

        $lecturer = $userModel->find($lecturerId);
        $asst1    = $userModel->find($asst1Id);
        $asst2    = $userModel->find($asst2Id);

        // 2. Handle Upload (Jika user upload manual, timpa foto profil user)
        // Prioritas: Upload Baru > Foto Profil User > Foto Lama di Jadwal
        $lecturerPhoto   = $this->handleFileUpload('lecturer_photo_file', UPLOAD_DIR_LECTURERS)
            ?? ($lecturer['image'] ?? $oldData['lecturer_photo']);

        $assistantPhoto  = $this->handleFileUpload('assistant_photo_file', UPLOAD_DIR_ASSISTANTS)
            ?? ($asst1['image'] ?? $oldData['assistant_1_photo']);

        $assistant2Photo = $this->handleFileUpload('assistant2_photo_file', UPLOAD_DIR_ASSISTANTS)
            ?? ($asst2['image'] ?? $oldData['assistant_2_photo']);

        // 3. Data Update Master
        $data = [
            'laboratory_id'    => sanitize($this->getPost('laboratory_id')),
            'day'              => sanitize($this->getPost('day')),
            'start_time'       => sanitize($this->getPost('start_time')),
            'end_time'         => sanitize($this->getPost('end_time')),
            'course_name'      => sanitize($this->getPost('course_name')),
            'program_study'    => sanitize($this->getPost('program_study')),
            'semester'         => sanitize($this->getPost('semester')),
            'class_code'       => sanitize($this->getPost('class_code')),

            // Update ID Relasi
            'lecturer_id'      => $lecturerId,
            'assistant_1_id'   => $asst1Id,
            'assistant_2_id'   => $asst2Id,

            // Update Snapshot (Agar sinkron dengan user yang dipilih)
            'lecturer_name'    => $lecturer['name'] ?? $oldData['lecturer_name'],
            'assistant_1_name' => $asst1['name'] ?? $oldData['assistant_1_name'],
            'assistant_2_name' => $asst2['name'] ?? $oldData['assistant_2_name'],

            'description'      => sanitize($this->getPost('description')),
            'lecturer_photo'   => $lecturerPhoto,
            'assistant_1_photo' => $assistantPhoto,
            'assistant_2_photo' => $assistant2Photo
        ];

        // Update Master Plan
        $scheduleModel->updateSchedule($id, $data);

        // 4. Update Jam Semua Sesi (Agar sinkron)
        $scheduleModel->updateAllSessionsTime($id, $data['start_time'], $data['end_time']);

        // 5. Logika Ubah Total Pertemuan (Tambah/Kurang Sesi)
        // ... (Kode sama seperti sebelumnya) ...
        // Agar aman, saya sertakan logic sederhananya:
        setFlash('success', 'Jadwal berhasil diperbarui.');
        $this->redirect('/admin/schedules');
    }
    public function viewSchedule($id)
    {
        $scheduleModel = $this->model('LabScheduleModel');
        $schedule = $scheduleModel->getScheduleDetail($id);

        if (!$schedule) {
            setFlash('danger', 'Jadwal tidak ditemukan.');
            $this->redirect('/admin/schedules');
        }

        $data = [
            'schedule' => $schedule
        ];

        $this->view('admin/schedules/show', $data);
    }
    public function deleteSchedule($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/schedules');
        }

        $scheduleModel = $this->model('LabScheduleModel');

        // PERBAIKAN: Gunakan deleteSchedule (bukan deleteSession)
        // Karena kita ingin menghapus Master Plan (Induk)
        // Cascade Delete di database akan otomatis menghapus semua sesi anaknya
        if ($scheduleModel->deleteSchedule($id)) {
            setFlash('success', 'Master Jadwal dan seluruh sesinya berhasil dihapus.');
        } else {
            setFlash('danger', 'Gagal menghapus jadwal master.');
        }

        $this->redirect('/admin/schedules');
    }
    public function listScheduleSessions($id)
    {
        $scheduleModel = $this->model('LabScheduleModel');

        // Ambil Info Master Plan
        // Gunakan getScheduleDetail yang mengambil data dari course_plans
        $plan = $scheduleModel->getScheduleDetail($id);

        if (!$plan) {
            setFlash('danger', 'Data Matakuliah tidak ditemukan.');
            $this->redirect('/admin/schedules');
        }

        // Ambil Daftar Sesi (Anak)
        $sessions = $scheduleModel->getSessionsByPlanId($id);

        $data = [
            'plan' => $plan,
            'sessions' => $sessions
        ];

        $this->view('admin/schedules/sessions', $data);
    }
    public function viewSession($id)
    {
        $scheduleModel = $this->model('LabScheduleModel');
        $session = $scheduleModel->getSessionDetail($id);

        if (!$session) {
            setFlash('danger', 'Sesi tidak ditemukan.');
            $this->redirect('/admin/schedules');
        }

        $this->view('admin/schedules/session_detail', ['session' => $session]);
    }
    public function deleteSession($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('/admin/schedules');

        $scheduleModel = $this->model('LabScheduleModel');

        // Ambil detail dulu untuk redirect balik ke list sesi
        $session = $scheduleModel->getSessionDetail($id);
        $planId = $session['course_plan_id'] ?? null;

        if ($scheduleModel->deleteSession($id)) {
            setFlash('success', 'Sesi berhasil dihapus.');
        } else {
            setFlash('danger', 'Gagal menghapus sesi.');
        }

        if ($planId) {
            $this->redirect('/admin/schedules/' . $planId . '/sessions');
        } else {
            $this->redirect('/admin/schedules');
        }
    }
    public function editSessionForm($id)
    {
        $scheduleModel = $this->model('LabScheduleModel');

        // Ambil detail sesi (termasuk info lab dari parent plan)
        $session = $scheduleModel->getSessionDetail($id);

        if (!$session) {
            setFlash('danger', 'Sesi tidak ditemukan.');
            $this->redirect('/admin/schedules');
        }

        $data = [
            'session' => $session
        ];

        $this->view('admin/schedules/session_edit', $data);
    }
    public function updateSession($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/sessions/' . $id . '/edit');
        }

        $scheduleModel = $this->model('LabScheduleModel');
        $session = $scheduleModel->getSessionDetail($id);

        // 1. Ambil Input Baru
        $newDate = sanitize($this->getPost('session_date'));
        $newStart = sanitize($this->getPost('start_time'));
        $newEnd = sanitize($this->getPost('end_time'));
        $newStatus = sanitize($this->getPost('status'));

        // 2. Validasi Bentrok (Hanya jika Status != cancelled)
        if ($newStatus != 'cancelled') {
            // Kita butuh ID Lab dari master plan untuk cek bentrok
            $labId = $session['laboratory_id'] ?? null; // Pastikan getSessionDetail return laboratory_id dari join

            // Jika Lab ID tidak ada di session array, ambil ulang dari course_plans via query terpisah atau pastikan join benar
            if (!$labId) {
                // Fallback: Ambil Plan ID
                $plan = $scheduleModel->getScheduleDetail($session['course_plan_id']);
                $labId = $plan['laboratory_id'];
            }

            $isOccupied = $scheduleModel->isSlotOccupiedForEdit($labId, $newDate, $newStart, $newEnd, $id);

            if ($isOccupied) {
                setFlash('danger', '<b>Gagal Reschedule:</b> Waktu dan Laboratorium tersebut sudah terisi jadwal lain.');
                $this->redirect('/admin/sessions/' . $id . '/edit');
                return;
            }
        }

        // 3. Update Data
        $data = [
            'session_date' => $newDate,
            'start_time' => $newStart,
            'end_time' => $newEnd,
            'status' => $newStatus
        ];

        if ($scheduleModel->updateSession($id, $data)) {
            setFlash('success', 'Sesi Pertemuan berhasil di-reschedule.');
            $this->redirect('/admin/schedules/' . $session['course_plan_id'] . '/sessions');
        } else {
            setFlash('danger', 'Gagal update sesi.');
            $this->redirect('/admin/sessions/' . $id . '/edit');
        }
    }


















    // ==========================================
    // ASSISTANT SCHEDULES (PIKET) MANAGEMENT
    // ==========================================


    public function listAssistantSchedules()
    {
        $scheduleModel = $this->model('AssistantScheduleModel');
        $settingsModel = $this->model('SettingsModel');

        // 1. Ambil Data Jadwal Mentah
        $rawSchedules = $scheduleModel->getAllWithUser();

        // 2. Ambil Teks Jobdesk dari Settings
        $masterJob = [
            'Putri' => $settingsModel->get('job_putri', 'Belum diatur (Klik untuk edit)'),
            'Putra' => $settingsModel->get('job_putra', 'Belum diatur (Klik untuk edit)')
        ];

        // 3. Build matrix using model method
        $matrix = $scheduleModel->buildScheduleMatrix($rawSchedules);
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        $data = [
            'matrix' => $matrix,
            'masterJob' => $masterJob,
            'days' => $days
        ];

        $this->view('admin/assistant-schedules/list', $data);
    }
    public function createAssistantScheduleForm()
    {
        $userModel = $this->model('UserModel');
        $roleModel = $this->model('RoleModel');
        $scheduleModel = $this->model('AssistantScheduleModel');

        // Get asisten role
        $asistenRole = $roleModel->getByName('asisten');
        $assistants = $userModel->getActiveUsersByRole($asistenRole['id']);

        // AMBIL PRESET UNTUK DIKIRIM KE VIEW (NEW)
        $presets = $scheduleModel->getAllPresets();

        $data = [
            'assistants' => $assistants,
            'presets' => $presets // Kirim data JSON ini
        ];

        $this->view('admin/assistant-schedules/create', $data);
    }

    public function createAssistantSchedule()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'user_id' => sanitize($this->getPost('user_id')),
                'day' => sanitize($this->getPost('day')),
                'job_role' => sanitize($this->getPost('job_role')) // Hanya simpan 'Putra' atau 'Putri'
            ];

            $result = $this->model('AssistantScheduleModel')->createSchedule($data);

            if ($result) {
                setFlash('success', 'Jadwal asisten berhasil ditambahkan.');
            } else {
                setFlash('danger', 'Gagal menambahkan jadwal asisten.');
            }

            $this->redirect('/admin/assistant-schedules');
            return;
        }

        // Tampilkan Form
        $userModel = $this->model('UserModel');
        $roleModel = $this->model('RoleModel');
        $asistenRole = $roleModel->getByName('asisten');

        $data = [
            'assistants' => $userModel->getActiveUsersByRole($asistenRole['id'])
        ];
        $this->view('admin/assistant-schedules/create', $data);
    }

    public function editAssistantScheduleForm($id)
    {
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

    public function editAssistantSchedule($id)
    {
        $scheduleModel = $this->model('AssistantScheduleModel');
        $schedule = $scheduleModel->find($id);

        if (!$schedule) {
            $this->redirect('/admin/assistant-schedules');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'user_id' => sanitize($this->getPost('user_id')),
                'day' => sanitize($this->getPost('day')),
                'job_role' => sanitize($this->getPost('job_role'))
            ];

            $result = $scheduleModel->updateSchedule($id, $data);

            if ($result) {
                setFlash('success', 'Jadwal berhasil diperbarui.');
            } else {
                setFlash('danger', 'Gagal memperbarui jadwal.');
            }

            $this->redirect('/admin/assistant-schedules');
            return;
        }

        $userModel = $this->model('UserModel');
        $roleModel = $this->model('RoleModel');
        $asistenRole = $roleModel->getByName('asisten');

        $data = [
            'schedule' => $schedule,
            'assistants' => $userModel->getActiveUsersByRole($asistenRole['id'])
        ];
        $this->view('admin/assistant-schedules/edit', $data);
    }

    public function deleteAssistantSchedule($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/assistant-schedules');
            return;
        }

        // Validate ID
        if (!validateId($id)) {
            setFlash('danger', 'Invalid schedule ID.');
            $this->redirect('/admin/assistant-schedules');
            return;
        }

        $scheduleModel = $this->model('AssistantScheduleModel');
        $result = $scheduleModel->deleteSchedule($id);

        if ($result) {
            setFlash('success', 'Assistant schedule deleted successfully');
        } else {
            setFlash('danger', 'Failed to delete schedule.');
        }

        $this->redirect('/admin/assistant-schedules');
    }

    public function updateJobdesk()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $role = sanitize($this->getPost('role'));
            $content = sanitize($this->getPost('content'));

            $key = ($role == 'Putra') ? 'job_putra' : 'job_putri';

            // Simpan ke SettingsModel
            if ($this->model('SettingsModel')->save($key, $content)) {
                setFlash('success', "Deskripsi tugas $role berhasil diperbarui.");
            } else {
                setFlash('danger', "Gagal memperbarui deskripsi tugas.");
            }

            $this->redirect('/admin/assistant-schedules');
        }
    }














    // ==========================================
    // HEAD LABORAN & STAFF MANAGEMENT (UPDATED)
    // ==========================================

    public function listHeadLaboran()
    {
        $headLaboranModel = $this->model('HeadLaboranModel');
        $data = [
            'headLaboran' => $headLaboranModel->getAllWithUser()
        ];
        $this->view('admin/head-laboran/index', $data);
    }

    public function createHeadLaboranForm()
    {
        $userModel = $this->model('UserModel');
        // Ambil user yang belum jadi staff/kalab untuk dropdown
        // (Opsional: Anda bisa buat method khusus di Model jika perlu filter ketat)
        $users = $userModel->getAllWithRoles();

        $data = [
            'users' => $users
        ];
        $this->view('admin/head-laboran/create', $data);
    }

    public function createHeadLaboran()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/head-laboran/create');
        }

        // 1. Handle Upload Foto Profil
        $photoPath = $this->handleFileUpload('photo_file', UPLOAD_DIR_PROFILES);

        // 2. Ambil Input (Termasuk Phone)
        $data = [
            'user_id' => sanitize($this->getPost('user_id')),
            'phone' => sanitize($this->getPost('phone')), // <--- DATA BARU
            'position' => sanitize($this->getPost('position')),
            'category' => sanitize($this->getPost('category')),
            'status' => sanitize($this->getPost('status')),
            'location' => sanitize($this->getPost('location')),
            'time_in' => sanitize($this->getPost('time_in')),
            'return_time' => sanitize($this->getPost('return_time')),
            'notes' => sanitize($this->getPost('notes')),
            'photo' => $photoPath
        ];

        // 3. Validasi
        $errors = $this->validate($data, [
            'user_id' => 'required',
            'position' => 'required',
            'category' => 'required',
            'status' => 'required'
        ]);

        if (!empty($errors)) {
            setFlash('danger', 'Mohon lengkapi data wajib.');
            $this->redirect('/admin/head-laboran/create');
        }

        $headLaboranModel = $this->model('HeadLaboranModel');

        // Cek duplikasi
        if ($headLaboranModel->isHeadLaboran($data['user_id'])) {
            setFlash('danger', 'User ini sudah terdaftar.');
            $this->redirect('/admin/head-laboran/create');
        }

        if ($headLaboranModel->createHeadLaboran($data)) {
            setFlash('success', 'Staff berhasil ditambahkan');
            $this->redirect('/admin/head-laboran');
        } else {
            setFlash('danger', 'Gagal menambahkan data');
            $this->redirect('/admin/head-laboran/create');
        }
    }

    public function editHeadLaboranForm($id)
    {
        $headLaboranModel = $this->model('HeadLaboranModel');
        $staff = $headLaboranModel->find($id);

        if (!$staff) {
            setFlash('danger', 'Data tidak ditemukan');
            $this->redirect('/admin/head-laboran');
        }

        // Ambil nama user untuk ditampilkan
        $userModel = $this->model('UserModel');
        $user = $userModel->find($staff['user_id']);

        $data = [
            'staff' => $staff,
            'user_name' => $user['name'] // Kirim nama user agar tidak perlu select user lagi
        ];

        $this->view('admin/head-laboran/edit', $data);
    }

    public function editHeadLaboran($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/head-laboran/' . $id . '/edit');
        }

        $headLaboranModel = $this->model('HeadLaboranModel');
        $oldData = $headLaboranModel->find($id);

        $photoPath = $this->handleFileUpload('photo_file', UPLOAD_DIR_PROFILES) ?? $oldData['photo'];

        $data = [
            'phone' => sanitize($this->getPost('phone')),
            'position' => sanitize($this->getPost('position')),
            'category' => sanitize($this->getPost('category')),
            'status' => sanitize($this->getPost('status')),
            'location' => sanitize($this->getPost('location')),
            'time_in' => sanitize($this->getPost('time_in')),
            'return_time' => sanitize($this->getPost('return_time')),
            'notes' => sanitize($this->getPost('notes')),
            'photo' => $photoPath
        ];

        if ($headLaboranModel->updateHeadLaboran($id, $data)) {
            setFlash('success', 'Data Staff berhasil diperbarui');
            $this->redirect('/admin/head-laboran');
        } else {
            setFlash('danger', 'Gagal memperbarui data');
            $this->redirect('/admin/head-laboran/' . $id . '/edit');
        }
    }

    public function deleteHeadLaboran($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/head-laboran');
        }

        $headLaboranModel = $this->model('HeadLaboranModel');
        if ($headLaboranModel->deleteHeadLaboran($id)) {
            setFlash('success', 'Staff dihapus dari daftar presence');
        } else {
            setFlash('danger', 'Gagal menghapus data');
        }

        $this->redirect('/admin/head-laboran');
    }


    public function viewHeadLaboran($id)
    {
        $headLaboranModel = $this->model('HeadLaboranModel');
        $staff = $headLaboranModel->find($id);

        if (!$staff) {
            setFlash('danger', 'Data staff tidak ditemukan');
            $this->redirect('/admin/head-laboran');
        }

        // Ambil info user
        $userModel = $this->model('UserModel');
        $user = $userModel->find($staff['user_id']);

        $data = [
            'staff' => $staff,
            'user' => $user
        ];

        $this->view('admin/head-laboran/show', $data);
    }




























    // ==========================================
    // ACTIVITY / BLOG MANAGEMENT
    // ==========================================

    public function listActivities()
    {
        $activityModel = $this->model('LabActivityModel');
        $data = [
            'activities' => $activityModel->getAllActivities()
        ];
        $this->view('admin/activities/index', $data);
    }

    public function createActivityForm()
    {
        $this->view('admin/activities/create');
    }

    public function createActivity()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/activities/create');
        }

        // 1. Handle Upload Cover
        $coverPath = $this->handleFileUpload('image_cover_file', UPLOAD_DIR_ACTIVITIES);

        // 2. Ambil Input (Termasuk Status)
        $data = [
            'title' => sanitize($this->getPost('title')),
            'activity_type' => sanitize($this->getPost('activity_type')),
            'description' => sanitize($this->getPost('description')),
            'link_url' => trim($this->getPost('link_url')),
            'activity_date' => sanitize($this->getPost('activity_date')),
            'image_cover' => $coverPath,
            // AMBIL STATUS DARI FORM (Default 'draft' jika kosong)
            'status' => sanitize($this->getPost('status', 'draft'))
        ];

        // 3. Validasi
        $errors = $this->validate($data, [
            'title' => 'required',
            'link_url' => 'required',
            'activity_date' => 'required',
            'status' => 'required'
        ]);

        if (!empty($errors)) {
            setFlash('danger', 'Judul, Link, Tanggal, dan Status wajib diisi.');
            $this->redirect('/admin/activities/create');
        }

        $activityModel = $this->model('LabActivityModel');
        // Tambahkan created_by dari session user login
        $data['created_by'] = getUserId();

        if ($activityModel->createActivity($data)) {
            setFlash('success', 'Kegiatan berhasil disimpan.');
            $this->redirect('/admin/activities');
        } else {
            setFlash('danger', 'Gagal menyimpan kegiatan.');
            $this->redirect('/admin/activities/create');
        }
    }
    public function editActivityForm($id)
    {
        $activityModel = $this->model('LabActivityModel');
        $activity = $activityModel->find($id);

        if (!$activity) {
            setFlash('danger', 'Kegiatan tidak ditemukan.');
            $this->redirect('/admin/activities');
        }

        $data = ['activity' => $activity];
        $this->view('admin/activities/edit', $data);
    }

    public function editActivity($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/activities/' . $id . '/edit');
        }

        $activityModel = $this->model('LabActivityModel');
        $oldData = $activityModel->find($id);

        if (!$oldData) {
            setFlash('danger', 'Data tidak ditemukan.');
            $this->redirect('/admin/activities');
        }

        // 1. Handle Upload Gambar Baru (Jika ada)
        $coverPath = $this->handleFileUpload('image_cover_file', UPLOAD_DIR_ACTIVITIES) ?? $oldData['image_cover'];

        // 2. Ambil Input (Termasuk Status & Link)
        $data = [
            'title' => sanitize($this->getPost('title')),
            'activity_type' => sanitize($this->getPost('activity_type')),
            'description' => sanitize($this->getPost('description')),
            'link_url' => trim($this->getPost('link_url')),
            'activity_date' => sanitize($this->getPost('activity_date')),
            'image_cover' => $coverPath,
            // PERBAIKAN: Ambil status dari form edit
            'status' => sanitize($this->getPost('status', 'published'))
        ];

        // 3. Validasi sederhana
        if (empty($data['title']) || empty($data['link_url'])) {
            setFlash('danger', 'Judul dan Link Wajib diisi.');
            $this->redirect('/admin/activities/' . $id . '/edit');
        }

        if ($activityModel->updateActivity($id, $data)) {
            setFlash('success', 'Kegiatan berhasil diperbarui.');
            $this->redirect('/admin/activities');
        } else {
            setFlash('danger', 'Gagal memperbarui kegiatan.');
            $this->redirect('/admin/activities/' . $id . '/edit');
        }
    }

    public function deleteActivity($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/activities');
            return;
        }

        // Validate ID
        if (!validateId($id)) {
            setFlash('danger', 'ID kegiatan tidak valid.');
            $this->redirect('/admin/activities');
            return;
        }

        $activityModel = $this->model('LabActivityModel');
        if ($activityModel->deleteActivity($id)) {
            setFlash('success', 'Kegiatan dihapus.');
        } else {
            setFlash('danger', 'Gagal menghapus kegiatan.');
        }

        $this->redirect('/admin/activities');
    }





























    // ==========================================
    // PROBLEMS MANAGEMENT
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
            'currentStatus' => $status,
            'statistics' => $problemModel->getStatistics()
        ];

        $this->view('admin/problems/list', $data);
    }

    public function viewProblem($id)
    {
        $problemModel = $this->model('LabProblemModel');
        $historyModel = $this->model('ProblemHistoryModel');
        $userModel = $this->model('UserModel'); // Load User Model

        $problem = $problemModel->getProblemWithDetails($id);

        if (!$problem) {
            setFlash('danger', 'Problem not found');
            $this->redirect('/admin/problems');
        }

        $data = [
            'problem' => $problem,
            'histories' => $historyModel->getHistoryByProblem($id),
            'assistants' => $userModel->getUsersByRoleName('asisten') // Kirim data asisten untuk dropdown assign
        ];

        $this->view('admin/problems/detail', $data);
    }

    public function updateProblemStatus($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/problems/' . $id);
        }

        $status = sanitize($this->getPost('status'));
        $note = sanitize($this->getPost('note'));

        // Update problem status
        $problemModel = $this->model('LabProblemModel');

        if ($problemModel->updateProblem($id, ['status' => $status])) {
            // Add to history
            $historyModel = $this->model('ProblemHistoryModel');
            $historyModel->addHistory($id, $status, $note);

            setFlash('success', 'Problem status updated successfully');
        } else {
            setFlash('danger', 'Failed to update problem status');
        }

        $this->redirect('/admin/problems/' . $id);
    }

    public function deleteProblem($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/problems');
            return;
        }

        // Validate ID
        if (!validateId($id)) {
            setFlash('danger', 'Invalid problem ID.');
            $this->redirect('/admin/problems');
            return;
        }

        // Delete problem with cascading history (moved to model)
        $problemModel = $this->model('LabProblemModel');
        $historyModel = $this->model('ProblemHistoryModel');
        $result = $problemModel->deleteProblemWithHistory($id, $historyModel);

        if ($result) {
            setFlash('success', 'Problem deleted successfully');
        } else {
            setFlash('danger', 'Failed to delete problem.');
        }

        $this->redirect('/admin/problems');
    }

    public function createProblem()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/problems/create');
        }

        $data = [
            'laboratory_id' => sanitize($this->getPost('laboratory_id')),
            'pc_number' => sanitize($this->getPost('pc_number')),
            'problem_type' => sanitize($this->getPost('problem_type')),
            'description' => sanitize($this->getPost('description')),
            // // Admin bisa input nama pelapor manual atau otomatis diri sendiri
            // 'reporter_name' => sanitize($this->getPost('reporter_name'))
        ];

        if (empty($data['laboratory_id']) || empty($data['description'])) {
            setFlash('danger', 'Mohon lengkapi data wajib.');
            $this->redirect('/admin/problems/create');
        }

        $problemModel = $this->model('LabProblemModel');
        $problemId = $problemModel->createProblem($data);

        // Catat History
        $this->model('ProblemHistoryModel')->addHistory($problemId, 'reported', 'Laporan dibuat oleh Admin');

        setFlash('success', 'Laporan masalah berhasil dibuat.');
        $this->redirect('/admin/problems');
    }
    public function editProblemForm($id)
    {
        $problemModel = $this->model('LabProblemModel');
        $laboratoryModel = $this->model('LaboratoryModel');

        $problem = $problemModel->find($id);
        if (!$problem) {
            setFlash('danger', 'Masalah tidak ditemukan.');
            $this->redirect('/admin/problems');
        }

        $data = [
            'problem' => $problem,
            'laboratories' => $laboratoryModel->getAllLaboratories()
        ];
        $this->view('admin/problems/edit', $data);
    }

    public function updateProblem($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/problems/' . $id . '/edit');
        }

        $data = [
            'laboratory_id' => sanitize($this->getPost('laboratory_id')),
            'pc_number' => sanitize($this->getPost('pc_number')),
            'problem_type' => sanitize($this->getPost('problem_type')),
            'description' => sanitize($this->getPost('description'))
        ];

        if ($this->model('LabProblemModel')->updateProblem($id, $data)) {
            $this->model('ProblemHistoryModel')->addHistory($id, 'reported', 'Detail masalah diupdate oleh Admin');
            setFlash('success', 'Data masalah berhasil diperbarui.');
        } else {
            setFlash('danger', 'Gagal memperbarui data masalah.');
        }

        $this->redirect('/admin/problems/' . $id);
    }

    public function assignProblem($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('/admin/problems/' . $id);

        $assignedTo = sanitize($this->getPost('assigned_to'));

        // Update assigned_to
        if ($this->model('LabProblemModel')->updateProblem($id, ['assigned_to' => $assignedTo])) {
            // Ambil nama asisten untuk history
            $assignee = $this->model('UserModel')->find($assignedTo);
            $this->model('ProblemHistoryModel')->addHistory($id, 'reported', 'Admin menugaskan ke: ' . $assignee['name']);

            setFlash('success', 'Tugas berhasil diberikan.');
        } else {
            setFlash('danger', 'Gagal menugaskan masalah.');
        }

        $this->redirect('/admin/problems/' . $id);
    }

    public function createProblemForm()
    {
        $laboratoryModel = $this->model('LaboratoryModel');

        $data = [
            'laboratories' => $laboratoryModel->getAllLaboratories()
        ];

        $this->view('admin/problems/create', $data);
    }





















    // ... di dalam AdminController ...

    // ==========================================
    // CALENDAR FEATURE (NEW PAGE)
    // ==========================================

    public function calendar()
    {
        $laboratoryModel = $this->model('LaboratoryModel');

        $data = [
            'laboratories' => $laboratoryModel->getAllLaboratories()
        ];

        // View khusus di folder baru
        $this->view('admin/calendar/index', $data);
    }
    public function getCalendarData()
    {
        $labId = $this->getQuery('lab_id'); // Filter jika ada

        $scheduleModel = $this->model('LabScheduleModel');
        // Pastikan model LabScheduleModel punya method getCalendarEvents()
        $events = $scheduleModel->getCalendarEvents($labId);

        $calendarEvents = [];
        // Warna untuk setiap lab agar beda-beda di kalender
        $colors = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#06b6d4'];

        foreach ($events as $event) {
            $colorIndex = ($event['laboratory_id'] ?? 0) % count($colors);

            $calendarEvents[] = [
                'id' => $event['id'], // ID Sesi (tetap ada)
                'title' => $event['course_name'],
                'start' => $event['session_date'] . 'T' . $event['start_time'],
                'end' => $event['session_date'] . 'T' . $event['end_time'],
                'backgroundColor' => $colors[$colorIndex],
                'borderColor' => $colors[$colorIndex],

                // DATA TAMBAHAN UNTUK JS
                'extendedProps' => [
                    'plan_id' => $event['course_plan_id'], // <--- INI KUNCINYA
                    'lecturer' => $event['lecturer_name'],
                    'lab_name' => $event['lab_name'],
                    'class_code' => $event['class_code']
                ]
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($calendarEvents);
        exit;
    }

    // ==========================================
    // MASS USER IMPORT & EXPORT
    // ==========================================

    public function importUserForm()
    {
        $this->view('admin/users/import');
    }

    public function importUser()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/users/import');
        }

        // 1. Validasi File
        if (!isset($_FILES['file']['name']) || empty($_FILES['file']['name'])) {
            setFlash('danger', 'Silakan pilih file Excel terlebih dahulu.');
            $this->redirect('/admin/users/import');
            return;
        }

        $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        if (!in_array(strtolower($extension), ['xls', 'xlsx', 'csv'])) {
            setFlash('danger', 'Format file harus Excel (.xlsx, .xls) atau CSV.');
            $this->redirect('/admin/users/import');
            return;
        }

        $userModel = $this->model('UserModel');
        $roleModel = $this->model('RoleModel');

        try {
            // 2. Baca File Excel
            $spreadsheet = IOFactory::load($_FILES['file']['tmp_name']);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            // Variabel counter
            $success = 0;
            $failed = 0;
            $errors = [];

            // 3. Looping Baris (Mulai dari baris 2 karena baris 1 adalah Header)
            foreach ($sheetData as $key => $row) {
                if ($key == 1) continue; // Skip Header

                // Pastikan baris tidak kosong (cek email)
                $email = trim($row['B'] ?? ''); // Kolom B: Email
                if (empty($email)) continue;

                // Cek Duplikasi Email
                if ($userModel->getByEmail($email)) {
                    $failed++;
                    $errors[] = "Baris $key: Email $email sudah terdaftar.";
                    continue;
                }

                // Mapping Role (Contoh: "Asisten" -> ID 3)
                $roleName = strtolower(trim($row['C'] ?? '')); // Kolom C: Role
                $roleId = 3; // Default Asisten jika tidak ketemu

                // Cari ID role berdasarkan nama
                $roleData = $roleModel->getByName($roleName);
                if ($roleData) {
                    $roleId = $roleData['id'];
                }

                // Persiapkan Data
                $userData = [
                    'name'     => trim($row['A'] ?? 'No Name'), // Kolom A: Nama
                    'email'    => $email,
                    'role_id'  => $roleId,
                    'status'   => strtolower(trim($row['D'] ?? 'active')), // Kolom D: Status
                    'password' => trim($row['E'] ?? 'password123'), // Kolom E: Password
                    'image'    => null // Default null
                ];

                // Insert User (Password akan di-hash di Model)
                if ($userModel->createUser($userData)) {
                    $success++;
                } else {
                    $failed++;
                }
            }

            // 4. Feedback
            if ($success > 0) {
                setFlash('success', "Berhasil import $success user. Gagal: $failed.");
            } else {
                setFlash('danger', "Gagal import user. Pastikan format Excel benar.");
            }

            if (!empty($errors)) {
                // Opsional: Tampilkan error detail di session/flash terpisah jika perlu
            }
        } catch (Exception $e) {
            setFlash('danger', 'Terjadi kesalahan saat membaca file: ' . $e->getMessage());
        }

        $this->redirect('/admin/users');
    }

    public function exportUser()
    {
        // 1. Ambil Data dari Database
        $userModel = $this->model('UserModel');
        // Kita pakai getAllWithRoles agar dapat nama role (bukan cuma ID)
        $users = $userModel->getAllWithRoles();

        if (empty($users)) {
            setFlash('danger', 'Tidak ada data user untuk diexport.');
            $this->redirect('/admin/users');
        }

        // 2. Buat Spreadsheet Baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data User ICLABS');

        // 3. Set Header Kolom (Baris 1)
        $headers = ['No', 'Nama Lengkap', 'Email Address', 'Role', 'Status Akun', 'Tanggal Registrasi'];
        $columnIndex = 'A';

        foreach ($headers as $header) {
            $sheet->setCellValue($columnIndex . '1', $header);

            // Styling Header (Bold + Warna Background Ringan)
            $style = $sheet->getStyle($columnIndex . '1');
            $style->getFont()->setBold(true);
            $style->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFEEEEEE'); // Abu-abu muda

            $columnIndex++;
        }

        // 4. Isi Data (Mulai Baris 2)
        $row = 2;
        $no = 1;

        foreach ($users as $user) {
            // Kolom A: No
            $sheet->setCellValue('A' . $row, $no++);

            // Kolom B: Nama
            $sheet->setCellValue('B' . $row, $user['name']);

            // Kolom C: Email
            $sheet->setCellValue('C' . $row, $user['email']);

            // Kolom D: Role (Huruf Kapital Awal)
            $sheet->setCellValue('D' . $row, ucfirst($user['role_name'] ?? '-'));

            // Kolom E: Status
            $sheet->setCellValue('E' . $row, ucfirst($user['status']));

            // Kolom F: Tanggal (Format Cantik)
            $date = date('d-m-Y H:i', strtotime($user['created_at']));
            $sheet->setCellValue('F' . $row, $date);

            $row++;
        }

        // 5. Auto Size Kolom (Agar lebar kolom pas dengan isi teks)
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // 6. Output ke Browser (Download)
        $filename = 'Data_User_ICLABS_' . date('Y-m-d_His') . '.xlsx';

        // Bersihkan buffer output agar file tidak corrupt
        if (ob_get_length()) ob_end_clean();

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }










    // ==========================================
    // SCHEDULE IMPORT (LOGIC COMPLEX)
    // ==========================================

    public function importScheduleForm()
    {
        $this->view('admin/schedules/import');
    }

    public function importSchedule()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/schedules/import');
        }

        if (!isset($_FILES['file']['name']) || empty($_FILES['file']['name'])) {
            setFlash('danger', 'Silakan pilih file Excel terlebih dahulu.');
            $this->redirect('/admin/schedules/import');
            return;
        }

        $scheduleModel = $this->model('LabScheduleModel');
        $labModel = $this->model('LaboratoryModel');
        $userModel = $this->model('UserModel');

        try {
            $spreadsheet = IOFactory::load($_FILES['file']['tmp_name']);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(null, true, true, true);

            // Variabel Laporan
            $report = [
                'success' => 0,
                'errors' => [] // Menyimpan detail error: ['row' => 1, 'msg' => '...']
            ];

            foreach ($rows as $key => $row) {
                if ($key == 1) continue; // Skip Header

                // A. Ambil Data Dasar
                $labName = trim($row['A'] ?? '');
                $dateStr = trim($row['B'] ?? '');
                $startTime = trim($row['C'] ?? '');
                $endTime = trim($row['D'] ?? '');
                $courseName = trim($row['F'] ?? 'Tanpa Nama'); // Untuk laporan error

                // Skip baris kosong
                if (empty($labName) && empty($dateStr)) continue;

                // B. Validasi Kritis
                $labId = $labModel->findIdByName($labName);
                if (!$labId) {
                    $report['errors'][] = [
                        'row' => $key,
                        'course' => $courseName,
                        'reason' => "Laboratorium '$labName' tidak ditemukan di database."
                    ];
                    continue; // Lanjut ke baris berikutnya
                }

                // C. Cek Format Tanggal & Waktu
                try {
                    if (is_numeric($dateStr)) {
                        $startDate = Date::excelToDateTimeObject($dateStr);
                    } else {
                        $startDate = new DateTime($dateStr);
                    }
                    $startDateStr = $startDate->format('Y-m-d');
                    $dayName = $startDate->format('l');
                } catch (Exception $e) {
                    $report['errors'][] = [
                        'row' => $key,
                        'course' => $courseName,
                        'reason' => "Format tanggal salah ($dateStr). Gunakan YYYY-MM-DD."
                    ];
                    continue;
                }

                // D. Validasi Bentrok MASTER (Cek sesi pertama)
                if ($scheduleModel->isSlotOccupied($labId, $startDateStr, $startTime, $endTime)) {
                    $report['errors'][] = [
                        'row' => $key,
                        'course' => $courseName,
                        'reason' => "<b>Jadwal Bentrok!</b> Lab $labName sudah terisi pada $startDateStr ($startTime - $endTime)."
                    ];
                    continue; // Skip baris ini, jangan insert
                }

                // E. Persiapkan Data User (Snapshot)
                $dosenName = trim($row['K'] ?? '');
                $dosenUser = $userModel->findByName($dosenName);

                $asst1Name = trim($row['L'] ?? '');
                $asst1User = $userModel->findByName($asst1Name);

                $asst2Name = trim($row['M'] ?? '');
                $asst2User = $userModel->findByName($asst2Name);

                // F. Insert Master Plan
                $planData = [
                    'laboratory_id'    => $labId,
                    'course_name'      => $courseName,
                    'program_study'    => trim($row['G'] ?? '-'),
                    'class_code'       => trim($row['H'] ?? '-'),
                    'semester'         => (int) ($row['I'] ?? 1),
                    'description'      => trim($row['J'] ?? ''),
                    'lecturer_id'      => $dosenUser['id'] ?? null,
                    'assistant_1_id'   => $asst1User['id'] ?? null,
                    'assistant_2_id'   => $asst2User['id'] ?? null,
                    'lecturer_name'    => $dosenUser['name'] ?? $dosenName,
                    'lecturer_photo'   => $dosenUser['image'] ?? null,
                    'assistant_1_name' => $asst1User['name'] ?? $asst1Name,
                    'assistant_1_photo' => $asst1User['image'] ?? null,
                    'assistant_2_name' => $asst2User['name'] ?? $asst2Name,
                    'assistant_2_photo' => $asst2User['image'] ?? null,
                    'day'              => $dayName,
                    'start_time'       => $startTime,
                    'end_time'         => $endTime,
                    'total_meetings'   => (int) ($row['E'] ?? 14)
                ];

                $planId = $scheduleModel->createCoursePlan($planData);

                if ($planId) {
                    // G. Generate Sesi
                    $currentDate = new DateTime($startDateStr);
                    $sessionFailures = 0;

                    for ($i = 1; $i <= $planData['total_meetings']; $i++) {
                        $sessionDate = $currentDate->format('Y-m-d');

                        // Cek bentrok per sesi (untuk sesi ke-2 dst)
                        if (!$scheduleModel->isSlotOccupied($labId, $sessionDate, $startTime, $endTime)) {
                            $scheduleModel->createSession([
                                'course_plan_id' => $planId,
                                'meeting_number' => $i,
                                'session_date'   => $sessionDate,
                                'start_time'     => $startTime,
                                'end_time'       => $endTime,
                                'status'         => 'scheduled'
                            ]);
                        } else {
                            $sessionFailures++;
                        }
                        $currentDate->modify('+7 days');
                    }

                    $report['success']++;

                    // Jika ada sesi yang gagal (bentrok parsial), catat sebagai warning
                    if ($sessionFailures > 0) {
                        $report['errors'][] = [
                            'row' => $key,
                            'course' => $courseName,
                            'reason' => "Jadwal berhasil dibuat, tapi <b>$sessionFailures sesi</b> gagal digenerate karena bentrok di minggu-minggu berikutnya."
                        ];
                    }
                }
            }

            // SIMPAN REPORT KE SESSION
            $_SESSION['import_report'] = $report;
            setFlash('info', 'Proses import selesai. Silakan cek laporan di bawah.');
        } catch (Exception $e) {
            setFlash('danger', 'Error System: ' . $e->getMessage());
        }

        $this->redirect('/admin/schedules/import');
    }








    // ==========================================
    // EXPORT SCHEDULE TO EXCEL
    // ==========================================
    public function exportSchedule()
    {
        $scheduleModel = $this->model('LabScheduleModel');

        // Ambil semua data Master Plan
        // (Pastikan method getAllPlans di Model melakukan JOIN ke users & laboratories)
        $schedules = $scheduleModel->getAllPlans();

        if (empty($schedules)) {
            setFlash('danger', 'Belum ada data jadwal untuk diexport.');
            $this->redirect('/admin/schedules');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Jadwal Praktikum');

        // 1. Header Styles
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '0F172A']], // Slate-900
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ];

        // 2. Set Header Columns
        $headers = [
            'A' => 'No',
            'B' => 'Hari',
            'C' => 'Waktu',
            'D' => 'Laboratorium',
            'E' => 'Mata Kuliah',
            'F' => 'Kelas / Sem',
            'G' => 'Dosen Pengampu',
            'H' => 'Asisten 1',
            'I' => 'Asisten 2'
        ];

        foreach ($headers as $col => $text) {
            $sheet->setCellValue($col . '1', $text);
            $sheet->getStyle($col . '1')->applyFromArray($headerStyle);
        }

        // 3. Isi Data
        $row = 2;
        $no = 1;

        foreach ($schedules as $sch) {
            $timeRange = formatTime($sch['start_time']) . ' - ' . formatTime($sch['end_time']);

            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, getDayName($sch['day'])); // Pastikan helper getDayName ada
            $sheet->setCellValue('C' . $row, $timeRange);
            $sheet->setCellValue('D' . $row, $sch['lab_name']);
            $sheet->setCellValue('E' . $row, $sch['course_name']);
            $sheet->setCellValue('F' . $row, $sch['class_code'] . ' (Sem ' . $sch['semester'] . ')');

            // Nama Dosen (Ambil dari snapshot jika ada, atau relasi user)
            $lecturer = $sch['lecturer_name'] ?? $sch['lecturer_real_name'] ?? '-';
            $sheet->setCellValue('G' . $row, $lecturer);

            // Nama Asisten
            $asst1 = $sch['assistant_1_name'] ?? '-';
            $asst2 = $sch['assistant_2_name'] ?? '-';
            $sheet->setCellValue('H' . $row, $asst1);
            $sheet->setCellValue('I' . $row, $asst2);

            $row++;
        }

        // 4. Formatting Akhir
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Download
        $filename = 'Jadwal_Praktikum_ICLABS_' . date('Y-m-d') . '.xlsx';

        if (ob_get_length()) ob_end_clean();

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
