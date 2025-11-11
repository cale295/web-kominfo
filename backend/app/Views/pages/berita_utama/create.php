<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <h3 class="fw-bold mb-3">➕ Tambah Berita Utama</h3>

    <form action="<?= site_url('berita-utama') ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label fw-semibold">Pilih Berita</label>
            <select name="id_berita" id="id_berita" class="form-select" required>
                <option value="">-- Pilih Berita --</option>
                <?php foreach ($beritas as $b): ?>
                    <option 
                        value="<?= $b['id_berita'] ?>" 
                        data-image="<?= base_url('uploads/berita/' . $b['feat_image']) ?>">
                        <?= esc($b['judul']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Preview Gambar -->
        <div class="mb-3 text-center" id="preview-wrapper" style="display:none;">
            <img id="preview-image" 
                 src="" 
                 alt="Preview Gambar" 
                 class="img-thumbnail" 
                 style="max-height: 200px; object-fit: cover;">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Jenis</label>
            <input type="number" name="jenis" class="form-control" placeholder="contoh: 1 untuk headline utama">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Status</label>
            <select name="status" class="form-select">
                <option value="1">Aktif</option>
                <option value="0">Nonaktif</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-save"></i> Simpan
        </button>
        <a href="<?= site_url('berita-utama') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<!-- Script Preview -->
<script>
document.getElementById('id_berita').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const imageSrc = selectedOption.getAttribute('data-image');
    const previewWrapper = document.getElementById('preview-wrapper');
    const previewImage = document.getElementById('preview-image');

    if (imageSrc && imageSrc !== '<?= base_url('uploads/berita/') ?>') {
        previewImage.src = imageSrc;
        previewWrapper.style.display = 'block';
    } else {
        previewWrapper.style.display = 'none';
    }
});
</script>

<?= $this->endSection() ?>
