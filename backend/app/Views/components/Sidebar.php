<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<?php
$session  = session();
$role     = $session->get('role') ?? 'superadmin'; 
$fullName = $session->get('full_name') ?? 'Guest User';
// Avatar dibuat lebih simple tanpa border tebal
$avatarUrl = "https://ui-avatars.com/api/?name=" . urlencode($fullName) . "&background=e2e8f0&color=475569&bold=true&format=svg";

$uri = service('uri');
$segments = $uri->getSegments();
$currentPath = '/' . (isset($segments[0]) ? $segments[0] : 'dashboard');
if(count($segments) > 1) {
    $currentPath = '/' . implode('/', $segments);
}

$menuController = service('menuAdmin');
$menuData = $menuController->getMenu();

function buildMenu(array $menus, $parentId = 0): array
{
    $result = [];
    foreach ($menus as $menu) {
        if ($menu['status'] !== 'active') continue;
        if ((int)$menu['parent_id'] !== (int)$parentId) continue;

        $item = [
            'type'  => 'item',
            'title' => $menu['menu_name'],
            'url'   => $menu['admin_url'],
            'icon'  => $menu['menu_icon'] ?: 'bi bi-circle',
            'roles' => ['superadmin','admin'],
        ];

        $submenu = buildMenu($menus, $menu['id_menu']);
        if (!empty($submenu)) {
            $item['type'] = 'dropdown';
            $item['submenu'] = $submenu;
        }
        $result[] = $item;
    }
    return $result;
}

$menuItems = buildMenu($menuData, 0);
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap');

:root {
    --sidebar-width: 260px;
    --bg-sidebar: #ffffff;
    --bg-hover: #f1f5f9;
    --text-main: #334155;
    --text-muted: #94a3b8;
    --primary: #2563eb; /* Biru Profesional */
    --border-color: #e2e8f0;
}

* { box-sizing: border-box; }

body { font-family: 'Inter', sans-serif; }

/* ===== STRUCTURE ===== */
#sidebar {
    width: var(--sidebar-width);
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    background: var(--bg-sidebar);
    border-right: 1px solid var(--border-color);
    display: flex;
    flex-direction: column;
    z-index: 1000;
    transition: transform 0.3s ease; /* Hanya untuk mobile toggle */
}

/* ===== HEADER ===== */
.sidebar-header {
    height: 64px;
    display: flex;
    align-items: center;
    padding: 0 1.25rem;
    border-bottom: 1px solid var(--border-color);
}

.brand-logo {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1.1rem;
    font-weight: 600;
    color: #0f172a;
}

.brand-logo i {
    font-size: 1.4rem;
    color: var(--primary);
}

/* ===== USER PROFILE (Minimalist) ===== */
.user-profile {
    padding: 1.25rem;
    display: flex;
    align-items: center;
    gap: 12px;
    border-bottom: 1px solid var(--border-color);
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%; /* Bulat sempurna */
    object-fit: cover;
}

.user-info h4 {
    margin: 0;
    font-size: 0.875rem;
    font-weight: 600;
    color: #1e293b;
}

.user-info span {
    font-size: 0.75rem;
    color: var(--text-muted);
    text-transform: capitalize;
}

/* ===== MENU LIST ===== */
.sidebar-content {
    flex: 1;
    overflow-y: auto;
    padding: 1rem 0.75rem;
}

.menu-label {
    padding: 1rem 0.75rem 0.5rem;
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    color: var(--text-muted);
    letter-spacing: 0.5px;
}

ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

/* ===== LINKS & ITEMS ===== */
.nav-link {
    display: flex;
    align-items: center;
    padding: 0.6rem 0.75rem;
    color: var(--text-main);
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    border-radius: 6px;
    margin-bottom: 2px;
    transition: background-color 0.15s ease, color 0.15s ease;
    cursor: pointer;
}

.nav-link i.icon-main {
    font-size: 1.1rem;
    width: 24px;
    margin-right: 10px;
    color: #64748b;
    display: flex;
    justify-content: center;
}

.nav-link .arrow {
    margin-left: auto;
    font-size: 0.75rem;
    transition: transform 0.2s ease;
}

/* Hover & Active States */
.nav-link:hover {
    background-color: var(--bg-hover);
    color: #0f172a;
}

.nav-link:hover i.icon-main {
    color: var(--primary);
}

.nav-link.active {
    background-color: #eff6ff; /* Very light blue */
    color: var(--primary);
    font-weight: 600;
}

.nav-link.active i.icon-main {
    color: var(--primary);
}

/* ===== DROPDOWN / SUBMENU ===== */
.submenu {
    display: none; /* Default hidden */
    padding-left: 2rem; /* Indentasi simpel */
    margin-top: 2px;
}

.has-submenu.open > .submenu {
    display: block; /* Langsung muncul tanpa animasi slide */
}

.has-submenu.open > .nav-link .arrow {
    transform: rotate(180deg);
}

/* Level 2 Items */
.submenu-link {
    display: block;
    padding: 0.5rem 0.75rem;
    font-size: 0.825rem;
    color: #64748b;
    text-decoration: none;
    border-radius: 6px;
    transition: color 0.15s;
    position: relative;
}

.submenu-link:hover {
    color: #0f172a;
}

.submenu-link.active {
    color: var(--primary);
    font-weight: 600;
}

/* Level 3 Indentation */
.submenu-level-3 {
    display: none;
    padding-left: 1rem;
    border-left: 1px solid #e2e8f0;
    margin-left: 0.75rem;
}

.has-submenu-level-3.open > .submenu-level-3 {
    display: block;
}

