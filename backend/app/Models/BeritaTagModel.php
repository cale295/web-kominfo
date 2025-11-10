<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaTagModel extends Model
{
    protected $table = 'm_berita_tag';
    protected $primaryKey = 'id_tags';
    protected $allowedFields = [
        'name', 'slug', 'created_at', 'created_by_id', 'created_by_name', 'is_delete'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'is_delete';

    protected $returnType = 'array';

    // =========================
    // Validation Rules
    // =========================
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[100]',
        'slug' => 'required|is_unique[m_berita_tag.slug,id_tags,{id}]',
        'is_delete' => 'in_list[0,1]',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Nama tag harus diisi.',
            'min_length' => 'Nama tag minimal 3 karakter.',
            'max_length' => 'Nama tag maksimal 100 karakter.'
        ],
        'slug' => [
            'required' => 'Slug harus diisi.',
            'is_unique' => 'Slug sudah digunakan, gunakan nama lain.'
        ],
        'is_delete' => [
            'in_list' => 'Nilai is_delete harus 0 atau 1.'
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;
}
