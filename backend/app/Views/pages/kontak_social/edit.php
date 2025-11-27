<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php
// Daftar Icon Social Media yang umum digunakan
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
    <h1 class="mt-4">Edit Kontak Social</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('kontak_social') ?>">Kontak Social</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            Form Edit Data
        </div>
        <div class="card-body">

            <!-- Tampilkan Error Validasi -->
            <?php if (session()->has('errors')): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif ?>

            <!-- Route Update menggunakan ID -->
            <form action="<?= base_url('kontak_social/' . $kontak['id_kontak_social']) ?>" method="POST">
                <?= csrf_field() ?>
                <!-- Method Spoofing untuk Resource Route -->
                <input type="hidden" name="_method" value="PUT">

                <div class="mb-3">
                    <label for="platform" class="form-label">Nama Platform <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="platform" name="platform" value="<?= old('platform', $kontak['platform']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="icon_class" class="form-label">Pilih Icon <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <!-- Preview Icon -->
                        <span class="input-group-text" id="icon-preview-box">
                            <i id="icon-preview" class="<?= old('icon_class', $kontak['icon_class']) ?>"></i>
                        </span>
                        
                        <!-- Dropdown Icon -->
                        <select class="form-select" id="icon_class" name="icon_class" required onchange="updateIconPreview(this)">
                            <option value="">-- Pilih Icon --</option>
                            <?php foreach ($socialIcons as $class => $label): ?>
                                <option value="<?= $class ?>" <?= old('icon_class', $kontak['icon_class']) == $class ? 'selected' : '' ?>>
                                    <?= $label ?>
                                </option>
                            <?php endforeach; ?>
                            
                            <!-- Opsi Custom (jika ada data lama yg tidak ada di list) -->
                            <?php if (!array_key_exists($kontak['icon_class'], $socialIcons) && !empty($kontak['icon_class'])): ?>
                                <option value="<?= $kontak['icon_class'] ?>" selected>Custom (<?= $kontak['icon_class'] ?>)</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="form-text">Pilih icon yang sesuai dengan platform.</div>
                </div>

                <div class="mb-3">
                    <label for="link_url" class="form-label">Link URL <span class="text-danger">*</span></label>
                    <input type="url" class="form-control" id="link_url" name="link_url" value="<?= old('link_url', $kontak['link_url']) ?>" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="urutan" class="form-label">Urutan</label>
                        <input type="number" class="form-control" id="urutan" name="urutan" value="<?= old('urutan', $kontak['urutan']) ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="aktif" <?= old('status', $kontak['status']) == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="nonaktif" <?= old('status', $kontak['status']) == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="<?= base_url('kontak_social') ?>" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function updateIconPreview(selectElement) {
        var iconClass = selectElement.value;
        var previewIcon = document.getElementById('icon-preview');
        // Update class pada tag <i>
        previewIcon.className = iconClass;
    }
</script>

<?= $this->endSection() ?>