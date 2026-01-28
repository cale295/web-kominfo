<?php

namespace App\Controllers\frontend;

use App\Controllers\BaseController;use App\Models\TemaKategoriModel;
use App\Models\AccessRightsModel; // 1. Tambahkan model hak akses

class TemaKategoriController extends BaseController
{
    protected $temaModel;
    protected $accessRightsModel; // 2. Tambahkan properti model hak akses
    protected $module = 'berita_tema'; // 3. Tentukan nama modul ini

    public function __construct()
    {
        $this->temaModel = new TemaKategoriModel();
        $this->accessRightsModel = new AccessRightsModel(); // 4. Inisialisasi model hak akses
    }

    // Menampilkan semua data
    public function index()
    {
        $role = session()->get('role');
        $access = $this->getAccess($role);

        // Handle jika tidak ada definisi akses sama sekali
        if (!$access) {
            return view('pages/kategori_tema/index', [
                'title' => 'Kategori Tema',
                'temas' => [],
                'error' => '⚠ Kamu tidak memiliki hak akses ke modul ini.'
            ]);
        }

        // Handle jika tidak punya akses 'read'
        if (!$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat Kategori Tema.');
        }

        $data = [
            'title' => 'Manajemen Kategori Tema',
            'temas' => $this->temaModel->findAll(),
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ];

        return view('pages/kategori_tema/index', $data);
    }

    // Menampilkan form tambah
    public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/tema')->with('error', 'Kamu tidak punya izin menambah Kategori Tema.');
        }

        $data = [
            'title' => 'Tambah Kategori Tema'
        ];
        return view('pages/kategori_tema/create', $data);
    }

    // Simpan data baru
    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/tema')->with('error', 'Kamu tidak punya izin menambah Kategori Tema.');
        }

        $data = [
            'nama_tema' => $this->request->getPost('nama_tema')
        ];

        if (!$this->temaModel->insert($data)) {
            // Asumsi model TemaKategoriModel memiliki rules validasi
            return redirect()->back()->withInput()->with('errors', $this->temaModel->errors());
        }

        return redirect()->to('/tema')->with('success', 'Kategori Tema berhasil ditambahkan.');
    }

    // Hapus method store() karena duplikat dengan create()
    // public function store() { ... }

    // Menampilkan satu data
    public function show($id = null)
    {
        $access = $this->getAccess(session()->get('role'));

        if (!$access || !$access['can_read']) {
            return redirect()->to('/tema')->with('error', 'Kamu tidak punya izin melihat Kategori Tema.');
        }

        $tema = $this->temaModel->find($id);
        if (!$tema) {
            return redirect()->to('/tema')->with('error', 'Kategori Tema tidak ditemukan.');
        }

        $data = [
            'title' => 'Detail Kategori Tema',
            'tema'  => $tema,
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ];

        return view('pages/kategori_tema/show', $data);
    }

    // Menampilkan form edit
    public function edit($id = null)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/tema')->with('error', 'Kamu tidak punya izin mengedit Kategori Tema.');
        }

        $tema = $this->temaModel->find($id);
        if (!$tema) {
            return redirect()->to('/tema')->with('error', 'Kategori Tema tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Kategori Tema',
            'tema'  => $tema,
            'can_update' => $access['can_update'],
        ];

        return view('pages/kategori_tema/edit', $data);
    }

    // Update data
    public function update($id = null)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/tema')->with('error', 'Kamu tidak punya izin mengubah Kategori Tema.');
        }

        $tema = $this->temaModel->find($id);
        if (!$tema) {
            return redirect()->to('/tema')->with('error', 'Kategori Tema tidak ditemukan.');
        }

        $data = [
            'nama_tema' => $this->request->getPost('nama_tema')
        ];

        if (!$this->temaModel->update($id, $data)) {
            // Asumsi model TemaKategoriModel memiliki rules validasi
            return redirect()->back()->withInput()->with('errors', $this->temaModel->errors());
        }

        return redirect()->to('/tema')->with('success', 'Kategori Tema berhasil diperbarui.');
    }

    // Hapus data
    public function delete($id = null)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) {
            return redirect()->to('/tema')->with('error', 'Kamu tidak punya izin menghapus Kategori Tema.');
        }

        $tema = $this->temaModel->find($id);
        if (!$tema) {
            return redirect()->to('/tema')->with('error', 'Kategori Tema tidak ditemukan.');
        }

        $this->temaModel->delete($id);
        return redirect()->to('/tema')->with('success', 'Kategori Tema berhasil dihapus.');
    }

    // ========================================================
    // Fungsi bantu untuk ambil akses role
    // ========================================================
    private function getAccess($role)
    {
        $access = $this->accessRightsModel
            ->where('role', $role)
            ->where('module_name', $this->module)
            ->first();

        if (!$access) return false;

        return [
            'can_create' => (bool) $access['can_create'],
            'can_read'   => (bool) $access['can_read'],
            'can_update' => (bool) $access['can_update'],
            'can_delete' => (bool) $access['can_delete'],
        ];
    }
}   