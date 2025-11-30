import React from "react";
import "./tugas.css";

const Tugas: React.FC = () => {
  const FungsiList = [
    {
      id: 1,
      Deskripsi:
        "Perumusan kebijakan teknis pelaksanaan urusan di bidang komunikasi dan informatika",
    },
    {
      id: 2,
      Deskripsi:
        "Perumusan kebijakan teknis pelaksanaan urusan di bidang persandian",
    },
    {
      id: 3,
      Deskripsi:
        "Perumusan kebijakan teknis pelaksanaan urusan di bidang statistik",
    },
    {
      id: 4,
      Deskripsi:
        "Pemberian dukungan atas penyelenggaraan urusan pemerintahan daerah di bidang komunikasi dan informatika",
    },
    {
      id: 5,
      Deskripsi:
        "Pemberian dukungan atas penyelenggaraan urusan pemerintahan daerah di bidang persandian",
    },
  ];

  return (
    <div className="tugas-container">
      <h1 className="tugas-title">Tugas</h1>
      <p className="tugas-subtitle">Dinas Kominfo Kota Tangerang</p>

      <div className="tugas-box">
        <p className="tugas-text">
          Menyelenggarakan urusan pemerintahan bidang komunikasi dan
          informatika, urusan pemerintahan bidang statistik dan urusan
          pemerintahan bidang persandian.
        </p>
      </div>

      <h1 className="fungsi-title">Fungsi</h1>
      <p className="fungsi-subtitle">Dinas Kominfo Kota Tangerang</p>

      <div className="fungsi-box">
        <ol>
          {FungsiList.map((item) => (
            <li key={item.id}>{item.Deskripsi}</li>
          ))}
        </ol>
      </div>
    </div>
  );
};

export default Tugas;
