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
    private function saveLog($idBerita, $keterangan, $status = null)
    {
        $berita = $this->beritaModel->find($idBerita);
        if (!$berita) return;

        $logData = [
            'id_hash' => $berita['hash_berita'] ?? '',
            'id_berita' => $idBerita,
            'log' => json_encode($berita, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES),
            'keterangan' => $keterangan,
            'id_user' => session()->get('id_user'),
            'created_date' => date('Y-m-d H:i:s'),
            'status' => $status ?? $berita['status'] ?? 0,
            'fullname' => session()->get('username'),
        ];

        $this->beritaLogModel->insert($logData);
    }
}
