<?php

namespace App\Models\frontend;

use CodeIgniter\Model;

class IpSwakelolaModel extends Model
{
    protected $table            = 't_ip_swakelola';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields    = [
        'id_rup',
        'nama_paket',
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
        // Wajib ada agar placeholder {id} berfungsi saat edit
        'id' => 'required',

        'id_rup' => [
            'rules'  => 'required|max_length[50]|is_unique[t_ip_swakelola.id_rup,id,{id}]',
            'label'  => 'ID RUP'
        ],
        'nama_paket' => [
            'rules'  => 'required',
            'label'  => 'Nama Paket'
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