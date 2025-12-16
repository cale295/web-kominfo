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

        // Ambil data terbaru
        $data = $this->pengumumanModel->orderBy('created_at', 'DESC')->findAll();

        // Pastikan path view sesuai dengan struktur folder Anda
        return view('pages/pengumuman/index', [
            'pengumuman' => $data,
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete']
        ]);
    }

    // =========================================================================
    // UPDATE UTAMA: CREATE DATA (MENANGANI INPUT DARI MODAL)
    // =========================================================================
    public function create()
    {
        // 1. Cek Hak Akses
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) return redirect()->to('/pengumuman');

        // 2. Tentukan Aturan Validasi
        // Kita validasi di Controller agar bisa redirect back dengan error spesifik
        $rules = [
            'judul' => [
                'rules' => 'required',
                'errors' => ['required' => 'Judul pengumuman wajib diisi.']
            ],
            'content' => [
                'rules' => 'required',
                'errors' => ['required' => 'Isi pengumuman wajib diisi.']
            ],
            'featured_image' => [
                'rules' => 'uploaded[featured_image]|is_image[featured_image]|mime_in[featured_image,image/jpg,image/jpeg,image/png]|max_size[featured_image,2048]',
                'errors' => [
                    'uploaded' => 'Gambar Cover (Featured Image) wajib diupload.',
                    'is_image' => 'File harus berupa gambar.',
                    'max_size' => 'Ukuran gambar maksimal 2MB.'
                ]
            ]
        ];

        // Validasi Kondisional: Jika Tipe Media = File, maka File Wajib Upload
        if ($this->request->getPost('tipe_media') == 'file') {
            $rules['file_media'] = [
                'rules' => 'uploaded[file_media]|max_size[file_media,5120]|ext_in[file_media,pdf,doc,docx]',
                'errors' => [
                    'uploaded' => 'File dokumen wajib diupload jika memilih tipe Media File.',
                    'max_size' => 'Ukuran file dokumen maksimal 5MB.',
                    'ext_in'   => 'Format file harus PDF, DOC, atau DOCX.'
                ]
            ];
        }

        // 3. Jalankan Validasi
        if (!$this->validate($rules)) {
            // PENTING: Jika gagal, redirect kembali ke halaman index + bawa input & error
            // Ini akan memicu Javascript di View untuk membuka kembali Modal
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 4. Proses Upload Gambar Cover
        $img = $this->request->getFile('featured_image');
        $namaGambar = $img->getRandomName();
        $img->move('uploads/pengumuman', $namaGambar);

        // 5. Proses Data Media (Link vs File)
        $tipeMedia = $this->request->getPost('tipe_media');
        $fileMediaName = null;
        $linkUrl = $this->request->getPost('link_url');

        if ($tipeMedia == 'file') {
            $fileDoc = $this->request->getFile('file_media');
            $fileMediaName = $fileDoc->getRandomName();
            $fileDoc->move('uploads/pengumuman', $fileMediaName);
            $linkUrl = null; // Pastikan link kosong jika pilih file
        } else {
            // Jika Link
            $fileMediaName = null; // Pastikan file kosong
        }

        // 6. Simpan ke Database
        $this->pengumumanModel->save([
            'judul'          => $this->request->getPost('judul'),
            'content'        => $this->request->getPost('content'),
            'tipe_media'     => $tipeMedia,
            'link_url'       => $linkUrl,
            'file_media'     => ($fileMediaName) ? 'uploads/pengumuman/' . $fileMediaName : null,
            'featured_image' => 'uploads/pengumuman/' . $namaGambar,
            'status'         => $this->request->getPost('status') ?? 0, // Default 0
            'created_by'     => session()->get('id_user') // Opsional
        ]);

        return redirect()->to('/pengumuman')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    // =========================================================================
    // BAGIAN EDIT & UPDATE (MASIH MENGGUNAKAN HALAMAN TERPISAH)
    // =========================================================================
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

        // Validasi minimal (Gambar & File opsional saat update)
        if (!$this->validate([
            'judul' => 'required',
            'content' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $tipeMedia = $this->request->getPost('tipe_media');
        
        $data = [
            'id_pengumuman' => $id,
            'judul'         => $this->request->getPost('judul'),
            'content'       => $this->request->getPost('content'),
            'tipe_media'    => $tipeMedia,
            'link_url'      => ($tipeMedia == 'link') ? $this->request->getPost('link_url') : null,
        ];

        // 1. Handle Update Featured Image
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

        // 2. Handle Update File Media
        if ($tipeMedia == 'file') {
            $fileDoc = $this->request->getFile('file_media');
            if ($fileDoc && $fileDoc->isValid() && !$fileDoc->hasMoved()) {
                $docName = $fileDoc->getRandomName();
                $fileDoc->move('uploads/pengumuman', $docName);
                $data['file_media'] = 'uploads/pengumuman/' . $docName;

                // Hapus file lama
                if (!empty($oldData['file_media']) && file_exists($oldData['file_media'])) {
                    unlink($oldData['file_media']);
                }
            } else {
                // Jika switch ke File tapi tidak upload baru, cek apa sudah ada file sebelumnya
                if ($oldData['tipe_media'] != 'file' && empty($oldData['file_media'])) {
                    return redirect()->back()->withInput()->with('error', 'File Dokumen wajib diupload saat mengubah tipe ke File.');
                }
            }
        } else {
            // Jika berubah jadi Link, set file null (opsional: hapus file fisik jika mau)
            $data['file_media'] = null; 
        }

        $this->pengumumanModel->save($data);

        return redirect()->to('/pengumuman')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function delete($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) return redirect()->to('/pengumuman');

        $data = $this->pengumumanModel->find($id);
        if ($data) {
            // Hapus file fisik
            if (!empty($data['featured_image']) && file_exists($data['featured_image'])) {
                unlink($data['featured_image']);
            }
            if (!empty($data['file_media']) && file_exists($data['file_media'])) {
                unlink($data['file_media']);
            }

            $this->pengumumanModel->delete($id);
            return redirect()->to('/pengumuman')->with('success', 'Data berhasil dihapus.');
        }

        return redirect()->to('/pengumuman')->with('error', 'Gagal menghapus data.');
    }

    // =========================================================================
    // FUNGSI AJAX TOGGLE STATUS (TIDAK ADA PERUBAHAN)
    // =========================================================================
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

        $id = $this->request->getPost('id');
        $data = $this->pengumumanModel->find($id);

        if ($data) {
            $newStatus = ($data['status'] == '1') ? '0' : '1';
            $updateData = [
                'status'            => $newStatus,
                'updated_at'        => date('Y-m-d H:i:s'),
                'updated_by_id'     => session()->get('id_user'),
                // 'updated_by_name'   => session()->get('username'), 
            ];

            if ($this->pengumumanModel->update($id, $updateData)) {
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
}