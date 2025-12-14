import React, { useEffect, useState } from "react";
import './KerjasamaDaerah.css';
import api from "../../../services/api";

interface KerjasamaDaerah {
    id: string;
    tanggal: string;
    perihal: string;
    nomor: string;
    created_at: string;
}

const KerjasamaDaerah: React.FC = () => {
    const [kerjasama, setKerjasama] = useState<KerjasamaDaerah[]>([]);
    const [loading, setLoading] = useState<boolean>(true);
    const [error, setError] = useState<string | null>(null);
    const [currentPage, setCurrentPage] = useState<number>(1);
    const [entriesPerPage, setEntriesPerPage] = useState<number>(10);
    const [searchTerm, setSearchTerm] = useState<string>("");

    const fetchKerjasama = async () => {
        try {
            setLoading(true);
            setError(null);

            const response = await api.get("/ip_kerjasama_daerah");

            if (response.data.status && Array.isArray(response.data.data)) {
                setKerjasama(response.data.data);
            } else {
                setKerjasama([]);
            }
        } catch (err) {
            console.error("Error fetching kerjasama daerah", err);
            setError("Gagal memuat data kerjasama daerah. Silahkan coba lagi.");
            setKerjasama([]);
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchKerjasama();
    }, []);

    // Format tanggal menjadi lebih readable
    const formatDate = (dateString: string) => {
        try {
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            });
        } catch {
            return dateString;
        }
    };

    // Filter data berdasarkan search term
    const filteredData = kerjasama.filter(item =>
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

    if (loading) {
        return (
            <div className="program-container">
                <div className="text-center py-5">
                    <div className="spinner-border text-primary" role="status" />
                    <p className="mt-2">Memuat data Kerjasama Daerah...</p>
                </div>
            </div>
        );
    }

    return (
        <div className="program-container">
            <h2 className="program-title">Kerjasama Daerah</h2>

            {/* Tampilkan error message jika ada */}
            {error && (
                <div className="alert alert-danger mb-3" role="alert">
                    {error}
                    <button 
                        className="btn btn-sm btn-outline-danger ms-3" 
                        onClick={fetchKerjasama}
                    >
                        Coba Lagi
                    </button>
                </div>
            )}

            <div className="table-toolbar">
                <div>
                    Show
                    <select 
                        value={entriesPerPage} 
                        onChange={(e) => {
                            setEntriesPerPage(Number(e.target.value));
                            setCurrentPage(1);
                        }}
                        disabled={kerjasama.length === 0}
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
                        placeholder="Cari kerjasama daerah..." 
                        value={searchTerm}
                        onChange={(e) => {
                            setSearchTerm(e.target.value);
                            setCurrentPage(1);
                        }}
                        disabled={kerjasama.length === 0}
                    />
                </div>
            </div>

            <div className="table-responsive">
                <table className="program-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Perihal</th>
                            <th>Nomor Dokumen</th>
                            <th>Tanggal Dibuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        {currentEntries.length > 0 ? (
                            currentEntries.map((item, index) => (
                                <tr key={item.id} className="category-row">
                                    <td>{indexOfFirstEntry + index + 1}</td>
                                    <td>{formatDate(item.tanggal)}</td>
                                    <td>{item.perihal}</td>
                                    <td>{item.nomor}</td>
                                    <td>{formatDate(item.created_at)}</td>
                                </tr>
                            ))
                        ) : (
                            <tr>
                                <td colSpan={5} className="text-center py-4">
                                    {searchTerm 
                                        ? "Tidak ada data kerjasama daerah yang cocok dengan pencarian" 
                                        : "Tidak ada data kerjasama daerah"
                                    }
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

export default KerjasamaDaerah;