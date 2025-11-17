<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\DokumentModel;

class ApiDokumentController extends ResourceController
{
    protected $modelName = DokumentModel::class;
    protected $format = 'json';
public function index()
{
    $dokument = $this->model
        ->orderBy('created_at', 'DESC')   // urutkan dari terbaru
        ->findAll();

    return $this->respond([
        'status'  => true,
        'message' => 'Daftar dokumen berhasil diambil.',
        'data'    => $dokument
    ]);
}

    public function show($id = null)
    {
        $data = $this->model->find($id);

        if (!$data) {
            return $this->failNotFound('Dokumen tidak ditemukan.');
        }

        return $this->respond([
            'status'  => true,
            'message' => 'Detail dokumen berhasil diambil.',
            'data'    => $data
        ]);
    }



    
}
