import React, { useState, useEffect, useMemo } from "react";
import { useParams, useNavigate } from "react-router-dom";
import "./css/beritadetail.css";
import api from "../../services/api";
import { ArrowLeft, Calendar, Eye, Share2, Triangle } from "lucide-react";

interface AdditionalImage {
  url: string;
  caption: string;
}

interface Tag {
  id_tags: string;
  nama_tag: string;
  slug: string;
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

    if (typeof imagesData === "string") {
      const trimmed = imagesData.trim();
      if (trimmed.startsWith("[") && trimmed.endsWith("]")) {
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
  currentIndex: number;
  setCurrentIndex: React.Dispatch<React.SetStateAction<number>>;
}

const Carousel: React.FC<CarouselProps> = ({
  images,
  currentIndex,
  setCurrentIndex,
}) => {
  const [isHovered, setIsHovered] = useState(false);

  const next = () => setCurrentIndex((prev) => (prev + 1) % images.length);

  const prev = () =>
    setCurrentIndex((prev) => (prev - 1 + images.length) % images.length);

  useEffect(() => {
    if (images.length <= 1) return;

    const interval = setInterval(() => {
      if (!isHovered) {
        setCurrentIndex((prev) => (prev + 1) % images.length);
      }
    }, 5000);

    return () => clearInterval(interval);
  }, [images.length, isHovered, setCurrentIndex]);

  if (!images.length) return null;

  return (
    <div
      className="carousel-container"
      onMouseEnter={() => setIsHovered(true)}
      onMouseLeave={() => setIsHovered(false)}
    >
      <div className="carousel-slide text-center">
        <img
          src={images[currentIndex].url}
          className="img-fluid shadow-sm d-block mx-auto"
          style={{ maxHeight: "500px", objectFit: "contain" }}
        />
      </div>

      {images.length > 1 && (
        <>
          <button className="carousel-control-prev" onClick={prev}>
            ‹
          </button>
          <button className="carousel-control-next" onClick={next}>
            ›
          </button>
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
  id_berita_terkait?: string;
  content2?: string;
  id_berita_terkait2?: string;
  feat_image: string;
  additional_images?: any;
  tanggal: string;
  hit: string;
  created_by_name?: string;
  sumber?: string;
  link_video?: string;
  caption?: string;
  id_kategori: string;
  id_sub_kategori: string | null;
  kategori: string[];
  kategori_ids: string[];
  tags: string[];
}

interface BeritaTerkait {
  id_berita: string;
  judul: string;
  slug: string;
  intro: string;
  feat_image: string;
  hit?: string;
}

// Komponen BeritaTerkaitSisipan Sederhana
interface BeritaTerkaitSisipanProps {
  berita: BeritaTerkait;
  onItemClick: (slug: string) => void;
}

const BeritaTerkaitSisipan: React.FC<BeritaTerkaitSisipanProps> = ({
  berita,
  onItemClick,
}) => {
  return (
    <div 
      className="berita-sisipan-simple mt-4 mb-4 cursor-pointer"
      onClick={() => onItemClick(berita.slug)}
    >
      <div className="sisipan-content p-3">
        <div className="sisipan-label mb-2">
          <strong>Baca Juga:</strong>
        </div>
        <h6 className="sisipan-judul mb-0 fw-bold">{berita.judul}</h6>
      </div>
    </div>
  );
};

const BeritaDetail: React.FC = () => {
  const { id } = useParams<{ id: string }>();
  const navigate = useNavigate();
  const [berita, setBerita] = useState<BeritaDetail | null>(null);
  const [beritaTerkaitSisipan1, setBeritaTerkaitSisipan1] = useState<BeritaTerkait | null>(null);
  const [beritaTerkaitSisipan2, setBeritaTerkaitSisipan2] = useState<BeritaTerkait | null>(null);
  const [beritaPopuler, setBeritaPopuler] = useState<BeritaTerkait[]>([]);
  const [tagPopuler, setTagPopuler] = useState<Tag[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState("");
  const [currentSlide, setCurrentSlide] = useState(0);

  const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString("id-ID", {
      day: "numeric",
      month: "long",
      year: "numeric"
    });
  };
  
  const allImages = useMemo(() => {
    if (!berita) return [];

    const images: AdditionalImage[] = [];

    // Tambahkan feat_image sebagai gambar pertama
    if (berita.feat_image) {
      images.push({
        url: berita.feat_image,
        caption: berita.caption || "",
      });
    }

    // Tambahkan additional_images
    const additionalImgs = parseAdditionalImages(berita.additional_images);
    images.push(...additionalImgs);

    return images;
  }, [berita]);

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
        const customText = `${selectedText}\n\n---\nSumber: ${
          berita.judul
        }\nDikutip dari: ${
          window.location.href
        }\n© ${new Date().getFullYear()} - Hak Cipta Dilindungi`;

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
      if (target.closest(".berita-article")) {
        e.preventDefault();
        return false;
      }
    };

    document.addEventListener("contextmenu", handleContextMenu);

    return () => {
      document.removeEventListener("contextmenu", handleContextMenu);
    };
  }, []);

  const fetchBeritaManualTerkait = (idTerkait: string, semuaBerita: BeritaTerkait[]) => {
    if (!idTerkait) return null;
    return semuaBerita.find((item: BeritaTerkait) => item.id_berita === idTerkait);
  };

  useEffect(() => {
    const fetchBeritaDetail = async () => {
      if (!id) return;

      setLoading(true);
      setError("");

      try {
        const [resDetail, resAll] = await Promise.all([
          api.get(`/berita/${id}`),
          api.get("/berita"),
        ]);

        const data = resDetail?.data?.data;
        const allData = resAll?.data?.data;

        if (data) {
          setBerita(data);

          const allBerita = allData?.berita || [];
          
          // Ambil berita terkait sisipan
          if (data.id_berita_terkait) {
            const terkait1 = fetchBeritaManualTerkait(data.id_berita_terkait, allBerita);
            setBeritaTerkaitSisipan1(terkait1 || null);
          }

          if (data.id_berita_terkait2) {
            const terkait2 = fetchBeritaManualTerkait(data.id_berita_terkait2, allBerita);
            setBeritaTerkaitSisipan2(terkait2 || null);
          }

          // Setup Berita Populer
          const populer = [...allBerita]
            .sort((a: BeritaTerkait, b: BeritaTerkait) => Number(b.hit || 0) - Number(a.hit || 0))
            .slice(0, 5);
          setBeritaPopuler(populer);

          // Setup Tag Populer
          if (allData?.tag) {
            setTagPopuler(allData.tag);
          }
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
    window.scrollTo({ top: 0, behavior: "smooth" });
    navigate(`/berita/${slug}`);
  };

  const handleTagClick = (tag: Tag) => {
    navigate(`/berita?search=${encodeURIComponent(tag.nama_tag)}`);
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
        <button className="btn btn-primary" onClick={() => navigate("/berita")}>
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
                {formatDate(berita.tanggal)}
              </span>
              <span className="meta-item">
                <Eye size={16} />
                {berita.hit}
              </span>
              <button className="btn-share" onClick={handleShare}>
                <Share2 size={16} />
                Bagikan
              </button>
            </div>

            <div className="article-image-section mt-4">
              {allImages.length > 0 && (
                <>
                  <Carousel
                    images={allImages}
                    currentIndex={currentSlide}
                    setCurrentIndex={setCurrentSlide}
                  />

                  {allImages[currentSlide]?.caption && (
                    <div className="image-caption-outside">
                      {allImages[currentSlide].caption}
                    </div>
                  )}
                </>
              )}
            </div>

            {/* Content 1 */}
            <div
              className="article-content"
              dangerouslySetInnerHTML={{ __html: berita.content }}
            />

            {/* Sisipan Berita Terkait 1 */}
            {beritaTerkaitSisipan1 && (
              <BeritaTerkaitSisipan
                berita={beritaTerkaitSisipan1}
                onItemClick={handleBeritaTerkaitClick}
              />
            )}

            {/* Content 2 (jika ada) */}
            {berita.content2 && (
              <div
                className="article-content"
                dangerouslySetInnerHTML={{ __html: berita.content2 }}
              />
            )}

            {/* Sisipan Berita Terkait 2 (setelah content2) */}
            {beritaTerkaitSisipan2 && (
              <BeritaTerkaitSisipan
                berita={beritaTerkaitSisipan2}
                onItemClick={handleBeritaTerkaitClick}
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
                  <a
                    href={berita.link_video}
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    Tonton Video
                  </a>
                </p>
              )}
            </div>

            {berita.tags && berita.tags.length > 0 && (
              <div className="article-tags mt-4">
                {berita.tags.map((cat, idx) => (
                  <span
                    key={idx}
                    className="tag-badge text-blue px-2 py-1 rounded me-2"
                  >
                    {cat}
                  </span>
                ))}
              </div>
            )}
          </article>
        </div>

        <div className="col-lg-4">
          <div className="sidebar-sticky">
            {/* Berita Populer */}
            <div className="mb-4">
              <h5 className="sidebar-title">
                <Triangle className="icon-triangle" size={16} /> Berita Populer
              </h5>
              <div className="berita-populer-card">
                <ul className="list-unstyled berita-populer-list">
                  {beritaPopuler.length > 0 ? (
                    beritaPopuler.map((item, index) => (
                      <li key={item.id_berita} className="berita-populer-item">
                        <div
                          onClick={() => handleBeritaTerkaitClick(item.slug)}
                          className="berita-populer-link text-decoration-none"
                          style={{ cursor: "pointer" }}
                        >
                          <span className="berita-number">{index + 1}#</span>
                          <div className="berita-content">
                            <span className="berita-title text-break">
                              {item.judul}
                            </span>
                            <span className="berita-date">
                              dibaca {item.hit || 0} kali
                            </span>
                          </div>
                        </div>
                      </li>
                    ))
                  ) : (
                    <li className="text-muted">Tidak ada data</li>
                  )}
                </ul>
              </div>
            </div>

            {/* Tag Paling Dicari */}
            <div className="mb-4">
              <h5 className="sidebar-title">
                <Triangle className="icon-triangle" size={16} /> Tag Paling Dicari
              </h5>
              <div className="tag-populer-card">
                <ul className="list-unstyled tag-populer-list">
                  {tagPopuler.length > 0 ? (
                    tagPopuler.map((tag, index) => (
                      <li key={tag.id_tags} className="tag-populer-item">
                        <button
                          onClick={() => handleTagClick(tag)}
                          className="tag-populer-link"
                          style={{
                            background: "none",
                            border: "none",
                            width: "100%",
                            textAlign: "left",
                            cursor: "pointer",
                            padding: "0.5rem",
                          }}
                        >
                          <span className="tag-number">#{index + 1}</span>
                          <span className="tag-name">{tag.nama_tag}</span>
                        </button>
                      </li>
                    ))
                  ) : (
                    <p className="text-muted small">Tidak ada tag</p>
                  )}
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default BeritaDetail;