<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BannerModel;
use App\Models\AccessRightsModel; // 1. Tambahkan model hak akses

class BannerController extends BaseController
{
    protected $bannerModel;
    protected $accessRightsModel; // 2. Tambahkan properti model hak akses
    protected $module = 'banner'; // 3. Tentukan nama modul ini

    public function __construct()
    {
        $this->bannerModel = new BannerModel();
        $this->accessRightsModel = new AccessRightsModel(); // 4. Inisialisasi model hak akses
    }

    // TAMPILKAN SEMUA BANNER AKTIF
    public function index()
    {
        $role = session()->get('role');
        $access = $this->getAccess($role);

        if (!$access) {
            return view('pages/banner/index', [
                'title' => 'Manajemen Banner',
                'banners' => [],
                'error' => '⚠ Kamu tidak memiliki hak akses ke modul ini.'
            ]);
        }

        if (!$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat banner.');
        }

        $data = [
            'title' => 'Manajemen Banner',
            'banners' => $this->bannerModel->getAllActive(),
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ];

        return view('pages/banner/index', $data);
    }

    // TAMPILKAN SAMPAH
    public function trash()
    {
        $role = session()->get('role');
        $access = $this->getAccess($role);

        // Memerlukan hak 'read' untuk melihat sampah
        if (!$access || !$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat sampah banner.');
        }

        $data = [
            'title' => 'Sampah Banner',
            'banners' => $this->bannerModel->getAllDeleted(),
            'can_update' => $access['can_update'], // Untuk tombol restore
            'can_delete' => $access['can_delete'], // Untuk tombol hapus permanen
        ];

        return view('pages/banner/trash', $data);
    }

    // TAMBAH
    public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/banner')->with('error', 'Kamu tidak punya izin menambah banner.');
        }

        $data = [
            'title' => 'Tambah Banner'
        ];
        return view('pages/banner/create', $data);
    }

    // SIMPAN DATA
    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/banner')->with('error', 'Kamu tidak punya izin menambah banner.');
        }

        $gambar = $this->request->getFile('image');
        $namaFile = null;

        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $namaFile = $gambar->getRandomName();
            $gambar->move('uploads/banner', $namaFile);
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'status' => $this->request->getPost('status') ?? '0',
            'image' => $namaFile,
            'media_type' => $this->request->getPost('media_type'),
            'url' => $this->request->getPost('url'),
            'url_yt' => $this->request->getPost('url_yt'),
            'sorting' => $this->request->getPost('sorting'),
            'keterangan' => $this->request->getPost('keterangan'),
            'category_banner' => $this->request->getPost('category_banner'),
            'is_delete' => '0',
            'created_at' => date('Y-m-d H:i:s'),
            'created_by_id' => session()->get('id_user') ?? null,
            'created_by_name' => session()->get('username') ?? 'Guest',
        ];

        if (!$this->bannerModel->insert($data)) {
            // Asumsi model BannerModel memiliki rules validasi
            return redirect()->back()->withInput()->with('errors', $this->bannerModel->errors());
        }

        return redirect()->to('/banner')->with('success', 'Banner berhasil ditambahkan.');
    }

    // EDIT
    public function edit($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/banner')->with('error', 'Kamu tidak punya izin mengedit banner.');
        }

        $banner = $this->bannerModel->find($id);
        if (!$banner || $banner['is_delete'] == '1') {
            return redirect()->to('/banner')->with('error', 'Banner tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Banner',
            'banner' => $banner,
            'can_update' => $access['can_update'],
        ];

        return view('pages/banner/edit', $data);
    }

    // UPDATE
    public function update($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/banner')->with('error', 'Kamu tidak punya izin mengubah banner.');
        }

        $banner = $this->bannerModel->find($id);
        if (!$banner) {
            return redirect()->to('/banner')->with('error', 'Banner tidak ditemukan.');
        }

        $gambar = $this->request->getFile('image');
        $namaFile = $banner['image'];

        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $namaFile = $gambar->getRandomName();
            $gambar->move('uploads/banner', $namaFile);

            if (!empty($banner['image']) && file_exists('uploads/banner/' . $banner['image'])) {
                @unlink('uploads/banner/' . $banner['image']);
            }
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'status' => $this->request->getPost('status') ?? '0',
            'image' => $namaFile,
            'media_type' => $this->request->getPost('media_type'),
            'url' => $this->request->getPost('url'),
            'url_yt' => $this->request->getPost('url_yt'),
            'sorting' => $this->request->getPost('sorting'),
            'keterangan' => $this->request->getPost('keterangan'),
            'category_banner' => $this->request->getPost('category_banner'),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by_id' => session()->get('id_user') ?? null,
            'updated_by_name' => session()->get('username') ?? 'Guest',
        ];

        if (!$this->bannerModel->update($id, $data)) {
            // Asumsi model BannerModel memiliki rules validasi
            return redirect()->back()->withInput()->with('errors', $this->bannerModel->errors());
        }

        return redirect()->to('/banner')->with('success', 'Banner berhasil diperbarui.');
    }

    // HAPUS KE SAMPAH
    public function delete($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) {
            return redirect()->to('/banner')->with('error', 'Kamu tidak punya izin menghapus banner.');
        }

        $banner = $this->bannerModel->find($id);
        if (!$banner) {
            return redirect()->to('/banner')->with('error', 'Banner tidak ditemukan.');
        }

        $this->bannerModel->update($id, [
            'is_delete' => '1',
            'is_delete_at' => date('Y-m-d H:i:s'),
            'is_delete_by_id' => session()->get('id_user') ?? null,
            'is_delete_by_name' => session()->get('username') ?? 'Guest',
        ]);

        return redirect()->to('/banner')->with('success', 'Banner dipindahkan ke sampah.');
    }

    // RESTORE
    public function restore($id)
    {
        // Memerlukan hak 'update' untuk me-restore
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/banner/trash')->with('error', 'Kamu tidak punya izin memulihkan banner.');
        }

        $banner = $this->bannerModel->find($id);
        if (!$banner) {
            return redirect()->to('/banner/trash')->with('error', 'Banner tidak ditemukan.');
        }

        $this->bannerModel->update($id, [
            'is_delete' => '0',
            'is_delete_at' => null,
            'is_delete_by_id' => null,
            'is_delete_by_name' => null,
        ]);

        return redirect()->to('/banner/trash')->with('success', 'Banner berhasil dipulihkan.');
    }

    // HAPUS PERMANEN
    public function destroyPermanent($id)
    {
        // Memerlukan hak 'delete' untuk menghapus permanen
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) {
            return redirect()->to('/banner/trash')->with('error', 'Kamu tidak punya izin menghapus banner permanen.');
        }

        $banner = $this->bannerModel->find($id);
        if (!$banner) {
            return redirect()->to('/banner/trash')->with('error', 'Banner tidak ditemukan.');
        }

        // Hapus file gambar terkait
        if (!empty($banner['image']) && file_exists('uploads/banner/' . $banner['image'])) {
            @unlink('uploads/banner/' . $banner['image']);
        }

        // Hapus data dari database (sesuai cara di controller asli)
        $this->bannerModel->where('id_banner', $id)->delete();
        return redirect()->to('/banner/trash')->with('success', 'Banner dihapus permanen!');
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