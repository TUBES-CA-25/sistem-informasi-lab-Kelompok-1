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
    // LABORATORY MANAGEMENT
    // ==========================================

    public function listLaboratories()
    {
        $laboratoryModel = $this->model('LaboratoryModel');

        $data = [
            'laboratories' => $laboratoryModel->getAllLaboratories()
        ];

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
        $schedules = $scheduleModel->getAllWithLaboratory();

        $data = [
            'schedules' => $schedules
        ];

        $this->view('admin/schedules/index', $data);
    }

    public function createScheduleForm()
    {
        $laboratoryModel = $this->model('LaboratoryModel');

        $data = [
            'laboratories' => $laboratoryModel->getAllLaboratories()
        ];

        $this->view('admin/schedules/create', $data);
    }



    private function handleFileUpload($fileInputName, $targetDir = 'uploads/schedules/')
    {
        if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES[$fileInputName]['tmp_name'];
            $fileName = basename($_FILES[$fileInputName]['name']);
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            // Generate nama unik agar tidak bentrok
            $newFileName = uniqid() . '_' . time() . '.' . $fileExt;
            $targetPath = '../public/' . $targetDir . $newFileName;

            // Pastikan folder ada
            if (!is_dir('../public/' . $targetDir)) {
                mkdir('../public/' . $targetDir, 0777, true);
            }

            if (move_uploaded_file($tmpName, $targetPath)) {
                // Kembalikan URL publik untuk disimpan di DB
                return BASE_URL . '/' . $targetDir . $newFileName;
            }
        }
        return null;
    }




    public function createSchedule()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/schedules/create');
        }

        // 1. Handle Uploads Dulu
        $lecturerPhoto = $this->handleFileUpload('lecturer_photo_file');
        $assistantPhoto = $this->handleFileUpload('assistant_photo_file');
        $assistant2Photo = $this->handleFileUpload('assistant2_photo_file');

        // 2. Ambil Input Data
        $data = [
            'laboratory_id' => sanitize($this->getPost('laboratory_id')),
            'day' => sanitize($this->getPost('day')),
            'start_time' => sanitize($this->getPost('start_time')),
            'end_time' => sanitize($this->getPost('end_time')),
            'course' => sanitize($this->getPost('course')),
            'program_study' => sanitize($this->getPost('program_study')),
            'semester' => sanitize($this->getPost('semester')),
            'class_code' => sanitize($this->getPost('class_code')),
            'frequency' => sanitize($this->getPost('frequency')), // Input Manual
            'lecturer' => sanitize($this->getPost('lecturer')),
            'assistant' => sanitize($this->getPost('assistant')),
            'assistant_2' => sanitize($this->getPost('assistant_2')),
            'participant_count' => sanitize($this->getPost('participant_count')),
            'description' => sanitize($this->getPost('description')),

            // Masukkan path hasil upload
            'lecturer_photo' => $lecturerPhoto,
            'assistant_photo' => $assistantPhoto,
            'assistant2_photo' => $assistant2Photo,
        ];

        // 3. Simpan
        $scheduleModel = $this->model('LabScheduleModel');
        if ($scheduleModel->createSchedule($data)) {
            setFlash('success', 'Jadwal berhasil dibuat dengan foto.');
            $this->redirect('/admin/schedules');
        } else {
            setFlash('danger', 'Gagal membuat jadwal.');
            $this->redirect('/admin/schedules/create');
        }
    }




    public function editScheduleForm($id)
    {
        $scheduleModel = $this->model('LabScheduleModel');
        $laboratoryModel = $this->model('LaboratoryModel');

        $schedule = $scheduleModel->getScheduleDetail($id); // Pakai method getScheduleDetail yg baru

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











    public function editSchedule($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/schedules/' . $id . '/edit');
        }

        $scheduleModel = $this->model('LabScheduleModel');
        $oldData = $scheduleModel->getScheduleDetail($id);

        // 1. Handle Uploads (Cek jika ada file baru, jika tidak pakai yang lama)
        $lecturerPhoto = $this->handleFileUpload('lecturer_photo_file') ?? $oldData['lecturer_photo'];
        $assistantPhoto = $this->handleFileUpload('assistant_photo_file') ?? $oldData['assistant_photo'];
        $assistant2Photo = $this->handleFileUpload('assistant2_photo_file') ?? $oldData['assistant2_photo'];

        $data = [
            'laboratory_id' => sanitize($this->getPost('laboratory_id')),
            'day' => sanitize($this->getPost('day')),
            'start_time' => sanitize($this->getPost('start_time')),
            'end_time' => sanitize($this->getPost('end_time')),
            'course' => sanitize($this->getPost('course')),
            'program_study' => sanitize($this->getPost('program_study')),
            'semester' => sanitize($this->getPost('semester')),
            'class_code' => sanitize($this->getPost('class_code')),
            'frequency' => sanitize($this->getPost('frequency')),
            'lecturer' => sanitize($this->getPost('lecturer')),
            'assistant' => sanitize($this->getPost('assistant')),
            'assistant_2' => sanitize($this->getPost('assistant_2')),
            'participant_count' => sanitize($this->getPost('participant_count')),
            'description' => sanitize($this->getPost('description')),

            // Path Foto
            'lecturer_photo' => $lecturerPhoto,
            'assistant_photo' => $assistantPhoto,
            'assistant2_photo' => $assistant2Photo,
        ];

        if ($scheduleModel->updateSchedule($id, $data)) {
            setFlash('success', 'Jadwal berhasil diperbarui.');
            $this->redirect('/admin/schedules');
        } else {
            setFlash('danger', 'Gagal memperbarui jadwal.');
            $this->redirect('/admin/schedules/' . $id . '/edit');
        }
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
        if ($scheduleModel->deleteSchedule($id)) {
            setFlash('success', 'Schedule deleted successfully');
        } else {
            setFlash('danger', 'Failed to delete schedule');
        }

        $this->redirect('/admin/schedules');
    }
















    // ==========================================
    // ASSISTANT SCHEDULES (PIKET) MANAGEMENT
    // ==========================================

    public function listAssistantSchedules()
    {
        $scheduleModel = $this->model('AssistantScheduleModel');

        $data = [
            'schedules' => $scheduleModel->getAllWithUser()
        ];

        $this->view('admin/assistant-schedules/list', $data);
    }

    public function createAssistantScheduleForm()
    {
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

    public function createAssistantSchedule()
    {
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
        $photoPath = $this->handleFileUpload('photo_file', 'uploads/profiles/');

        // 2. Ambil Input
        $data = [
            'user_id' => sanitize($this->getPost('user_id')),
            'position' => sanitize($this->getPost('position')), // Contoh: Kepala Lab Multimedia
            'status' => sanitize($this->getPost('status')),     // active / inactive
            'location' => sanitize($this->getPost('location')),
            'time_in' => sanitize($this->getPost('time_in')),
            'return_time' => sanitize($this->getPost('return_time')), // Jika inactive
            'notes' => sanitize($this->getPost('notes')),
            'photo' => $photoPath
        ];

        // 3. Validasi
        $errors = $this->validate($data, [
            'user_id' => 'required',
            'position' => 'required',
            'status' => 'required'
        ]);

        if (!empty($errors)) {
            setFlash('danger', 'Mohon lengkapi data wajib (User, Jabatan, Status)');
            $this->redirect('/admin/head-laboran/create');
        }

        // 4. Simpan
        $headLaboranModel = $this->model('HeadLaboranModel');

        // Cek duplikasi (User ini sudah jadi staff belum?)
        if ($headLaboranModel->isHeadLaboran($data['user_id'])) {
            setFlash('danger', 'User ini sudah terdaftar sebagai Staff/Kepala Lab.');
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

        // 1. Handle Upload Foto (Gunakan lama jika tidak ada baru)
        $photoPath = $this->handleFileUpload('photo_file', 'uploads/profiles/') ?? $oldData['photo'];

        $data = [
            'position' => sanitize($this->getPost('position')),
            'status' => sanitize($this->getPost('status')),
            'location' => sanitize($this->getPost('location')),
            'time_in' => sanitize($this->getPost('time_in')),
            'return_time' => sanitize($this->getPost('return_time')),
            'notes' => sanitize($this->getPost('notes')),
            'photo' => $photoPath
        ];

        if ($headLaboranModel->updateHeadLaboran($id, $data)) {
            setFlash('success', 'Status & Data Staff berhasil diperbarui');
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
        $coverPath = $this->handleFileUpload('image_cover_file', 'uploads/activities/');

        // 2. Ambil Input (Termasuk Link URL)
        $data = [
            'title' => sanitize($this->getPost('title')),
            'activity_type' => sanitize($this->getPost('activity_type')),
            'description' => sanitize($this->getPost('description')), // Deskripsi Singkat
            'link_url' => trim($this->getPost('link_url')),         // NEW: Link ke Berita
            'activity_date' => sanitize($this->getPost('activity_date')),
            'image_cover' => $coverPath
        ];

        // 3. Validasi
        $errors = $this->validate($data, [
            'title' => 'required',
            'link_url' => 'required', // Link wajib diisi
            'activity_date' => 'required'
        ]);

        if (!empty($errors)) {
            setFlash('danger', 'Judul, Link Berita, dan Tanggal wajib diisi.');
            $this->redirect('/admin/activities/create');
        }

        $activityModel = $this->model('LabActivityModel');
        if ($activityModel->createActivity($data)) {
            setFlash('success', 'Kegiatan berhasil diterbitkan.');
            $this->redirect('/admin/activities');
        } else {
            setFlash('danger', 'Gagal menerbitkan kegiatan.');
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

        $coverPath = $this->handleFileUpload('image_cover_file', 'uploads/activities/') ?? $oldData['image_cover'];

        $data = [
            'title' => sanitize($this->getPost('title')),
            'activity_type' => sanitize($this->getPost('activity_type')),
            'description' => sanitize($this->getPost('description')),
            'link_url' => trim($this->getPost('link_url')), // NEW
            'activity_date' => sanitize($this->getPost('activity_date')),
            'image_cover' => $coverPath
        ];

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
}
