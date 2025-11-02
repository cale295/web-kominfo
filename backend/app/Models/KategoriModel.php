<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table = 'm_kategori_berita';
    protected $primaryKey = 'id_kategori';

    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_parent',
        'hash',
        'kategori',
        'slug',
        'keterangan',
        'status',
        'trash',
        'created_on',
        'modified_on',
        'is_show_nav',
        'sorting_nav'
    ];

    // Optional: timestamps manual
    protected $useTimestamps = false;

    // Callbacks untuk timestamps
    protected $beforeInsert = ['setCreatedOn'];
    protected $beforeUpdate = ['setModifiedOn'];

    protected function setCreatedOn(array $data)
    {
        $data['data']['created_on'] = date('Y-m-d H:i:s');
        return $data;
    }

    protected function setModifiedOn(array $data)
    {
        $data['data']['modified_on'] = date('Y-m-d H:i:s');
        return $data;
    }

    // ======================
    // Validation
    // ======================
    protected $validationRules = [
        'kategori' => 'required|min_length[3]|max_length[100]',
        'slug'     => 'required|alpha_dash|is_unique[m_kategori_berita.slug,id_kategori,{id}]',
        'status'   => 'required|in_list[active,inactive]',
        'trash'    => 'permit_empty|in_list[0,1]',
        'is_show_nav' => 'permit_empty|in_list[0,1]',
        'sorting_nav' => 'permit_empty|numeric'
    ];

    protected $validationMessages = [
        'kategori' => [
            'required'   => 'Nama kategori harus diisi.',
            'min_length' => 'Kategori minimal 3 karakter.',
            'max_length' => 'Kategori maksimal 100 karakter.',
        ],
        'slug' => [
            'required'    => 'Slug harus diisi.',
            'alpha_dash'  => 'Slug hanya boleh huruf, angka, dash, dan underscore.',
            'is_unique'   => 'Slug sudah digunakan.',
        ],
        'status' => [
            'required' => 'Status harus diisi.',
            'in_list'  => 'Status harus "active" atau "inactive".',
        ],
        'trash' => [
            'in_list' => 'Trash hanya boleh 0 atau 1.',
        ],
        'is_show_nav' => [
            'in_list' => 'is_show_nav hanya boleh 0 atau 1.',
        ],
        'sorting_nav' => [
            'numeric' => 'Sorting nav harus angka.',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;
}
