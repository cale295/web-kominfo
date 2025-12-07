<?php

namespace App\Controllers\frontend;

use App\Models\frontend\IpKerjasamaDaerahModel;
use App\Models\AccessRightsModel;
use App\Controllers\BaseController;

class IpKerjasamaDaerahController extends BaseController
{
    protected $kerjasamaModel;
    protected $accessRightsModel;
    protected $module = 'ip_kerjasama_daerah'; // Pastikan modul ini terdaftar

    public function __construct()
    {
        $this->kerjasamaModel = new IpKerjasamaDaerahModel();
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

        // Urutkan berdasarkan tanggal terbaru
        $data = $this->kerjasamaModel
            ->orderBy('tanggal', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('pages/ip_kerjasama_daerah/index', [
            'kerjasama'  => $data,
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete']
        ]);
    }

    public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/ip_kerjasama_daerah')->with('error', 'Akses ditolak.');
        }
        return view('pages/ip_kerjasama_daerah/create');
    }

    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) return redirect()->to('/ip_kerjasama_daerah');

        $data = [
            'tanggal' => $this->request->getPost('tanggal'),
            'nomor'   => $this->request->getPost('nomor'),
            'tentang' => $this->request->getPost('tentang'),
            'perihal' => $this->request->getPost('perihal'),
        ];

        if (!$this->kerjasamaModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->kerjasamaModel->errors());
        }

        return redirect()->to('/ip_kerjasama_daerah')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/ip_kerjasama_daerah')->with('error', 'Akses ditolak.');
        }

        $item = $this->kerjasamaModel->find($id);
        if (!$item) {
            return redirect()->to('/ip_kerjasama_daerah')->with('error', 'Data tidak ditemukan.');
        }

        return view('pages/ip_kerjasama_daerah/edit', ['item' => $item]);
    }

    public function update($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) return redirect()->to('/ip_kerjasama_daerah');

        $oldData = $this->kerjasamaModel->find($id);
        if (!$oldData) return redirect()->to('/ip_kerjasama_daerah')->with('error', 'Data tidak ditemukan.');

        $data = [
            'id'      => $id,
            'tanggal' => $this->request->getPost('tanggal'),
            'nomor'   => $this->request->getPost('nomor'),
            'tentang' => $this->request->getPost('tentang'),
            'perihal' => $this->request->getPost('perihal'),
        ];

        if (!$this->kerjasamaModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->kerjasamaModel->errors());
        }

        return redirect()->to('/ip_kerjasama_daerah')->with('success', 'Data berhasil diperbarui.');
    }

    public function delete($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) return redirect()->to('/ip_kerjasama_daerah');

        $data = $this->kerjasamaModel->find($id);
        if ($data) {
            $this->kerjasamaModel->delete($id);
            return redirect()->to('/ip_kerjasama_daerah')->with('success', 'Data berhasil dihapus.');
        }

        return redirect()->to('/ip_kerjasama_daerah')->with('error', 'Gagal menghapus data.');
    }
}