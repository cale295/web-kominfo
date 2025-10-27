<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/pages/menu/index.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header-gov">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h3>
                    <i class="bi bi-menu-button-wide me-2"></i>
                    <?= esc($title) ?>
                </h3>
                <p>Kelola menu dan submenu yang tampil di sistem informasi</p>
            </div>
            <?php if ($can_create): ?>
                <div class="mt-3 mt-md-0">
                    <a href="<?= site_url('menu/create') ?>" class="btn">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Menu Baru
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success-gov alert-gov alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <strong>Berhasil!</strong> <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger-gov alert-gov alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Error!</strong> <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Data Table Card -->
    <div class="card card-gov">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-gov table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th style="width: 35%;">Nama Menu</th>
                            <th style="width: 30%;">URL</th>
                            <th style="width: 15%;">Status</th>
                            <th style="width: 120px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $parents = array_filter($menus, fn($m) => $m['parent_id'] == 0);
                        $children = array_filter($menus, fn($m) => $m['parent_id'] != 0);
                        $counter = 1;

                        if (empty($parents)):
                        ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="bi bi-inbox"></i>
                                        <h5>Belum Ada Menu</h5>
                                        <p>Silakan tambahkan menu baru untuk memulai</p>
                                    </div>
                                </td>
                            </tr>
                        <?php
                        endif;

                        foreach ($parents as $parent):
                        ?>
                            <!-- Parent Menu Row -->
                            <tr class="parent-row">
                                <td><strong><?= $counter++ ?></strong></td>
                                <td>
                                    <i class="<?= esc($parent['menu_icon']) ?> menu-icon"></i>
                                    <strong><?= esc($parent['menu_name']) ?></strong>
                                </td>
                                <td>
                                    <code class="text-primary"><?= esc($parent['menu_url']) ?: '-' ?></code>
                                </td>
                                <td>
                                    <span class="badge-gov <?= ($parent['status'] === 'active') ? 'badge-active' : 'badge-inactive' ?>">
                                        <?= ($parent['status'] === 'active') ? 'Aktif' : 'Nonaktif' ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group-gov justify-content-center">
                                        <?php if ($can_update): ?>
                                            <form action="<?= site_url('menu/toggleStatus/' . $parent['id_menu']) ?>" method="post" class="d-inline form-toggle-status">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn-action <?= ($parent['status'] === 'active') ? 'btn-toggle-active' : '' ?>" 
                                                        data-bs-toggle="tooltip" 
                                                        title="<?= ($parent['status'] === 'active') ? 'Nonaktifkan Menu' : 'Aktifkan Menu' ?>">
                                                    <i class="bi <?= ($parent['status'] === 'active') ? 'bi-toggle-on' : 'bi-toggle-off' ?>"></i>
                                                </button>
                                            </form>
                                            <a href="<?= site_url('menu/' . $parent['id_menu'].'/edit') ?>" 
                                               class="btn-action btn-edit" 
                                               data-bs-toggle="tooltip" 
                                               title="Edit Menu">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>

                            <!-- Child Menu Rows -->
                            <?php foreach ($children as $child):
                                if ($child['parent_id'] == $parent['id_menu']):
                            ?>
                                <tr class="child-row">
                                    <td><?= $counter++ ?></td>
                                    <td>
                                        <span class="child-indicator">└─</span>
                                        <i class="<?= esc($child['menu_icon']) ?> menu-icon"></i>
                                        <?= esc($child['menu_name']) ?>
                                    </td>
                                    <td>
                                        <code class="text-muted"><?= esc($child['menu_url']) ?: '-' ?></code>
                                    </td>
                                    <td>
                                        <span class="badge-gov <?= ($child['status'] === 'active') ? 'badge-active' : 'badge-inactive' ?>">
                                            <?= ($child['status'] === 'active') ? 'Aktif' : 'Nonaktif' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group-gov justify-content-center">
                                            <?php if ($can_update): ?>
                                                <form action="<?= site_url('menu/toggleStatus/' . $child['id_menu']) ?>" method="post" class="d-inline form-toggle-status">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn-action <?= ($child['status'] === 'active') ? 'btn-toggle-active' : '' ?>" 
                                                            data-bs-toggle="tooltip" 
                                                            title="<?= ($child['status'] === 'active') ? 'Nonaktifkan Menu' : 'Aktifkan Menu' ?>">
                                                        <i class="bi <?= ($child['status'] === 'active') ? 'bi-toggle-on' : 'bi-toggle-off' ?>"></i>
                                                    </button>
                                                </form>
                                                <a href="<?= site_url('menu/' . $child['id_menu'].'/edit') ?>" 
                                                   class="btn-action btn-edit" 
                                                   data-bs-toggle="tooltip" 
                                                   title="Edit Menu">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                                endif;
                            endforeach;
                            ?>
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
    // Initialize tooltips
