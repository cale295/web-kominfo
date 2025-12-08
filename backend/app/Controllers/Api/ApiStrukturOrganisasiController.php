<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\frontend\StrukturOrganisasiModel;

class ApiStrukturOrganisasiController extends ResourceController
{
    protected $modelName = StrukturOrganisasiModel::class;
    protected $format    = 'json';

    /**
     * Index: Ambil semua data struktur organisasi yang aktif
     * Diurutkan berdasarkan parent dan sorting untuk memudahkan frontend membuat tree.
     */
    public function index()
    {
        $data = $this->model
            ->where('is_active', '1')
            ->orderBy('parent_id', 'ASC') // Parent dulu (NULL)
            ->orderBy('sorting', 'ASC')
            ->findAll();

        if ($data) {
            return $this->respond([
                'status'  => 200,
                'message' => 'Data struktur organisasi berhasil diambil.',
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
     * Show: Detail per Slug (Prioritas) atau ID (Fallback)
     * URL: /api/struktur_organisasi/{slug}
     */
    public function show($slug = null)
    {
        if (empty($slug)) {
            return $this->failNotFound('Slug atau ID tidak boleh kosong.');
        }

        // 1. Cari berdasarkan SLUG dulu (Prioritas)
        $data = $this->model->where('slug', $slug)->first();

        // 2. Fallback: Cari berdasarkan ID jika slug tidak ketemu & parameter berupa angka
        if (!$data && is_numeric($slug)) {
            $data = $this->model->find($slug);
        }

        if ($data) {
            return $this->respond([
                'status'  => 200,
                'message' => 'Detail struktur berhasil diambil.',
                'data'    => $data
            ], 200);
        } else {
            return $this->failNotFound('Data struktur organisasi tidak ditemukan.');
        }
    }
}