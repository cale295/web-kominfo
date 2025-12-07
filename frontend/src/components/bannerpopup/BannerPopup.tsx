import React, { useEffect, useState } from "react";
import { Modal } from "react-bootstrap";
import api from "../../services/api"; // axios
import "./BannerPopup.css";

interface BannerPopup {
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
  is_delete: string;
}

const BannerPopupComponent: React.FC = () => {
  const [show, setShow] = useState(false);
  const [banner, setBanner] = useState<BannerPopup | null>(null);
  const BASE_URL = import.meta.env.VITE_API_URL;

  const fetchBanner = async () => {
    try {
      const res = await api.get("/banner");

      // PASTIKAN data berupa array
      const banners = Array.isArray(res.data)
        ? res.data
        : Array.isArray(res.data.data)
        ? res.data.data
        : Array.isArray(res.data?.data?.data)
        ? res.data.data.data
        : [];

      if (!banners.length) {
        console.warn("Data banner kosong atau format salah:", res.data);
        return;
      }

      const popupBanner = banners.find(
        (item: BannerPopup) =>
          item.status === "1" &&
          item.category_banner === "2" &&
          item.is_delete === "0"
      );

      if (popupBanner) {
        const alreadyShown = sessionStorage.getItem("popupShown");

        if (!alreadyShown) {
          setTimeout(() => {
            setBanner(popupBanner);
            setShow(true);
            sessionStorage.setItem("popupShown", "true");
          }, 1500);
        }
      }
    } catch (error) {
      console.error("Gagal load banner popup", error);
    }
  };

  useEffect(() => {
    fetchBanner();
  }, []);

  return (
    <Modal show={show} onHide={() => setShow(false)} centered size="lg">
      {banner && (
        <>
          <Modal.Header closeButton>
            <Modal.Title>{banner.title}</Modal.Title>
          </Modal.Header>

          <Modal.Body className="text-center">
            {/* Kalau Image */}
            {banner.media_type === "image" && (
              <a href={banner.url} target="_blank" rel="noopener noreferrer">
                <img
                  src={`${BASE_URL}/uploads/banner/${banner.image}`}
                  alt={banner.title}
                  className="popup-banner-img"
                />
              </a>
            )}

            {/* Kalau Youtube */}
            {banner.media_type === "youtube" && banner.url_yt && (
              <div className="ratio ratio-16x9">
                <iframe
                  src={banner.url_yt}
                  title={banner.title}
                  allowFullScreen
                ></iframe>
              </div>
            )}

            {/* Keterangan */}
            {banner.keterangan && <p className="mt-3">{banner.keterangan}</p>}
          </Modal.Body>
        </>
      )}
    </Modal>
  );
};

export default BannerPopupComponent;
