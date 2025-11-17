import React, { useEffect, useState } from "react";
import { Youtube, Facebook, Instagram, Twitter } from "lucide-react";
import "../css/navbar.css";
import api from "../services/api";

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

        console.log("Data Menu Setelah Rename:", menusWithChildren);
        setMenus(menusWithChildren);
      } catch (error) {
        console.error("Gagal mengambil data menu:", error);
      }
    };

    fetchMenus();
  }, []);

  const renderMenus = (menuList: Menu[], depth = 0) => {
    if (!Array.isArray(menuList)) {
      console.warn("renderMenus menerima argumen bukan array:", menuList);
      return null;
    }

    const activeMenus = menuList.filter((menu) => menu.status === "active");

    return activeMenus.map((menu) => (
      <div
        key={menu.id_menu}
        className="navbar-menu-item position-relative d-inline-block"
      >
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

        {menu.children && menu.children.length > 0 && (
          <div
            className={`
            position-absolute bg-white shadow-md rounded-md z-index-99 min-width-200px
            submenu-hidden submenu-transition
            ${depth === 0 ? "top-100 start-0 mt-1" : "top-0 start-100 ms-1"}
          `}
          >
            {renderMenus(menu.children, depth + 1)}
          </div>
        )}
      </div>
    ));
  };

  return (
    <nav className="bg-gradient-to-r-blue-800-950 text-white rounded-top-6 rounded-top-sm-4 rounded-top-md-4 rounded-top-lg-4 rounded-top-xl-4 rounded-top-xxl-4 shadow-md">
      <div className="d-flex align-items-center position-relative px-4 px-md-5 px-lg-6 px-xl-6 px-xxl-6 py-6 h-10">
        <div className="d-none d-sm-flex gap-3 position-absolute top-6 start-6 start-md-6 start-lg-6 start-xl-6 start-xxl-6">
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

        <div className="flex-grow-1 d-flex flex-column align-items-center justify-content-center">
          <img
            src="/assets/logo.png"
            alt="Logo Kominfo"
            className="w-24 mb-3 mt-7"
            style={{ width: "6rem" }}
          />
          <h1 className="font-bold text-lg leading-snug text-center tracking-wide">
            DINAS KOMUNIKASI DAN INFORMATIKA <br /> KOTA TANGERANG
          </h1>
        </div>

        <div className="batik">
          <img src="/assets/batik.png" alt="" />
        </div>

        <div className="d-flex gap-2 position-absolute top-6 end-6 end-md-6 end-lg-6 end-xl-6 end-xxl-6">
          <img
            src="/assets/indo.png"
            alt="Bahasa Indonesia"
            className="w-8 h-8 rounded-circle cursor-pointer hover-opacity-80 transition"
            style={{ width: "2rem", height: "2rem" }}
          />
          <img
            src="/assets/britain.jpg"
            alt="English"
            className="w-8 h-8 rounded-circle cursor-pointer hover-opacity-80 transition"
            style={{ width: "2rem", height: "2rem" }}
          />
        </div>
      </div>

      <div className="border-top border-white"></div>

      <div className="w-100 navbar-wrapper">
        <div className="d-flex justify-content-between min-width-max px-3 px-md-5 px-lg-5 px-xl-5 px-xxl-5 py-3 font-semibold text-md">
          {renderMenus(menus)}
        </div>
      </div>
    </nav>
  );
}

export default Navbar;
