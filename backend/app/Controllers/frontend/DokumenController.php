<?php

namespace App\Controllers\frontend;

use App\Controllers\BaseController;
use App\Models\DokumentModel;
use App\Models\DokumentKategoriModel;
use App\Models\AccessRightsModel;

class DokumenController extends BaseController
{
    protected $dokumentModel;
    protected $kategoriModel;
    protected $accessRightsModel;

    protected $module = 'dokumen';

    public function __construct()
    {
        $this->dokumentModel = new DokumentModel();
        $this->kategoriModel = new DokumentKategoriModel();
        $this->accessRightsModel = new AccessRightsModel();
    }

    public function index()
    {
        $role = session()->get('role');
        $access = $this->getAccess($role);

        if (!$access) {
            return view('pages/dokument/index', [
                'title'    => 'Manajemen Dokumen',
                'dokument' => [],
                'error'    => '⚠ Kamu tidak memiliki hak akses ke modul ini.'
            ]);
        }

        if (!$access['can_read']) {
            return redirect()->to('/dashboard')
                ->with('error', 'Kamu tidak punya izin melihat dokumen.');
        }

        $data = [
            'title' => 'Manajemen Dokumen',
            'dokument' => $this->dokumentModel
                ->select('t_documents.*, m_document_category.category_name')
                ->join(
                    'm_document_category',
                    'm_document_category.id_document_category = t_documents.id_document_category',
                    'left'
                )
                ->findAll(),
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ];

        return view('pages/dokument/index', $data);
    }

    public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/dokument')
                ->with('error', 'Kamu tidak punya izin menambah dokumen.');
        }

        $data = [
            'title' => 'Tambah Dokumen',
            'kategori' => $this->kategoriModel->findAll(),
        ];

        return view('pages/dokument/create', $data);
    }

public function create()
{
    $access = $this->getAccess(session()->get('role'));
    if (!$access || !$access['can_create']) {
        return redirect()->to('/dokument')->with('error', 'Kamu tidak punya izin menambah dokumen.');
    }

    $data = [
        'document_name' => $this->request->getPost('document_name'),
        'id_document_category' => $this->request->getPost('id_document_category'),
    ];

    // VALIDASI FILE WAJIB UPLOAD
    $file = $this->request->getFile('file_path');
    if (!$file || !$file->isValid()) {
        return redirect()->back()->withInput()->with('errors', [
            'file_path' => 'File dokumen harus diupload.'
        ]);
    }

    // UPLOAD FILE
    $original = $file->getName();
    $newName  = time() . '-' . $original;

    $file->move('uploads/dokumen', $newName);

    $data['file_path'] = 'uploads/dokumen/' . $newName;

    if (!$this->dokumentModel->save($data)) {
        return redirect()->back()->withInput()->with('errors', $this->dokumentModel->errors());
    }

    return redirect()->to('/dokument')->with('success', 'Dokumen berhasil ditambahkan.');
}


    public function edit($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/dokument')->with('error', 'Kamu tidak punya izin mengubah dokumen.');
        }

        $dokument = $this->dokumentModel->find($id);
        if (!$dokument) {
            return redirect()->to('/dokument')->with('error', 'Dokumen tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Dokumen',
            'dokument' => $dokument,
            'kategori' => $this->kategoriModel->findAll(),
        ];

        return view('pages/dokument/edit', $data);
    }

    public function update($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/dokument')->with('error', 'Kamu tidak punya izin mengubah dokumen.');
        }

        $dokument = $this->dokumentModel->find($id);
        if (!$dokument) {
            return redirect()->to('/dokument')->with('error', 'Dokumen tidak ditemukan.');
        }

        $data = [
            'document_name' => $this->request->getPost('document_name'),
            'id_document_category' => $this->request->getPost('id_document_category'),
        ];

        // Upload file baru jika ada
        $file = $this->request->getFile('file_path');
        if ($file && $file->isValid() && !$file->hasMoved()) {

            // Nama asli + timestamp
            $original = $file->getName();
            $newName  = time() . '-' . $original;

            $file->move('uploads/dokumen', $newName);
            $data['file_path'] = 'uploads/dokumen/' . $newName;

            // Hapus file lama
            if (!empty($dokument['file_path']) && file_exists($dokument['file_path'])) {
                unlink($dokument['file_path']);
            }
        }

        if (!$this->dokumentModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->dokumentModel->errors());
        }

        return redirect()->to('/dokument')->with('success', 'Dokumen berhasil diupdate.');
    }

    public function delete($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) {
            return redirect()->back()->with('error', 'Kamu tidak punya izin menghapus dokumen.');
        }

        $dokument = $this->dokumentModel->find($id);
        if (!$dokument) {
            return redirect()->back()->with('error', 'Dokumen tidak ditemukan.');
        }

        // Hapus file di folder
        if (!empty($dokument['file_path']) && file_exists($dokument['file_path'])) {
            unlink($dokument['file_path']);
        }

        $this->dokumentModel->delete($id);

        return redirect()->back()->with('success', 'Dokumen berhasil dihapus.');
    }

    private function getAccess($role)
    {
        $access = $this->accessRightsModel
            ->where('role', $role)
            ->where('module_name', $this->module)
            ->first();

        if (!$access) return false;

        return [
            'can_create' => (bool)$access['can_create'],
            'can_read'   => (bool)$access['can_read'],
            'can_update' => (bool)$access['can_update'],
            'can_delete' => (bool)$access['can_delete'],
        ];
    }
}
