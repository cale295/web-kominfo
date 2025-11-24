import React from "react";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import Navbar from "../sections/homepage/navbar/Navbar";
import HeroSection from "../sections/homepage/hero/Hero";
import ServiceGrid from "../sections/homepage/services/Services";
import Agenda from "../sections/homepage/agenda/Agenda";
import Media from "../sections/homepage/media/Media";
import HubungiKami from "../sections/homepage/contact/Contact";
import Structure from "../sections/homepage/structure/Structure";
import Modal from "../sections/homepage/modal/Modal";
import Footer from "../sections/homepage/footer/Footer";
import BeritaNavbar from "../sections/berita/Navbar";
import Berita from "../sections/berita/Berita";
import AccessibilityPanel from "../sections/homepage/AccessibilityPanel";

const HomePage: React.FC = () => {
  return (
    <>
      <Navbar />
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
    <BeritaNavbar />
    <Berita />
  </>
  )
}

const AppRouter: React.FC = () => {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<HomePage />} />
        <Route path="/berita" element={<BeritaPage />} />
        <Route path="*" element={<HomePage />} />
      </Routes>
      <AccessibilityPanel />
    </BrowserRouter>
  );
};

export default AppRouter;
