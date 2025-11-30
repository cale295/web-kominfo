import React, { useState } from 'react';
import './Tentang.css';

interface AccordionItem {
  id: string;
  title: string;
  content: string;
}

const Tentang: React.FC = () => {
  const [openItem, setOpenItem] = useState<string>('profil');

  const accordionData: AccordionItem[] = [
    {
      id: 'profil',
      title: 'Profil',
      content: `Dinas Komunikasi dan Informatika Kota Tangerang terbentuk berdasarkan Peraturan Daerah Nomor 9 Tahun 2019 Tentang Perubahan atas Peraturan Daerah Nomor 8 Tahun 2016 tentang Pembentukan dan Susunan Perangkat Daerah. Dalam regulasi tersebut Dinas Komunikasi dan Informatika Kota Tangerang termasuk dalam klasifikasi Dinas tipe A. Dalam melaksanakan tugasnya, Dinas Komunikasi dan Informatika Kota Tangerang menyelenggarakan fungsi dan wewenang yaitu pengelolaan informasi dan komunikasi publik Pemerintah daerah, pengelolaan e-Government di lingkup Pemerintah Kota Tangerang, penyelenggaraan statistik sektoral di lingkup Pemerintah Kota Tangerang, dan pelaksanaan tugas yang diberikan oleh walikota terkait dengan tugas dan fungsinya. Pegawai Dinas Komunikasi dan Informatika Kota Tangerang per Januari 2020 berjumlah 50 orang Pegawai Negeri Sipil (PNS).`
    },
    {
      id: 'ruang-lingkup',
      title: 'Ruang Lingkup Kegiatan',
      content: 'Konten untuk Ruang Lingkup Kegiatan akan ditampilkan di sini.'
    },
    {
      id: 'susunan-organisasi',
      title: 'Susunan Organisasi',
      content: 'Konten untuk Susunan Organisasi akan ditampilkan di sini.'
    },
    {
      id: 'visi-misi',
      title: 'Visi dan Misi',
      content: 'Konten untuk Visi dan Misi akan ditampilkan di sini.'
    }
  ];

  const toggleAccordion = (id: string) => {
    setOpenItem(openItem === id ? '' : id);
  };

  return (
    <div className="tentang-container">
      <div className="tentang-header">
        <h1>Tentang</h1>
        <p>Dinas Kominfo Kota Tangerang</p>
      </div>

      <div className="content-wrapper">
        <div className="row">
          <div className="col-lg-6 mb-4">
            <div className="accordion-custom">
              {accordionData.map((item) => (
                <div key={item.id} className="accordion-item-custom">
                  <div
                    className={`accordion-header-custom ${openItem === item.id ? 'active' : ''}`}
                    onClick={() => toggleAccordion(item.id)}
                  >
                    <h3 className="accordion-title">{item.title}</h3>
                  </div>
                  <div className={`accordion-body-custom ${openItem === item.id ? 'open' : ''}`}>
                    <div className="accordion-content">
                      {item.content.split('\n').map((paragraph, index) => (
                        <p key={index}>{paragraph}</p>
                      ))}
                    </div>
                  </div>
                </div>
              ))}
            </div>
          </div>

          <div className="col-lg-6">
            <div className="logo-container">
              <img 
                src="./assets/logo.png" 
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