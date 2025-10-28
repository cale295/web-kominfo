import React from "react";
import "../css/services.css";

interface ServiceItem {
  id: number;
  image: string;
  title: string;
  link: string;
}

const services: ServiceItem[] = [
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
    image: "/images/egov.png",
    title: "Layanan EGOV",
    link: "https://egov.tangerangkota.go.id",
  },
  {
    id: 4,
    image: "/images/statistik.png",
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

const ServiceGrid: React.FC = () => {
  return (
    <section className="py-16 bg-gray-50">
      <div className="container-fluid mx-auto px-6">
        {/* Baris pertama */}
        <div className="row row-cols-1 row-cols-2 row-cols-md-3 row-cols-lg-5 g-4 justify-content-center">
          {services.map((service) => (
            <div key={service.id} className="col d-flex justify-content-center">
              <a
                href={service.link}
                target="_blank"
                rel="noopener noreferrer"
                className="service-card-link d-flex flex-column align-items-center text-center focus-outline-none focus-ring-4 focus-ring-blue-400 rounded-xl"
              >
                <div className="service-card bg-gray-100 rounded-2 rounded-lg-2 rounded-xl-2 shadow p-6 w-48 h-28 d-flex justify-content-center align-items-center transition service-hover-effect">
                  <img
                    src={service.image}
                    alt={service.title}
                    className="service-image max-h-16 object-contain"
                  />
                </div>
                <p className="mt-4 font-semibold text-gray-900 text-sm text-md-base service-title-hover">
                  {service.title}
                </p>
              </a>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default ServiceGrid;