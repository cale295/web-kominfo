import type { RefObject } from "react";
import { Link } from "react-router-dom";
import { Triangle } from "lucide-react";
import "./css/Berita.css";

// Interface untuk LeftSide props
interface LeftSideProps {
  beritaUtamaList: BeritaItem[];
  beritaTerkini: BeritaItem[];
  getMainContent: () => React.ReactNode;
  getMainContentTitle: () => string;
  getImageUrl: (imagePath: string) => string;
  formatDate: (dateString: string) => string;
  isFilterMode: boolean;
  hasMore: boolean;
  loadingMore: boolean;
  observerTarget: RefObject<HTMLDivElement>;
  
  // Untuk filter mode
  selectedTag?: Tag | null;
  selectedKategori?: Kategori | null;
  searchQuery?: string;
  hasSearched?: boolean;
  beritaByTag?: BeritaItem[];
  beritaByKategori?: BeritaItem[];
  searchResults?: BeritaItem[];
  isSearching?: boolean;
  loadingTag?: boolean;
  loadingKategori?: boolean;
}

interface BeritaItem {
  id_berita: string;
  judul: string;
  slug: string;
  intro: string;
  feat_image: string;
  tanggal: string;
  hit: string;
  kategori?: string[];
  kategori_slugs?: string[];
  tags?: string[];
  tags_slugs?: string[];
}

interface Tag {
  id_tags: string;
  nama_tag: string;
  slug: string;
}

interface Kategori {
  id_kategori: string;
  kategori: string;
  slug: string;
  trash: string;
}

const LeftSide: React.FC<LeftSideProps> = ({
  beritaUtamaList,
  beritaTerkini,
  getMainContent,
  getMainContentTitle,
  getImageUrl,
  formatDate,
  isFilterMode,
  hasMore,
  loadingMore,
  observerTarget
}) => {
  // Render Berita Utama Carousel
  const renderBeritaUtamaCarousel = () => (
    <div className="">
      <h5 className="section-title">
        <Triangle className="icon-triangle" /> Berita Utama
      </h5>

      {beritaUtamaList.length > 0 ? (
        <div
          id="carouselBeritaUtama"
          className="carousel slide"
          data-bs-ride="carousel"
        >
          <div className="carousel-indicators">
            {beritaUtamaList.map((_, index) => (
              <button
                key={index}
                type="button"
                data-bs-target="#carouselBeritaUtama"
                data-bs-slide-to={index}
                className={index === 0 ? "active" : ""}
                aria-current={index === 0 ? "true" : "false"}
              ></button>
            ))}
          </div>

          <div className="carousel-inner">
            {beritaUtamaList.map((item, index) => (
              <Link
                key={item.id_berita}
                to={`/berita/${item.slug}`}
                className={`carousel-item ${
                  index === 0 ? "active" : ""
                }`}
                style={{ textDecoration: "none" }}
              >
                <img
                  src={getImageUrl(item.feat_image)}
                  className="d-block w-100 carousel-image"
                  alt={item.judul}
                  onError={(e) => {
                    (e.target as HTMLImageElement).src =
                      "/assets/placeholder-news.jpg";
                  }}
                />
                <div className="carousel-caption-custom">
                  <h5 className="caption-title">{item.judul}</h5>
                  <p className="caption-date">
                    {formatDate(item.tanggal)}
                  </p>
                </div>
              </Link>
            ))}
          </div>

          <button
            className="carousel-control-prev"
            type="button"
            data-bs-target="#carouselBeritaUtama"
            data-bs-slide="prev"
          >
            <span
              className="carousel-control-prev-icon"
              aria-hidden="true"
            ></span>
          </button>
          <button
            className="carousel-control-next"
            type="button"
            data-bs-target="#carouselBeritaUtama"
            data-bs-slide="next"
          >
            <span
              className="carousel-control-next-icon"
              aria-hidden="true"
            ></span>
          </button>
        </div>
      ) : (
        <p className="text-muted">Memuat berita utama...</p>
      )}
    </div>
  );

  // Render Berita Terkini Section
  const renderBeritaTerkiniSection = () => (
    <div className="">
      <h5 className="section-title">
        <Triangle className="icon-triangle" /> Berita Terkini
      </h5>
      <div 
        className="berita-terkini-scroll-container"
        style={{ 
          maxHeight: "850px", 
          overflowY: "auto",
          position: "relative"
        }}
      >
        {getMainContent()}
      </div>
    </div>
  );

  // Render Full Content Section (saat filter mode)
  const renderFullContentSection = () => (
    <div className="">
      <h5 className="section-title">
        <Triangle className="icon-triangle" />
        {getMainContentTitle()}
      </h5>
      <div className="berita-terkini-scroll-container">
        {getMainContent()}
      </div>
    </div>
  );

  // Render berdasarkan mode
  if (!isFilterMode) {
    return (
      <div className="col-lg-8">
        {renderBeritaUtamaCarousel()}
        {renderBeritaTerkiniSection()}
      </div>
    );
  }

  // Saat filter mode aktif
  return renderFullContentSection();
};

export default LeftSide;