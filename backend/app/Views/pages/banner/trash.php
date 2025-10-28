<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>🗑️ Sampah Banner</h3>
        <a href="<?= site_url('banner') ?>" class="btn btn-secondary">← Kembali</a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?= $this->include('layouts/alerts') ?>

    <?php if (!empty($banners)): ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Dihapus Oleh</th>
                    <th>Tanggal Hapus</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($banners as $b): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($b['title']) ?></td>
                        <td><?= esc($b['category_banner']) ?></td>
                        <td><?= esc($b['is_delete_by_name'] ?? '-') ?></td>
                        <td><?= esc($b['is_delete_at'] ?? '-') ?></td>
                        <td>
                            <a href="<?= site_url('banner/restore/' . $b['id_banner']) ?>" class="btn btn-success btn-sm">
                                Pulihkan
                            </a>
                            <a href="<?= site_url('banner/destroyPermanent/' . $b['id_banner']) ?>"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin ingin menghapus permanen banner ini?')">
                                Hapus Permanen
                            </a>
                        </td>

                        
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning text-center">
            Tidak ada banner di sampah.
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
