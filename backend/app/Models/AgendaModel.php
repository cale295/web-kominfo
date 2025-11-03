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
    'activity_name' => 'required|min_length[3]',
    'start_date'    => 'required|valid_date',
    'end_date'      => 'required|valid_date',
];
    
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks (jika dibutuhkan nanti)
    protected $allowCallbacks = true;
}
