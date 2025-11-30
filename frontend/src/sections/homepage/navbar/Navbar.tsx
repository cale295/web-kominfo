import React, { useEffect, useState } from "react";
import { useLocation } from "react-router-dom";
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

// Interface untuk tipe menu yang berbeda
interface MenuItem {
  id_menu: string | number;
  menu_name: string;
  menu_url: string | null;
  menu_icon: string | null;
  order_number: string | number | null;
  parent_id: string | number | null;
  status: "active" | "inactive" | null;
  sub_menu?: MenuItem[];
  children?: MenuItem[];
}

interface CategoryItem {
  id_kategori: string | number;
  kategori: string;
  slug: string;
  id_parent: string | number | null;
  is_show_nav: string;
  sorting_nav: string | number;
  children?: CategoryItem[];
  status: string;
}

type MenuType = 'main' | 'berita';

function Navbar() {
  const location = useLocation();
  const [menus, setMenus] = useState<(MenuItem | CategoryItem)[]>([]);
  const [menuType, setMenuType] = useState<MenuType>('main');
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const [openSubmenu, setOpenSubmenu] = useState<string | null>(null);
  const [isLoading, setIsLoading] = useState(false);

  // Deteksi route untuk menentukan menu type
  const getMenuTypeFromPath = (pathname: string): MenuType => {
    if (pathname.startsWith('/berita') || 
        pathname.startsWith('/news') || 
        pathname.startsWith('/artikel') ||
        pathname.includes('kategori')) {
      return 'berita';
    }
    return 'main';
  };

  // Fungsi untuk mengambil menu utama
  const fetchMainMenus = async () => {
    if (menuType === 'main' && menus.length > 0) return; // Skip jika sudah loaded
    
    setIsLoading(true);
    try {
      const response = await api.get<{
        status: number;
        message: string;
        data: MenuItem[];
      }>("/menu");

      const menusWithChildren = response.data.data
        .filter((menu) => menu.status === "active")
        .map((menu) => ({
          ...menu,
          children: menu.sub_menu?.filter((sub) => sub.status === "active") || [],
        }));

      setMenus(menusWithChildren);
      setMenuType('main');
    } catch (error) {
      console.error("Gagal mengambil data menu:", error);
    } finally {
      setIsLoading(false);
    }
  };

  // Fungsi untuk mengambil menu berita/kategori
  const fetchCategoryMenus = async () => {
    if (menuType === 'berita' && menus.length > 0) return; // Skip jika sudah loaded
    
    setIsLoading(true);
    try {
      const res = await api.get("/berita");
      const categories = res.data.data.kategori;

      const filtered = categories
        .filter((c: CategoryItem) => c.is_show_nav === "1" && c.status === "1")
        .sort((a: CategoryItem, b: CategoryItem) => 
          Number(a.sorting_nav) - Number(b.sorting_nav)
        );

      const categoryTree = filtered
        .filter((c: CategoryItem) => c.id_parent === null || c.id_parent === "0")
        .map((parent: CategoryItem) => ({
          ...parent,
          children: filtered.filter((child: CategoryItem) => 
            child.id_parent === parent.id_kategori
          )
        }));

      setMenus(categoryTree);
      setMenuType('berita');
    } catch (err) {
      console.error("Gagal mengambil kategori:", err);
      // Fallback ke menu utama jika gagal
      fetchMainMenus();
    } finally {
      setIsLoading(false);
    }
  };

  // Switch menu berdasarkan route
  const switchMenuBasedOnRoute = () => {
    const newMenuType = getMenuTypeFromPath(location.pathname);
    
    if (newMenuType !== menuType) {
      if (newMenuType === 'main') {
        fetchMainMenus();
      } else {
        fetchCategoryMenus();
      }
    }
  };

  // Effect untuk handle route changes
  useEffect(() => {
    switchMenuBasedOnRoute();
  }, [location.pathname]);

  // Effect initial load
  useEffect(() => {
    const initialMenuType = getMenuTypeFromPath(location.pathname);
    if (initialMenuType === 'main') {
      fetchMainMenus();
    } else {
      fetchCategoryMenus();
    }
  }, []);

  // Toggle submenu di mobile
  const toggleSubmenu = (id: string | number) => {
    setOpenSubmenu(openSubmenu === String(id) ? null : String(id));
  };

  // Render menu utama
  const renderMainMenus = (menuList: MenuItem[], depth = 0, isMobile = false) => {
    if (!Array.isArray(menuList) || menuList.length === 0) {
      return <div className="text-white px-3 py-2">Menu tidak tersedia</div>;
    }

    return menuList.map((menu) => {
      const hasChildren = menu.children && menu.children.length > 0;
      const isSubOpen = openSubmenu === String(menu.id_menu);

      return (
        <div
          key={menu.id_menu}
          className={`navbar-menu-item position-relative ${
            isMobile ? "w-100 py-2 border-bottom border-gray-200" : "d-inline-block"
          }`}
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
                  className="text-blue-900 d-block text-decoration-none fw-semibold"
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
            <div className="position-relative d-inline-block">
              <a
                href={menu.menu_url || "#"}
                className={`px-3 py-2 d-inline-block transition-colors duration-300 navbar-menu-link ${
                  depth === 0
                    ? "text-white hover-text-decoration-underline"
                    : "hover-bg-blue-100 text-blue-900"
                }`}
              >
                {menu.menu_name}
                {hasChildren && <ChevronDown size={14} className="ms-1" />}
              </a>

              {hasChildren && depth === 0 && (
                <div className="navbar-submenu position-absolute bg-white shadow-lg rounded-md z-index-99 min-width-200px top-100 start-0 mt-1">
                  {menu.children!.map((child) => (
                    <a
                      key={child.id_menu}
                      href={child.menu_url || "#"}
                      className="d-block px-4 py-3 text-blue-900 hover-bg-blue-50 text-decoration-none border-bottom border-gray-100 last-border-bottom-0"
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
    });
  };

  // Render menu kategori berita
  const renderCategoryMenus = (menuList: CategoryItem[], depth = 0, isMobile = false) => {
    if (!Array.isArray(menuList) || menuList.length === 0) {
      return <div className="text-white px-3 py-2">Kategori tidak tersedia</div>;
    }

    return menuList.map((menu) => {
      const hasChildren = menu.children && menu.children.length > 0;
      const isSubOpen = openSubmenu === String(menu.id_kategori);

      return (
        <div
          key={menu.id_kategori}
          className={`navbar-menu-item position-relative ${
            isMobile ? "w-100 py-2 border-bottom border-gray-200" : "d-inline-block"
          }`}
        >
          {isMobile ? (
            // MOBILE VERSION
            <>
              <div
                className="d-flex justify-content-between align-items-center px-3 py-2 cursor-pointer"
                onClick={() => {
                  if (hasChildren) {
                    toggleSubmenu(menu.id_kategori);
                  } else {
                    setIsMenuOpen(false);
                  }
                }}
              >
                <a
                  href={`/berita/kategori/${menu.slug}`}
                  className="text-blue-900 d-block text-decoration-none fw-semibold"
                  onClick={(e) => {
                    if (hasChildren) e.preventDefault();
                  }}
                >
                  {menu.kategori}
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
                  {menu.children!.map((child) => (
                    <a
                      key={child.id_kategori}
                      href={`/berita/kategori/${child.slug}`}
                      className="d-block px-3 py-2 text-blue-900 hover-bg-blue-50 rounded text-decoration-none"
                      onClick={() => setIsMenuOpen(false)}
                    >
                      {child.kategori}
                    </a>
                  ))}
                </div>
              )}
            </>
          ) : (
            // DESKTOP VERSION
            <div className="position-relative d-inline-block">
              <a
                href={`/berita/kategori/${menu.slug}`}
                className={`px-3 py-2 d-inline-block transition-colors duration-300 navbar-menu-link ${
                  depth === 0
                    ? "text-white hover-text-decoration-underline"
                    : "hover-bg-blue-100 text-blue-900"
                }`}
              >
                {menu.kategori}
                {hasChildren && <ChevronDown size={14} className="ms-1" />}
              </a>

              {hasChildren && depth === 0 && (
                <div className="navbar-submenu position-absolute bg-white shadow-lg rounded-md z-index-99 min-width-200px top-100 start-0 mt-1">
                  {menu.children!.map((child) => (
                    <a
                      key={child.id_kategori}
                      href={`/berita/kategori/${child.slug}`}
                      className="d-block px-4 py-3 text-blue-900 hover-bg-blue-50 text-decoration-none border-bottom border-gray-100 last-border-bottom-0"
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
    });
  };

  // Render menu berdasarkan tipe
  const renderMenus = (isMobile = false) => {
    if (isLoading) {
      return (
        <div className="text-center py-2">
          <div className="spinner-border spinner-border-sm text-white" role="status">
            <span className="visually-hidden">Loading...</span>
          </div>
        </div>
      );
    }

    if (menuType === 'main') {
      return renderMainMenus(menus as MenuItem[], 0, isMobile);
    } else {
      return renderCategoryMenus(menus as CategoryItem[], 0, isMobile);
    }
  };

  // Dapatkan judul menu berdasarkan tipe
  const getMenuTitle = () => {
    return menuType === 'main' ? 'Menu Utama' : 'Kategori Berita';
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
          
          {/* Menu Type Indicator */}
          <div className="d-none d-md-block mt-2">
            <span className="badge bg-light text-blue-800 fs-6">
              {getMenuTitle()}
            </span>
          </div>

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
          {renderMenus(false)}
        </div>
      </div>

      {/* MOBILE MENU (Hamburger) */}
      {isMenuOpen && (
        <div className="d-md-none bg-white p-4 text-blue-900 position-relative z-index-100 shadow-lg">
          <div className="text-center mb-3">
            <span className="badge bg-blue-800 text-white">
              {getMenuTitle()}
            </span>
          </div>
          {renderMenus(true)}
        </div>
      )}
    </nav>
  );
}

export default Navbar;