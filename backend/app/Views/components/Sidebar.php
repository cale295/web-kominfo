<?php
$session = session();
$role = $session->get('role'); 
$fullName = $session->get('full_name');

// Konfigurasi menu dengan permission (sesuaikan dengan role dari database)
$menuItems = [
    [
        'title' => 'Dashboard',
        'icon' => 'bi-speedometer2',
        'url' => '/dashboard',
        'roles' => ['superadmin', 'admin', 'editor']
    ],
    [
        'title' => 'Banner',
        'icon' => 'bi-house-door',
        'url' => 'banner/',
        'roles' => ['admin']
    ],
    [
        'title' => 'Manajemen Berita',
        'icon' => 'bi-newspaper',
        'roles' => ['admin', 'editor'],
        'submenu' => [
            ['title' => 'Daftar Berita', 'url' => '/berita', 'roles' => ['admin', 'editor']],
            ['title' => 'Tambah Berita', 'url' => '/berita/create', 'roles' => ['admin', 'editor']],
            ['title' => 'Kategori Berita', 'url' => '/berita/kategori', 'roles' => ['admin']],
            ['title' => 'Tema Berita', 'url' => '/tema', 'roles' => ['admin']],
            ['title' => 'Tag Berita', 'url' => '/berita/tag', 'roles' => ['admin']],
            ['title' => 'Berita Utama', 'url' => '/berita/featured', 'roles' => ['admin', 'editor']]
        ]
    ],
    [
        'title' => 'Agenda Kegiatan',
        'icon' => 'bi-calendar-event',
        'roles' => ['admin', 'editor'],
        'submenu' => [
            ['title' => 'Daftar Agenda', 'url' => '/agenda', 'roles' => ['admin', 'editor']],
            ['title' => 'Tambah Agenda', 'url' => '/agenda/create', 'roles' => ['admin', 'editor']],
            ['title' => 'Kalender', 'url' => '/agenda/calendar', 'roles' => ['admin', 'editor']]
        ]
    ],
    [
        'title' => 'Galeri',
        'icon' => 'bi-images',
        'roles' => ['admin', 'editor'],
        'submenu' => [
            ['title' => 'Album Foto', 'url' => '/galeri/album', 'roles' => ['admin', 'editor']],
            ['title' => 'Foto Galeri', 'url' => '/galeri/foto', 'roles' => ['admin', 'editor']],
            ['title' => 'Upload Foto', 'url' => '/galeri/upload', 'roles' => ['admin', 'editor']]
        ]
    ],
    [
        'title' => 'Dokumen',
        'icon' => 'bi-file-earmark-text',
        'roles' => ['admin', 'editor'],
        'submenu' => [
            ['title' => 'Daftar Dokumen', 'url' => '/dokumen', 'roles' => ['admin', 'editor']],
            ['title' => 'Kategori Dokumen', 'url' => '/dokumen/kategori', 'roles' => ['admin']],
            ['title' => 'Upload Dokumen', 'url' => '/dokumen/upload', 'roles' => ['admin', 'editor']]
        ]
    ],
    [
        'title' => 'Layanan',
        'icon' => 'bi-gear',
        'url' => '/layanan',
        'roles' => ['admin']
    ],
    [
        'title' => 'Pengaturan Menu',
        'icon' => 'bi-menu-button-wide',
        'url' => '/menu',
        'roles' => ['superadmin']
    ],
    [
        'title' => 'Pengguna & Akses',
        'icon' => 'bi-people',
        'roles' => ['superadmin'],
        'submenu' => [
            ['title' => 'Manajemen User', 'url' => '/manage_user', 'roles' => ['superadmin']],
            ['title' => 'Hak Akses', 'url' => '/access_rights', 'roles' => ['superadmin']]
        ]
    ],
    [
        'title' => 'Pengaturan',
        'icon' => 'bi-sliders',
        'url' => '/settings',
        'roles' => ['superadmin', 'admin']
    ],
    [
        'title' => 'Profil',
        'icon' => 'bi-person',
        'url' => '/profile',
        'roles' => ['superadmin', 'admin', 'editor']
    ]
];

// Get current URI for active menu
$uri = service('uri');
$currentPath = '/' . $uri->getPath();
?>

