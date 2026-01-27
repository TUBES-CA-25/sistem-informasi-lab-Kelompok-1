<?php

/**
 * ICLABS - Routes Configuration
 */

// ==========================================
// PUBLIC ROUTES (No authentication required)
// ==========================================

// Landing Page
$router->get('/', 'LandingController@index');
$router->get('/home', 'LandingController@index');

// Schedule
$router->get('/schedule', 'LandingController@schedule');
$router->get('/schedule/:id', 'LandingController@scheduleDetail');
// Route untuk Update Jobdesk (Popup)
$router->post('/admin/assistant-schedules/update-job', 'AdminController@updateJobdesk');

// Management Presence (Updated from head-laboran)
$router->get('/presence', 'LandingController@presence');

// Activities (Blog style)
$router->get('/activities', 'LandingController@labActivities');
$router->get('/activity/{id}', 'LandingController@activityDetail');

// ==========================================
// AUTHENTICATION ROUTES
// ==========================================

// Login
$router->get('/login', 'AuthController@loginForm');
$router->post('/auth/login', 'AuthController@login');
$router->post('/auth/logout', 'AuthController@logout');
$router->get('/logout', 'AuthController@logout');

// Dashboard redirect (auto detect role)
$router->get('/dashboard', 'AuthController@dashboard');

// ==========================================
// API ROUTES (JSON responses for AJAX/Modal)
// ==========================================

// Public API
$router->get('/api/schedules', 'ApiController@getSchedules');
$router->get('/api/schedule/:id', 'ApiController@getScheduleDetail'); // NEW: Untuk tombol Detail
$router->get('/api/head-laboran', 'ApiController@getHeadLaboran');
$router->get('/api/lab-activities', 'ApiController@getLabActivities');

// ==========================================
// ASISTEN ROUTES (Role: asisten)
// ==========================================

$router->get('/asisten/dashboard', 'AsistenController@dashboard');

// 1. Fitur Jobdesk (Baru)
$router->get('/asisten/jobdesk', 'AsistenController@jobdesk');
$router->get('/asisten/jobdesk/:id/edit', 'AsistenController@editTaskForm');
$router->post('/asisten/jobdesk/:id/edit', 'AsistenController@updateTaskStatus');

// 2. Fitur Permasalahan Lab (CRUD)
$router->get('/asisten/problems', 'AsistenController@problems');
$router->get('/asisten/problems/create', 'AsistenController@createProblemForm');
$router->post('/asisten/problems/create', 'AsistenController@createProblem');
$router->post('/asisten/delete-problem/:id', 'AsistenController@deleteProblem');

// 3. Fitur Jadwal Piket
$router->get('/asisten/assistant-schedules', 'AsistenController@listAssistantSchedules');
$router->get('/asisten/problems/:id/edit', 'AsistenController@editProblemForm'); // Route Edit Form
$router->post('/asisten/problems/:id/edit', 'AsistenController@updateProblem'); // Route Submit Edit


// ==========================================
// KOORDINATOR ROUTES (Role: koordinator)
// ==========================================

$router->get('/koordinator/dashboard', 'KoordinatorController@dashboard');

// Problem CRUD
$router->get('/koordinator/problems', 'KoordinatorController@listProblems');
$router->get('/koordinator/problems/create', 'KoordinatorController@createProblemForm');
$router->post('/koordinator/problems/create', 'KoordinatorController@createProblem');
$router->get('/koordinator/problems/:id', 'KoordinatorController@viewProblem');
$router->get('/koordinator/problems/:id/edit', 'KoordinatorController@editProblemForm');
$router->post('/koordinator/problems/:id/edit', 'KoordinatorController@updateProblem');
$router->post('/koordinator/problems/:id/delete', 'KoordinatorController@deleteProblem');
$router->post('/koordinator/problems/:id/update-status', 'KoordinatorController@updateProblemStatus');
$router->post('/koordinator/problems/:id/assign', 'KoordinatorController@assignProblem');

// Koordinator read-only views (using KoordinatorController)
// Route Koordinator Schedule
$router->get('/koordinator/assistant-schedules', 'KoordinatorController@listAssistantSchedules'); // Perhatikan nama methodnya
$router->get('/koordinator/assistant-schedules/create', 'KoordinatorController@createAssistantSchedule');
$router->post('/koordinator/assistant-schedules/create', 'KoordinatorController@createAssistantSchedule');
$router->get('/koordinator/assistant-schedules/:id/edit', 'KoordinatorController@editAssistantSchedule');
$router->post('/koordinator/assistant-schedules/:id/edit', 'KoordinatorController@editAssistantSchedule');
$router->post('/koordinator/assistant-schedules/:id/delete', 'KoordinatorController@deleteAssistantSchedule');
$router->post('/koordinator/assistant-schedules/update-job', 'KoordinatorController@updateJobdesk');

$router->get('/koordinator/laboratories', 'KoordinatorController@listLaboratories');
$router->get('/koordinator/laboratories/create', 'KoordinatorController@createLaboratoryForm');
$router->post('/koordinator/laboratories/create', 'KoordinatorController@createLaboratory');
$router->get('/koordinator/laboratories/:id/edit', 'KoordinatorController@editLaboratoryForm');
$router->post('/koordinator/laboratories/:id/edit', 'KoordinatorController@updateLaboratory');
$router->post('/koordinator/laboratories/:id/delete', 'KoordinatorController@deleteLaboratory');

