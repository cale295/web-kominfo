<?php

namespace App\Controllers\Api\Admin;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\HakAksesModel;
/**
 * @property \CodeIgniter\HTTP\IncomingRequest $request
 */
class HakAksesControll extends ResourceController
{
    use ResponseTrait;

    protected $modelName = 'App\Models\HakAksesModel';
    protected $format    = 'json';
    
    // Perbaikan DocBlock untuk membantu linter mengidentifikasi properti request (Opsional)
    /**
     * @var \CodeIgniter\HTTP\Request $request
     */

    // ... (Metode index() dan show() dihilangkan untuk fokus pada error)

    /**
     * Membuat aturan hak akses baru (POST /api/admin/hakakses)
     */
    public function create()
    {
        // FIX UNTUK ERROR INTELEPHENSE: Mengakses getJSON melalui $this->request
        $data = $this->request->getJSON(true);

        // 1. Tambahkan Validasi Khusus untuk Hak Akses
        if (!$this->validate([
            'role' => 'required|max_length[50]',
            'nama_modul' => 'required|max_length[50]',
        ])) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        // 2. Cek duplikasi manual 
        $existing = $this->model->getIzin($data['role'], $data['nama_modul']);
        if ($existing) {
             // FIX UNTUK failConflict(): Diganti dengan fail() dan HTTP 409
             return $this->fail('Aturan hak akses untuk Role dan Modul ini sudah ada. Gunakan PUT untuk mengubah.', 409);
        }

        // 3. Simpan data
        if ($this->model->save($data) === false) {
             return $this->failServerError('Gagal menyimpan aturan hak akses.');
        }

        return $this->respondCreated(['message' => 'Aturan hak akses berhasil ditambahkan.']);
    }

    // ... (Metode update() dan delete() dihilangkan untuk fokus pada error)
    
    // ... (Metode getUserPermissions() di sini)
}