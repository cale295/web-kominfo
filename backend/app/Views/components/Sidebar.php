<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<?php
<<<<<<< HEAD
// --- SETUP AWAL & SESSION ---
$session  = session();
$role     = $session->get('role') ?? 'superadmin'; 
$fullName = $session->get('full_name') ?? 'Guest User';
$avatarUrl = "https://ui-avatars.com/api/?name=" . urlencode($fullName) . "&background=3b82f6&color=ffffff&bold=true&format=svg";
=======
$session  = session();
$role     = $session->get('role') ?? 'superadmin'; 
$fullName = $session->get('full_name') ?? 'Administrator';
$avatarUrl = "https://ui-avatars.com/api/?name=" . urlencode($fullName) . "&background=e2e8f0&color=475569&bold=true&format=svg";
>>>>>>> 5187b086ab1cea09d0f5dc17498e3981ad23779e
$uri = service('uri');
$segments = $uri->getSegments();
$currentPath = '/' . (isset($segments[0]) ? $segments[0] : 'dashboard');
if(count($segments) > 1) {
    $currentPath = '/' . implode('/', $segments);
}

<<<<<<< HEAD
// --- LOGIKA OTOMATIS INFORMASI PUBLIK DARI DATABASE ---
// Pastikan Model dipanggil
$menuModel = new \App\Models\MenuModel(); 

// 1. Cari Parent Menu "Informasi Publik"
=======
$menuModel = new \App\Models\MenuModel(); 

>>>>>>> 5187b086ab1cea09d0f5dc17498e3981ad23779e
$parentInfoPublik = $menuModel->where('menu_name', 'Informasi Publik')->first();
$dynamicInfoPublikSubmenu = [];

if ($parentInfoPublik) {
<<<<<<< HEAD
    // 2. Ambil anak-anaknya (Level 2)
=======
>>>>>>> 5187b086ab1cea09d0f5dc17498e3981ad23779e
    $children = $menuModel->where('parent_id', $parentInfoPublik['id_menu'])
                          ->where('status', 'active')
                          ->orderBy('order_number', 'ASC')
                          ->findAll();

    foreach ($children as $child) {
<<<<<<< HEAD
        // Parsing roles dari string "admin,editor" ke array
        $childRoles = !empty($child['allowed_roles']) 
                      ? array_map('trim', explode(',', $child['allowed_roles'])) 
                      : ['superadmin', 'admin']; // Default role jika kosong
=======
        $childRoles = !empty($child['allowed_roles']) 
                      ? array_map('trim', explode(',', $child['allowed_roles'])) 
                      : ['superadmin', 'admin']; 
>>>>>>> 5187b086ab1cea09d0f5dc17498e3981ad23779e

        $menuItem = [
            'title' => $child['menu_name'],
            'url'   => $child['menu_url'] ?: '#',
            'roles' => $childRoles
        ];

<<<<<<< HEAD
        // 3. Cek apakah punya anak lagi? (Level 3 - Contoh: Pengadaan Barang -> Swakelola)
=======
>>>>>>> 5187b086ab1cea09d0f5dc17498e3981ad23779e
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
<<<<<<< HEAD
            // Jika ada submenu, set submenu array dan url jadi #
=======
>>>>>>> 5187b086ab1cea09d0f5dc17498e3981ad23779e
            $menuItem['submenu'] = $grandChildItems;
            $menuItem['url'] = '#';
        }

        $dynamicInfoPublikSubmenu[] = $menuItem;
    }
}
<<<<<<< HEAD
// --------------------------------------------------------


