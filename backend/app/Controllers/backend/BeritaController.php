<?php

namespace App\Controllers\backend;

use App\Controllers\BaseController;
use App\Models\BeritaModel;
use App\Models\KategoriModel;
use App\Models\AccessRightsModel;
use App\Models\BeritaLogModel;
use App\Models\BeritaTagModel;

class BeritaController extends BaseController
{
    protected $beritaModel;

    protected $beritaTagModel;
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
        $this->beritaTagModel = new BeritaTagModel();
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

        // Loop berita untuk ambil Kategori & Tags
        foreach ($berita as &$b) {
            // 1. Ambil Kategori (Existing)
            $kats = $this->beritaModel->db->table('t_berita_kategori')
                ->select('m_kategori_berita.id_kategori, m_kategori_berita.kategori')
                ->join('m_kategori_berita', 'm_kategori_berita.id_kategori = t_berita_kategori.id_kategori')
                ->where('t_berita_kategori.id_berita', $b['id_berita'])
                ->get()
                ->getResultArray();

            $b['kategori'] = array_column($kats, 'kategori');
            $b['kategori_ids'] = array_column($kats, 'id_kategori');

            // 2. ✅ TAMBAHAN TAGS: Ambil Tags untuk ditampilkan di Index (Optional)
            // Asumsi tabel master tags: m_berita_tag, PK: id_tags, Nama: nama_tag
            $tags = $this->beritaModel->db->table('t_berita_tag')
                ->select('m.nama_tag')
                ->join('m_berita_tag m', 'm.id_tags = t_berita_tag.id_tags')
                ->where('t_berita_tag.id_berita', $b['id_berita'])
                ->get()
                ->getResultArray();
            
            $b['tags'] = array_column($tags, 'nama_tag'); // Array nama tags
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
        $model = new \App\Models\BeritaModel(); // <--- GANTI INI SESUAI MODUL
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

    // Ambil ID User yang sedang login
    $currentUserId = session()->get('id_user');

    $data = [
        'title' => 'Tambah Berita',
        'kategori' => $this->kategoriModel->where('trash', '0')->where('status', '1')->findAll(),
        'tags' => $this->beritaTagModel->findAll(),
        
        // --- PERUBAHAN DISINI ---
        // Hanya ambil berita yang dibuat oleh user ini & tidak trash
        'beritaAll' => $this->beritaModel
                            ->where('created_by_id', $currentUserId) 
                            ->where('trash', '0')
                            ->orderBy('id_berita', 'DESC')
                            ->findAll(),
        // ------------------------

        'tempCoverImage' => session()->get('temp_cover_image'),
        'tempAdditionalImages' => session()->get('temp_additional_images') ?? []
    ];

    return view('pages/berita/create', $data);
}

    // ========================================================
    // Detail Berita (Show)
    // ========================================================
// ========================================================
    // Detail Berita (Show)
    // ========================================================
    // Ubah parameter dari $id menjadi $slug
    public function show($slug = null)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat berita.');
        }

        // ----------------------------------------------------
        // PERUBAHAN LOGIKA PENCARIAN
        // ----------------------------------------------------
        // Cari berdasarkan kolom 'slug'
        $berita = $this->beritaModel->where('slug', $slug)->first();

        // (Opsional) Fallback: Jika slug tidak ketemu, coba cari pakai ID (siapa tau link lama masih pakai ID)
        if (!$berita && is_numeric($slug)) {
             $berita = $this->beritaModel->find($slug);
        }
        // ----------------------------------------------------

        if (!$berita) {
            return redirect()->to('/berita')->with('error', 'Berita tidak ditemukan.');
        }

        // Ambil ID dari data berita yang ditemukan untuk query relasi lainnya
        $id = $berita['id_berita']; 

        // --- SISA KODE KE BAWAH TETAP SAMA ---
        
        // Ambil kategori berita
        $kategori = $this->beritaModel->getKategoriByBerita($id);
        $kategoriNames = array_column($kategori, 'kategori');

        // Ambil tags
        $tags = $this->beritaModel->getTagsByBerita($id); 
        $tagNames = array_column($tags, 'nama_tag');

        // Ambil berita terkait
        $beritaTerkait = [];
        if (!empty($berita['id_berita_terkait'])) {
            $beritaTerkait[] = $this->beritaModel->find($berita['id_berita_terkait']);
        }
        if (!empty($berita['id_berita_terkait2'])) {
            $beritaTerkait[] = $this->beritaModel->find($berita['id_berita_terkait2']);
        }

        // Decode additional images
        $rawImages = !empty($berita['additional_images']) ? json_decode($berita['additional_images'], true) : [];
        $additionalImages = [];
        
        foreach($rawImages as $img) {
            if (is_string($img)) {
                $additionalImages[] = ['path' => $img, 'caption' => ''];
            } else {
                $additionalImages[] = $img;
            }
        }

        $data = [
            'title' => 'Detail Berita',
            'berita' => $berita,
            'kategori' => $kategoriNames,
            'tags' => $tagNames,
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
            'tanggal' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Tanggal wajib diisi.'
                ],
            ],
            'sumber' => [
                'rules'  => 'required|max_length[255]',
                'errors' => [
                    'max_length' => 'Sumber maksimal 255 karakter.'
                ]
            ],
