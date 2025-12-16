<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    /* Simple Clean Styling */
    :root {
        --primary-color: #2563eb;
        --border-color: #e5e7eb;
        --text-primary: #111827;
        --text-secondary: #6b7280;
        --bg-hover: #f9fafb;
    }

    .cursor-pointer { cursor: pointer; }
    
    /* Header Section - Minimal */
    .page-header {
        background: white;
        border-bottom: 2px solid var(--border-color);
        padding: 1.5rem 0;
        margin-bottom: 2rem;
    }
    
    .page-header h2 {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }
    
    .page-header p {
        color: var(--text-secondary);
        font-size: 0.875rem;
        margin-bottom: 0;
    }

    /* Card - Simple */
    .menu-card {
        background: white;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        overflow: hidden;
    }

    /* Table Styling - Minimal */
    .table thead {
        background: #f9fafb;
        border-bottom: 1px solid var(--border-color);
    }
    
    .table thead th {
        border: none;
        padding: 0.75rem 1rem;
        font-weight: 600;
        font-size: 0.75rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table tbody td {
        padding: 1rem;
        border-bottom: 1px solid #f3f4f6;
    }

    /* Parent Row */
    .parent-row {
        transition: background-color 0.2s;
    }
    
    .parent-row:hover {
        background-color: var(--bg-hover);
    }

    /* Child Row */
    .child-row {
        background: #fafbfc;
        display: none;
    }
    
    .child-row:hover {
        background: #f5f6f7;
    }
    
    .child-row.show {
        display: table-row;
    }

    /* Toggle Icon */
    .toggle-icon {
        transition: transform 0.2s;
        display: inline-block;
        font-size: 0.75rem;
        color: var(--text-secondary);
    }
    
    .parent-row.expanded .toggle-icon {
        transform: rotate(90deg);
    }

    /* Menu Icon - Simple */
    .menu-icon {
        width: 32px;
        height: 32px;
        background: #f3f4f6;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    /* Tree Line - Simple */
    .tree-line {
        position: relative;
        padding-left: 24px;
        margin-left: 12px;
    }
    
    .tree-line::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        width: 16px;
        height: 1px;
        background: var(--border-color);
    }
    
    .tree-line::after {
        content: "";
        position: absolute;
        left: 0;
        top: -100%;
        width: 1px;
        height: 200%;
        background: var(--border-color);
    }

    /* Toggle Switch - Simple */
    .form-switch .form-check-input {
        width: 2.75rem;
        height: 1.5rem;
        cursor: pointer;
        border: 2px solid #d1d5db;
        background-color: white;
        transition: all 0.2s;
    }
    
    .form-switch .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    
    .form-switch .form-check-input:focus {
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    /* Status Label */
    .status-label {
        font-size: 0.75rem;
        font-weight: 500;
        color: var(--text-secondary);
        margin-left: 0.5rem;
    }
    
    .status-label.active {
        color: var(--primary-color);
    }

    /* Badge - Simple */
    .badge-simple {
        display: inline-block;
        padding: 0.25rem 0.625rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .badge-primary {
        background: #eff6ff;
        color: var(--primary-color);
    }

    .badge-secondary {
        background: #f3f4f6;
        color: var(--text-secondary);
    }

    /* URL Code - Simple */
    code {
        background: #f3f4f6;
        color: var(--text-primary);
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.8125rem;
        font-family: 'Courier New', monospace;
    }

    /* Action Buttons - Simple */
    .btn-action {
        width: 32px;
        height: 32px;
        padding: 0;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border-color);
        background: white;
        color: var(--text-secondary);
        transition: all 0.2s;
    }
    
    .btn-action:hover {
        background: var(--bg-hover);
        border-color: var(--text-secondary);
    }
    
    .btn-action.btn-delete:hover {
        background: #fef2f2;
        border-color: #ef4444;
        color: #ef4444;
    }

    /* Primary Button - Simple */
    .btn-primary-simple {
        background: var(--primary-color);
        border: none;
        padding: 0.625rem 1.25rem;
        border-radius: 6px;
        color: white;
        font-weight: 500;
        font-size: 0.875rem;
        transition: background 0.2s;
    }
    
    .btn-primary-simple:hover {
        background: #1d4ed8;
    }

    /* Empty State - Simple */
    .empty-state {
        padding: 3rem 2rem;
        text-align: center;
    }
    
    .empty-state-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        background: #f3f4f6;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: var(--text-secondary);
    }

    /* Submenu Badge */
    .submenu-count {
        background: #f3f4f6;
        color: var(--text-secondary);
        padding: 0.125rem 0.5rem;
        border-radius: 10px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            padding: 1rem 0;
        }
        
        .table thead th,
        .table tbody td {
            padding: 0.75rem 0.5rem;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container-fluid py-4">
    <!-- Simple Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h2>
                    <i class="bi bi-list-ul me-2"></i><?= esc($title) ?>
                </h2>
                <p><?= count($menus) ?> total menu</p>
            </div>
            <?php if ($can_create): ?>
                <a href="<?= site_url('menu/new') ?>" class="btn btn-primary-simple">
                    <i class="bi bi-plus-lg me-1"></i>Tambah Menu
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Simple Card -->
    <div class="menu-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="40%">Nama Menu</th>
                        <th width="25%">URL / Route</th>
                        <th width="15%" class="text-center">Status</th>
                        <th width="15%" class="text-center">Aksi</th>
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
                            <td colspan="5" class="p-0">
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="bi bi-inbox"></i>
                                    </div>
                                    <h5 class="fw-semibold mb-2">Belum Ada Menu</h5>
                                    <p class="text-muted mb-3">Mulai dengan menambahkan menu pertama</p>
                                    <?php if ($can_create): ?>
                                        <a href="<?= site_url('menu/new') ?>" class="btn btn-primary-simple">
                                            <i class="bi bi-plus-lg me-1"></i>Tambah Menu
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
                                <span class="badge-simple badge-secondary"><?= $counter++ ?></span>
                            </td>
                            
                            <td>
                                <div class="d-flex align-items-center">
                                    <div style="width: 20px;" class="me-2">
                                        <?php if ($hasChild): ?>
                                            <i class="bi bi-chevron-right toggle-icon"></i>
                                        <?php endif; ?>
                                    </div>

                                    <div>
                                        <div class="fw-semibold text-dark"><?= esc($parent['menu_name']) ?></div>
                                        <?php if($hasChild): ?>
                                            <span class="submenu-count mt-1 d-inline-block">
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
                                    <span class="text-muted">—</span>
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
                                            <?= ($parent['status'] === 'active') ? 'Aktif' : 'Nonaktif' ?>
                                        </label>
                                    </div>
                                <?php else: ?>
                                    <span class="badge-simple <?= ($parent['status'] === 'active') ? 'badge-primary' : 'badge-secondary' ?>">
                                        <?= ($parent['status'] === 'active') ? 'Aktif' : 'Nonaktif' ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                            
                            <td class="text-center" onclick="event.stopPropagation()">
                                <div class="d-flex justify-content-center gap-2">
                                    <?php if ($can_update): ?>
                                        <a href="<?= site_url('menu/' . $parent['id_menu'].'/edit') ?>" 
                                           class="btn-action" 
                                           data-bs-toggle="tooltip" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($can_delete): ?>
                                        <form action="<?= site_url('menu/' . $parent['id_menu']) ?>" method="post" class="d-inline"
                                              onsubmit="return confirm('Hapus menu ini? Submenu akan ikut terhapus.');">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn-action btn-delete" 
                                                    data-bs-toggle="tooltip" title="Hapus">
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
                                            <div class="menu-icon me-3" style="width: 28px; height: 28px; font-size: 0.8rem;">
                                                <i class="<?= esc($child['menu_icon']) ?>"></i>
                                            </div>
                                            <span class="text-secondary"><?= esc($child['menu_name']) ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <code><?= esc($child['menu_url']) ?: '—' ?></code>
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
                                                <?= ($child['status'] === 'active') ? 'Aktif' : 'Nonaktif' ?>
                                            </label>
                                        </div>
                                    <?php else: ?>
                                        <span class="badge-simple <?= ($child['status'] === 'active') ? 'badge-primary' : 'badge-secondary' ?>">
                                            <?= ($child['status'] === 'active') ? 'Aktif' : 'Nonaktif' ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <?php if ($can_update): ?>
                                            <a href="<?= site_url('menu/' . $child['id_menu'].'/edit') ?>" 
                                               class="btn-action" 
                                               data-bs-toggle="tooltip" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        <?php endif; ?>

                                        <?php if ($can_delete): ?>
                                            <form action="<?= site_url('menu/' . $child['id_menu']) ?>" method="post" class="d-inline"
                                                  onsubmit="return confirm('Hapus submenu ini?');">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn-action btn-delete" 
                                                        data-bs-toggle="tooltip" title="Hapus">
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

        // Toggle Status
        const toggles = document.querySelectorAll('.toggle-status');
        
        toggles.forEach(toggle => {
            toggle.addEventListener('change', function() {
                const url = this.getAttribute('data-url');
                const label = this.parentElement.nextElementSibling;
                const isChecked = this.checked;

                this.disabled = true;

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
                        if(isChecked) {
                            label.textContent = 'Aktif';
                            label.classList.add('active');
                        } else {
                            label.textContent = 'Nonaktif';
                            label.classList.remove('active');
                        }
                    } else {
                        this.checked = !isChecked;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.checked = !isChecked;
                })
                .finally(() => {
                    this.disabled = false;
                });
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
</script>
<?= $this->endSection() ?>