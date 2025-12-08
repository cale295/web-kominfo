<?php

namespace App\Models\frontend;

use CodeIgniter\Model;

class ProfilTentangModel extends Model
{
    protected $table            = 'm_profil_tentang';
    protected $primaryKey       = 'id_tentang';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields    = [
        'section',
        'title',
        'content',
        'image_url',
        'sorting',
        'is_active',
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
        'section' => [
            'rules'  => 'required|max_length[255]',
            'label'  => 'Section/Kategori'
        ],
        'title' => [
            'rules'  => 'required|max_length[255]',
            'label'  => 'Judul'
        ],
        'content' => [
            'rules'  => 'required',
            'label'  => 'Konten'
        ],
        'image_url' => [
            'rules'  => 'required|max_length[255]',
            'label'  => 'Gambar'
        ],
        'sorting' => [
            'rules'  => 'required|numeric',
            'label'  => 'Urutan'
        ],
        'is_active' => [
            'rules'  => 'required|in_list[0,1]',
            'label'  => 'Status Aktif'
        ]
    ];

    protected $validationMessages = [
        'section' => [
            'required' => 'Section/Kategori harus diisi.'
        ],
        'title' => [
            'required' => 'Judul harus diisi.',
            'max_length' => 'Judul tidak boleh lebih dari 255 karakter.'
        ],
        'image_url' => [
            'max_length' => 'URL gambar tidak boleh lebih dari 255 karakter.'
        ],
        'sorting' => [
            'numeric' => 'Urutan harus berupa angka.'
        ]
    ];
}