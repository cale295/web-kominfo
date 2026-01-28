<?php

namespace App\Controllers\frontend;

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
                'error' => '⚠ Kamu tidak memiliki hak akses ke modul ini.',
            ]);
        }

        if (!$access['can_read']) {
            return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya izin melihat agenda.');
        }

        $agendas = $this->agendaModel->orderBy('start_date', 'DESC')->findAll();

        $data = [
            'agendas' => $agendas,
            'can_create' => $access['can_create'],
            'can_update' => $access['can_update'],
            'can_delete' => $access['can_delete'],
        ];

        return view('pages/agenda/index', $data);
    }

    public function toggleStatus()
    {
        // 1. Cek Request AJAX
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // 2. Cek Hak Akses
        $role = session()->get('role');
        $access = $this->getAccess($role);

        if (!$access || !$access['can_update']) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Anda tidak memiliki izin akses.',
                'token' => csrf_hash(),
            ]);
        }

        // 3. Proses Update Sesuai Struktur Tabel
        $id = $this->request->getPost('id');

        // Pastikan ID ada
        $agenda = $this->agendaModel->find($id);

        if ($agenda) {
            // Logic Toggle untuk ENUM('0','1')
            // Jika status sekarang '1', ubah jadi '0'. Jika tidak, ubah jadi '1'.
            $newStatus = $agenda['status'] === '1' ? '0' : '1';

            // Data yang akan diupdate (HANYA STATUS)
            // updated_at tidak perlu dimasukkan karena database Anda sudah ON UPDATE CURRENT_TIMESTAMP
            $updateData = [
                'status' => $newStatus,
            ];

            // Gunakan update() biasa.
            // Kita tidak perlu skipValidation kecuali ada rules ketat di model yang mengharuskan field lain diisi ulang.
            if ($this->agendaModel->update($id, $updateData)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Status berhasil diubah',
                    'newStatus' => $newStatus,
                    'token' => csrf_hash(), // Kirim token CSRF baru
                ]);
            }
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Gagal mengupdate database.',
            'token' => csrf_hash(),
        ]);
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
    // ... dalam AgendaController.php

    public function create()
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_create']) {
            return redirect()->to('/agenda')->with('error', 'Kamu tidak punya izin menambah agenda.');
        }

        $data = [
            'activity_name' => $this->request->getPost('activity_name'),
            'description' => $this->request->getPost('description'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date'),
            'location' => $this->request->getPost('location'),
            'status' => '1', // ✅ FIX: ENUM
        ];

        if ($img = $this->request->getFile('image')) {
            if ($img->isValid() && !$img->hasMoved()) {
                $newName = $img->getRandomName();
                $img->move(FCPATH . 'uploads/agenda/', $newName);
                $data['image'] = $newName;
            }
        }

        if (!$this->agendaModel->insert($data)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->agendaModel->errors());
        }

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
    // ==========================================================
    // PUT /pages/agenda/{id} → update agenda
    // ==========================================================
    public function update($id = null)
    {
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_update']) {
            return redirect()->to('/agenda')->with('error', 'Kamu tidak punya izin mengubah agenda.');
        }

        $agenda = $this->agendaModel->find($id);
        if (!$agenda) {
            return redirect()->to('/agenda')->with('error', 'Agenda tidak ditemukan.');
        }

        $data = [
            'activity_name' => $this->request->getPost('activity_name'),
            'description' => $this->request->getPost('description'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date'),
            'location' => $this->request->getPost('location'),
            'status' => $this->request->getPost('status') === '1' ? '1' : '0', // ✅
        ];

        $img = $this->request->getFile('image');
        $uploadPath = FCPATH . 'uploads/agenda/';

        // 1. --- VALIDASI FILE (TETAP DI CONTROLLER JIKA TIDAK ADA DI MODEL) ---
        // Aturan untuk file tidak bisa dimasukkan ke insert/update Model,
        // jadi tetap validasi di sini jika file *diisi* atau *wajib*.
        if ($img && $img->isValid() && $img->getSize() > 0) {
            $fileRules = [
                'image' => 'uploaded[image]|max_size[image,1024]|ext_in[image,jpg,jpeg,png]',
            ];

            // Validasi HANYA untuk file jika ada
            if (!$this->validate($fileRules)) {
                // Jika validasi file GAGAL, kirim error kembali
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('errors', $this->validator->getErrors());
            }

            // Proses upload file jika validasi file lolos
            $newName = $img->getRandomName();

            if (!$img->move($uploadPath, $newName)) {
                return redirect()->back()->with('error', 'Gagal menyimpan gambar. Pastikan folder "uploads/agenda" writable.');
            }

            $data['image'] = $newName;

            // hapus gambar lama
            if (!empty($agenda['image']) && file_exists($uploadPath . $agenda['image'])) {
                @unlink($uploadPath . $agenda['image']);
            }
        }
        // 2. --- EKSEKUSI UPDATE DENGAN VALIDASI MODEL ---
        // Jika ada error dari validasi Model (misal: activity_name kosong), ini akan gagal.
        if (!$this->agendaModel->update($id, $data)) {
            // Jika Validasi Model GAGAL
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->agendaModel->errors());
        }

        return redirect()->to('/agenda')->with('success', 'Agenda berhasil diperbarui.');
    }
   // ==========================================================
    // DELETE /pages/agenda/delete/{id}
    // ==========================================================
    public function delete($id = null)
    {
        // 1. Cek Hak Akses
        $access = $this->getAccess(session()->get('role'));
        if (!$access || !$access['can_delete']) {
            return redirect()->to('/agenda')->with('error', 'Kamu tidak punya izin menghapus agenda.');
        }

        // 2. Cari Data Berdasarkan ID
        // Model sudah tau primaryKey-nya 'id_agenda', jadi find($id) aman.
        $agenda = $this->agendaModel->find($id);

        if (!$agenda) {
            return redirect()->to('/agenda')->with('error', 'Data tidak ditemukan.');
        }
        
        // 3. Hapus Gambar (Path diperbaiki: uploads/agenda/)
        // Sesuai dengan saat Anda upload di function create()
        $uploadPath = FCPATH . 'uploads/agenda/'; 
        
        if (!empty($agenda['image'])) {
            $filePath = $uploadPath . $agenda['image'];
            if (file_exists($filePath)) {
                @unlink($filePath); // Hapus file fisik
            }
        }

        // 4. Hapus Data di Database
        // delete($id) akan menjalankan "DELETE FROM t_agenda WHERE id_agenda = $id"
        if ($this->agendaModel->delete($id)) {
            return redirect()->to('/agenda')->with('success', 'Agenda berhasil dihapus.');
        } else {
            return redirect()->to('/agenda')->with('error', 'Gagal menghapus data dari database.');
        }
    }

    // ==========================================================
    // Fungsi bantu untuk ambil akses role
    // ==========================================================
    private function getAccess($role)
    {
        $access = $this->accessRightsModel->where('role', $role)->where('module_name', $this->module)->first();

        if (!$access) {
            return false;
        }

        return [
            'can_create' => (bool) $access['can_create'],
            'can_read' => (bool) $access['can_read'],
            'can_update' => (bool) $access['can_update'],
            'can_delete' => (bool) $access['can_delete'],
        ];
    }
}
