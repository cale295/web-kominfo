import React, { useEffect, useState } from "react";
import "./Program.css";
import api from "../../services/api";

interface ProgramList {
  id_program: string;
  nama_program: string;
  nama_kegiatan: string;
  nilai_anggaran: string;
  tahun: string;
}

const Program: React.FC = () => {
  const [program, setProgram] = useState<ProgramList[]>([]);
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<string | null>(null);

  const fetchProgram = async () => {
    try {
      setLoading(true);
      setError(null);

      const response = await api.get("/program");

      if (response.data.status && Array.isArray(response.data.data)) {
        setProgram(response.data.data);
      } else {
        setProgram([]);
      }
    } catch (err: any) {
      console.error("Error fetching program", err);
      setError("Gagal memuat data program. Silahkan coba lagi.");
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchProgram();
  }, []); // ✅ penting

  if (loading) {
    return (
      <div className="container-fluid px-3 py-3">
        <div className="text-center">
          <div className="spinner-border text-primary" role="status" />
          <p className="mt-2">Memuat data program...</p>
        </div>
      </div>
    );
  }

  if (error && program.length === 0) {
    return (
      <div className="container-fluid px-3 py-3">
        <div className="text-center text-danger">
          <p>{error}</p>
          <button className="btn btn-primary" onClick={fetchProgram}>
            Coba Lagi
          </button>
        </div>
      </div>
    );
  }

  return (
    <div className="program-container">
      <h2 className="program-title">PROGRAM SKPD TAHUN 2025</h2>

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
          Search: <input type="text" placeholder="Cari program..." />
        </div>
      </div>

      <div className="table-responsive">
        <table className="program-table">
          <thead>
            <tr>
              <th>Nama Program</th>
              <th>Nama Kegiatan</th>
              <th>Nilai Anggaran (Rupiah)</th>
              <th>Tahun</th>
            </tr>
          </thead>

          <tbody>
            {program.map((item) => (
              <tr key={item.id_program}>
                <td>{item.nama_program}</td>
                <td>{item.nama_kegiatan}</td>
                <td className="text-right">
                  {Number(item.nilai_anggaran).toLocaleString("id-ID")}
                </td>
                <td style={{ textAlign: "center" }}>{item.tahun}</td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>

      <div className="table-footer">
        <div>Showing 1 to 10 of {program.length} entries</div>

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
            <button>4</button>
          </li>
          <li>
            <button>5</button>
          </li>
          <li>
            <button>Next</button>
          </li>
        </ul>
      </div>
    </div>
  );
};

export default Program;
