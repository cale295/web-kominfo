<?php

namespace App\Models\frontend;

use CodeIgniter\Model;

class FooterOpdModel extends Model
{
    // Konfigurasi Tabel
    protected $table            = 'm_footer_opd_info';
    protected $primaryKey       = 'id_opd_info';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    // Kolom yang boleh diisi melalui Model (Mass Assignment)
    protected $allowedFields    = [
        'website_name',
        'official_title',
        'address',
        'email',
        'phone',
        'logo_cominfo',   // Menyimpan path string
        'election_badge', // Menyimpan path string
        'is_active',
        'created_by',
        'updated_by'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Casting Tipe Data (Opsional, agar output JSON konsisten)
    protected array $casts = [
        'id_opd_info' => 'int',
        'is_active'   => 'int',
    ];
    protected array $castHandlers = [];

    // Dates Management
    // Ubah ke true karena tabel Anda memiliki created_at & updated_at
    protected $useTimestamps = true; 
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at'; // Tidak dipakai karena soft delete false

    // =================================================================
    // VALIDATION RULES
    // =================================================================
    protected $validationRules = [
        'website_name' => [
            'rules'  => 'required|max_length[100]',
            'label'  => 'Nama Website'
        ],
        'official_title' => [
            'rules'  => 'required|max_length[200]',
            'label'  => 'Judul Resmi'
        ],
        'address' => [
            'rules'  => 'required',
            'label'  => 'Alamat'
        ],
        'email' => [
            'rules'  => 'required|valid_email|max_length[100]',
            'label'  => 'Email'
        ],
        'phone' => [
            'rules'  => 'required|max_length[50]|numeric', // Sesuaikan jika boleh ada tanda + atau -
            'label'  => 'Nomor Telepon'
        ],
    ];

    // Custom Pesan Error (Bahasa Indonesia)
    protected $validationMessages = [
        'website_name' => [
            'required'   => '{field} wajib diisi.',
            'max_length' => '{field} maksimal 100 karakter.'
        ],
        'official_title' => [
            'required'   => '{field} wajib diisi.',
            'max_length' => '{field} maksimal 200 karakter.'
        ],
        'address' => [
            'required' => '{field} wajib diisi.'
        ],
        'email' => [
            'valid_email' => 'Format email tidak valid.',
            'max_length'  => 'Email maksimal 100 karakter.'
        ],
        'phone' => [
            'numeric'    => '{field} hanya boleh berisi angka.',
            'max_length' => '{field} maksimal 50 karakter.'
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