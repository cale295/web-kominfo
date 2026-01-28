<?php

namespace App\Controllers\frontend;

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

        $count = $this->bannerModel->countAllResults();
        if ($count >= 10) {
            return redirect()->to('/banner')->with('error', 'Maksimal 10 banner.');
        }

        $data = [
            'title' => 'Tambah Banner',
            'selected_kategori' => $this->request->getGet('kategori')
        ];
        return view('pages/banner/create', $data);
    }

    // --- PROCESS CREATE ---
// SIMPAN DATA
    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/banner')->with('error', 'Akses ditolak.');
        }

        // Ambil input
        $mediaType = $this->request->getPost('media_type');
        
        // ============================================================
        // 1. VALIDASI DINAMIS (KUNCI UTAMA)
        // ============================================================
        if ($mediaType === 'video') {
            // Jika Video: URL Youtube WAJIB
            $this->bannerModel->setValidationRule('url_yt', 'required|valid_url');
            // Gambar TIDAK WAJIB
            // (Note: Validasi upload gambar sebaiknya manual di controller karena CI4 model validation untuk file kadang tricky)
        } else {
            // Jika Image: URL Youtube TIDAK WAJIB
            $this->bannerModel->setValidationRule('url_yt', 'permit_empty');
            
            // Validasi manual: Pastikan user upload gambar
            $file = $this->request->getFile('image');
            if (!$file->isValid()) {
                return redirect()->back()->withInput()->with('error', 'Anda wajib mengupload gambar jika memilih tipe Gambar.');
            }
        }
        // ============================================================

        $gambar = $this->request->getFile('image');
        $namaFile = null;
        $urlYt = null;

        // Logika File & URL (Seperti sebelumnya)
        if ($mediaType === 'image') {
            if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
                $namaFile = $gambar->getRandomName();
                $gambar->move(FCPATH . 'uploads/banner', $namaFile);
            }
            $urlYt = null; 
        } 
        elseif ($mediaType === 'video') {
            $urlYt = $this->request->getPost('url_yt');
            $namaFile = null;
        }

        $data = [
            'title'           => $this->request->getPost('title'),
            'status'          => $this->request->getPost('status') ?? '0',
            'image'           => $namaFile,
            'media_type'      => $mediaType,
            'url'             => $this->request->getPost('url'), // Ini sekarang boleh kosong (karena permit_empty di model)
            'url_yt'          => $urlYt,
            'sorting'         => $this->request->getPost('sorting'),
            'keterangan'      => $this->request->getPost('keterangan'),
            'category_banner' => $this->request->getPost('category_banner'),
            'is_delete'       => '0',
            'created_at'      => date('Y-m-d H:i:s'),
            'created_by_id'   => session()->get('id_user'),
            'created_by_name' => session()->get('username') ?? 'Guest',
        ];

        // Simpan dengan Validasi Dinamis
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
// UPDATE
    public function update($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/banner')->with('error', 'Akses ditolak.');
        }

        $banner = $this->bannerModel->find($id);
        if (!$banner) return redirect()->to('/banner')->with('error', 'Data tidak ditemukan.');

        $mediaType = $this->request->getPost('media_type');

        // ============================================================
        // 1. VALIDASI DINAMIS UPDATE
        // ============================================================
        if ($mediaType === 'video') {
            // Jika Video: URL Youtube WAJIB
            $this->bannerModel->setValidationRule('url_yt', 'required|valid_url');
        } else {
            // Jika Image: URL Youtube TIDAK WAJIB
            $this->bannerModel->setValidationRule('url_yt', 'permit_empty');
            // Gambar tidak wajib required karena bisa pakai gambar lama
        }
        // ============================================================

        $gambar = $this->request->getFile('image');
        $namaFile = $banner['image'];
        $urlYt = $banner['url_yt'];

        // Logika Hapus File & Ganti Tipe (Sama seperti sebelumnya)
        if ($mediaType === 'video') {
            $urlYt = $this->request->getPost('url_yt');
            if (!empty($banner['image']) && file_exists(FCPATH . 'uploads/banner/' . $banner['image'])) {
                @unlink(FCPATH . 'uploads/banner/' . $banner['image']);
            }
            $namaFile = null;
        } 
        elseif ($mediaType === 'image') {
            if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
                $namaFile = $gambar->getRandomName();
                $gambar->move(FCPATH . 'uploads/banner', $namaFile);
                if (!empty($banner['image']) && file_exists(FCPATH . 'uploads/banner/' . $banner['image'])) {
                    @unlink(FCPATH . 'uploads/banner/' . $banner['image']);
                }
            }
            $urlYt = null;
        }

        $data = [
            'title'           => $this->request->getPost('title'),
            'image'           => $namaFile,
            'media_type'      => $mediaType,
            'url'             => $this->request->getPost('url'), // Boleh kosong
            'url_yt'          => $urlYt,
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