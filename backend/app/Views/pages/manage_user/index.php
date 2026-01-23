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

    /* Custom styles for new features */
    .user-type-selector {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        border: 1px solid #e9ecef;
        margin-bottom: 20px;
    }

    .conditional-field {
        transition: all 0.3s ease-in-out;
        opacity: 1;
        max-height: 1000px;
        overflow: hidden;
    }

    .conditional-field.hidden {
        opacity: 0;
        max-height: 0;
        margin-top: 0 !important;
        margin-bottom: 0 !important;
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        pointer-events: none;
    }

    .password-strength {
        height: 5px;
        margin-top: 5px;
        background-color: #e9ecef;
        border-radius: 3px;
        overflow: hidden;
        display: none;
    }

    .password-strength.show { display: block; }

    .password-strength-bar {
        height: 100%;
        width: 0%;
        transition: width 0.3s ease, background-color 0.3s ease;
    }

    .password-strength-text {
        font-size: 0.75rem;
        margin-top: 5px;
        font-weight: 600;
    }

    .role-preview {
        margin-top: 10px;
        padding: 10px;
        border-radius: 6px;
        background-color: #f8f9fa;
        border-left: 4px solid #ccc;
        font-size: 0.9rem;
        display: none;
    }
    .role-preview.show { display: block; }
    .role-preview.superadmin { border-left-color: #dc3545; background-color: #fff5f5; }
    .role-preview.admin { border-left-color: #0d6efd; background-color: #f0f7ff; }
    .role-preview.editor { border-left-color: #198754; background-color: #f0fff4; }

    .search-container {
        display: flex;
        gap: 10px;
        align-items: flex-start;
    }
    .search-container .input-group-gov { flex-grow: 1; }
    
    .btn-search-gov {
        background-color: var(--primary-text);
        color: white;
        border: none;
        border-radius: 0.375rem;
        padding: 0 20px;
        height: 48px;
        font-weight: 600;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        white-space: nowrap;
        cursor: pointer;
    }
    .btn-search-gov:hover {
        filter: brightness(90%);
        color: white;
    }
    
    .form-section-title {
        font-weight: 600;
        color: #374151;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e5e7eb;
        font-size: 1.1rem;
    }
    
    .input-group-modern {
        position: relative;
    }
    
    .input-group-modern .input-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #6b7280;
        z-index: 10;
    }
    
    .input-group-modern .form-control {
        padding-left: 40px;
    }
    
    .password-toggle {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #6b7280;
        z-index: 10;
    }
    
    .btn-action-group {
        display: flex;
        gap: 8px;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #6b7280;
    }
    
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.3;
    }
    
    .password-section {
        transition: all 0.3s ease-in-out;
    }
    
    .password-section.hidden {
        opacity: 0;
        max-height: 0;
        margin-top: 0 !important;
        margin-bottom: 0 !important;
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        pointer-events: none;
    }
</style>

<div class="container-fluid px-4 pb-5">
    <!-- Header Section -->
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

    <!-- Flash Messages -->
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
                <div class="empty-state">
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
                                <th class="text-center py-3" width="5%">
                                    <input type="checkbox" id="selectAll" class="form-check-input form-check-input-gov">
                                </th>
                                <th class="text-center py-3" width="5%">ID</th>
                                <th class="py-3" width="20%">Nama Lengkap</th>
                                <th class="py-3" width="15%">Username</th>
                                <th class="py-3" width="20%">Email</th>
                                <th class="text-center py-3" width="12%">Role</th>
                                <th class="text-center py-3" width="23%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $index => $user): ?>
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" class="form-check-input form-check-input-gov user-checkbox" data-id="<?= $user['id_user'] ?>">
                                    </td>
                                    <td class="text-center fw-bold text-muted"><?= $user['id_user'] ?></td>
                                    
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
                                        <div class="btn-action-group justify-content-center">
                                            <button type="button" 
                                                    class="btn-action btn-soft-primary hover-scale btn-detail-trigger"
                                                    title="Lihat Detail"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#detailUserModal"
                                                    data-user="<?= htmlspecialchars(json_encode($user)) ?>">
                                                <i class="fas fa-eye me-1"></i> Detail
                                            </button>

                                            <button type="button" 
                                                    class="btn-action btn-soft-warning hover-scale btn-edit-trigger"
                                                    title="Edit User"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editUserModal"
                                                    data-user="<?= htmlspecialchars(json_encode($user)) ?>">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </button>
                                            
                                            <form action="<?= site_url('manage_user/'.$user['id_user']) ?>" method="post" class="d-inline delete-form">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" 
                                                        class="btn-action btn-soft-danger hover-scale"
                                                        onclick="return confirm('Yakin ingin hapus?')"
                                                        title="Hapus User">
                                                    <i class="fas fa-trash me-1"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="table-footer px-4 py-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="mb-2 mb-md-0">
                            <form id="deleteSelectedForm" action="<?= base_url('manage_user/delete_selected') ?>" method="post">
                                <?= csrf_field() ?>
                                <button type="button" id="deleteSelectedBtn" class="btn btn-danger btn-sm rounded-pill" disabled>
                                    <i class="fas fa-trash me-2"></i>
                                    Hapus Terpilih (<span id="selectedCount">0</span>)
                                </button>
                            </form>
                        </div>
                    </div>
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

                    <div class="form-section-title mt-0">
                        <i class="fas fa-user-tag me-2"></i> Tipe Pengguna
                    </div>
                    
                    <div class="user-type-selector">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipe_user" id="type_non_pegawai" value="non_pegawai" checked>
                                    <label class="form-check-label fw-bold" for="type_non_pegawai">
                                        <i class="fas fa-user me-1"></i> Masyarakat Umum
                                    </label>
                                    <div class="text-muted small ms-4">Memerlukan NIK & Email</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipe_user" id="type_pegawai" value="pegawai">
                                    <label class="form-check-label fw-bold" for="type_pegawai">
                                        <i class="fas fa-building me-1"></i> Pegawai Internal
                                    </label>
                                    <div class="text-muted small ms-4">Login via NIP (Auto Username) - Tidak Perlu Password</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section-title">
                        <i class="fas fa-user-circle me-2"></i> Informasi Utama
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="id_user" class="form-label fw-semibold" id="identity_label">
                                <i class="fas fa-id-card me-1"></i> NIK <span class="text-danger">*</span>
                            </label>
                            <div class="search-container">
                                <div class="input-group-modern">
                                    <i class="fas fa-id-card input-icon"></i>
                                    <input type="text" name="id_user" id="id_user" class="form-control form-control-modern" value="<?= old('id_user') ?>" placeholder="Masukkan 16 digit NIK" required>
                                </div>
                                <button type="button" id="btn_check_data" class="btn-search-gov hover-scale" title="Cari data otomatis">
                                    <i class="fas fa-search" id="icon_search"></i>
                                    <span class="spinner-border spinner-border-sm d-none" id="icon_loading" role="status"></span>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="full_name" class="form-label fw-semibold">
                                <i class="fas fa-user me-1"></i> Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <div class="input-group-modern">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text" name="full_name" id="full_name" class="form-control form-control-modern" value="<?= old('full_name') ?>" placeholder="Nama lengkap" required>
                            </div>
                        </div>
                    </div>

                    <div id="non_pegawai_fields" class="conditional-field">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold"><i class="fas fa-at me-1"></i> Username <span class="text-danger">*</span></label>
                                <div class="input-group-modern">
                                    <i class="fas fa-user-circle input-icon"></i>
                                    <input type="text" name="username" id="username" class="form-control form-control-modern" value="<?= old('username') ?>" placeholder="username123" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold"><i class="fas fa-envelope me-1"></i> Email <span class="text-danger">*</span></label>
                                <div class="input-group-modern">
                                    <i class="fas fa-envelope input-icon"></i>
                                    <input type="email" name="email" id="email" class="form-control form-control-modern" value="<?= old('email') ?>" placeholder="email@example.com" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold"><i class="fas fa-phone me-1"></i> No. Telp</label>
                                <div class="input-group-modern">
                                    <i class="fas fa-phone input-icon"></i>
                                    <input type="text" name="no_telp" id="no_telp" class="form-control form-control-modern" value="<?= old('no_telp') ?>" placeholder="0812xxxx">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold"><i class="fas fa-image me-1"></i> Foto Avatar</label>
                                <div class="input-group-modern">
                                    <input type="file" name="foto" id="foto" class="form-control form-control-modern" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Password Section (Hanya untuk Masyarakat Umum) -->
                    <div id="passwordSection" class="password-section">
                        <div class="form-section-title mt-2">
                            <i class="fas fa-shield-alt me-2"></i> Keamanan & Akses
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold"><i class="fas fa-key me-1"></i> Password <span class="text-danger">*</span></label>
                                <div class="input-group-modern">
                                    <i class="fas fa-lock input-icon"></i>
                                    <input type="password" name="password" id="password" class="form-control form-control-modern" placeholder="Min. 8 karakter" required>
                                    <i class="fas fa-eye password-toggle" id="togglePassword" style="cursor: pointer;"></i>
                                </div>
                                <div class="password-strength" id="passwordStrength"><div class="password-strength-bar" id="strengthBar"></div></div>
                                <div class="password-strength-text" id="strengthText"></div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold"><i class="fas fa-check-double me-1"></i> Konfirmasi <span class="text-danger">*</span></label>
                                <div class="input-group-modern">
                                    <i class="fas fa-lock input-icon"></i>
                                    <input type="password" name="password_confirm" id="password_confirm" class="form-control form-control-modern" placeholder="Ulangi password" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold"><i class="fas fa-user-shield me-1"></i> Role Pengguna <span class="text-danger">*</span></label>
                            <div class="input-group-modern">
                                <i class="fas fa-sitemap input-icon"></i>
                                <select name="role" id="role" class="form-control form-control-modern" required>
                                    <option value="">-- Pilih Role --</option>
                                    <option value="superadmin">Super Admin</option>
                                    <option value="admin">Admin</option>
                                    <option value="editor">Editor</option>
                                </select>
                            </div>
                            <div id="rolePreview" class="role-preview"></div>
                        </div>
                    </div>

                    <div class="modal-footer bg-light border-0 px-0 pb-0">
                        <button type="button" class="btn btn-secondary rounded-pill px-4 hover-scale" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm hover-scale">
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
                    <input type="hidden" name="tipe_user" id="edit_tipe_user_val">

                    <div class="form-section-title mt-0">
                        <i class="fas fa-user-circle me-2"></i> Informasi Utama
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold" id="edit_identity_label">
                                <i class="fas fa-id-card me-1"></i> ID User (NIK/NIP)
                            </label>
                            <div class="input-group-modern">
                                <i class="fas fa-id-card input-icon"></i>
                                <input type="text" name="id_user" id="edit_id_user" class="form-control form-control-modern" readonly style="background-color: #f3f4f6;">
                            </div>
                            <small class="text-muted">ID User tidak dapat diubah.</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-user me-1"></i> Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <div class="input-group-modern">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text" name="full_name" id="edit_full_name" class="form-control form-control-modern" required>
                            </div>
                        </div>
                    </div>

                    <div id="edit_non_pegawai_fields" class="conditional-field">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold"><i class="fas fa-at me-1"></i> Username <span class="text-danger">*</span></label>
                                <div class="input-group-modern">
                                    <i class="fas fa-user-circle input-icon"></i>
                                    <input type="text" name="username" id="edit_username" class="form-control form-control-modern" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold"><i class="fas fa-envelope me-1"></i> Email <span class="text-danger">*</span></label>
                                <div class="input-group-modern">
                                    <i class="fas fa-envelope input-icon"></i>
                                    <input type="email" name="email" id="edit_email" class="form-control form-control-modern" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold"><i class="fas fa-phone me-1"></i> No. Telp</label>
                                <div class="input-group-modern">
                                    <i class="fas fa-phone input-icon"></i>
                                    <input type="text" name="no_telp" id="edit_no_telp" class="form-control form-control-modern">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold"><i class="fas fa-image me-1"></i> Ganti Foto (Opsional)</label>
                                <div class="input-group-modern">
                                    <input type="file" name="foto" id="edit_foto" class="form-control form-control-modern" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section-title mt-2">
                        <i class="fas fa-shield-alt me-2"></i> Keamanan & Akses
                    </div>
                    
                    <div class="alert alert-warning border-0 border-start border-4 border-warning rounded-3 py-2 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle me-2 text-warning"></i>
                            <span class="small">Kosongkan password jika tidak ingin mengganti.</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold"><i class="fas fa-key me-1"></i> Password Baru</label>
                            <div class="input-group-modern">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" name="password" id="edit_password" class="form-control form-control-modern" placeholder="Biarkan kosong jika tidak berubah">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold"><i class="fas fa-check-double me-1"></i> Konfirmasi Password</label>
                            <div class="input-group-modern">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" name="password_confirm" id="edit_password_confirm" class="form-control form-control-modern" placeholder="Ulangi password baru">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold"><i class="fas fa-user-shield me-1"></i> Role Pengguna <span class="text-danger">*</span></label>
                            <div class="input-group-modern">
                                <i class="fas fa-sitemap input-icon"></i>
                                <select name="role" id="edit_role" class="form-control form-control-modern" required>
                                    <option value="superadmin">Super Admin</option>
                                    <option value="admin">Admin</option>
                                    <option value="editor">Editor</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer bg-light border-0 px-0 pb-0">
                        <button type="button" class="btn btn-secondary rounded-pill px-4 hover-scale" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-warning rounded-pill px-4 shadow-sm hover-scale">
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
                            <img src="" id="detail_foto_preview" class="rounded-circle img-thumbnail shadow-sm" style="width: 150px; height: 150px; object-fit: cover;" alt="Foto Profil">
                        </div>
                        <h5 class="fw-bold mb-1" id="detail_full_name_display">-</h5>
                        <p class="text-muted mb-2" id="detail_role_display">-</p>
                        <div class="d-grid gap-2 col-10 mx-auto">
                            <button type="button" class="btn btn-outline-primary btn-sm disabled" style="opacity:1;">
                                <i class="fas fa-check-circle"></i> Data Terverifikasi
                            </button>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-section-title mt-0">
                            <i class="fas fa-info-circle me-2"></i> Informasi Akun
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="detail-label">ID User / NIK / NIP</div>
                                <div class="detail-value" id="detail_id_user">-</div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="detail-label">Username</div>
                                <div class="detail-value">
                                    <i class="fas fa-user-circle me-2 text-secondary"></i>
                                    <span id="detail_username">-</span>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="detail-label">Role Akses</div>
                                <div class="detail-value">
                                    <i class="fas fa-shield-alt me-2 text-secondary"></i>
                                    <span id="detail_role">-</span>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="detail-label">Email</div>
                                <div class="detail-value">
                                    <i class="fas fa-envelope me-2 text-secondary"></i>
                                    <span id="detail_email">-</span>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="detail-label">Nomor Telepon</div>
                                <div class="detail-value">
                                    <i class="fas fa-phone me-2 text-secondary"></i>
                                    <span id="detail_no_telp">-</span>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="detail-label">Dibuat Pada</div>
                                <div class="small text-secondary mt-1" id="detail_created_at">-</div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-label">Terakhir Diupdate</div>
                                <div class="small text-secondary mt-1" id="detail_updated_at">-</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-0">
                <button type="button" class="btn btn-secondary rounded-pill px-4 hover-scale" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        
        // ==========================================
        // 1. LOGIC UTAMA (TIPE USER & CREATE)
        // ==========================================
        const radios = document.querySelectorAll('input[name="tipe_user"]');
        const identityLabel = document.getElementById('identity_label');
        const idUser = document.getElementById('id_user');
        const nonPegawaiFields = document.getElementById('non_pegawai_fields');
        const usernameInput = document.getElementById('username');
        const emailInput = document.getElementById('email');
        const passwordSection = document.getElementById('passwordSection');
        
        // Password Logic (hanya untuk masyarakat umum)
        const passwordInput = document.getElementById('password');
        const passwordConfirmInput = document.getElementById('password_confirm');
        const togglePassword = document.getElementById('togglePassword');
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');
        const passwordStrength = document.getElementById('passwordStrength');
        
        // Role Logic
        const roleSelect = document.getElementById('role');
        const rolePreview = document.getElementById('rolePreview');

        // Fungsi Toggle Field Pegawai/Non-Pegawai
        function toggleUserType() {
            let selectedType = document.querySelector('input[name="tipe_user"]:checked').value;
            
            if (selectedType === 'pegawai') {
                identityLabel.innerHTML = '<i class="fas fa-id-card me-1"></i> NIP (Nomor Induk Pegawai) <span class="text-danger">*</span>';
                idUser.placeholder = "Masukkan NIP...";
                
                // Hide fields yang auto-generate untuk pegawai
                nonPegawaiFields.classList.add('hidden');
                
                // Hide password section untuk pegawai
                passwordSection.classList.add('hidden');
                
                // Remove required attribute saat hidden agar form bisa submit
                usernameInput.removeAttribute('required');
                emailInput.removeAttribute('required');
                passwordInput.removeAttribute('required');
                passwordConfirmInput.removeAttribute('required');
            } else {
                identityLabel.innerHTML = '<i class="fas fa-id-card me-1"></i> NIK (Nomor Induk Kependudukan) <span class="text-danger">*</span>';
                idUser.placeholder = "Masukkan 16 digit NIK";
                
                // Show fields untuk masyarakat umum
                nonPegawaiFields.classList.remove('hidden');
                passwordSection.classList.remove('hidden');
                
                // Add required back
                usernameInput.setAttribute('required', 'required');
                emailInput.setAttribute('required', 'required');
                passwordInput.setAttribute('required', 'required');
                passwordConfirmInput.setAttribute('required', 'required');
            }
        }

        // Listener Radio Buttons
        radios.forEach(radio => {
            radio.addEventListener('change', toggleUserType);
        });
        
        // Init state awal
        if(radios.length > 0) toggleUserType();

        // ==========================================
        // 2. PASSWORD STRENGTH METER (hanya untuk masyarakat umum)
        // ==========================================
        if(passwordInput) {
            passwordInput.addEventListener('input', function() {
                const val = this.value;
                if(val.length > 0) {
                    passwordStrength.classList.add('show');
                } else {
                    passwordStrength.classList.remove('show');
                }

                let strength = 0;
                if (val.length >= 8) strength += 1;
                if (val.match(/[a-z]+/)) strength += 1;
                if (val.match(/[A-Z]+/)) strength += 1;
                if (val.match(/[0-9]+/)) strength += 1;
                if (val.match(/[$@#&!]+/)) strength += 1;

                let color = '#dc3545'; // red
                let width = '20%';
                let text = 'Lemah';

                switch(strength) {
                    case 3: color = '#ffc107'; width = '60%'; text = 'Sedang'; break;
                    case 4: 
                    case 5: color = '#198754'; width = '100%'; text = 'Kuat'; break;
                }

                strengthBar.style.width = width;
                strengthBar.style.backgroundColor = color;
                strengthText.innerText = text;
                strengthText.style.color = color;
            });

            // Toggle Password Visibility
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }

        // ==========================================
        // 3. ROLE PREVIEW
        // ==========================================
        if(roleSelect) {
            roleSelect.addEventListener('change', function() {
                const role = this.value;
                rolePreview.className = 'role-preview show ' + role;
                let desc = '';
                if(role === 'superadmin') desc = '<strong>Super Admin:</strong> Akses penuh ke seluruh sistem.';
                else if(role === 'admin') desc = '<strong>Admin:</strong> Mengelola user dan konten, tapi terbatas.';
                else if(role === 'editor') desc = '<strong>Editor:</strong> Hanya bisa mengedit konten.';
                else {
                    rolePreview.classList.remove('show');
                }
                rolePreview.innerHTML = desc;
            });
        }

        // ==========================================
        // 4. LOGIC MODAL EDIT
        // ==========================================
        const editButtons = document.querySelectorAll('.btn-edit-trigger');
        const editForm = document.getElementById('editUserForm');
        
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const userData = JSON.parse(this.getAttribute('data-user'));
                
                // Set Action URL
                editForm.action = "<?= base_url('manage_user') ?>/" + userData.id_user;
                
                // Fill Fields
                document.getElementById('edit_id_user').value = userData.id_user;
                document.getElementById('edit_full_name').value = userData.full_name;
                document.getElementById('edit_username').value = userData.username;
                document.getElementById('edit_email').value = userData.email;
                document.getElementById('edit_no_telp').value = userData.no_telp || '';
                document.getElementById('edit_role').value = userData.role;

                // Handle Tipe User di Edit (Simulasi berdasarkan data)
                // Jika ingin logic pegawai/non-pegawai di edit, sesuaikan kondisi ini
                // Disini kita biarkan semua field bisa diedit kecuali ID
            });
        });

        // ==========================================
        // 5. LOGIC MODAL DETAIL
        // ==========================================
        const detailButtons = document.querySelectorAll('.btn-detail-trigger');
        
        detailButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const userData = JSON.parse(this.getAttribute('data-user'));
                
                // 1. Populate Bagian Header (Kiri)
                document.getElementById('detail_full_name_display').textContent = userData.full_name;
                document.getElementById('detail_role_display').textContent = userData.role.charAt(0).toUpperCase() + userData.role.slice(1);
                
                // Handle Foto
                const imgPreview = document.getElementById('detail_foto_preview');
                if (userData.foto && userData.foto !== '') {
                    // Pastikan path uploads/users/ sesuai konfigurasi controller Anda
                    imgPreview.src = "<?= base_url('uploads/users/') ?>/" + userData.foto;
                } else {
                    imgPreview.src = "https://ui-avatars.com/api/?name=" + encodeURIComponent(userData.full_name) + "&background=random&size=150";
                }

                // 2. Populate Bagian Detail (Kanan)
                document.getElementById('detail_id_user').textContent = userData.id_user;
                document.getElementById('detail_username').textContent = userData.username;
                document.getElementById('detail_role').textContent = userData.role;
                document.getElementById('detail_email').textContent = userData.email;
                document.getElementById('detail_no_telp').textContent = userData.no_telp || '-';
                
                // Tanggal (jika ada field created_at/updated_at di DB)
                document.getElementById('detail_created_at').textContent = userData.created_at || '-';
                document.getElementById('detail_updated_at').textContent = userData.updated_at || '-';
            });
        });

        // ==========================================
        // 6. DELETE SELECTED LOGIC
        // ==========================================
        const selectAll = document.getElementById('selectAll');
        const userCheckboxes = document.querySelectorAll('.user-checkbox');
        const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
        const deleteSelectedForm = document.getElementById('deleteSelectedForm');
        const selectedCountSpan = document.getElementById('selectedCount');

        function updateDeleteBtnState() {
            const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
            const count = checkedBoxes.length;
            selectedCountSpan.innerText = count;
            
            if(count > 0) {
                deleteSelectedBtn.removeAttribute('disabled');
                deleteSelectedBtn.classList.add('active');
            } else {
                deleteSelectedBtn.setAttribute('disabled', 'disabled');
                deleteSelectedBtn.classList.remove('active');
            }
        }

        if(selectAll) {
            selectAll.addEventListener('change', function() {
                const isChecked = this.checked;
                userCheckboxes.forEach(cb => cb.checked = isChecked);
                updateDeleteBtnState();
            });
        }

        userCheckboxes.forEach(cb => {
            cb.addEventListener('change', updateDeleteBtnState);
        });

        if(deleteSelectedBtn) {
            deleteSelectedBtn.addEventListener('click', function() {
                if(confirm('Apakah Anda yakin ingin menghapus data terpilih?')) {
                    // Append hidden inputs for selected IDs
                    document.querySelectorAll('.user-checkbox:checked').forEach(cb => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'ids[]';
                        input.value = cb.getAttribute('data-id');
                        deleteSelectedForm.appendChild(input);
                    });
                    deleteSelectedForm.submit();
                }
            });
        }

        // ==========================================
        // 7. SEARCH FILTER LOGIC
        // ==========================================
        const searchInput = document.getElementById('searchInput');
        const roleFilter = document.getElementById('roleFilter');
        const limitSelect = document.getElementById('limitSelect');

        function applyFilters() {
            // Logika refresh halaman dengan query params
            const search = searchInput.value;
            const role = roleFilter.value;
            const limit = limitSelect.value;
            
            let url = new URL(window.location.href);
            if(search) url.searchParams.set('search', search); else url.searchParams.delete('search');
            if(role) url.searchParams.set('role', role); else url.searchParams.delete('role');
            if(limit) url.searchParams.set('limit', limit);
            
            // Redirect/Reload (Better use AJAX in real app, but for now reload)
            window.location.href = url.toString();
        }

        // Add event listeners with debounce for search if possible, or trigger on Enter
        searchInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') applyFilters();
        });
        roleFilter.addEventListener('change', applyFilters);
        limitSelect.addEventListener('change', applyFilters);

    });
</script>
<?= $this->endSection() ?>