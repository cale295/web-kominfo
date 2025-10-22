<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1 fw-bold">Edit Menu</h3>
            <p class="text-muted mb-0">Ubah informasi menu yang sudah ada.</p>
        </div>
        <a href="<?= site_url('menu') ?>" class="btn btn-secondary shadow-sm">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i><?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form action="<?= site_url('menu/update/' . $menu['id_menu']) ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="menu_name" class="form-label fw-semibold">Nama Menu <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= isset($validation) && $validation->hasError('menu_name') ? 'is-invalid' : '' ?>" 
                               id="menu_name" name="menu_name" value="<?= old('menu_name', esc($menu['menu_name'])) ?>" required>
                        <?php if (isset($validation) && $validation->hasError('menu_name')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('menu_name') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="menu_url" class="form-label fw-semibold">URL Menu</label>
                        <input type="text" class="form-control <?= isset($validation) && $validation->hasError('menu_url') ? 'is-invalid' : '' ?>" 
                               id="menu_url" name="menu_url" value="<?= old('menu_url', esc($menu['menu_url'])) ?>" 
                               placeholder="contoh: dashboard atau admin/users">
                        <?php if (isset($validation) && $validation->hasError('menu_url')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('menu_url') ?>
                            </div>
                        <?php endif; ?>
                        <small class="text-muted">Kosongkan jika menu memiliki submenu</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="menu_icon" class="form-label fw-semibold">Icon Menu <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i id="icon-preview" class="<?= old('menu_icon', esc($menu['menu_icon'])) ?>"></i></span>
                            <input type="text" class="form-control <?= isset($validation) && $validation->hasError('menu_icon') ? 'is-invalid' : '' ?>" 
                                   id="menu_icon" name="menu_icon" value="<?= old('menu_icon', esc($menu['menu_icon'])) ?>" 
                                   placeholder="bi bi-house" required>
                            <?php if (isset($validation) && $validation->hasError('menu_icon')): ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('menu_icon') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <small class="text-muted">Gunakan Bootstrap Icons, contoh: bi bi-house</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="parent_id" class="form-label fw-semibold">Parent Menu</label>
                        <select class="form-select <?= isset($validation) && $validation->hasError('parent_id') ? 'is-invalid' : '' ?>" 
                                id="parent_id" name="parent_id">
                            <option value="0" <?= old('parent_id', $menu['parent_id']) == 0 ? 'selected' : '' ?>>Menu Utama</option>
                            <?php foreach ($parentMenus as $parent): ?>
                                <?php if ($parent['id_menu'] != $menu['id_menu']): // Tidak bisa memilih diri sendiri ?>
                                    <option value="<?= $parent['id_menu'] ?>" <?= old('parent_id', $menu['parent_id']) == $parent['id_menu'] ? 'selected' : '' ?>>
                                        <?= esc($parent['menu_name']) ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($validation) && $validation->hasError('parent_id')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('parent_id') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="menu_order" class="form-label fw-semibold">Urutan Menu</label>
                        <input type="number" class="form-control <?= isset($validation) && $validation->hasError('menu_order') ? 'is-invalid' : '' ?>" 
                               id="menu_order" name="menu_order" value="<?= old('menu_order', esc($menu['menu_order'])) ?>" min="1">
                        <?php if (isset($validation) && $validation->hasError('menu_order')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('menu_order') ?>
                            </div>
                        <?php endif; ?>
                        <small class="text-muted">Semakin kecil angka, semakin atas posisinya</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label fw-semibold">Status</label>
                        <select class="form-select <?= isset($validation) && $validation->hasError('status') ? 'is-invalid' : '' ?>" 
                                id="status" name="status">
                            <option value="active" <?= old('status', $menu['status']) === 'active' ? 'selected' : '' ?>>Aktif</option>
                            <option value="inactive" <?= old('status', $menu['status']) === 'inactive' ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                        <?php if (isset($validation) && $validation->hasError('status')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('status') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="bi bi-trash me-2"></i>Hapus Menu
                    </button>
                    <div>
                        <a href="<?= site_url('menu') ?>" class="btn btn-light me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus menu <strong>"<?= esc($menu['menu_name']) ?>"</strong>?</p>
                <p class="text-danger mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Tindakan ini tidak dapat dibatalkan!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="<?= site_url('menu/delete/' . $menu['id_menu']) ?>" method="post" class="d-inline">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-2"></i>Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Preview icon saat mengetik
document.getElementById('menu_icon').addEventListener('input', function() {
    const iconPreview = document.getElementById('icon-preview');
    iconPreview.className = this.value || 'bi bi-question-circle';
});

// Validasi URL berdasarkan parent_id
document.getElementById('parent_id').addEventListener('change', function() {
    const urlInput = document.getElementById('menu_url');
    if (this.value === '0') {
        urlInput.removeAttribute('required');
    } else {
        urlInput.setAttribute('required', 'required');
    }
});
</script>
<?= $this->endSection() ?>