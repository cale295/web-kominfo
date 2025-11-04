<?php

namespace App\Models;

use CodeIgniter\Model;

class TemaKategoriModel extends Model
{
    protected $table            = 'm_ori_tema';
    protected $primaryKey       = 'id_tema';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_tema'];

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
    protected $validationRules      = ['nama_tema' => 'required|is_unique[m_ori_tema.nama_tema]|max_length[100]|min_length[3]'];
    protected $validationMessages   = ['nama_tema' => ['required' => 'Tema harus diisi.', 'is_unique' => 'Tema sudah ada.', 'max_length' => 'Tema maksimal 100 karakter.', 'min_length' => 'Tema minimal 3 karakter.']];
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
