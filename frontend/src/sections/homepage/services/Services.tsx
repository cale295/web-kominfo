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
      <img
        src={`${BASE_URL}/${icon_image}`}
        alt={title}
      />
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

  // Pisahkan services menjadi 2 baris
  const getRows = () => {
    const totalItems = services.length;
    const itemsPerRow = Math.ceil(totalItems / 2);
    
    const row1 = services.slice(0, itemsPerRow);
    const row2 = services.slice(itemsPerRow);
    
    return { row1, row2 };
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

  const { row1, row2 } = getRows();

  return (
    <div className="service-container">
      <div className="service-wrapper">
        <div className="service-scroll-wrapper">
          <div className="service-grid-horizontal">
            {/* Baris pertama */}
            <div className="service-row">
              {row1.map((service) => (
                <div key={`row1-${service.id_service}`} className="service-item">
                  <ServiceCard
                    title={service.title}
                    icon_image={service.icon_image}
                    link={service.link}
                  />
                </div>
              ))}
            </div>
            
            {/* Baris kedua (jika ada) */}
            {row2.length > 0 && (
              <div className="service-row">
                {row2.map((service) => (
                  <div key={`row2-${service.id_service}`} className="service-item">
                    <ServiceCard
                      title={service.title}
                      icon_image={service.icon_image}
                      link={service.link}
                    />
                  </div>
                ))}
              </div>
            )}
          </div>
        </div>
      </div>
    </div>
  );
};

export default Service;