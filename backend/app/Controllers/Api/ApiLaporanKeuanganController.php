<?php

namespace App\Controllers\Api;

use App\Models\frontend\LaporanKeuanganModel;
use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class ApiLaporanKeuanganController extends BaseController
{
    use ResponseTrait;

    protected $keuanganModel;

    public function __construct()
    {
        $this->keuanganModel = new LaporanKeuanganModel();
    }

    /**
     * Get All Documents
     * Method: GET
     * URL: /api/laporan_keuangan
     */
    public function index()
    {
        // Langsung ambil semua data, urutkan berdasarkan tahun terbaru
        $data = $this->keuanganModel->orderBy('tahun', 'DESC')->orderBy('created_at', 'DESC')->findAll();

        if (empty($data)) {
            return $this->respond([
                'status'  => 404,
                'error'   => true,
                'message' => 'Data tidak ditemukan',
                'data'    => []
            ], 404);
        }

        // Generate Full Download URL
        $data = array_map(function($item) {
            $item['download_url'] = base_url($item['file_path']);
            return $item;
        }, $data);

        return $this->respond([
            'status'  => 200,
            'error'   => false,
            'message' => 'Berhasil mengambil data laporan keuangan',
            'data'    => $data
        ], 200);
    }

    /**
     * Get Single Document Detail
     * Method: GET
     * URL: /api/laporan_keuangan/{id}
     */
    public function show($id = null)
    {
        $data = $this->keuanganModel->find($id);

        if (!$data) {
            return $this->failNotFound('Data laporan dengan ID ' . $id . ' tidak ditemukan.');
        }

        // Generate Full Download URL
        $data['download_url'] = base_url($data['file_path']);

        return $this->respond([
            'status' => 200,
            'error'  => false,
            'data'   => $data
        ], 200);
    }
}