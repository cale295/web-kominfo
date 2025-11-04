<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <h3><?= esc($title) ?></h3>
    <form action="<?= site_url('album/'.$album['id_album']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">
        <div class="mb-3">
            <label>Nama Album</label>
            <input type="text" name="album_name" value="<?= esc($album['album_name']) ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control"><?= esc($album['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label>Cover Image</label><br>
            <?php if ($album['cover_image']): ?>
                <img src="<?= base_url('uploads/album_covers/'.$album['cover_image']) ?>" width="100" class="mb-2">
            <?php endif; ?>
            <input type="file" name="cover_image" class="form-control">
        </div>
        <button class="btn btn-success">Update</button>
        <a href="<?= site_url('album') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection() ?>

