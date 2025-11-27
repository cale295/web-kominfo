<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Social Media</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/footer_social">Social Media</a></li>
        <li class="breadcrumb-item active">Tambah</li>
    </ol>

    <?php if (session()->has('errors')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                <?php foreach (session('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif ?>

    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-plus-circle me-1"></i> Form Tambah Akun</h6>
        </div>
        <div class="card-body">
            <form action="/footer_social" method="post">
                <?= csrf_field() ?>

                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Platform <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="platform_name" placeholder="Contoh: Instagram" value="<?= old('platform_name') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih Icon <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i id="icon-preview" class="fab fa-instagram fs-5"></i></span>
                                <select class="form-select" name="platform_icon" id="platform_icon" required onchange="updateIconPreview()">
                                    <option value="instagram" <?= old('platform_icon') == 'instagram' ? 'selected' : '' ?>>Instagram</option>
                                    <option value="facebook" <?= old('platform_icon') == 'facebook' ? 'selected' : '' ?>>Facebook</option>
                                    <option value="twitter" <?= old('platform_icon') == 'twitter' ? 'selected' : '' ?>>Twitter / X</option>
                                    <option value="youtube" <?= old('platform_icon') == 'youtube' ? 'selected' : '' ?>>YouTube</option>
                                    <option value="tiktok" <?= old('platform_icon') == 'tiktok' ? 'selected' : '' ?>>TikTok</option>
                                    <option value="linkedin" <?= old('platform_icon') == 'linkedin' ? 'selected' : '' ?>>LinkedIn</option>
                                    <option value="whatsapp" <?= old('platform_icon') == 'whatsapp' ? 'selected' : '' ?>>WhatsApp</option>
                                    <option value="telegram" <?= old('platform_icon') == 'telegram' ? 'selected' : '' ?>>Telegram</option>
                                    <option value="globe" <?= old('platform_icon') == 'globe' ? 'selected' : '' ?>>Website (Globe)</option>
                                </select>
                            </div>
                            <div class="form-text">Icon menggunakan FontAwesome Brand Icons.</div>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Akun <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">@</span>
                                <input type="text" class="form-control" name="account_name" placeholder="username" value="<?= old('account_name') ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Link URL <span class="text-danger">*</span></label>
                            <input type="url" class="form-control" name="account_url" placeholder="https://instagram.com/username" value="<?= old('account_url') ?>" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Urutan (Sorting)</label>
                            <input type="number" class="form-control" name="sorting" value="<?= old('sorting', 0) ?>">
                            <div class="form-text">Angka kecil tampil lebih dulu (0, 1, 2...).</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3 pt-4">
                            <div class="form-check form-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?= old('is_active', 1) == 1 ? 'checked' : '' ?>>
                                <label class="form-check-label fw-bold" for="is_active">Status Aktif</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="/footer_social" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function updateIconPreview() {
        const select = document.getElementById('platform_icon');
        const preview = document.getElementById('icon-preview');
        const iconClass = select.value;
        
        // Reset class
        preview.className = '';
        
        // Handle 'globe' as fas (solid), others as fab (brands)
        if(iconClass === 'globe' || iconClass === 'envelope' || iconClass === 'phone') {
            preview.className = `fas fa-${iconClass} fs-5`;
        } else {
            preview.className = `fab fa-${iconClass} fs-5`;
        }
    }
    
    // Run on load
    document.addEventListener('DOMContentLoaded', updateIconPreview);
</script>
<?= $this->endSection() ?>