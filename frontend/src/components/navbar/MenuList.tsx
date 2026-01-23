import React from "react";
import { ChevronDown } from "lucide-react";
import type { MenuItemType, CategoryItemType } from "./Navbar";

// ========== MENU ITEM COMPONENT ==========
interface MenuItemProps {
  menu: MenuItemType | CategoryItemType;
  currentMenuType: "main" | "berita" | "profile";
  depth: number;
  isMobile: boolean;
  isSubOpen: boolean;
  onToggleSubmenu: (id: string | number) => void;
  onCloseMenu: () => void;
}

// ========== MENU ITEM COMPONENT ==========
const MenuItem: React.FC<MenuItemProps> = ({
  menu,
  currentMenuType,
  depth,
  isMobile,
  isSubOpen,
  onToggleSubmenu,
  onCloseMenu,
}) => {
  // Fungsi untuk render menu item berdasarkan tipe
  const renderMenuItem = () => {
    if (currentMenuType === "main" || currentMenuType === "profile") {
      const menuItem = menu as MenuItemType;

      // Untuk menu profile, semua submenu aktif
      const isValid =
        currentMenuType === "profile" ? true : menuItem.status === "active";

      if (!isValid) return null;

      const hasChildren = menuItem.children && menuItem.children.length > 0;

      return (
        <div
          className={`navbar-menu-item ${
            isMobile ? "w-100 py-2 border-bottom border-gray-200" : ""
          }`}
        >
          {isMobile ? (
            // Mobile version untuk MenuItem
            <>
              <div
                className="d-flex justify-content-between align-items-center px-3 py-2 cursor-pointer"
                onClick={() => {
                  if (hasChildren) {
                    onToggleSubmenu(menuItem.id_menu);
                  } else {
                    if (menuItem.menu_url) {
                      // Untuk submenu profile, langsung navigasi
                      window.location.href = menuItem.menu_url;
                    }
                    onCloseMenu();
                  }
                }}
              >
                <span
                  className={`d-block flex-grow-1 ${
                    currentMenuType === "profile"
                      ? "text-blue-900"
                      : "text-blue-900"
                  }`}
                >
                  {menuItem.menu_name}
                </span>
                {hasChildren && (
                  <ChevronDown
                    size={16}
                    className={`transition-transform ${
                      isSubOpen ? "rotate-180" : ""
                    }`}
                  />
                )}
              </div>
              {hasChildren && isSubOpen && (
                <div className="ms-4 mt-2">
                  {menuItem.children!.map((child) => (
                    <a
                      key={child.id_menu}
                      href={child.menu_url || "#"}
                      className="d-block px-3 py-2 text-blue-900 hover-bg-blue-50 rounded text-decoration-none"
                      onClick={() => onCloseMenu()}
                    >
                      {child.menu_name}
                    </a>
                  ))}
                </div>
              )}
            </>
          ) : (
            // Desktop version untuk MenuItem
            <>
              <a
                href={menuItem.menu_url || "#"}
                className={`px-3 py-2 d-inline-flex align-items-center navbar-menu-link ${
                  currentMenuType === "profile"
                    ? "text-white profile-submenu-item"
                    : depth === 0
                    ? "text-white"
                    : "text-blue-900"
                }`}
                style={{
                  fontWeight: currentMenuType === "profile" ? "500" : "normal",
                }}
              >
                {menuItem.menu_name}
                {hasChildren && <ChevronDown size={14} className="ms-1" />}
              </a>

              {hasChildren && depth === 0 && currentMenuType === "main" && (
                <div className="navbar-submenu-container">
                  <div className="submenu-hidden">
                    {menuItem.children!.map((child) => (
                      <a
                        key={child.id_menu}
                        href={child.menu_url || "#"}
                        className="d-block px-4 py-2 text-blue-900 hover-bg-blue-50 text-decoration-none"
                      >
                        {child.menu_name}
                      </a>
                    ))}
                  </div>
                </div>
              )}
            </>
          )}
        </div>
      );
    } else {
      const categoryItem = menu as CategoryItemType;
      if (categoryItem.status !== "1") return null;

      const hasChildren =
        categoryItem.children && categoryItem.children.length > 0;

      return (
        <div
          className={`navbar-menu-item ${
            isMobile ? "w-100 py-2 border-bottom border-gray-200" : ""
          }`}
        >
          {isMobile ? (
            // Mobile version untuk CategoryItem
            <>
              <div
                className="d-flex justify-content-between align-items-center px-3 py-2 cursor-pointer"
                onClick={() => {
                  if (hasChildren) {
                    onToggleSubmenu(categoryItem.id_kategori);
                  } else {
                    window.location.href = `/berita?kategori=${categoryItem.slug}`;
                    onCloseMenu();
                  }
                }}
              >
                <span className="text-blue-900 d-block flex-grow-1">
                  {categoryItem.kategori}
                </span>
                {hasChildren && (
                  <ChevronDown
                    size={16}
                    className={`transition-transform ${
                      isSubOpen ? "rotate-180" : ""
                    }`}
                  />
                )}
              </div>
              {hasChildren && isSubOpen && (
                <div className="ms-4 mt-2">
                  {categoryItem.children!.map((child) => (
                    <a
                      key={child.id_kategori}
                      href={`/berita?kategori=${child.slug}`}
                      className="d-block px-3 py-2 text-blue-900 hover-bg-blue-50 rounded text-decoration-none"
                      onClick={(e) => {
                        e.preventDefault();
                        window.location.href = `/berita?kategori=${child.slug}`;
                        onCloseMenu();
                      }}
                    >
                      {child.kategori}
                    </a>
                  ))}
                </div>
              )}
            </>
          ) : (
            // Desktop version untuk CategoryItem
            <>
              <a
                href={`/berita?kategori=${categoryItem.slug}`}
                className={`px-3 py-2 d-inline-flex align-items-center navbar-menu-link text-white`}
                onClick={(e) => {
                  e.preventDefault();
                  window.location.href = `/berita?kategori=${categoryItem.slug}`;
                }}
              >
                {categoryItem.kategori}
                {hasChildren && <ChevronDown size={14} className="ms-1" />}
              </a>
              {hasChildren && depth === 0 && (
                <div className="navbar-submenu-container">
                  <div className="submenu-hidden">
                    {categoryItem.children!.map((child) => (
                      <a
                        key={child.id_kategori}
                        href={`/berita?kategori=${child.slug}`}
                        className="d-block px-4 py-2 text-blue-900 hover-bg-blue-50 text-decoration-none"
                        onClick={(e) => {
                          e.preventDefault();
                          window.location.href = `/berita?kategori=${child.slug}`;
                        }}
                      >
                        {child.kategori}
                      </a>
                    ))}
                  </div>
                </div>
              )}
            </>
          )}
        </div>
      );
    }
  };

  return renderMenuItem();
};

