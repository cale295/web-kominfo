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
    /* Primary Colors - Sama dengan sidebar & dashboard */
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
                <a href="<?= site_url('menu/new') ?>" class="btn-primary-custom">
                    <i class="bi bi-plus-lg"></i>
                    Tambah Menu
                </a>
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
                    // Memisahkan Parent dan Child
                    $parents = array_filter($menus, fn($m) => $m['parent_id'] == 0 || empty($m['parent_id']));
                    $allChildren = array_filter($menus, fn($m) => !empty($m['parent_id']) && $m['parent_id'] != 0);
                    
                    // Grouping child
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
                                        <a href="<?= site_url('menu/new') ?>" class="btn-primary-custom">
                                            <i class="bi bi-plus-lg"></i>
                                            Tambah Menu
                                        </a>
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
                                        <a href="<?= site_url('menu/' . $parent['id_menu'].'/edit') ?>" 
                                           class="btn-action" 
                                           data-bs-toggle="tooltip" title="Edit Menu">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($can_delete): ?>
                                        <form action="<?= site_url('menu/' . $parent['id_menu']) ?>" method="post" class="d-inline"
                                              onsubmit="return confirm('Hapus menu ini? Semua submenu akan ikut terhapus.');">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn-action btn-delete" 
                                                    data-bs-toggle="tooltip" title="Hapus Menu">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
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
                                            <a href="<?= site_url('menu/' . $child['id_menu'].'/edit') ?>" 
                                               class="btn-action" 
                                               data-bs-toggle="tooltip" title="Edit Submenu">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        <?php endif; ?>

                                        <?php if ($can_delete): ?>
                                            <form action="<?= site_url('menu/' . $child['id_menu']) ?>" method="post" class="d-inline"
                                                  onsubmit="return confirm('Hapus submenu ini?');">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn-action btn-delete" 
                                                        data-bs-toggle="tooltip" title="Hapus Submenu">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
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

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // Initialize Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Toggle Status dengan feedback visual yang lebih baik
        const toggles = document.querySelectorAll('.toggle-status');
        
        toggles.forEach(toggle => {
            toggle.addEventListener('change', function() {
                const url = this.getAttribute('data-url');
                const label = this.parentElement.nextElementSibling;
                const isChecked = this.checked;

                // Disable saat loading
                this.disabled = true;
                
                // Visual feedback
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
                        // Update label dengan smooth transition
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
                        // Rollback jika gagal
                        this.checked = !isChecked;
                        label.style.opacity = '1';
                        alert('Gagal mengubah status menu');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.checked = !isChecked;
                    label.style.opacity = '1';
                    alert('Terjadi kesalahan saat mengubah status');
                })
                .finally(() => {
                    this.disabled = false;
                });
            });
        });
    });

    // Toggle Accordion dengan smooth animation
    function toggleRows(parentId, element) {
        element.classList.toggle('expanded');
        const childRows = document.querySelectorAll(`.child-of-${parentId}`);
        
        childRows.forEach(row => {
            row.classList.toggle('show');
        });
    }
</script>
<?= $this->endSection() ?>