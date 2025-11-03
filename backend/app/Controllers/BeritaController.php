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
        $this->kategoriModel = new KategoriModel();
        $this->accessRightsModel = new AccessRightsModel();
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

        $data = [
            'title' => 'Manajemen Berita',
            'berita' => $this->beritaModel->getBeritaWithKategori(true),
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete']
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
            'kategori' => $this->kategoriModel->getKategoriAktif(),
            'beritaAll' => $this->beritaModel->getBeritaWithKategori(false)
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

        $data = [
            'judul'       => $post['judul'],
            'topik'       => $post['topik'] ?? null,
            'id_kategori' => $post['id_kategori'] ?? null,
            'id_sub_kategori' => $post['id_sub_kategori'] ?? null,
            'content'     => $post['content'] ?? null,
            'intro'       => $post['intro'] ?? null,
            'feat_image'  => $post['feat_image'] ?? null,
            'caption'     => $post['caption'] ?? null,
            'sumber'      => $post['sumber'] ?? null,
            'link_video'  => $post['link_video'] ?? null,
            'status'      => $post['status'] ?? '0',
            'status_berita' => $post['status_berita'] ?? '0',
            'id_berita_terkait'  => $post['id_berita_terkait'] ?? null,
            'id_berita_terkait2' => $post['id_berita_terkait2'] ?? null,
            'keyword'     => $post['keyword'] ?? null,
            'dokumen_title' => $post['dokumen_title'] ?? null,
            'dokumen_duo_title' => $post['dokumen_duo_title'] ?? null,
            'dokumen_tigo_title' => $post['dokumen_tigo_title'] ?? null,
            'dokumen_quatro_title' => $post['dokumen_quatro_title'] ?? null,
            'dokumen' => $post['dokumen'] ?? null,
            'dokumen_duo' => $post['dokumen_duo'] ?? null,
            'dokumen_tigo' => $post['dokumen_tigo'] ?? null,
            'dokumen_quatro' => $post['dokumen_quatro'] ?? null,
            'slug'        => url_title($post['judul'], '-', true),
            'hash_berita' => md5(uniqid()),
            'created_by_id'   => session()->get('id_user'),
            'created_by_name' => session()->get('username'),
            'created_at'      => date('Y-m-d H:i:s'),



            
        ];

        if (!$this->beritaModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->beritaModel->errors());
        }

        return redirect()->to('/berita')->with('success', 'Berita berhasil ditambahkan.');
    }

    // ========================================================
    // Form Edit Berita
    // ========================================================
    public function edit($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/berita')->with('error', 'Kamu tidak punya izin mengedit berita.');
        }

        $berita = $this->beritaModel->find($id);
        if (!$berita || $berita['trash'] == '1') {
            return redirect()->to('/berita')->with('error', 'Berita tidak ditemukan.');
        }

        $kategori = $this->kategoriModel->where('trash', '0')->findAll();
        $beritaAll = $this->beritaModel
            ->where('trash', '0')
            ->where('id_berita !=', $id)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('pages/berita/edit', [
            'title' => 'Edit Berita',
            'berita' => $berita,
            'kategori' => $kategori,
            'beritaAll' => $beritaAll
        ]);
    }

    // ========================================================
    // Update Berita
    // ========================================================
    public function update($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/berita')->with('error', 'Kamu tidak punya izin mengedit berita.');
        }

        $berita = $this->beritaModel->find($id);
        if (!$berita) {
            return redirect()->to('/berita')->with('error', 'Berita tidak ditemukan.');
        }

        $post = $this->request->getPost();

        $data = [
            'judul'       => $post['judul'],
            'topik'       => $post['topik'] ?? null,
            'id_kategori' => $post['id_kategori'] ?? null,
            'id_sub_kategori' => $post['id_sub_kategori'] ?? null,
            'content'     => $post['content'] ?? null,
            'intro'       => $post['intro'] ?? null,
            'feat_image'  => $post['feat_image'] ?? null,
            'caption'     => $post['caption'] ?? null,
            'sumber'      => $post['sumber'] ?? null,
            'link_video'  => $post['link_video'] ?? null,
            'status'      => $post['status'] ?? '0',
            'status_berita' => $post['status_berita'] ?? '0',
            'id_berita_terkait'  => $post['id_berita_terkait'] ?? null,
            'id_berita_terkait2' => $post['id_berita_terkait2'] ?? null,
            'keyword'     => $post['keyword'] ?? null,
            'dokumen_title' => $post['dokumen_title'] ?? null,
            'dokumen_duo_title' => $post['dokumen_duo_title'] ?? null,
            'dokumen_tigo_title' => $post['dokumen_tigo_title'] ?? null,
            'dokumen_quatro_title' => $post['dokumen_quatro_title'] ?? null,
            'dokumen' => $post['dokumen'] ?? null,
            'dokumen_duo' => $post['dokumen_duo'] ?? null,
            'dokumen_tigo' => $post['dokumen_tigo'] ?? null,
            'dokumen_quatro' => $post['dokumen_quatro'] ?? null,
            'slug'        => url_title($post['judul'], '-', true),
            'updated_by_id'   => session()->get('id_user'),
            'updated_by_name' => session()->get('username'),
            'updated_at'      => date('Y-m-d H:i:s')


        ];

        $this->beritaModel->skipValidation(true)->update($id, $data);

        return redirect()->to('/berita')->with('success', 'Berita berhasil diperbarui.');
    }

    // ========================================================
    // Detail Berita
    // ========================================================
    public function show($slug)
    {
        $berita = $this->beritaModel->getBySlug($slug);
        if (!$berita) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Berita tidak ditemukanass');
        }

        $related = [];
        if (!empty($berita['id_berita_terkait'])) {
            $related[] = $this->beritaModel->find($berita['id_berita_terkait']);
        }
        if (!empty($berita['id_berita_terkait2'])) {
            $related[] = $this->beritaModel->find($berita['id_berita_terkait2']);
        }

        return view('pages/berita/show', [
            'berita' => $berita,
            'related' => $related
        ]);
    }

    // ========================================================
    // Soft Delete Berita
    // ========================================================
