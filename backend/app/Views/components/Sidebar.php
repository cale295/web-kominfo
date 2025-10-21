<?php
$session = session();
$role = $session->get('role'); // Akan dapat: Admin, Editor, atau User dari database
$fullName = $session->get('full_name');

// Debug - hapus setelah berhasil
// echo "<!-- Current Role: " . $role . " -->";

// Konfigurasi menu dengan permission (sesuaikan dengan role dari database)
$menuItems = [
    [
        'title' => 'Dashboard',
        'icon' => 'bi-speedometer2',
        'url' => '/dashboard',
        'roles' => ['Admin', 'Editor', 'User'] // Sesuai database
    ],
    [
        'title' => 'Manajemen Berita',
        'icon' => 'bi-newspaper',
        'roles' => ['Admin', 'Editor'],
        'submenu' => [
            ['title' => 'Daftar Berita', 'url' => '/berita', 'roles' => ['Admin', 'Editor']],
            ['title' => 'Tambah Berita', 'url' => '/berita/create', 'roles' => ['Admin', 'Editor']],
            ['title' => 'Kategori Berita', 'url' => '/berita/kategori', 'roles' => ['Admin']],
            ['title' => 'Tema Berita', 'url' => '/berita/tema', 'roles' => ['Admin']],
            ['title' => 'Tag Berita', 'url' => '/berita/tag', 'roles' => ['Admin']],
            ['title' => 'Berita Utama', 'url' => '/berita/featured', 'roles' => ['Admin', 'Editor']]
        ]
    ],
    [
        'title' => 'Agenda Kegiatan',
        'icon' => 'bi-calendar-event',
        'roles' => ['Admin', 'Editor'],
        'submenu' => [
            ['title' => 'Daftar Agenda', 'url' => '/agenda', 'roles' => ['Admin', 'Editor']],
            ['title' => 'Tambah Agenda', 'url' => '/agenda/create', 'roles' => ['Admin', 'Editor']],
            ['title' => 'Kalender', 'url' => '/agenda/calendar', 'roles' => ['Admin', 'Editor']]
        ]
    ],
    [
        'title' => 'Galeri',
        'icon' => 'bi-images',
        'roles' => ['Admin', 'Editor'],
        'submenu' => [
            ['title' => 'Album Foto', 'url' => '/galeri/album', 'roles' => ['Admin', 'Editor']],
            ['title' => 'Foto Galeri', 'url' => '/galeri/foto', 'roles' => ['Admin', 'Editor']],
            ['title' => 'Upload Foto', 'url' => '/galeri/upload', 'roles' => ['Admin', 'Editor']]
        ]
    ],
    [
        'title' => 'Dokumen',
        'icon' => 'bi-file-earmark-text',
        'roles' => ['Admin', 'Editor'],
        'submenu' => [
            ['title' => 'Daftar Dokumen', 'url' => '/dokumen', 'roles' => ['Admin', 'Editor']],
            ['title' => 'Kategori Dokumen', 'url' => '/dokumen/kategori', 'roles' => ['Admin']],
            ['title' => 'Upload Dokumen', 'url' => '/dokumen/upload', 'roles' => ['Admin', 'Editor']]
        ]
    ],
    [
        'title' => 'Layanan',
        'icon' => 'bi-gear',
        'url' => '/layanan',
        'roles' => ['Admin']
    ],
    [
        'title' => 'Pengaturan Menu',
        'icon' => 'bi-menu-button-wide',
        'url' => '/menu',
        'roles' => ['Admin']
    ],
    [
        'title' => 'Pengguna & Akses',
        'icon' => 'bi-people',
        'roles' => ['Admin'],
        'submenu' => [
            ['title' => 'Manajemen User', 'url' => '/users', 'roles' => ['Admin']],
            ['title' => 'Hak Akses', 'url' => '/users/access', 'roles' => ['Admin']]
        ]
    ],
    [
        'title' => 'Artikel Saya',
        'icon' => 'bi-file-earmark-text',
        'url' => '/my-posts',
        'roles' => ['User']
    ],
    [
        'title' => 'Pengaturan',
        'icon' => 'bi-sliders',
        'url' => '/settings',
        'roles' => ['Admin']
    ],
    [
        'title' => 'Profil',
        'icon' => 'bi-person',
        'url' => '/profile',
        'roles' => ['Admin', 'Editor', 'User']
    ]
];

