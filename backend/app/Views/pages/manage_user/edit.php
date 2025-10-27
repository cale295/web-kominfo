<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/pages/manage_user/edit.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header-gov">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h3>
                    <i class="bi bi-pencil-square me-2"></i>
                    Edit Pengguna
                </h3>
                <p>Perbarui informasi dan pengaturan pengguna</p>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="<?= base_url('manage_user') ?>" class="btn btn-back-gov">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger-gov alert-dismissible fade show" role="alert">
            <strong>Terdapat kesalahan pada form:</strong>
            <ul class="mt-2">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success-gov alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="card form-card-gov">
        <div class="card-body">
            <!-- User Info Badge -->
            <div class="row g-3 user-info-badge">
                <div class="col-md-4">
                    <div class="badge-label">User ID</div>
                    <div class="badge-value">#<?= $user['id_user'] ?></div>
                </div>
                <div class="col-md-4">
                    <div class="badge-label">Username</div>
                    <div class="badge-value"><?= esc($user['username']) ?></div>
                </div>
                <div class="col-md-4">
                    <div class="badge-label">Role Saat Ini</div>
                    <div class="badge-value"><?= ucfirst($user['role']) ?></div>
                </div>
            </div>

            <form action="<?= base_url('manage_user/' . $user['id_user']) ?>" method="post" id="updateUserForm">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">

                <!-- Personal Information -->
                <div class="form-section-title">
                    <i class="bi bi-person-badge"></i>
                    Informasi Personal
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label for="full_name" class="form-label form-label-gov">
                            <i class="bi bi-person"></i>
                            Nama Lengkap
                            <span class="required">*</span>
                        </label>
                        <div class="input-group-gov">
                            <i class="bi bi-person-fill input-icon"></i>
                            <input type="text" 
                                   name="full_name" 
                                   id="full_name"
                                   class="form-control form-control-gov" 
                                   value="<?= old('full_name', $user['full_name']) ?>" 
                                   required>
                        </div>
                        <div class="form-text-gov">
                            <i class="bi bi-lightbulb"></i>
                            Nama lengkap sesuai identitas resmi
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="username" class="form-label form-label-gov">
                            <i class="bi bi-at"></i>
                            Username
                            <span class="required">*</span>
                        </label>
                        <div class="input-group-gov">
                            <i class="bi bi-person-circle input-icon"></i>
                            <input type="text" 
                                   name="username" 
                                   id="username"
                                   class="form-control form-control-gov" 
                                   value="<?= old('username', $user['username']) ?>" 
                                   required>
                        </div>
                        <div class="form-text-gov">
                            <i class="bi bi-lightbulb"></i>
                            Username harus unik dan tanpa spasi
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="email" class="form-label form-label-gov">
                            <i class="bi bi-envelope"></i>
                            Email
                            <span class="required">*</span>
                        </label>
                        <div class="input-group-gov">
                            <i class="bi bi-envelope-fill input-icon"></i>
                            <input type="email" 
                                   name="email" 
                                   id="email"
                                   class="form-control form-control-gov" 
                                   value="<?= old('email', $user['email']) ?>" 
                                   required>
                        </div>
                        <div class="form-text-gov">
                            <i class="bi bi-lightbulb"></i>
                            Email harus valid dan unik
                        </div>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="form-section-title">
                    <i class="bi bi-shield-lock"></i>
                    Keamanan & Password
                </div>

                <div class="info-box">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-info-circle-fill"></i>
                        <div class="info-box-text">
                            <strong>Informasi:</strong> Kosongkan field password jika tidak ingin mengubah password pengguna. 
                            Password harus minimal 6 karakter untuk keamanan yang lebih baik.
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="password" class="form-label form-label-gov">
                            <i class="bi bi-key"></i>
                            Password Baru
                        </label>
                        <div class="input-group-gov">
                            <i class="bi bi-lock-fill input-icon"></i>
                            <input type="password" 
                                   name="password" 
                                   id="password"
                                   class="form-control form-control-gov" 
                                   placeholder="Biarkan kosong jika tidak diubah">
                            <i class="bi bi-eye password-toggle-icon" id="togglePassword"></i>
                        </div>
                        <div class="form-text-gov">
                            <i class="bi bi-lightbulb"></i>
                            Minimal 6 karakter
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="password_confirm" class="form-label form-label-gov">
                            <i class="bi bi-shield-check"></i>
                            Konfirmasi Password
                        </label>
                        <div class="input-group-gov">
                            <i class="bi bi-lock-fill input-icon"></i>
                            <input type="password" 
                                   name="password_confirm" 
                                   id="password_confirm"
                                   class="form-control form-control-gov" 
                                   placeholder="Ulangi password baru">
                            <i class="bi bi-eye password-toggle-icon" id="togglePasswordConfirm"></i>
                        </div>
                        <div class="form-text-gov">
                            <i class="bi bi-lightbulb"></i>
                            Harus sama dengan password baru
                        </div>
                    </div>
                </div>

                <!-- Access Rights -->
                <div class="form-section-title">
                    <i class="bi bi-shield-check"></i>
                    Hak Akses & Role
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label for="role" class="form-label form-label-gov">
                            <i class="bi bi-award"></i>
                            Role Pengguna
                            <span class="required">*</span>
                        </label>
                        <div class="input-group-gov">
                            <i class="bi bi-diagram-3 input-icon"></i>
                            <select name="role" 
                                    id="role" 
                                    class="form-select form-select-gov" 
                                    required>
                                <option value="">-- Pilih Role --</option>
                                <option value="superadmin" <?= old('role', $user['role']) === 'superadmin' ? 'selected' : '' ?>>
                                    🔴 Super Admin - Akses penuh sistem
                                </option>
                                <option value="admin" <?= old('role', $user['role']) === 'admin' ? 'selected' : '' ?>>
                                    🔵 Admin - Kelola konten & pengguna
                                </option>
                                <option value="editor" <?= old('role', $user['role']) === 'editor' ? 'selected' : '' ?>>
                                    🟢 Editor - Kelola konten
                                </option>
                            </select>
                        </div>
                        <div id="rolePreview" class="role-preview" style="display: none;"></div>
                        <div class="form-text-gov">
                            <i class="bi bi-lightbulb"></i>
                            Ubah role sesuai dengan tanggung jawab pengguna
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-end mt-4 pt-3 border-top form-actions">
                    <a href="<?= base_url('manage_user') ?>" class="btn btn-cancel-gov me-2">
                        <i class="bi bi-x-circle"></i>
                        Batal
                    </a>
                    <button type="submit" class="btn btn-submit-gov">
                        <i class="bi bi-check-circle"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('js/pages/manage_user/edit.js') ?>"></script>
<?= $this->endSection() ?>