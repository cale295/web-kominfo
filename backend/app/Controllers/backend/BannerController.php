<?php

namespace App\Controllers\backend;

use App\Controllers\BaseController;
use App\Models\BannerModel;
use App\Models\AccessRightsModel;

class BannerController extends BaseController
{
    protected $bannerModel;
    protected $accessRightsModel;
    protected $module = 'banner';

    public function __construct()
    {
        $this->bannerModel = new BannerModel();
        $this->accessRightsModel = new AccessRightsModel();
    }

    // --- INDEX ---
    public function index()
    {
        $role = session()->get('role');
        $access = $this->getAccess($role);

        if (!$access || !$access['can_read']) {
            return view('pages/banner/index', [
                'title' => 'Manajemen Banner',
                'banners' => [],
                'error' => '⚠ Kamu tidak memiliki hak akses ke modul ini.'
            ]);
        }

        $data = [
            'title' => 'Manajemen Banner',
            'banners' => $this->bannerModel->orderBy('created_at', 'DESC')->findAll(),
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ];

        return view('pages/banner/index', $data);
    }

    // --- TOGGLE STATUS (AJAX) ---
    public function toggleStatus()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $role = session()->get('role');
        $access = $this->getAccess($role);

        if (!$access || !$access['can_update']) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Anda tidak memiliki izin.',
                'token' => csrf_hash()
            ]);
        }

        $id = $this->request->getPost('id');
        $banner = $this->bannerModel->find($id);

        if ($banner) {
            $newStatus = ($banner['status'] == '1') ? '0' : '1';
            $this->bannerModel->update($id, [
                'status' => $newStatus,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by_id' => session()->get('id_user'),
                'updated_by_name' => session()->get('username'),
            ]);

            return $this->response->setJSON([
                'status' => 'success',
                'newStatus' => $newStatus,
                'token' => csrf_hash()
            ]);
        }

        return $this->response->setJSON(['status' => 'error', 'token' => csrf_hash()]);
    }

    // --- FORM CREATE ---
    public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/banner')->with('error', 'Akses ditolak.');
        }

        $data = [
            'title' => 'Tambah Banner',
            'selected_kategori' => $this->request->getGet('kategori')
        ];
        return view('pages/banner/create', $data);
    }

    // --- PROCESS CREATE ---
    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/banner')->with('error', 'Akses ditolak.');
        }

        $mediaType = $this->request->getPost('media_type');
        $gambar = $this->request->getFile('image');
        $namaFile = null;
        $urlYt = null;

        // LOGIKA MEDIA TYPE
        if ($mediaType === 'image') {
            // Jika Image, proses upload
            if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
                $namaFile = $gambar->getRandomName();
                $gambar->move(FCPATH . 'uploads/banner', $namaFile);
            }
            // URL Youtube dipastikan NULL
            $urlYt = null; 
        } 
        elseif ($mediaType === 'video') {
            // Jika Video, ambil URL Youtube
            $urlYt = $this->request->getPost('url_yt');
            // Image dipastikan NULL (tidak ada upload)
            $namaFile = null;
        }

        $data = [
            'title'           => $this->request->getPost('title'),
            'status'          => '0', // Default non-aktif
            'image'           => $namaFile,
            'media_type'      => $mediaType,
            'url'             => $this->request->getPost('url'),
            'url_yt'          => $urlYt,
            'sorting'         => $this->request->getPost('sorting'),
            'keterangan'      => $this->request->getPost('keterangan'),
            'category_banner' => $this->request->getPost('category_banner'),
            'is_delete'       => '0',
            'created_at'      => date('Y-m-d H:i:s'),
            'created_by_id'   => session()->get('id_user'),
            'created_by_name' => session()->get('username') ?? 'Guest',
        ];

        if (!$this->bannerModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->bannerModel->errors());
        }

        return redirect()->to('/banner')->with('success', 'Banner berhasil ditambahkan.');
    }

    // --- FORM EDIT ---
    public function edit($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/banner')->with('error', 'Akses ditolak.');
        }

        $banner = $this->bannerModel->find($id);
        if (!$banner) {
            return redirect()->to('/banner')->with('error', 'Data tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Banner',
            'banner' => $banner,
        ];
        return view('pages/banner/edit', $data);
    }

    // --- PROCESS UPDATE ---
    public function update($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/banner')->with('error', 'Akses ditolak.');
        }

        $banner = $this->bannerModel->find($id);
        if (!$banner) {
            return redirect()->to('/banner')->with('error', 'Data tidak ditemukan.');
        }

        $mediaType = $this->request->getPost('media_type');
        $gambar = $this->request->getFile('image');
        
        $namaFile = $banner['image']; // Default pakai lama
        $urlYt = $banner['url_yt'];   // Default pakai lama

        // LOGIKA PERUBAHAN TIPE MEDIA
        if ($mediaType === 'video') {
            // User pilih VIDEO
            
            // 1. Ambil input URL baru
            $urlYt = $this->request->getPost('url_yt');

            // 2. Hapus file gambar lama (jika ada) untuk hemat space
            if (!empty($banner['image']) && file_exists(FCPATH . 'uploads/banner/' . $banner['image'])) {
                @unlink(FCPATH . 'uploads/banner/' . $banner['image']);
            }
            
            // 3. Set kolom image jadi NULL
            $namaFile = null;
        } 
        elseif ($mediaType === 'image') {
            // User pilih IMAGE

            // 1. Cek ada upload baru gak?
            if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
                $namaFile = $gambar->getRandomName();
                $gambar->move(FCPATH . 'uploads/banner', $namaFile);

                // Hapus gambar lama agar tidak numpuk
                if (!empty($banner['image']) && file_exists(FCPATH . 'uploads/banner/' . $banner['image'])) {
                    @unlink(FCPATH . 'uploads/banner/' . $banner['image']);
                }
            }
            // Jika tidak upload baru, $namaFile tetap pakai $banner['image']

            // 2. Set URL Youtube jadi NULL
            $urlYt = null;
        }

        $data = [
            'title'           => $this->request->getPost('title'),
            'image'           => $namaFile,
            'media_type'      => $mediaType,
            'url'             => $this->request->getPost('url'),
            'url_yt'          => $urlYt, // Hasil logika di atas
            'sorting'         => $this->request->getPost('sorting'),
            'keterangan'      => $this->request->getPost('keterangan'),
            'category_banner' => $this->request->getPost('category_banner'),
            'updated_at'      => date('Y-m-d H:i:s'),
            'updated_by_id'   => session()->get('id_user'),
            'updated_by_name' => session()->get('username'),
        ];

        if (!$this->bannerModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->bannerModel->errors());
        }

        return redirect()->to('/banner')->with('success', 'Banner berhasil diperbarui.');
    }

    // --- DELETE ---
    public function delete($id = null)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) {
            return redirect()->to('/banner')->with('error', 'Akses ditolak.');
        }

        $banner = $this->bannerModel->find($id);
        
        // Hapus fisik file jika ada
        if ($banner && !empty($banner['image'])) {
            $path = FCPATH . 'uploads/banner/' . $banner['image'];
            if (file_exists($path)) {
                @unlink($path);
            }
        }

        if ($this->bannerModel->delete($id)) {
            return redirect()->to('/banner')->with('success', 'Banner dihapus.');
        }
        
        return redirect()->to('/banner')->with('error', 'Gagal menghapus.');
    }

    // --- HELPER ---
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