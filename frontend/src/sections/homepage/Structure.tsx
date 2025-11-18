import React from "react";
const anggota = [
  {
    img: "/assets/mas.png",
    nama: "Dr. MUGIYA WARDHANY, SE, M.Si",
    jabatan: "Kepala Dinas Komunikasi dan Informatika",
  },
  {
    img: "/assets/mas.png",
    nama: "NURHIDAYATULLAH, S.IP, M.Si",
    jabatan: "Sekretaris Dinas Komunikasi dan Informatika",
  },
  {
    img: "/assets/mas.png",
    nama: "MOHAMAD MUFLIH SUTISNA, SSTP, M.AP",
    jabatan:
      "Kepala Bidang Sarana dan Prasarana TIK dan Persandian Dinas Komunikasi dan Informatika",
  },
  {
    img: "/assets/mas.png",
    nama: "ANTON RIYANTO, ST, MT",
    jabatan:
      "Kepala Bidang Statistik dan Pemberdayaan TIK Dinas Komunikasi dan Informatika",
  },
  {
    img: "/assets/mas.png",
    nama: "RIZKY FEBRIYANTO SUNARYO, S.Kom., M.T.I",
    jabatan:
      "Kepala Bidang Pengembangan eGovernment Dinas Komunikasi dan Informatika",
  },
  {
    img: "/assets/mas.png",
    nama: "IAN CHAVIDZ RIZQIULLAH, S.STP",
    jabatan:
      "Kepala Bidang Diseminasi Informasi dan Komunikasi Publik Dinas Komunikasi dan Informatika",
  },
  {
    img: "/assets/mas.png",
    nama: "MUHAMMAD IQBAL SANTOSO, A.Md.P., S.H",
    jabatan:
      "Kepala UPT Pengelola Ruang Kendali Kota Dinas Komunikasi dan Informatika",
  },
];
const customStyles = `
.bg-blue-light { background-color: #ECF1FF; }
.bg-blue-card-light { background-color: #C9D7FF; }
.bg-blue-card-alt { background-color: #ECF1FF; }
.text-blue-dark { color: #1e3a8a; }
.text-blue-title { color: #1d4ed8; font-size: 1rem; }
.text-blue-jabatan { color: #2563eb; font-size: 0.9rem; }
.member-card {
width: 100%;
min-height: 130px;
border-radius: 10px;
box-shadow: 0 2px 6px rgba(0,0,0,0.08);
transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.member-card:hover {
transform: scale(1.02);
box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}
.member-img {
width: 90px;
height: 100px;
object-fit: cover;
border-radius: 6px;
}
.custom-scrollbar {
height: 750px;
overflow-y: auto;
}
.custom-scrollbar::-webkit-scrollbar {
width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
background-color: #60a5fa;
border-radius: 3px;
}
.custom-scrollbar::-webkit-scrollbar-track {
background-color: #dbeafe;
border-radius: 3px;
}
.image-text-container {
position: relative;
display: flex;
flex-direction: column;
justify-content: flex-end;
align-items: center;
text-align: center;
height: 750px;
}
.image-text-container .overlay-text {
position: absolute;
top: 30%;
left: 50%;
transform: translate(-50%, -50%);
font-size: 7rem;
font-family: "Poppins", sans-serif;
font-weight: 600;
line-height: 1.2;
text-align: left;
white-space: pre-line;
color: transparent;
-webkit-text-stroke: 2px #BECEFB;
z-index: 1;
pointer-events: none;
}
.image-text-container img {
max-width: 100%;
height: auto;
max-height: 570px;
margin-left: 150px;
position: relative;
z-index: 2;
align-self: center;
}
/* RESPONSIVE AREA — hanya aktif di layar kecil */
@media (max-width: 992px) {
.row {
flex-direction: column;
}
.image-text-container {
height: auto;
margin-bottom: 40px;
}
.image-text-container .overlay-text {
font-size: 4rem;
top: 20%;
text-align: center;
}
.image-text-container img {
margin-left: 0;
max-height: 300px;
}
.custom-scrollbar {
height: auto;
max-height: 500px;
}
}
@media (max-width: 576px) {
.image-text-container .overlay-text {
font-size: 2.5rem;
top: 18%;
}
.image-text-container img {
max-height: 200px;
}
.member-img {
width: 70px;
height: 80px;
}
.text-blue-title { font-size: 0.9rem; }
.text-blue-jabatan { font-size: 0.8rem; }
}
@media (max-width: 992px) {
  .col-left {
    display: none !important;
  }
}

`;
export default function Structure() {
  return (
    <div className="container-fluid px-3 px-md-4 bg-blue-light">
      <style>{customStyles}</style>
      <div className="text-center mb-3 mb-md-4">
        <h1 className="text-blue-dark fw-bold fs-3 fs-md-1">
          Struktur Organisasi
        </h1>
        <p className="fw-semibold fs-5 fs-md-3">
          Dinas Komunikasi dan Informatika
        </p>
      </div>

      <div className="row g-4">
        {/* Kolom Kiri */}
        <div className="col col-left d-flex align-items-center justify-content-center">
          <div className="image-text-container">
            <div className="overlay-text">{`Pejabat\nStruktural\nOPD`}</div>
            <img src="/assets/jam.png" alt="Gambar Jam" className="img-fluid" />
          </div>
        </div>

        {/* Kolom Kanan */}
        <div className="col">
          <div className="custom-scrollbar pe-2">
            <div className="pb-4 pt-2 pr-2">
              {anggota.map((item, index) => (
                <div
                  key={index}
                  className={`d-flex align-items-center p-3 mb-3 member-card ${
                    index % 2 === 0 ? "bg-blue-card-light" : "bg-blue-card-alt"
                  }`}
                >
                  <img
                    src={item.img}
                    alt={item.nama}
                    className="member-img me-3"
                  />
                  <div className="flex-grow-1">
                    <p className="text-secondary mb-0 small">Nama:</p>
                    <h2 className="text-blue-title fw-bold mb-1">
                      {item.nama}
                    </h2>
                    <p className="text-secondary mb-0 small">Jabatan:</p>
                    <h3 className="text-blue-jabatan mb-0">{item.jabatan}</h3>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
