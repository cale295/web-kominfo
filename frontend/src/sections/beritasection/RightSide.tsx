import React from "react";
import { Link } from "react-router-dom";
import { Triangle } from "lucide-react";
import "./css/Berita.css";

// Interface untuk RightSide props
interface RightSideProps {
  beritaPopuler: BeritaItem[];
  tagPopuler: Tag[];
  filterBeritaByTag: (tag: Tag) => void;
  selectedTag?: Tag | null;
  getImageUrl: (imagePath: string) => string;
  formatDate: (dateString: string) => string;
  isFilterMode: boolean;
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

const RightSide: React.FC<RightSideProps> = ({
  beritaPopuler,
  tagPopuler,
  filterBeritaByTag,
  selectedTag,
  getImageUrl,
  formatDate,
  isFilterMode
}) => {
  // Render Berita Populer Section
  const renderBeritaPopulerSection = () => (
    <div className={isFilterMode ? "mb-4" : ""} >
      <h5 className="section-title">
        <Triangle className="icon-triangle" /> Berita Populer
      </h5>
      <div className="berita-populer-card">
        <ul className="list-unstyled berita-populer-list">
          {beritaPopuler.length > 0 ? (
            beritaPopuler.map((item, index) => (
              <li key={item.id_berita} className="berita-populer-item">
                <Link
                  to={`/berita/${item.slug}`}
                  className="berita-populer-link text-decoration-none"
                >
                  <span className="berita-number">{index + 1}#</span>
                  <div className="berita-content">
                    <span className="berita-title text-break">
                      {item.judul}
                    </span>
                    <span className="berita-date">
                      dibaca {item.hit} kali
                    </span>
                  </div>
                </Link>
              </li>
            ))
          ) : (
            <li className="text-muted">Memuat...</li>
          )}
        </ul>
        <Link to="/berita/populer" className="btn-link-more">
          Lihat berita populer lainnya
        </Link>
      </div>
    </div>
  );

  // Render Tag Populer Section
  const renderTagPopulerSection = () => (
    <div>
      <h5 className="section-title">
        <Triangle className="icon-triangle" /> Tag Paling Dicari
      </h5>
      <div className="tag-populer-card">
        <ul className="list-unstyled tag-populer-list">
          {tagPopuler.length > 0 ? (
            tagPopuler.map((tag, index) => (
              <li key={tag.id_tags} className="tag-populer-item">
                <button
                  onClick={() => filterBeritaByTag(tag)}
                  className={`tag-populer-link ${
                    selectedTag?.id_tags === tag.id_tags ? "active" : ""
                  }`}
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
            <p className="text-muted small">Memuat tag...</p>
          )}
        </ul>
      </div>
    </div>
  );

  // Render berdasarkan mode
  return (
    <div className="col-lg-4">
      {renderBeritaPopulerSection()}
      {renderTagPopulerSection()}
    </div>
  );
};

export default RightSide;