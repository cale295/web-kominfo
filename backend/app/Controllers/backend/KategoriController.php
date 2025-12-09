<?php

namespace App\Controllers\backend;

use App\Controllers\BaseController;use App\Models\KategoriModel;
use App\Models\AccessRightsModel;

class KategoriController extends BaseController
{
    protected $kategoriModel;
    protected $accessRightsModel;
    protected $module = 'berita_kategori';

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
        $this->accessRightsModel = new AccessRightsModel();
    }

    // ========================================================
    // Tampilkan semua kategori
    // ========================================================
    public function index()
    {
        $access = $this->getAccess(session()->get('role'));

        if (!$access) {
            return view('pages/kategori/index', [
                'title' => 'Kategori',
                'kategori' => [],
                'error' => '⚠ Kamu tidak memiliki hak akses ke modul ini.'
            ]);
        }

        if (!$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat kategori.');
        }

        $data = [
            'title' => 'Manajemen Kategori',
            'kategori' => $this->kategoriModel->where('trash', '0')->findAll(),
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ];

        return view('pages/kategori/index', $data);
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
        $model = new \App\Models\KategoriModel(); // <--- GANTI INI SESUAI MODUL
        // ==================================================

        $id = $this->request->getPost('id');
        $data = $model->find($id);

        if ($data) {
            // Logic Toggle (1 -> 0, 0 -> 1)
            $newStatus = ($data['status'] == '1') ? '0' : '1';

            // Data Update (Termasuk Audit Trail)
            $updateData = [
                'status'            => $newStatus,
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

    // ========================================================
    // Tampilkan sampah
    // ========================================================
    public function trash()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat sampah kategori.');
        }

        $data = [
            'title' => 'Sampah Kategori',
            'kategori' => $this->kategoriModel->where('trash', '1')->findAll(),
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ];

        return view('pages/kategori/trash', $data);
    }

    // ========================================================
    // Form tambah kategori
    // ========================================================
public function new()
{
    $access = $this->getAccess(session()->get('role'));
    if (!$access || !$access['can_create']) {
        return redirect()->to('/kategori')->with('error', 'Kamu tidak punya izin menambah kategori.');
    }

    $data = [
        'title' => 'Tambah Kategori',
        'kategori' => $this->kategoriModel->where('trash', '0')->findAll() // untuk parent category
    ];

    return view('pages/kategori/create', $data);
}

    // ========================================================
    // Simpan kategori baru
    // ========================================================
public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/kategori')->with('error', 'Kamu tidak punya izin menambah kategori.');
        }

        // --- TAMBAHAN: Validasi Manual ---
        $inputSorting = $this->request->getPost('sorting_nav');
        
        // Cek apakah nilai lebih dari 9
        if ($inputSorting > 9) {
            return redirect()->back()->withInput()->with('error', 'Urutan Navigasi (Sorting) maksimal angka 9.');
        }
        // ---------------------------------

        $data = [
            'id_parent'   => $this->request->getPost('id_parent'),
            'hash'        => md5(uniqid()),
            'kategori'    => $this->request->getPost('kategori'),
            'slug'        => url_title($this->request->getPost('kategori'), '-', true),
            'keterangan'  => $this->request->getPost('keterangan'),
            'status'      => $this->request->getPost('status') ?? 'active',
            'is_show_nav' => $this->request->getPost('is_show_nav') ?? '0',
            'sorting_nav' => $inputSorting, // Gunakan variabel yang sudah divalidasi
        ];

        if (!$this->kategoriModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->kategoriModel->errors());
        }

        return redirect()->to('/kategori')->with('success', 'Kategori berhasil ditambahkan.');
    }

    // ========================================================
    // Tampilkan detail kategori
    // ========================================================
    public function show($id = null)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_read']) {
            return redirect()->to('/kategori')->with('error', 'Kamu tidak punya izin melihat kategori.');
        }

        $kategori = $this->kategoriModel->find($id);
        if (!$kategori) {
            return redirect()->to('/kategori')->with('error', 'Kategori tidak ditemukan.');
        }

        return view('pages/kategori/show', [
            'title' => 'Detail Kategori',
            'kategori' => $kategori,
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ]);
    }

    // ========================================================
    // Form edit kategori
    // ========================================================
    public function edit($id = null)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/kategori')->with('error', 'Kamu tidak punya izin mengedit kategori.');
        }

        $kategori = $this->kategoriModel->find($id);
        if (!$kategori || $kategori['trash'] == '1') {
            return redirect()->to('/kategori')->with('error', 'Kategori tidak ditemukan.');
        }

        return view('pages/kategori/edit', [
            'title' => 'Edit Kategori',
            'kategori' => $kategori,
            'can_update' => $access['can_update'],
        ]);
    }

    // ========================================================
    // Update kategori
    // ========================================================
public function update($id = null)
{
    $kategori = $this->kategoriModel->find($id);
    if (!$kategori) {
        return redirect()->to('/kategori')->with('error', 'Kategori tidak ditemukan.');
    }

    $kategoriBaru = $this->request->getPost('kategori');
    $slugBaru = url_title($kategoriBaru, '-', true);

    $data = [
        'id_parent'   => $this->request->getPost('id_parent'),
        'kategori'    => $kategoriBaru,
        'slug'        => $slugBaru,
        'keterangan'  => $this->request->getPost('keterangan'),
        'status'      => $this->request->getPost('status'),
        'is_show_nav' => $this->request->getPost('is_show_nav') ?? '0',
        'sorting_nav' => $this->request->getPost('sorting_nav'),
    ];

    // ❌ Nonaktifkan validasi model untuk update
    $this->kategoriModel->skipValidation(true)->update($id, $data);

    return redirect()->to('/kategori')->with('success', 'Kategori berhasil diperbarui.');
}


    // ========================================================
    // Soft delete → ubah trash jadi '1'
    // ========================================================
    public function delete($id = null)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) {
            return redirect()->to('/kategori')->with('error', 'Kamu tidak punya izin menghapus tag$tag.');
        }

        $kategori = $this->kategoriModel->find($id);

        // =======================================================================
        // PERBAIKAN: Tambahkan FCPATH. Path 'uploads/pages/tag$tag/...' saja tidak akan
        // ditemukan. Harus FCPATH . 'uploads/pages/tag$tag/'


        if ($this->kategoriModel->delete($id)) {
            return redirect()->to('/kategori')->with('success', 'tag berhasil dihapus.');
        } else {
            return redirect()->to('/kategori')->with('error', 'Gagal menghapus tag.');
        }

    }

    // ========================================================
    // Fungsi bantu untuk ambil akses role
    // ========================================================
    private function getAccess($role)
    {
        $access = $this->accessRightsModel
            ->where('role', $role)
            ->where('module_name', $this->module)
            ->first();

        if (!$access) return false;

        return [
            'can_create' => (bool) $access['can_create'],
            'can_read'   => (bool) $access['can_read'],
            'can_update' => (bool) $access['can_update'],
            'can_delete' => (bool) $access['can_delete'],
        ];
    }
}
