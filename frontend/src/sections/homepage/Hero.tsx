import React from "react";
import "./css/hero.css";
import { Search, Accessibility } from "lucide-react";

const HeroSection: React.FC = () => {
  return (
    <div className="hero-container">
      {/* Header Bar */}
      <header className="hero-header d-flex justify-content-between align-items-center px-1 py-3">
        <button
          className="btn-disabilitas d-flex align-items-center gap-2"
          onClick={() =>
            window.dispatchEvent(new Event("toggleAccessibilityPanel"))
          }
        >
          <Accessibility className="icon-accessibility" />
          <span className="disabilitas">DISABILITAS</span>
        </button>

        <div className="search-wrapper d-flex align-items-center">
          <div className="search-input-wrapper">
            <input
              type="text"
              placeholder="Apa yang kamu cari"
              className="search-input"
            />
          </div>
          <button className="btn-search">
            <Search className="icon-search" />
          </button>
        </div>
      </header>

      {/* Hero Section */}
      <section className="hero-content d-flex flex-column flex-md-row align-items-center">
        <div className="hero-text p-4 p-md-5 p-lg-6">
          <h1 className="hero-title mb-3">
            Mau ikut pelatihan kerja? Ikut Cakap Kerja, Yuk!
          </h1>
          <p className="hero-subtitle">
            Tangerang Cakap kerja adalah Lorem ipsum dolor sit amet, consectetur
            adipiscing elit. Ut posuere vitae felis quis pretium. Maecenas
            ultricies rutrum mattis.
          </p>
        </div>

        <div className="hero-image-wrapper">
          <img
            src="/assets/mbak.png"
            alt="Woman smiling with laptop"
            className="hero-image"
          />
        </div>
      </section>
    </div>
  );
};

export default HeroSection;
