<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <h3>Tambah Kategori</h3>
    <form action="<?= site_url('kategori') ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label>Nama Kategori</label>
            <input type="text" name="kategori" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="1" selected>Aktif</option>
                <option value="0">Nonaktif</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Tampilkan di Navigasi?</label>
            <select name="is_show_nav" class="form-select">
                <option value="0" selected>Tidak</option>
                <option value="1">Ya</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Urutan Navigasi (sorting_nav)</label>
            <input type="number" name="sorting_nav" class="form-control" placeholder="Misal: 1, 2, 3">
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="<?= site_url('kategori') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection() ?>
