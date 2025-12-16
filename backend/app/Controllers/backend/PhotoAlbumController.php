<?php

namespace App\Controllers\backend;

use App\Models\AccessRightsModel;
use App\Controllers\BaseController;
use App\Models\PhotoAlbumModel;
use App\Models\PhotoGalleryModel;

class PhotoAlbumController extends BaseController
{
    protected $albumModel;
    protected $galleryModel;
    protected $accessRightsModel;
    protected $module = 'galeri_album';

    public function __construct()
    {
        $this->albumModel = new PhotoAlbumModel();
        $this->galleryModel = new PhotoGalleryModel();
        $this->accessRightsModel = new AccessRightsModel();
    }

    // ================= INDEX =================
    public function index()
    {
        $role = session()->get('role');
        $access = $this->getAccess($role);

        if (!$access) {
            return view('pages/album/index', [
                'title' => 'Manajemen Album', // PERBAIKAN: Sebelumnya Banner
                'albums' => [],
                'error' => '⚠ Kamu tidak memiliki hak akses ke modul ini.'
            ]);
        }

        if (!$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat album.');
        }

        $data = [
            'title' => 'Daftar Album Foto',
            'albums' => $this->albumModel->findAll(),
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ];

        return view('pages/album/index', $data);
    }

    // ================= GET PHOTOS (AJAX) =================
    public function get_photos($id_album = null)
    {
        if (!$this->request->isAJAX()) {
             // return $this->response->setStatusCode(403);
        }

        if ($id_album === null) {
            return $this->response->setJSON([]);
        }

        $photos = $this->galleryModel->where('id_album', $id_album)->findAll();
        return $this->response->setJSON($photos);
    }

