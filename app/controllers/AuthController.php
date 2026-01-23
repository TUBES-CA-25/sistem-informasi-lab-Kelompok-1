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

        // 2. LOGIKA BARU: Ambil Data Foto Lab untuk Slideshow Login
        $labModel = $this->model('LaboratoryModel');
        $labs = $labModel->getAllLaboratories();

        // Filter: Hanya ambil lab yang memiliki foto (kolom 'image' tidak kosong)
        $labImages = array_filter($labs, function ($lab) {
            return !empty($lab['image']);
        });

        // 3. Kirim data ke View
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

        // ... (Validasi input & verifikasi user sama seperti sebelumnya) ...
        // ... (Kode validasi disingkat agar fokus ke logic redirect) ...

        $userModel = $this->model('UserModel');
        $user = $userModel->verifyLogin($email, $password);

        if (!$user) {
            setFlash('danger', 'Email atau password salah.');
            $this->redirect('/login');
        }

        $userWithRole = $userModel->getUserWithRole($user['id']);

        // Set Session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['role'] = $userWithRole['role_name'];
        $_SESSION['role_id'] = $user['role_id'];

        // LOGIKA REDIRECT
        $role = $userWithRole['role_name'];

        if ($role === 'admin') {
            // Admin punya dashboard sendiri
            $this->redirect('/admin/dashboard');
        } else {
            // Koordinator & Asisten kembali ke halaman depan
            $this->redirect('/');
        }
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('/login');
    }
}
