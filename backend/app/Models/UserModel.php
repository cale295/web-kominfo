<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'm_user';
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_lengkap', 'username', 'password', 'email', 'role'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = 
    [
        'nama_lengkap' => 'required|min_length[3]|max_length[100]', 
        'username' => 'required|min_length[3]|max_length[50]', 
        'password' => 'required|min_length[8]|max_length[255]', 
        'email' => 'required|min_length[6]|max_length[255]|is_unique[m_user.email]',
    ];
    protected $validationMessages   = 
    [
        'nama_lengkap' => [
            'required' => 'Nama lengkap harus diisi.',
            'min_length' => 'Nama lengkap minimal 3 karakter.',
            'max_length' => 'Nama lengkap maksimal 100 karakter.',
        ],
        'username' => [
            'required' => 'Username harus diisi.',
            'min_length' => 'Username minimal 3 karakter.',
            'max_length' => 'Username maksimal 50 karakter.',
        ],
        'password' => [
            'required' => 'Password harus diisi.',
            'min_length' => 'Password minimal 8 karakter.',
            'max_length' => 'Password maksimal 255 karakter.',
        ],
        'email' => [
            'required' => 'Email harus diisi.',
            'min_length' => 'Email minimal 6 karakter.',
            'max_length' => 'Email maksimal 255 karakter.',
            'is_unique' => 'Email sudah terdaftar.',
        ],

    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['hashPassword'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['hashPassword'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
     protected function hashPassword(array $data): array
    {
        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        return $data;
    }
}
