<?php

namespace App\Models\frontend;

use CodeIgniter\Model;

class PengumumanModel extends Model
{
    protected $table            = 't_pengumuman';
    protected $primaryKey       = 'id_pengumuman';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields    = [
        'judul',
        'content',
        'featured_image',
        'tipe_media',
        'link_url',
        'file_media',
        'status',
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
        'judul' => [
            'rules'  => 'required|max_length[255]',
            'label'  => 'Judul Pengumuman'
        ],
        'content' => [
            'rules'  => 'required',
            'label'  => 'Isi Pengumuman'
        ],
        'tipe_media' => [
            'rules'  => 'required|in_list[link,file]',
            'label'  => 'Tipe Media'
        ],
        'status' => [
            'rules'  => 'required|in_list[0,1]',
            'label'  => 'Status'
        ],
        // Validasi featured_image dan file_media ditangani di controller untuk fleksibilitas update
    ];
}