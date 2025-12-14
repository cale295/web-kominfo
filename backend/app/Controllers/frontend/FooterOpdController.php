<?php

namespace App\Controllers\frontend;

use App\Models\frontend\FooterOpdModel;
use App\Models\AccessRightsModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class FooterOpdController extends BaseController
{
    protected $footerOpdModel;
    protected $accessRightsModel;

    protected $module = 'footer_opd';

    public function __construct()
    {
        $this->footerOpdModel = new FooterOpdModel();
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

        $footer_opd = $this->footerOpdModel->orderBy('created_at', 'DESC')->findAll();

        $data = [
            'footer_opd' => $footer_opd,
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ];

        return view('pages/footer_opd/index', $data);
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
        $model = new \App\Models\frontend\FooterOpdModel(); // <--- GANTI INI SESUAI MODUL
        // ==================================================

        $id = $this->request->getPost('id');
        $data = $model->find($id);

        if ($data) {
            // Logic Toggle (1 -> 0, 0 -> 1)
            $newStatus = ($data['is_active'] == '1') ? '0' : '1';

            // Data Update (Termasuk Audit Trail)
            $updateData = [
                'is_active'            => $newStatus,
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
            return redirect()->to('/footer_opd')->with('error', 'Kamu tidak punya izin menambah data.');
        }
        $counrt = $this->footerOpdModel->countAllResults();
        if ($counrt > 0) {
            return redirect()->to('/footer_opd')->with('error', 'Data Footer OPD sudah ada. Hanya diperbolehkan 1 data. Silakan edit data yang sudah ada.');
        }
        return view('pages/footer_opd/create');
    }

    // =================================================================
    // CREATE: Simpan Data Baru
    // =================================================================
    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/footer_opd')->with('error', 'Kamu tidak punya izin menambah data.');
        }
        // --- LOGIKA BARU: Cek apakah data sudah ada ---
        // Menghitung jumlah data di tabel footer_opd
        $existingData = $this->footerOpdModel->countAllResults();

        // Jika jumlah data sudah lebih dari 0 (artinya sudah ada 1), tolak proses create
        if ($existingData > 0) {
            return redirect()->to('/footer_opd')->with('error', 'Data Footer OPD sudah ada. Hanya diperbolehkan 1 data. Silakan edit data yang sudah ada.');
        }

        // Ambil Data Input
        $data = [
            'website_name'   => $this->request->getPost('website_name'),
            'official_title' => $this->request->getPost('official_title'),
            'address'        => $this->request->getPost('address'),
            'email'          => $this->request->getPost('email'),
            'phone'          => $this->request->getPost('phone'),
            'created_by'     => session()->get('id_user'), // Asumsi session user ID ada
        ];

        // --- Handle File 1: Logo Cominfo ---
        $fileLogo = $this->request->getFile('logo_cominfo');
        if ($fileLogo && $fileLogo->isValid() && !$fileLogo->hasMoved()) {
            // Validasi tipe/size bisa ditambahkan disini atau di model
            $newName = $fileLogo->getRandomName();
            $fileLogo->move('uploads/footer_opd', $newName);
            $data['logo_cominfo'] = 'uploads/footer_opd/' . $newName;
        }

        // --- Handle File 2: Election Badge ---
        $fileBadge = $this->request->getFile('election_badge');
        if ($fileBadge && $fileBadge->isValid() && !$fileBadge->hasMoved()) {
            $newName = $fileBadge->getRandomName();
            $fileBadge->move('uploads/footer_opd', $newName);
            $data['election_badge'] = 'uploads/footer_opd/' . $newName;
        }

        // Simpan ke DB
        if (!$this->footerOpdModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->footerOpdModel->errors());
        }

        return redirect()->to('/footer_opd')->with('success', 'Data Footer OPD berhasil ditambahkan.');
    }

    // =================================================================
    // EDIT: Form Edit
    // =================================================================
    public function edit($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/footer_opd')->with('error', 'Kamu tidak punya izin mengedit data.');
        }

        $footerOpd = $this->footerOpdModel->find($id);
        if (!$footerOpd) {
            return redirect()->to('/footer_opd')->with('error', 'Data tidak ditemukan.');
        }

        return view('pages/footer_opd/edit', [
            'footer_opd' => $footerOpd
        ]);
    }

    // =================================================================
    // UPDATE: Simpan Perubahan
    // =================================================================
    public function update($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/footer_opd')->with('error', 'Kamu tidak punya izin mengupdate data.');
        }

        // Cek data lama
        $oldData = $this->footerOpdModel->find($id);
        if (!$oldData) {
            return redirect()->to('/footer_opd')->with('error', 'Data tidak ditemukan.');
        }

        $data = [
            'id_opd_info'    => $id, // Penting untuk save() agar mode update
            'website_name'   => $this->request->getPost('website_name'),
            'official_title' => $this->request->getPost('official_title'),
            'address'        => $this->request->getPost('address'),
            'email'          => $this->request->getPost('email'),
            'phone'          => $this->request->getPost('phone'),
            'is_active'      => $this->request->getPost('is_active') ?? 0,
            'updated_by'     => session()->get('id_user'),
        ];

        // --- Handle File 1: Logo Cominfo ---
        $fileLogo = $this->request->getFile('logo_cominfo');
        if ($fileLogo && $fileLogo->isValid() && !$fileLogo->hasMoved()) {
            // Upload baru
            $newName = $fileLogo->getRandomName();
            $fileLogo->move('uploads/footer_opd', $newName);
            $data['logo_cominfo'] = 'uploads/footer_opd/' . $newName;

            // Hapus file lama jika ada
            if (!empty($oldData['logo_cominfo']) && file_exists($oldData['logo_cominfo'])) {
                unlink($oldData['logo_cominfo']);
            }
        }

        // --- Handle File 2: Election Badge ---
        $fileBadge = $this->request->getFile('election_badge');
        if ($fileBadge && $fileBadge->isValid() && !$fileBadge->hasMoved()) {
            // Upload baru
            $newName = $fileBadge->getRandomName();
            $fileBadge->move('uploads/footer_opd', $newName);
            $data['election_badge'] = 'uploads/footer_opd/' . $newName;

            // Hapus file lama jika ada
            if (!empty($oldData['election_badge']) && file_exists($oldData['election_badge'])) {
                unlink($oldData['election_badge']);
            }
        }

        if (!$this->footerOpdModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->footerOpdModel->errors());
        }

        return redirect()->to('/footer_opd')->with('success', 'Data Footer OPD berhasil diperbarui.');
    }

    // =================================================================
    // DELETE: Hapus Data
    // =================================================================
    public function delete($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) {
            return redirect()->to('/footer_opd')->with('error', 'Kamu tidak punya izin menghapus data.');
        }

        $data = $this->footerOpdModel->find($id);
        if (!$data) {
            return redirect()->to('/footer_opd')->with('error', 'Data tidak ditemukan.');
        }

        // Hapus File Fisik Logo
        if (!empty($data['logo_cominfo']) && file_exists($data['logo_cominfo'])) {
            unlink($data['logo_cominfo']);
        }

        // Hapus File Fisik Badge
        if (!empty($data['election_badge']) && file_exists($data['election_badge'])) {
            unlink($data['election_badge']);
        }

        $this->footerOpdModel->delete($id);

        return redirect()->to('/footer_opd')->with('success', 'Data berhasil dihapus permanen.');
    }
}