<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1 fw-bold"><?= esc($title) ?></h3>
            <p class="text-muted mb-0">Kelola menu dan submenu yang tampil di sistem.</p>
        </div>
        <?php if ($can_create): ?>
            <a href="<?= site_url('menu/create') ?>" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-lg me-2"></i>Tambah Menu
            </a>
        <?php endif; ?>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i><?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;" class="ps-3">#</th>
                            <th>Nama Menu</th>
                            <th>URL</th>
                            <th>Status</th>
                            <th class="text-end pe-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $parents = array_filter($menus, fn($m) => $m['parent_id'] == 0);
                        $children = array_filter($menus, fn($m) => $m['parent_id'] != 0);
                        $counter = 1;

                        foreach ($parents as $parent):
                        ?>
                            <tr class="fw-bold table-primary">
                                <td class="ps-3"><?= $counter++ ?></td>
                                <td>
                                    <i class="<?= esc($parent['menu_icon']) ?> me-2"></i>
                                    <?= esc($parent['menu_name']) ?>
                                </td>
                                <td><?= esc($parent['menu_url']) ?: '-' ?></td>
                                <td>
                                    <?= ($parent['status'] === 'active') ? '<span class="badge bg-success-subtle text-success-emphasis">Aktif</span>' : '<span class="badge bg-secondary-subtle text-secondary-emphasis">Nonaktif</span>' ?>
                                </td>
                                <td class="text-end pe-3">
                                    <div class="btn-group btn-group-sm">
                                        <?php if ($can_update): ?>
                                            <form action="<?= site_url('menu/toggleStatus/' . $parent['id_menu']) ?>" method="post" class="d-inline">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="<?= ($parent['status'] === 'active') ? 'Nonaktifkan' : 'Aktifkan' ?>">
                                                    <i class="bi <?= ($parent['status'] === 'active') ? 'bi-toggle-on text-success' : 'bi-toggle-off' ?>"></i>
                                                </button>
                                            </form>
                                            <a href="<?= site_url('menu/edit/' . $parent['id_menu']) ?>" class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="Edit Menu">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>

                            <?php foreach ($children as $child):
                                if ($child['parent_id'] == $parent['id_menu']):
                            ?>
                                <tr>
                                    <td class="ps-3"><?= $counter++ ?></td>
                                    <td class="ps-4">
                                        <span class="me-2 text-muted">↳</span>
                                        <i class="<?= esc($child['menu_icon']) ?> me-2"></i>
                                        <?= esc($child['menu_name']) ?>
                                    </td>
                                    <td><?= esc($child['menu_url']) ?: '-' ?></td>
                                    <td>
                                       <?= ($child['status'] === 'active') ? '<span class="badge bg-success-subtle text-success-emphasis">Aktif</span>' : '<span class="badge bg-secondary-subtle text-secondary-emphasis">Nonaktif</span>' ?>
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="btn-group btn-group-sm">
                                            <?php if ($can_update): ?>
                                                <form action="<?= site_url('menu/toggleStatus/' . $child['id_menu']) ?>" method="post" class="d-inline form-toggle-status">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="<?= ($child['status'] === 'active') ? 'Nonaktifkan' : 'Aktifkan' ?>">
                                                        <i class="bi <?= ($child['status'] === 'active') ? 'bi-toggle-on text-success' : 'bi-toggle-off' ?>"></i>
                                                    </button>
                                                </form>
                                                <a href="<?= site_url('menu/edit/' . $child['id_menu']) ?>" class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="Edit Menu">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                                endif;
                            endforeach;
                            ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.querySelectorAll('.form-toggle-status').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault(); // cegah reload halaman

        const url = this.action;
        const formData = new FormData(this);

        fetch(url, {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // ubah ikon & badge status tanpa reload
                const btn = this.querySelector('button i');
                const row = this.closest('tr');
                const badgeCell = row.querySelector('td:nth-child(4)');

                if (data.newStatus === 'active') {
                    btn.classList.remove('bi-toggle-off');
                    btn.classList.add('bi-toggle-on', 'text-success');
                    badgeCell.innerHTML = '<span class="badge bg-success-subtle text-success-emphasis">Aktif</span>';
                } else {
                    btn.classList.remove('bi-toggle-on', 'text-success');
                    btn.classList.add('bi-toggle-off');
                    badgeCell.innerHTML = '<span class="badge bg-secondary-subtle text-secondary-emphasis">Nonaktif</span>';
                }
            } else {
                alert(data.message || 'Gagal memperbarui status');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan');
        });
    });
});
</script>

<?= $this->endSection() ?>