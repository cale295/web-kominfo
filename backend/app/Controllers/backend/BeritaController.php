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
            'kategori' => $this->kategoriModel->where('trash', '0')->findAll(),
            'beritaAll' => $this->beritaModel->findAll(),
            'tempCoverImage' => session()->get('temp_cover_image'),
            'tempAdditionalImages' => session()->get('temp_additional_images') ?? []
        ];

        return view('pages/berita/create', $data);
    }


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

        // Decode additional images
        $additionalImages = !empty($berita['additional_images']) ? json_decode($berita['additional_images'], true) : [];

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
    // Simpan Berita Baru
    // ========================================================
    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_create']) {
            return redirect()->to('/berita')->with('error', 'Kamu tidak punya izin menambah berita.');
        }

        $validation = \Config\Services::validation();
        $rules = [
            'judul' => 'required|min_length[5]',
            'content' => 'required',
            'content2' => 'required',
            'id_kategori' => 'required'
        ];

        if (!session()->has('temp_cover_image')) {
            $rules['feat_image'] = 'uploaded[feat_image]|max_size[feat_image,2048]|is_image[feat_image]';
        }

        if (!$this->validate($rules)) {
            $this->saveTemporaryImages();
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // --- Cover Image ---
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

        // --- Additional Images ---
        $additionalImages = [];
        if (session()->has('temp_additional_images')) {
            foreach (session()->get('temp_additional_images') as $tempFile) {
                $tempPath = WRITEPATH . '../public/uploads/temp/' . $tempFile;
                if (file_exists($tempPath)) {
                    $finalDir = WRITEPATH . '../public/uploads/berita/additional/';
                    if (!is_dir($finalDir)) mkdir($finalDir, 0755, true);
                    $finalPath = $finalDir . $tempFile;
                    rename($tempPath, $finalPath);
                    $additionalImages[] = 'uploads/berita/additional/' . $tempFile;
                }
            }
            session()->remove('temp_additional_images');
        }

        $files = $this->request->getFileMultiple('additional_images');
        if ($files) {
            foreach ($files as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move(WRITEPATH . '../public/uploads/berita/additional', $newName);
                    $additionalImages[] = 'uploads/berita/additional/' . $newName;
                }
            }
        }

        // --- Simpan ke database ---
        $post = $this->request->getPost();
        $kategoriIds = is_array($post['id_kategori']) ? $post['id_kategori'] : explode(',', $post['id_kategori']);
        $idKategori = $kategoriIds[0] ?? null;

        $data = [
            'judul' => $post['judul'],
            'topik' => $post['topik'] ?? null,
            'intro' => $post['intro'] ?? null,
            'sumber' => $post['sumber'] ?? null,
            'content' => $post['content'],
            'content2' => $post['content2'],
            'id_kategori' => $idKategori,
            'link_video' => $post['link_video'] ?? null,
            'keyword' => $post['keyword'] ?? null,
            'feat_image' => $featImagePath,
            'additional_images' => !empty($additionalImages) ? json_encode($additionalImages) : null,
            'slug' => url_title($post['judul'], '-', true),
            'hash_berita' => bin2hex(random_bytes(16)),
            'status' => $post['status'] ?? 0,
            'status_berita' => $post['status_berita'] ?? 0,
            'created_by_id' => session()->get('id_user'),
            'created_by_name' => session()->get('username'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if (!$this->beritaModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->beritaModel->errors());
        }

        $idBerita = $this->beritaModel->getInsertID();
        if (!empty($kategoriIds)) $this->beritaModel->saveKategoriBerita($idBerita, $kategoriIds);
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

    // Decode gambar tambahan agar bisa ditampilkan
    $additionalImages = [];
    if (!empty($berita['additional_images'])) {
        $decoded = json_decode($berita['additional_images'], true);
        if (is_array($decoded)) {
            $additionalImages = $decoded;
        }
    }

    // Ambil semua kategori
    $kategori = $this->kategoriModel->findAll();

    // Ambil kategori yang dipilih sebelumnya
    $kategoriPivot = $this->beritaModel->getKategoriByBerita($id);
    $selected = array_column($this->beritaModel->getKategoriByBerita($id), 'id_kategori');
    

    $beritaAll = $this->beritaModel->findAll();

    return view('pages/berita/edit', [
        'berita' => $berita,
        'kategori' => $kategori,
        'beritaAll' => $beritaAll,
        'additionalImages' => $additionalImages,
        'selected' => $selected, // kirim ke view
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

    $post = $this->request->getPost();
    $berita = $this->beritaModel->find($id);
    if (!$berita) {
        return redirect()->to('/berita')->with('error', 'Berita tidak ditemukan.');
    }

    // --- Cover Image ---
    $featImagePath = $berita['feat_image'];
    $featImage = $this->request->getFile('feat_image');
    if ($featImage && $featImage->isValid() && !$featImage->hasMoved()) {
        $newName = $featImage->getRandomName();
        $featImage->move(WRITEPATH . '../public/uploads/berita', $newName);
        $featImagePath = 'uploads/berita/' . $newName;
    }

    // --- Additional Images ---
    $additionalImages = !empty($berita['additional_images']) ? json_decode($berita['additional_images'], true) : [];
    $files = $this->request->getFileMultiple('additional_images');
    if ($files) {
        foreach ($files as $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(WRITEPATH . '../public/uploads/berita/additional', $newName);
                $additionalImages[] = 'uploads/berita/additional/' . $newName;
            }
        }
    }

    // --- Ambil kategori ---
    $kategoriIds = $post['id_kategori'] ?? [];
    if (is_string($kategoriIds)) {
        $kategoriIds = array_filter(array_map('trim', explode(',', $kategoriIds)));
    }
    if (empty($kategoriIds)) {
        $kategoriPivot = $this->beritaModel->getKategoriByBerita($id);
        $kategoriIds = array_column($kategoriPivot, 'id_kategori');
    }
    $idKategori = (!empty($kategoriIds) && isset($kategoriIds[0])) ? (int)$kategoriIds[0] : null;

    // --- Data Update ---
    $data = [
        'judul'             => $post['judul'] ?? null,
        'topik'             => $post['topik'] ?? null,
        'intro'             => $post['intro'] ?? null,
        'sumber'            => $post['sumber'] ?? null,
        'content'           => $post['content'] ?? null,
        'content2'          => $post['content2'] ?? null,
        'id_berita_terkait' => $post['id_berita_terkait'] ?? null,
        'id_berita_terkait2' => $post['id_berita_terkait2'] ?? null,
        'id_kategori'       => $idKategori,
        'link_video'        => $post['link_video'] ?? null,
        'keyword'           => $post['keyword'] ?? null,
        'feat_image'        => $featImagePath,
        'additional_images' => !empty($additionalImages) ? json_encode($additionalImages) : null,
        'slug'              => url_title($post['judul'], '-', true),
        'hash_berita'       => $berita['hash_berita'] ?? bin2hex(random_bytes(16)),
        'status'            => (string)$post['status'],
        'status_berita'     => (int)$post['status_berita'],
        'updated_by_id'     => session()->get('id_user'),
        'updated_by_name'   => session()->get('username'),
        'updated_at'        => date('Y-m-d H:i:s'),
        'note'              => $post['note'] ?? null,
        'note_revisi'       => $post['note_revisi'] ?? null,
    ];

    // --- Simpan dengan validasi model ---
    if (!$this->beritaModel->save(array_merge($data, ['id_berita' => $id]))) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->beritaModel->errors());
    }

    // --- Update kategori pivot ---
    if (!empty($kategoriIds)) {
        $this->beritaModel->saveKategoriBerita($id, $kategoriIds);
    }

    // --- Buat keterangan log otomatis berdasarkan perubahan ---
    $keteranganArr = [];
    $fields = [
        'judul','topik','intro','sumber','content','content2',
        'id_berita_terkait','id_berita_terkait2','id_kategori',
        'link_video','keyword','feat_image','additional_images'
    ];
    foreach ($fields as $field) {
        if (isset($data[$field]) && $berita[$field] != $data[$field]) {
            $fieldName = str_replace('_', ' ', $field);
            $keteranganArr[] = "Mengubah $fieldName";
        }
    }
    $keterangan = !empty($keteranganArr) ? implode(', ', $keteranganArr) : 'Melakukan update berita';

    // --- Simpan log ---
    $this->saveLog($id, $keterangan, $data['status'], $data['note'], $data['note_revisi']);

    return redirect()->to('/berita')->with('success', 'Berita berhasil diperbarui.');
}



