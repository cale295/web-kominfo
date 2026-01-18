<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<style>
    :root {
        --primary-soft: #eef2ff;
        --primary-text: #4f46e5;
        --success-soft: #ecfdf5;
        --success-text: #059669;
        --danger-soft: #fef2f2;
        --danger-text: #dc2626;
        --warning-soft: #fffbeb;
        --warning-text: #d97706;
        --info-soft: #eff6ff;
        --info-text: #3b82f6;
    }

    /* Gradient Title */
    .text-gradient {
        background: linear-gradient(45deg, #4e73df, #224abe);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Modern Card */
    .card-modern {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease;
    }

    /* Soft Badges & Buttons */
    .btn-soft-primary { background-color: var(--primary-soft); color: var(--primary-text); border: none; }
    .btn-soft-primary:hover { background-color: #4f46e5; color: white; }
    
    .btn-soft-danger { background-color: var(--danger-soft); color: var(--danger-text); border: none; }
    .btn-soft-danger:hover { background-color: #dc2626; color: white; }
    
    .btn-soft-warning { background-color: var(--warning-soft); color: var(--warning-text); border: none; }
    .btn-soft-warning:hover { background-color: #d97706; color: white; }
    
    .btn-soft-success { background-color: var(--success-soft); color: var(--success-text); border: none; }
    .btn-soft-success:hover { background-color: #059669; color: white; }
    
    .btn-soft-info { background-color: var(--info-soft); color: var(--info-text); border: none; }
    .btn-soft-info:hover { background-color: #3b82f6; color: white; }

    /* Table Styling */
    .table thead th {
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        color: #6b7280;
        border-bottom: 2px solid #f3f4f6;
        text-transform: uppercase;
        background-color: #f9fafb;
    }
    .table tbody tr td {
        vertical-align: middle;
        padding: 1rem 0.75rem;
    }
    .table-hover tbody tr:hover {
        background-color: #f8fafc;
    }

    /* Badge Styling */
    .badge-custom {
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 600;
        border-radius: 10px;
    }
    
    /* Role Badges */
    .role-badge {
        font-size: 0.85rem;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-weight: 600;
    }
    .role-superadmin { background-color: #dc2626; color: white; }
    .role-admin { background-color: #0d6efd; color: white; }
    .role-editor { background-color: #059669; color: white; }

    /* Master Toggle */
    .master-toggle-container {
        background-color: var(--primary-soft);
        border: 1px solid #c7d2fe;
        color: var(--primary-text);
        transition: all 0.3s ease;
        border-radius: 12px;
        cursor: pointer;
    }
    
    .master-toggle-container:hover {
        background-color: #e0e7ff;
        border-color: #a5b4fc;
    }

    /* Filter Card */
    .filter-card {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border: 1px solid #e2e8f0;
        border-radius: 12px;
    }

    /* Module Badge */
    .module-badge {
        background-color: #f3f4f6;
        color: #374151;
        font-weight: 600;
        padding: 0.35rem 0.75rem;
        border-radius: 6px;
        font-family: 'SF Mono', 'Monaco', 'Inconsolata', 'Fira Code', monospace;
        font-size: 0.8rem;
    }

    /* Button Action */
    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all 0.2s;
    }
    
    /* Hover Scale */
    .hover-scale { 
        transition: transform 0.2s; 
    }
    .hover-scale:hover { 
        transform: scale(1.05); 
    }
</style>

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

<div class="container-fluid px-4 pb-5">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between my-4 py-2">
        <div class="mb-3 mb-md-0">
            <h1 class="h3 fw-bolder mb-1 text-gradient">Hak Akses</h1>
            <p class="text-muted small mb-0">
                <i class="fas fa-shield-alt me-1 text-primary"></i> 
                Kelola hak akses untuk Admin, Editor, dan Superadmin
            </p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded-pill shadow-sm mb-0 border">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none fw-bold text-primary small"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active small" aria-current="page">Hak Akses</li>
            </ol>
        </nav>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success border-0 shadow-sm border-start border-4 border-success rounded-3 fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center bg-white text-success me-3 shadow-sm rounded-circle" style="width: 32px; height: 32px;">
                    <i class="fas fa-check"></i>
                </div>
                <div class="fw-medium">
                    <?= session()->getFlashdata('success') ?>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger border-0 shadow-sm border-start border-4 border-danger rounded-3 fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center bg-white text-danger me-3 shadow-sm rounded-circle" style="width: 32px; height: 32px;">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="fw-medium">
                    <?= session()->getFlashdata('error') ?>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Filter Card -->
    <div class="card card-modern mb-4">
        <div class="card-body">
            <form method="get" class="row g-3 align-items-end">
                <div class="col-lg-4 col-md-6">
                    <label for="filter" class="form-label fw-semibold small mb-1">
                        <i class="fas fa-search me-1 text-primary"></i> Cari Module
                    </label>
                    <input type="text" class="form-control rounded-pill" name="filter" id="filter" placeholder="Cari module..." value="<?= esc($filter ?? '') ?>">
                </div>
                <div class="col-lg-3 col-md-6">
                    <label for="roleFilter" class="form-label fw-semibold small mb-1">
                        <i class="fas fa-user-tag me-1 text-primary"></i> Filter Role
                    </label>
                    <select class="form-select rounded-pill" name="role" id="roleFilter">
                        <option value="">Semua Role</option>
                        <?php foreach($allowedRoles as $role): ?>
                            <option value="<?= $role ?>" <?= (isset($_GET['role']) && $_GET['role'] == $role) ? 'selected' : '' ?>>
                                <?= ucfirst($role) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-lg-2 col-md-6">
                    <button type="submit" class="btn btn-primary rounded-pill shadow-sm w-100 hover-scale">
                        <i class="fas fa-filter me-1"></i> Cari
                    </button>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="/access_rights" class="btn btn-outline-secondary rounded-pill w-100 shadow-sm hover-scale">
                        <i class="fas fa-redo me-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="card card-modern">
        <div class="card-header bg-white py-4 border-0 d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold text-dark mb-0">Ringkasan Hak Akses per Role</h5>
                <span class="text-muted small">Detail module dan permission berdasarkan role</span>
            </div>
            
            <button type="button" 
                    class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold mt-3 mt-md-0 hover-scale" 
                    data-bs-toggle="modal" 
                    data-bs-target="#addAccessModal">
                <i class="fas fa-plus-circle me-2"></i>Tambah Akses
            </button>
        </div>

        <div class="card-body p-0">
            <?php if (empty($filteredAccessList)): ?>
                <div class="text-center py-5">
                    <div class="py-4">
                        <div class="mb-3 opacity-25">
                            <i class="fas fa-shield-alt fa-4x text-secondary"></i>
                        </div>
                        <h6 class="fw-bold text-secondary">Belum ada data hak akses</h6>
                        <p class="small text-muted mb-0">Silakan tambahkan hak akses baru untuk module.</p>
                        <button type="button" 
                                class="btn btn-primary rounded-pill px-4 mt-3 shadow-sm hover-scale" 
                                data-bs-toggle="modal" 
                                data-bs-target="#addAccessModal">
                            <i class="fas fa-plus me-1"></i>Tambah Akses
                        </button>
                    </div>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="dataTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="py-3" width="20%">Role</th>
                                <th class="py-3" width="25%">Jumlah Module</th>
                                <th class="text-center py-3" width="30%">Status Permission</th>
                                <th class="text-center py-3" width="25%">Aksi</th>
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
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-light text-dark border shadow-sm px-3 py-2 rounded-pill font-monospace">
                                                    <i class="fas fa-folder me-1"></i> <?= $totalModules ?> Module
                                                </span>
                                            </div>
                                        </td>
                                        
                                        <td class="text-center">
                                            <?php if($isFullAccess): ?>
                                                <span class="badge bg-success-soft text-success px-3 py-2 rounded-pill">
                                                    <i class="fas fa-check-circle me-1"></i> Akses Penuh
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-warning-soft text-warning px-3 py-2 rounded-pill">
                                                    <i class="fas fa-shield-check me-1"></i> <?= $totalActivePermissions ?>/<?= $totalPossiblePermissions ?> Permission
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        
                                        <td class="text-center">
                                            <button type="button" 
                                                    class="btn btn-soft-primary rounded-pill px-3 hover-scale"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#moduleListModal"
                                                    data-role="<?= $currentRole ?>"
                                                    data-modules='<?= json_encode($groupedByRole[$currentRole]) ?>'>
                                                <i class="fas fa-eye me-1"></i> Lihat Detail
                                            </button>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="card-footer bg-white border-top-0 py-3">
            <div class="d-flex align-items-center text-muted small">
                <i class="fas fa-info-circle me-2 text-primary"></i>
                <span>Hak akses mengatur permission untuk role Superadmin, Admin, dan Editor.</span>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Akses -->
<div class="modal fade" id="addAccessModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content card-modern border-0">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Akses Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="/access_rights/store" method="post">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-user-tag me-1"></i> Role
                        </label>
                        <select class="form-control rounded-pill" name="role" required>
                            <option value="" selected disabled>-- Pilih Role --</option>
                            <?php foreach($allowedRoles as $role): ?>
                                <option value="<?= $role ?>"><?= ucfirst($role) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-folder me-1"></i> Nama Module
                        </label>
                        <input type="text" class="form-control rounded-pill" name="module_name" placeholder="Contoh: surat_masuk" required>
                        <div class="form-text small">Gunakan huruf kecil dan underscore (_)</div>
                    </div>
                    
                    <div class="alert alert-light border rounded-3 py-2 mb-0">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1 text-primary"></i> 
                            Secara default, akses penuh akan diberikan untuk module baru.
                        </small>
                    </div>
                    
                    <!-- Hidden inputs untuk default full access -->
                    <?php foreach ($permissions as $key => $label): ?>
                        <input type="hidden" name="<?= $key ?>" value="on">
                    <?php endforeach; ?>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                        <i class="fas fa-check me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Daftar Module per Role -->
<div class="modal fade" id="moduleListModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content card-modern border-0">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-folder me-2"></i>Daftar Module - 
                    <span id="moduleModalRole" class="text-uppercase fw-bold">-</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="py-3" width="5%">#</th>
                                <th class="py-3" width="35%">Module</th>
                                <th class="text-center py-3" width="30%">Status</th>
                                <th class="text-center py-3" width="30%">Akses Penuh</th>
                            </tr>
                        </thead>
                        <tbody id="moduleTableBody">
                            <!-- Akan diisi oleh JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="modal-footer bg-light border-0">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Akses -->
<div class="modal fade" id="editAccessModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content card-modern border-0">
            <div class="modal-header bg-warning text-white border-0">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-edit me-2"></i>Edit Hak Akses
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
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
                            <code id="modalModuleName" class="module-badge">-</code>
                        </p>
                    </div>

                    <!-- Single Master Toggle -->
                    <div class="master-toggle-container p-3 rounded mb-3" onclick="document.getElementById('masterToggle').click()">
                        <div class="text-center">
                            <div class="form-check form-switch d-inline-block">
                                <input class="form-check-input" type="checkbox" id="masterToggle" style="transform: scale(1.5);">
                                <label class="form-check-label fw-bold ms-2" for="masterToggle" style="font-size: 1.15em;">
                                    <i class="fas fa-shield-check me-1"></i> Berikan Akses Penuh
                                </label>
                            </div>
                            <div class="text-muted small mt-2">
                                Aktifkan untuk memberikan seluruh izin:
                                <div class="mt-1">
                                    <span class="badge bg-light text-primary border mx-1">Create</span>
                                    <span class="badge bg-light text-primary border mx-1">Read</span>
                                    <span class="badge bg-light text-primary border mx-1">Update</span>
                                    <span class="badge bg-light text-primary border mx-1">Delete</span>
                                    <span class="badge bg-light text-primary border mx-1">Publish</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Info tambahan -->
                    <div class="alert alert-light border rounded-3 mb-0">
                        <small class="text-muted">
                            <i class="fas fa-lightbulb me-1"></i> 
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
                
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-warning rounded-pill px-4 shadow-sm">
                        <i class="fas fa-check me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Init Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

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
                        statusBadge = '<span class="badge bg-success-soft text-success px-3 py-2 rounded-pill"><i class="fas fa-check-circle me-1"></i> Akses Penuh</span>';
                    } else if (activeCount > 0) {
                        statusBadge = '<span class="badge bg-warning-soft text-warning px-3 py-2 rounded-pill"><i class="fas fa-shield-check me-1"></i> Terbatas (' + activeCount + '/5)</span>';
                    } else {
                        statusBadge = '<span class="badge bg-light text-secondary border px-3 py-2 rounded-pill"><i class="fas fa-times-circle me-1"></i> Tidak Ada Akses</span>';
                    }
                    
                    const row = `
                        <tr>
                            <td class="text-center fw-bold text-muted">${index + 1}</td>
                            <td>
                                <code class="module-badge">${module.module_name}</code>
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
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('success', 'Permission berhasil diupdate!');
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
            });
        }

        // Fungsi untuk show notification
        function showNotification(type, message) {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const icon = type === 'success' ? 'check-circle' : 'exclamation-triangle';
            
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert ${alertClass} border-0 shadow-sm border-start border-4 ${type === 'success' ? 'border-success' : 'border-danger'} rounded-3 position-fixed top-0 start-50 translate-middle-x mt-3`;
            alertDiv.style.zIndex = '9999';
            alertDiv.style.minWidth = '300px';
            alertDiv.innerHTML = `
                <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center justify-content-center bg-white ${type === 'success' ? 'text-success' : 'text-danger'} me-3 shadow-sm rounded-circle" style="width: 32px; height: 32px;">
                        <i class="fas fa-${icon}"></i>
                    </div>
                    <div class="fw-medium">${message}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            `;
            
            document.body.appendChild(alertDiv);
            
            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
        }

        // Script Logic untuk Single Toggle di Modal Edit
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
        const masterToggle = document.getElementById('masterToggle');
        if (masterToggle) {
            masterToggle.addEventListener('change', function() {
                syncHiddenCheckboxes(this.checked);
            });
        }

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
    });
</script>
<?= $this->endSection() ?>