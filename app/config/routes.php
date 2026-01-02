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

// Management Presence (Updated from head-laboran)
$router->get('/presence', 'LandingController@presence');

// Activities (Blog style)
$router->get('/activities', 'LandingController@labActivities');

// ==========================================
// AUTHENTICATION ROUTES
// ==========================================

// Login
$router->get('/login', 'AuthController@loginForm');
$router->post('/auth/login', 'AuthController@login');
$router->post('/auth/logout', 'AuthController@logout');
$router->get('/logout', 'AuthController@logout');

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
$router->get('/asisten/report-problem', 'AsistenController@reportProblemForm');
$router->post('/asisten/report-problem', 'AsistenController@reportProblem');
$router->get('/asisten/my-reports', 'AsistenController@myReports');

// ==========================================
// KOORDINATOR ROUTES (Role: koordinator)
// ==========================================

$router->get('/koordinator/dashboard', 'KoordinatorController@dashboard');
$router->get('/koordinator/problems', 'KoordinatorController@listProblems');
$router->get('/koordinator/problems/:id', 'KoordinatorController@viewProblem');
$router->post('/koordinator/problems/:id/update-status', 'KoordinatorController@updateProblemStatus');

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




// Lab Activities Management
$router->get('/admin/activities', 'AdminController@listActivities');
$router->get('/admin/activities/create', 'AdminController@createActivityForm');
$router->post('/admin/activities/create', 'AdminController@createActivity');
$router->get('/admin/activities/:id/edit', 'AdminController@editActivityForm');
$router->post('/admin/activities/:id/edit', 'AdminController@editActivity');
$router->post('/admin/activities/:id/delete', 'AdminController@deleteActivity');

// Problems Management
$router->get('/admin/problems', 'AdminController@listProblems');
$router->get('/admin/problems/:id', 'AdminController@viewProblem');
$router->post('/admin/problems/:id/update-status', 'AdminController@updateProblemStatus');
$router->post('/admin/problems/:id/delete', 'AdminController@deleteProblem');