document.addEventListener("DOMContentLoaded", function () {
  const tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });
});

// Toggle Status with AJAX
document.querySelectorAll(".form-toggle-status").forEach((form) => {
  form.addEventListener("submit", function (e) {
    e.preventDefault();

    const url = this.action;
    const formData = new FormData(this);
    const btn = this.querySelector("button");
    const icon = btn.querySelector("i");
    const row = this.closest("tr");
    const badgeCell = row.querySelector("td:nth-child(4) .badge-gov");

    // Add loading state
    btn.classList.add("loading");
    btn.disabled = true;

    fetch(url, {
      method: "POST",
      body: formData,
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.success) {
          // Update icon and badge
          if (data.newStatus === "active") {
            icon.classList.remove("bi-toggle-off");
            icon.classList.add("bi-toggle-on");
            btn.classList.add("btn-toggle-active");
            btn.setAttribute("data-bs-original-title", "Nonaktifkan Menu");

            badgeCell.className = "badge-gov badge-active";
            badgeCell.textContent = "Aktif";
          } else {
            icon.classList.remove("bi-toggle-on");
            icon.classList.add("bi-toggle-off");
            btn.classList.remove("btn-toggle-active");
            btn.setAttribute("data-bs-original-title", "Aktifkan Menu");

            badgeCell.className = "badge-gov badge-inactive";
            badgeCell.textContent = "Nonaktif";
          }

          // Show success animation
          row.style.animation = "none";
          setTimeout(() => {
            row.style.animation = "fadeInUp 0.3s ease-out";
          }, 10);
        } else {
          // Show error alert
          showAlert("danger", data.message || "Gagal memperbarui status");
        }
      })
      .catch((err) => {
        console.error(err);
        showAlert("danger", "Terjadi kesalahan saat memperbarui status");
      })
      .finally(() => {
        // Remove loading state
        btn.classList.remove("loading");
        btn.disabled = false;
      });
  });
});

// Show Alert Function
function showAlert(type, message) {
  const alertClass =
    type === "danger" ? "alert-danger-gov" : "alert-success-gov";
  const icon =
    type === "danger" ? "bi-exclamation-triangle-fill" : "bi-check-circle-fill";
  const title = type === "danger" ? "Error!" : "Berhasil!";

  const alertHTML = `
        <div class="alert ${alertClass} alert-gov alert-dismissible fade show" role="alert">
            <i class="bi ${icon} me-2"></i>
            <strong>${title}</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;

  const container = document.querySelector(".container-fluid");
  const firstCard = container.querySelector(".card-gov");
  firstCard.insertAdjacentHTML("beforebegin", alertHTML);

  // Auto dismiss after 5 seconds
  setTimeout(() => {
    const alert = container.querySelector(".alert-gov");
    if (alert) {
      const bsAlert = new bootstrap.Alert(alert);
      bsAlert.close();
    }
  }, 5000);
}
</script>
<?= $this->endSection() ?>