<?php
/**
 * ICLABS - Landing Controller
 * Handles public pages
 */

class LandingController extends Controller {
    
    /**
     * Landing page
     */
    public function index() {
        $scheduleModel = $this->model('LabScheduleModel');
        $activityModel = $this->model('LabActivityModel');
        $headLaboranModel = $this->model('HeadLaboranModel');
        
        $data = [
            'todaySchedules' => $scheduleModel->getTodaySchedules(),
            'recentActivities' => $activityModel->getPublicActivities(5),
            'headLaboran' => $headLaboranModel->getActiveHeadLaboran()
        ];
        
        $this->view('landing/index', $data);
    }
    
    /**
     * Laboratory schedule page
     */
    public function schedule() {
        $scheduleModel = $this->model('LabScheduleModel');
        
        $data = [
            'schedules' => $scheduleModel->getAllWithLaboratory()
        ];
        
        $this->view('landing/schedule', $data);
    }
    
    /**
     * Head Laboran section
     */
    public function headLaboran() {
        $headLaboranModel = $this->model('HeadLaboranModel');
        
        $data = [
            'headLaboran' => $headLaboranModel->getAllWithUser()
        ];
        
        $this->view('landing/head-laboran', $data);
    }
    
    /**
     * Lab activities section
     */
    public function labActivities() {
        $activityModel = $this->model('LabActivityModel');
        
        $data = [
            'activities' => $activityModel->getPublicActivities(20)
        ];
        
        $this->view('landing/lab-activities', $data);
    }
}
