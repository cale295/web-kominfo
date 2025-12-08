<?php

namespace App\Controllers\frontend;

use App\Models\frontend\StrukturOrganisasiModel;
use App\Models\AccessRightsModel;
use App\Controllers\BaseController;

class StrukturOrganisasiController extends BaseController
{
    protected $strukturModel;
    protected $accessRightsModel;
    protected $module = 'struktur_organisasi'; // Pastikan modul ini terdaftar

    public function __construct()
    {
        $this->strukturModel = new StrukturOrganisasiModel();
        $this->accessRightsModel = new AccessRightsModel();
    }

    // --- TAMBAHAN BARU ---
    // Fungsi rekursif untuk menyusun hierarki tree
    private function getHierarchicalOptions($data, $parentId = null, $depth = 0)
    {
        $result = [];
        foreach ($data as $item) {
            // Cek apakah parent_id item ini sama dengan parentId yang dicari
            // Kita gunakan loose comparison (==) agar null dan 0 bisa terhandle jika perlu, 
            // tapi karena di database kamu set null, pastikan logikanya cocok.
            if ($item['parent_id'] == $parentId) {
                $item['depth'] = $depth; // Tambahkan info kedalaman
                $result[] = $item;

                // Cari anak dari item ini (Recursion)
                $children = $this->getHierarchicalOptions($data, $item['id_struktur'], $depth + 1);
                
                // Gabungkan hasil
                $result = array_merge($result, $children);
            }
        }
        return $result;
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
        $model = new \App\Models\frontend\StrukturOrganisasiModel(); // <--- GANTI INI SESUAI MODUL
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

    public function index()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat modul ini.');
        }

        // Ambil data dengan join ke diri sendiri untuk mendapatkan nama parent
        $struktur = $this->strukturModel
            ->select('m_p_struktur_organisasi.*, parent.nama as parent_name')
            ->join('m_p_struktur_organisasi as parent', 'parent.id_struktur = m_p_struktur_organisasi.parent_id', 'left')
            ->orderBy('m_p_struktur_organisasi.sorting', 'ASC')
            ->findAll();

        return view('pages/struktur_organisasi/index', [
            'struktur'   => $struktur,
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete']
        ]);
    }

public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/struktur_organisasi')->with('error', 'Akses ditolak.');
        }

        // 1. Ambil data mentah (urutkan berdasarkan sorting agar urutannya pas)
        $rawStruktur = $this->strukturModel->orderBy('sorting', 'ASC')->orderBy('nama', 'ASC')->findAll();

        // 2. Proses menjadi hierarki
        // Parameter kedua 'null' karena root parent_id di database kamu null
        $parents = $this->getHierarchicalOptions($rawStruktur, null, 0);

        return view('pages/struktur_organisasi/create', ['parents' => $parents]);
    }

    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) return redirect()->to('/struktur_organisasi');

        $parentId = $this->request->getPost('parent_id');
        
        $data = [
            'nama'        => $this->request->getPost('nama'),
            'parent_id'   => !empty($parentId) ? $parentId : null,
            'slug'        => url_title($this->request->getPost('nama'), '-', true),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'sorting'     => $this->request->getPost('sorting') ?? 0,
            'is_active'   => $this->request->getPost('is_active') ?? 0,
        ];

        if (!$this->strukturModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->strukturModel->errors());
        }

        return redirect()->to('/struktur_organisasi')->with('success', 'Data struktur berhasil ditambahkan.');
    }

public function edit($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/struktur_organisasi')->with('error', 'Akses ditolak.');
        }

        $struktur = $this->strukturModel->find($id);
        if (!$struktur) {
            return redirect()->to('/struktur_organisasi')->with('error', 'Data tidak ditemukan.');
        }

        // 1. Ambil semua data (JANGAN difilter 'where id != id' disini, nanti hierarki anaknya putus)
        $rawStruktur = $this->strukturModel->orderBy('sorting', 'ASC')->orderBy('nama', 'ASC')->findAll();

        // 2. Susun Hierarki
        $hierarchicalData = $this->getHierarchicalOptions($rawStruktur, null, 0);

        // 3. Filter: Hapus diri sendiri dari daftar opsi parent (opsional: hapus juga turunannya agar tidak loop)
        $parents = array_filter($hierarchicalData, function($item) use ($id) {
            return $item['id_struktur'] != $id;
        });

        return view('pages/struktur_organisasi/edit', [
            'struktur' => $struktur,
            'parents'  => $parents
        ]);
    }
    public function update($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) return redirect()->to('/struktur_organisasi');

        $oldData = $this->strukturModel->find($id);
        if (!$oldData) return redirect()->to('/struktur_organisasi')->with('error', 'Data tidak ditemukan.');

        $parentId = $this->request->getPost('parent_id');

        $data = [
            'id_struktur' => $id,
            'nama'        => $this->request->getPost('nama'),
            'parent_id'   => !empty($parentId) ? $parentId : null,
            'slug'        => url_title($this->request->getPost('nama'), '-', true),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'sorting'     => $this->request->getPost('sorting') ?? 0,
            'is_active'   => $this->request->getPost('is_active') ?? 0,
        ];

        if (!$this->strukturModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->strukturModel->errors());
        }

        return redirect()->to('/struktur_organisasi')->with('success', 'Data struktur berhasil diperbarui.');
    }

    public function delete($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) return redirect()->to('/struktur_organisasi');

        $data = $this->strukturModel->find($id);
        if ($data) {
            // Opsional: Cek apakah punya child sebelum hapus?
            // Untuk sekarang langsung hapus saja (soft delete dimatikan)
            $this->strukturModel->delete($id);
            return redirect()->to('/struktur_organisasi')->with('success', 'Data berhasil dihapus.');
        }

        return redirect()->to('/struktur_organisasi')->with('error', 'Gagal menghapus data.');
    }
}