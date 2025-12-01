<?php

namespace App\Models\frontend;

use CodeIgniter\Model;

class TugasFungsiModel extends Model
{
    protected $table            = 'm_p_tugas_fungsi';
    protected $primaryKey       = 'id_tugas';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields    = [
        'type',          // Enum: tugas, fungsi
        'description',   // Text konten
        'order_number',  // Sorting
        'is_active',
        'created_at',
        'updated_at'
    ];

    // Dates Management
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation Rules
    protected $validationRules = [
        'type' => [
            'rules'  => 'required|in_list[tugas,fungsi]',
            'label'  => 'Tipe (Tugas/Fungsi)'
        ],
        'description' => [
            'rules'  => 'required',
            'label'  => 'Deskripsi'
        ],
        'order_number' => [
            'rules'  => 'permit_empty|numeric',
            'label'  => 'Urutan'
        ],
        'is_active' => [
            'rules'  => 'permit_empty|in_list[0,1]',
            'label'  => 'Status Aktif'
        ]
    ];
}