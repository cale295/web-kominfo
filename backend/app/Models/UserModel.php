<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'm_users';
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['full_name', 'username', 'password', 'email', 'role'];

    // Tambahan opsional
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation rules
    protected $validationRules = [
    'full_name' => [
        'rules' => 'required|min_length[3]|max_length[100]',
        'label' => 'Nama Lengkap'
    ],
    'username' => [
        'rules' => 'required|min_length[3]|max_length[50]',
        'label' => 'Username'
    ],
    'password' => [
        'rules' => 'required|min_length[8]|max_length[255]|regex_match[/(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+/]',
        'label' => 'Password'
    ],
    'email' => [
        'rules' => 'required|min_length[6]|max_length[255]|valid_email|is_unique[m_users.email]',
        'label' => 'Email'
    ],
];

protected $validationMessages = [
    'full_name' => [
        'required'   => 'Nama lengkap harus diisi.',
        'min_length' => 'Nama lengkap minimal 3 karakter.',
        'max_length' => 'Nama lengkap maksimal 100 karakter.',
    ],
    'username' => [
        'required'   => 'Username harus diisi.',
        'min_length' => 'Username minimal 3 karakter.',
        'max_length' => 'Username maksimal 50 karakter.',
    ],
    'password' => [
        'required'    => 'Password harus diisi.',
        'min_length'  => 'Password minimal 8 karakter.',
        'regex_match' => 'Password harus mengandung minimal satu huruf besar, satu angka, dan satu simbol.',
    ],
    'email' => [
        'required'    => 'Email harus diisi.',
        'valid_email' => 'Format email tidak valid.',
        'is_unique'   => 'Email sudah terdaftar.',
    ],
];


    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['hashPassword'];
    protected $beforeUpdate   = ['hashPassword'];

    /**
     * Hash password sebelum disimpan ke database
     */
    protected function hashPassword(array $data): array
    {
        if (!empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }
}
