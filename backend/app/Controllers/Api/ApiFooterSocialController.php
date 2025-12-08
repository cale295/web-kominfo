<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\frontend\FooterSocialModel;

class ApiFooterSocialController extends ResourceController
{
    protected $modelName = FooterSocialModel::class;
    protected $format    = 'json';

    /**
     * Tampilkan List Social Media (Public API)
     * Hanya menampilkan yang statusnya Aktif
     * Method: GET /api/footer_social
     */
    public function index()
    {
        try {
            $data = $this->model
                ->where('is_active', '1')
                ->orderBy('sorting', 'ASC')
                ->orderBy('created_at', 'DESC')
                ->findAll();

            if (empty($data)) {
                return $this->respond([
                    'status'  => true,
                    'message' => 'Data social media belum ada.',
                    'data'    => []
                ]);
            }

            return $this->respond([
                'status'  => true,
                'message' => 'Data social media berhasil diambil.',
                'count'   => count($data),
                'data'    => $data
            ]);

        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    /**
     * Tampilkan Detail
     * Method: GET /api/footer_social/{id}
     */
    public function show($id = null)
    {
        try {
            if (empty($id)) {
                return $this->failNotFound('ID tidak boleh kosong.');
            }

            $data = $this->model->find($id);

            if (!$data) {
                return $this->failNotFound('Data tidak ditemukan.');
            }

            return $this->respond([
                'status'  => true,
                'message' => 'Detail social media berhasil diambil.',
                'data'    => $data
            ]);

        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }
}