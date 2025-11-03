<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BeritaModel;
use App\Models\KategoriModel;
use App\Models\AccessRightsModel;

class BeritaController extends BaseController
{
    protected $beritaModel;
    protected $kategoriModel;
    protected $accessRightsModel;
    protected $module = 'berita';

    public function __construct()
    {
        $this->beritaModel = new BeritaModel();
        $this->kategoriModel = new KategoriModel(); // Panggil kategori dari sini
        $this->accessRightsModel = new AccessRightsModel();
    }

    // ========================================================
    // Daftar berita
    // ========================================================
        public function index()
        {
            $access = $this->getAccess(session()->get('role'));
            if (!$access || !$access['can_read']) {
                return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat berita.');
            }

            // Ambil semua berita yang trash = 0
            $data = [
                'title' => 'Manajemen Berita',
                'berita' => $this->beritaModel->getBeritaWithKategori(false), // tampilkan semua kategori
                'can_create' => $access['can_create'],
                'can_update' => $access['can_update'],
                'can_delete' => $access['can_delete']
            ];

            return view('pages/berita/index', $data);
        }



    // ========================================================
    // Form edit berita
    // ========================================================
public function edit($id = null)
{
    $access = $this->getAccess(session()->get('role'));
    if (!$access || !$access['can_update']) {
        return redirect()->to('/berita')->with('error', 'Kamu tidak punya izin mengedit berita.');
    }

    $berita = $this->beritaModel->find($id);
    if (!$berita || $berita['trash'] == '1') {
        return redirect()->to('/berita')->with('error', 'Berita tidak ditemukan.');
    }

    // Ambil semua berita untuk dropdown terkait, kecuali berita yang sedang diedit
    $beritaAll = $this->beritaModel
        ->where('trash', '0')
        ->where('id_berita !=', $id)
        ->orderBy('created_at', 'DESC')
        ->findAll();

    $kategori = $this->kategoriModel->where('trash', '0')->findAll();

    return view('pages/berita/edit', [
        'title' => 'Edit Berita',
        'berita' => $berita,
        'beritaAll' => $beritaAll, // kirim ke view
        'kategori' => $kategori,
    ]);
}

    // ========================================================
    // Update berita
    // ========================================================
    public function update($id = null)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/berita')->with('error', 'Kamu tidak punya izin mengedit berita.');
        }

        $berita = $this->beritaModel->find($id);
        if (!$berita) {
            return redirect()->to('/berita')->with('error', 'Berita tidak ditemukan.');
        }

        $data = [
            'judul'       => $this->request->getPost('judul'),
            'topik'       => $this->request->getPost('topik'),
            'id_kategori' => $this->request->getPost('id_kategori'),
            'content'     => $this->request->getPost('content'),
            'status'      => $this->request->getPost('status') ?? '0',
            'slug'        => url_title($this->request->getPost('judul'), '-', true),
            'id_berita_terkait' => $this->request->getPost('id_berita_terkait') ?: null,
            'id_berita_terkait2'=> $this->request->getPost('id_berita_terkait2') ?: null,

            
        ];

        $this->beritaModel->skipValidation(true)->update($id, $data);

        return redirect()->to('/berita')->with('success', 'Berita berhasil diperbarui.');
    }

    // ========================================================
    // Form tambah berita
    // ========================================================
    public function new()
{
    $access = $this->getAccess(session()->get('role'));
    if (!$access || !$access['can_create']) {
        return redirect()->to('/berita')->with('error', 'Kamu tidak punya izin menambah berita.');
    }

    $data = [
        'title' => 'Tambah Berita',
        'kategori' => $this->kategoriModel->getKategoriAktif(),
        'beritaAll' => $this->beritaModel->getBeritaWithKategori(false) // semua berita untuk pilihan terkait
    ];

    return view('pages/berita/create', $data);
}


    // ========================================================
    // Tambah berita baru
    // ========================================================
    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/berita')->with('error', 'Kamu tidak punya izin menambah berita.');
        }

        $data = [
            'judul'       => $this->request->getPost('judul'),
            'topik'       => $this->request->getPost('topik'),
            'id_kategori' => $this->request->getPost('id_kategori'),
            'content'     => $this->request->getPost('content'),
            'status'      => $this->request->getPost('status') ?? '0',
            'slug'        => url_title($this->request->getPost('judul'), '-', true),
            'id_berita_terkait' => $this->request->getPost('id_berita_terkait') ?: null,
            'id_berita_terkait2'=> $this->request->getPost('id_berita_terkait2') ?: null,
            'hash_berita' => md5(uniqid())
        ];

        if (!$this->beritaModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->beritaModel->errors());
        }

        return redirect()->to('/berita')->with('success', 'Berita berhasil ditambahkan.');
    }

    // ========================================================
    // Detail berita + hit count
    // ========================================================
public function show($slug = null)
{
    $berita = $this->beritaModel->getBySlug($slug); // ambil berita berdasarkan slug
    if (!$berita) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Berita tidak ditemukan');
    }

    // Ambil berita terkait 1 dan 2
    $related = [];
    if ($berita['id_berita_terkait']) {
        $related[] = $this->beritaModel->find($berita['id_berita_terkait']);
    }
    if ($berita['id_berita_terkait2']) {
        $related[] = $this->beritaModel->find($berita['id_berita_terkait2']);
    }

    return view('pages/berita/show', [
        'berita' => $berita,
        'related' => $related
    ]);
}



    // ========================================================
    // Soft delete berita
    // ========================================================
    public function delete($id = null)
    {
        $this->beritaModel->update($id, ['trash' => '1']);
        return redirect()->to('/berita')->with('success', 'Berita dipindahkan ke sampah.');
    }

    // ========================================================
    // Hak akses
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
            'can_read'   => (bool) $access['can_read'],
            'can_update' => (bool) $access['can_update'],
            'can_delete' => (bool) $access['can_delete'],
        ];
    }
}
