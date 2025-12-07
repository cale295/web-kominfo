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
import api from "../../services/api";

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

type MenuType = "main" | "berita";

function Navbar() {
  const location = useLocation();
  const [mainMenus, setMainMenus] = useState<MenuItem[]>([]);
  const [categoryMenus, setCategoryMenus] = useState<CategoryItem[]>([]);
  const [currentMenuType, setCurrentMenuType] = useState<MenuType>("main");
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const [openSubmenu, setOpenSubmenu] = useState<string | null>(null);

  // Deteksi route untuk menentukan menu type
  const getMenuTypeFromPath = (pathname: string): MenuType => {
    if (
      pathname.startsWith("/berita") ||
      pathname.startsWith("/news") ||
      pathname.startsWith("/artikel") ||
      pathname.includes("kategori")
    ) {
      return "berita";
    }
    return "main";
  };

  // Fungsi untuk mengambil menu utama
  const fetchMainMenus = async () => {
    try {
      const response = await api.get<{
        status: number;
        message: string;
        data: MenuItem[];
      }>("/menu");

      console.log("Data Menu dari API:", response.data.data);

      const menusWithChildren = response.data.data.map((menu) => ({
        ...menu,
        children: menu.sub_menu,
      }));

      setMainMenus(menusWithChildren);
    } catch (error) {
      console.error("Gagal mengambil data menu:", error);
    }
  };

  // Fungsi untuk mengambil menu berita/kategori
  const fetchCategoryMenus = async () => {
    try {
      const res = await api.get("/berita");
      const categories = res.data.data.kategori;

      // Filter kategori yang tampil di navbar
      const filtered = categories
        .filter((c: CategoryItem) => c.is_show_nav === "1" && c.status === "1")
        .sort(
          (a: CategoryItem, b: CategoryItem) =>
            Number(a.sorting_nav) - Number(b.sorting_nav)
        );

      // Buat tree category
      const categoryTree = filtered
        .filter(
          (c: CategoryItem) => c.id_parent === null || c.id_parent === "0"
        )
        .map((parent: CategoryItem) => ({
          ...parent,
          children: filtered.filter(
            (child: CategoryItem) => child.id_parent === parent.id_kategori
          ),
        }));

      setCategoryMenus(categoryTree);
    } catch (err) {
      console.error("Gagal mengambil kategori:", err);
    }
  };

  // Effect untuk handle route changes
  useEffect(() => {
    const newMenuType = getMenuTypeFromPath(location.pathname);
    setCurrentMenuType(newMenuType);
  }, [location.pathname]);

  // Effect initial load - fetch kedua menu sekaligus
  useEffect(() => {
    fetchMainMenus();
    fetchCategoryMenus();
  }, []);
  // Tambahkan script ini di component Navbar.tsx setelah useEffect

  useEffect(() => {
    // Function untuk set posisi submenu
    const handleSubmenuPosition = () => {
      const menuItems = document.querySelectorAll(".navbar-menu-item");

      menuItems.forEach((item) => {
        const submenu = item.querySelector(".submenu-hidden");
        if (!submenu) return;

        const link = item.querySelector(".navbar-menu-link");
        if (!link) return;

        // Event listener untuk hover
        item.addEventListener("mouseenter", () => {
          const rect = link.getBoundingClientRect();
          const submenuEl = submenu as HTMLElement;

          // Set posisi submenu berdasarkan posisi link
          submenuEl.style.position = "fixed";
          submenuEl.style.top = `${rect.bottom + 5}px`;
          submenuEl.style.left = `${rect.left}px`;
        });
      });
    };

    // Jalankan setelah render
    handleSubmenuPosition();

    // Re-calculate saat resize
    window.addEventListener("resize", handleSubmenuPosition);
    window.addEventListener("scroll", handleSubmenuPosition);

    return () => {
      window.removeEventListener("resize", handleSubmenuPosition);
      window.removeEventListener("scroll", handleSubmenuPosition);
    };
  }, [mainMenus, categoryMenus, currentMenuType]);

  // Toggle submenu di mobile
  const toggleSubmenu = (id: string | number) => {
    setOpenSubmenu(openSubmenu === String(id) ? null : String(id));
  };

  // Get current menus based on type
  const getCurrentMenus = () => {
    return currentMenuType === "main" ? mainMenus : categoryMenus;
  };

  // Render menu — untuk desktop dan mobile
  // Jika mau lebih simple, bisa pakai type assertion
  const renderMenus = (
    menus: (MenuItem | CategoryItem)[],
    depth = 0,
    isMobile = false
  ) => {
    if (!Array.isArray(menus) || menus.length === 0) {
      return null;
    }

    return menus
      .map((menu) => {
        // Type assertion berdasarkan currentMenuType
        if (currentMenuType === "main") {
          const menuItem = menu as MenuItem;
          if (menuItem.status !== "active") return null;

          const hasChildren = menuItem.children && menuItem.children.length > 0;
          const isSubOpen = openSubmenu === String(menuItem.id_menu);

          return (
            <div
              key={menuItem.id_menu}
              className={`navbar-menu-item position-relative ${
                isMobile ? "w-100" : "d-inline-block"
              } ${isMobile ? "py-2 border-bottom border-gray-200" : ""}`}
            >
              {/* Render logic untuk MenuItem */}
              {isMobile ? (
                // Mobile version untuk MenuItem
                <>
                  <div
                    className="d-flex justify-content-between align-items-center px-3 py-2 cursor-pointer"
                    onClick={() => {
                      if (hasChildren) {
                        toggleSubmenu(menuItem.id_menu);
                      } else {
                        setIsMenuOpen(false);
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
                          onClick={() => setIsMenuOpen(false)}
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
          const categoryItem = menu as CategoryItem;
          if (categoryItem.status !== "1") return null;

          const hasChildren =
            categoryItem.children && categoryItem.children.length > 0;
          const isSubOpen = openSubmenu === String(categoryItem.id_kategori);

          return (
            <div
              key={categoryItem.id_kategori}
              className={`navbar-menu-item position-relative ${
                isMobile ? "w-100" : "d-inline-block"
              } ${isMobile ? "py-2 border-bottom border-gray-200" : ""}`}
            >
              {/* Render logic untuk CategoryItem */}
              {isMobile ? (
                // Mobile version untuk CategoryItem
                <>
                  <div
                    className="d-flex justify-content-between align-items-center px-3 py-2 cursor-pointer"
                    onClick={() => {
                      if (hasChildren) {
                        toggleSubmenu(categoryItem.id_kategori);
                      } else {
                        setIsMenuOpen(false);
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
                          setIsMenuOpen(false);
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
                            setIsMenuOpen(false);
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
                      // Navigate programmatically ke halaman berita dengan parameter kategori
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
      })
      .filter(Boolean); // Filter out null values
  };

  return (
    <nav className="bg-gradient-to-r-blue-800-950 text-white rounded-top-6 rounded-top-sm-4 rounded-top-md-4 rounded-top-lg-4 rounded-top-xl-4 rounded-top-xxl-4 shadow-md">
      {/* Bagian Atas Navbar */}
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
        <div className="d-flex gap-2 position-absolute top-6 end-6 z-10">
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
        <div className="flex-grow-1 d-flex flex-column align-items-center text-center mt-5 z-10 header-mobile">
          <a
            href="/"
            style={{ textDecoration: "none", color: "white" }}
            className="d-flex flex-column align-items-center gap-3 header-row"
          >
            <img
              src="/assets/logo.png"
              alt="Logo Kominfo"
              className="w-24"
              style={{ width: "6rem" }}
            />

            <h1 className="font-bold text-lg leading-snug tracking-wide text-center text-white">
              DINAS KOMUNIKASI DAN INFORMATIKA <br /> KOTA TANGERANG
            </h1>
          </a>

          <button
            className="d-md-none text-white hamburger-btn"
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

      {/* DESKTOP MENU - PERBAIKAN DI SINI */}
      <div className="w-100 navbar-wrapper d-none d-md-block">
        <div
          className="d-flex justify-content-between align-items-center min-width-max px-3 px-md-5 py-3 font-semibold text-md"
          style={{ maxWidth: "4000px", margin: "0 auto" }}
        >
          {renderMenus(getCurrentMenus(), 0, false)}
        </div>
      </div>

      {/* MOBILE MENU (Hamburger) */}
      {isMenuOpen && (
        <div className="d-md-none bg-white p-4 text-blue-900 position-relative z-index-100 shadow-lg">
          {renderMenus(getCurrentMenus(), 0, true)}
        </div>
      )}
    </nav>
  );
}

export default Navbar;
