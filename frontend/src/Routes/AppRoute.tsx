import React from "react";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import Navbar from "../sections/homepage/Navbar";
import HeroSection from "../sections/homepage/Hero";
import ServiceGrid from "../sections/homepage/Services";
import TangerangNewsApp from "../sections/homepage//News";
import Media from "../sections/homepage/Media";
import HubungiKami from "../sections/homepage/contact";
import Structure from "../sections/homepage/Structure";
import Modal from "../sections/homepage/Modal";
import Footer from "../sections/homepage/footer";
import BeritaNavbar from "../sections/berita/Navbar";
import Berita from "../sections/berita/Berita";
import AccessibilityPanel from "../sections/homepage/AccessibilityPanel";

const HomePage: React.FC = () => {
  return (
    <>
      <Navbar />
      <HeroSection />
      <ServiceGrid />
      <TangerangNewsApp />
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
