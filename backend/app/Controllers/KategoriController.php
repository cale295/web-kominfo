<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KategoriModel;

class KategoriController extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
    }

    /**
     * Menampilkan semua kategori
     */
    public function index()
    {
        $data['kategori'] = $this->kategoriModel
            ->where('trash', '0')
            ->findAll();

        return view('pages/kategori/index', $data);
    }

    /**
     * Form tambah kategori
     */
    public function new()
    {
        return view('pages/kategori/create');
    }

    /**
     * Simpan kategori baru
     */
    public function create()
    {
        $this->kategoriModel->save([
            'id_parent'    => $this->request->getPost('id_parent'),
            'hash'         => md5(uniqid()),
            'kategori'     => $this->request->getPost('kategori'),
            'slug'         => url_title($this->request->getPost('kategori'), '-', true),
            'keterangan'   => $this->request->getPost('keterangan'),
            'status'       => $this->request->getPost('status') ?? 1,
            'is_show_nav'  => $this->request->getPost('is_show_nav') ?? '0',
            'sorting_nav'  => $this->request->getPost('sorting_nav'),
        ]);

        return redirect()->to('/kategori')->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail
     */
    public function show($id = null)
    {
        $data['kategori'] = $this->kategoriModel->find($id);
        return view('pages/kategori/show', $data);
    }

    /**
     * Form edit
     */
    public function edit($id = null)
    {
        $data['kategori'] = $this->kategoriModel->find($id);
        return view('pages/kategori/edit', $data);
    }

    /**
     * Update data
     */
    public function update($id = null)
    {
        $this->kategoriModel->update($id, [
            'id_parent'    => $this->request->getPost('id_parent'),
            'kategori'     => $this->request->getPost('kategori'),
            'slug'         => url_title($this->request->getPost('kategori'), '-', true),
            'keterangan'   => $this->request->getPost('keterangan'),
            'status'       => $this->request->getPost('status') ?? 1,
            'is_show_nav'  => $this->request->getPost('is_show_nav') ?? '0',
            'sorting_nav'  => $this->request->getPost('sorting_nav'),
        ]);

        return redirect()->to('/kategori')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Soft delete → ubah trash jadi '1'
     */
    public function delete($id = null)
    {
        $this->kategoriModel->update($id, ['trash' => '1']);
        return redirect()->to('/kategori')->with('success', 'Kategori dipindahkan ke sampah.');
    }

    /**
     * Restore kategori dari trash
     */
    public function restore($id = null)
    {
        $this->kategoriModel->update($id, ['trash' => '0']);
        return redirect()->to('/kategori')->with('success', 'Kategori berhasil dikembalikan.');
    }

    /**
     * Hapus permanen
     */
    public function destroyPermanent($id = null)
    {
        $this->kategoriModel->delete($id, true);
        return redirect()->to('/kategori')->with('success', 'Kategori dihapus permanen.');
    }

    public function trash()
{
    $data['kategori'] = $this->kategoriModel
        ->where('trash', '1')
        ->findAll();

    return view('pages/kategori/trash', $data);
}

}
