<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

:root {
    --primary-soft: #eef2ff;
    --primary-text: #4f46e5;
    --primary-dark: #4338ca;
    --success-soft: #ecfdf5;
    --success-text: #059669;
    --danger-soft: #fef2f2;
    --danger-text: #dc2626;
    --warning-soft: #fffbeb;
    --warning-text: #d97706;
    --info-soft: #eff6ff;
    --info-text: #3b82f6;
    
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-300: #d1d5db;
    --gray-500: #6b7280;
    --gray-700: #374151;
    --gray-900: #111827;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background: var(--gray-50);
    color: var(--gray-900);
}

/* Gradient Title */
.text-gradient {
    background: linear-gradient(45deg, #4e73df, #224abe);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Modern Card */
.card-modern {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    transition: transform 0.2s ease;
}

/* Soft Buttons */
.btn-soft-primary { 
    background-color: var(--primary-soft); 
    color: var(--primary-text); 
    border: none; 
}
.btn-soft-primary:hover { 
    background-color: #4f46e5; 
    color: white; 
}

.btn-soft-danger { 
    background-color: var(--danger-soft); 
    color: var(--danger-text); 
    border: none; 
}
.btn-soft-danger:hover { 
    background-color: #dc2626; 
    color: white; 
}

/* Table Styling */
.table thead th {
    font-size: 0.75rem;
    letter-spacing: 0.05em;
    color: var(--gray-500);
    border-bottom: 2px solid var(--gray-100);
    text-transform: uppercase;
    font-weight: 600;
    padding: 1rem 0.75rem;
}

.table tbody tr td {
    vertical-align: middle;
    padding: 1rem 0.75rem;
    border-bottom: 1px solid var(--gray-100);
}

.table tbody tr:last-child td {
    border-bottom: none;
}

.table-hover tbody tr:hover {
    background-color: var(--gray-50);
}

/* Parent Row */
.parent-row {
    transition: background-color 0.2s;
}

.parent-row:hover {
    background-color: var(--gray-50);
}

.parent-row.expanded {
    background-color: var(--gray-50);
}

.parent-row.cursor-pointer {
    cursor: pointer;
}

/* Child Row */
.child-row {
    background: var(--gray-50);
    display: none;
}

.child-row:hover {
    background: var(--gray-100);
}

.child-row.show {
    display: table-row;
    animation: fadeInRow 0.3s ease;
}

@keyframes fadeInRow {
    from {
        opacity: 0;
        transform: translateY(-5px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Toggle Icon */
.toggle-icon {
    transition: transform 0.2s;
    display: inline-block;
    font-size: 0.875rem;
    color: var(--gray-500);
}

.parent-row.expanded .toggle-icon {
    transform: rotate(90deg);
    color: var(--primary-text);
}

/* Menu Icon Box */
.menu-icon-box {
    width: 45px;
    height: 45px;
    background: white;
    border-radius: 10px;
    border: 1px solid var(--gray-200);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-text);
    font-size: 1rem;
    flex-shrink: 0;
}

.menu-icon-small {
    width: 32px;
    height: 32px;
    background: var(--gray-100);
    border-radius: 0.375rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gray-700);
    font-size: 0.875rem;
}

/* Tree Line */
.tree-line {
    position: relative;
    padding-left: 28px;
    margin-left: 16px;
}

.tree-line::before {
    content: "";
    position: absolute;
    left: 0;
    top: 50%;
    width: 20px;
    height: 1px;
    background: var(--gray-300);
}

.tree-line::after {
    content: "";
    position: absolute;
    left: 0;
    top: -100%;
    width: 1px;
    height: 200%;
    background: var(--gray-300);
}

/* Badges */
.badge-number {
    background: var(--gray-100);
    color: var(--gray-700);
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    font-size: 0.75rem;
    font-weight: 600;
}

.submenu-count {
    background: var(--gray-200);
    color: var(--gray-700);
    padding: 0.125rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.7rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}

/* Code Display */
code {
    background: var(--gray-100);
    color: var(--gray-900);
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    font-size: 0.8125rem;
    font-family: 'Courier New', monospace;
    font-weight: 500;
    border: 1px solid var(--gray-200);
}

/* Modal Styling */
.modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 1rem 1rem 0 0;
    border: none;
    padding: 1.5rem;
}

.modal-content {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.modal-header .modal-title {
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.modal-header .btn-close {
    filter: brightness(0) invert(1);
    opacity: 0.8;
}

.modal-header .btn-close:hover {
    opacity: 1;
}

.modal-body {
    padding: 2rem;
}

.modal-footer {
    padding: 1.5rem 2rem;
    border-top: 1px solid var(--gray-200);
    background: var(--gray-50);
}

/* Form Labels */
.form-label-modal {
    font-weight: 600;
    color: var(--gray-700);
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
}

.required {
    color: var(--danger-text);
}

/* Empty State */
.empty-state {
    padding: 4rem 2rem;
    text-align: center;
}

.empty-state-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    background: var(--gray-100);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: var(--gray-500);
}

/* Icon Preview in Modal */
.icon-preview-modal {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 60px;
    height: 60px;
    background: var(--primary-soft);
    border-radius: 0.5rem;
    color: var(--primary-text);
    font-size: 1.75rem;
}

/* Input Group Enhancement */
.input-group-text {
    background-color: var(--gray-100);
    border-color: var(--gray-300);
    color: var(--gray-600);
}

.form-control:focus,
.form-select:focus {
    border-color: var(--primary-text);
    box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.15);
}

/* Responsive */
@media (max-width: 768px) {
    .table thead th,
    .table tbody td {
        padding: 0.75rem 0.5rem;
        font-size: 0.8125rem;
    }

    .menu-icon-box {
        width: 36px;
        height: 36px;
        font-size: 0.9375rem;
    }
    
    .modal-body {
        padding: 1.5rem;
    }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container-fluid px-4 pb-5">
    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between my-4 py-2">
        <div class="mb-3 mb-md-0">
            <h1 class="h3 fw-bolder mb-1 text-gradient"><?= esc($title) ?></h1>
            <p class="text-muted small mb-0">
                <i class="fas fa-list-ul me-1 text-primary"></i> 
                <?= count($menus) ?> total menu dalam sistem
            </p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded-pill shadow-sm mb-0 border">
                <li class="breadcrumb-item">
                    <a href="/dashboard" class="text-decoration-none fw-bold text-primary small">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item active small" aria-current="page">Menu Management</li>
            </ol>
        </nav>
    </div>

    <!-- Alert Success -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success border-0 shadow-sm border-start border-4 border-success rounded-3 fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center bg-white text-success me-3 shadow-sm rounded-circle" style="width: 32px; height: 32px;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-0">Berhasil!</h6>
                    <small><?= session()->getFlashdata('success') ?></small>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Alert Error -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger border-0 shadow-sm border-start border-4 border-danger rounded-3 fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center bg-white text-danger me-3 shadow-sm rounded-circle" style="width: 32px; height: 32px;">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-0">Terjadi Kesalahan!</h6>
                    <small><?= session()->getFlashdata('error') ?></small>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Card -->
    <div class="card card-modern">
        <div class="card-header bg-white py-4 border-0 d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold text-dark mb-0">Daftar Menu</h5>
                <span class="text-muted small">Kelola struktur menu navigasi sistem</span>
            </div>
            
            <?php if ($can_create): ?>
                <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold mt-3 mt-md-0" 
                        data-bs-toggle="modal" data-bs-target="#menuModal" onclick="openCreateModal()">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Menu
                </button>
            <?php endif; ?>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center py-3" width="5%">#</th>
                            <th class="py-3" width="35%">Nama Menu</th>
                            <th class="py-3" width="20%">URL / Route</th>
                            <th class="py-3" width="15%">Admin URL</th>
                            <th class="text-center py-3" width="12%">Status</th>
                            <th class="text-center py-3" width="13%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $parents = array_filter($menus, fn($m) => $m['parent_id'] == 0 || empty($m['parent_id']));
                        $allChildren = array_filter($menus, fn($m) => !empty($m['parent_id']) && $m['parent_id'] != 0);
                        
                        $groupedChildren = [];
                        foreach ($allChildren as $child) {
                            $groupedChildren[$child['parent_id']][] = $child;
                        }

                        $counter = 1;

                        if (empty($parents)): ?>
                            <tr>
                                <td colspan="6" class="p-0">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">
                                            <i class="fas fa-inbox"></i>
                                        </div>
                                        <h5>Belum Ada Menu</h5>
                                        <p>Mulai dengan menambahkan menu pertama untuk sistem Anda</p>
                                        <?php if ($can_create): ?>
                                            <button type="button" class="btn btn-primary rounded-pill px-4" 
                                                    data-bs-toggle="modal" data-bs-target="#menuModal" onclick="openCreateModal()">
                                                <i class="fas fa-plus-circle me-2"></i>Tambah Menu
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endif;

                        foreach ($parents as $parent):
                            $hasChild = isset($groupedChildren[$parent['id_menu']]);
                        ?>
                            <tr class="parent-row <?= $hasChild ? 'cursor-pointer' : '' ?>" 
                                <?= $hasChild ? 'onclick="toggleRows('.$parent['id_menu'].', this)"' : '' ?>>
                                
                                <td class="text-center">
                                    <span class="badge-number"><?= $counter++ ?></span>
                                </td>
                                
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div style="width: 20px;">
                                            <?php if ($hasChild): ?>
                                                <i class="bi bi-chevron-right toggle-icon"></i>
                                            <?php endif; ?>
                                        </div>

                                        <div class="menu-icon-box">
                                            <i class="<?= esc($parent['menu_icon'] ?: 'bi bi-circle') ?>"></i>
                                        </div>

                                        <div>
                                            <div class="fw-bold text-dark"><?= esc($parent['menu_name']) ?></div>
                                            <?php if($hasChild): ?>
                                                <span class="submenu-count">
                                                    <i class="bi bi-diagram-3" style="font-size: 0.65rem;"></i>
                                                    <?= count($groupedChildren[$parent['id_menu']]) ?> submenu
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                
                                <td>
                                    <?php if(!empty($parent['menu_url']) && $parent['menu_url'] != '#'): ?>
                                        <code><?= esc($parent['menu_url']) ?></code>
                                    <?php else: ?>
                                        <span class="text-muted small fst-italic">—</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if(!empty($parent['admin_url']) && $parent['admin_url'] != '#'): ?>
                                        <code><?= esc($parent['admin_url']) ?></code>
                                    <?php else: ?>
                                        <span class="text-muted small fst-italic">—</span>
                                    <?php endif; ?>
                                </td>
                                
                                <td class="text-center" onclick="event.stopPropagation()">
                                    <?php if ($can_update): ?>
                                        <div class="d-flex justify-content-center" data-bs-toggle="tooltip" title="Klik untuk mengubah status">
                                            <?= btn_toggle($parent['id_menu'], $parent['status'] === 'active' ? 1 : 0, 'menu/toggleStatus') ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="badge <?= ($parent['status'] === 'active') ? 'bg-success' : 'bg-secondary' ?> px-3 py-2">
                                            <?= ($parent['status'] === 'active') ? 'Aktif' : 'Nonaktif' ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                
                                <td class="text-center" onclick="event.stopPropagation()">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <?php if ($can_update): ?>
                                            <button type="button" 
                                                    class="btn btn-soft-primary btn-sm rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center" 
                                                    style="width: 32px; height: 32px;"
                                                    data-bs-toggle="tooltip" title="Edit Menu"
                                                    onclick="openEditModal(<?= htmlspecialchars(json_encode($parent)) ?>)">
                                                <i class="fas fa-pen fa-xs"></i>
                                            </button>
                                        <?php endif; ?>

                                        <?php if ($can_delete): ?>
                                            <button type="button" 
                                                    class="btn btn-soft-danger btn-sm rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center" 
                                                    style="width: 32px; height: 32px;"
                                                    data-bs-toggle="tooltip" title="Hapus Menu"
                                                    onclick="deleteMenu(<?= $parent['id_menu'] ?>, '<?= esc($parent['menu_name']) ?>')">
                                                <i class="fas fa-trash-alt fa-xs"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>

                            <?php if ($hasChild): 
                                foreach ($groupedChildren[$parent['id_menu']] as $child):
                            ?>
                                <tr class="child-row child-of-<?= $parent['id_menu'] ?>">
                                    <td></td>
                                    <td>
                                        <div class="d-flex align-items-center ps-4">
                                            <div class="tree-line">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="menu-icon-small">
                                                        <i class="<?= esc($child['menu_icon'] ?: 'bi bi-circle') ?>"></i>
                                                    </div>
                                                    <span class="fw-bold text-dark"><?= esc($child['menu_name']) ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if(!empty($child['menu_url']) && $child['menu_url'] != '#'): ?>
                                            <code><?= esc($child['menu_url']) ?></code>
                                        <?php else: ?>
                                            <span class="text-muted small fst-italic">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if(!empty($child['admin_url']) && $child['admin_url'] != '#'): ?>
                                            <code><?= esc($child['admin_url']) ?></code>
                                        <?php else: ?>
                                            <span class="text-muted small fst-italic">—</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td class="text-center">
                                        <?php if ($can_update): ?>
                                            <div class="d-flex justify-content-center" data-bs-toggle="tooltip" title="Klik untuk mengubah status">
                                                <?= btn_toggle($child['id_menu'], $child['status'] === 'active' ? 1 : 0, 'menu/toggleStatus') ?>
                                            </div>
                                        <?php else: ?>
                                            <span class="badge <?= ($child['status'] === 'active') ? 'bg-success' : 'bg-secondary' ?> px-3 py-2">
                                                <?= ($child['status'] === 'active') ? 'Aktif' : 'Nonaktif' ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <?php if ($can_update): ?>
                                                <button type="button" 
                                                        class="btn btn-soft-primary btn-sm rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center" 
                                                        style="width: 32px; height: 32px;"
                                                        data-bs-toggle="tooltip" title="Edit Submenu"
                                                        onclick="openEditModal(<?= htmlspecialchars(json_encode($child)) ?>)">
                                                    <i class="fas fa-pen fa-xs"></i>
                                                </button>
                                            <?php endif; ?>

                                            <?php if ($can_delete): ?>
                                                <button type="button" 
                                                        class="btn btn-soft-danger btn-sm rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center" 
                                                        style="width: 32px; height: 32px;"
                                                        data-bs-toggle="tooltip" title="Hapus Submenu"
                                                        onclick="deleteMenu(<?= $child['id_menu'] ?>, '<?= esc($child['menu_name']) ?>')">
                                                    <i class="fas fa-trash-alt fa-xs"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php 
                                endforeach; 
                            endif; ?>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card-footer bg-white border-top-0 py-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="d-flex align-items-center text-muted small">
                    <i class="fas fa-info-circle me-2 text-primary"></i>
                    <span>Gunakan kolom <strong>Status</strong> untuk mengaktifkan/menonaktifkan menu.</span>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-info px-3 py-2">
                        <i class="fas fa-list-ul me-1"></i>
                        Total Menu: <?= count($menus) ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah/Edit Menu -->
<div class="modal fade" id="menuModal" tabindex="-1" aria-labelledby="menuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="menuModalLabel">
                    <i class="fas fa-plus-square me-2"></i>
                    <span id="modalTitle">Tambah Menu Baru</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="menuForm" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <input type="hidden" name="id_menu" id="id_menu" value="">
                
                <div class="modal-body" style="overflow-y: auto; max-height: 70vh;">
                    <!-- Informasi Dasar -->
                    <div class="mb-4">
                        <h6 class="text-primary fw-bold mb-3">
                            <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="menu_name" class="form-label-modal">
                                    <i class="fas fa-tag me-1"></i>
                                    Nama Menu <span class="required">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                    <input type="text" class="form-control" id="menu_name" name="menu_name" 
                                           placeholder="Contoh: Dashboard, Berita, Produk" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="menu_icon" class="form-label-modal">
                                    <i class="fas fa-icons me-1"></i>Icon Menu
                                </label>
                                <div class="d-flex gap-2">
                                    <div class="flex-grow-1">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-star"></i></span>
                                            <input type="text" class="form-control" id="menu_icon" name="menu_icon" 
                                                   placeholder="bi-house, bi-gear, fas fa-home...">
                                        </div>
                                    </div>
                                    <div class="icon-preview-modal" id="iconPreview">
                                        <i class="bi bi-question-circle"></i>
                                    </div>
                                </div>
                                <div class="form-text">
                                    <i class="fas fa-lightbulb text-warning me-1"></i>
                                    Gunakan Bootstrap Icons (bi-*) atau Font Awesome (fas fa-*)
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="parent_id" class="form-label-modal">
                                <i class="fas fa-sitemap me-1"></i>
                                Parent Menu (Menu Induk)
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-folder-tree"></i></span>
                                <select class="form-select" id="parent_id" name="parent_id">
                                    <option value="0">📌 Menu Utama (Tanpa Parent)</option>
                                    <?php foreach ($parents as $p): ?>
                                        <option value="<?= $p['id_menu'] ?>">
                                            <?= esc($p['menu_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-text">
                                <i class="fas fa-info-circle text-info me-1"></i>
                                Pilih menu induk jika ingin membuat submenu
                            </div>
                        </div>
                    </div>

                    <!-- URL & Route -->
                    <div class="mb-4">
                        <h6 class="text-primary fw-bold mb-3">
                            <i class="fas fa-link me-2"></i>URL & Route
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="menu_url" class="form-label-modal">
                                    <i class="fas fa-external-link-alt me-1"></i>
                                    URL Menu (Frontend)
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                    <input type="text" class="form-control" id="menu_url" name="menu_url" 
                                           placeholder="/home, /about, /products">
                                </div>
                                <div class="form-text">
                                    Gunakan '#' untuk menu tanpa link atau sebagai parent
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="admin_url" class="form-label-modal">
                                    <i class="fas fa-user-shield me-1"></i>
                                    Admin URL (Backend)
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="text" class="form-control" id="admin_url" name="admin_url" 
                                           placeholder="/admin/dashboard, /admin/users">
                                </div>
                                <div class="form-text">
                                    URL untuk akses admin/backend (opsional)
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pengaturan Tambahan -->
                    <div class="mb-4">
                        <h6 class="text-primary fw-bold mb-3">
                            <i class="fas fa-cog me-2"></i>Pengaturan Tambahan
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="menu_order" class="form-label-modal">
                                    <i class="fas fa-sort-numeric-down me-1"></i>
                                    Urutan Menu
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-sort"></i></span>
                                    <input type="number" class="form-control" id="menu_order" name="menu_order" 
                                           value="0" min="0" placeholder="0">
                                </div>
                                <div class="form-text">
                                    Semakin kecil angka, semakin atas posisinya
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label-modal">
                                    <i class="fas fa-toggle-on me-1"></i>
                                    Status Menu
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-power-off"></i></span>
                                    <select class="form-select" id="status" name="status">
                                        <option value="active" selected>✅ Aktif</option>
                                        <option value="inactive">❌ Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Catatan -->
                    <div class="alert alert-info border-0 d-flex align-items-start">
                        <i class="fas fa-info-circle me-2 mt-1"></i>
                        <div>
                            <strong>Tips:</strong>
                            <ul class="mb-0 mt-2 ps-3">
                                <li>Field bertanda <span class="text-danger">*</span> wajib diisi</li>
                                <li>Icon harus menggunakan class yang valid (Bootstrap Icons atau Font Awesome)</li>
                                <li>URL bisa diisi '#' jika menu hanya sebagai parent/kategori</li>
                                <li>Urutan menu dimulai dari 0 (paling atas)</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-2"></i>
                        <span id="submitBtnText">Simpan Menu</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Toggle child rows
function toggleRows(parentId, row) {
    const children = document.querySelectorAll('.child-of-' + parentId);
    const isExpanded = row.classList.contains('expanded');
    
    if (isExpanded) {
        row.classList.remove('expanded');
        children.forEach(child => {
            child.classList.remove('show');
        });
    } else {
        row.classList.add('expanded');
        children.forEach(child => {
            child.classList.add('show');
        });
    }
}

// Icon preview
document.getElementById('menu_icon')?.addEventListener('input', function() {
    const iconClass = this.value.trim();
    const preview = document.getElementById('iconPreview');
    
    if (iconClass) {
        preview.innerHTML = '<i class="' + iconClass + '"></i>';
    } else {
        preview.innerHTML = '<i class="bi bi-question-circle"></i>';
    }
});

// Open create modal
function openCreateModal() {
    document.getElementById('menuModalLabel').innerHTML = '<i class="fas fa-plus-square me-2"></i>Tambah Menu Baru';
    document.getElementById('modalTitle').textContent = 'Tambah Menu Baru';
    document.getElementById('submitBtnText').textContent = 'Simpan Menu';
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('menuForm').action = '<?= base_url('menu/store') ?>';
    document.getElementById('menuForm').reset();
    document.getElementById('id_menu').value = '';
    document.getElementById('status').value = 'active';
    document.getElementById('menu_order').value = '0';
    document.getElementById('parent_id').value = '0';
    document.getElementById('iconPreview').innerHTML = '<i class="bi bi-question-circle"></i>';
}

// Open edit modal
function openEditModal(menu) {
    document.getElementById('menuModalLabel').innerHTML = '<i class="fas fa-edit me-2"></i>Edit Menu';
    document.getElementById('modalTitle').textContent = 'Edit Menu';
    document.getElementById('submitBtnText').textContent = 'Update Menu';
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('menuForm').action = '<?= base_url('menu/update') ?>/' + menu.id_menu;
    
    document.getElementById('id_menu').value = menu.id_menu;
    document.getElementById('menu_name').value = menu.menu_name;
    document.getElementById('menu_icon').value = menu.menu_icon || '';
    document.getElementById('menu_url').value = menu.menu_url || '';
    document.getElementById('admin_url').value = menu.admin_url || '';
    document.getElementById('parent_id').value = menu.parent_id || '0';
    document.getElementById('menu_order').value = menu.menu_order || '0';
    document.getElementById('status').value = menu.status || 'active';
    
    // Update icon preview
    const iconClass = menu.menu_icon || '';
    const preview = document.getElementById('iconPreview');
    if (iconClass) {
        preview.innerHTML = '<i class="' + iconClass + '"></i>';
    } else {
        preview.innerHTML = '<i class="bi bi-question-circle"></i>';
    }
    
    const modal = new bootstrap.Modal(document.getElementById('menuModal'));
    modal.show();
}

// Delete menu confirmation
function deleteMenu(id, name) {
    Swal.fire({
        title: 'Hapus Menu?',
        html: `Anda yakin ingin menghapus menu <strong>${name}</strong>?<br><small class="text-muted">Menu dan semua submenu-nya akan dihapus!</small>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-trash-alt me-2"></i>Ya, Hapus!',
        cancelButtonText: '<i class="fas fa-times me-2"></i>Batal',
        reverseButtons: true,
        customClass: {
            confirmButton: 'btn btn-danger rounded-pill px-4',
            cancelButton: 'btn btn-secondary rounded-pill px-4'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '<?= base_url('menu/delete') ?>/' + id;
        }
    });
}
</script>
<?= $this->endSection() ?>