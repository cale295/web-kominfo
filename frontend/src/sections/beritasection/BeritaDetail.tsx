import React, { useState, useEffect, useMemo } from "react";
import { useParams, useNavigate } from "react-router-dom";
import "./css/beritadetail.css";
import api from "../../services/api";
import { ArrowLeft, Calendar, Eye, Share2 } from "lucide-react";

interface AdditionalImage {
  url: string;
  caption: string;
}

const parseAdditionalImages = (imagesData: any): AdditionalImage[] => {
  if (!imagesData) return [];
  
  try {
    if (Array.isArray(imagesData)) {
      return imagesData.map((item: any) => ({
        url: item.url || "",
        caption: item.caption || "",
      }));
    }
    
    if (typeof imagesData === 'string') {
      const trimmed = imagesData.trim();
      if (trimmed.startsWith('[') && trimmed.endsWith(']')) {
        const parsed = JSON.parse(trimmed);
        if (Array.isArray(parsed)) {
          return parsed.map((item: any) => ({
            url: item.url || "",
            caption: item.caption || "",
          }));
        }
      }
    }

    console.warn("Format additional_images tidak dikenali:", imagesData);
    return [];
  } catch (e) {
    console.warn("Gagal mem-parse additional_images:", e, "Data:", imagesData);
    return [];
  }
};

// Komponen Carousel
interface CarouselProps {
  images: AdditionalImage[];
  getImageUrl: (path: string) => string | null;
}

const Carousel: React.FC<CarouselProps> = ({ images, getImageUrl }) => {
  const [currentIndex, setCurrentIndex] = useState(0);
  const [isHovered, setIsHovered] = useState(false);

  const next = () => {
    setCurrentIndex((prev) => (prev + 1) % images.length);
  };

  const prev = () => {
    setCurrentIndex((prev) => (prev - 1 + images.length) % images.length);
  };

  const goToSlide = (index: number) => {
    setCurrentIndex(index);
  };

  useEffect(() => {
    if (images.length <= 1) return;

    const interval = setInterval(() => {
      if (!isHovered) {
        setCurrentIndex((prev) => (prev + 1) % images.length);
      }
    }, 5000);

    return () => clearInterval(interval);
  }, [images.length, isHovered]);

  const currentImage = images[currentIndex];

  if (images.length === 0) return null;

  return (
    <div
      className="carousel-container position-relative"
      onMouseEnter={() => setIsHovered(true)}
      onMouseLeave={() => setIsHovered(false)}
      role="region"
      aria-label="Galeri foto berita"
    >
      <div className="carousel-slide text-center">
        <img
          src={currentImage.url}
          className="img-fluid rounded shadow-sm d-block mx-auto"
          alt={currentImage.caption || `Foto ${currentIndex + 1}`}
          style={{ maxHeight: "500px", objectFit: "contain" }}
          onError={(e) => {
            console.error("Carousel image failed to load:", currentImage.url);
            e.currentTarget.style.display = "none";
          }}
        />
        {currentImage.caption && (
          <div className="carousel-caption mt-2 fst-italic text-muted small">
            {currentImage.caption}
          </div>
        )}
      </div>

      {images.length > 1 && (
        <>
          <button
            className="carousel-control-prev"
            onClick={prev}
            aria-label="Foto sebelumnya"
          >
            ‹
          </button>
          <button
            className="carousel-control-next"
            onClick={next}
            aria-label="Foto selanjutnya"
          >
            ›
          </button>

          <div className="carousel-indicators d-flex justify-content-center mt-3">
            {images.map((_, idx) => (
              <button
                key={idx}
                className={`indicator-dot ${idx === currentIndex ? "active" : ""}`}
                onClick={() => goToSlide(idx)}
                aria-label={`Lihat foto ${idx + 1}`}
                aria-current={idx === currentIndex ? "true" : undefined}
              />
            ))}
          </div>
        </>
      )}
    </div>
  );
};

interface BeritaDetail {
  id_berita: string;
  judul: string;
  intro: string;
  content: string;
  content2?: string;
  feat_image: string;
  additional_images?: any;
  created_at: string;
  updated_at: string;
  hit: string;
  created_by_name?: string;
  sumber?: string;
  link_video?: string;
  caption?: string;
  topik?: string;
  id_kategori: string;
  id_sub_kategori: string | null;
  kategori: string[];
  kategori_ids: string[];
}

interface BeritaTerkait {
  id_berita: string;
  judul: string;
  slug: string;
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

