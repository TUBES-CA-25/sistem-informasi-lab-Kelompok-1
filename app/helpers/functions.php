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
        'active' => '<span style="padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.85rem; font-weight: 600; background: rgba(16, 185, 129, 0.15); color: #059669; display: inline-block;">✓ Active</span>',
        'inactive' => '<span style="padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.85rem; font-weight: 600; background: rgba(239, 68, 68, 0.15); color: #dc2626; display: inline-block;">✕ Inactive</span>',
        'pending' => '<span style="padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.85rem; font-weight: 600; background: rgba(245, 158, 11, 0.15); color: #d97706; display: inline-block;">⏳ Pending</span>',
        'completed' => '<span style="padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.85rem; font-weight: 600; background: rgba(16, 185, 129, 0.15); color: #059669; display: inline-block;">✓ Completed</span>',
        'in_progress' => '<span style="padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.85rem; font-weight: 600; background: rgba(59, 130, 246, 0.15); color: #2563eb; display: inline-block;">⚙️ In Progress</span>',
        'reported' => '<span style="padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.85rem; font-weight: 600; background: rgba(245, 158, 11, 0.15); color: #d97706; display: inline-block;">📋 Reported</span>',
        'resolved' => '<span style="padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.85rem; font-weight: 600; background: rgba(16, 185, 129, 0.15); color: #059669; display: inline-block;">✅ Resolved</span>',
    ];
    
    return $badges[$status] ?? '<span style="padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.85rem; font-weight: 600; background: rgba(100, 116, 139, 0.15); color: #475569; display: inline-block;">' . e($status) . '</span>';
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
// app/helpers/functions.php (atau di bagian bawah index.php jika tidak pakai helper terpisah)

// Di helper function (misal: app/helpers/functions.php)
function getActivityTypeLabel($type)
{
    $labels = [
        'news' => 'Berita',
        'announcement' => 'Pengumuman',
        'achievement' => 'Prestasi',
        'praktikum' => 'Praktikum',
        'seminar' => 'Seminar/Workshop',
        'lomba' => 'Kompetisi',
        'event' => 'Event',
        'recruitment' => 'Open Recruitment',
        'collaboration' => 'Kerjasama',
        'other' => 'Lainnya'
    ];
    return $labels[$type] ?? 'Kegiatan';
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
 * Check if flash message exists
 */
function hasFlash() {
    return isset($_SESSION['flash']);
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
        
        // Map alert types to Tailwind colors and icons
        $config = [
            'success' => [
                'bg' => 'bg-green-50',
                'border' => 'border-green-200',
                'text' => 'text-green-800',
                'icon' => 'bi-check-circle-fill',
                'iconColor' => 'text-green-500'
            ],
            'danger' => [
                'bg' => 'bg-red-50',
                'border' => 'border-red-200',
                'text' => 'text-red-800',
                'icon' => 'bi-exclamation-circle-fill',
                'iconColor' => 'text-red-500'
            ],
            'warning' => [
                'bg' => 'bg-yellow-50',
                'border' => 'border-yellow-200',
                'text' => 'text-yellow-800',
                'icon' => 'bi-exclamation-triangle-fill',
                'iconColor' => 'text-yellow-500'
            ],
            'info' => [
                'bg' => 'bg-blue-50',
                'border' => 'border-blue-200',
                'text' => 'text-blue-800',
                'icon' => 'bi-info-circle-fill',
                'iconColor' => 'text-blue-500'
            ],
            'error' => [
                'bg' => 'bg-red-50',
                'border' => 'border-red-200',
                'text' => 'text-red-800',
                'icon' => 'bi-x-circle-fill',
                'iconColor' => 'text-red-500'
            ]
        ];
        
        $style = $config[$type] ?? $config['info'];
        
        echo "
        <div id='toast-notification' class='fixed top-6 right-6 z-50 transform translate-x-0 transition-all duration-500 ease-out'>
            <div class='flex items-center w-full max-w-sm p-4 {$style['bg']} border {$style['border']} rounded-lg shadow-xl backdrop-blur-sm'>
                <div class='inline-flex items-center justify-center flex-shrink-0 w-10 h-10 {$style['iconColor']}'>
                    <i class='bi {$style['icon']} text-2xl'></i>
                </div>
                <div class='ml-3 text-sm font-medium {$style['text']} flex-1'>
                    {$message}
                </div>
                <button type='button' onclick='closeToast()' class='ml-3 -mx-1.5 -my-1.5 {$style['bg']} {$style['text']} hover:bg-opacity-80 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 inline-flex items-center justify-center h-8 w-8 transition-colors'>
                    <i class='bi bi-x-lg'></i>
                </button>
            </div>
        </div>
        
        <script>
            // Auto hide after 5 seconds
            setTimeout(function() {
                closeToast();
            }, 5000);
            
            function closeToast() {
                const toast = document.getElementById('toast-notification');
                if (toast) {
                    toast.classList.add('translate-x-full', 'opacity-0');
                    setTimeout(function() {
                        toast.remove();
                    }, 300);
                }
            }
            
            // Slide in animation on load
            window.addEventListener('DOMContentLoaded', function() {
                const toast = document.getElementById('toast-notification');
                if (toast) {
                    toast.classList.add('-translate-x-full');
                    setTimeout(function() {
                        toast.classList.remove('-translate-x-full');
                        toast.classList.add('translate-x-0');
                    }, 100);
                }
            });
        </script>
        ";
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