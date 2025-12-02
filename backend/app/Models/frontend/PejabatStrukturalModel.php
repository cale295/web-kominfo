<?php

namespace App\Models\frontend;

use CodeIgniter\Model;

class PejabatStrukturalModel extends Model
{
    protected $table            = 'm_p_pejabat_struktural';
    protected $primaryKey       = 'id_pejabat_s';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title',
        'subtitle',
        'image_url',
        'description',
        'is_active'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'title' => [
            'label' => 'Judul',
            'rules' => 'required|max_length[255]'
        ],
        'subtitle' => [
            'label' => 'Sub Judul',
            'rules' => 'permit_empty|max_length[255]'
        ],
        'is_active' => [
            'label' => 'Status',
            'rules' => 'required|in_list[0,1]'
        ],
        // Validasi gambar di handle manual di controller untuk update (agar bisa skip jika tidak ganti gambar)
        // Namun kita definisikan aturan dasar di sini
        'image' => [
            'label' => 'Gambar Struktur',
            'rules' => 'permit_empty|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]|max_size[image,5120]' // Max 5MB
        ]
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Judul wajib diisi.'
        ],
        'image' => [
            'is_image' => 'File yang diupload harus berupa gambar.',
            'mime_in'  => 'Format gambar harus JPG, JPEG, atau PNG.',
            'max_size' => 'Ukuran gambar maksimal 5MB.'
        ]
    ];
}