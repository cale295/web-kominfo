<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
    <h2>Daftar Menu</h2>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?php if ($can_create): ?>
        <a href="<?= site_url('menu/new') ?>" class="btn btn-primary mb-3">Tambah Menu</a>
    <?php endif; ?>

    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Menu</th>
                <th>URL</th>
                <th>Icon</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($menus as $i => $menu): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= esc($menu['menu_name']) ?></td>
                <td><?= esc($menu['menu_url']) ?></td>
                <td><i class="<?= esc($menu['menu_icon']) ?>"></i></td>
                <td>
                    <?php if ($menu['status'] === 'active'): ?>
                        <span class="badge bg-success">Aktif</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Nonaktif</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($can_update): ?>
                        <!-- Toggle Status Button -->
                        <form action="<?= site_url('menu/toggleStatus/' . $menu['id_menu']) ?>" method="post" class="d-inline">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-sm btn-warning">
                                <?= ($menu['status'] === 'active') ? 'Nonaktifkan' : 'Aktifkan' ?>
                            </button>
                        </form>
                        <!-- Edit Button -->
                        <a href="<?= site_url('menu/edit/' . $menu['id_menu']) ?>" class="btn btn-sm btn-info">Edit</a>
                    <?php endif; ?>

                    <?php if ($can_delete): ?>
                        <!-- Delete Button -->
                        <form action="<?= site_url('menu/' . $menu['id_menu']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus menu ini?');">
                            <?= csrf_field() ?>
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
