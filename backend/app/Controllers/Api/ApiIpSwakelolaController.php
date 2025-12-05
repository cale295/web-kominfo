<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\frontend\IpSwakelolaModel;

class ApiIpSwakelolaController extends ResourceController
{
    protected $modelName = IpSwakelolaModel::class;
    protected $format    = 'json';

    /**
     * Index: Ambil semua data IP Swakelola
     * Method: GET /api/ip_swakelola
     */
    public function index()
    {
        $data = $this->model
            ->orderBy('created_at', 'DESC')
            ->findAll();

        if ($data) {
            return $this->respond([
                'status'  => 200,
                'message' => 'Data IP Swakelola berhasil diambil.',
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
     * Method: GET /api/ip_swakelola/{id}
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