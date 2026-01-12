import React, { useState, useEffect } from "react";
import "./tugas.css";
import api from "../../../services/api";
import DOMPurify from "dompurify";

interface ListData {
  id_tugas: string;
  type: string;
  description: string;
  is_active: string;
}

const Tugas: React.FC = () => {
  const [tugasData, setTugasData] = useState<ListData[]>([]);
  const [fungsiData, setFungsiData] = useState<ListData[]>([]);
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    const fetchData = async () => {
      try {
        setLoading(true);

        const response = await api.get("/tugasfungsi");

        const rawData: ListData[] = Array.isArray(response.data)
          ? response.data
          : Array.isArray(response.data?.data)
          ? response.data.data
          : [];

        if (rawData.length === 0) {
          throw new Error("Data kosong atau format salah");
        }

        const tugas = rawData.filter(
          (item) =>
            item.type?.toLowerCase().trim() === "tugas" &&
            item.is_active === "1"
        );

        const fungsi = rawData.filter(
          (item) =>
            item.type?.toLowerCase().trim() === "fungsi" &&
            item.is_active === "1"
        );

        setTugasData(tugas);
        setFungsiData(fungsi);
        setError(null);
      } catch (err) {
        setError("Gagal memuat data. Silakan coba lagi.");
      } finally {
        setLoading(false);
      }
    };

    fetchData();
  }, []);

  if (loading) {
    return (
      <div className="tugas-container">
        <p>Memuat data...</p>
      </div>
    );
  }

  if (error) {
    return (
      <div className="tugas-container">
        <p className="error-message">{error}</p>
      </div>
    );
  }

  return (
    <div className="tugas-container">
      <h1 className="tugas-title">Tugas</h1>
      <p className="tugas-subtitle">Dinas Kominfo Kota Tangerang</p>

      <div className="tugas-box">
        {tugasData.length > 0 ? (
          tugasData.map((item) => (
            <div
              key={item.id_tugas}
              className="tugas-text"
              dangerouslySetInnerHTML={{
                __html: DOMPurify.sanitize(item.description),
              }}
            />
          ))
        ) : (
          <p className="tugas-text">
            Menyelenggarakan urusan pemerintahan bidang komunikasi dan
            informatika, statistik, dan persandian.
          </p>
        )}
      </div>

      <h1 className="fungsi-title">Fungsi</h1>
      <p className="fungsi-subtitle">Dinas Kominfo Kota Tangerang</p>

      <div className="fungsi-box">
        {fungsiData.length > 0 ? (
          fungsiData.map((item) => (
            <div
              key={item.id_tugas}
              className="fungsi-html"
              dangerouslySetInnerHTML={{
                __html: DOMPurify.sanitize(item.description),
              }}
            />
          ))
        ) : (
          <ol>
            <li>
              Perumusan kebijakan teknis bidang komunikasi dan informatika
            </li>
            <li>Perumusan kebijakan teknis bidang persandian</li>
            <li>Perumusan kebijakan teknis bidang statistik</li>
            <li>Dukungan penyelenggaraan urusan komunikasi dan informatika</li>
            <li>Dukungan penyelenggaraan urusan persandian</li>
          </ol>
        )}
      </div>
    </div>
  );
};

export default Tugas;
