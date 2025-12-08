<?php

namespace App\Models\frontend;

use CodeIgniter\Model;

class KontakLayananModel extends Model
{
    protected $table            = 'm_kontak_layanan';
    protected $primaryKey       = 'id_kontak_layanan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array'; // Bisa diganti 'object' jika lebih suka
    protected $useSoftDeletes   = false;   // Tabel tidak memiliki kolom deleted_at
    protected $protectFields    = true;
    
    // Field yang boleh diisi (Mass Assignment)
    protected $allowedFields    = [
        'judul', 
        'subjudul', 
        'icon_class', 
        'icon_bg_color', 
        'link_url', 
        'urutan', 
        'status'
    ];

    // Konfigurasi Tanggal/Waktu
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // -------------------------------------------------------------------------
    // VALIDASI
    // -------------------------------------------------------------------------
    
    protected $validationRules = [
        'judul' => [
            'label' => 'Judul',
            'rules' => 'required|max_length[150]'
        ],
        'subjudul' => [
            'label' => 'Sub Judul',
            'rules' => 'required|max_length[255]'
        ],
        'icon_class' => [
            'label' => 'Icon Class',
            'rules' => 'required|max_length[100]'
        ],
        'icon_bg_color' => [
            'label' => 'Warna Background Icon',
            'rules' => 'required|max_length[20]'
        ],
        'urutan' => [
            'label' => 'Urutan',
            'rules' => 'required|integer'
        ],
        'status' => [
            'label' => 'Status',
            'rules' => 'required|in_list[aktif,nonaktif]'
        ],
    ];

    // Pesan Error Custom (Opsional, agar lebih ramah pengguna)
    protected $validationMessages = [
        'judul' => [
            'required'   => 'Judul layanan wajib diisi.',
            'max_length' => 'Judul tidak boleh lebih dari 150 karakter.'
        ],
        'link_url' => [
            'required'   => 'Link URL wajib diisi.',
            'max_length' => 'Link URL tidak boleh lebih dari 255 karakter.'
        ],
        'subjudul' => [
            'required'   => 'Sub judul wajib diisi.',
            'max_length' => 'Sub judul tidak boleh lebih dari 255 karakter.'
        ]

    ];
}