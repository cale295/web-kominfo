<?php

namespace App\Controllers\Api;

use App\Models\frontend\InformasiPerencanaanModel;
use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class ApiInformasiPerencanaanController extends BaseController
{
    use ResponseTrait;

    protected $perencanaanModel;

    public function __construct()
    {
        $this->perencanaanModel = new InformasiPerencanaanModel();
    }

    /**
     * Get All Documents
     * Method: GET
     * URL: /api/informasi_perencanaan
     */
    public function index()
    {
        // Langsung ambil semua data, urutkan berdasarkan tahun terbaru
        $data = $this->perencanaanModel->orderBy('tahun', 'DESC')->orderBy('created_at', 'DESC')->findAll();

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
            // Pastikan URL file valid
            $item['download_url'] = base_url($item['file_path']);
            return $item;
        }, $data);

        return $this->respond([
            'status'  => 200,
            'error'   => false,
            'message' => 'Berhasil mengambil data dokumen',
            'data'    => $data
        ], 200);
    }

    /**
     * Get Single Document Detail
     * Method: GET
     * URL: /api/informasi_perencanaan/{id}
     */
    public function show($id = null)
    {
        $data = $this->perencanaanModel->find($id);

        if (!$data) {
            return $this->failNotFound('Data dokumen dengan ID ' . $id . ' tidak ditemukan.');
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