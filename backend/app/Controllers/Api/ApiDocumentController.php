<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\DocumentModel;
use App\Models\DocumentCategoryModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\IncomingRequest;

/**
 * @property IncomingRequest $request
 */

class ApiDocumentController extends BaseController
{
    use ResponseTrait; // Trait penting untuk return JSON standard (respond, fail, dll)

    protected $documentModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->documentModel = new DocumentModel();
        $this->categoryModel = new DocumentCategoryModel();
    }

    // Helper function (sedikit dimodifikasi untuk return null daripada throw exception langsung)
    private function getKategoriBySlug($slug)
    {
        return $this->categoryModel
            ->where('slug_kategori', $slug)
            ->first();
    }
    /* ======================
     * GET LIST ALL CATEGORIES
     * Method: GET
     * URL: /api/dokumen-publik
     * ====================== */
    public function listCategories()
    {
        $categories = $this->categoryModel->findAll();
        
        if (!$categories) {
            return $this->failNotFound('Belum ada kategori dokumen.');
        }

        return $this->respond([
            'status' => 200,
            'message' => 'Daftar Kategori Dokumen',
            'data' => $categories
        ]);
    }

    /* ======================
     * GET ALL (LIST FOLDER & DOKUMEN)
     * Method: GET
     * URL: /api/dokumen/{slug}
     * ====================== */
    public function index($slug)
    {
        $kategori = $this->getKategoriBySlug($slug);

        if (!$kategori) {
            return $this->failNotFound('Kategori tidak ditemukan');
        }

        // Ambil folder unik
        $folders = $this->documentModel
            ->select('nama_folder')
            ->where('id_kategori', $kategori['id_kategori'])
            ->where('nama_folder IS NOT NULL')
            ->groupBy('nama_folder')
            ->findAll();

        // Loop untuk mengisi dokumen di setiap folder
        foreach ($folders as &$folder) {
            $folder['dokumen'] = $this->documentModel
                ->where('id_kategori', $kategori['id_kategori'])
                ->where('nama_folder', $folder['nama_folder'])
                ->where('file_path IS NOT NULL')
                ->orderBy('tahun', 'DESC')
                ->findAll();
        }

        $data = [
            'kategori' => $kategori,
            'folders'  => $folders
        ];

        return $this->respond($data);
    }

    /* ======================
     * TAMBAH FOLDER
     * Method: POST
     * URL: /api/dokumen/{slug}/folder
     * Body: nama_folder
     * ====================== */
    public function storeFolder($slug)
    {
        $kategori = $this->getKategoriBySlug($slug);

        if (!$kategori) {
            return $this->failNotFound('Kategori tidak ditemukan');
        }

        // Validasi input
        if (!$this->validate(['nama_folder' => 'required'])) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = [
            'id_kategori' => $kategori['id_kategori'],
            'nama_folder' => $this->request->getPost('nama_folder')
        ];

        $this->documentModel->insert($data);

        return $this->respondCreated([
            'status'  => 201,
            'message' => 'Folder berhasil ditambahkan',
            'data'    => $data
        ]);
    }

    /* ======================
     * TAMBAH DOKUMEN
     * Method: POST
     * URL: /api/dokumen/{slug}/{nama_folder}
     * Body: nama_dokumen, tahun, file_upload (multipart/form-data)
     * ====================== */
    public function storeDokumen($slug, $nama_folder)
    {
        $kategori = $this->getKategoriBySlug($slug);

        if (!$kategori) {
            return $this->failNotFound('Kategori tidak ditemukan');
        }

        $rules = [
            'nama_dokumen' => 'required',
            'tahun'        => 'required|numeric',
            'file_upload'  => 'uploaded[file_upload]|max_size[file_upload,5120]|ext_in[file_upload,pdf,doc,docx,xls,xlsx]'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $file = $this->request->getFile('file_upload');
        $namaFile = $file->getRandomName();
        
        if (!$file->move('uploads/dokumen', $namaFile)) {
             return $this->failServerError('Gagal mengupload file');
        }

        $data = [
            'id_kategori'  => $kategori['id_kategori'],
            'nama_folder'  => urldecode($nama_folder),
            'nama_dokumen' => $this->request->getPost('nama_dokumen'),
            'tahun'        => $this->request->getPost('tahun'),
            'file_path'    => $namaFile
        ];

        $this->documentModel->insert($data);

        return $this->respondCreated([
            'status'  => 201,
            'message' => 'Dokumen berhasil ditambahkan',
            'data'    => $data
        ]);
    }

    /* ======================
     * UPDATE DOKUMEN
     * Method: POST (karena file upload kadang bermasalah dengan PUT)
     * URL: /api/dokumen/{slug}/{id_document}/update
     * Body: nama_dokumen, tahun, file_upload (optional)
     * ====================== */
    public function update($slug, $id_document)
    {
        $kategori = $this->getKategoriBySlug($slug);

        if (!$kategori) {
            return $this->failNotFound('Kategori tidak ditemukan');
        }

        $dokumenLama = $this->documentModel
            ->where('id_document', $id_document)
            ->where('id_kategori', $kategori['id_kategori'])
            ->first();

        if (!$dokumenLama) {
            return $this->failNotFound('Dokumen tidak ditemukan');
        }

        $rules = [
            'nama_dokumen' => 'required',
            'tahun'        => 'required|numeric',
            'file_upload'  => 'max_size[file_upload,5120]|ext_in[file_upload,pdf,doc,docx,xls,xlsx]'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $file = $this->request->getFile('file_upload');
        $namaFile = $dokumenLama['file_path'];

        // Cek jika ada file baru diupload
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFile = $file->getRandomName();
            $file->move('uploads/dokumen', $namaFile);

            // Hapus file lama
            if ($dokumenLama['file_path'] && file_exists('uploads/dokumen/' . $dokumenLama['file_path'])) {
                unlink('uploads/dokumen/' . $dokumenLama['file_path']);
            }
        }

        $data = [
            'nama_dokumen' => $this->request->getPost('nama_dokumen'),
            'tahun'        => $this->request->getPost('tahun'),
            'file_path'    => $namaFile
        ];

        $this->documentModel->update($id_document, $data);

        return $this->respond([
            'status'  => 200,
            'message' => 'Dokumen berhasil diperbarui',
            'data'    => $data
        ]);
    }

    /* ======================
     * DELETE DOKUMEN
     * Method: DELETE
     * URL: /api/dokumen/{slug}/{id_document}
     * ====================== */
    public function delete($slug, $id_document)
    {
        $kategori = $this->getKategoriBySlug($slug);

        if (!$kategori) {
            return $this->failNotFound('Kategori tidak ditemukan');
        }

        $dokumen = $this->documentModel
            ->where('id_document', $id_document)
            ->where('id_kategori', $kategori['id_kategori'])
            ->first();

        if (!$dokumen) {
            return $this->failNotFound('Dokumen tidak ditemukan');
        }

        // Hapus file fisik
        if ($dokumen['file_path'] && file_exists('uploads/dokumen/' . $dokumen['file_path'])) {
            unlink('uploads/dokumen/' . $dokumen['file_path']);
        }

        $this->documentModel->delete($id_document);

        return $this->respondDeleted([
            'status'  => 200,
            'message' => 'Dokumen berhasil dihapus'
        ]);
    }
}