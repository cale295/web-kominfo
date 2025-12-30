<?php

namespace App\Controllers\frontend;

use App\Controllers\BaseController;
use App\Models\AccessRightsModel;
use App\Models\frontend\KontakModel;        // Model Instansi
use App\Models\frontend\KontakSocialModel;  // Model Social Media
use App\Models\frontend\KontakLayananModel; // Model Layanan

class KontakController extends BaseController
{
    protected $kontakModel;
    protected $kontakSocialModel;
    protected $kontakLayananModel;
    protected $accessRightsModel;
    
    // Nama Modul untuk Cek Permission Database
    protected $moduleInstansi = 'Kontak';         
    protected $moduleSocial   = 'Kontak_Social';
    protected $moduleLayanan  = 'Kontak_Layanan';

    public function __construct()
    {
        $this->kontakModel = new KontakModel();
        $this->kontakSocialModel = new KontakSocialModel();
        $this->kontakLayananModel = new KontakLayananModel(); 
        $this->accessRightsModel = new AccessRightsModel();
    }

    // Helper Cek Akses
    private function getAccess($role, $moduleName)
    {
        $access = $this->accessRightsModel
                        ->where('role', $role)
                        ->where('module_name', $moduleName)
                        ->first();

        if (!$access) {
            return ['can_create' => false, 'can_read' => false, 'can_update' => false, 'can_delete' => false];
        }

        return [
            'can_create' => (bool) $access['can_create'],
            'can_read'   => (bool) $access['can_read'],
            'can_update' => (bool) $access['can_update'],
            'can_delete' => (bool) $access['can_delete'],
        ];
    }

    // =========================================================================
    // INDEX (HALAMAN UTAMA)
    // =========================================================================
    public function index()
    {
        $role = session()->get('role');
        $activeTab = $this->request->getGet('tab') ?? 'instansi';

        $dataList   = [];
        $moduleName = '';
        $pageTitle  = '';
        $maxData    = 0;

        switch ($activeTab) {
            case 'social':
                $moduleName = $this->moduleSocial;
                $pageTitle  = 'Daftar Media Sosial';
                $maxData    = 4; 
                $model      = $this->kontakSocialModel;
                $orderBy    = 'urutan ASC';
                break;

            case 'layanan': 
                $moduleName = $this->moduleLayanan;
                $pageTitle  = 'Daftar Kontak Layanan';
                $maxData    = 5;
                $model      = $this->kontakLayananModel;
                $orderBy    = 'urutan ASC';
                break;

            case 'instansi':
            default:
                $activeTab  = 'instansi'; 
                $moduleName = $this->moduleInstansi;
                $pageTitle  = 'Data Instansi';
                $maxData    = 1;
                $model      = $this->kontakModel;
                $orderBy    = 'created_at DESC';
                break;
        }

        $access = $this->getAccess($role, $moduleName);

        if ($access['can_read']) {
            $dataList  = $model->orderBy($orderBy)->findAll();
            $countData = $model->countAllResults();
        } else {
            return redirect()->to('/dashboard')->with('error', 'Anda tidak memiliki izin akses.');
        }

        $data = [
            'title'       => 'Manajemen Kontak',
            'activeTab'   => $activeTab,
            'page_title'  => $pageTitle,
            'data_list'   => $dataList,
            'count_data'  => $countData,
            'max_data'    => $maxData,
            'access'      => $access, 
        ];

        return view('pages/kontak/index', $data);
    }

    
    // =========================================================================
    // CREATE (UNIVERSAL UNTUK 3 TAB)
    // =========================================================================
    public function create($type)
    {
        // 1. Validasi Tipe
        if (!in_array($type, ['instansi', 'social', 'layanan'])) {
            return redirect()->to('/kontak')->with('error', 'Tipe data tidak valid.');
        }

        // 2. Tentukan Module & Model
        $moduleName = $type == 'instansi' ? $this->moduleInstansi : ($type == 'social' ? $this->moduleSocial : $this->moduleLayanan);
        $model      = $type == 'instansi' ? $this->kontakModel : ($type == 'social' ? $this->kontakSocialModel : $this->kontakLayananModel);
        $maxLimit   = $type == 'instansi' ? 1 : ($type == 'social' ? 4 : 5);

        // 3. Cek Permission & Limit
        $access = $this->getAccess(session()->get('role'), $moduleName);
        if (!$access['can_create']) return redirect()->to("/kontak?tab=$type")->with('error', 'Akses ditolak.');

        if ($model->countAllResults() >= $maxLimit) {
            return redirect()->to("/kontak?tab=$type")->with('error', "Maksimal data $type sudah tercapai ($maxLimit).");
        }

        $data = [
            'title' => 'Tambah Data ' . ucfirst($type),
            'type'  => $type,
            'validation' => \Config\Services::validation()
        ];

        // Load View Universal
        return view('pages/kontak/form_create', $data);
    }

