import React, { useEffect } from "react";
import "./Footer.css";
import api from "../../../services/api";

interface opd {
  id_opd_info: number;
  website_name: string;
  official_title: string;
  adress: string;
  email: string;
  logo_cominfo: string;
}

interface socialMedia {
  id_footer_social: number;
  platform_name: string;
  paltform_icon: string;
}

interface visitorCount {
  id_footer_statis: number;
  stat_label: string;
  stat_value: number;
}

const Footer: React.FC = () => {
  const [visitorCounts, setVisitorCounts] = React.useState<visitorCount[]>([]);
  const [loading, setLoading] = React.useState<boolean>(true);
  const [error, setError] = React.useState<string | null>(null);
  const [opdInfo, setOpdInfo] = React.useState<opd | null>(null);
  const [opdLoading, setOpdLoading] = React.useState<boolean>(true);
  const [opdError, setOpdError] = React.useState<string | null>(null);

  useEffect(() => {
    const fetchOpdInfo = async () => {
      try {
        setOpdLoading(true);
        setOpdError(null);

        const response = await api.get("/footer_opd");

        if (response.data.status && response.data.data.length > 0) {
          setOpdInfo(response.data.data[0]);
        } else {
          setOpdInfo(null);
        }
      } catch (err: any) {
        console.error("Error fetching OPD info", err);
        setOpdError("Gagal memuat data OPD. Silahkan coba lagi.");
      } finally {
        setOpdLoading(false);
      }
    };

    fetchOpdInfo();
  }, []);

  const fetchVisitorCounts = async () => {
    try {
      setLoading(true);
      setError(null);

      const response = await api.get("/footer_statistics");

      if (response.data.status && Array.isArray(response.data.data)) {
        setVisitorCounts(response.data.data);
      } else {
        setVisitorCounts([]);
      }
    } catch (err: any) {
      console.error("Error fetching visitor counts", err);
      setError("Gagal memuat data pengunjung. Silahkan coba lagi.");
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchVisitorCounts();
  }, []);

  if (error && visitorCounts.length === 0) {
    return (
      <div className="container-fluid px-3 py-3">
        <div className="text-center text-danger">
          <p>{error}</p>
          <button className="btn btn-primary" onClick={fetchVisitorCounts}>
            Coba Lagi
          </button>
        </div>
      </div>
    );
  }

  const kanal = [
    {
      id: 1,
      nama: "@kominfotangerangkota",
      link: "https://www.instagram.com/kominfotangerangkota/",
    },
    {
      id: 2,
      nama: "@Tangerang LIVE Room",
      link: "https://live.tangerangkota.go.id/",
    },
    {
      id: 3,
      nama: "@PPID Kota Tangerang",
      link: "https://ppid.tangerangkota.go.id/",
    },
    {
      id: 4,
      nama: "@Tangerang Smart City",
      link: "https://smartcity.tangerangkota.go.id/",
    },
    {
      id: 5,
      nama: "@Tangerang Satu Data",
      link: "https://data.tangerangkota.go.id/",
    },
    {
      id: 6,
      nama: "@SP4N-LAPOR! Kota Tangerang",
      link: "https://lapor.go.id/",
    },
  ];

  return (
    <footer className="footer">
      <div className="footer-wrapper">
        {/* Kolom Kiri */}
        {/* Kolom Kiri */}
        <div className="footer-col">
          {opdLoading ? (
            <p className="p-text">Memuat data OPD...</p>
          ) : opdError ? (
            <p className="p-text text-danger">{opdError}</p>
          ) : opdInfo ? (
            <>
              <div className="p-text">Powered by</div>
              <div className="h-text">{opdInfo.website_name}</div>

              <p className="p-text">
                {opdInfo.official_title}
                <br />
                {opdInfo.adress}
                <br />
                {opdInfo.email}
              </p>

              {opdInfo.logo_cominfo && (
                <img
                  src={opdInfo.logo_cominfo}
                  alt={opdInfo.website_name}
                  className="flag-logo"
                />
              )}
            </>
          ) : (
            <p className="p-text">Data OPD tidak tersedia</p>
          )}
        </div>
        {/* Kolom Tengah */}
        <div className="footer-col">
          <div className="h-text">Kanal Informasi Resmi Lainnya</div>
          <div className="kanal-wrapper">
            {kanal.map((k) => (
              <a
                key={k.id}
                href={k.link}
                className="kanal-link"
                target="_blank"
                rel="noopener noreferrer"
              >
                {k.nama}
              </a>
            ))}
          </div>
        </div>

        {/* Kolom Kanan */}
        <div className="footer-col">
          <div className="h-text">Pengunjung</div>
          <div className="visitor-stats-wrapper">
            {loading ? (
              <p className="p-text">Memuat data...</p>
            ) : (
              visitorCounts.map((stat) => (
                <div key={stat.id_footer_statis} className="visitor-stat">
                  <div className="stat-label">{stat.stat_label} :</div>
                  <div className="stat-value">
                    {stat.stat_value.toLocaleString()}
                  </div>
                </div>
              ))
            )}
          </div>
        </div>
      </div>

      <p className="p-text footer-bottom">
        © Copyright 2025 - Pemerintah Kota Tangerang
      </p>
    </footer>
  );
};

export default Footer;
