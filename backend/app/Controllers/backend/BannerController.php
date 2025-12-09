<?php

namespace App\Controllers\backend;

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
            'banners' => $this->bannerModel->orderBy('created_at', 'DESC')->findAll(),            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ];

        return view('pages/banner/index', $data);
    }

public function toggleStatus()
    {
        // 1. Cek Request AJAX
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // 2. CEK HAK AKSES (PENTING! Tambahan Keamanan)
        $role = session()->get('role');
        $access = $this->getAccess($role);

        if (!$access || !$access['can_update']) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Anda tidak memiliki izin untuk mengubah status banner.',
                'token' => csrf_hash()
            ]);
        }

        // 3. Ambil ID
        $id = $this->request->getPost('id');
        
        // 4. Cari data (Gunakan $this->bannerModel yang sudah di-init di construct)
        $banner = $this->bannerModel->find($id);

        if ($banner) {
            $currentStatus = $banner['status']; 
            $newStatus = ($currentStatus == '1') ? '0' : '1';

            // 5. Update data LENGKAP (Termasuk siapa yang update)
            $updateData = [
                'status'            => $newStatus,
                'updated_at'        => date('Y-m-d H:i:s'), // Update waktu
                'updated_by_id'     => session()->get('id_user'), // Update user ID
                'updated_by_name'   => session()->get('username'), // Update nama user
            ];

            if ($this->bannerModel->update($id, $updateData)) {
                return $this->response->setJSON([
                    'status'    => 'success',
                    'message'   => 'Status berhasil diperbarui',
                    'newStatus' => $newStatus,
                    'token'     => csrf_hash() 
                ]);
            }
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Gagal update atau data tidak ditemukan',
            'token'   => csrf_hash()
        ]);
    }




    // TAMBAH
public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/banner')->with('error', 'Kamu tidak punya izin menambah banner.');
        }

        // --- BAGIAN YANG DITAMBAHKAN ---
        // Menangkap parameter ?kategori=X dari URL
        $kategori = $this->request->getGet('kategori'); 
        // -------------------------------

        $data = [
            'title' => 'Tambah Banner',
            'selected_kategori' => $kategori // Kirim variabel ini ke View
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

    public function delete($id = null)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) {
            return redirect()->to('/banner')->with('error', 'Kamu tidak punya izin menghapus banner.');
        }

        $banner = $this->bannerModel->find($id);

        // =======================================================================
        // PERBAIKAN: Tambahkan FCPATH. Path 'uploads/pages/banner/...' saja tidak akan
        // ditemukan. Harus FCPATH . 'uploads/pages/banner/'
        // =======================================================================
        $uploadPath = FCPATH . 'uploads/banner/';
        if ($banner && !empty($banner['image']) && file_exists($uploadPath . $banner['image'])) {
            @unlink($uploadPath . $banner['image']); // gunakan @ untuk menekan error
        }

        if ($this->bannerModel->delete($id)) {
            return redirect()->to('/banner')->with('success', 'banner berhasil dihapus.');
        } else {
            return redirect()->to('/banner')->with('error', 'Gagal menghapus banner.');
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