<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    /**
     * Halaman login
     */
    public function index()
    {
        // Jika sudah login, langsung ke dashboard
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        return view('pages/auth/Login');
    }

    /**
     * Proses login
     */
    public function login()
    {
        $session = session();
        $model = new UserModel();

        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        // Cek username di database
        $user = $model->where('username', $username)->first();

        if ($user) {
            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                $sessionData = [
                    'id_user'      => $user['id_user'],
                    'full_name' => $user['full_name'],
                    'username'     => $user['username'],
                    'email'        => $user['email'],
                    'role'         => $user['role'],
                    'logged_in'    => true
                ];
                $session->set($sessionData);
                return redirect()->to('/dashboard');
            } else {
                $session->setFlashdata('error', 'Password salah.');
            }
        } else {
            $session->setFlashdata('error', 'Username tidak ditemukan.');
        }

        return redirect()->back();
    }

    /**
     * Logout
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
