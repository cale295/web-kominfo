<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #1e3c72 0%, #2a5298 100%);
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 4px 8px;
            transition: all 0.3s ease;
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
    </style>
</head>
<body>

<?php
session_start();

// Simulasi data user login
$_SESSION['user'] = [
    'id_user' => 1,
    'full_name' => 'Administrator',
    'username' => 'admin',
    'role' => 'admin', // admin, editor, user
    'email' => 'admin@example.com'
];

$current_user = $_SESSION['user'];
$user_role = $current_user['role'];

// Fungsi untuk cek akses berdasarkan role
function hasAccess($allowed_roles) {
    global $user_role;
    return in_array($user_role, $allowed_roles);
}

// Konfigurasi menu dengan permission
$menu_items = [
    [
        'title' => 'Dashboard',
        'icon' => 'bi-speedometer2',
        'url' => 'dashboard.php',
        'roles' => ['admin', 'editor', 'user'],
        'active' => true
    ],
    [
        'title' => 'Manajemen Berita',
        'icon' => 'bi-newspaper',
        'roles' => ['admin', 'editor'],
        'submenu' => [
            ['title' => 'Daftar Berita', 'url' => 'berita/list.php', 'roles' => ['admin', 'editor']],
            ['title' => 'Tambah Berita', 'url' => 'berita/add.php', 'roles' => ['admin', 'editor']],
            ['title' => 'Kategori Berita', 'url' => 'berita/kategori.php', 'roles' => ['admin']],
            ['title' => 'Tema Berita', 'url' => 'berita/tema.php', 'roles' => ['admin']],
            ['title' => 'Tag Berita', 'url' => 'berita/tag.php', 'roles' => ['admin']],
            ['title' => 'Berita Utama', 'url' => 'berita/featured.php', 'roles' => ['admin', 'editor']],
        ]
    ],
    [
        'title' => 'Agenda Kegiatan',
        'icon' => 'bi-calendar-event',
        'roles' => ['admin', 'editor'],
        'submenu' => [
            ['title' => 'Daftar Agenda', 'url' => 'agenda/list.php', 'roles' => ['admin', 'editor']],
            ['title' => 'Tambah Agenda', 'url' => 'agenda/add.php', 'roles' => ['admin', 'editor']],
            ['title' => 'Kalender', 'url' => 'agenda/calendar.php', 'roles' => ['admin', 'editor']],
        ]
    ],
    [
        'title' => 'Galeri',
        'icon' => 'bi-images',
        'roles' => ['admin', 'editor'],
        'submenu' => [
            ['title' => 'Album Foto', 'url' => 'galeri/album.php', 'roles' => ['admin', 'editor']],
            ['title' => 'Foto Galeri', 'url' => 'galeri/foto.php', 'roles' => ['admin', 'editor']],
            ['title' => 'Upload Foto', 'url' => 'galeri/upload.php', 'roles' => ['admin', 'editor']],
        ]
    ],
    [
        'title' => 'Dokumen',
        'icon' => 'bi-file-earmark-text',
        'roles' => ['admin', 'editor'],
        'submenu' => [
            ['title' => 'Daftar Dokumen', 'url' => 'dokumen/list.php', 'roles' => ['admin', 'editor']],
            ['title' => 'Kategori Dokumen', 'url' => 'dokumen/kategori.php', 'roles' => ['admin']],
            ['title' => 'Upload Dokumen', 'url' => 'dokumen/upload.php', 'roles' => ['admin', 'editor']],
        ]
    ],
    [
        'title' => 'Layanan',
        'icon' => 'bi-gear',
        'url' => 'layanan/list.php',
        'roles' => ['admin']
    ],
    [
        'title' => 'Pengaturan Menu',
        'icon' => 'bi-menu-button-wide',
        'url' => 'menu/list.php',
        'roles' => ['admin']
    ],
    [
        'title' => 'Pengguna & Akses',
        'icon' => 'bi-people',
        'roles' => ['admin'],
        'submenu' => [
            ['title' => 'Manajemen User', 'url' => 'user/list.php', 'roles' => ['admin']],
            ['title' => 'Hak Akses', 'url' => 'user/access.php', 'roles' => ['admin']],
        ]
    ],
    [
        'title' => 'Pengaturan',
        'icon' => 'bi-sliders',
        'url' => 'settings.php',
        'roles' => ['admin']
    ]
];

// Fungsi render menu
function renderMenu($items) {
    $current_page = basename($_SERVER['PHP_SELF']);
    
    foreach ($items as $index => $item) {
        // Cek permission
        if (!hasAccess($item['roles'])) {
            continue;
        }
        
        // Menu dengan submenu
        if (isset($item['submenu'])) {
            $collapse_id = 'collapse-' . $index;
            echo '<li class="nav-item">';
            echo '<a class="nav-link collapsed" data-bs-toggle="collapse" href="#' . $collapse_id . '" role="button">';
            echo '<i class="' . $item['icon'] . '"></i>' . $item['title'];
            echo '<i class="bi bi-chevron-down collapse-icon"></i>';
            echo '</a>';
            echo '<div class="collapse" id="' . $collapse_id . '">';
            echo '<ul class="nav flex-column submenu">';
            
            foreach ($item['submenu'] as $sub) {
                if (!hasAccess($sub['roles'])) {
                    continue;
                }
                $active = (basename($sub['url']) === $current_page) ? 'active' : '';
                echo '<li class="nav-item">';
                echo '<a class="nav-link ' . $active . '" href="' . $sub['url'] . '">' . $sub['title'] . '</a>';
                echo '</li>';
            }
            
            echo '</ul>';
            echo '</div>';
            echo '</li>';
        } 
        // Menu tunggal
        else {
            $active = (isset($item['url']) && basename($item['url']) === $current_page) ? 'active' : '';
            echo '<li class="nav-item">';
            echo '<a class="nav-link ' . $active . '" href="' . $item['url'] . '">';
            echo '<i class="' . $item['icon'] . '"></i>' . $item['title'];
            echo '</a>';
            echo '</li>';
        }
    }
}
?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 px-0 sidebar">
            <div class="sidebar-header">
                <h5 class="mb-0"><i class="bi bi-building"></i> Admin Panel</h5>
                <small class="text-white-50"><?php echo $current_user['full_name']; ?></small>
            </div>
            
            <ul class="nav flex-column py-3">
                <?php renderMenu($menu_items); ?>
            </ul>
            
            <div class="position-absolute bottom-0 w-100 p-3">
                <a href="logout.php" class="nav-link text-danger">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-md-9 col-lg-10">
            <div class="p-4">
                <h2>Dashboard</h2>
                <p class="text-muted">Selamat datang, <strong><?php echo $current_user['full_name']; ?></strong> (Role: <?php echo ucfirst($user_role); ?>)</p>
                
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
                    Menu yang ditampilkan disesuaikan dengan role Anda. Ubah role di session untuk melihat perbedaan menu.
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>