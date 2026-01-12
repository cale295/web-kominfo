<?php
// ==========================================
// 1. LOGIKA BACKEND (DARI KODE PERTAMA)
// ==========================================

$session   = session();
$role      = $session->get('role') ?? 'guest'; 
$fullName  = $session->get('full_name') ?? 'Guest User';
// Menggunakan avatar style dari request
$avatarUrl = "https://ui-avatars.com/api/?name=" . urlencode($fullName) . "&background=6366f1&color=ffffff&bold=true&format=svg";

// Setup URI
$uri = service('uri');
$segments = $uri->getSegments();
$currentPath = '/' . (isset($segments[0]) ? $segments[0] : 'dashboard');
if(count($segments) > 1) {
    $currentPath = '/' . implode('/', $segments);
}

// Ambil menu dari database
$menuController = service('menuAdmin');
$menuData = $menuController->getMenu();

// Service Access Right
$accessRightController = service('accessRight'); 

// Function Generate Warna (Kita pakai untuk mewarnai icon sesuai desain baru)
function getIconStyle($index) {
    $colors = [
        '#6366f1', // Indigo (Primary di desain baru)
        '#8b5cf6', // Purple
        '#ec4899', // Pink
        '#f59e0b', // Amber
        '#10b981', // Emerald
        '#06b6d4', // Cyan
        '#ef4444', // Red
        '#3b82f6', // Blue
    ];
    return $colors[$index % count($colors)];
}

// Function Cek Akses
function hasMenuAccess($menu, $userRole, $accessRightController) {
    $allowedRolesString = '';
    
    if (isset($menu['allowed_roles'])) {
        $allowedRolesString = $menu['allowed_roles'];
    } elseif (isset($menu['roles'])) {
        $allowedRolesString = $menu['roles']; 
    }

    if (empty(trim($allowedRolesString))) {
        return true; 
    }

    $allowedRolesArray = array_map('trim', explode(',', $allowedRolesString));
    return in_array($userRole, $allowedRolesArray);
}

// Function Build Menu (Rekursif)
function buildMenu(array $menus, $parentId = 0, $userRole = 'guest', $accessRightController = null, &$colorIndex = 0): array
{
    $result = [];

    foreach ($menus as $menu) {
        if ($menu['status'] !== 'active') continue;
        if ((int)$menu['parent_id'] !== (int)$parentId) continue;
        if (!hasMenuAccess($menu, $userRole, $accessRightController)) continue;

        $item = [
            'type'  => 'item',
            'title' => $menu['menu_name'],
            'url'   => $menu['admin_url'],
            'icon'  => $menu['menu_icon'] ?: 'bi bi-circle',
        ];

        // Assign warna hanya untuk level 0 (Root menu)
        if ($parentId === 0) {
            $item['color'] = getIconStyle($colorIndex);
            $colorIndex++;
        }
        
        $submenu = buildMenu($menus, $menu['id_menu'], $userRole, $accessRightController, $colorIndex);
        
        if (!empty($submenu)) {
            $item['type'] = 'dropdown';
            $item['submenu'] = $submenu;
        }

        $result[] = $item;
    }
    return $result;
}

