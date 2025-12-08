<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'm_users';
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'full_name',
        'username',
        'email',
        'password',
        'role',
        'created_at',
        'updated_at',
    ];

    // Dates
    protected $useTimestamps = true; // ✅ aktifkan agar otomatis update waktu
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation rules
    protected $validationRules = [
        'full_name' => [
            'rules' => 'required|min_length[5]|max_length[100]',
            'label' => 'Nama Lengkap'
        ],
        'username' => [
            'rules' => 'required|min_length[5]|max_length[50]',
            'label' => 'Username'
        ],
        'password' => [
            // ✅ regex untuk huruf besar, angka, dan simbol
            'rules' => 'required|min_length[8]|max_length[255]|regex_match[/(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).+/]',
            'label' => 'Password'
        ],
        'email' => [
            'rules' => 'required|min_length[6]|max_length[255]|valid_email',
            'label' => 'Email'
        ],
    ];

    protected $validationMessages = [
        'full_name' => [
            'required'   => 'Nama lengkap harus diisi.',
            'min_length' => 'Nama lengkap minimal 5 karakter.',
            'max_length' => 'Nama lengkap maksimal 100 karakter.',
        ],
        'username' => [
            'required'   => 'Username harus diisi.',
            'min_length' => 'Username minimal 5 karakter.',
            'max_length' => 'Username maksimal 50 karakter.',
        ],
        'password' => [
            'required'    => 'Password harus diisi.',
            'min_length'  => 'Password minimal 8 karakter.',
            'regex_match' => 'Password harus mengandung minimal satu huruf besar, satu huruf kecil, satu angka, dan satu simbol.',
        ],
        'email' => [
            'required'    => 'Email harus diisi.',
            'valid_email' => 'Format email tidak valid.',
        ],
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['hashPassword'];
    protected $beforeUpdate   = ['hashPassword', 'adjustEmailRule', 'adjustPasswordRule'];

    /**
     * 🔒 Hash password sebelum disimpan
     */
    protected function hashPassword(array $data): array
    {
        if (!empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    /**
     * 💡 Saat update, password boleh kosong (tidak wajib ubah)
     */
    protected function adjustPasswordRule(array $data)
    {
        $id = $data['id'][0] ?? null;
        if ($id) {
            $this->validationRules['password'] = 'required|min_length[8]|max_length[255]|regex_match[/(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).+/]';
        }
        return $data;
    }

    /**
     * 📧 Saat update, validasi email tetap valid tapi tidak wajib unik ke dirinya sendiri
     */
    protected function adjustEmailRule(array $data)
    {
        $id = $data['id'][0] ?? null;
        if ($id) {
            $this->validationRules['email'] = 'required|min_length[6]|max_length[255]|valid_email';
        }
        return $data;
    }
}
