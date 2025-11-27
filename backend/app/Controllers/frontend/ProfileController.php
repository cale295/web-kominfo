<?php

namespace App\Controllers\frontend;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AccessRightsModel;
use App\Models\frontend\ProfileModel;

class ProfileController extends BaseController
{
    protected $profileModel;
    protected $accessRightsModel;
    protected $module = 'menu_profile';

     private function getAccess($role)
    {
        $access = $this->accessRightsModel->where('role', $role)->where('module_name', $this->module)->first();
        if (!$access) return ['can_create'=>false,'can_read'=>false,'can_update'=>false,'can_delete'=>false];
        return [
            'can_create' => (bool)$access['can_create'],
            'can_read' => (bool)$access['can_read'],
            'can_update' => (bool)$access['can_update'],
            'can_delete' => (bool)$access['can_delete'],
        ];
    }
    public function __construct()
    {
        $this->profileModel = new ProfileModel();
        $this->accessRightsModel = new AccessRightsModel();
    }
    public function index()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat berita.');
        }        $role = session()->get('role');
        $access = $this->getAccess($role);

        if (!$access) {
            return view('pages/menu_profile/index', [
                'menu_profiles' => [],
                'error'   => '⚠ Kamu tidak memiliki hak akses ke modul ini.'
            ]);
        }

        if (!$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat agenda.');
        }

        $menu_profiles = $this->profileModel->orderBy('created_at', 'DESC')->findAll();

        $data = [
            'menu_profiles'    => $menu_profiles,
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ];

        return view('pages/menu_profile/index', $data);
    }

    //function new

    public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/menu_profile')->with('error', 'Kamu tidak punya izin menambah menu_profile.');
        }
        return view('pages/menu_profile/create');
    }

    //function create
    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/menu_profile')->with('error', 'Kamu tidak punya izin menambah menu_profile.');
        }
        $data = [
            'id_parent' => $this->request->getPost('id_parent'),
            'type' => $this->request->getPost('type'),
            'title' => $this->request->getPost('title'),
            'slug' => url_title($this->request->getPost('title'), '-', true),
            'sorting' => $this->request->getPost('sorting'),
            'is_active' => $this->request->getPost('is_active')?? 1,
            'hash' => md5(uniqid()),
            'content' => $this->request->getPost('content'),
            'description' => $this->request->getPost('description'),
        ];
            if ($img = $this->request->getFile('image')) {
            if ($img->isValid() && !$img->hasMoved()) {
                $newName = $img->getRandomName();
                $img->move(FCPATH . 'uploads/menu_profile/', $newName); // Gunakan FCPATH
                $data['image'] = $newName;
            }
        }
        if (!$this->profileModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->profileModel->errors());
        }
        return redirect()->to('/menu_profile')->with('success', 'menu_profile berhasil ditambahkan.');
    }

        // =========================================================
    // EDIT VIEW
    // =========================================================
    public function edit($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/menu_profile')->with('error', 'Kamu tidak punya izin mengubah menu_profile.');
        }

        $menu_profile = $this->profileModel->find($id);
        if (!$menu_profile) {
            return redirect()->to('/menu_profile')->with('error', 'Data menu_profile tidak ditemukan.');
        }

        return view('pages/menu_profile/edit', [
            'menu_profile' => $menu_profile
        ]);
    }

    // =========================================================
    // UPDATE
    // =========================================================
public function update($id)
{
    $access = $this->getAccess(session()->get('role'));
    if (!$access || !$access['can_update']) {
        return redirect()->to('/menu_profile')->with('error', 'Kamu tidak punya izin memperbarui menu_profile.');
    }

    $menu_profile = $this->profileModel->find($id);
    if (!$menu_profile) {
        return redirect()->to('/menu_profile')->with('error', 'Data menu_profile tidak ditemukan.');
    }

    $post = $this->request->getPost();

    $data = [
        'id_profil'  => $id, // WAJIB! kalau tidak, save() bikin data baru
        'type'       => $post['type'] ?? $menu_profile['type'],
        'title'      => $post['title'] ?? $menu_profile['title'],
        'slug'       => url_title($post['title'], '-', true),
        'sorting'    => $post['sorting'] ?? $menu_profile['sorting'],
        'is_active'  => $post['is_active'] ?? $menu_profile['is_active'],
        'content'    => $post['content'] ?? $menu_profile['content'],
        'updated_at' => date('Y-m-d H:i:s'),
        'image'      => $menu_profile['image'], // default foto lama
    ];

    // ============================================
    // HANDLE UPLOAD FOTO TANPA MERESSET JIKA KOSONG
    // ============================================
    $image = $this->request->getFile('image');

    if ($image && $image->isValid() && !$image->hasMoved()) {

        // hapus foto lama
        if (!empty($menu_profile['image']) && file_exists(FCPATH . 'uploads/menu_profile/' . $menu_profile['image'])) {
            unlink(FCPATH . 'uploads/menu_profile/' . $menu_profile['image']);
        }

        $newName = $image->getRandomName();
        $image->move(FCPATH . 'uploads/menu_profile', $newName);

        $data['image'] = $newName;
    }

    // SIMPAN DATA DENGAN UPDATE SEBENARNYA
    if (!$this->profileModel->save($data)) {
        return redirect()->back()->withInput()->with('errors', $this->profileModel->errors());
    }

    return redirect()->to('/menu_profile')->with('success', 'menu_profile berhasil diperbarui.');
}


    // =========================================================
    // DELETE
    // =========================================================
    public function delete($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) {
            return redirect()->to('/menu_profile')->with('error', 'Kamu tidak punya izin menghapus menu_profile.');
        }

        $menu_profile = $this->profileModel->find($id);
        if (!$menu_profile) {
            return redirect()->to('/menu_profile')->with('error', 'Data profile tidak ditemukan.');
        }

        // Hapus foto
        if (!empty($menu_profile['image']) && file_exists(FCPATH . 'uploads/menu_profile/' . $menu_profile['image'])) {
            unlink(FCPATH . 'uploads/menu_profile/' . $menu_profile['image']);
        }

        $this->profileModel->delete($id);

        return redirect()->to('/menu_profile')->with('success', 'profile berhasil dihapus.');
    }
}

