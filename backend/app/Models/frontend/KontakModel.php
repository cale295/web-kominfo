<?php

namespace App\Models\frontend;

use CodeIgniter\Model;

class KontakModel extends Model
{
    protected $table            = 'm_kontak';
    protected $primaryKey       = 'id_kontak';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    
    // Saya hapus duplikasi 'email' yang ada di snippet Anda sebelumnya
    protected $allowedFields    = [
        'nama_instansi',
        'alamat_lengkap',
        'telepon',
        'email',
        'fax',
        'website',
        'latitude',
        'longitude',
        'map_link',
        'footer_text',
        'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // -------------------------------------------------------------------------
    // VALIDASI
    // -------------------------------------------------------------------------
    
    protected $validationRules = [
        'nama_instansi' => [
            'label' => 'Nama Instansi',
            'rules' => 'required|max_length[255]'
        ],
        'alamat_lengkap' => [
            'label' => 'Alamat Lengkap',
            'rules' => 'required' // Tidak pakai max_length jika tipe DB-nya TEXT
        ],
        'telepon' => [
            'label' => 'Telepon',
            // Tidak pakai numeric agar bisa input karakter: (021) 123-4567 atau +62
            'rules' => 'required|max_length[50]' 
        ],
        'email' => [
            'label' => 'Email',
            'rules' => 'required|valid_email|max_length[100]'
        ],
        'fax' => [
            'label' => 'Fax',
            'rules' => 'permit_empty|max_length[50]'
        ],
        'website' => [
            'label' => 'Website',
            'rules' => 'permit_empty|valid_url|max_length[255]'
        ],
        'latitude' => [
            'label' => 'Latitude',
            // Decimal memastikan input berupa angka desimal koordinat
            'rules' => 'permit_empty|decimal|max_length[50]' 
        ],
        'longitude' => [
            'label' => 'Longitude',
            'rules' => 'permit_empty|decimal|max_length[50]'
        ],
        'map_link' => [
            'label' => 'Link Google Maps',
            'rules' => 'permit_empty|valid_url' // URL Maps biasanya panjang, jadi hati-hati jika pakai max_length
        ],
        'footer_text' => [
            'label' => 'Teks Footer',
            'rules' => 'permit_empty|max_length[255]'
        ],
        'status' => [
            'label' => 'Status',
            'rules' => 'required|in_list[aktif,nonaktif]'
        ],
    ];

    // -------------------------------------------------------------------------
    // PESAN ERROR CUSTOM (Bahasa Indonesia)
    // -------------------------------------------------------------------------

    protected $validationMessages = [
        'nama_instansi' => [
            'required'   => 'Nama instansi wajib diisi.',
            'max_length' => 'Nama instansi terlalu panjang (maksimal 255 karakter).'
        ],
        'alamat_lengkap' => [
            'required' => 'Alamat lengkap wajib diisi.'
        ],
        'telepon' => [
            'required'   => 'Nomor telepon wajib diisi.',
            'max_length' => 'Nomor telepon terlalu panjang.'
        ],
        'email' => [
            'required'    => 'Email wajib diisi.',
            'valid_email' => 'Format email tidak valid (contoh: admin@instansi.com).',
            'max_length'  => 'Email terlalu panjang.'
        ],
        'website' => [
            'valid_url' => 'Format URL website tidak valid (harus diawali http:// atau https://).'
        ],
        'latitude' => [
            'decimal' => 'Latitude harus berupa angka desimal.'
        ],
        'longitude' => [
            'decimal' => 'Longitude harus berupa angka desimal.'
        ],
        'map_link' => [
            'valid_url' => 'Link Google Maps tidak valid (harus diawali http:// atau https://).'
        ],
        'status' => [
            'required' => 'Status wajib dipilih.',
            'in_list'  => 'Status yang dipilih tidak valid.'
        ]
    ];
}