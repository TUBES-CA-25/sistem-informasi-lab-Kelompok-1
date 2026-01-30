<?php

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

    public function listUsers()
    {
        $userModel = $this->model('UserModel');

        $data = [
            'users' => $userModel->getAllWithRoles()
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

    public function editUserForm($id)
    {
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

    public function editUser($id)
    {
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

    public function deleteUser($id)
    {
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
        $imagePath = $this->handleFileUpload('image_file', 'laboratories');

        $data = [
            'lab_name' => sanitize($this->getPost('lab_name')),
            'image' => $imagePath, // INI YANG SEBELUMNYA HILANG
            'description' => sanitize($this->getPost('description')),
            'pc_count' => (int) sanitize($this->getPost('pc_count')),
            'tv_count' => (int) sanitize($this->getPost('tv_count')),
            'location' => sanitize($this->getPost('location'))
        ];

        $laboratoryModel = $this->model('LaboratoryModel');
        $laboratoryModel->createLaboratory($data);

        setFlash('success', 'Laboratorium berhasil ditambahkan');
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
        $imagePath = $this->handleFileUpload('image_file', 'laboratories') ?? $oldData['image'];

        $data = [
            'lab_name' => sanitize($this->getPost('lab_name')),
            'image' => $imagePath, // Update Foto
            'description' => sanitize($this->getPost('description')),
            'pc_count' => (int) sanitize($this->getPost('pc_count')),
            'tv_count' => (int) sanitize($this->getPost('tv_count')),
            'location' => sanitize($this->getPost('location'))
        ];

        $laboratoryModel->updateLaboratory($id, $data);

        setFlash('success', 'Laboratorium berhasil diperbarui');
        $this->redirect('/admin/laboratories');
    }

    public function deleteLaboratory($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/laboratories');
        }

        $laboratoryModel = $this->model('LaboratoryModel');
        $laboratoryModel->deleteLaboratory($id);

        setFlash('success', 'Laboratory deleted successfully');
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

        // Tangkap tanggal dari URL (jika ada)
        $prefillDate = $this->getQuery('date') ?? '';

        $data = [
            'laboratories' => $laboratoryModel->getAllLaboratories(),
            'prefillDate' => $prefillDate // Kirim ke View
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
    /**
     * Handle file upload with standardized helper
     * 
     * @param string $fileInputName Name of file input field
     * @param string $targetDir Target directory name (lecturers, assistants, schedules)
     * @return string|null Full URL for database storage or null on failure
     */
    private function handleFileUpload($fileInputName, $targetDir = 'schedules')
    {
        if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
            $relativePath = uploadFile($_FILES[$fileInputName], $targetDir, null, 5242880, 'file');
            if ($relativePath) {
                // Return full URL for database storage
                return BASE_URL . $relativePath;
            }
        }
        return null;
    }
    public function createSchedule()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/schedules/create');
        }

        // 1. HANDLE UPLOAD 3 FOTO (Lecturer + 2 Assistants)
        $lecturerPhoto = $this->handleFileUpload('lecturer_photo_file', 'lecturers');
        $asst1Photo = $this->handleFileUpload('assistant_photo_file', 'assistants'); // Sesuai name di form
        $asst2Photo = $this->handleFileUpload('assistant2_photo_file', 'assistants'); // Sesuai name di form

        // 2. DATA MASTER (Rencana Kuliah)
        $totalMeetings = (int) sanitize($this->getPost('total_meetings'));
        if ($totalMeetings < 1) $totalMeetings = 14; // Default jika kosong

        $startDate = sanitize($this->getPost('start_date')); // Input Tanggal Mulai

        $planData = [
            'laboratory_id' => sanitize($this->getPost('laboratory_id')),
            'course_name' => sanitize($this->getPost('course')), // Sesuaikan name di form
            'program_study' => sanitize($this->getPost('program_study')),
            'semester' => sanitize($this->getPost('semester')),
            'class_code' => sanitize($this->getPost('class_code')),

            // Personil
            'lecturer_name' => sanitize($this->getPost('lecturer')),
            'lecturer_photo' => $lecturerPhoto,
            'assistant_1_name' => sanitize($this->getPost('assistant')),
            'assistant_1_photo' => $asst1Photo,
            'assistant_2_name' => sanitize($this->getPost('assistant_2')),
            'assistant_2_photo' => $asst2Photo,

            // Waktu Template
            'day' => sanitize($this->getPost('day')),
            'start_time' => sanitize($this->getPost('start_time')),
            'end_time' => sanitize($this->getPost('end_time')),
            'total_meetings' => $totalMeetings,
            'description' => sanitize($this->getPost('description')),
        ];

        $scheduleModel = $this->model('LabScheduleModel');

        // Simpan ke tabel course_plans
        // Note: insert() biasanya me-return ID, pastikan Core Model Anda mendukung ini.
        // Jika tidak, Anda harus pakai $this->db->lastInsertId();
        $planId = $scheduleModel->createCoursePlan($planData);

        if (!$planId) {
            setFlash('danger', 'Gagal menyimpan Data Rencana Kuliah.');
            $this->redirect('/admin/schedules/create');
        }

        // 3. SMART SKIP GENERATOR (Looping & Collision Check)
        $currentDate = new DateTime($startDate);
        $successCount = 0;
        $failDates = [];

        for ($i = 1; $i <= $totalMeetings; $i++) {
            $dateStr = $currentDate->format('Y-m-d');

            // Cek apakah ada jadwal lain di tanggal & jam ini?
            $isOccupied = $scheduleModel->isSlotOccupied(
                $planData['laboratory_id'],
                $dateStr,
                $planData['start_time'],
                $planData['end_time']
            );

            if (!$isOccupied) {
                // AMAN: Insert ke schedule_sessions
                $sessionData = [
                    'course_plan_id' => $planId,
                    'meeting_number' => $i,
                    'session_date' => $dateStr,
                    'start_time' => $planData['start_time'],
                    'end_time' => $planData['end_time'],
                    'status' => 'scheduled'
                ];
                $scheduleModel->createSession($sessionData);
                $successCount++;
            } else {
                // BENTROK: Lewati dan catat tanggalnya
                $failDates[] = $dateStr . " (Pertemuan ke-$i)";
            }

            // Geser tanggal ke minggu depan (+7 hari)
            $currentDate->modify('+7 days');
        }

        // 4. FEEDBACK KE ADMIN
        if (empty($failDates)) {
            setFlash('success', "Sukses! $successCount pertemuan berhasil dijadwalkan tanpa bentrok.");
            $this->redirect('/admin/schedules'); // Redirect ke List
        } else {
            // Ada yang bentrok
            $failMsg = implode(', ', $failDates);
            setFlash('warning', "<b>Jadwal Parsial:</b> Berhasil menyimpan $successCount pertemuan.<br> 
            <b>GAGAL (Bentrok) pada:</b> $failMsg.<br> 
            Silakan cek Kalender dan input manual jadwal pengganti untuk tanggal tersebut.");
            $this->redirect('/admin/schedules'); // Redirect ke List (atau Kalender nanti)
        }
    }
    public function editScheduleForm($id)
    {
        $scheduleModel = $this->model('LabScheduleModel');
        $laboratoryModel = $this->model('LaboratoryModel');

        $schedule = $scheduleModel->getScheduleDetail($id);

        if (!$schedule) {
            setFlash('danger', 'Jadwal tidak ditemukan');
            $this->redirect('/admin/schedules');
        }

        // AMBIL JUMLAH SESI SAAT INI
        $totalSessions = $scheduleModel->countSessions($id);

        $data = [
            'schedule' => $schedule,
            'totalSessions' => $totalSessions, // Kirim ke View
            'laboratories' => $laboratoryModel->getAllLaboratories()
        ];

        $this->view('admin/schedules/edit', $data);
    }
    public function editSchedule($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/schedules/' . $id . '/edit');
        }

        $scheduleModel = $this->model('LabScheduleModel');
        $oldData = $scheduleModel->getScheduleDetail($id);

        // 1. Handle Uploads
        $lecturerPhoto = $this->handleFileUpload('lecturer_photo_file', 'lecturers') ?? $oldData['lecturer_photo'];
        $assistantPhoto = $this->handleFileUpload('assistant_photo_file', 'assistants') ?? $oldData['assistant_1_photo'];
        $assistant2Photo = $this->handleFileUpload('assistant2_photo_file', 'assistants') ?? $oldData['assistant_2_photo'];

        // 2. Data Update Master
        $data = [
            'laboratory_id'   => sanitize($this->getPost('laboratory_id')),
            'day'             => sanitize($this->getPost('day')),
            'start_time'      => sanitize($this->getPost('start_time')),
            'end_time'        => sanitize($this->getPost('end_time')),
            'course_name'     => sanitize($this->getPost('course_name')),
            'program_study'   => sanitize($this->getPost('program_study')),
            'semester'        => sanitize($this->getPost('semester')),
            'class_code'      => sanitize($this->getPost('class_code')),
            'lecturer_name'   => sanitize($this->getPost('lecturer_name')),
            'assistant_1_name' => sanitize($this->getPost('assistant_1_name')),
            'assistant_2_name' => sanitize($this->getPost('assistant_2_name')),
            'description'     => sanitize($this->getPost('description')),
            'lecturer_photo'    => $lecturerPhoto,
            'assistant_1_photo' => $assistantPhoto,
            'assistant_2_photo' => $assistant2Photo
        ];

        // Update Master Plan
        $scheduleModel->updateSchedule($id, $data);

        // 3. UPDATE JAM SEMUA SESI (Opsional, agar sinkron)
        // Jika user mengubah jam di master, update juga semua sesi anak yang belum selesai
        $scheduleModel->updateAllSessionsTime($id, $data['start_time'], $data['end_time']);

        // 4. LOGIKA UBAH TOTAL PERTEMUAN (LOOPING)
        $newTotal = (int) $this->getPost('total_meetings');
        $currentTotal = $scheduleModel->countSessions($id);

        if ($newTotal > $currentTotal) {
            // CASE A: NAMBAH PERTEMUAN
            // Ambil tanggal sesi terakhir
            $lastSession = $scheduleModel->getLastSessionDate($id);
            if ($lastSession) {
                $lastDate = new DateTime($lastSession['session_date']);
                $lastMeetingNum = $lastSession['meeting_number'];
            } else {
                // Fallback jika anehnya kosong, pakai hari ini
                $lastDate = new DateTime();
                $lastMeetingNum = 0;
            }

            $diff = $newTotal - $currentTotal;
            for ($i = 1; $i <= $diff; $i++) {
                $lastDate->modify('+7 days'); // Tambah 1 minggu dari sesi terakhir
                $meetingNum = $lastMeetingNum + $i;

                $sessionData = [
                    'course_plan_id' => $id,
                    'meeting_number' => $meetingNum,
                    'session_date' => $lastDate->format('Y-m-d'),
                    'start_time' => $data['start_time'],
                    'end_time' => $data['end_time'],
                    'status' => 'scheduled'
                ];
                $scheduleModel->createSession($sessionData);
            }
            setFlash('success', "Jadwal diperbarui. $diff sesi baru berhasil ditambahkan.");
        } elseif ($newTotal < $currentTotal) {
            // CASE B: KURANGI PERTEMUAN
            // Hapus sesi dari yang paling belakang
            $diff = $currentTotal - $newTotal;
            $scheduleModel->deleteSessionsFromEnd($id, $diff);
            setFlash('warning', "Jadwal diperbarui. $diff sesi terakhir telah dihapus.");
        } else {
            // Tidak ada perubahan jumlah
            setFlash('success', 'Data Master Jadwal berhasil diperbarui.');
        }

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

        // 3. OLAH DATA MENJADI MATRIKS
        // Struktur: $matrix['Putra']['Monday'] = [Data Asisten A, Data Asisten B]
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $matrix = [
            'Putri' => array_fill_keys($days, []),
            'Putra' => array_fill_keys($days, [])
        ];

        foreach ($rawSchedules as $row) {
            $role = $row['job_role']; // 'Putra' atau 'Putri'
            $day  = $row['day'];

            // Masukkan ke slot yang sesuai jika role valid
            if (isset($matrix[$role][$day])) {
                $matrix[$role][$day][] = $row;
            }
        }

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

            $this->model('AssistantScheduleModel')->createSchedule($data);
            setFlash('success', 'Jadwal asisten berhasil ditambahkan.');
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

            $scheduleModel->updateSchedule($id, $data);
            setFlash('success', 'Jadwal berhasil diperbarui.');
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
        }

        $scheduleModel = $this->model('AssistantScheduleModel');
        $scheduleModel->deleteSchedule($id);

        setFlash('success', 'Assistant schedule deleted successfully');
        $this->redirect('/admin/assistant-schedules');
    }

    public function updateJobdesk()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $role = sanitize($this->getPost('role'));
            $content = sanitize($this->getPost('content'));

            $key = ($role == 'Putra') ? 'job_putra' : 'job_putri';

            // Simpan ke SettingsModel
            $this->model('SettingsModel')->save($key, $content);

            setFlash('success', "Deskripsi tugas $role berhasil diperbarui.");
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
        $photoPath = $this->handleFileUpload('photo_file', 'profiles');

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

        $photoPath = $this->handleFileUpload('photo_file', 'profiles') ?? $oldData['photo'];

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
        $coverPath = $this->handleFileUpload('image_cover_file', 'activities');

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
        $coverPath = $this->handleFileUpload('image_cover_file', 'activities') ?? $oldData['image_cover'];

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
        $problemModel->updateProblem($id, ['status' => $status]);

        // Add to history
        $historyModel = $this->model('ProblemHistoryModel');
        $historyModel->addHistory($id, $status, $note);

        setFlash('success', 'Problem status updated successfully');
        $this->redirect('/admin/problems/' . $id);
    }

    public function deleteProblem($id)
    {
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

        $this->model('LabProblemModel')->updateProblem($id, $data);
        $this->model('ProblemHistoryModel')->addHistory($id, 'reported', 'Detail masalah diupdate oleh Admin');

        setFlash('success', 'Data masalah berhasil diperbarui.');
        $this->redirect('/admin/problems/' . $id);
    }

    public function assignProblem($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('/admin/problems/' . $id);

        $assignedTo = sanitize($this->getPost('assigned_to'));

        // Update assigned_to
        $this->model('LabProblemModel')->updateProblem($id, ['assigned_to' => $assignedTo]);

        // Ambil nama asisten untuk history
        $assignee = $this->model('UserModel')->find($assignedTo);
        $this->model('ProblemHistoryModel')->addHistory($id, 'reported', 'Admin menugaskan ke: ' . $assignee['name']);

        setFlash('success', 'Tugas berhasil diberikan.');
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
}