<?php

namespace App\Models;

use CodeIgniter\Model;

class BannerModel extends Model
{
    protected $table = 'm_banner';
    protected $primaryKey = 'id_banner';

    protected $allowedFields = [
        'title',
        'status',
        'image',
        'media_type',
        'url',
        'url_yt',
        'sorting',
        'keterangan',
        'category_banner',
        'created_at',
        'created_by_id',
        'created_by_name',
        'updated_at',
        'updated_by_id',
        'updated_by_name',
        'is_delete',
        'is_delete_at',
        'is_delete_by_id',
        'is_delete_by_name',
    ];

    // ❌ Nonaktifkan soft delete bawaan CI
    protected $useSoftDeletes = false;

    // ✅ Gunakan field waktu biasa
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // ✅ Ambil data aktif
    public function getAllActive()
    {
        return $this->where('is_delete', '0')->findAll();
    }

    // ✅ Ambil data sampah
    public function getAllDeleted()
    {
        return $this->where('is_delete', '1')->findAll();
    }

    // ✅ Fungsi hapus (soft delete manual)
    public function softDeleteBanner($id, $userId = null, $userName = null)
    {
        return $this->update($id, [
            'is_delete' => 1,
            'is_delete_at' => date('Y-m-d H:i:s'),
            'is_delete_by_id' => $userId,
            'is_delete_by_name' => $userName
        ]);
    }

    // ✅ Fungsi restore
    public function restoreBanner($id)
    {
        return $this->update($id, [
            'is_delete' => 0,
            'is_delete_at' => null,
            'is_delete_by_id' => null,
            'is_delete_by_name' => null
        ]);
    }
}
