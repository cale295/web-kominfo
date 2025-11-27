import React, { useState, useEffect } from "react";
import "./structure.css";
import api from "../../../services/api";

interface Anggota {
  id_pejabat: string;
  nama: string;
  jabatan: string;
  foto?: string;
  foto_url?: string;
}

export default function Structure() {
  const [anggota, setAnggota] = useState<Anggota[]>([]);
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<string | null>(null);

  const fetchPejabat = async () => {
    try {
      setLoading(true);
      setError(null);
      
      const response = await api.get("/pejabat");
      
      if (response.data.status && response.data.data && Array.isArray(response.data.data)) {
        setAnggota(response.data.data);
      } else {
        setAnggota([]);
      }
    } catch (err: any) {
      console.error("Error fetching pejabat:", err);
      setError("Gagal memuat data pejabat. Silakan coba lagi.");
      
      setAnggota([
        {
          id_pejabat: "1",
          nama: "Dr. MUGIYA WARDHANY, SE, M.Si",
          jabatan: "Kepala Dinas Komunikasi dan Informatika",
        },
        {
          id_pejabat: "2", 
          nama: "NURHIDAYATULLAH, S.IP, M.Si",
          jabatan: "Sekretaris Dinas Komunikasi dan Informatika",
        },
      ]);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchPejabat();
  }, []);

  const getImageSrc = (item: Anggota) => {
    return item.foto_url || "/assets/mas.png";
  };

  if (loading) {
    return (
      <div className="container-fluid px-3 py-3 bg-blue-light">
        <div className="text-center">
          <div className="spinner-border text-primary" role="status">
            <span className="visually-hidden">Memuat data...</span>
          </div>
          <p className="mt-2">Memuat data pejabat...</p>
        </div>
      </div>
    );
  }

  if (error && anggota.length === 0) {
    return (
      <div className="container-fluid px-3 py-3 bg-blue-light">
        <div className="text-center text-danger">
          <p>{error}</p>
          <button 
            className="btn btn-primary"
            onClick={fetchPejabat}
          >
            Coba Lagi
          </button>
        </div>
      </div>
    );
  }

  return (
    <div className="container-fluid px-3 py-3 bg-blue-light">
      <div className="text-center mb-3 mb-md-4">
        <h1 className="text-blue-dark fw-bold fs-3 fs-md-1">
          Daftar Pejabat Struktural
        </h1>
        <p className="fw-semibold fs-5 fs-md-3">
          Dinas Komunikasi dan Informatika
        </p>
      </div>

      {error && (
        <div className="alert alert-warning alert-dismissible fade show" role="alert">
          {error}
          <button 
            type="button" 
            className="btn-close" 
            onClick={() => setError(null)}
          ></button>
        </div>
      )}

      <div className="row g-4">
        <div className="col col-left d-flex align-items-center justify-content-center">
          <div className="image-text-container">
            <div className="overlay-text">{`Pejabat\nStruktural\nOPD`}</div>
            <img src="/assets/jam.png" alt="Gambar Jam" className="img-fluid" />
          </div>
        </div>

        <div className="col">
          <div className="custom-scrollbar pe-2">
            <div className="pb-4 pt-2 pr-2">
              {anggota.length > 0 ? (
                anggota.map((item, index) => (
                  <div
                    key={item.id_pejabat || index}
                    className={`d-flex align-items-center p-3 mb-3 member-card ${
                      index % 2 === 0 ? "bg-blue-card-light" : "bg-blue-card-alt"
                    }`}
                  >
                    <img
                      src={getImageSrc(item)}
                      alt={item.nama}
                      className="member-img me-3"
                    />
                    <div className="flex-grow-1">
                      <p className="text-secondary mb-0 small">Nama:</p>
                      <h2 className="text-blue-title fw-bold mb-1">
                        {item.nama}
                      </h2>
                      <p className="text-secondary mb-0 small">Jabatan:</p>
                      <h3 className="text-blue-jabatan mb-0">{item.jabatan}</h3>
                    </div>
                  </div>
                ))
              ) : (
                <div className="text-center py-4">
                  <p>Tidak ada data pejabat yang ditemukan.</p>
                </div>
              )}
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}