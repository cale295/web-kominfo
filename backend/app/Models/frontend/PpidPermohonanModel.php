<?php

namespace App\Models\frontend;

use CodeIgniter\Model;

class PpidPermohonanModel extends Model
{
    protected $table            = 't_ppid_formulir_permohonan';
    protected $primaryKey       = 'id_formulir';
    
    // ⚠️ PENTING: Matikan Auto Increment agar kita bisa isi ID manual (8 angka)
    protected $useAutoIncrement = false; 
    
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields    = [
        'id_formulir', // ✅ Tambahkan ini agar bisa di-insert manual
        'nik',
        'nama',
        'no_telepon',
        'email',
        'alamat',
        'pekerjaan',
        'cara_memperoleh_informasi',
        'cara_mendapatkan_salinan',
        'rincian_informasi',
        'tujuan_penggunaan',
        'pemohon_informasi',
        'status', 
        'tanggal_permohonan',
        'tanggal_diproses',
        'created_at',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation Rules
    protected $validationRules = [
        // id_formulir wajib unik
        'id_formulir' => [
            'rules' => 'required|is_unique[t_ppid_formulir_permohonan.id_formulir]',
            'label' => 'ID Formulir'
        ],
        'nik' => [
            'rules' => 'required|numeric|min_length[16]|max_length[16]',
            'label' => 'NIK'
        ],
        'nama' => [
            'rules' => 'required|max_length[255]',
            'label' => 'Nama Lengkap'
        ],
        'email' => [
            'rules' => 'required|valid_email|max_length[100]',
            'label' => 'Email'
        ],
        'no_telepon' => [
            'rules' => 'required|numeric|max_length[20]',
            'label' => 'No Telepon'
        ],
        'rincian_informasi' => [
            'rules' => 'required',
            'label' => 'Rincian Informasi'
        ],
        'tujuan_penggunaan' => [
            'rules' => 'required',
            'label' => 'Tujuan Penggunaan'
        ],
        'cara_memperoleh_informasi' => [
            'rules' => 'required|in_list[Melihat/Membaca/Mendengarkan/Mencatat,Hardcopy,Softcopy]',
            'label' => 'Cara Memperoleh'
        ],
        'pemohon_informasi' => [
            'rules' => 'required|in_list[Perorangan,Kelompok,Badan Hukum,Organisasi Berbadan Hukum,Organisasi Tanpa Badan Hukum]',
            'label' => 'Kategori Pemohon'
        ]
    ];
}