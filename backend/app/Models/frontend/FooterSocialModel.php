<?php

namespace App\Models\frontend;

use CodeIgniter\Model;

class FooterSocialModel extends Model
{
    // Konfigurasi Tabel
    protected $table            = 'm_footer_social_media';
    protected $primaryKey       = 'id_footer_social'; // ✅ ID Updated
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    // Kolom yang boleh diisi
    protected $allowedFields    = [
        'platform_name',
        'platform_icon',
        'account_name',
        'account_url',
        'is_active',
        'sorting',
        'created_by',
        'updated_by'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Casting
    protected array $casts = [
        'id_footer_social' => 'int', // ✅ ID Updated
        'is_active'        => 'int',
        'sorting'          => 'int',
    ];

    // Dates Management
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation Rules
    protected $validationRules = [
        'platform_name' => [
            'rules'  => 'required|max_length[50]',
            'label'  => 'Nama Platform'
        ],
        'platform_icon' => [
            'rules'  => 'required|max_length[50]',
            'label'  => 'Icon Class'
        ],
        'account_name' => [
            'rules'  => 'required|max_length[100]',
            'label'  => 'Nama Akun'
        ],
        'account_url' => [
            'rules'  => 'required|max_length[255]|valid_url',
            'label'  => 'URL Akun'
        ],
        'sorting' => [
            'rules'  => 'required|numeric',
            'label'  => 'Urutan'
        ],
        'is_active' => [
            'rules'  => 'required|in_list[0,1]',
            'label'  => 'Status Aktif'
        ],
    ];

    // Custom Messages
    protected $validationMessages = [
        'platform_name' => [
            'required' => '{field} wajib diisi.'
        ],
        'account_url' => [
            'valid_url' => 'Format URL tidak valid (harus diawali http:// atau https://).'
        ]
    ];
}