// Generate Struktur Menu
$colorIndex = 0;
$menuItems = buildMenu($menuData, 0, $role, $accessRightController, $colorIndex);
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap');

    * { margin: 0; padding: 0; box-sizing: border-box; }

    /* Overlay untuk Mobile */
    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1030;
        backdrop-filter: blur(2px);
    }
    .sidebar-overlay.show { display: block; }

    #sidebar {
        width: 260px;
        height: 100vh;
        position: fixed;
        top: 0; 
        left: 0;
        background: #fff;
        border-right: 1px solid #e5e7eb;
        z-index: 1040;
        display: flex; 
        flex-direction: column;
        font-family: 'Inter', sans-serif;
        transition: transform 0.3s ease;
        overflow: hidden; /* Prevent horizontal scroll */
    }

    /* Brand */
    .sidebar-brand {
        height: 64px;
        display: flex; 
        align-items: center;
        padding: 0 1.25rem;
        border-bottom: 1px solid #e5e7eb;
        flex-shrink: 0;
        background: #fff;
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
        white-space: nowrap;
    }

    /* User Profile */
    .sidebar-user {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex; 
        align-items: center;
        flex-shrink: 0;
        background: #f9fafb;
    }
    .user-avatar { 
        width: 40px; 
        height: 40px; 
        border-radius: 8px;
        flex-shrink: 0;
        border: 1px solid #e5e7eb;
    }
    .user-info { 
        margin-left: 10px; 
        flex: 1;
        min-width: 0;
    }
    .user-name { 
        font-weight: 600; 
        color: #111827; 
        font-size: 0.85rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .user-role { 
        font-size: 0.7rem; 
        color: #6b7280; 
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    /* Menu Wrapper */
    .sidebar-menu { 
        flex: 1; 
        overflow-y: auto; 
        overflow-x: hidden;
        padding: 1rem 0; 
    }
    .sidebar-menu::-webkit-scrollbar { width: 5px; }
    .sidebar-menu::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }
    
    .menu-list { list-style: none; }
    
    /* Header Menu (Optional jika ada) */
    .menu-header {
        font-size: 0.7rem;
        font-weight: 700;
        color: #9ca3af;
        text-transform: uppercase;
        margin: 1.5rem 1.25rem 0.5rem;
        letter-spacing: 0.5px;
    }

    /* Links Utama */
    .menu-link {
        display: flex; 
        align-items: center;
        padding: 0.75rem 1.25rem;
        color: #4b5563; 
        text-decoration: none;
        font-weight: 500; 
        font-size: 0.875rem;
        transition: all 0.2s;
        cursor: pointer;
        position: relative;
    }

    .menu-link i.menu-icon {
        font-size: 1.1rem;
        margin-right: 12px;
        width: 20px;
        text-align: center;
        flex-shrink: 0;
        transition: transform 0.2s;
    }

    .menu-link span {
        flex: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .menu-link:hover { 
        background: #f3f4f6; 
        color: #111827;
    }
    .menu-link:hover i.menu-icon {
        transform: scale(1.1);
    }

    .menu-link.active {
        background: #eef2ff;
        color: #6366f1;
        font-weight: 600;
        border-right: 3px solid #6366f1;
    }
    
    .arrow { 
        margin-left: auto; 
        font-size: 0.75rem; 
        transition: transform 0.3s; 
        color: #9ca3af;
        flex-shrink: 0;
    }
    
    /* Parent Active State */
    .has-submenu.open > .menu-link {
        color: #111827;
        background: #f9fafb;
    }
    .has-submenu.open > .menu-link .arrow { 
        transform: rotate(180deg); 
        color: #6366f1;
    }

    /* Submenu Level 2 */
    .submenu { 
        display: none; 
        list-style: none; 
        background: #fff;
        padding-top: 0.25rem;
        padding-bottom: 0.25rem;
    }
    .has-submenu.open > .submenu { 
        display: block; 
        animation: fadeIn 0.3s ease;
    }

    .submenu-link {
        display: block;
        padding: 0.6rem 1.25rem 0.6rem 3.25rem;
        text-decoration: none; 
        color: #6b7280;
        font-size: 0.825rem; 
        font-weight: 500;
        transition: all 0.2s;
        position: relative;
    }

    /* Dot indicator untuk submenu */
    .submenu-link::before {
        content: ''; 
        position: absolute; 
        left: 1.85rem; 
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 4px;
        border-radius: 50%;
        background-color: #d1d5db;
        transition: all 0.2s;
    }

    .submenu-link:hover { 
        color: #111827; 
        background: #f9fafb;
    }
    .submenu-link:hover::before {
        background-color: #6366f1;
        transform: translateY(-50%) scale(1.2);
    }

    .submenu-link.active { 
        color: #6366f1; 
        background: #fff;
        font-weight: 600;
    }
    .submenu-link.active::before {
        background-color: #6366f1;
        width: 6px;
        height: 6px;
    }

    /* Submenu Level 3 */
    .has-submenu-level-3 > .submenu-link {
        display: flex;
        align-items: center;
    }
    .has-submenu-level-3 > .submenu-link .arrow {
        transform: rotate(-90deg);
        font-size: 0.7rem;
    }
    .has-submenu-level-3.open > .submenu-link .arrow {
        transform: rotate(0deg);
        color: #6366f1;
    }
    
    .submenu-level-3 {
        display: none;
        list-style: none;
        background: #f9fafb; /* Sedikit lebih gelap untuk level 3 */
    }
    .has-submenu-level-3.open > .submenu-level-3 {
        display: block;
    }

    .submenu-link-level-3 {
        display: block;
        padding: 0.5rem 1.25rem 0.5rem 4.5rem;
        text-decoration: none;
        color: #6b7280;
        font-size: 0.8rem;
        transition: all 0.2s;
    }
    
    .submenu-link-level-3:hover {
        color: #111827;
    }
    
    .submenu-link-level-3.active {
        color: #6366f1;
        font-weight: 600;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        #sidebar { transform: translateX(-100%); }
        #sidebar.mobile-open { transform: translateX(0); box-shadow: 0 0 20px rgba(0,0,0,0.1); }
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
                
                <?php if ($item['type'] === 'header'): ?>
                    <li class="menu-header"><?= $item['title'] ?></li>

                <?php elseif ($item['type'] === 'dropdown'): ?>
                    <?php 
                        // Logic Active State untuk Parent (Level 1)
                        $isSubActive = false;
                        foreach($item['submenu'] as $sub) {
                            if (isset($sub['submenu'])) { // Cek Level 3
                                foreach($sub['submenu'] as $l3) {
                                    if(strpos($currentPath, $l3['url']) === 0) { $isSubActive = true; break; }
                                }
                            } else {
                                if(strpos($currentPath, $sub['url']) === 0) { $isSubActive = true; break; }
                            }
                        }
                    ?>
                    <li class="has-submenu <?= $isSubActive ? 'open' : '' ?>">
                        <a href="javascript:void(0)" class="menu-link" onclick="toggleMenu(this)">
                            <i class="<?= $item['icon'] ?> menu-icon" style="color: <?= $item['color'] ?? '#6b7280' ?>"></i>
                            <span><?= $item['title'] ?></span>
                            <i class="bi bi-chevron-down arrow"></i>
                        </a>
                        
                        <ul class="submenu">
                            <?php foreach ($item['submenu'] as $subItem): ?>
                                <?php if(isset($subItem['submenu'])): // Ada Level 3 
                                    $isL3Active = false;
                                    foreach($subItem['submenu'] as $l3) {
                                        if(strpos($currentPath, $l3['url']) === 0) { $isL3Active = true; break; }
                                    }
                                ?>
                                    <li class="has-submenu-level-3 <?= $isL3Active ? 'open' : '' ?>">
                                        <a href="javascript:void(0)" class="submenu-link" onclick="toggleLevel3(this, event)">
                                            <?= $subItem['title'] ?>
                                            <i class="bi bi-chevron-down arrow"></i>
                                        </a>
                                        <ul class="submenu-level-3">
                                            <?php foreach($subItem['submenu'] as $l3Item): ?>
                                                <li>
                                                    <a href="<?= $l3Item['url'] ?>" class="submenu-link-level-3 <?= ($currentPath === $l3Item['url']) ? 'active' : '' ?>">
                                                        <?= $l3Item['title'] ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </li>
                                <?php else: // Hanya Level 2 ?>
                                    <li>
                                        <a href="<?= $subItem['url'] ?>" class="submenu-link <?= ($currentPath === $subItem['url']) ? 'active' : '' ?>">
                                            <?= $subItem['title'] ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </li>

                <?php elseif ($item['type'] === 'item'): ?>
                    <li>
                        <a href="<?= $item['url'] ?>" class="menu-link <?= ($currentPath === $item['url']) ? 'active' : '' ?>">
                            <i class="<?= $item['icon'] ?> menu-icon" style="color: <?= $item['color'] ?? '#6b7280' ?>"></i>
                            <span><?= $item['title'] ?></span>
                        </a>
                    </li>
                <?php endif; ?>

            <?php endforeach; ?>
        </ul>

        <ul class="menu-list" style="margin-top: 1rem; border-top: 1px solid #f3f4f6;">
            <li>
                <a href="/logout" class="menu-link" style="color: #ef4444;">
                    <i class="bi bi-box-arrow-right menu-icon"></i>
                    <span>Keluar</span>
                </a>
            </li>
        </ul>
    </div>
</nav>

<script>
function toggleMenu(element) {
    const parentListItem = element.closest('li.has-submenu');
    
    // Accordion style: Tutup menu lain saat satu dibuka (opsional, hapus loop ini jika ingin multiple open)
    const allMenus = document.querySelectorAll('li.has-submenu');
    allMenus.forEach(menu => {
        if (menu !== parentListItem && menu.classList.contains('open')) {
            menu.classList.remove('open');
        }
    });

    if (parentListItem) {
        parentListItem.classList.toggle('open');
    }
}

function toggleLevel3(element, event) {
    event.preventDefault();
    event.stopPropagation();
    const parentListItem = element.closest('li.has-submenu-level-3');
    if (parentListItem) {
        parentListItem.classList.toggle('open');
    }
}

// Mobile toggle functions
function openSidebar() {
    document.getElementById('sidebar').classList.add('mobile-open');
    document.getElementById('sidebarOverlay').classList.add('show');
}

function closeSidebar() {
    document.getElementById('sidebar').classList.remove('mobile-open');
    document.getElementById('sidebarOverlay').classList.remove('show');
}

// Auto scroll ke active item saat load
document.addEventListener("DOMContentLoaded", function() {
    const activeItem = document.querySelector('.menu-link.active') || document.querySelector('.submenu-link.active') || document.querySelector('.submenu-link-level-3.active');
    
    if (activeItem) {
        // Buka parent level 1
        const level1Parent = activeItem.closest('.has-submenu');
        if(level1Parent) level1Parent.classList.add('open');
        
        // Buka parent level 2 jika ada (untuk level 3)
        const level2Parent = activeItem.closest('.has-submenu-level-3');
        if(level2Parent) level2Parent.classList.add('open');
        
        setTimeout(() => {
            activeItem.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 500);
    }
});
</script>