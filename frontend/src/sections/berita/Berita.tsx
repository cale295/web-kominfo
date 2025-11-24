import React, { useState, useEffect } from "react";
import "bootstrap/dist/css/bootstrap.min.css";
import "./css/berita.css";
import api from "../../services/api";
import { Triangle } from "lucide-react";

interface BeritaItem {
  id_berita: string;
  judul: string;
  intro: string;
  feat_image: string;
  created_at: string;
  hit: string;
}

interface Tag {
  id_tags: string;
  name: string;
  slug: string;
  trash: string;
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

  const formatDate = (dateString: string) => {
    const options: Intl.DateTimeFormatOptions = {
      day: "numeric",
      month: "long",
      year: "numeric",
    };
    return new Date(dateString).toLocaleDateString("id-ID", options);
  };

  useEffect(() => {
    const fetchBerita = async () => {
      try {
        const res = await api.get("/berita");
        const data = res?.data?.data;

        if (!data) return;
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
          const filteredTags = data.tag.filter((t: Tag) => t.trash === "0");
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

  const ROOT = api.defaults.baseURL?.replace("/api", "") ?? "";

  return (
    <div className="container my-5 berita-container">
      <div className="row">
        {/* Berita Utama */}
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
                  <div
                    key={item.id_berita}
                    className={`carousel-item ${index === 0 ? "active" : ""}`}
                  >
                    <img
                      src={`${ROOT}/${item.feat_image.replace(/^\/+/, "")}`}
                      className="d-block w-100 carousel-image"
                      alt={item.judul}
                    />
                    <div className="carousel-caption-custom">
                      <h5 className="caption-title">{item.judul}</h5>
                      <p className="caption-date">{formatDate(item.created_at)}</p>
                    </div>
                  </div>
                ))}
              </div>

              <button
                className="carousel-control-prev"
                type="button"
                data-bs-target="#carouselBeritaUtama"
                data-bs-slide="prev"
              >
                <span className="carousel-control-prev-icon" aria-hidden="true"></span>
                <span className="visually-hidden">Previous</span>
              </button>
              <button
                className="carousel-control-next"
                type="button"
                data-bs-target="#carouselBeritaUtama"
                data-bs-slide="next"
              >
                <span className="carousel-control-next-icon" aria-hidden="true"></span>
                <span className="visually-hidden">Next</span>
              </button>
            </div>
          ) : (
            <p>Memuat berita utama...</p>
          )}
        </div>

        {/* Berita Populer */}
        <div className="col-lg-4 mb-4">
          <h5 className="section-title">
            <Triangle className="icon-triangle" /> Berita Populer
          </h5>
          <div className="card berita-populer-card">
            <div className="card-body">
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
                          <span className="berita-title">{item.judul}</span>
                          <span className="berita-date">Sabtu 2019 Mei</span>
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
            </div>
          </div>
        </div>
      </div>

      <div className="row mt-4">
        {/* Berita Terkini */}
        <div className="col-lg-8 mb-4">
          <h5 className="section-title">
            <Triangle className="icon-triangle" /> Berita Terkini
          </h5>

          {beritaTerkini.length > 0 ? (
            beritaTerkini.map((item) => (
              <div key={item.id_berita} className="card berita-terkini-card mb-3">
                <div className="card-body">
                  <div className="row g-3">
                    <div className="col-auto">
                      <img
                        src={`${ROOT}/${item.feat_image.replace(/^\/+/, "")}`}
                        className="berita-terkini-img"
                        alt={item.judul}
                      />
                    </div>
                    <div className="col">
                      <h6 className="berita-terkini-title">{item.judul}</h6>
                      <p className="berita-terkini-date">
                        {formatDate(item.created_at)}
                      </p>
                      <p className="berita-terkini-intro">{item.intro}</p>
                    </div>
                  </div>
                </div>
              </div>
            ))
          ) : (
            <p>Memuat berita terkini...</p>
          )}
        </div>

        {/* Tag Paling Dicari */}
        <div className="col-lg-4 mb-4">
          <h5 className="section-title">
            <Triangle className="icon-triangle" /> Tag Paling Dicari
          </h5>
          <div className="card tag-populer-card">
            <div className="card-body">
              <ul className="list-unstyled tag-populer-list">
                {tagPopuler.length > 0 ? (
                  tagPopuler.map((tag, index) => (
                    <li key={tag.id_tags} className="tag-populer-item">
                      <a
                        href={`/berita/tag/${tag.slug}`}
                        className="tag-populer-link"
                      >
                        <span className="tag-number">#{index + 1}</span>
                        <span className="tag-name">{tag.name}</span>
                      </a>
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
    </div>
  );
};

export default Berita;