import React from "react";

const Berita: React.FC = () => {
  return (
    <>
        <div className="container my-5">
            <div className="row justify-content-center">
                <div className="col-md-8">
                    <h1>Judul Berita</h1>
                    <p className="text-muted">Tanggal: 1 Januari 2024 | Penulis: Admin</p>
                    <img
                        src="/assets/berita-sample.jpg"
                        alt="Gambar Berita"
                        className="img-fluid mb-4"
                        style={{ borderRadius: "10px" }}
                    />
                    <p>
                        Ini adalah isi dari berita. Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                        Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, 
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </p>
                    <p>
                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
                        Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </p>
                </div>
            </div>
        </div>
    </>
  );
};

export default Berita;