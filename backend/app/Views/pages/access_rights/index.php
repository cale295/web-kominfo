<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/pages/access_rights/index.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header-gov">
        <h3>
            <i class="bi bi-shield-lock-fill"></i>
            <?= esc($title) ?>
        </h3>
        <p>Kelola hak akses dan permission untuk setiap role pengguna</p>
    </div>

    <!-- Alert Success -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success-gov alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Filter & Sort Card -->
    <div class="card filter-card-gov">
        <div class="card-body">
            <form method="get" class="row g-3 align-items-end">
                <div class="col-lg-4 col-md-6">
                    <label for="filter" class="filter-label">
                        <i class="bi bi-search"></i>
                        Pencarian
                    </label>
                    <input type="text" 
                           class="form-control form-control-gov" 
                           name="filter" 
                           id="filter" 
                           placeholder="Cari role atau module..." 
                           value="<?= esc($filter ?? '') ?>">
                </div>

                <div class="col-lg-4 col-md-6">
                    <label for="sort" class="filter-label">
                        <i class="bi bi-sort-down"></i>
                        Urutkan Berdasarkan
                    </label>
                    <select class="form-select form-select-gov" name="sort" id="sort">
                        <option value="">-- Pilih Urutan --</option>
                        <option value="role_asc" <?= (isset($sort) && $sort == 'role_asc') ? 'selected' : '' ?>>
                            Role (A → Z)
                        </option>
                        <option value="role_desc" <?= (isset($sort) && $sort == 'role_desc') ? 'selected' : '' ?>>
                            Role (Z → A)
                        </option>
                        <option value="module_asc" <?= (isset($sort) && $sort == 'module_asc') ? 'selected' : '' ?>>
                            Module (A → Z)
                        </option>
                        <option value="module_desc" <?= (isset($sort) && $sort == 'module_desc') ? 'selected' : '' ?>>
                            Module (Z → A)
                        </option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <button type="submit" class="btn btn-apply-filter w-100">
                        <i class="bi bi-funnel me-1"></i>
                        Terapkan
                    </button>
                </div>

                <div class="col-lg-2 col-md-6">
                    <a href="/access_rights" class="btn btn-reset-filter w-100">
                        <i class="bi bi-arrow-clockwise me-1"></i>
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Access Rights Table Card -->
    <div class="card table-card-gov">
        <!-- Header -->
        <div class="table-card-header">
            <i class="bi bi-table"></i>
            <span>Daftar Hak Akses & Permission</span>
        </div>

        <!-- Optional Stats Summary -->
        <?php if (!empty($accessList)): ?>
        <div class="stats-summary">
            <div class="stat-item">
                <div class="stat-label">Total Akses</div>
                <div class="stat-value"><?= count($accessList) ?></div>
            </div>
            <div class="stat-item">
                <div class="stat-label">Unique Roles</div>
                <div class="stat-value"><?= count(array_unique(array_column($accessList, 'role'))) ?></div>
            </div>
            <div class="stat-item">
                <div class="stat-label">Modules</div>
                <div class="stat-value"><?= count(array_unique(array_column($accessList, 'module_name'))) ?></div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-gov table-hover mb-0">
                <thead>
                    <tr>
                        <th>Role</th>
                        <th>Module</th>
                        <th>Create</th>
                        <th>Read</th>
                        <th>Update</th>
                        <th>Delete</th>
                        <th>Publish</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($accessList)): ?>
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <h5>Belum Ada Data Hak Akses</h5>
                                    <p>Silakan tambahkan konfigurasi hak akses untuk memulai</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($accessList as $a): ?>
                            <tr>
                                <td class="role-cell">
                                    <i class="bi bi-person-badge me-2" style="color: var(--primary-gov);"></i>
                                    <strong><?= esc($a['role']) ?></strong>
                                </td>
                                <td class="module-cell">
                                    <i class="bi bi-box me-2" style="color: #64748b;"></i>
                                    <?= esc($a['module_name']) ?>
                                </td>
                                <td>
                                    <span class="permission-badge <?= $a['can_create'] ? 'permission-yes' : 'permission-no' ?>">
                                        <?= $a['can_create'] ? 'Yes' : 'No' ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="permission-badge <?= $a['can_read'] ? 'permission-yes' : 'permission-no' ?>">
                                        <?= $a['can_read'] ? 'Yes' : 'No' ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="permission-badge <?= $a['can_update'] ? 'permission-yes' : 'permission-no' ?>">
                                        <?= $a['can_update'] ? 'Yes' : 'No' ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="permission-badge <?= $a['can_delete'] ? 'permission-yes' : 'permission-no' ?>">
                                        <?= $a['can_delete'] ? 'Yes' : 'No' ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="permission-badge <?= $a['can_publish'] ? 'permission-yes' : 'permission-no' ?>">
                                        <?= $a['can_publish'] ? 'Yes' : 'No' ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="/access_rights/edit/<?= $a['id_access'] ?>" 
                                       class="btn-edit-access">
                                        <i class="bi bi-pencil-square"></i>
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Auto-submit filter on sort change (optional)
document.getElementById('sort').addEventListener('change', function() {
    if (this.value) {
        this.closest('form').submit();
    }
});

// Highlight search results
const filterInput = document.getElementById('filter');
if (filterInput && filterInput.value) {
    const searchTerm = filterInput.value.toLowerCase();
    const rows = document.querySelectorAll('.table-gov tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.backgroundColor = '#fef3c7';
            setTimeout(() => {
                row.style.transition = 'background-color 1s ease';
                row.style.backgroundColor = '';
            }, 2000);
        }
    });
}
</script>
<?= $this->endSection() ?>