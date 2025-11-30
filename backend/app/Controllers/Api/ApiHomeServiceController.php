<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\frontend\HomeServiceModel;

class ApiHomeServiceController extends ResourceController
{
    protected $modelName = HomeServiceModel::class;
    protected $format    = 'json';

    /**
     * Tampilkan List Service (Public API)
     * Hanya menampilkan yang statusnya Aktif
     * Method: GET /api/home_service
     */
    public function index()
    {
        try {
            $data = $this->model
                ->where('is_active', 1)
                ->orderBy('sorting', 'ASC')
                ->orderBy('created_at', 'DESC')
                ->findAll();

            if (empty($data)) {
                return $this->respond([
                    'status'  => true,
                    'message' => 'Data layanan belum ada.',
                    'data'    => []
                ]);
            }

            // Note: Path gambar dikirim raw (relative path) agar frontend bisa mengatur base URL sendiri.
            
            return $this->respond([
                'status'  => true,
                'message' => 'Data layanan berhasil diambil.',
                'count'   => count($data),
                'data'    => $data
            ]);

        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    /**
     * Tampilkan Detail
     * Method: GET /api/home_service/{id}
     */
    public function show($id = null)
    {
        try {
            if (empty($id)) {
                return $this->failNotFound('ID tidak boleh kosong.');
            }

            $data = $this->model->find($id);

            if (!$data) {
                return $this->failNotFound('Data layanan tidak ditemukan.');
            }

            return $this->respond([
                'status'  => true,
                'message' => 'Detail layanan berhasil diambil.',
                'data'    => $data
            ]);

        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }
}