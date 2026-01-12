<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

/* ===============================
   DESIGN SYSTEM (Selaras dengan Sidebar & Dashboard)
================================ */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

:root {
    /* Primary Colors */
    --primary: #6366f1;
    --primary-light: #eef2ff;
    --primary-dark: #4f46e5;
    
    /* Neutral Colors */
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-300: #d1d5db;
    --gray-400: #9ca3af;
    --gray-500: #6b7280;
    --gray-600: #4b5563;
    --gray-700: #374151;
    --gray-800: #1f2937;
    --gray-900: #111827;
    
    /* Semantic Colors */
    --success: #10b981;
    --success-light: #d1fae5;
    --warning: #f59e0b;
    --warning-light: #fef3c7;
    --danger: #ef4444;
    --danger-light: #fee2e2;
    --info: #06b6d4;
    --info-light: #cffafe;
    
    /* Surface */
    --bg-body: #f9fafb;
    --card-bg: #ffffff;
    --border: #e5e7eb;
    
    /* Shadows */
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background: var(--bg-body);
    color: var(--gray-900);
    font-size: 14px;
    line-height: 1.5;
}

.cursor-pointer { cursor: pointer; }

/* ===============================
   PAGE HEADER
================================ */

.page-header {
    background: var(--card-bg);
    border-bottom: 1px solid var(--border);
    padding: 1.5rem 0;
    margin-bottom: 2rem;
    border-radius: 0.75rem 0.75rem 0 0;
}

.page-header h2 {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--gray-900);
    margin-bottom: 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.page-header h2 i {
    color: var(--primary);
}

.page-header p {
    color: var(--gray-500);
    font-size: 0.875rem;
    margin-bottom: 0;
    font-weight: 500;
}

/* ===============================
   BUTTONS
================================ */

.btn-primary-custom {
    background: var(--primary);
    border: none;
    padding: 0.625rem 1.25rem;
    border-radius: 0.5rem;
    color: white;
    font-weight: 500;
    font-size: 0.875rem;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    box-shadow: var(--shadow-sm);
}

.btn-primary-custom:hover {
    background: var(--primary-dark);
    transform: translateY(-1px);
    box-shadow: var(--shadow-md);
    color: white;
}

.btn-action {
    width: 32px;
    height: 32px;
    padding: 0;
    border-radius: 0.5rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid var(--border);
    background: white;
    color: var(--gray-600);
    transition: all 0.2s;
    font-size: 0.875rem;
}

.btn-action:hover {
    background: var(--gray-50);
    border-color: var(--gray-400);
    color: var(--gray-900);
    transform: translateY(-1px);
}

.btn-action.btn-delete:hover {
    background: var(--danger-light);
    border-color: var(--danger);
    color: var(--danger);
}

/* ===============================
   CARD
================================ */

.menu-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 0.75rem;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}

/* ===============================
   TABLE
================================ */

.table {
    margin-bottom: 0;
}

.table thead {
    background: var(--gray-50);
    border-bottom: 1px solid var(--border);
}

.table thead th {
    border: none;
    padding: 0.875rem 1rem;
    font-weight: 600;
    font-size: 0.75rem;
    color: var(--gray-600);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table tbody td {
    padding: 1rem;
    border-bottom: 1px solid var(--gray-100);
    vertical-align: middle;
}

.table tbody tr:last-child td {
    border-bottom: none;
}

/* ===============================
   PARENT ROW
================================ */

.parent-row {
    transition: background-color 0.2s;
}

.parent-row:hover {
    background-color: var(--gray-50);
}

.parent-row.expanded {
    background-color: var(--gray-50);
}

/* ===============================
   CHILD ROW
================================ */

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

/* ===============================
   TOGGLE ICON
================================ */

.toggle-icon {
    transition: transform 0.2s;
    display: inline-block;
    font-size: 0.875rem;
    color: var(--gray-400);
}

.parent-row.expanded .toggle-icon {
    transform: rotate(90deg);
    color: var(--primary);
}

/* ===============================
   MENU ICON
================================ */

.menu-icon-box {
    width: 40px;
    height: 40px;
    background: var(--primary-light);
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
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
    color: var(--gray-600);
    font-size: 0.875rem;
}

/* ===============================
   TREE LINE
================================ */

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

/* ===============================
   TOGGLE SWITCH
================================ */

.form-switch .form-check-input {
    width: 2.75rem;
    height: 1.5rem;
    cursor: pointer;
    border: 2px solid var(--gray-300);
    background-color: white;
    transition: all 0.2s;
}

.form-switch .form-check-input:checked {
    background-color: var(--primary);
    border-color: var(--primary);
}

.form-switch .form-check-input:focus {
    box-shadow: 0 0 0 3px var(--primary-light);
    border-color: var(--primary);
}

.form-switch .form-check-input:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.status-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--gray-500);
    margin-left: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.status-label.active {
    color: var(--primary);
}

