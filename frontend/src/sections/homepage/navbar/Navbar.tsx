import React, { useEffect, useState } from "react";
import {
  Youtube,
  Facebook,
  Instagram,
  Twitter,
  Menu as MenuIcon,
  ChevronDown,
  X,
} from "lucide-react";
import "./navbar.css";
import api from "../../../services/api";

interface Menu {
  id_menu: string | number;
  menu_name: string;
  menu_url: string | null;
  menu_icon: string | null;
  order_number: string | number | null;
  parent_id: string | number | null;
  status: "active" | "inactive" | null;
  sub_menu?: Menu[];
  children?: Menu[];
}

function Navbar() {
  const [menus, setMenus] = useState<Menu[]>([]);
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const [openSubmenu, setOpenSubmenu] = useState<string | null>(null);

  useEffect(() => {
    const fetchMenus = async () => {
      try {
        const response = await api.get<{
          status: number;
          message: string;
          data: Menu[];
        }>("/menu");
        console.log("Data Menu dari API:", response.data.data);

        const menusWithChildren = response.data.data.map((menu) => ({
          ...menu,
          children: menu.sub_menu,
        }));

        setMenus(menusWithChildren);
      } catch (error) {
        console.error("Gagal mengambil data menu:", error);
      }
    };

    fetchMenus();
  }, []);

  // Toggle submenu di mobile
  const toggleSubmenu = (id: string | number) => {
    setOpenSubmenu(openSubmenu === String(id) ? null : String(id));
  };

  // Render menu — bisa untuk desktop atau mobile
  const renderMenus = (menuList: Menu[], depth = 0, isMobile = false) => {
    if (!Array.isArray(menuList)) return null;

    const activeMenus = menuList.filter((menu) => menu.status === "active");

    return activeMenus.map((menu) => {
      const hasChildren = menu.children && menu.children.length > 0;
      const isSubOpen = openSubmenu === String(menu.id_menu);

      return (
        <div
          key={menu.id_menu}
          className={`
            position-relative d-inline-block w-100 ${
              isMobile ? "py-2 border-bottom border-gray-200" : ""
            }
          `}
        >
          {isMobile ? (
            // MOBILE VERSION
            <>
              <div
                className="d-flex justify-content-between align-items-center px-3 py-2 cursor-pointer"
                onClick={() => {
                  if (hasChildren) {
                    toggleSubmenu(menu.id_menu);
                  } else {
                    setIsMenuOpen(false);
                  }
                }}
              >
                <a
                  href={menu.menu_url || "#"}
                  className="text-blue-900 d-block text-decoration-none"
                  onClick={(e) => {
                    if (hasChildren) e.preventDefault();
                  }}
                >
                  {menu.menu_name}
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

              {/* Submenu Mobile Dropdown */}
              {hasChildren && isSubOpen && (
                <div className="ms-4 mt-2">
                  {menu.children!.map((child) => (
                    <a
                      key={child.id_menu}
                      href={child.menu_url || "#"}
                      className="d-block px-3 py-2 text-blue-900 hover-bg-blue-50 rounded text-decoration-none"
                      onClick={() => setIsMenuOpen(false)}
                    >
                      {child.menu_name}
                    </a>
                  ))}
                </div>
              )}
            </>
          ) : (
            // DESKTOP VERSION
            <>
              <a
                href={menu.menu_url || "#"}
                className={`px-3 py-2 d-inline-block transition-colors duration-300 navbar-menu-link ${
                  depth === 0
                    ? "text-white hover-text-decoration-underline"
                    : "hover-bg-blue-100 text-blue-900"
                }`}
              >
                {menu.menu_name}
              </a>

              {/* Submenu Desktop (hover) */}
              {hasChildren && depth === 0 && (
                <div
                  className={`
                    position-absolute bg-white shadow-md rounded-md z-index-99 min-width-200px
                    submenu-hidden submenu-transition top-100 start-0 mt-1
                  `}
                >
                  {menu.children!.map((child) => (
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
            </>
          )}
        </div>
      );
    });
  };

  return (
    <nav className="bg-gradient-to-r-blue-800-950 text-white rounded-top-6 rounded-top-sm-4 rounded-top-md-4 rounded-top-lg-4 rounded-top-xl-4 rounded-top-xxl-4 shadow-md">
      <div className="d-flex align-items-center position-relative px-4 px-md-5 px-lg-6 px-xl-6 px-xxl-6 py-6 h-20 flex-wrap">
        {/* Social Icons - Desktop Only */}
        <div className="d-flex gap-3 position-absolute top-6 start-6">
          <div className="w-7 h-7 cursor-pointer text-blue-800 bg-white rounded-circle p-1 hover-scale-110 transition-transform">
            <Youtube size={20} />
          </div>
          <div className="w-7 h-7 cursor-pointer text-blue-800 bg-white rounded-circle p-1 hover-scale-110 transition-transform">
            <Facebook size={20} />
          </div>
          <div className="w-7 h-7 cursor-pointer text-blue-800 bg-white rounded-circle p-1 hover-scale-110 transition-transform">
            <Instagram size={20} />
          </div>
          <div className="w-7 h-7 cursor-pointer text-blue-800 bg-white rounded-circle p-1 hover-scale-110 transition-transform">
            <Twitter size={20} />
          </div>
        </div>

        {/* Bahasa - Desktop Only */}
        <div className="d-flex gap-2 position-absolute top-6 end-6 z-index-50">
          <img
            src="/assets/indo.png"
            alt="Bahasa Indonesia"
            className="w-8 h-8 rounded-circle cursor-pointer hover-opacity-80 transition"
          />
          <img
            src="/assets/britain.jpg"
            alt="English"
            className="w-8 h-8 rounded-circle cursor-pointer hover-opacity-80 transition"
          />
        </div>

        {/* Batik - Desktop Only */}
        <div className="batik d-none d-md-block">
          <img src="/assets/batik.png" alt="" />
        </div>

        {/* Logo & Judul */}
        <div className="flex-grow-1 d-flex flex-md-column align-items-center text-center mt-5 z-10">
          <img
            src="/assets/logo.png"
            alt="Logo Kominfo"
            className="w-24 mx-3 my-2"
            style={{ width: "6rem" }}
          />
          <h1 className="font-bold text-lg leading-snug tracking-wide">
            DINAS KOMUNIKASI DAN INFORMATIKA <br /> KOTA TANGERANG
          </h1>
          <button
            className="d-md-none text-white hamburger-btn d-flex end-6 position-absolute"
            onClick={() => {
              setIsMenuOpen(!isMenuOpen);
              setOpenSubmenu(null);
            }}
            aria-label="Toggle menu"
          >
            {isMenuOpen ? <X size={28} /> : <MenuIcon size={28} />}
          </button>
        </div>
      </div>

      <div className="border-top border-white"></div>

      {/* DESKTOP MENU */}
      <div className="w-100 navbar-wrapper d-none d-md-block">
        <div className="d-flex justify-content-center min-width-max px-3 px-md-5 py-3 font-semibold text-md text-center">
          {renderMenus(menus, 0, false)}
        </div>
      </div>

      {/* MOBILE MENU (Hamburger) */}
      {isMenuOpen && (
        <div className="d-md-none bg-white p-4 text-blue-900 position-relative z-index-100 shadow-lg">
          {renderMenus(menus, 0, true)}
        </div>
      )}
    </nav>
  );
}

export default Navbar;
