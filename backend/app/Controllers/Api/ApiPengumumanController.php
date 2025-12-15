<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\frontend\PengumumanModel;

class ApiPengumumanController extends ResourceController
{
    protected $modelName = PengumumanModel::class;
    protected $format    = 'json';

    /**
     * Index: Ambil semua pengumuman yang aktif
     * Method: GET /api/pengumuman
     */
    public function index()
    {
        $data = $this->model
            ->where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        if ($data) {
            return $this->respond([
                'status'  => 200,
                'message' => 'Data pengumuman berhasil diambil.',
                'count'   => count($data),
                'data'    => $data
            ], 200);
        } else {
            return $this->respond([
                'status'  => 404,
                'message' => 'Data kosong.',
                'data'    => []
            ], 404);
        }
    }

    /**
     * Show: Detail per ID
     * Method: GET /api/pengumuman/{id}
     */
    public function show($id = null)
    {
        if (!$id) {
            return $this->failNotFound('ID tidak boleh kosong.');
        }

        $data = $this->model->find($id);

        if ($data) {
            return $this->respond([
                'status'  => 200,
                'message' => 'Detail pengumuman berhasil diambil.',
                'data'    => $data
            ], 200);
        } else {
            return $this->failNotFound('Data dengan ID ' . $id . ' tidak ditemukan.');
        }
    }
}