<?php

namespace App\Models\frontend;

use CodeIgniter\Model;

class PermohonanInformasiModel extends Model
{
    protected $table            = 'permohonan_informasi';
    protected $primaryKey       = 'id_permohonan'; // Disesuaikan dengan SQL
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'judul_dokumen',
        'tahun',
        'file_name',
        'file_path'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation Rules
    protected $validationRules = [
        'judul_dokumen' => [
            'label' => 'Judul Dokumen',
            'rules' => 'required|max_length[255]'
        ],
        'tahun' => [
            'label' => 'Tahun',
            'rules' => 'permit_empty|numeric|max_length[50]'
        ],
        // Validasi file upload dihandle di controller
    ];

    protected $validationMessages = [
        'tahun' => [
            'numeric' => 'Tahun harus berupa angka.'
        ]
    ];
}