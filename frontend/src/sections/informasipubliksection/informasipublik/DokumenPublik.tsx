import React, { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import {
  FolderOpen,
  FileText,
  Download,
  Eye,
  Calendar,
  ArrowLeft,
  ChevronRight,
  Home,
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
  const [documents, setDocuments] = useState<Dokumen[]>([]);
  const [selectedFolder, setSelectedFolder] = useState<Folder | null>(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState("");

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

  const getFileIcon = (fileName: string) => {
    const ext = fileName.split(".").pop()?.toLowerCase();
    switch (ext) {
      case "pdf":
        return "📄";
      case "doc":
      case "docx":
        return "📝";
      case "xls":
      case "xlsx":
        return "📊";
      default:
        return "📎";
    }
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

      // 🔥 FLATTEN dokumen dari folder
      const allDocs: Dokumen[] = (data.folders || []).flatMap(
        (folder: Folder) =>
          folder.dokumen.map((doc) => ({
            ...doc,
            nama_folder: folder.nama_folder,
          }))
      );

      setDocuments(allDocs);
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

  const handleView = handleDownload;

  const handleBackToCategories = () => {
    navigate("/informasi-publik");
    setSelectedFolder(null);
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
      setDocuments([]);
    }
  }, [slug]);

  /* =======================
     FILTER DOKUMEN
  ======================= */
  const filteredDocuments = selectedFolder
    ? documents.filter((doc) => doc.nama_folder === selectedFolder.nama_folder)
    : documents;

  /* =======================
     LOADING & ERROR
  ======================= */
  if (loading) {
    return (
      <div className="text-center py-5">
        <div className="spinner-border text-primary" />
        <p className="mt-3">Memuat dokumen publik…</p>
      </div>
    );
  }

  if (error) {
    return (
      <div className="container my-5">
        <div className="alert alert-danger">{error}</div>
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
     DETAIL KATEGORI
  ======================= */
  return (
    <div className="container my-5">
      {/* Breadcrumb */}
      <nav className="mb-4">
        <button className="btn btn-link p-0" onClick={handleBackToCategories}>
          <Home size={16} className="me-1" /> Dokumen Publik
        </button>
        {selectedCategory && ` / ${selectedCategory.nama_kategori}`}
        {selectedFolder && ` / ${selectedFolder.nama_folder}`}
      </nav>

      <h3 className="mb-4">
        {selectedFolder
          ? selectedFolder.nama_folder
          : selectedCategory?.nama_kategori}
      </h3>

      {/* Folder */}
      {!selectedFolder && folders.length > 0 && (
        <div className="row g-3 mb-5">
          {folders.map((folder) => (
            <div key={folder.nama_folder} className="col-md-4">
              <div
                className="folder-card"
                onClick={() => setSelectedFolder(folder)}
              >
                <FolderOpen size={32} />
                <span className="ms-2">{folder.nama_folder}</span>
              </div>
            </div>
          ))}
        </div>
      )}

      {/* Dokumen */}
      {filteredDocuments.length > 0 ? (
        filteredDocuments.map((doc) => (
          <div key={doc.id_document} className="document-card">
            <span>{getFileIcon(doc.nama_dokumen)}</span>
            <div className="ms-3 flex-grow-1">
              <h6>{doc.nama_dokumen}</h6>
              <small>
                <Calendar size={14} /> {formatDate(doc.created_at)}
              </small>
            </div>
            <button
              className="btn btn-sm btn-outline-primary me-2"
              onClick={() => handleView(doc)}
            >
              <Eye size={16} />
            </button>
            <button
              className="btn btn-sm btn-primary"
              onClick={() => handleDownload(doc)}
            >
              <Download size={16} />
            </button>
          </div>
        ))
      ) : (
        <div className="alert alert-info">Belum ada dokumen.</div>
      )}
    </div>
  );
};

export default DokumenPublik;
