<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\frontend\HomeVideoLayananModel;

class ApiHomeVideoLayananController extends ResourceController
{
    protected $modelName = HomeVideoLayananModel::class;
    protected $format    = 'json';

    /**
     * Index: Menampilkan semua video yang Aktif
     */
    public function index()
    {
        try {
            $data = $this->model
                ->where('is_active', 1)
                ->orderBy('is_featured', 'DESC') // Tampilkan yang featured/utama duluan
                ->orderBy('sorting', 'ASC')
                ->findAll();

            if (empty($data)) {
                return $this->respond([
                    'status'  => true,
                    'message' => 'Data video kosong.',
                    'data'    => []
                ]);
            }

            // Note: Path 'thumb_image' dikirim raw (relative path)
            // Contoh: "uploads/home_video/thumb.png"
            
            return $this->respond([
                'status'  => true,
                'message' => 'Data video berhasil diambil.',
                'count'   => count($data),
                'data'    => $data
            ]);

        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    /**
     * Show: Detail Video
     */
    public function show($id = null)
    {
        try {
            if (!$id) return $this->failNotFound('ID tidak boleh kosong.');

            $data = $this->model->find($id);

            if (!$data) return $this->failNotFound('Data tidak ditemukan.');

            return $this->respond([
                'status'  => true,
                'message' => 'Detail video berhasil diambil.',
                'data'    => $data
            ]);

        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }
}