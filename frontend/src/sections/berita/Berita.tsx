import React, { useState, useEffect } from "react";
import "bootstrap/dist/css/bootstrap.min.css";
import "./css/berita.css";
import api from "../../services/api";

// Interface untuk data berita
interface BeritaItem {
  id_berita: string;
  judul: string;
  intro: string;
  feat_image: string;
  created_at: string;
}

const Berita: React.FC = () => {
  // State untuk menyimpan data berita
  const [beritaUtama, setBeritaUtama] = useState<BeritaItem | null>(null);
  const [beritaPopuler, setBeritaPopuler] = useState<BeritaItem[]>([]);
  const [beritaTerkini, setBeritaTerkini] = useState<BeritaItem[]>([]);

  // Format tanggal
  const formatDate = (dateString: string) => {
    const options: Intl.DateTimeFormatOptions = { 
      day: 'numeric', 
      month: 'long', 
      year: 'numeric' 
    };
    return new Date(dateString).toLocaleDateString('id-ID', options);
  };

  useEffect(() => {
  const fetchBerita = async () => {
    try {
      // Fetch utama + list berita
      const res = await api.get("/berita");
      const data = res?.data?.data;

      if (!data) return;

      // ==========================
      // === FIX BERITA UTAMA ====
      // ==========================
      const utamaInfo = data.utama;
      let beritaUtamaDetail = null;

      if (utamaInfo && utamaInfo.id_berita) {
        const idUtama = utamaInfo.id_berita;

        // Cek apakah berita utama sudah ada di list "berita"
        const foundInList = data.berita.find(
          (item: BeritaItem) => item.id_berita === idUtama
        );

        if (foundInList) {
          beritaUtamaDetail = foundInList;
        } else {
          // Kalau tidak ada → fetch pakai endpoint detail
          const detailRes = await api.get(`/berita/${idUtama}`);
          beritaUtamaDetail = detailRes?.data?.data || null;
        }
      }

      setBeritaUtama(beritaUtamaDetail);

      // ==========================
      // === BERITA POPULER =======
      // ==========================
      const populer = [...data.berita]
        .sort((a, b) => Number(b.hit) - Number(a.hit))
        .slice(0, 5);
      setBeritaPopuler(populer);

      // ==========================
      // === BERITA TERKINI =======
      // ==========================
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
      {/* ROW 1 */}
      <div className="row">
        {/* ===== BERITA UTAMA ===== */}
        <div className="col-lg-8">
          <h5 className="section-title">
            <i className="bi bi-caret-right-fill me-2"></i>Berita Utama
          </h5>
          {beritaUtama ? (
            <div className="card border-0 shadow-sm berita-utama">
              <img
               src={`${ROOT}/${beritaUtama.feat_image.replace(/^\/+/, "")}`} // Gunakan base URL API jika perlu
                className="card-img-top rounded-2"
                alt={beritaUtama.judul}
              />
              <div className="card-body">
                <h5 className="card-title fw-semibold mb-2">
                  {beritaUtama.judul}
                </h5>
                <p className="card-text text-muted small mb-2">
                  {formatDate(beritaUtama.created_at)}
                </p>
                <p className="card-text small">
                  {beritaUtama.intro}
                </p>
                <a href={`/berita/${beritaUtama.id_berita}`} className="btn btn-primary btn-sm">
                  Baca Selengkapnya
                </a>
              </div>
            </div>
          ) : (
            <p>Loading berita utama...</p>
          )}
        </div>

        {/* ===== BERITA POPULER ===== */}
        <div className="col-lg-4">
          <h5 className="section-title">
            <i className="bi bi-caret-right-fill me-2"></i>Berita Populer
          </h5>
          <ul className="list-group list-group-flush">
            {beritaPopuler.length > 0 ? (
              beritaPopuler.map((item, index) => (
                <li key={item.id_berita} className="list-group-item px-0 border-0 pb-2">
                  <a 
                    href={`/berita/${item.id_berita}`} 
                    className="text-decoration-none text-dark small"
                  >
                    {index + 1}# {item.judul}
                  </a>
                </li>
              ))
            ) : (
              <li className="list-group-item px-0 border-0 pb-2">Loading...</li>
            )}
          </ul>
          <a href="#" className="small text-primary">
            Lihat berita populer lainnya
          </a>
        </div>
      </div>

      {/* ROW 2 */}
      <div className="row mt-5">
        {/* ===== BERITA TERKINI ===== */}
        <div className="col-lg-8">
          <h5 className="section-title">
            <i className="bi bi-caret-right-fill me-2"></i>Berita Terkini
          </h5>

          {beritaTerkini.length > 0 ? (
            beritaTerkini.map((item) => (
              <div
                key={item.id_berita}
                className="d-flex gap-3 align-items-start berita-terkini-item mb-3 pb-3 border-bottom"
              >
                <img
                  src={`${ROOT}/${item.feat_image.replace(/^\/+/, "")}`}
                  className="rounded berita-thumb"
                  alt={item.judul}
                  style={{ width: '100px', height: '60px', objectFit: 'cover' }} // Gaya opsional
                />
                <div>
                  <h6 className="fw-semibold mb-1">
                    {item.judul}
                  </h6>
                  <p className="text-muted small mb-2">
                    {formatDate(item.created_at)}
                  </p>
                  <p className="text-secondary small mb-2">
                    {item.intro}
                  </p>
                  <a href={`/berita/${item.id_berita}`} className="btn btn-outline-primary btn-sm">
                    Baca Selengkapnya
                  </a>
                </div>
              </div>
            ))
          ) : (
            <p>Loading berita terkini...</p>
          )}
        </div>

        {/* ===== TAG PALING DICARI ===== */}
        <div className="col-lg-4">
          <h5 className="section-title">
            <i className="bi bi-caret-right-fill me-2"></i>Tag Paling Dicari
          </h5>
          <div className="d-flex flex-wrap gap-2">
            {[
              "Kota Tangerang",
              "Dinas Kesehatan",
              "Festival",
              "Banjir",
              "UMKM",
              "PBB",
              "Darurat",
              "Pariwisata",
              "Makanan",
              "Ekonomi",
            ].map((tag, i) => (
              <a
                key={i}
                href={`/berita/tag/${tag.toLowerCase().replace(" ", "-")}`}
                className="btn btn-outline-secondary btn-sm rounded-pill"
              >
                #{tag}
              </a>
            ))}
          </div>
        </div>
      </div>
    </div>
  );
};

export default Berita;