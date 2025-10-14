<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaModel extends Model
{
    protected $table            = 't_berita';
    protected $primaryKey       = 'id_berita';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    // Aktifkan Timestamps agar created_at dan updated_at terisi otomatis
    protected $useTimestamps    = true; 
    protected $dateFormat       = 'datetime';
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    protected $deletedField     = 'deleted_at'; // Hanya jika useSoftDeletes diaktifkan

    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    
    protected $allowedFields    = ['id_kategori', 'id_pengguna', 'judul', 'slug', 'isi', 'gambar', 'status', 'jumlah_pembaca'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Tambahkan Aturan Validasi untuk kolom wajib (Wajib!)
    protected $validationRules = [
        'id_kategori'   => 'required|integer',
        'id_pengguna'   => 'required|integer',
        'judul'         => 'required|min_length[5]|max_length[255]',
        'slug'          => 'required|is_unique[tabel_berita.slug,id_berita,{id_berita}]', // Cek unik saat buat/edit
        'isi'           => 'required',
        'status'        => 'required|in_list[draft,published,archived]',
    ];

    protected $validationMessages = [
        'judul' => [
            'required' => 'Judul berita wajib diisi.',
            'min_length' => 'Judul minimal 5 karakter.',
        ],
        'slug' => [
            'required' => 'Slug wajib diisi.',
            'is_unique' => 'Slug sudah digunakan, coba ubah sedikit.',
        ],
        'id_kategori' => [
            'required' => 'Kategori wajib dipilih.',
        ],
        
    ];

    // Sisanya biarkan default
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
    protected $allowCallbacks       = true;

}