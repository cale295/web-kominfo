<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    :root {
        --primary: #1e40af;
        --primary-dark: #1e3a8a;
        --gray-50: #f8fafc;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-500: #64748b;
        --gray-900: #0f172a;
    }

    body { background-color: var(--gray-50); }

    /* Container agar tidak terlalu lebar */
    .main-container {
        max-width: 800px;
        margin: 0 auto;
        padding-bottom: 40px;
    }

    /* Header Styles */
    .gov-header {
        background: white; padding: 20px 24px; border-radius: 12px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); margin-bottom: 24px;
        border: 1px solid var(--gray-200); border-left: 5px solid var(--primary);
        display: flex; align-items: center;
    }
    .gov-header h1 { font-size: 1.5rem; font-weight: 700; margin: 0; color: var(--gray-900); display: flex; align-items: center; gap: 12px; }
    .gov-header h1 i { color: var(--primary); font-size: 1.75rem; }

    /* Profile Card */
    .profile-card {
        background: white; border-radius: 16px; border: 1px solid var(--gray-200);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }

    /* Header Profile (Background Biru) */
    .profile-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        padding: 40px 20px; text-align: center; position: relative;
    }
    
    /* Foto Profil */
    .profile-avatar {
        width: 130px; height: 130px; border-radius: 50%; 
        background: white; margin: 0 auto 16px; 
        border: 4px solid rgba(255, 255, 255, 0.9);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        display: flex; align-items: center; justify-content: center;
        overflow: hidden; position: relative;
    }
    
    .profile-avatar img { 
        width: 100%; height: 100%; object-fit: cover; 
        display: block; /* Menghilangkan gap di bawah image */
    }
    
    .profile-avatar i { font-size: 4rem; color: var(--gray-200); }

    .profile-name { color: white; font-size: 1.5rem; font-weight: 700; margin: 0 0 4px 0; text-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    .profile-role { 
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(255, 255, 255, 0.2); 
        padding: 4px 12px; border-radius: 20px;
        color: white; font-size: 0.875rem; font-weight: 500; 
        backdrop-filter: blur(4px);
    }

    /* Body Profile */
    .profile-body { padding: 32px; }
    
    .section-title {
        font-size: 1.1rem; font-weight: 700; color: var(--gray-900);
        margin-bottom: 24px; padding-bottom: 12px; border-bottom: 2px solid var(--gray-100);
        display: flex; align-items: center; gap: 10px;
    }
    .section-title i { color: var(--primary); font-size: 1.25rem; }

    /* List Item Rapih */
    .profile-info-list { display: flex; flex-direction: column; gap: 0; }
    
    .profile-info-item {
        padding: 16px; border-bottom: 1px solid var(--gray-100);
        display: flex; align-items: center; gap: 20px;
        transition: background 0.2s;
        border-radius: 8px;
    }
    .profile-info-item:hover { background-color: var(--gray-50); }
    .profile-info-item:last-child { border-bottom: none; }

    .profile-info-icon {
        width: 44px; height: 44px; border-radius: 10px; 
        background: #eff6ff; color: var(--primary);
        display: flex; align-items: center; justify-content: center; 
        font-size: 1.25rem; flex-shrink: 0;
    }

    .profile-info-content { flex: 1; }
    .profile-info-label { 
        font-size: 0.75rem; color: var(--gray-500); 
        text-transform: uppercase; letter-spacing: 0.05em; 
        font-weight: 600; margin-bottom: 2px; 
    }
    .profile-info-value { 
        color: var(--gray-900); font-size: 1rem; font-weight: 500; 
        word-break: break-word; /* Mencegah teks panjang merusak layout */
    }

    /* Actions */
    .profile-actions { 
        padding: 24px 32px; background: var(--gray-50); 
        border-top: 1px solid var(--gray-200); 
        display: flex; gap: 12px; justify-content: flex-end;
    }

    .btn { 
        padding: 10px 20px; border-radius: 8px; font-weight: 600; font-size: 0.9rem; 
        border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; 
        transition: all 0.2s; text-decoration: none;
    }
    .btn-primary { background: var(--primary); color: white; box-shadow: 0 2px 4px rgba(30, 64, 175, 0.2); }
    .btn-primary:hover { background: var(--primary-dark); transform: translateY(-1px); box-shadow: 0 4px 6px rgba(30, 64, 175, 0.3); }
    
    .btn-danger { background: white; color: #dc2626; border: 1px solid #fee2e2; }
    .btn-danger:hover { background: #fef2f2; border-color: #dc2626; }

    @media (max-width: 640px) {
        .profile-actions { flex-direction: column; }
        .btn { width: 100%; justify-content: center; }
        .gov-header { flex-direction: column; text-align: center; gap: 10px; }
        .profile-info-item { align-items: flex-start; }
        .profile-info-icon { margin-top: 2px; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="main-container">

    <div class="gov-header">
        <h1>
            <i class="bi bi-person-circle"></i>
            Profil Pengguna
        </h1>
    </div>

    <?= $this->include('layouts/alerts') ?>

    <div class="profile-card">
        
        <div class="profile-header">
            <div class="profile-avatar">
                <?php 
                    // Logika Foto: Cek jika ada file dan file tersebut bukan default
                    $fotoUrl = base_url('uploads/users/' . $user['foto']);
                    $hasFoto = !empty($user['foto']) && $user['foto'] !== 'default.png';
                ?>
                
                <?php if ($hasFoto): ?>
                    <img src="<?= $fotoUrl ?>" alt="Foto Profil" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <i class="bi bi-person-fill" style="display: none;"></i>
                <?php else: ?>
                    <i class="bi bi-person-fill"></i>
                <?php endif; ?>
            </div>

            <h2 class="profile-name"><?= esc($user['full_name']) ?></h2>
            
            <div class="profile-role">
                <i class="bi bi-shield-check"></i>
                <span><?= ucfirst(str_replace('_', ' ', session()->get('role') ?? 'User')) ?></span>
            </div>
        </div>

        <div class="profile-body">
            <div class="profile-section">
                <div class="section-title">
                    <i class="bi bi-info-circle"></i> Informasi Detail
                </div>

                <div class="profile-info-list">
                    <div class="profile-info-item">
                        <div class="profile-info-icon"><i class="bi bi-card-heading"></i></div>
                        <div class="profile-info-content">
                            <div class="profile-info-label">NIK / NIP (ID Pengguna)</div>
                            <div class="profile-info-value"><?= esc($user['id_user']) ?></div>
                        </div>
                    </div>

                    <div class="profile-info-item">
                        <div class="profile-info-icon"><i class="bi bi-person"></i></div>
                        <div class="profile-info-content">
                            <div class="profile-info-label">Nama Lengkap</div>
                            <div class="profile-info-value"><?= esc($user['full_name']) ?></div>
                        </div>
                    </div>

                    <div class="profile-info-item">
                        <div class="profile-info-icon"><i class="bi bi-at"></i></div>
                        <div class="profile-info-content">
                            <div class="profile-info-label">Username</div>
                            <div class="profile-info-value"><?= esc($user['username']) ?></div>
                        </div>
                    </div>

                    <div class="profile-info-item">
                        <div class="profile-info-icon"><i class="bi bi-envelope"></i></div>
                        <div class="profile-info-content">
                            <div class="profile-info-label">Alamat Email</div>
                            <div class="profile-info-value"><?= esc($user['email']) ?></div>
                        </div>
                    </div>

                    <div class="profile-info-item">
                        <div class="profile-info-icon"><i class="bi bi-telephone"></i></div>
                        <div class="profile-info-content">
                            <div class="profile-info-label">Nomor Telepon</div>
                            <div class="profile-info-value">
                                <?= !empty($user['no_telp']) ? esc($user['no_telp']) : '<span style="color:#94a3b8; font-style:italic;">Belum diatur</span>' ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="profile-actions">
            <form action="<?= base_url('profile/' . $user['id_user']) ?>" method="post" onsubmit="return confirm('PERINGATAN: Akun ini akan dihapus permanen. Lanjutkan?')" style="margin-right: auto;">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Hapus Akun
                </button>
            </form>

            <a href="<?= base_url('profile/' . $user['id_user'] . '/edit') ?>" class="btn btn-primary">
                <i class="bi bi-pencil-square"></i> Edit Data
            </a>
        </div>

    </div>
</div>

<?= $this->endSection() ?>