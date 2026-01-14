<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/pages/access_rights/index.css') ?>">
<style>
    /* Styling Custom Gov */
    .modal-header-gov { background-color: #f8f9fa; border-bottom: 1px solid #e9ecef; }
    .modal-title i { color: var(--primary-gov); }
    .header-actions { display: flex; gap: 10px; }
    .cursor-pointer { cursor: pointer; }
    
    /* Style untuk Single Toggle yang diminta Boss */
    .master-toggle-container {
        background-color: #eef2ff;
        border: 1px solid #c7d2fe;
        color: #3730a3;
        transition: all 0.3s ease;
    }
    
    .master-toggle-container:hover {
        background-color: #e0e7ff;
        border-color: #a5b4fc;
    }
    
    /* Style untuk role badge */
    .role-badge {
        font-size: 0.85rem;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-weight: 600;
    }
    
    .role-superadmin { background-color: #dc3545; color: white; }
    .role-admin { background-color: #0d6efd; color: white; }
    .role-editor { background-color: #198754; color: white; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
// KONFIGURASI KHUSUS (FILTER ROLE)
$allowedRoles = ['superadmin', 'admin', 'editor'];

// DEFINISI PERMISSION
$permissions = [
    'can_create'  => 'Create',
    'can_read'    => 'Read',
    'can_update'  => 'Update',
    'can_delete'  => 'Delete',
    'can_publish' => 'Publish'
];

// Filter data berdasarkan role yang diizinkan
$filteredAccessList = array_filter($accessList ?? [], function($item) use ($allowedRoles) {
    return in_array(strtolower($item['role']), $allowedRoles);
});
?>

<div class="container-fluid py-4">
    
    <div class="page-header-gov d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1">
                <i class="bi bi-shield-lock-fill"></i> <?= esc($title) ?>
            </h3>
            <p class="text-muted mb-0">Kelola hak akses untuk Admin, Editor, dan Superadmin</p>
        </div>
        <div class="header-actions">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAccessModal">
                <i class="bi bi-plus-lg me-2"></i>Tambah Akses
            </button>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card filter-card-gov mb-4">
        <div class="card-body">
            <form method="get" class="row g-3 align-items-end">
                <div class="col-lg-4 col-md-6">
                    <label for="filter" class="filter-label"><i class="bi bi-search"></i> Cari Module</label>
                    <input type="text" class="form-control" name="filter" id="filter" placeholder="Cari module..." value="<?= esc($filter ?? '') ?>">
                </div>
                <div class="col-lg-3 col-md-6">
                    <label for="roleFilter" class="filter-label"><i class="bi bi-person-badge"></i> Filter Role</label>
                    <select class="form-select" name="role" id="roleFilter">
                        <option value="">Semua Role</option>
                        <?php foreach($allowedRoles as $role): ?>
                            <option value="<?= $role ?>" <?= (isset($_GET['role']) && $_GET['role'] == $role) ? 'selected' : '' ?>>
                                <?= ucfirst($role) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-lg-2 col-md-6">
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-funnel me-1"></i> Cari</button>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="/access_rights" class="btn btn-outline-secondary w-100"><i class="bi bi-arrow-clockwise me-1"></i> Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card table-card-gov">
        <div class="table-card-header">
            <i class="bi bi-table"></i> <span>Ringkasan Hak Akses per Role</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 20%">Role</th>
                        <th style="width: 25%">Jumlah Module</th>
                        <th class="text-center" style="width: 30%">Status Permission</th>
                        <th class="text-center" style="width: 25%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Kelompokkan data berdasarkan role
                    $groupedByRole = [];
                    foreach ($filteredAccessList as $item) {
                        $groupedByRole[strtolower($item['role'])][] = $item;
                    }
                    
                    // Urutkan role: superadmin, admin, editor
                    $roleOrder = ['superadmin', 'admin', 'editor'];
                    ?>
                    
                    <?php foreach ($roleOrder as $currentRole): ?>
                        <?php if (isset($groupedByRole[$currentRole])): ?>
                            <?php 
                            // Ambil data pertama untuk role ini
                            $firstItem = $groupedByRole[$currentRole][0];
                            $totalModules = count($groupedByRole[$currentRole]);
                            
                            // Hitung total permission aktif untuk role ini
                            $totalActivePermissions = 0;
                            $totalPossiblePermissions = $totalModules * 5;
                            
                            foreach ($groupedByRole[$currentRole] as $item) {
                                foreach(['can_create', 'can_read', 'can_update', 'can_delete', 'can_publish'] as $perm) {
                                    if($item[$perm]) $totalActivePermissions++;
                                }
                            }
                            
                            $isFullAccess = ($totalActivePermissions == $totalPossiblePermissions);
                            ?>
                            <tr>
                                <td>
                                    <span class="role-badge role-<?= $currentRole ?>">
                                        <?= strtoupper($currentRole) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="badge bg-info text-dark px-3 py-2">
                                            <i class="bi bi-folder-fill me-1"></i> <?= $totalModules ?> Module
                                        </span>
                                    </div>
                                </td>
                                
                                <td class="text-center">
                                    <?php if($isFullAccess): ?>
                                        <span class="badge bg-success px-3 py-2">
                                            <i class="bi bi-check-all me-1"></i> Akses Penuh
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark px-3 py-2">
                                            <i class="bi bi-shield-check me-1"></i> <?= $totalActivePermissions ?>/<?= $totalPossiblePermissions ?> Permission
                                        </span>
                                    <?php endif; ?>
                                </td>
                                
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#moduleListModal"
                                            data-role="<?= $currentRole ?>"
                                            data-modules='<?= json_encode($groupedByRole[$currentRole]) ?>'>
                                        <i class="bi bi-eye"></i> Lihat Detail
                                    </button>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    
                    <?php if (empty($filteredAccessList)): ?>
                        <tr><td colspan="4" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Belum ada data hak akses.
                        </td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Akses -->
<div class="modal fade" id="addAccessModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-header-gov">
                <h5 class="modal-title"><i class="bi bi-plus-circle-fill me-2"></i>Tambah Akses Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="/access_rights/store" method="post">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="bi bi-person-badge me-1"></i> Role
                        </label>
                        <select class="form-select" name="role" required>
                            <option value="" selected disabled>-- Pilih Role --</option>
                            <?php foreach($allowedRoles as $role): ?>
                                <option value="<?= $role ?>"><?= ucfirst($role) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="bi bi-folder me-1"></i> Nama Module
                        </label>
                        <input type="text" class="form-control" name="module_name" placeholder="Contoh: surat_masuk" required>
                        <small class="text-muted">Gunakan huruf kecil dan underscore (_)</small>
                    </div>
                    
                    <div class="alert alert-info py-2 mb-0">
                        <small><i class="bi bi-info-circle me-1"></i> 
                            Secara default, akses penuh akan diberikan untuk module baru.
                        </small>
                    </div>
                    
                    <!-- Hidden inputs untuk default full access -->
                    <?php foreach ($permissions as $key => $label): ?>
                        <input type="hidden" name="<?= $key ?>" value="on">
                    <?php endforeach; ?>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-check-lg me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Daftar Module per Role -->
<div class="modal fade" id="moduleListModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header modal-header-gov">
                <h5 class="modal-title">
                    <i class="bi bi-folder-fill me-2"></i>Daftar Module - <span id="moduleModalRole" class="text-uppercase fw-bold">-</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%">#</th>
                                <th style="width: 35%">Module</th>
                                <th class="text-center" style="width: 30%">Status</th>
                                <th class="text-center" style="width: 30%">Akses Penuh</th>
                            </tr>
                        </thead>
                        <tbody id="moduleTableBody">
                            <!-- Akan diisi oleh JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Akses -->
<div class="modal fade" id="editAccessModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-header-gov">
                <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Hak Akses</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <form id="formEditAccess" action="" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">
                
                <div class="modal-body p-4">
                    <!-- Header Info -->
                    <div class="text-center mb-4 pb-3 border-bottom">
                        <span id="modalRoleBadge" class="role-badge mb-2 d-inline-block">-</span>
                        <p class="text-muted mb-0">
                            <small>Module:</small> 
                            <code id="modalModuleName" class="bg-light px-2 py-1 rounded">-</code>
                        </p>
                    </div>

                    <!-- Single Master Toggle -->
                    <div class="master-toggle-container p-3 rounded mb-3 cursor-pointer" onclick="document.getElementById('masterToggle').click()">
                        <div class="text-center">
                            <div class="form-check form-switch d-inline-block">
                                <input class="form-check-input" type="checkbox" id="masterToggle" style="transform: scale(1.5);">
                                <label class="form-check-label fw-bold ms-2" for="masterToggle" style="font-size: 1.15em;">
                                    <i class="bi bi-shield-fill-check me-1"></i> Berikan Akses Penuh
                                </label>
                            </div>
                            <div class="text-muted small mt-2">
                                Aktifkan untuk memberikan seluruh izin:<br>
                                <span class="badge bg-primary bg-opacity-10 text-primary mx-1">Create</span>
                                <span class="badge bg-primary bg-opacity-10 text-primary mx-1">Read</span>
                                <span class="badge bg-primary bg-opacity-10 text-primary mx-1">Update</span>
                                <span class="badge bg-primary bg-opacity-10 text-primary mx-1">Delete</span>
                                <span class="badge bg-primary bg-opacity-10 text-primary mx-1">Publish</span>
                            </div>
                        </div>
                    </div>

                    <!-- Info tambahan -->
                    <div class="alert alert-light border mb-0">
                        <small class="text-muted">
                            <i class="bi bi-lightbulb me-1"></i> 
                            Toggle ini mengontrol semua permission sekaligus untuk menjaga konsistensi akses.
                        </small>
                    </div>

                    <!-- Hidden Checkboxes untuk Submit -->
                    <div class="d-none">
                        <?php foreach ($permissions as $key => $label): ?>
                            <input type="checkbox" name="<?= $key ?>" id="edit_<?= $key ?>">
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Script untuk Modal Daftar Module
    const moduleListModal = document.getElementById('moduleListModal');
    
    if (moduleListModal) {
        moduleListModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const role = button.getAttribute('data-role');
            const modules = JSON.parse(button.getAttribute('data-modules'));
            
            // Set role name
            document.getElementById('moduleModalRole').textContent = role;
            
            // Urutkan module berdasarkan nama (A-Z)
            modules.sort((a, b) => {
                return a.module_name.localeCompare(b.module_name);
            });
            
            // Build table rows
            const tbody = document.getElementById('moduleTableBody');
            tbody.innerHTML = '';
            
            modules.forEach((module, index) => {
                const isFullAccess = (
                    module.can_create == 1 && 
                    module.can_read == 1 && 
                    module.can_update == 1 && 
                    module.can_delete == 1 && 
                    module.can_publish == 1
                );
                
                let activeCount = 0;
                ['can_create', 'can_read', 'can_update', 'can_delete', 'can_publish'].forEach(perm => {
                    if(module[perm] == 1) activeCount++;
                });
                
                let statusBadge = '';
                if (isFullAccess) {
                    statusBadge = '<span class="badge bg-success"><i class="bi bi-check-all me-1"></i> Akses Penuh</span>';
                } else if (activeCount > 0) {
                    statusBadge = '<span class="badge bg-warning text-dark"><i class="bi bi-shield-check me-1"></i> Terbatas (' + activeCount + '/5)</span>';
                } else {
                    statusBadge = '<span class="badge bg-secondary"><i class="bi bi-x-circle me-1"></i> Tidak Ada Akses</span>';
                }
                
                const row = `
                    <tr>
                        <td class="text-center">${index + 1}</td>
                        <td>
                            <code class="text-dark bg-light px-2 py-1 rounded border">${module.module_name}</code>
                        </td>
                        <td class="text-center">${statusBadge}</td>
                        <td class="text-center">
                            <div class="form-check form-switch d-inline-block">
                                <input class="form-check-input module-toggle" 
                                       type="checkbox" 
                                       id="toggle_${module.id_access}"
                                       data-id="${module.id_access}"
                                       data-role="${module.role}"
                                       data-module="${module.module_name}"
                                       style="transform: scale(1.3);"
                                       ${isFullAccess ? 'checked' : ''}>
                                <label class="form-check-label ms-2" for="toggle_${module.id_access}">
                                    ${isFullAccess ? 'Aktif' : 'Nonaktif'}
                                </label>
                            </div>
                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
            
            // Tambahkan event listener untuk setiap toggle
            setTimeout(() => {
                document.querySelectorAll('.module-toggle').forEach(toggle => {
                    toggle.addEventListener('change', function() {
                        handleToggleChange(this);
                    });
                });
            }, 100);
        });
    }

    // Fungsi untuk handle perubahan toggle
    function handleToggleChange(toggleElement) {
        const id = toggleElement.getAttribute('data-id');
        const role = toggleElement.getAttribute('data-role');
        const moduleName = toggleElement.getAttribute('data-module');
        const isChecked = toggleElement.checked;
        
        // Update label
        const label = toggleElement.nextElementSibling;
        label.textContent = isChecked ? 'Aktif' : 'Nonaktif';
        
        // Kirim request untuk update
        updatePermission(id, isChecked);
    }

    // Fungsi untuk update permission via AJAX
    function updatePermission(id, isFullAccess) {
        // Buat FormData
        const formData = new FormData();
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
        formData.append('_method', 'PUT');
        
        // Set semua permission sesuai toggle
        ['can_create', 'can_read', 'can_update', 'can_delete', 'can_publish'].forEach(perm => {
            if (isFullAccess) {
                formData.append(perm, 'on');
            }
        });
        
        // Kirim request
        fetch('/access_rights/update/' + id, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            // Cek apakah response sukses
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            
            // Cek content-type
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                return response.json();
            } else {
                // Jika bukan JSON, kemungkinan redirect atau HTML error
                // Anggap sukses jika status 200-299
                if (response.status >= 200 && response.status < 300) {
                    return { success: true };
                } else {
                    throw new Error('Server returned non-JSON response');
                }
            }
        })
        .then(data => {
            if (data.success || data.success === undefined) {
                // Show success notification
                showNotification('success', 'Permission berhasil diupdate!');
                
                // Update status badge di table
                updateStatusBadge(id, isFullAccess);
                
                // Reload halaman setelah 1 detik untuk refresh data
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                showNotification('error', data.message || 'Gagal mengupdate permission!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'Terjadi kesalahan saat mengupdate!');
            
            // Kembalikan toggle ke posisi semula
            const toggle = document.getElementById('toggle_' + id);
            if (toggle) {
                toggle.checked = !toggle.checked;
                const label = toggle.nextElementSibling;
                label.textContent = toggle.checked ? 'Aktif' : 'Nonaktif';
            }
        });
    }

    // Fungsi untuk update status badge di table
    function updateStatusBadge(id, isFullAccess) {
        const toggle = document.getElementById('toggle_' + id);
        if (toggle) {
            const row = toggle.closest('tr');
            const statusCell = row.children[2];
            
            if (isFullAccess) {
                statusCell.innerHTML = '<span class="badge bg-success"><i class="bi bi-check-all me-1"></i> Akses Penuh</span>';
            } else {
                statusCell.innerHTML = '<span class="badge bg-secondary"><i class="bi bi-x-circle me-1"></i> Tidak Ada Akses</span>';
            }
        }
    }

    // Fungsi untuk show notification
    function showNotification(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const icon = type === 'success' ? 'check-circle-fill' : 'exclamation-triangle-fill';
        
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert ${alertClass} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3`;
        alertDiv.style.zIndex = '9999';
        alertDiv.style.minWidth = '300px';
        alertDiv.innerHTML = `
            <i class="bi bi-${icon} me-2"></i> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(alertDiv);
        
        setTimeout(() => {
            alertDiv.remove();
        }, 3000);
    }

    // Script Logic untuk Single Toggle di Modal Edit (tetap ada untuk backup jika diperlukan)
    const editModal = document.getElementById('editAccessModal');
    
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            
            // Tutup modal module list jika ada
            if (button.getAttribute('data-dismiss-module-modal') === 'true') {
                const moduleModal = bootstrap.Modal.getInstance(moduleListModal);
                if (moduleModal) moduleModal.hide();
            }
            
            // Ambil Data dari Button
            const id = button.getAttribute('data-id');
            const role = button.getAttribute('data-role');
            const moduleName = button.getAttribute('data-module');
            
            // Data Permission (0 atau 1)
            const permissions = {
                create: button.getAttribute('data-create'),
                read:   button.getAttribute('data-read'),
                update: button.getAttribute('data-update'),
                delete: button.getAttribute('data-delete'),
                publish: button.getAttribute('data-publish')
            };

            // Update UI Modal
            const roleBadge = document.getElementById('modalRoleBadge');
            roleBadge.textContent = role.toUpperCase();
            roleBadge.className = 'role-badge role-' + role.toLowerCase() + ' mb-2 d-inline-block';
            
            document.getElementById('modalModuleName').textContent = moduleName;
            document.getElementById('formEditAccess').action = '/access_rights/update/' + id;
            
            // LOGIKA MASTER TOGGLE:
            // Jika semua permission bernilai 1, maka Master Toggle ON
            // Jika ada satu saja yang 0, maka Master Toggle OFF
            const isFullAccess = (
                permissions.create == 1 && 
                permissions.read == 1 && 
                permissions.update == 1 && 
                permissions.delete == 1 && 
                permissions.publish == 1
            );
            
            const masterToggle = document.getElementById('masterToggle');
            masterToggle.checked = isFullAccess;

            // Sinkronisasi checkbox tersembunyi sesuai status master toggle
            syncHiddenCheckboxes(isFullAccess);
        });
    }

    // Event Listener: Saat Master Toggle diubah oleh User
    document.getElementById('masterToggle').addEventListener('change', function() {
        syncHiddenCheckboxes(this.checked);
    });

    /**
     * Fungsi untuk menyinkronkan semua checkbox permission tersembunyi
     * dengan status Master Toggle
     */
    function syncHiddenCheckboxes(isChecked) {
        const permissionKeys = ['can_create', 'can_read', 'can_update', 'can_delete', 'can_publish'];
        
        permissionKeys.forEach(key => {
            const checkbox = document.getElementById('edit_' + key);
            if (checkbox) {
                checkbox.checked = isChecked;
            }
        });
    }

    // Auto-dismiss alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert-dismissible');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    });
</script>
<?= $this->endSection() ?>