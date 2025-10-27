<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/pages/menu/edit.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
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
            <div class="mt-3 mt-md-0">
                <a href="<?= site_url('menu') ?>" class="btn btn-back-gov">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
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
            <form action="<?= site_url('menu/update/' . $menu['id_menu']) ?>" method="post" id="menuForm">
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
                            Nama Menu
                            <span class="required">*</span>
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
                        <div class="form-text-gov">
                            <i class="bi bi-lightbulb"></i>
                            Nama yang akan ditampilkan di menu navigasi
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="menu_url" class="form-label form-label-gov">
                            <i class="bi bi-link-45deg"></i>
                            URL / Route
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
                        <div class="form-text-gov">
                            <i class="bi bi-lightbulb"></i>
                            Kosongkan jika menu memiliki submenu
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="menu_icon" class="form-label form-label-gov">
                            <i class="bi bi-app-indicator"></i>
                            Icon Bootstrap
                        </label>
                        <div class="input-group-gov">
                            <i class="bi bi-palette input-icon"></i>
                            <input type="text" 
                                   class="form-control form-control-gov" 
                                   id="menu_icon" 
                                   name="menu_icon" 
                                   value="<?= esc($menu['menu_icon']) ?>"
                                   placeholder="bi-speedometer2">
                        </div>
                        <div class="form-text-gov">
                            <i class="bi bi-lightbulb"></i>
                            Gunakan kelas dari Bootstrap Icons
                        </div>
                        <!-- Icon Preview -->
                        <div class="icon-preview-box">
                            <div class="preview-icon">
                                <i class="<?= esc($menu['menu_icon']) ?>" id="iconPreview"></i>
                            </div>
                            <div class="preview-text">Preview Icon</div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="status" class="form-label form-label-gov">
                            <i class="bi bi-toggle-on"></i>
                            Status Menu
                            <span class="required">*</span>
                        </label>
                        <select class="form-select form-select-gov" id="status" name="status" required>
                            <option value="active" <?= $menu['status'] === 'active' ? 'selected' : '' ?>>
                                ✓ Aktif - Menu ditampilkan
                            </option>
                            <option value="inactive" <?= $menu['status'] === 'inactive' ? 'selected' : '' ?>>
                                ✗ Nonaktif - Menu disembunyikan
                            </option>
                        </select>
                        <div class="form-text-gov">
                            <i class="bi bi-lightbulb"></i>
                            Status aktif akan menampilkan menu di sistem
                        </div>
                    </div>
                </div>

                <!-- Struktur Menu -->
                <div class="form-section-title">
                    <i class="bi bi-diagram-3"></i>
                    Struktur & Hierarki Menu
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label for="parent_id" class="form-label form-label-gov">
                            <i class="bi bi-folder-symlink"></i>
                            Parent Menu (Induk)
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
                        <div class="form-text-gov">
                            <i class="bi bi-lightbulb"></i>
                            Pilih parent jika menu ini merupakan submenu
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
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
<script>
    // Icon Preview Live Update
document.getElementById("menu_icon").addEventListener("input", function (e) {
  const iconClass = e.target.value;
  const previewIcon = document.getElementById("iconPreview");

  // Remove all bi- classes
  previewIcon.className = "";

  // Add new icon class
  if (iconClass) {
    previewIcon.className = iconClass;
  } else {
    previewIcon.className = "bi bi-question-circle";
  }
});

// Form Validation Enhancement
document.getElementById("menuForm").addEventListener("submit", function (e) {
  const menuName = document.getElementById("menu_name").value.trim();

  if (menuName === "") {
    e.preventDefault();
    alert("Nama Menu harus diisi!");
    document.getElementById("menu_name").focus();
    return false;
  }
});

// Auto-format URL input
document.getElementById("menu_url").addEventListener("blur", function (e) {
  let url = e.target.value.trim();

  if (url && !url.startsWith("/") && !url.startsWith("http")) {
    e.target.value = "/" + url;
  }
});

// Parent selection info
document.getElementById("parent_id").addEventListener("change", function (e) {
  const parentId = e.target.value;
  const urlInput = document.getElementById("menu_url");

  if (parentId !== "0") {
    // Submenu biasanya tidak perlu URL jika parent punya URL
    console.log("Submenu selected - URL optional");
  }
});
</script>
<?= $this->endSection() ?>
