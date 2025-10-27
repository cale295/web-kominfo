<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Edit Tema</h2>

<form action="<?= site_url('tema/'.$tema['id_tema']) ?>" method="post">
    <input type="hidden" name="_method" value="PUT">
    <div class="mb-3">
        <label for="nama_tema" class="form-label">Nama Tema</label>
        <input type="text" class="form-control" name="nama_tema" id="nama_tema" value="<?= $tema['nama_tema'] ?>" required>
    </div>
    <button type="submit" class="btn btn-success">Update</button>
    <a href="<?= site_url('tema') ?>" class="btn btn-secondary">Kembali</a>
</form>

<?= $this->endSection() ?>
