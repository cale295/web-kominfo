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
            // 1. Ambil semua data menu (flat data) dari Model
            $flatMenu = $this->menuModel->getAllMenu();
            
            // 2. Ubah data flat menjadi struktur hierarki (tree)
            // Fungsi buildTree didefinisikan di MenuModel (seperti contoh sebelumnya)
            $menuTree = $this->menuModel->buildTree($flatMenu);

            // 3. Kembalikan data dalam format JSON
            return $this->respond([
                'status'  => 200,
                'message' => 'Data menu berhasil diambil',
                'data'    => $menuTree
            ]);
            
        } catch (\Exception $e) {
            // Tangani error jika terjadi masalah pada database atau logika
            return $this->failServerError('Terjadi kesalahan saat mengambil data menu.');
        }
    }
    
    // Anda bisa menambahkan method lain seperti show, create, update, delete di sini
}
