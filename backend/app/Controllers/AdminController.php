<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AdminController extends BaseController
{
    public function index()
    {
        // Ambil data dari session (misalnya username dan role)
        $session = session();
        $data = [
            'title' => 'Dashboard Admin',
            'username' => $session->get('username'),
            'role' => $session->get('role'),
        ];

        // Kirim data ke view
        return view('admin/dashboard', $data);
    }
}
