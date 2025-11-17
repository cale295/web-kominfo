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

    /* Profile Card */
    .profile-card {
        background: white;
        border-radius: 12px;
        border: 1px solid var(--gray-200);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .profile-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        padding: 40px 32px;
        text-align: center;
        position: relative;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 3rem;
        color: var(--primary);
        border: 4px solid white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .profile-name {
        color: white;
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
    }

    .profile-role {
        color: rgba(255, 255, 255, 0.85);
        font-size: 0.9375rem;
        margin-top: 8px;
    }

    .profile-body {
        padding: 32px;
    }

    .profile-section {
        margin-bottom: 32px;
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

    .profile-info-item {
        padding: 16px 0;
        border-bottom: 1px solid var(--gray-100);
        display: flex;
        align-items: start;
        gap: 16px;
    }

    .profile-info-item:last-child {
        border-bottom: none;
    }

    .profile-info-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: var(--gray-100);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .profile-info-icon i {
        color: var(--primary);
        font-size: 1.125rem;
    }

    .profile-info-content {
        flex: 1;
    }

    .profile-info-label {
        font-size: 0.75rem;
        color: var(--gray-500);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .profile-info-value {
        color: var(--gray-900);
        font-size: 0.9375rem;
        font-weight: 500;
    }

    /* Action Buttons */
    .profile-actions {
        padding: 24px 32px;
        background: var(--gray-50);
        border-top: 1px solid var(--gray-200);
        display: flex;
        gap: 12px;
    }

    .btn {
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.9375rem;
        transition: all 0.2s;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
    }

    .btn-danger {
        background: var(--danger);
        color: white;
    }

    .btn-danger:hover {
        background: #b91c1c;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }

    .btn i {
        font-size: 1rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .gov-header {
            padding: 20px;
        }
        
        .gov-header h1 {
            font-size: 1.375rem;
        }

        .profile-header {
            padding: 32px 24px;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            font-size: 2.5rem;
        }

        .profile-name {
            font-size: 1.25rem;
        }

        .profile-body {
            padding: 24px;
        }

        .profile-actions {
            flex-direction: column;
            padding: 20px 24px;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="gov-header">
    <h1>
        <i class="bi bi-person-circle"></i>
        Profil Saya
    </h1>
</div>

<?= $this->include('layouts/alerts') ?>

<!-- Profile Card -->
<div class="profile-card">
    <!-- Profile Header -->
    <div class="profile-header">
        <div class="profile-avatar">
            <i class="bi bi-person-fill"></i>
        </div>
        <h2 class="profile-name"><?= esc($user['full_name']) ?></h2>
        <div class="profile-role">
            <i class="bi bi-shield-check"></i>
            <?= ucfirst(str_replace('_', ' ', session()->get('role') ?? 'User')) ?>
        </div>
    </div>

    <!-- Profile Body -->
    <div class="profile-body">
        <div class="profile-section">
            <div class="section-title">
                <i class="bi bi-info-circle"></i>
                Informasi Akun
            </div>

            <div class="profile-info-item">
                <div class="profile-info-icon">
                    <i class="bi bi-person"></i>
                </div>
                <div class="profile-info-content">
                    <div class="profile-info-label">Nama Lengkap</div>
                    <div class="profile-info-value"><?= esc($user['full_name']) ?></div>
                </div>
            </div>

            <div class="profile-info-item">
                <div class="profile-info-icon">
                    <i class="bi bi-at"></i>
                </div>
                <div class="profile-info-content">
                    <div class="profile-info-label">Username</div>
                    <div class="profile-info-value"><?= esc($user['username']) ?></div>
                </div>
            </div>

            <div class="profile-info-item">
                <div class="profile-info-icon">
                    <i class="bi bi-envelope"></i>
                </div>
                <div class="profile-info-content">
                    <div class="profile-info-label">Email</div>
                    <div class="profile-info-value"><?= esc($user['email']) ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="profile-actions">
        <a href="<?= base_url('profile/' . $user['id_user'] . '/edit') ?>" class="btn btn-primary">
            <i class="bi bi-pencil-square"></i>
            Edit Profil
        </a>
        <a href="<?= base_url('profile/delete') ?>" 
           onclick="return confirm('Yakin ingin menghapus akun ini? Tindakan ini tidak dapat dibatalkan!')" 
           class="btn btn-danger">
            <i class="bi bi-trash"></i>
            Hapus Akun
        </a>
    </div>
</div>

<?= $this->endSection() ?>