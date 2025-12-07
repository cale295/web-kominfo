<?php

namespace App\Controllers\frontend;

use App\Controllers\BaseController;
use App\Models\AccessRightsModel;
// Pastikan kamu sudah membuat Model ini
use App\Models\frontend\StrukturOrganisasiModel; 

class StrukturOrganisasiController extends BaseController
{
    protected $strukturModel;
    protected $accessRightsModel;
    protected $module = 'struktur_organisasi'; // Sesuaikan nama modul di tabel hak akses

    public function __construct()
    {
        $this->strukturModel = new StrukturOrganisasiModel();
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
        
        if (!$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat data ini.');
        }

        // Kita bisa sort berdasarkan 'sorting' ASC agar urutan sesuai input user
        $data = [
            'struktur_organisasi' => $this->strukturModel->orderBy('sorting', 'ASC')->findAll(),
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ];

        return view('pages/struktur_organisasi/index', $data);
    }

    public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_create']) {
            return redirect()->to('/struktur_organisasi')->with('error', 'Akses ditolak.');
        }

        // PENTING: Kirim data 'parents' untuk dropdown select option
        $data = [
            'parents' => $this->strukturModel->orderBy('nama', 'ASC')->findAll()
        ];

        return view('pages/struktur_organisasi/create', $data);
    }

    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_create']) {
            return redirect()->to('/struktur_organisasi')->with('error', 'Akses ditolak.');
        }

        // 1. Validasi Input
        if (!$this->validate([
            'nama'     => 'required|min_length[3]',
            'kategori' => 'required',
            'sorting'  => 'integer'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. LOGIC KHUSUS: Handle Parent ID (String kosong "" jadi NULL)
        $parentIdInput = $this->request->getPost('parent_id');
        $parentId = empty($parentIdInput) ? null : $parentIdInput;

        // 3. Persiapkan Data
        $data = [
            'nama'        => $this->request->getPost('nama'),
            'kategori'    => $this->request->getPost('kategori'),
            'parent_id'   => $parentId, // Ini variable yang sudah di-cek null
            'deskripsi'   => $this->request->getPost('deskripsi'), // Isi dari Quill JS
            'sorting'     => $this->request->getPost('sorting'),
            // Checkbox: jika dicentang kirim '1', jika tidak kirim '0'
            'is_active'   => $this->request->getPost('is_active') ? 1 : 0, 
        ];

        // 4. Simpan
        if (!$this->strukturModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->strukturModel->errors());
        }

        return redirect()->to('/struktur_organisasi')->with('success', 'Data struktur organisasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_update']) {
            return redirect()->to('/struktur_organisasi')->with('error', 'Akses ditolak.');
        }

        $struktur = $this->strukturModel->find($id);
        if (!$struktur) {
            return redirect()->to('/struktur_organisasi')->with('error', 'Data tidak ditemukan.');
        }

        // PENTING: Kirim data 'parents' tapi KECUALIKAN dirinya sendiri
        // (Agar tidak terjadi error hierarki: bapak adalah anak dari dirinya sendiri)
        $parents = $this->strukturModel->where('id_struktur !=', $id)->orderBy('nama', 'ASC')->findAll();

        $data = [
            'struktur' => $struktur,
            'parents'  => $parents
        ];

        return view('pages/struktur_organisasi/edit', $data);
    }

    public function update($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_update']) {
            return redirect()->to('/struktur_organisasi')->with('error', 'Akses ditolak.');
        }

        $struktur = $this->strukturModel->find($id);
        if (!$struktur) {
            return redirect()->to('/struktur_organisasi')->with('error', 'Data tidak ditemukan.');
        }

        // Validasi
        if (!$this->validate([
            'nama'     => 'required|min_length[3]',
            'kategori' => 'required',
            'sorting'  => 'integer'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle Parent ID Null
        $parentIdInput = $this->request->getPost('parent_id');
        $parentId = empty($parentIdInput) ? null : $parentIdInput;

        // Cegah user memilih dirinya sendiri sebagai parent (Circular Logic)
        if ($parentId == $id) {
            return redirect()->back()->withInput()->with('error', 'Unit tidak bisa menjadi atasan bagi dirinya sendiri.');
        }

        $data = [
            'id_struktur' => $id, // Primary Key wajib ada untuk update
            'nama'        => $this->request->getPost('nama'),
            'kategori'    => $this->request->getPost('kategori'),
            'parent_id'   => $parentId,
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'sorting'     => $this->request->getPost('sorting'),
            'is_active'   => $this->request->getPost('is_active') ? 1 : 0,
        ];

        if (!$this->strukturModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->strukturModel->errors());
        }

        return redirect()->to('/struktur_organisasi')->with('success', 'Data berhasil diperbarui.');
    }

    public function delete($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_delete']) {
            return redirect()->to('/struktur_organisasi')->with('error', 'Akses ditolak.');
        }

        // Opsional: Cek apakah data ini punya Child (Anak)
        // Jika punya anak, sebaiknya dilarang hapus agar data anak tidak jadi "yatim piatu"
        $hasChild = $this->strukturModel->where('parent_id', $id)->first();
        if ($hasChild) {
            return redirect()->to('/struktur_organisasi')->with('error', 'Gagal hapus! Unit ini memiliki bawahan. Hapus atau pindahkan bawahannya terlebih dahulu.');
        }

        $this->strukturModel->delete($id);

        return redirect()->to('/struktur_organisasi')->with('success', 'Data berhasil dihapus.');
    }
    
}