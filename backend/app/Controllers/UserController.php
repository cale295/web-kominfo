<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // ========================================================
    // GET /manage_user → tampilkan semua user
    // ========================================================
    public function index()
    {
        $data['users'] = $this->userModel->findAll();
        return view('pages/manage_user/index', $data);
    }

    // ========================================================
    // GET /manage_user/new → tampilkan form tambah user
    // ========================================================
    public function new()
    {
        return view('pages/manage_user/create');
    }

    // ========================================================
    // POST /manage_user → simpan user baru
    // ========================================================
    public function create()
    {
        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username'     => $this->request->getPost('username'),
            'password'     => $this->request->getPost('password'),
            'email'        => $this->request->getPost('email'),
            'role'         => $this->request->getPost('role'),
        ];

        if (!$this->userModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }

        return redirect()->to('/manage_user')->with('success', 'User berhasil ditambahkan.');
    }

    // ========================================================
    // GET /manage_user/{id} → detail user
    // ========================================================
    public function show($id = null)
    {
        $data['user'] = $this->userModel->find($id);

        if (!$data['user']) {
            return redirect()->to('/manage_user')->with('error', 'User tidak ditemukan.');
        }

        return view('pages/manage_user/show', $data);
    }

    // ========================================================
    // GET /manage_user/{id}/edit → form edit user
    // ========================================================
    public function edit($id = null)
    {
        $data['user'] = $this->userModel->find($id);

        if (!$data['user']) {
            return redirect()->to('/manage_user')->with('error', 'User tidak ditemukan.');
        }

        return view('pages/manage_user/edit', $data);
    }

    // ========================================================
    // PUT /manage_user/{id} → update user
    // ========================================================
    public function update($id = null)
    {
        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username'     => $this->request->getPost('username'),
            'email'        => $this->request->getPost('email'),
            'role'         => $this->request->getPost('role'),
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = $password;
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
        if (!$this->userModel->find($id)) {
            return redirect()->to('/manage_user')->with('error', 'User tidak ditemukan.');
        }

        $this->userModel->delete($id);
        return redirect()->to('/manage_user')->with('success', 'User berhasil dihapus.');
    }
}