$router->get('/koordinator/activities', 'KoordinatorController@listActivities');
$router->get('/koordinator/activities/create', 'KoordinatorController@createActivityForm');
$router->post('/koordinator/activities/create', 'KoordinatorController@createActivity');
$router->get('/koordinator/activities/:id/edit', 'KoordinatorController@editActivityForm');
$router->post('/koordinator/activities/:id/edit', 'KoordinatorController@updateActivity');
$router->post('/koordinator/activities/:id/delete', 'KoordinatorController@deleteActivity');

// ==========================================
// ADMIN ROUTES (Role: admin)
// ==========================================

// Dashboard
$router->get('/admin/dashboard', 'AdminController@dashboard');

// User Management
$router->get('/admin/users', 'AdminController@listUsers');
$router->get('/admin/users/create', 'AdminController@createUserForm');
$router->post('/admin/users/create', 'AdminController@createUser');
$router->get('/admin/users/:id/edit', 'AdminController@editUserForm');
$router->post('/admin/users/:id/edit', 'AdminController@editUser');
$router->post('/admin/users/:id/delete', 'AdminController@deleteUser');

// Laboratory Management
$router->get('/admin/laboratories', 'AdminController@listLaboratories');
$router->get('/admin/laboratories/create', 'AdminController@createLaboratoryForm');
$router->post('/admin/laboratories/create', 'AdminController@createLaboratory');
$router->get('/admin/laboratories/:id/edit', 'AdminController@editLaboratoryForm');
$router->post('/admin/laboratories/:id/edit', 'AdminController@editLaboratory');
$router->post('/admin/laboratories/:id/delete', 'AdminController@deleteLaboratory');


// Lab Schedules
$router->get('/admin/schedules', 'AdminController@listSchedules');
$router->get('/admin/schedules/create', 'AdminController@createScheduleForm');
$router->post('/admin/schedules/create', 'AdminController@createSchedule');
$router->get('/admin/schedules/:id/edit', 'AdminController@editScheduleForm');
$router->post('/admin/schedules/:id/edit', 'AdminController@editSchedule');
$router->post('/admin/schedules/:id/delete', 'AdminController@deleteSchedule');
$router->get('/admin/schedules/:id', 'AdminController@viewSchedule');




// Assistant Schedules (Piket)
$router->get('/admin/assistant-schedules', 'AdminController@listAssistantSchedules');
$router->get('/admin/assistant-schedules/create', 'AdminController@createAssistantScheduleForm');
$router->post('/admin/assistant-schedules/create', 'AdminController@createAssistantSchedule');
$router->get('/admin/assistant-schedules/:id/edit', 'AdminController@editAssistantScheduleForm');
$router->post('/admin/assistant-schedules/:id/edit', 'AdminController@editAssistantSchedule');
$router->post('/admin/assistant-schedules/:id/delete', 'AdminController@deleteAssistantSchedule');




// Head Laboran Management
$router->get('/admin/head-laboran', 'AdminController@listHeadLaboran');
$router->get('/admin/head-laboran/create', 'AdminController@createHeadLaboranForm');
$router->post('/admin/head-laboran/create', 'AdminController@createHeadLaboran');

$router->get('/admin/head-laboran/:id', 'AdminController@viewHeadLaboran');

$router->get('/admin/head-laboran/:id/edit', 'AdminController@editHeadLaboranForm');
$router->post('/admin/head-laboran/:id/edit', 'AdminController@editHeadLaboran');
$router->post('/admin/head-laboran/:id/delete', 'AdminController@deleteHeadLaboran');




// Lab Activities (Blog/News)
$router->get('/admin/activities', 'AdminController@listActivities');
$router->get('/admin/activities/create', 'AdminController@createActivityForm'); // Create DI ATAS ID
$router->post('/admin/activities/create', 'AdminController@createActivity');
$router->get('/admin/activities/:id/edit', 'AdminController@editActivityForm');
$router->post('/admin/activities/:id/edit', 'AdminController@editActivity');
$router->post('/admin/activities/:id/delete', 'AdminController@deleteActivity');




// Problems Management
$router->get('/admin/problems', 'AdminController@listProblems');
$router->get('/admin/problems/create', 'AdminController@createProblemForm');
$router->post('/admin/problems/create', 'AdminController@createProblem');
$router->get('/admin/problems/:id', 'AdminController@viewProblem');
$router->get('/admin/problems/:id/edit', 'AdminController@editProblemForm');
$router->post('/admin/problems/:id/edit', 'AdminController@updateProblem');
$router->post('/admin/problems/:id/assign', 'AdminController@assignProblem');
$router->post('/admin/problems/:id/update-status', 'AdminController@updateProblemStatus');
$router->post('/admin/problems/:id/delete', 'AdminController@deleteProblem');



//Calender Jadwal Praktikum
$router->get('/admin/calendar', 'AdminController@calendar');
$router->get('/admin/calendar/data', 'AdminController@getCalendarData');
$router->post('/admin/calendar/clear', 'AdminController@clearScheduleByDate'); // Route untuk Hapus Harian