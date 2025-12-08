<?php

namespace App\Controllers\frontend;

use App\Models\AccessRightsModel;
use App\Models\frontend\KontakModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class KontakController extends BaseController
{
    protected $kontakModel;
    protected $accessRightsModel;

    protected $module = 'Kontak';
    public function __construct()
    {
        $this->kontakModel = new KontakModel();
        $this->accessRightsModel = new AccessRightsModel();
    }

        private function getAccess($role)
    {
        $access = $this->accessRightsModel->where('role', $role)->where('module_name', $this->module)->first();
        if (!$access)
            return ['can_create' => false, 'can_read' => false, 'can_update' => false, 'can_delete' => false];
        return [
            'can_create' => (bool) $access['can_create'],
            'can_read' => (bool) $access['can_read'],
            'can_update' => (bool) $access['can_update'],
            'can_delete' => (bool) $access['can_delete'],
        ];
    }
  public function index()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat berita.');
        }
        $role = session()->get('role');
        $access = $this->getAccess($role);

        if (!$access) {
            return view('pages/kontak/index', [
                'kontak' => [],
                'error' => '⚠ Kamu tidak memiliki hak akses ke modul ini.'
            ]);
        }

        if (!$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat agenda.');
        }

        $kontak = $this->kontakModel->orderBy('created_at', 'DESC')->findAll();

        $data = [
            'kontak' => $kontak,
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ];

        return view('pages/kontak/index', $data);
    }

        public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/kontak')->with('error', 'Kamu tidak punya izin menambah kontak.');
        }
        $countdata = $this->kontakModel->countAllResults();
        if ($countdata > 0) {
            return redirect()->to('/kontak')->with('error', 'Maksimal Data Kontak 1.');
        }
        return view('pages/kontak/create');

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
        $model = new \App\Models\frontend\KontakModel(); // <--- GANTI INI SESUAI MODUL
        // ==================================================

        $id = $this->request->getPost('id');
        $data = $model->find($id);

        if ($data) {
            // Logic Toggle (1 -> 0, 0 -> 1)
            $newStatus = ($data['status'] == '1') ? '0' : '1';

            // Data Update (Termasuk Audit Trail)
            $updateData = [
                'status'            => $newStatus,
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


        public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/kontak')->with('error', 'Kamu tidak punya izin menambah menu_profile.');
        }
        $data = [
            'nama_instansi' => $this->request->getPost('nama_instansi'),
            'alamat_lengkap' => $this->request->getPost('alamat_lengkap'),
            'telepon' => $this->request->getPost('telepon'),
            'fax' => $this->request->getPost('fax'),
            'map_link' => $this->request->getPost('map_link'),
            'status' => $this->request->getPost('status'),
        ];
        if (!$this->kontakModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->kontakModel->errors());
        }
        return redirect()->to('/kontak')->with('success', 'kkontak berhasil ditambahkan.');
    }

    public function edit($id)
    {
        // 1. Cek Hak Akses
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/kontak')->with('error', 'Kamu tidak punya izin mengubah data kontak.');
        }

        // 2. Ambil data
        $kontak = $this->kontakModel->find($id);

        if (!$kontak) {
            return redirect()->to('/kontak')->with('error', 'Data kontak tidak ditemukan.');
        }

        // 3. Tampilkan view
        return view('pages/kontak/edit', [
            'kontak' => $kontak
        ]);
    }

    public function update($id)
    {
        // 1. Cek Hak Akses
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/kontak')->with('error', 'Kamu tidak punya izin mengubah data kontak.');
        }

        // 2. Cek keberadaan data
        $existingData = $this->kontakModel->find($id);
        if (!$existingData) {
            return redirect()->to('/kontak')->with('error', 'Data tidak ditemukan.');
        }

        // 3. Siapkan data update (Tanpa Foto)
        $data = [
            'nama_instansi'  => $this->request->getPost('nama_instansi'),
            'alamat_lengkap' => $this->request->getPost('alamat_lengkap'),
            'telepon'        => $this->request->getPost('telepon'),
            'fax'            => $this->request->getPost('fax'),
            'map_link'       => $this->request->getPost('map_link'),
            'status'         => $this->request->getPost('status'),
        ];

        // 4. Proses Update ke Database
        if (!$this->kontakModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->kontakModel->errors());
        }

        return redirect()->to('/kontak')->with('success', 'Data kontak berhasil diperbarui.');
    }

    public function delete($id)
    {
        // 1. Cek Hak Akses
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) {
            return redirect()->to('/kontak')->with('error', 'Kamu tidak punya izin menghapus data kontak.');
        }

        // 2. Cek keberadaan data
        $data = $this->kontakModel->find($id);
        if (!$data) {
            return redirect()->to('/kontak')->with('error', 'Data tidak ditemukan.');
        }

        // 3. Hapus data dari database (Tanpa hapus file fisik karena tidak ada foto)
        $this->kontakModel->delete($id);

        return redirect()->to('/kontak')->with('success', 'Data kontak berhasil dihapus.');
    }
}
