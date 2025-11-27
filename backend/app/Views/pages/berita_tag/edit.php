<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container py-4">
    <h3>✏️ Edit Tag</h3>
    <a href="<?= site_url('berita_tag') ?>" class="btn btn-secondary mb-3">← Kembali</a>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= site_url('berita_tag/'.$tag['id_tags']) ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">
        <div class="mb-3">
            <label for="name" class="form-label">Nama Tag</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= esc($tag['nama_tag']) ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>

<?= $this->endSection() ?>
