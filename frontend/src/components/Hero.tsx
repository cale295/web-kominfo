import React from "react";
import { Search, Accessibility } from "lucide-react";

const HeroSection: React.FC = () => {
  return (
    <div className="bg-gray-50 py-4">
      <header className="flex flex-col md:flex-row justify-between items-center gap-4 px-4 py-6 md:px-6">
        <button className="w-full md:w-auto flex items-center justify-center gap-2 bg-yellow-400 text-blue-800 font-semibold px-5 py-3 rounded-full shadow hover:bg-yellow-300 transition">
          <Accessibility className="w-6 h-6" />
          <span>DISABILITAS</span>
        </button>

        <div className="flex items-center gap-2 w-full md:w-auto md:max-w-sm">
          <div className="flex-grow flex items-center bg-white rounded-full border-2 border-blue-800 px-4 py-2">
            <input 
              type="text"
              placeholder="Apa yang kamu cari"
              className="flex-1 w-full bg-transparent outline-none text-gray-700 placeholder-gray-400"
            />
          </div>
          <button className="text-white bg-blue-800 p-3 rounded-full flex-shrink-0">
            <Search className="w-5 h-5" />
          </button>
        </div>
      </header>

      <section className="flex flex-col md:flex-row items-center justify-between bg-radial from-[#c9815f] to-[#d67041] text-white shadow-lg overflow-hidden my-5 mx-4 rounded-xl">
      
        <div className="flex-1 p-8 md:p-12 lg:p-16 text-center md:text-left">
          {/* Ukuran font dibuat responsif */}
          <h1 className="text-3xl md:text-4xl lg:text-5xl font-bold leading-tight mb-4">
            Mau ikut pelatihan kerja? Ikut Cakap Kerja, Yuk!
          </h1>
          <p className="text-base text-orange-100">
            Tangerang Cakap kerja adalah Lorem ipsum dolor sit amet,
            consectetur adipiscing elit. Ut posuere vitae felis quis pretium.
            Maecenas ultricies rutrum mattis.
          </p>
        </div>

        <div className="flex-1 flex justify-center items-end w-full">
          <img
            src="/assets/mbak.png"
            alt="Woman smiling with laptop"
            className="w-full h-64 md:h-full object-cover object-center"
          />
        </div>
      </section>
    </div>
  );
};

export default HeroSection;