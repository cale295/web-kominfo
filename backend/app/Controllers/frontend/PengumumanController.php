<?php

namespace App\Controllers\frontend;

use App\Models\frontend\PengumumanModel;
use App\Models\AccessRightsModel;
use App\Controllers\BaseController;

class PengumumanController extends BaseController
{
    protected $pengumumanModel;
    protected $accessRightsModel;
    protected $module = 'pengumuman'; // Pastikan modul ini terdaftar

    public function __construct()
    {
        $this->pengumumanModel = new PengumumanModel();
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

        $data = $this->pengumumanModel->orderBy('created_at', 'DESC')->findAll();

        return view('pages/pengumuman/index', [
            'pengumuman' => $data,
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
        $model = new \App\Models\frontend\PengumumanModel(); // <--- GANTI INI SESUAI MODUL
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
            return redirect()->to('/pengumuman')->with('error', 'Akses ditolak.');
        }
        return view('pages/pengumuman/create');
    }

    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) return redirect()->to('/pengumuman');

        $tipeMedia = $this->request->getPost('tipe_media');

        $data = [
            'judul'          => $this->request->getPost('judul'),
            'content'        => $this->request->getPost('content'),
            'tipe_media'     => $tipeMedia,
            'link_url'       => ($tipeMedia == 'link') ? $this->request->getPost('link_url') : null,
            'status'         => $this->request->getPost('status'),
            'featured_image' => '', // Default kosong dulu
            'file_media'     => null
        ];

        // 1. Upload Featured Image (Wajib di DB Schema)
        $img = $this->request->getFile('featured_image');
        if ($img && $img->isValid() && !$img->hasMoved()) {
            $newName = $img->getRandomName();
            $img->move('uploads/pengumuman', $newName);
            $data['featured_image'] = 'uploads/pengumuman/' . $newName;
        } else {
            return redirect()->back()->withInput()->with('error', 'Gambar Utama wajib diupload.');
        }

        // 2. Upload File Media (Jika tipe = file)
        if ($tipeMedia == 'file') {
            $fileDoc = $this->request->getFile('file_media');
            if ($fileDoc && $fileDoc->isValid() && !$fileDoc->hasMoved()) {
                $docName = $fileDoc->getRandomName();
                $fileDoc->move('uploads/pengumuman', $docName);
                $data['file_media'] = 'uploads/pengumuman/' . $docName;
            } else {
                return redirect()->back()->withInput()->with('error', 'File Dokumen wajib diupload jika tipe media adalah File.');
            }
        }

        if (!$this->pengumumanModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->pengumumanModel->errors());
        }

        return redirect()->to('/pengumuman')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/pengumuman')->with('error', 'Akses ditolak.');
        }

        $item = $this->pengumumanModel->find($id);
        if (!$item) {
            return redirect()->to('/pengumuman')->with('error', 'Data tidak ditemukan.');
        }

        return view('pages/pengumuman/edit', ['item' => $item]);
    }

    public function update($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) return redirect()->to('/pengumuman');

        $oldData = $this->pengumumanModel->find($id);
        if (!$oldData) return redirect()->to('/pengumuman')->with('error', 'Data tidak ditemukan.');

        $tipeMedia = $this->request->getPost('tipe_media');

        $data = [
            'id_pengumuman' => $id,
            'judul'         => $this->request->getPost('judul'),
            'content'       => $this->request->getPost('content'),
            'tipe_media'    => $tipeMedia,
            'link_url'      => ($tipeMedia == 'link') ? $this->request->getPost('link_url') : null,
        ];

        // 1. Handle Featured Image
        $img = $this->request->getFile('featured_image');
        if ($img && $img->isValid() && !$img->hasMoved()) {
            $newName = $img->getRandomName();
            $img->move('uploads/pengumuman', $newName);
            $data['featured_image'] = 'uploads/pengumuman/' . $newName;

            // Hapus gambar lama
            if (!empty($oldData['featured_image']) && file_exists($oldData['featured_image'])) {
                unlink($oldData['featured_image']);
            }
        }

        // 2. Handle File Media
        if ($tipeMedia == 'file') {
            $fileDoc = $this->request->getFile('file_media');
            if ($fileDoc && $fileDoc->isValid() && !$fileDoc->hasMoved()) {
                $docName = $fileDoc->getRandomName();
                $fileDoc->move('uploads/pengumuman', $docName);
                $data['file_media'] = 'uploads/pengumuman/' . $docName;

                // Hapus file lama jika ada
                if (!empty($oldData['file_media']) && file_exists($oldData['file_media'])) {
                    unlink($oldData['file_media']);
                }
            } else {
                // Jika tidak upload baru, pertahankan yang lama (validasi manual jika beralih dari link ke file)
                if(empty($oldData['file_media']) && $oldData['tipe_media'] != 'file') {
                     return redirect()->back()->withInput()->with('error', 'File Dokumen wajib diupload.');
                }
                // Jika sudah ada file lama, biarkan (tidak perlu update kolom file_media)
            }
        } else {
            // Jika tipe link, kosongkan file_media di DB? 
            // Opsional: $data['file_media'] = null; (tergantung kebutuhan, biasanya disimpan saja tidak apa-apa)
            $data['file_media'] = null; 
        }

        if (!$this->pengumumanModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->pengumumanModel->errors());
        }

        return redirect()->to('/pengumuman')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function delete($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) return redirect()->to('/pengumuman');

        $data = $this->pengumumanModel->find($id);
        if ($data) {
            // Hapus gambar utama
            if (!empty($data['featured_image']) && file_exists($data['featured_image'])) {
                unlink($data['featured_image']);
            }
            // Hapus file dokumen
            if (!empty($data['file_media']) && file_exists($data['file_media'])) {
                unlink($data['file_media']);
            }

            $this->pengumumanModel->delete($id);
            return redirect()->to('/pengumuman')->with('success', 'Data berhasil dihapus.');
        }

        return redirect()->to('/pengumuman')->with('error', 'Gagal menghapus data.');
    }
}