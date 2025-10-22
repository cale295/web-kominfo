<?php
// ========================================
// 1. MODEL: App/Models/HakAksesModel.php
// ========================================
namespace App\Models;

use CodeIgniter\Model;

class HakAksesModel extends Model
{
    protected $table = 't_access_rights';
    protected $primaryKey = 'id_access';
    protected $allowedFields = [
        'role',
        'module_name',
        'can_create',
        'can_read',
        'can_update',
        'can_delete',
        'can_publish'
    ];
    protected $useTimestamps = false;
    
    // Get all access rights with grouping by role
    public function getAccessByRole()
    {
        return $this->orderBy('role', 'ASC')
                    ->orderBy('module_name', 'ASC')
                    ->findAll();
    }
    
    // Get access rights for specific role
    public function getAccessByRoleName($role)
    {
        return $this->where('role', $role)->findAll();
    }
    
    // Check if access exists
    public function accessExists($role, $module)
    {
        return $this->where(['role' => $role, 'module_name' => $module])->first();
    }
    
    // Update or create access
    public function updateOrCreate($data)
    {
        $existing = $this->accessExists($data['role'], $data['module_name']);
        
        if ($existing) {
            return $this->update($existing['id_access'], $data);
        } else {
            return $this->insert($data);
        }
    }
    
    // Get unique modules
    public function getModules()
    {
        return $this->distinct()
                    ->select('module_name')
                    ->orderBy('module_name', 'ASC')
                    ->findAll();
    }
}

// ========================================
// 2. CONTROLLER: App/Controllers/Admin/AccessRights.php
// ========================================
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\HakAksesModel;

class AccessRights extends BaseController
{
    protected $accessModel;
    
    public function __construct()
    {
        $this->accessModel = new HakAksesModel();
        
        // Middleware: Cek jika bukan Super Admin
        if (session()->get('role') !== 'Super Admin') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Access Denied');
        }
    }
    
    // Halaman utama daftar akses
    public function index()
    {
        $data = [
            'title' => 'Kelola Hak Akses',
            'access_rights' => $this->accessModel->getAccessByRole(),
            'roles' => ['Super Admin', 'Admin', 'Editor'],
            'modules' => $this->getAvailableModules()
        ];
        
        return view('admin/access_rights/index', $data);
    }
    
    // Form tambah/edit akses
    public function form($id = null)
    {
        $data = [
            'title' => $id ? 'Edit Hak Akses' : 'Tambah Hak Akses',
            'access' => $id ? $this->accessModel->find($id) : null,
            'roles' => ['Super Admin', 'Admin', 'Editor'],
            'modules' => $this->getAvailableModules()
        ];
        
        return view('admin/access_rights/form', $data);
    }
    
    // Simpan data
    public function save()
    {
        $rules = [
            'role' => 'required',
            'module_name' => 'required',
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'role' => $this->request->getPost('role'),
            'module_name' => $this->request->getPost('module_name'),
            'can_create' => $this->request->getPost('can_create') ? 1 : 0,
            'can_read' => $this->request->getPost('can_read') ? 1 : 0,
            'can_update' => $this->request->getPost('can_update') ? 1 : 0,
            'can_delete' => $this->request->getPost('can_delete') ? 1 : 0,
            'can_publish' => $this->request->getPost('can_publish') ? 1 : 0,
        ];
        
        $id = $this->request->getPost('id_access');
        
        if ($id) {
            $this->accessModel->update($id, $data);
            $message = 'Hak akses berhasil diupdate';
        } else {
            // Cek duplikasi
            if ($this->accessModel->accessExists($data['role'], $data['module_name'])) {
                return redirect()->back()->withInput()->with('error', 'Akses untuk role dan module ini sudah ada!');
            }
            $this->accessModel->insert($data);
            $message = 'Hak akses berhasil ditambahkan';
        }
        
        return redirect()->to('/admin/access-rights')->with('success', $message);
    }
    
    // Hapus akses
    public function delete($id)
    {
        $this->accessModel->delete($id);
        return redirect()->to('/admin/access-rights')->with('success', 'Hak akses berhasil dihapus');
    }
    
    // Bulk update untuk satu role
    public function bulkUpdate()
    {
        $role = $this->request->getPost('role');
        $permissions = $this->request->getPost('permissions');
        
        if (!$role || !$permissions) {
            return redirect()->back()->with('error', 'Data tidak lengkap');
        }
        
        foreach ($permissions as $module => $perms) {
            $data = [
                'role' => $role,
                'module_name' => $module,
                'can_create' => isset($perms['create']) ? 1 : 0,
                'can_read' => isset($perms['read']) ? 1 : 0,
                'can_update' => isset($perms['update']) ? 1 : 0,
                'can_delete' => isset($perms['delete']) ? 1 : 0,
                'can_publish' => isset($perms['publish']) ? 1 : 0,
            ];
            
            $this->accessModel->updateOrCreate($data);
        }
        
        return redirect()->to('/admin/access-rights')->with('success', 'Hak akses untuk role ' . $role . ' berhasil diupdate');
    }
    
    // Get list module yang tersedia
    private function getAvailableModules()
    {
        return [
            'Dashboard',
            'Berita',
            'Kategori Berita',
            'Tema Berita',
            'Tag Berita',
            'Berita Utama',
            'Agenda',
            'Galeri',
            'Album Foto',
            'Dokumen',
            'Kategori Dokumen',
            'Layanan',
            'Menu',
            'User',
            'Hak Akses',
            'Pengaturan'
        ];
    }
}

