<?php

namespace App\Controllers\frontend;

use App\Models\frontend\StrukturOrganisasiModel;
use App\Models\AccessRightsModel;
use App\Controllers\BaseController;

class StrukturOrganisasiController extends BaseController
{
    protected $strukturModel;
    protected $accessRightsModel;
    protected $module = 'struktur_organisasi'; // Pastikan modul ini terdaftar

    public function __construct()
    {
        $this->strukturModel = new StrukturOrganisasiModel();
        $this->accessRightsModel = new AccessRightsModel();
    }

    private function getAccess($role)
    {
        $access = $this->accessRightsModel->where('role', $role)->where('module_name', $this->module)->first();
        if (!$access) return ['can_create' => false, 'can_read' => false, 'can_update' => false, 'can_delete' => false];
        return [
            'can_create' => (bool)$access['can_create'],
            'can_read'   => (bool)$access['can_read'],
            'can_update' => (bool)$access['can_update'],
            'can_delete' => (bool)$access['can_delete'],
        ];
    }

    public function index()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat modul ini.');
        }

        // Ambil data dengan join ke diri sendiri untuk mendapatkan nama parent
        $struktur = $this->strukturModel
            ->select('m_p_struktur_organisasi.*, parent.nama as parent_name')
            ->join('m_p_struktur_organisasi as parent', 'parent.id_struktur = m_p_struktur_organisasi.parent_id', 'left')
            ->orderBy('m_p_struktur_organisasi.sorting', 'ASC')
            ->findAll();

        return view('pages/struktur_organisasi/index', [
            'struktur'   => $struktur,
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete']
        ]);
    }

    public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/struktur_organisasi')->with('error', 'Akses ditolak.');
        }

        // Ambil semua data untuk dropdown parent
        $parents = $this->strukturModel->orderBy('nama', 'ASC')->findAll();

        return view('pages/struktur_organisasi/create', ['parents' => $parents]);
    }

    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) return redirect()->to('/struktur_organisasi');

        $parentId = $this->request->getPost('parent_id');
        
        $data = [
            'nama'        => $this->request->getPost('nama'),
            'kategori'    => $this->request->getPost('kategori'),
            'parent_id'   => !empty($parentId) ? $parentId : null,
            'slug'        => url_title($this->request->getPost('nama'), '-', true),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'konten_html' => $this->request->getPost('konten_html'),
            'sorting'     => $this->request->getPost('sorting') ?? 0,
            'is_active'   => $this->request->getPost('is_active') ?? 0,
        ];

        if (!$this->strukturModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->strukturModel->errors());
        }

        return redirect()->to('/struktur_organisasi')->with('success', 'Data struktur berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/struktur_organisasi')->with('error', 'Akses ditolak.');
        }

        $struktur = $this->strukturModel->find($id);
        if (!$struktur) {
            return redirect()->to('/struktur_organisasi')->with('error', 'Data tidak ditemukan.');
        }

        // Ambil semua data untuk dropdown parent (kecuali diri sendiri)
        $parents = $this->strukturModel
            ->where('id_struktur !=', $id)
            ->orderBy('nama', 'ASC')
            ->findAll();

        return view('pages/struktur_organisasi/edit', [
            'struktur' => $struktur,
            'parents'  => $parents
        ]);
    }

    public function update($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) return redirect()->to('/struktur_organisasi');

        $oldData = $this->strukturModel->find($id);
        if (!$oldData) return redirect()->to('/struktur_organisasi')->with('error', 'Data tidak ditemukan.');

        $parentId = $this->request->getPost('parent_id');

        $data = [
            'id_struktur' => $id,
            'nama'        => $this->request->getPost('nama'),
            'kategori'    => $this->request->getPost('kategori'),
            'parent_id'   => !empty($parentId) ? $parentId : null,
            'slug'        => url_title($this->request->getPost('nama'), '-', true),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'konten_html' => $this->request->getPost('konten_html'),
            'sorting'     => $this->request->getPost('sorting') ?? 0,
            'is_active'   => $this->request->getPost('is_active') ?? 0,
        ];

        if (!$this->strukturModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->strukturModel->errors());
        }

        return redirect()->to('/struktur_organisasi')->with('success', 'Data struktur berhasil diperbarui.');
    }

    public function delete($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) return redirect()->to('/struktur_organisasi');

        $data = $this->strukturModel->find($id);
        if ($data) {
            // Opsional: Cek apakah punya child sebelum hapus?
            // Untuk sekarang langsung hapus saja (soft delete dimatikan)
            $this->strukturModel->delete($id);
            return redirect()->to('/struktur_organisasi')->with('success', 'Data berhasil dihapus.');
        }

        return redirect()->to('/struktur_organisasi')->with('error', 'Gagal menghapus data.');
    }
}