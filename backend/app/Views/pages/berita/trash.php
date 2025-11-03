<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>🗑️ Berita Dihapus</h3>
        <a href="<?= site_url('berita') ?>" class="btn btn-secondary">← Kembali</a>
    </div>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Judul</th>
                <th>Dihapus Oleh</th>
                <th>Tanggal Hapus</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($berita)): ?>
                <?php foreach ($berita as $i => $row): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= esc($row['judul']) ?></td>
                        <td><?= esc($row['is_delete_by_name']) ?></td>
                        <td><?= date('d M Y H:i', strtotime($row['delete_at'])) ?></td>
                        <td>
                            <a href="<?= site_url('berita/restore/'.$row['id_berita']) ?>" class="btn btn-sm btn-success">♻️ Restore</a>
                            <a href="<?= site_url('berita/destroy/'.$row['id_berita']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus permanen?')">🗑️ Hapus Permanen</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5" class="text-center">Tidak ada berita di sampah</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
