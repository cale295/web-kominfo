<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PhotoAlbumModel;

class PhotoAlbumController extends BaseController
{
    protected $albumModel;

    public function __construct()
    {
        $this->albumModel = new PhotoAlbumModel();
    }

    // ================= INDEX =================
    public function index()
    {
        $data = [
            'title' => 'Daftar Album Foto',
            'albums' => $this->albumModel->where('trash', '0')->findAll(),
        ];

        return view('pages/album/index', $data);
    }

    // ================= FORM TAMBAH =================
    public function new()
    {
        return view('pages/album/create', ['title' => 'Tambah Album Baru']);
    }

    // ================= SIMPAN DATA =================
    public function create()
    {
        $data = [
            'album_name' => $this->request->getPost('album_name'),
            'description' => $this->request->getPost('description'),
            'trash' => '0'
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
        $album = $this->albumModel->find($id);
        if (!$album) {
            return redirect()->to('/album')->with('error', 'Album tidak ditemukan.');
        }

        return view('pages/album/edit', [
            'title' => 'Edit Album',
            'album' => $album,
        ]);
    }

    // ================= UPDATE =================
    public function update($id = null)
    {
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

            if (!empty($album['cover_image']) && file_exists('uploads/album_covers/' . $album['cover_image'])) {
                unlink('uploads/album_covers/' . $album['cover_image']);
            }
        }

        $this->albumModel->update($id, $data);
        return redirect()->to('/album')->with('success', 'Album berhasil diperbarui.');
    }

    // ================= HAPUS (KE SAMPAH) =================
    public function delete($id = null)
    {
        $album = $this->albumModel->find($id);
        if (!$album) {
            return redirect()->to('/album')->with('error', 'Album tidak ditemukan.');
        }

        $this->albumModel->update($id, ['trash' => '1']);
        return redirect()->to('/album')->with('success', 'Album berhasil dipindahkan ke sampah.');
    }

    // ================= HALAMAN SAMPAH =================
    public function trash()
    {
        $data = [
            'title' => 'Sampah Album Foto',
            'albums' => $this->albumModel->where('trash', '1')->findAll(),
        ];

        return view('pages/album/trash', $data);
    }

    // ================= RESTORE =================
    public function restore($id = null)
    {
        $album = $this->albumModel->find($id);
        if (!$album) {
            return redirect()->to('/album/trash')->with('error', 'Album tidak ditemukan.');
        }

        $this->albumModel->update($id, ['trash' => '0']);
        return redirect()->to('/album/trash')->with('success', 'Album berhasil dipulihkan.');
    }

    // ================= HAPUS PERMANEN =================
    public function destroyPermanent($id = null)
    {
        $album = $this->albumModel->find($id);
        if (!$album) {
            return redirect()->to('/album/trash')->with('error', 'Album tidak ditemukan.');
        }

        if (!empty($album['cover_image']) && file_exists('uploads/album_covers/' . $album['cover_image'])) {
            unlink('uploads/album_covers/' . $album['cover_image']);
        }

        $this->albumModel->delete($id, true);
        return redirect()->to('/album/trash')->with('success', 'Album dihapus permanen.');
    }
}
