<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <h3>➕ Tambah Tag Baru</h3>
    <a href="<?= site_url('berita_tag') ?>" class="btn btn-secondary mb-3">← Kembali</a>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

<form action="<?= site_url('berita_tag') ?>" method="post">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label for="name" class="form-label">Nama Tag</label>
        <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama tag" required>
    </div>
    <button type="submit" class="btn btn-success">Simpan</button>
</form>

</div>

<?= $this->endSection() ?>
