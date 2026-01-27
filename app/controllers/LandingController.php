<?php

class LandingController extends Controller
{
    public function index()
    {
        $labModel = $this->model('LaboratoryModel');
        $activityModel = $this->model('LabActivityModel');
        $userModel = $this->model('UserModel');
        $scheduleModel = $this->model('LabScheduleModel');

        // 1. Data Statistik (Dashboard)
        $stats = [
            'labs_count' => $labModel->countLaboratories(),
            'assistants_count' => $userModel->countByRole(3),
            'lecturers_count' => 31,
            'students_count' => '300+'
        ];

        // 2. LOGIKA CAROUSEL (Slide 1: Banner, Slide 2-N: Jadwal per Lab)
        $allLabs = $labModel->getAllLaboratories(); // Ambil semua lab + Fotonya
        $rawSchedules = $scheduleModel->getTodaySchedules(); // Jadwal Hari Ini

        $labSlides = [];
        foreach ($allLabs as $lab) {
            $labId = $lab['id'];
            // Filter jadwal hanya untuk lab ini
            $labSchedules = array_filter($rawSchedules, function ($s) use ($labId) {
                return $s['laboratory_id'] == $labId;
            });

            $labSlides[] = [
                'lab_info' => $lab,
                'schedules' => $labSchedules
            ];
        }

        $data = [
            'stats' => $stats,
            'labs' => $allLabs,
            'activities' => $activityModel->getRecentActivities(3),
            'labSlides' => $labSlides,
            'currentDayName' => $this->getIndonesianDay(date('l')),
            'currentDate' => date('d F Y')
        ];

        $this->view('landing/index', $data);
    }

    private function getIndonesianDay($englishDay)
    {
        $days = [
            'Sunday' => 'MINGGU',
            'Monday' => 'SENIN',
            'Tuesday' => 'SELASA',
            'Wednesday' => 'RABU',
            'Thursday' => 'KAMIS',
            'Friday' => 'JUMAT',
            'Saturday' => 'SABTU'
        ];
        return $days[$englishDay] ?? $englishDay;
    }

    // ... (Biarkan method schedule, presence, dll tetap ada seperti sebelumnya) ...
    public function schedule()
    {
        $scheduleModel = $this->model('LabScheduleModel');

        // 1. Ambil Parameter
        $page = (int) ($this->getQuery('page') ?? 1);
        if ($page < 1) $page = 1;

        $limit = 20; // Limit data per halaman
        $offset = ($page - 1) * $limit;

        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

        // 2. Ambil Data dari Model
        $schedules = $scheduleModel->getPublicSchedules($limit, $offset, $search);
        $totalRows = $scheduleModel->countPublicSchedules($search);
        $totalPages = ceil($totalRows / $limit);

        // 3. Susun Data untuk View
        $data = [
            'schedules' => $schedules,
            'search' => $search,
            'pagination' => [
                'current' => $page,
                'total_pages' => $totalPages,
                'total_rows' => $totalRows
            ]
        ];

        // Load View
        $this->view('landing/schedule', $data);
    }

    public function presence()
    {
        $this->view('landing/presence', ['presenceList' => $this->model('HeadLaboranModel')->getAllPresence()]);
    }
    public function labActivities()
    {
        $this->view('landing/activities', ['activities' => $this->model('LabActivityModel')->getPublicActivities(20)]);
    }
    public function scheduleDetail($id)
    {
        $scheduleModel = $this->model('LabScheduleModel');

        // Gunakan method yang sudah ada di model: getScheduleDetail($id)
        $schedule = $scheduleModel->getScheduleDetail($id);

        if (!$schedule) {
            // Jika ID tidak ditemukan, kembalikan ke halaman jadwal
            $this->redirect('/schedule');
        }

        $data = [
            'schedule' => $schedule
        ];

        $this->view('landing/schedule-detail', $data);
    }

    // ==========================================
    // HALAMAN LIST SEMUA KEGIATAN
    // ==========================================
    public function activities()
    {
        $activityModel = $this->model('LabActivityModel');

        // Ambil semua kegiatan
        $activities = $activityModel->getAllActivities();

        $data = [
            'activities' => $activities
        ];

        // PERBAIKAN: Pastikan ini 'landing/activities' (sesuai nama file)
        $this->view('landing/activities', $data);
    }

    // ==========================================
    // HALAMAN DETAIL KEGIATAN
    // ==========================================
    public function activityDetail($id)
    {
        $activityModel = $this->model('LabActivityModel');
        $activity = $activityModel->find($id);

        if (!$activity) {
            // Jika berita tidak ditemukan, redirect ke halaman list
            $this->redirect('/activities');
        }

        // Ambil berita lain untuk rekomendasi di sidebar (kecuali yang sedang dibuka)
        $otherActivities = $activityModel->getRecentActivities(3, $id);

        $data = [
            'activity' => $activity,
            'related' => $otherActivities
        ];

        $this->view('landing/activity-detail', $data);
    }
}
