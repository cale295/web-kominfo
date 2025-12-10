import React from "react";
import "./daftarPejabat.css";
import api from "../../../services/api";

interface Pejabat {
  id_pejabat_s: string;
  title: string;
  subtitle: string;
  image_url: string;
  is_active: string;
}

const DaftarPejabat: React.FC = () => {
  const [pejabatData, setPejabatData] = React.useState<Pejabat | null>(null);
  const [loading, setLoading] = React.useState<boolean>(true);
  const [error, setError] = React.useState<string | null>(null);

  const fetchPejabatData = async () => {
    try {
      setLoading(true);
      setError(null);

      const response = await api.get("/pejabat_struktural");

      if (response.data.status && response.data.data.length > 0) {
        const activePejabat = response.data.data.find(
          (item: Pejabat) => item.is_active === "1"
        );

        const BASE_URL = import.meta.env.VITE_API_URL;

        if (activePejabat && activePejabat.image_url) {
          const filename = activePejabat.image_url.split("/").pop();
          activePejabat.image_url = `${BASE_URL}/uploads/pejabat_struktural/${filename}`;
        }

        setPejabatData(activePejabat || null);
      } else {
        setPejabatData(null);
      }
    } catch (err) {
      setError("Gagal memuat data daftar pejabat struktural.");
    } finally {
      setLoading(false);
    }
  };

  React.useEffect(() => {
    fetchPejabatData();
  }, []);

  if (loading) {
    return (
      <div className="pejabat-container">
        Memuat daftar pejabat struktural...
      </div>
    );
  }

  if (error) {
    return <div className="pejabat-container">{error}</div>;
  }

  if (!pejabatData) {
    return (
      <div className="pejabat-container">
        Tidak ada data daftar pejabat struktural.
      </div>
    );
  }

  return (
    <div className="pejabat-container">
      <h3 className="pejabat-title">{pejabatData.title}</h3>
      <p className="pejabat-subtitle">{pejabatData.subtitle}</p>
      {pejabatData.image_url && (
        <img
          src={pejabatData.image_url}
          alt={pejabatData.title || "Foto Pejabat Struktural"}
          className="pejabat-image"
          onError={(e) => {
            // Fallback jika gambar gagal dimuat
            (e.target as HTMLImageElement).style.display = "none";
          }}
        />
      )}
    </div>
  );
};

export default DaftarPejabat;
