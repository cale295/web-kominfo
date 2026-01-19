<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php
// --- 1. SETUP SESSION & URI ---
$session   = session();
$role      = $session->get('role') ?? 'guest'; 
$fullName  = $session->get('full_name') ?? 'Administrator';
$avatarUrl = "https://ui-avatars.com/api/?name=" . urlencode($fullName) . "&background=e2e8f0&color=475569&bold=true&format=svg";

$uri = service('uri');
$segments = $uri->getSegments();
$currentPath = '/' . (isset($segments[0]) ? $segments[0] : 'dashboard');
if(count($segments) > 1) {
    $currentPath = '/' . implode('/', $segments);
}

// --- 2. FUNGSI CEK HAK AKSES ---
function hasModuleAccess($moduleName, $userRole) {
    $accessModel = new \App\Models\AccessRightsModel();
    
    $access = $accessModel
        ->where('role', strtolower($userRole))
        ->where('module_name', $moduleName)
        ->first();
    
    if (!$access) {
        return false; // Jika tidak ada di database, anggap tidak ada akses
    }
    
    // Cek apakah minimal punya akses read
    return ($access['can_read'] == 1);
}

// --- 3. LOGIKA DATABASE (INFORMASI PUBLIK) ---
$menuModel = new \App\Models\MenuModel(); 
$parentInfoPublik = $menuModel->where('menu_name', 'Informasi Publik')->first();
$dynamicInfoPublikSubmenu = [];

if ($parentInfoPublik) {
    $children = $menuModel->where('parent_id', $parentInfoPublik['id_menu'])
                          ->where('status', 'active')
                          ->orderBy('order_number', 'ASC')
                          ->findAll();

    foreach ($children as $child) {
        $childRoles = !empty($child['allowed_roles']) 
                      ? array_map('trim', explode(',', $child['allowed_roles'])) 
                      : ['superadmin', 'admin'];

        $menuItem = [
            'title'  => $child['menu_name'],
            'url'    => $child['menu_url'] ?: '#',
            'roles'  => $childRoles,
            'module' => $child['module_name'] ?? null // Tambahkan module name
        ];

        $grandChildren = $menuModel->where('parent_id', $child['id_menu'])
                                   ->where('status', 'active')
                                   ->orderBy('order_number', 'ASC')
                                   ->findAll();

        if (!empty($grandChildren)) {
            $grandChildItems = [];
            foreach ($grandChildren as $gc) {
                $gcRoles = !empty($gc['allowed_roles']) 
                           ? array_map('trim', explode(',', $gc['allowed_roles'])) 
                           : ['superadmin', 'admin'];

                $grandChildItems[] = [
                    'title'  => $gc['menu_name'],
                    'url'    => $gc['menu_url'],
                    'roles'  => $gcRoles,
                    'module' => $gc['module_name'] ?? null
                ];
            }
            $menuItem['submenu'] = $grandChildItems;
            $menuItem['url'] = '#';
        }

        $dynamicInfoPublikSubmenu[] = $menuItem;
    }
}

