<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\frontend\FooterOpdModel;

class ApiFooterOpdController extends ResourceController
{
    protected $modelName = FooterOpdModel::class;
    protected $format    = 'json';

    /**
     * Tampilkan List Footer OPD (Public API)
     * Hanya menampilkan yang statusnya Aktif
     * Method: GET /api/footer_opd
     */
    public function index()
    {
        try {
            // Ambil data yang aktif saja untuk ditampilkan di Frontend
            $data = $this->model
                ->where('is_active', 1)
                ->orderBy('created_at', 'DESC')
                ->findAll();

            if (empty($data)) {
                return $this->respond([
                    'status'  => true,
                    'message' => 'Data footer belum ada.',
                    'data'    => []
                ]);
            }

            // Note: Path gambar ('logo_cominfo', 'election_badge') dikirim apa adanya 
            // (relative path) sesuai format di database agar frontend yang mengatur base URL-nya.

            return $this->respond([
                'status'  => true,
                'message' => 'Data footer berhasil diambil.',
                'count'   => count($data),
                'data'    => $data
            ]);

        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    /**
     * Tampilkan Detail Footer OPD
     * Method: GET /api/footer_opd/{id}
     */
    public function show($id = null)
    {
        try {
            if (empty($id)) {
                return $this->failNotFound('ID tidak boleh kosong.');
            }

            $data = $this->model->find($id);

            if (!$data) {
                return $this->failNotFound('Data footer tidak ditemukan.');
            }

            return $this->respond([
                'status'  => true,
                'message' => 'Detail footer berhasil diambil.',
                'data'    => $data
            ]);

        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }
}