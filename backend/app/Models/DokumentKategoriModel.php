<?php

namespace App\Models;

use CodeIgniter\Model;

class DokumentKategoriModel extends Model
{
    protected $table            = 'm_document_category';
    protected $primaryKey       = 'id_document_category ';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['category_name', 'category_description'];

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
    protected $validationRules      = ['category_name' => 'required|min_length[1]|max_length[50]',
                                      'category_description' => 'required|min_length[1]|max_length[100]'];
    protected $validationMessages   = ['category_name' => ['required' => 'Nama kategori harus diisi',
                                      'min_length' => 'Nama kategori minimal 1 karakter',
                                      'max_length' => 'Nama kategori maksimal 50 karakter'],
                                      'category_description' => ['required' => 'Deskripsi kategori harus diisi',
                                      'min_length' => 'Deskripsi kategori minimal 1 karakter',
                                      'max_length' => 'Deskripsi kategori maksimal 100 karakter']];
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
