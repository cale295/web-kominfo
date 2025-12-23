<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    /* Variabel Warna Tema Government/Enterprise */
    :root {
        --primary-gov: #2c3e50;       /* Navy Blue - Warna Utama */
        --secondary-gov: #34495e;     /* Abu Tua - Teks Label */
        --accent-gov: #3498db;        /* Biru Terang - Fokus/Link */
        --success-gov: #27ae60;       /* Hijau - Sukses */
        --danger-gov: #e74c3c;        /* Merah - Hapus/Error */
        --bg-light: #f8f9fa;          /* Background terang */
        --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.05); /* Bayangan halus */
    }

    /* Header Halaman */
    .page-header-gov {
        background: #ffffff;
        padding: 1.5rem 2rem;
        border-radius: 12px;
        box-shadow: var(--card-shadow);
        margin-bottom: 2rem;
        border-left: 5px solid var(--primary-gov);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .page-header-gov h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-gov);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-header-gov p {
        color: #7f8c8d;
        margin: 5px 0 0 0;
        font-size: 0.95rem;
    }

    /* Card Utama Form */
    .form-card-gov {
        border: none;
        border-radius: 12px;
        box-shadow: var(--card-shadow);
        background: #ffffff;
        overflow: hidden;
    }

    .card-body {
        padding: 2.5rem;
    }

    /* Judul Per-Bagian (Divider) */
    .form-section-title {
        color: var(--primary-gov);
        font-size: 1.1rem;
        font-weight: 600;
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 10px;
        margin-bottom: 25px;
        margin-top: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Styling Input & Label */
    .form-label-gov {
        font-weight: 600;
        color: var(--secondary-gov);
        font-size: 0.9rem;
        margin-bottom: 8px;
        display: block;
    }

    .form-label-gov i {
        color: var(--accent-gov);
        margin-right: 5px;
    }

    .required { color: var(--danger-gov); margin-left: 3px; }

    /* Wrapper Input untuk Icon di dalam */
    .input-group-gov {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon {
        position: absolute;
        left: 15px;
        color: #95a5a6;
        z-index: 10;
        font-size: 1.1rem;
        pointer-events: none; /* Supaya klik tembus ke input */
    }

    .form-control-gov, .form-select-gov {
        padding: 0.75rem 1rem 0.75rem 3rem !important; /* Padding kiri besar agar tidak menimpa icon */
        border-radius: 8px !important;
        border: 1px solid #ced4da;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        width: 100%;
        background-color: #fff;
    }

    .form-control-gov:focus, .form-select-gov:focus {
        border-color: var(--accent-gov);
        box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.1);
    }

    .form-text-gov {
        font-size: 0.8rem;
        color: #7f8c8d;
        margin-top: 5px;
    }

    /* Kotak Preview Icon */
    .icon-preview-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 0.5rem;
        background-color: #f8f9fa;
        border: 2px dashed #ced4da;
        border-radius: 10px;
        min-width: 100px;
        text-align: center;
        height: 100%;
    }
    
    .preview-icon i {
        font-size: 2rem;
        color: var(--primary-gov);
    }
    
    .preview-label {
        font-size: 0.7rem;
        color: #95a5a6;
        margin-top: 5px;
    }

    /* Tombol */
    .btn-back-gov {
        background-color: #95a5a6;
        color: white;
        border-radius: 8px;
        padding: 0.6rem 1.2rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s;
    }
    .btn-back-gov:hover { background-color: #7f8c8d; color: white; transform: translateY(-2px); }

    .btn-danger-gov {
        background-color: white;
        color: var(--danger-gov);
        border: 1px solid var(--danger-gov);
        border-radius: 8px;
        padding: 0.6rem 1.2rem;
        font-weight: 500;
        transition: all 0.3s;
    }
    .btn-danger-gov:hover { background-color: var(--danger-gov); color: white; box-shadow: 0 4px 10px rgba(231, 76, 60, 0.3); }

    .btn-submit-gov {
        background-color: var(--primary-gov);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-submit-gov:hover { background-color: #1a252f; transform: translateY(-2px); box-shadow: 0 4px 10px rgba(44, 62, 80, 0.3); }

    .btn-cancel-gov {
        background-color: transparent;
        color: #7f8c8d;
        border: 1px solid transparent;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s;
    }
    .btn-cancel-gov:hover { background-color: #f1f2f6; color: var(--danger-gov); }

    /* Alert Styling */
    .alert-danger-gov {
        background-color: #fcebeb;
        border: 1px solid #f5c6cb;
        color: #721c24;
        border-radius: 8px;
        border-left: 5px solid #e74c3c;
    }
</style>

<?php
// PHP LOGIC: Daftar Icon Bootstrap untuk Dropdown
$bootstrapIcons = [
    'bi bi-house-door'      => 'Home / Dashboard',
    'bi bi-speedometer2'    => 'Speedometer',
    'bi bi-grid'            => 'Grid / App',
    'bi bi-columns-gap'     => 'Layout / Columns',
    'bi bi-table'           => 'Table',
    'bi bi-people'          => 'People / Users',
    'bi bi-person-circle'   => 'User Profile',
    'bi bi-gear'            => 'Settings / Gear',
    'bi bi-file-text'       => 'File / Document',
    'bi bi-journal-text'    => 'Journal / Log',
    'bi bi-calendar-event'  => 'Calendar / Event',
    'bi bi-chat-dots'       => 'Chat / Message',
    'bi bi-bell'            => 'Notification / Bell',
    'bi bi-envelope'        => 'Email / Envelope',
    'bi bi-box-seam'        => 'Box / Product',
    'bi bi-folder2-open'    => 'Folder',
    'bi bi-check-circle'    => 'Success / Check',
    'bi bi-question-circle' => 'Help / Question',
    'bi bi-lock'            => 'Security / Lock',
    'bi bi-shield-check'    => 'Admin / Shield',
    'bi bi-bar-chart'       => 'Chart / Analytics',
    'bi bi-image'           => 'Image / Gallery',
    'bi bi-newspaper'       => 'News / Article',
    'bi bi-link-45deg'      => 'Link',
];
?>

<?= $this->include('layouts/alerts') ?>

<div class="container-fluid py-4">
    
    <div class="page-header-gov">
        <div>
            <h3><i class="bi bi-pencil-square"></i> Edit Menu</h3>
            <p>Perbarui informasi dan konfigurasi menu sistem</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= site_url('menu') ?>" class="btn btn-back-gov">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
            
            <form id="deleteForm" action="<?= site_url('menu/' . $menu['id_menu']) ?>" method="post" class="d-inline">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="DELETE">
                <button type="button" class="btn btn-danger-gov" id="btnDelete">
                    <i class="bi bi-trash me-2"></i>Hapus
                </button>
            </form>
        </div>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger-gov alert-dismissible fade show mb-4 shadow-sm" role="alert">
            <div class="d-flex">
                <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                <div>
                    <strong>Terdapat kesalahan input:</strong>
                    <ul class="mt-1 mb-0 ps-3">
                        <?php foreach(session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card form-card-gov">
        <div class="card-body">
            <form id="menuForm" action="<?= site_url('menu/' . $menu['id_menu']) ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">

                <div class="form-section-title">
                    <i class="bi bi-info-circle"></i> Informasi Dasar
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="menu_name" class="form-label form-label-gov">
                            <i class="bi bi-tag"></i> Nama Menu <span class="required">*</span>
                        </label>
                        <div class="input-group-gov">
                            <i class="bi bi-card-text input-icon"></i>
                            <input type="text" class="form-control form-control-gov" 
                                   id="menu_name" name="menu_name" 
                                   value="<?= esc($menu['menu_name']) ?>" 
                                   placeholder="Contoh: Dashboard" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="menu_url" class="form-label form-label-gov">
                            <i class="bi bi-link-45deg"></i> URL / Route
                        </label>
                        <div class="input-group-gov">
                            <i class="bi bi-globe input-icon"></i>
                            <input type="text" class="form-control form-control-gov" 
                                   id="menu_url" name="menu_url" 
                                   value="<?= esc($menu['menu_url']) ?>" 
                                   placeholder="Contoh: /api/dashboard">
                        </div>
                    </div>
                </div>

<div class="row">
    <div class="col-md-6 mb-4">
        <label for="admin_url" class="form-label form-label-gov">
            <i class="bi bi-shield-lock"></i> URL Admin
        </label>
        <div class="input-group-gov">
            <i class="bi bi-lock input-icon"></i>
            <input type="text" class="form-control form-control-gov" 
                   id="admin_url" name="admin_url" 
                   value="<?= esc($menu['admin_url'] ?? '') ?>" 
                   placeholder="/dashboard">
        </div>
        <div class="form-text-gov">
            Kosongkan jika menu tidak tampil di admin panel.
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <label for="allowed_roles" class="form-label form-label-gov">
            <i class="bi bi-person-badge"></i> Hak Akses (Roles)
        </label>
        <div class="input-group-gov">
            <i class="bi bi-people input-icon"></i>
            <input type="text" class="form-control form-control-gov" 
                   id="allowed_roles" name="allowed_roles" 
                   value="<?= esc($menu['allowed_roles'] ?? '') ?>" 
                   placeholder="superadmin, admin, editor">
        </div>
        <div class="form-text-gov text-warning">
            <i class="bi bi-info-circle"></i> Pisahkan dengan koma. Kosongkan untuk publik.
        </div>
    </div>
</div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="menu_icon" class="form-label form-label-gov">
                            <i class="bi bi-app-indicator"></i> Icon Bootstrap
                        </label>
                        <div class="d-flex gap-3 align-items-stretch">
                            <div class="flex-grow-1">
                                <div class="input-group-gov">
                                    <i class="bi bi-palette input-icon"></i>
                                    <select class="form-select form-select-gov" id="menu_icon" name="menu_icon">
                                        <option value="">-- Pilih Icon --</option>
                                        <?php foreach ($bootstrapIcons as $class => $label): ?>
                                            <option value="<?= $class ?>" <?= $menu['menu_icon'] === $class ? 'selected' : '' ?>>
                                                <?= $label ?>
                                            </option>
                                        <?php endforeach; ?>
                                        <?php if (!empty($menu['menu_icon']) && !array_key_exists($menu['menu_icon'], $bootstrapIcons)): ?>
                                            <option value="<?= esc($menu['menu_icon']) ?>" selected>Custom (<?= esc($menu['menu_icon']) ?>)</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-text-gov">Pilih ikon yang merepresentasikan menu.</div>
                            </div>
                            <div class="icon-preview-box">
                                <div class="preview-icon">
                                    <i class="<?= esc($menu['menu_icon']) ?: 'bi bi-question-circle' ?>" id="iconPreview"></i>
                                </div>
                                <span class="preview-label">Preview</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="order_number" class="form-label form-label-gov">
                                    <i class="bi bi-list-ol"></i> Urutan <span class="required">*</span>
                                </label>
                                <div class="input-group-gov">
                                    <i class="bi bi-sort-numeric-down input-icon"></i>
                                    <input type="number" class="form-control form-control-gov" 
                                           id="order_number" name="order_number" 
                                           value="<?= esc($menu['order_number']) ?>" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="status" class="form-label form-label-gov">
                                    <i class="bi bi-toggle-on"></i> Status <span class="required">*</span>
                                </label>
                                <div class="input-group-gov">
                                    <i class="bi bi-check-circle input-icon"></i>
                                    <select class="form-select form-select-gov" id="status" name="status" required>
                                        <option value="active" <?= $menu['status'] === 'active' ? 'selected' : '' ?>>Aktif</option>
                                        <option value="inactive" <?= $menu['status'] === 'inactive' ? 'selected' : '' ?>>Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section-title mt-2">
                    <i class="bi bi-diagram-3"></i> Struktur Hierarki
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label for="parent_id" class="form-label form-label-gov">
                            <i class="bi bi-folder-symlink"></i> Parent Menu (Induk)
                        </label>
                        <div class="input-group-gov">
                            <i class="bi bi-diagram-2 input-icon"></i>
                            <select class="form-select form-select-gov" id="parent_id" name="parent_id">
                                <option value="0" <?= $menu['parent_id'] == 0 ? 'selected' : '' ?>>
                                    📌 Menu Utama (Root / Tanpa Parent)
                                </option>
                                <?php foreach ($menus as $m): ?>
                                    <?php if ($m['parent_id'] == 0 && $m['id_menu'] != $menu['id_menu']): ?>
                                        <option value="<?= $m['id_menu'] ?>" <?= $menu['parent_id'] == $m['id_menu'] ? 'selected' : '' ?>>
                                            📁 <?= esc($m['menu_name']) ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-text-gov">
                            Jika dipilih sebagai "Menu Utama", menu ini akan tampil di sidebar level teratas.
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 justify-content-end mt-4 pt-3 border-top">
                    <a href="<?= site_url('menu') ?>" class="btn btn-cancel-gov">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-submit-gov">
                        <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    /**
     * 1. Script Konfirmasi Hapus (SweetAlert)
     * Menggunakan SweetAlert untuk dialog konfirmasi yang cantik.
     */
    document.getElementById('btnDelete').addEventListener('click', function () {
        Swal.fire({
            title: 'Hapus Menu?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74c3c', // Warna Merah (Gov Theme)
            cancelButtonColor: '#95a5a6',  // Warna Abu (Gov Theme)
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form hidden jika user menekan Ya
                document.getElementById('deleteForm').submit();
            }
        });
    });

    /**
     * 2. Script Real-time Icon Preview
     * Mengubah ikon di kotak preview saat dropdown berubah.
     */
    const iconSelect = document.getElementById("menu_icon");
    const previewIcon = document.getElementById("iconPreview");

    if (iconSelect) {
        iconSelect.addEventListener("change", function (e) {
            const iconClass = e.target.value;
            // Jika kosong, tampilkan tanda tanya. Jika ada, tampilkan iconnya.
            previewIcon.className = iconClass ? iconClass : "bi bi-question-circle";
        });
    }
</script>
<?= $this->endSection() ?>