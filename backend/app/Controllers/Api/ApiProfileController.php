<?php

namespace App\Controllers\Api;

use App\Models\frontend\ProfileModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait; // 1. Tambahkan Trait ini untuk fitur API

class ApiProfileController extends BaseController
{
    use ResponseTrait; // 2. Gunakan Trait

    protected $modelName = ProfileModel::class;
    protected $format    = 'json';
    protected $profileModel;

    public function __construct()
    {
        // Inisialisasi Model
        $this->profileModel = new ProfileModel();
    }

    /**
     * Menampilkan semua list profile
     * Method: GET
     * URL: /api/profile
     */
    public function index()
    {
        // Ambil data, urutkan sesuai controller frontend (created_at DESC)
        // Opsional: Anda bisa menambahkan .where('is_active', 1) jika API hanya boleh melihat yang aktif
        $data = $this->profileModel
        ->where('is_active', 1)
        ->orderBy('created_at', 'DESC')->findAll();

        if (empty($data)) {
            return $this->respond([
                'status' => 404,
                'error'  => true,
                'message' => 'Data tidak ditemukan',
                'data'   => []
            ], 404);
        }

        // Modifikasi data untuk menyertakan Full URL Gambar (Penting untuk API)
        $data = array_map(function($item) {
            if (!empty($item['image'])) {
                $item['image_url'] = base_url('uploads/menu_profile/' . $item['image']);
            } else {
                $item['image_url'] = null;
            }
            return $item;
        }, $data);

        return $this->respond([
            'status' => 200,
            'error'  => false,
            'message' => 'Berhasil mengambil data profile',
            'data'   => $data
        ], 200);
    }

    /**
     * Menampilkan detail satu profile berdasarkan ID
     * Method: GET
     * URL: /api/profile/{id}
     */
    public function show($id = null)
    {
        $data = $this->profileModel->find($id);

        if (!$data) {
            return $this->failNotFound('Data profile dengan ID ' . $id . ' tidak ditemukan.');
        }

        // Tambahkan URL gambar lengkap
        if (!empty($data['image'])) {
            $data['image_url'] = base_url('uploads/menu_profile/' . $data['image']);
        } else {
            $data['image_url'] = null;
        }

        return $this->respond([
            'status' => 200,
            'error'  => false,
            'data'   => $data
        ], 200);
    }
}