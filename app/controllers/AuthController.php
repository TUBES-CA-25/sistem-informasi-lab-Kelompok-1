<?php
/**
 * ICLABS - Authentication Controller
 */

class AuthController extends Controller {
    
    /**
     * Show login form
     */
    public function loginForm() {
        if (isLoggedIn()) {
            $role = getUserRole();
            $this->redirect("/$role/dashboard");
        }
        
        $this->view('auth/login');
    }
    
    /**
     * Process login
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/login');
        }
        
        $email = sanitize($this->getPost('email'));
        $password = $this->getPost('password');
        
        // Validate input
        $errors = $this->validate([
            'email' => $email,
            'password' => $password
        ], [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        
        if (!empty($errors)) {
            setFlash('danger', 'Invalid email or password format');
            $this->redirect('/login');
        }
        
        // Verify credentials
        $userModel = $this->model('UserModel');
        $user = $userModel->verifyLogin($email, $password);
        
        if (!$user) {
            setFlash('danger', 'Invalid email or password');
            $this->redirect('/login');
        }
        
        // Get user role
        $userWithRole = $userModel->getUserWithRole($user['id']);
        
        // Set session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['role'] = $userWithRole['role_name'];
        $_SESSION['role_id'] = $user['role_id'];
        
        // Redirect based on role
        $role = $userWithRole['role_name'];
        
        if ($role === 'admin') {
            $this->redirect('/admin/dashboard');
        } elseif ($role === 'koordinator') {
            $this->redirect('/koordinator/dashboard');
        } elseif ($role === 'asisten') {
            $this->redirect('/asisten/dashboard');
        } else {
            $this->redirect('/');
        }
    }
    
    /**
     * Logout
     */
    public function logout() {
        session_destroy();
        setFlash('success', 'You have been logged out successfully');
        $this->redirect('/login');
    }
}
