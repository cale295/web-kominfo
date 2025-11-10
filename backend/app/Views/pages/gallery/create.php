<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <h3>➕ Tambah Foto</h3>

<form action="<?= site_url('gallery') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

                <div class="mb-3">
            <label for="photo_title" class="form-label">Judul Foto</label>
            <input type="text" name="photo_title" id="photo_title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="id_album" class="form-label">Album</label>
            <select name="id_album" id="id_album" class="form-select" required>
                <option value="">-- Pilih Album --</option>
                <?php foreach ($albums as $album): ?>
                    <option value="<?= $album['id_album'] ?>"><?= esc($album['album_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="file_path" class="form-label">Upload Foto</label>
            <input type="file" name="file_path" id="file_path" class="form-control" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="<?= site_url('gallery') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection() ?>
