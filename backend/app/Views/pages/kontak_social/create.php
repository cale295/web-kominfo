<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php
// Daftar Icon Social Media
$socialIcons = [
    'fab fa-facebook'   => 'Facebook',
    'fab fa-facebook-f' => 'Facebook (F)',
    'fab fa-twitter'    => 'Twitter',
    'fab fa-instagram'  => 'Instagram',
    'fab fa-linkedin'   => 'LinkedIn',
    'fab fa-linkedin-in'=> 'LinkedIn (In)',
    'fab fa-youtube'    => 'YouTube',
    'fab fa-tiktok'     => 'TikTok',
    'fab fa-whatsapp'   => 'WhatsApp',
    'fab fa-telegram'   => 'Telegram',
    'fab fa-pinterest'  => 'Pinterest',
    'fab fa-github'     => 'Github',
    'fas fa-globe'      => 'Website (Globe)',
    'fas fa-envelope'   => 'Email',
    'fas fa-phone'      => 'Telepon',
    'fas fa-map-marker-alt' => 'Lokasi/Map',
];
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Kontak Social</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('kontak_social') ?>">Kontak Social</a></li>
        <li class="breadcrumb-item active">Tambah</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus me-1"></i>
            Form Tambah Data
        </div>
        <div class="card-body">
            
            <?php if (session()->has('errors')): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif ?>

            <form action="<?= base_url('kontak_social') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="platform" class="form-label">Nama Platform <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="platform" name="platform" value="<?= old('platform') ?>" placeholder="Contoh: Instagram" required>
                </div>

                <div class="mb-3">
                    <label for="icon_class" class="form-label">Pilih Icon <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <!-- Preview Icon Default -->
                        <span class="input-group-text" id="icon-preview-box">
                            <i id="icon-preview" class="<?= old('icon_class', 'fas fa-icons') ?>"></i>
                        </span>
                        
                        <select class="form-select" id="icon_class" name="icon_class" required onchange="updateIconPreview(this)">
                            <option value="">-- Pilih Icon --</option>
                            <?php foreach ($socialIcons as $class => $label): ?>
                                <option value="<?= $class ?>" <?= old('icon_class') == $class ? 'selected' : '' ?>>
                                    <?= $label ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-text">Pilih icon yang sesuai dengan platform.</div>
                </div>

                <div class="mb-3">
                    <label for="link_url" class="form-label">Link URL <span class="text-danger">*</span></label>
                    <input type="url" class="form-control" id="link_url" name="link_url" value="<?= old('link_url') ?>" placeholder="https://..." required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="urutan" class="form-label">Urutan</label>
                        <input type="number" class="form-control" id="urutan" name="urutan" value="<?= old('urutan', 0) ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="aktif" <?= old('status') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="nonaktif" <?= old('status') == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="<?= base_url('kontak_social') ?>" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function updateIconPreview(selectElement) {
        var iconClass = selectElement.value;
        // Jika belum pilih, set icon default
        if(iconClass === "") iconClass = "fas fa-icons";
        
        var previewIcon = document.getElementById('icon-preview');
        previewIcon.className = iconClass;
    }
</script>

<?= $this->endSection() ?>