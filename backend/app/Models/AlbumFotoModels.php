<?php

namespace App\Models;

use CodeIgniter\Model;

class AlbumFotoModels extends Model
{
    protected $table            = 'm_album_foto';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_album', 'deskripsi', 'gambar_sampul'];

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
    ['nama_album' => 'required|min_length[3]|max_length[100]', 
    'deskripsi' => 'required|min_length[3]|max_length[255]', 
    'gambar_sampul' => 'required'];
    protected $validationMessages   = 
    ['nama_album' => ['required' => 'Nama Album harus diisi', 'min_length' => 'Nama Album minimal 3 karakter', 'max_length' => 'Nama Album maksimal 100 karakter'], 
    'deskripsi' => ['required' => 'Deskripsi harus diisi', 'min_length' => 'Deskripsi minimal 3 karakter', 'max_length' => 'Deskripsi maksimal 255 karakter'], 
    'gambar_sampul' => ['required' => 'Gambar Sampul harus diisi']];
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
