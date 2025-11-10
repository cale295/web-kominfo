<?php

namespace App\Controllers\backend;

use App\Models\AccessRightsModel;
use App\Controllers\BaseController;
use App\Models\PhotoAlbumModel;

class PhotoAlbumController extends BaseController
{
    protected $albumModel;
    protected $accessRightsModel;

    // 3. Sesuaikan nama modul agar konsisten (biasanya snake_case)
    protected $module = 'galeri_album';

    public function __construct()
    {
        $this->albumModel = new PhotoAlbumModel();
        $this->accessRightsModel = new AccessRightsModel();
    }

    // ================= INDEX =================
    public function index()
    {
        $role = session()->get('role');
        $access = $this->getAccess($role);

        if (!$access) {
            return view('pages/album/index', [
                'title' => 'Manajemen Banner',
                'banners' => [],
                'error' => '⚠ Kamu tidak memiliki hak akses ke modul ini.'
            ]);
        }

        if (!$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat banner.');
        }

        $data = [
            'title' => 'Daftar Album Foto',
            'albums' => $this->albumModel->findAll(),
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ];

        return view('pages/album/index', $data);
    }


    // ================= FORM TAMBAH =================
    public function new()
    {
        // 5. Tambahkan Pengecekan Hak Akses
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/album')->with('error', 'Kamu tidak punya izin menambah album.');
        }

        return view('pages/album/create', ['title' => 'Tambah Album Baru']);
    }

    // ================= SIMPAN DATA =================
    public function create()
    {
        // 6. Tambahkan Pengecekan Hak Akses
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/album')->with('error', 'Kamu tidak punya izin menambah album.');
        }

        $data = [
            'album_name' => $this->request->getPost('album_name'),
            'description' => $this->request->getPost('description'),
        ];

        $cover = $this->request->getFile('cover_image');
        if ($cover && $cover->isValid() && !$cover->hasMoved()) {
            $newName = $cover->getRandomName();
            $cover->move('uploads/album_covers/', $newName);
            $data['cover_image'] = $newName;
        }

        if (!$this->albumModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->albumModel->errors());
        }

        return redirect()->to('/album')->with('success', 'Album berhasil ditambahkan.');
    }

    // ================= FORM EDIT =================
    public function edit($id = null)
    {
        // 7. Tambahkan Pengecekan Hak Akses
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/album')->with('error', 'Kamu tidak punya izin mengedit album.');
        }

        $album = $this->albumModel->find($id);
        // 8. Tambahkan pengecekan trash
        if (!$album || $album['trash'] == '1') {
            return redirect()->to('/album')->with('error', 'Album tidak ditemukan.');
        }

        return view('pages/album/edit', [
            'title' => 'Edit Album',
            'album' => $album,
            'can_update' => $access['can_update'], // Kirim hak akses ke view
        ]);
    }

    // ================= UPDATE =================
    public function update($id = null)
    {
        // 9. Tambahkan Pengecekan Hak Akses
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/album')->with('error', 'Kamu tidak punya izin mengubah album.');
        }

        $album = $this->albumModel->find($id);
        if (!$album) {
            return redirect()->to('/album')->with('error', 'Album tidak ditemukan.');
        }

        $data = [
            'album_name' => $this->request->getPost('album_name'),
            'description' => $this->request->getPost('description'),
        ];

        $cover = $this->request->getFile('cover_image');
        if ($cover && $cover->isValid() && !$cover->hasMoved()) {
            $newName = $cover->getRandomName();
            $cover->move('uploads/album_covers/', $newName);
            $data['cover_image'] = $newName;

            // 10. Perbaiki path unlink (gunakan FCPATH)
            $uploadPath = FCPATH . 'uploads/album_covers/';
            if (!empty($album['cover_image']) && file_exists($uploadPath . $album['cover_image'])) {
                @unlink($uploadPath . $album['cover_image']);
            }
        }

        if (!$this->albumModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->albumModel->errors());
        }

        return redirect()->to('/album')->with('success', 'Album berhasil diperbarui.');
    }
public function delete($id = null)
{
    $access = $this->getAccess(session()->get('role'));
    if (!$access || !$access['can_delete']) {
        return redirect()->to('/album')->with('error', 'Kamu tidak punya izin menghapus album.');
    }

    $album = $this->albumModel->find($id);
    if (!$album) {
        return redirect()->to('/album')->with('error', 'Album tidak ditemukan.');
    }

    // Hapus file cover jika ada
    $uploadPath = FCPATH . 'uploads/album_covers/';
    if (!empty($album['cover_image']) && file_exists($uploadPath . $album['cover_image'])) {
        @unlink($uploadPath . $album['cover_image']);
    }

    // Hapus record dari database (hard delete)
    if (!$this->albumModel->delete($id)) {
        return redirect()->back()->with('error', 'Gagal menghapus album.');
    }

    return redirect()->to('/album')->with('success', 'Album dan foto berhasil dihapus permanen.');
}



    // ========================================================
    // Fungsi bantu untuk ambil akses role (WAJIB ADA)
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