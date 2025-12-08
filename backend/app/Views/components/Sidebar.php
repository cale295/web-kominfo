<?php
$session = session();
$role = $session->get('role'); 
$fullName = $session->get('full_name');

// Konfigurasi menu dengan permission (sesuaikan dengan role dari database)
$menuItems = [
[
    'title' => 'Dashboard',
    'icon' => 'bi-house-door-fill',
    'url' => '/dashboard',
    'roles' => ['superadmin', 'admin', 'editor']
],
[
    'title' => 'Tampil Home',
    'icon' => 'bi-display',
    'roles' => ['superadmin', 'admin'],
    'submenu'=> [
        ['title' => 'Banner', 'url' => '/banner', 'roles' => ['superadmin', 'admin']],
        ['title' => 'Service', 'url' => '/home_service', 'roles' => ['superadmin', 'admin']],
        ['title' => 'Daftar Agenda', 'url' => '/agenda', 'roles' => ['superadmin', 'admin']],
        ['title' => 'Pejabat Publik', 'url' => '/pejabat', 'roles' => ['superadmin', 'admin']],
        ['title' => 'Video Layanan', 'url' => '/home_video_layanan', 'roles' => ['superadmin', 'admin']]

    ]
],
    
[
    'title' => 'Manajemen Berita',
    'icon' => 'bi-newspaper',
    'roles' => ['superadmin', 'admin', 'editor'],
    'submenu' => [
        ['title' => 'Daftar Berita', 'url' => '/berita', 'roles' => ['superadmin', 'admin', 'editor']],
        ['title' => 'Kategori Berita', 'url' => '/kategori', 'roles' => ['superadmin', 'admin']],
        ['title' => 'Tag Berita', 'url' => '/berita_tag', 'roles' => ['superadmin', 'admin']],
        ['title' => 'Berita Utama', 'url' => '/berita-utama', 'roles' => ['superadmin', 'admin', 'editor']]
    ]
],
[
    'title' => 'Tampil Profil',
    'icon' => 'bi-building',
    'roles' => ['superadmin', 'admin'],
    'submenu'=> [
        ['title' => 'Profil Tentang', 'url' => '/profil_tentang', 'roles'=> ['superadmin', 'admin']],
        ['title' => 'Tugas & Fungsi', 'url' => '/tugas_fungsi', 'roles'=> ['superadmin', 'admin']],
        //['title' => 'Pejabat Struktural', 'url' => '/pejabat_struktural', 'roles'=> ['superadmin', 'admin']],
        ['title' => 'Struktur Organisasi', 'url' => '/struktur_organisasi', 'roles' => ['superadmin', 'admin']]
    ]
],
[
    'title' => 'Tampil Informasi Publik',
    'icon' => 'bi-building',
    'roles' => ['superadmin', 'admin'],
    'submenu'=> [
        ['title' => 'Perencanaan', 'url' => '/informasi_perencanaan', 'roles'=> ['superadmin', 'admin']],
        //['title' => 'Pengadaan Barang & Jasa', 'url' => '/barang_jasa', 'roles'=> ['superadmin', 'admin']],
        ['title' => 'Laporan Keuangan', 'url' => '/laporan_keuangan', 'roles'=> ['superadmin', 'admin']],
        ['title' => 'Laporan Kinerja', 'url' => '/laporan_kinerja', 'roles'=> ['superadmin', 'admin']],
        //['title' => 'Pendidikan dan Pelatihan', 'url' => '/barang_jasa', 'roles'=> ['superadmin', 'admin']],
        ['title' => 'Permohonan Informasi', 'url' => '/permohonan_informasi', 'roles'=> ['superadmin', 'admin']],
        ['title' => 'Daftar Informasi Publik', 'url' => '/daftar_informasi_publik', 'roles' => ['superadmin', 'admin']],
        ['title' => 'Kerjasama Daerah', 'url' => '/ip_kerjasama_daerah', 'roles'=> ['superadmin', 'admin']]
    ]
],
[
    'title' => 'Tampil Kontak',
    'icon' => 'bi-telephone-fill',
    'roles' => ['superadmin', 'admin'],
    'submenu'=> [
        ['title' => 'Kontak', 'url' => '/kontak', 'roles' => ['superadmin', 'admin']],
        ['title' => 'Kontak Layanan', 'url' => '/kontak_layanan', 'roles' => ['superadmin', 'admin']],
        ['title' => 'Sosial Media', 'url' => '/kontak_social', 'roles' => ['superadmin', 'admin']]
    ]
],

[
    'title' => 'Galeri',
    'icon' => 'bi-image-fill',
    'roles' => ['superadmin', 'admin'],
    'submenu' => [
        ['title' => 'Album Foto', 'url' => '/album', 'roles' => ['superadmin', 'admin']],
        ['title' => 'Foto Galeri', 'url' => '/gallery', 'roles' => ['superadmin', 'admin']],
        ['title' => 'Upload Foto', 'url' => '/galeri/upload', 'roles' => ['superadmin', 'admin']]
    ]
 ],
// [
//     'title' => 'Dokumen',
//     'icon' => 'bi-file-earmark-pdf-fill',
//     'roles' => ['superadmin', 'admin'],
//     'submenu' => [   
//         ['title' => 'Daftar Dokumen', 'url' => '/dokument', 'roles' => ['superadmin', 'admin']],
//         ['title' => 'Kategori Dokumen', 'url' => '/dokument_kategori', 'roles' => ['superadmin', 'admin']],
//         ['title' => 'Upload Dokumen', 'url' => '/dokumen/upload', 'roles' => ['superadmin', 'admin']]
//     ]
// ],
[
    'title' => 'Tampil Footer',
    'icon' => 'bi-layout-text-window-reverse',   
    'roles' => ['superadmin', 'admin'],
    'submenu'=> [
        ['title' => 'Footer', 'url' => '/footer_opd', 'roles' => ['superadmin', 'admin']],
        ['title' => 'Sosial Media', 'url' => '/footer_social', 'roles' => ['superadmin', 'admin']],
        ['title' => 'Statistik', 'url' => '/footer_statistics', 'roles' => ['superadmin', 'admin']]
    ]
],
[
    'title' => 'Pengaturan Menu',
    'icon' => 'bi-list-ul',
    'url' => '/menu',
    'roles' => ['superadmin']
],
[
    'title' => 'Pengguna & Akses',
    'icon' => 'bi-shield-lock-fill',
    'roles' => ['superadmin'],
    'submenu' => [
        ['title' => 'Manajemen User', 'url' => '/manage_user', 'roles' => ['superadmin']],
        ['title' => 'Hak Akses', 'url' => '/access_rights', 'roles' => ['superadmin']]
    ]
],
// [
//     'title' => 'Pengaturan',
//     'icon' => 'bi-gear-fill',
//     'url' => '/settings',
//     'roles' => ['superadmin', 'admin']
// ],
[
    'title' => 'Profil',
    'icon' => 'bi-person-circle',
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
        --primary: #1e40af;
        --primary-dark: #1e3a8a;
        --primary-light: #3b82f6;
        --gray-50: #f8fafc;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-300: #cbd5e1;
        --gray-400: #94a3b8;
        --gray-500: #64748b;
        --gray-600: #475569;
        --gray-700: #334155;
        --gray-800: #1e293b;
        --gray-900: #0f172a;
    }

    .sidebar {
        width: 280px;
        height: 100vh;
        background: white;
        border-right: 1px solid var(--gray-200);
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        transition: transform 0.3s ease;
    }

    /* Header Sidebar */
    .sidebar-header {
        padding: 20px;
        border-bottom: 1px solid var(--gray-200);
        background-color: var(--gray-50);
    }

    .sidebar-header h5 {
        color: var(--gray-900);
        font-weight: 600;
        font-size: 1.125rem;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
    }

    .sidebar-header h5 i {
        color: var(--primary);
        margin-right: 10px;
        font-size: 1.25rem;
    }

    .sidebar-header small {
        color: var(--gray-600);
        font-size: 0.8125rem;
    }

    /* User Info Box */
    .user-info-box {
        background: var(--gray-50);
        padding: 16px;
        margin: 16px 16px 12px;
        border-radius: 8px;
        border: 1px solid var(--gray-200);
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        border: 2px solid var(--primary);
    }

    .user-name {
        color: var(--gray-900);
        font-weight: 600;
        font-size: 0.9375rem;
        margin-bottom: 4px;
        line-height: 1.3;
    }

    .user-role {
        color: var(--primary);
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 2px 8px;
        background: var(--gray-100);
        border-radius: 4px;
        display: inline-block;
        border: 1px solid var(--gray-200);
    }

    /* Scrollable Content */
    .sidebar-scrollable-content {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        max-height: calc(100vh - 240px);
        padding: 8px 0 20px;
    }

    .sidebar-scrollable-content::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar-scrollable-content::-webkit-scrollbar-track {
        background: transparent;
    }

    .sidebar-scrollable-content::-webkit-scrollbar-thumb {
        background: var(--gray-300);
        border-radius: 3px;
    }

    .sidebar-scrollable-content::-webkit-scrollbar-thumb:hover {
        background: var(--gray-400);
    }

    /* Navigation */
    .sidebar .nav {
        padding: 0;
    }

    .sidebar .nav-link {
        color: var(--gray-700);
        padding: 10px 16px;
        border-radius: 8px;
        margin: 2px 16px;
        transition: all 0.2s;
        white-space: nowrap;
        text-decoration: none;
        display: flex;
        align-items: center;
        font-weight: 500;
        font-size: 0.875rem;
        position: relative;
    }

    .sidebar .nav-link:hover {
        background: var(--gray-100);
        color: var(--gray-900);
    }

    .sidebar .nav-link.active {
        background: var(--primary);
        color: white;
        font-weight: 600;
    }

    .sidebar .nav-link.active i {
        color: white;
    }

    .sidebar .nav-link i {
        margin-right: 12px;
        font-size: 1.125rem;
        width: 20px;
        text-align: center;
        color: var(--gray-600);
        transition: color 0.2s;
    }

    .sidebar .nav-link:hover i {
        color: var(--primary);
    }

    /* Collapse Icon */
    .collapse-icon {
        margin-left: auto;
        transition: transform 0.2s ease;
        color: var(--gray-500);
        font-size: 0.875rem;
    }

    .nav-link:not(.collapsed) .collapse-icon {
        transform: rotate(180deg);
    }

    /* Submenu */
    .submenu {
        padding-left: 0;
        margin-top: 2px;
        margin-bottom: 4px;
    }

    .submenu .nav-link {
        font-size: 0.8125rem;
        padding: 8px 16px 8px 52px;
        margin: 2px 16px;
        position: relative;
        color: var(--gray-600);
    }

    .submenu .nav-link::before {
        content: '';
        position: absolute;
        left: 32px;
        top: 50%;
        width: 4px;
        height: 4px;
        background: var(--gray-400);
        border-radius: 50%;
        transform: translateY(-50%);
        transition: all 0.2s;
    }

    .submenu .nav-link:hover {
        color: var(--gray-900);
    }

    .submenu .nav-link:hover::before {
        background: var(--primary);
        transform: translateY(-50%) scale(1.5);
    }

    .submenu .nav-link.active {
        background: var(--gray-100);
        color: var(--primary);
        font-weight: 600;
    }

    .submenu .nav-link.active::before {
        background: var(--primary);
        transform: translateY(-50%) scale(1.5);
    }

    /* Logout Button */
    .logout-btn {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        background: white;
        padding: 16px;
        border-top: 1px solid var(--gray-200);
    }

    .logout-btn .nav-link {
        background: white;
        border: 1px solid var(--gray-300);
        color: var(--gray-700);
        font-weight: 500;
        justify-content: center;
        margin: 0;
        transition: all 0.2s;
    }

    .logout-btn .nav-link:hover {
        background: #fef2f2;
        border-color: #fecaca;
        color: #dc2626;
    }

    .logout-btn .nav-link i {
        color: var(--gray-600);
        margin-right: 8px;
    }

    .logout-btn .nav-link:hover i {
        color: #dc2626;
    }

    /* Mobile Top Bar */
    .sidebar-toggle-container {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 64px;
        background: white;
        border-bottom: 1px solid var(--gray-200);
        z-index: 1050;
        padding: 12px 16px;
        display: none;
    }

    .sidebar-toggle-container .d-flex {
        height: 100%;
    }

    .sidebar-toggle-container .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        border: 2px solid var(--primary);
    }

    .sidebar-toggle-container .user-name {
        color: var(--gray-900);
        font-weight: 600;
        font-size: 0.9375rem;
        margin-bottom: 2px;
    }

    .sidebar-toggle-container .user-role {
        color: var(--primary);
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 2px 8px;
        background: var(--gray-100);
        border-radius: 4px;
        display: inline-block;
        border: 1px solid var(--gray-200);
    }

    /* Hamburger Toggle Button */
    #sidebarToggle {
        background: white;
        border: 1px solid var(--gray-300);
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        flex-shrink: 0;
        margin-left: auto;
    }

    #sidebarToggle:hover {
        background: var(--gray-50);
        border-color: var(--gray-400);
    }

    #sidebarToggle i {
        font-size: 1.25rem;
        color: var(--gray-700);
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
            top: 64px;
            height: calc(100vh - 64px);
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar.show {
            transform: translateX(0);
        }

        body {
            padding-top: 64px;
        }
    }
</style>

<!-- Mobile Top Bar -->
<div class="sidebar-toggle-container d-md-none">
    <div class="d-flex align-items-center flex-grow-1">
        <img src="https://ui-avatars.com/api/?name=<?= urlencode($fullName) ?>&background=1e40af&color=fff&bold=true&format=svg" 
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
            <i class="bi bi-shield-lock"></i>
            Admin Panel
        </h5>
        <small>Sistem Informasi Pemerintah</small>
    </div>

    <!-- User Info -->
    <div class="user-info-box d-md-block d-none">
        <div class="d-flex align-items-center">
            <img src="https://ui-avatars.com/api/?name=<?= urlencode($fullName) ?>&background=1e40af&color=fff&bold=true&format=svg" 
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
            <span>Keluar</span>
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