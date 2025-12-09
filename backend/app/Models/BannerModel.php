<?php

namespace App\Models;

use CodeIgniter\Model;

class BannerModel extends Model
{
    protected $table = 'm_banner';
    protected $primaryKey = 'id_banner';

    protected $allowedFields = [
        'title', 'status', 'image', 'media_type', 'url', 'url_yt',
        'sorting', 'keterangan', 'category_banner',
        'created_at', 'created_by_id', 'created_by_name',
        'updated_at', 'updated_by_id', 'updated_by_name',
        'is_delete', 'is_delete_at', 'is_delete_by_id', 'is_delete_by_name',
    ];

    // --- PERUBAHAN DI SINI ---
    protected $validationRules = [
        'title'           => 'required|min_length[3]|max_length[255]',
        'status'          => 'required|in_list[0,1]',
        'media_type'      => 'required|in_list[image,video]',
        
        // UBAH JADI permit_empty (Opsional secara default)
        'url'             => 'permit_empty|valid_url', 
        
        // UBAH JADI permit_empty (Akan diperketat di Controller jika Video)
        'url_yt'          => 'permit_empty|valid_url', 
        
        'keterangan'      => 'permit_empty|string|max_length[255]',
        'sorting'         => 'required|integer',
        'category_banner' => 'required|string|max_length[100]',
    ];

    protected $validationMessages = [
        'title' => [
            'required'    => 'Judul banner wajib diisi.',
            'min_length'  => 'Judul minimal 3 karakter.',
        ],
        'url' => [
            'valid_url' => 'Format URL Tujuan tidak valid (Gunakan http/https).',
        ],
        'url_yt' => [
            'required'  => 'Link Youtube WAJIB diisi jika memilih tipe Video.', // Pesan Custom
            'valid_url' => 'Link Youtube tidak valid.',
        ],
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // ... (Sisa fungsi delete/restore biarkan sama) ...
}