<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\BannerModel;

use CodeIgniter\RESTful\ResourceController;

class ApiBannerController extends ResourceController
{
    protected $modelName = BannerModel::class;
    protected $format = 'json';

    public function index()
    {
        $banners = $this->model
        ->where('status', 'active')
        ->orderBy('sorting', 'ASC')
        ->findAll();
        return $this->respond([
            'status'  => true,
            'message' => 'Daftar banner berhasil diambil.',
            'data'    => $banners
        ]);
    }

    public function show($id = null)
    {
        $banner = $this->model->find($id);
        if (!$banner) {
            return $this->failNotFound('Banner tidak ditemukan.');
        }
        return $this->respond([
            'status'  => true,
            'message' => 'Detail banner berhasil diambil.',
            'data'    => $banner
        ]);
    }
}
