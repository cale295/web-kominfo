<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php
/**
 * ==========================================
 * 1. SETUP SESSION
 * ==========================================
 */
$session  = session();
$role     = $session->get('role') ?? 'superadmin'; 
$fullName = $session->get('full_name') ?? 'Administrator';
// Avatar generator
$avatarUrl = "https://ui-avatars.com/api/?name=" . urlencode($fullName) . "&background=e2e8f0&color=475569&bold=true&format=svg";

// URI Detection untuk penanda menu aktif
$uri = service('uri');
$segments = $uri->getSegments();
$currentPath = '/' . (isset($segments[0]) ? $segments[0] : 'dashboard');
if(count($segments) > 1) {
    $currentPath = '/' . implode('/', $segments);
}

/**
 * ==========================================
 * 2. LOGIKA OTOMATIS INFORMASI PUBLIK DARI DATABASE
 * ==========================================
 */
$menuModel = new \App\Models\MenuModel(); 

// 1. Cari Parent Menu "Informasi Publik"
$parentInfoPublik = $menuModel->where('menu_name', 'Informasi Publik')->first();
$dynamicInfoPublikSubmenu = [];

if ($parentInfoPublik) {
    // 2. Ambil anak-anaknya (Level 2)
    $children = $menuModel->where('parent_id', $parentInfoPublik['id_menu'])
                          ->where('status', 'active')
                          ->orderBy('order_number', 'ASC')
                          ->findAll();

    foreach ($children as $child) {
        // Parsing roles dari string "admin,editor" ke array
        $childRoles = !empty($child['allowed_roles']) 
                      ? array_map('trim', explode(',', $child['allowed_roles'])) 
                      : ['superadmin', 'admin']; // Default role jika kosong

        $menuItem = [
            'title' => $child['menu_name'],
            'url'   => $child['menu_url'] ?: '#',
            'roles' => $childRoles
        ];

        // 3. Cek apakah punya anak lagi? (Level 3 - Contoh: Pengadaan Barang -> Swakelola)
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
            // Jika ada submenu, set submenu array dan url jadi #
            $menuItem['submenu'] = $grandChildItems;
            $menuItem['url'] = '#';
        }

        $dynamicInfoPublikSubmenu[] = $menuItem;
    }
}

/**
 * ==========================================
 * 3. STRUKTUR MENU BARU (DENGAN INFORMASI PUBLIK)
 * ==========================================
 */
