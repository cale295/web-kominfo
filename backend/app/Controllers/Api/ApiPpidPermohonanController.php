<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\frontend\PpidPermohonanModel;

class ApiPpidPermohonanController extends ResourceController
{
    protected $modelName = PpidPermohonanModel::class;
    protected $format    = 'json';

    /**
     * Create: Endpoint untuk Masyarakat mengajukan permohonan
     * Method: POST /api/ppid_permohonan
     */
    public function create()
    {
        // 🔹 TAMBAHKAN INI AGAR EDITOR TIDAK ERROR "Undefined method getVar"
        /** @var \CodeIgniter\HTTP\IncomingRequest $request */
        $request = $this->request;

        // 1. Generate ID Unik 8 Digit
        $uniqueId = $this->generateUniqueId();

        // 2. Ambil data dari JSON Body atau Form Data menggunakan variable $request
        $data = [
            'id_formulir'               => $uniqueId,
            'nik'                       => $request->getVar('nik'),
            'nama'                      => $request->getVar('nama'),
            'no_telepon'                => $request->getVar('no_telepon'),
            'email'                     => $request->getVar('email'),
            'alamat'                    => $request->getVar('alamat'),
            'pekerjaan'                 => $request->getVar('pekerjaan'),
            'cara_memperoleh_informasi' => $request->getVar('cara_memperoleh_informasi'),
            'cara_mendapatkan_salinan'  => $request->getVar('cara_mendapatkan_salinan'),
            'rincian_informasi'         => $request->getVar('rincian_informasi'),
            'tujuan_penggunaan'         => $request->getVar('tujuan_penggunaan'),
            'pemohon_informasi'         => $request->getVar('pemohon_informasi'),
            'status'                    => 'pending', 
            'tanggal_permohonan'        => date('Y-m-d H:i:s')
        ];

        // 3. Validasi dan Insert via Model
        if ($this->model->insert($data)) {
            return $this->respondCreated([
                'status'    => 201,
                'message'   => 'Permohonan berhasil dikirim.',
                'ticket_id' => $uniqueId, // ID ini digunakan user untuk cek status
                'data'      => $data
            ]);
        } else {
            return $this->fail($this->model->errors());
        }
    }

    /**
     * Fungsi Helper: Generate 8 angka unik
     */
    private function generateUniqueId()
    {
        do {
            // Generate angka acak 8 digit
            $id = mt_rand(10000000, 99999999);
            
            // Cek apakah ID sudah ada di database
            $exists = $this->model->where('id_formulir', $id)->countAllResults();
        } while ($exists > 0);

        return $id;
    }

    /**
     * Check Status: Endpoint untuk mengecek status permohonan
     * Method: GET /api/ppid_permohonan/status/{id_formulir}
     */
    public function checkStatus($id = null)
    {
        if (!$id) {
            return $this->failNotFound('ID Formulir wajib diisi.');
        }

        $data = $this->model->select('id_formulir, nama, status, tanggal_permohonan, tanggal_diproses')->find($id);

        if ($data) {
            return $this->respond([
                'status'  => 200,
                'message' => 'Data ditemukan.',
                'data'    => $data
            ]);
        } else {
            return $this->failNotFound('Permohonan dengan ID ' . $id . ' tidak ditemukan.');
        }
    }
}