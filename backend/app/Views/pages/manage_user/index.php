<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        /* Reset & Base Styles */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background-color: #f8f9fa; padding: 20px; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; line-height: 1.5; color: #212529; }
        h1,h2,h3,h4,h5,h6 { margin-top:0; margin-bottom:.5rem; font-weight:500; line-height:1.2; }
        .display-5 { font-size: 2.5rem; font-weight: 300; }
        .mb-0 { margin-bottom: 0 !important; }
        .mb-1 { margin-bottom: .25rem !important; }
        .mb-2 { margin-bottom: .5rem !important; }
        .mb-3 { margin-bottom: 1rem !important; }
        .mb-4 { margin-bottom: 1.5rem !important; }
        .mt-2 { margin-top: .5rem !important; }
        .mt-3 { margin-top: 1rem !important; }
        .me-2 { margin-right: .5rem !important; }
        .py-4 { padding-top:1.5rem !important; padding-bottom:1.5rem !important; }
        .py-5 { padding-top:3rem !important; padding-bottom:3rem !important; }
        .d-flex { display: flex !important; }
        .d-none { display: none !important; }
        .flex-wrap { flex-wrap: wrap !important; }
        .align-items-center { align-items: center !important; }
        .align-items-end { align-items: flex-end !important; }
        .justify-content-between { justify-content: space-between !important; }
        .justify-content-center { justify-content: center !important; }
        .w-100 { width: 100% !important; }
        .g-3 > * { padding: .75rem; }
        .container { max-width: 1320px; margin:0 auto; padding:0 15px; width:100%; }
        .row { display:flex; flex-wrap:wrap; margin-right:-15px; margin-left:-15px; }
        .col, .col-md-2, .col-md-3, .col-md-4 { position:relative; width:100%; padding-right:15px; padding-left:15px; }
        @media(min-width:768px){ .col-md-2{flex:0 0 auto;width:16.666667%} .col-md-3{flex:0 0 auto;width:25%} .col-md-4{flex:0 0 auto;width:33.333333%} }
        .card { position:relative; display:flex; flex-direction:column; min-width:0; word-wrap:break-word; background-color:#fff; border:none; border-radius:10px; box-shadow:0 2px 4px rgba(0,0,0,0.1); padding:20px; margin-bottom:20px; }
        .card-body { flex:1 1 auto; padding:1.25rem; }
        .btn { display:inline-block; font-weight:400; line-height:1.5; text-align:center; text-decoration:none; vertical-align:middle; cursor:pointer; user-select:none; border:1px solid transparent; padding:.375rem .75rem; font-size:1rem; border-radius:.375rem; transition:all .15s ease-in-out; }
        .btn:hover{ opacity:.9; }
        .btn-gradient{ background: linear-gradient(90deg,#0d6efd,#6610f2); border:none; color:white; padding:8px 16px; border-radius:6px; cursor:pointer; text-decoration:none; display:inline-block; }
        .btn-gradient:hover{ background: linear-gradient(90deg,#0b5ed7,#520dc2); color:white; }
        .stats-card{ transition: all .3s ease-in-out; border-radius:10px; }
        .stats-card:hover{ transform: translateY(-5px); box-shadow:0 4px 15px rgba(0,0,0,0.2); }
        .table-responsive { overflow-x:auto; -webkit-overflow-scrolling:touch; }
        .table { width:100%; margin-bottom:1rem; color:#212529; vertical-align:top; border-color:#dee2e6; border-collapse:collapse; }
        .table th,.table td { padding:.75rem; border-bottom:1px solid #dee2e6; }
        .table-hover > tbody > tr:hover { background-color:#f8f9fa; }
        .align-middle { vertical-align: middle !important; }
        .btn-sm { padding:.25rem .5rem; font-size:.875rem; border-radius:.25rem; }
        .btn-info { color:#000; background-color:#0dcaf0; border-color:#0dcaf0; }
        .btn-warning { color:#000; background-color:#ffc107; border-color:#ffc107; }
        .btn-danger { color:#fff; background-color:#dc3545; border-color:#dc3545; }
        .btn-group { display:inline-flex; gap:5px; }
        .badge { padding:4px 8px; border-radius:4px; color:white; font-size:.875rem; }
        .bg-danger { background-color:#dc3545; }
        .bg-primary { background-color:#0d6efd; }
        .bg-success { background-color:#198754; }
        .bg-info { background-color:#0dcaf0; }
        .form-control, .form-select { display:block; width:100%; padding:.375rem .75rem; font-size:1rem; font-weight:400; line-height:1.5; color:#212529; background-color:#fff; border:1px solid #ced4da; border-radius:.375rem; transition:border-color .15s ease-in-out, box-shadow .15s ease-in-out; }
        .form-control:focus, .form-select:focus { color:#212529; background-color:#fff; border-color:#86b7fe; outline:0; box-shadow:0 0 0 .25rem rgba(13,110,253,.25); }
        .form-label{ display:block; margin-bottom:.5rem; }
        .form-check-input{ width:1em; height:1em; margin-top:.25em; vertical-align:top; background-color:#fff; border:1px solid rgba(0,0,0,.25); appearance:none; cursor:pointer; }
        .form-check-input[type="checkbox"]{ border-radius:.25em; }
        .form-check-input:checked{ background-color:#0d6efd; border-color:#0d6efd; }
        .form-check-input:checked[type="checkbox"]{ background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M6 10l3 3l6-6'/%3e%3c/svg%3e"); }
        .spinner-border { width:2rem; height:2rem; border:.25em solid currentColor; border-right-color:transparent; border-radius:50%; animation:spinner-border .75s linear infinite; }
        @keyframes spinner-border { to { transform: rotate(360deg); } }
        .pagination { display:flex; padding-left:0; list-style:none; gap:5px; }
        .page-item { display:inline-block; }
        .page-link { position:relative; display:block; padding:.375rem .75rem; color:#0d6efd; text-decoration:none; background-color:#fff; border:1px solid #dee2e6; border-radius:.375rem; transition:all .15s ease-in-out; }
        .page-link:hover{ z-index:2; color:#0a58ca; background-color:#e9ecef; border-color:#dee2e6; }
        .page-item.active .page-link{ z-index:3; color:#fff; background-color:#0d6efd; border-color:#0d6efd; }
        .page-item.disabled .page-link{ color:#6c757d; pointer-events:none; background-color:#fff; border-color:#dee2e6; opacity:.65; }
        .text-primary{ color:#0d6efd !important; }
        .text-muted{ color:#6c757d !important; }
        .text-white{ color:#fff !important; }
        .text-center{ text-align:center !important; }
        .fw-bold{ font-weight:700 !important; }
        .rounded-circle{ border-radius:50% !important; }
        strong{ font-weight:600; }
    </style>
</head>
<body>
<div class="container">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col">
            <h1 class="display-5 fw-bold">
                <i class="bi bi-people-fill text-primary"></i> Manajemen User
            </h1>
            <p class="text-muted">Kelola data pengguna sistem Anda</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stats-card card bg-primary text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">Total Users</h6>
                        <h2 class="mb-0"><?= $totalUsers ?></h2>
                    </div>
                    <i class="bi bi-people" style="font-size:2.5rem;opacity:.8;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card card bg-danger text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">Admin</h6>
                        <h2 class="mb-0"><?= $admin ?></h2>
                    </div>
                    <i class="bi bi-shield-fill-check" style="font-size:2.5rem;opacity:.8;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card card bg-info text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">Editor</h6>
                        <h2 class="mb-0"><?= $editor ?></h2>
                    </div>
                    <i class="bi bi-person-badge" style="font-size:2.5rem;opacity:.8;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card card bg-success text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">User</h6>
                        <h2 class="mb-0"><?= $user ?></h2>
                    </div>
                    <i class="bi bi-pencil-square" style="font-size:2.5rem;opacity:.8;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Actions -->
    <div class="card mb-3">
        <div class="card-body">
            <div class="row align-items-end g-3">
                <div class="col-md-3">
                    <label class="form-label fw-bold"><i class="bi bi-funnel"></i> Filter by Role</label>
                    <select id="roleFilter" class="form-select">
                        <option value="">Semua Role</option>
                        <option value="Super Admin">Super Admin</option>
                        <option value="Admin">Admin</option>
                        <option value="Editor">Editor</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold"><i class="bi bi-search"></i> Search</label>
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari nama, username, atau email...">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold"><i class="bi bi-list-ol"></i> Show</label>
                    <select id="limitSelect" class="form-select">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <a href="<?= base_url( 'manage_user/new') ?>" class="btn btn-gradient w-100">
                        <i class="bi bi-plus-circle"></i> Tambah User Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
<table id="usersTable" class="table table-hover align-middle">
    <thead>
        <tr>
            <th width="5%"><input type="checkbox" id="selectAll" class="form-check-input"></th>
            <th width="5%">ID</th>
            <th width="25%">Nama Lengkap</th>
            <th width="15%">Username</th>
            <th width="20%">Email</th>
            <th width="10%">Role</th>
            <th width="20%">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($users)): ?>
            <?php foreach($users as $user): ?>
                <tr>
                    <td><input type="checkbox" class="form-check-input" data-id="<?= $user['id_user'] ?>"></td>
                    <td><?= $user['id_user'] ?></td>
                    <td><?= esc($user['full_name']) ?></td>
                    <td><?= esc($user['username']) ?></td>
                    <td><?= esc($user['email']) ?></td>
                    <td><?= esc($user['role']) ?></td>
                    <td>
                        <div class="btn-group">
                            <a href="<?= base_url('manage_user/show/'.$user['id_user']) ?>" class="btn btn-info btn-sm">Detail</a>
                            <a href="<?= base_url('manage_user/'.$user['id_user'].'/edit') ?>" class="btn btn-warning btn-sm">Edit</a>
                            <form action="<?= base_url('manage_user/'.$user['id_user']) ?>" method="post" style="display:inline;">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" class="text-center py-5">Belum ada data user.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                <div class="mb-2 mb-md-0">
                    <button id="deleteSelectedBtn" class="btn btn-danger btn-sm" disabled>
                        <i class="bi bi-trash"></i> Hapus Terpilih
                    </button>
                </div>
                <nav>
                    <ul class="pagination mb-0" id="pagination">
                        <!-- Pagination JS -->
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script>
    // JS Ajax / Render Table Placeholder
    
</script>
</body>
</html>
