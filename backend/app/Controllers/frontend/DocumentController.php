<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\DocumentModel;
use App\Models\DocumentCategoryModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class DocumentController extends BaseController
{
    protected $documentModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->documentModel = new DocumentModel();
        $this->categoryModel = new DocumentCategoryModel();
    }

    private function getKategoriBySlug($slug)
    {
        $kategori = $this->categoryModel
            ->where('slug_kategori', $slug)
            ->first();

        if (!$kategori) {
            throw PageNotFoundException::forPageNotFound('Kategori tidak ditemukan');
        }

        return $kategori;
    }

    /* ======================
     * INDEX (LIST FOLDER)
     * ====================== */
    public function index($slug)
    {
        $kategori = $this->getKategoriBySlug($slug);

        // ambil folder unik
        $folders = $this->documentModel
            ->select('nama_folder')
            ->where('id_kategori', $kategori['id_kategori'])
            ->where('nama_folder IS NOT NULL')
            ->groupBy('nama_folder')
            ->findAll();

        foreach ($folders as &$folder) {
            $folder['dokumen'] = $this->documentModel
                ->where('id_kategori', $kategori['id_kategori'])
                ->where('nama_folder', $folder['nama_folder'])
                ->where('file_path IS NOT NULL')
                ->orderBy('tahun', 'DESC')
                ->findAll();
        }

        return view('pages/dokumen/index', [
            'title'   => 'Dokumen - ' . $kategori['nama_kategori'],
            'slug'    => $slug,
            'folders' => $folders
        ]);
    }

    /* ======================
     * TAMBAH FOLDER
     * ====================== */
    public function create($slug)
    {
        return view('pages/dokumen/folder_create', [
            'title' => 'Tambah Folder',
            'slug'  => $slug
        ]);
    }

    public function store($slug)
    {
        $kategori = $this->getKategoriBySlug($slug);

        $this->validate([
            'nama_folder' => 'required'
        ]);

        $this->documentModel->insert([
            'id_kategori' => $kategori['id_kategori'],
            'nama_folder' => $this->request->getPost('nama_folder')
        ]);

        return redirect()->to("informasi-publik/$slug")
            ->with('pesan', 'Folder berhasil ditambahkan');
    }

    /* ======================
     * TAMBAH DOKUMEN
     * ====================== */
    public function createDokumen($slug, $nama_folder)
    {
        return view('pages/dokumen/create', [
            'title'       => 'Tambah Dokumen',
            'slug'        => $slug,
            'nama_folder' => urldecode($nama_folder),
            'validation'  => \Config\Services::validation()
        ]);
    }

    public function storeDokumen($slug, $nama_folder)
    {
        $kategori = $this->getKategoriBySlug($slug);

        if (!$this->validate([
            'nama_dokumen' => 'required',
            'tahun'        => 'required|numeric',
            'file_upload'  => 'uploaded[file_upload]|max_size[file_upload,5120]|ext_in[file_upload,pdf,doc,docx,xls,xlsx]'
        ])) {
            return redirect()->back()->withInput();
        }

        $file = $this->request->getFile('file_upload');
        $namaFile = $file->getRandomName();
        $file->move('uploads/dokumen', $namaFile);

        $this->documentModel->insert([
            'id_kategori'  => $kategori['id_kategori'],
            'nama_folder'  => urldecode($nama_folder),
            'nama_dokumen' => $this->request->getPost('nama_dokumen'),
            'tahun'        => $this->request->getPost('tahun'),
            'file_path'    => $namaFile
        ]);

        return redirect()->to("informasi-publik/$slug")
            ->with('pesan', 'Dokumen berhasil ditambahkan');
    }

    /* ======================
 * EDIT DOKUMEN
 * ====================== */
    public function edit($slug, $id_document)
    {
        $kategori = $this->getKategoriBySlug($slug);

        $dokumen = $this->documentModel
            ->where('id_document', $id_document)
            ->where('id_kategori', $kategori['id_kategori'])
            ->first();

        if (!$dokumen) {
            throw PageNotFoundException::forPageNotFound('Dokumen tidak ditemukan');
        }

        return view('pages/dokumen/edit', [
            'title'      => 'Edit Dokumen',
            'slug'       => $slug,
            'dokumen'    => $dokumen,
            'validation' => \Config\Services::validation()
        ]);
    }

    public function update($slug, $id_document)
    {
        $kategori = $this->getKategoriBySlug($slug);

        $dokumenLama = $this->documentModel
            ->where('id_document', $id_document)
            ->where('id_kategori', $kategori['id_kategori'])
            ->first();

        if (!$dokumenLama) {
            throw PageNotFoundException::forPageNotFound('Dokumen tidak ditemukan');
        }

        if (!$this->validate([
            'nama_dokumen' => 'required',
            'tahun'        => 'required|numeric',
            'file_upload'  => 'max_size[file_upload,5120]|ext_in[file_upload,pdf,doc,docx,xls,xlsx]'
        ])) {
            return redirect()->back()->withInput();
        }

        $file = $this->request->getFile('file_upload');

        // default pakai file lama
        $namaFile = $dokumenLama['file_path'];

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFile = $file->getRandomName();
            $file->move('uploads/dokumen', $namaFile);

            // hapus file lama
            if (
                $dokumenLama['file_path'] &&
                file_exists('uploads/dokumen/' . $dokumenLama['file_path'])
            ) {
                unlink('uploads/dokumen/' . $dokumenLama['file_path']);
            }
        }

        $this->documentModel->update($id_document, [
            'nama_dokumen' => $this->request->getPost('nama_dokumen'),
            'tahun'        => $this->request->getPost('tahun'),
            'file_path'    => $namaFile
        ]);

        return redirect()->to("informasi-publik/$slug")
            ->with('pesan', 'Dokumen berhasil diperbarui');
    }

    /* ======================
 * HAPUS DOKUMEN
 * ====================== */
    public function delete($slug, $id_document)
    {
        $kategori = $this->getKategoriBySlug($slug);

        $dokumen = $this->documentModel
            ->where('id_document', $id_document)
            ->where('id_kategori', $kategori['id_kategori'])
            ->first();

        if (!$dokumen) {
            return redirect()->to("informasi-publik/$slug")
                ->with('error', 'Dokumen tidak ditemukan');
        }

        if (
            $dokumen['file_path'] &&
            file_exists('uploads/dokumen/' . $dokumen['file_path'])
        ) {
            unlink('uploads/dokumen/' . $dokumen['file_path']);
        }

        $this->documentModel->delete($id_document);

        return redirect()->to("informasi-publik/$slug")
            ->with('pesan', 'Dokumen berhasil dihapus');
    }
}
