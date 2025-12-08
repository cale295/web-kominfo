<?php

namespace App\Models\frontend;

use CodeIgniter\Model;

class ProgramModel extends Model
{
    protected $table            = 'm_program';
    protected $primaryKey       = 'id_program';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_program', 'nama_kegiatan', 'nilai_anggaran', 'tahun', 'slug', 'file_lampiran', 'sorting', 'is_active', 'hash'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // -------------------------------------------------------------------------
    // VALIDATION RULES
    // -------------------------------------------------------------------------
    protected $validationRules      = [
        'nama_program' => [
            'label' => 'Nama Program',
            'rules' => 'required|min_length[3]|max_length[255]',
        ],
        'nama_kegiatan' => [
            'label' => 'Nama Kegiatan',
            'rules' => 'required|min_length[3]|max_length[255]',
        ],
        'nilai_anggaran' => [
            'label' => 'Nilai Anggaran',
            'rules' => 'required|numeric', // Boleh kosong, jika isi harus angka
        ],
        'tahun' => [
            'label' => 'Tahun',
            'rules' => 'required|numeric|exact_length[4]', // Harus angka 4 digit
        ],
        'sorting' => [
            'label' => 'Urutan',
            'rules' => 'required|numeric',
        ],
    ];

    protected $validationMessages   = [
        'nama_program' => [
            'required'   => ' wajib diisi.',
            'min_length' => '{field} terlalu pendek, minimal 3 karakter.',
            'max_length' => '{field} terlalu panjang.'
        ],
        'nama_kegiatan' => [
            'required'   => '{field} wajib diisi.',
            'min_length' => '{field} terlalu pendek, minimal 3 karakter.'
        ],
        'tahun' => [
            'required'     => '{field} wajib diisi.',
            'numeric'      => '{field} harus berupa angka.',
            'exact_length' => '{field} harus format tahun 4 digit (misal: 2024).'
        ],
        'nilai_anggaran' => [
            'numeric' => '{field} harus berupa angka tanpa titik/koma.'
        ],
        'sorting' => [
            'numeric' => '{field} harus berupa angka.'
        ]
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