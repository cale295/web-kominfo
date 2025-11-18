import React, { useEffect, useState } from "react";
import { Youtube, Facebook, Instagram, Twitter } from "lucide-react";
import "./css/navbar.css";
import api from "../../services/api";

interface Category {
  id_kategori: string | number;
  kategori: string;
  slug: string;
  id_parent: string | number | null;
  is_show_nav: string;
  sorting_nav: string | number;
  children?: Category[];
  status: string;
}


function Navbar() {
  const [menus, setMenus] = useState<Category[]>([]);

  useEffect(() => {
  const fetchCategories = async () => {
    try {
      const res = await api.get("/berita"); // endpoint kamu yang ada kategori
      const categories = res.data.data.kategori;

      // Filter hCategorya yang tampil di navbar
      const filtered = categories
        .filter((c: Category) => c.is_show_nav === "1" && c.status === "1")
        .sort((a: Category, b: Category) => Number(a.sorting_nav) - Number(b.sorting_nav));

      // Buat tree category
      const categoryTree = filtered
        .filter((c: Category) => c.id_parent === null || c.id_parent === "0")
        .map((parent: Category) => ({
          ...parent,
          children: filtered.filter((child: Category) => child.id_parent === parent.id_kategori)
        }));

      setMenus(categoryTree);
    } catch (err) {
      console.error("Gagal mengambil kategori:", err);
    }
  };

  fetchCategories();
}, []);


  const renderMenus = (menuList: Category[], depth = 0) => {
  return menuList.map((menu) => (
    <div key={menu.id_kategori} className="navbar-menu-item position-relative d-inline-block">
      
      <a
        href={`/berita/kategori/${menu.slug}`}
        className={`px-3 py-2 d-inline-block navbar-menu-link ${
          depth === 0 ? "text-white" : "text-blue-900"
        }`}
      >
        {menu.kategori}
      </a>

      {menu.children && menu.children.length > 0 && (
        <div
          className={`
            position-absolute bg-white shadow-md rounded-md
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
        
        <a href="/" className="flex-grow-1 d-flex flex-column align-items-center justify-content-center text-decoration-none text-white">
          <img
            src="/assets/logo.png"
            alt="Logo Kominfo"
            className="w-24 mb-3 mt-7"
            style={{ width: "6rem" }}
          />
          <h1 className="font-bold text-lg leading-snug text-center tracking-wide">
            DINAS KOMUNIKASI DAN INFORMATIKA <br /> KOTA TANGERANG
          </h1>
        </a>

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
