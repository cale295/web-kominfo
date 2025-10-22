<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    body { background-color: #f8f9fa; }
    .container { max-width: 900px; margin: 40px auto; }
    .card { border: none; border-radius: 12px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
    .form-label { font-weight: 600; }
    .breadcrumb { background: transparent; margin-bottom: 1rem; }
    .btn-primary {
        background: linear-gradient(90deg, #0d6efd, #6610f2);
        border: none;
    }
    .btn-primary:hover {
        background: linear-gradient(90deg, #0b5ed7, #520dc2);
    }
    .password-toggle {
        position: relative;
    }
    .password-toggle .toggle-btn {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #6c757d;
        cursor: pointer;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>"><i class="bi bi-house-door"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('manage_user') ?>">Manajemen User</a></li>
            <li class="breadcrumb-item active">Edit User</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="mb-4">
        <h3><i class="bi bi-pencil-square text-primary"></i> Edit User</h3>
        <p class="text-muted mb-0">Perbarui informasi pengguna di bawah ini.</p>
    </div>

    <!-- Alert error -->
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <strong><i class="bi bi-exclamation-triangle"></i> Terjadi kesalahan:</strong>
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Alert success -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i> <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- Form -->
    <div class="card p-4">
        <form action="<?= base_url('manage_user/' . $user['id_user']) ?>" method="post" id="updateUserForm">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">

            <!-- Nama Lengkap -->
            <div class="mb-3">
                <label for="full_name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="full_name" id="full_name"
                    class="form-control <?= session('errors.full_name') ? 'is-invalid' : '' ?>"
                    value="<?= old('full_name', $user['full_name']) ?>" required>
                <?php if (session('errors.full_name')): ?>
                    <div class="invalid-feedback"><?= session('errors.full_name') ?></div>
                <?php endif; ?>
            </div>

            <!-- Username -->
            <div class="mb-3">
                <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                <input type="text" name="username" id="username"
                    class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?>"
                    value="<?= old('username', $user['username']) ?>" required>
                <small class="text-muted">Username harus unik dan tidak boleh mengandung spasi.</small>
                <?php if (session('errors.username')): ?>
                    <div class="invalid-feedback"><?= session('errors.username') ?></div>
                <?php endif; ?>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" id="email"
                    class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>"
                    value="<?= old('email', $user['email']) ?>" required>
                <small class="text-muted">Pastikan email valid dan unik.</small>
                <?php if (session('errors.email')): ?>
                    <div class="invalid-feedback"><?= session('errors.email') ?></div>
                <?php endif; ?>
            </div>

            <!-- Password Baru -->
            <div class="mb-3 password-toggle">
                <label for="password" class="form-label">Password Baru</label>
                <input type="password" name="password" id="password"
                    class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>"
                    placeholder="Kosongkan jika tidak ingin mengubah password">
                <button type="button" class="toggle-btn" onclick="togglePassword('password')">
                    <i class="bi bi-eye" id="password-icon"></i>
                </button>
                <?php if (session('errors.password')): ?>
                    <div class="invalid-feedback"><?= session('errors.password') ?></div>
                <?php endif; ?>
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-3 password-toggle">
                <label for="password_confirm" class="form-label">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirm" id="password_confirm"
                    class="form-control" placeholder="Ulangi password baru">
                <button type="button" class="toggle-btn" onclick="togglePassword('password_confirm')">
                    <i class="bi bi-eye" id="password_confirm-icon"></i>
                </button>
            </div>

            <!-- Role -->
            <div class="mb-4">
                <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                <select name="role" id="role"
                    class="form-select <?= session('errors.role') ? 'is-invalid' : '' ?>" required>
                    <option value="">-- Pilih Role --</option>
<<<<<<< HEAD
                    <option value="superadmin" <?= old('role', $user['role']) === 'superadmin' ? 'selected' : '' ?>>Super Admin</option>
                    <option value="admin" <?= old('role', $user['role']) === 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="editor" <?= old('role', $user['role']) === 'editor' ? 'selected' : '' ?>>Editor</option>
=======
                    <option value="superadmin" <?= old('role', $user['role']) == 'superadmin' ? 'selected' : '' ?>>Super Admin</option>
                    <option value="admin" <?= old('role', $user['role']) == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="editor" <?= old('role', $user['role']) == 'editor' ? 'selected' : '' ?>>Editor</option>
>>>>>>> 3868209bfb9dae62ec7d459ed0aa07edd1f6bda2
                </select>
                <?php if (session('errors.role')): ?>
                    <div class="invalid-feedback"><?= session('errors.role') ?></div>
                <?php endif; ?>
            </div>

            <!-- Tombol -->
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Perubahan</button>
                <a href="<?= base_url('manage_user') ?>" class="btn btn-secondary"><i class="bi bi-arrow-left-circle"></i> Kembali</a>
            </div>
        </form>
    </div>
</div>

<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(inputId + '-icon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}

// Validasi konfirmasi password
document.getElementById('updateUserForm').addEventListener('submit', function(e) {
    const pass = document.getElementById('password').value;
    const confirm = document.getElementById('password_confirm').value;
    if (pass !== '' || confirm !== '') {
        if (pass !== confirm) {
            e.preventDefault();
            alert('Password dan konfirmasi tidak cocok!');
            return false;
        }
        if (pass.length < 6) {
            e.preventDefault();
            alert('Password minimal 6 karakter!');
            return false;
        }
    }
});
</script>
<?= $this->endSection() ?>
