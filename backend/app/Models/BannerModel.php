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
     protected $validationRules = [
    'title'         => 'required|min_length[3]|max_length[255]',
    'status'        => 'required|in_list[0,1]',
    'media_type'    => 'required|in_list[image,video]',
    'url'           => 'required',
    'keterangan'    => 'required|min_length[3]|string|max_length[255]',
    'url_yt'        => 'required|valid_url',
    'sorting'       => 'required|integer',
    'category_banner' => 'required|string|max_length[100]',
    ];


    protected $validationMessages = [
    'title' => [
        'required'    => 'Judul banner wajib diisi.',
        'min_length'  => 'Judul minimal 3 karakter.',
        'max_length'  => 'Judul maksimal 255 karakter.',
    ],
    'status' => [
        'required' => 'Status wajib diisi.',
        'in_list'  => 'Status harus 0 (nonaktif) atau 1 (aktif).',
    ],
    'keterangan' => [
        'required' => 'Keterangan wajib diisi.',
        'min_length' => 'Keterangan minimal 3 karakter.',
        'max_length' => 'Keterangan maksimal 255 karakter.',
    ],
    'url' => [
        'valid_url' => 'URL tidak valid.',
    ],
    'url_yt' => [
        'valid_url' => 'URL YouTube tidak valid.',
    ],
    ];

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
