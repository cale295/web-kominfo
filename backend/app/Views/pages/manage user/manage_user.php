<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --info-color: #3b82f6;
        }
        
        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        
        .main-header {
            background: var(--primary-gradient);
            color: white;
            padding: 2rem 0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }
        
        .stats-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            overflow: hidden;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        
        .stats-card .card-body {
            padding: 1.5rem;
        }
        
        .stats-icon {
            font-size: 2.5rem;
            opacity: 0.8;
        }
        
        .table-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .table thead {
            background: var(--primary-gradient);
            color: white;
        }
        
        .table tbody tr {
            transition: background-color 0.2s;
        }
        
        .table tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.05);
        }
        
        .btn-gradient {
            background: var(--primary-gradient);
            border: none;
            color: white;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        .badge {
            padding: 0.5em 1em;
            font-weight: 500;
        }
        
        .modal-header {
            background: var(--primary-gradient);
            color: white;
        }
        
        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }
        
        .filter-section {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
        }
        
        .action-buttons .btn {
            margin: 0 2px;
        }
        
        .loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }
        
        .loading-overlay.active {
            display: flex;
        }
        
        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .password-strength {
            height: 5px;
            border-radius: 3px;
            margin-top: 5px;
            transition: all 0.3s;
        }
        
        .strength-weak { background: #ef4444; width: 33%; }
        .strength-medium { background: #f59e0b; width: 66%; }
        .strength-strong { background: #10b981; width: 100%; }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
    </div>

    <!-- Header -->
    <div class="main-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="mb-0">
                        <i class="bi bi-people-fill"></i> User Management System
                    </h1>
                    <p class="mb-0 mt-2 opacity-75">Kelola data pengguna dengan mudah</p>
                </div>
                <div class="col-md-6 text-end">
                    <button class="btn btn-light" onclick="refreshData()">
                        <i class="bi bi-arrow-clockwise"></i> Refresh
                    </button>
                    <button class="btn btn-light" onclick="exportData()">
                        <i class="bi bi-download"></i> Export
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stats-card card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Total Users</h6>
                                <h2 class="mb-0" id="totalUsers">0</h2>
                            </div>
                            <i class="bi bi-people stats-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card card bg-danger text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Super Admin</h6>
                                <h2 class="mb-0" id="superAdminCount">0</h2>
                            </div>
                            <i class="bi bi-shield-fill-check stats-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Admin</h6>
                                <h2 class="mb-0" id="adminCount">0</h2>
                            </div>
                            <i class="bi bi-person-badge stats-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Editor</h6>
                                <h2 class="mb-0" id="editorCount">0</h2>
                            </div>
                            <i class="bi bi-pencil-square stats-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters & Actions -->
        <div class="filter-section">
            <div class="row align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-bold">
                        <i class="bi bi-funnel"></i> Filter by Role
                    </label>
                    <select id="roleFilter" class="form-select">
                        <option value="">Semua Role</option>
                        <option value="Super Admin">Super Admin</option>
                        <option value="Admin">Admin</option>
                        <option value="Editor">Editor</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">
                        <i class="bi bi-search"></i> Search
                    </label>
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari nama, username, atau email...">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">
                        <i class="bi bi-list-ol"></i> Show
                    </label>
                    <select id="limitSelect" class="form-select">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="col-md-3 text-end">
                    <button class="btn btn-gradient w-100" onclick="openAddModal()">
                        <i class="bi bi-plus-circle"></i> Tambah User Baru
                    </button>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="table-card card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="usersTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th width="5%">
                                    <input type="checkbox" id="selectAll" class="form-check-input">
                                </th>
                                <th width="5%">ID</th>
                                <th width="20%">Nama Lengkap</th>
                                <th width="15%">Username</th>
                                <th width="20%">Email</th>
                                <th width="10%">Role</th>
                                <th width="10%">Status</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="usersTableBody">
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="mt-2">Memuat data...</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <span class="text-muted">Showing <strong id="showingFrom">0</strong> to <strong id="showingTo">0</strong> of <strong id="totalRecords">0</strong> entries</span>
                    </div>
                    <nav>
                        <ul class="pagination mb-0" id="pagination"></ul>
                    </nav>
                </div>
                
                <!-- Bulk Actions -->
                <div class="mt-3" id="bulkActions" style="display: none;">
                    <button class="btn btn-danger btn-sm" onclick="bulkDelete()">
                        <i class="bi bi-trash"></i> Hapus yang dipilih (<span id="selectedCount">0</span>)
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add/Edit User -->
    <div class="modal fade" id="userModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalTitle">
                        <i class="bi bi-person-plus"></i> Tambah User Baru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="userForm">
                        <input type="hidden" id="userId">
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="fullName" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="username" required>
                                <small class="text-muted">Min. 3 karakter, hanya huruf dan angka</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Password <span class="text-danger" id="passwordRequired">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                                        <i class="bi bi-eye" id="passwordIcon"></i>
                                    </button>
                                    <button class="btn btn-outline-primary" type="button" onclick="generatePassword()">
                                        <i class="bi bi-arrow-repeat"></i>
                                    </button>
                                </div>
                                <div class="password-strength" id="passwordStrength"></div>
                                <small class="text-muted" id="passwordHelper">Min. 8 karakter</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Role <span class="text-danger">*</span></label>
                                <select class="form-select" id="role" required>
                                    <option value="">Pilih Role</option>
                                    <option value="Super Admin">Super Admin</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Editor">Editor</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i>
                            <strong>Info:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Super Admin: Akses penuh ke semua fitur</li>
                                <li>Admin: Akses terbatas, tidak bisa kelola Super Admin</li>
                                <li>Editor: Hanya bisa kelola konten</li>
                            </ul>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Batal
                    </button>
                    <button type="button" class="btn btn-gradient" onclick="saveUser()">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Change Password -->
    <div class="modal fade" id="passwordModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-key"></i> Ubah Password
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="changePasswordUserId">
                    <div class="mb-3">
                        <label class="form-label">Password Lama</label>
                        <input type="password" class="form-control" id="oldPassword">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="newPassword">
                            <button class="btn btn-outline-primary" type="button" onclick="generatePasswordForChange()">
                                <i class="bi bi-arrow-repeat"></i>
                            </button>
                        </div>
                        <small class="text-muted">Min. 8 karakter</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-gradient" onclick="submitChangePassword()">
                        <i class="bi bi-check-circle"></i> Ubah Password
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Configuration
        const API_BASE_URL = 'http://localhost:8080/api';
        let currentPage = 1;
        let limit = 10;
        let roleFilter = '';
        let searchQuery = '';
        let selectedUsers = [];

        // Initialize
        $(document).ready(function() {
            loadStats();
            loadUsers();
            
            // Event listeners
            $('#roleFilter').change(function() {
                roleFilter = $(this).val();
                currentPage = 1;
                loadUsers();
            });
            
            $('#searchInput').on('keyup', debounce(function() {
                searchQuery = $(this).val();
                currentPage = 1;
                loadUsers();
            }, 500));
            
            $('#limitSelect').change(function() {
                limit = $(this).val();
                currentPage = 1;
                loadUsers();
            });
            
            $('#selectAll').change(function() {
                const isChecked = $(this).is(':checked');
                $('.user-checkbox').prop('checked', isChecked);
                updateSelectedUsers();
            });
            
            // Password strength checker
            $('#password').on('keyup', function() {
                checkPasswordStrength($(this).val());
            });
        });

        // Debounce function
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Load Statistics
        function loadStats() {
            $.ajax({
                url: `${API_BASE_URL}/users/stats`,
                method: 'GET',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#totalUsers').text(response.data.total_users);
                        $('#superAdminCount').text(response.data.by_role['Super Admin'] || 0);
                        $('#adminCount').text(response.data.by_role['Admin'] || 0);
                        $('#editorCount').text(response.data.by_role['Editor'] || 0);
                    }
                },
                error: function(xhr) {
                    console.error('Failed to load stats:', xhr);
                }
            });
        }

        // Load Users
        function loadUsers() {
            showLoading(true);
            
            $.ajax({
                url: `${API_BASE_URL}/users`,
                method: 'GET',
                data: {
                    page: currentPage,
                    limit: limit,
                    role: roleFilter,
                    search: searchQuery
                },
                success: function(response) {
                    if (response.status === 'success') {
                        renderUsers(response.data);
                        renderPagination(response.pagination);
                    }
                    showLoading(false);
                },
                error: function(xhr) {
                    showLoading(false);
                    Swal.fire('Error', 'Gagal memuat data users', 'error');
                }
            });
        }

        // Render Users Table
        function renderUsers(users) {
            const tbody = $('#usersTableBody');
            tbody.empty();
            
            if (users.length === 0) {
                tbody.append(`
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.3;"></i>
                            <p class="mt-2 text-muted">Tidak ada data</p>
                        </td>
                    </tr>
                `);
                return;
            }
            
            users.forEach(user => {
                const roleBadge = getRoleBadge(user.role);
                const statusBadge = '<span class="badge bg-success">Active</span>';
                
                tbody.append(`
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input user-checkbox" 
                                   value="${user.id_user}" onchange="updateSelectedUsers()">
                        </td>
                        <td>${user.id_user}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle me-2 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 35px; height: 35px;">
                                    ${user.full_name.charAt(0).toUpperCase()}
                                </div>
                                <strong>${user.full_name}</strong>
                            </div>
                        </td>
                        <td>${user.username}</td>
                        <td>${user.email}</td>
                        <td>${roleBadge}</td>
                        <td>${statusBadge}</td>
                        <td class="action-buttons">
                            <button class="btn btn-sm btn-info" onclick="viewUser(${user.id_user})" title="Lihat">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-warning" onclick="editUser(${user.id_user})" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-primary" onclick="changePassword(${user.id_user})" title="Ubah Password">
                                <i class="bi bi-key"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteUser(${user.id_user}, '${user.username}')" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                `);
            });
        }

        // Render Pagination
        function renderPagination(pagination) {
            const paginationEl = $('#pagination');
            paginationEl.empty();
            
            const totalPages = Math.ceil(pagination.total / pagination.per_page);
            
            // Update showing text
            const from = ((pagination.current_page - 1) * pagination.per_page) + 1;
            const to = Math.min(pagination.current_page * pagination.per_page, pagination.total);
            $('#showingFrom').text(from);
            $('#showingTo').text(to);
            $('#totalRecords').text(pagination.total);
            
            // Previous button
            paginationEl.append(`
                <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="changePage(${currentPage - 1})">Previous</a>
                </li>
            `);
            
            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
                    paginationEl.append(`
                        <li class="page-item ${i === currentPage ? 'active' : ''}">
                            <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
                        </li>
                    `);
                } else if (i === currentPage - 3 || i === currentPage + 3) {
                    paginationEl.append('<li class="page-item disabled"><a class="page-link">...</a></li>');
                }
            }
            
            // Next button
            paginationEl.append(`
                <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="changePage(${currentPage + 1})">Next</a>
                </li>
            `);
        }

        // Change Page
        function changePage(page) {
            currentPage = page;
            loadUsers();
            return false;
        }

        // Get Role Badge
        function getRoleBadge(role) {
            const badges = {
                'Super Admin': 'bg-danger',
                'Admin': 'bg-primary',
                'Editor': 'bg-success'
            };
            return `<span class="badge ${badges[role]}">${role}</span>`;
        }

        // Open Add Modal
        function openAddModal() {
            $('#userModalTitle').html('<i class="bi bi-person-plus"></i> Tambah User Baru');
            $('#userForm')[0].reset();
            $('#userId').val('');
            $('#passwordRequired').show();
            $('#password').prop('required', true);
            $('#passwordHelper').text('Min. 8 karakter');
            $('#passwordStrength').html('').removeClass();
            $('#userModal').modal('show');
        }

        // View User
        function viewUser(id) {
            showLoading(true);
            $.ajax({
                url: `${API_BASE_URL}/users/${id}`,
                method: 'GET',
                success: function(response) {
                    showLoading(false);
                    if (response.status === 'success') {
                        const user = response.data;
                        Swal.fire({
                            title: user.full_name,
                            html: `
                                <div class="text-start">
                                    <p><strong>ID:</strong> ${user.id_user}</p>
                                    <p><strong>Username:</strong> ${user.username}</p>
                                    <p><strong>Email:</strong> ${user.email}</p>
                                    <p><strong>Role:</strong> ${getRoleBadge(user.role)}</p>
                                </div>
                            `,
                            icon: 'info',
                            confirmButtonText: 'Tutup'
                        });
                    }
                },
                error: function() {
                    showLoading(false);
                    Swal.fire('Error', 'Gagal memuat data user', 'error');
                }
            });
        }

        // Edit User
        function editUser(id) {
            showLoading(true);
            $.ajax({
                url: `${API_BASE_URL}/users/${id}`,
                method: 'GET',
                success: function(response) {
                    showLoading(false);
                    if (response.status === 'success') {
                        const user = response.data;
                        $('#userModalTitle').html('<i class="bi bi-pencil"></i> Edit User');
                        $('#userId').val(user.id_user);
                        $('#fullName').val(user.full_name);
                        $('#username').val(user.username);
                        $('#email').val(user.email);
                        $('#role').val(user.role);
                        $('#password').val('').prop('required', false);
                        $('#passwordRequired').hide();
                        $('#passwordHelper').text('Kosongkan jika tidak ingin mengubah password');
                        $('#passwordStrength').html('').removeClass();
                        $('#userModal').modal('show');
                    }
                },
                error: function() {
                    showLoading(false);
                    Swal.fire('Error', 'Gagal memuat data user', 'error');
                }
            });
        }   

        // Delete User
        function deleteUser(userId, username) {
            Swal.fire({
                title: 'Yakin?',
                text: `Hapus user "${username}"? Tindakan ini tidak dapat dibatalkan.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoading(true);
                    $.ajax({
                        url: `${API_BASE_URL}/users/${userId}`,
                        method: 'DELETE',
                        success: function(response) {
                            showLoading(false);
                            if (response.status === 'success') {
                                Swal.fire('Dihapus!', response.message, 'success');
                                loadUsers();
                            } else {
                                Swal.fire('Error', response.message, 'error');
                            }
                        },
                        error: function() {
                            showLoading(false);
                            Swal.fire('Error', 'Gagal menghapus user', 'error');
                        }
                    });
                }
            });
        }
    // ... (rest of the JavaScript code)
    </script>
