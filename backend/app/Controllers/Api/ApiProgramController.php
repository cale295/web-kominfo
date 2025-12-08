<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\frontend\ProgramModel;

class ApiProgramController extends ResourceController
{
    // ✅ PERBAIKAN: Gunakan $modelName (L besar), bukan $modename
    protected $modelName = ProgramModel::class;
    protected $format    = 'json';

    /**
     * Tampilkan List Program
     * Method: GET /api/program
     */
    public function index()
    {
        // Ambil data yang aktif saja
        $data = $this->model
            ->where('is_active', '1') 
            ->orderBy('sorting', 'ASC')       // Urutkan berdasarkan nomor urut (jika ada)
            ->orderBy('created_at', 'DESC')   // Lalu yang terbaru
            ->findAll();

        if (empty($data)) {
            return $this->respond([
                'status'  => true, // Tetap true tapi data kosong (best practice list)
                'message' => 'Data program belum ada.',
                'data'    => []
            ]);
        }

        return $this->respond([
            'status'  => true,
            'message' => 'Data program berhasil diambil.',
            'count'   => count($data),
            'data'    => $data
        ]);
    }

    /**
     * Tampilkan Detail Program
     * Method: GET /api/program/{slug}
     */
    public function show($slug = null)
    {
        if (empty($slug)) {
            return $this->failNotFound('Slug/ID program tidak boleh kosong.');
        }

        // 1. Cari berdasarkan SLUG dan Status Aktif
        $data = $this->model
            ->where('slug', $slug)
            ->where('is_active', 1)
            ->first();

        // 2. Fallback: Cari berdasarkan ID (jika parameter angka & belum ketemu)
        if (!$data && is_numeric($slug)) {
            $data = $this->model
                ->where('id_program', $slug) // Pastikan Primary Key sesuai DB (id_program/id)
                ->where('is_active', 1)
                ->first();
        }

        // 3. Jika tidak ditemukan
        if (!$data) {
            return $this->failNotFound('Program tidak ditemukan.');
        }

        // 4. Return Data
        // Path file_lampiran dikirim mentah (misal: "uploads/program/file.pdf")
        // Biarkan Frontend menambahkan Base URL-nya sendiri.
        return $this->respond([
            'status'  => true,
            'message' => 'Detail program berhasil diambil.',
            'data'    => $data
        ]);
    }
}