<?php

namespace App\Controllers\backend;

use App\Controllers\BaseController;
use App\Models\DokumentKategoriModel;
use App\Models\AccessRightsModel;
class DokumenKategoriController extends BaseController
{
    protected $dokumentKategoriModel;
    protected $accessRightsModel;

    protected $module = 'dokumen_kategori';
    public function __construct()
    {
        $this->dokumentKategoriModel = new DokumentKategoriModel();
        $this->accessRightsModel = new AccessRightsModel();
    }
    public function index()
    {
        $role = session()->get('role');
        $access = $this->getAccess($role);

        if (!$access) {
            return view('pages/dokument_kategori/index', [
                'title' => 'Manajemen dokument kategori',
                'dokumentKategori' => [],
                'error' => '⚠ Kamu tidak memiliki hak akses ke modul ini.'
            ]);
        }

        if (!$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat dokument kategori.');
        }

        $data = [
            'title' => 'Manajemen dokument kategori',
            'dokumentKategori' => $this->dokumentKategoriModel->findAll(),
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ];

        return view('pages/dokument_kategori/index', $data);
    }

    public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/dokument_kategori')->with('error', 'Kamu tidak punya izin menambah dokument kategori.');
        }

        $data = [
            'title' => 'Tambah dokument kategori'
        ];
        return view('pages/dokument_kategori/create', $data);
    }


    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/dokument_kategori')->with('error', 'Kamu tidak punya izin menambah dokument kategori.');
        }

        $data = [
            'category_name' => $this->request->getPost('category_name'),
            'category_description' => $this->request->getPost('category_description'),
        ];

        if (!$this->dokumentKategoriModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->dokumentKategoriModel->errors());
        }

        return redirect()->to('/dokument_kategori')->with('success', 'Dokument kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/dokument_kategori')->with('error', 'Kamu tidak punya izin mengubah dokument kategori.');
        }

        $dokumentKategori = $this->dokumentKategoriModel->find($id);
        if (!$dokumentKategori) {
            return redirect()->to('/dokument_kategori')->with('error', 'Dokument kategori tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit dokument kategori',
            'dokumentKategori' => $dokumentKategori
        ];

        return view('pages/dokument_kategori/edit', $data);
    }

    public function update($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/dokument_kategori')->with('error', 'Kamu tidak punya izin mengubah dokument kategori.');
        }

        $dokumentKategori = $this->dokumentKategoriModel->find($id);
        if (!$dokumentKategori) {
            return redirect()->to('/dokument_kategori')->with('error', 'Dokument kategori tidak ditemukan.');
        }

        $data = [
            'category_name' => $this->request->getPost('category_name'),
            'category_description' => $this->request->getPost('category_description'),
        ];

        if (!$this->dokumentKategoriModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->dokumentKategoriModel->errors());
        }

        return redirect()->to('/dokument_kategori')->with('success', 'Dokument kategori berhasil diupdate.');
        
    }

    public function delete($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) {
            return redirect()->back()->with('error', 'Kamu tidak punya izin menghapus dokument kategori.');
        }

        $dokumentKategori = $this->dokumentKategoriModel->find($id);
        if (!$dokumentKategori) {
            return redirect()->back()->with('error', 'Dokument kategori tidak ditemukan.');
        }

        $this->dokumentKategoriModel->delete($id);
        return redirect()->back()->with('success', 'Dokument kategori berhasil dihapus.');
    }

    

    private function getAccess($role)
    {
        $access = $this->accessRightsModel
            ->where('role', $role)
            ->where('module_name', $this->module)
            ->first();

        if (!$access) return false;

        return [
            'can_create' => (bool) $access['can_create'],
            'can_read'   => (bool) $access['can_read'],
            'can_update' => (bool) $access['can_update'],
            'can_delete' => (bool) $access['can_delete'],
        ];
    }
}
