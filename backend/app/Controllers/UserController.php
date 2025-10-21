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
    // GET /user → tampilkan semua user
    // ========================================================
    public function index()
    {
        $data['users'] = $this->userModel->findAll();
        return view('pages/user/index', $data);
    }

    // ========================================================
    // GET /user/new → tampilkan form tambah user
    // ========================================================
    public function new()
    {
        return view('pages/user/create');
    }

    // ========================================================
    // POST /user → simpan user baru
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

        return redirect()->to('/user')->with('success', 'User berhasil ditambahkan.');
    }

    // ========================================================
    // GET /user/{id} → detail user
    // ========================================================
    public function show($id = null)
    {
        $data['user'] = $this->userModel->find($id);

        if (!$data['user']) {
            return redirect()->to('/user')->with('error', 'User tidak ditemukan.');
        }

        return view('pages/user/show', $data);
    }

    // ========================================================
    // GET /user/{id}/edit → form edit user
    // ========================================================
    public function edit($id = null)
    {
        $data['user'] = $this->userModel->find($id);

        if (!$data['user']) {
            return redirect()->to('/user')->with('error', 'User tidak ditemukan.');
        }

        return view('pages/user/edit', $data);
    }

    // ========================================================
    // PUT /user/{id} → update user
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

        return redirect()->to('/user')->with('success', 'User berhasil diperbarui.');
    }

    // ========================================================
    // DELETE /user/{id} → hapus user
    // ========================================================
    public function delete($id = null)
    {
        if (!$this->userModel->find($id)) {
            return redirect()->to('/user')->with('error', 'User tidak ditemukan.');
        }

        $this->userModel->delete($id);
        return redirect()->to('/user')->with('success', 'User berhasil dihapus.');
    }
}