// ========================================
// 3. VIEW: App/Views/admin/access_rights/index.php
// ========================================
?>
<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-shield-lock"></i> <?= $title ?></h2>
        <a href="<?= base_url('admin/access-rights/form') ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Hak Akses
        </a>
    </div>
    
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <!-- Tab Navigation -->
    <ul class="nav nav-tabs mb-3" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#super-admin">Super Admin</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#admin">Admin</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#editor">Editor</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#all-access">Semua Akses</a>
        </li>
    </ul>
    
    <!-- Tab Content -->
    <div class="tab-content">
        <!-- Super Admin Tab -->
        <div class="tab-pane fade show active" id="super-admin">
            <?= view('admin/access_rights/role_table', ['role' => 'Super Admin', 'access_rights' => $access_rights, 'modules' => $modules]) ?>
        </div>
        
        <!-- Admin Tab -->
        <div class="tab-pane fade" id="admin">
            <?= view('admin/access_rights/role_table', ['role' => 'Admin', 'access_rights' => $access_rights, 'modules' => $modules]) ?>
        </div>
        
        <!-- Editor Tab -->
        <div class="tab-pane fade" id="editor">
            <?= view('admin/access_rights/role_table', ['role' => 'Editor', 'access_rights' => $access_rights, 'modules' => $modules]) ?>
        </div>
        
        <!-- All Access Tab -->
        <div class="tab-pane fade" id="all-access">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Role</th>
                                    <th>Module</th>
                                    <th>Create</th>
                                    <th>Read</th>
                                    <th>Update</th>
                                    <th>Delete</th>
                                    <th>Publish</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($access_rights as $access): ?>
                                <tr>
                                    <td><span class="badge bg-primary"><?= $access['role'] ?></span></td>
                                    <td><?= $access['module_name'] ?></td>
                                    <td><?= $access['can_create'] ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle-fill text-danger"></i>' ?></td>
                                    <td><?= $access['can_read'] ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle-fill text-danger"></i>' ?></td>
                                    <td><?= $access['can_update'] ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle-fill text-danger"></i>' ?></td>
                                    <td><?= $access['can_delete'] ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle-fill text-danger"></i>' ?></td>
                                    <td><?= $access['can_publish'] ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle-fill text-danger"></i>' ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/access-rights/form/' . $access['id_access']) ?>" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="<?= base_url('admin/access-rights/delete/' . $access['id_access']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?php
// ========================================
// 4. VIEW: App/Views/admin/access_rights/role_table.php
// ========================================
?>
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Hak Akses untuk Role: <?= $role ?></h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('admin/access-rights/bulk-update') ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="role" value="<?= $role ?>">
            
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Module Name</th>
                            <th class="text-center">Create</th>
                            <th class="text-center">Read</th>
                            <th class="text-center">Update</th>
                            <th class="text-center">Delete</th>
                            <th class="text-center">Publish</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Group access rights by module for this role
                        $roleAccess = [];
                        foreach ($access_rights as $access) {
                            if ($access['role'] === $role) {
                                $roleAccess[$access['module_name']] = $access;
                            }
                        }
                        
                        foreach ($modules as $module): 
                            $access = $roleAccess[$module] ?? null;
                        ?>
                        <tr>
                            <td><strong><?= $module ?></strong></td>
                            <td class="text-center">
                                <input type="checkbox" name="permissions[<?= $module ?>][create]" class="form-check-input" <?= ($access && $access['can_create']) ? 'checked' : '' ?>>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" name="permissions[<?= $module ?>][read]" class="form-check-input" <?= ($access && $access['can_read']) ? 'checked' : '' ?>>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" name="permissions[<?= $module ?>][update]" class="form-check-input" <?= ($access && $access['can_update']) ? 'checked' : '' ?>>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" name="permissions[<?= $module ?>][delete]" class="form-check-input" <?= ($access && $access['can_delete']) ? 'checked' : '' ?>>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" name="permissions[<?= $module ?>][publish]" class="form-check-input" <?= ($access && $access['can_publish']) ? 'checked' : '' ?>>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Simpan Perubahan untuk <?= $role ?>
                </button>
            </div>
        </form>
    </div>
</div>

<?php
// ========================================
// 5. ROUTES: App/Config/Routes.php
// ========================================
// Tambahkan routes berikut:
?>

// Access Rights Management (Super Admin Only)
$routes->group('admin/access-rights', ['filter' => 'auth', 'namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('/', 'AccessRights::index');
    $routes->get('form/(:num)', 'AccessRights::form/$1');
    $routes->get('form', 'AccessRights::form');
    $routes->post('save', 'AccessRights::save');
    $routes->post('bulk-update', 'AccessRights::bulkUpdate');
    $routes->get('delete/(:num)', 'AccessRights::delete/$1');
});

<?php
// ========================================
// 6. FILTER: App/Filters/AuthFilter.php (Optional - untuk proteksi route)
// ========================================
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}

// ========================================
// 7. HELPER FUNCTION: App/Helpers/permission_helper.php
// ========================================
if (!function_exists('can')) {
    function can($module, $permission)
    {
        $db = \Config\Database::connect();
        $role = session()->get('role');
        
        $query = $db->table('t_access_rights')
                    ->where('role', $role)
                    ->where('module_name', $module)
                    ->get()
                    ->getRowArray();
        
        if (!$query) {
            return false;
        }
        
        switch ($permission) {
            case 'create':
                return (bool) $query['can_create'];
            case 'read':
                return (bool) $query['can_read'];
            case 'update':
                return (bool) $query['can_update'];
            case 'delete':
                return (bool) $query['can_delete'];
            case 'publish':
                return (bool) $query['can_publish'];
            default:
                return false;
        }
    }
}

// Usage di view atau controller:
// if (can('Berita', 'create')) {
//     // Tampilkan tombol tambah berita
// }
?>