    // =========================================================================
    // STORE (UNIVERSAL UNTUK 3 TAB)
    // =========================================================================
    public function store($type)
    {
        $rules = [];
        $dataInput = [];
        $model = null;

        // Persiapan Data berdasarkan Tipe
        switch ($type) {
            case 'instansi':
                $model = $this->kontakModel;
                $rules = ['nama_instansi' => 'required', 'alamat_lengkap' => 'required', 'telepon' => 'required'];
                $dataInput = [
                    'nama_instansi'  => $this->request->getPost('nama_instansi'),
                    'alamat_lengkap' => $this->request->getPost('alamat_lengkap'),
                    'telepon'        => $this->request->getPost('telepon'),
                    'fax'            => $this->request->getPost('fax'),
                    'map_link'       => $this->request->getPost('map_link'),
                    'status'         => 1 // Default 1 (Aktif)
                ];
                break;

            case 'social':
                $model = $this->kontakSocialModel;
                $rules = ['platform' => 'required', 'link_url' => 'required|valid_url'];
                $dataInput = [
                    'platform'   => $this->request->getPost('platform'),
                    'icon_class' => $this->request->getPost('icon_class'),
                    'link_url'   => $this->request->getPost('link_url'),
                    'urutan'     => $this->request->getPost('urutan'),
                    'status'     => 1 // Default 1 (Aktif)
                ];
                break;

            case 'layanan':
                $model = $this->kontakLayananModel;
                $rules = ['judul' => 'required', 'link_url' => 'required|valid_url'];
                $dataInput = [
                    'judul'         => $this->request->getPost('judul'),
                    'subjudul'      => $this->request->getPost('subjudul'),
                    'link_url'      => $this->request->getPost('link_url'),
                    'icon_class'    => $this->request->getPost('icon_class'),
                    'icon_bg_color' => $this->request->getPost('icon_bg_color'),
                    'urutan'        => $this->request->getPost('urutan'),
                    'status'        => 1, // Default 1 (Aktif)
                    'updated_by_id' => session()->get('id_user'),
                ];
                break;
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model->insert($dataInput);
        return redirect()->to("/kontak?tab=$type")->with('success', 'Data berhasil ditambahkan.');
    }

    // =========================================================================
    // EDIT (UNIVERSAL)
    // =========================================================================
    public function edit($type, $id)
    {
        // Tentukan Module & Model
        $moduleName = $type == 'instansi' ? $this->moduleInstansi : ($type == 'social' ? $this->moduleSocial : $this->moduleLayanan);
        $model      = $type == 'instansi' ? $this->kontakModel : ($type == 'social' ? $this->kontakSocialModel : $this->kontakLayananModel);

        $access = $this->getAccess(session()->get('role'), $moduleName);
        if (!$access['can_update']) return redirect()->to("/kontak?tab=$type")->with('error', 'Akses ditolak.');

        $dataRow = $model->find($id);
        if (!$dataRow) return redirect()->to("/kontak?tab=$type")->with('error', 'Data tidak ditemukan.');

        $data = [
            'title' => 'Edit Data ' . ucfirst($type),
            'type'  => $type,
            'row'   => $dataRow,
            'validation' => \Config\Services::validation()
        ];

        return view('pages/kontak/form_edit', $data);
    }

    // =========================================================================
    // UPDATE (UNIVERSAL)
    // =========================================================================
    public function update($type, $id)
    {
        $rules = [];
        $dataInput = [];
        $model = null;

        // Persiapan Data
        switch ($type) {
            case 'instansi':
                $model = $this->kontakModel;
                $rules = ['nama_instansi' => 'required'];
                $dataInput = [
                    'id_kontak'      => $id,
                    'nama_instansi'  => $this->request->getPost('nama_instansi'),
                    'alamat_lengkap' => $this->request->getPost('alamat_lengkap'),
                    'telepon'        => $this->request->getPost('telepon'),
                    'fax'            => $this->request->getPost('fax'),
                    'map_link'       => $this->request->getPost('map_link'),
                ];
                break;

            case 'social':
                $model = $this->kontakSocialModel;
                $rules = ['platform' => 'required', 'link_url' => 'required'];
                $dataInput = [
                    'id_kontak_social' => $id,
                    'platform'   => $this->request->getPost('platform'),
                    'icon_class' => $this->request->getPost('icon_class'),
                    'link_url'   => $this->request->getPost('link_url'),
                    'urutan'     => $this->request->getPost('urutan'),
                ];
                break;

            case 'layanan':
                $model = $this->kontakLayananModel;
                $rules = ['judul' => 'required'];
                $dataInput = [
                    'id_kontak_layanan' => $id,
                    'judul'         => $this->request->getPost('judul'),
                    'subjudul'      => $this->request->getPost('subjudul'),
                    'link_url'      => $this->request->getPost('link_url'),
                    'icon_class'    => $this->request->getPost('icon_class'),
                    'icon_bg_color' => $this->request->getPost('icon_bg_color'),
                    'urutan'        => $this->request->getPost('urutan'),
                    'updated_by_id' => session()->get('id_user'),
                ];
                break;
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model->save($dataInput);
        return redirect()->to("/kontak?tab=$type")->with('success', 'Data berhasil diperbarui.');
    }

    // =========================================================================
    // DELETE (UNIVERSAL)
    // =========================================================================
    public function delete($type, $id)
    {
        $moduleName = $type == 'instansi' ? $this->moduleInstansi : ($type == 'social' ? $this->moduleSocial : $this->moduleLayanan);
        $model      = $type == 'instansi' ? $this->kontakModel : ($type == 'social' ? $this->kontakSocialModel : $this->kontakLayananModel);

        $access = $this->getAccess(session()->get('role'), $moduleName);
        if (!$access['can_delete']) return redirect()->to("/kontak?tab=$type")->with('error', 'Akses hapus ditolak.');

        $model->delete($id);
        return redirect()->to("/kontak?tab=$type")->with('success', 'Data berhasil dihapus.');
    }
    
    // =========================================================================
    // UPDATE STATUS (AJAX) - FIXED
    // =========================================================================
    public function updateStatus()
    {
        // 1. Cek apakah request AJAX
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // 2. Ambil Data (Gunakan getPost karena FormData mengirim POST)
        // Jangan gunakan getJSON() karena View menggunakan FormData
        $id     = $this->request->getPost('id');
        $type   = $this->request->getPost('type');
        $status = $this->request->getPost('status'); // Menerima '1' atau '0'

        // 3. Tentukan Model & Update
        $model = null;
        
        if ($type == 'instansi') {
            $model = $this->kontakModel;
            // Jika tabel menggunakan ID yang berbeda (misal id_kontak), Model CI4 otomatis tahu dari $primaryKey di file modelnya
            $model->update($id, ['status' => $status]);

        } elseif ($type == 'social') {
            $model = $this->kontakSocialModel;
            $model->update($id, ['status' => $status]);

        } elseif ($type == 'layanan') {
            $model = $this->kontakLayananModel;
            $model->update($id, ['status' => $status]);
        }

        // 4. Return JSON
        if ($model) {
            return $this->response->setJSON([
                'success' => true, 
                'message' => 'Status berhasil diubah',
                'csrf_token' => csrf_hash() // Kirim token baru jika diperlukan
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Tipe data salah'
            ]);
        }
    }
}