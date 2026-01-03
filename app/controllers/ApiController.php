<?php

/**
 * ICLABS - API Controller
 * Handles JSON responses for AJAX requests
 */

class ApiController extends Controller
{

    /**
     * Constructor to set JSON header
     */
    public function __construct()
    {
        header('Content-Type: application/json');
    }

    /**
     * Get all schedules
     */
    public function getSchedules()
    {
        $scheduleModel = $this->model('LabScheduleModel');
        $data = $scheduleModel->getAllWithLaboratory();
        echo json_encode(['success' => true, 'data' => $data]);
    }

    /**
     * [NEW] Get Single Schedule Detail
     * Digunakan untuk modal detail pada halaman Schedule
     */
    public function getScheduleDetail($id)
    {
        $scheduleModel = $this->model('LabScheduleModel');

        // Mengambil detail jadwal spesifik (termasuk assistant_2, prodi, dll)
        $data = $scheduleModel->getScheduleDetail($id);

        if ($data) {
            echo json_encode(['success' => true, 'data' => $data]);
        } else {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Schedule not found']);
        }
    }

    /**
     * Get head laboran list
     */
    public function getHeadLaboran()
    {
        $headLaboranModel = $this->model('HeadLaboranModel');
        $data = $headLaboranModel->getActiveHeadLaboran();
        echo json_encode(['success' => true, 'data' => $data]);
    }

    /**
     * Get lab activities
     */
    public function getLabActivities()
    {
        $activityModel = $this->model('LabActivityModel');
        $data = $activityModel->getPublicActivities();
        echo json_encode(['success' => true, 'data' => $data]);
    }
}