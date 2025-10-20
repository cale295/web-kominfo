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
      icon: <Download className="w-5 h-5 text-gray-800" />,
      title: "TANGERANG LIVE",
      subtitle: "Download Aplikasi Tangerang LIVE",
      bgColor: "bg-yellow-400",
      link: "#",
    },
    {
      icon: <MessageCircle className="w-5 h-5 text-white" />,
      title: "WHATSAPP",
      subtitle: "0811-1500-293",
      bgColor: "bg-blue-500",
      link: "https://wa.me/6281115002932",
    },
    {
      icon: <Users className="w-5 h-5 text-gray-800" />,
      title: "LAYANAN",
      subtitle: "0811-1500-293",
      bgColor: "bg-yellow-400",
      link: "tel:081115002932",
    },
    {
      icon: <MessageSquare className="w-5 h-5 text-white" />,
      title: "LAYANAN SP4N-LAPOR",
      subtitle: "",
      bgColor: "bg-blue-600",
      link: "#",
    },
    {
      icon: <AlertCircle className="w-5 h-5 text-white" />,
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
    <div className="bg-gray-50 py-12 md:py-16">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 className="text-3xl md:text-4xl font-bold text-blue-800 text-center mb-10 md:mb-12">
          Hubungi Kami
        </h1>

        <div className="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-8">
          <div className="flex flex-col gap-4">
            {contactItems.map((item, index) => (
              <a
                key={index}
                href={item.link}
                target="_blank"
                rel="noopener noreferrer"
                className="flex items-center gap-4 p-4 rounded-lg hover:bg-gray-100 transition-colors duration-200 group"
              >
                <div className={`${item.bgColor} p-3 rounded-full flex-shrink-0`}>
                  {item.icon}
                </div>
                <div className="flex-1">
                  <h3 className="text-lg font-bold text-blue-800 group-hover:text-blue-600">
                    {item.title}
                  </h3>
                  {item.subtitle && (
                    <p className="text-sm text-gray-700 mt-1">
                      {item.subtitle}
                    </p>
                  )}
                </div>
              </a>
            ))} 

            <div className="flex justify-center gap-6 pt-6">
              {socialMedia.map((social, index) => (
                <a
                  key={index}
                  href={social.link}
                  target="_blank"
                  rel="noopener noreferrer"
                  className={`text-blue-800 ${social.color} transition-colors duration-300`}
                >
                  {social.icon}
                </a>
              ))}
            </div>
          </div>

          <div className="flex flex-col text-center md:text-left items-center md:items-start">
            <h2 className="text-xl font-bold text-blue-800">
              Dinas Komunikasi dan Informatika
            </h2>
            <h3 className="text-xl font-bold text-blue-800 mb-4">
              Kota Tangerang
            </h3>

            <address className="text-gray-600 text-sm leading-relaxed not-italic mb-6">
              Jl. Satria, RT.002/RW.001, Sukasari, Kec. Tangerang,
              Kota Tangerang, Banten, Indonesia 15111 <br />
              Telp. 021-55764955 Fax. 021-55764957
            </address>

            <div className="w-full h-64 rounded-xl overflow-hidden shadow-md">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.582531321013!2d106.6310888153472!3d-6.186675062335191!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f8d555555555%3A0xbf55869536831c1!2sPusat%20Pemerintahan%20Kota%20Tangerang!5e0!3m2!1sen!2sid!4v1668581123999!5m2!1sen!2sid"
                width="100%"
                height="100%"
                style={{ border: 0 }}
                allowFullScreen={false}
                loading="lazy"
                referrerPolicy="no-referrer-when-downgrade"
                title="Peta Lokasi Dinas Komunikasi dan Informatika Kota Tangerang"
              ></iframe>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}