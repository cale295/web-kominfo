<?php

namespace App\Models\frontend;

use CodeIgniter\Model;

class AgendaPelatihanModel extends Model
{
    protected $table            = 't_ip_agenda_pelatihan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields    = [
        'judul',
        'tanggal_agenda',
        'waktu',
        'tempat',
        'deskripsi',
        'thumbnail',      // Nama file / Path
        'thumbnail_path', // Path lengkap (Duplicate untuk memenuhi struktur DB)
        'status',         // draft, published, archived
        'tanggal_publish',
        'created_at',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'judul' => [
            'rules'  => 'required|max_length[255]',
            'label'  => 'Judul Agenda'
        ],
        'tanggal_agenda' => [
            'rules'  => 'required|valid_date',
            'label'  => 'Tanggal Agenda'
        ],
        'waktu' => [
            'rules'  => 'required|max_length[50]',
            'label'  => 'Waktu'
        ],
        'tempat' => [
            'rules'  => 'required',
            'label'  => 'Tempat'
        ],
        'deskripsi' => [
            'rules'  => 'required',
            'label'  => 'Deskripsi'
        ],
        'status' => [
            'rules'  => 'required|in_list[draft,published,archived]',
            'label'  => 'Status'
        ],
        // Thumbnail wajib saat insert, opsional saat update (handled di controller)
    ];
}