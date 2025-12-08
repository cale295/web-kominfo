<?php

namespace App\Controllers\frontend;

use App\Models\frontend\HomeVideoLayananModel;
use App\Models\AccessRightsModel;
use App\Controllers\BaseController;

class HomeVideoLayananController extends BaseController
{
    protected $homeVideoModel;
    protected $accessRightsModel;
    protected $module = 'home_video_layanan'; // Pastikan nama modul ini terdaftar

    public function __construct()
    {
        $this->homeVideoModel = new HomeVideoLayananModel();
        $this->accessRightsModel = new AccessRightsModel();
    }

    private function getAccess($role)
    {
        $access = $this->accessRightsModel->where('role', $role)->where('module_name', $this->module)->first();
        if (!$access) return ['can_create' => false, 'can_read' => false, 'can_update' => false, 'can_delete' => false];
        return [
            'can_create' => (bool)$access['can_create'],
            'can_read'   => (bool)$access['can_read'],
            'can_update' => (bool)$access['can_update'],
            'can_delete' => (bool)$access['can_delete'],
        ];
    }

    public function index()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat modul ini.');
        }

        // Urutkan: Featured dulu, lalu Sorting, lalu Terbaru
        $videos = $this->homeVideoModel
            ->orderBy('is_featured', 'DESC')
            ->orderBy('sorting', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('pages/home_video_layanan/index', [
            'videos'     => $videos,
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete']
        ]);
    }

    public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/home_video_layanan')->with('error', 'Akses ditolak.');
        }
        $countdata = $this->homeVideoModel->countAllResults();
        if ($countdata > 3) {
            return redirect()->to('/home_video_layanan')->with('error', 'Maksimal Data Video Layanan 4.');
        }
        return view('pages/home_video_layanan/create');
    }
        public function toggleStatus()
    {
        // 1. Cek Request AJAX
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // 2. CEK HAK AKSES
        // Pastikan Controller punya property $this->accessRightsModel & fungsi getAccess()
        $role = session()->get('role');
        $access = $this->getAccess($role);

        if (!$access || !$access['can_update']) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Anda tidak memiliki izin untuk mengubah data ini.',
                'token' => csrf_hash()
            ]);
        }

        // 3. LOAD MODEL & AMBIL DATA
        // ==================================================
        $model = new \App\Models\frontend\HomeVideoLayananModel(); // <--- GANTI INI SESUAI MODUL
        // ==================================================

        $id = $this->request->getPost('id');
        $data = $model->find($id);

        if ($data) {
            // Logic Toggle (1 -> 0, 0 -> 1)
            $newStatus = ($data['is_active'] == '1') ? '0' : '1';

            // Data Update (Termasuk Audit Trail)
            $updateData = [
                'is_active'            => $newStatus,
                'updated_at'        => date('Y-m-d H:i:s'),
                'updated_by_id'     => session()->get('id_user'),
                'updated_by_name'   => session()->get('username'),
            ];

            if ($model->update($id, $updateData)) {
                return $this->response->setJSON([
                    'status'    => 'success',
                    'message'   => 'Status berhasil diperbarui',
                    'newStatus' => $newStatus,
                    'token'     => csrf_hash() // Kirim token baru
                ]);
            }
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Gagal update status atau data tidak ditemukan',
            'token'   => csrf_hash()
        ]);
    }


