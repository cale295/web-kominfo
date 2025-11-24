<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container py-4">

    <h4 class="fw-bold mb-4">Tambah Profile</h4>

    <form action="<?= site_url('menu_profile') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="card shadow-sm">
            <div class="card-body">

                <!-- Title -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Judul Profile</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="4"></textarea>
                </div>

                <!-- Content -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Konten</label>
                    <textarea name="content" class="form-control" rows="6"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Sorting</label>
                    <input type="number" name="sorting" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Is Active</label>
                    <select name="is_active" class="form-select" required>
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                </div>

<div class="mb-3">
    <label class="form-label fw-bold">Type</label>
    <select name="type" class="form-select" required>
        <option value="">-- Pilih Type --</option>
        <option value="1" <?= (old('type') == 1 ? 'selected' : '') ?>>Page</option>
        <option value="2" <?= (old('type') == 2 ? 'selected' : '') ?>>Dropdown</option>
        <option value="3" <?= (old('type') == 3 ? 'selected' : '') ?>>Link</option>
        <option value="4" <?= (old('type') == 4 ? 'selected' : '') ?>>File</option>
    </select>
</div>


                <!-- Image Upload -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Gambar</label>
                    <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImg(event)">
                </div>

                <div class="mb-3">
                    <img id="preview" src="" class="img-fluid rounded border" style="max-height:200px; display:none;">
                </div>

            </div>
        </div>

        <div class="mt-3">
            <button class="btn btn-primary">Simpan</button>
            <a href="<?= base_url('profile') ?>" class="btn btn-secondary">Kembali</a>
        </div>

    </form>
</div>

<script>
function previewImg(event) {
    let preview = document.getElementById('preview');
    preview.src = URL.createObjectURL(event.target.files[0]);
    preview.style.display = 'block';
}
</script>

<?= $this->endSection() ?>
