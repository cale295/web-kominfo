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
      <Footer />
    </>
  );
};

const BeritaPage: React.FC = () => {
  return (
    <>
      <ModalBerita/>
      <Berita />
      <Footer />
    </>
  );
};

const BeritaDetailPage: React.FC = () => {
  return (
    <>
      <BeritaDetail />
      <Footer />
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

const AppRouter: React.FC = () => {
  return (
    <BrowserRouter>
      <Navbar />
      <Routes>
        <Route path="/" element={<HomePage />} />
        <Route path="/berita" element={<BeritaPage />} />
        <Route path="/berita/:id" element={<BeritaDetailPage />} />
        <Route path="/berita/tag/:slug" element={<BeritaPage />} />
        <Route path="*" element={<HomePage />} />
        <Route path="/profile" element={<ProfilePage />} />
        <Route path="/program" element={<ProgramPage />} />
      </Routes>
      <AccessibilityPanel />
    </BrowserRouter>
  );
};

export default AppRouter;