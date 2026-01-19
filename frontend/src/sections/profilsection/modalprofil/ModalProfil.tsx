import React, { useState, useEffect } from "react";
import "./ModalProfil.css";
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

const ModalProfil: React.FC = () => {
    const [heroBanner, setHeroBanner] = useState<Banner | null>(null);
  const [isLoading, setIsLoading] = useState<boolean>(true);

  useEffect(() => {
    const fetchBanner = async () => {
      try {
        const res = await api.get("/banner");
        const banners: Banner[] = res?.data?.data || [];

        const selected = banners.find(
          (b) => b.category_banner === "4" && b.status === "1"
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
        <section className="hero-banner-section">
        {isLoading ? (
          <div className="">
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
          <p>Banner tidak tersedia</p>
        )}
      </section>
    );
};

export default ModalProfil;