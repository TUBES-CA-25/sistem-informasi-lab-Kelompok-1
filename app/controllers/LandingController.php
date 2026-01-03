<?php

/**
 * ICLABS - Landing Controller
 * Handles public pages with updated logic
 */

class LandingController extends Controller
{

    /**
     * Dashboard / Landing Page
     * - Welcome Message
     * - Stats (Labs, Assistants, Lecturers)
     * - Lab Carousel Data
     * - Blog Activities
     */
    public function index()
    {
        $labModel = $this->model('LaboratoryModel');
        $userModel = $this->model('UserModel');
        $activityModel = $this->model('LabActivityModel');

        // 1. Statistics Data
        $stats = [
            'labs_count' => $labModel->countLaboratories(),
            // Asisten = Role ID 3
            'assistants_count' => $userModel->countByRole(3),
            // Dosen/Staff (Kita pakai Koordinator/Role 2 sebagai proxy data dosen)
            'lecturers_count' => $userModel->countByRole(2)
        ];

        // 2. Data for Lab Carousel
        // Mengambil semua lab untuk ditampilkan fotonya di kanan
        $labs = $labModel->getAllLaboratories();

        // 3. Blog Activities
        // Mengambil 6 kegiatan terakhir untuk bagian bawah
        $activities = $activityModel->getPublicActivities(6);

        $data = [
            'stats' => $stats,
            'labs' => $labs,
            'activities' => $activities
        ];

        $this->view('landing/index', $data);
    }

    /**
     * Laboratory Schedule Page
     * Menampilkan tabel jadwal (Prodi, MK, Kelas, dll)
     */
    public function schedule()
    {
        $scheduleModel = $this->model('LabScheduleModel');

        // Mengambil semua jadwal lengkap dengan nama Lab
        $schedules = $scheduleModel->getAllWithLaboratory();

        $data = [
            'schedules' => $schedules
        ];

        $this->view('landing/schedule', $data);
    }

    /**
     * Management Presence Page (Dulu: headLaboran)
     * Menampilkan status kehadiran Kepala Lab & Laboran
     */
    public function presence()
    {
        $headLaboranModel = $this->model('HeadLaboranModel');

        // Mengambil data presence yang sudah diurutkan (Active first)
        // Menggunakan method baru 'getAllPresence' yang kita buat di Model
        $presenceList = $headLaboranModel->getAllPresence();

        $data = [
            'presenceList' => $presenceList
        ];

        $this->view('landing/presence', $data);
    }

    /**
     * Lab Activities (Full Page - Optional)
     */
    public function labActivities()
    {
        $activityModel = $this->model('LabActivityModel');

        $data = [
            'activities' => $activityModel->getPublicActivities(20)
        ];

        $this->view('landing/lab-activities', $data);
    }

    /**
     * Schedule Detail Page (Full Page)
     */
    public function scheduleDetail($id)
    {
        $scheduleModel = $this->model('LabScheduleModel');

        // Ambil data detail (Method ini sudah kita buat sebelumnya di langkah update Model)
        $schedule = $scheduleModel->getScheduleDetail($id);

        // Jika data tidak ditemukan, redirect ke halaman jadwal
        if (!$schedule) {
            header('Location: ' . BASE_URL . '/schedule');
            exit;
        }

        $data = [
            'schedule' => $schedule
        ];

        $this->view('landing/schedule-detail', $data);
    }
}
