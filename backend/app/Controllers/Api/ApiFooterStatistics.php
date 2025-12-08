<?php

namespace App\Controllers\frontend;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\frontend\FooterStatisticsModel;

class ApiFooterStatistics extends ResourceController
{
    // Load Model secara otomatis oleh ResourceController
    protected $modelName = FooterStatisticsModel::class;
    protected $format    = 'json';

    public function index()
    {
        try {
            // 1. PENTING: Trigger hitung ulang otomatis sebelum mengambil data.
            // Ini memastikan pengunjung yang baru saja masuk langsung terhitung saat API dipanggil.
            $this->model->syncAutoStats();

            // 2. Ambil data statistik
            // Kondisi: Hanya yang AKTIF dan urutkan berdasarkan SORTING
            $data = $this->model
                ->where('is_active', '1')
                ->orderBy('sorting', 'ASC')
                ->findAll();

            // 3. Cek jika data kosong
            if (empty($data)) {
                return $this->respond([
                    'status'  => 404,
                    'message' => 'Data statistik belum tersedia.',
                    'data'    => []
                ], 404);
            }

            // 4. Return Data JSON Sukses
            return $this->respond([
                'status'  => 200,
                'message' => 'Data statistik berhasil diambil.',
                'data'    => $data
            ], 200);

        } catch (\Exception $e) {
            // Error Handling jika terjadi masalah server
            return $this->failServerError('Terjadi kesalahan server: ' . $e->getMessage());
        }
    }
}