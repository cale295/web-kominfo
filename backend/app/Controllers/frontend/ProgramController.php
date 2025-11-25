<?php

namespace App\Controllers\frontend;

use App\Models\frontend\ProgramModel;
use App\Models\AccessRightsModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ProgramController extends BaseController
{
    protected $programModel;
    protected $accessRightsModel;

    protected $module = 'Program';

    public function __construct()
    {
        $this->programModel = new ProgramModel();
        $this->accessRightsModel = new AccessRightsModel();
    }
         private function getAccess($role)
    {
        $access = $this->accessRightsModel->where('role', $role)->where('module_name', $this->module)->first();
        if (!$access) return ['can_create'=>false,'can_read'=>false,'can_update'=>false,'can_delete'=>false];
        return [
            'can_create' => (bool)$access['can_create'],
            'can_read' => (bool)$access['can_read'],
            'can_update' => (bool)$access['can_update'],
            'can_delete' => (bool)$access['can_delete'],
        ];
    }
    public function index()
    {
        //
    }
}
