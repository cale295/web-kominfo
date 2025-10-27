<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TemaKategoriModel;

class TemaKategoriController extends BaseController
{
    protected $temaModel;

    public function __construct()
    {
        $this->temaModel = new TemaKategoriModel();
    }

    // Menampilkan semua data
    public function index()
    {
        $data['temas'] = $this->temaModel->findAll();
        return view('pages/kategori_tema/index', $data);
    }

    // Menampilkan form tambah (method wajib untuk resource)
    public function new()
    {
        return view('pages/kategori_tema/create');
    }

    // Simpan data baru
    public function create()
    {
        $this->temaModel->insert([
            'nama_tema' => $this->request->getPost('nama_tema')
        ]);
        return redirect()->to('/tema');
    }

    public function store()
    {
        $this->temaModel->insert([
            'nama_tema' => $this->request->getPost('nama_tema')
        ]);
        return redirect()->to('/tema');
    }

    // Menampilkan satu data
    public function show($id = null)
    {
        $data['tema'] = $this->temaModel->find($id);
        return view('pages/kategori_tema/show', $data);
    }

    // Menampilkan form edit
    public function edit($id = null)
    {
        $data['tema'] = $this->temaModel->find($id);
        return view('pages/kategori_tema/edit', $data);
    }

    // Update data
    public function update($id = null)
    {
        $this->temaModel->update($id, [
            'nama_tema' => $this->request->getPost('nama_tema')
        ]);
        return redirect()->to('/tema');
    }

    // Hapus data
    public function delete($id = null)
    {
        $this->temaModel->delete($id);
        return redirect()->to('/tema');
    }
}
