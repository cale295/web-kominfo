<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>📷 Daftar Foto</h3>
        <div>
            <a href="<?= site_url('gallery/new') ?>" class="btn btn-primary">+ Tambah Foto</a>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <table class="table table-bordered table-striped align-middle">
        <thead>
            <tr class="text-center">
                <th>#</th>
                <th>Judul Foto</th>
                <th>Deskripsi</th>
                <th>Album</th>
                <th>File</th>
                <th>Tanggal Upload</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($gallery)): ?>
                <?php foreach ($gallery as $i => $row): ?>
                    <tr>
                        <td class="text-center"><?= $i + 1 ?></td>
                        <td><?= esc($row['photo_title']) ?></td>
                        <td><?= esc($row['deskripsi']) ?></td>
                        <td><?= esc($row['album_name'] ?? '-') ?></td>
                        <td class="text-center">
                            <?php if (!empty($row['file_path'])): ?>
                                <img src="<?= base_url('uploads/gallery/' . $row['file_path']) ?>" width="80" height="80" class="rounded shadow-sm">
                            <?php else: ?>
                                <span class="text-muted">Tidak ada file</span>
                            <?php endif; ?>
                        </td>
                        <td><?= esc($row['created_at']) ?></td>
                        <td class="text-center">
                            <a href="<?= site_url('gallery/' . $row['id_photo'] . '/edit') ?>" class="btn btn-sm btn-warning">Edit</a>

                            <form action="<?= site_url('gallery/' . $row['id_photo']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus foto ini?')">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6" class="text-center text-muted">Belum ada foto.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
