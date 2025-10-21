<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaModel extends Model
{
    protected $table            = 't_berita';
    protected $primaryKey       = 'id_berita';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    // Kolom yang boleh diisi (disamakan dengan struktur tabel)
    protected $allowedFields    = [
        'id_tema',
        'judul',
        'isi_berita',
        'id_kategori',
        'id_user',
        'tanggal_publikasi',
        'status',
        'jumlah_pembaca',
        'berita_sisipan',
        'written_by',
        'sumber',
        'id_tag',
        'featured_image',
        'galeri_foto'
    ];

    protected $useTimestamps    = false; // Tidak ada kolom created_at/updated_at
    protected $dateFormat       = 'datetime';

    // Validasi dasar
    protected $validationRules = [
        'judul'             => 'required|min_length[5]|max_length[255]',
        'isi_berita'        => 'required',
        'status'            => 'required|in_list[Publish,Draf,Unpublished]',
        'id_user'           => 'required|integer',
        'id_kategori'       => 'permit_empty|integer',
        'id_tema'           => 'permit_empty|integer',
        'id_tag'            => 'permit_empty|integer',
        'jumlah_pembaca'    => 'permit_empty|integer',
    ];

    protected $validationMessages = [
        'judul' => [
            'required' => 'Judul berita wajib diisi.',
            'min_length' => 'Judul minimal 5 karakter.',
        ],
        'isi_berita' => [
            'required' => 'Isi berita wajib diisi.',
        ],
        'status' => [
            'required' => 'Status wajib diisi (Publish / Draf / Unpublished).',
            'in_list' => 'Status tidak valid.',
        ],
    ];

    protected bool $skipValidation       = false;
    protected bool $cleanValidationRules = true;
}

