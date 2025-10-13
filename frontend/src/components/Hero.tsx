import React from "react";
import { Search, Accessibility } from "lucide-react";

const HeroSection: React.FC = () => {
  return (
    <div className="bg-gray-50 py-5">
      <header className="flex justify-between items-center py-6">
        <button className="flex items-center gap-2 bg-yellow-400 text-blue-800 font-semibold px-5 py-2 rounded-r-full shadow hover:bg-yellow-300 transition">
          <Accessibility className="w-8 h-8" />
          DISABILITAS
        </button>

        <div className="flex items-center space-x-5 mr-10">
          <div className="flex items-center bg-white rounded-full border-2 border-blue-800 px-4 py-2 w-[300px]">
          <input
            type="text"
            placeholder="Apa yang kamu cari"
            className="flex-1 outline-none text-gray-700 placeholder-gray-400"
          />
          </div>
          <button className="text-white bg-blue-800 p-3 rounded-full">
            <Search className="w-5 h-5" />
          </button>
        </div>
      </header>

      <section className="flex flex-col md:flex-row items-center justify-between bg-radial from-[#c9815f] to-[#d67041] text-white shadow-lg overflow-hidden my-5">
        <div className="flex-1 p-20">
          <h1 className="text-4xl md:text-5xl font-bold leading-snug mb-4">
            Mau ikut pelatihan kerja? Ikut Cakap Kerja, Yuk!
          </h1>
          <p className="text-base md:text-md text-orange-100">
            Tangerang Cakap kerja adalah Lorem ipsum dolor sit amet,
            consectetur adipiscing elit. Ut posuere vitae felis quis pretium.
            Maecenas ultricies rutrum mattis. Sed rhoncus luctus erat,
            vel porttitor nunc convallis id.
          </p>
        </div>

        <div className="flex-1 flex justify-center">
          <img
            src="/assets/mbak.png"
            alt="Woman smiling with laptop"
            className="w-[100%]  object-cover"
          />
        </div>
      </section>
    </div>
  );
};

export default HeroSection;
