<?php

namespace App\Controllers\frontend;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\frontend\PejabatModel;
use App\Models\AccessRightsModel;

class PejabatController extends BaseController
{
    protected $pejabatModel;
    protected $accessRightsModel;

    protected $module = 'pejabat';

    public function __construct()
    {
        $this->pejabatModel = new PejabatModel();
        $this->accessRightsModel = new AccessRightsModel();
    }
    private function getAccess($role)
    {
        $access = $this->accessRightsModel->where('role', $role)->where('module_name', $this->module)->first();
        if (!$access)
            return ['can_create' => false, 'can_read' => false, 'can_update' => false, 'can_delete' => false];
        return [
            'can_create' => (bool) $access['can_create'],
            'can_read' => (bool) $access['can_read'],
            'can_update' => (bool) $access['can_update'],
            'can_delete' => (bool) $access['can_delete'],
        ];
    }
    public function index()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat berita.');
        }
        $role = session()->get('role');
        $access = $this->getAccess($role);

        if (!$access) {
            return view('pages/pejabat/index', [
                'pejabat' => [],
                'error' => '⚠ Kamu tidak memiliki hak akses ke modul ini.'
            ]);
        }

        if (!$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat agenda.');
        }

        $pejabat = $this->pejabatModel->orderBy('created_at', 'DESC')->findAll();

        $data = [
            'pejabat' => $pejabat,
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ];

        return view('pages/pejabat/index', $data);
    }

    public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/pejabat')->with('error', 'Kamu tidak punya izin menambah pejabat.');
        }
        return view('pages/pejabat/create');

    }

    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/pejabat')->with('error', 'Kamu tidak punya izin menambah menu_profile.');
        }
        $data = [
            'nama' => $this->request->getPost('nama'),
            'nip' => $this->request->getPost('nip'),
            'alamat_kantor' => $this->request->getPost('alamat_kantor'),
            'tempat_tanggal_lahir' => $this->request->getPost('tempat_tanggal_lahir'),
            'jabatan' => $this->request->getPost('jabatan'),
            'slug' => url_title($this->request->getPost('nama'), '-', true),
            'urutan' => $this->request->getPost('urutan'),
            'hash' => md5(uniqid()),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,        ];
        if ($img = $this->request->getFile('foto')) {
            if ($img->isValid() && !$img->hasMoved()) {
                $newName = $img->getRandomName();
                $img->move(FCPATH . 'uploads/pejabat/', $newName); // Gunakan FCPATH
                $data['foto'] = $newName;
            }
        }
        if (!$this->pejabatModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->pejabatModel->errors());
        }
        return redirect()->to('/pejabat')->with('success', 'pejabat berhasil ditambahkan.');
    }
    // ... (kode sebelumnya: __construct, getAccess, index, new, create)

    public function edit($id)
    {
        // 1. Cek Hak Akses
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/pejabat')->with('error', 'Kamu tidak punya izin mengedit pejabat.');
        }

        // 2. Ambil data berdasarkan ID
        $pejabat = $this->pejabatModel->find($id);

        // 3. Jika data tidak ditemukan, tampilkan 404
        if (!$pejabat) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Data pejabat dengan ID $id tidak ditemukan.");
        }

        // 4. Kirim data ke view
        return view('pages/pejabat/edit', [
            'pejabat' => $pejabat
        ]);
    }

    public function update($id)
    {
        // 1. Cek Hak Akses
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/pejabat')->with('error', 'Kamu tidak punya izin mengupdate pejabat.');
        }

        // 2. Cek apakah data ada
        $pejabatLama = $this->pejabatModel->find($id);
        if (!$pejabatLama) {
            return redirect()->to('/pejabat')->with('error', 'Data tidak ditemukan.');
        }

        // 3. Siapkan data yang akan diupdate
        $data = [
            'id_pejabat'           => $id,
            'nama'                 => $this->request->getPost('nama'),
            'nip'                  => $this->request->getPost('nip'),
            'alamat_kantor'        => $this->request->getPost('alamat_kantor'),
            'tempat_tanggal_lahir' => $this->request->getPost('tempat_tanggal_lahir'),
            'jabatan'              => $this->request->getPost('jabatan'),
            // Update slug jika jabatan berubah
            'slug'                 => url_title($this->request->getPost('jabatan'), '-', true),
            'urutan'               => $this->request->getPost('urutan'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0, // Default 0 jika checkbox tidak dicentang
        ];

        // 4. Logika Upload Foto (Jika ada file baru diupload)
        $img = $this->request->getFile('foto');
        
        if ($img && $img->isValid() && !$img->hasMoved()) {
            // Generate nama file baru
            $newName = $img->getRandomName();
            // Pindahkan file ke folder uploads
            $img->move(FCPATH . 'uploads/pejabat/', $newName);
            
            // Masukkan nama file baru ke array data
            $data['foto'] = $newName;

            // Hapus file lama jika ada dan file tersebut benar-benar ada di folder
            if (!empty($pejabatLama['foto']) && file_exists(FCPATH . 'uploads/pejabat/' . $pejabatLama['foto'])) {
                unlink(FCPATH . 'uploads/pejabat/' . $pejabatLama['foto']);
            }
        }

        // 5. Eksekusi Update
        if (!$this->pejabatModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->pejabatModel->errors());
        }

        return redirect()->to('/pejabat')->with('success', 'Data pejabat berhasil diperbarui.');
    }

    public function delete($id)
    {
        // 1. Cek Hak Akses
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) {
            return redirect()->to('/pejabat')->with('error', 'Kamu tidak punya izin menghapus pejabat.');
        }

        // 2. Ambil data lama untuk mendapatkan nama file foto
        $pejabat = $this->pejabatModel->find($id);

        if (!$pejabat) {
            return redirect()->to('/pejabat')->with('error', 'Data tidak ditemukan.');
        }

        // 3. Hapus file fisik foto jika ada
        if (!empty($pejabat['foto']) && file_exists(FCPATH . 'uploads/pejabat/' . $pejabat['foto'])) {
            unlink(FCPATH . 'uploads/pejabat/' . $pejabat['foto']);
        }

        // 4. Hapus data dari database
        $this->pejabatModel->delete($id);

        return redirect()->to('/pejabat')->with('success', 'Data pejabat berhasil dihapus.');
    }
}
