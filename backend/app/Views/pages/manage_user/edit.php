<?= $this->extend('layouts/main') ?>
<?= $this->section('styles') ?>

<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { background-color: #f8f9fa; padding: 20px; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; }
    .container { max-width: 900px; margin: 0 auto; padding: 0 15px; }
    .card { background: #fff; border-radius: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); padding: 30px; margin-bottom: 20px; }
    .page-header { margin-bottom: 30px; }
    .page-header h1 { font-size: 2rem; font-weight: 600; color: #212529; margin-bottom: 0.5rem; }
    .page-header p { color: #6c757d; margin: 0; }
    .breadcrumb { background: transparent; padding: 0; margin-bottom: 20px; display: flex; list-style: none; gap: 0.5rem; }
    .breadcrumb-item { color: #6c757d; }
    .breadcrumb-item a { color: #0d6efd; text-decoration: none; }
    .breadcrumb-item.active { color: #212529; }
    .form-group { margin-bottom: 1.5rem; }
    .form-label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #212529; }
    .form-label .text-danger { color: #dc3545; }
    .form-control, .form-select { display: block; width: 100%; padding: 0.75rem; font-size: 1rem; border: 1px solid #ced4da; border-radius: 0.375rem; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; }
    .form-control:focus, .form-select:focus { border-color: #86b7fe; outline: 0; box-shadow: 0 0 0 0.25rem rgba(13,110,253,0.25); }
    .form-control.is-invalid { border-color: #dc3545; }
    .invalid-feedback { display: block; color: #dc3545; font-size: 0.875rem; margin-top: 0.25rem; }
    .form-text { display: block; margin-top: 0.25rem; font-size: 0.875rem; color: #6c757d; }
    .btn { display: inline-block; padding: 0.75rem 1.5rem; font-size: 1rem; font-weight: 400; text-align: center; text-decoration: none; border-radius: 0.375rem; border: none; cursor: pointer; transition: all 0.15s ease-in-out; }
    .btn-primary { background: linear-gradient(90deg, #0d6efd, #6610f2); color: #fff; }
    .btn-primary:hover { background: linear-gradient(90deg, #0b5ed7, #520dc2); }
    .btn-secondary { background-color: #6c757d; color: #fff; }
    .btn-secondary:hover { background-color: #5c636a; }
    .btn-group { display: flex; gap: 10px; }
    .alert { padding: 1rem; border-radius: 0.375rem; margin-bottom: 1rem; }
    .alert-danger { background-color: #f8d7da; border: 1px solid #f5c2c7; color: #842029; }
    .alert-success { background-color: #d1e7dd; border: 1px solid #badbcc; color: #0f5132; }
    .bi { margin-right: 0.5rem; }
    .password-toggle { position: relative; }
    .password-toggle .toggle-btn { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #6c757d; cursor: pointer; padding: 0.5rem; }
    .password-toggle .toggle-btn:hover { color: #212529; }
    .info-box { background-color: #cff4fc; border: 1px solid #9eeaf9; border-radius: 0.375rem; padding: 1rem; margin-bottom: 1.5rem; color: #055160; }
    .info-box .bi-info-circle { color: #0dcaf0; }
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

    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="bi bi-pencil-square text-primary"></i> Edit User</h1>
        <p>Perbarui informasi pengguna</p>
    </div>

    <!-- Info Box -->
    <div class="info-box">
        <i class="bi bi-info-circle"></i>
        <strong>Informasi:</strong> Kosongkan field password jika tidak ingin mengubahnya. Pastikan email dan username unik.
    </div>

    <!-- Validation Errors -->
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <strong><i class="bi bi-exclamation-triangle"></i> Terdapat kesalahan:</strong>
            <ul style="margin: 0.5rem 0 0 1.5rem; padding: 0;">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="card">
        <form action="<?= base_url('manage_user/' . $user['id_user']) ?>" method="post" id="updateUserForm">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">
            
            <div class="form-group">
                <label for="full_name" class="form-label">
                    Nama Lengkap <span class="text-danger">*</span>
                </label>
                <input 
                    type="text" 
                    class="form-control <?= session('errors.full_name') ? 'is-invalid' : '' ?>" 
                    id="full_name" 
                    name="full_name" 
                    value="<?= old('full_name', $user['full_name']) ?>"
                    placeholder="Masukkan nama lengkap"
                    required
                >
                <?php if (session('errors.full_name')): ?>
                    <div class="invalid-feedback"><?= session('errors.full_name') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="username" class="form-label">
                    Username <span class="text-danger">*</span>
                </label>
                <input 
                    type="text" 
                    class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?>" 
                    id="username" 
                    name="username" 
                    value="<?= old('username', $user['username']) ?>"
                    placeholder="Masukkan username"
                    required
                >
                <small class="form-text">Username harus unik dan tidak boleh mengandung spasi</small>
                <?php if (session('errors.username')): ?>
                    <div class="invalid-feedback"><?= session('errors.username') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">
                    Email <span class="text-danger">*</span>
                </label>
                <input 
                    type="email" 
                    class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" 
                    id="email" 
                    name="email" 
                    value="<?= old('email', $user['email']) ?>"
                >
                <small class="form-text">Email harus valid dan unik</small>
                <?php if (session('errors.email')): ?>
                    <div class="invalid-feedback"><?= session('errors.email') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">
                    Password Baru
                </label>
                <div class="password-toggle">
                    <input 
                        type="password" 
                        class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" 
                        id="password" 
                        name="password" 
                        placeholder="Kosongkan jika tidak ingin mengubah"
                    >
                    <button type="button" class="toggle-btn" onclick="togglePassword('password')">
                        <i class="bi bi-eye" id="password-icon"></i>
                    </button>
                </div>
                <small class="form-text">Minimal 6 karakter. Kosongkan jika tidak ingin mengubah password</small>
                <?php if (session('errors.password')): ?>
                    <div class="invalid-feedback"><?= session('errors.password') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password_confirm" class="form-label">
                    Konfirmasi Password Baru
                </label>
                <div class="password-toggle">
                    <input 
                        type="password" 
                        class="form-control <?= session('errors.password_confirm') ? 'is-invalid' : '' ?>" 
                        id="password_confirm" 
                        name="password_confirm" 
                        placeholder="Ulangi password baru"
                    >
                    <button type="button" class="toggle-btn" onclick="togglePassword('password_confirm')">
                        <i class="bi bi-eye" id="password_confirm-icon"></i>
                    </button>
                </div>
                <?php if (session('errors.password_confirm')): ?>
                    <div class="invalid-feedback"><?= session('errors.password_confirm') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="role" class="form-label">
                    Role <span class="text-danger">*</span>
                </label>
                <select 
                    class="form-select <?= session('errors.role') ? 'is-invalid' : '' ?>" 
                    id="role" 
                    name="role"
                    required
                >
                    <option value="">-- Pilih Role --</option>
                    <option value="superadmin" <?= old('role', $user['role']) == 'superadmin' ? 'selected' : '' ?>>Super Admin</option>
                    <option value="admin" <?= old('role', $user['role']) == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="editor" <?= old('role', $user['role']) == 'editor' ? 'selected' : '' ?>>Editor</option>
                    <option value="user" <?= old('role', $user['role']) == 'user' ? 'selected' : '' ?>>User</option>
                </select>
                <small class="form-text">Tentukan level akses pengguna</small>
                <?php if (session('errors.role')): ?>
                    <div class="invalid-feedback"><?= session('errors.role') ?></div>
                <?php endif; ?>
            </div>

            <!-- Action Buttons -->
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Update User
                </button>
                <a href="<?= base_url('manage_user') ?>" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Batal
                </a>
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
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}

// Form validation
document.getElementById('updateUserForm').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const passwordConfirm = document.getElementById('password_confirm').value;
    
    // Jika password diisi, pastikan konfirmasi juga diisi dan cocok
    if (password !== '' || passwordConfirm !== '') {
        if (password !== passwordConfirm) {
            e.preventDefault();
            alert('Password dan konfirmasi password tidak cocok!');
            return false;
        }
        
        if (password.length > 0 && password.length < 6) {
            e.preventDefault();
            alert('Password minimal 6 karakter!');
            return false;
        }
    }
    
    return true;
});
</script>
<?= $this->endSection() ?>