    // ================= FORM TAMBAH =================
    public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/album')->with('error', 'Kamu tidak punya izin menambah album.');
        }

        return view('pages/album/create', ['title' => 'Tambah Album Baru']);
    }

    // ================= UPLOAD FOTO KE GALERI =================
    public function upload_store()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->back()->with('error', 'Tidak punya akses.');
        }

        $albumId = $this->request->getPost('id_album');
        $titles = $this->request->getPost('titles');       
        $descriptions = $this->request->getPost('descriptions'); 
        $files = $this->request->getFileMultiple('gallery_photos');

        $count = 0;

        if ($files) {
            foreach ($files as $index => $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $fileName = $file->getRandomName();
                    
                    // Pastikan path folder benar
                    $file->move('uploads/gallery/', $fileName); 

                    $userTitle = !empty($titles[$index]) ? $titles[$index] : pathinfo($file->getClientName(), PATHINFO_FILENAME);
                    $userDesc = !empty($descriptions[$index]) ? $descriptions[$index] : '-';

                    $dataToSave = [
                        'id_album'    => $albumId,
                        'photo_title' => $userTitle,
                        'deskripsi'   => $userDesc,
                        'file_path'   => $fileName, // PASTIKAN KOLOM DB BERNAMA file_path
                        'slug'        => url_title($userTitle, '-', true) . '-' . uniqid(),
                    ];

                    if ($this->galleryModel->insert($dataToSave)) {
                        $count++;
                    }
                }
            }
        }

        if ($count == 0) {
            return redirect()->back()->with('error', 'Tidak ada foto yang diupload.');
        }

        return redirect()->to('/album')->with('success', "$count Foto berhasil ditambahkan.");
    }

    // ================= DETAIL ALBUM =================
    public function show($id)
    {
        // Gunakan properti class yang sudah di-load di construct
        $album = $this->albumModel->find($id);

        if (!$album) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Album tidak ditemukan");
        }

        $photos = $this->galleryModel->where('id_album', $id)->findAll();

        $data = [
            'title'  => 'Detail Album: ' . $album['album_name'], // Ambil dari DB
            'album'  => $album,
            'photos' => $photos
        ];

        return view('pages/album/detail', $data); 
    }

    // ================= HAPUS SATU FOTO =================
    public function deletePhoto($id)
    {
        $photo = $this->galleryModel->find($id);

        if ($photo) {
            // Gunakan FCPATH agar path absolut server terbaca dengan benar
            $filePath = FCPATH . 'uploads/gallery/' . $photo['file_path']; 
            
            if (file_exists($filePath)) {
                @unlink($filePath); // Pakai @ agar tidak error jika file sudah hilang duluan
            }

            $this->galleryModel->delete($id);

            return redirect()->back()->with('success', 'Foto berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Foto tidak ditemukan.');
        }
    }

    // ================= SIMPAN ALBUM BARU =================
    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/album')->with('error', 'Kamu tidak punya izin menambah album.');
        }

        $data = [
            'album_name' => $this->request->getPost('album_name'),
            'description' => $this->request->getPost('description'),
        ];

        $cover = $this->request->getFile('cover_image');
        if ($cover && $cover->isValid() && !$cover->hasMoved()) {
            $newName = $cover->getRandomName();
            $cover->move('uploads/album_covers/', $newName);
            $data['cover_image'] = $newName;
        }

        if (!$this->albumModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->albumModel->errors());
        }

        return redirect()->to('/album')->with('success', 'Album berhasil ditambahkan.');
    }

    // ================= FORM EDIT ALBUM =================
    public function edit($id = null)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/album')->with('error', 'Kamu tidak punya izin mengedit album.');
        }

        $album = $this->albumModel->find($id);

        return view('pages/album/edit', [
            'title' => 'Edit Album',
            'album' => $album,
            'can_update' => $access['can_update'],
        ]);
    }

    // ================= UPDATE ALBUM =================
    public function update($id = null)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/album')->with('error', 'Kamu tidak punya izin mengubah album.');
        }

        $album = $this->albumModel->find($id);
        if (!$album) {
            return redirect()->to('/album')->with('error', 'Album tidak ditemukan.');
        }

        $data = [
            'album_name' => $this->request->getPost('album_name'),
            'description' => $this->request->getPost('description'),
        ];

        $cover = $this->request->getFile('cover_image');
        if ($cover && $cover->isValid() && !$cover->hasMoved()) {
            $newName = $cover->getRandomName();
            $cover->move('uploads/album_covers/', $newName);
            $data['cover_image'] = $newName;

            $uploadPath = FCPATH . 'uploads/album_covers/';
            if (!empty($album['cover_image']) && file_exists($uploadPath . $album['cover_image'])) {
                @unlink($uploadPath . $album['cover_image']);
            }
        }

        if (!$this->albumModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->albumModel->errors());
        }

        return redirect()->to('/album')->with('success', 'Album berhasil diperbarui.');
    }

    // ================= DELETE ALBUM (LENGKAP) =================
    public function delete($id = null)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) {
            return redirect()->to('/album')->with('error', 'Kamu tidak punya izin menghapus album.');
        }

        $album = $this->albumModel->find($id);
        if (!$album) {
            return redirect()->to('/album')->with('error', 'Album tidak ditemukan.');
        }

        // 1. HAPUS SEMUA FOTO DI DALAM ALBUM INI DULU (PENTING!)
        $photos = $this->galleryModel->where('id_album', $id)->findAll();
        foreach ($photos as $photo) {
            // Hapus file fisik foto galeri
            $photoPath = FCPATH . 'uploads/gallery/' . $photo['file_path'];
            if (file_exists($photoPath)) {
                @unlink($photoPath);
            }
        }
        // Hapus data foto di database
        $this->galleryModel->where('id_album', $id)->delete();


        // 2. Hapus Cover Album
        $coverPath = FCPATH . 'uploads/album_covers/';
        if (!empty($album['cover_image']) && file_exists($coverPath . $album['cover_image'])) {
            @unlink($coverPath . $album['cover_image']);
        }

        // 3. Hapus Record Album dari database
        if (!$this->albumModel->delete($id)) {
            return redirect()->back()->with('error', 'Gagal menghapus album.');
        }

        return redirect()->to('/album')->with('success', 'Album dan seluruh isinya berhasil dihapus.');
    }

    // ================= HELPER AKSES =================
    private function getAccess($role)
    {
        $access = $this->accessRightsModel
            ->where('role', $role)
            ->where('module_name', $this->module)
            ->first();

        if (!$access) return false;

        return [
            'can_create' => (bool) $access['can_create'],
            'can_read'   => (bool) $access['can_read'],
            'can_update' => (bool) $access['can_update'],
            'can_delete' => (bool) $access['can_delete'],
        ];
    }
}