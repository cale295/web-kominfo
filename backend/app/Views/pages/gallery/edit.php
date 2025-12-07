<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <h3>✏️ Edit Foto</h3>

    <form action="<?= site_url('gallery/' . $photo['id_photo']) ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="PUT">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label for="photo_title" class="form-label">Judul Foto</label>
            <input type="text" name="photo_title" id="photo_title" value="<?= esc($photo['photo_title']) ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi Foto</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" required><?= esc($photo['deskripsi']) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="id_album" class="form-label">Album</label>
            <select name="id_album" id="id_album" class="form-select" required>
                <?php foreach ($albums as $album): ?>
                    <option value="<?= $album['id_album'] ?>" <?= $album['id_album'] == $photo['id_album'] ? 'selected' : '' ?>>
                        <?= esc($album['album_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="file_path" class="form-label">Ganti Foto (opsional)</label><br>
            <?php if (!empty($photo['file_path'])): ?>
                <img src="<?= base_url('uploads/gallery/' . $photo['file_path']) ?>" width="100" class="rounded mb-2"><br>
            <?php endif; ?>
            <input type="file" name="file_path" id="file_path" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">Perbarui</button>
        <a href="<?= site_url('gallery') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection() ?>
