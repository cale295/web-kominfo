<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container py-4">
    <h3>Edit Kategori</h3>
    <form action="<?= site_url('kategori/' . $kategori['id_kategori']) ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">

        <div class="mb-3">
            <label>Nama Kategori</label>
            <input type="text" name="kategori" class="form-control" value="<?= esc($kategori['kategori']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control"><?= esc($kategori['keterangan']) ?></textarea>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="1" <?= $kategori['status'] == 1 ? 'selected' : '' ?>>Aktif</option>
                <option value="0" <?= $kategori['status'] == 0 ? 'selected' : '' ?>>Nonaktif</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Tampilkan di Navigasi?</label>
            <select name="is_show_nav" class="form-select">
                <option value="0" <?= $kategori['is_show_nav'] == '0' ? 'selected' : '' ?>>Tidak</option>
                <option value="1" <?= $kategori['is_show_nav'] == '1' ? 'selected' : '' ?>>Ya</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Urutan Navigasi (sorting_nav)</label>
            <input type="number" name="sorting_nav" class="form-control" value="<?= esc($kategori['sorting_nav']) ?>">
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="<?= site_url('kategori') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection() ?>
