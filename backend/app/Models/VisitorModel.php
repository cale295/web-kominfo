<?php

namespace App\Models;

use CodeIgniter\Model;

class VisitorModel extends Model
{
    protected $table = 't_visitors';
    protected $primaryKey = 'id';
    protected $allowedFields = ['ip_address', 'user_agent', 'access_date', 'last_activity'];
    protected $useTimestamps = false;
}