$menuItems = [
   [
        'type' => 'item', 
=======

$menuItems = [
    [
        'type'  => 'item', 
>>>>>>> 5187b086ab1cea09d0f5dc17498e3981ad23779e
        'title' => 'Dashboard', 
        'icon' => 'bi-speedometer2',
        'url' => '/dashboard', 
        'roles' => ['superadmin', 'admin', 'editor'],
        'color' => '#4e73df', 
        'bg' => 'rgba(78, 115, 223, 0.1)' 
    ],
<<<<<<< HEAD
=======

>>>>>>> 5187b086ab1cea09d0f5dc17498e3981ad23779e
    [
        'type' => 'item', 
        'title' => 'Pengaturan Menu', 
        'icon' => 'bi-gear-fill', 
        'url' => '/menu', 
        'roles' => ['superadmin'],
        'color' => '#4e73df', 
        'bg' => 'rgba(78, 115, 223, 0.1)' 
    ],
<<<<<<< HEAD
    ['type' => 'header', 'title' => 'BANNER & LAYANAN'],
    [
        'type' => 'dropdown', 
        'title' => 'Tampil Home', 
        'icon' => 'bi-laptop', 
=======
 
    [
        'type'  => 'item', 
        'title' => 'Banner', 
        'icon'  => 'bi-aspect-ratio',
        'url'   => '/banner', 
>>>>>>> 5187b086ab1cea09d0f5dc17498e3981ad23779e
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
<<<<<<< HEAD
    ['type' => 'header', 'title' => 'BERITA'],
=======

>>>>>>> 5187b086ab1cea09d0f5dc17498e3981ad23779e
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
<<<<<<< HEAD
    ['type' => 'header', 'title' => 'ProGRAM SKPD'],
    [
        'type' => 'dropdown', 
        'title' => 'Program SKPD', 
        'icon' => 'bi-journal-bookmark-fill', 
        'roles' => ['superadmin', 'admin'],
        'color' => '#f6c23e', 
        'bg' => 'rgba(246, 194, 62, 0.1)',
=======

    [
        'type'  => 'item', 
        'title' => 'Galeri', 
        'icon'  => 'bi-images', 
        'url'   => '/album', 
        'roles' => ['superadmin', 'admin'],
        'color' => '#f6c23e', 
        'bg'    => 'rgba(246, 194, 62, 0.1)' 
    ],

  
    ['type' => 'header', 'title' => 'PENGATURAN HALAMAN'],

    [
        'type'    => 'dropdown', 
        'title'   => 'Tampilan Menu Home', 
        'icon'    => 'bi-laptop', 
        'roles'   => ['superadmin', 'admin'],
        'color'   => '#36b9cc',
        'bg'      => 'rgba(54, 185, 204, 0.1)',
>>>>>>> 5187b086ab1cea09d0f5dc17498e3981ad23779e
        'submenu' => [
            ['title' => 'Program SKPD', 'url' => '/program', 'roles' => ['superadmin', 'admin']],
        ]
    ],
<<<<<<< HEAD
    ['type' => 'header', 'title' => 'HALAMAN PUBLIK'],
    [
        'type' => 'dropdown', 
        'title' => 'Profil Instansi', 
        'icon' => 'bi-building', 
        'roles' => ['superadmin', 'admin'],
        'color' => '#36b9cc', 
        'bg' => 'rgba(54, 185, 204, 0.1)',
=======

    [
        'type'    => 'dropdown', 
        'title'   => 'Hal Profil', 
        'icon'    => 'bi-building-check', 
        'roles'   => ['superadmin', 'admin'],
        'color'   => '#1cc88a',
        'bg'      => 'rgba(28, 200, 138, 0.1)',
>>>>>>> 5187b086ab1cea09d0f5dc17498e3981ad23779e
        'submenu' => [
            ['title' => 'Profil Tentang', 'url' => '/profil_tentang', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Tugas & Fungsi', 'url' => '/tugas_fungsi', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Struktur Pejabat', 'url' => '/pejabat_struktural', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Struktur Organisasi', 'url' => '/struktur_organisasi', 'roles' => ['superadmin', 'admin']],
        ]
    ],
<<<<<<< HEAD
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
=======

    [
        'type'    => 'dropdown', 
        'title'   => 'Pengaturan Berita', 
        'icon'    => 'bi-sliders', 
        'roles'   => ['superadmin', 'admin', 'editor'],
        'color'   => '#fd7e14',
        'bg'      => 'rgba(253, 126, 20, 0.1)',
>>>>>>> 5187b086ab1cea09d0f5dc17498e3981ad23779e
        'submenu' => [
            ['title' => 'Album Foto', 'url' => '/album', 'roles' => ['superadmin', 'admin']],
            ['title' => 'Foto Galeri', 'url' => '/gallery', 'roles' => ['superadmin', 'admin']],
        ]
    ],
<<<<<<< HEAD
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
=======

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

    [
        'type'    => 'dropdown', 
        'title'   => 'User & Akses', 
        'icon'    => 'bi-shield-lock', 
        'roles'   => ['superadmin'],
        'color'   => '#858796',
        'bg'      => 'rgba(133, 135, 150, 0.1)',
>>>>>>> 5187b086ab1cea09d0f5dc17498e3981ad23779e
        'submenu' => [
            ['title' => 'Manajemen User', 'url' => '/manage_user', 'roles' => ['superadmin']],
            ['title' => 'Hak Akses', 'url' => '/access_rights', 'roles' => ['superadmin']],
        ]
    ],
<<<<<<< HEAD
=======

>>>>>>> 5187b086ab1cea09d0f5dc17498e3981ad23779e
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

<<<<<<< HEAD
    /* Layout Sidebar */
=======

>>>>>>> 5187b086ab1cea09d0f5dc17498e3981ad23779e
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

<<<<<<< HEAD
    /* Brand Header */
=======
>>>>>>> 5187b086ab1cea09d0f5dc17498e3981ad23779e
    .sidebar-brand {
        height: 70px;
        display: flex; align-items: center;
        padding: 0 1.5rem;
<<<<<<< HEAD
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
=======
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


    .sidebar-content {
        flex: 1;
        overflow-y: auto;
        padding: 0 1rem 2rem 1rem;
>>>>>>> 5187b086ab1cea09d0f5dc17498e3981ad23779e
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

<<<<<<< HEAD
    /* Main Links */
    .sidebar-link {
=======

    .nav-link {
>>>>>>> 5187b086ab1cea09d0f5dc17498e3981ad23779e
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

<<<<<<< HEAD
    .submenu-item::before {
        content: ''; position: absolute; left: 2.25rem; top: 50%;
        transform: translateY(-50%); width: 5px; height: 5px;
        background: #cbd5e1; border-radius: 50%; transition: all 0.2s;
=======
    /* --- SUBMENU LEVEL 2 --- */
    .submenu {
        display: none; padding-left: 0; margin-top: 2px; overflow: hidden;
>>>>>>> 5187b086ab1cea09d0f5dc17498e3981ad23779e
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

<<<<<<< HEAD
    /* Footer */
    .sidebar-footer { padding: 1rem; border-top: 1px solid var(--border); background: #ffffff; }
    .logout-btn { 
        background: #fff5f5; color: var(--danger); 
        border: 1px solid #ffecec; justify-content: center; font-weight: 600;
=======
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
>>>>>>> 5187b086ab1cea09d0f5dc17498e3981ad23779e
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
<<<<<<< HEAD
                if (isset($item['roles']) && !in_array($role, $item['roles'])) continue;
                $iconColor = $item['color'] ?? '#64748b';
                $iconBg    = $item['bg'] ?? 'rgba(100, 116, 139, 0.1)';
=======
         
                if (isset($item['roles']) && !in_array($role, $item['roles'])) continue;
            
                $iColor = $item['color'] ?? '#64748b';
                $iBg    = $item['bg'] ?? 'rgba(100, 116, 139, 0.1)';
>>>>>>> 5187b086ab1cea09d0f5dc17498e3981ad23779e
                ?>

                <?php if ($item['type'] === 'header'): ?>
                    <li class="menu-header"><?= $item['title'] ?></li>
                
                <?php elseif ($item['type'] === 'dropdown'): ?>
                    <?php 
<<<<<<< HEAD
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
=======

                        $isActive = false;
                        if(isset($item['submenu'])) {
                            foreach($item['submenu'] as $sub) {
                               
                                if(strpos($currentPath, $sub['url']) === 0 && $sub['url'] !== '#') { 
                                    $isActive = true; 
                                    break; 
                                }
                                
                                if(isset($sub['submenu'])) {
                                    foreach($sub['submenu'] as $subLevel3) {
                                        if(strpos($currentPath, $subLevel3['url']) === 0) { 
                                            $isActive = true; 
                                            break 2; 
                                        }
                                    }
>>>>>>> 5187b086ab1cea09d0f5dc17498e3981ad23779e
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
<<<<<<< HEAD
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
=======
                                    
                                            $isLevel3Active = false;
                                            foreach($subItem['submenu'] as $l3) {
                                                if(strpos($currentPath, $l3['url']) === 0) { 
                                                    $isLevel3Active = true; 
                                                    break; 
                                                }
                                            }
                                        ?>
                                       
                                            <li class="sub-item-with-children <?= $isLevel3Active ? 'open' : '' ?>">
                                                <a href="javascript:void(0)" class="sub-link" onclick="toggleLevel3(this, event)">
                                                    <?= $subItem['title'] ?>
                                                    <i class="bi bi-chevron-down nav-arrow"></i>
>>>>>>> 5187b086ab1cea09d0f5dc17498e3981ad23779e
                                                </a>
                                                <ul class="submenu-level-3">
                                                    <?php foreach($subItem['submenu'] as $lvl3Item): ?>
                                                        <?php if (in_array($role, $lvl3Item['roles'])): ?>
                                                        <li>
<<<<<<< HEAD
                                                            <a href="<?= $lvl3Item['url'] ?>" class="submenu-item-level-3 <?= ($currentPath === $lvl3Item['url']) ? 'active' : '' ?>">
=======
                                                            <a href="<?= $lvl3Item['url'] ?>" 
                                                               class="sub-link-level-3 <?= ($currentPath === $lvl3Item['url']) ? 'active' : '' ?>">
>>>>>>> 5187b086ab1cea09d0f5dc17498e3981ad23779e
                                                                <i class="bi bi-dot"></i> <?= $lvl3Item['title'] ?>
                                                            </a>
                                                        </li>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </li>
                                        <?php else: ?>
<<<<<<< HEAD
                                            <li>
                                                <a href="<?= $subItem['url'] ?>" class="submenu-item <?= ($currentPath === $subItem['url']) ? 'active' : '' ?>">
=======
                                
                                            <li>
                                                <a href="<?= $subItem['url'] ?>" 
                                                   class="sub-link <?= ($currentPath === $subItem['url']) ? 'active' : '' ?>">
>>>>>>> 5187b086ab1cea09d0f5dc17498e3981ad23779e
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
<<<<<<< HEAD
function toggleMenu(element) {
    const parentListItem = element.closest('li.has-submenu');
    
    if (parentListItem) {
        // Tutup menu Level 1 lain
        const allMenus = document.querySelectorAll('li.has-submenu');
        allMenus.forEach(menu => {
            if (menu !== parentListItem && menu.classList.contains('open')) {
                menu.classList.remove('open');
            }
=======
    function toggleMenu(element) {
        const parent = element.parentElement;
        document.querySelectorAll('.nav-item.open').forEach(item => {
            if (item !== parent) item.classList.remove('open');
>>>>>>> 5187b086ab1cea09d0f5dc17498e3981ad23779e
        });
        parentListItem.classList.toggle('open');
    }
}


<<<<<<< HEAD
function toggleLevel3(element, event) {
    event.stopPropagation(); 
    event.preventDefault();  

    const parentListItem = element.closest('li.has-submenu-level-3');
    if (parentListItem) {
        parentListItem.classList.toggle('open');
=======
    function toggleLevel3(element, event) {
        event.stopPropagation(); 
        event.preventDefault();  

        const parentListItem = element.closest('.sub-item-with-children');
        if (parentListItem) {
            parentListItem.classList.toggle('open');
        }

    function toggleSidebar() {
        const sb = document.getElementById('sidebar');
        const ov = document.getElementById('overlay');
        sb.classList.toggle('mobile-open');
        sb.classList.contains('mobile-open') ? ov.classList.add('show') : ov.classList.remove('show');
>>>>>>> 5187b086ab1cea09d0f5dc17498e3981ad23779e
    }
}

<<<<<<< HEAD
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
=======
    document.addEventListener("DOMContentLoaded", function() {
        const activeLink = document.querySelector('.sub-link-level-3.active') || 
                          document.querySelector('.sub-link.active') || 
                          document.querySelector('.nav-link.active');
        
        if (activeLink) {
            const level3Parent = activeLink.closest('.sub-item-with-children');
            if(level3Parent) level3Parent.classList.add('open');

            const mainParent = activeLink.closest('.nav-item');
            if(mainParent) mainParent.classList.add('open');
            
            setTimeout(() => {
                activeLink.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 300);
        }
    });
>>>>>>> 5187b086ab1cea09d0f5dc17498e3981ad23779e
</script>