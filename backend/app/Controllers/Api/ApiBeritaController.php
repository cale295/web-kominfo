<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\BeritaModel;
use App\Models\BeritaUtamaModel;
use App\Models\KategoriModel;
use App\Models\BeritaTagModel;

class ApiBeritaController extends ResourceController
{
    protected $modelName = BeritaModel::class; // model default bawaan CI
    protected $format = 'json';

    protected $utamaModel; // model kedua
    protected $katemodel;
    protected $tagmodel;

    public function __construct()
    {
        $this->utamaModel = new BeritaUtamaModel(); // instance manual model kedua
        $this->katemodel = new KategoriModel();
        $this->tagmodel = new BeritaTagModel();
    }

    // ================================
    // TAMPILKAN SEMUA AGENDA (API)
    // ================================
public function index()
{
    $tagmodes = $this->tagmodel
    ->orderBy('created_at', 'DESC')
    ->findAll();


    $kategories = $this->katemodel
        ->where('trash', '0')
        ->where('is_show_nav', '1')
        ->orderBy('created_on', 'DESC')
        ->findAll();


    $beritautama = $this->utamaModel
        ->where('status', '1')
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
            'berita' => $beritas,
            'kategori' => $kategories,
            'tag' => $tagmodes
        ]
    ]);
}


    // ================================
    // TAMPILKAN 1 AGENDA BERDASARKAN ID
    // ================================
    public function show($id = null)
    {
        $kategories = $this->katemodel
            ->where('trash', '0')
            ->where('is_show_nav', '1')
            ->orderBy('created_on', 'DESC')
            ->findAll();
        if ($kategories) {
            return $this->respond([
                'status'  => true,
                'message' => 'Daftar kategori berhasil diambil.',
                'data'    => $kategories
            ]);
        }

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
