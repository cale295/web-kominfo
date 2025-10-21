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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background-color: #f8f9fa;
            padding: 20px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            line-height: 1.5;
            color: #212529;
        }
        
        h1, h2, h3, h4, h5, h6 {
            margin-top: 0;
            margin-bottom: 0.5rem;
            font-weight: 500;
            line-height: 1.2;
        }
        
        .display-5 {
            font-size: 2.5rem;
            font-weight: 300;
        }
        
        .mb-0 { margin-bottom: 0 !important; }
        .mb-1 { margin-bottom: 0.25rem !important; }
        .mb-2 { margin-bottom: 0.5rem !important; }
        .mb-3 { margin-bottom: 1rem !important; }
        .mb-4 { margin-bottom: 1.5rem !important; }
        .mt-2 { margin-top: 0.5rem !important; }
        .mt-3 { margin-top: 1rem !important; }
        .me-2 { margin-right: 0.5rem !important; }
        .py-4 { padding-top: 1.5rem !important; padding-bottom: 1.5rem !important; }
        .py-5 { padding-top: 3rem !important; padding-bottom: 3rem !important; }
        
        .d-flex { display: flex !important; }
        .d-none { display: none !important; }
        .flex-wrap { flex-wrap: wrap !important; }
        .align-items-center { align-items: center !important; }
        .align-items-end { align-items: flex-end !important; }
        .justify-content-between { justify-content: space-between !important; }
        .justify-content-center { justify-content: center !important; }
        .w-100 { width: 100% !important; }
        .g-3 > * { padding: 0.75rem; }
        
        .container {
            max-width: 1320px;
            margin: 0 auto;
            padding: 0 15px;
            width: 100%;
        }
        
        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }
        
        .col, .col-md-2, .col-md-3, .col-md-4 {
            position: relative;
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
        }
        
        @media (min-width: 768px) {
            .col-md-2 { flex: 0 0 auto; width: 16.666667%; }
            .col-md-3 { flex: 0 0 auto; width: 25%; }
            .col-md-4 { flex: 0 0 auto; width: 33.333333%; }
        }
        
        /* Card Styles */
        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .card-body {
            flex: 1 1 auto;
            padding: 1.25rem;
        }
        
        /* Button Styles */
        .btn {
            display: inline-block;
            font-weight: 400;
            line-height: 1.5;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            cursor: pointer;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            border-radius: 0.375rem;
            transition: all 0.15s ease-in-out;
        }
        
        .btn:hover {
            opacity: 0.9;
        }
        .btn-gradient {
            background: linear-gradient(90deg, #0d6efd, #6610f2);
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-gradient:hover {
            background: linear-gradient(90deg, #0b5ed7, #520dc2);
            color: white;
        }
        
        .stats-card {
            transition: all 0.3s ease-in-out;
            border-radius: 10px;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        
        .card {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border: none;
            border-radius: 10px;
            background: white;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        /* Table Styles */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            vertical-align: top;
            border-color: #dee2e6;
            border-collapse: collapse;
        }
        
        .table > :not(caption) > * > * {
            padding: 0.75rem;
            background-color: var(--bs-table-bg);
            border-bottom-width: 1px;
            box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
        }
        
        .table > tbody {
            vertical-align: inherit;
        }
        
        .table > thead {
            vertical-align: bottom;
            background-color: #f8f9fa;
        }
        
        .table th,
        .table td {
            padding: 0.75rem;
            border-bottom: 1px solid #dee2e6;
        }
        
        .table-hover > tbody > tr:hover {
            background-color: #f8f9fa;
        }
        
        .align-middle {
            vertical-align: middle !important;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 0.25rem;
        }
        
        .btn-info {
            color: #000;
            background-color: #0dcaf0;
            border-color: #0dcaf0;
        }
        
        .btn-warning {
            color: #000;
            background-color: #ffc107;
            border-color: #ffc107;
        }
        
        .btn-danger {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }
        
        .btn-group {
            display: inline-flex;
            gap: 5px;
        }
        
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            color: white;
            font-size: 0.875rem;
        }
        
        .bg-danger { background-color: #dc3545; }
        .bg-primary { background-color: #0d6efd; }
        .bg-success { background-color: #198754; }
        .bg-info { background-color: #0dcaf0; }
        
        /* Form Styles */
        .form-control, .form-select {
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            appearance: none;
            border-radius: 0.375rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        
        .form-control:focus, .form-select:focus {
            color: #212529;
            background-color: #fff;
            border-color: #86b7fe;
            outline: 0;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
        }
        
        .form-check-input {
            width: 1em;
            height: 1em;
            margin-top: 0.25em;
            vertical-align: top;
            background-color: #fff;
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
            border: 1px solid rgba(0, 0, 0, 0.25);
            appearance: none;
            cursor: pointer;
        }
        
        .form-check-input[type="checkbox"] {
            border-radius: 0.25em;
        }
        
        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        
        .form-check-input:checked[type="checkbox"] {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M6 10l3 3l6-6'/%3e%3c/svg%3e");
        }
        
        .spinner-border {
            width: 3rem;
            height: 3rem;
            border: 0.25em solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            animation: spinner-border 0.75s linear infinite;
        }
        
        @keyframes spinner-border {
            to { transform: rotate(360deg); }
        }
        
        /* Pagination Styles */
        .pagination {
            display: flex;
            padding-left: 0;
            list-style: none;
            gap: 5px;
        }
        
        .page-item {
            display: inline-block;
        }
        
        .page-link {
            position: relative;
            display: block;
            padding: 0.375rem 0.75rem;
            color: #0d6efd;
            text-decoration: none;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        
        .page-link:hover {
            z-index: 2;
            color: #0a58ca;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }
        
        .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        
        .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
            border-color: #dee2e6;
            opacity: 0.65;
        }
        
        /* Text Utilities */
        .text-primary {
            color: #0d6efd !important;
        }
        
        .text-muted {
            color: #6c757d !important;
        }
        
        .text-white {
            color: #fff !important;
        }
        
        .text-center {
            text-align: center !important;
        }
        
        .fw-bold {
            font-weight: 700 !important;
        }
        
        /* Spinner */
        .spinner-border {
            display: inline-block;
            width: 2rem;
            height: 2rem;
            vertical-align: -0.125em;
            border: 0.25em solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            animation: spinner-border 0.75s linear infinite;
        }
        
        @keyframes spinner-border {
            to {
                transform: rotate(360deg);
            }
        }
        
        .visually-hidden {
            position: absolute !important;
            width: 1px !important;
            height: 1px !important;
            padding: 0 !important;
            margin: -1px !important;
            overflow: hidden !important;
            clip: rect(0, 0, 0, 0) !important;
            white-space: nowrap !important;
            border: 0 !important;
        }
        
        /* Icon Placeholder (jika Bootstrap Icons gagal load) */
        .bi::before {
            display: inline-block;
            font-family: bootstrap-icons !important;
            font-style: normal;
            font-weight: normal !important;
            font-variant: normal;
            text-transform: none;
            line-height: 1;
            vertical-align: -0.125em;
        }
        
        /* Strong tag */
        strong {
            font-weight: 600;
        }
        
        /* Rounded Circle for Avatar */
        .rounded-circle {
            border-radius: 50% !important;
        }
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
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Total Users</h6>
                            <h2 class="mb-0" id="totalUsers">0</h2>
                        </div>
                        <i class="bi bi-people" style="font-size: 2.5rem; opacity: 0.8;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Super Admin</h6>
                            <h2 class="mb-0" id="superAdminCount">0</h2>
                        </div>
                        <i class="bi bi-shield-fill-check" style="font-size: 2.5rem; opacity: 0.8;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Admin</h6>
                            <h2 class="mb-0" id="adminCount">0</h2>
                        </div>
                        <i class="bi bi-person-badge" style="font-size: 2.5rem; opacity: 0.8;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Editor</h6>
                            <h2 class="mb-0" id="editorCount">0</h2>
                        </div>
                        <i class="bi bi-pencil-square" style="font-size: 2.5rem; opacity: 0.8;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Actions -->
    <div class="card mb-3">
        <div class="card-body">
            <div class="row align-items-end g-3">
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
                <div class="col-md-3">
                    <a href="create.php" class="btn btn-gradient w-100">
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
                            <th width="5%">
                                <input type="checkbox" id="selectAll" class="form-check-input">
                            </th>
                            <th width="5%">ID</th>
                            <th width="25%">Nama Lengkap</th>
                            <th width="15%">Username</th>
                            <th width="20%">Email</th>
                            <th width="10%">Role</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        <tr>
                            <td colspan="7" class="text-center py-5">
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
            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                <div class="mb-2 mb-md-0">
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

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!-- Bootstrap Bundle JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.5/sweetalert2.all.min.js"></script>

<!-- Config & Scripts -->
<script>
// Ganti dengan URL API Anda
const API_BASE_URL = 'http://localhost/api';

// Demo data untuk testing tanpa API
const DEMO_MODE = true; // Set false jika API sudah siap

function showLoading(show) {
    if (show) {
        Swal.fire({
            title: 'Mohon tunggu...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    } else {
        Swal.close();
    }
}

function showAlert(icon, title, text) {
    Swal.fire({
        icon: icon,
        title: title,
        text: text
    });
}

let currentPage = 1;
let limit = 10;
let roleFilter = '';
let searchQuery = '';
let selectedUsers = [];

$(document).ready(function() {
    // Cek apakah CSS sudah dimuat
    checkCSSLoaded();
    
    loadStats();
    loadUsers();
    
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
        $('.user-checkbox').prop('checked', $(this).is(':checked'));
        updateSelectedUsers();
    });
});

function checkCSSLoaded() {
    // Cek apakah Bootstrap dimuat
    const testEl = $('<div class="d-none"></div>').appendTo('body');
    const isHidden = testEl.css('display') === 'none';
    testEl.remove();
    
    if (!isHidden) {
        console.warn('Bootstrap CSS mungkin tidak dimuat dengan baik');
    }
}

function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

function loadStats() {
    if (DEMO_MODE) {
        // Demo data
        $('#totalUsers').text('24');
        $('#superAdminCount').text('3');
        $('#adminCount').text('8');
        $('#editorCount').text('13');
        return;
    }
    
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
        error: function() {
            console.error('Gagal memuat statistik');
        }
    });
}

function loadUsers() {
    if (DEMO_MODE) {
        // Demo data
        setTimeout(() => {
            const demoUsers = [
                {id_user: 1, full_name: 'John Doe', username: 'johndoe', email: 'john@example.com', role: 'Super Admin'},
                {id_user: 2, full_name: 'Jane Smith', username: 'janesmith', email: 'jane@example.com', role: 'Admin'},
                {id_user: 3, full_name: 'Bob Wilson', username: 'bobwilson', email: 'bob@example.com', role: 'Editor'}
            ];
            renderUsers(demoUsers);
            renderPagination({current_page: 1, per_page: 10, total: 3});
        }, 500);
        return;
    }
    
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
            showLoading(false);
            if (response.status === 'success') {
                renderUsers(response.data);
                renderPagination(response.pagination);
            }
        },
        error: function() {
            showLoading(false);
            showAlert('error', 'Error', 'Gagal memuat data users');
        }
    });
}

function renderUsers(users) {
    const tbody = $('#usersTableBody');
    tbody.empty();
    
    if (users.length === 0) {
        tbody.append(`
            <tr>
                <td colspan="7" class="text-center py-4">
                    <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.3;"></i>
                    <p class="mt-2 text-muted">Tidak ada data</p>
                </td>
            </tr>
        `);
        return;
    }
    
    users.forEach(user => {
        const roleBadge = getRoleBadge(user.role);
        
        tbody.append(`
            <tr>
                <td>
                    <input type="checkbox" class="form-check-input user-checkbox" 
                           value="${user.id_user}" onchange="updateSelectedUsers()">
                </td>
                <td>${user.id_user}</td>
                <td>
                    <div style="display: flex; align-items: center;">
                        <div class="bg-primary text-white" 
                             style="width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            ${user.full_name.charAt(0).toUpperCase()}
                        </div>
                        <strong>${user.full_name}</strong>
                    </div>
                </td>
                <td>${user.username}</td>
                <td>${user.email}</td>
                <td>${roleBadge}</td>
                <td>
                    <div style="display: flex; gap: 5px;">
                        <a href="show.php?id=${user.id_user}" class="btn btn-sm btn-info" title="Detail">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="edit.php?id=${user.id_user}" class="btn btn-sm btn-warning" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button class="btn btn-sm btn-danger" onclick="deleteUser(${user.id_user}, '${user.username}')" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `);
    });
}

function renderPagination(pagination) {
    const paginationEl = $('#pagination');
    paginationEl.empty();
    
    const totalPages = Math.ceil(pagination.total / pagination.per_page);
    
    const from = ((pagination.current_page - 1) * pagination.per_page) + 1;
    const to = Math.min(pagination.current_page * pagination.per_page, pagination.total);
    $('#showingFrom').text(from);
    $('#showingTo').text(to);
    $('#totalRecords').text(pagination.total);
    
    paginationEl.append(`
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="return changePage(${currentPage - 1})">Previous</a>
        </li>
    `);
    
    for (let i = 1; i <= totalPages; i++) {
        if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
            paginationEl.append(`
                <li class="page-item ${i === currentPage ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="return changePage(${i})">${i}</a>
                </li>
            `);
        } else if (i === currentPage - 3 || i === currentPage + 3) {
            paginationEl.append('<li class="page-item disabled"><a class="page-link">...</a></li>');
        }
    }
    
    paginationEl.append(`
        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="return changePage(${currentPage + 1})">Next</a>
        </li>
    `);
}

function changePage(page) {
    currentPage = page;
    loadUsers();
    return false;
}

function getRoleBadge(role) {
    const badges = {
        'Super Admin': 'bg-danger',
        'Admin': 'bg-primary',
        'Editor': 'bg-success'
    };
    return `<span class="badge ${badges[role] || 'bg-secondary'}">${role}</span>`;
}

function deleteUser(id, username) {
    Swal.fire({
        title: 'Konfirmasi Hapus',
        html: `Yakin ingin menghapus user <strong>${username}</strong>?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            if (DEMO_MODE) {
                Swal.fire('Demo Mode', 'Fitur hapus tidak aktif di demo mode', 'info');
                return;
            }
            
            showLoading(true);
            $.ajax({
                url: `${API_BASE_URL}/users/${id}`,
                method: 'DELETE',
                success: function(response) {
                    showLoading(false);
                    if (response.status === 'success') {
                        Swal.fire('Berhasil', response.message, 'success');
                        loadUsers();
                        loadStats();
                    }
                },
                error: function(xhr) {
                    showLoading(false);
                    const response = xhr.responseJSON;
                    Swal.fire('Error', response?.message || 'Gagal menghapus user', 'error');
                }
            });
        }
    });
}

function updateSelectedUsers() {
    selectedUsers = [];
    $('.user-checkbox:checked').each(function() {
        selectedUsers.push($(this).val());
    });
    
    $('#selectedCount').text(selectedUsers.length);
    
    if (selectedUsers.length > 0) {
        $('#bulkActions').show();
    } else {
        $('#bulkActions').hide();
    }
}

function bulkDelete() {
    if (selectedUsers.length === 0) {
        Swal.fire('Error', 'Pilih user yang ingin dihapus', 'error');
        return;
    }
    
    Swal.fire({
        title: 'Konfirmasi Bulk Delete',
        html: `Yakin ingin menghapus <strong>${selectedUsers.length} user</strong>?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus Semua!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            if (DEMO_MODE) {
                Swal.fire('Demo Mode', 'Fitur bulk delete tidak aktif di demo mode', 'info');
                return;
            }
            
            showLoading(true);
            $.ajax({
                url: `${API_BASE_URL}/users/bulk-delete`,
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ ids: selectedUsers }),
                success: function(response) {
                    showLoading(false);
                    Swal.fire('Berhasil', response.message, 'success');
                    selectedUsers = [];
                    $('#selectAll').prop('checked', false);
                    $('#bulkActions').hide();
                    loadUsers();
                    loadStats();
                },
                error: function(xhr) {
                    showLoading(false);
                    const response = xhr.responseJSON;
                    Swal.fire('Error', response?.message || 'Gagal menghapus user', 'error');
                }
            });
        }
    });
}
</script>

</body>
</html>