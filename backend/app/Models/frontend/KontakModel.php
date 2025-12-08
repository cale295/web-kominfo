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
        'fax',
        'map_link',
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
        'fax' => [
            'label' => 'Fax',
            'rules' => 'required|max_length[50]'
        ],
        'map_link' => [
            'label' => 'Link Google Maps',
            'rules' => 'required|valid_url' // URL Maps biasanya panjang, jadi hati-hati jika pakai max_length
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
        'fax' => [
            'max_length' => 'Nomor fax terlalu panjang.'
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