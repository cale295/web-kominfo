<?php

namespace App\Controllers\backend;

use App\Controllers\BaseController;
use App\Models\PhotoGalleryModel;
use App\Models\PhotoAlbumModel;
use App\Models\AccessRightsModel;

class PhotoGalleryController extends BaseController
{
    protected $galleryModel;
    protected $albumModel;
    protected $accessRightsModel;
    protected $module = 'galeri_foto';

    public function __construct()
    {
        $this->galleryModel = new PhotoGalleryModel();
        $this->albumModel = new PhotoAlbumModel();
        $this->accessRightsModel = new AccessRightsModel();
    }

    // ================= INDEX =================
    public function index()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat foto.');
        }

        $data = [
            'title'   => 'Daftar Foto',
            'gallery' => $this->galleryModel
                ->select('t_photo_gallery.*, m_photo_album.album_name')
                ->join('m_photo_album', 'm_photo_album.id_album = t_photo_gallery.id_album', 'left')
                ->orderBy('t_photo_gallery.created_at', 'DESC')
                ->findAll(),
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ];

        return view('pages/gallery/index', $data);
    }

    // ================= FORM TAMBAH =================
    public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/gallery')->with('error', 'Kamu tidak punya izin menambah foto.');
        }

        return view('pages/gallery/create', [
            'title'  => 'Tambah Foto',
            'albums' => $this->albumModel->findAll(),
        ]);
    }

    // ================= SIMPAN DATA =================
    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/gallery')->with('error', 'Kamu tidak punya izin menambah foto.');
        }

        $file = $this->request->getFile('file_path');
        if (!$file || !$file->isValid()) {
            return redirect()->back()->withInput()->with('error', 'File tidak valid atau belum diupload.');
        }

        $newName = $file->getRandomName();
        $uploadPath = FCPATH . 'uploads/gallery/';
        if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);
        $file->move($uploadPath, $newName);

        $data = [
            'photo_title' => $this->request->getPost('photo_title'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'id_album'    => $this->request->getPost('id_album') ?: null,
            'file_path'   => $newName,
        ];

        if (!$this->galleryModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->galleryModel->errors());
        }

        return redirect()->to('/gallery')->with('success', 'Foto berhasil ditambahkan.');
    }

    // ================= FORM EDIT =================
    public function edit($id = null)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/gallery')->with('error', 'Kamu tidak punya izin mengedit foto.');
        }

        $photo = $this->galleryModel->find($id);
        if (!$photo) {
            return redirect()->to('/gallery')->with('error', 'Foto tidak ditemukan.');
        }

        return view('pages/gallery/edit', [
            'title'  => 'Edit Foto',
            'photo'  => $photo,
            'albums' => $this->albumModel->findAll(),
        ]);
    }

    // ================= UPDATE =================
    public function update($id = null)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/gallery')->with('error', 'Kamu tidak punya izin mengubah foto.');
        }

        $photo = $this->galleryModel->find($id);
        if (!$photo) {
            return redirect()->to('/gallery')->with('error', 'Foto tidak ditemukan.');
        }

        $file = $this->request->getFile('file_path');
        $newName = $photo['file_path'];

        if ($file && $file->isValid() && !$file->hasMoved()) {
            if (!empty($photo['file_path']) && file_exists(FCPATH . 'uploads/gallery/' . $photo['file_path'])) {
                @unlink(FCPATH . 'uploads/gallery/' . $photo['file_path']);
            }
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/gallery/', $newName);
        }

        $data = [
            'photo_title' => $this->request->getPost('photo_title'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'id_album'    => $this->request->getPost('id_album') ?: null,
            'file_path'   => $newName,
        ];

        if (!$this->galleryModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->galleryModel->errors());
        }

        return redirect()->to('/gallery')->with('success', 'Foto berhasil diperbarui.');
    }

    // ================= DELETE =================
    public function delete($id = null)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) {
            return redirect()->to('/gallery')->with('error', 'Kamu tidak punya izin menghapus foto.');
        }

        $photo = $this->galleryModel->find($id);
        if (!$photo) {
            return redirect()->to('/gallery')->with('error', 'Foto tidak ditemukan.');
        }

        $uploadPath = FCPATH . 'uploads/gallery/';
        if (!empty($photo['file_path']) && file_exists($uploadPath . $photo['file_path'])) {
            @unlink($uploadPath . $photo['file_path']);
        }

        $this->galleryModel->delete($id);

        return redirect()->to('/gallery')->with('success', 'Foto berhasil dihapus permanen.');
    }

    // ================= HAK AKSES =================
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
