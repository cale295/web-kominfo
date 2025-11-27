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
import BeritaNavbar from "../sections/beritasection/Navbar";
import Berita from "../sections/beritasection/Berita";
import BeritaDetail from "../sections/beritasection/BeritaDetail";
import AccessibilityPanel from "../sections/homepage/AccessibilityPanel";
import Navbar from "../components/navbar/Navbar";

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

const AppRouter: React.FC = () => {
  return (
    <BrowserRouter>

      <Navbar />
      <Routes>
        <Route path="/" element={<HomePage />} />
        <Route path="/berita" element={<BeritaPage />} />
        <Route path="/berita/:id" element={<BeritaDetailPage />} />
        <Route path="*" element={<HomePage />} />
      </Routes>
      <AccessibilityPanel />
    </BrowserRouter>
  );
};

export default AppRouter;