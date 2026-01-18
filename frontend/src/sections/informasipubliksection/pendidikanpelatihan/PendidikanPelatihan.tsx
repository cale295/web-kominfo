import React from "react";
import api from "../../../services/api";
import "./PendidikanPelatihan.css";

interface PendidikanPelatihanData {
    id: string;
    judul: string;
    tanggal_agenda: string;
    waktu: string;
    tempat: string;
    deskripsi: string;
    thumbnail: string;
    thumbnail_path: string;
    status: string;
    tanggal_publish: string;
}

const PendidikanPelatihan: React.FC = () => {
    const [data, setData] = React.useState<PendidikanPelatihanData[]>([]);
    const [loading, setLoading] = React.useState<boolean>(true);
    const [error, setError] = React.useState<string | null>(null);

    React.useEffect(() => {
        const fetchData = async () => {
            try {
                setLoading(true);
                setError(null);

                const response = await api.get("/agenda_pelatihan");

                if (response.data.status && Array.isArray(response.data.data)) {
                    setData(response.data.data);
                } else {
                    setData([]);
                }
            } catch (err) {
                console.error("Error fetching Pendidikan Pelatihan", err);
                setError("Gagal memuat data Pendidikan dan Pelatihan. Silahkan coba lagi.");
            } finally {
                setLoading(false);
            }
        };

        fetchData();
    }, []);

    // Format tanggal menjadi lebih mudah dibaca
    const formatDate = (dateString: string) => {
        const options: Intl.DateTimeFormatOptions = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        };
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', options);
    };

    // Tambahkan fungsi untuk menentukan kelas status
    const getStatusClass = (status: string) => {
        switch(status.toLowerCase()) {
            case 'aktif': return 'aktif';
            case 'selesai': return 'selesai';
            case 'mendatang': return 'mendatang';
            default: return '';
        }
    };

    // Tampilkan loading skeleton
    if (loading) {
        return (
            <div className="pendidikan-pelatihan-container">
                <h2 className="section-title">Pendidikan dan Pelatihan</h2>
                <div className="pendidikan-pelatihan-loading">
                    {[...Array(3)].map((_, index) => (
                        <div key={index} className="loading-card">
                            <div className="loading-thumbnail"></div>
                            <div className="loading-content">
                                <div className="loading-title"></div>
                                <div className="loading-meta"></div>
                                <div className="loading-meta" style={{width: '70%'}}></div>
                                <div className="loading-description"></div>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        );
    }

    if (error) {
        return (
            <div className="pendidikan-pelatihan-container">
                <h2 className="section-title">Pendidikan dan Pelatihan</h2>
                <p className="text-center text-danger mt-5">{error}</p>
            </div>
        );
    }

    return (
        <div className="pendidikan-pelatihan-container">
            <h2 className="section-title">Pendidikan dan Pelatihan</h2>
            <div className="pendidikan-pelatihan-list">
                {data.length === 0 ? (
                    <p className="text-center">Tidak ada data Pendidikan dan Pelatihan.</p>
                ) : (
                    data.map((item) => (
                        <div key={item.id} className="pendidikan-pelatihan-item">
                            <img
                                src={`${item.thumbnail_path}/${item.thumbnail}`}
                                alt={item.judul}
                                className="pendidikan-pelatihan-thumbnail"
                                onError={(e) => {
                                    // Fallback image jika thumbnail gagal dimuat
                                    e.currentTarget.src = 'https://via.placeholder.com/400x220/3498db/ffffff?text=Pelatihan';
                                }}
                            />
                            <div className="pendidikan-pelatihan-info">
                                <h3 className="pendidikan-pelatihan-judul">{item.judul}</h3>
                                <p className="pendidikan-pelatihan-tanggal">
                                    Tanggal: {formatDate(item.tanggal_agenda)}
                                </p>
                                <p className="pendidikan-pelatihan-waktu">
                                    Waktu: {item.waktu}
                                </p>
                                <p className="pendidikan-pelatihan-tempat">
                                    Tempat: {item.tempat}
                                </p>
                                <p className="pendidikan-pelatihan-deskripsi">
                                    {item.deskripsi}
                                </p>
                                {item.status && (
                                    <span className={`pendidikan-pelatihan-status ${getStatusClass(item.status)}`}>
                                        {item.status}
                                    </span>
                                )}
                            </div>
                        </div>
                    ))
                )}
            </div>
        </div>
    )
};

export default PendidikanPelatihan;