// --- 4. DEFINISI MENU ARRAY DENGAN MODULE NAME ---
$menuItems = [
    [
        'type'   => 'item', 
        'title'  => 'Dashboard', 
        'icon'   => 'bi-speedometer2',
        'url'    => '/dashboard', 
        'roles'  => ['superadmin', 'admin', 'editor'],
        'module' => 'dashboard',
        'color'  => '#4e73df', 
        'bg'     => 'rgba(78, 115, 223, 0.1)' 
    ],
    [
        'type'   => 'item', 
        'title'  => 'Pengaturan Menu', 
        'icon'   => 'bi-gear-fill', 
        'url'    => '/menu', 
        'roles'  => ['superadmin'],
        'module' => 'menu',
        'color'  => '#4e73df', 
        'bg'     => 'rgba(78, 115, 223, 0.1)' 
    ],
    ['type' => 'header', 'title' => 'BANNER & LAYANAN', 'roles' => ['superadmin, admin, editor']],
    [
        'type'   => 'dropdown', 
        'title'  => 'Tampil Home', 
        'icon'   => 'bi-laptop', 
        'roles'  => ['superadmin', 'admin'],
        'color'  => '#6610f2', 
        'bg'     => 'rgba(102, 16, 242, 0.1)',
        'submenu' => [
            ['title' => 'Banner Slider', 'url' => '/banner', 'roles' => ['superadmin', 'admin'], 'module' => 'banner'],
            ['title' => 'Layanan', 'url' => '/home_service', 'roles' => ['superadmin', 'admin'], 'module' => 'home_service'],
            ['title' => 'Video Layanan', 'url' => '/home_video_layanan', 'roles' => ['superadmin', 'admin'], 'module' => 'home_video_layanan'],
            ['title' => 'Agenda', 'url' => '/agenda', 'roles' => ['superadmin', 'admin', 'editor'], 'module' => 'agenda'],
            ['title' => 'Pengumuman', 'url' => '/pengumuman', 'roles' => ['superadmin', 'admin', 'editor'], 'module' => 'pengumuman'],
            ['title' => 'Pejabat Publik', 'url' => '/pejabat', 'roles' => ['superadmin', 'admin'], 'module' => 'pejabat'],
        ]
    ],
    ['type' => 'header', 'title' => 'BERITA'],
    [
        'type'   => 'dropdown', 
        'title'  => 'Manajemen Berita', 
        'icon'   => 'bi-newspaper', 
        'roles'  => ['superadmin', 'admin', 'editor'],
        'color'  => '#e74a3b', 
        'bg'     => 'rgba(231, 74, 59, 0.1)',
        'submenu' => [
            ['title' => 'Berita', 'url' => '/berita', 'roles' => ['superadmin', 'admin', 'editor'], 'module' => 'berita'],
            ['title' => 'Berita Utama', 'url' => '/berita-utama', 'roles' => ['superadmin', 'admin'], 'module' => 'berita_utama'],
            ['title' => 'Kategori', 'url' => '/kategori', 'roles' => ['superadmin', 'admin'], 'module' => 'berita_kategori'],
            ['title' => 'Tag', 'url' => '/berita_tag', 'roles' => ['superadmin', 'admin'], 'module' => 'berita_tag'],
        ]
    ],
    ['type' => 'header', 'title' => 'HALAMAN PUBLIK', 'roles' => ['superadmin, admin']],
    [
        'type'   => 'dropdown', 
        'title'  => 'Profil Instansi', 
        'icon'   => 'bi-building', 
        'roles'  => ['superadmin', 'admin'],
        'color'  => '#36b9cc', 
        'bg'     => 'rgba(54, 185, 204, 0.1)',
        'submenu' => [
            ['title' => 'Profil Tentang', 'url' => '/profil_tentang', 'roles' => ['superadmin', 'admin'], 'module' => 'profil_tentang'],
            ['title' => 'Tugas & Fungsi', 'url' => '/tugas_fungsi', 'roles' => ['superadmin', 'admin'], 'module' => 'tugas_fungsi'],
            ['title' => 'Struktur Pejabat', 'url' => '/pejabat_struktural', 'roles' => ['superadmin', 'admin'], 'module' => 'pejabat_struktural'],
            ['title' => 'Struktur Organisasi', 'url' => '/struktur_organisasi', 'roles' => ['superadmin', 'admin'], 'module' => 'struktur_organisasi'],
            ['title' => 'Program SKPD', 'url' => '/program', 'roles' => ['superadmin', 'admin'], 'module' => 'program'],
        ]
    ],
    [
        'type'    => 'dropdown', 
        'title'   => 'Informasi Publik', 
        'icon'    => 'bi-info-circle', 
        'roles'   => ['superadmin', 'admin'],
        'color'   => '#1cc88a', 
        'bg'      => 'rgba(28, 200, 138, 0.1)',
        'submenu' => $dynamicInfoPublikSubmenu 
    ],
    [
        'type'   => 'item', 
        'title'  => 'Galeri & Media', 
        'url' => '/album',
        'icon'   => 'bi-images', 
        'roles'  => ['superadmin', 'admin', 'editor'],
        'module' => 'galeri_album',
        'color'  => '#f6c23e',
        'bg'     => 'rgba(246, 194, 62, 0.1)',
    ],
    [
        'type'   => 'dropdown', 
        'title'  => 'Kontak & Footer', 
        'icon'   => 'bi-layout-text-window', 
        'roles'  => ['superadmin', 'admin'],
        'color'  => '#fd7e14', 
        'bg'     => 'rgba(253, 126, 20, 0.1)',
        'submenu' => [
            ['title' => 'Info Kontak', 'url' => '/kontak', 'roles' => ['superadmin', 'admin'], 'module' => 'kontak'],
            ['title' => 'Pengaturan Footer', 'url' => '/footer_opd', 'roles' => ['superadmin', 'admin'], 'module' => 'footer_opd'],
        ]
    ],
    ['type' => 'header', 'title' => 'SYSTEM SETTINGS'],
    [
        'type'   => 'dropdown', 
        'title'  => 'Users & Akses', 
        'icon'   => 'bi-shield-lock', 
        'roles'  => ['superadmin'],
        'color'  => '#858796', 
        'bg'     => 'rgba(133, 135, 150, 0.1)',
        'submenu' => [
            ['title' => 'Manajemen User', 'url' => '/manage_user', 'roles' => ['superadmin'], 'module' => 'manage_user'],
            ['title' => 'Hak Akses', 'url' => '/access_rights', 'roles' => ['superadmin'], 'module' => 'access_rights'],
        ]
    ],
    [
        'type'   => 'item', 
        'title'  => 'Profil Saya', 
        'icon'   => 'bi-person-circle', 
        'url'    => '/profile', 
        'roles'  => ['superadmin', 'admin', 'editor'],
        'module' => 'profile',
        'color'  => '#4e73df', 
        'bg'     => 'rgba(78, 115, 223, 0.1)'
    ]
];
?>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

