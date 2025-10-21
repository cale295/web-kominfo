import React, { useEffect, useState } from "react";
import { Youtube, Facebook, Instagram, Twitter } from "lucide-react";
import "../index.css";
import api from "../services/api";

interface Menu {
  id_menu: string | number;
  menu_name: string;
  menu_url: string | null;
  menu_icon: string | null;
  order_number: string | number | null;
  parent_id: string | number | null;
  status: "active" | "inactive" | null;
  children?: Menu[];
}

function Navbar() {
  const [menus, setMenus] = useState<Menu[]>([]);

  useEffect(() => {
    const fetchMenus = async () => {
      try {
        const response = await api.get<{ status: number; message: string; data: Menu[] }>("/menu");
        setMenus(response.data.data || []);
      } catch (error) {
        console.error("Gagal mengambil data menu:", error);
      }
    };

    fetchMenus();
  }, []);

  // 🔹 Render recursive multi-level menu
  const renderMenus = (menuList: Menu[], depth = 0) => {
    return menuList.map((menu) => (
      <div key={menu.id_menu} className="relative group">
        <a
          href={menu.menu_url || "#"}
          className={`px-3 py-2 inline-block transition-colors duration-300 ${
            depth === 0 ? "hover:underline" : "hover:bg-blue-100 text-blue-900"
          }`}
        >
          {menu.menu_name}
        </a>

        {/* Kalau punya anak, tampilkan dropdown */}
        {menu.children && menu.children.length > 0 && (
          <div
            className={`
              absolute bg-white shadow-md rounded-md z-50 min-w-[200px]
              opacity-0 translate-y-2 invisible
              group-hover:opacity-100 group-hover:translate-y-0 group-hover:visible
              transition-all duration-300 ease-out
              ${depth === 0 ? "top-full left-0 mt-1" : "top-0 left-full ml-1"}
            `}
          >
            {renderMenus(menu.children, depth + 1)}
          </div>
        )}
      </div>
    ));
  };

  return (
    // 👇 PERBAIKAN DI SINI: class "overflow-hidden" dihapus
    <nav className="bg-gradient-to-r from-blue-800 to-blue-950 text-white rounded-t-4xl shadow-md">
      {/* 🔹 Top Bar */}
      <div className="flex items-center px-16 py-6 relative">
        {/* Left icons */}
        <div className="hidden md:flex space-x-4 absolute top-6 left-16">
          <Youtube className="w-7 h-7 cursor-pointer text-blue-800 bg-white rounded-full p-1 hover:scale-110 transition-transform" />
          <Facebook className="w-7 h-7 cursor-pointer text-blue-800 bg-white rounded-full p-1 hover:scale-110 transition-transform" />
          <Instagram className="w-7 h-7 cursor-pointer text-blue-800 bg-white rounded-full p-1 hover:scale-110 transition-transform" />
          <Twitter className="w-7 h-7 cursor-pointer text-blue-800 bg-white rounded-full p-1 hover:scale-110 transition-transform" />
        </div>

        {/* Logo & Title */}
        <div className="flex-1 flex flex-col items-center justify-center">
          <img src="/assets/logo.png" alt="Logo Kominfo" className="w-24 mb-3 mt-7" />
          <h1 className="font-bold text-lg leading-snug text-center tracking-wide">
            DINAS KOMUNIKASI DAN INFORMATIKA <br /> KOTA TANGERANG
          </h1>
        </div>

        {/* Language flags */}
        <div className="flex space-x-5 absolute top-6 right-16">
          <img
            src="/assets/indo.png"
            alt="Bahasa Indonesia"
            className="w-8 h-8 rounded-full cursor-pointer hover:opacity-80 transition"
          />
          <img
            src="/assets/britain.jpg"
            alt="English"
            className="w-8 h-8 rounded-full cursor-pointer hover:opacity-80 transition"
          />
        </div>
      </div>

      {/* Divider */}
      <div className="border-t border-white"></div>

      {/* 🔹 Menu bar */}
      <div className="w-full overflow-x-auto lg:overflow-visible">
        <div className="flex justify-between min-w-max px-10 md:px-20 py-3 font-semibold text-md whitespace-nowrap">
          {renderMenus(menus)}
        </div>
      </div>
    </nav>
  );
}

export default Navbar;