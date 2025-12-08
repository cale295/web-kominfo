<?php

namespace App\Controllers\backend;

use App\Models\AccessRightsModel;
use App\Controllers\BaseController;
use App\Models\BeritaModel;
use App\Models\BeritaUtamaModel;

class BeritaUtamaController extends BaseController
{
    protected $beritaModel;
    protected $utamaModel;
    protected $accessRightsModel;
    protected $module = 'berita_utama';

    public function __construct()
    {
        $this->beritaModel = new BeritaModel();
        $this->utamaModel = new BeritaUtamaModel();
        $this->accessRightsModel = new AccessRightsModel();
    }

    // ============================
    // Daftar berita utama
    // ============================
    public function index()
    {
        $role = session()->get('role');
        $access = $this->getAccess($role);

        if (!$access || !$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat berita utama.');
        }

        $data['beritaUtama'] = $this->utamaModel
            ->select('t_berita_utama.*, t_berita.judul, t_berita.slug, t_berita.feat_image, t_berita.created_at')
            ->join('t_berita', 't_berita.id_berita = t_berita_utama.id_berita')
            ->orderBy('t_berita_utama.created_date', 'DESC')
            ->findAll();

        $data['can_create'] = $access['can_create'];
        $data['can_update'] = $access['can_update'];
        $data['can_delete'] = $access['can_delete'];
        $data['title'] = 'Manajemen Berita Utama';

        return view('pages/berita_utama/index', $data);
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
        $model = new \App\Models\BeritaUtamaModel(); // <--- GANTI INI SESUAI MODUL
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
    // ============================
    // Form tambah berita utama
    // ============================
    public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/berita-utama')->with('error', 'Kamu tidak punya izin menambah berita utama.');
        }

        $beritas = $this->beritaModel->where('trash', '0')->findAll();

        return view('pages/berita_utama/create', [
            'title' => 'Tambah Berita Utama',
            'beritas' => $beritas,
            'can_create' => $access['can_create'],
        ]);
    }

    // ============================
    // Simpan berita utama baru
    // ============================
    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/berita-utama')->with('error', 'Kamu tidak punya izin menyimpan berita utama.');
        }

        $id_berita = $this->request->getPost('id_berita');
        if (!$id_berita) {
            return redirect()->back()->with('error', 'Silakan pilih berita terlebih dahulu.');
        }

        if ($this->utamaModel->where('id_berita', $id_berita)->first()) {
            return redirect()->back()->with('error', 'Berita ini sudah menjadi berita utama.');
        }

        $jumlahUtama = $this->utamaModel->where('status', 1)->countAllResults();
        if ($jumlahUtama >= 6) {
            return redirect()->back()->with('error', 'Berita utama sudah mencapai batas maksimal (6).');
        }

        $this->utamaModel->insert([
            'id_berita' => $id_berita,
            'jenis' => $this->request->getPost('jenis'),
            'content' => $this->request->getPost('content'),
            'content2' => $this->request->getPost('content2'),
            'status' => $this->request->getPost('status'),
            'created_date' => date('Y-m-d H:i:s'),
            'created_by_id' => session()->get('id_user'),
            'created_by_name' => session()->get('username'),
        ]);

        return redirect()->to('/berita-utama')->with('success', 'Berita utama berhasil ditambahkan.');
    }

    // ============================
    // Edit berita utama
    // ============================
    public function edit($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/berita-utama')->with('error', 'Kamu tidak punya izin mengedit berita utama.');
        }

        $utama = $this->utamaModel
            ->select('t_berita_utama.*, t_berita.judul, t_berita.feat_image, t_berita.id_berita')
            ->join('t_berita', 't_berita.id_berita = t_berita_utama.id_berita')
            ->where('t_berita_utama.id_berita_utama', $id)
            ->first();

        if (!$utama) {
            return redirect()->to('/berita-utama')->with('error', 'Data tidak ditemukan.');
        }

        $beritaList = $this->beritaModel->where('trash', '0')->orderBy('created_at', 'DESC')->findAll();

        return view('pages/berita_utama/edit', [
            'title' => 'Edit Berita Utama',
            'utama' => $utama,
            'beritaList' => $beritaList,
            'can_update' => $access['can_update'],
        ]);
    }

    // ============================
    // Update berita utama
    // ============================
    public function update($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/berita-utama')->with('error', 'Kamu tidak punya izin memperbarui berita utama.');
        }

        $utama = $this->utamaModel->find($id);
        if (!$utama) {
            return redirect()->to('/berita-utama')->with('error', 'Data tidak ditemukan.');
        }

        $this->utamaModel->update($id, [
            'id_berita' => $this->request->getPost('id_berita'),
            'jenis' => $this->request->getPost('jenis'),
            'status' => $this->request->getPost('status'),
        ]);

        return redirect()->to('/berita-utama')->with('success', 'Berita utama berhasil diperbarui.');
    }

    // ============================
    // Hapus berita utama
    // ============================
    public function delete($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) {
            return redirect()->back()->with('error', 'Kamu tidak punya izin menghapus berita utama.');
        }

        $utama = $this->utamaModel->find($id);
        if (!$utama) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $this->utamaModel->delete($id);
        return redirect()->back()->with('success', 'Berita utama berhasil dihapus.');
    }

    // ============================
    // Fungsi bantu ambil hak akses
    // ============================
    private function getAccess($role)
    {
        $access = $this->accessRightsModel
            ->where('role', $role)
            ->where('module_name', $this->module)
            ->first();

        if (!$access) return false;

        return [
            'can_create' => (bool)$access['can_create'],
            'can_read' => (bool)$access['can_read'],
            'can_update' => (bool)$access['can_update'],
            'can_delete' => (bool)$access['can_delete'],
        ];
    }
}
