<?php

namespace App\Models\frontend;

use CodeIgniter\Model;

class HomeVideoLayananModel extends Model
{
    protected $table            = 'm_home_video_layanan';
    protected $primaryKey       = 'id_video_layanan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields    = [
        'youtube_url',
        'embed_code',
        'thumb_image',
        'title',
        'description',
        'is_featured',
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
        'title' => [
            'rules'  => 'required|max_length[255]',
            'label'  => 'Judul Video'
        ],
        'youtube_url' => [
            'rules'  => 'required|max_length[255]|valid_url',
            'label'  => 'Link YouTube'
        ],
        'thumb_image' => [
            'rules'  => 'permit_empty|max_length[255]',
            'label'  => 'Thumbnail Video'
        ],
        'is_featured' => [
            'rules'  => 'permit_empty|in_list[0,1]',
            'label'  => 'Video Utama'
        ],
        'sorting' => [
            'rules'  => 'permit_empty|numeric',
            'label'  => 'Urutan'
        ],
        'is_active' => [
            'rules'  => 'permit_empty|in_list[0,1]',
            'label'  => 'Status Aktif'
        ]
    ];
}