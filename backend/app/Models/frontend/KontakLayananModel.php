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
        'nomor_telepon', 
        'tipe', 
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
        'nomor_telepon' => [
            'label' => 'Nomor Telepon',
            // Tidak menggunakan 'numeric' agar mendukung karakter seperti + atau -
            'rules' => 'required|max_length[50]' 
        ],
        'tipe' => [
            'label' => 'Tipe Layanan',
            // Validasi input harus salah satu dari opsi ENUM
            'rules' => 'required|in_list[download,whatsapp,layanan,sp4n,darurat]'
        ],
        'urutan' => [
            'label' => 'Urutan',
            'rules' => 'permit_empty|integer'
        ],
        'status' => [
            'label' => 'Status',
            'rules' => 'permit_empty|in_list[aktif,nonaktif]'
        ],
    ];

    // Pesan Error Custom (Opsional, agar lebih ramah pengguna)
    protected $validationMessages = [
        'judul' => [
            'required'   => 'Judul layanan wajib diisi.',
            'max_length' => 'Judul tidak boleh lebih dari 150 karakter.'
        ],
        'tipe' => [
            'in_list' => 'Tipe yang dipilih tidak valid.'
        ],
        'link_url' => [
            'required'   => 'Link URL wajib diisi.',
            'max_length' => 'Link URL tidak boleh lebih dari 255 karakter.'
        ],
        'nomor_telepon' => [
            'required'   => 'Nomor telepon wajib diisi.',
            'max_length' => 'Nomor telepon tidak boleh lebih dari 50 karakter.'
        ],
        'subjudul' => [
            'required'   => 'Sub judul wajib diisi.',
            'max_length' => 'Sub judul tidak boleh lebih dari 255 karakter.'
        ]

    ];
}