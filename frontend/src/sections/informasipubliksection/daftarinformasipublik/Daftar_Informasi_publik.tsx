import React, { useEffect, useState } from "react";
import api from "../../../services/api";
import './Daftar_Informasi_Publik.css';

interface DaftarInformasiPublik {
  id_daftar_ip: string;
  judul_dokumen: string;
  tahun: string;
  file_path: string;
  download_url: string;
}

const DaftarInformasiPublik: React.FC = () => {
  const [informasiPublik, setInformasiPublik] = useState<DaftarInformasiPublik[]>([]);
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<string | null>(null);

  const fetchInformasiPublik = async () => {
    try {
      setLoading(true);
      setError(null);

      const response = await api.get("/daftar_informasi_publik");

      if (response.data.status && Array.isArray(response.data.data)) {
        setInformasiPublik(response.data.data);
      } else {
        setInformasiPublik([]);
      }
    } catch (err) {
      console.error("Error fetching informasi publik", err);
      setError("Gagal memuat data informasi publik. Silahkan coba lagi.");
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchInformasiPublik();
  }, []);

  if (loading) {
    return (
      <div className="program-container">
        <div className="text-center py-5">
          <div className="spinner-border text-primary" role="status" />
          <p className="mt-2">Memuat data Informasi Publik...</p>
        </div>
      </div>
    );
  }

  if (error && informasiPublik.length === 0) {
    return (
      <div className="program-container">
        <div className="text-center text-danger py-5">
          <p>{error}</p>
          <button className="btn-unduh mt-2" onClick={fetchInformasiPublik}>
            Coba Lagi
          </button>
        </div>
      </div>
    );
  }

  return (
    <div className="program-container">
      <h2 className="program-title">Informasi Publik</h2>

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
            {informasiPublik.map((info) => (
              <tr key={info.id_daftar_ip} className="category-row">
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
          Showing 1 to {informasiPublik.length} of {informasiPublik.length} entries
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

export default DaftarInformasiPublik;