/* ===============================
   BADGES
================================ */

.badge-custom {
    display: inline-block;
    padding: 0.25rem 0.625rem;
    border-radius: 0.375rem;
    font-size: 0.75rem;
    font-weight: 600;
}

.badge-primary-custom {
    background: var(--primary-light);
    color: var(--primary);
}

.badge-secondary-custom {
    background: var(--gray-100);
    color: var(--gray-600);
}

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
    color: var(--gray-600);
    padding: 0.125rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.7rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}

/* ===============================
   CODE/URL DISPLAY
================================ */

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

/* ===============================
   EMPTY STATE
================================ */

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
    color: var(--gray-400);
}

.empty-state h5 {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--gray-900);
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: var(--gray-500);
    font-size: 0.875rem;
    margin-bottom: 1.5rem;
}

/* ===============================
   MENU NAME SECTION
================================ */

.menu-name-section {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.menu-name-text {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.menu-name-title {
    font-weight: 600;
    color: var(--gray-900);
    font-size: 0.9375rem;
}

/* ===============================
   MODAL STYLES
================================ */

.modal-content {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

.modal-header {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    color: white;
    border-radius: 1rem 1rem 0 0;
    padding: 1.5rem;
    border: none;
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
    border-top: 1px solid var(--border);
}

/* Form Styles in Modal */
.form-label-modal {
    font-weight: 600;
    color: var(--gray-700);
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-label-modal i {
    color: var(--primary);
}

.required {
    color: var(--danger);
}

.input-group-modal {
    position: relative;
}

.input-icon-modal {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray-400);
    z-index: 10;
}

.form-control-modal,
.form-select-modal {
    padding: 0.75rem 1rem 0.75rem 3rem;
    border: 2px solid var(--gray-200);
    border-radius: 0.5rem;
    font-size: 0.875rem;
    transition: all 0.2s;
}

.form-control-modal:focus,
.form-select-modal:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px var(--primary-light);
}

.form-control-modal[readonly] {
    background-color: var(--gray-50);
    color: var(--gray-500);
    cursor: not-allowed;
}

.form-text-modal {
    font-size: 0.75rem;
    color: var(--gray-500);
    margin-top: 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.icon-preview-modal {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 60px;
    height: 60px;
    background: var(--primary-light);
    border-radius: 0.5rem;
    color: var(--primary);
    font-size: 1.75rem;
}

/* Modal Buttons */
.btn-modal-cancel {
    background: var(--gray-100);
    border: 1px solid var(--gray-300);
    color: var(--gray-700);
    padding: 0.625rem 1.25rem;
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-modal-cancel:hover {
    background: var(--gray-200);
    border-color: var(--gray-400);
}

.btn-modal-submit {
    background: var(--primary);
    border: none;
    color: white;
    padding: 0.625rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 500;
    box-shadow: var(--shadow-sm);
    transition: all 0.2s;
}

.btn-modal-submit:hover {
    background: var(--primary-dark);
    transform: translateY(-1px);
    box-shadow: var(--shadow-md);
}

.btn-modal-delete {
    background: var(--danger);
    border: none;
    color: white;
    padding: 0.625rem 1.25rem;
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-modal-delete:hover {
    background: #dc2626;
    transform: translateY(-1px);
}

/* ===============================
   MODAL SCROLLABLE FIX
================================ */

.modal-dialog-scrollable .modal-content {
    max-height: 90vh;
    display: flex;
    flex-direction: column;
}

.modal-dialog-scrollable .modal-body {
    overflow-y: auto;
    flex: 1;
    max-height: calc(90vh - 120px); /* Tinggi total dikurangi header & footer */
}

/* Pastikan modal responsive */
.modal-dialog {
    max-width: 90%;
    margin: 1rem auto;
}

@media (max-width: 768px) {
    .modal-dialog {
        max-width: 95%;
        margin: 0.5rem auto;
    }
    
    .modal-dialog-scrollable .modal-body {
        max-height: calc(80vh - 120px);
    }
}

/* ===============================
   RESPONSIVE
================================ */

@media (max-width: 768px) {
    .page-header {
        padding: 1rem 0;
    }

    .page-header h2 {
        font-size: 1.25rem;
    }

    .table thead th,
    .table tbody td {
        padding: 0.75rem 0.5rem;
        font-size: 0.8125rem;
    }

    .btn-primary-custom {
        padding: 0.5rem 1rem;
        font-size: 0.8125rem;
    }

    .menu-icon-box {
        width: 36px;
        height: 36px;
        font-size: 0.9375rem;
    }

    .tree-line {
        padding-left: 20px;
        margin-left: 12px;
    }

    .modal-body {
        padding: 1.5rem;
    }
}

/* ===============================
   CONTAINER
================================ */

.container-fluid {
    padding-left: 2rem;
    padding-right: 2rem;
}

@media (max-width: 768px) {
    .container-fluid {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h2>
                    <i class="bi bi-list-ul"></i>
                    <?= esc($title) ?>
                </h2>
                <p><?= count($menus) ?> total menu dalam sistem</p>
            </div>
            <?php if ($can_create): ?>
                <button type="button" class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#menuModal" onclick="openCreateModal()">
                    <i class="bi bi-plus-lg"></i>
                    Tambah Menu
                </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Menu Card -->
    <div class="menu-card">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="35%">Nama Menu</th>
                        <th width="20%">URL / Route</th>
                        <th width="15%">Admin URL</th>
                        <th width="12%" class="text-center">Status</th>
                        <th width="13%" class="text-center">Aksi</th>
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
                                        <i class="bi bi-inbox"></i>
                                    </div>
                                    <h5>Belum Ada Menu</h5>
                                    <p>Mulai dengan menambahkan menu pertama untuk sistem Anda</p>
                                    <?php if ($can_create): ?>
                                        <button type="button" class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#menuModal" onclick="openCreateModal()">
                                            <i class="bi bi-plus-lg"></i>
                                            Tambah Menu
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
                            
                            <td>
                                <span class="badge-number"><?= $counter++ ?></span>
                            </td>
                            
                            <td>
                                <div class="menu-name-section">
                                    <div style="width: 20px;">
                                        <?php if ($hasChild): ?>
                                            <i class="bi bi-chevron-right toggle-icon"></i>
                                        <?php endif; ?>
                                    </div>

                                    <div class="menu-icon-box">
                                        <i class="<?= esc($parent['menu_icon'] ?: 'bi bi-circle') ?>"></i>
                                    </div>

                                    <div class="menu-name-text">
                                        <div class="menu-name-title"><?= esc($parent['menu_name']) ?></div>
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
                                    <span style="color: var(--gray-400);">—</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if(!empty($parent['admin_url']) && $parent['admin_url'] != '#'): ?>
                                    <code><?= esc($parent['admin_url']) ?></code>
                                <?php else: ?>
                                    <span style="color: var(--gray-400);">—</span>
                                <?php endif; ?>
                            </td>
                            
                            <td class="text-center" onclick="event.stopPropagation()">
                                <?php if ($can_update): ?>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="form-check form-switch mb-0">
                                            <input class="form-check-input toggle-status" type="checkbox" role="switch"
                                                   data-id="<?= $parent['id_menu'] ?>"
                                                   data-url="<?= site_url('menu/toggleStatus/' . $parent['id_menu']) ?>"
                                                   id="toggle-<?= $parent['id_menu'] ?>"
                                                   <?= ($parent['status'] === 'active') ? 'checked' : '' ?>>
                                        </div>
                                        <label for="toggle-<?= $parent['id_menu'] ?>" class="status-label <?= ($parent['status'] === 'active') ? 'active' : '' ?>" style="cursor: pointer;">
                                            <?= ($parent['status'] === 'active') ? 'Aktif' : 'Off' ?>
                                        </label>
                                    </div>
                                <?php else: ?>
                                    <span class="badge-custom <?= ($parent['status'] === 'active') ? 'badge-primary-custom' : 'badge-secondary-custom' ?>">
                                        <?= ($parent['status'] === 'active') ? 'Aktif' : 'Nonaktif' ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                            
                            <td class="text-center" onclick="event.stopPropagation()">
                                <div class="d-flex justify-content-center gap-2">
                                    <?php if ($can_update): ?>
                                        <button type="button" class="btn-action" 
                                           data-bs-toggle="tooltip" title="Edit Menu"
                                           onclick="openEditModal(<?= htmlspecialchars(json_encode($parent)) ?>)">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    <?php endif; ?>

                                    <?php if ($can_delete): ?>
                                        <button type="button" class="btn-action btn-delete" 
                                                data-bs-toggle="tooltip" title="Hapus Menu"
                                                onclick="deleteMenu(<?= $parent['id_menu'] ?>, '<?= esc($parent['menu_name']) ?>')">
                                            <i class="bi bi-trash"></i>
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
                                            <div class="menu-icon-small me-3">
                                                <i class="<?= esc($child['menu_icon'] ?: 'bi bi-circle') ?>"></i>
                                            </div>
                                            <span style="color: var(--gray-700); font-weight: 500;">
                                                <?= esc($child['menu_name']) ?>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if(!empty($child['menu_url']) && $child['menu_url'] != '#'): ?>
                                        <code><?= esc($child['menu_url']) ?></code>
                                    <?php else: ?>
                                        <span style="color: var(--gray-400);">—</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if(!empty($child['admin_url']) && $child['admin_url'] != '#'): ?>
                                        <code><?= esc($child['admin_url']) ?></code>
                                    <?php else: ?>
                                        <span style="color: var(--gray-400);">—</span>
                                    <?php endif; ?>
                                </td>
                                
                                <td class="text-center">
                                    <?php if ($can_update): ?>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <div class="form-check form-switch mb-0">
                                                <input class="form-check-input toggle-status" type="checkbox" role="switch"
                                                       data-id="<?= $child['id_menu'] ?>"
                                                       data-url="<?= site_url('menu/toggleStatus/' . $child['id_menu']) ?>"
                                                       id="toggle-child-<?= $child['id_menu'] ?>"
                                                       <?= ($child['status'] === 'active') ? 'checked' : '' ?>>
                                            </div>
                                            <label for="toggle-child-<?= $child['id_menu'] ?>" class="status-label <?= ($child['status'] === 'active') ? 'active' : '' ?>" style="cursor: pointer;">
                                                <?= ($child['status'] === 'active') ? 'Aktif' : 'Off' ?>
                                            </label>
                                        </div>
                                    <?php else: ?>
                                        <span class="badge-custom <?= ($child['status'] === 'active') ? 'badge-primary-custom' : 'badge-secondary-custom' ?>">
                                            <?= ($child['status'] === 'active') ? 'Aktif' : 'Nonaktif' ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <?php if ($can_update): ?>
                                            <button type="button" class="btn-action" 
                                               data-bs-toggle="tooltip" title="Edit Submenu"
                                               onclick="openEditModal(<?= htmlspecialchars(json_encode($child)) ?>)">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        <?php endif; ?>

                                        <?php if ($can_delete): ?>
                                            <button type="button" class="btn-action btn-delete" 
                                                    data-bs-toggle="tooltip" title="Hapus Submenu"
                                                    onclick="deleteMenu(<?= $child['id_menu'] ?>, '<?= esc($child['menu_name']) ?>')">
                                                <i class="bi bi-trash"></i>
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
</div>

<div class="modal fade" id="menuModal" tabindex="-1" aria-labelledby="menuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="menuModalLabel">
                    <i class="bi bi-plus-square"></i>
                    <span id="modalTitle">Tambah Menu Baru</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- Modal Body dengan scrollable area -->
            <div class="modal-body" style="overflow-y: auto; max-height: 70vh;">
                <form id="menuForm" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <input type="hidden" name="id_menu" id="id_menu" value="">
                    
                    <!-- Konten form Anda tetap sama di sini -->
                    <div class="mb-4">
                        <h6 class="text-primary fw-bold mb-3">
                            <i class="bi bi-info-circle"></i> Informasi Dasar
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="menu_name" class="form-label-modal">
                                    <i class="bi bi-tag-fill"></i>
                                    Nama Menu <span class="required">*</span>
                                </label>
                                <div class="input-group-modal">
                                    <i class="bi bi-card-text input-icon-modal"></i>
                                    <input type="text" class="form-control form-control-modal" 
                                           id="menu_name" name="menu_name" 
                                           placeholder="Contoh: Dashboard, Berita, Produk" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="menu_icon" class="form-label-modal">
                                    <i class="bi bi-emoji-smile"></i>
                                    Icon Menu
                                </label>
                                <div class="d-flex gap-2">
                                    <div class="flex-grow-1">
                                        <div class="input-group-modal">
                                            <i class="bi bi-star input-icon-modal"></i>
                                            <input type="text" class="form-control form-control-modal" 
                                                   id="menu_icon" name="menu_icon" 
                                                   placeholder="bi-house, bi-gear...">
                                        </div>
                                    </div>
                                    <div class="icon-preview-modal" id="iconPreview">
                                        <i class="bi bi-question-circle"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="parent_id" class="form-label-modal">
                                <i class="bi bi-folder-symlink-fill"></i>
                                Parent Menu (Menu Induk)
                            </label>
                            <div class="input-group-modal">
                                <i class="bi bi-diagram-3 input-icon-modal"></i>
                                <select class="form-select form-select-modal" id="parent_id" name="parent_id">
                                    <option value="0">📌 Menu Utama (Tanpa Parent)</option>
                                    <?php foreach ($menus as $m): ?>
                                        <?php if ($m['parent_id'] == 0): ?>
                                            <option value="<?= $m['id_menu'] ?>" 
                                                    data-is-infopublik="<?= (strtolower($m['menu_name']) === 'informasi publik') ? 'true' : 'false' ?>">
                                                📁 <?= esc($m['menu_name']) ?>
                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-text-modal" id="urlHelperText">
                                <i class="bi bi-lightbulb-fill text-warning"></i>
                                <span>Pilih "Informasi Publik" untuk otomatis membuat kategori dokumen.</span>
                            </div>
                        </div>
                    </div>

                    <!-- URL & Routing -->
                    <div class="mb-4">
                        <h6 class="text-primary fw-bold mb-3">
                            <i class="bi bi-link-45deg"></i> URL & Routing
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="menu_url" class="form-label-modal">
                                    <i class="bi bi-link-45deg"></i>
                                    URL / Route
                                </label>
                                <div class="input-group-modal">
                                    <i class="bi bi-globe2 input-icon-modal"></i>
                                    <input type="text" class="form-control form-control-modal" 
                                           id="menu_url" name="menu_url" 
                                           placeholder="/api/dashboard atau https://example.com">
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="admin_url" class="form-label-modal">
                                    <i class="bi bi-shield-lock-fill"></i>
                                    URL Admin
                                </label>
                                <div class="input-group-modal">
                                    <i class="bi bi-lock input-icon-modal"></i>
                                    <input type="text" class="form-control form-control-modal" 
                                           id="admin_url" name="admin_url" 
                                           placeholder="/dashboard">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Konfigurasi -->
                    <div class="mb-4">
                        <h6 class="text-primary fw-bold mb-3">
                            <i class="bi bi-gear-fill"></i> Konfigurasi
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="allowed_roles" class="form-label-modal">
                                    <i class="bi bi-person-badge-fill"></i>
                                    Hak Akses (Roles)
                                </label>
                                <div class="input-group-modal">
                                    <i class="bi bi-people-fill input-icon-modal"></i>
                                    <input type="text" class="form-control form-control-modal" 
                                           id="allowed_roles" name="allowed_roles" 
                                           placeholder="superadmin, admin, editor">
                                </div>
                                <div class="form-text-modal">
                                    <i class="bi bi-info-circle"></i>
                                    Pisahkan dengan koma. Kosongkan untuk akses publik.
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="order_number" class="form-label-modal">
                                    <i class="bi bi-sort-numeric-down"></i>
                                    Urutan Menu <span class="required">*</span>
                                </label>
                                <div class="input-group-modal">
                                    <i class="bi bi-list-ol input-icon-modal"></i>
                                    <input type="number" class="form-control form-control-modal" 
                                           id="order_number" name="order_number" 
                                           value="1" min="1" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label-modal">
                                    <i class="bi bi-toggle2-on"></i>
                                    Status Menu <span class="required">*</span>
                                </label>
                                <div class="input-group-modal">
                                    <i class="bi bi-toggle-on input-icon-modal"></i>
                                    <select class="form-select form-select-modal" id="status" name="status" required>
                                        <option value="active">✅ Aktif - Menu akan ditampilkan</option>
                                        <option value="inactive">⛔ Nonaktif - Menu disembunyikan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                <button type="button" class="btn btn-modal-cancel" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-2"></i>Batal
                </button>
                <button type="button" class="btn btn-modal-delete d-none" id="btnDeleteModal" onclick="deleteMenuFromModal()">
                    <i class="bi bi-trash me-2"></i>Hapus Menu
                </button>
                <button type="submit" form="menuForm" class="btn btn-modal-submit">
                    <i class="bi bi-check-circle me-2"></i>
                    <span id="submitBtnText">Simpan Menu</span>
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    
    // Initialize Tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Toggle Status
    const toggles = document.querySelectorAll('.toggle-status');
    
    toggles.forEach(toggle => {
        toggle.addEventListener('change', function() {
            const url = this.getAttribute('data-url');
            const label = this.parentElement.nextElementSibling;
            const isChecked = this.checked;

            this.disabled = true;
            label.style.opacity = '0.5';

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    setTimeout(() => {
                        if(isChecked) {
                            label.textContent = 'Aktif';
                            label.classList.add('active');
                        } else {
                            label.textContent = 'Off';
                            label.classList.remove('active');
                        }
                        label.style.opacity = '1';
                    }, 150);
                } else {
                    this.checked = !isChecked;
                    label.style.opacity = '1';
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal mengubah status menu',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.checked = !isChecked;
                label.style.opacity = '1';
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat mengubah status',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            })
            .finally(() => {
                this.disabled = false;
            });
        });
    });

    // Icon Preview
    const iconInput = document.getElementById('menu_icon');
    const iconPreview = document.getElementById('iconPreview');
    
    iconInput.addEventListener('input', function() {
        const iconClass = this.value.trim();
        iconPreview.innerHTML = `<i class="${iconClass || 'bi bi-question-circle'}"></i>`;
    });

    // Parent Select Handler
    const parentSelect = document.getElementById('parent_id');
    const urlInput = document.getElementById('menu_url');
    const adminUrlInput = document.getElementById('admin_url');
    const urlHelper = document.getElementById('urlHelperText');
    
    function checkParentType() {
        const selectedOption = parentSelect.options[parentSelect.selectedIndex];
        const isInfoPublik = selectedOption.getAttribute('data-is-infopublik') === 'true';

        if (isInfoPublik) {
            urlInput.value = "Akan digenerate otomatis";
            urlInput.setAttribute('readonly', true);
            urlInput.style.backgroundColor = "#eff6ff";
            
            adminUrlInput.value = "Akan digenerate otomatis";
            adminUrlInput.setAttribute('readonly', true);
            adminUrlInput.style.backgroundColor = "#eff6ff";
            
            urlHelper.innerHTML = `
                <i class="bi bi-info-circle text-primary"></i>
                <span class="text-primary fw-bold">
                    URL akan otomatis dibuat berdasarkan Nama Menu.
                </span>
            `;
        } else {
            if (urlInput.value === "Akan digenerate otomatis") {
                urlInput.value = "";
            }
            urlInput.removeAttribute('readonly');
            urlInput.style.backgroundColor = "";
            
            if (adminUrlInput.value === "Akan digenerate otomatis") {
                adminUrlInput.value = "";
            }
            adminUrlInput.removeAttribute('readonly');
            adminUrlInput.style.backgroundColor = "";
            
            urlHelper.innerHTML = `
                <i class="bi bi-lightbulb-fill text-warning"></i>
                <span>Pilih "Informasi Publik" untuk otomatis membuat kategori dokumen.</span>
            `;
        }
    }

    parentSelect.addEventListener('change', checkParentType);

    // Form Submit Handler
    const menuForm = document.getElementById('menuForm');
    menuForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const method = document.getElementById('formMethod').value;
        const idMenu = document.getElementById('id_menu').value;
        
        let url = '<?= site_url('menu') ?>';
        if (method === 'PUT') {
            url = '<?= site_url('menu') ?>/' + idMenu;
        }

        // Show loading
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Menyimpan...';

        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message || 'Menu berhasil disimpan',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: data.message || 'Terjadi kesalahan',
                    confirmButtonColor: '#6366f1'
                });
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Terjadi kesalahan saat menyimpan data',
                confirmButtonColor: '#6366f1'
            });
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });
});

