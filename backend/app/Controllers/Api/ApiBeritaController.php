<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\BeritaModel;

class ApiBeritaController extends ResourceController
{
    protected $modelName = BeritaModel::class;
    protected $format = 'json';

    // ================================
    // TAMPILKAN SEMUA AGENDA (API)
    // ================================
public function index()
{
    $beritas = $this->model
        ->where('trash', '0')
        ->orderBy('created_at', 'DESC')
        ->findAll();

    return $this->respond([
        'status'  => true,
        'message' => 'Daftar agenda aktif berhasil diambil.',
        'data'    => $beritas
    ]);
}


    // ================================
    // TAMPILKAN 1 AGENDA BERDASARKAN ID
    // ================================
    public function show($id = null)
    {
        $beritas = $this->model
            ->where('id_berita ', $id)
            ->where('trash', '0') // pastikan bukan sampah
            ->first();

        if (!$beritas) {
            return $this->failNotFound('berita tidak ditemukan.');
        }

        return $this->respond([
            'status'  => true,
            'message' => 'Detail album berhasil diambil.',
            'data'    => $beritas
        ]);
    }
}
