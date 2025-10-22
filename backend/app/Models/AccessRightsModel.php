<?php

namespace App\Models;

use CodeIgniter\Model;

class AccessRightsModel extends Model
{
    protected $table = 't_access_rights';
    protected $primaryKey = 'id_access';
    protected $allowedFields = [
        'role', 'module_name', 'can_create', 'can_read', 'can_update', 'can_delete', 'can_publish'
    ];
}
