import React, { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import {
  FolderOpen,
  ChevronRight,
  Home,
  ArrowLeft,
} from "lucide-react";
import "./dokumenpublik.css";
import api from "../../../services/api";

/* =======================
   INTERFACES (SESUI API)
======================= */
interface Category {
  id_kategori: string;
  nama_kategori: string;
  slug_kategori: string;
  created_at: string;
  updated_at: string;
}

interface Dokumen {
  id_document: string;
  nama_folder: string;
  nama_dokumen: string;
  file_path: string;
  tahun: string;
  id_kategori: string;
  created_at: string;
  updated_at: string;
}

interface Folder {
  nama_folder: string;
  dokumen: Dokumen[];
}

const DokumenPublik: React.FC = () => {
  const { slug } = useParams<{ slug: string }>();
  const navigate = useNavigate();

  const [categories, setCategories] = useState<Category[]>([]);
  const [selectedCategory, setSelectedCategory] = useState<Category | null>(null);
  const [folders, setFolders] = useState<Folder[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState("");
  const [openFolder, setOpenFolder] = useState<string | null>(null);
  const [searchTerm, setSearchTerm] = useState("");

  const ROOT = api.defaults.baseURL?.replace("/api", "") ?? "";

  /* =======================
     UTIL
  ======================= */
  const formatDate = (dateString: string) =>
    new Date(dateString).toLocaleDateString("id-ID", {
      day: "numeric",
      month: "long",
      year: "numeric",
    });

  const toggleAccordion = (folderName: string) => {
    setOpenFolder((prev) => (prev === folderName ? null : folderName));
  };

  /* =======================
     FETCH LIST KATEGORI
  ======================= */
  const fetchCategories = async () => {
    try {
      const res = await api.get("/informasi-publik");
      setCategories(res.data.data || []);
    } catch (err) {
      console.error(err);
      setError("Gagal memuat kategori dokumen");
    }
  };

  /* =======================
     FETCH DETAIL KATEGORI
  ======================= */
  const fetchCategoryData = async (categorySlug: string) => {
    setLoading(true);
    setError("");

    try {
      const res = await api.get(`/informasi-publik/${categorySlug}`);
      const data = res.data;

      setSelectedCategory(data.kategori);
      setFolders(data.folders || []);
    } catch (err) {
      console.error(err);
      setError("Gagal memuat data dokumen");
    } finally {
      setLoading(false);
    }
  };

  /* =======================
     HANDLER
  ======================= */
  const handleDownload = (doc: Dokumen) => {
    window.open(`${ROOT}/uploads/dokumen/${doc.file_path}`, "_blank");
  };

  const handleBackToCategories = () => {
    navigate("/informasi-publik");
    setOpenFolder(null);
    setSearchTerm("");
  };

  /* =======================
     EFFECT
  ======================= */
  useEffect(() => {
    fetchCategories();
  }, []);

  useEffect(() => {
    if (slug) {
      fetchCategoryData(slug);
    } else {
      setLoading(false);
      setSelectedCategory(null);
      setFolders([]);
    }
  }, [slug]);

  /* =======================
     FILTER DOKUMEN
  ======================= */
  const filteredFolders = folders.filter((folder) => {
    if (!searchTerm) return true;
    
    const searchLower = searchTerm.toLowerCase();
    const folderMatch = folder.nama_folder.toLowerCase().includes(searchLower);
    const docMatch = folder.dokumen.some(doc => 
      doc.nama_dokumen.toLowerCase().includes(searchLower)
    );
    
    return folderMatch || docMatch;
  });

  const totalDokumen = folders.reduce((acc, folder) => acc + folder.dokumen.length, 0);

  /* =======================
     LOADING & ERROR
  ======================= */
  if (loading) {
    return (
      <div className="container-fluid px-3 py-3">
        <div className="text-center">
          <div className="spinner-border text-primary" role="status" />
          <p className="mt-2">Memuat dokumen publik…</p>
        </div>
      </div>
    );
  }

  if (error) {
    return (
      <div className="program-container">
        <div className="alert alert-danger mb-3" role="alert">
          {error}
          <button 
            className="btn btn-sm btn-outline-danger ms-3" 
            onClick={() => slug && fetchCategoryData(slug)}
          >
            Coba Lagi
          </button>
        </div>
        <button className="btn btn-primary" onClick={handleBackToCategories}>
          <ArrowLeft size={16} className="me-2" /> Kembali
        </button>
      </div>
    );
  }

  /* =======================
     LIST KATEGORI
  ======================= */
  if (!slug) {
    return (
      <div className="container my-5">
        <h2 className="mb-4">Dokumen Publik</h2>

        <div className="row g-4">
          {categories.map((cat) => (
            <div key={cat.id_kategori} className="col-md-4">
              <div
                className="category-card"
                onClick={() =>
                  navigate(`/informasi-publik/${cat.slug_kategori}`)
                }
              >
                <FolderOpen size={40} />
                <h5 className="mt-3">{cat.nama_kategori}</h5>
                <ChevronRight />
              </div>
            </div>
          ))}
        </div>
      </div>
    );
  }

  /* =======================
     DETAIL KATEGORI (TABLE STYLE)
  ======================= */
  return (
    <div className="program-container">
      {/* Breadcrumb */}
      <nav className="mb-3">
        <button className="btn btn-link p-0" onClick={handleBackToCategories}>
          <Home size={16} className="me-1" /> Dokumen Publik
        </button>
        {selectedCategory && ` / ${selectedCategory.nama_kategori}`}
      </nav>

      <h2 className="program-title">{selectedCategory?.nama_kategori}</h2>

      <div className="table-toolbar">
        <div>
          Show
          <select disabled={folders.length === 0}>
            <option>10</option>
            <option>25</option>
            <option>50</option>
          </select>
          entries
        </div>

        <div className="search-box">
          Search: 
          <input 
            type="text" 
            placeholder="Cari dokumen..." 
            disabled={folders.length === 0}
            value={searchTerm}
            onChange={(e) => setSearchTerm(e.target.value)}
          />
        </div>
      </div>

      <div className="table-responsive">
        <table className="program-table">
          <thead>
            <tr>
              <th>Informasi</th>
              <th>Tanggal Upload</th>
              <th>File</th>
            </tr>
          </thead>
          <tbody>
            {filteredFolders.length > 0 ? (
              filteredFolders.map((folder) => {
                const isOpen = openFolder === folder.nama_folder;
                const totalItems = folder.dokumen.length;

                return (
                  <React.Fragment key={folder.nama_folder}>
                    {/* === HEADER FOLDER === */}
                    <tr
                      className="category-row"
                      onClick={() => toggleAccordion(folder.nama_folder)}
                      style={{ cursor: 'pointer' }}
                    >
                      <td>
                        <span className="toggle-icon">{isOpen ? "▾" : "▸"}</span>
                        📁 <strong>{folder.nama_folder}</strong>
                      </td>
                      <td className="text-center">{totalItems} dokumen</td>
                      <td></td>
                    </tr>

                    {/* === DOKUMEN DALAM FOLDER === */}
                    {isOpen &&
                      folder.dokumen.map((doc) => (
                        <tr key={doc.id_document} className="file-row">
                          <td className="file-name">
                            <span className="file-indent" />
                            📄 {doc.nama_dokumen}
                          </td>
                          <td className="text-center">
                            {formatDate(doc.created_at)}
                          </td>
                          <td className="text-center">
                            <a
                              href={`${ROOT}/uploads/dokumen/${doc.file_path}`}
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
              <tr>
                <td colSpan={3} className="text-center py-4">
                  {searchTerm ? "Tidak ada dokumen yang sesuai dengan pencarian" : "Belum ada dokumen"}
                </td>
              </tr>
            )}
          </tbody>
        </table>
      </div>

      <div className="table-footer">
        <div>
          Showing {filteredFolders.length > 0 ? 1 : 0} to {filteredFolders.length} of {folders.length} folder ({totalDokumen} dokumen)
        </div>

        <ul className="pagination">
          <li>
            <button disabled={folders.length === 0}>Previous</button>
          </li>
          <li className={folders.length > 0 ? "active" : ""}>
            <button disabled={folders.length === 0}>1</button>
          </li>
          <li>
            <button disabled={folders.length === 0}>2</button>
          </li>
          <li>
            <button disabled={folders.length === 0}>3</button>
          </li>
          <li>
            <button disabled={folders.length === 0}>Next</button>
          </li>
        </ul>
      </div>
    </div>
  );
};

export default DokumenPublik;