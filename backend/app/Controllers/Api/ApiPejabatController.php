<?php

namespace App\Controllers\Api;

use App\Models\frontend\PejabatModel;
use CodeIgniter\RESTful\ResourceController;

class ApiPejabatController extends ResourceController
{
    protected $modelName = PejabatModel::class;
    protected $format    = 'json';

    public function index()
    {


        // 2. Mulai Query Builder
        // Kita gunakan logika where is_active = 1 agar yang non-aktif tidak muncul di public API
        $builder = $this->model->where('is_active', 1);



        // 4. Sorting (Penting untuk susunan pejabat)
        // Prioritaskan kolom 'urutan', lalu 'id' atau 'created_at'
        $data = $builder->orderBy('urutan', 'ASC')
                        ->orderBy('id_pejabat', 'DESC')
                        ->findAll();

        // 5. Transformasi Data (Menambahkan Full URL Foto)
        // Kita loop data untuk memodifikasi path foto
        $data = array_map(function($item) {
            // Cek apakah ada foto dan file fisiknya ada (optional check file_exists)
            if (!empty($item['foto'])) {
                $item['foto_url'] = base_url('uploads/pejabat/' . $item['foto']);
            } else {
                // Berikan default image jika null (opsional)
                $item['foto_url'] = base_url('uploads/default_profile.png'); 
            }
            return $item;
        }, $data);

        return $this->respond([
            'status'  => true,
            'message' => 'Daftar pejabat berhasil diambil.',
            'count'   => count($data), // Berguna untuk klien tahu jumlah data
            'data'    => $data
        ]);
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);

        if (!$data) {
            return $this->failNotFound('Pejabat tidak ditemukan.');
        }

        // Cek status aktif (Opsional: jika ingin membatasi akses detail user non-aktif)
        /* if ($data['is_active'] == 0) {
            return $this->failNotFound('Pejabat ini sedang tidak aktif.');
        }
        */

        // Tambahkan Full URL Foto
        if (!empty($data['foto'])) {
            $data['foto_url'] = base_url('uploads/pejabat/' . $data['foto']);
        } else {
            $data['foto_url'] = base_url('uploads/default_profile.png');
        }

        return $this->respond([
            'status'  => true,
            'message' => 'Detail Pejabat berhasil diambil.',
            'data'    => $data
        ]);
    }
}