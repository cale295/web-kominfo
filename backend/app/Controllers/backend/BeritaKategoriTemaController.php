<?php

namespace App\Controllers\backend;

use App\Models\BeritaKategoriModel;
use CodeIgniter\Controller;

class BeritaKategoriTemaController extends Controller
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new BeritaKategoriModel();
    }

    // ---------------------------
    // 1. Tampilkan semua data
    // ---------------------------
    public function index()
    {
        $data['kategori'] = $this->kategoriModel->findAll();
        $data['mode'] = 'index';
        return view('kategori', $data);
    }

    // ---------------------------
    // 2. Tampilkan form tambah
    // ---------------------------
    public function create()
    {
        $data['mode'] = 'create';
        return view('kategori', $data);
    }

    // ---------------------------
    // 3. Simpan data baru
    // ---------------------------
    public function store()
    {
        $data = $this->request->getPost();

        if ($this->kategoriModel->insert($data)) {
            return redirect()->to('/beritakategori')->with('success', 'Data berhasil ditambahkan.');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan data.');
        }
    }

    // ---------------------------
    // 4. Form edit
    // ---------------------------
    public function edit($id)
    {
        $data['kategori'] = $this->kategoriModel->find($id);
        $data['mode'] = 'edit';
        return view('kategori', $data);
    }

    // ---------------------------
    // 5. Update data
    // ---------------------------
    public function update($id)
    {
        $data = $this->request->getPost();
        $this->kategoriModel->update($id, $data);
        return redirect()->to('/beritakategori')->with('success', 'Data berhasil diperbarui.');
    }

    // ---------------------------
    // 6. Hapus data
    // ---------------------------
    public function delete($id)
    {
        $this->kategoriModel->delete($id);
        return redirect()->to('/beritakategori')->with('success', 'Data berhasil dihapus.');
    }
}
