import React from "react";
import "../css/Footer.css";

const Footer: React.FC = () => {
    const kanal = [
        { id: 1, icon: "", nama: "@kominfotangerangkota", link: "https://www.instagram.com/kominfotangerangkota/" },
        { id: 2, icon: "", nama: "@Tangerang LIVE Room", link: "https://live.tangerangkota.go.id/" },
        { id: 3, icon: "", nama: "@PPID Kota Tangerang", link: "https://ppid.tangerangkota.go.id/" },
        { id: 4, icon: "", nama: "@Tangerang Smart City", link: "https://smartcity.tangerangkota.go.id/" },
        { id: 5, icon: "", nama: "@Tangerang Satu Data", link: "https://data.tangerangkota.go.id/" },
        { id: 6, icon: "", nama: "@SP4N-LAPOR! Kota Tangerang", link: "https://lapor.go.id/" },
    ];
    const visitorCount = 123456; 
    return (
        <footer className="bg-gradient-to-r-blue-800-950 py-4 rounded-bottom-6 rounded-bottom-sm-4 rounded-bottom-md-4 rounded-bottom-lg-4 rounded-bottom-xl-4 rounded-bottom-xxl-4">
            <div className="container row footer-wrapper">
                <div className="col justify-content-center">
                    <div className="p-text">
                        Powered by
                    </div>
                    <div className="h-text">
                        tangerangkota.go.id
                    </div>
                    <p className="p-text">
                        Situs Resmi Pemerintah Kota Tangerang
                    </p>
                    <p className="p-text">
                        Jl. Satria Sudirman No.1, Sukarasa, Kec. Tangerang, Kota Tangerang, Banten 15117<br />
                        redaksi@tangerangkota.id
                    </p>
                    <img src="./assets/indo.png" alt="" width={50} />
                </div>
                <div className="col justify-content-center ">
                    <div className="h-text">
                        Kanal Informasi Resmi Lainnya
                    </div>
                    <div className="kanal-wrapper">
                        {kanal.map((k) => (
                            <a key={k.id} href={k.link} target="_blank" rel="noopener noreferrer" className="kanal-link">
                                {k.nama}
                            </a>
                        ))}
                    </div>
                </div>
                <div className="col justify-content-center ">
                    <div className="h-text">
                        Pengunjung
                    </div>
                    <div className="visitor-counter mt-3 p-text">
                        Pengunjung hari ini : {visitorCount.toLocaleString()} <br />
                        Pengunjung online : 5 <br />
                        Total pengunjung : {visitorCount.toLocaleString()}
                    </div>
                </div>
                <div className="row footer-bottom mt-4">
                    <p className="p-text mt-5">
                        © Copyright 2025 - Pemerintah Kota Tangerang
                    </p>
                </div>
            </div>
        </footer>
    );
};

export default Footer;