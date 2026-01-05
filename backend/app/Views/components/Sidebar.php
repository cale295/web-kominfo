<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<?php

$session  = session();
$role     = $session->get('role') ?? 'superadmin'; 
$fullName = $session->get('full_name') ?? 'Guest User';
$avatarUrl = "https://ui-avatars.com/api/?name=" . urlencode($fullName) . "&background=3b82f6&color=ffffff&bold=true&format=svg";
$uri = service('uri');
$segments = $uri->getSegments();
$currentPath = '/' . (isset($segments[0]) ? $segments[0] : 'dashboard');
if(count($segments) > 1) {
    $currentPath = '/' . implode('/', $segments);
}

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
                      : ['superadmin', 'admin']; // Default role jika kosong

        $menuItem = [
    'title' => $child['menu_name'],
    'url'   => $child['menu_url'] 
                ? site_url($child['menu_url']) 
                : '#',
    'roles' => $childRoles
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
    'title' => $gc['menu_name'],
    'url'   => site_url($gc['menu_url']),
    'roles' => $gcRoles
];

            }
   
            $menuItem['submenu'] = $grandChildItems;
            $menuItem['url'] = '#';
        }

        $dynamicInfoPublikSubmenu[] = $menuItem;
    }
}
// --------------------------------------------------------


