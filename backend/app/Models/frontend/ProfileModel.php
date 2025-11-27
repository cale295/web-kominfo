<?php

namespace App\Models\frontend;

use CodeIgniter\Model;

class ProfileModel extends Model
{
    protected $table            = 'm_profil';
    protected $primaryKey       = 'id_profil';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields    = [
        'id_parent',
        'type',
        'title',
        'slug',
        'content',
        'image',
        'sorting',
        'is_active',
        'hash'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // =============================
    //       VALIDATION RULES
    // =============================
    protected $validationRules = [
        'title' => [
            'label' => 'Judul',
            'rules' => 'required|min_length[3]|max_length[255]'
        ],

        'content' => [
            'label' => 'Konten',
            'rules' => 'permit_empty'
        ],

        'sorting' => [
            'label' => 'Sorting',
            'rules' => 'permit_empty|integer'
        ],

        'is_active' => [
            'label' => 'Status',
            'rules' => 'required|in_list[0,1]'
        ],

        'image' => [
            'label' => 'Gambar',
            'rules' =>
                'permit_empty|' .
                'is_image[image]|' .
                'mime_in[image,image/png,image/jpg,image/jpeg]|' .
                'max_size[image,2048]'
        ],
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Judul wajib diisi.',
            'min_length' => 'Judul minimal 3 karakter.',
            'max_length' => 'Judul maksimal 255 karakter.'
        ],
        'is_active' => [
            'required' => 'Status wajib dipilih.',
            'in_list' => 'Status tidak valid.'
        ],
        'image' => [
            'is_image' => 'File harus berupa gambar.',
            'mime_in' => 'Format gambar hanya boleh JPG, JPEG, PNG.',
            'max_size' => 'Ukuran gambar maksimal 2MB.'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
