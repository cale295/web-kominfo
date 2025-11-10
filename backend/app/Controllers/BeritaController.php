<?php

namespace App\Controllers;

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
    protected $module = 'berita';
    protected $beritaLogModel;


    public function __construct()
    {
        $this->beritaModel = new BeritaModel();
        $this->kategoriModel = new KategoriModel();
        $this->accessRightsModel = new AccessRightsModel();
        $this->beritaLogModel = new BeritaLogModel();

    }

    // ========================================================
    // Daftar Berita
    // ========================================================
    public function index()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat berita.');
        }

$berita = $this->beritaModel->where('trash', '0')->findAll();

        // Ambil semua kategori (id => nama)
        $kategoriAll = $this->kategoriModel->where('trash', '0')->findAll();
        $kategoriMap = [];
        foreach ($kategoriAll as $k) {
            $kategoriMap[$k['id_kategori']] = $k['kategori'];
        }

        // Ambil kategori untuk tiap berita dari pivot table t_berita_kategori
        foreach ($berita as &$b) {
            $kats = $this->beritaModel->db->table('t_berita_kategori')
                        ->select('m_kategori_berita.id_kategori, m_kategori_berita.kategori')
                        ->join('m_kategori_berita', 'm_kategori_berita.id_kategori = t_berita_kategori.id_kategori')
                        ->where('t_berita_kategori.id_berita', $b['id_berita'])
                        ->get()
                        ->getResultArray();

            $b['kategori'] = array_column($kats, 'kategori');       // Nama kategori
            $b['kategori_ids'] = array_column($kats, 'id_kategori'); // ID kategori
        }

        $data = [
            'title' => 'Manajemen Berita',
            'berita' => $berita,
            'kategoriMap' => $kategoriMap,
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ];

        return view('pages/berita/index', $data);
    }

    // ========================================================
    // Form Tambah Berita
    // ========================================================
    public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/berita')->with('error', 'Kamu tidak punya izin menambah berita.');
        }

        $data = [
            'title' => 'Tambah Berita',
            'kategori' => $this->kategoriModel->where('trash', '0')->findAll(),
            'beritaAll' => $this->beritaModel->findAll(), // untuk dropdown berita terkait
        ];

        return view('pages/berita/create', $data);
    }

    // ========================================================
    // Simpan Berita Baru
    // ========================================================
    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/berita')->with('error', 'Kamu tidak punya izin menambah berita.');
        }

        $post = $this->request->getPost();

        // --- Upload Cover ---
        $featImagePath = null;
        $featImage = $this->request->getFile('feat_image');
        if ($featImage && $featImage->isValid() && !$featImage->hasMoved()) {
            $newName = $featImage->getRandomName();
            $featImage->move(WRITEPATH . '../public/uploads/berita', $newName);
            $featImagePath = 'uploads/berita/' . $newName;
        }

        // --- Upload Foto Tambahan ---
        $additionalImages = [];
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

        // --- Simpan berita ---
        $data = [
            'judul' => $post['judul'],
            'topik' => $post['topik'] ?? null,
            'content' => $post['content'] ?? null,
            'intro' => $post['intro'] ?? null,
            'id_berita_terkait' => $post['id_berita_terkait'] ?? null,
            'id_berita_terkait2' => $post['id_berita_terkait2'] ?? null,
            'link_video' => $post['link_video'] ?? null,
            'keyword' => $post['keyword'] ?? null,
            'sumber' => $post['sumber'] ?? null,
            'feat_image' => $featImagePath,
            'additional_images' => !empty($additionalImages) ? json_encode($additionalImages) : null,
            'slug' => url_title($post['judul'], '-', true),
            'status' => $post['status'] ?? 0,
            'status_berita' => $post['status_berita'] ?? 2,
            'created_by_id' => session()->get('id_user'),
            'created_by_name' => session()->get('username'),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $idBerita = $this->beritaModel->insert($data);

        // --- Simpan kategori ke pivot table ---
        if (!empty($kategoriIds)) {
            $this->beritaModel->saveKategoriBerita($idBerita, $kategoriIds);
        }

        $this->saveLog($idBerita, 'Menambahkan berita baru');

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

    // Ambil semua kategori untuk checkbox
    $kategori = $this->kategoriModel->where('trash', '0')->findAll();

    // Ambil kategori yang dipilih
    $selectedKategori = $this->beritaModel->getKategoriByBerita($id);
    $selectedKategoriIds = array_column($selectedKategori, 'id_kategori');

    $data = [
        'title' => 'Edit Berita',
        'berita' => $berita,
        'kategori' => $kategori,
        'selectedKategoriIds' => $selectedKategoriIds,
        'beritaAll' => $this->beritaModel->findAll(),
    ];

    return view('pages/berita/edit', $data);
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

    // --- Kategori ---
    $kategoriIds = $post['id_kategori'] ?? [];
    if (is_string($kategoriIds)) {
        $kategoriIds = array_filter(array_map('trim', explode(',', $kategoriIds)));
    }

    // --- Update data ---
    $data = [
        'judul' => $post['judul'],
        'topik' => $post['topik'] ?? null,
        'content' => $post['content'] ?? null,
        'intro' => $post['intro'] ?? null,
        'id_berita_terkait' => $post['id_berita_terkait'] ?? null,
        'id_berita_terkait2' => $post['id_berita_terkait2'] ?? null,
        'link_video' => $post['link_video'] ?? null,
        'keyword' => $post['keyword'] ?? null,
        'sumber' => $post['sumber'] ?? null,
        'feat_image' => $featImagePath,
        'additional_images' => !empty($additionalImages) ? json_encode($additionalImages) : null,
        'slug' => url_title($post['judul'], '-', true),
        'status' => $post['status'] ?? 0,
        'status_berita' => $post['status_berita'] ?? 2,
        'updated_by_id' => session()->get('id_user'),
        'updated_by_name' => session()->get('username'),
        'updated_at' => date('Y-m-d H:i:s'),
    ];

    $this->beritaModel->update($id, $data);

    // --- Update kategori pivot ---
    $this->beritaModel->saveKategoriBerita($id, $kategoriIds);

    $this->saveLog($id, 'Mengubah berita');


    return redirect()->to('/berita')->with('success', 'Berita berhasil diperbarui.');
}

