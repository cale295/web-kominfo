<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/pages/manage_user/show.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header-gov">
        <h1>
            <i class="bi bi-person-circle"></i>
            Detail Pengguna
        </h1>
        <p>Informasi lengkap data pengguna sistem</p>
        <a href="/manage_user" class="btn-back">
            <i class="bi bi-arrow-left"></i>
            Kembali
        </a>
    </div>

    <!-- Alerts -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Detail Card -->
    <div class="detail-card-gov">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-avatar">
                <i class="bi bi-person-fill"></i>
            </div>
            <h2 class="profile-name"><?= esc($user['full_name']) ?></h2>
            <p class="profile-username">
                <code>@<?= esc($user['username']) ?></code>
            </p>
            <?php
            $roleClass = '';
            $roleLower = strtolower($user['role']);
            if (strpos($roleLower, 'super') !== false) {
                $roleClass = 'role-superadmin';
            } elseif (strpos($roleLower, 'admin') !== false) {
                $roleClass = 'role-admin';
            } else {
                $roleClass = 'role-editor';
            }
            ?>
            <span class="role-badge-large <?= $roleClass ?>">
                <i class="bi bi-shield-check me-1"></i>
                <?= esc($user['role']) ?>
            </span>
        </div>

        <!-- Info Cards -->
        <div class="info-cards">
            <div class="info-card">
                <div class="info-card-header">
                    <div class="info-card-icon icon-id">
                        <i class="bi bi-hash"></i>
                    </div>
                    <h6 class="info-card-title">User ID</h6>
                </div>
                <p class="info-card-value">#<?= esc($user['id_user'] ?? '-') ?></p>
            </div>

            <div class="info-card">
                <div class="info-card-header">
                    <div class="info-card-icon icon-username">
                        <i class="bi bi-at"></i>
                    </div>
                    <h6 class="info-card-title">Username</h6>
                </div>
                <p class="info-card-value"><?= esc($user['username']) ?></p>
            </div>

            <div class="info-card">
                <div class="info-card-header">
                    <div class="info-card-icon icon-email">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <h6 class="info-card-title">Email</h6>
                </div>
                <p class="info-card-value"><?= esc($user['email']) ?></p>
            </div>

            <div class="info-card">
                <div class="info-card-header">
                    <div class="info-card-icon icon-role">
                        <i class="bi bi-shield-fill-check"></i>
                    </div>
                    <h6 class="info-card-title">Role</h6>
                </div>
                <p class="info-card-value"><?= esc($user['role']) ?></p>
            </div>
        </div>

        <!-- Detailed Information Table -->
        <div class="card-header" style="margin-top: 0;">
            <h5 class="card-header-title">
                <i class="bi bi-info-circle-fill"></i>
                Informasi Detail
            </h5>
        </div>
        
        <table class="table detail-table">
            <tbody>
                <tr>
                    <th>
                        <span class="detail-icon icon-id">
                            <i class="bi bi-hash"></i>
                        </span>
                        ID Pengguna
                    </th>
                    <td><strong>#<?= esc($user['id_user'] ?? '-') ?></strong></td>
                </tr>
                <tr>
                    <th>
                        <span class="detail-icon icon-name">
                            <i class="bi bi-person-badge-fill"></i>
                        </span>
                        Nama Lengkap
                    </th>
                    <td><?= esc($user['full_name']) ?></td>
                </tr>
                <tr>
                    <th>
                        <span class="detail-icon icon-username">
                            <i class="bi bi-person-fill"></i>
                        </span>
                        Username
                    </th>
                    <td><code style="background: #f1f5f9; padding: 4px 12px; border-radius: 6px; font-weight: 600; color: #475569;"><?= esc($user['username']) ?></code></td>
                </tr>
                <tr>
                    <th>
                        <span class="detail-icon icon-email">
                            <i class="bi bi-envelope-fill"></i>
                        </span>
                        Alamat Email
                    </th>
                    <td>
                        <a href="mailto:<?= esc($user['email']) ?>" style="color: var(--primary-gov); text-decoration: none; font-weight: 600;">
                            <?= esc($user['email']) ?>
                        </a>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span class="detail-icon icon-role">
                            <i class="bi bi-shield-check"></i>
                        </span>
                        Role/Jabatan
                    </th>
                    <td>
                        <span class="role-badge-large <?= $roleClass ?>">
                            <?= esc($user['role']) ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span class="detail-icon icon-created-at">
                            <i class="bi bi-calendar-date-fill"></i>
                        </span>
                        Tanggal Dibuat
                    </th>
                    <td>
                        <?= date('d F Y', strtotime($user['created_at'])) ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span class="detail-icon icon-updated-at">
                            <i class="bi bi-calendar-date-fill"></i>
                        </span>
                        Tanggal Diperbarui
                    </th>
                    <td>
                        <?= date('d F Y', strtotime($user['updated_at'])) ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="/manage_user" class="btn-action-detail btn-back-detail">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>
            <a href="/manage_user/<?= esc($user['id_user']) ?>/edit" class="btn-action-detail btn-edit-detail">
                <i class="bi bi-pencil-square"></i>
                Edit Pengguna
            </a>
            <form action="/manage_user/<?= esc($user['id_user']) ?>" method="post" style="display: inline; margin: 0;">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" 
                        class="btn-action-detail btn-delete-detail" 
                        onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?\n\nData yang dihapus tidak dapat dikembalikan!')">
                    <i class="bi bi-trash-fill"></i>
                    Hapus Pengguna
                </button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Confirmation for delete button
    const deleteForm = document.querySelector('form[method="post"]');
    if (deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
            const confirmed = confirm(
                'Apakah Anda yakin ingin menghapus pengguna ini?\n\n' +
                'Pengguna: <?= esc($user['full_name']) ?>\n' +
                'Username: <?= esc($user['username']) ?>\n\n' +
                'Data yang dihapus tidak dapat dikembalikan!'
            );
            
            if (!confirmed) {
                e.preventDefault();
                return false;
            }
        });
    }
});
</script>
<?= $this->endSection() ?>