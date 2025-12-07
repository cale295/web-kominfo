<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\frontend\IpKerjasamaDaerahModel;

class ApiIpKerjasamaDaerahController extends ResourceController
{
    protected $modelName = IpKerjasamaDaerahModel::class;
    protected $format    = 'json';

    /**
     * Index: Ambil semua data
     * Method: GET /api/ip_kerjasama_daerah
     */
    public function index()
    {
        $data = $this->model
            ->orderBy('tanggal', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        if ($data) {
            return $this->respond([
                'status'  => 200,
                'message' => 'Data Kerjasama Daerah berhasil diambil.',
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
     * Method: GET /api/ip_kerjasama_daerah/{id}
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
                'message' => 'Detail data berhasil diambil.',
                'data'    => $data
            ], 200);
        } else {
            return $this->failNotFound('Data dengan ID ' . $id . ' tidak ditemukan.');
        }
    }
}