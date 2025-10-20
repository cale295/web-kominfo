import React from "react";

const anggota = [
  {
    img: "/assets/mas.png",
    nama: "Dr. MUGIYA WARDHANY, SE, M.Si",
    jabatan: "Kepala Dinas Komunikasi dan Informatika",
  },
  {
    img: "/assets/mas.png",
    nama: "NURHIDAYATULLAH, S.IP, M.Si",
    jabatan: "Sekretaris Dinas Komunikasi dan Informatika",
  },
  {
    img: "/assets/mas.png",
    nama: "MOHAMAD MUFLIH SUTISNA, SSTP, M.AP",
    jabatan:
      "Kepala Bidang Sarana dan Prasarana TIK dan Persandian Dinas Komunikasi dan Informatika",
  },
  {
    img: "/assets/mas.png",
    nama: "ANTON RIYANTO, ST, MT",
    jabatan:
      "Kepala Bidang Statistik dan Pemberdayaan TIK Dinas Komunikasi dan Informatika",
  },
  {
    img: "/assets/mas.png",
    nama: "RIZKY FEBRIYANTO SUNARYO, S.Kom., M.T.I",
    jabatan:
      "Kepala Bidang Pengembangan eGovernment Dinas Komunikasi dan Informatika",
  },
  {
    img: "/assets/mas.png",
    nama: "IAN CHAVIDZ RIZQIULLAH, S.STP",
    jabatan:
      "Kepala Bidang Diseminasi Informasi dan Komunikasi Publik Dinas Komunikasi dan Informatika",
  },
  {
    img: "/assets/mas.png",
    nama: "MUHAMMAD IQBAL SANTOSO, A.Md.P., S.H",
    jabatan:
      "Kepala UPT Pengelola Ruang Kendali Kota Dinas Komunikasi dan Informatika",
  },
];

export default function Structure() {
  return (
    <div className="px-4 sm:px-8 py-8 bg-blue-50 min-h-screen">
      {/* Judul */}
      <h1 className="text-2xl sm:text-4xl font-bold text-blue-800 text-center mb-2">
        Struktur Organisasi
      </h1>
      <p className="text-lg sm:text-2xl font-semibold text-center mb-8">
        Dinas Komunikasi dan Informatika
      </p>

      {/* Layout utama */}
      <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {/* AREA DESIGN (tempat gambar struktur organisasi) */}
        <div className="flex items-center justify-center bg-white border border-blue-100 rounded-xl p-4 shadow-md min-h-[250px] sm:min-h-[400px]">
          <p className="text-gray-500 italic text-center">
            [Area Design - tempat foto/diagram struktur organisasi nanti]
          </p>
        </div>

        {/* GRID ANGGOTA */}
        <div className="h-[750px] overflow-y-auto scrollbar-thin scrollbar-thumb-blue-400 scrollbar-track-blue-100 rounded-lg">
          <div className="flex flex-col gap-4 pb-4 pt-2 pr-2">
            {anggota.map((item, index) => (
              <div
                key={index}
                className={`flex items-center p-4 transition duration-300 hover:scale-[1.02] ${
                  index % 2 === 0 ? "bg-blue-200" : "bg-blue-50"
                }`}
              >
                <img
                  src={item.img}
                  alt={item.nama}
                  className="w-24 h-26 md:w-32 md:h-36 rounded-lg mr-4 object-cover"
                />
                <div className="flex flex-col">
                  <p className="text-sm font-medium text-gray-700">Nama:</p>
                  <h2 className="text-lg font-bold text-blue-900 leading-tight">
                    {item.nama}
                  </h2>
                  <p className="text-sm font-medium text-gray-700 mt-2">
                    Jabatan:
                  </p>
                  <h3 className="text-md text-blue-700 leading-snug">
                    {item.jabatan}
                  </h3>
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>
    </div>
  );
}
