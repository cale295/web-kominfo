<?php

namespace App\Controllers\Api;

use App\Models\frontend\DaftarInformasiPublikModel;
use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class ApiDaftarInformasiPublikController extends BaseController
{
    use ResponseTrait;

    protected $infoPublikModel;

    public function __construct()
    {
        $this->infoPublikModel = new DaftarInformasiPublikModel();
    }

    /**
     * Get All Documents
     * Method: GET
     * URL: /api/daftar_informasi_publik
     */
    public function index()
    {
        // Ambil semua data urut berdasarkan tahun dan created_at
        $data = $this->infoPublikModel->orderBy('tahun', 'DESC')->orderBy('created_at', 'DESC')->findAll();

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
            'message' => 'Berhasil mengambil data dokumen',
            'data'    => $data
        ], 200);
    }

    /**
     * Get Single Document Detail
     * Method: GET
     * URL: /api/daftar_informasi_publik/{id}
     */
    public function show($id = null)
    {
        $data = $this->infoPublikModel->find($id);

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