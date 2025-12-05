<?php

namespace App\Controllers\frontend;

use App\Models\frontend\IpPenyediaModel;
use App\Models\AccessRightsModel;
use App\Controllers\BaseController;

class IpPenyediaController extends BaseController
{
    protected $ipPenyediaModel;
    protected $accessRightsModel;
    protected $module = 'ip_penyedia'; // Pastikan modul ini terdaftar di DB permission

    public function __construct()
    {
        $this->ipPenyediaModel = new IpPenyediaModel();
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

        $data = $this->ipPenyediaModel->orderBy('created_at', 'DESC')->findAll();

        return view('pages/ip_penyedia/index', [
            'ip_penyedia' => $data,
            'can_create'  => $access['can_create'],
            'can_update'  => $access['can_update'],
            'can_delete'  => $access['can_delete']
        ]);
    }

    public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/ip_penyedia')->with('error', 'Akses ditolak.');
        }
        return view('pages/ip_penyedia/create');
    }

    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) return redirect()->to('/ip_penyedia');

        $data = [
            'id_rup'           => $this->request->getPost('id_rup'),
            'nama_paket'       => $this->request->getPost('nama_paket'),
            'jenis_pengadaan'  => $this->request->getPost('jenis_pengadaan'),
            'metode_pengadaan' => $this->request->getPost('metode_pengadaan'),
            'jumlah_pagu'      => $this->request->getPost('jumlah_pagu'),
        ];

        if (!$this->ipPenyediaModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->ipPenyediaModel->errors());
        }

        return redirect()->to('/ip_penyedia')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/ip_penyedia')->with('error', 'Akses ditolak.');
        }

        $item = $this->ipPenyediaModel->find($id);
        if (!$item) {
            return redirect()->to('/ip_penyedia')->with('error', 'Data tidak ditemukan.');
        }

        return view('pages/ip_penyedia/edit', ['item' => $item]);
    }

    public function update($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) return redirect()->to('/ip_penyedia');

        $oldData = $this->ipPenyediaModel->find($id);
        if (!$oldData) return redirect()->to('/ip_penyedia')->with('error', 'Data tidak ditemukan.');

        $data = [
            'id'               => $id,
            'id_rup'           => $this->request->getPost('id_rup'),
            'nama_paket'       => $this->request->getPost('nama_paket'),
            'jenis_pengadaan'  => $this->request->getPost('jenis_pengadaan'),
            'metode_pengadaan' => $this->request->getPost('metode_pengadaan'),
            'jumlah_pagu'      => $this->request->getPost('jumlah_pagu'),
        ];

        if (!$this->ipPenyediaModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->ipPenyediaModel->errors());
        }

        return redirect()->to('/ip_penyedia')->with('success', 'Data berhasil diperbarui.');
    }

    public function delete($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) return redirect()->to('/ip_penyedia');

        $data = $this->ipPenyediaModel->find($id);
        if ($data) {
            $this->ipPenyediaModel->delete($id);
            return redirect()->to('/ip_penyedia')->with('success', 'Data berhasil dihapus.');
        }

        return redirect()->to('/ip_penyedia')->with('error', 'Gagal menghapus data.');
    }
}