:root {
    --sb-width: 260px;
    --sb-bg: #ffffff;
    --sb-text: #64748b;
    --sb-text-active: #1e293b;
    --sb-header: #a0aec0;
    --primary: #3b82f6;
    --hover-bg: #f8fafc;
    --active-bg: #eff6ff;
    --border: #e2e8f0;
    --danger: #ef4444;
}

* { margin: 0; padding: 0; box-sizing: border-box; }

#sidebar {
    width: var(--sb-width);
    height: 100vh;
    position: fixed;
    top: 0; left: 0;
    background: var(--sb-bg);
    border-right: 1px solid var(--border);
    z-index: 1040;
    display: flex; 
    flex-direction: column;
    font-family: 'Inter', sans-serif;
    transition: transform 0.3s ease;
    box-shadow: 4px 0 24px rgba(0,0,0,0.02);
}

.sidebar-brand {
    height: 60px; /* Dikecilkan dari 70px */
    display: flex; 
    align-items: center;
    padding: 0 1.25rem; /* Dikecilkan dari 1.5rem */
    border-bottom: 1px solid var(--border);
    font-weight: 800;
    font-size: 1.1rem; /* Dikecilkan dari 1.25rem */
    color: #0f172a;
    letter-spacing: -0.5px;
    flex-shrink: 0;
}
.brand-icon { color: var(--primary); margin-right: 8px; font-size: 1.2rem; } /* Dikecilkan */

.sidebar-user-card {
    padding: 0.75rem 1.25rem; /* Dikecilkan dari 1rem 1.5rem */
    display: flex; 
    align-items: center; 
    gap: 10px; /* Dikecilkan dari 12px */
    border-bottom: 1px solid var(--border);
    margin-bottom: 8px; /* Dikecilkan dari 10px */
    flex-shrink: 0;
}
.user-avatar { width: 36px; height: 36px; border-radius: 8px; border: 1px solid var(--border); object-fit: cover; } /* Dikecilkan */
.user-details { overflow: hidden; flex: 1; }
.user-name { font-weight: 700; color: #334155; font-size: 0.85rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; } /* Dikecilkan */
.user-role { font-size: 0.65rem; color: var(--primary); text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; } /* Dikecilkan */

.sidebar-menu-wrapper { 
    flex: 1; 
    padding: 0 0 1.5rem 0; /* Dikecilkan dari 2rem */
    display: flex;
    flex-direction: column;
    min-height: 0;
    overflow: hidden;
}

.menu-list-container {
    overflow-y: auto;
    flex: 1;
    padding: 0 0.25rem 0 0; /* Dikecilkan dari 0.5rem */
}

.menu-list-container::-webkit-scrollbar { width: 4px; } /* Dikecilkan dari 5px */
.menu-list-container::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 8px; }
.menu-list-container::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

.menu-list { list-style: none; }

