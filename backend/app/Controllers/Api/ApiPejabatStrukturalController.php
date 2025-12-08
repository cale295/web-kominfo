<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\frontend\PejabatStrukturalModel;

class ApiPejabatStrukturalController extends ResourceController
{
    protected $modelName = PejabatStrukturalModel::class;
    protected $format    = 'json';

    /**
     * Index: Menampilkan semua data pejabat struktural yang aktif
     * Method: GET /api/pejabat_struktural
     */
    public function index()
    {
        // Ambil data yang statusnya aktif (1)
        // Urutkan berdasarkan ID ASC (atau sesuaikan kebutuhan)
        $data = $this->model
            ->where('is_active', '1')
            ->orderBy('id_pejabat_s', 'ASC')
            ->findAll();

        if ($data) {
            return $this->respond([
                'status'  => 200,
                'message' => 'Data pejabat struktural berhasil diambil.',
                'count'   => count($data),
                'data'    => $data
            ], 200);
        } else {
            return $this->respond([
                'status'  => 404,
                'message' => 'Data pejabat struktural kosong.',
                'data'    => []
            ], 404);
        }
    }

    /**
     * Show: Detail per ID
     * Method: GET /api/pejabat_struktural/{id}
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
                'message' => 'Detail pejabat struktural berhasil diambil.',
                'data'    => $data
            ], 200);
        } else {
            return $this->failNotFound('Data dengan ID ' . $id . ' tidak ditemukan.');
        }
    }
}