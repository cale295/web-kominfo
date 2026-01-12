<?php

namespace App\Controllers\backend;

use App\Controllers\BaseController;
use App\Models\MenuModel;
use App\Models\AccessRightsModel;
use App\Models\DocumentCategoryModel;

class MenuController extends BaseController
{
    protected $menuModel;
    protected $accessRightsModel;
    protected $kategoriModel;
    protected $module = 'menu'; // Nama modul untuk hak akses

    public function __construct()
    {
        $this->menuModel = new MenuModel();
        $this->accessRightsModel = new AccessRightsModel();
        $this->kategoriModel = new DocumentCategoryModel();
    }

    // ========================================================
    // GET /menu → tampilkan semua menu
    // ========================================================
    public function index()
    {
        $role = session()->get('role');
        $access = $this->getAccess($role);

        if (!$access) {
            return view('pages/menu/index', [
                'title' => 'Manajemen Menu',
                'menus' => [],
                'can_create' => false,
                'can_update' => false,
                'can_delete' => false,
                'error' => '⚠ Kamu tidak memiliki hak akses ke modul ini.'
            ]);
        }

        if (!$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat menu.');
        }

        $menus = $this->menuModel
            ->orderBy('parent_id', 'ASC')
            ->orderBy('order_number', 'ASC')
            ->orderBy('id_menu', 'ASC')
            ->findAll();

        $data = [
            'title' => 'Manajemen Menu',
            'menus' => $menus,
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
            'error' => null,
        ];

        return view('pages/menu/index', $data);
    }

    // ========================================================
    // GET /menu/{id} → detail menu
    // ========================================================
    public function show($id = null)
    {
        $access = $this->getAccess(session()->get('role'));

        if (!$access || !$access['can_read']) {
            return redirect()->to('/menu')->with('error', 'Kamu tidak punya izin melihat menu.');
        }

        $menu = $this->menuModel->find($id);
        if (!$menu) {
            return redirect()->to('/menu')->with('error', 'Menu tidak ditemukan.');
        }

        $data = [
            'title' => 'Detail Menu',
            'menu'  => $menu,
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ];

        return view('pages/menu/show', $data);
    }

