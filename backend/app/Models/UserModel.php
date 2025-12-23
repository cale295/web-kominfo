<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'm_users';
    protected $primaryKey       = 'id_user';
    
    // PENTING: False karena ID adalah NIK/NIP (Input Manual)
    protected $useAutoIncrement = false; 
    
    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'id_user',      // Primary Key manual wajib masuk sini
        'full_name',
        'username',
        'email',
        'password',
        'role',
        'no_telp',
        'foto',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // =========================================================================
    // VALIDATION RULES (YANG SUDAH DIPERBAIKI)
    // =========================================================================
    protected $validationRules = [
        'id_user' => [
            'label' => 'NIK/NIP',
            // CUKUP begini. Jangan tambah ,id_user,{id_user} di sini.
            'rules' => 'required|min_length[5]|max_length[20]|is_unique[m_users.id_user]',
        ],
        'full_name' => [
            'label' => 'Nama Lengkap',
            'rules' => 'required|min_length[3]|max_length[100]',
        ],
        'username' => [
            'label' => 'Username',
            // Perbaikan: Hapus parameter ignore manual, CI otomatis tahu.
            'rules' => 'required|min_length[5]|max_length[50]|is_unique[m_users.username]',
        ],
        'email' => [
            'label' => 'Email',
            // Perbaikan: Hapus parameter ignore manual.
            'rules' => 'required|valid_email|max_length[255]|is_unique[m_users.email]',
        ],
        'password' => [
            'label' => 'Password',
            // Password required hanya saat insert, controller akan override ini saat update
            'rules' => 'required|min_length[8]|max_length[255]', 
        ],
    ];

    protected $validationMessages = [
        'id_user' => [
            'required'   => 'NIK/NIP wajib diisi.',
            'is_unique'  => 'NIK/NIP sudah terdaftar.',
        ],
        'username' => [
            'is_unique'  => 'Username sudah digunakan.',
        ],
        'email' => [
            'is_unique'  => 'Email sudah digunakan.',
            'valid_email'=> 'Format email tidak valid.',
        ],
        'password' => [
            'min_length' => 'Password minimal 8 karakter.',
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // =========================================================================
    // CALLBACKS (HASHING PASSWORD)
    // =========================================================================
    protected $allowCallbacks = true;
    
    // SAYA COMMENT DULU AGAR TIDAK BENTROK DENGAN CONTROLLER
    // Karena di Controller ProfileController.php kita sudah pakai password_hash()
    // Jika ini dinyalakan, password akan ter-hash 2 KALI -> Gagal Login.
    
    protected $beforeInsert   = []; // ['hashPassword']; 
    protected $beforeUpdate   = []; // ['hashPassword'];

    /**
     * 🔒 Hash password (Opsional: Aktifkan jika Controller mengirim password polos)
     */
    protected function hashPassword(array $data)
    {
        if (! isset($data['data']['password'])) return $data;

        if (empty($data['data']['password'])) {
            unset($data['data']['password']);
            return $data;
        }

        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);

        return $data;
    }
}