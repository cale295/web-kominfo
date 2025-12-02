<?php

namespace App\Models\frontend;

use CodeIgniter\Model;

class DaftarInformasiPublikModel extends Model
{
    protected $table            = 't_ip_daftar_informasi_publik';
    protected $primaryKey       = 'id_daftar_ip';
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

    // Validation
    protected $validationRules = [
        'judul_dokumen' => [
            'label' => 'Judul Dokumen',
            'rules' => 'required|max_length[255]'
        ],
        'tahun' => [
            'label' => 'Tahun',
            'rules' => 'required|numeric|max_length[50]'
        ],
        // Validasi file dihandle di controller agar fleksibel saat update
    ];

    protected $validationMessages = [
        'tahun' => [
            'numeric' => 'Tahun harus berupa angka.'
        ]
    ];
}