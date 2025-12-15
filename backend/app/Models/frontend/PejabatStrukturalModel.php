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
            'rules' => 'required|max_length[255]'
        ],
        'is_active' => [
            'label' => 'Status',
            'rules' => 'required|in_list[0,1]'
        ],
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Judul wajib diisi.'
        ],
    ];
}