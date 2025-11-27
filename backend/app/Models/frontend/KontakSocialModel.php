<?php

namespace App\Models\frontend;

use CodeIgniter\Model;

class KontakSocialModel extends Model
{
    // Sesuaikan dengan nama tabel di database
    protected $table            = 'm_kontak_social_media';
    protected $primaryKey       = 'id_kontak_social';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    // Field yang diizinkan untuk di-insert/update
    protected $allowedFields    = [
        'platform',
        'icon_class',
        'link_url',
        'urutan',
        'status'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    // Diaktifkan (true) karena tabel memiliki created_at dan updated_at
    protected $useTimestamps = true; 
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at'; // Tidak dipakai karena softDeletes false

    // =============================
    //       VALIDATION RULES
    // =============================
    protected $validationRules = [
        'platform' => [
            'label' => 'Nama Platform',
            'rules' => 'required|max_length[50]'
        ],
        'icon_class' => [
            'label' => 'Class Icon',
            'rules' => 'required|max_length[100]'
        ],
        'link_url' => [
            'label' => 'Link URL',
            'rules' => 'required|valid_url|max_length[255]'
        ],
        'urutan' => [
            'label' => 'Urutan',
            'rules' => 'permit_empty|integer'
        ],
        'status' => [
            'label' => 'Status',
            'rules' => 'required|in_list[aktif,nonaktif]'
        ],
    ];

    protected $validationMessages = [
        'platform' => [
            'required' => 'Nama platform wajib diisi.',
            'max_length' => 'Nama platform maksimal 50 karakter.'
        ],
        'icon_class' => [
            'required' => 'Icon class wajib diisi (contoh: fa fa-facebook).',
        ],
        'link_url' => [
            'required' => 'Link URL wajib diisi.',
            'valid_url' => 'Format URL tidak valid (harus dimulai http:// atau https://).',
        ],
        'status' => [
            'in_list' => 'Status harus pilih Aktif atau Nonaktif.'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}