// Toggle Accordion
function toggleRows(parentId, element) {
    element.classList.toggle('expanded');
    const childRows = document.querySelectorAll(`.child-of-${parentId}`);
    
    childRows.forEach(row => {
        row.classList.toggle('show');
    });
}

// Open Create Modal
function openCreateModal() {
    document.getElementById('menuModalLabel').innerHTML = '<i class="bi bi-plus-square"></i> <span>Tambah Menu Baru</span>';
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('id_menu').value = '';
    document.getElementById('submitBtnText').textContent = 'Simpan Menu';
    document.getElementById('btnDeleteModal').classList.add('d-none');
    
    // Reset form
    document.getElementById('menuForm').reset();
    document.getElementById('menu_name').value = '';
    document.getElementById('menu_icon').value = '';
    document.getElementById('parent_id').value = '0';
    document.getElementById('menu_url').value = '';
    document.getElementById('admin_url').value = '';
    document.getElementById('allowed_roles').value = '';
    document.getElementById('order_number').value = '1';
    document.getElementById('status').value = 'active';
    
    // Reset icon preview
    document.getElementById('iconPreview').innerHTML = '<i class="bi bi-question-circle"></i>';
    
    // Reset readonly states
    document.getElementById('menu_url').removeAttribute('readonly');
    document.getElementById('menu_url').style.backgroundColor = '';
    document.getElementById('admin_url').removeAttribute('readonly');
    document.getElementById('admin_url').style.backgroundColor = '';
}

