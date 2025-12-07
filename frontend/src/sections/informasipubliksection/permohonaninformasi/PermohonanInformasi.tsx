import React, { useEffect, useState } from "react";
import api from "../../../services/api";
import './PermohonanInformasi.css';

interface PermohonanInformasi {
  id_permohonan: string;
  judul_dokumen: string;
  tahun: string;
  file_path: string;
  download_url: string;
}

const PermohonanInformasi: React.FC = () => {
  const [permohonanInformasi, setPermohonanInformasi] = useState<PermohonanInformasi[]>([]);
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<string | null>(null);

  const fetchPermohonanInformasi = async () => {
    try {
      setLoading(true);
      setError(null);

      const response = await api.get("/permohonan_informasi");

      if (response.data.status && Array.isArray(response.data.data)) {
        setPermohonanInformasi(response.data.data);
      } else {
        setPermohonanInformasi([]);
      }
    } catch (err) {
      console.error("Error fetching Permohonan Informasi", err);
      setError("Gagal memuat data Permohonan Informasi. Silahkan coba lagi.");
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchPermohonanInformasi();
  }, []);

  if (loading) {
    return (
      <div className="program-container">
        <div className="text-center py-5">
          <div className="spinner-border text-primary" role="status" />
          <p className="mt-2">Memuat data Permohonan Informasi...</p>
        </div>
      </div>
    );
  }

  if (error && PermohonanInformasi.length === 0) {
    return (
      <div className="program-container">
        <div className="text-center text-danger py-5">
          <p>{error}</p>
          <button className="btn-unduh mt-2" onClick={fetchPermohonanInformasi}>
            Coba Lagi
          </button>
        </div>
      </div>
    );
  }

  return (
    <div className="program-container">
      <h2 className="program-title">Permohonan Informasi</h2>

      <div className="table-toolbar">
        <div>
          Show
          <select>
            <option>10</option>
            <option>25</option>
            <option>50</option>
          </select>
          entries
        </div>

        <div className="search-box">
          Search: <input type="text" placeholder="Cari dokumen..." />
        </div>
      </div>

      <div className="table-responsive">
        <table className="program-table">
          <thead>
            <tr>
              <th>Informasi</th>
              <th>Tahun</th>
              <th>File</th>
            </tr>
          </thead>
          <tbody>
            {permohonanInformasi.map((info) => (
              <tr key={info.id_permohonan} className="category-row">
                <td>{info.judul_dokumen}</td>
                <td>{info.tahun}</td>
                <td>
                  <a
                    href={info.download_url}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="btn-unduh"
                  >
                    Download
                  </a>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>

      <div className="table-footer">
        <div>
          Showing 1 to {PermohonanInformasi.length} of {PermohonanInformasi.length} entries
        </div>

        <ul className="pagination">
          <li>
            <button>Previous</button>
          </li>
          <li className="active">
            <button>1</button>
          </li>
          <li>
            <button>2</button>
          </li>
          <li>
            <button>3</button>
          </li>
          <li>
            <button>Next</button>
          </li>
        </ul>
      </div>
    </div>
  );
};

export default PermohonanInformasi;