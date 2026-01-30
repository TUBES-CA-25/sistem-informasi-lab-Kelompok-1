<?php

/**
 * ICLABS - Application Constants
 * Centralized constants to avoid hardcoded values
 */

// Upload directories
define('UPLOAD_DIR_ACTIVITIES', 'activities');
define('UPLOAD_DIR_LECTURERS', 'lecturers');
define('UPLOAD_DIR_ASSISTANTS', 'assistants');
define('UPLOAD_DIR_SCHEDULES', 'schedules');
define('UPLOAD_DIR_LABORATORIES', 'laboratories');
define('UPLOAD_DIR_PROFILES', 'profiles');

// File upload limits
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/jpg', 'image/png', 'image/gif']);

// Pagination
define('DEFAULT_PER_PAGE', 10);
define('PROBLEMS_PER_PAGE', 10);
define('ACTIVITIES_PER_PAGE', 12);

// Route prefixes (for cleaner redirect calls)
define('ROUTE_ADMIN', '/admin');
define('ROUTE_KOORDINATOR', '/koordinator');
define('ROUTE_ASISTEN', '/asisten');
define('ROUTE_PUBLIC', '');

// Common routes
define('ROUTE_LOGIN', '/login');
define('ROUTE_LOGOUT', '/logout');
define('ROUTE_DASHBOARD', '/dashboard');

// Status constants
define('STATUS_REPORTED', 'reported');
define('STATUS_IN_PROGRESS', 'in_progress');
define('STATUS_RESOLVED', 'resolved');

// Flash message types
define('FLASH_SUCCESS', 'success');
define('FLASH_DANGER', 'danger');
define('FLASH_WARNING', 'warning');
define('FLASH_INFO', 'info');
