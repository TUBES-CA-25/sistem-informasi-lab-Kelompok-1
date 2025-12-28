<?php
/**
 * ICLABS - Helper Functions
 */

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['role']);
}

/**
 * Get current user ID
 */
function getUserId() {
    return $_SESSION['user_id'] ?? null;
}

/**
 * Get current user role
 */
function getUserRole() {
    return $_SESSION['role'] ?? null;
}

/**
 * Get current user name
 */
function getUserName() {
    return $_SESSION['user_name'] ?? 'Guest';
}

/**
 * Check if user has role
 */
function hasRole($roles) {
    if (!isLoggedIn()) {
        return false;
    }
    
    if (!is_array($roles)) {
        $roles = [$roles];
    }
    
    return in_array(getUserRole(), $roles);
}

/**
 * Hash password
 */
function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

/**
 * Verify password
 */
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

/**
 * Sanitize input
 */
function sanitize($data) {
    if (is_array($data)) {
        return array_map('sanitize', $data);
    }
    
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

/**
 * Escape output
 */
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Generate CSRF token
 */
function generateCsrfToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 */
function verifyCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Format date
 */
function formatDate($date, $format = 'd M Y') {
    return date($format, strtotime($date));
}

/**
 * Format datetime
 */
function formatDateTime($datetime, $format = 'd M Y H:i') {
    return date($format, strtotime($datetime));
}

/**
 * Format time
 */
function formatTime($time) {
    return date('H:i', strtotime($time));
}

/**
 * Get status badge HTML
 */
function getStatusBadge($status) {
    $badges = [
        'active' => '<span class="badge badge-success">Active</span>',
        'inactive' => '<span class="badge badge-danger">Inactive</span>',
        'pending' => '<span class="badge badge-warning">Pending</span>',
        'completed' => '<span class="badge badge-success">Completed</span>',
        'in_progress' => '<span class="badge badge-info">In Progress</span>',
        'reported' => '<span class="badge badge-warning">Reported</span>',
        'resolved' => '<span class="badge badge-success">Resolved</span>',
    ];
    
    return $badges[$status] ?? '<span class="badge">' . e($status) . '</span>';
}

/**
 * Get problem type label
 */
function getProblemTypeLabel($type) {
    $types = [
        'hardware' => 'Hardware',
        'software' => 'Software',
        'network' => 'Network',
        'other' => 'Other',
    ];
    
    return $types[$type] ?? ucfirst($type);
}

/**
 * Get activity type label
 */
function getActivityTypeLabel($type) {
    $types = [
        'praktikum' => 'Praktikum',
        'workshop' => 'Workshop',
        'seminar' => 'Seminar',
        'maintenance' => 'Maintenance',
        'other' => 'Other',
    ];
    
    return $types[$type] ?? ucfirst($type);
}

/**
 * Get day name in Indonesian
 */
function getDayName($day) {
    $days = [
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu',
        'Sunday' => 'Minggu',
    ];
    
    return $days[$day] ?? $day;
}

/**
 * Upload file
 */
function uploadFile($file, $uploadDir = 'uploads/', $allowedTypes = ['jpg', 'jpeg', 'png']) {
    if (!isset($file['error']) || is_array($file['error'])) {
        return ['success' => false, 'message' => 'Invalid file'];
    }
    
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'Upload error'];
    }
    
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    if (!in_array($fileExtension, $allowedTypes)) {
        return ['success' => false, 'message' => 'File type not allowed'];
    }
    
    $fileName = uniqid() . '.' . $fileExtension;
    $targetPath = PUBLIC_PATH . '/' . $uploadDir . $fileName;
    
    if (!is_dir(PUBLIC_PATH . '/' . $uploadDir)) {
        mkdir(PUBLIC_PATH . '/' . $uploadDir, 0777, true);
    }
    
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return ['success' => true, 'filename' => $fileName, 'path' => $uploadDir . $fileName];
    }
    
    return ['success' => false, 'message' => 'Failed to move uploaded file'];
}

/**
 * Delete file
 */
function deleteFile($filePath) {
    $fullPath = PUBLIC_PATH . '/' . $filePath;
    if (file_exists($fullPath)) {
        return unlink($fullPath);
    }
    return false;
}

/**
 * Set flash message
 */
function setFlash($type, $message) {
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message
    ];
}

/**
 * Get and clear flash message
 */
function getFlash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Display flash message HTML
 */
function displayFlash() {
    $flash = getFlash();
    if ($flash) {
        $type = $flash['type'];
        $message = $flash['message'];
        echo "<div class='alert alert-{$type}'>{$message}</div>";
    }
}

/**
 * Generate URL
 */
function url($path = '') {
    return BASE_URL . '/' . ltrim($path, '/');
}

/**
 * Asset URL
 */
function asset($path) {
    return BASE_URL . '/assets/' . ltrim($path, '/');
}

/**
 * Debug helper
 */
function dd($data) {
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
}
