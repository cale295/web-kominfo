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
        ->where('is_active', '1')
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
public function show($slug = null)
    {
        if (empty($slug)) {
            return $this->failNotFound('Slug tidak boleh kosong.');
        }

        // 1. CARI BERDASARKAN SLUG (Utama)
        // Pastikan tabel database punya kolom 'slug'
        $data = $this->profileModel->where('slug', $slug)->first();

        // 2. FALLBACK: Cari berdasarkan ID (jika slug tidak ketemu & parameter berupa angka)
        if (!$data && is_numeric($slug)) {
            $data = $this->profileModel->where('id', $slug)->first(); 
            // Sesuaikan 'id' dengan nama primary key di tabelmu (misal: id_profile)
        }

        if (!$data) {
            return $this->failNotFound('Data profile tidak ditemukan.');
        }

        // HAPUS base_url()
        if (!empty($data['image'])) {
            $data['image_url'] = 'uploads/menu_profile/' . $data['image'];
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