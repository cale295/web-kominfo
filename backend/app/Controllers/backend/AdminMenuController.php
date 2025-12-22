<?php

namespace App\Controllers\backend;

use App\Controllers\BaseController;
use App\Models\MenuModel;

class AdminMenuController extends BaseController
{
    protected $menuModel;

    public function __construct()
    {
        $this->menuModel = new MenuModel();
    }

    /**
     * Ambil menu admin (parent + child)
     * Dipakai untuk sidebar admin
     */
 public function getMenu()
{
    return $this->menuModel
        ->where('status', 'active')
        ->where('admin_url IS NOT NULL')
        ->where('admin_url !=', '')
        ->orderBy('order_number', 'ASC')
        ->findAll();
}

}
