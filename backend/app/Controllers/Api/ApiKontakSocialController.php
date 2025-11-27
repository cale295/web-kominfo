<?php

namespace App\Controllers\Api;

use App\Models\frontend\KontakSocialModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class ApiKontakSocialController extends ResourceController
{
    protected $modelName = KontakSocialModel::class;
    protected $format    = 'json';

    /**
     * Menampilkan semua data kontak social
     * Method: GET
     * URL: /api/kontak_social
     */
    public function index()
    {
        $model = new KontakSocialModel();

        // Mengambil data dengan urutan terbaru (created_at DESC) sesuai logic frontend
        $data = $model
        ->where('status', 'aktif')
        ->orderBy('created_at', 'DESC')->findAll();

        if ($data) {
            return $this->respond([
                'status'  => 200,
                'message' => 'Data kontak social berhasil diambil',
                'data'    => $data
            ], 200);
        } else {
            return $this->respond([
                'status'  => 404,
                'message' => 'Data kontak social tidak ditemukan',
                'data'    => []
            ], 404);
        }
    }

    /**
     * Menampilkan satu data kontak social berdasarkan ID
     * Method: GET
     * URL: /api/kontak_social/{id}
     */
    public function show($id = null)
    {
        $model = new KontakSocialModel();
        $data = $model->find($id);

        if ($data) {
            return $this->respond([
                'status'  => 200,
                'message' => 'Detail kontak social ditemukan',
                'data'    => $data
            ], 200);
        } else {
            return $this->failNotFound('Data kontak social dengan ID ' . $id . ' tidak ditemukan.');
        }
    }
}