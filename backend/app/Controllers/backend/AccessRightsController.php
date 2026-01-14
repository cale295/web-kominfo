<?php

namespace App\Controllers\backend;

use App\Controllers\BaseController;
use App\Models\AccessRightsModel;

class AccessRightsController extends BaseController
{
    protected $accessModel;

    public function __construct()
    {
        $this->accessModel = new AccessRightsModel();
    }

    // ======== INDEX (Hanya Superadmin) ========
    public function index()
    {
        // Cek role login
        $session = session();
        if ($session->get('role') !== 'superadmin') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        $accessModel = new AccessRightsModel();

        $filter = $this->request->getGet('filter');
        $sort = $this->request->getGet('sort');

        $query = $accessModel->select('*');

        // Filter
        if ($filter) {
            $query->groupStart()
                  ->like('role', $filter)
                  ->orLike('module_name', $filter)
                  ->groupEnd();
        }

        // Sort
        switch ($sort) {
            case 'role_asc':
                $query->orderBy('role', 'ASC');
                break;
            case 'role_desc':
                $query->orderBy('role', 'DESC');
                break;
            case 'module_asc':
                $query->orderBy('module_name', 'ASC');
                break;
            case 'module_desc':
                $query->orderBy('module_name', 'DESC');
                break;
        }

        $data = [
            'title' => 'Manajemen Hak Akses',
            'accessList' => $query->findAll(),
            'filter' => $filter,
            'sort' => $sort
        ];

        return view('pages/access_rights/index', $data);
    }
    
    // ======== CREATE / STORE (Data Baru) ========
    public function store()
    {
        $session = session();
        if ($session->get('role') !== 'superadmin') {
            return redirect()->to('/dashboard');
        }

        // Validasi input sederhana
        if (!$this->validate([
            'role'        => 'required',
            'module_name' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('error', 'Role dan Nama Module wajib diisi.');
        }

        $data = [
            'role'        => $this->request->getPost('role'),
            'module_name' => $this->request->getPost('module_name'),
            'can_create'  => $this->request->getPost('can_create') ? 1 : 0,
            'can_read'    => $this->request->getPost('can_read') ? 1 : 0,
            'can_update'  => $this->request->getPost('can_update') ? 1 : 0,
            'can_delete'  => $this->request->getPost('can_delete') ? 1 : 0,
            'can_publish' => $this->request->getPost('can_publish') ? 1 : 0,
        ];

        $this->accessModel->insert($data);

        return redirect()->to('/access_rights')->with('success', 'Hak akses baru berhasil ditambahkan.');
    }

    // ======== FORM EDIT ========
    public function edit($id)
    {
        $session = session();
        if ($session->get('role') !== 'superadmin') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        $data['access'] = $this->accessModel->find($id);
        return view('pages/access_rights/edit', $data);
    }

    // ======== UPDATE ========
    public function update($id)
    {
        $session = session();
        if ($session->get('role') !== 'superadmin') {
            // Jika AJAX request
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Akses ditolak.'
                ]);
            }
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        $data = [
            'can_create'  => $this->request->getPost('can_create') ? 1 : 0,
            'can_read'    => $this->request->getPost('can_read') ? 1 : 0,
            'can_update'  => $this->request->getPost('can_update') ? 1 : 0,
            'can_delete'  => $this->request->getPost('can_delete') ? 1 : 0,
            'can_publish' => $this->request->getPost('can_publish') ? 1 : 0,
        ];

        try {
            $this->accessModel->update($id, $data);
            
            // Jika request AJAX (dari toggle)
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Hak akses berhasil diperbarui.'
                ]);
            }
            
            // Jika request form biasa (dari modal edit)
            return redirect()->to('/access_rights')->with('success', 'Hak akses berhasil diperbarui.');
            
        } catch (\Exception $e) {
            // Jika AJAX request
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal memperbarui hak akses: ' . $e->getMessage()
                ]);
            }
            
            return redirect()->back()->with('error', 'Gagal memperbarui hak akses.');
        }
    }
    
    // ======== DELETE (Optional) ========
    public function delete($id)
    {
        $session = session();
        if ($session->get('role') !== 'superadmin') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        try {
            $this->accessModel->delete($id);
            
            // Jika AJAX request
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Hak akses berhasil dihapus.'
                ]);
            }
            
            return redirect()->to('/access_rights')->with('success', 'Hak akses berhasil dihapus.');
            
        } catch (\Exception $e) {
            // Jika AJAX request
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menghapus hak akses.'
                ]);
            }
            
            return redirect()->back()->with('error', 'Gagal menghapus hak akses.');
        }
    }
}