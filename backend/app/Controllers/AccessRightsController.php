<?php

namespace App\Controllers;

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

        $data['title'] = 'Manajemen Hak Akses';
        $data['accessList'] = $this->accessModel->findAll();

        return view('pages/access_rights/index', $data);
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
        $data = [
            'can_create' => $this->request->getPost('can_create') ? 1 : 0,
            'can_read' => $this->request->getPost('can_read') ? 1 : 0,
            'can_update' => $this->request->getPost('can_update') ? 1 : 0,
            'can_delete' => $this->request->getPost('can_delete') ? 1 : 0,
            'can_publish' => $this->request->getPost('can_publish') ? 1 : 0,
        ];

        $this->accessModel->update($id, $data);
        return redirect()->to('/access_rights')->with('success', 'Hak akses berhasil diperbarui.');
    }
}