$menuItems = [
    // --- ITEM: DASHBOARD ---
    [
        'type'  => 'item', 
        'title' => 'Dashboard', 
        'icon'  => 'bi-speedometer2',
        'url'   => '/dashboard', 
        'roles' => ['superadmin', 'admin', 'editor'],
        'color' => '#4361ee', 
        'bg'    => 'rgba(67, 97, 238, 0.1)' 
    ],
    // --- ITEM: PENGATURAN MENU ---
    [
        'type'  => 'item', 
        'title' => 'Pengaturan Menu', 
        'icon'  => 'bi-gear-fill', 
        'url'   => '/menu', 
        'roles' => ['superadmin'],
        'color' => '#3a0ca3', 
        'bg'    => 'rgba(58, 12, 163, 0.1)' 
    ],
    // --- ITEM: BANNER ---
    [
        'type'  => 'item', 
        'title' => 'Banner', 
        'icon'  => 'bi-aspect-ratio',
        'url'   => '/banner', 
        'roles' => ['superadmin', 'admin'],
        'color' => '#7209b7', 
        'bg'    => 'rgba(114, 9, 183, 0.1)' 
    ],
    // --- ITEM: BERITA (LIST) ---
    [
        'type'  => 'item', 
        'title' => 'Berita', 
        'icon'  => 'bi-newspaper', 
        'url'   => '/berita', 
        'roles' => ['superadmin', 'admin', 'editor'],
        'color' => '#e74a3b', 
        'bg'    => 'rgba(231, 74, 59, 0.1)' 
    ],
    // --- ITEM: GALERI ---
    [
        'type'  => 'item', 
        'title' => 'Galeri', 
        'icon'  => 'bi-images', 
        'url'   => '/album', 
        'roles' => ['superadmin', 'admin'],
        'color' => '#f6c23e', 
        'bg'    => 'rgba(246, 194, 62, 0.1)' 
    ],

    // --- SEPARATOR ---
    ['type' => 'header', 'title' => 'PENGATURAN HALAMAN'],

    // --- DROPDOWN: TAMPILAN MENU HOME ---
    [
        'type'    => 'dropdown', 
        'title'   => 'Tampilan Menu Home', 
        'icon'    => 'bi-laptop', 
        'roles'   => ['superadmin', 'admin'],
        'color'   => '#36b9cc',
        'bg'      => 'rgba(54, 185, 204, 0.1)',
        'submenu' => [
            ['title' => 'Layanan/Service', 'url' => '/home_service', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Video Layanan', 'url' => '/home_video_layanan', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Agenda', 'url' => '/agenda', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Pengumuman', 'url' => '/pengumuman', 'roles' => ['superadmin', 'admin']],
            ['title' => 'List Pejabat Public', 'url' => '/pejabat', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Kontak Hubungi Kami', 'url' => '/kontak', 'roles' => ['superadmin', 'admin']],
        ]
    ],

    // --- DROPDOWN: HAL PROFIL ---
    [
        'type'    => 'dropdown', 
        'title'   => 'Hal Profil', 
        'icon'    => 'bi-building-check', 
        'roles'   => ['superadmin', 'admin'],
        'color'   => '#1cc88a',
        'bg'      => 'rgba(28, 200, 138, 0.1)',
        'submenu' => [
            ['title' => 'Tentang', 'url' => '/profil_tentang', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Profil Pejabat Struktural', 'url' => '/pejabat_struktural', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Tugas & Fungsi', 'url' => '/tugas_fungsi', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Struktur Organisasi', 'url' => '/struktur_organisasi', 'roles' => ['superadmin', 'admin']],
        ]
    ],
    
    // --- DROPDOWN: PENGATURAN BERITA ---
    [
        'type'    => 'dropdown', 
        'title'   => 'Pengaturan Berita', 
        'icon'    => 'bi-sliders', 
        'roles'   => ['superadmin', 'admin', 'editor'],
        'color'   => '#fd7e14',
        'bg'      => 'rgba(253, 126, 20, 0.1)',
        'submenu' => [
            ['title' => 'Berita Utama', 'url' => '/berita-utama', 'roles' => ['superadmin', 'admin', 'editor']],
            ['title' => 'Kategori Berita', 'url' => '/kategori', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Tag Berita', 'url' => '/berita_tag', 'roles' => ['superadmin', 'admin']],
        ]
    ],

    // --- DROPDOWN: INFORMASI PUBLIK (DINAMIS DARI DATABASE) ---
    [
        'type'    => 'dropdown', 
        'title'   => 'Informasi Publik', 
        'icon'    => 'bi-info-circle', 
        'roles'   => ['superadmin', 'admin'],
        'color'   => '#1cc88a', 
        'bg'      => 'rgba(28, 200, 138, 0.1)',
        'submenu' => $dynamicInfoPublikSubmenu // <--- MENGGUNAKAN VARIABEL DB
    ],

    // --- DROPDOWN: PENGATURAN FOOTER ---
    [
        'type' => 'dropdown', 
        'title' => 'Pengaturan Footer', 
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
    
    // --- DROPDOWN: USER & AKSES ---
    [
        'type'    => 'dropdown', 
        'title'   => 'User & Akses', 
        'icon'    => 'bi-shield-lock', 
        'roles'   => ['superadmin'],
        'color'   => '#858796',
        'bg'      => 'rgba(133, 135, 150, 0.1)',
        'submenu' => [
            ['title' => 'User', 'url' => '/manage_user', 'roles' => ['superadmin']],
            ['title' => 'Hak Akses', 'url' => '/access_rights', 'roles' => ['superadmin']],
        ]
    ],

    // --- ITEM: PROFIL SAYA ---
    [
        'type'  => 'item', 
        'title' => 'Profil Saya', 
        'icon'  => 'bi-person-circle', 
        'url'   => '/profile', 
        'roles' => ['superadmin', 'admin', 'editor'],
        'color'   => '#4e73df',
        'bg'      => 'rgba(78, 115, 223, 0.1)'
    ]
];
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    :root {
        --sb-width: 270px;
        --sb-bg: #ffffff;
        --sb-text: #64748b;         
        --sb-text-hover: #0f172a;   
        --sb-border: #f1f5f9;       
        --primary: #4e73df;
        --radius: 10px;
        --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * { box-sizing: border-box; }
    
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #f8fafc;
        margin: 0; padding: 0;
    }

    /* --- SIDEBAR --- */
    #sidebar {
        width: var(--sb-width);
        height: 100vh;
        position: fixed;
        top: 0; left: 0;
        background: var(--sb-bg);
        border-right: 1px solid var(--sb-border);
        display: flex;
        flex-direction: column;
        z-index: 1040;
        transition: transform 0.3s ease;
        box-shadow: 4px 0 24px rgba(0,0,0,0.015);
    }

    /* --- BRAND --- */
    .sidebar-brand {
        height: 70px;
        display: flex; align-items: center;
        padding: 0 1.5rem;
        font-weight: 800;
        font-size: 1.25rem;
        color: #0f172a;
        letter-spacing: -0.5px;
    }
    .brand-dot {
        width: 10px; height: 10px;
        background: var(--primary);
        border-radius: 50%;
        margin-right: 10px;
        box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.15);
    }

    /* --- USER CARD --- */
    .user-card {
        padding: 1rem 1.5rem;
        display: flex; align-items: center; gap: 12px;
        border-bottom: 1px solid var(--sb-border);
        margin-bottom: 10px;
    }
    .user-avatar {
        width: 40px; height: 40px; border-radius: 10px; object-fit: cover;
    }
    .user-info h6 { margin: 0; font-size: 0.9rem; font-weight: 700; color: #1e293b; }
    .user-info span { font-size: 0.75rem; color: #94a3b8; font-weight: 500; text-transform: uppercase; }

    /* --- CONTENT --- */
    .sidebar-content {
        flex: 1;
        overflow-y: auto;
        padding: 0 1rem 2rem 1rem;
    }
    .sidebar-content::-webkit-scrollbar { width: 4px; }
    .sidebar-content::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 4px; }

    ul { list-style: none; padding: 0; margin: 0; }
    
    .menu-header {
        font-size: 0.7rem; text-transform: uppercase;
        letter-spacing: 0.8px; color: #94a3b8;
        font-weight: 700;
        margin: 1.5rem 0 0.5rem 0.75rem;
    }

    /* --- LINKS --- */
    .nav-link {
        display: flex; align-items: center;
        padding: 0.7rem 0.75rem;
        margin-bottom: 4px;
        color: var(--sb-text);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        border-radius: var(--radius);
        transition: var(--transition);
        cursor: pointer;
        position: relative;
    }

    .nav-icon {
        width: 32px; height: 32px; min-width: 32px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 8px; margin-right: 12px;
        font-size: 1.1rem;
        transition: var(--transition);
    }

    .nav-arrow {
        margin-left: auto; font-size: 0.75rem;
        transition: transform 0.3s ease; opacity: 0.5;
    }

    /* Hover */
    .nav-link:hover { background: #f1f5f9; color: var(--sb-text-hover); }
    
    /* Active / Open */
    .nav-link.active,
    .nav-item.open > .nav-link {
        background: #fff; font-weight: 600; color: #0f172a;
    }
    .nav-item.open > .nav-link .nav-arrow { transform: rotate(180deg); opacity: 1; }

    /* --- SUBMENU LEVEL 2 --- */
    .submenu {
        display: none; padding-left: 0; margin-top: 2px; overflow: hidden;
    }
    .nav-item.open > .submenu { display: block; animation: slideDown 0.25s ease forwards; }

    .sub-link {
        display: flex; align-items: center;
        padding: 0.6rem 1rem 0.6rem 3.5rem;
        font-size: 0.85rem; color: #64748b;
        text-decoration: none; font-weight: 500;
        border-radius: var(--radius); margin-bottom: 2px;
        position: relative; transition: var(--transition);
    }
    
    .sub-link::before {
        content: ''; position: absolute;
        left: 2rem; top: 50%; transform: translateY(-50%);
        width: 6px; height: 6px; border-radius: 50%;
        background: #cbd5e1; transition: var(--transition);
    }

    .sub-link:hover { color: #0f172a; background: #f8fafc; }
    .sub-link:hover::before { background: var(--primary); transform: translateY(-50%) scale(1.2); }

    .sub-link.active { color: var(--primary); font-weight: 600; background: #fff; }
    .sub-link.active::before { background: var(--primary); box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.15); }

    /* --- SUBMENU LEVEL 3 (untuk Informasi Publik dengan nested menu) --- */
    .sub-item-with-children > .sub-link .nav-arrow {
        transform: rotate(-90deg);
    }
    .sub-item-with-children.open > .sub-link .nav-arrow {
        transform: rotate(0deg);
    }

    .submenu-level-3 {
        display: none;
        list-style: none;
        padding: 0;
        margin-top: 2px;
    }
    .sub-item-with-children.open > .submenu-level-3 {
        display: block;
        animation: slideDown 0.25s ease forwards;
    }

    .sub-link-level-3 {
        display: flex; align-items: center;
        padding: 0.5rem 1rem 0.5rem 4.5rem;
        font-size: 0.8rem; color: #64748b;
        text-decoration: none; font-weight: 500;
        border-radius: var(--radius); margin-bottom: 2px;
        transition: var(--transition);
    }

    .sub-link-level-3:hover { color: #0f172a; background: #f8fafc; }
    .sub-link-level-3.active { color: var(--primary); font-weight: 600; background: rgba(78, 115, 223, 0.05); }

    /* --- FOOTER --- */
    .sidebar-footer { padding: 1rem; border-top: 1px solid var(--sb-border); }
    .btn-logout {
        display: flex; align-items: center; justify-content: center;
        width: 100%; padding: 0.75rem;
        background: #fee2e2; color: #ef4444;
        border: none; border-radius: var(--radius);
        font-weight: 600; font-size: 0.9rem; text-decoration: none;
        transition: var(--transition);
    }
    .btn-logout:hover { background: #fecaca; color: #dc2626; }
    .btn-logout i { margin-right: 8px; }

    /* --- RESPONSIVE --- */
    .overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(2px);
        z-index: 1030; display: none; opacity: 0; transition: opacity 0.3s;
    }
    .overlay.show { display: block; opacity: 1; }

    @media (max-width: 768px) {
        #sidebar { transform: translateX(-100%); }
        #sidebar.mobile-open { transform: translateX(0); }
    }
    @keyframes slideDown { from { opacity: 0; transform: translateY(-5px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

<nav id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-dot"></div>
        Admin Panel
    </div>

    <div class="user-card">
        <img src="<?= $avatarUrl ?>" alt="Avatar" class="user-avatar">
        <div class="user-info">
            <h6><?= esc(substr($fullName, 0, 18)) ?></h6>
            <span><?= esc($role) ?></span>
        </div>
    </div>

    <div class="sidebar-content">
        <ul>
            <?php foreach ($menuItems as $item): ?>
                <?php 
                // Filter Role
                if (isset($item['roles']) && !in_array($role, $item['roles'])) continue;
                
                // Styling
                $iColor = $item['color'] ?? '#64748b';
                $iBg    = $item['bg'] ?? 'rgba(100, 116, 139, 0.1)';
                ?>

                <?php if ($item['type'] === 'header'): ?>
                    <li class="menu-header"><?= $item['title'] ?></li>
                
                <?php elseif ($item['type'] === 'dropdown'): ?>
                    <?php 
                        // Check Active State (Level 2 & Level 3)
                        $isActive = false;
                        if(isset($item['submenu'])) {
                            foreach($item['submenu'] as $sub) {
                                // Cek Level 2
                                if(strpos($currentPath, $sub['url']) === 0 && $sub['url'] !== '#') { 
                                    $isActive = true; 
                                    break; 
                                }
                                // Cek Level 3
                                if(isset($sub['submenu'])) {
                                    foreach($sub['submenu'] as $subLevel3) {
                                        if(strpos($currentPath, $subLevel3['url']) === 0) { 
                                            $isActive = true; 
                                            break 2; 
                                        }
                                    }
                                }
                            }
                        }
                    ?>
                    <li class="nav-item <?= $isActive ? 'open' : '' ?>">
                        <a href="javascript:void(0)" class="nav-link" onclick="toggleMenu(this)">
                            <div class="nav-icon" style="color: <?= $iColor ?>; background: <?= $iBg ?>;">
                                <i class="<?= $item['icon'] ?>"></i>
                            </div>
                            <span><?= $item['title'] ?></span>
                            <i class="bi bi-chevron-down nav-arrow"></i>
                        </a>
                        
                        <ul class="submenu">
                            <?php if(isset($item['submenu'])): ?>
                                <?php foreach ($item['submenu'] as $subItem): ?>
                                    <?php if (in_array($role, $subItem['roles'])): ?>
                                        
                                        <?php if(isset($subItem['submenu'])): 
                                            // Ada Level 3, cek aktif
                                            $isLevel3Active = false;
                                            foreach($subItem['submenu'] as $l3) {
                                                if(strpos($currentPath, $l3['url']) === 0) { 
                                                    $isLevel3Active = true; 
                                                    break; 
                                                }
                                            }
                                        ?>
                                            <!-- Sub Item dengan Children (Level 3) -->
                                            <li class="sub-item-with-children <?= $isLevel3Active ? 'open' : '' ?>">
                                                <a href="javascript:void(0)" class="sub-link" onclick="toggleLevel3(this, event)">
                                                    <?= $subItem['title'] ?>
                                                    <i class="bi bi-chevron-down nav-arrow"></i>
                                                </a>
                                                <ul class="submenu-level-3">
                                                    <?php foreach($subItem['submenu'] as $lvl3Item): ?>
                                                        <?php if (in_array($role, $lvl3Item['roles'])): ?>
                                                        <li>
                                                            <a href="<?= $lvl3Item['url'] ?>" 
                                                               class="sub-link-level-3 <?= ($currentPath === $lvl3Item['url']) ? 'active' : '' ?>">
                                                                <i class="bi bi-dot"></i> <?= $lvl3Item['title'] ?>
                                                            </a>
                                                        </li>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </li>
                                        <?php else: ?>
                                            <!-- Sub Item Biasa (Level 2) -->
                                            <li>
                                                <a href="<?= $subItem['url'] ?>" 
                                                   class="sub-link <?= ($currentPath === $subItem['url']) ? 'active' : '' ?>">
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
                    <?php $isActiveItem = ($currentPath === $item['url']); ?>
                    <li>
                        <a href="<?= $item['url'] ?>" class="nav-link <?= $isActiveItem ? 'active' : '' ?>" 
                           style="<?= $isActiveItem ? 'background:'.str_replace('0.1', '0.05', $iBg).'; color:'.$iColor.';' : '' ?>">
                            <div class="nav-icon" style="color: <?= $iColor ?>; background: <?= $iBg ?>;">
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
        <a href="/logout" class="btn-logout">
            <i class="bi bi-box-arrow-right"></i> Keluar
        </a>
    </div>
</nav>

<script>
    // Toggle Dropdown Level 1
    function toggleMenu(element) {
        const parent = element.parentElement;
        // Tutup yang lain
        document.querySelectorAll('.nav-item.open').forEach(item => {
            if (item !== parent) item.classList.remove('open');
        });
        parent.classList.toggle('open');
    }

    // Toggle Dropdown Level 3 (untuk nested submenu)
    function toggleLevel3(element, event) {
        event.stopPropagation(); 
        event.preventDefault();  

        const parentListItem = element.closest('.sub-item-with-children');
        if (parentListItem) {
            parentListItem.classList.toggle('open');
        }
    }

    // Mobile Toggle
    function toggleSidebar() {
        const sb = document.getElementById('sidebar');
        const ov = document.getElementById('overlay');
        sb.classList.toggle('mobile-open');
        sb.classList.contains('mobile-open') ? ov.classList.add('show') : ov.classList.remove('show');
    }

    // Auto Scroll & Open Active
    document.addEventListener("DOMContentLoaded", function() {
        const activeLink = document.querySelector('.sub-link-level-3.active') || 
                          document.querySelector('.sub-link.active') || 
                          document.querySelector('.nav-link.active');
        
        if (activeLink) {
            // Buka parent level 3 jika ada
            const level3Parent = activeLink.closest('.sub-item-with-children');
            if(level3Parent) level3Parent.classList.add('open');

            // Buka parent level 1
            const mainParent = activeLink.closest('.nav-item');
            if(mainParent) mainParent.classList.add('open');
            
            setTimeout(() => {
                activeLink.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 300);
        }
    });
</script>