<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Data</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('pejabat_struktural') ?>">Pejabat Struktural</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>

    <div class="card mb-4 shadow-sm">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i> Form Edit Pejabat Struktural
        </div>
        <div class="card-body">
            
            <?= $this->include('layouts/alerts') ?>

            <form action="<?= base_url('pejabat_struktural/' . $pejabat['id_pejabat_s']) ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">

                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Halaman <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" value="<?= old('title', $pejabat['title']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Sub Judul</label>
                            <input type="text" name="subtitle" class="form-control" value="<?= old('subtitle', $pejabat['subtitle']) ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="4"><?= old('description', $pejabat['description']) ?></textarea>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    
                        <div class="mb-3">
                            <label class="form-label fw-bold">Ganti Gambar (Opsional)</label>
                            <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImg(event)">
                            <div class="form-text">Biarkan kosong jika tidak ingin mengubah gambar.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block fw-bold">Preview Saat Ini / Baru:</label>
                            <?php $imgSrc = !empty($pejabat['image_url']) ? base_url('uploads/pejabat_struktural/' . $pejabat['image_url']) : ''; ?>
                            
                            <img id="preview" src="<?= $imgSrc ?>" 
                                 class="img-fluid rounded border shadow-sm" 
                                 style="max-height: 250px; <?= empty($imgSrc) ? 'display: none;' : '' ?>">
                        </div>
                    </div>
                </div>

                <div class="mt-3 border-top pt-3 d-flex justify-content-end gap-2">
                    <a href="<?= base_url('pejabat_struktural') ?>" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Data</button>
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
    }
}
</script>
<?= $this->endSection() ?>