// ========================================================
// Soft Delete / Trash
// ========================================================
// Soft Delete / Trash
public function delete($id)
{
    $access = $this->getAccess(session()->get('role'));
    if (!$access || !$access['can_delete']) {
        return redirect()->to('/berita')->with('error', 'Kamu tidak punya izin menghapus berita.');
    }

    // Update field trash menjadi string '1' (ENUM)
    $updated = $this->beritaModel->update($id, [
        'trash' => '1',
        'is_delete_by_id' => session()->get('id_user'),
        'is_delete_by_name' => session()->get('username'),
        'delete_at' => date('Y-m-d H:i:s')
    ]);

    if(!$updated){
        return redirect()->to('/berita')->with('error', 'Gagal memindahkan berita ke sampah.');
    }
    $this->saveLog($id, 'Memindahkan berita ke sampah');


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

    // Hapus berita permanen
    $this->beritaModel->delete($id, true); // true = force delete
    $this->saveLog($id, 'Menghapus berita secara permanen');


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

    // Update field trash menjadi string '0' (ENUM)
    $this->beritaModel->update($id, [
        'trash' => '0',
        'is_delete_by_id' => null,
        'is_delete_by_name' => null,
        'delete_at' => null
    ]);

    $this->saveLog($id, 'Memulihkan berita dari sampah');


    return redirect()->to('/berita/trash')->with('success', 'Berita berhasil dipulihkan.');
}


// ========================================================
// Daftar Berita Trash
// ========================================================
// ========================================================
// Daftar Berita Trash
// ========================================================
public function trash()
{
    $access = $this->getAccess(session()->get('role'));
    if (!$access || !$access['can_read']) {
        return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat berita.');
    }

    // Ambil berita trash dengan join kategori
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
    // Hak Akses
    // ========================================================
    private function getAccess($role)
    {
        $access = $this->accessRightsModel
            ->where('role', $role)
            ->where('module_name', $this->module)
            ->first();

        if (!$access) return false;

        return [
            'can_create' => (bool) $access['can_create'],
            'can_read' => (bool) $access['can_read'],
            'can_update' => (bool) $access['can_update'],
            'can_delete' => (bool) $access['can_delete'],
        ];
    }

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
}/// ========================================================
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
