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
     * Bisa difilter by section: /api/profil_tentang?section=visi_misi
     */
    public function index()
    {
        try {
            
            $builder = $this->model->where('is_active', 1);

            if (!empty($section)) {
                $builder->where('section', $section);
            }

            $data = $builder
                ->orderBy('sorting', 'ASC')
                ->orderBy('id_tentang', 'ASC')
                ->findAll();

            if (empty($data)) {
                return $this->respond([
                    'status'  => true,
                    'message' => 'Data profil kosong.',
                    'data'    => []
                ]);
            }

            // Path gambar dikirim raw (tanpa base_url) sesuai standar project ini
            
            return $this->respond([
                'status'  => true,
                'message' => 'Data profil berhasil diambil.',
                'count'   => count($data),
                'data'    => $data
            ]);

        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    /**
     * Show: Detail per ID
     */
    public function show($id = null)
    {
        try {
            if (!$id) return $this->failNotFound('ID tidak boleh kosong.');

            $data = $this->model->find($id);

            if (!$data) return $this->failNotFound('Data tidak ditemukan.');

            return $this->respond([
                'status'  => true,
                'message' => 'Detail profil berhasil diambil.',
                'data'    => $data
            ]);

        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }
    
    /**
     * Helper khusus: Get By Section
     * Route manual: $routes->get('api/profil_tentang/section/(:segment)', 'Api\ApiProfilTentangController::getBySection/$1');
     */
    public function getBySection($sectionName = null)
    {
        try {
            if (!$sectionName) return $this->failNotFound('Nama section kosong.');

            $data = $this->model
                ->where('section', $sectionName)
                ->where('is_active', 1)
                ->orderBy('sorting', 'ASC')
                ->findAll();

            if (empty($data)) return $this->respond(['status' => true, 'data' => []]);

            return $this->respond([
                'status' => true,
                'data'   => $data
            ]);
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }
}