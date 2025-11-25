import React from "react";
import "./Services.css"; // CSS Eksternal

interface ServiceCardProps {
  title: string;
  imageUrl: string;
  link: string;
}

const ServiceCard: React.FC<ServiceCardProps> = ({ title, imageUrl, link }) => {
  return (
    <a
      href={link}
      target="_blank"
      rel="noopener noreferrer"
      className="service-card"
    >
      <img src={imageUrl} alt={title} />
      <p className="title">{title}</p>
    </a>
  );
};

const Service: React.FC = () => {
  const services = [
    {
      id: 1,
      image: "/assets/PPID LOGO.png",
      title: "Layanan Komunikasi Publik",
      link: "https://ppid.tangerangkota.go.id",
    },
    {
      id: 2,
      image: "/assets/logo-kota-tangerang.png",
      title: "Website Resmi Kota Tangerang",
      link: "https://tangerangkota.go.id",
    },
    {
      id: 3,
      image: "/assets/egov.png",
      title: "Layanan EGOV",
      link: "https://egov.tangerangkota.go.id",
    },
    {
      id: 4,
      image: "/assets/statistik.png",
      title: "Layanan Statistik",
      link: "https://statistik.tangerangkota.go.id",
    },
    {
      id: 5,
      image: "/assets/tangerang_live.png",
      title: "Layanan Tangerang LIVE Room",
      link: "https://live.tangerangkota.go.id",
    },
    {
      id: 6,
      image: "",
      title: "Layanan Pengaduan SP4N-LAPOR",
      link: "https://lapor.go.id",
    },
    {
      id: 7,
      image: "/assets/sandi.png",
      title: "Layanan Persandian",
      link: "#",
    },
    {
      id: 8,
      image: "/assets/upt.png",
      title: "Layanan UPT Pengelola Ruang Kendali Kota",
      link: "#",
    },
    {
      id: 9,
      image: "/assets/layanan-tik.png",
      title: "Layanan TIK",
      link: "#",
    },
    {
      id: 10,
      image: "/assets/layanan-informasi.png",
      title: "Layanan Informasi dan Komunikasi Publik",
      link: "#",
    },
  ];

  return (
    <div className="service-container">
      <div className="service-wrapper">
        <div className="service-grid">
          {services.map((service) => (
            <ServiceCard
              key={service.id}
              title={service.title}
              imageUrl={service.image}
              link={service.link}
            />
          ))}
        </div>
      </div>
    </div>
  );
};

export default Service;
