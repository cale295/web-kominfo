<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Footer OPD</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/footer_opd">Footer OPD</a></li>
        <li class="breadcrumb-item active">Tambah Baru</li>
    </ol>

    <div class="card mb-4 shadow-sm">
        <div class="card-header">
            <i class="fas fa-plus me-1"></i> Form Tambah Data
        </div>
        <div class="card-body">
            <form action="/footer_opd" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="website_name" class="form-label">Nama Website <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="website_name" name="website_name" value="<?= old('website_name') ?>" required placeholder="Contoh: tangerangkota.go.id">
                    </div>
                    <div class="col-md-6">
                        <label for="official_title" class="form-label">Judul Resmi (Official Title) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="official_title" name="official_title" value="<?= old('official_title') ?>" required placeholder="Contoh: Official Website of Tangerang City Government">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="address" name="address" rows="3" required><?= old('address') ?></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?= old('phone') ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Link Url Logo</label>
                        <input type="text" class="form-control" id="link_url_logo" name="link_url_logo" value="<?= old('link_url_logo') ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <!-- Logo Kominfo -->
                    <div class="col-md-6">
                        <label for="logo_cominfo" class="form-label">Logo Kominfo</label>
                        <!-- Preview Container -->
                        <div class="mb-2">
                            <img id="preview_logo" src="#" alt="Preview Logo" class="d-none img-thumbnail" style="height: 100px; object-fit: contain;">
                        </div>
                        <input class="form-control" type="file" id="logo_cominfo" name="logo_cominfo" accept="image/*" onchange="previewImage(this, 'preview_logo')">
                        <div class="form-text">Format: JPG, PNG. Maksimal 2MB.</div>
                    </div>

                    <!-- Election Badge -->
                    <div class="col-md-6">
                        <label for="election_badge" class="form-label">Badge Pemilu / Lainnya</label>
                        <!-- Preview Container -->
                        <div class="mb-2">
                            <img id="preview_badge" src="#" alt="Preview Badge" class="d-none img-thumbnail" style="height: 100px; object-fit: contain;">
                        </div>
                        <input class="form-control" type="file" id="election_badge" name="election_badge" accept="image/*" onchange="previewImage(this, 'preview_badge')">
                        <div class="form-text">Format: JPG, PNG. Maksimal 2MB.</div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input type="hidden" name="is_active" value="0">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?= old('is_active', 1) == 1 ? 'checked' : '' ?>>
                        <label class="form-check-label" for="is_active">Status Aktif</label>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="/footer_opd" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none'); // Tampilkan gambar
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = "#";
            preview.classList.add('d-none'); // Sembunyikan jika batal pilih
        }
    }
</script>
<?= $this->endSection() ?>