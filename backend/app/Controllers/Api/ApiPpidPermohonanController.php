<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\frontend\PpidPermohonanModel;

class ApiPpidPermohonanController extends ResourceController
{
    protected $modelName = PpidPermohonanModel::class;
    protected $format    = 'json';

    public function create()
    {
        $request = $this->request;

        // 1. Ambil Data (Support JSON Raw & Form Data)
        // Jika request adalah JSON, ambil body JSON. Jika bukan, ambil $_POST biasa.
        if ($request->getHeaderLine('Content-Type') === 'application/json') {
            $input = $request->getJSON(true); // true = array associative
        } else {
            $input = $request->getVar(); // fallback ke form-data biasa
        }

        // Cek jika input kosong
        if (!$input) {
            return $this->fail(['message' => 'Data JSON tidak terbaca atau kosong'], 400);
        }

        // 2. Generate ID Unik
        $uniqueId = $this->generateUniqueId();

        // 3. Mapping Data (Gunakan Null Coalescing '??' biar gak error undefined index)
        $data = [
            'id_formulir'               => $uniqueId,
            'nik'                       => $input['nik'] ?? '',
            'nama'                      => $input['nama'] ?? '',
            'no_telepon'                => $input['no_telepon'] ?? '',
            'email'                     => $input['email'] ?? '',
            'alamat'                    => $input['alamat'] ?? '',
            'pekerjaan'                 => $input['pekerjaan'] ?? '',
            'cara_memperoleh_informasi' => $input['cara_memperoleh_informasi'] ?? '',
            'cara_mendapatkan_salinan'  => $input['cara_mendapatkan_salinan'] ?? '',
            'rincian_informasi'         => $input['rincian_informasi'] ?? '',
            'tujuan_penggunaan'         => $input['tujuan_penggunaan'] ?? '',
            'pemohon_informasi'         => $input['pemohon_informasi'] ?? '',
            'status'                    => 'pending',
            'tanggal_permohonan'        => date('Y-m-d H:i:s')
        ];

        // 4. Insert dengan Model
        // Model akan otomatis menjalankan validasi jika disetting di Model file
        if ($this->model->insert($data)) {
            return $this->respondCreated([
                'status'    => 201,
                'message'   => 'Permohonan berhasil dikirim.',
                'ticket_id' => $uniqueId,
                'data'      => $data
            ]);
        } else {
            // PENTING: Kembalikan pesan error validasi agar React tahu salahnya dimana
            return $this->fail([
                'status' => 400,
                'message' => 'Validasi Gagal',
                'errors' => $this->model->errors() 
            ], 400);
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