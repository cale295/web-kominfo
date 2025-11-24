<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container py-4">

    <h4 class="fw-bold mb-4">Edit Profile</h4>

    <form action="<?= base_url('menu_profile/'.$menu_profile['id_profil']) ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">

        <div class="card shadow-sm">
            <div class="card-body">

                <!-- Title -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Judul Profile</label>
                    <input type="text" name="title" class="form-control"
                           value="<?= esc($menu_profile['title']) ?>" required>
                </div>
                <!-- Content -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Konten</label>
                    <textarea name="content" class="form-control" rows="6"><?= esc($menu_profile['content']) ?></textarea>
                </div>

<div class="mb-3">
    <label class="form-label fw-bold">Type</label>
    <select name="type" class="form-select" required>
        <option value="">-- Pilih Type --</option>
        <option value="page" <?= ($menu_profile['type'] == 'page' ? 'selected' : '') ?>>Page</option>
        <option value="dropdown" <?= ($menu_profile['type'] == 'dropdown' ? 'selected' : '') ?>>Dropdown</option>
        <option value="link" <?= ($menu_profile['type'] == 'link' ? 'selected' : '') ?>>Link</option>
        <option value="file" <?= ($menu_profile['type'] == 'file' ? 'selected' : '') ?>>File</option>
    </select>
</div>


<div class="mb-3">
        <label class="form-label fw-bold">Type</label>
<select name="is_active" class="form-select" required>
    <option value="1" <?= ($menu_profile['is_active'] == 1 ? 'selected' : '') ?>>Aktif</option>
    <option value="0" <?= ($menu_profile['is_active'] == 0 ? 'selected' : '') ?>>Tidak Aktif</option>
</select>

</div>
                <!-- Current Image -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Gambar Saat Ini</label><br>

                    <?php if ($menu_profile['image']): ?>
                        <img src="<?= base_url('uploads/menu_profile/'.$menu_profile['image']) ?>" 
                             class="img-fluid rounded border mb-2"
                             style="max-height:200px;">
                    <?php else: ?>
                        <p class="text-muted">Tidak ada gambar.</p>
                    <?php endif ?>
                </div>

                <!-- Upload New Image -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Ganti Gambar</label>
                    <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImg(event)">
                </div>

                <div class="mb-3">
                    <img id="preview" class="img-fluid rounded border" style="max-height:200px; display:none;">
                </div>

            </div>
        </div>

        <div class="mt-3">
            <button class="btn btn-primary">Update</button>
            <a href="<?= base_url('menu_profile') ?>" class="btn btn-secondary">Kembali</a>
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