public function delete($id)
{
    $access = $this->getAccess(session()->get('role'));
    if (!$access || !$access['can_delete']) {
        return redirect()->to('/berita')->with('error', 'Kamu tidak punya izin menghapus berita.');
    }

    $berita = $this->beritaModel->find($id); // ← WAJIB ADA
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
    }

    if (!$updated) {
        return redirect()->to('/berita')->with('error', 'Gagal memindahkan berita ke sampah.');
    }

    return redirect()->to('/berita')->with('success', 'Berita dipindahkan ke sampah.');
}


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

        // Hapus file cover jika ada
        if (!empty($berita['feat_image']) && file_exists(WRITEPATH . '../public/' . $berita['feat_image'])) {
            unlink(WRITEPATH . '../public/' . $berita['feat_image']);
        }

        // Hapus additional images jika ada
        if (!empty($berita['additional_images'])) {
            $addImages = json_decode($berita['additional_images'], true);
            foreach ($addImages as $img) {
                if (file_exists(WRITEPATH . '../public/' . $img)) {
                    unlink(WRITEPATH . '../public/' . $img);
                }
            }
        }

        // Hapus berita permanen
        $this->beritaModel->delete($id, true); // true = force delete

        return redirect()->to('/berita/trash')->with('success', 'Berita berhasil dihapus permanen.');
    }

        // ========================================================
    // Restore dari Trash
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

        // ========================================================
    // Daftar Berita Trash
    // ========================================================
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
    // Fungsi Upload Sementara
    // ========================================================
    private function saveTemporaryImages()
    {
        $session = session();
        $tempDir = WRITEPATH . '../public/uploads/temp/';
        if (!is_dir($tempDir)) mkdir($tempDir, 0755, true);

        // Cover
        if (!$session->has('temp_cover_image')) {
            $cover = $this->request->getFile('feat_image');
            if ($cover && $cover->isValid() && !$cover->hasMoved()) {
                $name = 'temp_cover_' . uniqid() . '.' . $cover->getExtension();
                $cover->move($tempDir, $name);
                $session->set('temp_cover_image', $name);
            }
        }

        // Additional
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

        // Cover
        if ($session->has('temp_cover_image')) {
            $file = $tempDir . $session->get('temp_cover_image');
            if (file_exists($file)) unlink($file);
            $session->remove('temp_cover_image');
        }

        // Additional
        if ($session->has('temp_additional_images')) {
            foreach ($session->get('temp_additional_images') as $img) {
                $file = $tempDir . $img;
                if (file_exists($file)) unlink($file);
            }
            $session->remove('temp_additional_images');
        }
    }

    // ========================================================
    // Hak Akses
    // ========================================================
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

    // ========================================================
    // Log Berita
    // ========================================================
    // ========================================================
    // Save log perubahan berita
    // ========================================================

    private function saveLog($idBerita, $keterangan, $status = null, $notePerbaikan = null, $noteRevisi = null)
    {
        log_message('info', 'User ID: ' . session()->get('id_user'));
        log_message('info', 'Username: ' . session()->get('username'));
        $berita = $this->beritaModel->find($idBerita);
        if (!$berita) {
            log_message('error', "Berita tidak ditemukan: ID $idBerita");
            return;
        }

        // Ambil data kategori
        $kategori = $this->beritaModel->getKategoriByBerita($idBerita);
        $berita['kategori_berita'] = $kategori;

        // Ambil additional images jika ada
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

        // DEBUG: tampilkan data yang akan disimpan
        log_message('info', 'Data Log: ' . print_r($logData, true));

        $result = $this->beritaLogModel->insert($logData);

        if (!$result) {
            $errors = $this->beritaLogModel->errors();
            log_message('error', 'Gagal simpan log: ' . print_r($errors, true));
        } else {
            log_message('info', "Log berhasil disimpan untuk berita ID: $idBerita");
        }
    } /// ========================================================
    // Log Aktivitas Berita
    // ========================================================
    public function log($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_read']) {
            return redirect()->to('/berita')->with('error', 'Kamu tidak punya izin melihat log berita.');
        }

        $db = \Config\Database::connect();

        // Ambil data berita
        $berita = $this->beritaModel->find($id);
        if (!$berita) {
            return redirect()->to('/berita')->with('error', 'Berita tidak ditemukan.');
        }

        // Ambil log berdasarkan id_berita
        $logs = $db->table('t_berita_log')
            ->select('t_berita_log.*, m_users.full_name AS user_name')
            ->join('m_users', 'm_users.id_user = t_berita_log.id_user', 'left')
            ->where('t_berita_log.id_berita', $id)
            ->orderBy('t_berita_log.created_date', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Log Aktivitas Berita',
            'berita' => $berita,
            'logs' => $logs
        ];

        return view('pages/berita/logs', $data);
    }

}
