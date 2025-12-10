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

    if (loading) {
        return <p className="text-center mt-5">Loading...</p>;
    }

    if (error) {
        return <p className="text-center text-danger mt-5">{error}</p>;
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
                            />
                            <div className="pendidikan-pelatihan-info">
                                <h3 className="pendidikan-pelatihan-judul">{item.judul}</h3>
                                <p className="pendidikan-pelatihan-tanggal">
                                    Tanggal: {item.tanggal_agenda}
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
                            </div>
                        </div>
                    ))
                )}
            </div>
        </div>
    )
};
export default PendidikanPelatihan;