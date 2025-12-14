import React, { useEffect, useState } from "react";
import api from "../../../services/api";
import './PengadaanBarangJasa.css';

interface Penyedia {
    id: string;
    id_rup: string;
    nama_paket: string;
    jenis_pengadaan: string;
    metode_pengadaan: string;
    jumlah_pagu: string;
}

interface Swakelola {
    id: string;
    id_rup: string;
    nama_paket: string;
    jumlah_pagu: string;
}

type TabType = 'penyedia' | 'swakelola';

const PengadaanBarangJasa: React.FC = () => {
  const [activeTab, setActiveTab] = useState<TabType>('penyedia');
  const [penyedia, setPenyedia] = useState<Penyedia[]>([]);
  const [swakelola, setSwakelola] = useState<Swakelola[]>([]);
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<string | null>(null);
  const [currentPage, setCurrentPage] = useState<number>(1);
  const [entriesPerPage, setEntriesPerPage] = useState<number>(10);
  const [searchTerm, setSearchTerm] = useState<string>("");

  const fetchData = async (type: TabType) => {
    try {
      setLoading(true);
      setError(null);

      const endpoint = type === 'penyedia' ? "/ip_penyedia" : "/ip_swakelola";
      const response = await api.get(endpoint);

      if (response.data.status && Array.isArray(response.data.data)) {
        if (type === 'penyedia') {
          setPenyedia(response.data.data);
        } else {
          setSwakelola(response.data.data);
        }
      } else {
        if (type === 'penyedia') {
          setPenyedia([]);
        } else {
          setSwakelola([]);
        }
      }
    } catch (err) {
      console.error(`Error fetching ${type === 'penyedia' ? 'Penyedia' : 'Swakelola'}`, err);
      setError(`Gagal memuat data ${type === 'penyedia' ? 'Penyedia' : 'Swakelola'}. Silahkan coba lagi.`);
      // Pastikan array kosong saat error
      if (type === 'penyedia') {
        setPenyedia([]);
      } else {
        setSwakelola([]);
      }
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchData(activeTab);
  }, [activeTab]);

  // Get current data based on active tab
  const getCurrentData = () => {
    return activeTab === 'penyedia' ? penyedia : swakelola;
  };

  // Filter data berdasarkan search term
  const filteredData = getCurrentData().filter(item =>
    Object.values(item).some(value =>
      value?.toString().toLowerCase().includes(searchTerm.toLowerCase())
    )
  );

  // Pagination logic
  const indexOfLastEntry = currentPage * entriesPerPage;
  const indexOfFirstEntry = indexOfLastEntry - entriesPerPage;
  const currentEntries = filteredData.slice(indexOfFirstEntry, indexOfLastEntry);
  const totalPages = Math.ceil(filteredData.length / entriesPerPage);

  const handlePageChange = (pageNumber: number) => {
    setCurrentPage(pageNumber);
  };

  const handleTabChange = (tab: TabType) => {
    setActiveTab(tab);
    setCurrentPage(1);
    setSearchTerm("");
  };

  const formatCurrency = (amount: string) => {
    try {
      const number = parseFloat(amount);
      if (isNaN(number)) return amount;
      
      return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
      }).format(number);
    } catch {
      return amount;
    }
  };

  if (loading) {
    return (
      <div className="program-container">
        <div className="text-center py-5">
          <div className="spinner-border text-primary" role="status" />
          <p className="mt-2">Memuat data Pengadaan Barang & Jasa...</p>
        </div>
      </div>
    );
  }

  return (
    <div className="program-container">
      <h2 className="program-title">Pengadaan Barang & Jasa</h2>
      
      {/* Tampilkan error message jika ada */}
      {error && (
        <div className="alert alert-danger mb-3" role="alert">
          {error}
          <button 
            className="btn btn-sm btn-outline-danger ms-3" 
            onClick={() => fetchData(activeTab)}
          >
            Coba Lagi
          </button>
        </div>
      )}
      
      {/* Tab Navigation */}
      <div className="tab-navigation mb-4">
        <button 
          className={`tab-button ${activeTab === 'penyedia' ? 'active' : ''}`}
          onClick={() => handleTabChange('penyedia')}
        >
          Penyedia
        </button>
        <button 
          className={`tab-button ${activeTab === 'swakelola' ? 'active' : ''}`}
          onClick={() => handleTabChange('swakelola')}
        >
          Swakelola
        </button>
      </div>

      <div className="table-toolbar">
        <div>
          Show
          <select 
            value={entriesPerPage} 
            onChange={(e) => {
              setEntriesPerPage(Number(e.target.value));
              setCurrentPage(1);
            }}
            disabled={getCurrentData().length === 0}
          >
            <option value={10}>10</option>
            <option value={25}>25</option>
            <option value={50}>50</option>
          </select>
          entries
        </div>

        <div className="search-box">
          Search: 
          <input 
            type="text" 
            placeholder="Cari..." 
            value={searchTerm}
            onChange={(e) => {
              setSearchTerm(e.target.value);
              setCurrentPage(1);
            }}
            disabled={getCurrentData().length === 0}
          />
        </div>
      </div>

      <div className="table-responsive">
        <table className="program-table">
          <thead>
            <tr>
              <th>No</th>
              <th>ID RUP</th>
              <th>Nama Paket</th>
              {activeTab === 'penyedia' && (
                <>
                  <th>Jenis Pengadaan</th>
                  <th>Metode Pengadaan</th>
                </>
              )}
              <th>Jumlah Pagu (Rupiah)</th>
            </tr>
          </thead>
          <tbody>
            {currentEntries.length > 0 ? (
              currentEntries.map((item, index) => (
                <tr key={item.id} className="category-row">
                  <td>{indexOfFirstEntry + index + 1}</td>
                  <td>{item.id_rup}</td>
                  <td>{item.nama_paket}</td>
                  {activeTab === 'penyedia' && (
                    <>
                      <td>{(item as Penyedia).jenis_pengadaan}</td>
                      <td>{(item as Penyedia).metode_pengadaan}</td>
                    </>
                  )}
                  <td>{formatCurrency(item.jumlah_pagu)}</td>
                </tr>
              ))
            ) : (
              <tr>
                <td colSpan={activeTab === 'penyedia' ? 6 : 4} className="text-center py-4">
                  {searchTerm ? "Tidak ada data yang cocok dengan pencarian" : "Tidak ada data"}
                </td>
              </tr>
            )}
          </tbody>
        </table>
      </div>

      <div className="table-footer">
        <div>
          Showing {filteredData.length > 0 ? indexOfFirstEntry + 1 : 0} to{" "}
          {Math.min(indexOfLastEntry, filteredData.length)} of{" "}
          {filteredData.length} entries
          {searchTerm && filteredData.length === 0 && " (setelah filter)"}
        </div>

        {totalPages > 1 && (
          <ul className="pagination">
            <li>
              <button 
                onClick={() => handlePageChange(currentPage - 1)}
                disabled={currentPage === 1}
              >
                Previous
              </button>
            </li>
            
            {[...Array(totalPages)].map((_, index) => (
              <li key={index} className={currentPage === index + 1 ? "active" : ""}>
                <button onClick={() => handlePageChange(index + 1)}>
                  {index + 1}
                </button>
              </li>
            ))}
            
            <li>
              <button 
                onClick={() => handlePageChange(currentPage + 1)}
                disabled={currentPage === totalPages}
              >
                Next
              </button>
            </li>
          </ul>
        )}
      </div>
    </div>
  );
};

export default PengadaanBarangJasa;