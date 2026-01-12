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
    // Daftar berita utama dengan modal popup
    // ============================
    public function index()
    {
        $role = session()->get('role');
        $access = $this->getAccess($role);

        if (!$access || !$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat berita utama.');
        }

        // Ambil data berita utama dengan join
        $beritaUtama = $this->utamaModel
            ->select('t_berita_utama.*, t_berita.judul, t_berita.slug, t_berita.feat_image, t_berita.created_at')
            ->join('t_berita', 't_berita.id_berita = t_berita_utama.id_berita')
            ->orderBy('t_berita_utama.created_date', 'DESC')
            ->findAll();

        // Ambil semua berita untuk dropdown
        $semuaBerita = $this->beritaModel
            ->where('trash', '0')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        // Filter berita yang belum jadi berita utama (untuk create modal)
        $beritaSudahUtama = array_column($beritaUtama, 'id_berita');
        $beritas = array_filter($semuaBerita, function($berita) use ($beritaSudahUtama) {
            return !in_array($berita['id_berita'], $beritaSudahUtama);
        });

        // Untuk edit modal, kita butuh semua berita termasuk yang sudah dipilih
        $beritaList = $semuaBerita;

        $data = [
            'beritaUtama' => $beritaUtama,
            'beritas' => $beritas, // Untuk create modal (hanya berita yang belum jadi utama)
            'beritaList' => $beritaList, // Untuk edit modal (semua berita)
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
            'title' => 'Manajemen Berita Utama'
        ];

        return view('pages/berita_utama/index', $data);
    }

    public function toggleStatus()
    {
        // 1. Cek Request AJAX
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // 2. CEK HAK AKSES
        $role = session()->get('role');
        $access = $this->getAccess($role);

        if (!$access || !$access['can_update']) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Anda tidak memiliki izin untuk mengubah data ini.',
                'token' => csrf_hash()
            ]);
        }

        $id = $this->request->getPost('id');
        $data = $this->utamaModel->find($id);

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

            if ($this->utamaModel->update($id, $updateData)) {
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

    // ============================
    // Simpan berita utama baru (untuk modal)
    // ============================
    public function create()
    {
        $role = session()->get('role');
        $access = $this->getAccess($role);
        
        if (!$access || !$access['can_create']) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Kamu tidak punya izin menyimpan berita utama.',
                    'token' => csrf_hash()
                ]);
            }
            return redirect()->to('/berita-utama')->with('error', 'Kamu tidak punya izin menyimpan berita utama.');
        }

        $id_berita = $this->request->getPost('id_berita');
        
        if (!$id_berita) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Silakan pilih berita terlebih dahulu.',
                    'token' => csrf_hash()
                ]);
            }
            return redirect()->back()->with('error', 'Silakan pilih berita terlebih dahulu.');
        }

        // Cek apakah berita sudah menjadi berita utama
        if ($this->utamaModel->where('id_berita', $id_berita)->first()) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Berita ini sudah menjadi berita utama.',
                    'token' => csrf_hash()
                ]);
            }
            return redirect()->back()->with('error', 'Berita ini sudah menjadi berita utama.');
        }

        // Cek batas maksimal berita utama aktif
        $jumlahUtama = $this->utamaModel->where('status', 1)->countAllResults();
        $status = $this->request->getPost('status');
        
        if ($status == 1 && $jumlahUtama >= 6) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Berita utama sudah mencapai batas maksimal (6).',
                    'token' => csrf_hash()
                ]);
            }
            return redirect()->back()->with('error', 'Berita utama sudah mencapai batas maksimal (6).');
        }

        // Simpan data
        $data = [
            'id_berita' => $id_berita,
            'jenis' => $this->request->getPost('jenis') ?: null,
            'content' => $this->request->getPost('content'),
            'content2' => $this->request->getPost('content2'),
            'status' => $status,
            'created_date' => date('Y-m-d H:i:s'),
            'created_by_id' => session()->get('id_user'),
            'created_by_name' => session()->get('username'),
        ];

        if ($this->utamaModel->insert($data)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Berita utama berhasil ditambahkan.',
                    'redirect' => site_url('berita-utama'),
                    'token' => csrf_hash()
                ]);
            }
            return redirect()->to('/berita-utama')->with('success', 'Berita utama berhasil ditambahkan.');
        } else {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Gagal menyimpan berita utama.',
                    'token' => csrf_hash()
                ]);
            }
            return redirect()->back()->with('error', 'Gagal menyimpan berita utama.');
        }
    }

    // ============================
    // Update berita utama (untuk modal)
    // ============================
    public function update($id)
    {
        $role = session()->get('role');
        $access = $this->getAccess($role);
        
        if (!$access || !$access['can_update']) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Kamu tidak punya izin memperbarui berita utama.',
                    'token' => csrf_hash()
                ]);
            }
            return redirect()->to('/berita-utama')->with('error', 'Kamu tidak punya izin memperbarui berita utama.');
        }

        $utama = $this->utamaModel->find($id);
        if (!$utama) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan.',
                    'token' => csrf_hash()
                ]);
            }
            return redirect()->to('/berita-utama')->with('error', 'Data tidak ditemukan.');
        }

        $id_berita = $this->request->getPost('id_berita');
        
        // Cek jika id_berita berubah, pastikan tidak duplikat
        if ($id_berita != $utama['id_berita']) {
            $existing = $this->utamaModel->where('id_berita', $id_berita)->first();
            if ($existing) {
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Berita ini sudah menjadi berita utama.',
                        'token' => csrf_hash()
                    ]);
                }
                return redirect()->back()->with('error', 'Berita ini sudah menjadi berita utama.');
            }
        }

        // Cek batas maksimal berita utama aktif jika status diubah menjadi aktif
        $status = $this->request->getPost('status');
        if ($status == 1 && $utama['status'] == 0) {
            $jumlahUtama = $this->utamaModel->where('status', 1)->countAllResults();
            if ($jumlahUtama >= 6) {
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Berita utama sudah mencapai batas maksimal (6).',
                        'token' => csrf_hash()
                    ]);
                }
                return redirect()->back()->with('error', 'Berita utama sudah mencapai batas maksimal (6).');
            }
        }

        // Update data
        $updateData = [
            'id_berita' => $id_berita,
            'jenis' => $this->request->getPost('jenis') ?: null,
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by_id' => session()->get('id_user'),
            'updated_by_name' => session()->get('username'),
        ];

        if ($this->utamaModel->update($id, $updateData)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Berita utama berhasil diperbarui.',
                    'redirect' => site_url('berita-utama'),
                    'token' => csrf_hash()
                ]);
            }
            return redirect()->to('/berita-utama')->with('success', 'Berita utama berhasil diperbarui.');
        } else {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Gagal memperbarui berita utama.',
                    'token' => csrf_hash()
                ]);
            }
            return redirect()->back()->with('error', 'Gagal memperbarui berita utama.');
        }
    }

    // ============================
    // Hapus berita utama (AJAX support)
    // ============================
    public function delete($id)
    {
        $role = session()->get('role');
        $access = $this->getAccess($role);
        
        if (!$access || !$access['can_delete']) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Kamu tidak punya izin menghapus berita utama.',
                    'token' => csrf_hash()
                ]);
            }
            return redirect()->back()->with('error', 'Kamu tidak punya izin menghapus berita utama.');
        }

        $utama = $this->utamaModel->find($id);
        if (!$utama) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan.',
                    'token' => csrf_hash()
                ]);
            }
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        if ($this->utamaModel->delete($id)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Berita utama berhasil dihapus.',
                    'token' => csrf_hash()
                ]);
            }
            return redirect()->back()->with('success', 'Berita utama berhasil dihapus.');
        } else {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Gagal menghapus berita utama.',
                    'token' => csrf_hash()
                ]);
            }
            return redirect()->back()->with('error', 'Gagal menghapus berita utama.');
        }
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

    // ============================
    // Redirect untuk method new() dan edit() ke index (karena sekarang pakai modal)
    // ============================
    public function new()
    {
        // Redirect ke index karena create sudah di-handle di modal
        return redirect()->to('berita-utama');
    }

    public function edit($id)
    {
        // Redirect ke index karena edit sudah di-handle di modal
        return redirect()->to('berita-utama');
    }
}