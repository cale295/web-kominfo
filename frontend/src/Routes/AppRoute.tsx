import React from "react";
import { BrowserRouter, Routes, Route } from "react-router-dom";

// ... Import yang sudah ada ...
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
import GalleryDetail from "../sections/gallerysection/GalleryDetail";
import Perencanaan from "../sections/informasipubliksection/perencanaan/Perencanaan";
import SBU from "../sections/profilsection/sbu/SBU";
import BannerPopupComponent from "../components/bannerpopup/BannerPopup";
import DaftarInformasiPublik from "../sections/informasipubliksection/daftarinformasipublik/Daftar_Informasi_publik";
import PermohonanInformasi from "../sections/informasipubliksection/permohonaninformasi/PermohonanInformasi";
import PengadaanBarangJasa from "../sections/informasipubliksection/pengadaanbarangjasa/PengadaanBarangJasa";
import AjukanPermohonan from "../sections/ppidsection/ajukanpermohonan/AjukanPermohonan";
import CheckStatus from "../sections/ppidsection/lacakpermohonan/LacakPermohonan";
import PendidikanPelatihan from "../sections/informasipubliksection/pendidikanpelatihan/PendidikanPelatihan";
import KerjasamaDaerah from "../sections/informasipubliksection/kerjasamadaerah/KerjasamaDaerah";
import DokumenPublik from "../sections/informasipubliksection/informasipublik/DokumenPublik";

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

const GalleryDetailPage: React.FC = () => {
  return(
    <>
      <GalleryDetail />
    </>
  )
}

const CekStatusPage: React.FC = () => {
  return (
    <div style={{ 
      backgroundColor: "#f8f9fa", 
      paddingTop: "40px", 
      paddingBottom: "60px", 
      minHeight: "60vh" 
    }}>
      <CheckStatus />
    </div>
  )
}

const DokumenPublikPage: React.FC = () => {
  return (
    <div style={{ backgroundColor: "#f8f9fa", minHeight: "80vh" }}>
      <DokumenPublik />
    </div>
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
        <Route path="/gallery/:id" element={<GalleryDetailPage />} />
        <Route path="/informasi_perencanaan" element={<Perencanaan />} />
        <Route path="/pengadaan_barang_jasa" element={<PengadaanBarangJasa />} />
        <Route path="/daftar_informasi_publik" element={<DaftarInformasiPublik />} />
        <Route path="/agenda_pelatihan" element={<PendidikanPelatihan />} />
        <Route path="/kerjasama_daerah" element={<KerjasamaDaerah />} />
        <Route path="/permohonan_informasi" element={<PermohonanInformasi />} />
        <Route path="/ajukan_permohonan" element={<AjukanPermohonan />} />
        <Route path="/informasi-publik" element={<DokumenPublikPage />} />
        <Route path="/informasi-publik/:slug" element={<DokumenPublikPage />} />
        <Route path="/cek_status_permohonan" element={<CekStatusPage />} />
      </Routes>
      <Footer />
      <AccessibilityPanel />
    </BrowserRouter>
  );
};

export default AppRouter;