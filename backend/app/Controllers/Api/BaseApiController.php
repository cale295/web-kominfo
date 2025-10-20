<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\HakAksesModel;

/**
 * Controller Dasar untuk semua endpoint API yang memerlukan otentikasi/otorisasi.
 * Mewarisi dari ResourceController untuk kemudahan penggunaan $routes->resource().
 */
class BaseApiController extends ResourceController
{
    // Menggunakan ResponseTrait untuk method seperti failNotFound, failForbidden, dll.
    use ResponseTrait;

    protected $hakAksesModel;

    public function __construct()
    {
        // Inisialisasi Model Hak Akses
        $this->hakAksesModel = new HakAksesModel();
    }
    
    /**
     * Helper untuk memverifikasi izin pengguna.
     * * PENTING: Untuk sementara, role diambil dari Header Kustom 'X-User-Role'.
     * Metode ini HARUS diganti dengan pengambilan role dari Token JWT saat deploy.
     * * @param string $permissionColumn Nama kolom izin (e.g., 'bisa_buat', 'bisa_hapus')
     * @param string $module Nama modul di t_hak_akses (e.g., 'Berita', 'GaleriFoto')
     * @return bool|\CodeIgniter\HTTP\Response True jika diizinkan, atau Response 403 jika ditolak.
     */
    protected function verifyIzin(string $permissionColumn, string $module)
    {
        // ====================================================================
        // 1. Ambil Role Pengguna dari Header Kustom (SOLUSI SEMENTARA TANPA JWT)
        // ====================================================================
        $userRole = $this->request->getHeaderLine('X-User-Role');
        
        // Jika header kosong atau tidak ada, asumsikan 'guest'
        if (empty($userRole)) {
            $userRole = 'guest'; 
            
            // Catatan: Jika Anda ingin menolak akses guest sepenuhnya tanpa pengecekan
            // di t_hak_akses, Anda bisa mengaktifkan baris ini:
            // return $this->failUnauthorized('Akses Ditolak. Harap kirimkan Role di Header X-User-Role.');
        }
        
        // ====================================================================
        // 2. Ambil Izin dari Database
        // ====================================================================
        $izin = $this->hakAksesModel->getIzin($userRole, $module);

        // ====================================================================
        // 3. Cek Penegakan Izin
        // ====================================================================
        
        // Cek: Apakah tidak ada aturan untuk role/modul tersebut, ATAU izin spesifiknya BUKAN true
        if (!$izin || !isset($izin[$permissionColumn]) || $izin[$permissionColumn] !== true) {
            
            // KIRIM RESPONSE 403 FORBIDDEN
            return $this->failForbidden('Akses Ditolak. Anda tidak memiliki izin (' . $permissionColumn . ') di modul ' . $module . '. (Role: ' . $userRole . ')');
        }

        return true; // Diizinkan
    }
}