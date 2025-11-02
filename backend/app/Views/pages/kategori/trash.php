<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container py-4">
    <h3>Trash Kategori</h3>
    <a href="<?= site_url('kategori') ?>" class="btn btn-secondary mb-3">← Kembali</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($kategori)): ?>
                <?php foreach ($kategori as $i => $row): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= esc($row['kategori']) ?></td>
                        <td><?= esc($row['keterangan']) ?></td>
                        <td><?= $row['status'] ? 'Aktif' : 'Nonaktif' ?></td>
                        <td>
                            <a href="<?= site_url('kategori/' . $row['id_kategori'] . '/restore') ?>" class="btn btn-sm btn-success">Restore</a>
                            <form action="<?= site_url('kategori/' . $row['id_kategori'] . '/destroyPermanent') ?>" method="post" style="display:inline;">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus permanen?')">Hapus Permanen</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Trash kosong</td>
                </tr>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
