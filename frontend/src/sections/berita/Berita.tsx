import React from "react";
import "bootstrap/dist/css/bootstrap.min.css";
import "./css/berita.css";

const Berita: React.FC = () => {
  return (
    <div className="container my-5 berita-container">
      {/* ROW 1 */}
      <div className="row">
        {/* ===== BERITA UTAMA ===== */}
        <div className="col-lg-8">
          <h5 className="section-title">
            <i className="bi bi-caret-right-fill me-2"></i>Berita Utama
          </h5>
          <div className="card border-0 shadow-sm berita-utama">
            <img
              src="/assets/berita-utama-sample.jpg"
              className="card-img-top rounded-2"
              alt="Berita Utama"
            />
            <div className="card-body">
              <h5 className="card-title fw-semibold mb-2">
                Optimalkan Pembangunan Infrastruktur, Pemkot Tangerang Perbaiki 40 Ruas Jalan Kota
              </h5>
              <p className="card-text text-muted small mb-2">
                Selasa, 25 Juni 2025
              </p>
              <p className="card-text small">
                Ini adalah ringkasan dari berita utama. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
              </p>
              <a href="/berita/1" className="btn btn-primary btn-sm">
                Baca Selengkapnya
              </a>
            </div>
          </div>
        </div>

        {/* ===== BERITA POPULER ===== */}
        <div className="col-lg-4">
          <h5 className="section-title">
            <i className="bi bi-caret-right-fill me-2"></i>Berita Populer
          </h5>
          <ul className="list-group list-group-flush">
            <li className="list-group-item px-0 border-0 pb-2">
              <a href="/berita/2" className="text-decoration-none text-dark small">
                1# Dinkes Genjot Capaian Booster Covid-19, Ini Cara Cek Jadwal Vaksinasi
              </a>
            </li>
            <li className="list-group-item px-0 border-0 pb-2">
              <a href="/berita/3" className="text-decoration-none text-dark small">
                2# Catat! Ini 69 Obat yang Dicabut Izin Edarnya oleh BPOM
              </a>
            </li>
            <li className="list-group-item px-0 border-0 pb-2">
              <a href="/berita/4" className="text-decoration-none text-dark small">
                3# Kick Off Imunisasi PCV, Cegah Pneumonia pada Bayi
              </a>
            </li>
            <li className="list-group-item px-0 border-0 pb-2">
              <a href="/berita/5" className="text-decoration-none text-dark small">
                4# Mulai Hari Ini, Bus Tayo dan Si Benteng Digratiskan
              </a>
            </li>
            <li className="list-group-item px-0 border-0 pb-2">
              <a href="/berita/6" className="text-decoration-none text-dark small">
                5# Segera Siapkan Berkas, Disnaker Akan Buka 783 Loker Besar!
              </a>
            </li>
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

          {[1, 2, 3, 4, 5].map((item) => (
            <div
              key={item}
              className="d-flex gap-3 align-items-start berita-terkini-item mb-3 pb-3 border-bottom"
            >
              <img
                src="/assets/mas.png"
                className="rounded berita-thumb"
                alt="Berita Terkini"
              />
              <div>
                <h6 className="fw-semibold mb-1">
                  Judul Berita Terkini {item}
                </h6>
                <p className="text-muted small mb-2">
                  Kamis, 25 Desember | 15 jam lalu
                </p>
                <p className="text-secondary small mb-2">
                  Ini adalah ringkasan dari berita terkini. Lorem ipsum dolor sit amet,
                  consectetur adipiscing elit.
                </p>
                <a href={`/berita/${item}`} className="btn btn-outline-primary btn-sm">
                  Baca Selengkapnya
                </a>
              </div>
            </div>
          ))}
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
