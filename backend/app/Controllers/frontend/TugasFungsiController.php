<?php

namespace App\Controllers\frontend;

use App\Models\frontend\TugasFungsiModel;
use App\Models\AccessRightsModel;
use App\Controllers\BaseController;

class TugasFungsiController extends BaseController
{
    protected $tugasModel;
    protected $accessRightsModel;
    protected $module = 'tugas_fungsi'; // Pastikan modul ini terdaftar di DB permission

    public function __construct()
    {
        $this->tugasModel = new TugasFungsiModel();
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

        // Urutkan berdasarkan Tipe lalu Order Number
        $data = $this->tugasModel
            ->orderBy('type', 'ASC')
            ->orderBy('order_number', 'ASC')
            ->findAll();

        return view('pages/tugas_fungsi/index', [
            'tugas_fungsi' => $data,
            'can_create'   => $access['can_create'],
            'can_update'   => $access['can_update'],
            'can_delete'   => $access['can_delete']
        ]);
    }

    public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/tugas_fungsi')->with('error', 'Akses ditolak.');
        }
        return view('pages/tugas_fungsi/create');
    }

    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) return redirect()->to('/tugas_fungsi');

        $data = [
            'type'         => $this->request->getPost('type'),
            'description'  => $this->request->getPost('description'),
            'order_number' => $this->request->getPost('order_number') ?? 0,
            'is_active'    => $this->request->getPost('is_active') ?? 0,
        ];

        if (!$this->tugasModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->tugasModel->errors());
        }

        return redirect()->to('/tugas_fungsi')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/tugas_fungsi')->with('error', 'Akses ditolak.');
        }

        $data = $this->tugasModel->find($id);
        if (!$data) {
            return redirect()->to('/tugas_fungsi')->with('error', 'Data tidak ditemukan.');
        }

        return view('pages/tugas_fungsi/edit', ['item' => $data]);
    }

    public function update($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) return redirect()->to('/tugas_fungsi');

        $oldData = $this->tugasModel->find($id);
        if (!$oldData) return redirect()->to('/tugas_fungsi')->with('error', 'Data tidak ditemukan.');

        $data = [
            'id_tugas'     => $id,
            'type'         => $this->request->getPost('type'),
            'description'  => $this->request->getPost('description'),
            'order_number' => $this->request->getPost('order_number') ?? 0,
            'is_active'    => $this->request->getPost('is_active') ?? 0,
        ];

        if (!$this->tugasModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->tugasModel->errors());
        }

        return redirect()->to('/tugas_fungsi')->with('success', 'Data berhasil diperbarui.');
    }

    public function delete($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) return redirect()->to('/tugas_fungsi');

        $data = $this->tugasModel->find($id);
        if ($data) {
            $this->tugasModel->delete($id);
            return redirect()->to('/tugas_fungsi')->with('success', 'Data berhasil dihapus.');
        }

        return redirect()->to('/tugas_fungsi')->with('error', 'Gagal menghapus data.');
    }
}