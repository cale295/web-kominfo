<?php

namespace App\Controllers\frontend;

use App\Models\frontend\ProgramModel;
use App\Models\AccessRightsModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ProgramController extends BaseController
{
    protected $programModel;
    protected $accessRightsModel;

    protected $module = 'program';

    public function __construct()
    {
        $this->programModel = new ProgramModel();
        $this->accessRightsModel = new AccessRightsModel();
    }
         private function getAccess($role)
    {
        $access = $this->accessRightsModel->where('role', $role)->where('module_name', $this->module)->first();
        if (!$access) return ['can_create'=>false,'can_read'=>false,'can_update'=>false,'can_delete'=>false];
        return [
            'can_create' => (bool)$access['can_create'],
            'can_read' => (bool)$access['can_read'],
            'can_update' => (bool)$access['can_update'],
            'can_delete' => (bool)$access['can_delete'],
        ];
    }
    public function index()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat berita.');
        }        $role = session()->get('role');
        $access = $this->getAccess($role);

        if (!$access) {
            return view('pages/program/index', [
                'Program' => [],
                'error'   => '⚠ Kamu tidak memiliki hak akses ke modul ini.'
            ]);
        }

        if (!$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat agenda.');
        }

        $menu_profiles = $this->programModel->orderBy('created_at', 'DESC')->findAll();

        $data = [
            'menu_profiles'    => $menu_profiles,
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ];

        return view('pages/program/index', $data);
    }

    public function toggleStatus()
    {
        // 1. Cek Request AJAX
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // 2. CEK HAK AKSES
        // Pastikan Controller punya property $this->accessRightsModel & fungsi getAccess()
        $role = session()->get('role');
        $access = $this->getAccess($role);

        if (!$access || !$access['can_update']) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Anda tidak memiliki izin untuk mengubah data ini.',
                'token' => csrf_hash()
            ]);
        }

        // 3. LOAD MODEL & AMBIL DATA
        // ==================================================
        $model = new \App\Models\frontend\ProgramModel(); // <--- GANTI INI SESUAI MODUL
        // ==================================================

        $id = $this->request->getPost('id');
        $data = $model->find($id);

        if ($data) {
            // Logic Toggle (1 -> 0, 0 -> 1)
            $newStatus = ($data['is_active'] == '1') ? '0' : '1';

            // Data Update (Termasuk Audit Trail)
            $updateData = [
                'is_active'            => $newStatus,
                'updated_at'        => date('Y-m-d H:i:s'),
                'updated_by_id'     => session()->get('id_user'),
                'updated_by_name'   => session()->get('username'),
            ];

            if ($model->update($id, $updateData)) {
                return $this->response->setJSON([
                    'status'    => 'success',
                    'message'   => 'Status berhasil diperbarui',
                    'newStatus' => $newStatus,
                    'token'     => csrf_hash() // Kirim token baru
                ]);
            }
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Gagal update status atau data tidak ditemukan',
            'token'   => csrf_hash()
        ]);
    }
    public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/menu_profile')->with('error', 'Kamu tidak punya izin menambah menu_profile.');
        }
        return view('pages/program/create');
    }

