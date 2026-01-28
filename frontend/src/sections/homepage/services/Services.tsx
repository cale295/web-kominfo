import React from "react";
import "./Services.css";
import api from "../../../services/api";

interface Layanan {
  id_service: number;
  title: string;
  icon_image: string;
  link: string;
  sorting: number;
  is_active: number;
}

interface ServiceCardProps {
  title: string;
  icon_image: string;
  link: string;
}

const BASE_URL = import.meta.env.VITE_API_URL;

const ServiceCard: React.FC<ServiceCardProps> = ({
  title,
  icon_image,
  link,
}) => {
  return (
    <a
      href={link}
      target="_blank"
      rel="noopener noreferrer"
      className="service-card"
    >
      <img src={`${BASE_URL}/${icon_image}`} alt={title} />
      <p className="title">{title}</p>
    </a>
  );
};

const Service: React.FC = () => {
  const [services, setServices] = React.useState<Layanan[]>([]);
  const [loading, setLoading] = React.useState<boolean>(true);
  const [error, setError] = React.useState<string | null>(null);

  const fetchServices = async () => {
    try {
      setLoading(true);
      setError(null);
      const response = await api.get("/home_service");
      if (response.data.status && response.data.data.length > 0) {
        const activeServices = response.data.data
          .filter((service: Layanan) => service.is_active === 1)
          .sort((a: Layanan, b: Layanan) => a.sorting - b.sorting);
        setServices(activeServices);
      } else {
        setServices([]);
      }
    } catch (err) {
      console.error("Error fetching services:", err);
      setError("Gagal memuat data layanan. Silahkan coba lagi.");
    } finally {
      setLoading(false);
    }
  };

  React.useEffect(() => {
    fetchServices();
  }, []);

  // Pisahkan services berdasarkan layar
  const getRows = (maxRows: number) => {
    const totalItems = services.length;
    const itemsPerRow = Math.ceil(totalItems / maxRows);
    
    const rows: Layanan[][] = [];
    for (let i = 0; i < maxRows; i++) {
      const start = i * itemsPerRow;
      const end = start + itemsPerRow;
      const rowItems = services.slice(start, end);
      if (rowItems.length > 0) {
        rows.push(rowItems);
      }
    }
    return rows;
  };

  if (loading) {
    return <div className="service-container">Memuat layanan...</div>;
  }

  if (error) {
    return <div className="service-container">{error}</div>;
  }

  if (services.length === 0) {
    return <div className="service-container">Tidak ada layanan aktif</div>;
  }

  return (
    <div className="service-container">
      <div className="service-wrapper">
        <div className="service-scroll-wrapper">
          <div className="service-grid-horizontal" data-total={services.length}>
            {/* Mobile: 5 baris */}
            <div className="mobile-rows">
              {getRows(5).map((row, rowIndex) => (
                <div key={`mobile-row-${rowIndex}`} className="service-row">
                  {row.map((service) => (
                    <div key={`mobile-${service.id_service}`} className="service-item">
                      <ServiceCard
                        title={service.title}
                        icon_image={service.icon_image}
                        link={service.link}
                      />
                    </div>
                  ))}
                </div>
              ))}
            </div>

            {/* Desktop: 2 baris */}
            <div className="desktop-rows">
              {getRows(2).map((row, rowIndex) => (
                <div key={`desktop-row-${rowIndex}`} className="service-row">
                  {row.map((service) => (
                    <div key={`desktop-${service.id_service}`} className="service-item">
                      <ServiceCard
                        title={service.title}
                        icon_image={service.icon_image}
                        link={service.link}
                      />
                    </div>
                  ))}
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Service;