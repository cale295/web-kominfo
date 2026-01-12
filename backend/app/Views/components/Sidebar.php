<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<?php
// --- SETUP AWAL & SESSION ---
$session  = session();
$role     = $session->get('role') ?? 'superadmin'; 
$fullName = $session->get('full_name') ?? 'Guest User';
$avatarUrl = "https://ui-avatars.com/api/?name=" . urlencode($fullName) . "&background=6366f1&color=ffffff&bold=true&format=svg";
$uri = service('uri');
$segments = $uri->getSegments();
$currentPath = '/' . (isset($segments[0]) ? $segments[0] : 'dashboard');
if(count($segments) > 1) {
    $currentPath = '/' . implode('/', $segments);
}

// --- LOGIKA OTOMATIS INFORMASI PUBLIK DARI DATABASE ---
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
            'title' => $child['menu_name'],
            'url'   => $child['menu_url'] ?: '#',
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
                    'url'   => $gc['menu_url'],
                    'roles' => $gcRoles
                ];
            }
            $menuItem['submenu'] = $grandChildItems;
            $menuItem['url'] = '#';
        }

        // CUSTOM: Tambahan khusus untuk "Barang dan Jasa"
        if (strtolower($child['menu_name']) === 'barang dan jasa' || 
            stripos($child['menu_name'], 'barang') !== false && stripos($child['menu_name'], 'jasa') !== false) {
            $menuItem['submenu'] = [
                [
                    'title' => 'Swakelola',
                    'url' => '/ip_swakelola',
                    'roles' => ['superadmin', 'admin']
                ],
                [
                    'title' => 'Penyedia',
                    'url' => '/ip_penyedia',
                    'roles' => ['superadmin', 'admin']
                ]
            ];
            $menuItem['url'] = '#';
        }

        $dynamicInfoPublikSubmenu[] = $menuItem;
    }
}

