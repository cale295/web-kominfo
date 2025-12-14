<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    /* Enhanced Modern Styling */
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        --danger-gradient: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);
    }

    .cursor-pointer { cursor: pointer; }
    
    /* Header Section */
    .page-header {
        background: var(--primary-gradient);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        position: relative;
        overflow: hidden;
    }
    
    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }
    
    .page-header::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
    }
    
    .page-header-content {
        position: relative;
        z-index: 1;
    }
    
    .stats-badge {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 0.5rem 1rem;
        border-radius: 50px;
        display: inline-block;
        margin-top: 0.5rem;
    }

    /* Enhanced Card */
    .menu-card {
        border: none;
        border-radius: 24px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .menu-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
    }

    /* Table Styling */
    .table thead {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: none;
    }
    
    .table thead th {
        border: none;
        padding: 1.2rem 1rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        font-size: 0.75rem;
    }

    /* Parent Row Enhanced */
    .parent-row {
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }
    
    .parent-row:hover {
        background: linear-gradient(90deg, #f8f9ff 0%, #ffffff 100%) !important;
        border-left-color: #667eea;
        transform: translateX(2px);
    }
    
    .parent-row.expanded {
        background: linear-gradient(90deg, #f0f3ff 0%, #ffffff 100%) !important;
        border-left-color: #667eea;
    }

    /* Child Row Enhanced */
    .child-row {
        background: linear-gradient(90deg, #fafbff 0%, #ffffff 100%);
        display: none;
        border-left: 4px solid #e9ecef;
    }
    
    .child-row:hover {
        background: linear-gradient(90deg, #f5f7ff 0%, #ffffff 100%);
        border-left-color: #a5b4fc;
    }
    
    .child-row.show {
        display: table-row;
        animation: slideDown 0.4s ease-out;
    }

    /* Icon Styling */
    .toggle-icon {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-block;
        font-size: 0.85rem;
        color: #cbd5e1;
        font-weight: bold;
    }
    
    .parent-row.expanded .toggle-icon {
        transform: rotate(90deg);
        color: #667eea;
    }

    /* Menu Icon Container */
    .menu-icon-container {
        width: 42px;
        height: 42px;
        background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
        border: 2px solid #667eea30;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    
    .parent-row:hover .menu-icon-container,
    .child-row:hover .menu-icon-container {
        background: var(--primary-gradient);
        border-color: transparent;
        transform: rotate(5deg) scale(1.1);
    }
    
    .parent-row:hover .menu-icon-container i,
    .child-row:hover .menu-icon-container i {
        color: white !important;
    }

    /* Tree Line Enhanced */
    .tree-line {
        position: relative;
        padding-left: 32px;
        margin-left: 16px;
    }
    
    .tree-line::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        width: 24px;
        height: 2px;
        background: linear-gradient(90deg, #667eea 0%, transparent 100%);
    }
    
    .tree-line::after {
        content: "";
        position: absolute;
        left: 0;
        top: -100%;
        width: 2px;
        height: 200%;
        background: linear-gradient(180deg, #667eea50 0%, #667eea20 100%);
    }

    /* Beautiful Toggle Switch */
    .toggle-container {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .form-switch {
        padding-left: 0;
        margin-bottom: 0;
    }
    
    .form-switch .form-check-input {
        width: 3.5rem;
        height: 1.75rem;
        cursor: pointer;
        border: none;
        background-color: #e2e8f0;
        background-image: none;
        position: relative;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    /* Toggle Handle (Circle) */
    .form-switch .form-check-input::before {
        content: '';
        position: absolute;
        width: 1.35rem;
        height: 1.35rem;
        border-radius: 50%;
        background: white;
        top: 50%;
        left: 0.2rem;
        transform: translateY(-50%);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15), 0 1px 3px rgba(0, 0, 0, 0.2);
    }
    
    /* Icon Inside Handle - OFF State */
    .form-switch .form-check-input::after {
        content: '✕';
        position: absolute;
        width: 1.35rem;
        height: 1.35rem;
        left: 0.2rem;
        top: 50%;
        transform: translateY(-50%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: bold;
        color: #94a3b8;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 1;
    }
    
    /* Checked State */
    .form-switch .form-check-input:checked {
        background: var(--success-gradient);
        box-shadow: 0 4px 16px rgba(56, 239, 125, 0.4), inset 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    /* Handle Movement - Checked */
    .form-switch .form-check-input:checked::before {
        left: calc(100% - 1.55rem);
        box-shadow: 0 3px 12px rgba(56, 239, 125, 0.3), 0 1px 4px rgba(0, 0, 0, 0.2);
    }
    
    /* Icon Change - Checked */
    .form-switch .form-check-input:checked::after {
        content: '✓';
        left: calc(100% - 1.55rem);
        color: #10b981;
        font-size: 0.8rem;
    }
    
    /* Hover Effects */
    .form-switch .form-check-input:hover:not(:disabled) {
        transform: scale(1.05);
    }
    
    .form-switch .form-check-input:not(:checked):hover {
        background-color: #cbd5e1;
    }
    
    /* Focus State */
    .form-switch .form-check-input:focus {
        box-shadow: 0 0 0 0.3rem rgba(102, 126, 234, 0.25);
        outline: none;
    }
    
    /* Disabled State */
    .form-switch .form-check-input:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    /* Loading State */
    .form-switch .form-check-input.loading {
        pointer-events: none;
        opacity: 0.7;
    }
    
    .form-switch .form-check-input.loading::after {
        content: '⟳';
        animation: spin 0.8s linear infinite;
    }

    /* Status Label */
    .status-label {
        font-weight: 700;
        font-size: 0.75rem;
        letter-spacing: 0.3px;
        transition: all 0.3s ease;
        text-transform: uppercase;
    }
    
    .status-label.text-success {
        color: #10b981 !important;
        text-shadow: 0 1px 2px rgba(16, 185, 129, 0.1);
    }
    
    .status-label.text-muted {
        color: #64748b !important;
    }
    
    /* Spin Animation for Loading */
    @keyframes spin {
        from { transform: translateY(-50%) rotate(0deg); }
        to { transform: translateY(-50%) rotate(360deg); }
    }

    /* Badge Styling */
    .badge-custom {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.7rem;
        letter-spacing: 0.5px;
    }

    /* URL Code */
    code {
        background: linear-gradient(135deg, #f8f9ff 0%, #f0f3ff 100%);
        color: #667eea;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        border: 1px solid #e0e7ff;
        font-weight: 600;
        font-size: 0.8rem;
    }

    /* Action Buttons Enhanced */
    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    .action-btn:hover {
        transform: translateY(-2px) scale(1.05);
    }
    
    .btn-edit {
        background: linear-gradient(135deg, #667eea20 0%, #764ba220 100%);
        color: #667eea;
    }
    
    .btn-edit:hover {
        background: var(--primary-gradient);
        color: white;
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }
    
    .btn-delete {
        background: linear-gradient(135deg, #eb334920 0%, #f45c4320 100%);
        color: #eb3349;
    }
    
    .btn-delete:hover {
        background: var(--danger-gradient);
        color: white;
        box-shadow: 0 6px 20px rgba(235, 51, 73, 0.4);
    }

    /* Add Menu Button */
    .btn-add-menu {
        background: var(--primary-gradient);
        border: none;
        padding: 0.8rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        transition: all 0.3s ease;
    }
    
    .btn-add-menu:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(102, 126, 234, 0.5);
    }

    /* Empty State */
    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
    }
    
    .empty-state-icon {
        width: 120px;
        height: 120px;
        margin: 0 auto 2rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: #cbd5e1;
    }

    /* Submenu Badge */
    .submenu-badge {
        background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
        color: #667eea;
        padding: 0.2rem 0.6rem;
        border-radius: 50px;
        font-size: 0.65rem;
        font-weight: 700;
        border: 1px solid #667eea30;
    }

    /* Animations */
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    .loading {
        animation: pulse 1.5s ease-in-out infinite;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem;
            border-radius: 16px;
        }
        
        .menu-card {
            border-radius: 16px;
        }
        
        .action-btn {
            width: 32px;
            height: 32px;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container-fluid py-4">
    <!-- Enhanced Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h2 class="fw-bold mb-2">
                        <i class="bi bi-diagram-3 me-2"></i><?= esc($title) ?>
                    </h2>
                    <p class="mb-2 opacity-90">Kelola struktur menu website dengan mudah dan efisien</p>
                    <div class="stats-badge">
                        <i class="bi bi-layers-fill me-2"></i>
                        <strong><?= count($menus) ?></strong> Total Menu
                    </div>
                </div>
                <?php if ($can_create): ?>
                    <a href="<?= site_url('menu/new') ?>" class="btn btn-add-menu text-white">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Menu Baru
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Enhanced Card -->
    <div class="menu-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="py-3 ps-4" width="5%">#</th>
                            <th class="py-3" width="40%">NAMA MENU</th>
                            <th class="py-3" width="25%">URL / ROUTE</th>
                            <th class="py-3 text-center" width="15%">STATUS</th>
                            <th class="py-3 text-center" width="15%">AKSI</th>
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
                                        <h5 class="fw-bold text-dark mb-2">Belum Ada Menu</h5>
                                        <p class="text-muted mb-4">Mulai dengan menambahkan menu pertama Anda</p>
                                        <?php if ($can_create): ?>
                                            <a href="<?= site_url('menu/new') ?>" class="btn btn-add-menu text-white">
                                                <i class="bi bi-plus-circle me-2"></i>Tambah Menu
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
                                
                                <td class="ps-4">
                                    <span class="badge bg-light text-primary fw-bold"><?= $counter++ ?></span>
                                </td>
                                
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div style="width: 28px;" class="me-2 text-center">
                                            <?php if ($hasChild): ?>
                                                <i class="bi bi-chevron-right toggle-icon"></i>
                                            <?php endif; ?>
                                        </div>

                                        <div class="menu-icon-container me-3">
                                            <i class="<?= esc($parent['menu_icon']) ?> text-primary"></i>
                                        </div>
                                        
                                        <div>
                                            <span class="fw-bold text-dark d-block mb-1"><?= esc($parent['menu_name']) ?></span>
                                            <?php if($hasChild): ?>
                                                <span class="submenu-badge">
                                                    <i class="bi bi-diagram-3 me-1"></i>
                                                    <?= count($groupedChildren[$parent['id_menu']]) ?> Submenu
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                
                                <td>
                                    <?php if(!empty($parent['menu_url']) && $parent['menu_url'] != '#'): ?>
                                        <code><?= esc($parent['menu_url']) ?></code>
                                    <?php else: ?>
                                        <span class="badge badge-custom bg-light text-secondary">
                                            <i class="bi bi-folder2 me-1"></i>Group Header
                                        </span>
                                    <?php endif; ?>
                                </td>
                                
                                <td class="text-center" onclick="event.stopPropagation()">
                                    <?php if ($can_update): ?>
                                        <div class="toggle-container">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input toggle-status" type="checkbox" role="switch"
                                                       data-id="<?= $parent['id_menu'] ?>"
                                                       data-url="<?= site_url('menu/toggleStatus/' . $parent['id_menu']) ?>"
                                                       id="toggle-<?= $parent['id_menu'] ?>"
                                                       <?= ($parent['status'] === 'active') ? 'checked' : '' ?>>
                                            </div>
                                            <label for="toggle-<?= $parent['id_menu'] ?>" class="status-label <?= ($parent['status'] === 'active') ? 'text-success' : 'text-muted' ?>" style="cursor: pointer;">
                                                <?= ($parent['status'] === 'active') ? 'Aktif' : 'Nonaktif' ?>
                                            </label>
                                        </div>
                                    <?php else: ?>
                                        <span class="badge badge-custom <?= ($parent['status'] === 'active') ? 'bg-success' : 'bg-secondary' ?>">
                                            <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>
                                            <?= ucfirst($parent['status']) ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                
                                <td class="text-center" onclick="event.stopPropagation()">
                                    <div class="d-flex justify-content-center gap-2">
                                        <?php if ($can_update): ?>
                                            <a href="<?= site_url('menu/' . $parent['id_menu'].'/edit') ?>" 
                                               class="action-btn btn-edit" 
                                               data-bs-toggle="tooltip" title="Edit Menu">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                        <?php endif; ?>

                                        <?php if ($can_delete): ?>
                                            <form action="<?= site_url('menu/' . $parent['id_menu']) ?>" method="post" class="d-inline"
                                                  onsubmit="return confirm('⚠️ Hapus menu ini?\n\nPeringatan: Submenu di bawahnya akan ikut terhapus!');">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="action-btn btn-delete" 
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
                                    <td class="py-3">
                                        <div class="d-flex align-items-center ps-5">
                                            <div class="tree-line">
                                                <div class="menu-icon-container me-3" style="width: 32px; height: 32px;">
                                                    <i class="<?= esc($child['menu_icon']) ?> text-muted small"></i>
                                                </div>
                                                <span class="text-secondary fw-semibold"><?= esc($child['menu_name']) ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <code class="small"><?= esc($child['menu_url']) ?: '-' ?></code>
                                    </td>
                                    
                                    <td class="text-center">
                                        <?php if ($can_update): ?>
                                            <div class="toggle-container">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input toggle-status" type="checkbox" role="switch"
                                                           data-id="<?= $child['id_menu'] ?>"
                                                           data-url="<?= site_url('menu/toggleStatus/' . $child['id_menu']) ?>"
                                                           id="toggle-child-<?= $child['id_menu'] ?>"
                                                           <?= ($child['status'] === 'active') ? 'checked' : '' ?>>
                                                </div>
                                                <label for="toggle-child-<?= $child['id_menu'] ?>" class="status-label <?= ($child['status'] === 'active') ? 'text-success' : 'text-muted' ?>" style="cursor: pointer;">
                                                    <?= ($child['status'] === 'active') ? 'Aktif' : 'Nonaktif' ?>
                                                </label>
                                            </div>
                                        <?php else: ?>
                                            <span class="badge badge-custom <?= ($child['status'] === 'active') ? 'bg-success' : 'bg-secondary' ?>">
                                                <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>
                                                <?= ucfirst($child['status']) ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <?php if ($can_update): ?>
                                                <a href="<?= site_url('menu/' . $child['id_menu'].'/edit') ?>" 
                                                   class="action-btn btn-edit" 
                                                   data-bs-toggle="tooltip" title="Edit Submenu">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($can_delete): ?>
                                                <form action="<?= site_url('menu/' . $child['id_menu']) ?>" method="post" class="d-inline"
                                                      onsubmit="return confirm('⚠️ Hapus submenu ini?');">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="action-btn btn-delete" 
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

        // Toggle Status dengan AJAX
        const toggles = document.querySelectorAll('.toggle-status');
        
        toggles.forEach(toggle => {
            toggle.addEventListener('change', function() {
                const url = this.getAttribute('data-url');
                const label = this.closest('.toggle-container').querySelector('.status-label');
                const isChecked = this.checked;

                // Add loading state
                this.disabled = true;
                this.classList.add('loading');

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
                        // Update UI dengan animasi smooth
                        setTimeout(() => {
                            if(isChecked) {
                                label.textContent = 'Aktif';
                                label.classList.remove('text-muted');
                                label.classList.add('text-success');
                            } else {
                                label.textContent = 'Nonaktif';
                                label.classList.remove('text-success');
                                label.classList.add('text-muted');
                            }
                            
                            // Success feedback
                            showNotification('✓ Status berhasil diupdate', 'success');
                        }, 200);
                    } else {
                        // Revert jika gagal
                        this.checked = !isChecked;
                        showNotification('✕ Gagal update status: ' + (data.message || 'Error'), 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.checked = !isChecked;
                    showNotification('✕ Terjadi kesalahan koneksi', 'error');
                })
                .finally(() => {
                    this.disabled = false;
                    this.classList.remove('loading');
                });
            });
        });
    });

    // Accordion Toggle Function
    function toggleRows(parentId, element) {
        element.classList.toggle('expanded');
        const childRows = document.querySelectorAll(`.child-of-${parentId}`);
        
        childRows.forEach(row => {
            if (row.classList.contains('show')) {
                row.classList.remove('show');
                setTimeout(() => { 
                    if(!row.classList.contains('show')) row.style.display = 'none'; 
                }, 400);
            } else {
                row.style.display = 'table-row';
                requestAnimationFrame(() => row.classList.add('show'));
            }
        });
    }


    function showNotification(message, type = 'info') {
        console.log(`${type.toUpperCase()}: ${message}`);
    }
</script>
<?= $this->endSection() ?>