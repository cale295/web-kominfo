<?php

namespace App\Models\frontend;

use CodeIgniter\Model;

class InformasiPerencanaanModel extends Model
{
    protected $table            = 't_ip_perencanaan';
    protected $primaryKey       = 'id_perencanaan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'kategori',
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
        'kategori' => [
            'label' => 'Kategori',
            'rules' => 'required|max_length[255]'
        ],
        'judul_dokumen' => [
            'label' => 'Judul Dokumen',
            'rules' => 'required|max_length[255]'
        ],
        'tahun' => [
            'label' => 'Tahun',
            'rules' => 'required|numeric|max_length[4]'
        ],
        // Validasi file dihandle di controller agar lebih fleksibel saat update (bisa kosong)
    ];

    protected $validationMessages = [
        'tahun' => [
            'numeric' => 'Tahun harus berupa angka.'
        ]
    ];
}