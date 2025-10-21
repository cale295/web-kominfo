<?php
// ========================================
// FILE: index.php
// ========================================
?>

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
                        <i class="bi bi-people" style="font-size: 2.5rem; opacity: 0.8;"></i>
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
                        <i class="bi bi-shield-fill-check" style="font-size: 2.5rem; opacity: 0.8;"></i>
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
                        <i class="bi bi-person-badge" style="font-size: 2.5rem; opacity: 0.8;"></i>
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
                        <i class="bi bi-pencil-square" style="font-size: 2.5rem; opacity: 0.8;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Actions -->
    <div class="card mb-3">
        <div class="card-body">
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
                <table id="usersTable" class="table table-hover">
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
                                <div class="spinner-border text-primary" role="status"></div>
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

<script>
let currentPage = 1;
let limit = 10;
let roleFilter = '';
let searchQuery = '';
let selectedUsers = [];

$(document).ready(function() {
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

function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

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
        }
    });
}

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
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                             style="width: 35px; height: 35px;">
                            ${user.full_name.charAt(0).toUpperCase()}
                        </div>
                        <strong>${user.full_name}</strong>
                    </div>
                </td>
                <td>${user.username}</td>
                <td>${user.email}</td>
                <td>${roleBadge}</td>
                <td>
                    <a href="show.php?id=${user.id_user}" class="btn btn-sm btn-info" title="Detail">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="edit.php?id=${user.id_user}" class="btn btn-sm btn-warning" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <button class="btn btn-sm btn-danger" onclick="deleteUser(${user.id_user}, '${user.username}')" title="Hapus">
                        <i class="bi bi-trash"></i>
                    </button>
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
            <a class="page-link" href="#" onclick="changePage(${currentPage - 1})">Previous</a>
        </li>
    `);
    
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
    
    paginationEl.append(`
        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="changePage(${currentPage + 1})">Next</a>
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
    return `<span class="badge ${badges[role]}">${role}</span>`;
}

function deleteUser(id, username) {
    Swal.fire({
        title: 'Konfirmasi Hapus',
        html: `Yakin ingin menghapus user <strong>${username}</strong>?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
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
                    Swal.fire('Error', response.message || 'Gagal menghapus user', 'error');
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
        confirmButtonColor: '#ef4444',
        confirmButtonText: 'Ya, Hapus Semua!'
    }).then((result) => {
        if (result.isConfirmed) {
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
                }
            });
        }
    });
}
</script>


