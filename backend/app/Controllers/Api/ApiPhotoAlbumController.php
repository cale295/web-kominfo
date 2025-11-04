<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\PhotoAlbumModel;

class ApiPhotoAlbumController extends ResourceController
{
    protected $modelName = PhotoAlbumModel::class;
    protected $format = 'json';

    /**
     * GET /api/album
     * Menampilkan semua album yang aktif (trash = 0)
     */
    public function index()
    {
        $albums = $this->model
            ->where('trash', '0') // hanya tampilkan yang aktif
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return $this->respond([
            'status'  => true,
            'message' => 'Daftar album berhasil diambil.',
            'data'    => $albums
        ]);
    }

    /**
     * GET /api/album/{id}
     * Menampilkan detail satu album
     */
    public function show($id = null)
    {
        $album = $this->model
            ->where('id_album', $id)
            ->where('trash', '0') // pastikan bukan sampah
            ->first();

        if (!$album) {
            return $this->failNotFound('Album tidak ditemukan.');
        }

        return $this->respond([
            'status'  => true,
            'message' => 'Detail album berhasil diambil.',
            'data'    => $album
        ]);
    }
}
