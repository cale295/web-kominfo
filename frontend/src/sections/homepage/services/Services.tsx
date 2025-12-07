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
        onError={(e) => {
          (e.currentTarget as HTMLImageElement).src =
            "https://via.placeholder.com/150";
        }}
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
        <div className="service-grid">
          {services.map((service) => {
            console.log("IMAGE URL =>", `${BASE_URL}/${service.icon_image}`);

            return (
              <ServiceCard
                key={service.id_service}
                title={service.title}
                icon_image={service.icon_image}
                link={service.link}
              />
            );
          })}
        </div>
      </div>
    </div>
  );
};

export default Service;
