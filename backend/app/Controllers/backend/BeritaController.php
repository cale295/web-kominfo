<?php

namespace App\Controllers\backend;

use App\Controllers\BaseController;
use App\Models\BeritaModel;
use App\Models\KategoriModel;
use App\Models\AccessRightsModel;
use App\Models\BeritaLogModel;

class BeritaController extends BaseController
{
    protected $beritaModel;
    protected $kategoriModel;
    protected $accessRightsModel;
    protected $beritaLogModel;
    protected $module = 'berita';

    public function __construct()
    {
        $this->beritaModel = new BeritaModel();
        $this->kategoriModel = new KategoriModel();
        $this->accessRightsModel = new AccessRightsModel();
        $this->beritaLogModel = new BeritaLogModel();
    }

    // ========================================================
    // Index / Daftar Berita
    // ========================================================
    public function index()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat berita.');
        }

        $berita = $this->beritaModel->where('trash', '0')->findAll();

        // Ambil semua kategori (id => nama)
        $kategoriAll = $this->kategoriModel->where('trash', '0')->findAll();
        $kategoriMap = [];
        foreach ($kategoriAll as $k) {
            $kategoriMap[$k['id_kategori']] = $k['kategori'];
        }

        // Ambil kategori tiap berita
        foreach ($berita as &$b) {
            $kats = $this->beritaModel->db->table('t_berita_kategori')
                ->select('m_kategori_berita.id_kategori, m_kategori_berita.kategori')
                ->join('m_kategori_berita', 'm_kategori_berita.id_kategori = t_berita_kategori.id_kategori')
                ->where('t_berita_kategori.id_berita', $b['id_berita'])
                ->get()
                ->getResultArray();

            $b['kategori'] = array_column($kats, 'kategori');
            $b['kategori_ids'] = array_column($kats, 'id_kategori');
        }

        $data = [
            'title' => 'Manajemen Berita',
            'berita' => $berita,
            'kategoriMap' => $kategoriMap,
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
            'can_read' => $access['can_read'],
        ];

        return view('pages/berita/index', $data);
    }

    // ========================================================
    // Form Tambah Berita
    // ========================================================
    public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_create']) {
            return redirect()->to('/berita')->with('error', 'Kamu tidak punya izin menambah berita.');
        }

        if (!old('judul')) {
            $this->clearTemporaryImages();
        }

        $data = [
            'title' => 'Tambah Berita',
            'kategori' => $this->kategoriModel->where('trash', '0')->where('status', '1')->findAll(),
            'beritaAll' => $this->beritaModel->findAll(),
            'tempCoverImage' => session()->get('temp_cover_image'),
            'tempAdditionalImages' => session()->get('temp_additional_images') ?? []
        ];

        return view('pages/berita/create', $data);
    }

    // ========================================================
    // Detail Berita (Show)
    // ========================================================
    public function show($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat berita.');
        }

        $berita = $this->beritaModel->find($id);
        if (!$berita) {
            return redirect()->to('/berita')->with('error', 'Berita tidak ditemukan.');
        }

        // === HIT++ (Tambah jumlah pembaca) ===
        $this->beritaModel->set('hit', 'hit + 1', false)
                          ->where('id_berita', $id)
                          ->update();

        // Ambil kategori berita
        $kategori = $this->beritaModel->getKategoriByBerita($id);
        $kategoriNames = array_column($kategori, 'kategori');

        // Ambil berita terkait
        $beritaTerkait = [];
        if (!empty($berita['id_berita_terkait'])) {
            $beritaTerkait[] = $this->beritaModel->find($berita['id_berita_terkait']);
        }
        if (!empty($berita['id_berita_terkait2'])) {
            $beritaTerkait[] = $this->beritaModel->find($berita['id_berita_terkait2']);
        }

        // Decode additional images & Normalisasi
        $rawImages = !empty($berita['additional_images']) ? json_decode($berita['additional_images'], true) : [];
        $additionalImages = [];
        
        foreach($rawImages as $img) {
            if (is_string($img)) {
                // Format Lama (Hanya string path)
                $additionalImages[] = [
                    'path' => $img,
                    'caption' => '' // Default caption kosong
                ];
            } else {
                // Format Baru (Array/Object)
                $additionalImages[] = $img;
            }
        }

        $data = [
            'title' => 'Detail Berita',
            'berita' => $berita,
            'kategori' => $kategoriNames,
            'additionalImages' => $additionalImages,
            'beritaTerkait' => $beritaTerkait,
        ];

        return view('pages/berita/show', $data);
    }

    // ========================================================
    // Simpan Berita Baru (Create)
    // ========================================================
    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_create']) {
            return redirect()->to('/berita')->with('error', 'Kamu tidak punya izin menambah berita.');
        }

        $validation = \Config\Services::validation();

        // Rules dalam Bahasa Indonesia
        $rules = [
            'judul' => [
                'rules'  => 'required|min_length[5]|max_length[255]',
                'errors' => [
                    'required'   => 'Judul berita wajib diisi.',
                    'min_length' => 'Judul minimal 5 karakter.',
                    'max_length' => 'Judul maksimal 255 karakter.'
                ]
            ],
            'topik' => [
                'rules'  => 'required|min_length[5]|max_length[255]',
                'errors' => [
                    'required'   => 'Topik wajib diisi.',
                    'min_length' => 'Topik minimal 5 karakter.',
                    'max_length' => 'Topik maksimal 255 karakter.'
                ]
            ],
            'intro' => [
                'rules'  => 'required|min_length[5]',
                'errors' => [
                    'required'   => 'Intro singkat wajib diisi.',
                    'min_length' => 'Intro minimal 5 karakter.'
                ]
            ],
            'content' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Konten berita wajib diisi.'
                ]
            ],
            'id_kategori' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Kategori wajib dipilih minimal satu.'
                ]
            ],
            'sumber' => [
                'rules'  => 'permit_empty|max_length[255]',
                'errors' => [
                    'max_length' => 'Sumber maksimal 255 karakter.'
                ]
            ],
        ];

        // Validasi Cover Image
        if (!session()->has('temp_cover_image')) {
            $rules['feat_image'] = [
                'rules'  => 'uploaded[feat_image]|max_size[feat_image,2048]|is_image[feat_image]|mime_in[feat_image,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Foto cover wajib diupload.',
                    'max_size' => 'Ukuran foto maksimal 2MB.',
                    'is_image' => 'File yang diupload bukan gambar.',
                    'mime_in'  => 'Format gambar harus JPG, JPEG, atau PNG.'
                ]
            ];
        }

        if (!$this->validate($rules)) {
            $this->saveTemporaryImages();
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // 1. HANDLE COVER IMAGE
        $featImagePath = null;
        
        if (session()->has('temp_cover_image')) {
            $tempFile = session()->get('temp_cover_image');
            $tempPath = WRITEPATH . '../public/uploads/temp/' . $tempFile;
            if (file_exists($tempPath)) {
                $finalPath = WRITEPATH . '../public/uploads/berita/' . $tempFile;
                rename($tempPath, $finalPath);
                $featImagePath = 'uploads/berita/' . $tempFile;
            }
            session()->remove('temp_cover_image');
        } else {
            $featImage = $this->request->getFile('feat_image');
            if ($featImage && $featImage->isValid() && !$featImage->hasMoved()) {
                $newName = $featImage->getRandomName();
                $featImage->move(WRITEPATH . '../public/uploads/berita', $newName);
                $featImagePath = 'uploads/berita/' . $newName;
            }
        }

        // 2. HANDLE ADDITIONAL IMAGES + CAPTIONS
        $additionalData = []; 
        $captions = $this->request->getPost('caption_additional'); 
        
        // A. Handle Temp Images
        if (session()->has('temp_additional_images')) {
            $tempImages = session()->get('temp_additional_images');
            foreach ($tempImages as $index => $tempFile) {
                $tempPath = WRITEPATH . '../public/uploads/temp/' . $tempFile;
                if (file_exists($tempPath)) {
                    $finalDir = WRITEPATH . '../public/uploads/berita/additional/';
                    if (!is_dir($finalDir)) mkdir($finalDir, 0755, true);

                    $finalPath = $finalDir . $tempFile;
                    rename($tempPath, $finalPath);

                    $additionalData[] = [
                        'path'    => 'uploads/berita/additional/' . $tempFile,
                        'caption' => $captions[$index] ?? ''
                    ];
                }
            }
            session()->remove('temp_additional_images');
        }

        // B. Handle New Uploads
        $files = $this->request->getFileMultiple('additional_images');
        $startIndex = isset($tempImages) ? count($tempImages) : 0;

        if ($files) {
            foreach ($files as $index => $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move(WRITEPATH . '../public/uploads/berita/additional', $newName);
                    
                    $currentCaption = '';
                    if(isset($captions[$startIndex + $index])) {
                        $currentCaption = $captions[$startIndex + $index];
                    }

                    $additionalData[] = [
                        'path'    => 'uploads/berita/additional/' . $newName,
                        'caption' => $currentCaption
                    ];
                }
            }
        }

        // 3. SIMPAN DATA
        $post = $this->request->getPost();
        $kategoriIds = is_array($post['id_kategori']) ? $post['id_kategori'] : explode(',', $post['id_kategori']);
        $idKategori = $kategoriIds[0] ?? null;

        $data = [
            'judul'             => $post['judul'],
            'topik'             => $post['topik'],
            'intro'             => $post['intro'],
            'sumber'            => $post['sumber'],
            'content'           => $post['content'],
            'content2'          => $post['content2'],
            'id_kategori'       => $idKategori,
            'link_video'        => $post['link_video'] ?? null,
            'keyword'           => $post['keyword'] ?? null,
            'feat_image'        => $featImagePath,
            
            // Simpan Caption Cover
            'caption'           => $post['caption_cover'] ?? null, 
            
            // Simpan JSON Additional
            'additional_images' => !empty($additionalData) ? json_encode($additionalData) : null,
            
            'slug'              => url_title($post['judul'], '-', true),
            'hash_berita'       => bin2hex(random_bytes(16)),
            'status'            => $post['status'] ?? 0,
            'status_berita'     => $post['status_berita'] ?? 0,
            'created_by_id'     => session()->get('id_user'),
            'created_by_role'   => session()->get('role'),
            'created_by_name'   => session()->get('username'),
            'created_at'        => date('Y-m-d H:i:s')
        ];

        if (!$this->beritaModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->beritaModel->errors());
        }

        $idBerita = $this->beritaModel->getInsertID();
        if (!empty($kategoriIds)) {
            $this->beritaModel->saveKategoriBerita($idBerita, $kategoriIds);
        }

        $this->saveLog($idBerita, 'Berita dibuat', $post['status'] ?? 0);
        $this->clearTemporaryImages();

        return redirect()->to('/berita')->with('success', 'Berita berhasil ditambahkan.');
    }

    // ========================================================
    // Form Edit Berita
    // ========================================================
    public function edit($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/berita')->with('error', 'Kamu tidak punya izin mengubah berita.');
        }

        $berita = $this->beritaModel->find($id);
        if (!$berita) {
            return redirect()->to('/berita')->with('error', 'Berita tidak ditemukan.');
        }

        if (!old('judul')) {
            $this->clearTemporaryImages();
        }

        $additionalImages = [];
        if (!empty($berita['additional_images'])) {
            $decoded = json_decode($berita['additional_images'], true);
            if (is_array($decoded)) {
                $additionalImages = $decoded;
            }
        }

        $kategori = $this->kategoriModel->findAll();
        $selected = array_column(
            $this->beritaModel->getKategoriByBerita($id),
            'id_kategori'
        );
        $beritaAll = $this->beritaModel->findAll();

        return view('pages/berita/edit', [
            'berita' => $berita,
            'kategori' => $kategori,
            'beritaAll' => $beritaAll,
            'additionalImages' => $additionalImages,
            'selected' => $selected,
            'tempCoverImage' => session()->get('temp_cover_image'),
            'tempAdditionalImages' => session()->get('temp_additional_images') ?? []
        ]);
    }

    // ========================================================
    // Update Berita
    // ========================================================
    public function update($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/berita')->with('error', 'Kamu tidak punya izin mengubah berita.');
        }

        $berita = $this->beritaModel->find($id);
        if (!$berita) {
            return redirect()->to('/berita')->with('error', 'Berita tidak ditemukan.');
        }

        $post = $this->request->getPost();
        $validation = \Config\Services::validation();

        // Rules Update (Bahasa Indonesia)
        $rules = [
            'judul' => [
                'rules'  => 'required|min_length[5]|max_length[255]',
                'errors' => [
                    'required'   => 'Judul berita wajib diisi.',
                    'min_length' => 'Judul minimal 5 karakter.',
                    'max_length' => 'Judul maksimal 255 karakter.'
                ]
            ],
            'topik' => [
                'rules'  => 'required|min_length[5]|max_length[255]',
                'errors' => [
                    'required'   => 'Topik wajib diisi.',
                    'min_length' => 'Topik minimal 5 karakter.',
                    'max_length' => 'Topik maksimal 255 karakter.'
                ]
            ],
            'intro' => [
                'rules'  => 'required|min_length[5]',
                'errors' => [
                    'required'   => 'Intro singkat wajib diisi.',
                    'min_length' => 'Intro minimal 5 karakter.'
                ]
            ],
            'content' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Konten berita wajib diisi.'
                ]
            ],
            'id_kategori' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Kategori wajib dipilih minimal satu.'
                ]
            ],
        ];

        // Validasi Cover Image (Optional saat update)
        if (!session()->has('temp_cover_image')) {
            $rules['feat_image'] = [
                'rules'  => 'permit_empty|max_size[feat_image,2048]|is_image[feat_image]|mime_in[feat_image,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran foto maksimal 2MB.',
                    'is_image' => 'File yang diupload bukan gambar.',
                    'mime_in'  => 'Format gambar harus JPG, JPEG, atau PNG.'
                ]
            ];
        }

        if (!$this->validate($rules)) {
            $this->saveTemporaryImages();
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // 1. HANDLE EXISTING DATA (NORMALISASI)
        $existingData = [];
        if (!empty($berita['additional_images'])) {
            $decoded = json_decode($berita['additional_images'], true);
            if (is_array($decoded)) {
                foreach($decoded as $item) {
                    if (is_string($item)) {
                        // Konversi format lama ke baru
                        $existingData[] = ['path' => $item, 'caption' => ''];
                    } else {
                        $existingData[] = $item;
                    }
                }
            }
        }

        // 2. HANDLE DELETE OLD IMAGES
        $deleteImages = $this->request->getPost('delete_old_images');
        if (!empty($deleteImages)) {
            $existingData = array_filter($existingData, function($item) use ($deleteImages) {
                $path = is_array($item) ? $item['path'] : $item;
                if (in_array($path, $deleteImages)) {
                    $fullPath = FCPATH . ltrim($path, '/');
                    if (file_exists($fullPath)) unlink($fullPath);
                    return false;
                }
                return true;
            });
            $existingData = array_values($existingData);
        }

        // 3. HANDLE NEW UPLOADS
        $newData = [];
        $captions = $this->request->getPost('caption_additional');
        
        // A. Temp Images
        if (session()->has('temp_additional_images')) {
            $tempImages = session()->get('temp_additional_images');
            foreach ($tempImages as $index => $tempFile) {
                $tempPath = WRITEPATH . '../public/uploads/temp/' . $tempFile;
                if (file_exists($tempPath)) {
                    $finalDir = FCPATH . 'uploads/berita/additional/';
                    if (!is_dir($finalDir)) mkdir($finalDir, 0755, true);

                    $finalPath = $finalDir . $tempFile;
                    rename($tempPath, $finalPath);

                    $newData[] = [
                        'path'    => 'uploads/berita/additional/' . $tempFile,
                        'caption' => $captions[$index] ?? ''
                    ];
                }
            }
            session()->remove('temp_additional_images');
        }

        // B. Direct Uploads
        $files = $this->request->getFileMultiple('additional_images');
        $startIndex = isset($tempImages) ? count($tempImages) : 0;

        if ($files) {
            foreach ($files as $index => $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move(FCPATH . 'uploads/berita/additional', $newName);
                    
                    $currentCaption = $captions[$startIndex + $index] ?? '';

                    $newData[] = [
                        'path'    => 'uploads/berita/additional/' . $newName,
                        'caption' => $currentCaption
                    ];
                }
            }
        }

        $finalAdditionalImages = array_merge($existingData, $newData);

        // 4. HANDLE COVER IMAGE
        $featImagePath = $berita['feat_image'];
        if (session()->has('temp_cover_image')) {
            $tempFile = session()->get('temp_cover_image');
            $tempPath = WRITEPATH . '../public/uploads/temp/' . $tempFile;
            if (file_exists($tempPath)) {
                $finalPath = FCPATH . 'uploads/berita/' . $tempFile;
                rename($tempPath, $finalPath);
                $featImagePath = 'uploads/berita/' . $tempFile;
            }
            session()->remove('temp_cover_image');
        } else {
            $featImage = $this->request->getFile('feat_image');
            if ($featImage && $featImage->isValid() && !$featImage->hasMoved()) {
                $newName = $featImage->getRandomName();
                $featImage->move(FCPATH . 'uploads/berita', $newName);
                $featImagePath = 'uploads/berita/' . $newName;
            }
        }

        // 5. SAVE
        $kategoriIds = $post['id_kategori'] ?? [];
        if (is_string($kategoriIds)) {
            $kategoriIds = array_filter(array_map('trim', explode(',', $kategoriIds)));
        }
        $idKategori = $kategoriIds[0] ?? null;
        $captionCover = $post['caption_cover'] ?? $berita['caption']; 

        $data = [
            'id_berita'         => $id,
            'judul'             => $post['judul'],
            'topik'             => $post['topik'],
            'intro'             => $post['intro'],
            'sumber'            => $post['sumber'],
            'content'           => $post['content'],
            'content2'          => $post['content2'],
            'id_kategori'       => $idKategori,
            'link_video'        => $post['link_video'] ?? null,
            'keyword'           => $post['keyword'] ?? null,
            'feat_image'        => $featImagePath,
            'additional_images' => json_encode($finalAdditionalImages, JSON_UNESCAPED_SLASHES),
            'slug'              => url_title($post['judul'], '-', true),
            'caption'           => $captionCover,
            'status'            => $post['status'] ?? 0,
            'status_berita'     => $post['status_berita'] ?? 0,
            'updated_by_id'     => session()->get('id_user'),
            'updated_by_name'   => session()->get('username'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'note'              => $post['note'] ?? null,
            'note_revisi'       => $post['note_revisi'] ?? null,
        ];

        if (!$this->beritaModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->beritaModel->errors());
        }

        if (!empty($kategoriIds)) {
            $this->beritaModel->saveKategoriBerita($id, $kategoriIds);
        }

        $this->saveLog($id, 'Berita diperbarui', $data['status'], $data['note'], $data['note_revisi']);
        $this->clearTemporaryImages();

        return redirect()->to('/berita')->with('success', 'Berita berhasil diperbarui.');
    }

    // ========================================================
    // Delete (Soft Delete)
    // ========================================================
    public function delete($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) {
            return redirect()->to('/berita')->with('error', 'Kamu tidak punya izin menghapus berita.');
        }

        $berita = $this->beritaModel->find($id);
        if (!$berita) {
            return redirect()->to('/berita')->with('error', 'Berita tidak ditemukan.');
        }

        $updated = $this->beritaModel->update($id, [
            'trash' => '1',
            'is_delete_by_id' => session()->get('id_user'),
            'is_delete_by_name' => session()->get('username'),
            'delete_at' => date('Y-m-d H:i:s')
        ]);

        if ($updated) {
            $this->saveLog($id, 'Berita dipindahkan ke sampah', $berita['status'] ?? 0);
            return redirect()->to('/berita')->with('success', 'Berita dipindahkan ke sampah.');
        }

        return redirect()->to('/berita')->with('error', 'Gagal memindahkan berita ke sampah.');
    }

    // ========================================================
    // Destroy Permanent
    // ========================================================
    public function destroyPermanent($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) {
            return redirect()->to('/berita/trash')->with('error', 'Kamu tidak punya izin menghapus berita.');
        }

        $berita = $this->beritaModel->find($id);
        if (!$berita) {
            return redirect()->to('/berita/trash')->with('error', 'Berita tidak ditemukan.');
        }

        if (!empty($berita['feat_image']) && file_exists(FCPATH . $berita['feat_image'])) {
            unlink(FCPATH . $berita['feat_image']);
        }

        if (!empty($berita['additional_images'])) {
            $addImages = json_decode($berita['additional_images'], true);
            foreach ($addImages as $imgItem) {
                $path = is_array($imgItem) ? $imgItem['path'] : $imgItem;
                if (file_exists(FCPATH . $path)) {
                    unlink(FCPATH . $path);
                }
            }
        }

        $this->beritaModel->delete($id, true);
        return redirect()->to('/berita/trash')->with('success', 'Berita berhasil dihapus permanen.');
    }

    // ========================================================
    // Restore & Trash View
    // ========================================================
    public function restore($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/berita/trash')->with('error', 'Kamu tidak punya izin memulihkan berita.');
        }

        $this->beritaModel->update($id, [
            'trash' => '0',
            'is_delete_by_id' => null,
            'is_delete_by_name' => null,
            'delete_at' => null
        ]);

        $this->saveLog($id, 'Berita dipulihkan dari sampah');
        return redirect()->to('/berita/trash')->with('success', 'Berita berhasil dipulihkan.');
    }

    public function trash()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat berita.');
        }

        $berita = $this->beritaModel->db->table('t_berita')
            ->select('t_berita.*, GROUP_CONCAT(m_kategori_berita.kategori SEPARATOR ", ") as kategori')
            ->join('t_berita_kategori', 't_berita_kategori.id_berita = t_berita.id_berita', 'left')
            ->join('m_kategori_berita', 'm_kategori_berita.id_kategori = t_berita_kategori.id_kategori', 'left')
            ->where('t_berita.trash', '1')
            ->groupBy('t_berita.id_berita')
            ->orderBy('t_berita.updated_at', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Sampah Berita',
            'berita' => $berita,
            'can_restore' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ];

        return view('pages/berita/trash', $data);
    }

    // ========================================================
    // Helpers: Upload & Log
    // ========================================================
    private function saveTemporaryImages()
    {
        $session = session();
        $tempDir = WRITEPATH . '../public/uploads/temp/';
        if (!is_dir($tempDir)) mkdir($tempDir, 0755, true);

        if (!$session->has('temp_cover_image')) {
            $cover = $this->request->getFile('feat_image');
            if ($cover && $cover->isValid() && !$cover->hasMoved()) {
                $name = 'temp_cover_' . uniqid() . '.' . $cover->getExtension();
                $cover->move($tempDir, $name);
                $session->set('temp_cover_image', $name);
            }
        }

        if (!$session->has('temp_additional_images')) {
            $additional = $this->request->getFileMultiple('additional_images');
            $tempAdditional = [];
            if ($additional) {
                foreach ($additional as $file) {
                    if ($file->isValid() && !$file->hasMoved()) {
                        $name = 'temp_add_' . uniqid() . '.' . $file->getExtension();
                        $file->move($tempDir, $name);
                        $tempAdditional[] = $name;
                    }
                }
                if ($tempAdditional) $session->set('temp_additional_images', $tempAdditional);
            }
        }
    }

    private function clearTemporaryImages()
    {
        $session = session();
        $tempDir = WRITEPATH . '../public/uploads/temp/';

        if ($session->has('temp_cover_image')) {
            $file = $tempDir . $session->get('temp_cover_image');
            if (file_exists($file)) unlink($file);
            $session->remove('temp_cover_image');
        }

        if ($session->has('temp_additional_images')) {
            foreach ($session->get('temp_additional_images') as $img) {
                $file = $tempDir . $img;
                if (file_exists($file)) unlink($file);
            }
            $session->remove('temp_additional_images');
        }
    }

    private function getAccess($role)
    {
        $access = $this->accessRightsModel->where('role', $role)->where('module_name', $this->module)->first();
        if (!$access) return ['can_create'=>false,'can_read'=>false,'can_update'=>false,'can_delete'=>false];
        return [
            'can_create' => (bool)$access['can_create'],
            'can_read' => (bool)$access['can_read'],
            'can_update' => (bool)$access['can_update'],
            'can_delete' => (bool)$access['can_delete'],
        ];
    }

    private function saveLog($idBerita, $keterangan, $status = null, $notePerbaikan = null, $noteRevisi = null)
    {
        $berita = $this->beritaModel->find($idBerita);
        if (!$berita) return;

        $kategori = $this->beritaModel->getKategoriByBerita($idBerita);
        $berita['kategori_berita'] = $kategori;

        if (!empty($berita['additional_images'])) {
            $berita['galeri_foto'] = json_decode($berita['additional_images'], true);
        }

        $logData = [
            'id_hash' => $berita['hash_berita'] ?? '',
            'id_berita' => $idBerita,
            'log' => json_encode($berita, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'keterangan' => $keterangan,
            'id_user' => session()->get('id_user'),
            'created_date' => date('Y-m-d H:i:s'),
            'status' => $status ?? $berita['status'] ?? 0,
            'note_perbaikan' => $notePerbaikan,
            'note_revisi' => $noteRevisi,
            'fullname' => session()->get('username'),
        ];

        $this->beritaLogModel->insert($logData);
    }
    
    public function log($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_read']) {
            return redirect()->to('/berita')->with('error', 'Kamu tidak punya izin melihat log berita.');
        }

        $berita = $this->beritaModel->find($id);
        if (!$berita) return redirect()->to('/berita')->with('error', 'Berita tidak ditemukan.');

        $logs = $this->beritaLogModel->where('id_berita', $id)->orderBy('created_date', 'DESC')->findAll();

        return view('pages/berita/log', [
            'title' => 'Log Berita',
            'berita' => $berita,
            'logs' => $logs
        ]);
    }
}