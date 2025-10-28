<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BeritaTagModel;

class BeritaTagController extends BaseController
{
    protected $beritaTagModel;

    public function __construct()
    {
        $this->beritaTagModel = new BeritaTagModel();
    }

    // ========================
    // TAMPILKAN SEMUA TAG
    // ========================
    public function index()
    {
        $data = [
            'tags' => $this->beritaTagModel->where('trash', '0')->findAll()
        ];
        return view('pages/berita_tag/index', $data);
    }

    // ========================
    // FORM TAMBAH TAG
    // ========================
    public function new()
    {
        return view('pages/berita_tag/create');
    }

    // ========================
    // SIMPAN TAG BARU
    // ========================
    public function create()
    {
        $this->beritaTagModel->save([
            'name' => $this->request->getPost('name'),
            'slug' => url_title($this->request->getPost('name'), '-', true),
            'created_at' => date('Y-m-d H:i:s'),
            'created_by_id' => session()->get('user_id'),
            'created_by_name' => session()->get('username'),
            'is_delete' => '0',
            'trash' => '0'
        ]);

        return redirect()->to('berita_tag')->with('success', 'Tag berhasil ditambahkan.');
    }

    // ========================
    // FORM EDIT TAG
    // ========================
    public function edit($id)
    {
        $tag = $this->beritaTagModel->find($id);
        if (!$tag) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Tag tidak ditemukan');
        }
        return view('pages/berita_tag/edit', ['tag' => $tag]);
    }

    // ========================
    // UPDATE TAG
    // ========================
    public function update($id)
    {
        $this->beritaTagModel->update($id, [
            'name' => $this->request->getPost('name'),
            'slug' => url_title($this->request->getPost('name'), '-', true),
        ]);

        return redirect()->to('berita_tag')->with('success', 'Tag berhasil diupdate.');
    }

    // ========================
    // MASUKKAN TAG KE TRASH
    // ========================
    public function trash()
{
    $data['tags'] = $this->beritaTagModel
        ->where('trash', '1')
        ->findAll();

    return view('pages/berita_tag/trash', $data);
}


    public function delete($id = null)
    {
        $this->beritaTagModel->update($id, ['trash' => '1']);
        return redirect()->to('/berita_tag')->with('success', 'Kategori dipindahkan ke sampah.');
    }


    // ========================
    // KEMBALIKAN DARI TRASH
    // ========================
    public function restore($id)
    {
        $this->beritaTagModel->update($id, ['trash' => '0']);
        return redirect()->to('berita_tag/trash')->with('success', 'Tag berhasil dikembalikan.');
    }

    // ========================
    // HAPUS PERMANEN
    // ========================
    public function destroyPermanent($id)
    {
        $this->beritaTagModel->delete($id);
        return redirect()->to('berita_tag/trash')->with('success', 'Tag berhasil dihapus permanen.');
    }
}
