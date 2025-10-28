<?php

namespace App\Models;

use CodeIgniter\Model;

class GaleriFotoModel extends Model
{
    protected $table            = 't_galeri_fotophp';
    protected $primaryKey       = 'id_foto';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['judul_foto', 'path_file', 'slug', 'id_album', 'created_at', 'updated_at'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = 
    ['judul_foto' => 'required|min_length[8]|max_length[100]', 
    'path_file' => 'required|min_length[8]|max_length[100]', 
    'slug' => 'required|min_length[8]|max_length[100]', 
    'id_album' => 'required', 
    'created_at' => 'required', 
    'updated_at' => 'required',];
    protected $validationMessages =
        [
            'judul_foto' => [
                'required' => 'Judul Foto harus diisi',
            ],
            'path_file' => [
                'required' => 'Path File harus diisi',
            ],
            'slug' => [
                'required' => 'Slug harus diisi',
            ],
            'id_album' => [
                'required' => 'Id Album harus diisi',
            ],
            'created_at' => [
                'required' => 'Created At harus diisi',
            ],
        ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
