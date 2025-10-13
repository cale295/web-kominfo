import React from "react";
import { Youtube, Facebook, Instagram, Twitter } from "lucide-react";
import "../index.css";
function Navbar() {
  return (
    <nav className="bg-gradient-to-r from-blue-800 to-blue-950 text-white rounded-t-[3rem] overflow-hidden shadow-md">
      {" "}
      <div className="flex items-center px-16 py-6 relative">
        {" "}
        <div className="hidden md:flex space-x-4 absolute top-6 left-16">
          {" "}
          <Youtube className="w-7 h-7 cursor-pointer text-blue-800 bg-white rounded-full p-1" />{" "}
          <Facebook className="w-7 h-7 cursor-pointer text-blue-800 bg-white rounded-full p-1" />{" "}
          <Instagram className="w-7 h-7 cursor-pointer text-blue-800 bg-white rounded-full p-1" />{" "}
          <Twitter className="w-7 h-7 cursor-pointer text-blue-800 bg-white rounded-full p-1" />{" "}
        </div>{" "}
        <div className="flex-1 flex flex-col items-center justify-center">
          {" "}
          <img
            src="/assets/logo.png"
            alt="Logo Kominfo"
            className="w-24 mb-3 mt-7"
          />{" "}
          <h1 className="font-bold text-lg leading-snug text-center tracking-wide">
            {" "}
            DINAS KOMUNIKASI DAN INFORMATIKA <br /> KOTA TANGERANG{" "}
          </h1>{" "}
        </div>{" "}
        <div className="flex space-x-3 absolute top-6 right-16">
          {" "}
          <img
            src="/assets/indo.png"
            alt="Bahasa Indonesia"
            className="w-8 h-8 rounded-full border-2 border-white cursor-pointer hover:opacity-80 transition"
          />{" "}
          <img
            src="/assets/britain.jpg"
            alt="English"
            className="w-8 h-8 rounded-full border-2 border-white cursor-pointer hover:opacity-80 transition"
          />{" "}
        </div>{" "}
      </div>{" "}
      <div className="border-t border-white"></div>{" "}
      <div className="w-full overflow-x-auto lg:overflow-visible">
        {" "}
        <div className="flex justify-between min-w-max px-10 md:px-20 py-3 font-semibold text-md whitespace-nowrap">
          {" "}
          <a href="#" className="hover:underline px-2">
            {" "}
            PROFIL{" "}
          </a>{" "}
          <a href="#" className="hover:underline px-2">
            {" "}
            BERITA{" "}
          </a>{" "}
          <a href="#" className="hover:underline px-2">
            {" "}
            PROGRAM{" "}
          </a>{" "}
          <a href="#" className="hover:underline px-2">
            {" "}
            INFORMASI PUBLIK{" "}
          </a>{" "}
          <a href="#" className="hover:underline px-2">
            {" "}
            PPID{" "}
          </a>{" "}
          <a href="#" className="hover:underline px-2">
            {" "}
            GALERI{" "}
          </a>{" "}
          <a href="#" className="hover:underline px-2">
            {" "}
            KONTAK{" "}
          </a>{" "}
        </div>{" "}
      </div>{" "}
    </nav>
  );
}
export default Navbar;
