import React from 'react';
import {
  Download,
  MessageCircle,
  Users,
  MessageSquare,
  AlertCircle,
  Youtube,
  Facebook,
  Instagram,
  Twitter,
} from 'lucide-react';

export default function HubungiKami() {
  const contactItems = [
    {
      icon: <Download className="w-5 h-5" />,
      title: "TANGERANG LIVE",
      subtitle: "Download Aplikasi Tangerang LIVE",
      bgColor: "bg-yellow-400",
      link: "#",
    },
    {
      icon: <MessageCircle className="w-5 h-5" />,
      title: "WHATSAPP",
      subtitle: "0811-1500-293",
      bgColor: "bg-blue-500",
      link: "https://wa.me/6281115002932",
    },
    {
      icon: <Users className="w-5 h-5" />,
      title: "LAYANAN",
      subtitle: "0811-1500-293",
      bgColor: "bg-yellow-400",
      link: "tel:081115002932",
    },
    {
      icon: <MessageSquare className="w-5 h-5" />,
      title: "LAYANAN SP4N-LAPOR",
      subtitle: "",
      bgColor: "bg-blue-600",
      link: "#",
    },
    {
      icon: <AlertCircle className="w-5 h-5" />,
      title: "KEGAWAT DARURATAN",
      subtitle: (
    <>
      Emergency Call <span className="font-bold">112</span> (Bebas Pulsa)
    </>
),
      bgColor: "bg-blue-700",
      link: "tel:112",
    },
  ];

  const socialMedia = [
    { icon: <Youtube className="w-6 h-6" />, link: "#", color: "hover:text-red-600"  },
    { icon: <Facebook className="w-6 h-6" />, link: "#", color: "hover:text-blue-600" },
    { icon: <Instagram className="w-6 h-6" />, link: "#", color: "hover:text-pink-600" },
    { icon: <Twitter className="w-6 h-6" />, link: "#", color: "hover:text-blue-400" },
  ];

  return (
    <div className="min-h-screen  py-10 px-5 ">
      <div className="max-w-7xl mx-auto pl-20">
        {/* Header */}
        <h1 className="text-4xl font-bold text-blue-800 text-center mb-12">
          Hubungi Kami
        </h1>

        {/* Dua Kolom */}
        <div className="grid md:grid-cols-2 gap-8">
          {/* Kolom Kiri: Informasi Kontak */}
          <div className="-space-y-5">
            {contactItems.map((item, index) => (
              <a
                key={index}
                href={item.link}
                className="flex items-center gap-4 p-5"
              >
                <div className={`${item.bgColor} text-Blue p-4 rounded-full flex-shrink-0`}>
                  {item.icon}
                </div>
                <div className="flex-1">
                  <h3 className="text-xl font-bold text-blue-800">
                    {item.title}
                  </h3>
                  {item.subtitle && (
                    <p className="text-sm text-blue-800 italic mt-1">
                      {item.subtitle}
                    </p>
                  )}
                </div>
              </a>
            ))} 

            {/* Ikon Sosial Media */}
            <div className="flex gap-6 pt-6 pl-10">
              {socialMedia.map((social, index) => (
                <a
                  key={index}
                  href={social.link}
                  className={`text-blue-800 ${social.color} transition-colors duration-300`}
                >
                  {social.icon}
                </a>
              ))}
            </div>
          </div>

          {/* Kolom Kanan: Informasi Dinas & Peta */}
          <div className="bg-white p-1 rounded-xl pl-6">
            <h2 className="text-xl font-bold text-blue-800 mb-1">
              Dinas Komunikasi dan Informatika
            </h2>
            <h3 className="text-xl font-bold text-blue-800 mb-3">
              Kota Tangerang
            </h3>

            <div className="text-gray-700 -space-y-2 mb-6">
              <p className="text-xs leading-relaxed">
                Jl. Satria, RT.002/RW.001, Sukasari, Kec. Tangerang,<br />
                Kota Tangerang, Banten, Indonesia 15111 <br />
                Telp. 021-55764955 Fax. 021-55764957
              </p>
            </div>

            <div className="w-90 h-60 rounded-xl overflow-hidden shadow-md">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3770.4321672194087!2d106.63783387475007!3d-6.170743393816583!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f8cc30a3028d%3A0x3213b598f86ba516!2sPusat%20Pemerintahan%20Kota%20Tangerang%20(%20PUSPEM%20)!5e1!3m2!1sid!2sid!4v1760411282570!5m2!1sid!2sid"
                width="100%"
                height="100%"
                style={{ border: 0 }}
                allowFullScreen={false}
                loading="lazy"
                referrerPolicy="no-referrer-when-downgrade"
                title="Peta Puspem Kota Tangerang"
              ></iframe>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
