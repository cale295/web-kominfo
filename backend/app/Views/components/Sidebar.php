<?php
$session   = session();
$role      = $session->get('role') ?? 'guest'; 
$fullName  = $session->get('full_name') ?? 'Guest User';
$avatarUrl = "https://ui-avatars.com/api/?name=" . urlencode($fullName) . "&background=3b82f6&color=ffffff&bold=true&format=svg";

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

// Service Access Right (biarkan null jika logika filter murni dari kolom database)
$accessRightController = service('accessRight'); 

// Function untuk generate warna otomatis
function getIconStyle($index, $menuName = '') {
    $colors = [
        ['color' => '#3b82f6', 'bg' => 'rgba(59, 130, 246, 0.1)'],   // Blue
        ['color' => '#8b5cf6', 'bg' => 'rgba(139, 92, 246, 0.1)'],   // Purple
        ['color' => '#ec4899', 'bg' => 'rgba(236, 72, 153, 0.1)'],   // Pink
        ['color' => '#f59e0b', 'bg' => 'rgba(245, 158, 11, 0.1)'],   // Amber
        ['color' => '#10b981', 'bg' => 'rgba(16, 185, 129, 0.1)'],   // Green
        ['color' => '#06b6d4', 'bg' => 'rgba(6, 182, 212, 0.1)'],    // Cyan
        ['color' => '#ef4444', 'bg' => 'rgba(239, 68, 68, 0.1)'],    // Red
        ['color' => '#6366f1', 'bg' => 'rgba(99, 102, 241, 0.1)'],   // Indigo
    ];
    return $colors[$index % count($colors)];
}

// === FUNCTION CEK AKSES YANG SUDAH DIPERBAIKI ===
function hasMenuAccess($menu, $userRole, $accessRightController) {
    // 1. Bypass Superadmin SUDAH DIHAPUS agar sesuai request
    // if ($userRole === 'superadmin') { return true; }
    
    // 2. Deteksi nama kolom secara aman (Anti Error Undefined Array Key)
    $allowedRolesString = '';
    
    if (isset($menu['allowed_roles'])) {
        $allowedRolesString = $menu['allowed_roles'];
    } elseif (isset($menu['roles'])) {
        $allowedRolesString = $menu['roles']; 
    }

    // 3. Jika kosong, berarti PUBLIC (Tampil Semua)
    if (empty(trim($allowedRolesString))) {
        return true; 
    }

    // 4. Cek Role User
    $allowedRolesArray = array_map('trim', explode(',', $allowedRolesString));

    if (in_array($userRole, $allowedRolesArray)) {
        return true; 
    }

    return false;
}

function buildMenu(array $menus, $parentId = 0, $userRole = 'guest', $accessRightController = null, &$colorIndex = 0): array
{
    $result = [];

    foreach ($menus as $menu) {
        // Cek status
        if ($menu['status'] !== 'active') {
            continue;
        }

        // Cek parent
        if ((int)$menu['parent_id'] !== (int)$parentId) {
            continue;
        }

        // Cek Akses
        if (!hasMenuAccess($menu, $userRole, $accessRightController)) {
            continue;
        }

        $item = [
            'type'  => 'item',
            'title' => $menu['menu_name'],
            'url'   => $menu['admin_url'],
            'icon'  => $menu['menu_icon'] ?: 'bi bi-circle',
        ];

        if ($parentId === 0) {
            $style = getIconStyle($colorIndex, $menu['menu_name']);
            $item['color'] = $style['color'];
            $item['bg'] = $style['bg'];
            $colorIndex++;
        }
        
        // Rekursif submenu
        $submenu = buildMenu($menus, $menu['id_menu'], $userRole, $accessRightController, $colorIndex);
        
        if (!empty($submenu)) {
            $item['type'] = 'dropdown';
            $item['submenu'] = $submenu;
        }

        $result[] = $item;
    }

    return $result;
}

$colorIndex = 0;
$menuItems = buildMenu($menuData, 0, $role, $accessRightController, $colorIndex);
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

:root {
    --sb-width: 280px;
    --sb-bg: #ffffff;
    --sb-text: #64748b;
    --sb-text-active: #0f172a;
    --sb-header: #94a3b8;
    --primary: #3b82f6;
    --primary-light: #dbeafe;
    --hover-bg: #f8fafc;
    --active-bg: #eff6ff;
    --border: #e2e8f0;
    --danger: #ef4444;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* ===== SIDEBAR LAYOUT ===== */
#sidebar {
    width: var(--sb-width);
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    background: var(--sb-bg);
    border-right: 1px solid var(--border);
    z-index: 1040;
    display: flex;
    flex-direction: column;
    font-family: 'Inter', sans-serif;
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: var(--shadow-lg);
}

/* ===== BRAND HEADER ===== */
.sidebar-brand {
    height: 72px;
    display: flex;
    align-items: center;
    padding: 0 1.5rem;
    border-bottom: 1px solid var(--border);
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    flex-shrink: 0;
}

