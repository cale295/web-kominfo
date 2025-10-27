<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/pages/manage_user/create.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header-gov">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h3>
                    <i class="bi bi-person-plus-fill me-2"></i>
                    Tambah Pengguna Baru
                </h3>
                <p>Buat akun pengguna baru untuk sistem informasi</p>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="<?= base_url('manage_user') ?>" class="btn btn-back-gov">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card form-card-gov">
        <div class="card-body">
            <!-- Error Alert -->
            <?php if (session()->getFlashdata('errors')) : ?>
                <div class="alert alert-danger-gov alert-dismissible fade show" role="alert">
                    <strong>Terdapat kesalahan pada form:</strong>
                    <ul class="mt-2">
                        <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('manage_user') ?>" method="post" id="userForm">
                <?= csrf_field() ?>

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
                                   value="<?= old('full_name') ?>" 
                                   placeholder="Masukkan nama lengkap"
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
                                   value="<?= old('username') ?>" 
                                   placeholder="username123"
                                   required>
                        </div>
                        <div class="form-text-gov">
                            <i class="bi bi-lightbulb"></i>
                            Username untuk login (huruf kecil, angka, underscore)
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
                                   value="<?= old('email') ?>" 
                                   placeholder="email@example.com"
                                   required>
                        </div>
                        <div class="form-text-gov">
                            <i class="bi bi-lightbulb"></i>
                            Email aktif untuk notifikasi sistem
                        </div>
                    </div>
                </div>

                <!-- Security Information -->
                <div class="form-section-title">
                    <i class="bi bi-shield-lock"></i>
                    Keamanan & Password
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label for="password" class="form-label form-label-gov">
                            <i class="bi bi-key"></i>
                            Password
                            <span class="required">*</span>
                        </label>
                        <div class="input-group-gov">
                            <i class="bi bi-lock-fill input-icon"></i>
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   class="form-control form-control-gov" 
                                   placeholder="Minimal 8 karakter"
                                   required>
                            <i class="bi bi-eye password-toggle" id="togglePassword"></i>
                        </div>
                        <div class="password-strength" id="passwordStrength">
                            <div class="password-strength-bar" id="strengthBar"></div>
                        </div>
                        <div class="password-strength-text" id="strengthText"></div>
                        <div class="form-text-gov">
                            <i class="bi bi-lightbulb"></i>
                            Gunakan kombinasi huruf besar, kecil, angka, dan simbol
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
                                <option value="superadmin" <?= old('role') == 'superadmin' ? 'selected' : '' ?>>
                                    🔴 Super Admin - Akses penuh sistem
                                </option>
                                <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>
                                    🔵 Admin - Kelola konten & pengguna
                                </option>
                                <option value="editor" <?= old('role') == 'editor' ? 'selected' : '' ?>>
                                    🟢 Editor - Kelola konten
                                </option>
                            </select>
                        </div>
                        <div id="rolePreview" class="role-preview"></div>
                        <div class="form-text-gov">
                            <i class="bi bi-lightbulb"></i>
                            Pilih role sesuai dengan tanggung jawab pengguna
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
                        Simpan Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('js/pages/manage_user/create.js') ?>"></script>
<?= $this->endSection() ?>