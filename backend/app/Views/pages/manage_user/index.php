<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/pages/manage_user/index.css') ?>">
<style>
    /* --- CSS LAMA ANDA (TIDAK BERUBAH) --- */
    /* Transisi halus untuk field yang muncul/hilang */
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

    .user-type-selector {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        border: 1px solid #e9ecef;
        margin-bottom: 20px;
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
        background-color: var(--bs-primary);
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
    
    .modal-lg { max-width: 800px; }
    
    /* --- TAMBAHAN STYLE UNTUK MODAL DETAIL --- */
    .detail-label {
        font-weight: 600;
        color: #6c757d;
        font-size: 0.85rem;
        margin-bottom: 0.2rem;
    }
    .detail-value {
        font-weight: 500;
        color: #212529;
        background-color: #f8f9fa;
        padding: 8px 12px;
        border-radius: 6px;
        border: 1px solid #e9ecef;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container-fluid py-4">
    <div class="page-header-gov">
        <h1>
            <i class="bi bi-people-fill"></i>
            Manajemen Pengguna
        </h1>
        <p>Kelola data pengguna dan hak akses sistem informasi</p>
    </div>

    <div class="stats-row">
        <div class="stats-card-gov stats-card-primary">
            <div class="card-body">
                <div class="stats-info">
                    <h6>Total Pengguna</h6>
                    <h2><?= $totalUsers ?></h2>
                </div>
                <div class="stats-icon"><i class="bi bi-people"></i></div>
            </div>
        </div>
        <div class="stats-card-gov stats-card-danger">
            <div class="card-body">
                <div class="stats-info">
                    <h6>Super Admin</h6>
                    <h2><?= $superadmin ?></h2>
                </div>
                <div class="stats-icon"><i class="bi bi-shield-fill-check"></i></div>
            </div>
        </div>
        <div class="stats-card-gov stats-card-info">
            <div class="card-body">
                <div class="stats-info">
                    <h6>Administrator</h6>
                    <h2><?= $admin ?></h2>
                </div>
                <div class="stats-icon"><i class="bi bi-person-badge"></i></div>
            </div>
        </div>
        <div class="stats-card-gov stats-card-success">
            <div class="card-body">
                <div class="stats-info">
                    <h6>Editor</h6>
                    <h2><?= $editor ?></h2>
                </div>
                <div class="stats-icon"><i class="bi bi-pencil-square"></i></div>
            </div>
        </div>
    </div>

    <div class="card filter-card-gov">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-lg-3 col-md-6">
                    <label class="filter-label"><i class="bi bi-funnel"></i> Filter Role</label>
                    <select id="roleFilter" class="form-select form-select-gov">
                        <option value="">Semua Role</option>
                        <option value="superadmin">Super Admin</option>
                        <option value="admin">Admin</option>
                        <option value="editor">Editor</option>
                    </select>
                </div>

                <div class="col-lg-4 col-md-6">
                    <label class="filter-label"><i class="bi bi-search"></i> Pencarian</label>
                    <input type="text" id="searchInput" class="form-control form-control-gov" placeholder="Cari nama, username, atau email...">
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="filter-label"><i class="bi bi-list-ol"></i> Tampilkan</label>
                    <select id="limitSelect" class="form-select form-select-gov">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>

                <div class="col-lg-3 col-md-6">
                    <button type="button" class="btn btn-add-user w-100" data-bs-toggle="modal" data-bs-target="#createUserModal">
                        <i class="bi bi-plus-circle"></i>
                        Tambah Pengguna Baru
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card table-card-gov">
        <div class="table-responsive">
            <table id="usersTable" class="table table-gov table-hover">
                <thead>
                    <tr>
                        <th style="width: 50px;">
                            <input type="checkbox" id="selectAll" class="form-check-input form-check-input-gov">
                        </th>
                        <th style="width: 60px;">ID</th>
                        <th style="width: 25%;">Nama Lengkap</th>
                        <th style="width: 15%;">Username</th>
                        <th style="width: 20%;">Email</th>
                        <th style="width: 12%;">Role</th>
                        <th style="width: 18%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td>
                                    <input type="checkbox" class="form-check-input form-check-input-gov user-checkbox" data-id="<?= $user['id_user'] ?>">
                                </td>
                                <td><strong><?= $user['id_user'] ?></strong></td>
                                <td><strong><?= esc($user['full_name']) ?></strong></td>
                                <td><code style="color: #64748b;"><?= esc($user['username']) ?></code></td>
                                <td><?= esc($user['email']) ?></td>
                                <td>
                                    <?php
                                    $roleClass = '';
                                    $roleLower = strtolower($user['role']);
                                    if (strpos($roleLower, 'super') !== false) $roleClass = 'role-superadmin';
                                    elseif (strpos($roleLower, 'admin') !== false) $roleClass = 'role-admin';
                                    else $roleClass = 'role-editor';
                                    ?>
                                    <span class="role-badge <?= $roleClass ?>"><?= esc($user['role']) ?></span>
                                </td>
                                <td>
                                    <div class="btn-action-group">
                                        <button type="button" 
                                                class="btn-action btn-detail btn-detail-trigger" 
                                                title="Lihat Detail"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#detailUserModal"
                                                data-user="<?= htmlspecialchars(json_encode($user)) ?>">
                                            <i class="bi bi-eye"></i> Detail
                                        </button>

                                        <button type="button" 
                                                class="btn-action btn-edit btn-edit-trigger" 
                                                title="Edit User"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editUserModal"
                                                data-user="<?= htmlspecialchars(json_encode($user)) ?>">
                                            <i class="bi bi-pencil"></i> Edit
                                        </button>
                                        
                                        <form action="<?= site_url('manage_user/'.$user['id_user']) ?>" method="post" style="display:inline;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn-action btn-delete" onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <h5>Belum Ada Data Pengguna</h5>
                                    <p>Silakan tambahkan pengguna baru untuk memulai</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="mb-2 mb-md-0">
                    <form id="deleteSelectedForm" action="<?= base_url('manage_user/delete_selected') ?>" method="post">
                        <?= csrf_field() ?>
                        <button type="button" id="deleteSelectedBtn" class="btn-delete-selected" disabled>
                            <i class="bi bi-trash me-2"></i>
                            Hapus Terpilih (<span id="selectedCount">0</span>)
                        </button>
                    </form>
                </div>
                <nav>
                    <ul class="pagination-gov" id="pagination">
                        </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserModalLabel">
                    <i class="bi bi-person-plus-fill me-2"></i>Tambah Pengguna Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if (session()->getFlashdata('errors')) : ?>
                    <div class="alert alert-danger-gov alert-dismissible fade show" role="alert">
                        <strong>Perhatian:</strong>
                        <ul class="mt-2 mb-0 ps-3">
                            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('manage_user') ?>" method="post" id="userForm" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="form-section-title mt-0">
                        <i class="bi bi-grid-fill"></i> Tipe Pengguna
                    </div>
                    
                    <div class="user-type-selector">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipe_user" id="type_non_pegawai" value="non_pegawai" checked>
                                    <label class="form-check-label fw-bold" for="type_non_pegawai">
                                        <i class="bi bi-person me-1"></i> Masyarakat Umum
                                    </label>
                                    <div class="text-muted small ms-4">Memerlukan NIK & Email</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipe_user" id="type_pegawai" value="pegawai">
                                    <label class="form-check-label fw-bold" for="type_pegawai">
                                        <i class="bi bi-building me-1"></i> Pegawai Internal
                                    </label>
                                    <div class="text-muted small ms-4">Login via NIP (Auto Username)</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section-title">
                        <i class="bi bi-person-badge"></i> Informasi Utama
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="id_user" class="form-label form-label-gov" id="identity_label">
                                <i class="bi bi-card-heading"></i> NIK <span class="required">*</span>
                            </label>
                            <div class="search-container">
                                <div class="input-group-gov">
                                    <i class="bi bi-card-text input-icon"></i>
                                    <input type="text" name="id_user" id="id_user" class="form-control form-control-gov" value="<?= old('id_user') ?>" placeholder="Masukkan 16 digit NIK" required>
                                </div>
                                <button type="button" id="btn_check_data" class="btn btn-search-gov" title="Cari data otomatis">
                                    <i class="bi bi-search" id="icon_search"></i>
                                    <span class="spinner-border spinner-border-sm d-none" id="icon_loading" role="status"></span>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="full_name" class="form-label form-label-gov">
                                <i class="bi bi-person"></i> Nama Lengkap <span class="required">*</span>
                            </label>
                            <div class="input-group-gov">
                                <i class="bi bi-person-fill input-icon"></i>
                                <input type="text" name="full_name" id="full_name" class="form-control form-control-gov" value="<?= old('full_name') ?>" placeholder="Nama lengkap" required>
                            </div>
                        </div>
                    </div>

                    <div id="non_pegawai_fields" class="conditional-field">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label form-label-gov"><i class="bi bi-at"></i> Username <span class="required">*</span></label>
                                <div class="input-group-gov">
                                    <i class="bi bi-person-circle input-icon"></i>
                                    <input type="text" name="username" id="username" class="form-control form-control-gov" value="<?= old('username') ?>" placeholder="username123" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label form-label-gov"><i class="bi bi-envelope"></i> Email <span class="required">*</span></label>
                                <div class="input-group-gov">
                                    <i class="bi bi-envelope-fill input-icon"></i>
                                    <input type="email" name="email" id="email" class="form-control form-control-gov" value="<?= old('email') ?>" placeholder="email@example.com" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label form-label-gov"><i class="bi bi-whatsapp"></i> No. Telp</label>
                                <div class="input-group-gov">
                                    <i class="bi bi-telephone-fill input-icon"></i>
                                    <input type="text" name="no_telp" id="no_telp" class="form-control form-control-gov" value="<?= old('no_telp') ?>" placeholder="0812xxxx">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label form-label-gov"><i class="bi bi-image"></i> Foto Avatar</label>
                                <div class="input-group-gov">
                                    <input type="file" name="foto" id="foto" class="form-control form-control-gov" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section-title mt-2">
                        <i class="bi bi-shield-lock"></i> Keamanan & Akses
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label form-label-gov"><i class="bi bi-key"></i> Password <span class="required">*</span></label>
                            <div class="input-group-gov">
                                <i class="bi bi-lock-fill input-icon"></i>
                                <input type="password" name="password" id="password" class="form-control form-control-gov" placeholder="Min. 8 karakter" required>
                                <i class="bi bi-eye password-toggle" id="togglePassword" style="cursor: pointer; margin-left: 10px;"></i>
                            </div>
                            <div class="password-strength" id="passwordStrength"><div class="password-strength-bar" id="strengthBar"></div></div>
                            <div class="password-strength-text" id="strengthText"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label form-label-gov"><i class="bi bi-check-all"></i> Konfirmasi <span class="required">*</span></label>
                            <div class="input-group-gov">
                                <i class="bi bi-lock-fill input-icon"></i>
                                <input type="password" name="password_confirm" id="password_confirm" class="form-control form-control-gov" placeholder="Ulangi password" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label form-label-gov"><i class="bi bi-award"></i> Role Pengguna <span class="required">*</span></label>
                            <div class="input-group-gov">
                                <i class="bi bi-diagram-3 input-icon"></i>
                                <select name="role" id="role" class="form-select form-select-gov" required>
                                    <option value="">-- Pilih Role --</option>
                                    <option value="superadmin">Super Admin</option>
                                    <option value="admin">Admin</option>
                                    <option value="editor">Editor</option>
                                </select>
                            </div>
                            <div id="rolePreview" class="role-preview"></div>
                        </div>
                    </div>

                    <div class="modal-footer px-0 pb-0">
                        <button type="button" class="btn btn-cancel-gov" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-submit-gov">
                            <i class="bi bi-check-circle"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">
                    <i class="bi bi-pencil-square me-2"></i>Edit Data Pengguna
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="editUserForm" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT"> <input type="hidden" name="tipe_user" id="edit_tipe_user_val">

                    <div class="form-section-title mt-0">
                        <i class="bi bi-person-badge"></i> Informasi Utama
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label form-label-gov" id="edit_identity_label">
                                <i class="bi bi-card-heading"></i> ID User (NIK/NIP)
                            </label>
                            <div class="input-group-gov">
                                <i class="bi bi-card-text input-icon"></i>
                                <input type="text" name="id_user" id="edit_id_user" class="form-control form-control-gov" readonly style="background-color: #e9ecef;">
                            </div>
                            <small class="text-muted">ID User tidak dapat diubah.</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label form-label-gov">
                                <i class="bi bi-person"></i> Nama Lengkap <span class="required">*</span>
                            </label>
                            <div class="input-group-gov">
                                <i class="bi bi-person-fill input-icon"></i>
                                <input type="text" name="full_name" id="edit_full_name" class="form-control form-control-gov" required>
                            </div>
                        </div>
                    </div>

                    <div id="edit_non_pegawai_fields" class="conditional-field">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label form-label-gov"><i class="bi bi-at"></i> Username <span class="required">*</span></label>
                                <div class="input-group-gov">
                                    <i class="bi bi-person-circle input-icon"></i>
                                    <input type="text" name="username" id="edit_username" class="form-control form-control-gov" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label form-label-gov"><i class="bi bi-envelope"></i> Email <span class="required">*</span></label>
                                <div class="input-group-gov">
                                    <i class="bi bi-envelope-fill input-icon"></i>
                                    <input type="email" name="email" id="edit_email" class="form-control form-control-gov" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label form-label-gov"><i class="bi bi-whatsapp"></i> No. Telp</label>
                                <div class="input-group-gov">
                                    <i class="bi bi-telephone-fill input-icon"></i>
                                    <input type="text" name="no_telp" id="edit_no_telp" class="form-control form-control-gov">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label form-label-gov"><i class="bi bi-image"></i> Ganti Foto (Opsional)</label>
                                <div class="input-group-gov">
                                    <input type="file" name="foto" id="edit_foto" class="form-control form-control-gov" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section-title mt-2">
                        <i class="bi bi-shield-lock"></i> Keamanan & Akses
                    </div>
                    
                    <div class="alert alert-warning-gov py-2 mb-3">
                        <i class="bi bi-info-circle me-1"></i> Kosongkan password jika tidak ingin mengganti.
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label form-label-gov"><i class="bi bi-key"></i> Password Baru</label>
                            <div class="input-group-gov">
                                <i class="bi bi-lock-fill input-icon"></i>
                                <input type="password" name="password" id="edit_password" class="form-control form-control-gov" placeholder="Biarkan kosong jika tidak berubah">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label form-label-gov"><i class="bi bi-check-all"></i> Konfirmasi Password</label>
                            <div class="input-group-gov">
                                <i class="bi bi-lock-fill input-icon"></i>
                                <input type="password" name="password_confirm" id="edit_password_confirm" class="form-control form-control-gov" placeholder="Ulangi password baru">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label form-label-gov"><i class="bi bi-award"></i> Role Pengguna <span class="required">*</span></label>
                            <div class="input-group-gov">
                                <i class="bi bi-diagram-3 input-icon"></i>
                                <select name="role" id="edit_role" class="form-select form-select-gov" required>
                                    <option value="superadmin">Super Admin</option>
                                    <option value="admin">Admin</option>
                                    <option value="editor">Editor</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer px-0 pb-0">
                        <button type="button" class="btn btn-cancel-gov" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-submit-gov">
                            <i class="bi bi-check-circle"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailUserModal" tabindex="-1" aria-labelledby="detailUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="detailUserModalLabel">
                    <i class="bi bi-person-lines-fill me-2"></i>Detail Data Pengguna
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center border-end">
                        <div class="mb-3 mt-2">
                            <img src="" id="detail_foto_preview" class="rounded-circle img-thumbnail shadow-sm" style="width: 150px; height: 150px; object-fit: cover;" alt="Foto Profil">
                        </div>
                        <h5 class="fw-bold mb-1" id="detail_full_name_display">-</h5>
                        <p class="text-muted mb-2" id="detail_role_display">-</p>
                        <div class="d-grid gap-2 col-10 mx-auto">
                            <button type="button" class="btn btn-outline-primary btn-sm disabled" style="opacity:1;">
                                <i class="bi bi-check-circle-fill"></i> Data Terverifikasi
                            </button>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-section-title mt-0">
                            <i class="bi bi-info-circle"></i> Informasi Akun
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="detail-label">ID User / NIK / NIP</div>
                                <div class="detail-value" id="detail_id_user">-</div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="detail-label">Username</div>
                                <div class="detail-value">
                                    <i class="bi bi-person-circle me-1 text-secondary"></i>
                                    <span id="detail_username">-</span>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="detail-label">Role Akses</div>
                                <div class="detail-value">
                                    <i class="bi bi-shield-lock me-1 text-secondary"></i>
                                    <span id="detail_role">-</span>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="detail-label">Email</div>
                                <div class="detail-value">
                                    <i class="bi bi-envelope me-1 text-secondary"></i>
                                    <span id="detail_email">-</span>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="detail-label">Nomor Telepon</div>
                                <div class="detail-value">
                                    <i class="bi bi-whatsapp me-1 text-secondary"></i>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
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
        
        // Password Logic
        const passwordInput = document.getElementById('password');
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
                identityLabel.innerHTML = '<i class="bi bi-card-heading"></i> NIP (Nomor Induk Pegawai) <span class="required">*</span>';
                idUser.placeholder = "Masukkan NIP...";
                
                // Hide fields yang auto-generate untuk pegawai
                nonPegawaiFields.classList.add('hidden');
                
                // Remove required attribute saat hidden agar form bisa submit
                usernameInput.removeAttribute('required');
                emailInput.removeAttribute('required');
            } else {
                identityLabel.innerHTML = '<i class="bi bi-card-heading"></i> NIK (Nomor Induk Kependudukan) <span class="required">*</span>';
                idUser.placeholder = "Masukkan 16 digit NIK";
                
                // Show fields
                nonPegawaiFields.classList.remove('hidden');
                
                // Add required back
                usernameInput.setAttribute('required', 'required');
                emailInput.setAttribute('required', 'required');
            }
        }

        // Listener Radio Buttons
        radios.forEach(radio => {
            radio.addEventListener('change', toggleUserType);
        });
        
        // Init state awal
        if(radios.length > 0) toggleUserType();

        // ==========================================
        // 2. PASSWORD STRENGTH METER
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
                this.classList.toggle('bi-eye');
                this.classList.toggle('bi-eye-slash');
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
        // 5. LOGIC MODAL DETAIL (NEW FEATURE)
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