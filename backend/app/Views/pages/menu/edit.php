<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1 fw-bold">Edit Menu</h3>
            <p class="text-muted mb-0">Perbarui informasi menu.</p>
        </div>
        <a href="<?= site_url('menu') ?>" class="btn btn-secondary shadow-sm">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="<?= site_url('menu/update/' . $menu['id_menu']) ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">

                <div class="mb-3">
                    <label for="menu_name" class="form-label">Nama Menu</label>
                    <input type="text" class="form-control" id="menu_name" name="menu_name" value="<?= esc($menu['menu_name']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="menu_url" class="form-label">URL</label>
                    <input type="text" class="form-control" id="menu_url" name="menu_url" value="<?= esc($menu['menu_url']) ?>">
                </div>

                <div class="mb-3">
                    <label for="menu_icon" class="form-label">Icon (kelas bootstrap/icons)</label>
                    <input type="text" class="form-control" id="menu_icon" name="menu_icon" value="<?= esc($menu['menu_icon']) ?>">
                </div>

                <div class="mb-3">
                    <label for="parent_id" class="form-label">Parent Menu</label>
                    <select class="form-select" id="parent_id" name="parent_id">
                        <option value="0" <?= $menu['parent_id'] == 0 ? 'selected' : '' ?>>Menu Utama</option>
                        <?php foreach ($menus as $m): ?>
                            <?php if ($m['id_menu'] != $menu['id_menu']): // hindari memilih dirinya sendiri ?>
                                <option value="<?= $m['id_menu'] ?>" <?= $menu['parent_id'] == $m['id_menu'] ? 'selected' : '' ?>>
                                    <?= esc($m['menu_name']) ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="active" <?= $menu['status'] === 'active' ? 'selected' : '' ?>>Aktif</option>
                        <option value="inactive" <?= $menu['status'] === 'inactive' ? 'selected' : '' ?>>Nonaktif</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
