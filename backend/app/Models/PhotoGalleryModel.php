<?php

namespace App\Models;

use CodeIgniter\Model;

class PhotoGalleryModel extends Model
{
    protected $table = 't_photo_gallery';
    protected $primaryKey = 'id_photo';
    protected $allowedFields = [
        'photo_title',
        'file_path',
        'id_album',
    ];

    // Untuk otomatis update timestamp kalau mau (opsional)
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Ambil semua data foto berdasarkan album
    public function getByAlbum($id_album)
    {
        return $this->where('id_album', $id_album)
                    ->findAll();
    }

    // Ambil data foto yang masuk tong sampah
}
