<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\frontend\ProfilTentangModel;

class ApiProfilTentangController extends ResourceController
{
    protected $modelName = ProfilTentangModel::class;
    protected $format    = 'json';

    /**
     * Index: Ambil semua data profil yang aktif
     */
    public function index()
    {
        // Mengambil semua data yang aktif
        $data = $this->model
            ->where('is_active', 1)
            ->orderBy('section', 'ASC') // Urutkan berdasarkan section agar rapi
            ->orderBy('sorting', 'ASC')
            ->findAll();

        if ($data) {
            return $this->respond([
                'status'  => 200,
                'message' => 'Data profil berhasil diambil.',
                'count'   => count($data),
                'data'    => $data
            ], 200);
        } else {
            return $this->respond([
                'status'  => 404,
                'message' => 'Data profil kosong.',
                'data'    => []
            ], 404);
        }
    }

    /**
     * Show: Detail per ID
     */
    public function show($id = null)
    {
        $data = $this->model->find($id);

        if ($data) {
            return $this->respond([
                'status'  => 200,
                'message' => 'Detail profil berhasil diambil.',
                'data'    => $data
            ], 200);
        } else {
            return $this->failNotFound('Data profil dengan ID ' . $id . ' tidak ditemukan.');
        }
    }
    
    /**
     * Helper khusus: Get By Section
     * Route manual: $routes->get('api/profil_tentang/section/(:segment)', 'Api\ApiProfilTentangController::getBySection/$1');
     */
    public function getBySection($sectionName = null)
    {
        if (!$sectionName) {
            return $this->failNotFound('Nama section kosong.');
        }

        $data = $this->model
            ->where('section', $sectionName)
            ->where('is_active', 1)
            ->orderBy('sorting', 'ASC')
            ->findAll();

        if ($data) {
            return $this->respond([
                'status'  => 200,
                'message' => 'Data section ' . $sectionName . ' berhasil diambil.',
                'data'    => $data
            ], 200);
        } else {
            return $this->respond([
                'status'  => 404,
                'message' => 'Data section ' . $sectionName . ' tidak ditemukan.',
                'data'    => []
            ], 404);
        }
    }
}