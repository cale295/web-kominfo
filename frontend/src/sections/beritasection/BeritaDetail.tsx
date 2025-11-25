import React, { useState, useEffect } from "react";
import { useParams, useNavigate } from "react-router-dom";
import "./css/beritadetail.css";
import api from "../../services/api";
import { ArrowLeft, Calendar, Eye, Share2 } from "lucide-react";

interface BeritaDetail {
  id_berita: string;
  judul: string;
  intro: string;
  content: string;
  content2?: string;
  feat_image: string;
  additional_images?: string;
  created_at: string;
  updated_at: string;
  hit: string;
  created_by_name?: string;
  sumber?: string;
  link_video?: string;
  caption?: string;
  topik?: string;
}

interface BeritaTerkait {
  id_berita: string;
  judul: string;
  intro: string;
  feat_image: string;
  created_at: string;
}

const BeritaDetail: React.FC = () => {
  const { id } = useParams<{ id: string }>();
  const navigate = useNavigate();
  const [berita, setBerita] = useState<BeritaDetail | null>(null);
  const [beritaTerkait, setBeritaTerkait] = useState<BeritaTerkait[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState("");

  const ROOT = api.defaults.baseURL?.replace("/api", "") ?? "";

  const formatDate = (dateString: string) => {
    const options: Intl.DateTimeFormatOptions = {
      day: "numeric",
      month: "long",
      year: "numeric",
      hour: "2-digit",
      minute: "2-digit",
    };
    return new Date(dateString).toLocaleDateString("id-ID", options);
  };

  const formatDateShort = (dateString: string) => {
    const options: Intl.DateTimeFormatOptions = {
      day: "numeric",
      month: "short",
      year: "numeric",
    };
    return new Date(dateString).toLocaleDateString("id-ID", options);
  };

  const getImageUrl = (imagePath: string | undefined) => {
    if (!imagePath) return null;
    
    // Clean path dari leading slash
    const cleanPath = imagePath.replace(/^\/+/, "");
    
    // Cek apakah path sudah lengkap dengan ROOT
    if (cleanPath.startsWith('http')) {
      return cleanPath;
    }
    
    // Gabungkan ROOT dengan path
    const fullUrl = `${ROOT}/${cleanPath}`;
    console.log("Image URL:", fullUrl);
    return fullUrl;
  };

  useEffect(() => {
    const fetchBeritaDetail = async () => {
      if (!id) return;

      setLoading(true);
      setError("");

      try {
        // Fetch detail berita dan berita terkait dalam satu waktu
        const [resDetail, resAll] = await Promise.all([
          api.get(`/berita/${id}`),
          api.get("/berita")
        ]);

        const data = resDetail?.data?.data;

        if (data) {
          setBerita(data);
          console.log("Data Berita Detail:", data);
          console.log("Featured Image Path:", data.feat_image);
          console.log("Full Image URL:", getImageUrl(data.feat_image));

          // Filter berita terkait
          const allBerita = resAll?.data?.data?.berita || [];
          const terkait = allBerita
            .filter((item: BeritaTerkait) => item.id_berita !== id)
            .sort(
              (a: BeritaTerkait, b: BeritaTerkait) =>
                new Date(b.created_at).getTime() -
                new Date(a.created_at).getTime()
            )
            .slice(0, 4);

          setBeritaTerkait(terkait);
        } else {
          setError("Berita tidak ditemukan");
        }
      } catch (err: any) {
        console.error("Gagal fetch berita detail:", err);
        if (err?.response?.status === 404) {
          setError("Berita tidak ditemukan");
        } else {
          setError("Gagal memuat berita. Silakan coba lagi.");
        }
      } finally {
        setLoading(false);
      }
    };

    fetchBeritaDetail();
  }, [id]);

  const handleShare = () => {
    if (navigator.share) {
      navigator.share({
        title: berita?.judul,
        text: berita?.intro,
        url: window.location.href,
      });
    } else {
      navigator.clipboard.writeText(window.location.href);
      alert("Link berhasil disalin!");
    }
  };

  const handleBeritaTerkaitClick = (beritaId: string) => {
    // Scroll ke atas dan navigate
    window.scrollTo({ top: 0, behavior: 'smooth' });
    navigate(`/berita/${beritaId}`);
  };

  if (loading) {
    return (
      <div className="container my-5">
        <div className="text-center py-5">
          <div className="spinner-border text-primary" role="status">
            <span className="visually-hidden">Memuat...</span>
          </div>
          <p className="mt-3 text-muted">Memuat berita...</p>
        </div>
      </div>
    );
  }

  if (error || !berita) {
    return (
      <div className="container my-5">
        <div className="alert alert-danger" role="alert">
          {error || "Berita tidak ditemukan"}
        </div>
        <button
          className="btn btn-primary"
          onClick={() => navigate("/berita")}
        >
          <ArrowLeft size={18} className="me-2" />
          Kembali ke Berita
        </button>
      </div>
    );
  }

  return (
    <div className="container-fluid berita-detail-container my-5">
      <div className="row">
        {/* Main Content */}
        <div className="col-lg-8">
          {/* Back Button */}
          <button
            className="btn btn-link back-button mb-3"
            onClick={() => navigate("/berita")}
          >
            <ArrowLeft size={18} className="me-2" />
            Kembali ke Berita
          </button>

          {/* Article Header */}
          <article className="berita-article">
            <h1 className="article-title">{berita.judul}</h1>

            <div className="article-meta">
              <span className="meta-item">
                <Calendar size={16} />
                {formatDate(berita.created_at)}
              </span>
              <span className="meta-item">
                <Eye size={16} />
                {berita.hit} views
              </span>
              {berita.created_by_name && (
                <span className="meta-item">
                  Penulis: {berita.created_by_name}
                </span>
              )}
              <button className="btn-share" onClick={handleShare}>
                <Share2 size={16} />
                Bagikan
              </button>
            </div>

            {/* Featured Image */}
            {berita.feat_image ? (
              <div className="article-image-wrapper">
                <img
                  src={getImageUrl(berita.feat_image) || ""}
                  className="article-image"
                  alt={berita.judul}
                  onError={(e) => {
                    console.error("Image failed to load:", getImageUrl(berita.feat_image));
                    e.currentTarget.style.display = 'none';
                    e.currentTarget.parentElement?.classList.add('image-error');
                  }}
                />
              </div>
            ) : (
              <div className="article-image-wrapper">
                <div className="article-image-placeholder">
                  <span>Tidak ada gambar</span>
                </div>
              </div>
            )}

            {/* Intro */}
            <div className="article-intro">
              <strong>{berita.intro}</strong>
            </div>

            {/* Content */}
            <div
              className="article-content"
              dangerouslySetInnerHTML={{ __html: berita.content }}
            />

            {/* Content 2 */}
            {berita.content2 && (
              <div
                className="article-content"
                dangerouslySetInnerHTML={{ __html: berita.content2 }}
              />
            )}

            {/* Additional Images */}
            {berita.additional_images && (() => {
              const imagesData = berita.additional_images;

              if (typeof imagesData !== 'string') {
                return null;
              }

              try {
                const trimmedData = imagesData.trim();
                
                if (trimmedData.startsWith('[') && trimmedData.endsWith(']')) {
                  const images = JSON.parse(trimmedData);

                  if (Array.isArray(images) && images.length > 0) {
                    return (
                      <div className="additional-images">
                        <h5>Galeri Foto</h5>
                        <div className="image-gallery">
                          {images.map((img: string, idx: number) => (
                            <img
                              key={idx}
                              src={getImageUrl(img) || ""}
                              alt={`Gambar tambahan ${idx + 1}`}
                              className="gallery-image"
                              onError={(e) => {
                                console.error("Gallery image failed to load:", img);
                                e.currentTarget.style.display = 'none';
                              }}
                            />
                          ))}
                        </div>
                      </div>
                    );
                  }
                }
              } catch (e) {
                console.error("Error parsing additional images:", e);
              }
              return null;
            })()}

            {/* Source & Video */}
            <div className="article-footer-info">
              {berita.sumber && (
                <p className="article-source">
                  <strong>Sumber:</strong> {berita.sumber}
                </p>
              )}
              {berita.link_video && (
                <p className="article-video">
                  <strong>Video:</strong>{" "}
                  <a href={berita.link_video} target="_blank" rel="noopener noreferrer">
                    Tonton Video
                  </a>
                </p>
              )}
            </div>

            {/* Tags/Topik */}
            {berita.topik && (
              <div className="article-tags">
                <strong>Topik:</strong>
                <span className="tag-badge">{berita.topik}</span>
              </div>
            )}
          </article>
        </div>

        {/* Sidebar */}
        <div className="col-lg-4">
          <div className="sidebar-sticky">
            <h5 className="sidebar-title">Berita Terkait</h5>

            {beritaTerkait.length > 0 ? (
              <div className="berita-terkait-list">
                {beritaTerkait.map((item) => (
                  <div
                    key={item.id_berita}
                    className="berita-terkait-item"
                    onClick={() => handleBeritaTerkaitClick(item.id_berita)}
                  >
                    {item.feat_image ? (
                      <img
                        src={getImageUrl(item.feat_image) || ""}
                        alt={item.judul}
                        className="terkait-image"
                        onError={(e) => {
                          console.error("Terkait image failed to load:", item.feat_image);
                          e.currentTarget.style.display = 'none';
                        }}
                      />
                    ) : (
                      <div className="terkait-image-placeholder">
                        <span>No Image</span>
                      </div>
                    )}
                    <div className="terkait-content">
                      <h6 className="terkait-title">{item.judul}</h6>
                      <p className="terkait-date">
                        {formatDateShort(item.created_at)}
                      </p>
                    </div>
                  </div>
                ))}
              </div>
            ) : (
              <p className="text-muted">Tidak ada berita terkait</p>
            )}
          </div>
        </div>
      </div>
    </div>
  );
};

export default BeritaDetail;