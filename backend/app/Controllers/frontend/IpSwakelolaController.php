<?php

namespace App\Controllers\frontend;

use App\Models\frontend\IpSwakelolaModel;
use App\Models\AccessRightsModel;
use App\Controllers\BaseController;

class IpSwakelolaController extends BaseController
{
    protected $ipSwakelolaModel;
    protected $accessRightsModel;
    protected $module = 'ip_swakelola'; // Pastikan modul ini terdaftar

    public function __construct()
    {
        $this->ipSwakelolaModel = new IpSwakelolaModel();
        $this->accessRightsModel = new AccessRightsModel();
    }

    private function getAccess($role)
    {
        $access = $this->accessRightsModel->where('role', $role)->where('module_name', $this->module)->first();
        if (!$access) return ['can_create' => false, 'can_read' => false, 'can_update' => false, 'can_delete' => false];
        return [
            'can_create' => (bool)$access['can_create'],
            'can_read'   => (bool)$access['can_read'],
            'can_update' => (bool)$access['can_update'],
            'can_delete' => (bool)$access['can_delete'],
        ];
    }

    public function index()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat modul ini.');
        }

        $data = $this->ipSwakelolaModel->orderBy('created_at', 'DESC')->findAll();

        return view('pages/ip_swakelola/index', [
            'ip_swakelola' => $data,
            'can_create'   => $access['can_create'],
            'can_update'   => $access['can_update'],
            'can_delete'   => $access['can_delete']
        ]);
    }

    public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/ip_swakelola')->with('error', 'Akses ditolak.');
        }
        return view('pages/ip_swakelola/create');
    }

    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) return redirect()->to('/ip_swakelola');

        $data = [
            'id_rup'      => $this->request->getPost('id_rup'),
            'nama_paket'  => $this->request->getPost('nama_paket'),
            'jumlah_pagu' => $this->request->getPost('jumlah_pagu'),
        ];

        if (!$this->ipSwakelolaModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->ipSwakelolaModel->errors());
        }

        return redirect()->to('/ip_swakelola')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/ip_swakelola')->with('error', 'Akses ditolak.');
        }

        $item = $this->ipSwakelolaModel->find($id);
        if (!$item) {
            return redirect()->to('/ip_swakelola')->with('error', 'Data tidak ditemukan.');
        }

        return view('pages/ip_swakelola/edit', ['item' => $item]);
    }

    public function update($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) return redirect()->to('/ip_swakelola');

        $oldData = $this->ipSwakelolaModel->find($id);
        if (!$oldData) return redirect()->to('/ip_swakelola')->with('error', 'Data tidak ditemukan.');

        $data = [
            'id'          => $id,
            'id_rup'      => $this->request->getPost('id_rup'),
            'nama_paket'  => $this->request->getPost('nama_paket'),
            'jumlah_pagu' => $this->request->getPost('jumlah_pagu'),
        ];

        if (!$this->ipSwakelolaModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->ipSwakelolaModel->errors());
        }

        return redirect()->to('/ip_swakelola')->with('success', 'Data berhasil diperbarui.');
    }

    public function delete($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) return redirect()->to('/ip_swakelola');

        $data = $this->ipSwakelolaModel->find($id);
        if ($data) {
            $this->ipSwakelolaModel->delete($id);
            return redirect()->to('/ip_swakelola')->with('success', 'Data berhasil dihapus.');
        }

        return redirect()->to('/ip_swakelola')->with('error', 'Gagal menghapus data.');
    }
}