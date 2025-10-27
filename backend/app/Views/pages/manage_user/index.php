<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/pages/manage_user/index.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header-gov">
        <h1>
            <i class="bi bi-people-fill"></i>
            Manajemen Pengguna
        </h1>
        <p>Kelola data pengguna dan hak akses sistem informasi</p>
    </div>

    <!-- Alerts -->
    <?= $this->include('layouts/alerts') ?>

    <!-- Statistics Cards -->
    <div class="stats-row">
        <div class="stats-card-gov stats-card-primary">
            <div class="card-body">
                <div class="stats-info">
                    <h6>Total Pengguna</h6>
                    <h2><?= $totalUsers ?></h2>
                </div>
                <div class="stats-icon">
                    <i class="bi bi-people"></i>
                </div>
            </div>
        </div>

        <div class="stats-card-gov stats-card-danger">
            <div class="card-body">
                <div class="stats-info">
                    <h6>Super Admin</h6>
                    <h2><?= $superadmin ?></h2>
                </div>
                <div class="stats-icon">
                    <i class="bi bi-shield-fill-check"></i>
                </div>
            </div>
        </div>

        <div class="stats-card-gov stats-card-info">
            <div class="card-body">
                <div class="stats-info">
                    <h6>Administrator</h6>
                    <h2><?= $admin ?></h2>
                </div>
                <div class="stats-icon">
                    <i class="bi bi-person-badge"></i>
                </div>
            </div>
        </div>

        <div class="stats-card-gov stats-card-success">
            <div class="card-body">
                <div class="stats-info">
                    <h6>Editor</h6>
                    <h2><?= $editor ?></h2>
                </div>
                <div class="stats-icon">
                    <i class="bi bi-pencil-square"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Actions -->
    <div class="card filter-card-gov">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-lg-3 col-md-6">
                    <label class="filter-label">
                        <i class="bi bi-funnel"></i>
                        Filter Role
                    </label>
                    <select id="roleFilter" class="form-select form-select-gov">
                        <option value="">Semua Role</option>
                        <option value="superadmin">Super Admin</option>
                        <option value="admin">Admin</option>
                        <option value="editor">Editor</option>
                    </select>
                </div>

                <div class="col-lg-4 col-md-6">
                    <label class="filter-label">
                        <i class="bi bi-search"></i>
                        Pencarian
                    </label>
                    <input type="text"
                        id="searchInput"
                        class="form-control form-control-gov"
                        placeholder="Cari nama, username, atau email...">
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="filter-label">
                        <i class="bi bi-list-ol"></i>
                        Tampilkan
                    </label>
                    <select id="limitSelect" class="form-select form-select-gov">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>

                <div class="col-lg-3 col-md-6">
                    <a href="<?= base_url('manage_user/new') ?>" class="btn btn-add-user">
                        <i class="bi bi-plus-circle"></i>
                        Tambah Pengguna Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card table-card-gov">
        <div class="table-responsive">
            <table id="usersTable" class="table table-gov table-hover">
                <thead>
                    <tr>
                        <th style="width: 50px;">
                            <input type="checkbox" id="selectAll" class="form-check-input form-check-input-gov">
                        </th>
                        <th style="width: 60px;">ID</th>
                        <th style="width: 25%;">Nama Lengkap</th>
                        <th style="width: 15%;">Username</th>
                        <th style="width: 20%;">Email</th>
                        <th style="width: 12%;">Role</th>
                        <th style="width: 18%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td>
                                    <input type="checkbox"
                                        class="form-check-input form-check-input-gov user-checkbox"
                                        data-id="<?= $user['id_user'] ?>">
                                </td>
                                <td><strong><?= $user['id_user'] ?></strong></td>
                                <td>
                                    <strong><?= esc($user['full_name']) ?></strong>
                                </td>
                                <td>
                                    <code style="color: #64748b;"><?= esc($user['username']) ?></code>
                                </td>
                                <td><?= esc($user['email']) ?></td>
                                <td>
                                    <?php
                                    $roleClass = '';
                                    $roleLower = strtolower($user['role']);
                                    if (strpos($roleLower, 'super') !== false) {
                                        $roleClass = 'role-superadmin';
                                    } elseif (strpos($roleLower, 'admin') !== false) {
                                        $roleClass = 'role-admin';
                                    } else {
                                        $roleClass = 'role-editor';
                                    }
                                    ?>
                                    <span class="role-badge <?= $roleClass ?>">
                                        <?= esc($user['role']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-action-group">
                                        <a href="<?= base_url('manage_user/' . $user['id_user'] . '/show') ?>"
                                            class="btn-action btn-detail"
                                            title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                            Detail
                                        </a>
                                        <a href="<?= base_url('manage_user/' . $user['id_user'] . '/edit') ?>"
                                            class="btn-action btn-edit"
                                            title="Edit User">
                                            <i class="bi bi-pencil"></i>
                                            Edit
                                        </a>
                <form action="<?= site_url('manage_user/'.$user['id_user']) ?>" method="post" style="display:inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                </form>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <h5>Belum Ada Data Pengguna</h5>
                                    <p>Silakan tambahkan pengguna baru untuk memulai</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Table Footer -->
        <div class="table-footer">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="mb-2 mb-md-0">
                    <form id="deleteSelectedForm" action="<?= base_url('manage_user/delete_selected') ?>" method="post">
                        <?= csrf_field() ?>
                        <button type="button" id="deleteSelectedBtn" class="btn-delete-selected" disabled>
                            <i class="bi bi-trash me-2"></i>
                            Hapus Terpilih (<span id="selectedCount">0</span>)
                        </button>
                    </form>
                </div>
                <nav>
                    <ul class="pagination-gov" id="pagination">
                        <!-- Pagination will be generated by JavaScript -->
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
  const selectAllCheckbox = document.getElementById("selectAll");
  const userCheckboxes = document.querySelectorAll(".user-checkbox");
  const deleteBtn = document.getElementById("deleteSelectedBtn");
  const selectedCountSpan = document.getElementById("selectedCount");
  const deleteForm = document.getElementById("deleteSelectedForm");

  // Fungsi untuk memperbarui status tombol "Hapus Terpilih"
  function updateDeleteButtonState() {
    const checkedBoxes = document.querySelectorAll(".user-checkbox:checked");
    const count = checkedBoxes.length;

    selectedCountSpan.textContent = count;

    if (count > 0) {
      deleteBtn.disabled = false;
    } else {
      deleteBtn.disabled = true;
    }

    // Sinkronisasi checkbox "Select All"
    selectAllCheckbox.checked = count > 0 && count === userCheckboxes.length;
  }

  // Event listener untuk checkbox "Select All"
  selectAllCheckbox.addEventListener("change", function (e) {
    userCheckboxes.forEach((cb) => (cb.checked = e.target.checked));
    updateDeleteButtonState();
  });

  // Event listener untuk setiap checkbox user
  userCheckboxes.forEach((checkbox) => {
    checkbox.addEventListener("change", updateDeleteButtonState);
  });

  // Event listener untuk tombol "Hapus Terpilih"
  deleteBtn.addEventListener("click", function () {
    const checkedBoxes = document.querySelectorAll(".user-checkbox:checked");
    const ids = Array.from(checkedBoxes).map((cb) => cb.dataset.id);

    if (ids.length > 0) {
      if (
        confirm(
          `Apakah Anda yakin ingin menghapus ${ids.length} pengguna terpilih?`
        )
      ) {
        // Hapus input tersembunyi yang mungkin ada sebelumnya
        deleteForm
          .querySelectorAll('input[name="user_ids[]"]')
          .forEach((input) => input.remove());

        // Tambahkan ID yang terpilih sebagai input tersembunyi ke dalam form
        ids.forEach((id) => {
          const input = document.createElement("input");
          input.type = "hidden";
          input.name = "user_ids[]"; // Nama sebagai array agar mudah dibaca di PHP
          input.value = id;
          deleteForm.appendChild(input);
        });

        // Kirim form
        deleteForm.submit();
      }
    }
  });

  // Panggil fungsi sekali saat halaman dimuat untuk memastikan status tombol benar
  updateDeleteButtonState();

  // --- Kode Filter Anda (sudah benar, tidak perlu diubah) ---
  // Search Filter
  document
    .getElementById("searchInput")
    .addEventListener("input", function (e) {
      const searchTerm = e.target.value.toLowerCase();
      const rows = document.querySelectorAll("#usersTable tbody tr");

      rows.forEach((row) => {
        if (row.querySelector("td").colSpan === 7) return; // Abaikan baris "empty state"
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? "" : "none";
      });
    });

  // Role Filter
  document
    .getElementById("roleFilter")
    .addEventListener("change", function (e) {
      const filterRole = e.target.value.toLowerCase();
      const rows = document.querySelectorAll("#usersTable tbody tr");

      rows.forEach((row) => {
        if (row.querySelector("td").colSpan === 7) return; // Abaikan baris "empty state"
        if (!filterRole) {
          row.style.display = "";
        } else {
          const roleCell = row.querySelector(".role-badge");
          const role = roleCell
            ? roleCell.textContent.trim().toLowerCase()
            : "";
          row.style.display = role.includes(filterRole) ? "" : "none";
        }
      });
    });
});
</script>
<?= $this->endSection() ?>