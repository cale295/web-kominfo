<?php

namespace App\Controllers\frontend;

use App\Models\AccessRightsModel;
use App\Models\frontend\KontakLayananModel;
use App\Controllers\BaseController;

class KontakLayananController extends BaseController
{
    protected $kontakLayananModel;
    protected $accessRightsModel;
    protected $module = 'kontak_layanan';

    public function __construct()
    {
        $this->kontakLayananModel = new KontakLayananModel();
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
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat modul ini.');
        }

        $kontaklayanan = $this->kontakLayananModel->orderBy('created_at', 'DESC')->findAll();

        $data = [
            'kontaklayanan' => $kontaklayanan,
            'can_create'    => $access['can_create'],
            'can_update'    => $access['can_update'],
            'can_delete'    => $access['can_delete'],
        ];

        return view('pages/kontak_layanan/index', $data);
    }

    public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/kontak_layanan')->with('error', 'Kamu tidak punya izin menambah kontak.');
        }
        return view('pages/kontak_layanan/create');
    }

    // -------------------------------------------------------------------------
    // CREATE (Proses Simpan Data Baru)
    // -------------------------------------------------------------------------
    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/kontak_layanan')->with('error', 'Kamu tidak punya izin menambah data.');
        }

        // Ambil data dari form
        $data = [
            'judul'         => $this->request->getPost('judul'),
            'subjudul'      => $this->request->getPost('subjudul'),
            'icon_class'    => $this->request->getPost('icon_class'),
            'icon_bg_color' => $this->request->getPost('icon_bg_color'),
            'link_url'      => $this->request->getPost('link_url'),
            'nomor_telepon' => $this->request->getPost('nomor_telepon'),
            'tipe'          => $this->request->getPost('tipe'),
            'urutan'        => $this->request->getPost('urutan'),
            'status'        => $this->request->getPost('status'),
        ];

        // Simpan data (Model akan otomatis memvalidasi berdasarkan $validationRules)
        if ($this->kontakLayananModel->save($data) === false) {
            // Jika validasi gagal, kembali ke form dengan input sebelumnya dan pesan error
            return redirect()->back()->withInput()->with('errors', $this->kontakLayananModel->errors());
        }

        return redirect()->to('/kontak_layanan')->with('success', 'Data kontak layanan berhasil ditambahkan.');
    }

    // -------------------------------------------------------------------------
    // EDIT (Tampilkan Form Edit)
    // -------------------------------------------------------------------------
    public function edit($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/kontak_layanan')->with('error', 'Kamu tidak punya izin mengubah data.');
        }

        // Cari data berdasarkan ID
        $kontak = $this->kontakLayananModel->find($id);

        if (!$kontak) {
            return redirect()->to('/kontak_layanan')->with('error', 'Data tidak ditemukan.');
        }

        $data = [
            'kontak' => $kontak
        ];

        return view('pages/kontak_layanan/edit', $data);
    }

    // -------------------------------------------------------------------------
    // UPDATE (Proses Update Data)
    // -------------------------------------------------------------------------
    public function update($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/kontak_layanan')->with('error', 'Kamu tidak punya izin mengubah data.');
        }

        // Cek apakah data ada
        $existing = $this->kontakLayananModel->find($id);
        if (!$existing) {
            return redirect()->to('/kontak_layanan')->with('error', 'Data tidak ditemukan.');
        }

        // Siapkan data update
        // Penting: Kita harus menyertakan Primary Key agar CI4 tahu ini Update, bukan Insert
        $data = [
            'id_kontak_layanan' => $id, // Sesuai dengan $primaryKey di Model Anda
            'judul'             => $this->request->getPost('judul'),
            'subjudul'          => $this->request->getPost('subjudul'),
            'icon_class'        => $this->request->getPost('icon_class'),
            'icon_bg_color'     => $this->request->getPost('icon_bg_color'),
            'link_url'          => $this->request->getPost('link_url'),
            'nomor_telepon'     => $this->request->getPost('nomor_telepon'),
            'tipe'              => $this->request->getPost('tipe'),
            'urutan'            => $this->request->getPost('urutan'),
            'status'            => $this->request->getPost('status'),
        ];

        // Proses Update (Validasi model tetap berjalan)
        if ($this->kontakLayananModel->save($data) === false) {
            return redirect()->back()->withInput()->with('errors', $this->kontakLayananModel->errors());
        }

        return redirect()->to('/kontak_layanan')->with('success', 'Data kontak layanan berhasil diperbarui.');
    }

    // -------------------------------------------------------------------------
    // DELETE (Hapus Data)
    // -------------------------------------------------------------------------
    public function delete($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) {
            return redirect()->to('/kontak_layanan')->with('error', 'Kamu tidak punya izin menghapus data.');
        }

        // Cek keberadaan data
        $existing = $this->kontakLayananModel->find($id);
        if (!$existing) {
            return redirect()->to('/kontak_layanan')->with('error', 'Data tidak ditemukan.');
        }

        // Proses hapus
        $this->kontakLayananModel->delete($id);

        return redirect()->to('/kontak_layanan')->with('success', 'Data kontak layanan berhasil dihapus.');
    }
}