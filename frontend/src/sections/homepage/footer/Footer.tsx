import React, { useEffect, useState } from "react";
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

interface kanal {
  id_footer_social: number;
  platform_name: string;
  paltform_icon: string;
  account_name: string;
  account_url: string;
  is_active: number;
  sorting: number;
}

interface visitorCount {
  id_footer_statis: number;
  stat_label: string;
  stat_value: number;
}

const Footer: React.FC = () => {
  const [visitorCounts, setVisitorCounts] = useState<visitorCount[]>([]);
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<string | null>(null);
  const [opdInfo, setOpdInfo] = useState<opd | null>(null);
  const [opdLoading, setOpdLoading] = useState<boolean>(true);
  const [opdError, setOpdError] = useState<string | null>(null);
  const [kanalData, setKanalData] = useState<kanal[]>([]);
  const [kanalLoading, setKanalLoading] = useState<boolean>(true);
  const [kanalError, setKanalError] = useState<string | null>(null);

  // Fetch OPD Info
  const BASE_URL = import.meta.env.VITE_API_URL;

  // Fungsi untuk mengubah relative path menjadi absolute URL
  const getFullLogoUrl = (relativePath: string) => {
    if (!relativePath) return null;

    // Jika sudah absolute URL, kembalikan langsung
    if (
      relativePath.startsWith("http://") ||
      relativePath.startsWith("https://")
    ) {
      return relativePath;
    }

    // Jika dimulai dengan slash, tambahkan base URL
    if (relativePath.startsWith("/")) {
      return `${BASE_URL}${relativePath}`;
    }

    // Jika tanpa slash, tambahkan dengan slash
    return `${BASE_URL}/${relativePath}`;
  };

  // Update bagian fetch data:
  useEffect(() => {
    const fetchOpdInfo = async () => {
      try {
        setOpdLoading(true);
        setOpdError(null);

        const response = await api.get("/footer_opd");
        console.log("OPD API Response:", response.data);

        if (response.data.status && response.data.data.length > 0) {
          const opdData = response.data.data[0];

          // Transform logo URL ke absolute
          const transformedData = {
            ...opdData,
            logo_cominfo: getFullLogoUrl(opdData.logo_cominfo),
          };

          console.log("Transformed logo URL:", transformedData.logo_cominfo);
          setOpdInfo(transformedData);
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

  // Fetch Visitor Counts
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

  // Fetch Kanal Data
  const fetchKanalData = async () => {
    try {
      setKanalLoading(true);
      setKanalError(null);

      const response = await api.get("/footer_social");

      console.log("API Response kanal:", response.data);

      if (response.data.status && Array.isArray(response.data.data)) {
        // Filter only active kanal and sort by sorting number
        const activeKanal = response.data.data
          .filter((item: kanal) => item.is_active === 1)
          .sort((a: kanal, b: kanal) => a.sorting - b.sorting);

        setKanalData(activeKanal);
      } else {
        setKanalData([]);
      }
    } catch (err: any) {
      console.error("Error fetching kanal data", err);
      setKanalError("Gagal memuat data kanal informasi.");
    } finally {
      setKanalLoading(false);
    }
  };

  useEffect(() => {
    fetchKanalData();
  }, []);

  // Get icon based on platform name
  const getPlatformIcon = (platformName: string, platformIcon: string) => {
    // Jika ada custom icon dari API, gunakan itu
    if (platformIcon) {
      return <i className={`${platformIcon} me-2`}></i>;
    }

    // Default mapping based on platform name
    const platform = platformName.toLowerCase();
    if (platform.includes("instagram"))
      return <i className="fab fa-instagram me-2"></i>;
    if (platform.includes("live") || platform.includes("stream"))
      return <i className="fas fa-video me-2"></i>;
    if (platform.includes("ppid") || platform.includes("informasi"))
      return <i className="fas fa-info-circle me-2"></i>;
    if (platform.includes("smart"))
      return <i className="fas fa-brain me-2"></i>;
    if (platform.includes("data"))
      return <i className="fas fa-database me-2"></i>;
    if (platform.includes("lapor"))
      return <i className="fas fa-comment-alt me-2"></i>;
    if (platform.includes("youtube"))
      return <i className="fab fa-youtube me-2"></i>;
    if (platform.includes("facebook"))
      return <i className="fab fa-facebook me-2"></i>;
    if (platform.includes("twitter"))
      return <i className="fab fa-twitter me-2"></i>;

    return <i className="fas fa-link me-2"></i>;
  };

  // Format platform name for display
  const formatPlatformName = (platformName: string) => {
    return platformName.startsWith("@") ? platformName : `@${platformName}`;
  };

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

  return (
    <footer className="footer">
      <div className="footer-wrapper">
        {/* Kolom Kiri - OPD Info */}
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

        {/* Kolom Tengah - Kanal Informasi */}
        <div className="footer-col">
          <div className="h-text">Kanal Informasi Resmi Lainnya</div>
          <div className="kanal-wrapper">
            {kanalLoading ? (
              <p className="p-text">Memuat kanal informasi...</p>
            ) : kanalError ? (
              <p className="p-text text-danger">{kanalError}</p>
            ) : kanalData.length > 0 ? (
              kanalData.map((k) => (
                <a
                  key={k.id_footer_social}
                  href={k.account_url}
                  className="kanal-link"
                  target="_blank"
                  rel="noopener noreferrer"
                  title={k.account_name}
                >
                  {getPlatformIcon(k.platform_name, k.paltform_icon)}
                  {formatPlatformName(k.account_name)}
                </a>
              ))
            ) : (
              // Fallback jika tidak ada data dari API
              <>
                <a
                  href="https://www.instagram.com/kominfotangerangkota/"
                  className="kanal-link"
                  target="_blank"
                  rel="noopener noreferrer"
                >
                  <i className="fab fa-instagram me-2"></i>
                  @kominfotangerangkota
                </a>
                <a
                  href="https://live.tangerangkota.go.id/"
                  className="kanal-link"
                  target="_blank"
                  rel="noopener noreferrer"
                >
                  <i className="fas fa-video me-2"></i>
                  @Tangerang LIVE Room
                </a>
                <a
                  href="https://ppid.tangerangkota.go.id/"
                  className="kanal-link"
                  target="_blank"
                  rel="noopener noreferrer"
                >
                  <i className="fas fa-info-circle me-2"></i>
                  @PPID Kota Tangerang
                </a>
                <a
                  href="https://smartcity.tangerangkota.go.id/"
                  className="kanal-link"
                  target="_blank"
                  rel="noopener noreferrer"
                >
                  <i className="fas fa-brain me-2"></i>
                  @Tangerang Smart City
                </a>
                <a
                  href="https://data.tangerangkota.go.id/"
                  className="kanal-link"
                  target="_blank"
                  rel="noopener noreferrer"
                >
                  <i className="fas fa-database me-2"></i>
                  @Tangerang Satu Data
                </a>
                <a
                  href="https://lapor.go.id/"
                  className="kanal-link"
                  target="_blank"
                  rel="noopener noreferrer"
                >
                  <i className="fas fa-comment-alt me-2"></i>
                  @SP4N-LAPOR! Kota Tangerang
                </a>
              </>
            )}
          </div>
        </div>

        {/* Kolom Kanan - Pengunjung */}
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
