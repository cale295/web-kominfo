<?php

namespace App\Controllers\frontend;

use App\Models\frontend\FooterSocialModel;
use App\Models\AccessRightsModel;
use App\Controllers\BaseController;

class FooterSocialController extends BaseController
{
    protected $footerSocialModel;
    protected $accessRightsModel;

    protected $module = 'footer_social';

    public function __construct()
    {
        $this->footerSocialModel = new FooterSocialModel();
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

        $socials = $this->footerSocialModel
            ->orderBy('sorting', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $data = [
            'social_media' => $socials,
            'can_create'   => $access['can_create'],
            'can_update'   => $access['can_update'],
            'can_delete'   => $access['can_delete'],
        ];

        return view('pages/footer_social/index', $data);
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
        $model = new \App\Models\frontend\FooterSocialModel(); // <--- GANTI INI SESUAI MODUL
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
            return redirect()->to('/footer_social')->with('error', 'Kamu tidak punya izin menambah data.');
        }
        return view('pages/footer_social/create');
    }

    // =================================================================
    // CREATE
    // =================================================================
    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/footer_social')->with('error', 'Kamu tidak punya izin menambah data.');
        }

        $data = [
            'platform_name' => $this->request->getPost('platform_name'),
            'platform_icon' => $this->request->getPost('platform_icon'),
            'account_name'  => $this->request->getPost('account_name'),
            'account_url'   => $this->request->getPost('account_url'),
            'sorting'       => $this->request->getPost('sorting') ?? 0,
            'is_active'     => $this->request->getPost('is_active') ?? 0,
            'created_by'    => session()->get('id_user'),
        ];

        if (!$this->footerSocialModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->footerSocialModel->errors());
        }

        return redirect()->to('/footer_social')->with('success', 'Data Social Media berhasil ditambahkan.');
    }

    // =================================================================
    // EDIT
    // =================================================================
    public function edit($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/footer_social')->with('error', 'Kamu tidak punya izin mengedit data.');
        }

        $social = $this->footerSocialModel->find($id);
        if (!$social) {
            return redirect()->to('/footer_social')->with('error', 'Data tidak ditemukan.');
        }

        return view('pages/footer_social/edit', [
            'social' => $social
        ]);
    }

    // =================================================================
    // UPDATE
    // =================================================================
    public function update($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/footer_social')->with('error', 'Kamu tidak punya izin mengupdate data.');
        }

        $oldData = $this->footerSocialModel->find($id);
        if (!$oldData) {
            return redirect()->to('/footer_social')->with('error', 'Data tidak ditemukan.');
        }

        $data = [
            'id_footer_social' => $id, // ✅ ID Updated (Penting untuk save() mode update)
            'platform_name'    => $this->request->getPost('platform_name'),
            'platform_icon'    => $this->request->getPost('platform_icon'),
            'account_name'     => $this->request->getPost('account_name'),
            'account_url'      => $this->request->getPost('account_url'),
            'sorting'          => $this->request->getPost('sorting') ?? 0,
            'is_active'        => $this->request->getPost('is_active') ?? 0,
            'updated_by'       => session()->get('id_user'),
        ];

        if (!$this->footerSocialModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->footerSocialModel->errors());
        }

        return redirect()->to('/footer_social')->with('success', 'Data Social Media berhasil diperbarui.');
    }

    // =================================================================
    // DELETE
    // =================================================================
    public function delete($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) {
            return redirect()->to('/footer_social')->with('error', 'Kamu tidak punya izin menghapus data.');
        }

        $data = $this->footerSocialModel->find($id);
        if (!$data) {
            return redirect()->to('/footer_social')->with('error', 'Data tidak ditemukan.');
        }

        $this->footerSocialModel->delete($id);

        return redirect()->to('/footer_social')->with('success', 'Data berhasil dihapus permanen.');
    }
}