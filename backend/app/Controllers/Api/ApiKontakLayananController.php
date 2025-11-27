<?php

namespace App\Controllers\Api;

use App\Models\frontend\KontakLayananModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class ApiKontakLayananController extends ResourceController
{
    protected $modelName = KontakLayananModel::class;
    protected $format    = 'json';

    /**
     * Menampilkan semua data kontak layanan
     * Method: GET
     * URL: /api/kontak_layanan
     */
    public function index()
    {
        $model = new KontakLayananModel();

        // Mengambil data dengan urutan terbaru (created_at DESC) sesuai logic frontend
        $data = $model
        ->where('status', 'aktif')
        ->orderBy('created_at', 'DESC')->findAll();

        if ($data) {
            return $this->respond([
                'status'  => 200,
                'message' => 'Data kontak layanan berhasil diambil',
                'data'    => $data
            ], 200);
        } else {
            return $this->respond([
                'status'  => 404,
                'message' => 'Data kontak layanan tidak ditemukan',
                'data'    => []
            ], 404);
        }
    }

    /**
     * Menampilkan satu data kontak layanan berdasarkan ID
     * Method: GET
     * URL: /api/kontak_layanan/{id}
     */
    public function show($id = null)
    {
        $model = new KontakLayananModel();
        $data = $model->find($id);

        if ($data) {
            return $this->respond([
                'status'  => 200,
                'message' => 'Detail kontak layanan ditemukan',
                'data'    => $data
            ], 200);
        } else {
            return $this->failNotFound('Data kontak layanan dengan ID ' . $id . ' tidak ditemukan.');
        }
    }
}