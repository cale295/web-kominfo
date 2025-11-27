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

        $stats = $this->statsModel
            ->orderBy('sorting', 'ASC')
            ->findAll();

        $data = [
            'statistics' => $stats,
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ];

        return view('pages/footer_statistics/index', $data);
    }

    public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/footer_statistics')->with('error', 'Kamu tidak punya izin menambah data.');
        }
        return view('pages/footer_statistics/create');
    }

    // =================================================================
    // CREATE
    // =================================================================
    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/footer_statistics')->with('error', 'Kamu tidak punya izin menambah data.');
        }

        $data = [
            'stat_type'   => $this->request->getPost('stat_type'),
            'stat_label'  => $this->request->getPost('stat_label'),
            'stat_value'  => $this->request->getPost('stat_value'),
            'stat_icon'   => $this->request->getPost('stat_icon'),
            'auto_update' => $this->request->getPost('auto_update') ?? 0,
            'sorting'     => $this->request->getPost('sorting') ?? 0,
            'is_active'   => $this->request->getPost('is_active') ?? 0,
            'created_by'  => session()->get('id_user'),
        ];

        if (!$this->statsModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->statsModel->errors());
        }

        return redirect()->to('/footer_statistics')->with('success', 'Data Statistik berhasil ditambahkan.');
    }

    // =================================================================
    // EDIT
    // =================================================================
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

    // =================================================================
    // UPDATE
    // =================================================================
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

        $data = [
            'id_footer_statis' => $id,
            'stat_type'        => $this->request->getPost('stat_type'),
            'stat_label'       => $this->request->getPost('stat_label'),
            'stat_value'       => $this->request->getPost('stat_value'),
            'stat_icon'        => $this->request->getPost('stat_icon'),
            'auto_update'      => $this->request->getPost('auto_update') ?? 0,
            'sorting'          => $this->request->getPost('sorting') ?? 0,
            'is_active'        => $this->request->getPost('is_active') ?? 0,
            'updated_by'       => session()->get('id_user'),
        ];

        if (!$this->statsModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->statsModel->errors());
        }

        return redirect()->to('/footer_statistics')->with('success', 'Data Statistik berhasil diperbarui.');
    }

    // =================================================================
    // DELETE
    // =================================================================
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