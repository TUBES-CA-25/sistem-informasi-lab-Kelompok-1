<?php

/**
 * ICLABS - Authentication Controller
 */

class AuthController extends Controller
{

    public function loginForm()
    {
        // 1. Cek jika user sudah login, langsung redirect
        if (isLoggedIn()) {
            $role = getUserRole();
            if ($role === 'admin') {
                $this->redirect('/admin/dashboard');
            } else {
                $this->redirect('/');
            }
        }

        // 2. Ambil Data Foto Lab untuk Slideshow Login
        $labModel = $this->model('LaboratoryModel');
        $labs = $labModel->getAllLaboratories();

        $labImages = array_filter($labs, function ($lab) {
            return !empty($lab['image']);
        });

        $data = [
            'labImages' => $labImages
        ];

        $this->view('auth/login', $data);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/login');
        }

        $email = sanitize($this->getPost('email'));
        $password = $this->getPost('password');

        if (empty($email) || empty($password)) {
            setFlash('danger', 'Email dan password wajib diisi.');
            $this->redirect('/login');
        }

        $userModel = $this->model('UserModel');
        $user = $userModel->verifyLogin($email, $password);

        if (!$user) {
            setFlash('danger', 'Email atau password salah.');
            $this->redirect('/login');
        }

        $userWithRole = $userModel->getUserWithRole($user['id']);
        $role = $userWithRole['role_name'];

        // --- UPDATE BARU: BLOKIR LOGIN DOSEN ---
        // Dosen hanya data administratif ("Role as Label")
        if ($role === 'dosen') {
            setFlash('danger', 'Akun Dosen hanya untuk pendataan administratif, tidak dapat digunakan untuk login.');
            $this->redirect('/login');
            return;
        }
        // ---------------------------------------

        // Set Session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['role'] = $role;
        $_SESSION['role_id'] = $user['role_id'];

        // Logika Redirect
        if ($role === 'admin') {
            $this->redirect('/admin/dashboard');
        } elseif ($role === 'koordinator') {
            $this->redirect('/koordinator/activities');
        } elseif ($role === 'asisten') {
            $this->redirect('/asisten/jobdesk');
        } else {
            $this->redirect('/');
        }
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('/login');
    }
}