// Get current URI for active menu
$uri = service('uri');
$currentPath = '/' . $uri->getPath();
?>

<style>
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
        text-decoration: none;
        display: block;
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
    .logout-btn {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 250px;
        background: linear-gradient(180deg, transparent 0%, rgba(30, 60, 114, 0.95) 30%, rgba(30, 60, 114, 1) 100%);
        padding: 15px 10px 20px;
        z-index: 10;
    }
    .user-info-box {
        background: rgba(255,255,255,0.1);
        padding: 12px;
        border-radius: 8px;
        margin: 10px;
    }
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 2px solid rgba(255,255,255,0.3);
    }
    @media (max-width: 768px) {
        .sidebar {
            margin-left: -250px;
        }
        .sidebar.show {
            margin-left: 0;
        }
    }
</style>

<div class="sidebar">
    <div class="sidebar-header">
        <h5 class="mb-0"><i class="bi bi-building"></i> Admin Panel</h5>
        <small class="text-white-50">Sistem Manajemen</small>
    </div>

    <div class="sidebar-scrollable-content">
        <!-- User Info -->
        <div class="user-info-box">
            <div class="d-flex align-items-center">
                <img src="https://ui-avatars.com/api/?name=<?= urlencode($fullName) ?>&background=random" 
                     alt="Avatar" class="user-avatar me-2">
                <div class="flex-grow-1">
                    <div class="text-white small fw-bold"><?= esc($fullName) ?></div>
                    <div class="text-white-50" style="font-size: 0.75rem;">
                        <?= esc($role) ?>
                    </div>
                </div>
            </div>
        </div>
        
        <ul class="nav flex-column py-3">
            <?php 
            $menuIndex = 0;
            foreach ($menuItems as $item): 
                // Cek akses role
                if (!in_array($role, $item['roles'])) continue;
            ?>
                <li class="nav-item">
                    <?php if (isset($item['submenu']) && !empty($item['submenu'])): ?>
                        <!-- Menu dengan Submenu -->
                        <?php $collapseId = 'collapse-' . $menuIndex; ?>
                        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#<?= $collapseId ?>" role="button" aria-expanded="false">
                            <i class="<?= $item['icon'] ?>"></i><?= $item['title'] ?>
                            <i class="bi bi-chevron-down collapse-icon"></i>
                        </a>
                        <div class="collapse" id="<?= $collapseId ?>">
                            <ul class="nav flex-column submenu">
                                <?php foreach ($item['submenu'] as $subItem): ?>
                                    <?php if (!in_array($role, $subItem['roles'])) continue; ?>
                                    <li class="nav-item">
                                        <?php 
                                        $isActive = ($currentPath === $subItem['url']) ? 'active' : '';
                                        ?>
                                        <a class="nav-link <?= $isActive ?>" href="<?= $subItem['url'] ?>">
                                            <?= $subItem['title'] ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php else: ?>
                        <!-- Menu tanpa Submenu -->
                        <?php 
                        $isActive = ($currentPath === $item['url']) ? 'active' : '';
                        ?>
                        <a class="nav-link <?= $isActive ?>" href="<?= $item['url'] ?>">
                            <i class="<?= $item['icon'] ?>"></i><?= $item['title'] ?>
                        </a>
                    <?php endif; ?>
                </li>
            <?php 
                $menuIndex++;
            endforeach; 
            ?>
        </ul>
    </div>
    
    <div class="logout-btn">
        <a href="/logout" class="nav-link text-danger">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>
</div>