.sidebar-brand i {
    font-size: 1.75rem;
    color: var(--primary);
    margin-right: 12px;
    filter: drop-shadow(0 2px 4px rgba(59, 130, 246, 0.2));
}

.sidebar-brand span {
    font-weight: 700;
    font-size: 1.25rem;
    color: #0f172a;
    letter-spacing: -0.5px;
}

/* ===== USER PROFILE CARD ===== */
.sidebar-user-card {
    padding: 1rem;
    margin: 1.25rem 1rem;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    display: flex;
    align-items: center;
    box-shadow: var(--shadow-sm);
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.sidebar-user-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.user-avatar {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    border: 3px solid white;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    flex-shrink: 0;
}

.user-details {
    margin-left: 12px;
    overflow: hidden;
    flex: 1;
    min-width: 0;
}

.user-name {
    font-weight: 600;
    color: #0f172a;
    font-size: 0.9rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.4;
}

.user-role {
    font-size: 0.75rem;
    color: var(--primary);
    text-transform: uppercase;
    font-weight: 700;
    letter-spacing: 0.5px;
    margin-top: 2px;
}

/* ===== MENU WRAPPER ===== */
.sidebar-menu-wrapper {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 0.5rem 0 1rem 0;
    scrollbar-width: thin;
    scrollbar-color: #cbd5e1 transparent;
}

.sidebar-menu-wrapper::-webkit-scrollbar {
    width: 6px;
}

.sidebar-menu-wrapper::-webkit-scrollbar-track {
    background: transparent;
}

.sidebar-menu-wrapper::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}

.sidebar-menu-wrapper::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

.menu-list {
    list-style: none;
    padding: 0;
}

/* ===== SECTION HEADER ===== */
.menu-header {
    font-size: 0.7rem;
    font-weight: 700;
    color: var(--sb-header);
    text-transform: uppercase;
    margin: 1.5rem 0 0.75rem 1.5rem;
    letter-spacing: 1px;
}

/* ===== MAIN MENU LINKS ===== */
.sidebar-link {
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem;
    color: var(--sb-text);
    text-decoration: none;
    font-weight: 500;
    font-size: 0.875rem;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    margin: 0.25rem 1rem;
    border-radius: 12px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.sidebar-link::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 3px;
    background: var(--primary);
    transform: scaleY(0);
    transition: transform 0.2s ease;
}

.icon-wrapper {
    width: 36px;
    height: 36px;
    min-width: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    margin-right: 12px;
    transition: all 0.2s ease;
    font-size: 1.1rem;
}

.sidebar-link:hover {
    background: var(--hover-bg);
    color: var(--sb-text-active);
    transform: translateX(2px);
}

.sidebar-link:hover .icon-wrapper {
    transform: scale(1.1) rotate(5deg);
}

.sidebar-link.active {
    background: var(--active-bg);
    color: var(--primary);
    font-weight: 600;
}

.sidebar-link.active::before {
    transform: scaleY(1);
}

.sidebar-link.active .icon-wrapper {
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
}

.has-submenu.open > .sidebar-link {
    background: var(--hover-bg);
    color: var(--sb-text-active);
    font-weight: 600;
}

.arrow {
    margin-left: auto;
    font-size: 0.75rem;
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    color: #94a3b8;
}

.has-submenu.open > .sidebar-link .arrow {
    transform: rotate(180deg);
    color: var(--primary);
}

/* ===== LEVEL 2 SUBMENU ===== */
.submenu {
    display: none;
    list-style: none;
    padding: 0.5rem 0;
    animation: slideDown 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}

.has-submenu.open > .submenu {
    display: block;
}

.submenu-item {
    display: flex;
    align-items: center;
    padding: 0.65rem 1rem 0.65rem 4rem;
    text-decoration: none;
    color: var(--sb-text);
    font-size: 0.85rem;
    font-weight: 500;
    margin: 0.15rem 1rem;
    border-radius: 10px;
    position: relative;
    transition: all 0.2s ease;
}

.submenu-item::before {
    content: '';
    position: absolute;
    left: 2.5rem;
    top: 50%;
    transform: translateY(-50%);
    width: 6px;
    height: 6px;
    background: #cbd5e1;
    border-radius: 50%;
    transition: all 0.2s ease;
}

.submenu-item:hover {
    color: var(--sb-text-active);
    background: var(--hover-bg);
    transform: translateX(2px);
}

.submenu-item:hover::before {
    background: var(--primary);
    transform: translateY(-50%) scale(1.3);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
}

.submenu-item.active {
    color: var(--primary);
    background: var(--active-bg);
    font-weight: 600;
}

.submenu-item.active::before {
    background: var(--primary);
    width: 8px;
    height: 8px;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
}

/* ===== LEVEL 3 SUBMENU ===== */
.has-submenu-level-3 > .submenu-item .arrow {
    transform: rotate(-90deg);
    margin-left: auto;
}

.has-submenu-level-3.open > .submenu-item .arrow {
    transform: rotate(0deg);
    color: var(--primary);
}

