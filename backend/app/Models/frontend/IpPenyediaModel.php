<?php

namespace App\Models\frontend;

use CodeIgniter\Model;

class IpPenyediaModel extends Model
{
    protected $table            = 't_ip_penyedia';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields    = [
        'id_rup',
        'nama_paket',
        'jenis_pengadaan',
        'metode_pengadaan',
        'jumlah_pagu',
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
        // ✅ TAMBAHKAN INI (Wajib ada agar placeholder {id} berfungsi saat edit)
        'id' => 'required', 

        'id_rup' => [
            // Gunakan 'required' karena di DB kolom ini NOT NULL
            'rules'  => 'required|max_length[50]|is_unique[t_ip_penyedia.id_rup,id,{id}]',
            'label'  => 'ID RUP'
        ],
        'nama_paket' => [
            'rules'  => 'required',
            'label'  => 'Nama Paket'
        ],
        'jenis_pengadaan' => [
            'rules'  => 'required|max_length[100]',
            'label'  => 'Jenis Pengadaan'
        ],
        'metode_pengadaan' => [
            'rules'  => 'required|max_length[100]',
            'label'  => 'Metode Pengadaan'
        ],
        'jumlah_pagu' => [
            'rules'  => 'required|max_length[50]',
            'label'  => 'Jumlah Pagu'
        ]
    ];

    protected $validationMessages = [
        'id_rup' => [
            'is_unique' => 'ID RUP sudah terdaftar.'
        ]
    ];
}