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
import './contact.css'; // file CSS custom di bawah

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
          Emergency Call <span className="fw-bold">112</span> (Bebas Pulsa)
        </>
      ),
      bgColor: "bg-blue-700",
      link: "tel:112",
    },
  ];

  const socialMedia = [
    { icon: <Youtube className="w-6 h-6" />, link: "#", colorClass: "text-red-600-hover" },
    { icon: <Facebook className="w-6 h-6" />, link: "#", colorClass: "text-blue-600-hover" },
    { icon: <Instagram className="w-6 h-6" />, link: "#", colorClass: "text-pink-600-hover" },
    { icon: <Twitter className="w-6 h-6" />, link: "#", colorClass: "text-blue-400-hover" },
  ];

  return (
    <div className="py-12 py-md-16" id='kontak'>
      <div className="container px-4">
        <h1 className="fs-1 fs-md-1 fw-bold text-blue text-center mb-10 mb-md-12">
          Hubungi Kami
        </h1>

        <div className="row g-10 g-md-8">
          <div className="col-md-6 d-flex flex-column gap-4">
            {contactItems.map((item, index) => (
              <a
                key={index}
                href={item.link}
                target="_blank"
                rel="noopener noreferrer"
                className="d-flex align-items-center gap-4 p-4 rounded-lg bg-hover-gray-100 text-decoration-none"
              >
                <div className={`${item.bgColor} p-3 rounded-circle flex-shrink-0`}>
                  {item.icon}
                </div>
                <div className="flex-grow-1">
                  <h3 className="fs-7 fw-bold text-blue group-hover-text-blue-600">
                    {item.title}
                  </h3>
                  {item.subtitle && (
                    <p className="text-sm fs-i text-blue mt-1 mb-0">
                      {item.subtitle}
                    </p>
                  )}
                </div>
              </a>
            ))}

            <div className="d-flex mx-4 gap-6 pt-6">
              {socialMedia.map((social, index) => (
                <a
                  key={index}
                  href={social.link}
                  target="_blank"
                  rel="noopener noreferrer"
                  className={`text-blue ${social.colorClass} transition-colors`}
                >
                  {social.icon}
                </a>
              ))}
            </div>
          </div>

          <div className="col-md-6 d-flex flex-column align-items-center align-items-md-start text-center text-md-start">
            <h2 className="fs-4 fw-bold text-blue">
              Dinas Komunikasi dan Informatika
            </h2>
            <h3 className="fs-4 fw-bold text-blue mb-4">
              Kota Tangerang
            </h3>

            <address className="text-gray-600 fs-6 mb-6 lh-base fst-normal">
              Jl. Satria, RT.002/RW.001, Sukasari, Kec. Tangerang,<br />
              Kota Tangerang, Banten, Indonesia 15111 <br />
              Telp. 021-55764955 Fax. 021-55764957
            </address>

            <div className="w-100 rounded-xl overflow-hidden shadow-sm" style={{ height: '256px' }}>
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1319.3408819062997!2d106.6401152789647!3d-6.171026352341869!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f8cfe4d01d59%3A0xc9bf83c50c061315!2sDinas%20Komunikasi%20dan%20Informatika%20Kota%20Tangerang!5e1!3m2!1sid!2sid!4v1762144536793!5m2!1sid!2sid" width="100%" height="100%" loading="lazy"></iframe>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}