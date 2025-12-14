import React, { useEffect, useState } from "react";
import api from "../../../services/api";
import "./LaporanKeuangan.css";

interface ListKeuangan {
  id_laporan_keuangan: string;
  kategori: string;
  judul_dokumen: string;
  tahun: string;
  file_path: string;
  download_url: string;
}

const Keuangan: React.FC = () => {
  const [keuangan, setKeuangan] = useState<ListKeuangan[]>([]);
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<string | null>(null);
  const [openKategori, setOpenKategori] = useState<string | null>(null);

  const toggleAccordion = (kategori: string) => {
    setOpenKategori((prev) => (prev === kategori ? null : kategori));
  };

  const fetchKeuangan = async () => {
    try {
      setLoading(true);
      setError(null);

      const response = await api.get("/laporan_keuangan");

      if (response.data.status && Array.isArray(response.data.data)) {
        setKeuangan(response.data.data);
      } else {
        setKeuangan([]);
      }
    } catch (err) {
      console.error("Error fetching Keuangan", err);
      setError("Gagal memuat data Keuangan. Silahkan coba lagi.");
      setKeuangan([]); // Pastikan array kosong saat error
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchKeuangan();
  }, []);

  const groupedData = keuangan.reduce((acc, item) => {
    if (!acc[item.kategori]) {
      acc[item.kategori] = [];
    }
    acc[item.kategori].push(item);
    return acc;
  }, {} as Record<string, ListKeuangan[]>);

  if (loading) {
    return (
      <div className="container-fluid px-3 py-3">
        <div className="text-center">
          <div className="spinner-border text-primary" role="status" />
          <p className="mt-2">Memuat data Keuangan...</p>
        </div>
      </div>
    );
  }

  return (
    <div className="program-container">
      <h2 className="program-title">Keuangan</h2>

      {/* Tampilkan error message jika ada */}
      {error && (
        <div className="alert alert-danger mb-3" role="alert">
          {error}
          <button 
            className="btn btn-sm btn-outline-danger ms-3" 
            onClick={fetchKeuangan}
          >
            Coba Lagi
          </button>
        </div>
      )}

      <div className="table-toolbar">
        <div>
          Show
          <select 
            disabled={keuangan.length === 0}
          >
            <option>10</option>
            <option>25</option>
            <option>50</option>
          </select>
          entries
        </div>

        <div className="search-box">
          Search: <input 
            type="text" 
            placeholder="Cari Keuangan..." 
            disabled={keuangan.length === 0}
          />
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
            {keuangan.length > 0 ? (
              Object.entries(groupedData).map(([kategori, items]) => {
                const isOpen = openKategori === kategori;
                const totalItems = items.length;

                return (
                  <React.Fragment key={kategori}>
                    {/* === HEADER KATEGORI === */}
                    <tr
                      className="category-row"
                      onClick={() => toggleAccordion(kategori)}
                      style={{ cursor: 'pointer' }}
                    >
                      <td>
                        <span className="toggle-icon">{isOpen ? "▾" : "▸"}</span>
                        📁 <strong>{kategori}</strong>
                      </td>

                      <td className="text-center">{totalItems} dokumen</td>
                      <td></td>
                    </tr>

                    {/* === DOKUMEN DALAM KATEGORI === */}
                    {isOpen &&
                      items.map((item) => (
                        <tr key={item.id_laporan_keuangan} className="file-row">
                          <td className="file-name">
                            <span className="file-indent" />
                            📄 {item.judul_dokumen}
                          </td>

                          <td className="text-center">{item.tahun}</td>

                          <td className="text-center">
                            <a
                              href={item.download_url}
                              className="btn-unduh"
                              target="_blank"
                              rel="noopener noreferrer"
                              download
                            >
                              Unduh
                            </a>
                          </td>
                        </tr>
                      ))}
                  </React.Fragment>
                );
              })
            ) : (
              // Tampilkan baris kosong ketika tidak ada data
              <tr>
                <td colSpan={3} className="text-center py-4">
                  Tidak ada data keuangan
                </td>
              </tr>
            )}
          </tbody>
        </table>
      </div>

      <div className="table-footer">
        <div>
          Showing {keuangan.length > 0 ? 1 : 0} to {keuangan.length} of {keuangan.length} entries
        </div>

        <ul className="pagination">
          <li>
            <button disabled={keuangan.length === 0}>Previous</button>
          </li>
          <li className={keuangan.length > 0 ? "active" : ""}>
            <button disabled={keuangan.length === 0}>1</button>
          </li>
          <li>
            <button disabled={keuangan.length === 0}>2</button>
          </li>
          <li>
            <button disabled={keuangan.length === 0}>3</button>
          </li>
          <li>
            <button disabled={keuangan.length === 0}>Next</button>
          </li>
        </ul>
      </div>
    </div>
  );
};

export default Keuangan;