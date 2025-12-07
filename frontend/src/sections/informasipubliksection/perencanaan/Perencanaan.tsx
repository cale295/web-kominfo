import React, { useEffect, useState } from "react";
import api from "../../../services/api";
import "./Perencanaan.css";

interface ListPerencanaan {
  id_perencanaan: string;
  kategori: string;
  judul_dokumen: string;
  tahun: string;
  file_path: string;
  download_url: string;
}

const Perencanaan: React.FC = () => {
  const [perencanaan, setPerencanaan] = useState<ListPerencanaan[]>([]);
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<string | null>(null);
  const [openKategori, setOpenKategori] = useState<string | null>(null);

  const toggleAccordion = (kategori: string) => {
    setOpenKategori((prev) => (prev === kategori ? null : kategori));
  };

  const fetchPerencanaan = async () => {
    try {
      setLoading(true);
      setError(null);

      const response = await api.get("/informasi_perencanaan");

      if (response.data.status && Array.isArray(response.data.data)) {
        setPerencanaan(response.data.data);
      } else {
        setPerencanaan([]);
      }
    } catch (err) {
      console.error("Error fetching perencanaan", err);
      setError("Gagal memuat data perencanaan. Silahkan coba lagi.");
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchPerencanaan();
  }, []);

  const groupedData = perencanaan.reduce((acc, item) => {
    if (!acc[item.kategori]) {
      acc[item.kategori] = [];
    }
    acc[item.kategori].push(item);
    return acc;
  }, {} as Record<string, ListPerencanaan[]>);

  if (loading) {
    return (
      <div className="container-fluid px-3 py-3">
        <div className="text-center">
          <div className="spinner-border text-primary" role="status" />
          <p className="mt-2">Memuat data Perencanaan...</p>
        </div>
      </div>
    );
  }

  if (error && perencanaan.length === 0) {
    return (
      <div className="container-fluid px-3 py-3">
        <div className="text-center text-danger">
          <p>{error}</p>
          <button className="btn btn-primary" onClick={fetchPerencanaan}>
            Coba Lagi
          </button>
        </div>
      </div>
    );
  }

  return (
    <div className="program-container">
      <h2 className="program-title">PERENCANAAN</h2>

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
          Search: <input type="text" placeholder="Cari perencanaan..." />
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
            {Object.entries(groupedData).map(([kategori, items]) => {
              const isOpen = openKategori === kategori;

              return (
                <React.Fragment key={kategori}>
                  {/* === HEADER KATEGORI === */}
                  <tr
                    className="category-row"
                    onClick={() => toggleAccordion(kategori)}
                  >
                    <td>
                      <span className="toggle-icon">{isOpen ? "▾" : "▸"}</span>
                      📁 <strong>{kategori}</strong>
                    </td>

                    <td className="text-center">0</td>
                    <td></td>
                  </tr>

                  {/* === DOKUMEN DALAM KATEGORI === */}
                  {isOpen &&
                    items.map((item) => (
                      <tr key={item.id_perencanaan} className="file-row">
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
            })}
          </tbody>
        </table>
      </div>

      <div className="table-footer">
        <div>
          Showing 1 to {perencanaan.length} of {perencanaan.length} entries
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

export default Perencanaan;
