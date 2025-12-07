<?php

namespace App\Controllers\frontend;

use App\Models\frontend\PpidPermohonanModel;
use App\Models\AccessRightsModel;
use App\Controllers\BaseController;

class PpidPermohonanController extends BaseController
{
    protected $ppidModel;
    protected $accessRightsModel;
    protected $module = 'ppid_permohonan'; // Pastikan terdaftar di Access Rights

    public function __construct()
    {
        $this->ppidModel = new PpidPermohonanModel();
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
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        // Urutkan dari yang terbaru (Pending paling atas biasanya)
        $data = $this->ppidModel->orderBy('created_at', 'DESC')->findAll();

        return view('pages/ppid_permohonan/index', [
            'permohonan' => $data,
            // can_create kita set false atau tidak dipakai di view karena input via API
            'can_create' => false, 
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete']
        ]);
    }

    // Disable Create View Manual
    public function new()
    {
        return redirect()->to('/ppid_permohonan')->with('error', 'Input data hanya melalui Formulir Publik (API).');
    }

    // Disable Create Action Manual
    public function create()
    {
        return redirect()->to('/ppid_permohonan');
    }

    // Edit hanya untuk mengubah STATUS
    public function edit($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/ppid_permohonan')->with('error', 'Akses ditolak.');
        }

        $item = $this->ppidModel->find($id);
        if (!$item) {
            return redirect()->to('/ppid_permohonan')->with('error', 'Data tidak ditemukan.');
        }

        return view('pages/ppid_permohonan/edit', ['item' => $item]);
    }

    public function update($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) return redirect()->to('/ppid_permohonan');

        // Admin hanya boleh update STATUS
        $statusBaru = $this->request->getPost('status');
        
        $data = [
            'id_formulir' => $id,
            'status'      => $statusBaru,
        ];

        // Jika status berubah jadi diproses/selesai, update tanggal proses
        if (in_array($statusBaru, ['diproses', 'selesai', 'ditolak'])) {
            $data['tanggal_diproses'] = date('Y-m-d H:i:s');
        }

        // Kita gunakan skipValidation true karena data user lain (NIK dll) mungkin tidak dikirim ulang formnya
        // atau kita hanya update parsial.
        if (!$this->ppidModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->ppidModel->errors());
        }

        return redirect()->to('/ppid_permohonan')->with('success', 'Status permohonan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) return redirect()->to('/ppid_permohonan');

        if ($this->ppidModel->find($id)) {
            $this->ppidModel->delete($id);
            return redirect()->to('/ppid_permohonan')->with('success', 'Data berhasil dihapus.');
        }

        return redirect()->to('/ppid_permohonan')->with('error', 'Gagal menghapus data.');
    }
}