  const additionalImgs = useMemo(() => {
    return parseAdditionalImages(berita?.additional_images);
  }, [berita?.additional_images]);

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
    
    const cleanPath = imagePath.replace(/^\/+/, "");
    
    if (cleanPath.startsWith('http')) {
      return cleanPath;
    }
    
    const fullUrl = `${ROOT}/${cleanPath}`;
    console.log("Image URL:", fullUrl);
    return fullUrl;
  };

  // Event listener untuk copy protection
  useEffect(() => {
    const handleCopy = (e: ClipboardEvent) => {
      // Cegah default copy behavior
      e.preventDefault();
      
      // Ambil teks yang dipilih
      const selection = window.getSelection();
      const selectedText = selection?.toString() || "";
      
      if (selectedText && berita) {
        // Buat custom text dengan watermark/kredit
        const customText = `${selectedText}\n\n---\nSumber: ${berita.judul}\nDikutip dari: ${window.location.href}\n© ${new Date().getFullYear()} - Hak Cipta Dilindungi`;
        
        // Override clipboard dengan text custom
        e.clipboardData?.setData("text/plain", customText);
        
        // Optional: Tampilkan notifikasi
        console.log("Teks disalin dengan kredit sumber");
      }
    };

    // Tambahkan event listener
    document.addEventListener("copy", handleCopy);

    // Cleanup
    return () => {
      document.removeEventListener("copy", handleCopy);
    };
  }, [berita]);

  // Optional: Disable context menu (klik kanan)
  useEffect(() => {
    const handleContextMenu = (e: MouseEvent) => {
      // Hanya disable pada area artikel
      const target = e.target as HTMLElement;
      if (target.closest('.berita-article')) {
        e.preventDefault();
        return false;
      }
    };

    document.addEventListener("contextmenu", handleContextMenu);

    return () => {
      document.removeEventListener("contextmenu", handleContextMenu);
    };
  }, []);

  useEffect(() => {
    const fetchBeritaDetail = async () => {
      if (!id) return;

      setLoading(true);
      setError("");

      try {
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
          console.log("Additional Images Raw:", data.additional_images);
          console.log("Parsed Additional Images:", parseAdditionalImages(data.additional_images));

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

  const handleBeritaTerkaitClick = (slug: string) => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
    navigate(`/berita/${slug}`);
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
        <div className="col-lg-8">
          <button
            className="btn btn-link back-button mb-3"
            onClick={() => navigate("/berita")}
          >
            <ArrowLeft size={18} className="me-2" />
            Kembali ke Berita
          </button>

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

            <div className="article-image-section mt-4">
              {berita.feat_image && (
                <div className="main-image-wrapper mb-4">
                  <img
                    src={getImageUrl(berita.feat_image) || ""}
                    className="img-fluid rounded shadow-sm"
                    alt={berita.judul}
                    onError={(e) => {
                      console.error("Featured image failed to load:", berita.feat_image);
                      e.currentTarget.style.display = "none";
                    }}
                  />
                  {berita.caption && (
                    <div className="image-caption text-center mt-2 fst-italic text-muted small">
                      {berita.caption}
                    </div>
                  )}
                </div>
              )}

              {additionalImgs.length > 0 && (
                <div className="additional-images-carousel mt-4">
                  <h5 className="mb-3">Galeri Foto</h5>
                  <Carousel images={additionalImgs} getImageUrl={getImageUrl} />
                </div>
              )}
            </div>

            <div className="article-intro">
              <strong>{berita.intro}</strong>
            </div>

            <div
              className="article-content"
              dangerouslySetInnerHTML={{ __html: berita.content }}
            />

            {berita.content2 && (
              <div
                className="article-content"
                dangerouslySetInnerHTML={{ __html: berita.content2 }}
              />
            )}

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

            {berita.kategori && berita.kategori.length > 0 && (
              <div className="article-tags mt-4">
                <strong>Kategori:</strong>
                {berita.kategori.map((cat, idx) => (
                  <span key={idx} className="tag-badge bg-primary text-white px-2 py-1 rounded me-2">
                    {cat}
                  </span>
                ))}
              </div>
            )}
          </article>
        </div>

        <div className="col-lg-4">
          <div className="sidebar-sticky">
            <h5 className="sidebar-title">Berita Terkait</h5>

            {beritaTerkait.length > 0 ? (
              <div className="berita-terkait-list">
                {beritaTerkait.map((item) => (
                  <div
                    key={item.id_berita}
                    className="berita-terkait-item"
                    onClick={() => handleBeritaTerkaitClick(item.slug)}
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