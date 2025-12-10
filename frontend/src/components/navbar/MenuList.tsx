import React from "react";
import MenuItem from "./MenuItem";
import type { MenuItemType, CategoryItemType } from "./Navbar";

interface MenuListProps {
  menus: (MenuItemType | CategoryItemType)[];
  currentMenuType: "main" | "berita";
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
          currentMenuType === "main"
            ? (menu as MenuItemType).id_menu
            : (menu as CategoryItemType).id_kategori;

        const isSubOpen = openSubmenu === String(menuId);

        // Check status based on menu type
        const isValidMenu =
          currentMenuType === "main"
            ? (menu as MenuItemType).status === "active"
            : (menu as CategoryItemType).status === "1";

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