<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    /* Modern Form Styling */
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        --danger-gradient: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);
        --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    /* Page Header */
    .page-header-modern {
        background: var(--primary-gradient);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        position: relative;
        overflow: hidden;
    }
    
    .page-header-modern::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }
    
    .page-header-modern::after {
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
    
    .page-header-modern h3 {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .page-header-modern p {
        opacity: 0.9;
        margin: 0;
    }

    /* Back Button */
    .btn-back-modern {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 0.6rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-back-modern:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.5);
        color: white;
        transform: translateX(-5px);
    }

    /* Alert Styling */
    .alert-modern {
        border: none;
        border-radius: 16px;
        padding: 1.25rem;
        margin-bottom: 2rem;
        border-left: 4px solid;
        animation: slideInDown 0.4s ease-out;
    }
    
    .alert-danger-modern {
        background: linear-gradient(135deg, #fff5f5 0%, #ffe5e5 100%);
        border-left-color: #ef4444;
        color: #dc2626;
    }
    
    .alert-modern strong {
        display: block;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }
    
    .alert-modern ul {
        margin-bottom: 0;
        padding-left: 1.5rem;
    }

    /* Form Card */
    .form-card-modern {
        border: none;
        border-radius: 24px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        background: white;
    }
    
    .form-card-modern .card-body {
        padding: 2.5rem;
    }

    /* Section Title */
    .form-section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 3px solid;
        border-image: var(--primary-gradient) 1;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .form-section-title i {
        font-size: 1.5rem;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Form Label */
    .form-label-modern {
        font-weight: 700;
        color: #334155;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.95rem;
    }
    
    .form-label-modern i {
        color: #667eea;
        font-size: 1.1rem;
    }
    
    .required {
        color: #ef4444;
        font-weight: bold;
    }

    /* Input Group */
    .input-group-modern {
        position: relative;
        margin-bottom: 0.5rem;
    }
    
    .input-icon {
        position: absolute;
        left: 1.25rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 1.1rem;
        z-index: 10;
        transition: all 0.3s ease;
    }
    
    .form-control-modern,
    .form-select-modern {
        padding: 0.875rem 1.25rem 0.875rem 3.25rem;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #f8fafc;
        width: 100%; /* Ensure full width */
    }
    
    .form-control-modern:focus,
    .form-select-modern:focus {
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        outline: none;
    }
    
    .form-control-modern:focus ~ .input-icon,
    .form-select-modern:focus ~ .input-icon {
        color: #667eea;
    }

    /* Form Text (Helper) */
    .form-text-modern {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #64748b;
        font-size: 0.85rem;
        margin-top: 0.5rem;
    }
    
    .form-text-modern i {
        color: #fbbf24;
        font-size: 0.9rem;
    }

    /* Select Dropdown Enhancement */
    .form-select-modern {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23667eea' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1.25rem center;
        background-size: 16px;
        cursor: pointer;
    }

    /* Status Select Options */
    .form-select-modern option {
        padding: 0.75rem;
    }

    /* Action Buttons */
    .btn-cancel-modern {
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        border: 2px solid #cbd5e1;
        color: #475569;
        padding: 0.875rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-cancel-modern:hover {
        background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
        border-color: #94a3b8;
        color: #334155;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .btn-submit-modern {
        background: var(--primary-gradient);
        border: none;
        color: white;
        padding: 0.875rem 2.5rem;
        border-radius: 12px;
        font-weight: 600;
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        transition: all 0.3s ease;
    }
    
    .btn-submit-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(102, 126, 234, 0.4);
    }
    
    .btn-submit-modern:active {
        transform: translateY(-1px);
    }

    /* Animations */
    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Form Animation on Load */
    .form-card-modern {
        animation: fadeIn 0.5s ease-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header-modern {
            padding: 1.5rem;
            border-radius: 16px;
        }
        
        .form-card-modern .card-body {
            padding: 1.5rem;
        }
        
        .form-section-title {
            font-size: 1.1rem;
        }
        
        .btn-submit-modern,
        .btn-cancel-modern {
            width: 100%;
        }
        
        .d-flex.gap-2 {
            flex-direction: column-reverse;
        }
    }

    /* Loading State */
    .btn-loading {
        position: relative;
        pointer-events: none;
        opacity: 0.7;
    }
    
    .btn-loading::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        top: 50%;
        left: 50%;
        margin-left: -8px;
        margin-top: -8px;
        border: 2px solid #ffffff;
        border-radius: 50%;
        border-top-color: transparent;
        animation: spin 0.6s linear infinite;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Enhanced Tooltip */
    [data-bs-toggle="tooltip"] {
        cursor: help;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?= $this->include('layouts/alerts') ?>

<div class="container-fluid py-4">
    <div class="page-header-modern">
        <div class="page-header-content">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h3>
                        <i class="bi bi-plus-square me-2"></i>
                        Tambah Menu Baru
                    </h3>
                    <p>Tambahkan menu baru ke dalam sistem navigasi</p>
                </div>
                <div>
                    <a href="<?= site_url('menu') ?>" class="btn btn-back-modern">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger-modern alert-dismissible fade show" role="alert">
            <strong><i class="bi bi-exclamation-triangle me-2"></i>Terdapat kesalahan pada form:</strong>
            <ul class="mt-2 mb-0">
                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card form-card-modern">
        <div class="card-body">
            <form action="<?= site_url('menu') ?>" method="post" id="menuCreateForm">
                <?= csrf_field() ?>

                <div class="form-section-title">
                    <i class="bi bi-info-circle-fill"></i>
                    <span>Informasi Dasar Menu</span>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="menu_name" class="form-label-modern">
                            <i class="bi bi-tag-fill"></i>
                            Nama Menu
                            <span class="required">*</span>
                        </label>
                        <div class="input-group-modern">
                            <input type="text" 
                                   class="form-control-modern" 
                                   id="menu_name" 
                                   name="menu_name" 
                                   value="<?= esc(old('menu_name')) ?>" 
                                   placeholder="Contoh: Dashboard, Berita, Produk" 
                                   required>
                            <i class="bi bi-card-text input-icon"></i>
                        </div>
                        <div class="form-text-modern">
                            <i class="bi bi-lightbulb-fill"></i>
                            <span>Nama yang akan ditampilkan di menu navigasi</span>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="menu_url" class="form-label-modern">
                            <i class="bi bi-link-45deg"></i>
                            URL / Route
                        </label>
                        <div class="input-group-modern">
                            <input type="text" 
                                   class="form-control-modern" 
                                   id="menu_url" 
                                   name="menu_url" 
                                   value="<?= esc(old('menu_url')) ?>" 
                                   placeholder="/api/dashboard atau https://example.com">
                            <i class="bi bi-globe2 input-icon"></i>
                        </div>
                        <div class="form-text-modern">
                            <i class="bi bi-lightbulb-fill"></i>
                            <span>Kosongkan jika menu ini memiliki submenu (parent menu)</span>
                        </div>
                    </div>
                </div>

<div class="row">
    <div class="col-md-6 mb-4">
        <label for="admin_url" class="form-label-modern">
            <i class="bi bi-shield-lock-fill"></i>
            URL Admin
        </label>
        <div class="input-group-modern">
            <input type="text" 
                   class="form-control-modern" 
                   id="admin_url" 
                   name="admin_url" 
                   value="<?= esc(old('admin_url')) ?>" 
                   placeholder="/dashboard">
            <i class="bi bi-lock input-icon"></i>
        </div>
        <div class="form-text-modern">
            <i class="bi bi-lightbulb-fill"></i>
            <span>Kosongkan jika menu hanya tampil di frontend</span>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <label for="allowed_roles" class="form-label-modern">
            <i class="bi bi-person-badge-fill"></i>
            Hak Akses (Roles)
        </label>
        <div class="input-group-modern">
            <input type="text" 
                   class="form-control-modern" 
                   id="allowed_roles" 
                   name="allowed_roles" 
                   value="<?= esc(old('allowed_roles')) ?>" 
                   placeholder="superadmin, admin, editor">
            <i class="bi bi-people-fill input-icon"></i>
        </div>
        <div class="form-text-modern">
            <i class="bi bi-exclamation-circle-fill text-warning"></i>
            <span>Pisahkan dengan koma. Kosongkan untuk akses publik.</span>
        </div>
    </div>
</div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="order_number" class="form-label-modern">
                            <i class="bi bi-sort-numeric-down"></i>
                            Urutan Menu
                            <span class="required">*</span>
                        </label>
                        <div class="input-group-modern">
                            <input type="number" 
                                   class="form-control-modern" 
                                   id="order_number" 
                                   name="order_number" 
                                   value="<?= esc(old('order_number', '1')) ?>" 
                                   min="1"
                                   placeholder="Contoh: 1, 2, 3"
                                   required>
                            <i class="bi bi-list-ol input-icon"></i>
                        </div>
                        <div class="form-text-modern">
                            <i class="bi bi-lightbulb-fill"></i>
                            <span>Menentukan urutan tampilan menu (dari kecil ke besar)</span>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="status" class="form-label-modern">
                            <i class="bi bi-toggle2-on"></i>
                            Status Menu
                            <span class="required">*</span>
                        </label>
                        <div class="input-group-modern">
                            <select class="form-select-modern" id="status" name="status" required>
                                <option value="active" <?= old('status', 'active') === 'active' ? 'selected' : '' ?>>
                                    ✅ Aktif - Menu akan ditampilkan
                                </option>
                                <option value="inactive" <?= old('status') === 'inactive' ? 'selected' : '' ?>>
                                    ⛔ Nonaktif - Menu disembunyikan
                                </option>
                            </select>
                            <i class="bi bi-toggle-on input-icon"></i>
                        </div>
                        <div class="form-text-modern">
                            <i class="bi bi-lightbulb-fill"></i>
                            <span>Menu aktif akan langsung terlihat di sistem</span>
                        </div>
                    </div>
                </div>

                <div class="form-section-title mt-4">
                    <i class="bi bi-diagram-3-fill"></i>
                    <span>Struktur & Hierarki Menu</span>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label for="parent_id" class="form-label-modern">
                            <i class="bi bi-folder-symlink-fill"></i>
                            Parent Menu (Menu Induk)
                        </label>
                        <div class="input-group-modern">
                            <select class="form-select-modern" id="parent_id" name="parent_id">
                                <option value="0" <?= old('parent_id', '0') == '0' ? 'selected' : '' ?>>
                                    📌 Menu Utama (Tanpa Parent)
                                </option>

                                <?php if (!empty($menus)): ?>
                                    <?php foreach ($menus as $m): ?>
                                        <?php if ($m['parent_id'] == 0): ?>
                                            <option value="<?= $m['id_menu'] ?>" <?= old('parent_id') == $m['id_menu'] ? 'selected' : '' ?>>
                                                📁 <?= esc($m['menu_name']) ?>
                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <i class="bi bi-diagram-3 input-icon"></i>
                        </div>
                        <div class="form-text-modern">
                            <i class="bi bi-lightbulb-fill"></i>
                            <span>Pilih parent jika menu ini merupakan submenu dari menu lain</span>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-3 justify-content-end mt-5 pt-4 border-top">
                    <a href="<?= site_url('menu') ?>" class="btn btn-cancel-modern">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-submit-modern" id="submitBtn">
                        <i class="bi bi-check-circle me-2"></i>Simpan Menu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Auto-format URL input
    const urlInput = document.getElementById("menu_url");
    if (urlInput) {
        urlInput.addEventListener("blur", function (e) {
            let url = e.target.value.trim();
            if (url && !url.startsWith("/") && !url.startsWith("http")) {
                e.target.value = "/" + url;
            }
        });
        
        // Real-time validation indicator
        urlInput.addEventListener("input", function(e) {
            const value = e.target.value.trim();
            if (value) {
                if (value.startsWith("http") || value.startsWith("/")) {
                    this.style.borderColor = "#10b981";
                } else {
                    this.style.borderColor = "#f59e0b";
                }
            } else {
                this.style.borderColor = "#e2e8f0";
            }
        });
    }

    // Enhanced Form Validation
    const form = document.getElementById("menuCreateForm");
    const submitBtn = document.getElementById("submitBtn");
    
    form.addEventListener("submit", function (e) {
        const menuName = document.getElementById("menu_name").value.trim();
        const orderNum = document.getElementById("order_number").value.trim();
        
        let hasError = false;

        // Validasi Nama
        if (!menuName) {
            showError("menu_name", "Nama Menu harus diisi!");
            hasError = true;
        }

        // Validasi Urutan
        if (!orderNum) {
            showError("order_number", "Urutan harus diisi!");
            hasError = true;
        }
        
        if (hasError) {
            e.preventDefault();
            return false;
        }
        
        // Add loading state
        submitBtn.classList.add("btn-loading");
        submitBtn.innerHTML = '<span>Menyimpan...</span>';
        submitBtn.disabled = true;
    });

    function showError(elementId, message) {
        const input = document.getElementById(elementId);
        input.style.borderColor = "#ef4444";
        input.focus();
        
        // Remove existing error if any
        if (input.parentElement.nextElementSibling && input.parentElement.nextElementSibling.classList.contains('text-danger')) {
            input.parentElement.nextElementSibling.remove();
        }

        // Create error message
        const errorMsg = document.createElement("div");
        errorMsg.className = "text-danger mt-1 fw-bold small ps-2";
        errorMsg.innerHTML = '<i class="bi bi-exclamation-circle me-1"></i>' + message;
        
        input.parentElement.insertAdjacentElement('afterend', errorMsg);
        
        setTimeout(() => {
            errorMsg.remove();
            input.style.borderColor = "";
        }, 3000);
    }

    // Input focus effects
    const inputs = document.querySelectorAll('.form-control-modern, .form-select-modern');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'translateY(-2px)';
            this.parentElement.style.transition = 'transform 0.3s ease';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = '';
        });
    });

    // Initialize tooltips if Bootstrap is available
    if (typeof bootstrap !== 'undefined') {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
</script>
<?= $this->endSection() ?>