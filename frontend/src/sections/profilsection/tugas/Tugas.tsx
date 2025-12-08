import React, { useState, useEffect } from "react";
import "./tugas.css";
import api from "../../../services/api";

interface ListData {
  id_tugas: string;
  type: string;
  description: string;
  order_number: string;
  is_active: string;
}

const Tugas: React.FC = () => {
  const [tugasData, setTugasData] = useState<ListData[]>([]);
  const [fungsiData, setFungsiData] = useState<ListData[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
  const fetchData = async () => {
    try {
      setLoading(true);

      const response = await api.get("/tugasfungsi");
      console.log("API response:", response.data);

      const rawData = Array.isArray(response.data)
        ? response.data
        : response.data.data;

      const tugas = rawData
        .filter(
          (item: ListData) =>
            item.type?.toLowerCase().trim() === "tugas" &&
            item.is_active == "1"
        )
        .sort(
          (a: ListData, b: ListData) =>
            parseInt(a.order_number) - parseInt(b.order_number)
        );

      const fungsi = rawData
        .filter(
          (item: ListData) =>
            item.type?.toLowerCase().trim() === "fungsi" &&
            item.is_active == "1"
        )
        .sort(
          (a: ListData, b: ListData) =>
            parseInt(a.order_number) - parseInt(b.order_number)
        );

      console.log("Tugas:", tugas);
      console.log("Fungsi:", fungsi);

      setTugasData(tugas);
      setFungsiData(fungsi);
      setError(null);
    } catch (err) {
      console.error("Error fetching data:", err);
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
            <p key={item.id_tugas} className="tugas-text">
              {item.description}
            </p>
          ))
        ) : (
          <p className="tugas-text">
            Menyelenggarakan urusan pemerintahan bidang komunikasi dan
            informatika, urusan pemerintahan bidang statistik dan urusan
            pemerintahan bidang persandian.
          </p>
        )}
      </div>

      <h1 className="fungsi-title">Fungsi</h1>
      <p className="fungsi-subtitle">Dinas Kominfo Kota Tangerang</p>
      <div className="fungsi-box">
        <ol>
          {fungsiData.length > 0 ? (
            fungsiData.map((item) => (
              <li key={item.id_tugas}>{item.description}</li>
            ))
          ) : (
            <>
              <li>
                Perumusan kebijakan teknis pelaksanaan urusan di bidang komunikasi dan informatika
              </li>
              <li>
                Perumusan kebijakan teknis pelaksanaan urusan di bidang persandian
              </li>
              <li>
                Perumusan kebijakan teknis pelaksanaan urusan di bidang statistik
              </li>
              <li>
                Pemberian dukungan atas penyelenggaraan urusan pemerintahan daerah di bidang komunikasi dan informatika
              </li>
              <li>
                Pemberian dukungan atas penyelenggaraan urusan pemerintahan daerah di bidang persandian
              </li>
            </>
          )}
        </ol>
      </div>
    </div>
  );
};

export default Tugas;