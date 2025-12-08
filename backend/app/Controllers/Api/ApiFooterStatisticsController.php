<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\frontend\FooterStatisticsModel;

class ApiFooterStatisticsController extends ResourceController
{
    protected $modelName = FooterStatisticsModel::class;
    protected $format    = 'json';

    /**
     * Tampilkan List Statistik (Public API)
     * Hanya menampilkan yang statusnya Aktif
     * Method: GET /api/footer_statistics
     */
    public function index()
    {
        try {
            $data = $this->model
                ->where('is_active', '1')
                ->orderBy('sorting', 'ASC')
                ->findAll();

            if (empty($data)) {
                return $this->respond([
                    'status'  => true,
                    'message' => 'Data statistik belum ada.',
                    'data'    => []
                ]);
            }

            return $this->respond([
                'status'  => true,
                'message' => 'Data statistik berhasil diambil.',
                'count'   => count($data),
                'data'    => $data
            ]);

        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    /**
     * Tampilkan Detail
     * Method: GET /api/footer_statistics/{id}
     */
    public function show($id = null)
    {
        try {
            if (empty($id)) {
                return $this->failNotFound('ID tidak boleh kosong.');
            }

            // Cari berdasarkan ID
            $data = $this->model->find($id);

            // Jika tidak ketemu, coba cari berdasarkan stat_type (slug-like)
            if (!$data && !is_numeric($id)) {
                $data = $this->model->where('stat_type', $id)->first();
            }

            if (!$data) {
                return $this->failNotFound('Data tidak ditemukan.');
            }

            return $this->respond([
                'status'  => true,
                'message' => 'Detail statistik berhasil diambil.',
                'data'    => $data
            ]);

        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }
}