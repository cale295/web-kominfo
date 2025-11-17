import React from "react";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import Navbar from "../components/Navbar";
import HeroSection from "../components/Hero";
import ServiceGrid from "../components/Services";
import TangerangNewsApp from "../components/News";
import Media from "../components/Media";
import HubungiKami from "../components/contact";
import Structure from "../components/Structure";
import Modal from "../components/Modal";
import Footer from "../components/footer";
import Berita from "../sections/berita/Berita";
import AccessibilityPanel from "../components/AccessibilityPanel";

const HomePage: React.FC = () => {
  return (
    <>
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

const AppRouter: React.FC = () => {
  return (
    <BrowserRouter>
      <Navbar />
      <Routes>
        <Route path="/" element={<HomePage />} />
        <Route path="/berita" element={<Berita />} />
        <Route path="*" element={<HomePage />} />
      </Routes>
      <AccessibilityPanel />
    </BrowserRouter>
  );
};

export default AppRouter;
