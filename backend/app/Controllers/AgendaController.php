<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AgendaModel;
use App\Models\AccessRightsModel;

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
            return view('agenda/index', [
                'agendas' => [],
                'error'   => '⚠ Kamu tidak memiliki hak akses ke modul ini.'
            ]);
        }

        if (!$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat agenda.');
        }

        $agendas = $this->agendaModel->orderBy('start_date', 'DESC')->findAll();

        $data = [
            'agendas'     => $agendas,
            'can_create'  => $access['can_create'],
            'can_update'  => $access['can_update'],
            'can_delete'  => $access['can_delete'],
        ];

        return view('agenda/index', $data);
    }

    // ==========================================================
    // GET /agenda/new → form tambah agenda
    // ==========================================================
    public function new()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/agenda')->with('error', 'Kamu tidak punya izin menambah agenda.');
        }

        return view('agenda/create');
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
            'image'         => 'permit_empty|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
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
                $img->move('uploads/agenda/', $newName);
                $data['image'] = $newName;
            }
        }

        $this->agendaModel->insert($data);
        return redirect()->to('/agenda')->with('success', 'Agenda berhasil ditambahkan!');
    }

    // ==========================================================
    // GET /agenda/{id}/edit → form edit agenda
    // ==========================================================
    public function edit($id = null)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/agenda')->with('error', 'Kamu tidak punya izin mengedit agenda.');
        }

        $agenda = $this->agendaModel->find($id);
        if (!$agenda) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Agenda tidak ditemukan.');
        }

        return view('agenda/edit', ['agenda' => $agenda]);
    }

    // ==========================================================
    // PUT /agenda/{id} → update agenda
    // ==========================================================
    public function update($id = null)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/agenda')->with('error', 'Kamu tidak punya izin mengubah agenda.');
        }

        $validation = $this->validate([
            'activity_name' => 'required|min_length[3]',
            'start_date'    => 'required|valid_date',
            'end_date'      => 'required|valid_date',
            'image'         => 'permit_empty|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
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
            'status'        => $this->request->getPost('status') ?? 'inactive',
        ];

        // Handle upload gambar baru
        if ($img = $this->request->getFile('image')) {
            if ($img->isValid() && !$img->hasMoved()) {
                $newName = $img->getRandomName();
                $img->move('uploads/agenda/', $newName);
                $data['image'] = $newName;

                // hapus gambar lama
                $old = $this->agendaModel->find($id);
                if ($old && !empty($old['image']) && file_exists('uploads/agenda/' . $old['image'])) {
                    unlink('uploads/agenda/' . $old['image']);
                }
            }
        }

        $this->agendaModel->update($id, $data);
        return redirect()->to('/agenda')->with('success', 'Agenda berhasil diperbarui.');
    }

    // ==========================================================
    // DELETE /agenda/{id} → hapus agenda
    // ==========================================================
    public function delete($id = null)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) {
            return redirect()->to('/agenda')->with('error', 'Kamu tidak punya izin menghapus agenda.');
        }

        $agenda = $this->agendaModel->find($id);
        if ($agenda && !empty($agenda['image']) && file_exists('uploads/agenda/' . $agenda['image'])) {
            unlink('uploads/agenda/' . $agenda['image']);
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
