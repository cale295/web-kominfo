<?php

namespace App\Controllers\Api;

use App\Models\frontend\KontakModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class ApiKontakController extends ResourceController
{
    protected $modelName = KontakModel::class;
    protected $format    = 'json';

    /**
     * Menampilkan semua data kontak
     * Method: GET
     * URL: /api/kontak
     */
    public function index()
    {
        $model = new KontakModel();
        
        // Mengambil data dengan urutan terbaru seperti di controller frontend
        $data = $model
        ->where('status', 'aktif')
        ->orderBy('created_at', 'DESC')->findAll();

        if ($data) {
            return $this->respond([
                'status'  => 200,
                'message' => 'Data kontak berhasil diambil',
                'data'    => $data
            ], 200);
        } else {
            return $this->respond([
                'status'  => 404,
                'message' => 'Data kontak tidak ditemukan',
                'data'    => []
            ], 404);
        }
    }

    /**
     * Menampilkan satu data kontak berdasarkan ID
     * Method: GET
     * URL: /api/kontak/{id}
     */
    public function show($id = null)
    {
        $model = new KontakModel();
        $data = $model->find($id);

        if ($data) {
            return $this->respond([
                'status'  => 200,
                'message' => 'Detail kontak ditemukan',
                'data'    => $data
            ], 200);
        } else {
            return $this->failNotFound('Data kontak dengan ID ' . $id . ' tidak ditemukan.');
        }
    }
}