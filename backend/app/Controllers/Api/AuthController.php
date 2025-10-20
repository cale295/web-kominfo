<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
/**
 * @property \CodeIgniter\HTTP\IncomingRequest $request
 */

class AuthController extends ResourceController
{
    use ResponseTrait;

    /**
     * Endpoint untuk login pengguna (POST /api/login)
     * Mengembalikan ROLE yang DITEMUKAN.
     * * PENTING: Controller ini TIDAK MENGGUNAKAN JWT.
     * Solusi ini SANGAT TIDAK AMAN dan HANYA UNTUK TUJUAN PENGEMBANGAN/UJI COBA RBAC.
     */
    public function login()
    {
        $validation = \Config\Services::validation();

        // 1. Dapatkan input dari request
        $data = $this->request->getJSON(true) ?? [];
        
        // 2. Tentukan aturan validasi
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $userModel = new UserModel();
        $username = $data['username'];
        $password = $data['password'];

        // 3. Cari Pengguna di Database
        $user = $userModel->where('username', $username)->first(); 

        if (!$user) {
            return $this->failNotFound('Username atau password salah.');
        }

        // 4. Verifikasi Password
        if (!password_verify($password, $user['password'])) {
            return $this->failUnauthorized('Username atau password salah.');
        }

        // 5. Kirim Response Sukses
        // Kita hanya mengembalikan ROLE pengguna.
        return $this->respond([
            'message' => 'Login berhasil',
            'user_id' => $user['id'],
            'role' => $user['role'], // <--- Role yang akan digunakan
            'catatan' => 'Sistem ini tidak menggunakan Token. Harap kirimkan Role ini di Header kustom X-User-Role untuk mengakses API.'
        ]);
    }
    
    // ... Anda dapat menambahkan method getUserPermissions() jika diperlukan ...
}