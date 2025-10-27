<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Daftar Tema</h2>
<a href="<?= site_url('tema/new') ?>" class="btn btn-primary mb-2">Tambah Tema</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Tema</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <?= $this->include('layouts/alerts') ?>

    <tbody>
        <?php foreach($temas as $tema): ?>
        <tr>
            <td><?= $tema['id_tema'] ?></td>
            <td><?= $tema['nama_tema'] ?></td>
            <td>
                <a href="<?= site_url('tema/'.$tema['id_tema'].'/edit') ?>" class="btn btn-warning btn-sm">Edit</a>
                <form action="<?= site_url('tema/'.$tema['id_tema']) ?>" method="post" style="display:inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
