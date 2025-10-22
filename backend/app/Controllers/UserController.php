<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\AccessRightsModel; // Tambahkan model ini untuk hak akses

class UserController extends BaseController
{
    protected $userModel;
    protected $accessRightsModel;
    protected $module = 'manage_user'; // <=== ini module_name untuk access_rights

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
        // ✅ Cek akses dulu (misal hanya yang punya can_read boleh lihat)
        $role = session()->get('role');
        $access = $this->accessRightsModel
            ->where('role', $role)
            ->where('module_name', $this->module)
            ->first();

        if (!$access || !$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat data user.');
        }

        // Ambil semua data user dari database
        $users = $this->userModel->findAll();

        // Hitung total per role
        $totalUsers = count($users);
        $admin = $this->userModel->where('role', 'admin')->countAllResults();
        $editor = $this->userModel->where('role', 'editor')->countAllResults();
        $superadmin = $this->userModel->where('role', 'superadmin')->countAllResults();

        // Kirim ke view
        $data = [
            'title' => 'Manajemen User',
            'users' => $users,
            'totalUsers' => $totalUsers,
            'admin' => $admin,
            'editor' => $editor,
            'superadmin' => $superadmin
        ];

        // Tampilkan ke halaman index
        return view('pages/manage_user/index', $data);
    }

    // ========================================================
    // GET /manage_user/new → tampilkan form tambah user
    // ========================================================
    public function new()
    {
        $role = session()->get('role');
        $access = $this->accessRightsModel
            ->where('role', $role)
            ->where('module_name', $this->module)
            ->first();

        if (!$access || !$access['can_create']) {
            return redirect()->to('/manage_user')->with('error', 'Kamu tidak punya izin menambah user.');
        }

        return view('pages/manage_user/create');
    }

    // ========================================================
    // POST /manage_user → simpan user baru
    // ========================================================
    public function create()
    {
        $role = session()->get('role');
        $access = $this->accessRightsModel
            ->where('role', $role)
            ->where('module_name', $this->module)
            ->first();

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

    // dst... (update dan delete tinggal ditambah pengecekan akses seperti di atas)
}
