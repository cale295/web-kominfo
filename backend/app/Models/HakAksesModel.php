<?php

namespace App\Models;

use CodeIgniter\Model;

class HakAksesModel extends Model
{
    protected $table          = 't_hak_akses';
    protected $primaryKey     = 'id_hak_akses';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields  = true;

    // Kolom yang Diizinkan untuk Diisi (Harus sesuai dengan Migrasi Anda)
    protected $allowedFields  = [
        'role', 
        'nama_modul', 
        'bisa_buat', 
        'bisa_baca', 
        'bisa_ubah', 
        'bisa_hapus',
        'bisa_publikasi'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Validation (Dikosongkan karena validasi utama ada di sisi Controller Admin)
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // =========================================================================
    // METODE INTI UNTUK KEAMANAN (BACKEND ENFORCEMENT)
    // =========================================================================

    /**
     * Mengambil izin spesifik untuk satu aksi di satu modul.
     * Digunakan di Controller API untuk mengecek izin sebelum CRUD.
     * * @param string $role   Contoh: 'admin'
     * @param string $module Contoh: 'Berita'
     * @return array|null Mengembalikan data izin untuk kombinasi role/modul tersebut, atau null.
     */
    public function getIzin(string $role, string $module) : ?array
    {
        return $this->where(['role' => $role, 'nama_modul' => $module])->first();
    }
    
    // =========================================================================
    // METODE UNTUK OPTIMASI & FRONTEND (UI/MENU)
    // =========================================================================

    /**
     * Mengambil SEMUA izin pengguna di SEMUA modul.
     * Berguna saat login untuk dikirimkan ke frontend (untuk render menu/tombol kondisional).
     *
     * @param string $role
     * @return array Mengembalikan array data dari t_hak_akses yang terkait dengan role tersebut.
     */
    public function getAllIzinByRole(string $role): array
    {
        return $this->where('role', $role)->findAll();
    }
}