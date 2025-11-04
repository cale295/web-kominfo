<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PhotoGalleryModel;
use App\Models\PhotoAlbumModel;

class PhotoGalleryController extends BaseController
{
    protected $galleryModel;
    protected $albumModel;

    public function __construct()
    {
        $this->galleryModel = new PhotoGalleryModel();
        $this->albumModel   = new PhotoAlbumModel();
    }

    /**
     * Daftar foto
     */
    public function index()
    {
        $data = [
            'title'   => 'Daftar Foto',
            'gallery' => $this->galleryModel
                ->select('t_photo_gallery.*, m_photo_album.album_name')
                ->join('m_photo_album', 'm_photo_album.id_album = t_photo_gallery.id_album', 'left')
                ->where('t_photo_gallery.trash', '0')
                ->orderBy('t_photo_gallery.created_at', 'DESC')
                ->findAll(),
            'albums' => $this->albumModel->where('trash', '0')->findAll(),
        ];

        return view('pages/gallery/index', $data);
    }

    /**
     * Form tambah
     */
    public function create()
    {
        $data = [
            'title'  => 'Tambah Foto',
            'albums' => $this->albumModel->where('trash', '0')->findAll(),
        ];

        return view('pages/gallery/create', $data);
    }

    /**
     * Simpan foto baru
     */
    public function store()
    {
        $file = $this->request->getFile('file_path');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/gallery', $newName);

            $this->galleryModel->insert([
                'photo_title' => $this->request->getPost('photo_title'),
                'file_path'   => $newName,
                'id_album'    => $this->request->getPost('id_album') ?: null,
                'trash'       => '0',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ]);

            return redirect()->to('/gallery')->with('success', 'Foto berhasil ditambahkan.');
        }

        $data = [
            'title'  => 'Tambah Foto',
            'albums' => $this->albumModel->where('trash', '0')->findAll(),
            'error'  => 'Upload gagal. Pastikan file valid dan tidak terlalu besar.'
        ];

        return view('pages/gallery/create', $data);
    }

    /**
     * Form edit
     */
    public function edit($id = null)
    {
        $photo = $this->galleryModel->find($id);
        if (!$photo) {
            return redirect()->to('/gallery')->with('error', 'Foto tidak ditemukan.');
        }

        $data = [
            'title'  => 'Edit Foto',
            'photo'  => $photo,
            'albums' => $this->albumModel->where('trash', '0')->findAll(),
        ];

        return view('pages/gallery/edit', $data);
    }

    /**
     * Update foto
     */
    public function update($id = null)
    {
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
            $file->move(FCPATH . 'uploads/gallery', $newName);
        }

        $this->galleryModel->update($id, [
            'photo_title' => $this->request->getPost('photo_title'),
            'file_path'   => $newName,
            'id_album'    => $this->request->getPost('id_album') ?: null,
            'updated_at'  => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/gallery')->with('success', 'Foto berhasil diperbarui.');
    }

    /**
     * Soft delete
     */
    public function delete($id = null)
    {
        $photo = $this->galleryModel->find($id);
        if (!$photo) {
            return redirect()->to('/gallery')->with('error', 'Foto tidak ditemukan.');
        }

        $this->galleryModel->update($id, [
            'trash' => '1',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/gallery')->with('success', 'Foto dipindahkan ke sampah.');
    }

    /**
     * Halaman sampah
     */
    public function trash()
    {
        $data = [
            'title'   => 'Sampah Foto',
            'gallery' => $this->galleryModel
                ->select('t_photo_gallery.*, m_photo_album.album_name')
                ->join('m_photo_album', 'm_photo_album.id_album = t_photo_gallery.id_album', 'left')
                ->where('t_photo_gallery.trash', '1')
                ->orderBy('t_photo_gallery.created_at', 'DESC')
                ->findAll(),
            'albums' => $this->albumModel->where('trash', '0')->findAll(),
        ];

        return view('pages/gallery/trash', $data);
    }

    /**
     * Restore dari sampah
     */
    public function restore($id = null)
    {
        $photo = $this->galleryModel->find($id);
        if (!$photo) {
            return redirect()->to('/gallery/trash')->with('error', 'Foto tidak ditemukan.');
        }

        $this->galleryModel->update($id, [
            'trash' => '0',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/gallery/trash')->with('success', 'Foto berhasil dikembalikan.');
    }

    /**
     * Hapus permanen
     */
    public function destroyPermanent($id = null)
    {
        $photo = $this->galleryModel->find($id);
        if (!$photo) {
            return redirect()->to('/gallery/trash')->with('error', 'Foto tidak ditemukan.');
        }

        if (!empty($photo['file_path']) && file_exists(FCPATH . 'uploads/gallery/' . $photo['file_path'])) {
            @unlink(FCPATH . 'uploads/gallery/' . $photo['file_path']);
        }

        $this->galleryModel->delete($id, true);
        return redirect()->to('/gallery/trash')->with('success', 'Foto dihapus permanen.');
    }
}
