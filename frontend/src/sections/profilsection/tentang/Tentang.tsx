import React, { useEffect, useState } from "react";
import "./Tentang.css";
import api from "../../../services/api";

interface ListData {
  id_tentang: string;
  title: string;
  content: string;
  sorting: string;
  is_active: string;
}

const Tentang: React.FC = () => {
  const [listData, setListData] = useState<ListData[]>([]);
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<string | null>(null);
  const [openItem, setOpenItem] = useState<string | null>(null);

  const fetchTentang = async () => {
    try {
      setLoading(true);
      setError(null);

      const response = await api.get("/profil_tentang");

      if (response.data.status && Array.isArray(response.data.data)) {
        // filter yang aktif + sorting
        const cleanData = response.data.data
          .filter((item: ListData) => item.is_active === "1")
          .sort(
            (a: ListData, b: ListData) =>
              Number(a.sorting) - Number(b.sorting)
          );

        setListData(cleanData);
      } else {
        setListData([]);
      }
    } catch (err) {
      console.error("Error fetching Tentang", err);
      setError("Gagal memuat data Tentang. Silahkan coba lagi.");
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchTentang();
  }, []);

  const toggleAccordion = (id: string) => {
    setOpenItem((prev) => (prev === id ? null : id));
  };

  if (loading) return <p className="text-center mt-5">Loading...</p>;
  if (error) return <p className="text-center text-danger mt-5">{error}</p>;

  return (
    <div id="tentang" className="tentang-container">
      <div className="tentang-header">
        <h1>Tentang</h1>
        <p>Dinas Kominfo Kota Tangerang</p>
      </div>

      <div className="content-wrapper">
        <div className="row">
          <div className="col-lg-6 mb-4">
            <div className="accordion-custom">
              {listData.map((item) => (
                <div key={item.id_tentang} className="accordion-item-custom">
                  <div
                    className={`accordion-header-custom ${
                      openItem === item.id_tentang ? "active" : ""
                    }`}
                    onClick={() => toggleAccordion(item.id_tentang)}
                  >
                    <h3 className="accordion-title">{item.title}</h3>
                  </div>

                  <div
                    className={`accordion-body-custom ${
                      openItem === item.id_tentang ? "open" : ""
                    }`}
                  >
                    <div className="accordion-content">
                      {item.content.split("\n").map((paragraph, index) => (
                        <p key={index}>{paragraph}</p>
                      ))}
                    </div>
                  </div>
                </div>
              ))}

              {listData.length === 0 && (
                <p className="text-center">Data belum tersedia</p>
              )}
            </div>
          </div>

          <div className="col-lg-6">
            <div className="logo-container">
              <img
                src="/assets/logo.png"
                alt="Logo Dinas Kominfo Kota Tangerang"
                className="logo-image"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Tentang;
