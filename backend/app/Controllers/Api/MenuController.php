<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\MenuModel;

class MenuController extends ResourceController
{
    protected $menuModel;

    public function __construct()
    {
        $this->menuModel = new MenuModel();
    }
/**
     * Mengambil dan mengembalikan semua data menu dalam format hierarki (JSON).
     * Route: GET /api/menu
     */
public function index()
{
    try {
        // 🔹 Ambil menu khusus FRONTEND
        $flatMenu = $this->menuModel
            ->where('status', 'active')
            ->where('menu_url IS NOT NULL')
            ->where('menu_url !=', '')
            ->orderBy('order_number', 'ASC')
            ->findAll();

        // 🔹 Bangun tree frontend
        $menuTree = $this->menuModel->buildTree($flatMenu);

        return $this->respond([
            'status'  => 200,
            'message' => 'Data menu frontend berhasil diambil',
            'data'    => $menuTree
        ]);

    } catch (\Exception $e) {
        return $this->failServerError('Terjadi kesalahan saat mengambil menu frontend.');
    }
}

    
    // Anda bisa menambahkan method lain seperti show, create, update, delete di sini
}
