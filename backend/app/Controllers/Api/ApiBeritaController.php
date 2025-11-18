<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\BeritaModel;
use App\Models\BeritaUtamaModel;

class ApiBeritaController extends ResourceController
{
    protected $modelName = BeritaModel::class; // model default bawaan CI
    protected $format = 'json';

    protected $utamaModel; // model kedua

    public function __construct()
    {
        $this->utamaModel = new BeritaUtamaModel(); // instance manual model kedua
    }

    // ================================
    // TAMPILKAN SEMUA AGENDA (API)
    // ================================
public function index()
{
    $beritautama = $this->utamaModel
        ->where('status', '0')
        ->orderBy('created_date', 'DESC')
        ->first();

    $beritas = $this->model
        ->where('trash', '0')
        ->orderBy('created_at', 'DESC')
        ->findAll();

    return $this->respond([
        'status'  => true,
        'message' => 'Data berita berhasil diambil.',
        'data'    => [
            'utama'  => $beritautama,
            'berita' => $beritas
        ]
    ]);
}


    // ================================
    // TAMPILKAN 1 AGENDA BERDASARKAN ID
    // ================================
    public function show($id = null)
    {
        $beritautama = $this->utamaModel
            ->where('id_berita', $id)
            ->where('trash', '0')
            ->first();

        if ($beritautama) {
            return $this->respond([
                'status'  => true,
                'message' => 'Berita utama berhasil diambil.',
                'data'    => $beritautama
            ]);
        }

        $beritas = $this->model
            ->where('id_berita', $id)
            ->where('trash', '0')
            ->first();

        if (!$beritas) {
            return $this->failNotFound('Berita tidak ditemukan.');
        }

        // Tambah hit
        $this->model->set('hit', 'hit + 1', false)
                    ->where('id_berita', $id)
                    ->update();

        $beritas['hit']++;

        return $this->respond([
            'status'  => true,
            'message' => 'Detail berita berhasil diambil.',
            'data'    => $beritas
        ]);
    }
}
