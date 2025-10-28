<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaTagModel extends Model
{
    protected $table = 'm_berita_tag';
    protected $primaryKey = 'id_tags';
    protected $allowedFields = [
        'name', 'slug', 'created_at', 'created_by_id', 'created_by_name', 'is_delete', 'trash'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at'; // bisa ditambahkan jika mau update otomatis
    protected $deletedField  = 'is_delete';

    protected $returnType = 'array';
}