.menu-header {
    font-size: 0.65rem; /* Dikecilkan dari 0.7rem */
    font-weight: 700; 
    color: var(--sb-header);
    text-transform: uppercase; 
    margin: 0.75rem 0 0.4rem 1.25rem; /* Dikecilkan dan margin dikurangi */
    letter-spacing: 0.5px;
}

/* PERUBAHAN UTAMA: Ukuran Menu Item */
.sidebar-link {
    display: flex; 
    align-items: center;
    padding: 0.5rem 0.75rem; /* Dikecilkan dari 0.65rem 0.75rem */
    color: var(--sb-text); 
    text-decoration: none;
    font-weight: 500; 
    font-size: 0.8rem; /* Dikecilkan dari 0.875rem */
    transition: all 0.2s ease;
    margin: 0 0.5rem 0.15rem 0.5rem; /* Dikecilkan dari 0.75rem */
    border-radius: 8px; /* Dikecilkan dari 10px */
    cursor: pointer;
}

.icon-wrapper {
    width: 28px; /* Dikecilkan dari 32px */
    height: 28px; /* Dikecilkan dari 32px */
    min-width: 28px; /* Dikecilkan dari 32px */
    display: flex; 
    align-items: center; 
    justify-content: center;
    border-radius: 6px; /* Dikecilkan dari 8px */
    margin-right: 10px; /* Dikecilkan dari 12px */
    transition: all 0.2s ease;
    font-size: 0.95rem; /* Dikecilkan dari 1.1rem */
}

.sidebar-link:hover { background: var(--hover-bg); color: var(--sb-text-active); }
.sidebar-link:hover .icon-wrapper { transform: scale(1.05); }

.sidebar-link.active, .has-submenu.open > .sidebar-link {
    background: var(--active-bg);
    color: var(--sb-text-active);
    font-weight: 600;
}

.arrow { margin-left: auto; font-size: 0.7rem; transition: transform 0.3s ease; color: #94a3b8; } /* Dikecilkan */
.has-submenu.open > .sidebar-link .arrow { transform: rotate(180deg); color: var(--sb-text-active); }

.submenu { display: none; list-style: none; padding: 0.2rem 0; animation: slideDown 0.2s ease forwards; } /* Dikecilkan */
.has-submenu.open > .submenu { display: block; }

.submenu-item {
    display: flex; 
    align-items: center;
    padding: 0.45rem 0.75rem 0.45rem 3.2rem; /* Dikecilkan */
    text-decoration: none; 
    color: var(--sb-text);
    font-size: 0.75rem; /* Dikecilkan dari 0.85rem */
    font-weight: 500;
    margin: 0 0.5rem 0.1rem 0.5rem; /* Dikecilkan */
    border-radius: 6px; /* Dikecilkan */
    position: relative;
}

.submenu-item:hover { color: var(--sb-text-active); background: var(--hover-bg); }
.submenu-item.active { color: var(--primary); background: white; font-weight: 600; box-shadow: 0 1px 3px rgba(0,0,0,0.03); } /* Dikecilkan */

.submenu-item.active::before {
    content: ''; 
    position: absolute; 
    left: 2rem; /* Disesuaikan */
    top: 50%;
    transform: translateY(-50%); 
    width: 5px; /* Dikecilkan dari 6px */
    height: 5px; /* Dikecilkan dari 6px */
    background: var(--primary); 
    border-radius: 50%;
}

.has-submenu-level-3 > .submenu-item .arrow { transform: rotate(-90deg); margin-left: auto; }
.has-submenu-level-3.open > .submenu-item .arrow { transform: rotate(0deg); }

.submenu-level-3 { display: none; list-style: none; padding: 0; animation: slideDown 0.2s ease forwards; }
.has-submenu-level-3.open > .submenu-level-3 { display: block; }

.submenu-item-level-3 {
    display: flex; 
    align-items: center;
    padding: 0.4rem 0.75rem 0.4rem 4rem; /* Dikecilkan */ 
    text-decoration: none; 
    color: var(--sb-text);
    font-size: 0.7rem; /* Dikecilkan dari 0.8rem */
    font-weight: 500;
    margin: 0 0.5rem 0.1rem 0.5rem; /* Dikecilkan */
    border-radius: 6px; /* Dikecilkan */
}
.submenu-item-level-3:hover { color: var(--sb-text-active); background: var(--hover-bg); }
.submenu-item-level-3.active { color: var(--primary); font-weight: 700; background: rgba(59, 130, 246, 0.05); }

.sidebar-footer {
    border-top: 1px solid var(--border);
    padding: 0.5rem 1.25rem; /* Dikecilkan dari 0.75rem 1.5rem */
    margin-top: auto;
    flex-shrink: 0;
}

.logout-btn {
    display: flex;
    align-items: center;
    padding: 0.5rem; /* Dikecilkan dari 0.75rem */
    color: var(--danger);
    text-decoration: none;
    font-weight: 600;
    font-size: 0.8rem; /* Dikecilkan dari 0.9rem */
    border-radius: 8px; /* Dikecilkan dari 10px */
    transition: all 0.2s ease;
    background: rgba(239, 68, 68, 0.05);
    border: 1px solid rgba(239, 68, 68, 0.1);
}

.logout-btn:hover {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.1); /* Dikecilkan */
}

