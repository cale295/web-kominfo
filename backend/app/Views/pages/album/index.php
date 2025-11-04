<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="d-flex justify-content-between mb-3">
        <h3><?= esc($title) ?></h3>
        <div>
            <a href="<?= site_url('album/trash') ?>" class="btn btn-secondary">🗑️ Sampah</a>
            <a href="<?= site_url('album/new') ?>" class="btn btn-primary">➕ Tambah Album</a>
        </div>
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
                <a href="<?= site_url('album/'.$row['id_album'].'/edit') ?>" class="btn btn-sm btn-warning">Edit</a>
                <form action="<?= site_url('album/'.$row['id_album']) ?>" method="post" style="display:inline;">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Pindahkan ke sampah?')">Sampah</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<?= $this->endSection() ?>