// Open Edit Modal
function openEditModal(menuData) {
    document.getElementById('menuModalLabel').innerHTML = '<i class="bi bi-pencil-square"></i> <span>Edit Menu</span>';
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('id_menu').value = menuData.id_menu;
    document.getElementById('submitBtnText').textContent = 'Simpan Perubahan';
    document.getElementById('btnDeleteModal').classList.remove('d-none');
    
    // Fill form with data
    document.getElementById('menu_name').value = menuData.menu_name || '';
    document.getElementById('menu_icon').value = menuData.menu_icon || '';
    document.getElementById('parent_id').value = menuData.parent_id || '0';
    document.getElementById('menu_url').value = menuData.menu_url || '';
    document.getElementById('admin_url').value = menuData.admin_url || '';
    document.getElementById('allowed_roles').value = menuData.allowed_roles || '';
    document.getElementById('order_number').value = menuData.order_number || '1';
    document.getElementById('status').value = menuData.status || 'active';
    
    // Update icon preview
    const iconClass = menuData.menu_icon || 'bi bi-question-circle';
    document.getElementById('iconPreview').innerHTML = `<i class="${iconClass}"></i>`;
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('menuModal'));
    modal.show();
}

// Delete Menu
function deleteMenu(id, name) {
    Swal.fire({
        title: 'Hapus Menu?',
        html: `Anda yakin ingin menghapus menu <strong>"${name}"</strong>?<br><small class="text-muted">Semua submenu akan ikut terhapus.</small>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?= site_url('menu') ?>/' + id;
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '<?= csrf_token() ?>';
            csrfInput.value = '<?= csrf_hash() ?>';
            
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            
            form.appendChild(csrfInput);
            form.appendChild(methodInput);
            document.body.appendChild(form);
            form.submit();
        }
    });
}

// Delete from Modal
function deleteMenuFromModal() {
    const idMenu = document.getElementById('id_menu').value;
    const menuName = document.getElementById('menu_name').value;
    
    // Close modal first
    const modal = bootstrap.Modal.getInstance(document.getElementById('menuModal'));
    modal.hide();
    
    // Then show delete confirmation
    setTimeout(() => {
        deleteMenu(idMenu, menuName);
    }, 300);
}
</script>
<?= $this->endSection() ?>