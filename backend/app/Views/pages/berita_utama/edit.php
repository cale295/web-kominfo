<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <h3 class="fw-bold mb-3">✏️ Edit Berita Utama</h3>

    <form action="<?= site_url('berita-utama/' . $utama['id_berita_utama']) ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">

        <!-- Pilih Berita -->
        <div class="mb-3">
            <label class="form-label fw-semibold">Pilih Berita</label>
            <select name="id_berita" id="id_berita" class="form-select" required>
                <?php foreach ($beritaList as $b): ?>
  <option 
    value="<?= $b['id_berita'] ?>" 
    data-image="<?= base_url($b['feat_image']) ?>"
                                                >
    <?= esc($b['judul']) ?>
</option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Preview Gambar -->
        <div class="mb-3 text-center" id="preview-wrapper">
            <img id="preview-image" 
                 src="<?= base_url('uploads/berita/' . $utama['feat_image']) ?>" 
                 alt="Preview Gambar" 
                 class="img-thumbnail" 
                 style="max-height: 200px; object-fit: cover;">
        </div>

        <!-- Jenis -->
        <div class="mb-3">
            <label class="form-label fw-semibold">Jenis</label>
            <input type="number" name="jenis" class="form-control" value="<?= esc($utama['jenis']) ?>">
        </div>

        <!-- Status -->
        <div class="mb-3">
            <label class="form-label fw-semibold">Status</label>
            <select name="status" class="form-select">
                <option value="1" <?= $utama['status'] == 1 ? 'selected' : '' ?>>Aktif</option>
                <option value="0" <?= $utama['status'] == 0 ? 'selected' : '' ?>>Nonaktif</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save"></i> Update
        </button>
        <a href="<?= site_url('backend/berita-utama') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<script>
// Preview gambar saat dropdown berubah
const idBerita = document.getElementById('id_berita');
const previewImage = document.getElementById('preview-image');

idBerita.addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const imageSrc = selectedOption.getAttribute('data-image');

    if (imageSrc) {
        previewImage.src = imageSrc;
    } else {
        previewImage.src = ''; // Kosongkan jika tidak ada gambar
    }
});
</script>

<?= $this->endSection() ?>
