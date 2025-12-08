<?php

namespace App\Controllers\frontend;

use App\Models\frontend\ProfilTentangModel;
use App\Models\AccessRightsModel;
use App\Controllers\BaseController;

class ProfilTentangController extends BaseController
{
    protected $profilModel;
    protected $accessRightsModel;
    protected $module = 'profil_tentang'; // Pastikan modul ini terdaftar

    public function __construct()
    {
        $this->profilModel = new ProfilTentangModel();
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
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        // Urutkan berdasarkan Section lalu Sorting
        $profils = $this->profilModel
            ->orderBy('section', 'ASC')
            ->orderBy('sorting', 'ASC')
            ->findAll();

        return view('pages/profil_tentang/index', [
            'profils'    => $profils,
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete']
        ]);
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
        $model = new \App\Models\frontend\ProfilTentangModel(); // <--- GANTI INI SESUAI MODUL
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
        if (!$access || !$access['can_create']) return redirect()->to('/profil_tentang')->with('error', 'Akses ditolak.');
        
        return view('pages/profil_tentang/create');
    }

    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) return redirect()->to('/profil_tentang');

        $data = [
            'section'   => $this->request->getPost('section'), // Bisa input manual jika VARCHAR
            'title'     => $this->request->getPost('title'),
            'content'   => $this->request->getPost('content'),
            'sorting'   => $this->request->getPost('sorting') ?? 0,
            'is_active' => $this->request->getPost('is_active') ?? 0,
        ];

        // Handle Image Upload
        $file = $this->request->getFile('image_url');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/profil_tentang', $newName);
            $data['image_url'] = 'uploads/profil_tentang/' . $newName;
        }

        if (!$this->profilModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->profilModel->errors());
        }

        return redirect()->to('/profil_tentang')->with('success', 'Data profil berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) return redirect()->to('/profil_tentang')->with('error', 'Akses ditolak.');

        $profil = $this->profilModel->find($id);
        if (!$profil) return redirect()->to('/profil_tentang')->with('error', 'Data tidak ditemukan.');

        return view('pages/profil_tentang/edit', ['profil' => $profil]);
    }

    public function update($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) return redirect()->to('/profil_tentang');

        $oldData = $this->profilModel->find($id);
        if (!$oldData) return redirect()->to('/profil_tentang')->with('error', 'Data tidak ditemukan.');

        $data = [
            'id_tentang' => $id,
            'section'    => $this->request->getPost('section'),
            'title'      => $this->request->getPost('title'),
            'content'    => $this->request->getPost('content'),
            'sorting'    => $this->request->getPost('sorting') ?? 0,
            'is_active'  => $this->request->getPost('is_active') ?? 0,
        ];

        // Handle Image Upload & Replace
        $file = $this->request->getFile('image_url');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/profil_tentang', $newName);
            $data['image_url'] = 'uploads/profil_tentang/' . $newName;

            // Hapus file lama
            if (!empty($oldData['image_url']) && file_exists($oldData['image_url'])) {
                unlink($oldData['image_url']);
            }
        }

        if (!$this->profilModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->profilModel->errors());
        }

        return redirect()->to('/profil_tentang')->with('success', 'Data profil berhasil diperbarui.');
    }

    public function delete($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) return redirect()->to('/profil_tentang');

        $data = $this->profilModel->find($id);
        if ($data) {
            // Hapus file fisik
            if (!empty($data['image_url']) && file_exists($data['image_url'])) {
                unlink($data['image_url']);
            }
            $this->profilModel->delete($id);
            return redirect()->to('/profil_tentang')->with('success', 'Data berhasil dihapus.');
        }

        return redirect()->to('/profil_tentang')->with('error', 'Gagal menghapus data.');
    }
}