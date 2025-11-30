<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\PhotoGalleryModel;

class ApiPhotoGalleryController extends ResourceController
{
    protected $modelName = PhotoGalleryModel::class;
    protected $format = 'json';

    /**
     * GET /api/gallery
     * Menampilkan semua foto aktif (trash = 0)
     */
    public function index()
    {
        $galleries = $this->model->orderBy('created_at', 'DESC')->findAll();

        return $this->respond([
            'status'  => true,
            'message' => 'Daftar foto berhasil diambil.',
            'data'    => $galleries
        ]);
    }

    /**
     * GET /api/gallery/album/{album_id}
     * Menampilkan semua foto berdasarkan album tertentu
     */
    public function byAlbum($album_id = null)
    {
        $photos = $this->model
            ->where('album_id', $album_id)->orderBy('created_at', 'DESC')->findAll();

        if (!$photos) {
            return $this->failNotFound('Foto untuk album ini tidak ditemukan.');
        }

        return $this->respond([
            'status'  => true,
            'message' => 'Daftar foto berdasarkan album berhasil diambil.',
            'data'    => $photos
        ]);
    }

    /**
     * GET /api/gallery/{id}
     * Menampilkan detail satu foto
     */
    public function show($id = null)
    {
        $photo = $this->model
            ->where('id_gallery', $id)
            ->first();

        if (!$photo) {
            return $this->failNotFound('Foto tidak ditemukan.');
        }

        return $this->respond([
            'status'  => true,
            'message' => 'Detail foto berhasil diambil.',
            'data'    => $photo
        ]);
    }
}
