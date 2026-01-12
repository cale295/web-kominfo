<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/pages/access_rights/index.css') ?>">
<style>
    /* Styling Custom Gov */
    .modal-header-gov {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
    }
    .modal-title i {
        color: var(--primary-gov);
    }
    .header-actions {
        display: flex;
        gap: 10px;
    }
    /* Hover effect untuk baris permission */
    .permission-row:hover {
        background-color: #f8f9fa;
    }
    /* Agar kursor berubah jadi jari saat hover label */
    .cursor-pointer {
        cursor: pointer;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
// DEFINISI PERMISSION & DESKRIPSI (Dipakai untuk Modal Tambah & Edit)
$permissions = [
    'can_create'  => ['label' => 'Create',  'desc' => 'Izinkan membuat data', 'icon' => 'bi-plus-circle'],
    'can_read'    => ['label' => 'Read',    'desc' => 'Izinkan melihat data', 'icon' => 'bi-eye'],
    'can_update'  => ['label' => 'Update',  'desc' => 'Izinkan ubah data',    'icon' => 'bi-pencil'],
    'can_delete'  => ['label' => 'Delete',  'desc' => 'Izinkan hapus data',   'icon' => 'bi-trash'],
    'can_publish' => ['label' => 'Publish', 'desc' => 'Izinkan publikasi',    'icon' => 'bi-send']
];
?>

<div class="container-fluid py-4">
    
    <div class="page-header-gov d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1">
                <i class="bi bi-shield-lock-fill"></i>
                <?= esc($title) ?>
            </h3>
            <p class="text-muted mb-0">Kelola hak akses dan permission untuk setiap role pengguna</p>
        </div>
        <div class="header-actions">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAccessModal">
                <i class="bi bi-plus-lg me-2"></i>Tambah Akses
            </button>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success-gov alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card filter-card-gov mb-4">
        <div class="card-body">
            <form method="get" class="row g-3 align-items-end">
                <div class="col-lg-4 col-md-6">
                    <label for="filter" class="filter-label"><i class="bi bi-search"></i> Pencarian</label>
                    <input type="text" class="form-control form-control-gov" name="filter" id="filter" placeholder="Cari role atau module..." value="<?= esc($filter ?? '') ?>">
                </div>
                <div class="col-lg-4 col-md-6">
                    <label for="sort" class="filter-label"><i class="bi bi-sort-down"></i> Urutkan Berdasarkan</label>
                    <select class="form-select form-select-gov" name="sort" id="sort">
                        <option value="">-- Pilih Urutan --</option>
                        <option value="role_asc" <?= (isset($sort) && $sort == 'role_asc') ? 'selected' : '' ?>>Role (A → Z)</option>
                        <option value="role_desc" <?= (isset($sort) && $sort == 'role_desc') ? 'selected' : '' ?>>Role (Z → A)</option>
                        <option value="module_asc" <?= (isset($sort) && $sort == 'module_asc') ? 'selected' : '' ?>>Module (A → Z)</option>
                        <option value="module_desc" <?= (isset($sort) && $sort == 'module_desc') ? 'selected' : '' ?>>Module (Z → A)</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-6">
                    <button type="submit" class="btn btn-apply-filter w-100"><i class="bi bi-funnel me-1"></i> Terapkan</button>
                </div>
                <div class="col-lg-2 col-md-6">
                    <a href="/access_rights" class="btn btn-reset-filter w-100"><i class="bi bi-arrow-clockwise me-1"></i> Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card table-card-gov">
        <div class="table-card-header">
            <i class="bi bi-table"></i>
            <span>Daftar Hak Akses & Permission</span>
        </div>

        <div class="table-responsive">
            <table class="table table-gov table-hover mb-0">
                <thead>
                    <tr>
                        <th>Role</th>
                        <th>Module</th>
                        <th>Create</th>
                        <th>Read</th>
                        <th>Update</th>
                        <th>Delete</th>
                        <th>Publish</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($accessList)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="empty-state text-muted">
                                    <i class="bi bi-inbox fs-1 mb-3 d-block"></i>
                                    <h5>Belum Ada Data Hak Akses</h5>
                                    <p>Silakan tambahkan konfigurasi hak akses baru.</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($accessList as $a): ?>
                            <tr>
                                <td class="role-cell">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-light p-2 me-2 text-primary">
                                            <i class="bi bi-person-badge"></i>
                                        </div>
                                        <strong><?= esc($a['role']) ?></strong>
                                    </div>
                                </td>
                                <td class="module-cell">
                                    <code class="text-dark bg-light px-2 py-1 rounded border">
                                        <?= esc($a['module_name']) ?>
                                    </code>
                                </td>
                                
                                <?php 
                                    // Loop permission columns for table
                                    $keys = ['can_create', 'can_read', 'can_update', 'can_delete', 'can_publish'];
                                    foreach($keys as $key): 
                                ?>
                                <td>
                                    <?php if($a[$key]): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">
                                            <i class="bi bi-check-circle-fill me-1"></i>Yes
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill">
                                            <i class="bi bi-x-circle me-1"></i>No
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <?php endforeach; ?>
                                
                                <td class="text-center">
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-primary btn-edit-access" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editAccessModal"
                                            data-id="<?= $a['id_access'] ?>"
                                            data-role="<?= esc($a['role']) ?>"
                                            data-module="<?= esc($a['module_name']) ?>"
                                            data-create="<?= $a['can_create'] ? 1 : 0 ?>"
                                            data-read="<?= $a['can_read'] ? 1 : 0 ?>"
                                            data-update="<?= $a['can_update'] ? 1 : 0 ?>"
                                            data-delete="<?= $a['can_delete'] ? 1 : 0 ?>"
                                            data-publish="<?= $a['can_publish'] ? 1 : 0 ?>">
                                        <i class="bi bi-pencil-square me-1"></i> Edit
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addAccessModal" tabindex="-1" aria-labelledby="addAccessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-header-gov">
                <h5 class="modal-title" id="addAccessModalLabel">
                    <i class="bi bi-plus-circle-fill me-2"></i>Tambah Hak Akses Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="/access_rights/store" method="post">
                <?= csrf_field() ?>
                
                <div class="modal-body p-4">
                    <div class="row gy-3">
                        
                        <div class="col-12">
                            <label class="form-label fw-bold">Role Pengguna <span class="text-danger">*</span></label>
                            <select class="form-select" name="role" required>
                                <option value="" selected disabled>-- Pilih Role --</option>
                                <?php if(!empty($existingRoles)): ?>
                                    <?php foreach($existingRoles as $r): ?>
                                        <option value="<?= esc($r) ?>"><?= esc($r) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <option value="superadmin">superadmin</option>
                                <option value="admin">admin</option>
                                <option value="user">user</option>
                            </select>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label fw-bold">Nama Module <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-box"></i></span>
                                <input type="text" class="form-control" name="module_name" placeholder="Contoh: surat_masuk" required>
                            </div>
                        </div>

                        <div class="col-12"><hr class="my-2"></div>

                        <div class="col-12 mb-1"><label class="form-label fw-bold text-primary">Pengaturan Permission</label></div>
                        <?php foreach ($permissions as $key => $perm): ?>
                            <div class="col-12 permission-row rounded p-2 border mb-2">
                                <div class="form-check form-switch d-flex justify-content-between align-items-center m-0">
                                    <label class="form-check-label cursor-pointer" for="add_<?= $key ?>">
                                        <i class="bi <?= $perm['icon'] ?> me-2 text-muted"></i> 
                                        <span class="fw-medium"><?= $perm['label'] ?></span>
                                        <small class="text-muted ms-2 d-none d-sm-inline">(<?= $perm['desc'] ?>)</small>
                                    </label>
                                    <input class="form-check-input mt-0" type="checkbox" role="switch" name="<?= $key ?>" id="add_<?= $key ?>">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-save me-1"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editAccessModal" tabindex="-1" aria-labelledby="editAccessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-header-gov">
                <h5 class="modal-title" id="editAccessModalLabel">
                    <i class="bi bi-pencil-square me-2"></i>Edit Hak Akses
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="formEditAccess" action="" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">
                
                <div class="modal-body p-4">
                    <div class="alert alert-primary bg-primary-subtle border-primary-subtle text-primary mb-4">
                        <div class="d-flex justify-content-between">
                            <div><small class="text-uppercase fw-bold opacity-75">Role</small><br><strong id="modalRoleName">-</strong></div>
                            <div class="text-end"><small class="text-uppercase fw-bold opacity-75">Module</small><br><strong id="modalModuleName">-</strong></div>
                        </div>
                    </div>

                    <div class="row gy-2">
                        <?php foreach ($permissions as $key => $perm): ?>
                            <div class="col-12 permission-row rounded p-2 border">
                                <div class="form-check form-switch d-flex justify-content-between align-items-center m-0">
                                    <label class="form-check-label cursor-pointer" for="edit_<?= $key ?>">
                                        <i class="bi <?= $perm['icon'] ?> me-2 text-muted"></i> 
                                        <span class="fw-medium"><?= $perm['label'] ?></span>
                                        <small class="text-muted ms-2 d-none d-sm-inline">(<?= $perm['desc'] ?>)</small>
                                    </label>
                                    <input class="form-check-input mt-0" type="checkbox" role="switch" name="<?= $key ?>" id="edit_<?= $key ?>">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // 1. Script Highlight Search
    const filterInput = document.getElementById('filter');
    if (filterInput && filterInput.value) {
        const searchTerm = filterInput.value.toLowerCase();
        const rows = document.querySelectorAll('.table-gov tbody tr');
        rows.forEach(row => {
            if (row.textContent.toLowerCase().includes(searchTerm)) {
                row.style.backgroundColor = '#fef3c7'; 
                setTimeout(() => {
                    row.style.transition = 'background-color 1s ease';
                    row.style.backgroundColor = '';
                }, 2000);
            }
        });
    }

    // 2. Script Auto-Submit Sort
    document.getElementById('sort').addEventListener('change', function() {
        if (this.value) this.closest('form').submit();
    });

    // 3. Script untuk Modal Edit
    const editModal = document.getElementById('editAccessModal');
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            
            // Ambil data
            const id = button.getAttribute('data-id');
            const role = button.getAttribute('data-role');
            const moduleName = button.getAttribute('data-module');
            
            // Set Text
            document.getElementById('modalRoleName').textContent = role;
            document.getElementById('modalModuleName').textContent = moduleName;
            
            // Set Form Action
            const form = document.getElementById('formEditAccess');
            form.action = '/access_rights/update/' + id; 
            
            // Set Checkboxes
            const setCheck = (key) => {
                const val = button.getAttribute('data-' + key.replace('can_', ''));
                const checkbox = document.getElementById('edit_' + key);
                if(checkbox) checkbox.checked = (val == "1");
            };

            setCheck('can_create');
            setCheck('can_read');
            setCheck('can_update');
            setCheck('can_delete');
            setCheck('can_publish');
        });
    }
</script>
<?= $this->endSection() ?>