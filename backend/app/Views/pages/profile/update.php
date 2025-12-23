<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    :root {
        --primary: #1e40af;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-500: #64748b;
        --gray-700: #334155;
    }
    
    .form-card {
        background: white; border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); 
        border: 1px solid var(--gray-200);
        overflow: hidden;
    }
    .form-header {
        background: var(--gray-100); padding: 20px 32px;
        border-bottom: 1px solid var(--gray-200);
    }
    .form-header h2 { margin: 0; font-size: 1.25rem; color: var(--gray-700); font-weight: 700; }
    .form-body { padding: 32px; }
    
    .form-group { margin-bottom: 24px; }
    .form-label { display: block; margin-bottom: 8px; font-weight: 600; color: var(--gray-700); font-size: 0.9rem; }
    .form-control {
        width: 100%; padding: 10px 12px; border-radius: 8px;
        border: 1px solid var(--gray-200); font-size: 0.95rem;
        transition: all 0.2s;
    }
    .form-control:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1); }
    
    /* Upload Foto Preview Styles */
    .upload-box {
        display: flex; align-items: center; gap: 24px;
        padding: 20px; border: 1px dashed var(--gray-200); border-radius: 12px;
        background-color: #fafafa;
    }
    
    .img-preview-container {
        position: relative;
        width: 100px; height: 100px;
    }
    
    .img-preview {
        width: 100%; height: 100%; border-radius: 50%; object-fit: cover;
        background: white; border: 3px solid white;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .btn-save { background: var(--primary); color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; font-weight: 600; transition: background 0.2s; }
    .btn-cancel { background: white; color: var(--gray-500); border: 1px solid var(--gray-200); padding: 12px 24px; border-radius: 8px; text-decoration: none; display: inline-block; font-weight: 500; transition: background 0.2s; }
    .btn-save:hover { background: #1e3a8a; }
    .btn-cancel:hover { background: var(--gray-100); }
    
    .invalid-feedback { color: #dc2626; font-size: 0.85rem; margin-top: 6px; }
    .text-helper { color: var(--gray-500); font-size: 0.85rem; line-height: 1.4; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div style="margin-bottom: 24px;">
    <h1 style="font-size: 1.75rem; margin: 0; color: #0f172a; font-weight: 700;">
        <i class="bi bi-pencil-square" style="color: var(--primary);"></i> Edit Profil
    </h1>
</div>

<?= $this->include('layouts/alerts') ?>

<div class="form-card">
    <div class="form-header">
        <h2>Form Perubahan Data</h2>
    </div>

    <form action="<?= base_url('profile/' . $user['id_user']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <input type="hidden" name="_method" value="PUT">
        
        <div class="form-body">
            
            <div class="form-group">
                <label class="form-label">Foto Profil</label>
                <div class="upload-box">
                    <div class="img-preview-container">
                        <?php 
                            // LOGIKA GAMBAR:
                            // 1. Jika ada foto di DB & bukan default -> Pakai foto itu
                            // 2. Jika tidak ada -> Pakai UI Avatars (Generate dari Username)
                            
                            $hasFoto = !empty($user['foto']) && $user['foto'] !== 'default.png';
                            $urlFotoAsli = base_url('uploads/users/' . $user['foto']);
                            
                            // Generator Avatar (Fallback)
                            $urlFallback = 'https://ui-avatars.com/api/?name=' . urlencode($user['username']) . '&background=E2E8F0&color=64748B&size=128&bold=true';
                            
                            $displaySrc = $hasFoto ? $urlFotoAsli : $urlFallback;
                        ?>
                        
                        <img src="<?= $displaySrc ?>" 
                             alt="Preview" 
                             class="img-preview" 
                             id="previewImg"
                             onerror="this.onerror=null; this.src='<?= $urlFallback ?>';">
                    </div>
                    
                    <div style="flex: 1;">
                        <input type="file" 
                               class="form-control <?= session('errors.foto') ? 'is-invalid' : '' ?>" 
                               id="foto" 
                               name="foto" 
                               accept="image/png, image/jpeg, image/jpg" 
                               onchange="previewFile()">
                        
                        <div class="text-helper" style="margin-top: 8px;">
                            <i class="bi bi-info-circle"></i> Format diizinkan: JPG, JPEG, PNG. <br>
                            Ukuran maksimal: 2MB. Biarkan kosong jika tidak ingin mengubah foto.
                        </div>
                        
                        <?php if (session('errors.foto')) : ?>
                            <div class="invalid-feedback"><?= session('errors.foto') ?></div>
                        <?php endif ?>
                    </div>
                </div>
            </div>

            <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 32px 0;">

            <div class="form-group">
                <label class="form-label">NIK / NIP (ID Pengguna)</label>
                <input type="text" class="form-control" value="<?= esc($user['id_user']) ?>" disabled style="background-color: #f8fafc; color: #64748b; cursor: not-allowed;">
                <div class="text-helper" style="margin-top: 4px;">ID Pengguna tidak dapat diubah.</div>
            </div>

            <div class="row" style="display: flex; gap: 20px; flex-wrap: wrap;">
                <div class="form-group" style="flex: 1; min-width: 300px;">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="full_name" class="form-control <?= session('errors.full_name') ? 'is-invalid' : '' ?>" value="<?= old('full_name', $user['full_name']) ?>">
                    <?php if (session('errors.full_name')) : ?>
                        <div class="invalid-feedback"><?= session('errors.full_name') ?></div>
                    <?php endif ?>
                </div>

                <div class="form-group" style="flex: 1; min-width: 300px;">
                    <label class="form-label">No. Telepon</label>
                    <input type="number" name="no_telp" class="form-control <?= session('errors.no_telp') ? 'is-invalid' : '' ?>" value="<?= old('no_telp', $user['no_telp']) ?>">
                    <?php if (session('errors.no_telp')) : ?>
                        <div class="invalid-feedback"><?= session('errors.no_telp') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="row" style="display: flex; gap: 20px; flex-wrap: wrap;">
                <div class="form-group" style="flex: 1; min-width: 300px;">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?>" value="<?= old('username', $user['username']) ?>">
                    <?php if (session('errors.username')) : ?>
                        <div class="invalid-feedback"><?= session('errors.username') ?></div>
                    <?php endif ?>
                </div>

                <div class="form-group" style="flex: 1; min-width: 300px;">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" value="<?= old('email', $user['email']) ?>">
                    <?php if (session('errors.email')) : ?>
                        <div class="invalid-feedback"><?= session('errors.email') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 32px 0;">
            
            <h3 style="font-size: 1.1rem; color: var(--gray-700); margin-bottom: 20px; font-weight: 600;">
                <i class="bi bi-shield-lock"></i> Ganti Password (Opsional)
            </h3>

            <div class="row" style="display: flex; gap: 20px; flex-wrap: wrap;">
                <div class="form-group" style="flex: 1; min-width: 300px;">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" placeholder="Ketik jika ingin mengganti...">
                    <?php if (session('errors.password')) : ?>
                        <div class="invalid-feedback"><?= session('errors.password') ?></div>
                    <?php endif ?>
                </div>

                <div class="form-group" style="flex: 1; min-width: 300px;">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirm" class="form-control <?= session('errors.password_confirm') ? 'is-invalid' : '' ?>" placeholder="Ulangi password baru...">
                    <?php if (session('errors.password_confirm')) : ?>
                        <div class="invalid-feedback"><?= session('errors.password_confirm') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div style="margin-top: 30px; display: flex; gap: 12px; justify-content: flex-end;">
                <a href="<?= base_url('profile') ?>" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-save"><i class="bi bi-save"></i> Simpan Perubahan</button>
            </div>
        </div>
    </form>
</div>

<script>
    function previewFile() {
        const preview = document.getElementById('previewImg');
        const fileInput = document.getElementById('foto');
        const file = fileInput.files[0];
        const reader = new FileReader();

        reader.onloadend = function() {
            preview.src = reader.result;
        }

        if (file) {
            // Validasi sederhana ukuran file di JS (opsional, UX only)
            if(file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar! Maksimal 2MB.');
                fileInput.value = ""; // Reset input
                return;
            }
            reader.readAsDataURL(file);
        }
    }
</script>

<?= $this->endSection() ?>