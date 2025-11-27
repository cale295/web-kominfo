import React, { useState, useEffect } from "react";
import "bootstrap/dist/css/bootstrap.min.css";
import "./css/berita.css";
import api from "../../services/api";
import { Triangle, X } from "lucide-react";

interface BeritaItem {
  id_berita: string;
  judul: string;
  slug: string;
  intro: string;
  feat_image: string;
  created_at: string;
  hit: string;
  tags?: Tag[];
}

interface Tag {
  id_tags: string;
  nama_tag: string;
  slug: string;
  is_delete: string;
}

interface BeritaUtamaItem {
  id_berita_utama: string;
  id_berita: string;
  jenis: string;
  created_date: string;
  created_by_id: string;
  created_by_name: string;
  status: string;
}

const Berita: React.FC = () => {
  const [beritaUtamaList, setBeritaUtamaList] = useState<BeritaItem[]>([]);
  const [beritaPopuler, setBeritaPopuler] = useState<BeritaItem[]>([]);
  const [beritaTerkini, setBeritaTerkini] = useState<BeritaItem[]>([]);
  const [tagPopuler, setTagPopuler] = useState<Tag[]>([]);
  const [selectedTag, setSelectedTag] = useState<Tag | null>(null);
  const [beritaByTag, setBeritaByTag] = useState<BeritaItem[]>([]);
  const [loadingTag, setLoadingTag] = useState<boolean>(false);
  const [allBerita, setAllBerita] = useState<BeritaItem[]>([]);

  const formatDate = (dateString: string) => {
    const options: Intl.DateTimeFormatOptions = {
      day: "numeric",
      month: "long",
      year: "numeric",
    };
    return new Date(dateString).toLocaleDateString("id-ID", options);
  };

  // Fetch semua data berita
  useEffect(() => {
    const fetchBerita = async () => {
      try {
        const res = await api.get("/berita");
        const data = res?.data?.data;

        if (!data) return;

        // Simpan semua berita untuk filtering
        setAllBerita(data.berita || []);

        // berita utama
        const utamaArray: BeritaUtamaItem[] = data.utama || [];
        const beritaUtamaDetailList: BeritaItem[] = [];

        if (utamaArray.length > 0) {
          for (const utamaItem of utamaArray) {
            const idUtama = utamaItem.id_berita;

            const foundInList = data.berita.find(
              (item: BeritaItem) => item.id_berita === idUtama
            );

            if (foundInList) {
              beritaUtamaDetailList.push(foundInList);
            } else {
              try {
                const detailRes = await api.get(`/berita/${idUtama}`);
                const detailData = detailRes?.data?.data;
                if (detailData) {
                  beritaUtamaDetailList.push(detailData);
                }
              } catch (fetchError) {
                console.error(
                  `Gagal mengambil detail berita utama ${idUtama}:`,
                  fetchError
                );
              }
            }
          }
        }

        setBeritaUtamaList(beritaUtamaDetailList);

        if (data.tag) {
          const filteredTags = data.tag.filter((t: Tag) => t.is_delete === "0");
          setTagPopuler(filteredTags);
        }

        // berita popular
        const populer = [...data.berita]
          .sort((a, b) => Number(b.hit) - Number(a.hit))
          .slice(0, 5);
        setBeritaPopuler(populer);
        
        // berita terkini
        const terkini = [...data.berita]
          .sort(
            (a, b) =>
              new Date(b.created_at).getTime() -
              new Date(a.created_at).getTime()
          )
          .slice(0, 5);
        setBeritaTerkini(terkini);
      } catch (error) {
        console.error("Gagal fetch berita:", error);
      }
    };

    fetchBerita();
  }, []);

  // Fetch berita berdasarkan tag
  const fetchBeritaByTag = async (tag: Tag) => {
    try {
      setLoadingTag(true);
      setSelectedTag(tag);
      
      // Filter berita yang memiliki tag yang dipilih
      // Asumsi: data berita sudah memiliki properti tags
      const filteredBerita = allBerita.filter(berita => 
        berita.tags?.some(t => t.id_tags === tag.id_tags)
      );
      
      // Jika tidak ada data di local, fetch dari API
      if (filteredBerita.length === 0) {
        const res = await api.get(`/berita/tag/${tag.slug}`);
        if (res.data?.data) {
          setBeritaByTag(res.data.data);
        }
      } else {
        setBeritaByTag(filteredBerita);
      }
    } catch (error) {
      console.error("Gagal fetch berita by tag:", error);
      // Fallback: filter dari data local berdasarkan judul/intro yang mengandung tag
      const filteredByKeyword = allBerita.filter(berita => 
        berita.judul.toLowerCase().includes(tag.nama_tag.toLowerCase()) ||
        berita.intro.toLowerCase().includes(tag.nama_tag.toLowerCase())
      );
      setBeritaByTag(filteredByKeyword);
    } finally {
      setLoadingTag(false);
    }
  };

  // Clear tag filter
  const clearTagFilter = () => {
    setSelectedTag(null);
    setBeritaByTag([]);
  };

  const ROOT = api.defaults.baseURL?.replace("/api", "") ?? "";

  return (
    <div className="container-fluid my-5 berita-container">
      {/* Tag Filter Indicator */}
      {selectedTag && (
        <div className="row mb-4">
          <div className="col-12">
            <div className="alert alert-info d-flex justify-content-between align-items-center">
              <span>
                Menampilkan berita dengan tag: <strong>{selectedTag.nama_tag}</strong>
              </span>
              <button 
                className="btn btn-sm btn-outline-secondary"
                onClick={clearTagFilter}
              >
                <X size={16} /> Clear Filter
              </button>
            </div>
          </div>
        </div>
      )}

      <div className="row">
        {/* Berita Utama - TETAP MUNCUL meski ada filter tag */}
        <div className="col-lg-8 mb-4">
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
                    aria-label={`Slide ${index + 1}`}
                  ></button>
                ))}
              </div>

              <div className="carousel-inner">
                {beritaUtamaList.map((item, index) => (
                  <a
<<<<<<< HEAD
                    key={item.id_berita}
                    href={`/berita/${item.id_berita}`}
=======
                    href={`/berita/${item.slug}`}
>>>>>>> 8ed3398fd3c96094aa9aeb162cb9fe8f02364ba8
                    className={`carousel-item ${index === 0 ? "active" : ""}`}
                    style={{ textDecoration: "none" }}
                  >
                    <img
                      src={`${ROOT}/${item.feat_image.replace(/^\/+/, "")}`}
                      className="d-block w-100 carousel-image"
                      alt={item.judul}
                    />
                    <div className="carousel-caption-custom">
                      <h5 className="caption-title">{item.judul}</h5>
                      <p className="caption-date">
                        {formatDate(item.created_at)}
                      </p>
                    </div>
                  </a>
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
                <span className="visually-hidden">Previous</span>
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
                <span className="visually-hidden">Next</span>
              </button>
            </div>
          ) : (
            <p>Memuat berita utama...</p>
          )}
        </div>

        {/* Berita Populer - TETAP MUNCUL meski ada filter tag */}
        <div className="col-lg-4 mb-4">
          <h5 className="section-title">
            <Triangle className="icon-triangle" /> Berita Populer
          </h5>
          <div className="berita-populer-card">
<<<<<<< HEAD
            <ul className="list-unstyled berita-populer-list">
              {beritaPopuler.length > 0 ? (
                beritaPopuler.map((item, index) => (
                  <li key={item.id_berita} className="berita-populer-item">
                    <a
                      href={`/berita/${item.id_berita}`}
                      className="berita-populer-link"
                    >
                      <span className="berita-number">{index + 1}#</span>
                      <div className="berita-content">
                        <span className="berita-title text-break">
                          {item.judul}
                        </span>
                        <span className="berita-date">dibaca {item.hit} kali</span>
                      </div>
                    </a>
                  </li>
                ))
              ) : (
                <li className="text-muted">Memuat...</li>
              )}
            </ul>
            <a href="#" className="btn-link-more">
              Lihat berita populer lainnya
            </a>
=======
              <ul className="list-unstyled berita-populer-list">
                {beritaPopuler.length > 0 ? (
                  beritaPopuler.map((item, index) => (
                    <li key={item.id_berita} className="berita-populer-item">
                      <a
                        href={`/berita/${item.slug}`}
                        className="berita-populer-link"
                      >
                        <span className="berita-number">{index + 1}#</span>
                        <div className="berita-content">
                          <span className="berita-title text-break">
                            {item.judul}
                          </span>
                          <span className="berita-date">dibaca {item.hit} kali</span>
                        </div>
                      </a>
                    </li>
                  ))
                ) : (
                  <li className="text-muted">Memuat...</li>
                )}
              </ul>
              <a href="#" className="btn-link-more">
                Lihat berita populer lainnya
              </a>
>>>>>>> 8ed3398fd3c96094aa9aeb162cb9fe8f02364ba8
          </div>
        </div>
      </div>

      <div className="row mt-4">
        {/* Berita Terkini - BERUBAH menjadi berita berdasarkan tag jika ada filter */}
        <div className="col-lg-8 mb-4">
          <h5 className="section-title">
            <Triangle className="icon-triangle" /> 
            {selectedTag ? `Berita dengan Tag: ${selectedTag.nama_tag}` : "Berita Terkini"}
          </h5>

<<<<<<< HEAD
          {selectedTag ? (
            // Tampilkan berita berdasarkan tag
            loadingTag ? (
              <p>Memuat berita dengan tag {selectedTag.nama_tag}...</p>
            ) : beritaByTag.length > 0 ? (
              beritaByTag.map((item) => (
                <a
                  key={item.id_berita}
                  href={`/berita/${item.id_berita}`}
                  className="berita-terkini-card mb-3"
                >
=======
          {beritaTerkini.length > 0 ? (
            beritaTerkini.map((item) => (
              <a
                href={`/berita/${item.slug}`}
                className=" berita-terkini-card mb-3"
              >
>>>>>>> 8ed3398fd3c96094aa9aeb162cb9fe8f02364ba8
                  <div className="berita-terkini-card-body">
                    <div className="col-auto">
                      <img
                        src={`${ROOT}/${item.feat_image.replace(/^\/+/, "")}`}
                        className="berita-terkini-img"
                        alt={item.judul}
                      />
                    </div>
                    <div className="berita-terkini-card-item">
                      <h6 className="berita-terkini-title">{item.judul}</h6>
                      <p className="berita-terkini-intro">{item.intro}</p>
                      <p className="berita-terkini-date">
                        {formatDate(item.created_at)}
                      </p>
                    </div>
                  </div>
                </a>
              ))
            ) : (
              <p>Tidak ada berita dengan tag {selectedTag.nama_tag}.</p>
            )
          ) : (
            // Tampilkan berita terkini normal
            beritaTerkini.length > 0 ? (
              beritaTerkini.map((item) => (
                <a
                  key={item.id_berita}
                  href={`/berita/${item.id_berita}`}
                  className="berita-terkini-card mb-3"
                >
                  <div className="berita-terkini-card-body">
                    <div className="col-auto">
                      <img
                        src={`${ROOT}/${item.feat_image.replace(/^\/+/, "")}`}
                        className="berita-terkini-img"
                        alt={item.judul}
                      />
                    </div>
                    <div className="berita-terkini-card-item">
                      <h6 className="berita-terkini-title">{item.judul}</h6>
                      <p className="berita-terkini-intro">{item.intro}</p>
                      <p className="berita-terkini-date">
                        {formatDate(item.created_at)}
                      </p>
                    </div>
                  </div>
                </a>
              ))
            ) : (
              <p>Memuat berita terkini...</p>
            )
          )}
        </div>

        {/* Tag Paling Dicari - TETAP MUNCUL meski ada filter tag */}
        <div className="col-lg-4 mb-4">
          <h5 className="section-title">
            <Triangle className="icon-triangle" /> Tag Paling Dicari
          </h5>
          <div className="tag-populer-card">
            <ul className="list-unstyled tag-populer-list">
              {tagPopuler.length > 0 ? (
                tagPopuler.map((tag, index) => (
                  <li key={tag.id_tags} className="tag-populer-item">
                    <button
                      onClick={() => fetchBeritaByTag(tag)}
                      className={`tag-populer-link ${selectedTag?.id_tags === tag.id_tags ? 'active' : ''}`}
                      style={{ 
                        background: 'none', 
                        border: 'none', 
                        width: '100%', 
                        textAlign: 'left',
                        cursor: 'pointer'
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
      </div>
    </div>
  );
};

export default Berita;