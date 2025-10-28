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

    // Kalau mau otomatis isi waktu
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
}
