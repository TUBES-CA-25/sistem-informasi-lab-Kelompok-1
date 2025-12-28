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
            $this->json(['error' => 'Unauthorized access'], 403);
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
}
