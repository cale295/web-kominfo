<?php

namespace App\Models;

use CodeIgniter\Model;

class PhotoAlbumModel extends Model
{
    protected $table = 'm_photo_album';
    protected $primaryKey = 'id_album';
    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $useSoftDeletes = false; // manual soft delete via kolom 'trash'

    protected $allowedFields = [
        'album_name',
        'description',
        'cover_image',
        'trash', // 0 = aktif, 1 = sampah
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'album_name' => 'required|min_length[3]|max_length[255]',
        'description' => 'permit_empty|max_length[500]',
    ];

    protected $validationMessages = [
        'album_name' => [
            'required' => 'Nama album wajib diisi.',
            'min_length' => 'Minimal 3 karakter.',
        ]
    ];
}
