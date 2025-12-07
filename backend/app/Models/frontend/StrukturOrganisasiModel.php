<?php

namespace App\Models\frontend;

use CodeIgniter\Model;

class StrukturOrganisasiModel extends Model
{
    protected $table            = 'm_p_struktur_organisasi';
    protected $primaryKey       = 'id_struktur';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields    = [
        'parent_id',
        'nama',
        'slug',
        'deskripsi',
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
        'nama' => [
            'rules'  => 'required|max_length[255]',
            'label'  => 'Nama Unit/Jabatan'
        ],
        'sorting' => [
            'rules'  => 'permit_empty|numeric',
            'label'  => 'Urutan'
        ],
        'parent_id' => [
            'rules'  => 'permit_empty|numeric',
            'label'  => 'Induk'
        ]
    ];
}