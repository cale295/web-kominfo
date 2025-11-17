<?= $this->extend('layouts/main') ?>
<?= $this->section('styles') ?>
<style>
    :root {
        --primary: #1e40af;
        --primary-dark: #1e3a8a;
        --primary-light: #3b82f6;
        --success: #059669;
        --warning: #d97706;
        --info: #0284c7;
        --danger: #dc2626;
        --gray-50: #f8fafc;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-300: #cbd5e1;
        --gray-400: #94a3b8;
        --gray-500: #64748b;
        --gray-600: #475569;
        --gray-700: #334155;
        --gray-800: #1e293b;
        --gray-900: #0f172a;
    }

    body {
        background-color: var(--gray-50);
    }

    /* Header Styles */
    .gov-header {
        background: white;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        margin-bottom: 24px;
        border: 1px solid var(--gray-200);
        border-left: 4px solid var(--primary);
    }

    .gov-header h1 {
        font-size: 1.75rem;
        font-weight: 600;
        margin: 0;
        color: var(--gray-900);
    }

    .gov-header h1 i {
        color: var(--primary);
        margin-right: 10px;
    }

    /* Form Card */
    .form-card {
        background: white;
        border-radius: 12px;
        border: 1px solid var(--gray-200);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 32px;
    }

    .section-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--gray-200);
        display: flex;
        align-items: center;
    }

    .section-title i {
        color: var(--primary);
        margin-right: 10px;
        font-size: 1.25rem;
    }

    /* Info Box */
    .info-box {
        background: #fef3c7;
        border: 1px solid #fde047;
        border-left: 4px solid var(--warning);
        border-radius: 8px;
        padding: 16px 20px;
        margin-bottom: 24px;
        display: flex;
        align-items: start;
        gap: 12px;
    }

    .info-box i {
        color: var(--warning);
        font-size: 1.25rem;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .info-box-text {
        color: var(--gray-700);
        font-size: 0.875rem;
        line-height: 1.5;
    }

    .info-box-text strong {
        color: var(--gray-900);
        display: block;
        margin-bottom: 4px;
    }

    /* Form Controls */
    .form-label {
        font-weight: 500;
        color: var(--gray-700);
        margin-bottom: 8px;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .form-label i {
        color: var(--primary);
        font-size: 1rem;
    }

    .text-danger {
        color: var(--danger) !important;
    }

    .form-control {
        border: 1px solid var(--gray-300);
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 0.9375rem;
        transition: all 0.2s;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
    }

    .form-text {
        color: var(--gray-500);
        font-size: 0.8125rem;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .form-text i {
        font-size: 0.875rem;
    }

    /* Password Toggle */
    .password-wrapper {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--gray-500);
        cursor: pointer;
        padding: 4px;
        transition: color 0.2s;
    }

    .password-toggle:hover {
        color: var(--primary);
    }

    .password-toggle i {
        font-size: 1.125rem;
    }

    /* Action Buttons */
    .action-buttons {
        padding-top: 24px;
        border-top: 2px solid var(--gray-200);
        margin-top: 32px;
    }

    .btn {
        padding: 12px 28px;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.9375rem;
        transition: all 0.2s;
        border: none;
    }

    .btn-primary {
        background: var(--primary);
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
    }

    .btn-secondary {
        background: var(--gray-600);
    }

    .btn-secondary:hover {
        background: var(--gray-700);
        transform: translateY(-2px);
    }

    .btn i {
        margin-right: 6px;
    }

    /* Section Spacing */
    .form-section {
        margin-bottom: 32px;
        padding-bottom: 32px;
        border-bottom: 1px solid var(--gray-100);
    }

    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .form-card {
            padding: 20px;
        }

        .gov-header {
            padding: 20px;
        }

        .gov-header h1 {
            font-size: 1.375rem;
        }

        .section-title {
            font-size: 1rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .action-buttons .btn {
            width: 100%;
            margin: 4px 0 !important;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="gov-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1>
                <i class="bi bi-pencil-square"></i>
                Edit Profil
            </h1>
        </div>
        <div>
            <a href="<?= base_url('profile') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<?= $this->include('layouts/alerts') ?>

<!-- Form Card -->
<div class="form-card">
    <!-- Info Box -->
    <div class="info-box">
        <i class="bi bi-exclamation-triangle"></i>
        <div class="info-box-text">
            <strong>Perhatian</strong>
            Pastikan data yang Anda masukkan sudah benar. Perubahan akan langsung diterapkan setelah disimpan.
        </div>
    </div>

    <form action="<?= base_url('profile/' . $user['id_user']) ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">

        <!-- SECTION: Informasi Personal -->
        <div class="form-section">
            <div class="section-title">
                <i class="bi bi-person"></i>
                Informasi Personal
            </div>

            <div class="mb-3">
                <label for="full_name" class="form-label">
                    <i class="bi bi-person-fill"></i>
                    Nama Lengkap
                    <span class="text-danger">*</span>
                </label>
                <input 
                    type="text" 
                    name="full_name" 
                    id="full_name"
                    class="form-control" 
                    value="<?= esc($user['full_name']) ?>" 
                    placeholder="Masukkan nama lengkap"
                    required>
                <small class="form-text">
                    <i class="bi bi-info-circle"></i>
                    Nama lengkap yang akan ditampilkan di sistem
                </small>
            </div>
        </div>

        <!-- SECTION: Informasi Akun -->
        <div class="form-section">
            <div class="section-title">
                <i class="bi bi-key"></i>
                Informasi Akun
            </div>

            <div class="mb-3">
                <label for="username" class="form-label">
                    <i class="bi bi-at"></i>
                    Username
                    <span class="text-danger">*</span>
                </label>
                <input 
                    type="text" 
                    name="username" 
                    id="username"
                    class="form-control" 
                    value="<?= esc($user['username']) ?>" 
                    placeholder="Masukkan username"
                    required>
                <small class="form-text">
                    <i class="bi bi-info-circle"></i>
                    Username untuk login ke sistem
                </small>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">
                    <i class="bi bi-envelope"></i>
                    Email
                    <span class="text-danger">*</span>
                </label>
                <input 
                    type="email" 
                    name="email" 
                    id="email"
                    class="form-control" 
                    value="<?= esc($user['email']) ?>" 
                    placeholder="contoh@email.com"
                    required>
                <small class="form-text">
                    <i class="bi bi-info-circle"></i>
                    Email valid untuk komunikasi dan pemulihan akun
                </small>
            </div>
        </div>

        <!-- SECTION: Keamanan -->
        <div class="form-section">
            <div class="section-title">
                <i class="bi bi-shield-lock"></i>
                Keamanan
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">
                    <i class="bi bi-lock"></i>
                    Password Baru
                </label>
                <div class="password-wrapper">
                    <input 
                        type="password" 
                        name="password" 
                        id="password"
                        class="form-control" 
                        placeholder="Masukkan password baru">
                    <button type="button" class="password-toggle" onclick="togglePassword()">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                    </button>
                </div>
                <small class="form-text">
                    <i class="bi bi-info-circle"></i>
                    Kosongkan jika tidak ingin mengubah password. Minimal 6 karakter.
                </small>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons d-flex justify-content-end gap-2">
            <a href="<?= base_url('profile') ?>" class="btn btn-secondary">
                <i class="bi bi-x-circle"></i> Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('bi-eye');
        toggleIcon.classList.add('bi-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('bi-eye-slash');
        toggleIcon.classList.add('bi-eye');
    }
}
</script>

<?= $this->endSection() ?>