.logout-icon {
    width: 32px; /* Dikecilkan dari 36px */
    height: 32px; /* Dikecilkan dari 36px */
    min-width: 32px; /* Dikecilkan dari 36px */
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px; /* Dikecilkan dari 8px */
    margin-right: 10px; /* Dikecilkan dari 12px */
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger);
    font-size: 1rem; /* Dikecilkan dari 1.2rem */
}

.logout-btn:hover .logout-icon {
    background: rgba(239, 68, 68, 0.2);
    transform: scale(1.05);
}
@keyframes slideDown { from { opacity: 0; transform: translateY(-5px); } to { opacity: 1; transform: translateY(0); } }

.sidebar-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.5); z-index: 1030; backdrop-filter: blur(2px); }
@media (max-width: 768px) {
    #sidebar { transform: translateX(-100%); }
    #sidebar.mobile-open { transform: translateX(0); }
    .sidebar-overlay.show { display: block; }
}
</style>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<nav id="sidebar">
    <div class="sidebar-brand">
        <i class="bi bi-shield-lock-fill brand-icon"></i>
        <span>Admin Panel</span>
    </div>

    <div class="sidebar-user-card">
        <img src="<?= $avatarUrl ?>" alt="User" class="user-avatar">
        <div class="user-details">
            <div class="user-name"><?= esc($fullName) ?></div>
            <div class="user-role"><?= esc($role) ?></div>
        </div>
    </div>

    <div class="sidebar-menu-wrapper">
        <div class="menu-list-container">
            
            <ul class="menu-list">
                <?php foreach ($menuItems as $item): ?>
                    <?php 
                    // Cek role permission
                    if (isset($item['roles']) && !in_array($role, $item['roles'])) continue;
                    
                    // LOGIKA BARU: Cek access rights dari database
                    if (isset($item['module']) && !hasModuleAccess($item['module'], $role)) {
                        continue; // Skip menu jika tidak punya akses
                    }
                    
                    $iconColor = $item['color'] ?? '#64748b';
                    $iconBg    = $item['bg'] ?? 'rgba(100, 116, 139, 0.1)';
                    ?>
    
                    <?php if ($item['type'] === 'header'): ?>
                        <li class="menu-header"><?= $item['title'] ?></li>
                    
                    <?php elseif ($item['type'] === 'dropdown'): ?>
                        <?php 
                            // Filter submenu berdasarkan access rights
                            $visibleSubmenu = [];
                            if(isset($item['submenu']) && is_array($item['submenu'])) {
                                foreach($item['submenu'] as $sub) {
                                    // Cek role
                                    if (!in_array($role, $sub['roles'])) continue;
                                    
                                    // Cek access rights
                                    if (isset($sub['module']) && !hasModuleAccess($sub['module'], $role)) {
                                        continue;
                                    }
                                    
                                    // Jika ada submenu level 3, filter juga
                                    if (isset($sub['submenu'])) {
                                        $visibleLevel3 = [];
                                        foreach($sub['submenu'] as $l3) {
                                            if (!in_array($role, $l3['roles'])) continue;
                                            if (isset($l3['module']) && !hasModuleAccess($l3['module'], $role)) {
                                                continue;
                                            }
                                            $visibleLevel3[] = $l3;
                                        }
                                        if (!empty($visibleLevel3)) {
                                            $sub['submenu'] = $visibleLevel3;
                                            $visibleSubmenu[] = $sub;
                                        }
                                    } else {
                                        $visibleSubmenu[] = $sub;
                                    }
                                }
                            }
                            
                            // Jika tidak ada submenu yang visible, skip parent
                            if (empty($visibleSubmenu)) continue;
                            
                            // Cek apakah item ini atau anaknya sedang aktif
                            $isActive = false;
                            foreach($visibleSubmenu as $sub) {
                                if (isset($sub['submenu'])) {
                                    foreach($sub['submenu'] as $subLevel3) {
                                        if(strpos($currentPath, $subLevel3['url']) === 0 && $subLevel3['url'] !== '#') { 
                                            $isActive = true; break; 
                                        }
                                    }
                                } else {
                                    if(strpos($currentPath, $sub['url']) === 0 && $sub['url'] !== '#') { 
                                        $isActive = true; break; 
                                    }
                                }
                            }
                        ?>
                        <li class="has-submenu <?= $isActive ? 'open' : '' ?>">
                            <a href="javascript:void(0)" class="sidebar-link" onclick="toggleMenu(this)">
                                <div class="icon-wrapper" style="color: <?= $iconColor ?>; background-color: <?= $iconBg ?>;">
                                    <i class="<?= $item['icon'] ?>"></i>
                                </div>
                                <span><?= $item['title'] ?></span>
                                <i class="bi bi-chevron-down arrow"></i>
                            </a>
                            
                            <ul class="submenu">
                                <?php foreach ($visibleSubmenu as $subItem): ?>
                                    <?php if(isset($subItem['submenu'])): 
                                        $isLevel3Active = false;
                                        foreach($subItem['submenu'] as $l3) {
                                            if(strpos($currentPath, $l3['url']) === 0) { $isLevel3Active = true; break; }
                                        }
                                    ?>
                                        <li class="has-submenu-level-3 <?= $isLevel3Active ? 'open' : '' ?>">
                                            <a href="javascript:void(0)" class="submenu-item" onclick="toggleLevel3(this, event)">
                                                <?= $subItem['title'] ?>
                                                <i class="bi bi-chevron-down arrow"></i>
                                            </a>
                                            <ul class="submenu-level-3">
                                                <?php foreach($subItem['submenu'] as $lvl3Item): ?>
                                                <li>
                                                    <a href="<?= $lvl3Item['url'] ?>" class="submenu-item-level-3 <?= ($currentPath === $lvl3Item['url']) ? 'active' : '' ?>">
                                                        <i class="bi bi-dot"></i> <?= $lvl3Item['title'] ?>
                                                    </a>
                                                </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </li>
                                    <?php else: ?>
                                        <li>
                                            <a href="<?= $subItem['url'] ?>" class="submenu-item <?= ($currentPath === $subItem['url']) ? 'active' : '' ?>">
                                                <?= $subItem['title'] ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </li>
    
                    <?php elseif ($item['type'] === 'item'): ?>
                        <li>
                            <a href="<?= $item['url'] ?>" class="sidebar-link <?= ($currentPath === $item['url']) ? 'active' : '' ?>">
                                <div class="icon-wrapper" style="color: <?= $iconColor ?>; background-color: <?= $iconBg ?>;">
                                    <i class="<?= $item['icon'] ?>"></i>
                                </div>
                                <span><?= $item['title'] ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
    
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="sidebar-footer">
        <a href="<?= base_url('/logout') ?>" class="logout-btn" onclick="return confirm('Yakin ingin logout?')">
            <div class="logout-icon">
                <i class="bi bi-box-arrow-right"></i>
            </div>
            <span>Logout</span>
        </a>
    </div>
</nav>


<script>
    function toggleMenu(element) {
        let parentLi = element.parentElement;
        parentLi.classList.toggle('open');
    }

    function toggleLevel3(element, event) {
        event.preventDefault();
        event.stopPropagation();
        let parentLi = element.parentElement;
        parentLi.classList.toggle('open');
    }

    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('mobile-open');
        document.getElementById('sidebarOverlay').classList.remove('show');
    }
    
    function openSidebar() {
        document.getElementById('sidebar').classList.add('mobile-open');
        document.getElementById('sidebarOverlay').classList.add('show');
    }
</script>