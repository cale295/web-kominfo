<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaUtamaModel extends Model
{
    protected $table = 't_berita_utama';
    protected $primaryKey = 'id_berita_utama';
    protected $allowedFields = [
        'id_berita', 'jenis', 'created_date', 
        'created_by_id', 'created_by_name', 'status'
    ];
}