<style>
    :root {
        --sidebar-primary: #1e40af;
        --sidebar-secondary: #1e3a8a;
        --sidebar-accent: #fbbf24;
        --sidebar-text: rgba(255, 255, 255, 0.9);
        --sidebar-text-muted: rgba(255, 255, 255, 0.6);
    }

    .sidebar {
        width: 280px;
        height: 100vh;
        background: linear-gradient(180deg, var(--sidebar-primary) 0%, var(--sidebar-secondary) 100%);
        box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        transition: transform 0.3s ease;
    }

    /* Header Sidebar */
    .sidebar-header {
        padding: 24px 20px;
        background: linear-gradient(135deg, rgba(251, 191, 36, 0.15) 0%, transparent 100%);
        border-bottom: 2px solid rgba(251, 191, 36, 0.3);
        border-left: 4px solid var(--sidebar-accent);
    }

    .sidebar-header h5 {
        color: white;
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 4px;
        letter-spacing: 0.5px;
    }

    .sidebar-header h5 i {
        color: var(--sidebar-accent);
        margin-right: 10px;
        font-size: 1.3rem;
    }

    .sidebar-header small {
        color: var(--sidebar-text-muted);
        font-size: 0.8rem;
        letter-spacing: 0.3px;
    }

    /* User Info Box */
    .user-info-box {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        padding: 16px;
        margin: 16px 12px;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.15);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .user-avatar {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        border: 2px solid var(--sidebar-accent);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .user-name {
        color: white;
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 2px;
        line-height: 1.3;
    }

    .user-role {
        color: var(--sidebar-accent);
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 2px 8px;
        background: rgba(251, 191, 36, 0.2);
        border-radius: 4px;
        display: inline-block;
    }

    /* Scrollable Content */
    .sidebar-scrollable-content {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        max-height: calc(100vh - 240px);
        padding-bottom: 20px;
    }

    .sidebar-scrollable-content::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar-scrollable-content::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.1);
    }

    .sidebar-scrollable-content::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 3px;
    }

    .sidebar-scrollable-content::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.5);
    }

    /* Navigation */
    .sidebar .nav {
        padding: 8px 0;
    }

    .sidebar .nav-link {
        color: var(--sidebar-text);
        padding: 12px 20px;
        border-radius: 10px;
        margin: 3px 12px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        white-space: nowrap;
        text-decoration: none;
        display: flex;
        align-items: center;
        font-weight: 500;
        font-size: 0.9rem;
        position: relative;
        overflow: hidden;
    }

    .sidebar .nav-link::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: var(--sidebar-accent);
        transform: translateX(-4px);
        transition: transform 0.3s ease;
    }

    .sidebar .nav-link:hover {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        transform: translateX(4px);
    }

    .sidebar .nav-link:hover::before {
        transform: translateX(0);
    }

    .sidebar .nav-link.active {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .sidebar .nav-link.active::before {
        transform: translateX(0);
    }

    .sidebar .nav-link i {
        margin-right: 12px;
        font-size: 1.15rem;
        width: 20px;
        text-align: center;
        color: var(--sidebar-accent);
    }

    /* Collapse Icon */
    .collapse-icon {
        margin-left: auto;
        transition: transform 0.3s ease;
        color: var(--sidebar-text-muted);
        font-size: 0.9rem;
    }

    .nav-link:not(.collapsed) .collapse-icon {
        transform: rotate(180deg);
        color: var(--sidebar-accent);
    }

    /* Submenu */
    .submenu {
        padding-left: 12px;
        margin-top: 4px;
    }

    .submenu .nav-link {
        font-size: 0.85rem;
        padding: 10px 16px 10px 40px;
        margin: 2px 12px;
        position: relative;
    }

    .submenu .nav-link::after {
        content: '';
        position: absolute;
        left: 20px;
        top: 50%;
        width: 6px;
        height: 6px;
        background: var(--sidebar-text-muted);
        border-radius: 50%;
        transform: translateY(-50%);
        transition: all 0.3s ease;
    }

    .submenu .nav-link:hover::after {
        background: var(--sidebar-accent);
        transform: translateY(-50%) scale(1.3);
    }

    .submenu .nav-link.active::after {
        background: var(--sidebar-accent);
        transform: translateY(-50%) scale(1.3);
        box-shadow: 0 0 8px var(--sidebar-accent);
    }

    .submenu .nav-link::before {
        display: none;
    }

    /* Logout Button */
    .logout-btn {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        background: linear-gradient(180deg, transparent 0%, rgba(30, 58, 138, 0.95) 30%, rgba(30, 58, 138, 1) 100%);
        padding: 20px 12px;
        z-index: 10;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .logout-btn .nav-link {
        background: rgba(220, 38, 38, 0.1);
        border: 2px solid rgba(220, 38, 38, 0.3);
        color: #fca5a5;
        font-weight: 600;
        justify-content: center;
        margin: 0;
    }

    .logout-btn .nav-link:hover {
        background: rgba(220, 38, 38, 0.2);
        border-color: rgba(220, 38, 38, 0.5);
        color: #fecaca;
        transform: translateX(0);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }

    .logout-btn .nav-link i {
        color: #fca5a5;
        margin-right: 8px;
    }

    /* Mobile Top Bar */
    .sidebar-toggle-container {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 70px;
        background: linear-gradient(135deg, var(--sidebar-primary) 0%, var(--sidebar-secondary) 100%);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        z-index: 1050;
        padding: 12px 16px;
        display: none;
    }

    .sidebar-toggle-container .d-flex {
        height: 100%;
    }

    .sidebar-toggle-container .user-avatar {
        width: 45px;
        height: 45px;
        border-radius: 10px;
        border: 2px solid var(--sidebar-accent);
    }

    .sidebar-toggle-container .user-name {
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 2px;
    }

    .sidebar-toggle-container .user-role {
        color: var(--sidebar-accent);
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 2px 6px;
        background: rgba(251, 191, 36, 0.2);
        border-radius: 4px;
        display: inline-block;
    }

    /* Hamburger Toggle Button */
    #sidebarToggle {
        background: rgba(255, 255, 255, 0.15);
        border: 2px solid rgba(255, 255, 255, 0.3);
        width: 45px;
        height: 45px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        flex-shrink: 0;
        margin-left: auto;
    }

    #sidebarToggle:hover {
        background: rgba(255, 255, 255, 0.25);
        border-color: rgba(255, 255, 255, 0.5);
        transform: scale(1.05);
    }

    #sidebarToggle i {
        font-size: 1.5rem;
        color: white;
    }

    /* Overlay untuk mobile */
    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .sidebar-overlay.show {
        display: block;
        opacity: 1;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .sidebar-toggle-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sidebar {
            transform: translateX(-100%);
            top: 70px;
            height: calc(100vh - 70px);
        }

        .sidebar.show {
            transform: translateX(0);
        }

        /* Adjust body padding for mobile top bar */
        body {
            padding-top: 70px;
        }
    }

    /* Animation */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-10px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .sidebar .nav-item {
        animation: slideIn 0.3s ease-out backwards;
    }

    .sidebar .nav-item:nth-child(1) { animation-delay: 0.05s; }
    .sidebar .nav-item:nth-child(2) { animation-delay: 0.1s; }
    .sidebar .nav-item:nth-child(3) { animation-delay: 0.15s; }
    .sidebar .nav-item:nth-child(4) { animation-delay: 0.2s; }
    .sidebar .nav-item:nth-child(5) { animation-delay: 0.25s; }
    .sidebar .nav-item:nth-child(6) { animation-delay: 0.3s; }
    .sidebar .nav-item:nth-child(7) { animation-delay: 0.35s; }
    .sidebar .nav-item:nth-child(8) { animation-delay: 0.4s; }
