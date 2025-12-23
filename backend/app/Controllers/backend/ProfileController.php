<?php

namespace App\Controllers\backend;

use App\Controllers\BaseController;
use App\Models\UserModel;

class ProfileController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form', 'filesystem', 'text']);
    }

    public function index()
    {
        $idUser = session()->get('id_user');
        if (!$idUser) return redirect()->to('/login');

        $user = $this->userModel->find($idUser);
        if (!$user) {
            session()->destroy();
            return redirect()->to('/login');
        }

        return view('pages/profile/index', ['title' => 'Profil Saya', 'user' => $user]);
    }

    public function edit($id = null)
    {
        if ($id != session()->get('id_user')) {
            return redirect()->to('/profile')->with('error', 'Akses ditolak.');
        }

        $user = $this->userModel->find($id);
        if (!$user) return redirect()->to('/profile');

        return view('pages/profile/update', ['title' => 'Edit Profil', 'user' => $user]);
    }

    // =========================================================================
    // CODE YANG SUDAH DIUBAH (LEBIH BERSIH)
    // =========================================================================
public function update($id = null)
{
    // 1. Cek User Lama
    $userLama = $this->userModel->find($id);
    if (!$userLama) {
        return redirect()->to('/profile')->with('error', 'User tidak ditemukan.');
    }

    // 2. Siapkan Data
    $data = [
        'id_user'   => $id, 
        'full_name' => $this->request->getPost('full_name'),
        'username'  => $this->request->getPost('username'),
        'email'     => $this->request->getPost('email'),
        'no_telp'   => $this->request->getPost('no_telp'),
    ];

    // 3. Handle Password
    $passwordBaru = $this->request->getPost('password');
    if (!empty($passwordBaru)) {
        $data['password'] = password_hash($passwordBaru, PASSWORD_DEFAULT);
        // Set rule password jika diisi
        $this->userModel->setValidationRule('password', 'required|min_length[8]');
    } else {
        unset($data['password']); 
    }

    // 4. Handle Upload Foto
    $fileFoto = $this->request->getFile('foto');
    if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
        
        if (!$this->validate([
            'foto' => 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $namaFotoBaru = $fileFoto->getRandomName();
        $fileFoto->move('uploads/users', $namaFotoBaru);
        $data['foto'] = $namaFotoBaru;

        if (!empty($userLama['foto']) && $userLama['foto'] != 'default.png') {
            $path = 'uploads/users/' . $userLama['foto'];
            if (file_exists($path) && is_file($path)) unlink($path);
        }
    }

    // =========================================================================
    // 5. SOLUSI FIX: TIMPA RULES AGAR IGNORE ID SENDIRI
    // =========================================================================
    // Syntax: is_unique[nama_tabel.nama_kolom, nama_kolom_primary, nilai_primary_saat_ini]
    
    // Matikan validasi ID_User (karena pasti sama/duplikat dengan dirinya sendiri)
    $this->userModel->setValidationRule('id_user', 'permit_empty');

    // Paksa validasi username mengecualikan ID ini
    $this->userModel->setValidationRule(
        'username', 
        "required|min_length[5]|is_unique[m_users.username,id_user,{$id}]"
    );

    // Paksa validasi email mengecualikan ID ini
    $this->userModel->setValidationRule(
        'email', 
        "required|valid_email|is_unique[m_users.email,id_user,{$id}]"
    );

    // 6. Simpan
    if (!$this->userModel->save($data)) {
        return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
    }

    return redirect()->to('/profile')->with('success', 'Profil berhasil diperbarui!');
}
    public function delete($id = null)
    {
        if ($id != session()->get('id_user')) return redirect()->to('/profile');
        
        $user = $this->userModel->find($id);
        
        // Hapus fisik foto
        if ($user && !empty($user['foto']) && $user['foto'] != 'default.png') {
            if (file_exists('uploads/users/' . $user['foto'])) {
                unlink('uploads/users/' . $user['foto']);
            }
        }

        $this->userModel->delete($id);
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Akun berhasil dihapus.');
    }
}