// Tambahkan ini di dalam array $rules
            'additional_images' => [
                // 'required' adalah kuncinya agar tidak wajib diisi
                'rules'  => 'permit_empty', 
            ],
            // Jika ingin memvalidasi file hanya jika user mengupload (opsional tapi divalidasi):
            'additional_images.' => [
                'rules'  => 'permit_empty|max_size[additional_images,2048]|is_image[additional_images]|mime_in[additional_images,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran foto tambahan maksimal 2MB.',
                    'is_image' => 'File tambahan harus berupa gambar.',
                    'mime_in'  => 'Format harus JPG/PNG.'
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
        
$post = $this->request->getPost();
// --- LOGIKA DRAFT BARU ---
$submitType = $this->request->getPost('submit_type');
if ($submitType === 'draft') {
    $status       = '5'; // Status Aktif/Non-aktif (biasanya untuk toggle di index)
    $statusBerita = 0;   // Sesuai permintaan: Draft = 0
} else {
    $status       = '1'; // Status Aktif
    $statusBerita = 4;   // Sesuai permintaan: Publikasi = 4
}
        // 3. SIMPAN DATA
 $post = $this->request->getPost();
$kategoriIds = is_array($post['id_kategori']) ? $post['id_kategori'] : explode(',', $post['id_kategori']);
$idKategori = $kategoriIds[0] ?? null;

// ✅ TAMBAHKAN BAGIAN INI (BARU)
$tagsIds = $post['id_tags'] ?? '';
if (is_string($tagsIds) && !empty($tagsIds)) {
    $tagsIds = array_filter(array_map('trim', explode(',', $tagsIds)));
} elseif (!is_array($tagsIds)) {
    $tagsIds = [];
}
$idTagsUtama = !empty($tagsIds) ? $tagsIds[0] : null;
// ... (kode sebelumnya)
   $data = [
    'judul'             => $post['judul'],
    'topik'             => $post['topik'],
    'intro'             => $post['intro'],
    'sumber'            => $post['sumber'],
    'content'           => $post['content'],
    'content2'          => $post['content2'],
    'id_kategori'       => $idKategori,
    'id_tags'           => $idTagsUtama,
    'link_video'        => $post['link_video'] ?? null,
    'keyword'           => $post['keyword'] ?? null,
    'feat_image'        => $featImagePath,
    'id_berita_terkait'  => !empty($post['id_berita_terkait']) ? $post['id_berita_terkait'] : null,
    'id_berita_terkait2' => !empty($post['id_berita_terkait2']) ? $post['id_berita_terkait2'] : null,
    'caption'           => $post['caption_cover'] ?? null, 
    'additional_images' => !empty($additionalData) ? json_encode($additionalData) : null,
    'slug'              => url_title($post['judul'], '-', true),
    'hash_berita'       => bin2hex(random_bytes(16)),
    
    // --- GUNAKAN VARIABEL DINAMIS DI SINI ---
    'status'            => $status,
    'status_berita'     => $statusBerita,
    
    'tanggal'           => $post['tanggal'] ?? date('Y-m-d'),
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

// ✅ PERBAIKAN: Ganti id_tagss jadi id_tags
$tagsIds = $post['id_tags'] ?? ''; // ✅ Perbaiki nama field

// Normalisasi: Handle string comma-separated atau array
if (is_string($tagsIds) && !empty($tagsIds)) {
    $tagsIds = array_filter(array_map('trim', explode(',', $tagsIds)));
} elseif (!is_array($tagsIds)) {
    $tagsIds = [];
}
$message = ($submitType === 'draft') ? 'Berita berhasil disimpan sebagai draft.' : 'Berita berhasil dipublikasikan.';
return redirect()->to('/berita')->with('success', $message);
// ✅ GANTI BAGIAN INI JUGA
if (!empty($tagsIds)) {
    $this->beritaModel->saveTagsBerita($idBerita, $tagsIds);
}

$this->saveLog($idBerita, 'Berita dibuat', $post['status'] ?? '5');
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

    // Cek apakah user yang login adalah pembuat berita ini (opsional, untuk keamanan ekstra)
    // Jika admin boleh edit punya orang lain, hapus blok if di bawah ini.
    /*
    if ($berita['created_by_id'] != session()->get('id_user') && session()->get('role') != 'admin') {
         return redirect()->to('/berita')->with('error', 'Anda hanya bisa mengedit berita buatan sendiri.');
    }
    */

    if (!old('judul')) {
        $this->clearTemporaryImages();
    }

    // Normalisasi Additional Images
    $additionalImages = [];
    if (!empty($berita['additional_images'])) {
        $decoded = json_decode($berita['additional_images'], true);
        if (is_array($decoded)) {
            $additionalImages = $decoded;
        }
    }

    // Kategori
    $kategori = $this->kategoriModel->findAll();
    $selected = array_column(
        $this->beritaModel->getKategoriByBerita($id),
        'id_kategori'
    );

    $allTags = $this->beritaTagModel->findAll(); 
    $selectedTags = array_column(
        $this->beritaModel->getTagsByBerita($id), 
        'id_tags'
    );
    
    // --- PERUBAHAN DISINI ---
    $currentUserId = session()->get('id_user');
    
    $beritaAll = $this->beritaModel
        ->where('created_by_id', $currentUserId) // Hanya buatan sendiri
        ->where('id_berita !=', $id)             // Jangan tampilkan berita yang sedang diedit
        ->where('trash', '0')
        ->orderBy('id_berita', 'DESC')
        ->findAll();
    // ------------------------

    return view('pages/berita/edit', [
        'title' => 'Edit Berita',
        'berita' => $berita,
        'kategori' => $kategori,
        'beritaAll' => $beritaAll, // Data yang dikirim ke dropdown sudah terfilter
        'tags' => $allTags,            
        'selectedTags' => $selectedTags, 
        'additionalImages' => $additionalImages,
        'selected' => $selected,
        'tempCoverImage' => session()->get('temp_cover_image'),
        'tempAdditionalImages' => session()->get('temp_additional_images') ?? []
    ]);
}
    // ========================================================
    // Update Berita
    // ========================================================
// ========================================================
    // Update Berita (Full Code Fixed)
    // ========================================================
    public function update($id)
    {
        // 1. Cek Hak Akses
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/berita')->with('error', 'Kamu tidak punya izin mengubah berita.');
        }

        // 2. Cek Data Lama
        $berita = $this->beritaModel->find($id);
        if (!$berita) {
            return redirect()->to('/berita')->with('error', 'Berita tidak ditemukan.');
        }

        $post = $this->request->getPost();
        $validation = \Config\Services::validation();

        // 3. Rules Validasi Utama (Tanpa feat_image dulu)
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

        // 4. Logika Validasi Gambar (Hanya jika upload baru)
        $featImageFile = $this->request->getFile('feat_image');
        $isUploadNew = ($featImageFile && $featImageFile->isValid() && !$featImageFile->hasMoved());
        $hasTemp = session()->has('temp_cover_image');

        if ($isUploadNew || $hasTemp) {
            $rules['feat_image'] = [
                // Hapus 'required', cukup validasi spek gambar
                'rules'  => 'max_size[feat_image,2048]|is_image[feat_image]|mime_in[feat_image,image/jpg,image/jpeg,image/png]',
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

        // 5. HANDLE ADDITIONAL IMAGES (Gallery)
        // -------------------------------------
        // A. Ambil Data Lama
        $existingData = [];
        if (!empty($berita['additional_images'])) {
            $decoded = json_decode($berita['additional_images'], true);
            if (is_array($decoded)) {
                foreach($decoded as $item) {
                    if (is_string($item)) {
                        $existingData[] = ['path' => $item, 'caption' => ''];
                    } else {
                        $existingData[] = $item;
                    }
                }
            }
        }

        // B. Hapus Gambar Gallery Lama (Jika dicentang user)
        $deleteImages = $this->request->getPost('delete_old_images');
        if (!empty($deleteImages)) {
            $existingData = array_filter($existingData, function($item) use ($deleteImages) {
                $path = is_array($item) ? $item['path'] : $item;
                if (in_array($path, $deleteImages)) {
                    $fullPath = FCPATH . ltrim($path, '/');
                    if (file_exists($fullPath)) @unlink($fullPath);
                    return false;
                }
                return true;
            });
            $existingData = array_values($existingData);
        }

        // C. Proses Upload Gallery Baru
        $newData = [];
        $captions = $this->request->getPost('caption_additional');
        
        // C.1 Dari Temporary (Session)
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

        // C.2 Dari Upload Langsung
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


        // 6. HANDLE COVER IMAGE (FEAT IMAGE)
        // ----------------------------------
        // Default: Pakai gambar lama
        $featImagePath = $berita['feat_image'];

        // Skenario A: Ada di Temporary (gagal validasi field lain sebelumnya)
        if (session()->has('temp_cover_image')) {
            $tempFile = session()->get('temp_cover_image');
            $tempPath = WRITEPATH . '../public/uploads/temp/' . $tempFile;
            
            if (file_exists($tempPath)) {
                // Hapus file lama fisik
                if (!empty($berita['feat_image']) && file_exists(FCPATH . $berita['feat_image'])) {
                    @unlink(FCPATH . $berita['feat_image']);
                }

                $finalPath = FCPATH . 'uploads/berita/' . $tempFile;
                rename($tempPath, $finalPath);
                $featImagePath = 'uploads/berita/' . $tempFile;
            }
            session()->remove('temp_cover_image');
        } 
        // Skenario B: Upload Langsung Baru
        else {
            $featImage = $this->request->getFile('feat_image');
            if ($featImage && $featImage->isValid() && !$featImage->hasMoved()) {
                
                // Hapus file lama fisik
                if (!empty($berita['feat_image']) && file_exists(FCPATH . $berita['feat_image'])) {
                    @unlink(FCPATH . $berita['feat_image']);
                }

                $newName = $featImage->getRandomName();
                $featImage->move(FCPATH . 'uploads/berita', $newName);
                $featImagePath = 'uploads/berita/' . $newName;
            }
        }

        $submitType = $this->request->getPost('submit_type');
if ($submitType === 'draft') {
    $status       = '1';
    $statusBerita = 0;
} else {
    $status       = '1';
    $statusBerita = 4;
}

        // 7. PERSIAPAN DATA SAVE
        // ----------------------
        $kategoriIds = $post['id_kategori'] ?? [];
        if (is_string($kategoriIds)) {
            $kategoriIds = array_filter(array_map('trim', explode(',', $kategoriIds)));
        }
        $idKategori = $kategoriIds[0] ?? null;
        $captionCover = $post['caption_cover'] ?? $berita['caption']; 

        $tagsIds = $post['id_tags'] ?? [];
        if (is_string($tagsIds)) {
            $tagsIds = array_filter(array_map('trim', explode(',', $tagsIds)));
        }
        $idtags = $tagsIds[0] ?? null;

        $data = [
            'id_berita'         => $id,
            'judul'             => $post['judul'],
            'topik'             => $post['topik'],
            'intro'             => $post['intro'],
            'sumber'            => $post['sumber'],
            'content'           => $post['content'],
            'content2'          => $post['content2'],
            'id_kategori'       => $idKategori,
            'id_tags'           => $idtags,
            'link_video'        => $post['link_video'] ?? null,
            'keyword'           => $post['keyword'] ?? null,
            'feat_image'        => $featImagePath, // Menggunakan path baru atau lama
            
            'id_berita_terkait'  => !empty($post['id_berita_terkait']) ? $post['id_berita_terkait'] : null,
            'id_berita_terkait2' => !empty($post['id_berita_terkait2']) ? $post['id_berita_terkait2'] : null,

            'additional_images' => json_encode($finalAdditionalImages, JSON_UNESCAPED_SLASHES),
            'slug'              => url_title($post['judul'], '-', true),
            'caption'           => $captionCover,
            'tanggal'           => $post['tanggal'],
            'status'            => $status,
            'status_berita'     => $statusBerita,
            'updated_by_id'     => session()->get('id_user'),
            'updated_by_name'   => session()->get('username'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'note'              => $post['note'] ?? null,
            'note_revisi'       => $post['note_revisi'] ?? null,
        ];

        // 8. UPDATE DATABASE
        if (!$this->beritaModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->beritaModel->errors());
        }

        // 9. UPDATE RELASI KATEGORI
        if (!empty($kategoriIds)) {
            $this->beritaModel->saveKategoriBerita($id, $kategoriIds);
        }

        // 10. UPDATE RELASI TAGS
        $this->beritaModel->saveTagsBerita($id, $tagsIds);

        // 11. LOG & SELESAI
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
// ✅ PERBAIKAN DISINI: Gunakan 'username', bukan 'user_name'
            'username '   => session()->get('username '),        ];

        $this->beritaLogModel->insert($logData);
    }
    
public function log($id)
{
    $access = $this->getAccess(session()->get('role'));
    if (!$access || !$access['can_read']) {
        return redirect()->to('/berita')->with('error', 'Kamu tidak punya izin melihat log berita.');
    }

    $berita = $this->beritaModel->find($id);
    if (!$berita) {
        return redirect()->to('/berita')->with('error', 'Berita tidak ditemukan.');
    }

    // ✅ AMBIL SEMUA LOG (TAMPILKAN SEMUA PERUBAHAN STATUS BERITA)
    $logs = $this->beritaLogModel
        ->select('t_berita_log.*, m_users.full_name') 
        ->join('m_users', 'm_users.id_user = t_berita_log.id_user', 'left') 
        ->where('t_berita_log.id_berita', $id)
        ->orderBy('t_berita_log.created_date', 'DESC') // ✅ TERBARU DI ATAS
        ->findAll();

    // ✅ PROSES DATA UNTUK MENDETEKSI PERUBAHAN STATUS_BERITA & KONTEN
    // Data dari query sudah DESC (terbaru ke terlama)
    $processedLogs = [];
    $nextLog = null; // ✅ Gunakan nextLog karena kita loop dari terbaru

    foreach ($logs as $index => $log) {
        $currentData = json_decode($log['log'], true);
        
        // ✅ INISIALISASI SEMUA VARIABEL DI AWAL
        $changes = [];
        $statusBeritaChanged = false;
        $statusBeritaChangeInfo = null;
        
        // ✅ Bandingkan dengan log BERIKUTNYA (yang lebih lama)
        if ($nextLog !== null) {
            $nextData = json_decode($nextLog['log'], true);
            
            // ✅ CEK PERUBAHAN STATUS_BERITA (0=Draft, 4=Layak Tayang)
            $currentStatusBerita = $currentData['status_berita'] ?? 0;
            $nextStatusBerita = $nextData['status_berita'] ?? 0;
            
            if ($currentStatusBerita != $nextStatusBerita) {
                $statusBeritaChanged = true;
                $statusBeritaChangeInfo = [
                    'from' => $nextStatusBerita, // dari yang lama
                    'to' => $currentStatusBerita  // ke yang baru
                ];
            }
            
            // Bandingkan field-field penting (hanya jika status berubah atau perlu tracking detail)
            $fieldsToCompare = [
                'judul' => 'Judul',
                'intro' => 'Intro',
                'content' => 'Konten',
                'content2' => 'Konten Tambahan',
                'topik' => 'Topik',
                'sumber' => 'Sumber',
                'keyword' => 'Keyword',
                'feat_image' => 'Foto Cover',
                'link_video' => 'Link Video',
                'caption' => 'Caption Cover'
            ];

            foreach ($fieldsToCompare as $field => $label) {
                $currentValue = $currentData[$field] ?? '';
                $nextValue = $nextData[$field] ?? '';
                
                if ($currentValue != $nextValue) {
                    $changes[] = [
                        'field' => $label,
                        'old' => $nextValue,      // yang lama
                        'new' => $currentValue     // yang baru
                    ];
                }
            }

            // Cek perubahan kategori
            $currentKategori = $currentData['kategori_berita'] ?? [];
            $nextKategori = $nextData['kategori_berita'] ?? [];
            
            $currentKatNames = array_column($currentKategori, 'kategori');
            $nextKatNames = array_column($nextKategori, 'kategori');
            
            if ($currentKatNames != $nextKatNames) {
                $changes[] = [
                    'field' => 'Kategori',
                    'old' => implode(', ', $nextKatNames),
                    'new' => implode(', ', $currentKatNames)
                ];
            }

            // Cek perubahan galeri foto
            $currentGaleri = $currentData['galeri_foto'] ?? [];
            $nextGaleri = $nextData['galeri_foto'] ?? [];
            
            if (count($currentGaleri) != count($nextGaleri)) {
                $changes[] = [
                    'field' => 'Galeri Foto',
                    'old' => count($nextGaleri) . ' foto',
                    'new' => count($currentGaleri) . ' foto'
                ];
            }
        }

        $processedLogs[] = [
            'log' => $log,
            'data' => $currentData,
            'changes' => $changes,
            'hasChanges' => !empty($changes),
            'statusBeritaChanged' => $statusBeritaChanged ?? false,
            'statusBeritaChangeInfo' => $statusBeritaChangeInfo ?? null,
            'currentStatusBerita' => $currentData['status_berita'] ?? 0
        ];

        $nextLog = $log; // ✅ Simpan log saat ini untuk dibandingkan di iterasi berikutnya
    }

    return view('pages/berita/logs', [
        'title' => 'Riwayat Perubahan Status Berita',
        'berita' => $berita,
        'logs' => $processedLogs // ✅ Sudah urut DESC: Terbaru di atas
    ]);
}
}