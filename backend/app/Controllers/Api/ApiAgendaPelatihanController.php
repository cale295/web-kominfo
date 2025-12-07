<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\frontend\AgendaPelatihanModel;

class ApiAgendaPelatihanController extends ResourceController
{
    protected $modelName = AgendaPelatihanModel::class;
    protected $format    = 'json';

    /**
     * Index: Ambil semua agenda yang 'published'
     * Method: GET /api/agenda_pelatihan
     */
    public function index()
    {
        // Hanya tampilkan yang published
        $data = $this->model
            ->where('status', 'published')
            ->orderBy('tanggal_agenda', 'DESC') // Agenda terdekat/terbaru diatas
            ->findAll();

        if ($data) {
            return $this->respond([
                'status'  => 200,
                'message' => 'Data agenda berhasil diambil.',
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
     * Method: GET /api/agenda_pelatihan/{id}
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
                'message' => 'Detail agenda berhasil diambil.',
                'data'    => $data
            ], 200);
        } else {
            return $this->failNotFound('Agenda dengan ID ' . $id . ' tidak ditemukan.');
        }
    }
}