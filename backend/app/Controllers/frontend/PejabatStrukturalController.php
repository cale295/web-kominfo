<?php

namespace App\Controllers\frontend;

use App\Models\frontend\PejabatStrukturalModel;
use App\Models\AccessRightsModel;
use App\Controllers\BaseController;

class PejabatStrukturalController extends BaseController
{
    protected $pejabatModel;
    protected $accessRightsModel;
    protected $module = 'pejabat_struktural'; // Sesuaikan dengan nama modul di database hak akses
    protected $uploadPath = FCPATH . 'uploads/pejabat_struktural/';

    public function __construct()
    {
        $this->pejabatModel = new PejabatStrukturalModel();
        $this->accessRightsModel = new AccessRightsModel();
    }

    private function getAccess($role)
    {
        $access = $this->accessRightsModel->where('role', $role)->where('module_name', $this->module)->first();
        if (!$access)
            return ['can_create' => false, 'can_read' => false, 'can_update' => false, 'can_delete' => false];
        return [
            'can_create' => (bool) $access['can_create'],
            'can_read'   => (bool) $access['can_read'],
            'can_update' => (bool) $access['can_update'],
            'can_delete' => (bool) $access['can_delete'],
        ];
    }

    public function index()
    {
        $access = $this->getAccess(session()->get('role'));
        
        if (!$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat data ini.');
        }

        $data = [
            'pejabat_struktural' => $this->pejabatModel->orderBy('created_at', 'DESC')->findAll(),
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ];

        return view('pages/pejabat_struktural/index', $data);
    }

    public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_create']) {
            return redirect()->to('/pejabat_struktural')->with('error', 'Akses ditolak.');
        }
        return view('pages/pejabat_struktural/create');
    }

    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_create']) {
            return redirect()->to('/pejabat_struktural')->with('error', 'Akses ditolak.');
        }

        // Validasi Upload Gambar Wajib di Create
        if (!$this->validate([
            'image' => [
                'label' => 'Gambar Struktur',
                'rules' => 'uploaded[image]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]|max_size[image,5120]'
            ]
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title'       => $this->request->getPost('title'),
            'subtitle'    => $this->request->getPost('subtitle'),
            'description' => $this->request->getPost('description'),
            'is_active'   => $this->request->getPost('is_active'),
        ];

        // Handle File Upload
        $img = $this->request->getFile('image');
        if ($img->isValid() && !$img->hasMoved()) {
            $newName = $img->getRandomName();
            // Pastikan folder ada
            if (!is_dir($this->uploadPath)) {
                mkdir($this->uploadPath, 0777, true);
            }
            $img->move($this->uploadPath, $newName);
            $data['image_url'] = $newName;
        }

        if (!$this->pejabatModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->pejabatModel->errors());
        }

        return redirect()->to('/pejabat_struktural')->with('success', 'Data pejabat struktural berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_update']) {
            return redirect()->to('/pejabat_struktural')->with('error', 'Akses ditolak.');
        }

        $pejabat = $this->pejabatModel->find($id);
        if (!$pejabat) {
            return redirect()->to('/pejabat_struktural')->with('error', 'Data tidak ditemukan.');
        }

        return view('pages/pejabat_struktural/edit', ['pejabat' => $pejabat]);
    }

    public function update($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_update']) {
            return redirect()->to('/pejabat_struktural')->with('error', 'Akses ditolak.');
        }

        $pejabat = $this->pejabatModel->find($id);
        if (!$pejabat) {
            return redirect()->to('/pejabat_struktural')->with('error', 'Data tidak ditemukan.');
        }

        $data = [
            'id_pejabat_s' => $id,
            'title'        => $this->request->getPost('title'),
            'subtitle'     => $this->request->getPost('subtitle'),
            'description'  => $this->request->getPost('description'),
            'is_active'    => $this->request->getPost('is_active'),
        ];

        // Handle Image Upload (Optional on Update)
        $img = $this->request->getFile('image');
        if ($img && $img->isValid() && !$img->hasMoved()) {
            
            // Validasi file baru
            if (!$this->validate(['image' => 'is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]|max_size[image,5120]'])) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            // Hapus gambar lama
            if (!empty($pejabat['image_url']) && file_exists($this->uploadPath . $pejabat['image_url'])) {
                unlink($this->uploadPath . $pejabat['image_url']);
            }

            $newName = $img->getRandomName();
            $img->move($this->uploadPath, $newName);
            $data['image_url'] = $newName;
        }

        if (!$this->pejabatModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->pejabatModel->errors());
        }

        return redirect()->to('/pejabat_struktural')->with('success', 'Data berhasil diperbarui.');
    }

    public function delete($id)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access['can_delete']) {
            return redirect()->to('/pejabat_struktural')->with('error', 'Akses ditolak.');
        }

        $pejabat = $this->pejabatModel->find($id);
        if (!$pejabat) {
            return redirect()->to('/pejabat_struktural')->with('error', 'Data tidak ditemukan.');
        }

        // Hapus file fisik
        if (!empty($pejabat['image_url']) && file_exists($this->uploadPath . $pejabat['image_url'])) {
            unlink($this->uploadPath . $pejabat['image_url']);
        }

        $this->pejabatModel->delete($id);

        return redirect()->to('/pejabat_struktural')->with('success', 'Data berhasil dihapus.');
    }
}