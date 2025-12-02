<?php

namespace App\Controllers\frontend;

use App\Models\frontend\PermohonanInformasiModel;
use App\Models\AccessRightsModel;
use App\Controllers\BaseController;

class PermohonanInformasiController extends BaseController
{
    protected $permohonanModel;
    protected $accessRightsModel;
    protected $module = 'permohonan_informasi'; // Sesuaikan dengan nama modul di database hak akses
    protected $uploadPath = 'uploads/permohonan_informasi/';

    public function __construct()
    {
        $this->permohonanModel = new PermohonanInformasiModel();
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
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        $data = [
            'documents'  => $this->permohonanModel->orderBy('created_at', 'DESC')->findAll(),
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ];

        return view('pages/permohonan_informasi/index', $data);
    }

    public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_create']) return redirect()->to('/permohonan_informasi')->with('error', 'Akses ditolak.');
        
        return view('pages/permohonan_informasi/create');
    }

    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_create']) return redirect()->to('/permohonan_informasi')->with('error', 'Akses ditolak.');

        // Validasi Input + File
        if (!$this->validate([
            'document_file' => [
                'label' => 'File Dokumen',
                'rules' => 'uploaded[document_file]|ext_in[document_file,pdf,doc,docx,xls,xlsx,jpg,jpeg,png]|max_size[document_file,10240]' // Max 10MB
            ]
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('document_file');
        $fileName = $file->getRandomName(); // Generate nama unik
        $filePath = $this->uploadPath . $fileName;

        // Pindahkan file
        if (!$file->hasMoved()) {
            if (!is_dir(FCPATH . $this->uploadPath)) mkdir(FCPATH . $this->uploadPath, 0777, true);
            $file->move(FCPATH . $this->uploadPath, $fileName);
        }

        $data = [
            'judul_dokumen' => $this->request->getPost('judul_dokumen'),
            'tahun'         => $this->request->getPost('tahun'),
            'file_name'     => $fileName,
            'file_path'     => $filePath
        ];

        if (!$this->permohonanModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->permohonanModel->errors());
        }

        return redirect()->to('/permohonan_informasi')->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_update']) return redirect()->to('/permohonan_informasi')->with('error', 'Akses ditolak.');

        $doc = $this->permohonanModel->find($id);
        if (!$doc) return redirect()->to('/permohonan_informasi')->with('error', 'Data tidak ditemukan.');

        return view('pages/permohonan_informasi/edit', ['doc' => $doc]);
    }

    public function update($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_update']) return redirect()->to('/permohonan_informasi')->with('error', 'Akses ditolak.');

        $existing = $this->permohonanModel->find($id);
        if (!$existing) return redirect()->to('/permohonan_informasi')->with('error', 'Data tidak ditemukan.');

        $data = [
            'id_permohonan' => $id,
            'judul_dokumen' => $this->request->getPost('judul_dokumen'),
            'tahun'         => $this->request->getPost('tahun'),
        ];

        // Cek jika ada upload file baru
        $file = $this->request->getFile('document_file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            
            // Validasi file baru
            if (!$this->validate(['document_file' => 'ext_in[document_file,pdf,doc,docx,xls,xlsx,jpg,jpeg,png]|max_size[document_file,10240]'])) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            // Hapus file lama
            if (file_exists(FCPATH . $existing['file_path'])) {
                unlink(FCPATH . $existing['file_path']);
            }

            $fileName = $file->getRandomName();
            $file->move(FCPATH . $this->uploadPath, $fileName);

            $data['file_name'] = $fileName;
            $data['file_path'] = $this->uploadPath . $fileName;
        }

        if (!$this->permohonanModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->permohonanModel->errors());
        }

        return redirect()->to('/permohonan_informasi')->with('success', 'Data berhasil diperbarui.');
    }

    public function delete($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_delete']) return redirect()->to('/permohonan_informasi')->with('error', 'Akses ditolak.');

        $doc = $this->permohonanModel->find($id);
        if (!$doc) return redirect()->to('/permohonan_informasi')->with('error', 'Data tidak ditemukan.');

        // Hapus file fisik
        if (file_exists(FCPATH . $doc['file_path'])) {
            unlink(FCPATH . $doc['file_path']);
        }

        $this->permohonanModel->delete($id);

        return redirect()->to('/permohonan_informasi')->with('success', 'Dokumen berhasil dihapus.');
    }
}