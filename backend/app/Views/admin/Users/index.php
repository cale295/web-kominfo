<?php
// ========================================
// 3. VIEW: App/Views/admin/users/index.php
// ========================================
?>
<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-people"></i> <?= $title ?></h2>
        <div>
            <a href="<?= base_url('admin/users/export-excel') ?>" class="btn btn-success">
                <i class="bi bi-file-excel"></i> Export Excel
            </a>
            <a href="<?= base_url('admin/users/add') ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah User
            </a>
        </div>
    </div>
    
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <?php 
        $totalUsers = 0;
        $statsByRole = [];
        foreach ($stats as $stat) {
            $totalUsers += $stat['total'];
            $statsByRole[$stat['role']] = $stat['total'];
        }
        ?>
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h6>Total User</h6>
                    <h2><?= $totalUsers ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h6>Super Admin</h6>
                    <h2><?= $statsByRole['Super Admin'] ?? 0 ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h6>Admin</h6>
                    <h2><?= $statsByRole['Admin'] ?? 0 ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h6>Editor</h6>
                    <h2><?= $statsByRole['Editor'] ?? 0 ?></h2>
                </div>
            </div>
        </div>
    </div>
    
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle"></i> <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <!-- Filters -->
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label>Filter by Role:</label>
                    <select id="roleFilter" class="form-select">
                        <option value="all">Semua Role</option>
                        <option value="Super Admin">Super Admin</option>
                        <option value="Admin">Admin</option>
                        <option value="Editor">Editor</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    
    <!-- DataTable -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="usersTable" class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data loaded via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Reset Password -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reset Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="resetUserId">
                <div class="mb-3">
                    <label>Password Baru:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="newPassword" placeholder="Minimal 8 karakter">
                        <button class="btn btn-secondary" onclick="generateRandomPassword()">
                            <i class="bi bi-arrow-repeat"></i> Generate
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="submitResetPassword()">Reset Password</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

<script>
let table;

$(document).ready(function() {
    // Initialize DataTable
    table = $('#usersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '<?= base_url('admin/users/ajax-list') ?>',
            type: 'POST',
            data: function(d) {
                d.role_filter = $('#roleFilter').val();
            }
        },
        columns: [
            { data: 0 },
            { data: 1 },
            { data: 2 },
            { data: 3 },
            { data: 4 },
            { data: 5, orderable: false }
        ],
        order: [[0, 'desc']],
        pageLength: 10,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
        }
    });
    
    // Role filter change
    $('#roleFilter').change(function() {
        table.ajax.reload();
    });
});

function resetPassword(userId) {
    $('#resetUserId').val(userId);
    $('#newPassword').val('');
    $('#resetPasswordModal').modal('show');
}

function generateRandomPassword() {
    $.get('<?= base_url('admin/users/generate-password') ?>', function(response) {
        $('#newPassword').val(response.password);
    });
}

function submitResetPassword() {
    const userId = $('#resetUserId').val();
    const newPassword = $('#newPassword').val();
    
    if (newPassword.length < 8) {
        alert('Password minimal 8 karakter!');
        return;
    }
    
    $.post('<?= base_url('admin/users/reset-password') ?>', {
        id_user: userId,
        new_password: newPassword
    }, function(response) {
        if (response.success) {
            alert(response.message);
            $('#resetPasswordModal').modal('hide');
        } else {
            alert(response.message);
        }
    });
}

function deleteUser(userId, username) {
    if (!confirm('Yakin ingin menghapus user "' + username + '"?')) {
        return;
    }
    
    $.post('<?= base_url('admin/users/delete/') ?>' + userId, function(response) {
        if (response.success) {
            alert(response.message);
            table.ajax.reload();
        } else {
            alert(response.message);
        }
    });
}
</script>

<?= $this->endSection() ?>