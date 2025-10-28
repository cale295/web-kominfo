<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class ProfileController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $session = session();
        $userId = $session->get('id_user');
        $data['user'] = $this->userModel->find($userId);
        return view('pages/profile/index', $data);
    }

    public function show($id = null)
    {
        $data['user'] = $this->userModel->find($id);
        return view('pages/profile/show', $data);
    }

    public function edit($id = null)
    {
        $data['user'] = $this->userModel->find($id);
        return view('pages/profile/update', $data);
    }

public function update($id = null)
{
    $session = session();
    
    // Ambil data dari form
    $data = [
        'full_name' => $this->request->getPost('full_name'),
        'username'  => $this->request->getPost('username'),
        'email'     => $this->request->getPost('email'),
    ];

    $password = $this->request->getPost('password');
    if (!empty($password)) {
        $data['password'] = $password; // hash otomatis di model
    }

    // Coba update
    if (!$this->userModel->update($id, $data)) {
        // Gagal validasi
        return redirect()->back()
                         ->withInput()
                         ->with('errors', $this->userModel->errors());
    }

    return redirect()->to('/profile')
                     ->with('success', 'Profil berhasil diperbarui!');
}


    public function delete($id = null)
    {
        $this->userModel->delete($id);
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Akun berhasil dihapus.');
    }
}
