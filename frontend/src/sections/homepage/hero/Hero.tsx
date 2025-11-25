import React, { useState, useEffect } from "react";
import "./hero.css";
import { Search, Accessibility } from "lucide-react";
import api from "../../../services/api";

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

const HeroSection: React.FC = () => {
  const [bannerImage, setBannerImage] = useState<string>("");
  const [isLoading, setIsLoading] = useState<boolean>(true);

  useEffect(() => {
    const fetchBanner = async () => {
      try {
        const res = await api.get("/banner");
        const banners: Banner[] = res?.data?.data || [];
        
        // Filter banner dengan category_banner = "3" (banner berita) dan status aktif
        const heroBanner = banners.find(
          (banner) => banner.category_banner === "3" && banner.status === "1"
        );
        
        if (heroBanner) {
          const ROOT = api.defaults.baseURL?.replace("/api", "") ?? "";
          setBannerImage(`${ROOT}/uploads/banner/${heroBanner.image}`);
        }
      } catch (error) {
        console.error("Gagal fetch banner:", error);
      } finally {
        setIsLoading(false);
      }
    };

    fetchBanner();
  }, []);

  return (
    <div className="hero-container">
      {/* Header Bar */}
      <header className="hero-header d-flex justify-content-between align-items-center px-1 py-3">
        <button
          className="btn-disabilitas d-flex align-items-center gap-2"
          onClick={() =>
            window.dispatchEvent(new Event("toggleAccessibilityPanel"))
          }
        >
          <Accessibility className="icon-accessibility" />
          <span className="disabilitas">DISABILITAS</span>
        </button>
        <div className="search-wrapper d-flex align-items-center">
          <div className="search-input-wrapper">
            <input
              type="text"
              placeholder="Apa yang kamu cari"
              className="search-input"
            />
          </div>
          <button className="btn-search">
            <Search className="icon-search" />
          </button>
        </div>
      </header>

      {/* Hero Section with Banner */}
      <section className="hero-banner-section">
        {isLoading ? (
          <div className="hero-banner-loading">
            <p>Memuat banner...</p>
          </div>
        ) : bannerImage ? (
          <img
            src={bannerImage}
            alt="Banner Utama"
            className="hero-banner-image"
          />
        ) : (
          <div className="hero-banner-placeholder">
            <p>Banner tidak tersedia</p>
          </div>
        )}
      </section>
    </div>
  );
};

export default HeroSection;