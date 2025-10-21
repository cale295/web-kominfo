<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Sidebar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            overflow-x: hidden;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background: linear-gradient(180deg, #1e3c72 0%, #2a5298 100%);
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }
        .sidebar-header {
            padding: 20px;
            color: #fff;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-scrollable-content {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            max-height: calc(100vh - 140px);
        }
        .sidebar-scrollable-content::-webkit-scrollbar {
            width: 6px;
        }
        .sidebar-scrollable-content::-webkit-scrollbar-track {
            background: rgba(0,0,0,0.1);
        }
        .sidebar-scrollable-content::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 3px;
        }
        .sidebar-scrollable-content::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.5);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 4px 8px;
            transition: all 0.3s ease;
            white-space: nowrap;
        }
        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
            transform: translateX(5px);
        }
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: #fff;
            font-weight: 600;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
            font-size: 1.1rem;
        }
        .sidebar-header {
            padding: 20px;
            color: #fff;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .submenu {
            padding-left: 20px;
        }
        .submenu .nav-link {
            font-size: 0.9rem;
            padding: 8px 20px;
        }
        .collapse-icon {
            float: right;
            transition: transform 0.3s;
        }
        .collapsed .collapse-icon {
            transform: rotate(-90deg);
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .logout-btn {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 250px;
            background: linear-gradient(180deg, transparent 0%, rgba(30, 60, 114, 0.95) 30%, rgba(30, 60, 114, 1) 100%);
            padding: 15px 10px 20px;
            z-index: 10;
        }
        .role-selector {
            background: rgba(255,255,255,0.1);
            padding: 10px;
            border-radius: 8px;
            margin: 10px;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 250px;
                margin-left: -250px;
            }
            .sidebar.show {
                margin-left: 0;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 px-0 sidebar">
            <div class="sidebar-header">
                <h5 class="mb-0"><i class="bi bi-building"></i> Admin Panel</h5>
                <small class="text-white-50" id="userName">Administrator</small>
            </div>

            <div class="sidebar-scrollable-content">
                <!-- Role Selector (untuk demo) -->
                <div class="role-selector">
                    <label class="text-white-50 small">Test Role:</label>
                    <select class="form-select form-select-sm" id="roleSelector">
                        <option value="super_admin">Super Admin</option>
                        <option value="admin">Admin</option>
                        <option value="editor">Editor</option>
                    </select>
                </div>
                
                <ul class="nav flex-column py-3" id="menuContainer">
                    <!-- Menu akan di-generate oleh JavaScript -->
                </ul>
            </div>
            
            <div class="logout-btn">
                <a href="#" class="nav-link text-danger">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 main-content">
            <h2>Dashboard</h2>
            <p class="text-muted">Selamat datang, <strong id="displayName">Administrator</strong> (Role: <span id="displayRole">Super Admin</span>)</p>
            
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-newspaper"></i> Total Berita</h5>
                            <h2>245</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-calendar-event"></i> Agenda</h5>
                            <h2>18</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-images"></i> Foto</h5>
                            <h2>532</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-file-earmark"></i> Dokumen</h5>
                            <h2>89</h2>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="alert alert-info mt-4">
                <i class="bi bi-info-circle"></i> <strong>Info:</strong> 
                Gunakan dropdown "Test Role" di sidebar untuk melihat perbedaan menu berdasarkan role (Super Admin/Admin/Editor).
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5>Struktur Menu Berdasarkan Role</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Menu</th>
                                    <th>Super Admin</th>
                                    <th>Admin</th>
                                    <th>Editor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Dashboard</td>
                                    <td><i class="bi bi-check-circle-fill text-success"></i></td>
                                    <td><i class="bi bi-check-circle-fill text-success"></i></td>
                                    <td><i class="bi bi-check-circle-fill text-success"></i></td>
                                </tr>
                                <tr>
                                    <td>Manajemen Berita</td>
                                    <td><i class="bi bi-check-circle-fill text-success"></i></td>
                                    <td><i class="bi bi-check-circle-fill text-success"></i></td>
                                    <td><i class="bi bi-check-circle-fill text-success"></i></td>
                                </tr>
                                <tr>
                                    <td>Kategori/Tema/Tag Berita</td>
                                    <td><i class="bi bi-check-circle-fill text-success"></i></td>
                                    <td><i class="bi bi-check-circle-fill text-success"></i></td>
                                    <td><i class="bi bi-x-circle-fill text-danger"></i></td>
                                </tr>
                                <tr>
                                    <td>Agenda & Galeri</td>
                                    <td><i class="bi bi-check-circle-fill text-success"></i></td>
                                    <td><i class="bi bi-check-circle-fill text-success"></i></td>
                                    <td><i class="bi bi-check-circle-fill text-success"></i></td>
                                </tr>
                                <tr>
                                    <td>Layanan & Menu</td>
                                    <td><i class="bi bi-check-circle-fill text-success"></i></td>
                                    <td><i class="bi bi-check-circle-fill text-success"></i></td>
                                    <td><i class="bi bi-x-circle-fill text-danger"></i></td>
                                </tr>
                                <tr>
                                    <td>Pengguna & Akses</td>
                                    <td><i class="bi bi-check-circle-fill text-success"></i></td>
                                    <td><i class="bi bi-x-circle-fill text-danger"></i></td>
                                    <td><i class="bi bi-x-circle-fill text-danger"></i></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Konfigurasi menu dengan permission
const menuItems = [
    {
        title: 'Dashboard',
        icon: 'bi-speedometer2',
        url: '#dashboard',
        roles: ['super_admin', 'admin', 'editor'],
        active: true
    },
    {
        title: 'Manajemen Berita',
        icon: 'bi-newspaper',
        roles: ['super_admin', 'admin', 'editor'],
        submenu: [
            { title: 'Daftar Berita', url: '#berita-list', roles: ['super_admin', 'admin', 'editor'] },
            { title: 'Tambah Berita', url: '#berita-add', roles: ['super_admin', 'admin', 'editor'] },
            { title: 'Kategori Berita', url: '#berita-kategori', roles: ['super_admin', 'admin'] },
            { title: 'Tema Berita', url: '#berita-tema', roles: ['super_admin', 'admin'] },
            { title: 'Tag Berita', url: '#berita-tag', roles: ['super_admin', 'admin'] },
            { title: 'Berita Utama', url: '#berita-featured', roles: ['super_admin', 'admin', 'editor'] }
        ]
    },
    {
        title: 'Agenda Kegiatan',
        icon: 'bi-calendar-event',
        roles: ['super_admin', 'admin', 'editor'],
        submenu: [
            { title: 'Daftar Agenda', url: '#agenda-list', roles: ['super_admin', 'admin', 'editor'] },
            { title: 'Tambah Agenda', url: '#agenda-add', roles: ['super_admin', 'admin', 'editor'] },
            { title: 'Kalender', url: '#agenda-calendar', roles: ['super_admin', 'admin', 'editor'] }
        ]
    },
    {
        title: 'Galeri',
        icon: 'bi-images',
        roles: ['super_admin', 'admin', 'editor'],
        submenu: [
            { title: 'Album Foto', url: '#galeri-album', roles: ['super_admin', 'admin', 'editor'] },
            { title: 'Foto Galeri', url: '#galeri-foto', roles: ['super_admin', 'admin', 'editor'] },
            { title: 'Upload Foto', url: '#galeri-upload', roles: ['super_admin', 'admin', 'editor'] }
        ]
    },
    {
        title: 'Dokumen',
        icon: 'bi-file-earmark-text',
        roles: ['super_admin', 'admin', 'editor'],
        submenu: [
            { title: 'Daftar Dokumen', url: '#dokumen-list', roles: ['super_admin', 'admin', 'editor'] },
            { title: 'Kategori Dokumen', url: '#dokumen-kategori', roles: ['super_admin', 'admin'] },
            { title: 'Upload Dokumen', url: '#dokumen-upload', roles: ['super_admin', 'admin', 'editor'] }
        ]
    },
    {
        title: 'Layanan',
        icon: 'bi-gear',
        url: '#layanan',
        roles: ['super_admin', 'admin']
    },
    {
        title: 'Pengaturan Menu',
        icon: 'bi-menu-button-wide',
        url: '#menu',
        roles: ['super_admin', 'admin']
    },
    {
        title: 'Pengguna & Akses',
        icon: 'bi-people',
        roles: ['super_admin'],
        submenu: [
            { title: 'Manajemen User', url: '#user-list', roles: ['super_admin'] },
            { title: 'Hak Akses', url: '#user-access', roles: ['super_admin'] }
        ]
    },
    {
        title: 'Pengaturan',
        icon: 'bi-sliders',
        url: '#settings',
        roles: ['super_admin', 'admin']
    }
];

let currentRole = 'super_admin';

// Fungsi untuk cek akses
function hasAccess(roles) {
    return roles.includes(currentRole);
}

// Fungsi render menu
function renderMenu() {
    const container = document.getElementById('menuContainer');
    container.innerHTML = '';
    
    menuItems.forEach((item, index) => {
        if (!hasAccess(item.roles)) return;
        
        const li = document.createElement('li');
        li.className = 'nav-item';
        
        if (item.submenu) {
            const collapseId = `collapse-${index}`;
            li.innerHTML = `
                <a class="nav-link collapsed" data-bs-toggle="collapse" href="#${collapseId}" role="button">
                    <i class="${item.icon}"></i>${item.title}
                    <i class="bi bi-chevron-down collapse-icon"></i>
                </a>
                <div class="collapse" id="${collapseId}">
                    <ul class="nav flex-column submenu" id="submenu-${index}"></ul>
                </div>
            `;
            
            const submenuContainer = li.querySelector(`#submenu-${index}`);
            item.submenu.forEach(sub => {
                if (!hasAccess(sub.roles)) return;
                
                const subLi = document.createElement('li');
                subLi.className = 'nav-item';
                subLi.innerHTML = `<a class="nav-link" href="${sub.url}">${sub.title}</a>`;
                submenuContainer.appendChild(subLi);
            });
        } else {
            const activeClass = item.active ? 'active' : '';
            li.innerHTML = `
                <a class="nav-link ${activeClass}" href="${item.url}">
                    <i class="${item.icon}"></i>${item.title}
                </a>
            `;
        }
        
        container.appendChild(li);
    });
}

// Event listener untuk role selector
document.getElementById('roleSelector').addEventListener('change', (e) => {
    currentRole = e.target.value;
    let displayText = currentRole.replace('_', ' ').split(' ').map(word => 
        word.charAt(0).toUpperCase() + word.slice(1)
    ).join(' ');
    document.getElementById('displayRole').textContent = displayText;
    renderMenu();
});

// Initial render
renderMenu();
</script>

</body>
</html>