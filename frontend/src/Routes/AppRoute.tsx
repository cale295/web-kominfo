import React from "react";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import HeroSection from "../sections/homepage/hero/Hero";
import ServiceGrid from "../sections/homepage/services/Services";
import Agenda from "../sections/homepage/agenda/Agenda";
import Media from "../sections/homepage/media/Media";
import HubungiKami from "../sections/homepage/contact/Contact";
import Structure from "../sections/homepage/structure/Structure";
import Modal from "../sections/homepage/modal/Modal";
import Footer from "../sections/homepage/footer/Footer";
import Berita from "../sections/beritasection/Berita";
import BeritaDetail from "../sections/beritasection/BeritaDetail";
import AccessibilityPanel from "../sections/homepage/AccessibilityPanel";
import Navbar from "../components/navbar/Navbar";
import Tentang from "../sections/profilsection/tentang/Tentang";
import ModalBerita from "../sections/beritasection/ModalBerita";
import Tugas from "../sections/profilsection/tugas/Tugas";
import DaftarPejabat from "../sections/profilsection/daftarpejabat/DaftarPejabat";
import Program from "../sections/programsection/Program";
import ModalProfil from "../sections/profilsection/modalprofil/ModalProfil";
import Gallery from "../sections/gallerysection/Gallery";
import Perencanaan from "../sections/informasipubliksection/perencanaan/Perencanaan";
import Keuangan from "../sections/informasipubliksection/laporankeuangan/LaporanKeuangan";
import Kinerja from "../sections/informasipubliksection/laporankinerja/LaporanKinerja";
import SBU from "../sections/profilsection/sbu/SBU";
import BannerPopupComponent from "../components/bannerpopup/BannerPopup";
import DaftarInformasiPublik from "../sections/informasipubliksection/daftarinformasipublik/Daftar_Informasi_publik";
import PermohonanInformasi from "../sections/informasipubliksection/permohonaninformasi/PermohonanInformasi";
import PengadaanBarangJasa from "../sections/informasipubliksection/pengadaanbarangjasa/PengadaanBarangJasa";

const HomePage: React.FC = () => {
  return (
    <>
      <HeroSection />
      <ServiceGrid />
      <Agenda />
      <Structure />
      <Media />
      <HubungiKami />
      <Modal />
    </>
  );
};

const BeritaPage: React.FC = () => {
  return (
    <>
      <ModalBerita/>
      <Berita />
    </>
  );
};

const BeritaDetailPage: React.FC = () => {
  return (
    <>
      <BeritaDetail />
    </>
  );
};

const ProfilePage: React.FC = () => {
  return(
    <div style={{ backgroundColor: "#EDEDED" }}>
      <ModalProfil />
      <Tentang />
      <Tugas />
      <DaftarPejabat />
      <SBU />
    </div>
  )
}

const ProgramPage: React.FC = () => {
  return(
    <>
      <Program />
    </>
  )
}

const GalleryPage: React.FC = () => {
  return(
    <>
      <Gallery />
    </>
  )
}

const AppRouter: React.FC = () => {
  return (
    <BrowserRouter>
      <Navbar />

      <BannerPopupComponent />
      <Routes>
        <Route path="/" element={<HomePage />} />
        <Route path="/berita" element={<BeritaPage />} />
        <Route path="/berita/:id" element={<BeritaDetailPage />} />
        <Route path="/berita/tag/:slug" element={<BeritaPage />} />
        <Route path="*" element={<HomePage />} />
        <Route path="/profile" element={<ProfilePage />} />
        <Route path="/program" element={<ProgramPage />} />
        <Route path="/gallery" element={<GalleryPage />} />
        <Route path="/perencanaan" element={<Perencanaan />} />
        <Route path="/pengadaan_barang_jasa" element={<PengadaanBarangJasa />} />
        <Route path="/laporan_keuangan" element={<Keuangan />} />
        <Route path="/laporan_kinerja" element={<Kinerja />} />
        <Route path="/daftar_informasi_publik" element={<DaftarInformasiPublik />} />
        <Route path="/permohonan_informasi" element={<PermohonanInformasi />} />
      </Routes>
      <Footer />
      <AccessibilityPanel />
    </BrowserRouter>
  );
};

export default AppRouter;