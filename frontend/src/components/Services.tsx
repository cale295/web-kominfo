import React from "react";

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
];

const ServiceGrid: React.FC = () => {
  return (
    <section className="py-16 bg-gray-50">
      <div className="max-w-full mx-auto px-6">
        <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8 justify-items-center">
          {services.map((service) => (
            <a
              key={service.id}
              href={service.link}
              target="_blank"
              rel="noopener noreferrer"
              className="group flex flex-col items-center text-center focus:outline-none focus:ring-4 focus:ring-blue-400 rounded-xl"
            >
              <div className="bg-gray-100 rounded-2xl shadow p-6 w-48 h-28 flex justify-center items-center transition group-hover:shadow-lg group-hover:scale-105">
                <img
                  src={service.image}
                  alt={service.title}
                  className="max-h-16 object-contain"
                />
              </div>
              <p className="mt-4 font-semibold text-gray-900 text-sm md:text-base group-hover:text-blue-700">
                {service.title}
              </p>
            </a>
          ))}
        </div>
        <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8 justify-items-center mt-15">
          {services.map((service) => (
            <a
              key={service.id}
              href={service.link}
              target="_blank"
              rel="noopener noreferrer"
              className="group flex flex-col items-center text-center focus:outline-none focus:ring-4 focus:ring-blue-400 rounded-xl"
            >
              <div className="bg-gray-100 rounded-2xl shadow p-6 w-48 h-28 flex justify-center items-center transition group-hover:shadow-lg group-hover:scale-105">
                <img
                  src={service.image}
                  alt={service.title}
                  className="max-h-16 object-contain"
                />
              </div>
              <p className="mt-4 font-semibold text-gray-900 text-sm md:text-base group-hover:text-blue-700">
                {service.title}
              </p>
            </a>
          ))}
        </div>
      </div>
    </section>
  );
};

export default ServiceGrid;