.submenu-level-3 {
    display: none;
    list-style: none;
    padding: 0.25rem 0;
    animation: slideDown 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}

.has-submenu-level-3.open > .submenu-level-3 {
    display: block;
}

.submenu-item-level-3 {
    display: flex;
    align-items: center;
    padding: 0.6rem 1rem 0.6rem 5rem;
    text-decoration: none;
    color: var(--sb-text);
    font-size: 0.8rem;
    font-weight: 500;
    margin: 0.15rem 1rem;
    border-radius: 10px;
    position: relative;
    transition: all 0.2s ease;
}

.submenu-item-level-3::before {
    content: '';
    position: absolute;
    left: 3.75rem;
    top: 50%;
    transform: translateY(-50%);
    width: 4px;
    height: 4px;
    background: #cbd5e1;
    border-radius: 50%;
    transition: all 0.2s ease;
}

.submenu-item-level-3:hover {
    color: var(--sb-text-active);
    background: var(--hover-bg);
    transform: translateX(2px);
}

.submenu-item-level-3:hover::before {
    background: var(--primary);
    transform: translateY(-50%) scale(1.5);
}

.submenu-item-level-3.active {
    color: var(--primary);
    background: var(--active-bg);
    font-weight: 700;
}

.submenu-item-level-3.active::before {
    background: var(--primary);
    width: 6px;
    height: 6px;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}

.submenu-item-level-3 i.bi-dot {
    margin-right: 4px;
    font-size: 1.2rem;
}

/* ===== ANIMATIONS ===== */
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-8px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ===== FOOTER ===== */
.sidebar-footer {
    padding: 1rem;
    border-top: 1px solid var(--border);
    background: linear-gradient(to top, #ffffff, #f8fafc);
    flex-shrink: 0;
}

.logout-btn {
    background: linear-gradient(135deg, #fff5f5 0%, #fee2e2 100%);
    color: var(--danger);
    border: 1px solid #fecaca;
    justify-content: center;
    font-weight: 600;
    transition: all 0.3s ease;
}

.logout-btn:hover {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    border-color: #fca5a5;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
}

.logout-btn .icon-wrapper {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger);
}

/* ===== MOBILE RESPONSIVE ===== */
.sidebar-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1030;
    backdrop-filter: blur(4px);
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@media (max-width: 768px) {
    #sidebar {
        transform: translateX(-100%);
    }
    
    #sidebar.mobile-open {
        transform: translateX(0);
        box-shadow: 0 0 50px rgba(0, 0, 0, 0.3);
    }
    
    .sidebar-overlay.show {
        display: block;
    }
    
    .sidebar-brand {
        height: 64px;
    }
    
    .sidebar-user-card {
        margin: 1rem 0.75rem;
    }
    
    .menu-header {
        margin-left: 1rem;
    }
    
    .sidebar-link {
        margin: 0.25rem 0.75rem;
    }
    
    .submenu-item {
        margin: 0.15rem 0.75rem;
    }
    
    .submenu-item-level-3 {
        margin: 0.15rem 0.75rem;
    }
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
                $iconColor = $item['color'] ?? '#64748b';
                $iconBg    = $item['bg'] ?? 'rgba(100, 116, 139, 0.1)';
                ?>

                <?php if ($item['type'] === 'header'): ?>
                    <li class="menu-header"><?= $item['title'] ?></li>
                
                <?php elseif ($item['type'] === 'dropdown'): ?>
                    <?php 
                        $isSubActive = false;
                        foreach($item['submenu'] as $sub) {
                            if (isset($sub['submenu'])) {
                                foreach($sub['submenu'] as $subLevel3) {
                                    if(strpos($currentPath, $subLevel3['url']) === 0) { 
                                        $isSubActive = true; 
                                        break; 
                                    }
                                }
                            } else {
                                if(strpos($currentPath, $sub['url']) === 0) { 
                                    $isSubActive = true; 
                                    break; 
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
                            <?php foreach ($item['submenu'] as $subItem): ?>
                                <?php if(isset($subItem['submenu'])): 
                                    $isLevel3Active = false;
                                    foreach($subItem['submenu'] as $l3) {
                                        if(strpos($currentPath, $l3['url']) === 0) { 
                                            $isLevel3Active = true; 
                                            break; 
                                        }
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
                                                        <?= $lvl3Item['title'] ?>
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

    <div class="sidebar-footer">
        <a href="/logout" class="sidebar-link logout-btn">
            <div class="icon-wrapper">
                <i class="bi bi-box-arrow-right"></i>
            </div>
            <span>Keluar Sistem</span>
        </a>
    </div>
</nav>

<script>
function toggleMenu(element) {
    const parentListItem = element.closest('li.has-submenu');
    
    if (parentListItem) {
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

document.addEventListener("DOMContentLoaded", function() {
    const activeItem = document.querySelector('.submenu-item.active') || 
                       document.querySelector('.sidebar-link.active') || 
                       document.querySelector('.submenu-item-level-3.active');
    
    if (activeItem) {
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