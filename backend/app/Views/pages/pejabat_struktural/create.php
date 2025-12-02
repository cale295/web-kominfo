<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Data</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('pejabat_struktural') ?>">Pejabat Struktural</a></li>
        <li class="breadcrumb-item active">Tambah</li>
    </ol>

    <div class="card mb-4 shadow-sm">
        <div class="card-header">
            <i class="fas fa-plus me-1"></i> Form Tambah Pejabat Struktural
        </div>
        <div class="card-body">
            
            <?= $this->include('layouts/alerts') ?>

            <!-- Perhatikan enctype untuk upload file -->
            <form action="<?= base_url('pejabat_struktural') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Halaman <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" value="<?= old('title') ?>" placeholder="Contoh: Daftar Pejabat Struktural" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Sub Judul</label>
                            <input type="text" name="subtitle" class="form-control" value="<?= old('subtitle') ?>" placeholder="Contoh: Dinas Komunikasi dan Informatika">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="4"><?= old('description') ?></textarea>
                        </div>
                    </div>

                    <!-- Kolom Kanan (Gambar & Status) -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                            <select name="is_active" class="form-select">
                                <option value="1" <?= old('is_active') == '1' ? 'selected' : '' ?>>Aktif</option>
                                <option value="0" <?= old('is_active') == '0' ? 'selected' : '' ?>>Nonaktif</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Upload Gambar Struktur <span class="text-danger">*</span></label>
                            <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImg(event)" required>
                            <div class="form-text">Format: JPG, PNG. Max: 5MB.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block fw-bold">Preview:</label>
                            <img id="preview" src="" class="img-fluid rounded border shadow-sm" style="max-height: 250px; display: none;">
                        </div>
                    </div>
                </div>

                <div class="mt-3 border-top pt-3 d-flex justify-content-end gap-2">
                    <a href="<?= base_url('pejabat_struktural') ?>" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImg(event) {
    const preview = document.getElementById('preview');
    const file = event.target.files[0];
    
    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }
}
</script>
<?= $this->endSection() ?>