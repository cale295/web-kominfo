<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="d-flex justify-content-between mb-3">
        <h3><?= esc($title) ?></h3>
        <a href="<?= site_url('album') ?>" class="btn btn-secondary">← Kembali</a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Nama Album</th>
            <th>Deskripsi</th>
            <th>Cover</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($albums as $i => $row): ?>
        <tr>
            <td><?= $i+1 ?></td>
            <td><?= esc($row['album_name']) ?></td>
            <td><?= esc($row['description']) ?></td>
            <td>
                <?php if ($row['cover_image']): ?>
                    <img src="<?= base_url('uploads/album_covers/'.$row['cover_image']) ?>" width="80">
                <?php endif; ?>
            </td>
            <td>
                <a href="<?= site_url('album/restore/'.$row['id_album']) ?>" class="btn btn-sm btn-success">Restore</a>
                <a href="<?= site_url('album/destroy/'.$row['id_album']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus permanen album ini?')">Hapus Permanen</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<?= $this->endSection() ?>