public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/program')->with('error', 'Kamu tidak punya izin menambah program.');
        }

        $data = [
            'nama_program'   => $this->request->getPost('nama_program'),
            'nama_kegiatan'  => $this->request->getPost('nama_kegiatan'),
            'nilai_anggaran' => $this->request->getPost('nilai_anggaran'),
            'tahun'          => $this->request->getPost('tahun'),
            'slug'           => url_title($this->request->getPost('nama_program'), '-', true),
            'sorting'        => $this->request->getPost('sorting'),
            'is_active'      => $this->request->getPost('is_active'),
            'hash'           => $this->request->getPost('hash'),
            // Set default null agar tidak error jika tidak ada file
            'file_lampiran'  => null, 
        ];

        // AMBIL FILE TAPI JANGAN DIPAKSA ERROR
        $file = $this->request->getFile('file_lampiran');

        // Cek: Apakah file ada DAN valid DAN belum dipindahkan?
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $original = $file->getName();
            $newName  = time() . '-' . $original;

            $file->move('uploads/program', $newName);

            // Jika file berhasil diupload, update array data
            $data['file_lampiran'] = 'uploads/program/' . $newName;
        } 
        // Jika tidak ada file, kode akan lanjut dengan $data['file_lampiran'] = null

        if (!$this->programModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->programModel->errors());
        }
        
        return redirect()->to('/program')->with('success', 'Data program berhasil ditambahkan.');
    }
    // ... (Kode sebelumnya: __construct, getAccess, index, new, create)

    public function edit($id)
    {
        // 1. Cek Hak Akses
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/program')->with('error', 'Kamu tidak punya izin mengedit program.');
        }

        // 2. Ambil data
        $program = $this->programModel->find($id);

        if (!$program) {
            return redirect()->to('/program')->with('error', 'Data program tidak ditemukan.');
        }

        // 3. Tampilkan view
        return view('pages/program/edit', [
            'program' => $program
        ]);
    }

    public function update($id)
    {
        // 1. Cek Hak Akses
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/program')->with('error', 'Kamu tidak punya izin mengupdate program.');
        }

        // 2. Cek Data Lama
        $programLama = $this->programModel->find($id);
        if (!$programLama) {
            return redirect()->to('/program')->with('error', 'Data tidak ditemukan.');
        }

        // 3. Siapkan Data Update
        $data = [
            'nama_program'   => $this->request->getPost('nama_program'),
            'nama_kegiatan'  => $this->request->getPost('nama_kegiatan'),
            'nilai_anggaran' => $this->request->getPost('nilai_anggaran'),
            'tahun'          => $this->request->getPost('tahun'),
            // Update slug jika nama program berubah
            'slug'           => url_title($this->request->getPost('nama_program'), '-', true),
            'sorting'        => $this->request->getPost('sorting'),
            // Handle checkbox: jika tidak dicentang nilainya null, jadi kita set ke 0
        ];

        // 4. Logika Update File Lampiran
        $file = $this->request->getFile('file_lampiran');

        // Cek apakah ada file baru yang diupload valid
        if ($file && $file->isValid() && !$file->hasMoved()) {
            
            // a. Upload file baru
            $originalName = $file->getName();
            $newName      = time() . '-' . $originalName;
            $file->move('uploads/program', $newName);
            
            // Simpan path baru ke array data
            $data['file_lampiran'] = 'uploads/program/' . $newName;

            // b. Hapus file lama fisik (jika ada)
            // Cek apakah path file lama ada di database dan filenya ada di server
            if (!empty($programLama['file_lampiran']) && file_exists($programLama['file_lampiran'])) {
                unlink($programLama['file_lampiran']);
            }
        }

        // 5. Eksekusi Update ke Database
        if (!$this->programModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->programModel->errors());
        }

        return redirect()->to('/program')->with('success', 'Data program berhasil diperbarui.');
    }

    public function delete($id)
    {
        // 1. Cek Hak Akses
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) {
            return redirect()->to('/program')->with('error', 'Kamu tidak punya izin menghapus program.');
        }

        // 2. Ambil data untuk mendapatkan path file
        $program = $this->programModel->find($id);
        if (!$program) {
            return redirect()->to('/program')->with('error', 'Data tidak ditemukan.');
        }

        // 3. Hapus File Fisik Lampiran
        if (!empty($program['file_lampiran']) && file_exists($program['file_lampiran'])) {
            unlink($program['file_lampiran']);
        }

        // 4. Hapus Data dari Database
        $this->programModel->delete($id);

        return redirect()->to('/program')->with('success', 'Data program berhasil dihapus.');
    }
}
