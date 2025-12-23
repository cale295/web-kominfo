<?php

namespace App\Controllers\backend;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\AccessRightsModel;

class UserController extends BaseController
{
    protected $userModel;
    protected $accessRightsModel;
    protected $module = 'manage_user';
    protected $uploadPath = 'uploads/users'; // Pastikan folder ini ada dan writable

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

        if (!$access || !$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak memiliki hak akses melihat data user.');
        }

        $users = $this->userModel->findAll();

        $data = [
            'title'      => 'Manajemen User',
            'users'      => $users,
            'totalUsers' => count($users),
            'admin'      => $this->userModel->where('role', 'admin')->countAllResults(),
            'editor'     => $this->userModel->where('role', 'editor')->countAllResults(),
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
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/manage_user')->with('error', 'Akses ditolak.');
        }

        // 1. Ambil Input (PERBAIKAN: Gunakan 'id_user')
        $idUser   = $this->request->getPost('id_user'); // NIK atau NIP
        $tipeUser = $this->request->getPost('tipe_user'); // pegawai / non_pegawai

        // 2. Cek Duplikasi ID (NIK/NIP) secara Manual
        // Ini memastikan error muncul spesifik jika ID sudah ada di DB
        if ($this->userModel->find($idUser)) {
            return redirect()->back()->withInput()->with('errors', [
                'id_user' => 'NIK/NIP ini sudah terdaftar di sistem.'
            ]);
        }

        // 3. Logika Username & Email (Untuk Pegawai)
        if ($tipeUser === 'pegawai') {
            // Pegawai tidak input username/email, jadi kita generate otomatis
            $username = $idUser; 
            $email    = $idUser . '@internal.system'; // Dummy email unik
        } else {
            // Masyarakat umum input manual
            $username = $this->request->getPost('username');
            $email    = $this->request->getPost('email');
        }

        // 4. Manipulasi Request Data untuk Validasi
        // Kita gabungkan data generate (pegawai) ke dalam request agar bisa divalidasi
        $this->request->setGlobal('post', array_merge($this->request->getPost(), [
            'username' => $username,
            'email'    => $email
        ]));

        // 5. Rules Validasi
        // Catatan: Pastikan nama tabel di 'is_unique' benar (misal: m_users atau users)
        $rules = [
            'id_user'   => 'required', // Validasi dasar agar tidak kosong
            'full_name' => 'required',
            'username'  => 'required|is_unique[m_users.username]',
            'email'     => 'required|valid_email|is_unique[m_users.email]',
            'password'  => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]',
            'foto' => [
                'rules' => 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Maksimal ukuran foto 2MB',
                    'is_image' => 'File yang diupload bukan gambar',
                    'mime_in'  => 'Format harus JPG atau PNG'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 6. Siapkan Data Insert
        $data = [
            'id_user'   => $idUser, // Primary Key
            'full_name' => $this->request->getPost('full_name'),
            'username'  => $username,
            'password'  => $this->request->getPost('password'), // Model harus handle hash (beforeInsert) atau hash disini manual
            'email'     => $email,
            'role'      => $this->request->getPost('role'),
            'no_telp'   => $this->request->getPost('no_telp'),
        ];
        
        // Hash password manual jika di Model belum ada event callback
        // $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT); 

        // 7. Handle Foto
        $fileFoto = $this->request->getFile('foto');
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $fileName = $fileFoto->getRandomName();
            $fileFoto->move($this->uploadPath, $fileName);
            $data['foto'] = $fileName;
        } else {
            $data['foto'] = 'default.png';
        }

        // 8. Eksekusi Insert
        // Pastikan di UserModel properti $useAutoIncrement = false; karena kita input ID manual
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
            return redirect()->to('/manage_user')->with('error', 'Akses ditolak.');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/manage_user')->with('error', 'User tidak ditemukan.');
        }

        // Data yang akan diupdate (ID USER/NIK TIDAK BOLEH DIUBAH)
        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'username'  => $this->request->getPost('username'),
            'email'     => $this->request->getPost('email'),
            'role'      => $this->request->getPost('role'),
            'no_telp'   => $this->request->getPost('no_telp'),
        ];

        // Handle Password (Jika diisi)
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            if ($password !== $this->request->getPost('password_confirm')) {
                return redirect()->back()->withInput()->with('errors', ['password_confirm' => 'Konfirmasi password tidak cocok.']);
            }
            // Hash password (atau biarkan Model handle jika ada callback)
            $data['password'] = $password; 
            // $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // Handle Foto
        $fileFoto = $this->request->getFile('foto');
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            // Hapus foto lama jika bukan default
            if ($user['foto'] && $user['foto'] != 'default.png' && file_exists($this->uploadPath . '/' . $user['foto'])) {
                unlink($this->uploadPath . '/' . $user['foto']);
            }
            
            $fileName = $fileFoto->getRandomName();
            $fileFoto->move($this->uploadPath, $fileName);
            $data['foto'] = $fileName;
        }

        // Override Validation Rules untuk Update
        // PENTING: parameter ke-4 is_unique adalah value ID yang sedang diedit agar tidak dianggap duplikat diri sendiri
        // Format: is_unique[tabel.kolom,kolom_id,nilai_id]
        
        $this->userModel->setValidationRule('username', "required|is_unique[m_users.username,id_user,{$id}]");
        $this->userModel->setValidationRule('email', "required|valid_email|is_unique[m_users.email,id_user,{$id}]");
        
        // Password opsional saat update
        $this->userModel->setValidationRule('password', 'permit_empty|min_length[8]');

        if (!$this->userModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }

        return redirect()->to('/manage_user')->with('success', 'Data user berhasil diperbarui.');
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

        // Hapus file foto dari server
        if ($user['foto'] && $user['foto'] != 'default.png' && file_exists($this->uploadPath . '/' . $user['foto'])) {
            unlink($this->uploadPath . '/' . $user['foto']);
        }

        $this->userModel->delete($id);
        return redirect()->to('/manage_user')->with('success', 'User berhasil dihapus.');
    }

    // ========================================================
    // Bulk Delete
    // ========================================================
    public function deleteSelected()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) {
            return redirect()->to('/manage_user')->with('error', 'Kamu tidak punya izin menghapus user.');
        }

        $userIds = $this->request->getPost('user_ids');
        if (empty($userIds)) {
            return redirect()->back()->with('error', 'Tidak ada pengguna yang dipilih untuk dihapus.');
        }

        // Loop untuk menghapus foto fisik masing-masing user
        $usersToDelete = $this->userModel->whereIn('id_user', $userIds)->findAll();
        foreach ($usersToDelete as $user) {
            if ($user['foto'] && $user['foto'] != 'default.png' && file_exists($this->uploadPath . '/' . $user['foto'])) {
                unlink($this->uploadPath . '/' . $user['foto']);
            }
        }

        $this->userModel->delete($userIds);
        $count = count($userIds);
        return redirect()->to('manage_user')->with('success', "Berhasil menghapus {$count} pengguna.");
    }

    // ========================================================
    // Detail User
    // ========================================================
    public function show($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('/manage_user')->with('error', 'User tidak ditemukan.');
        }

        $data = [
            'title' => 'Detail User',
            'user'  => $user
        ];

        return view('pages/manage_user/show', $data);
    }

    // ========================================================
    // FUNGSI BANTU
    // ========================================================
    private function getAccess($role)
    {
        return $this->accessRightsModel
            ->where('role', $role)
            ->where('module_name', $this->module)
            ->first();
    }
}