</style>

<!-- Mobile Top Bar -->
<div class="sidebar-toggle-container d-md-none">
    <div class="d-flex align-items-center flex-grow-1">
        <img src="https://ui-avatars.com/api/?name=<?= urlencode($fullName) ?>&background=1e40af&color=fbbf24&bold=true&format=svg" 
             alt="Avatar" class="user-avatar me-3">
        <div class="flex-grow-1">
            <div class="user-name"><?= esc($fullName) ?></div>
            <span class="user-role"><?= esc(strtoupper($role)) ?></span>
        </div>
    </div>
    <button class="btn btn-primary" id="sidebarToggle">
        <i class="bi bi-list"></i>
    </button>
</div>

<!-- Overlay untuk mobile -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="sidebar" id="sidebar">
    <!-- Header -->
    <div class="sidebar-header">
        <h5>
            <i class="bi bi-shield-check"></i>
            Admin Panel
        </h5>
        <small>Sistem Informasi Pemerintah</small>
    </div>

    <!-- User Info -->
    <div class="user-info-box d-md-block d-none">
        <div class="d-flex align-items-center">
            <img src="https://ui-avatars.com/api/?name=<?= urlencode($fullName) ?>&background=1e40af&color=fbbf24&bold=true&format=svg" 
                 alt="Avatar" class="user-avatar me-3">
            <div class="flex-grow-1">
                <div class="user-name"><?= esc($fullName) ?></div>
                <span class="user-role"><?= esc(strtoupper($role)) ?></span>
            </div>
        </div>
    </div>

    <!-- Scrollable Menu -->
    <div class="sidebar-scrollable-content">
        <ul class="nav flex-column">
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
                            <i class="<?= $item['icon'] ?>"></i>
                            <span><?= $item['title'] ?></span>
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
                            <i class="<?= $item['icon'] ?>"></i>
                            <span><?= $item['title'] ?></span>
                        </a>
                    <?php endif; ?>
                </li>
            <?php 
                $menuIndex++;
            endforeach; 
            ?>
        </ul>
    </div>
    
    <!-- Logout Button -->
    <div class="logout-btn">
        <a href="/logout" class="nav-link">
            <i class="bi bi-box-arrow-right"></i>
            <span>Keluar dari Sistem</span>
        </a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    // Toggle sidebar
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        });
    }

    // Close sidebar when clicking overlay
    if (overlay) {
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
            if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            }
        }
    });

    // Prevent sidebar clicks from closing it
    sidebar.addEventListener('click', function(e) {
        e.stopPropagation();
    });
});
</script>