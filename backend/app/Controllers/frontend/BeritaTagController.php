<?php

namespace App\Controllers\frontend;

use App\Controllers\BaseController;
use App\Models\BeritaTagModel;
use App\Models\AccessRightsModel; // 1. Tambahkan model hak akses

class BeritaTagController extends BaseController
{
    protected $beritaTagModel;
    protected $accessRightsModel; // 2. Tambahkan properti model hak akses
    protected $module = 'berita_tag'; // 3. Tentukan nama modul ini

    public function __construct()
    {
        $this->beritaTagModel = new BeritaTagModel();
        $this->accessRightsModel = new AccessRightsModel(); // 4. Inisialisasi model hak akses
    }

    // ========================
    // TAMPILKAN SEMUA TAG
    // ========================
    public function index()
    {
        $role = session()->get('role');
        $access = $this->getAccess($role);

        if (!$access) {
            return view('pages/berita_tag/index', [
                'title' => 'Tag Berita',
                'tags' => [],
                'error' => '⚠ Kamu tidak memiliki hak akses ke modul ini.'
            ]);
        }

        if (!$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat Tag Berita.');
        }

        $data = [
            'title' => 'Manajemen Tag Berita',
            'tags' => $this->beritaTagModel->findAll(),
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ];

        return view('pages/berita_tag/index', $data);
    }


    // ========================
    // FORM TAMBAH TAG
    // ========================
    public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/berita_tag')->with('error', 'Kamu tidak punya izin menambah Tag Berita.');
        }

        $data = [
            'title' => 'Tambah Tag Berita'
        ];
        return view('pages/berita_tag/create', $data);
    }

    // ========================
    // SIMPAN TAG BARU
    // ========================
    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/berita_tag')->with('error', 'Kamu tidak punya izin menambah Tag Berita.');
        }

        $data = [
            'nama_tag' => $this->request->getPost('name'),
            'slug' => url_title($this->request->getPost('name'), '-', true),
            'created_at' => date('Y-m-d H:i:s'),
            'created_by_id' => session()->get('user_id'), // Sesuaikan 'user_id' jika key session Anda berbeda
            'created_by_name' => session()->get('username'), // Sesuaikan 'username' jika key session Anda berbeda
            'is_delete' => '0',
        ];

        if (!$this->beritaTagModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->beritaTagModel->errors());
        }

        return redirect()->to('/berita_tag')->with('success', 'Tag berhasil ditambahkan.');
    }

    // ========================
    // FORM EDIT TAG
    // ========================
    public function edit($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/berita_tag')->with('error', 'Kamu tidak punya izin mengedit Tag Berita.');
        }

        $tag = $this->beritaTagModel->find($id);
        if (!$tag) {
            return redirect()->to('/berita_tag')->with('error', 'Tag tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Tag Berita',
            'tag' => $tag,
            'can_update' => $access['can_update'],
        ];

        return view('pages/berita_tag/edit', $data);
    }

    // ========================
    // UPDATE TAG
    // ========================
    public function update($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/berita_tag')->with('error', 'Kamu tidak punya izin mengubah Tag Berita.');
        }

        $tag = $this->beritaTagModel->find($id);
        if (!$tag) {
            return redirect()->to('/berita_tag')->with('error', 'Tag tidak ditemukan.');
        }

        $data = [
            'nama_tag' => $this->request->getPost('name'),
            'slug' => url_title($this->request->getPost('name'), '-', true),
            // 'updated_at' bisa ditambahkan jika model tidak 'useTimestamps'
        ];

        if (!$this->beritaTagModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->beritaTagModel->errors());
        }

        return redirect()->to('/berita_tag')->with('success', 'Tag berhasil diupdate.');
    }

    
    public function delete($id = null)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) {
            return redirect()->to('/berita_tag')->with('error', 'Kamu tidak punya izin menghapus tag$tag.');
        }

        $tag = $this->beritaTagModel->find($id);

        // =======================================================================
        // PERBAIKAN: Tambahkan FCPATH. Path 'uploads/pages/tag$tag/...' saja tidak akan
        // ditemukan. Harus FCPATH . 'uploads/pages/tag$tag/'


        if ($this->beritaTagModel->delete($id)) {
            return redirect()->to('/berita_tag')->with('success', 'tag berhasil dihapus.');
        } else {
            return redirect()->to('/berita_tag')->with('error', 'Gagal menghapus tag.');
        }

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