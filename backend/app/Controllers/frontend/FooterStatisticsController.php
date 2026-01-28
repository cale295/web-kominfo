<?php

namespace App\Controllers\frontend;

use App\Models\frontend\FooterStatisticsModel;
use App\Models\AccessRightsModel;
use App\Controllers\BaseController;

class FooterStatisticsController extends BaseController
{
    protected $statsModel;
    protected $accessRightsModel;

    protected $module = 'footer_statistics';

    public function __construct()
    {
        $this->statsModel = new FooterStatisticsModel();
        $this->accessRightsModel = new AccessRightsModel();
    }

    private function getAccess($role)
    {
        $access = $this->accessRightsModel->where('role', $role)->where('module_name', $this->module)->first();
        if (!$access)
            return ['can_create' => false, 'can_read' => false, 'can_update' => false, 'can_delete' => false];
        return [
            'can_create' => (bool) $access['can_create'],
            'can_read'   => (bool) $access['can_read'],
            'can_update' => (bool) $access['can_update'],
            'can_delete' => (bool) $access['can_delete'],
        ];
    }

    public function index()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat modul ini.');
        }

        // Jalankan Update Otomatis setiap kali halaman index dibuka
        $this->statsModel->syncAutoStats();

        $stats = $this->statsModel
            ->orderBy('sorting', 'ASC')
            ->findAll();

        $data = [
            'statistics' => $stats,
            'active_tab' => 'footer_statistics',
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ];

        return view('pages/footer_statistics/index', $data);
    }

    public function toggleStatus()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $role = session()->get('role');
        $access = $this->getAccess($role);

        if (!$access || !$access['can_update']) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Anda tidak memiliki izin untuk mengubah data ini.',
                'token' => csrf_hash()
            ]);
        }

        $model = new \App\Models\frontend\FooterStatisticsModel();
        $id = $this->request->getPost('id');
        $data = $model->find($id);

        if ($data) {
            $newStatus = ($data['is_active'] == '1') ? '0' : '1';

            $updateData = [
                'is_active'       => $newStatus,
                'updated_at'      => date('Y-m-d H:i:s'),
                'updated_by_id'   => session()->get('id_user'),
                'updated_by_name' => session()->get('username'),
            ];

            if ($model->update($id, $updateData)) {
                return $this->response->setJSON([
                    'status'    => 'success',
                    'message'   => 'Status berhasil diperbarui',
                    'newStatus' => $newStatus,
                    'token'     => csrf_hash()
                ]);
            }
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Gagal update status atau data tidak ditemukan',
            'token'   => csrf_hash()
        ]);
    }

    public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/footer_statistics')->with('error', 'Kamu tidak punya izin menambah data.');
        }
        return view('pages/footer_statistics/create');
    }

    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/footer_statistics')->with('error', 'Kamu tidak punya izin menambah data.');
        }

        // Tentukan auto_update berdasarkan tipe statistik
        $stat_type = $this->request->getPost('stat_type');
        $auto_update = ($stat_type == 'manual') ? 0 : 1; // Hanya auto update jika bukan manual

        $data = [
            'stat_type'     => $stat_type,
            'stat_label'    => $this->request->getPost('stat_label'),
            'stat_value'    => 0, // Default 0 karena auto update akan mengisi nanti
            'auto_update'   => $auto_update,
            'sorting'       => $this->request->getPost('sorting') ?? 0,
            'is_active'     => $this->request->getPost('is_active') ?? 0,
            'created_by_id' => session()->get('id_user'),
            'created_at'    => date('Y-m-d H:i:s'),
        ];

        if (!$this->statsModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->statsModel->errors());
        }

        return redirect()->to('/footer_statistics')->with('success', 'Data Statistik berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/footer_statistics')->with('error', 'Kamu tidak punya izin mengedit data.');
        }

        $stat = $this->statsModel->find($id);
        if (!$stat) {
            return redirect()->to('/footer_statistics')->with('error', 'Data tidak ditemukan.');
        }

        return view('pages/footer_statistics/edit', [
            'statistic' => $stat
        ]);
    }

    public function update($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/footer_statistics')->with('error', 'Kamu tidak punya izin mengupdate data.');
        }

        $oldData = $this->statsModel->find($id);
        if (!$oldData) {
            return redirect()->to('/footer_statistics')->with('error', 'Data tidak ditemukan.');
        }

        // Tentukan auto_update berdasarkan tipe statistik
        $stat_type = $this->request->getPost('stat_type');
        $auto_update = ($stat_type == 'manual') ? 0 : 1;

        $data = [
            'id_footer_statis' => $id,
            'stat_type'        => $stat_type,
            'stat_label'       => $this->request->getPost('stat_label'),
            'stat_value'       => $oldData['stat_value'], // Tetap pakai nilai yang ada
            'auto_update'      => $auto_update,
            'sorting'          => $this->request->getPost('sorting') ?? 0,
            'is_active'        => $this->request->getPost('is_active') ?? 0,
            'updated_by_id'    => session()->get('id_user'),
            'updated_at'       => date('Y-m-d H:i:s'),
        ];

        if (!$this->statsModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->statsModel->errors());
        }

        return redirect()->to('/footer_statistics')->with('success', 'Data Statistik berhasil diperbarui.');
    }

    public function delete($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) {
            return redirect()->to('/footer_statistics')->with('error', 'Kamu tidak punya izin menghapus data.');
        }

        $data = $this->statsModel->find($id);
        if (!$data) {
            return redirect()->to('/footer_statistics')->with('error', 'Data tidak ditemukan.');
        }

        $this->statsModel->delete($id);

        return redirect()->to('/footer_statistics')->with('success', 'Data berhasil dihapus permanen.');
    }
}