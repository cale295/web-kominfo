import React from "react";
import "./daftarPejabat.css";

const DaftarPejabat: React.FC = () => {
  return (
    <div className="pejabat-container">
      <h1 className="pejabat-title">Daftar Pejabat Struktural</h1>
      <p className="pejabat-subtitle">
        Dinas Komunikasi dan Informatika
      </p>
        <img
          src="./assets/daftarstruktural.png"
          alt="Daftar Pejabat Struktural"
          className="pejabat-image"
        />
    </div>
  );
};

export default DaftarPejabat;