// --- STRUKTUR MENU ---
$menuItems = [
    ['type' => 'item', 'title' => 'Dashboard', 'icon' => 'bi-speedometer2', 'url' => '/dashboard', 'roles' => ['superadmin', 'admin', 'editor'], 'color' => '#6366f1'],
    ['type' => 'item', 'title' => 'Pengaturan Menu', 'icon' => 'bi-sliders', 'url' => '/menu', 'roles' => ['superadmin'], 'color' => '#8b5cf6'],
    ['type' => 'item', 'title' => 'Banner', 'icon' => 'bi-images', 'url' => '/banner', 'roles' => ['superadmin', 'admin'], 'color' => '#06b6d4'],
    ['type' => 'item', 'title' => 'Berita', 'icon' => 'bi-newspaper', 'url' => '/berita', 'roles' => ['superadmin', 'admin', 'editor'], 'color' => '#f59e0b'],
    ['type' => 'item', 'title' => 'Galeri', 'icon' => 'bi-camera-fill', 'url' => '/album', 'roles' => ['superadmin', 'admin'], 'color' => '#ec4899'],
    [
        'type' => 'dropdown', 'title' => 'Tampilan Menu Home', 'icon' => 'bi-house-door-fill', 'roles' => ['superadmin', 'admin'], 'color' => '#10b981',
        'submenu' => [
            ['title' => 'Layanan/Service', 'url' => '/home_service', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Video Layanan', 'url' => '/home_video_layanan', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Agenda', 'url' => '/agenda', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Pengumuman', 'url' => '/pengumuman', 'roles' => ['superadmin', 'admin']],
            ['title' => 'List Pejabat Publik', 'url' => '/pejabat', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Kontak Hubungi Kami', 'url' => '/kontak', 'roles' => ['superadmin', 'admin']],
        ]
    ],
    [
        'type' => 'dropdown', 'title' => 'Halaman Profil', 'icon' => 'bi-building', 'roles' => ['superadmin', 'admin'], 'color' => '#3b82f6',
        'submenu' => [
            ['title' => 'Tentang', 'url' => '/profil_tentang', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Profil Pejabat Struktural', 'url' => '/pejabat_struktural', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Tugas & Fungsi', 'url' => '/tugas_fungsi', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Struktur Organisasi', 'url' => '/struktur_organisasi', 'roles' => ['superadmin', 'admin']],
        ]
    ],
    [
        'type' => 'dropdown', 'title' => 'Pengaturan Berita', 'icon' => 'bi-file-earmark-text', 'roles' => ['superadmin', 'admin', 'editor'], 'color' => '#f97316',
        'submenu' => [
            ['title' => 'Berita Utama', 'url' => '/berita-utama', 'roles' => ['superadmin', 'admin', 'editor']],
            ['title' => 'Kategori Berita', 'url' => '/kategori', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Tag Berita', 'url' => '/berita_tag', 'roles' => ['superadmin', 'admin']],
        ]
    ],
    ['type' => 'dropdown', 'title' => 'Informasi Publik', 'icon' => 'bi-info-circle-fill', 'roles' => ['superadmin', 'admin'], 'color' => '#14b8a6', 'submenu' => $dynamicInfoPublikSubmenu],
    [
        'type' => 'dropdown', 'title' => 'User & Akses', 'icon' => 'bi-shield-lock-fill', 'roles' => ['superadmin'], 'color' => '#ef4444',
        'submenu' => [
            ['title' => 'User', 'url' => '/manage_user', 'roles' => ['superadmin']],
            ['title' => 'Hak Akses', 'url' => '/access_rights', 'roles' => ['superadmin']],
        ]
    ],
    ['type' => 'item', 'title' => 'Profil Saya', 'icon' => 'bi-person-fill', 'url' => '/profile', 'roles' => ['superadmin', 'admin', 'editor'], 'color' => '#a855f7'],
];
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap');

    * { margin: 0; padding: 0; box-sizing: border-box; }

    #sidebar {
        width: 260px;
        height: 100vh;
        position: fixed;
        top: 0; left: 0;
        background: #fff;
        border-right: 1px solid #e5e7eb;
        z-index: 1040;
        display: flex; 
        flex-direction: column;
        font-family: 'Inter', sans-serif;
    }

    /* Brand */
    .sidebar-brand {
        height: 64px;
        display: flex; 
        align-items: center;
        padding: 0 1.25rem;
        border-bottom: 1px solid #e5e7eb;
    }
    .sidebar-brand i { 
        font-size: 1.4rem; 
        color: #6366f1; 
        margin-right: 10px; 
    }
    .sidebar-brand span { 
        font-weight: 600; 
        font-size: 1rem; 
        color: #111827; 
    }

    /* User */
    .sidebar-user {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex; 
        align-items: center;
    }
    .user-avatar { 
        width: 40px; 
        height: 40px; 
        border-radius: 8px; 
    }
    .user-info { 
        margin-left: 10px; 
        flex: 1;
    }
    .user-name { 
        font-weight: 600; 
        color: #111827; 
        font-size: 0.85rem; 
    }
    .user-role { 
        font-size: 0.7rem; 
        color: #6b7280; 
        text-transform: uppercase;
    }

    /* Menu */
    .sidebar-menu { 
        flex: 1; 
        overflow-y: auto; 
        padding: 0.5rem 0; 
    }
    .sidebar-menu::-webkit-scrollbar { width: 4px; }
    .sidebar-menu::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }
    
    .menu-list { list-style: none; }

    /* Links */
    .menu-link {
        display: flex; 
        align-items: center;
        padding: 0.65rem 1.25rem;
        color: #6b7280; 
        text-decoration: none;
        font-weight: 500; 
        font-size: 0.85rem;
        transition: all 0.2s;
        cursor: pointer;
    }

    .menu-link i.menu-icon {
        font-size: 1.1rem;
        margin-right: 10px;
        width: 18px;
    }

    .menu-link:hover { 
        background: #f9fafb; 
        color: #111827;
    }

    .menu-link.active {
        background: #eef2ff;
        color: #6366f1;
        font-weight: 600;
    }
    
    .arrow { 
        margin-left: auto; 
        font-size: 0.7rem; 
        transition: transform 0.2s; 
        color: #9ca3af; 
    }
    .has-submenu.open > .menu-link .arrow { 
        transform: rotate(180deg); 
    }

    /* Submenu */
    .submenu { 
        display: none; 
        list-style: none; 
        background: #fafafa;
    }
    .has-submenu.open > .submenu { 
        display: block; 
    }

    .submenu-link {
        display: block;
        padding: 0.55rem 1.25rem 0.55rem 3rem;
        text-decoration: none; 
        color: #6b7280;
        font-size: 0.8rem; 
        font-weight: 500;
        transition: all 0.2s;
        position: relative;
    }

    .submenu-link::before {
        content: '•'; 
        position: absolute; 
        left: 2rem; 
        color: #d1d5db; 
    }

    .submenu-link:hover { 
        color: #111827; 
        background: #f3f4f6;
    }

    .submenu-link.active { 
        color: #6366f1; 
        background: #eef2ff;
        font-weight: 600;
    }

    /* Level 3 */
    .has-submenu-level-3 > .submenu-link .arrow {
        position: absolute;
        right: 1rem;
        transform: rotate(-90deg);
    }
    .has-submenu-level-3.open > .submenu-link .arrow {
        transform: rotate(0deg); 
    }
    
    .submenu-level-3 {
        display: none;
    }
    .has-submenu-level-3.open > .submenu-level-3 {
        display: block;
    }
    
    .submenu-link-level-3 {
        display: block;
        padding: 0.5rem 1.25rem 0.5rem 4rem; 
        text-decoration: none; 
        color: #6b7280;
        font-size: 0.75rem; 
        font-weight: 500;
        transition: all 0.2s;
    }
    .submenu-link-level-3:hover { 
        color: #111827; 
        background: #f3f4f6;
    }
    .submenu-link-level-3.active { 
        color: #6366f1; 
        font-weight: 600;
    }

    /* Footer */
    .sidebar-footer { 
        padding: 1rem 1.25rem; 
        border-top: 1px solid #e5e7eb; 
    }
    .logout-btn { 
        background: #fef2f2;
        color: #dc2626; 
        padding: 0.6rem;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.2s;
    }
    .logout-btn i {
        margin-right: 6px;
    }
    .logout-btn:hover { 
        background: #fee2e2;
    }

    /* Mobile */
    .sidebar-overlay { 
        display: none; 
        position: fixed; 
        top: 0; left: 0; 
        width: 100%; height: 100%; 
        background: rgba(0,0,0,0.5); 
        z-index: 1030; 
    }
    
    @media (max-width: 768px) {
        #sidebar { transform: translateX(-100%); transition: transform 0.3s; }
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

    <div class="sidebar-user">
        <img src="<?= $avatarUrl ?>" alt="User" class="user-avatar">
        <div class="user-info">
            <div class="user-name"><?= esc($fullName) ?></div>
            <div class="user-role"><?= esc($role) ?></div>
        </div>
    </div>

    <div class="sidebar-menu">
        <ul class="menu-list">
            <?php foreach ($menuItems as $item): ?>
                <?php 
                if (isset($item['roles']) && !in_array($role, $item['roles'])) continue; 
                $iconColor = $item['color'] ?? '#6b7280';
                ?>

                <?php if ($item['type'] === 'dropdown'): ?>
                    <?php 
                        $isSubActive = false;
                        if(isset($item['submenu'])) {
                            foreach($item['submenu'] as $sub) {
                                if (isset($sub['submenu'])) {
                                    foreach($sub['submenu'] as $l3) {
                                        if(strpos($currentPath, $l3['url']) === 0) { $isSubActive = true; break; }
                                    }
                                } else {
                                    if(strpos($currentPath, $sub['url']) === 0) { $isSubActive = true; break; }
                                }
                            }
                        }
                    ?>
                    <li class="has-submenu <?= $isSubActive ? 'open' : '' ?>">
                        <a href="javascript:void(0)" class="menu-link <?= $isSubActive ? 'active' : '' ?>" onclick="toggleMenu(this)">
                            <i class="<?= $item['icon'] ?> menu-icon" style="color: <?= $iconColor ?>;"></i>
                            <span><?= $item['title'] ?></span>
                            <i class="bi bi-chevron-down arrow"></i>
                        </a>
                        
                        <ul class="submenu">
                            <?php if(isset($item['submenu'])): ?>
                                <?php foreach ($item['submenu'] as $subItem): ?>
                                    <?php if (in_array($role, $subItem['roles'])): ?>
                                        
                                        <?php if(isset($subItem['submenu'])): 
                                            $isLevel3Active = false;
                                            foreach($subItem['submenu'] as $l3) {
                                                if(strpos($currentPath, $l3['url']) === 0) { $isLevel3Active = true; break; }
                                            }
                                        ?>
                                            <li class="has-submenu-level-3 <?= $isLevel3Active ? 'open' : '' ?>">
                                                <a href="javascript:void(0)" class="submenu-link <?= $isLevel3Active ? 'active' : '' ?>" onclick="toggleLevel3(this, event)">
                                                    <?= $subItem['title'] ?>
                                                    <i class="bi bi-chevron-down arrow"></i>
                                                </a>
                                                <ul class="submenu-level-3">
                                                    <?php foreach($subItem['submenu'] as $lvl3Item): ?>
                                                        <?php if (in_array($role, $lvl3Item['roles'])): ?>
                                                        <li>
                                                            <a href="<?= $lvl3Item['url'] ?>" class="submenu-link-level-3 <?= ($currentPath === $lvl3Item['url']) ? 'active' : '' ?>">
                                                                <?= $lvl3Item['title'] ?>
                                                            </a>
                                                        </li>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </li>
                                        <?php else: ?>
                                            <li>
                                                <a href="<?= $subItem['url'] ?>" class="submenu-link <?= ($currentPath === $subItem['url']) ? 'active' : '' ?>">
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
                        <a href="<?= $item['url'] ?>" class="menu-link <?= ($currentPath === $item['url']) ? 'active' : '' ?>">
                            <i class="<?= $item['icon'] ?> menu-icon" style="color: <?= $iconColor ?>;"></i>
                            <span><?= $item['title'] ?></span>
                        </a>
                    </li>
                <?php endif; ?>

            <?php endforeach; ?>
        </ul>
    </div>

    <div class="sidebar-footer">
        <a href="/logout" class="logout-btn">
            <i class="bi bi-box-arrow-right"></i>
            <span>Keluar</span>
        </a>
    </div>
</nav>

<script>
function toggleMenu(element) {
    const parent = element.closest('li.has-submenu');
    if (parent) {
        const allMenus = document.querySelectorAll('li.has-submenu');
        allMenus.forEach(menu => {
            if (menu !== parent) menu.classList.remove('open');
        });
        parent.classList.toggle('open');
    }
}

function toggleLevel3(element, event) {
    event.stopPropagation(); 
    event.preventDefault();  
    const parent = element.closest('li.has-submenu-level-3');
    if (parent) parent.classList.toggle('open');
}

function openSidebar() {
    document.getElementById('sidebar').classList.add('mobile-open');
    document.getElementById('sidebarOverlay').classList.add('show');
}

function closeSidebar() {
    document.getElementById('sidebar').classList.remove('mobile-open');
    document.getElementById('sidebarOverlay').classList.remove('show');
}

document.addEventListener("DOMContentLoaded", function() {
    const activeItem = document.querySelector('.submenu-link.active') || 
                       document.querySelector('.menu-link.active') || 
                       document.querySelector('.submenu-link-level-3.active');
    
    if (activeItem) {
        const level3Parent = activeItem.closest('.has-submenu-level-3');
        if(level3Parent) level3Parent.classList.add('open');

        const level1Parent = activeItem.closest('.has-submenu');
        if(level1Parent) level1Parent.classList.add('open');

        setTimeout(() => {
            activeItem.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 200);
    }
});
</script>