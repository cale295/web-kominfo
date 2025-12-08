<?php

namespace App\Controllers\frontend;

use App\Models\frontend\HomeServiceModel;
use App\Models\AccessRightsModel;
use App\Controllers\BaseController;

class HomeServiceController extends BaseController
{
    protected $homeServiceModel;
    protected $accessRightsModel;

    protected $module = 'home_service'; // Pastikan nama modul ini terdaftar di DB permission

    public function __construct()
    {
        $this->homeServiceModel = new HomeServiceModel();
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
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat modul ini.');
        }

        $services = $this->homeServiceModel
            ->orderBy('sorting', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $data = [
            'services'   => $services,
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ];

        return view('pages/home_service/index', $data);
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
        $model = new \App\Models\frontend\HomeServiceModel(); // <--- GANTI INI SESUAI MODUL
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
            return redirect()->to('/home_service')->with('error', 'Kamu tidak punya izin menambah data.');
        }
        return view('pages/home_service/create');
    }

    // =================================================================
    // CREATE
    // =================================================================
    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/home_service')->with('error', 'Kamu tidak punya izin menambah data.');
        }

        $data = [
            'title'     => $this->request->getPost('title'),
            'link'      => $this->request->getPost('link'),
            'sorting'   => $this->request->getPost('sorting') ?? 0,
            'is_active' => $this->request->getPost('is_active') ?? 0,
        ];

        // --- Handle File Upload ---
        $fileIcon = $this->request->getFile('icon_image');
        if ($fileIcon && $fileIcon->isValid() && !$fileIcon->hasMoved()) {
            $newName = $fileIcon->getRandomName();
            $fileIcon->move('uploads/home_service', $newName);
            $data['icon_image'] = 'uploads/home_service/' . $newName;
        }

        if (!$this->homeServiceModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->homeServiceModel->errors());
        }

        return redirect()->to('/home_service')->with('success', 'Data Layanan berhasil ditambahkan.');
    }

    // =================================================================
    // EDIT
    // =================================================================
    public function edit($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/home_service')->with('error', 'Kamu tidak punya izin mengedit data.');
        }

        $service = $this->homeServiceModel->find($id);
        if (!$service) {
            return redirect()->to('/home_service')->with('error', 'Data tidak ditemukan.');
        }

        return view('pages/home_service/edit', [
            'service' => $service
        ]);
    }

    // =================================================================
    // UPDATE
    // =================================================================
    public function update($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/home_service')->with('error', 'Kamu tidak punya izin mengupdate data.');
        }

        $oldData = $this->homeServiceModel->find($id);
        if (!$oldData) {
            return redirect()->to('/home_service')->with('error', 'Data tidak ditemukan.');
        }

        $data = [
            'id_service' => $id,
            'title'      => $this->request->getPost('title'),
            'link'       => $this->request->getPost('link'),
            'sorting'    => $this->request->getPost('sorting') ?? 0,
            'is_active'  => $this->request->getPost('is_active') ?? 0,
        ];

        // --- Handle File Upload ---
        $fileIcon = $this->request->getFile('icon_image');
        if ($fileIcon && $fileIcon->isValid() && !$fileIcon->hasMoved()) {
            // Upload baru
            $newName = $fileIcon->getRandomName();
            $fileIcon->move('uploads/home_service', $newName);
            $data['icon_image'] = 'uploads/home_service/' . $newName;

            // Hapus file lama fisik
            if (!empty($oldData['icon_image']) && file_exists($oldData['icon_image'])) {
                unlink($oldData['icon_image']);
            }
        }

        if (!$this->homeServiceModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->homeServiceModel->errors());
        }

        return redirect()->to('/home_service')->with('success', 'Data Layanan berhasil diperbarui.');
    }

    // =================================================================
    // DELETE
    // =================================================================
    public function delete($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) {
            return redirect()->to('/home_service')->with('error', 'Kamu tidak punya izin menghapus data.');
        }

        $data = $this->homeServiceModel->find($id);
        if (!$data) {
            return redirect()->to('/home_service')->with('error', 'Data tidak ditemukan.');
        }

        // Hapus File Fisik
        if (!empty($data['icon_image']) && file_exists($data['icon_image'])) {
            unlink($data['icon_image']);
        }

        $this->homeServiceModel->delete($id);

        return redirect()->to('/home_service')->with('success', 'Data berhasil dihapus permanen.');
    }
}