<?php
/**
 * ICLABS - Base Controller Class
 */

class Controller {
    
    /**
     * Load model
     */
    protected function model($modelName) {
        $modelFile = APP_PATH . '/models/' . $modelName . '.php';
        
        if (file_exists($modelFile)) {
            require_once $modelFile;
            return new $modelName();
        }
        
        die("Model not found: $modelName");
    }
    
    /**
     * Load view
     */
    protected function view($viewPath, $data = []) {
        extract($data);
        
        $viewFile = APP_PATH . '/views/' . $viewPath . '.php';
        
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("View not found: $viewPath");
        }
    }
    
    /**
     * JSON response
     */
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    /**
     * Redirect to URL
     */
    protected function redirect($url) {
        header('Location: ' . BASE_URL . $url);
        exit;
    }
    
    /**
     * Check if user is logged in
     */
    protected function requireLogin() {
        if (!isLoggedIn()) {
            $this->redirect('/login');
        }
    }
    
    /**
     * Check if user has required role
     */
    protected function requireRole($allowedRoles) {
        $this->requireLogin();
        
        if (!is_array($allowedRoles)) {
            $allowedRoles = [$allowedRoles];
        }
        
        if (!hasRole($allowedRoles)) {
            // Use error page instead of redirect
            $this->error(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }
    
    /**
     * Get POST data
     */
    protected function getPost($key = null, $default = null) {
        if ($key === null) {
            return $_POST;
        }
        
        return $_POST[$key] ?? $default;
    }
    
    /**
     * Get GET data
     */
    protected function getQuery($key = null, $default = null) {
        if ($key === null) {
            return $_GET;
        }
        
        return $_GET[$key] ?? $default;
    }
    
    /**
     * Validate input
     */
    protected function validate($data, $rules) {
        $errors = [];
        
        foreach ($rules as $field => $rule) {
            $ruleArray = explode('|', $rule);
            
            foreach ($ruleArray as $r) {
                if ($r === 'required' && empty($data[$field])) {
                    $errors[$field] = ucfirst($field) . ' is required';
                }
                
                if (strpos($r, 'min:') === 0) {
                    $min = (int) substr($r, 4);
                    if (strlen($data[$field]) < $min) {
                        $errors[$field] = ucfirst($field) . " must be at least $min characters";
                    }
                }
                
                if ($r === 'email' && !filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
                    $errors[$field] = 'Invalid email format';
                }
            }
        }
        
        return $errors;
    }
    
    /**
     * Show error page
     * 
     * @param int $code HTTP error code
     * @param string|null $message Custom error message
     */
    protected function error($code = 404, $message = null) {
        // ErrorController already loaded in index.php
        if (class_exists('ErrorController')) {
            $errorController = new ErrorController();
            $errorController->render($code, $message);
        } else {
            // Fallback
            http_response_code($code);
            echo "<h1>Error $code</h1>";
            if ($message) {
                echo "<p>" . htmlspecialchars($message) . "</p>";
            }
            exit;
        }
    }
    
    /**
     * Shortcut for 404 error
     */
    protected function notFound($message = null) {
        $this->error(404, $message);
    }
    
    /**
     * Shortcut for 403 error
     */
    protected function forbidden($message = null) {
        $this->error(403, $message);
    }
    
    /**
     * Shortcut for 401 error
     */
    protected function unauthorized($message = null) {
        $this->error(401, $message);
    }
    
    /**
     * Shortcut for 400 error
     */
    protected function badRequest($message = null) {
        $this->error(400, $message);
    }
    
    /**
     * Shortcut for 500 error
     */
    protected function serverError($message = null) {
        $this->error(500, $message);
    }
}
