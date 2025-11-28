<?php

namespace App\Models\frontend;

use CodeIgniter\Model;

class HomeServiceModel extends Model
{
    // Konfigurasi Tabel
    protected $table            = 'm_home_service';
    protected $primaryKey       = 'id_service';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    // Kolom yang boleh diisi
    protected $allowedFields    = [
        'title',
        'icon_image',
        'link',
        'sorting',
        'is_active',
        'created_at', // Auto filled by timestamps
        'updated_at'  // Auto filled by timestamps
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Casting
    protected array $casts = [
        'id_service' => 'int',
        'sorting'    => 'int',
        'is_active'  => 'int',
    ];

    // Dates Management
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation Rules
    protected $validationRules = [
        'title' => [
            'rules'  => 'required|max_length[150]',
            'label'  => 'Nama Layanan'
        ],
        'icon_image' => [
            'rules'  => 'permit_empty|max_length[255]',
            'label'  => 'Icon Layanan'
        ],
        'link' => [
            'rules'  => 'permit_empty|max_length[255]|valid_url',
            'label'  => 'URL Tujuan'
        ],
        'sorting' => [
            'rules'  => 'permit_empty|numeric',
            'label'  => 'Urutan'
        ],
        'is_active' => [
            'rules'  => 'permit_empty|in_list[0,1]',
            'label'  => 'Status Aktif'
        ],
    ];

    // Custom Messages
    protected $validationMessages = [
        'title' => [
            'required' => '{field} wajib diisi.'
        ]
    ];
}