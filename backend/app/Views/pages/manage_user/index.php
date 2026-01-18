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

    /* Stats Cards */
    .stats-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border: none;
        transition: transform 0.2s;
    }
    .stats-card:hover {
        transform: translateY(-2px);
    }
    .stats-card-primary { border-left: 4px solid var(--primary-text); }
    .stats-card-danger { border-left: 4px solid var(--danger-text); }
    .stats-card-info { border-left: 4px solid var(--info-text); }
    .stats-card-success { border-left: 4px solid var(--success-text); }
    
    .stats-number {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
        line-height: 1.2;
    }
    .stats-label {
        font-size: 0.875rem;
        color: #6b7280;
        margin-bottom: 0.5rem;
    }
    .stats-icon {
        font-size: 2rem;
        opacity: 0.7;
        text-align: right;
    }

    /* Role Badges */
    .role-badge {
        padding: 0.35rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .role-superadmin { background-color: var(--danger-soft); color: var(--danger-text); }
    .role-admin { background-color: var(--info-soft); color: var(--info-text); }
    .role-editor { background-color: var(--success-soft); color: var(--success-text); }

    /* Button Action */
    .btn-action {
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 500;
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

    /* Form Controls */
    .form-control-modern:focus {
        border-color: var(--primary-text);
        box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
    }

    /* Modal Styling */
    .modal-content {
        border-radius: 1rem;
        border: none;
    }
    .modal-header.bg-primary {
        border-top-left-radius: 1rem;
        border-top-right-radius: 1rem;
    }
    .modal-header.bg-warning {
        border-top-left-radius: 1rem;
        border-top-right-radius: 1rem;
    }

    /* Detail Preview */
    .detail-label {
        font-weight: 600;
        color: #6b7280;
        font-size: 0.85rem;
        margin-bottom: 0.2rem;
    }
    .detail-value {
        font-weight: 500;
        color: #1f2937;
        background-color: #f9fafb;
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        font-size: 0.9rem;
    }
</style>

<div class="container-fluid px-4 pb-5">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between my-4 py-2">
        <div class="mb-3 mb-md-0">
            <h1 class="h3 fw-bolder mb-1 text-gradient">Manajemen Pengguna</h1>
            <p class="text-muted small mb-0">
                <i class="fas fa-users-cog me-1 text-primary"></i> 
                Kelola data pengguna dan hak akses sistem informasi.
            </p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded-pill shadow-sm mb-0 border">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none fw-bold text-primary small"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active small" aria-current="page">Pengguna</li>
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

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-lg-6">
            <div class="stats-card stats-card-primary">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stats-label">Total Pengguna</div>
                        <div class="stats-number"><?= $totalUsers ?></div>
                    </div>
                    <div class="stats-icon text-primary">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="stats-card stats-card-danger">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stats-label">Super Admin</div>
                        <div class="stats-number"><?= $superadmin ?></div>
                    </div>
                    <div class="stats-icon text-danger">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="stats-card stats-card-info">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stats-label">Administrator</div>
                        <div class="stats-number"><?= $admin ?></div>
                    </div>
                    <div class="stats-icon text-info">
                        <i class="fas fa-user-tie"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="stats-card stats-card-success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stats-label">Editor</div>
                        <div class="stats-number"><?= $editor ?></div>
                    </div>
                    <div class="stats-icon text-success">
                        <i class="fas fa-edit"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card card-modern mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-semibold small">
                        <i class="fas fa-filter me-1"></i> Filter Role
                    </label>
                    <select id="roleFilter" class="form-control form-control-modern">
                        <option value="">Semua Role</option>
                        <option value="superadmin">Super Admin</option>
                        <option value="admin">Admin</option>
                        <option value="editor">Editor</option>
                    </select>
                </div>

                <div class="col-lg-4 col-md-6">
                    <label class="form-label fw-semibold small">
                        <i class="fas fa-search me-1"></i> Pencarian
                    </label>
                    <input type="text" id="searchInput" class="form-control form-control-modern" 
                           placeholder="Cari nama, username, atau email...">
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label fw-semibold small">
                        <i class="fas fa-list me-1"></i> Tampilkan
                    </label>
                    <select id="limitSelect" class="form-control form-control-modern">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>

                <div class="col-lg-3 col-md-6">
                    <button type="button" 
                            class="btn btn-primary rounded-pill px-4 w-100 hover-scale shadow-sm"
                            data-bs-toggle="modal" 
                            data-bs-target="#createUserModal">
                        <i class="fas fa-plus-circle me-2"></i>
                        Tambah Pengguna Baru
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="card card-modern">
        <div class="card-header bg-white py-4 border-0 d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold text-dark mb-0">Daftar Pengguna</h5>
                <span class="text-muted small">Pengguna dengan akses ke sistem</span>
            </div>
        </div>

        <div class="card-body p-0">
            <?php if (empty($users)): ?>
                <div class="text-center py-5">
                    <div class="py-4">
                        <div class="mb-3 opacity-25">
                            <i class="fas fa-users-slash fa-4x text-secondary"></i>
                        </div>
                        <h6 class="fw-bold text-secondary">Belum ada data pengguna</h6>
                        <p class="small text-muted mb-0">Silakan tambahkan pengguna baru untuk memulai.</p>
                    </div>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="usersTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center py-3" width="5%">No</th>
                                <th class="py-3" width="25%">Nama Lengkap</th>
                                <th class="py-3" width="15%">Username</th>
                                <th class="py-3" width="20%">Email</th>
                                <th class="text-center py-3" width="12%">Role</th>
                                <th class="text-center py-3" width="23%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $index => $user): ?>
                                <tr>
                                    <td class="text-center fw-bold text-muted"><?= $index + 1 ?></td>
                                    
                                    <td>
                                        <div class="fw-bold text-dark"><?= esc($user['full_name']) ?></div>
                                    </td>
                                    
                                    <td>
                                        <div class="text-muted">
                                            <i class="fas fa-user-circle me-1"></i> 
                                            <?= esc($user['username']) ?>
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <div class="small text-muted">
                                            <i class="fas fa-envelope me-1"></i> 
                                            <?= esc($user['email']) ?>
                                        </div>
                                    </td>
                                    
                                    <td class="text-center">
                                        <?php
                                        $roleClass = 'role-editor';
                                        $roleLower = strtolower($user['role']);
                                        if (strpos($roleLower, 'super') !== false) $roleClass = 'role-superadmin';
                                        elseif (strpos($roleLower, 'admin') !== false) $roleClass = 'role-admin';
                                        ?>
                                        <span class="role-badge <?= $roleClass ?>">
                                            <?= esc($user['role']) ?>
                                        </span>
                                    </td>
                                    
                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <button type="button" 
                                                    class="btn-action btn-soft-primary hover-scale btn-detail-trigger"
                                                    title="Lihat Detail"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#detailUserModal"
                                                    data-user="<?= htmlspecialchars(json_encode($user)) ?>">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            <button type="button" 
                                                    class="btn-action btn-soft-warning hover-scale btn-edit-trigger"
                                                    title="Edit User"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editUserModal"
                                                    data-user="<?= htmlspecialchars(json_encode($user)) ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            
                                            <form action="<?= site_url('manage_user/'.$user['id_user']) ?>" method="post" class="d-inline delete-form">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" 
                                                        class="btn-action btn-soft-danger hover-scale"
                                                        onclick="return confirm('Yakin ingin hapus?')"
                                                        title="Hapus User">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="card-footer bg-white border-top-0 py-3">
            <div class="d-flex align-items-center text-muted small">
                <i class="fas fa-info-circle me-2 text-primary"></i>
                <span>Super Admin memiliki akses penuh, Admin dapat mengelola konten, Editor hanya bisa mengedit konten.</span>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create User -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content card-modern">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title fw-bold" id="createUserModalLabel">
                    <i class="fas fa-user-plus me-2"></i>Tambah Pengguna Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <?php if (session()->getFlashdata('errors')) : ?>
                    <div class="alert alert-danger border-0 border-start border-4 border-danger rounded-3 small py-2 mb-4">
                        <div class="d-flex align-items-center">
                            <div class="d-flex align-items-center justify-content-center bg-white text-danger me-3 rounded-circle" style="width: 24px; height: 24px;">
                                <i class="fas fa-exclamation"></i>
                            </div>
                            <div>
                                <strong>Periksa kesalahan:</strong>
                                <ul class="mb-0 ps-3 mt-1">
                                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('manage_user') ?>" method="post" id="userForm" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-user me-1"></i> Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="full_name" id="full_name" 
                                   class="form-control form-control-modern" 
                                   value="<?= old('full_name') ?>" 
                                   placeholder="Nama lengkap" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-at me-1"></i> Username <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="username" id="username" 
                                   class="form-control form-control-modern" 
                                   value="<?= old('username') ?>" 
                                   placeholder="username123" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-envelope me-1"></i> Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" name="email" id="email" 
                                   class="form-control form-control-modern" 
                                   value="<?= old('email') ?>" 
                                   placeholder="email@example.com" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-key me-1"></i> Password <span class="text-danger">*</span>
                            </label>
                            <input type="password" name="password" id="password" 
                                   class="form-control form-control-modern" 
                                   placeholder="Min. 8 karakter" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-shield-alt me-1"></i> Role <span class="text-danger">*</span>
                            </label>
                            <select name="role" id="role" class="form-control form-control-modern" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="superadmin">Super Admin</option>
                                <option value="admin">Admin</option>
                                <option value="editor">Editor</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer bg-light border-0 px-0 pb-0">
                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit User -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content card-modern">
            <div class="modal-header bg-warning text-white border-0">
                <h5 class="modal-title fw-bold" id="editUserModalLabel">
                    <i class="fas fa-user-edit me-2"></i>Edit Data Pengguna
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="" method="post" id="editUserForm" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-user me-1"></i> Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="full_name" id="edit_full_name" 
                                   class="form-control form-control-modern" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-at me-1"></i> Username <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="username" id="edit_username" 
                                   class="form-control form-control-modern" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-envelope me-1"></i> Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" name="email" id="edit_email" 
                                   class="form-control form-control-modern" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-key me-1"></i> Password Baru
                            </label>
                            <input type="password" name="password" id="edit_password" 
                                   class="form-control form-control-modern" 
                                   placeholder="Kosongkan jika tidak berubah">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-shield-alt me-1"></i> Role <span class="text-danger">*</span>
                            </label>
                            <select name="role" id="edit_role" class="form-control form-control-modern" required>
                                <option value="superadmin">Super Admin</option>
                                <option value="admin">Admin</option>
                                <option value="editor">Editor</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer bg-light border-0 px-0 pb-0">
                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-warning rounded-pill px-4 shadow-sm">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail User -->
<div class="modal fade" id="detailUserModal" tabindex="-1" aria-labelledby="detailUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content card-modern">
            <div class="modal-header bg-light border-0">
                <h5 class="modal-title fw-bold" id="detailUserModalLabel">
                    <i class="fas fa-user-circle me-2"></i>Detail Data Pengguna
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-4 text-center border-end">
                        <div class="mb-3 mt-2">
                            <div class="avatar-placeholder rounded-circle mx-auto d-flex align-items-center justify-content-center bg-primary-soft text-primary" 
                                 style="width: 120px; height: 120px; font-size: 2.5rem;">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        <h5 class="fw-bold mb-1" id="detail_full_name_display">-</h5>
                        <p class="text-muted mb-2" id="detail_role_display">-</p>
                    </div>

                    <div class="col-md-8">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="detail-label">Username</div>
                                <div class="detail-value" id="detail_username">-</div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="detail-label">Role Akses</div>
                                <div class="detail-value" id="detail_role">-</div>
                            </div>

                            <div class="col-12">
                                <div class="detail-label">Email</div>
                                <div class="detail-value" id="detail_email">-</div>
                            </div>
                        </div>
                    </div>
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Tooltip Initialization
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Edit User Modal Logic
        const editButtons = document.querySelectorAll('.btn-edit-trigger');
        const editForm = document.getElementById('editUserForm');
        
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const userData = JSON.parse(this.getAttribute('data-user'));
                
                // Set Action URL
                editForm.action = "<?= base_url('manage_user') ?>/" + userData.id_user;
                
                // Fill Fields
                document.getElementById('edit_full_name').value = userData.full_name;
                document.getElementById('edit_username').value = userData.username;
                document.getElementById('edit_email').value = userData.email;
                document.getElementById('edit_role').value = userData.role;
            });
        });

        // Detail User Modal Logic
        const detailButtons = document.querySelectorAll('.btn-detail-trigger');
        
        detailButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const userData = JSON.parse(this.getAttribute('data-user'));
                
                // Populate Detail Modal
                document.getElementById('detail_full_name_display').textContent = userData.full_name;
                document.getElementById('detail_role_display').textContent = userData.role.charAt(0).toUpperCase() + userData.role.slice(1);
                document.getElementById('detail_username').textContent = userData.username;
                document.getElementById('detail_role').textContent = userData.role;
                document.getElementById('detail_email').textContent = userData.email;
            });
        });
    });
</script>
<?= $this->endSection() ?>