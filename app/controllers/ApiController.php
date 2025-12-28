<?php
/**
 * ICLABS - API Controller
 * Handles JSON API endpoints
 */

class ApiController extends Controller {
    
    /**
     * Get laboratory schedules (JSON)
     */
    public function getSchedules() {
        $scheduleModel = $this->model('LabScheduleModel');
        
        $day = $this->getQuery('day');
        
        if ($day) {
            $schedules = $scheduleModel->getSchedulesByDay($day);
        } else {
            $schedules = $scheduleModel->getAllWithLaboratory();
        }
        
        $this->json([
            'success' => true,
            'data' => $schedules
        ]);
    }
    
    /**
     * Get head laboran (JSON)
     */
    public function getHeadLaboran() {
        $headLaboranModel = $this->model('HeadLaboranModel');
        
        $headLaboran = $headLaboranModel->getActiveHeadLaboran();
        
        $this->json([
            'success' => true,
            'data' => $headLaboran
        ]);
    }
    
    /**
     * Get lab activities (JSON)
     */
    public function getLabActivities() {
        $activityModel = $this->model('LabActivityModel');
        
        $limit = $this->getQuery('limit', 10);
        $activities = $activityModel->getPublicActivities($limit);
        
        $this->json([
            'success' => true,
            'data' => $activities
        ]);
    }
}
