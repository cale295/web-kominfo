import React, { useEffect, useState } from 'react';
import './contact.css';
import api from '../../../services/api';

interface ContactItem {
  id_kontak_layanan: string;
  judul: string;
  subjudul: string;
  icon_class: string;
  icon_bg_color: string;
  link_url: string;
  urutan: string;
  status: string;
  created_at: string;
  updated_at: string;
}

interface PetaData {
  id_kontak: string;
  nama_instansi: string;
  alamat_lengkap: string;
  telepon: string;
  fax: string;
  map_link: string;
  status: string;
}



export default function HubungiKami() {
  const [contactItems, setContactItems] = useState<ContactItem[]>([]);
  const [petaData, setPetaData] = useState<PetaData | null>(null);
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<string | null>(null);
  const [loadingPeta, setLoadingPeta] = useState<boolean>(true);

  const fetchContactItems = async () => {
    try {
      setLoading(true);
      setError(null);

      const response = await api.get('/kontak_layanan');
      
      console.log('API Response kontak:', response.data);

      if (response.data.status === 200 && response.data.data && response.data.data.length > 0) {
        const activeItems = response.data.data
          .sort((a: ContactItem, b: ContactItem) => 
            Number(a.urutan) - Number(b.urutan)
          );
        
        console.log('Active items:', activeItems);
        setContactItems(activeItems);
      } else {
        setContactItems([]);
      }
    } catch (err: any) {
      setError('Gagal memuat data kontak layanan.');
      console.error('Error fetching contact items:', err);
    } finally {
      setLoading(false);
    }
  };

  const fetchPetaData = async () => {
    try {
      setLoadingPeta(true);
      
      const response = await api.get('/kontak'); // Endpoint untuk data peta
      
      console.log('API Response peta:', response.data);

      if (response.data.status === 200 && response.data.data) {
        // Jika respons berupa array, ambil item pertama yang aktif
        if (Array.isArray(response.data.data)) {
          const activePeta = response.data.data.find((item: PetaData) => 
            item.status === '1' || item.status.toLowerCase() === 'aktif'
          );
          if (activePeta) {
            setPetaData(activePeta);
          }
        } 
        // Jika respons berupa object langsung
        else if (typeof response.data.data === 'object') {
          const data = response.data.data;
          if (data.status === '1' || data.status.toLowerCase() === 'aktif') {
            setPetaData(data);
          }
        }
      }
    } catch (err: any) {
      console.error('Error fetching peta data:', err);
      // Tidak set error di sini, karena peta hanya sebagai tambahan
    } finally {
      setLoadingPeta(false);
    }
  };

  useEffect(() => {
    fetchContactItems();
    fetchPetaData();
  }, []);

  // Fungsi untuk memformat telepon dan fax
  const formatPhoneNumber = (phone: string) => {
    if (!phone) return '';
    return phone.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
  };


  if (loading) {
    return (
      <div className="contact-container py-12 d-flex justify-content-center align-items-center">
        <div className="text-center">
          <div className="spinner-border text-primary mb-3" role="status">
            <span className="visually-hidden">Memuat...</span>
          </div>
          <p className="text-gray-600">Memuat kontak layanan...</p>
        </div>
      </div>
    );
  }

  if (error) {
    return (
      <div className="contact-container py-12">
        <div className="alert alert-danger text-center" role="alert">
          {error}
          <button 
            className="btn btn-sm btn-outline-danger ms-3"
            onClick={() => {
              fetchContactItems();
              fetchPetaData();
            }}
          >
            Coba Lagi
          </button>
        </div>
      </div>
    );
  }

  if (contactItems.length === 0 && !petaData) {
    return (
      <div className="contact-container py-12 text-center">
        <div className="alert alert-warning" role="alert">
          Tidak ada kontak layanan aktif
        </div>
      </div>
    );
  }

  // Data default jika tidak ada data dari API
  const defaultPetaData = {
    nama_instansi: "Dinas Komunikasi dan Informatika",
    alamat_lengkap: "Jl. Satria, RT.002/RW.001, Sukasari, Kec. Tangerang, Kota Tangerang, Banten, Indonesia 15111",
    telepon: "02155764955",
    fax: "02155764957",
    map_link: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1319.3408819062997!2d106.6401152789647!3d-6.171026352341869!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f8cfe4d01d59%3A0xc9bf83c50c061315!2sDinas%20Komunikasi%20dan%20Informatika%20Kota%20Tangerang!5e1!3m2!1sid!2sid!4v1762144536793!5m2!1sid!2sid"
  };

  // Gunakan data dari API atau data default
  const currentPetaData = petaData || defaultPetaData;

  return (
    <div className="py-12" id='kontak'>
      <div className="container px-4">
        <h1 className="fs-1 fs-md-1 fw-bold text-blue-800 text-center mb-10 mb-md-12">
          Hubungi Kami
        </h1>

        <div className="row g-10 g-md-8">
          {/* Kolom Kiri - Kontak Items */}
          <div className="col-md-6 d-flex flex-column gap-4">
            {contactItems.map((item) => (
              <a
                key={item.id_kontak_layanan}
                href={item.link_url}
                target="_blank"
                rel="noopener noreferrer"
                className="d-flex align-items-center gap-4 p-4 rounded-lg bg-hover-gray-100 text-decoration-none"
              >
                <div 
                  className="p-3 rounded-circle flex-shrink-0 d-flex align-items-center justify-content-center"
                  style={{ 
                    backgroundColor: item.icon_bg_color || '#3b82f6',
                    width: '56px',
                    height: '56px'
                  }}
                >
                  <i className={`${item.icon_class} text-white fa-lg`}></i>
                </div>
                <div className="flex-grow-1">
                  <h3 className="fs-7 fw-bold text-blue-800 a .text-blue-800:hover mb-1">
                    {item.judul}
                  </h3>
                  {item.subjudul && (
                    <p className="text-sm fs-i text-gray-600 mt-0 mb-0">
                      {item.subjudul}
                    </p>
                  )}
                </div>
                <span className="text-gray-400">
                  <i className="fas fa-chevron-right"></i>
                </span>
              </a>
            ))}

            {/* Social Media */}
            <div className="d-flex mx-4 gap-6 pt-6 border-top">
              <p className="fw-semibold text-gray-700 mb-0 align-self-center">Ikuti Kami:</p>
              <a
                href="#"
                target="_blank"
                rel="noopener noreferrer"
                className="text-gray-600 text-red-600-hover transition-colors"
                aria-label="YouTube"
                title="YouTube"
              >
                <i className="fab fa-youtube fa-lg"></i>
              </a>
              <a
                href="#"
                target="_blank"
                rel="noopener noreferrer"
                className="text-gray-600 text-blue-600-hover transition-colors"
                aria-label="Facebook"
                title="Facebook"
              >
                <i className="fab fa-facebook-f fa-lg"></i>
              </a>
              <a
                href="#"
                target="_blank"
                rel="noopener noreferrer"
                className="text-gray-600 text-pink-600-hover transition-colors"
                aria-label="Instagram"
                title="Instagram"
              >
                <i className="fab fa-instagram fa-lg"></i>
              </a>
              <a
                href="#"
                target="_blank"
                rel="noopener noreferrer"
                className="text-gray-600 text-blue-400-hover transition-colors"
                aria-label="Twitter"
                title="Twitter"
              >
                <i className="fab fa-twitter fa-lg"></i>
              </a>
            </div>
          </div>

          {/* Kolom Kanan - Info Alamat & Peta */}
          <div className="col-md-6 d-flex flex-column align-items-start text-start">
            <h2 className="fs-4 fw-bold text-blue-800 mb-2">
              {currentPetaData.nama_instansi}
            </h2>
            <h3 className="fs-4 fw-bold text-blue-800 mb-4">
              Kota Tangerang
            </h3>

            <address className="text-gray-600 mb-6 lh-base fst-normal">
              {(currentPetaData.alamat_lengkap)}
              
            </address>
            <p className="mb-2">
                <i className="fas fa-phone me-2"></i>
                Telp. {formatPhoneNumber(currentPetaData.telepon)}
              </p>
              {currentPetaData.fax && (
                <p className="mb-0">
                  <i className="fas fa-fax me-2"></i>
                  Fax. {formatPhoneNumber(currentPetaData.fax)}
                </p>
              )}

            {/* Peta */}
            <div className="w-100 rounded-xl overflow-hidden shadow-sm" style={{ height: '256px' }}>
              {loadingPeta ? (
                <div className="w-100 h-100 d-flex justify-content-center align-items-center bg-gray-50">
                  <div className="text-center">
                    <div className="spinner-border text-primary mb-2" role="status">
                      <span className="visually-hidden">Memuat peta...</span>
                    </div>
                    <p className="text-gray-600 small">Memuat peta...</p>
                  </div>
                </div>
              ) : (
                <iframe 
                  src={currentPetaData.map_link}
                  width="100%" 
                  height="100%" 
                  style={{ border: 0 }}
                  allowFullScreen
                  loading="lazy"
                  referrerPolicy="no-referrer-when-downgrade"
                  title={`Lokasi ${currentPetaData.nama_instansi}`}
                ></iframe>
              )}
            </div>
            
            {/* Tombol arahkan ke Google Maps */}
            <a
              href={`https://www.google.com/maps/dir/?api=1&destination=${encodeURIComponent(currentPetaData.alamat_lengkap)}`}
              target="_blank"
              rel="noopener noreferrer"
              className="btn btn-primary mt-4 d-flex align-items-center"
            >
              <i className="fas fa-directions me-2"></i>
              Dapatkan Petunjuk Arah
            </a>
          </div>
        </div>
      </div>
    </div>
  );
}