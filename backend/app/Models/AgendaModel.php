<?php

namespace App\Models;

use CodeIgniter\Model;

class AgendaModel extends Model
{
    protected $table            = 't_agenda';
    protected $primaryKey       = 'id_agenda';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'activity_name',
        'description',
        'start_date',
        'end_date',
        'location',
        'status',
        'image',
    ];


    protected $useTimestamps = false;

    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation (opsional)
  protected $validationRules = [
    'activity_name' => 'required|min_length[3]|max_length[255]',
    'description'   => 'required|min_length[3]|max_length[255]',
    'location'      => 'required|min_length[2]|max_length[255]',
    'start_date'    => 'required|valid_date',
    'end_date'      => 'required|valid_date',
];
    
    protected $validationMessages   = [
        'activity_name' => [
            'required' => 'Nama kegiatan harus diisi.',
            'min_length' => 'Nama kegiatan minimal 3 karakter.',
            'max_length' => 'Nama kegiatan maksimal 255 karakter.',
        ],
        'description' => [
            'required' => 'Deskripsi harus diisi.',
            'min_length' => 'Deskripsi minimal 3 karakter.',
            'max_length' => 'Deskripsi maksimal 255 karakter.',
        ],
        'location' => [
            'required' => 'Lokasi harus diisi.',
            'min_length' => 'Lokasi minimal 2 karakter.',
            'max_length' => 'Lokasi maksimal 255 karakter.',        
        ],
        'start_date' => [
            'required' => 'Tanggal mulai harus diisi.',
            'valid_date' => 'Format tanggal mulai tidak valid.',
        ],        
        'end_date' => [
            'required' => 'Tanggal selesai harus diisi.',
            'valid_date' => 'Format tanggal selesai tidak valid.',
        ],   
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks (jika dibutuhkan nanti)
    protected $allowCallbacks = true;
}