$menuItems = [
   [
        'type' => 'item', 
        'title' => 'Dashboard', 
        'icon' => 'bi-speedometer2',
        'url' => '/dashboard', 
        'roles' => ['superadmin', 'admin', 'editor'],
        'color' => '#4e73df', 
        'bg' => 'rgba(78, 115, 223, 0.1)' 
    ],
    [
        'type' => 'item', 
        'title' => 'Pengaturan Menu', 
        'icon' => 'bi-gear-fill', 
        'url' => '/menu', 
        'roles' => ['superadmin'],
        'color' => '#4e73df', 
        'bg' => 'rgba(78, 115, 223, 0.1)' 
    ],
    ['type' => 'header', 'title' => 'BANNER & LAYANAN'],
    [
        'type' => 'dropdown', 
        'title' => 'Tampil Home', 
        'icon' => 'bi-laptop', 
        'roles' => ['superadmin', 'admin'],
        'color' => '#6610f2', 
        'bg' => 'rgba(102, 16, 242, 0.1)',
        'submenu' => [
            ['title' => 'Banner Slider', 'url' => '/banner', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Layanan', 'url' => '/home_service', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Video Layanan', 'url' => '/home_video_layanan', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Agenda', 'url' => '/agenda', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Pengumuman', 'url' => '/pengumuman', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Pejabat Publik', 'url' => '/pejabat', 'roles' => ['superadmin', 'admin']],
        ]
    ],
    ['type' => 'header', 'title' => 'BERITA'],
    [
        'type' => 'dropdown', 
        'title' => 'Manajemen Berita', 
        'icon' => 'bi-newspaper', 
        'roles' => ['superadmin', 'admin', 'editor'],
        'color' => '#e74a3b', 
        'bg' => 'rgba(231, 74, 59, 0.1)',
        'submenu' => [
            ['title' => 'Berita', 'url' => '/berita', 'roles' => ['superadmin', 'admin', 'editor']],
            ['title' => 'Berita Utama', 'url' => '/berita-utama', 'roles' => ['superadmin', 'admin', 'editor']],
            ['title' => 'Kategori', 'url' => '/kategori', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Tag', 'url' => '/berita_tag', 'roles' => ['superadmin', 'admin']],
        ]
    ],
    ['type' => 'header', 'title' => 'ProGRAM SKPD'],
    [
        'type' => 'dropdown', 
        'title' => 'Program SKPD', 
        'icon' => 'bi-journal-bookmark-fill', 
        'roles' => ['superadmin', 'admin'],
        'color' => '#f6c23e', 
        'bg' => 'rgba(246, 194, 62, 0.1)',
        'submenu' => [
            ['title' => 'Program SKPD', 'url' => '/program', 'roles' => ['superadmin', 'admin']],
        ]
    ],
    ['type' => 'header', 'title' => 'HALAMAN PUBLIK'],
    [
        'type' => 'dropdown', 
        'title' => 'Profil Instansi', 
        'icon' => 'bi-building', 
        'roles' => ['superadmin', 'admin'],
        'color' => '#36b9cc', 
        'bg' => 'rgba(54, 185, 204, 0.1)',
        'submenu' => [
            ['title' => 'Profil Tentang', 'url' => '/profil_tentang', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Tugas & Fungsi', 'url' => '/tugas_fungsi', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Struktur Pejabat', 'url' => '/pejabat_struktural', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Struktur Organisasi', 'url' => '/struktur_organisasi', 'roles' => ['superadmin', 'admin']],
        ]
    ],
    // --- DISINI BAGIAN INFORMASI PUBLIK YG OTOMATIS ---
    [
        'type' => 'dropdown', 
        'title' => 'Informasi Publik', 
        'icon' => 'bi-info-circle', 
        'roles' => ['superadmin', 'admin'],
        'color' => '#1cc88a', 
        'bg' => 'rgba(28, 200, 138, 0.1)',
        'submenu' => $dynamicInfoPublikSubmenu // <--- MENGGUNAKAN VARIABEL DB
    ],
    // --------------------------------------------------
    [
        'type' => 'dropdown', 
        'title' => 'Galeri & Media', 
        'icon' => 'bi-images', 
        'roles' => ['superadmin', 'admin'],
        'color' => '#f6c23e', 
        'bg' => 'rgba(246, 194, 62, 0.1)',
        'submenu' => [
            ['title' => 'Album Foto', 'url' => '/album', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Foto Galeri', 'url' => '/gallery', 'roles' => ['superadmin', 'admin']],
        ]
    ],
    [
        'type' => 'dropdown', 
        'title' => 'Kontak', 
        'icon' => 'bi-telephone', 
        'roles' => ['superadmin', 'admin'],
        'color' => '#fd7e14', 
        'bg' => 'rgba(253, 126, 20, 0.1)',
        'submenu' => [
            ['title' => 'Info Kontak', 'url' => '/kontak', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Layanan Kontak', 'url' => '/kontak_layanan', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Sosial Media', 'url' => '/kontak_social', 'roles' => ['superadmin', 'admin']],
        ]
    ],
    [
        'type' => 'dropdown', 
        'title' => 'Footer', 
        'icon' => 'bi-layout-text-window', 
        'roles' => ['superadmin', 'admin'],
        'color' => '#20c997', 
        'bg' => 'rgba(32, 201, 151, 0.1)',
        'submenu' => [
            ['title' => 'Pengaturan Footer', 'url' => '/footer_opd', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Footer Sosial Media', 'url' => '/footer_social', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Pengunjung', 'url' => '/footer_statistics', 'roles' => ['superadmin', 'admin']],
        ]
    ],
    ['type' => 'header', 'title' => 'SYSTEM SETTINGS'],
    [
        'type' => 'dropdown', 
        'title' => 'Users & Akses', 
        'icon' => 'bi-gear', 
        'roles' => ['superadmin'],
        'color' => '#858796', 
        'bg' => 'rgba(133, 135, 150, 0.1)',
        'submenu' => [
            ['title' => 'Manajemen User', 'url' => '/manage_user', 'roles' => ['superadmin']],
            ['title' => 'Hak Akses', 'url' => '/access_rights', 'roles' => ['superadmin']],
        ]
    ],
    [
        'type' => 'item', 
        'title' => 'Profil Saya', 
        'icon' => 'bi-person-circle', 
        'url' => '/profile', 
        'roles' => ['superadmin', 'admin', 'editor'],
        'color' => '#4e73df', 
        'bg' => 'rgba(78, 115, 223, 0.1)'
    ]
];
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    :root {
        --sb-width: 280px;
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

    /* Layout Sidebar */
    #sidebar {
        width: var(--sb-width);
        height: 100vh;
        position: fixed;
        top: 0; left: 0;
        background: var(--sb-bg);
        border-right: 1px solid var(--border);
        z-index: 1040;
        display: flex; flex-direction: column;
        font-family: 'Inter', sans-serif;
        transition: transform 0.3s ease;
        box-shadow: 4px 0 24px rgba(0,0,0,0.02);
    }

    /* Brand Header */
    .sidebar-brand {
        height: 70px;
        display: flex; align-items: center;
        padding: 0 1.5rem;
        border-bottom: 1px solid var(--border);
        background: #ffffff;
    }
    .sidebar-brand i { font-size: 1.5rem; color: var(--primary); margin-right: 10px; }
    .sidebar-brand span { font-weight: 700; font-size: 1.1rem; color: #1e293b; letter-spacing: -0.5px; }

    /* User Profile Card */
    .sidebar-user-card {
        padding: 1rem; margin: 1rem 0.75rem;
        background: #f8fafc; 
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        display: flex; align-items: center;
    }
    .user-avatar { width: 42px; height: 42px; border-radius: 10px; border: 2px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
    .user-details { margin-left: 12px; overflow: hidden; flex: 1; }
    .user-name { font-weight: 600; color: #334155; font-size: 0.85rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .user-role { font-size: 0.7rem; color: var(--primary); text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; }

    
    .sidebar-menu-wrapper { flex: 1; overflow-y: auto; padding: 0 0 1rem 0; }
    .sidebar-menu-wrapper::-webkit-scrollbar { width: 5px; }
    .sidebar-menu-wrapper::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .menu-list { list-style: none; }

    /* Section Header */
    .menu-header {
        font-size: 0.7rem; font-weight: 700; color: var(--sb-header);
        text-transform: uppercase; margin: 1.25rem 0 0.5rem 1.5rem; letter-spacing: 0.5px;
    }

    /* Main Links */
    .sidebar-link {
        display: flex; align-items: center;
        padding: 0.6rem 0.75rem;
        color: var(--sb-text); text-decoration: none;
        font-weight: 500; font-size: 0.875rem;
        transition: all 0.2s ease;
        margin: 0 0.75rem 0.25rem 0.75rem;
        border-radius: 10px; cursor: pointer;
    }

    .icon-wrapper {
        width: 34px; height: 34px;
        min-width: 34px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 8px;
        margin-right: 12px;
        transition: all 0.2s ease;
        font-size: 1.1rem;
    }

    .sidebar-link:hover { background: var(--hover-bg); color: var(--sb-text-active); }
    .sidebar-link:hover .icon-wrapper { transform: scale(1.05); }

    .sidebar-link.active, .has-submenu.open > .sidebar-link {
        background: var(--active-bg);
        color: var(--sb-text-active);
        font-weight: 600;
    }
    
    .arrow { margin-left: auto; font-size: 0.75rem; transition: transform 0.3s ease; color: #94a3b8; }
    .has-submenu.open > .sidebar-link .arrow { transform: rotate(180deg); color: var(--sb-text-active); }

    
    .submenu { display: none; list-style: none; padding: 0.25rem 0; animation: slideDown 0.2s ease forwards; }
    .has-submenu.open > .submenu { display: block; }

    .submenu-item {
        display: flex; align-items: center;
        padding: 0.6rem 1rem 0.6rem 3.8rem;
        text-decoration: none; color: var(--sb-text);
        font-size: 0.85rem; font-weight: 500;
        margin: 0 0.75rem 0.15rem 0.75rem;
        border-radius: 8px; position: relative;
    }

    .submenu-item::before {
        content: ''; position: absolute; left: 2.25rem; top: 50%;
        transform: translateY(-50%); width: 5px; height: 5px;
        background: #cbd5e1; border-radius: 50%; transition: all 0.2s;
    }

    .submenu-item:hover { color: var(--sb-text-active); background: var(--hover-bg); }
    .submenu-item:hover::before { background: var(--primary); transform: translateY(-50%) scale(1.2); }

    .submenu-item.active { color: var(--primary); background: white; font-weight: 600; box-shadow: 0 2px 4px rgba(0,0,0,0.03); }
    .submenu-item.active::before { background: var(--primary); width: 7px; height: 7px; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15); }

    
    .has-submenu-level-3 > .submenu-item .arrow {
        transform: rotate(-90deg);
    }
    .has-submenu-level-3.open > .submenu-item .arrow {
        transform: rotate(0deg); 
    }
    
    .submenu-level-3 {
        display: none;
        list-style: none;
        padding: 0;
        animation: slideDown 0.2s ease forwards;
    }
    .has-submenu-level-3.open > .submenu-level-3 {
        display: block;
    }
    
    .submenu-item-level-3 {
        display: flex; align-items: center;
        padding: 0.5rem 1rem 0.5rem 4.8rem; 
        text-decoration: none; color: var(--sb-text);
        font-size: 0.8rem; 
        font-weight: 500;
        margin: 0 0.75rem 0.15rem 0.75rem;
        border-radius: 8px;
    }
    .submenu-item-level-3:hover { color: var(--sb-text-active); background: var(--hover-bg); }
    .submenu-item-level-3.active { color: var(--primary); font-weight: 700; background: rgba(59, 130, 246, 0.05); }

    @keyframes slideDown { from { opacity: 0; transform: translateY(-5px); } to { opacity: 1; transform: translateY(0); } }

    /* Footer */
    .sidebar-footer { padding: 1rem; border-top: 1px solid var(--border); background: #ffffff; }
    .logout-btn { 
        background: #fff5f5; color: var(--danger); 
        border: 1px solid #ffecec; justify-content: center; font-weight: 600;
    }
    .logout-btn:hover { background: #fee2e2; border-color: #fecaca; }

    /* Mobile */
    .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); z-index: 1030; backdrop-filter: blur(2px); }
    @media (max-width: 768px) {
        #sidebar { transform: translateX(-100%); }
        #sidebar.mobile-open { transform: translateX(0); }
        .sidebar-overlay.show { display: block; }
    }
</style>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<nav id="sidebar">
    <div class="sidebar-brand">
        <i class="bi bi-shield-lock-fill"></i>
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
        <ul class="menu-list">
            <?php foreach ($menuItems as $item): ?>
                <?php 
                if (isset($item['roles']) && !in_array($role, $item['roles'])) continue;
                $iconColor = $item['color'] ?? '#64748b';
                $iconBg    = $item['bg'] ?? 'rgba(100, 116, 139, 0.1)';
                ?>

                <?php if ($item['type'] === 'header'): ?>
                    <li class="menu-header"><?= $item['title'] ?></li>
                
                <?php elseif ($item['type'] === 'dropdown'): ?>
                    <?php 
                        // Deteksi Aktif: Periksa level 2 dan level 3
                        $isSubActive = false;
                        if(isset($item['submenu']) && is_array($item['submenu'])) {
                            foreach($item['submenu'] as $sub) {
                                if (isset($sub['submenu'])) {
                                    // Cek Level 3
                                    foreach($sub['submenu'] as $subLevel3) {
                                        if(strpos($currentPath, $subLevel3['url']) === 0) { $isSubActive = true; break; }
                                    }
                                } else {
                                    // Cek Level 2 Biasa
                                    if(strpos($currentPath, $sub['url']) === 0) { $isSubActive = true; break; }
                                }
                            }
                        }
                    ?>
                    <li class="has-submenu <?= $isSubActive ? 'open' : '' ?>">
                        <a href="javascript:void(0)" class="sidebar-link" onclick="toggleMenu(this)">
                            <div class="icon-wrapper" style="color: <?= $iconColor ?>; background-color: <?= $iconBg ?>;">
                                <i class="<?= $item['icon'] ?>"></i>
                            </div>
                            <span><?= $item['title'] ?></span>
                            <i class="bi bi-chevron-down arrow"></i>
                        </a>
                        
                        <ul class="submenu">
                            <?php if(isset($item['submenu']) && is_array($item['submenu'])): ?>
                                <?php foreach ($item['submenu'] as $subItem): ?>
                                    <?php if (in_array($role, $subItem['roles'])): ?>
                                        
                                        <?php if(isset($subItem['submenu'])): 
                                            // Cek aktif untuk level 3
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
                                                        <?php if (in_array($role, $lvl3Item['roles'])): ?>
                                                        <li>
                                                            <a href="<?= $lvl3Item['url'] ?>" class="submenu-item-level-3 <?= ($currentPath === $lvl3Item['url']) ? 'active' : '' ?>">
                                                                <i class="bi bi-dot"></i> <?= $lvl3Item['title'] ?>
                                                            </a>
                                                        </li>
                                                        <?php endif; ?>
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

                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
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

    <div class="sidebar-footer">
        <a href="/logout" class="sidebar-link logout-btn">
            <i class="bi bi-box-arrow-right"></i>
            <span>Keluar Sistem</span>
        </a>
    </div>
</nav>

<script>
function toggleMenu(element) {
    const parentListItem = element.closest('li.has-submenu');
    
    if (parentListItem) {
        // Tutup menu Level 1 lain
        const allMenus = document.querySelectorAll('li.has-submenu');
        allMenus.forEach(menu => {
            if (menu !== parentListItem && menu.classList.contains('open')) {
                menu.classList.remove('open');
            }
        });
        parentListItem.classList.toggle('open');
    }
}


function toggleLevel3(element, event) {
    event.stopPropagation(); 
    event.preventDefault();  

    const parentListItem = element.closest('li.has-submenu-level-3');
    if (parentListItem) {
        parentListItem.classList.toggle('open');
    }
}

function openSidebar() {
    document.getElementById('sidebar').classList.add('mobile-open');
    document.getElementById('sidebarOverlay').classList.add('show');
}

function closeSidebar() {
    document.getElementById('sidebar').classList.remove('mobile-open');
    document.getElementById('sidebarOverlay').classList.remove('show');
}

// Auto Scroll ke menu aktif
document.addEventListener("DOMContentLoaded", function() {
    const activeItem = document.querySelector('.submenu-item.active') || 
                       document.querySelector('.sidebar-link.active') || 
                       document.querySelector('.submenu-item-level-3.active');
    
    if (activeItem) {
        // Jika ada di dalam level 3, pastikan parent (Level 2 & 1) terbuka
        const level3Parent = activeItem.closest('.has-submenu-level-3');
        if(level3Parent) level3Parent.classList.add('open');

        const level1Parent = activeItem.closest('.has-submenu');
        if(level1Parent) level1Parent.classList.add('open');

        setTimeout(() => {
            activeItem.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 300);
    }
});
</script>