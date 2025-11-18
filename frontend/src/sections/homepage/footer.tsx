import React from "react";
import "./css/Footer.css";

const Footer: React.FC = () => {
  const kanal = [
    {
      id: 1,
      icon: "",
      nama: "@kominfotangerangkota",
      link: "https://www.instagram.com/kominfotangerangkota/",
    },
    {
      id: 2,
      icon: "",
      nama: "@Tangerang LIVE Room",
      link: "https://live.tangerangkota.go.id/",
    },
    {
      id: 3,
      icon: "",
      nama: "@PPID Kota Tangerang",
      link: "https://ppid.tangerangkota.go.id/",
    },
    {
      id: 4,
      icon: "",
      nama: "@Tangerang Smart City",
      link: "https://smartcity.tangerangkota.go.id/",
    },
    {
      id: 5,
      icon: "",
      nama: "@Tangerang Satu Data",
      link: "https://data.tangerangkota.go.id/",
    },
    {
      id: 6,
      icon: "",
      nama: "@SP4N-LAPOR! Kota Tangerang",
      link: "https://lapor.go.id/",
    },
  ];
  const visitorCount = 123456;
  return (
    <footer className="bg-gradient-to-r-blue-800-950 py-4 rounded-bottom-6 rounded-bottom-sm-4 rounded-bottom-md-4 rounded-bottom-lg-4 rounded-bottom-xl-4 rounded-bottom-xxl-4 footer">
      <div className="footer-wrapper">
        {/* Kolom Kiri */}
        <div className="footer-col">
          <div className="p-text">Powered by</div>
          <div className="h-text">tangerangkota.go.id</div>

          <p className="p-text">
            Situs Resmi Pemerintah Kota Tangerang
            <br />
            Jl. Satria Sudirman No.1 Lt. IV Kota Tangerang 15111
            <br />
            redaksi@tangerangkota.id
          </p>

          <img
            src="./assets/indo.png"
            width={120}
            style={{ marginTop: "1rem" }}
          />
        </div>

        {/* Kolom Tengah */}
        <div className="footer-col">
          <div className="h-text">Kanal Informasi Resmi Lainnya</div>

          <div className="kanal-wrapper">
            {kanal.map((k) => (
              <a key={k.id} href={k.link} className="kanal-link">
                {k.nama}
              </a>
            ))}
          </div>
        </div>

        {/* Kolom Kanan */}
        <div className="footer-col">
          <div className="h-text">Pengunjung</div>

          <div className="p-text mt-3">
            Pengunjung hari ini : {visitorCount.toLocaleString()} <br />
            Pengunjung online : 5 <br />
            Total pengunjung : {visitorCount.toLocaleString()}
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
