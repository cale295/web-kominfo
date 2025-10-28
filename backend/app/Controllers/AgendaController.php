<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AgendaModel;
use App\Models\AccessRightsModel;
use CodeIgniter\Exceptions\PageNotFoundException; // Pastikan ini di-import

class AgendaController extends BaseController
{
    protected $agendaModel;
    protected $accessRightsModel;
    protected $module = 'agenda'; // nama modul untuk hak akses

    public function __construct()
    {
        $this->agendaModel = new AgendaModel();
        $this->accessRightsModel = new AccessRightsModel();
    }

    // ==========================================================
    // GET /agenda → tampilkan semua agenda
    // ==========================================================
    public function index()
    {
        $role = session()->get('role');
        $access = $this->getAccess($role);

        if (!$access) {
            return view('pages/agenda/index', [
                'agendas' => [],
                'error'   => '⚠ Kamu tidak memiliki hak akses ke modul ini.'
            ]);
        }

        if (!$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat agenda.');
        }

        $agendas = $this->agendaModel->orderBy('start_date', 'DESC')->findAll();

        $data = [
            'agendas'    => $agendas,
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ];

        return view('pages/agenda/index', $data);
    }

    // ==========================================================
    // GET /pages/agenda/new → form tambah agenda
    // ==========================================================
    public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/agenda')->with('error', 'Kamu tidak punya izin menambah agenda.');
        }

        return view('pages/agenda/create');
    }

    // ==========================================================
    // POST /agenda → simpan agenda baru
    // ==========================================================
    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/agenda')->with('error', 'Kamu tidak punya izin menambah agenda.');
        }

        $validation = $this->validate([
            'activity_name' => 'required|min_length[3]',
            'start_date'    => 'required|valid_date',
            'end_date'      => 'required|valid_date',
            
            // =======================================================================
            // PERBAIKAN: Aturan 'is_image[image]' dihapus untuk mengatasi masalah PNG.
            // Kita hanya bergantung pada 'ext_in' untuk memeriksa ekstensi.
            // =======================================================================
            'image' => 'permit_empty|ext_in[image,jpg,jpeg,png]' 
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'activity_name' => $this->request->getPost('activity_name'),
            'description'   => $this->request->getPost('description'),
            'start_date'    => $this->request->getPost('start_date'),
            'end_date'      => $this->request->getPost('end_date'),
            'location'      => $this->request->getPost('location'),
            'status'        => $this->request->getPost('status') ?? 'active',
        ];

        // Upload gambar jika ada
        if ($img = $this->request->getFile('image')) {
            if ($img->isValid() && !$img->hasMoved()) {
                $newName = $img->getRandomName();
                $img->move(FCPATH . 'uploads/pages/agenda/', $newName); // Gunakan FCPATH
                $data['image'] = $newName;
            }
        }

        $this->agendaModel->insert($data);
        return redirect()->to('/agenda')->with('success', 'Agenda berhasil ditambahkan!');
    }

    // ==========================================================
    // GET /pages/agenda/{id}/edit → form edit agenda
    // ==========================================================
    public function edit($id = null)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/agenda')->with('error', 'Kamu tidak punya izin mengedit agenda.');
        }

        $agenda = $this->agendaModel->find($id);
        if (!$agenda) {
            throw new PageNotFoundException('Agenda tidak ditemukan.');
        }

        return view('pages/agenda/edit', ['agenda' => $agenda]);
    }

    // ==========================================================
    // PUT /pages/agenda/{id} → update agenda
    // ==========================================================
    public function update($id = null)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/agenda')->with('error', 'Kamu tidak punya izin mengubah agenda.');
        }

        $img = $this->request->getFile('image');

        // =======================================================================
        // PERBAIKAN: Aturan validasi file ditambahkan di sini agar konsisten
        // dengan method create() dan lebih rapi.
        // =======================================================================
        $rules = [
            'activity_name' => 'required|min_length[3]',
            'start_date'    => 'required|valid_date',
            'end_date'      => 'required|valid_date',
            'image'         => 'permit_empty|ext_in[image,jpg,jpeg,png]' // 'is_image' juga dihapus
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'activity_name' => $this->request->getPost('activity_name'),
            'description'   => $this->request->getPost('description'),
            'start_date'    => $this->request->getPost('start_date'),
            'end_date'      => $this->request->getPost('end_date'),
            'location'      => $this->request->getPost('location'),
            'status'        => $this->request->getPost('status') ?? 'inactive',
        ];

        // Folder upload (gunakan FCPATH)
        $uploadPath = FCPATH . 'uploads/pages/agenda/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Upload file baru (Gunakan getSize() > 0 untuk memastikan file benar-benar di-upload)
        if ($img && $img->isValid() && $img->getSize() > 0) {
            
            // =======================================================================
            // PERBAIKAN: Pengecekan ekstensi manual dihapus,
            // karena sudah ditangani oleh $this->validate($rules) di atas.
            // =======================================================================

            $newName = $img->getRandomName();

            if (!$img->move($uploadPath, $newName)) {
                return redirect()->back()->with('error', 'Gagal menyimpan gambar. Pastikan folder "uploads/agenda" writable.');
            }

            $data['image'] = $newName;

            // hapus gambar lama
            $old = $this->agendaModel->find($id);
            if ($old && !empty($old['image']) && file_exists($uploadPath . $old['image'])) {
                @unlink($uploadPath . $old['image']); // gunakan @ untuk menekan error jika file tidak ada
            }
        }

        $this->agendaModel->update($id, $data);
        return redirect()->to('/agenda')->with('success', 'Agenda berhasil diperbarui.');
    }

    // ==========================================================
    // DELETE /pages/agenda/{id} → hapus agenda
    // ==========================================================
    public function delete($id = null)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) {
            return redirect()->to('/agenda')->with('error', 'Kamu tidak punya izin menghapus agenda.');
        }

        $agenda = $this->agendaModel->find($id);

        // =======================================================================
        // PERBAIKAN: Tambahkan FCPATH. Path 'uploads/pages/agenda/...' saja tidak akan
        // ditemukan. Harus FCPATH . 'uploads/pages/agenda/'
        // =======================================================================
        $uploadPath = FCPATH . 'uploads/pages/agenda/';
        if ($agenda && !empty($agenda['image']) && file_exists($uploadPath . $agenda['image'])) {
            @unlink($uploadPath . $agenda['image']); // gunakan @ untuk menekan error
        }

        if ($this->agendaModel->delete($id)) {
            return redirect()->to('/agenda')->with('success', 'Agenda berhasil dihapus.');
        } else {
            return redirect()->to('/agenda')->with('error', 'Gagal menghapus agenda.');
        }
    }

    // ==========================================================
    // Fungsi bantu untuk ambil akses role
    // ==========================================================
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