/* ===== FOOTER ===== */
.sidebar-footer {
    padding: 1rem;
    border-top: 1px solid var(--border-color);
}

.btn-logout {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 0.6rem;
    background-color: #fff1f2;
    color: #e11d48;
    border: 1px solid #fecdd3;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    transition: background-color 0.15s;
}

.btn-logout:hover {
    background-color: #ffe4e6;
}

/* ===== MOBILE ===== */
.overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.4);
    z-index: 900;
}

@media (max-width: 768px) {
    #sidebar { transform: translateX(-100%); }
    #sidebar.show { transform: translateX(0); }
    .overlay.show { display: block; }
}
</style>

<div class="overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<nav id="sidebar">
    <div class="sidebar-header">
        <div class="brand-logo">
            <i class="bi bi-grid-fill"></i>
            <span>AdminPanel</span>
        </div>
    </div>

    <div class="user-profile">
        <img src="<?= $avatarUrl ?>" alt="User" class="user-avatar">
        <div class="user-info">
            <h4><?= esc($fullName) ?></h4>
            <span><?= esc($role) ?></span>
        </div>
    </div>

    <div class="sidebar-content">
        <ul>
            <?php foreach ($menuItems as $item): ?>
                <?php if (isset($item['roles']) && !in_array($role, $item['roles'])) continue; ?>

                <?php if ($item['type'] === 'dropdown'): ?>
                    <?php 
                        // Logic Active State Parent
                        $isActive = false;
                        foreach($item['submenu'] as $sub) {
                            if(isset($sub['submenu'])){
                                foreach($sub['submenu'] as $l3) {
                                    if(strpos($currentPath, $l3['url']) === 0) { $isActive = true; break; }
                                }
                            } else {
                                if(strpos($currentPath, $sub['url']) === 0) { $isActive = true; break; }
                            }
                        }
                    ?>
                    <li class="has-submenu <?= $isActive ? 'open' : '' ?>">
                        <div class="nav-link <?= $isActive ? 'active' : '' ?>" onclick="toggleMenu(this)">
                            <i class="<?= $item['icon'] ?> icon-main"></i>
                            <span><?= $item['title'] ?></span>
                            <i class="bi bi-chevron-down arrow"></i>
                        </div>
                        <ul class="submenu">
                            <?php foreach ($item['submenu'] as $subItem): ?>
                                <?php if (in_array($role, $subItem['roles'])): ?>
                                    
                                    <?php if(isset($subItem['submenu'])): 
                                        $isL3Active = false;
                                        foreach($subItem['submenu'] as $l3) {
                                            if(strpos($currentPath, $l3['url']) === 0) { $isL3Active = true; break; }
                                        }
                                    ?>
                                        <li class="has-submenu-level-3 <?= $isL3Active ? 'open' : '' ?>">
                                            <a href="javascript:void(0)" class="submenu-link" onclick="toggleLevel3(this, event)" style="display:flex; justify-content:space-between; align-items:center;">
                                                <?= $subItem['title'] ?>
                                                <i class="bi bi-chevron-right arrow" style="font-size:0.7rem;"></i>
                                            </a>
                                            <ul class="submenu-level-3">
                                                <?php foreach($subItem['submenu'] as $lvl3Item): ?>
                                                    <?php if (in_array($role, $lvl3Item['roles'])): ?>
                                                    <li>
                                                        <a href="<?= $lvl3Item['url'] ?>" class="submenu-link <?= ($currentPath === $lvl3Item['url']) ? 'active' : '' ?>">
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
                        </ul>
                    </li>

                <?php elseif ($item['type'] === 'item'): ?>
                    <li>
                        <a href="<?= $item['url'] ?>" class="nav-link <?= ($currentPath === $item['url']) ? 'active' : '' ?>">
                            <i class="<?= $item['icon'] ?> icon-main"></i>
                            <span><?= $item['title'] ?></span>
                        </a>
                    </li>
                <?php endif; ?>

            <?php endforeach; ?>
        </ul>
    </div>

    <div class="sidebar-footer">
        <a href="/logout" class="btn-logout">
            <i class="bi bi-box-arrow-right me-2" style="margin-right:8px;"></i> Logout
        </a>
    </div>
</nav>

<script>
// Toggle Sidebar Mobile
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('show');
    document.getElementById('sidebarOverlay').classList.toggle('show');
}

// Toggle Menu Level 1
function toggleMenu(element) {
    const parent = element.parentElement;
    
    // Auto collapse menu lain (Opsional, hapus blok ini jika ingin multiple open)
    const allOpen = document.querySelectorAll('.has-submenu.open');
    allOpen.forEach(el => {
        if(el !== parent) el.classList.remove('open');
    });

    parent.classList.toggle('open');
}

// Toggle Menu Level 2/3
function toggleLevel3(element, event) {
    event.preventDefault();
    const parent = element.parentElement;
    parent.classList.toggle('open');
    
    // Rotate arrow level 3
    const arrow = element.querySelector('.arrow');
    if(arrow) {
        arrow.style.transform = parent.classList.contains('open') ? 'rotate(90deg)' : 'rotate(0deg)';
    }
}

// Auto Scroll to Active
document.addEventListener("DOMContentLoaded", function() {
    const active = document.querySelector('.nav-link.active, .submenu-link.active');
    if(active) {
        // Expand parents
        let parent = active.closest('.has-submenu');
        if(parent) parent.classList.add('open');
        
        let parentL3 = active.closest('.has-submenu-level-3');
        if(parentL3) {
            parentL3.classList.add('open');
            const arrow = parentL3.querySelector('.arrow');
            if(arrow) arrow.style.transform = 'rotate(90deg)';
        }
    }
});
</script>