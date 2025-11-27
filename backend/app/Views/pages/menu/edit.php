<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/pages/menu/edit.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
// Daftar Bootstrap Icons Umum (Sama dengan create.php)
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
    'bi bi-list-task'       => 'Task List',
    'bi bi-bar-chart'       => 'Chart / Analytics',
    'bi bi-image'           => 'Image / Gallery',
    'bi bi-newspaper'       => 'News / Article',
    'bi bi-link-45deg'      => 'Link',
    'bi bi-shield-check'    => 'Admin / Shield',
];
?>

<?= $this->include('layouts/alerts') ?>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header-gov">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h3>
                    <i class="bi bi-pencil-square me-2"></i>
                    Edit Menu
                </h3>
                <p>Perbarui informasi dan konfigurasi menu sistem</p>
            </div>
            <div class="mt-3 mt-md-0 d-flex gap-2">
                <a href="<?= site_url('menu') ?>" class="btn btn-back-gov">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>

                <!-- Tombol Hapus -->
                <form id="deleteForm" action="<?= site_url('menu/' . $menu['id_menu']) ?>" method="post" class="d-inline">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="button" class="btn btn-danger-gov" id="btnDelete">
                        <i class="bi bi-trash me-2 " ></i>Hapus Menu
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Error Alert -->
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger-gov alert-dismissible fade show" role="alert">
            <strong>Terdapat kesalahan pada form:</strong>
            <ul class="mt-2">
                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="card form-card-gov">
        <div class="card-body">
            <form id="menuForm" action="<?= site_url('menu/' . $menu['id_menu']) ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">

                <!-- Informasi Dasar -->
                <div class="form-section-title">
                    <i class="bi bi-info-circle"></i>
                    Informasi Dasar Menu
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="menu_name" class="form-label form-label-gov">
                            <i class="bi bi-tag"></i>
                            Nama Menu <span class="required">*</span>
                        </label>
                        <div class="input-group-gov">
                            <i class="bi bi-card-text input-icon"></i>
                            <input type="text"
                                   class="form-control form-control-gov"
                                   id="menu_name"
                                   name="menu_name"
                                   value="<?= esc($menu['menu_name']) ?>"
                                   placeholder="Contoh: Dashboard, Berita, dll"
                                   required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="menu_url" class="form-label form-label-gov">
                            <i class="bi bi-link-45deg"></i> URL / Route
                        </label>
                        <div class="input-group-gov">
                            <i class="bi bi-globe input-icon"></i>
                            <input type="text"
                                   class="form-control form-control-gov"
                                   id="menu_url"
                                   name="menu_url"
                                   value="<?= esc($menu['menu_url']) ?>"
                                   placeholder="/dashboard atau https://example.com">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="menu_icon" class="form-label form-label-gov">
                            <i class="bi bi-app-indicator"></i> Icon Bootstrap
                        </label>
                        <div class="input-group-gov">
                            <i class="bi bi-palette input-icon"></i>
                            <!-- Select Icon -->
                            <select class="form-select form-select-gov ps-5" id="menu_icon" name="menu_icon">
                                <option value="">-- Pilih Icon --</option>
                                <?php foreach ($bootstrapIcons as $class => $label): ?>
                                    <option value="<?= $class ?>" <?= $menu['menu_icon'] === $class ? 'selected' : '' ?>>
                                        <?= $label ?>
                                    </option>
                                <?php endforeach; ?>
                                
                                <!-- Fallback: Jika icon yang tersimpan tidak ada di list (custom manual sebelumnya), tetap tampilkan -->
                                <?php if (!empty($menu['menu_icon']) && !array_key_exists($menu['menu_icon'], $bootstrapIcons)): ?>
                                    <option value="<?= esc($menu['menu_icon']) ?>" selected>
                                        Custom (<?= esc($menu['menu_icon']) ?>)
                                    </option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-text-gov">
                            <i class="bi bi-lightbulb"></i>
                            Pilih ikon yang sesuai untuk representasi menu
                        </div>

                        <!-- Icon Preview -->
                        <div class="icon-preview-box mt-2">
                            <div class="preview-icon">
                                <i class="<?= esc($menu['menu_icon']) ?>" id="iconPreview"></i>
                            </div>
                            <div class="preview-text">Preview Icon</div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="order_number" class="form-label form-label-gov">
                            <i class="bi bi-list-ol"></i> Urutan Menu <span class="required">*</span>
                        </label>
                        <div class="input-group-gov">
                            <i class="bi bi-sort-numeric-down input-icon"></i>
                            <input type="number"
                                   class="form-control form-control-gov"
                                   id="order_number"
                                   name="order_number"
                                   value="<?= esc($menu['order_number']) ?>"
                                   required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="status" class="form-label form-label-gov">
                            <i class="bi bi-toggle-on"></i> Status Menu <span class="required">*</span>
                        </label>
                        <select class="form-select form-select-gov" id="status" name="status" required>
                            <option value="active" <?= $menu['status'] === 'active' ? 'selected' : '' ?>>✓ Aktif</option>
                            <option value="inactive" <?= $menu['status'] === 'inactive' ? 'selected' : '' ?>>✗ Nonaktif</option>
                        </select>
                    </div>
                </div>

                <!-- Struktur Menu -->
                <div class="form-section-title">
                    <i class="bi bi-diagram-3"></i> Struktur & Hierarki Menu
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label for="parent_id" class="form-label form-label-gov">
                            <i class="bi bi-folder-symlink"></i> Parent Menu (Induk)
                        </label>
                        <select class="form-select form-select-gov" id="parent_id" name="parent_id">
                            <option value="0" <?= $menu['parent_id'] == 0 ? 'selected' : '' ?>>
                                📌 Menu Utama (Tanpa Parent)
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
                </div>

                <!-- Tombol Aksi -->
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
<!-- SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Hapus Menu
    document.getElementById('btnDelete').addEventListener('click', function () {
        Swal.fire({
            title: 'Yakin ingin menghapus menu ini?',
            text: "Menu yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus sekarang!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm').submit();
            }
        });
    });

    // Icon Preview (Updated for Select)
    const iconSelect = document.getElementById("menu_icon");
    const previewIcon = document.getElementById("iconPreview");

    if (iconSelect) {
        iconSelect.addEventListener("change", function (e) {
            const iconClass = e.target.value;
            // Reset class list
            previewIcon.className = "";
            // Set new class or default if empty
            previewIcon.className = iconClass || "bi bi-question-circle";
        });
    }
</script>
<?= $this->endSection() ?>