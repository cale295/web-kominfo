<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<?php
// Daftar Icon Social Media
$socialIcons = [
    'fab fa-facebook'       => 'Facebook',
    'fab fa-facebook-f'     => 'Facebook (F)',
    'fab fa-twitter'        => 'Twitter',
    'fab fa-instagram'      => 'Instagram',
    'fab fa-linkedin'       => 'LinkedIn',
    'fab fa-linkedin-in'    => 'LinkedIn (In)',
    'fab fa-youtube'        => 'YouTube',
    'fab fa-tiktok'         => 'TikTok',
    'fab fa-whatsapp'       => 'WhatsApp',
    'fab fa-telegram'       => 'Telegram',
    'fab fa-pinterest'      => 'Pinterest',
    'fab fa-github'         => 'Github',
    'fas fa-globe'          => 'Website (Globe)',
    'fas fa-envelope'       => 'Email',
    'fas fa-phone'          => 'Telepon',
    'fas fa-map-marker-alt' => 'Lokasi/Map',
];
?>

<div class="container-fluid px-4">
    <div class="d-flex align-items-center justify-content-between my-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Edit Kontak Social</h1>
            <p class="text-muted small mb-0">Perbarui informasi tautan sosial media.</p>
        </div>
        <ol class="breadcrumb mb-0 bg-transparent p-0">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('kontak_social') ?>" class="text-decoration-none">Kontak Social</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow border-0 rounded-3 mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit me-2"></i>Form Edit Data
                    </h6>
                </div>
                <div class="card-body p-4">
                    
                    <form action="<?= base_url('kontak_social/' . $kontak['id_kontak_social']) ?>" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="PUT">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="platform" class="form-label fw-bold text-secondary small text-uppercase">
                                    Nama Platform <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="platform" name="platform" 
                                       value="<?= old('platform', $kontak['platform']) ?>" 
                                       placeholder="Contoh: Instagram Official" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="icon_class" class="form-label fw-bold text-secondary small text-uppercase">
                                    Pilih Icon <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-text bg-light border-end-0">
                                        <div class="d-flex justify-content-center align-items-center bg-primary text-white rounded-circle shadow-sm" 
                                             style="width: 24px; height: 24px;">
                                            <i id="icon-preview" class="<?= old('icon_class', $kontak['icon_class']) ?>" style="font-size: 0.8rem;"></i>
                                        </div>
                                    </div>
                                    <select class="form-select border-start-0 ps-0 bg-light" id="icon_class" name="icon_class" required onchange="updateIconPreview(this)">
                                        <option value="">-- Pilih Icon --</option>
                                        <?php foreach ($socialIcons as $class => $label): ?>
                                            <option value="<?= $class ?>" <?= old('icon_class', $kontak['icon_class']) == $class ? 'selected' : '' ?>>
                                                <?= $label ?> (<?= $class ?>)
                                            </option>
                                        <?php endforeach; ?>
                                        
                                        <?php if (!array_key_exists($kontak['icon_class'], $socialIcons) && !empty($kontak['icon_class'])): ?>
                                            <option value="<?= $kontak['icon_class'] ?>" selected>Custom (<?= $kontak['icon_class'] ?>)</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="link_url" class="form-label fw-bold text-secondary small text-uppercase">
                                Link URL <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted"><i class="fas fa-link"></i></span>
                                <input type="url" class="form-control" id="link_url" name="link_url" 
                                       value="<?= old('link_url', $kontak['link_url']) ?>" 
                                       placeholder="https://..." required>
                            </div>
                            <div class="form-text small">Pastikan link diawali dengan http:// atau https://</div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="urutan" class="form-label fw-bold text-secondary small text-uppercase">Urutan</label>
                                <input type="number" class="form-control" id="urutan" name="urutan" 
                                       value="<?= old('urutan', $kontak['urutan']) ?>" min="1">
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?= base_url('kontak_social') ?>" class="btn btn-light border shadow-sm px-4">
                                <i class="fas fa-arrow-left me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary shadow-sm px-4">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateIconPreview(selectElement) {
        var iconClass = selectElement.value;
        var previewIcon = document.getElementById('icon-preview');
        
        // Reset class dan set class baru
        previewIcon.className = '';
        
        if(iconClass) {
            previewIcon.className = iconClass;
        } else {
            previewIcon.className = 'fas fa-question'; // Default jika kosong
        }
    }
</script>

<?= $this->endSection() ?>