// ========== MENU LIST COMPONENT ==========
interface MenuListProps {
  menus: (MenuItemType | CategoryItemType)[];
  currentMenuType: "main" | "berita" | "profile";
  depth: number;
  isMobile: boolean;
  openSubmenu: string | null;
  onToggleSubmenu: (id: string | number) => void;
  onCloseMenu: () => void;
}

const MenuList: React.FC<MenuListProps> = ({
  menus,
  currentMenuType,
  depth,
  isMobile,
  openSubmenu,
  onToggleSubmenu,
  onCloseMenu,
}) => {
  if (!Array.isArray(menus) || menus.length === 0) {
    return null;
  }

  return (
    <>
      {menus.map((menu) => {
        // Get the correct ID based on menu type
        const menuId =
          currentMenuType === "berita"
            ? (menu as CategoryItemType).id_kategori
            : (menu as MenuItemType).id_menu;

        const isSubOpen = openSubmenu === String(menuId);

        // Check status based on menu type
        let isValidMenu = true;
        if (currentMenuType === "berita") {
          isValidMenu = (menu as CategoryItemType).status === "1";
        } else if (currentMenuType === "main") {
          isValidMenu = (menu as MenuItemType).status === "active";
        }
        // Untuk profile, semua menu valid

        if (!isValidMenu) return null;

        return (
          <MenuItem
            key={menuId}
            menu={menu}
            currentMenuType={currentMenuType}
            depth={depth}
            isMobile={isMobile}
            isSubOpen={isSubOpen}
            onToggleSubmenu={onToggleSubmenu}
            onCloseMenu={onCloseMenu}
          />
        );
      })}
    </>
  );
};

export default MenuList;