// ========================================================
// Soft Delete Berita
// ========================================================
public function delete($id = null)
{
    $access = $this->getAccess(session()->get('role'));
    if (!$access || !$access['can_delete']) {
        return redirect()->to('/berita')->with('error', 'Kamu tidak punya izin menghapus berita.');
    }

    $berita = $this->beritaModel->find($id);
    if (!$berita) {
        return redirect()->to('/berita')->with('error', 'Berita tidak ditemukan.');
    }

    $this->beritaModel->update($id, ['trash' => '1']);
    return redirect()->to('/berita')->with('success', 'Berita dipindahkan ke sampah.');
}

// ========================================================
// Restore Berita
// ========================================================
public function restore($id = null)
{
    $access = $this->getAccess(session()->get('role'));
    if (!$access || !$access['can_update']) {
        return redirect()->to('/berita/trash')->with('error', 'Kamu tidak punya izin memulihkan berita.');
    }

    $berita = $this->beritaModel->find($id);
    if (!$berita) {
        return redirect()->to('/berita/trash')->with('error', 'Berita tidak ditemukan.');
    }

    $this->beritaModel->update($id, ['trash' => '0']);
    return redirect()->to('/berita/trash')->with('success', 'Berita berhasil dipulihkan.');
}

// ========================================================
// Hapus Permanen Berita
// ========================================================
public function destroyPermanent($id = null)
{
    $access = $this->getAccess(session()->get('role'));
    if (!$access || !$access['can_delete']) {
        return redirect()->to('/berita/trash')->with('error', 'Kamu tidak punya izin menghapus berita permanen.');
    }

    $berita = $this->beritaModel->find($id);
    if (!$berita) {
        return redirect()->to('/berita/trash')->with('error', 'Berita tidak ditemukan.');
    }

    $this->beritaModel->delete($id, true); // force delete
    return redirect()->to('/berita/trash')->with('success', 'Berita dihapus permanen.');
}

public function trash()
{
    $access = $this->getAccess(session()->get('role'));
    if (!$access || !$access['can_read']) {
        return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat sampah berita.');
    }

    $data = [
        'title' => 'Sampah Berita',
        'berita' => $this->beritaModel->getTrashBerita()
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
            'can_read'   => (bool) $access['can_read'],
            'can_update' => (bool) $access['can_update'],
            'can_delete' => (bool) $access['can_delete'],
        ];
    }
}
