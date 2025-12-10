import React from "react";
import { ChevronDown } from "lucide-react";
import type { MenuItemType, CategoryItemType } from "./Navbar";

interface MenuItemProps {
  menu: MenuItemType | CategoryItemType;
  currentMenuType: "main" | "berita";
  depth: number;
  isMobile: boolean;
  isSubOpen: boolean;
  onToggleSubmenu: (id: string | number) => void;
  onCloseMenu: () => void;
}

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
    if (currentMenuType === "main") {
      const menuItem = menu as MenuItemType;
      if (menuItem.status !== "active") return null;

      const hasChildren = menuItem.children && menuItem.children.length > 0;

      return (
        <div
          className={`navbar-menu-item position-relative ${
            isMobile ? "w-100" : "d-inline-block"
          } ${isMobile ? "py-2 border-bottom border-gray-200" : ""}`}
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
                    onCloseMenu();
                  }
                }}
              >
                <a
                  href={menuItem.menu_url || "#"}
                  className="text-blue-900 d-block text-decoration-none flex-grow-1"
                  onClick={(e) => {
                    if (hasChildren) e.preventDefault();
                  }}
                >
                  {menuItem.menu_name}
                </a>
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
            <div className="position-relative d-inline-block h-100">
              <a
                href={menuItem.menu_url || "#"}
                className={`px-3 py-2 d-inline-block transition-colors duration-300 navbar-menu-link h-100 d-flex align-items-center ${
                  depth === 0
                    ? "text-white hover-text-decoration-underline"
                    : "hover-bg-blue-100 text-blue-900"
                }`}
              >
                {menuItem.menu_name}
                {hasChildren && <ChevronDown size={14} className="ms-1" />}
              </a>
              {hasChildren && depth === 0 && (
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
              )}
            </div>
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
          className={`navbar-menu-item position-relative ${
            isMobile ? "w-100" : "d-inline-block"
          } ${isMobile ? "py-2 border-bottom border-gray-200" : ""}`}
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
                    onCloseMenu();
                  }
                }}
              >
                <a
                  href={`/berita?kategori=${categoryItem.slug}`}
                  className="text-blue-900 d-block text-decoration-none flex-grow-1"
                  onClick={(e) => {
                    e.preventDefault();
                    if (!hasChildren) {
                      window.location.href = `/berita?kategori=${categoryItem.slug}`;
                      onCloseMenu();
                    }
                  }}
                >
                  {categoryItem.kategori}
                </a>
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
            <div className="position-relative d-inline-block h-100">
              <a
                href={`/berita?kategori=${categoryItem.slug}`}
                className={`px-3 py-2 d-inline-block transition-colors duration-300 navbar-menu-link h-100 d-flex align-items-center ${
                  depth === 0
                    ? "text-white hover-text-decoration-underline"
                    : "hover-bg-blue-100 text-blue-900"
                }`}
                onClick={(e) => {
                  e.preventDefault();
                  window.location.href = `/berita?kategori=${categoryItem.slug}`;
                }}
              >
                {categoryItem.kategori}
                {hasChildren && <ChevronDown size={14} className="ms-1" />}
              </a>
              {hasChildren && depth === 0 && (
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
              )}
            </div>
          )}
        </div>
      );
    }
  };

  return renderMenuItem();
};

export default MenuItem;