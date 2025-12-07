<?php

namespace App\Models\frontend;

use CodeIgniter\Model;

class IpKerjasamaDaerahModel extends Model
{
    protected $table            = 't_ip_kerjasama_daerah';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields    = [
        'tanggal',
        'perihal',
        'tentang',
        'nomor',
        'created_at',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'tanggal' => [
            'rules'  => 'required|valid_date',
            'label'  => 'Tanggal'
        ],
        'nomor' => [
            'rules'  => 'required|max_length[100]',
            'label'  => 'Nomor Surat/Dokumen'
        ],
        'tentang' => [
            'rules'  => 'required|max_length[255]',
            'label'  => 'Tentang'
        ],
        'perihal' => [
            'rules'  => 'required',
            'label'  => 'Perihal'
        ]
    ];
}