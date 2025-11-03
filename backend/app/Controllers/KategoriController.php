<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KategoriModel;
use App\Models\AccessRightsModel;

class KategoriController extends BaseController
{
    protected $kategoriModel;
    protected $accessRightsModel;
    protected $module = 'berita_kategori';

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
        $this->accessRightsModel = new AccessRightsModel();
    }

    // ========================================================
    // Tampilkan semua kategori
    // ========================================================
    public function index()
    {
        $access = $this->getAccess(session()->get('role'));

        if (!$access) {
            return view('pages/kategori/index', [
                'title' => 'Kategori',
                'kategori' => [],
                'error' => '⚠ Kamu tidak memiliki hak akses ke modul ini.'
            ]);
        }

        if (!$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat kategori.');
        }

        $data = [
            'title' => 'Manajemen Kategori',
            'kategori' => $this->kategoriModel->where('trash', '0')->findAll(),
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ];

        return view('pages/kategori/index', $data);
    }

    // ========================================================
    // Tampilkan sampah
    // ========================================================
    public function trash()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat sampah kategori.');
        }

        $data = [
            'title' => 'Sampah Kategori',
            'kategori' => $this->kategoriModel->where('trash', '1')->findAll(),
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ];

        return view('pages/kategori/trash', $data);
    }

    // ========================================================
    // Form tambah kategori
    // ========================================================
public function new()
{
    $access = $this->getAccess(session()->get('role'));
    if (!$access || !$access['can_create']) {
        return redirect()->to('/kategori')->with('error', 'Kamu tidak punya izin menambah kategori.');
    }

    $data = [
        'title' => 'Tambah Kategori',
        'kategori' => $this->kategoriModel->where('trash', '0')->findAll() // untuk parent category
    ];

    return view('pages/kategori/create', $data);
}

    // ========================================================
    // Simpan kategori baru
    // ========================================================
    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/kategori')->with('error', 'Kamu tidak punya izin menambah kategori.');
        }

        $data = [
            'id_parent'   => $this->request->getPost('id_parent'),
            'hash'        => md5(uniqid()),
            'kategori'    => $this->request->getPost('kategori'),
            'slug'        => url_title($this->request->getPost('kategori'), '-', true),
            'keterangan'  => $this->request->getPost('keterangan'),
            'status'      => $this->request->getPost('status') ?? 'active',
            'is_show_nav' => $this->request->getPost('is_show_nav') ?? '0',
            'sorting_nav' => $this->request->getPost('sorting_nav'),
        ];

        if (!$this->kategoriModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->kategoriModel->errors());
        }

        return redirect()->to('/kategori')->with('success', 'Kategori berhasil ditambahkan.');
    }

    // ========================================================
    // Tampilkan detail kategori
    // ========================================================
    public function show($id = null)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_read']) {
            return redirect()->to('/kategori')->with('error', 'Kamu tidak punya izin melihat kategori.');
        }

        $kategori = $this->kategoriModel->find($id);
        if (!$kategori) {
            return redirect()->to('/kategori')->with('error', 'Kategori tidak ditemukan.');
        }

        return view('pages/kategori/show', [
            'title' => 'Detail Kategori',
            'kategori' => $kategori,
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ]);
    }

    // ========================================================
    // Form edit kategori
    // ========================================================
    public function edit($id = null)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/kategori')->with('error', 'Kamu tidak punya izin mengedit kategori.');
        }

        $kategori = $this->kategoriModel->find($id);
        if (!$kategori || $kategori['trash'] == '1') {
            return redirect()->to('/kategori')->with('error', 'Kategori tidak ditemukan.');
        }

        return view('pages/kategori/edit', [
            'title' => 'Edit Kategori',
            'kategori' => $kategori,
            'can_update' => $access['can_update'],
        ]);
    }

    // ========================================================
    // Update kategori
    // ========================================================
public function update($id = null)
{
    $kategori = $this->kategoriModel->find($id);
    if (!$kategori) {
        return redirect()->to('/kategori')->with('error', 'Kategori tidak ditemukan.');
    }

    $kategoriBaru = $this->request->getPost('kategori');
    $slugBaru = url_title($kategoriBaru, '-', true);

    $data = [
        'id_parent'   => $this->request->getPost('id_parent'),
        'kategori'    => $kategoriBaru,
        'slug'        => $slugBaru,
        'keterangan'  => $this->request->getPost('keterangan'),
        'status'      => $this->request->getPost('status') ?? 'active',
        'is_show_nav' => $this->request->getPost('is_show_nav') ?? '0',
        'sorting_nav' => $this->request->getPost('sorting_nav'),
    ];

    // ❌ Nonaktifkan validasi model untuk update
    $this->kategoriModel->skipValidation(true)->update($id, $data);

    return redirect()->to('/kategori')->with('success', 'Kategori berhasil diperbarui.');
}


    // ========================================================
    // Soft delete → ubah trash jadi '1'
    // ========================================================
    public function delete($id = null)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) {
            return redirect()->to('/kategori')->with('error', 'Kamu tidak punya izin menghapus kategori.');
        }

        $kategori = $this->kategoriModel->find($id);
        if (!$kategori) {
            return redirect()->to('/kategori')->with('error', 'Kategori tidak ditemukan.');
        }

        $this->kategoriModel->update($id, ['trash' => '1']);
        return redirect()->to('/kategori')->with('success', 'Kategori dipindahkan ke sampah.');
    }

    // ========================================================
    // Restore kategori dari trash
    // ========================================================
    public function restore($id = null)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/kategori/trash')->with('error', 'Kamu tidak punya izin memulihkan kategori.');
        }

        $kategori = $this->kategoriModel->find($id);
        if (!$kategori) {
            return redirect()->to('/kategori/trash')->with('error', 'Kategori tidak ditemukan.');
        }

        $this->kategoriModel->update($id, ['trash' => '0']);
        return redirect()->to('/kategori/trash')->with('success', 'Kategori berhasil dipulihkan.');
    }

    // ========================================================
    // Hapus permanen
    // ========================================================
    public function destroyPermanent($id = null)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) {
            return redirect()->to('/kategori/trash')->with('error', 'Kamu tidak punya izin menghapus kategori permanen.');
        }

        $kategori = $this->kategoriModel->find($id);
        if (!$kategori) {
            return redirect()->to('/kategori/trash')->with('error', 'Kategori tidak ditemukan.');
        }

        $this->kategoriModel->delete($id, true); // force delete
        return redirect()->to('/kategori/trash')->with('success', 'Kategori dihapus permanen.');
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
