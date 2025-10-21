<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BeritaModel;

class BeritaController extends BaseController
{
    protected $beritaModel;

    public function __construct()
    {
        $this->beritaModel = new BeritaModel();
    }

    // ==========================
    // 1️⃣ Tampilkan Semua Berita
    // ==========================
    public function index()
    {
        $data['berita'] = $this->beritaModel->findAll();
        return view('pages/berita/index', $data);
    }

    // ==========================
    // 2️⃣ Form Tambah Berita
    // ==========================
    public function create()
    {
        return view('pages/berita/create');
    }

    // ==========================
    // 3️⃣ Simpan Berita Baru
    // ==========================
    public function store()
    {
        $data = [
            'id_tema'           => $this->request->getPost('id_tema'),
            'judul'             => $this->request->getPost('judul'),
            'isi_berita'        => $this->request->getPost('isi_berita'),
            'id_kategori'       => $this->request->getPost('id_kategori'),
            'id_user'           => $this->request->getPost('id_user'),
            'tanggal_publikasi' => $this->request->getPost('tanggal_publikasi'),
            'status'            => $this->request->getPost('status'),
            'jumlah_pembaca'    => $this->request->getPost('jumlah_pembaca') ?? 0,
            'berita_sisipan'    => $this->request->getPost('berita_sisipan'),
            'written_by'        => $this->request->getPost('written_by'),
            'sumber'            => $this->request->getPost('sumber'),
            'id_tag'            => $this->request->getPost('id_tag'),
            'featured_image'    => $this->request->getPost('featured_image'),
            'galeri_foto'       => $this->request->getPost('galeri_foto'),
        ];

        if (!$this->beritaModel->insert($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->beritaModel->errors());
        }

        return redirect()->to('/berita')->with('success', 'Berita berhasil ditambahkan.');
    }

    // ==========================
    // 4️⃣ Form Edit Berita
    // ==========================
    public function edit($id)
    {
        $data['berita'] = $this->beritaModel->find($id);

        if (!$data['berita']) {
            return redirect()->to('/berita')->with('error', 'Data berita tidak ditemukan.');
        }

        return view('pages/berita/edit', $data);
    }

    // ==========================
    // 5️⃣ Update Data Berita
    // ==========================
    public function update($id)
    {
        $data = [
            'id_tema'           => $this->request->getPost('id_tema'),
            'judul'             => $this->request->getPost('judul'),
            'isi_berita'        => $this->request->getPost('isi_berita'),
            'id_kategori'       => $this->request->getPost('id_kategori'),
            'id_user'           => $this->request->getPost('id_user'),
            'tanggal_publikasi' => $this->request->getPost('tanggal_publikasi'),
            'status'            => $this->request->getPost('status'),
            'jumlah_pembaca'    => $this->request->getPost('jumlah_pembaca'),
            'berita_sisipan'    => $this->request->getPost('berita_sisipan'),
            'written_by'        => $this->request->getPost('written_by'),
            'sumber'            => $this->request->getPost('sumber'),
            'id_tag'            => $this->request->getPost('id_tag'),
            'featured_image'    => $this->request->getPost('featured_image'),
            'galeri_foto'       => $this->request->getPost('galeri_foto'),
        ];

        if (!$this->beritaModel->update($id, $data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->beritaModel->errors());
        }

        return redirect()->to('/berita')->with('success', 'Berita berhasil diperbarui.');
    }

    // ==========================
    // 6️⃣ Hapus Data Berita
    // ==========================
    public function delete($id)
    {
        if (!$this->beritaModel->find($id)) {
            return redirect()->to('/berita')->with('error', 'Data berita tidak ditemukan.');
        }

        $this->beritaModel->delete($id);
        return redirect()->to('/berita')->with('success', 'Berita berhasil dihapus.');
    }

    public function show($id)
{
    // Cari berita berdasarkan ID
    $berita = $this->beritaModel->find($id);

    if (!$berita) {
        return redirect()->to('/berita')->with('error', 'Data berita tidak ditemukan.');
    }

    // Tambahkan jumlah pembaca tanpa perlu login
    $this->beritaModel->update($id, [
        'jumlah_pembaca' => ($berita['jumlah_pembaca'] ?? 0) + 1
    ]);

    // Ambil ulang berita setelah update (biar jumlah terbaru tampil)
    $data['berita'] = $this->beritaModel->find($id);

    // Tampilkan halaman detail berita
    return view('pages/berita/show', $data);
}


}
