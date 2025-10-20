<?php

namespace App\Controllers\Api;

use App\Models\GaleriFotoModel;
use App\Models\HakAksesModel; // <-- TAMBAHAN: Import Model Hak Akses
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait; // <-- TAMBAHAN: Untuk menggunakan failForbidden
/**
 * @property \CodeIgniter\HTTP\IncomingRequest $request
 */
class GaleriFotoController extends ResourceController
{
    use ResponseTrait; // <-- Diperlukan untuk ResponseTrait, meskipun ResourceController juga memilikinya.

    protected $modelName = GaleriFotoModel::class;
    protected $format = 'json';
    protected $hakAksesModel;

    public function __construct()
    {
        // INISIALISASI MODEL HAK AKSES
        $this->hakAksesModel = new HakAksesModel();
    }
    
    /**
     * Helper untuk memverifikasi izin pengguna.
     * @param string $permissionColumn Nama kolom izin (e.g., 'bisa_buat')
     * @return bool|object True jika diizinkan, atau Response 403 jika ditolak.
     */
    private function verifyIzin(string $permissionColumn, string $module = 'GaleriFoto')
    {
        // Ganti dengan cara Anda mendapatkan role pengguna
        $userRole = $this->request->userRole ?? 'guest'; 

        $izin = $this->hakAksesModel->getIzin($userRole, $module);

        // Cek: Jika tidak ada aturan (null) atau izin spesifiknya BUKAN true
        if (!$izin || $izin[$permissionColumn] !== true) {
            // KIRIM RESPONSE 403 FORBIDDEN
            return $this->failForbidden('Akses Ditolak. Anda tidak memiliki izin (' . $permissionColumn . ') di modul ' . $module . '.');
        }

        return true; // Diizinkan
    }
    
    // ==========================================================
    // METHOD DENGAN PENERAPAN HAK AKSES
    // ==========================================================

    public function index()
    {
        // index (GET) biasanya hanya memerlukan izin BACA (bisa_baca)
        $izin = $this->verifyIzin('bisa_baca');
        if ($izin !== true) {
            return $izin; 
        }
        
        return $this->respond($this->model->findAll());
    }

    public function show($id = null)
    {
        // show (GET by ID) juga memerlukan izin BACA (bisa_baca)
        $izin = $this->verifyIzin('bisa_baca');
        if ($izin !== true) {
            return $izin; 
        }
        
        // Ganti nama variabel dari $user menjadi $foto agar lebih sesuai konteks
        $foto = $this->model->find($id); 

        if (!$foto) {
            return $this->failNotFound('Foto tidak ditemukan');
        }

        return $this->respond($foto);
    }

    public function create()
    {
        // HAK AKSES WAJIB: create memerlukan izin 'bisa_buat'
        $izin = $this->verifyIzin('bisa_buat');
        if ($izin !== true) {
            return $izin; // Tolak dengan 403 Forbidden
        }
        
        // GANTI: Gunakan getJSON(true) untuk mengambil body JSON dan langsung mengubahnya ke array PHP.
        $data = $this->request->getJSON(true) ?? []; 
        // BARIS getRawInput() dan json_decode() DIHILANGKAN

        if ($this->model->insert($data) === false) {
            return $this->fail($this->model->errors(), 400);
        }

        return $this->respondCreated($data, 'berhasil ditambahkan');
    }

    public function update($id = null)
    {
        // HAK AKSES WAJIB: update memerlukan izin 'bisa_ubah'
        $izin = $this->verifyIzin('bisa_ubah');
        if ($izin !== true) {
            return $izin; // Tolak dengan 403 Forbidden
        }

        // GANTI: Gunakan getJSON(true)
        $data = $this->request->getJSON(true) ?? []; 
        // BARIS getRawInput() dan json_decode() DIHILANGKAN

        if (!$this->model->update($id, $data)) {
            return $this->fail($this->model->errors(), 400);
        }

        return $this->respondUpdated($data);
    }

    public function delete($id = null)
    {
        // HAK AKSES WAJIB: delete memerlukan izin 'bisa_hapus'
        $izin = $this->verifyIzin('bisa_hapus');
        if ($izin !== true) {
            return $izin; // Tolak dengan 403 Forbidden
        }
        
        if (!$this->model->find($id)) {
            // Ganti 'User' dengan 'Foto' agar sesuai konteks
            return $this->failNotFound('Foto dengan id ' . $id . ' tidak ditemukan');
        }

        $this->model->delete($id);
        return $this->respondDeleted(['id' => $id, 'message' => 'berhasil dihapus']);
    }
}