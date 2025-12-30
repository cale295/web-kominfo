<?php

namespace App\Controllers\frontend;

use App\Models\frontend\KontakSocialModel;
use App\Models\AccessRightsModel;
use App\Controllers\BaseController;

class KontakSocialController extends BaseController
{
    protected $kontakSocialModel;
    protected $accessRightsModel;
    protected $module = 'Kontak_Social';

    public function __construct()
    {
        $this->kontakSocialModel = new KontakSocialModel();
        $this->accessRightsModel = new AccessRightsModel();
    }

    private function getAccess($role)
    {
        $access = $this->accessRightsModel->where('role', $role)->where('module_name', $this->module)->first();
        if (!$access)
            return ['can_create' => false, 'can_read' => false, 'can_update' => false, 'can_delete' => false];
        return [
            'can_create' => (bool) $access['can_create'],
            'can_read'   => (bool) $access['can_read'],
            'can_update' => (bool) $access['can_update'],
            'can_delete' => (bool) $access['can_delete'],
        ];
    }

    public function index()
    {
        $access = $this->getAccess(session()->get('role'));
        
        // Cek permission read
        if (!$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat data ini.');
        }

        $kontak_social = $this->kontakSocialModel->orderBy('created_at', 'DESC')->findAll();

        $data = [
            'kontak_social' => $kontak_social,
            'can_create'    => $access['can_create'],
            'can_update'    => $access['can_update'],
            'can_delete'    => $access['can_delete'],
        ];

        return view('pages/kontak_social/index', $data);
    }

    public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_create']) {
            return redirect()->to('/kontak_social')->with('error', 'Kamu tidak punya izin menambah data.');
        }
        $countdata = $this->kontakSocialModel->countAllResults();
        if ($countdata > 3) {
            return redirect()->to('/kontak_social')->with('error', 'Maksimal Data Kontak Social 4.');
        }
        return view('pages/kontak_social/create');
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
        $model = new \App\Models\frontend\KontakSocialModel(); // <--- GANTI INI SESUAI MODUL
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
    // =========================================================
    // CREATE PROCESS
    // =========================================================
    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_create']) {
            return redirect()->to('/kontak_social')->with('error', 'Kamu tidak punya izin menambah data.');
        }
        // Ambil data dari form
        $data = [
            'platform'   => $this->request->getPost('platform'),
            'icon_class' => $this->request->getPost('icon_class'),
            'link_url'   => $this->request->getPost('link_url'),
            'urutan'     => $this->request->getPost('urutan'),
            'status'     => $this->request->getPost('status'),
        ];

        // Save ke database (Validasi otomatis berjalan di Model)
        if (!$this->kontakSocialModel->save($data)) {
            // Jika validasi gagal, kembalikan dengan error
            return redirect()->back()->withInput()->with('errors', $this->kontakSocialModel->errors());
        }

        return redirect()->to('/kontak_social')->with('success', 'Social Media berhasil ditambahkan.');
    }

    // =========================================================
    // EDIT VIEW
    // =========================================================
    public function edit($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_update']) {
            return redirect()->to('/kontak_social')->with('error', 'Kamu tidak punya izin mengubah data.');
        }

        $kontak = $this->kontakSocialModel->find($id);

        if (!$kontak) {
            return redirect()->to('/kontak_social')->with('error', 'Data tidak ditemukan.');
        }

        return view('pages/kontak_social/edit', [
            'kontak' => $kontak
        ]);
    }

    // =========================================================
    // UPDATE PROCESS
    // =========================================================
    public function update($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_update']) {
            return redirect()->to('/kontak_social')->with('error', 'Kamu tidak punya izin memperbarui data.');
        }

        // Cek keberadaan data
        $existing = $this->kontakSocialModel->find($id);
        if (!$existing) {
            return redirect()->to('/kontak_social')->with('error', 'Data tidak ditemukan.');
        }

        // Siapkan data update
        // Pastikan menyertakan Primary Key agar Model tahu ini adalah UPDATE, bukan INSERT
        $data = [
            'id_kontak_social' => $id, // Sesuaikan dengan Primary Key di Model
            'platform'         => $this->request->getPost('platform'),
            'icon_class'       => $this->request->getPost('icon_class'),
            'link_url'         => $this->request->getPost('link_url'),
            'urutan'           => $this->request->getPost('urutan'),
        ];

        // Save (Validasi model berjalan otomatis)
        if (!$this->kontakSocialModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->kontakSocialModel->errors());
        }

        return redirect()->to('/kontak_social')->with('success', 'Social Media berhasil diperbarui.');
    }

    // =========================================================
    // DELETE PROCESS
    // =========================================================
    public function delete($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_delete']) {
            return redirect()->to('/kontak_social')->with('error', 'Kamu tidak punya izin menghapus data.');
        }

        $existing = $this->kontakSocialModel->find($id);
        if (!$existing) {
            return redirect()->to('/kontak_social')->with('error', 'Data tidak ditemukan.');
        }

        $this->kontakSocialModel->delete($id);

        return redirect()->to('/kontak_social')->with('success', 'Social Media berhasil dihapus.');
    }
}