    // ========================================================
    // GET /menu/new → tampilkan form tambah menu
    // ========================================================
    public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/menu')->with('error', 'Kamu tidak punya izin menambah menu.');
        }

        // 🟢 Ambil semua menu utama untuk dropdown parent
        $menus = $this->menuModel
            ->where('parent_id', 0)
            ->orderBy('menu_name', 'ASC')
            ->findAll();

        $data = [
            'title' => 'Tambah Menu Baru',
            'menus' => $menus,
            'can_create' => $access['can_create']
        ];

        return view('pages/menu/create', $data);
    }

    // ========================================================
    // POST /menu → simpan menu baru
    // ========================================================
    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/menu')->with('error', 'Kamu tidak punya izin menambah menu.');
        }

        $namaMenu = $this->request->getPost('menu_name');
        $parentId = $this->request->getPost('parent_id') ?: 0;
        $menuUrl  = $this->request->getPost('menu_url'); // Default input user

        // --- LOGIKA OTOMATIS KATEGORI DOKUMEN ---
        // 1. Cari ID menu 'Informasi Publik' (sesuaikan string namanya dengan di DB kamu)
        $parentInfoPublik = $this->menuModel->where('menu_name', 'Informasi Publik')->first();
        
        // 2. Cek apakah parent yang dipilih adalah 'Informasi Publik'
        if ($parentInfoPublik && $parentId == $parentInfoPublik['id_menu']) {
            
            // Buat slug bersih (contoh: Laporan Keuangan -> laporan-keuangan)
            $slug = url_title($namaMenu, '-', true);

            // Cek apakah kategori sudah ada (mencegah duplikat)
            $existingCat = $this->kategoriModel->where('slug_kategori', $slug)->first();
            
            if (!$existingCat) {
                // Insert ke tabel m_document_categories
                $this->kategoriModel->save([
                    'nama_kategori' => $namaMenu,
                    'slug_kategori' => $slug
                ]);
            }

            // 3. Override/Paksa URL menjadi format dinamis agar connect ke DocumentController
            $menuUrl = '/informasi-publik/' . $slug;
        }
        // ----------------------------------------

        $data = [
            'menu_name'     => $namaMenu,
            'menu_url'      => $menuUrl, // Gunakan URL yang sudah diproses
            'admin_url'     => $menuUrl,
            'menu_icon'     => $this->request->getPost('menu_icon'),
            'parent_id'     => $parentId,
            'order_number'  => $this->request->getPost('order_number') ?: 0,
            'status'        => $this->request->getPost('status') ?: 'active',
            'allowed_roles' => $this->request->getPost('allowed_roles'),
        ];

        if (!$this->menuModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->menuModel->errors());
        }

        return redirect()->to('/menu')->with('success', 'Menu berhasil ditambahkan' . ($parentId == ($parentInfoPublik['id_menu'] ?? -1) ? ' & Kategori Dokumen dibuat.' : '.'));
    }
    // ========================================================
    // GET /menu/{id}/edit → form edit menu
    // ========================================================
    public function edit($id = null)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/menu')->with('error', 'Kamu tidak punya izin mengedit menu.');
        }

        $menu = $this->menuModel->find($id);
        if (!$menu) {
            return redirect()->to('/menu')->with('error', 'Menu tidak ditemukan.');
        }

        // Ambil semua menu lain sebagai pilihan parent
        $menus = $this->menuModel
            ->where('id_menu !=', $id)
            ->orderBy('menu_name', 'ASC')
            ->findAll();

        $data = [
            'title' => 'Edit Menu',
            'menu'  => $menu,
            'menus' => $menus,
            'can_update' => $access['can_update'],
        ];

        return view('pages/menu/edit', $data);
    }

    // ========================================================
    // PUT /menu/{id} → update menu
    // ========================================================
    public function update($id = null)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/menu')->with('error', 'Kamu tidak punya izin mengubah menu.');
        }

        $menu = $this->menuModel->find($id);
        if (!$menu) {
            return redirect()->to('/menu')->with('error', 'Menu tidak ditemukan.');
        }

        $namaMenu = $this->request->getPost('menu_name');
        $parentId = $this->request->getPost('parent_id') ?: 0;
        $menuUrl  = $this->request->getPost('menu_url');

        // --- LOGIKA UPDATE (OPSIONAL) ---
        // Jika parent dipindah ke Informasi Publik, atau nama diubah, kita bisa update kategori juga
        // Tapi untuk keamanan, biasanya update nama menu TIDAK otomatis update nama kategori 
        // agar tidak merusak link file lama.
        // Kode di bawah hanya memastikan URL tetap benar jika parentnya Informasi Publik.
        
        $parentInfoPublik = $this->menuModel->where('menu_name', 'Informasi Publik')->first();

        if ($parentInfoPublik && $parentId == $parentInfoPublik['id_menu']) {
            // Jika user tidak mengisi URL atau URL lama salah, kita perbaiki
            // Generate slug baru
            $slug = url_title($namaMenu, '-', true);
            
            // Paksa URL sesuai format controller dinamis
            $menuUrl = 'informasi-publik/' . $slug;

            // Note: Disini saya TIDAK mengupdate tabel kategori otomatis saat edit
            // karena berisiko memutuskan relasi dengan dokumen yang sudah ada.
            // Kategori sebaiknya diedit lewat master kategori jika salah nama.
        }
        // --------------------------------

        $order = $this->request->getPost('order_number');
        $data = [
            'menu_name'     => $namaMenu,
            'menu_url'      => $menuUrl,
            'admin_url'     => $this->request->getPost('admin_url'),
            'menu_icon'     => $this->request->getPost('menu_icon'),
            'parent_id'     => $parentId,
            'order_number'  => ($order === null ? $menu['order_number'] : $order),
            'status'        => $this->request->getPost('status') ?: 'active',
            'allowed_roles' => $this->request->getPost('allowed_roles'),
        ];

        if (!$this->menuModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->menuModel->errors());
        }

        return redirect()->to('/menu')->with('success', 'Menu berhasil diperbarui.');
    }

    // ========================================================
    // DELETE /menu/{id} → hapus menu
    // ========================================================
    public function delete($id = null)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) {
            return redirect()->to('/menu')->with('error', 'Kamu tidak punya izin menghapus menu.');
        }

        $menu = $this->menuModel->find($id);
        if (!$menu) {
            return redirect()->to('/menu')->with('error', 'Menu tidak ditemukan.');
        }

        $this->menuModel->delete($id);
        return redirect()->to('/menu')->with('success', 'Menu berhasil dihapus.');
    }

    // ========================================================
    // Toggle status aktif/nonaktif menu
    // ========================================================
    public function toggleStatus($id)
    {
        $menu = $this->menuModel->find($id);

        if (!$menu) {
            return $this->response->setJSON(['success' => false, 'message' => 'Menu tidak ditemukan']);
        }

        $newStatus = ($menu['status'] === 'active') ? 'inactive' : 'active';
        $this->menuModel->update($id, ['status' => $newStatus]);

        return $this->response->setJSON([
            'success' => true,
            'newStatus' => $newStatus
        ]);
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
