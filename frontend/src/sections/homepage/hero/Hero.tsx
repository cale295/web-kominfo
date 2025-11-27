import React, { useState, useEffect } from "react";
import "./hero.css";
import { Accessibility } from "lucide-react";
import Searchbar from "../../../components/searchbar/Searchbar";
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
  const [heroBanner, setHeroBanner] = useState<Banner | null>(null);
  const [isLoading, setIsLoading] = useState<boolean>(true);

  useEffect(() => {
    const fetchBanner = async () => {
      try {
        const res = await api.get("/banner");
        const banners: Banner[] = res?.data?.data || [];

        const selected = banners.find(
          (b) => b.category_banner === "3" && b.status === "1"
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
        <Searchbar />
      </header>

      <section className="hero-banner-section">
        {isLoading ? (
          <div className="hero-banner-loading">
            <p>Memuat banner...</p>
          </div>
        ) : heroBanner ? (
          heroBanner.media_type === "video" ? (
            <video
              src={`${api.defaults.baseURL?.replace(
                "/api",
                ""
              )}/uploads/banner/${heroBanner.image}`}
              className="hero-banner-video"
              autoPlay
              muted
              loop
              playsInline
            />
          ) : (
            <img
              src={`${api.defaults.baseURL?.replace(
                "/api",
                ""
              )}/uploads/banner/${heroBanner.image}`}
              alt={heroBanner.title}
              className="hero-banner-image"
            />
          )
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
