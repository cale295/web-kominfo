<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\frontend\TugasFungsiModel;

class ApiTugasFungsiController extends ResourceController
{
    protected $modelName = TugasFungsiModel::class;
    protected $format    = 'json';

    /**
     * Index: Ambil semua data tugas & fungsi
     */
    public function index()
    {
        // Mengambil semua data yang aktif
        $data = $this->model
            ->where('is_active', 1)
            ->orderBy('type', 'ASC')
            ->orderBy('order_number', 'ASC')
            ->findAll();

        if ($data) {
            return $this->respond([
                'status'  => 200,
                'message' => 'Data berhasil diambil.',
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
     */
    public function show($id = null)
    {
        $data = $this->model->find($id);

        if ($data) {
            return $this->respond([
                'status'  => 200,
                'message' => 'Detail data berhasil diambil.',
                'data'    => $data
            ], 200);
        } else {
            return $this->failNotFound('Data dengan ID ' . $id . ' tidak ditemukan.');
        }
    }
}