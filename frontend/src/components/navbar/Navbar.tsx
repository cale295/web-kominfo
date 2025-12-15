import React, { useEffect, useState } from "react";
import { useLocation } from "react-router-dom";
import { Menu as MenuIcon, ChevronDown, X } from "lucide-react";
import "./navbar.css";
import api from "../../services/api";
import MenuList from "./MenuList";
import MenuItem from "./MenuItem";

// Interface untuk tipe menu yang berbeda
export interface MenuItemType {
  id_menu: string | number;
  menu_name: string;
  menu_url: string | null;
  menu_icon: string | null;
  order_number: string | number | null;
  parent_id: string | number | null;
  status: "active" | "inactive" | null;
  sub_menu?: MenuItemType[];
  children?: MenuItemType[];
}

export interface CategoryItemType {
  id_kategori: string | number;
  kategori: string;
  slug: string;
  id_parent: string | number | null;
  is_show_nav: string;
  sorting_nav: string | number;
  children?: CategoryItemType[];
  status: string;
}

export interface KontakSocialType {
  id_kontak_social: string;
  platform: string;
  icon_class: string;
  link_url: string;
  urutan: string;
  status: string;
}

interface Banner {
  id_banner: string;
  title: string;
  status: string;
  image: string;
  media_type: string;
  url: string;
  url_yt: string;
  sorting: string;
  keterangan: string;
  category_banner: string;
}

type MenuType = "main" | "berita";

function Navbar() {
  const location = useLocation();
  const [mainMenus, setMainMenus] = useState<MenuItemType[]>([]);
  const [categoryMenus, setCategoryMenus] = useState<CategoryItemType[]>([]);
  const [currentMenuType, setCurrentMenuType] = useState<MenuType>("main");
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const [openSubmenu, setOpenSubmenu] = useState<string | null>(null);
  const [kontakSocials, setKontakSocials] = useState<KontakSocialType[]>([]);
  const [heroBanner, setHeroBanner] = useState<Banner | null>(null);
  const [isLoading, setIsLoading] = useState<boolean>(true);

  useEffect(() => {
    const fetchBanner = async () => {
      try {
        const res = await api.get("/banner");
        const banners: Banner[] = res?.data?.data || [];

        const selected = banners.find(
          (b) => b.category_banner === "1" && b.status === "1"
        );

        if (selected) setHeroBanner(selected);
      } catch (error) {
        console.error("Gagal fetch banner:", error);
      } finally {
        setIsLoading(false);
      }
    };

    fetchBanner();
  }, []);

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

  const fetchKontakSocials = async () => {
    try {
      const res = await api.get("/kontak_social");
      const socials = res.data.data;

      const activeSocials = socials
        .filter((s: KontakSocialType) => s.status === "1")
        .sort(
          (a: KontakSocialType, b: KontakSocialType) =>
            Number(a.urutan) - Number(b.urutan)
        );

      setKontakSocials(activeSocials);
    } catch (err) {
      console.error("Gagal mengambil kontak sosial:", err);
    }
  };

  useEffect(() => {
    fetchKontakSocials();
  }, []);

  // Fungsi untuk mengambil menu utama
  const fetchMainMenus = async () => {
    try {
      const response = await api.get<{
        status: number;
        message: string;
        data: MenuItemType[];
      }>("/menu");

      console.log("Data Menu dari API:", response.data.data);

      // Filter hanya menu dengan status 'active' dan map children
      const activeMenus = response.data.data
        .filter((menu) => menu.status === "active")
        .map((menu) => ({
          ...menu,
          children:
            menu.sub_menu?.filter((sub) => sub.status === "active") || [],
        }));

      setMainMenus(activeMenus);
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
        .filter(
          (c: CategoryItemType) => c.is_show_nav === "1" && c.status === "1"
        )
        .sort(
          (a: CategoryItemType, b: CategoryItemType) =>
            Number(a.sorting_nav) - Number(b.sorting_nav)
        );

      // Buat tree category
      const categoryTree = filtered
        .filter(
          (c: CategoryItemType) => c.id_parent === null || c.id_parent === "0"
        )
        .map((parent: CategoryItemType) => ({
          ...parent,
          children: filtered.filter(
            (child: CategoryItemType) => child.id_parent === parent.id_kategori
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

  // Toggle submenu di mobile
  const toggleSubmenu = (id: string | number) => {
    setOpenSubmenu(openSubmenu === String(id) ? null : String(id));
  };

  // Get current menus based on type
  const getCurrentMenus = () => {
    return currentMenuType === "main" ? mainMenus : categoryMenus;
  };

  return (
    <nav className="bg-gradient-to-r-blue-800-950 text-white rounded-top-6 rounded-top-sm-4 rounded-top-md-4 rounded-top-lg-4 rounded-top-xl-4 rounded-top-xxl-4 shadow-md">
      {/* Bagian Atas Navbar */}
      <div className="d-flex align-items-center position-relative px-4 px-md-5 px-lg-6 px-xl-6 px-xxl-6 py-6 h-20 flex-wrap">
        {/* Social Icons - Desktop Only */}
        <div className="d-flex gap-3 position-absolute top-6 start-6">
          {kontakSocials.map((social) => (
            <a
              key={social.id_kontak_social}
              href={social.link_url}
              target="_blank"
              rel="noopener noreferrer"
              className="w-7 h-7 text-blue-800 bg-white rounded-circle p-1 hover-scale-110 transition-transform d-flex justify-content-center align-items-center"
              style={{ textDecoration: "none" }}
            >
              <i className={social.icon_class}></i>
            </a>
          ))}
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
            {isLoading ? (
              <div className="hero-banner-loading">
                <p>Memuat banner...</p>
              </div>
            ) : heroBanner ? (
              <img
                src={`${api.defaults.baseURL?.replace(
                  "/api",
                  ""
                )}/uploads/banner/${heroBanner.image}`}
                alt={heroBanner.title}
                 className="w-24"
              style={{ width: "6rem" }}
              />
            ) : (
              <div className="hero-banner-placeholder">
                <p>Banner tidak tersedia</p>
              </div>
            )}

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

      {/* DESKTOP MENU */}
      <div className="w-100 navbar-wrapper d-none d-md-block">
        <div
          className="d-flex justify-content-between align-items-center min-width-max px-3 px-md-5 py-3 font-semibold text-md"
          style={{ maxWidth: "4000px", margin: "0 auto" }}
        >
          <MenuList
            menus={getCurrentMenus()}
            currentMenuType={currentMenuType}
            depth={0}
            isMobile={false}
            openSubmenu={openSubmenu}
            onToggleSubmenu={toggleSubmenu}
            onCloseMenu={() => {}}
          />
        </div>
      </div>

      {/* MOBILE MENU (Hamburger) */}
      {isMenuOpen && (
        <div className="d-md-none bg-white p-4 text-blue-900 position-relative z-index-100 shadow-lg">
          <MenuList
            menus={getCurrentMenus()}
            currentMenuType={currentMenuType}
            depth={0}
            isMobile={true}
            openSubmenu={openSubmenu}
            onToggleSubmenu={toggleSubmenu}
            onCloseMenu={() => setIsMenuOpen(false)}
          />
        </div>
      )}
    </nav>
  );
}

export default Navbar;
