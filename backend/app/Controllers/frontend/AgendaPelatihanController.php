<?php

namespace App\Controllers\frontend;

use App\Models\frontend\AgendaPelatihanModel;
use App\Models\AccessRightsModel;
use App\Controllers\BaseController;

class AgendaPelatihanController extends BaseController
{
    protected $agendaModel;
    protected $accessRightsModel;
    protected $module = 'agenda_pelatihan'; // Pastikan modul ini terdaftar

    public function __construct()
    {
        $this->agendaModel = new AgendaPelatihanModel();
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

        // Urutkan berdasarkan Tanggal Agenda Terbaru
        $data = $this->agendaModel
            ->orderBy('tanggal_agenda', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('pages/agenda_pelatihan/index', [
            'agenda'     => $data,
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete']
        ]);
    }
    public function toggleStatus()
    {
        // 1. Cek Request AJAX
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // 2. CEK HAK AKSES
        // Pastikan Controller punya property $this->accessRightsModel & fungsi getAccess()
        $role = session()->get('role');
        $access = $this->getAccess($role);

        if (!$access || !$access['can_update']) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Anda tidak memiliki izin untuk mengubah data ini.',
                'token' => csrf_hash()
            ]);
        }

        // 3. LOAD MODEL & AMBIL DATA
        // ==================================================
        $model = new \App\Models\frontend\AgendaPelatihanModel(); // <--- GANTI INI SESUAI MODUL
        // ==================================================

        $id = $this->request->getPost('id');
        $data = $model->find($id);

        if ($data) {
            // Logic Toggle (1 -> 0, 0 -> 1)
            $newStatus = ($data['status'] == '1') ? '0' : '1';

            // Data Update (Termasuk Audit Trail)
            $updateData = [
                'status'            => $newStatus,
                'updated_at'        => date('Y-m-d H:i:s'),
                'updated_by_id'     => session()->get('id_user'),
                'updated_by_name'   => session()->get('username'),
            ];

            if ($model->update($id, $updateData)) {
                return $this->response->setJSON([
                    'status'    => 'success',
                    'message'   => 'Status berhasil diperbarui',
                    'newStatus' => $newStatus,
                    'token'     => csrf_hash() // Kirim token baru
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
            return redirect()->to('/agenda_pelatihan')->with('error', 'Akses ditolak.');
        }
        return view('pages/agenda_pelatihan/create');
    }

    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) return redirect()->to('/agenda_pelatihan');

        $data = [
            'judul'           => $this->request->getPost('judul'),
            'tanggal_agenda'  => $this->request->getPost('tanggal_agenda'),
            'waktu'           => $this->request->getPost('waktu'),
            'tempat'          => $this->request->getPost('tempat'),
            'deskripsi'       => $this->request->getPost('deskripsi'),
            'status'          => $this->request->getPost('status') ?? 'draft',
            'tanggal_publish' => date('Y-m-d H:i:s'), // Default now
        ];

        // Validasi File Manual
        $file = $this->request->getFile('thumbnail');
        if (!$file->isValid()) {
            return redirect()->back()->withInput()->with('error', 'Thumbnail wajib diupload.');
        }

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/agenda_pelatihan', $newName);
            
            // Simpan path yang sama untuk kedua kolom (sesuai struktur tabel)
            $relativePath = 'uploads/agenda_pelatihan/' . $newName;
            $data['thumbnail']      = $relativePath;
            $data['thumbnail_path'] = $relativePath;
        }

        if (!$this->agendaModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->agendaModel->errors());
        }

        return redirect()->to('/agenda_pelatihan')->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/agenda_pelatihan')->with('error', 'Akses ditolak.');
        }

        $item = $this->agendaModel->find($id);
        if (!$item) {
            return redirect()->to('/agenda_pelatihan')->with('error', 'Data tidak ditemukan.');
        }

        return view('pages/agenda_pelatihan/edit', ['item' => $item]);
    }

    public function update($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) return redirect()->to('/agenda_pelatihan');

        $oldData = $this->agendaModel->find($id);
        if (!$oldData) return redirect()->to('/agenda_pelatihan')->with('error', 'Data tidak ditemukan.');

        $data = [
            'id'             => $id,
            'judul'          => $this->request->getPost('judul'),
            'tanggal_agenda' => $this->request->getPost('tanggal_agenda'),
            'waktu'          => $this->request->getPost('waktu'),
            'tempat'         => $this->request->getPost('tempat'),
            'deskripsi'      => $this->request->getPost('deskripsi'),
        ];

        // Update tanggal publish jika status berubah jadi published
        if ($data['status'] == 'published' && $oldData['status'] != 'published') {
            $data['tanggal_publish'] = date('Y-m-d H:i:s');
        }

        // Handle File Upload & Replace
        $file = $this->request->getFile('thumbnail');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/agenda_pelatihan', $newName);
            
            $relativePath = 'uploads/agenda_pelatihan/' . $newName;
            $data['thumbnail']      = $relativePath;
            $data['thumbnail_path'] = $relativePath;

            // Hapus file lama fisik
            if (!empty($oldData['thumbnail']) && file_exists($oldData['thumbnail'])) {
                unlink($oldData['thumbnail']);
            }
        }

        if (!$this->agendaModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->agendaModel->errors());
        }

        return redirect()->to('/agenda_pelatihan')->with('success', 'Agenda berhasil diperbarui.');
    }

    public function delete($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) return redirect()->to('/agenda_pelatihan');

        $data = $this->agendaModel->find($id);
        if ($data) {
            // Hapus file fisik
            if (!empty($data['thumbnail']) && file_exists($data['thumbnail'])) {
                unlink($data['thumbnail']);
            }
            $this->agendaModel->delete($id);
            return redirect()->to('/agenda_pelatihan')->with('success', 'Data berhasil dihapus.');
        }

        return redirect()->to('/agenda_pelatihan')->with('error', 'Gagal menghapus data.');
    }
}