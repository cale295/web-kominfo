<?php

namespace App\Models\frontend;

use CodeIgniter\Model;

class FooterStatisticsModel extends Model
{
    // Konfigurasi Tabel
    protected $table            = 'm_footer_statistics';
    protected $primaryKey       = 'id_footer_statis';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    // Kolom yang boleh diisi
    protected $allowedFields    = [
        'stat_type',    // Unik, misal: visitors_today
        'stat_label',   // Label Frontend: Pengunjung Hari Ini
        'stat_value',   // Nilai: 1024
        'stat_icon',    // Icon class: fas fa-users
        'is_active',
        'auto_update',  // 1 = Hitung otomatis sistem, 0 = Input manual
        'sorting',
        'created_by',
        'updated_by'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Casting
    protected array $casts = [
        'id_footer_statis' => 'int',
        'stat_value'       => 'int',
        'is_active'        => 'int',
        'auto_update'      => 'int',
        'sorting'          => 'int',
    ];

    // Dates Management
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at'; // Otomatis update sesuai definisi tabel

    // Validation Rules
    protected $validationRules = [
        'stat_type' => [
            'rules'  => 'required|max_length[50]|is_unique[m_footer_statistics.stat_type,id_footer_statis,{id_footer_statis}]',
            'label'  => 'Tipe Statistik'
        ],
        'stat_label' => [
            'rules'  => 'required|max_length[100]',
            'label'  => 'Label Tampilan'
        ],
        'stat_value' => [
            'rules'  => 'required|numeric',
            'label'  => 'Nilai'
        ],
        'stat_icon' => [
            'rules'  => 'permit_empty|max_length[50]',
            'label'  => 'Icon'
        ],
        'sorting' => [
            'rules'  => 'permit_empty|numeric',
            'label'  => 'Urutan'
        ],
        'is_active' => [
            'rules'  => 'permit_empty|in_list[0,1]',
            'label'  => 'Status Aktif'
        ],
        'auto_update' => [
            'rules'  => 'permit_empty|in_list[0,1]',
            'label'  => 'Auto Update'
        ],
    ];

    // Custom Messages
    protected $validationMessages = [
        'stat_type' => [
            'required'  => '{field} wajib diisi.',
            'is_unique' => '{field} ini sudah digunakan, harap pilih tipe lain.'
        ],
        'stat_value' => [
            'numeric' => '{field} harus berupa angka.'
        ]
    ];
}