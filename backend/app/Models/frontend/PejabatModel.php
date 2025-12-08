<?php

namespace App\Models\frontend;

use CodeIgniter\Model;

class PejabatModel extends Model
{
    protected $table            = 't_pejabat';
    protected $primaryKey       = 'id_pejabat';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama', 'nip', 'alamat_kantor', 'tempat_tanggal_lahir', 'jabatan', 'foto', 'slug', 'urutan', 'is_active', 'hash'];

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
        'id_pejabat' => [
            'rules' => 'required|numeric'
        ],
        'nama' => [
            'label' => 'Nama Lengkap',
            'rules' => 'required|min_length[3]|max_length[200]',
        ],
        'nip' => [
            'label' => 'NIP',
            // Rule: Boleh kosong, jika isi harus angka, min 5 digit, dan harus unik (kecuali record ini sendiri saat edit)
            'rules' => 'required|numeric|min_length[5]|is_unique[t_pejabat.nip,id_pejabat,{id_pejabat}]',
        ],
        'jabatan' => [
            'label' => 'Jabatan',
            'rules' => 'required|min_length[3]|max_length[200]',
        ],
        'tempat_tanggal_lahir' => [
            'label' => 'Tempat & Tanggal Lahir',
            'rules' => 'required|max_length[255]',
        ],
        'alamat_kantor' => [
            'label' => 'Alamat Kantor',
            'rules' => 'required|string',
        ],
        'urutan' => [
            'label' => 'Urutan',
            'rules' => 'required|numeric',
        ]
    ];

    protected $validationMessages   = [
        'nama' => [
            'required'   => '{field} wajib diisi.',
            'min_length' => '{field} terlalu pendek, minimal 3 karakter.',
            'max_length' => '{field} terlalu panjang.'
        ],
        'tempat_tanggal_lahir' => [
            'required'   => '{field} wajib diisi.',
        ],
        'alamat_kantor' => [
            'required'   => '{field} wajib diisi.',
        ],
        'nip' => [
            'required'   => '{field} wajib diisi.',
            'numeric'    => '{field} hanya boleh berisi angka.',
            'is_unique'  => '{field} sudah terdaftar pada pejabat lain.',
            'min_length' => '{field} terlalu pendek.'
        ],
        'jabatan' => [
            'required'   => '{field} wajib diisi.',
            'min_length' => '{field} terlalu pendek.'
        ],
        'urutan' => [
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