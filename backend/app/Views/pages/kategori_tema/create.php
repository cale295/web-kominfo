<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Tambah Tema</h2>

<form action="<?= site_url('tema') ?>" method="post">
    <div class="mb-3">
        <label for="nama_tema" class="form-label">Nama Tema</label>
        <input type="text" class="form-control" name="nama_tema" id="nama_tema" required>
    </div>
    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="<?= site_url('tema') ?>" class="btn btn-secondary">Kembali</a>
</form>

<?= $this->endSection() ?>
