<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container">
    <h2>Daftar Menu</h2>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
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

                    
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
