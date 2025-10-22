<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\AccessRightsModel;

class UserController extends BaseController
{
    protected $userModel;
    protected $accessRightsModel;
    protected $module = 'manage_user'; // Nama modul untuk hak akses

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->accessRightsModel = new AccessRightsModel();
    }

    // ========================================================
    // GET /manage_user → tampilkan semua user
    // ========================================================
    public function index()
    {
        $role = session()->get('role');
        $access = $this->getAccess($role);

        // Jika tidak ada data akses sama sekali
        if (!$access) {
            return view('pages/manage_user/index', [
                'title' => 'Manajemen User',
                'users' => [],
                'error' => '⚠️ Kamu tidak memiliki hak akses ke modul ini.'
            ]);
        }

        // Jika role tidak punya izin membaca
        if (!$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat data user.');
        }

        $users = $this->userModel->findAll();

        $data = [
            'title' => 'Manajemen User',
            'users' => $users,
            'totalUsers' => count($users),
            'admin' => $this->userModel->where('role', 'admin')->countAllResults(),
            'editor' => $this->userModel->where('role', 'editor')->countAllResults(),
            'superadmin' => $this->userModel->where('role', 'superadmin')->countAllResults()
        ];

        return view('pages/manage_user/index', $data);
    }

    // ========================================================
    // GET /manage_user/new → tampilkan form tambah user
    // ========================================================
    public function new()
    {
        $access = $this->getAccess(session()->get('role'));

        if (!$access) {
            return redirect()->to('/manage_user')->with('error', 'Data hak akses tidak ditemukan.');
        }

        if (!$access['can_create']) {
            return redirect()->to('/manage_user')->with('error', 'Kamu tidak punya izin menambah user.');
        }

        return view('pages/manage_user/create');
    }

    // ========================================================
    // POST /manage_user → simpan user baru
    // ========================================================
    public function create()
    {
        $access = $this->getAccess(session()->get('role'));

        if (!$access || !$access['can_create']) {
            return redirect()->to('/manage_user')->with('error', 'Kamu tidak punya izin menambah user.');
        }

        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'username'  => $this->request->getPost('username'),
            'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'email'     => $this->request->getPost('email'),
            'role'      => $this->request->getPost('role'),
        ];

        if (!$this->userModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }

        return redirect()->to('/manage_user')->with('success', 'User berhasil ditambahkan.');
    }

    // ========================================================
    // GET /manage_user/{id}/edit → form edit user
    // ========================================================
    public function edit($id = null)
    {
        $access = $this->getAccess(session()->get('role'));

        if (!$access || !$access['can_update']) {
            return redirect()->to('/manage_user')->with('error', 'Kamu tidak punya izin mengedit user.');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/manage_user')->with('error', 'User tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit User',
            'user'  => $user
        ];

        return view('pages/manage_user/edit', $data);
    }

    // ========================================================
    // PUT /manage_user/{id} → update user
    // ========================================================
    public function update($id = null)
    {
        $access = $this->getAccess(session()->get('role'));

        if (!$access || !$access['can_update']) {
            return redirect()->to('/manage_user')->with('error', 'Kamu tidak punya izin mengubah user.');
        }

        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'username'  => $this->request->getPost('username'),
            'email'     => $this->request->getPost('email'),
            'role'      => $this->request->getPost('role'),
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if (!$this->userModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }

        return redirect()->to('/manage_user')->with('success', 'User berhasil diperbarui.');
    }

    // ========================================================
    // DELETE /manage_user/{id} → hapus user
    // ========================================================
    public function delete($id = null)
    {
        $access = $this->getAccess(session()->get('role'));

        if (!$access || !$access['can_delete']) {
            return redirect()->to('/manage_user')->with('error', 'Kamu tidak punya izin menghapus user.');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/manage_user')->with('error', 'User tidak ditemukan.');
        }

        $this->userModel->delete($id);
        return redirect()->to('/manage_user')->with('success', 'User berhasil dihapus.');
    }

    // ========================================================
    // FUNGSI BANTU UNTUK AMBIL AKSES ROLE
    // ========================================================
    private function getAccess($role)
    {
        return $this->accessRightsModel
            ->where('role', $role)
            ->where('module_name', $this->module)
            ->first();
    }
}
