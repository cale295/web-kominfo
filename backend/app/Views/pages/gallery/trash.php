<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>🗑️ Sampah Foto</h3>
        <a href="<?= site_url('gallery') ?>" class="btn btn-secondary">← Kembali</a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <table class="table table-bordered table-striped align-middle">
        <thead>
            <tr class="text-center">
                <th width="5%">#</th>
                <th>Judul Foto</th>
                <th>Album</th>
                <th>File</th>
                <th>Tanggal Dibuat</th>
                <th width="25%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($gallery)): ?>
                <?php foreach ($gallery as $i => $row): ?>
                    <tr>
                        <td class="text-center"><?= $i + 1 ?></td>
                        <td><?= esc($row['photo_title']) ?></td>
                        <td><?= esc($row['album_name'] ?? '-') ?></td>
                        <td class="text-center">
                            <?php if (!empty($row['file_path'])): ?>
                                <img src="<?= base_url('uploads/gallery/' . $row['file_path']) ?>" 
                                     width="80" height="80" class="rounded shadow-sm" alt="foto">
                            <?php else: ?>
                                <span class="text-muted">Tidak ada file</span>
                            <?php endif; ?>
                        </td>
                        <td><?= esc($row['created_at']) ?></td>
                        <td class="text-center">
                            <a href="<?= site_url('gallery/restore/' . $row['id_photo']) ?>" 
                               class="btn btn-sm btn-success">Restore</a>
                            <a href="<?= site_url('gallery/destroy/' . $row['id_photo']) ?>" 
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Yakin ingin hapus permanen?')">Hapus Permanen</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center text-muted">Tidak ada foto di tong sampah</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
