<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\AgendaModel;

class ApiAgendaController extends ResourceController
{
    protected $modelName = AgendaModel::class;
    protected $format = 'json';

    // ================================
    // TAMPILKAN SEMUA AGENDA (API)
    // ================================
public function index()
{
    $agendas = $this->model
        ->where('status', '1')
        ->orderBy('start_date', 'DESC')
        ->findAll();

    return $this->respond([
        'status'  => true,
        'message' => 'Daftar agenda aktif berhasil diambil.',
        'data'    => $agendas
    ]);
}


    // ================================
    // TAMPILKAN 1 AGENDA BERDASARKAN ID
    // ================================
    public function show($id = null)
    {
        $agenda = $this->model->find($id);

        if (!$agenda) {
            return $this->failNotFound('Agenda tidak ditemukan.');
        }

        return $this->respond([
            'status'  => true,
            'message' => 'Detail agenda berhasil diambil.',
            'data'    => $agenda
        ]);
    }
}