public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) return redirect()->to('/home_video_layanan');

        // Ambil nilai is_featured dari input
        $isFeatured = $this->request->getPost('is_featured') ?? 0;

        // --- LOGIKA PENGECEKAN (VALIDASI) ---
        // Jika user mencoba menginput video sebagai Featured (1)
        if ($isFeatured == 1) {
            // Cek di database apakah sudah ada video yang featured?
            $existingFeatured = $this->homeVideoModel->where('is_featured', 1)->first();

            // Jika SUDAH ADA, tolak prosesnya
            if ($existingFeatured) {
                return redirect()->back()
                    ->withInput() // Kembalikan inputan user agar tidak mengetik ulang
                    ->with('error', 'Gagal: Video Utama (Featured) sudah ada. Silakan non-aktifkan video utama yang lama terlebih dahulu.');
            }
        }


       
        // --- SELESAI LOGIKA PENGECEKAN ---

        $data = [
            'youtube_url' => $this->request->getPost('youtube_url'),
            'embed_code'  => $this->request->getPost('embed_code'),
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'is_featured' => $isFeatured,
            'sorting'     => $this->request->getPost('sorting') ?? 0,
            'is_active'   => $this->request->getPost('is_active') ?? 0,
        ];

        // Handle File Upload (Thumbnail)
        $file = $this->request->getFile('thumb_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/home_video', $newName);
            $data['thumb_image'] = 'uploads/home_video/' . $newName;
        }

        if (!$this->homeVideoModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->homeVideoModel->errors());
        }

        return redirect()->to('/home_video_layanan')->with('success', 'Video berhasil ditambahkan.');
    }
    public function edit($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/home_video_layanan')->with('error', 'Akses ditolak.');
        }

        $video = $this->homeVideoModel->find($id);
        if (!$video) {
            return redirect()->to('/home_video_layanan')->with('error', 'Data tidak ditemukan.');
        }

        return view('pages/home_video_layanan/edit', ['video' => $video]);
    }

public function update($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) return redirect()->to('/home_video_layanan');

        $oldData = $this->homeVideoModel->find($id);
        if (!$oldData) return redirect()->to('/home_video_layanan')->with('error', 'Data tidak ditemukan.');

        // Ambil nilai is_featured dari input
        $isFeatured = $this->request->getPost('is_featured') ?? 0;

        // --- LOGIKA PENGECEKAN (VALIDASI UPDATE) ---
        // Jika user mencoba menyetel video ini sebagai Featured (1)
        if ($isFeatured == 1) {
            // Cek apakah ada video LAIN yang sudah featured?
            // Kita gunakan 'where id != $id' agar tidak mendeteksi dirinya sendiri
            $existingFeatured = $this->homeVideoModel
                                     ->where('is_featured', 1)
                                     ->where('id_video_layanan !=', $id) // PENTING: Kecualikan video yang sedang diedit ini
                                     ->first();

                                        
            // Jika ada video LAIN yang featured, tolak update
            if ($existingFeatured) {
                return redirect()->back()
                    ->withInput() // Kembalikan inputan user
                    ->with('error', 'Gagal: Video Utama (Featured) sudah ada pada video lain ("' . $existingFeatured['title'] . '"). Silakan non-aktifkan video tersebut terlebih dahulu.');
            }
        }
        // --- SELESAI LOGIKA PENGECEKAN ---

        $data = [
            'id_video_layanan' => $id,
            'youtube_url'      => $this->request->getPost('youtube_url'),
            'embed_code'       => $this->request->getPost('embed_code'),
            'title'            => $this->request->getPost('title'),
            'description'      => $this->request->getPost('description'),
            'is_featured'      => $isFeatured,
            'sorting'          => $this->request->getPost('sorting') ?? 0,
            'is_active'        => $this->request->getPost('is_active') ?? 0,
        ];

        // Handle File Upload & Replace
        $file = $this->request->getFile('thumb_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Upload baru
            $newName = $file->getRandomName();
            $file->move('uploads/home_video', $newName);
            $data['thumb_image'] = 'uploads/home_video/' . $newName;

            // Hapus file lama fisik
            if (!empty($oldData['thumb_image']) && file_exists($oldData['thumb_image'])) {
                unlink($oldData['thumb_image']);
            }
        }

        if (!$this->homeVideoModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->homeVideoModel->errors());
        }

        return redirect()->to('/home_video_layanan')->with('success', 'Video berhasil diperbarui.');
    }
    public function delete($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) return redirect()->to('/home_video_layanan');

        $data = $this->homeVideoModel->find($id);
        if ($data) {
            // Hapus file fisik
            if (!empty($data['thumb_image']) && file_exists($data['thumb_image'])) {
                unlink($data['thumb_image']);
            }
            $this->homeVideoModel->delete($id);
            return redirect()->to('/home_video_layanan')->with('success', 'Data berhasil dihapus.');
        }

        return redirect()->to('/home_video_layanan')->with('error', 'Gagal menghapus data.');
    }
}