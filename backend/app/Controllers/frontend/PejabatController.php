<?php

namespace App\Controllers\frontend;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\frontend\PejabatModel;
use App\Models\AccessRightsModel;

class PejabatController extends BaseController
{
    protected $pejabatModel;
    protected $accessRightsModel;

    protected $module = 'pejabat';

    public function __construct()
    {
        $this->pejabatModel = new PejabatModel();
        $this->accessRightsModel = new AccessRightsModel();
    }
    private function getAccess($role)
    {
        $access = $this->accessRightsModel->where('role', $role)->where('module_name', $this->module)->first();
        if (!$access)
            return ['can_create' => false, 'can_read' => false, 'can_update' => false, 'can_delete' => false];
        return [
            'can_create' => (bool) $access['can_create'],
            'can_read' => (bool) $access['can_read'],
            'can_update' => (bool) $access['can_update'],
            'can_delete' => (bool) $access['can_delete'],
        ];
    }
    public function index()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat berita.');
        }
        $role = session()->get('role');
        $access = $this->getAccess($role);

        if (!$access) {
            return view('pages/pejabat/index', [
                'pejabat' => [],
                'error' => '⚠ Kamu tidak memiliki hak akses ke modul ini.'
            ]);
        }

        if (!$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat agenda.');
        }

        $pejabat = $this->pejabatModel->orderBy('created_at', 'DESC')->findAll();

        $data = [
            'pejabat' => $pejabat,
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ];

        return view('pages/pejabat/index', $data);
    }

    public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/pejabat')->with('error', 'Kamu tidak punya izin menambah pejabat.');
        }
        return view('pages/pejabat/create');

    }

    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/pejabat')->with('error', 'Kamu tidak punya izin menambah menu_profile.');
        }
        $data = [
            'nama' => $this->request->getPost('nama'),
            'nip' => $this->request->getPost('nip'),
            'jabatan' => $this->request->getPost('jabatan'),
            'slug' => url_title($this->request->getPost('jabatan'), '-', true),
            'urutan' => $this->request->getPost('urutan'),
            'hash' => md5(uniqid()),
            'is_active' => $this->request->getPost('is_active') ?? 1,
        ];
        if ($img = $this->request->getFile('foto')) {
            if ($img->isValid() && !$img->hasMoved()) {
                $newName = $img->getRandomName();
                $img->move(FCPATH . 'uploads/pejabat/', $newName); // Gunakan FCPATH
                $data['foto'] = $newName;
            }
        }
        if (!$this->pejabatModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->pejabatModel->errors());
        }
        return redirect()->to('/pejabat')->with('success', 'pejabat berhasil ditambahkan.');
    }
}
