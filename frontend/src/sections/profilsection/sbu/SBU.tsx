import React, { useState } from "react";
import "./SBU.css";

interface SectionData {
  title: string;
  description: string;
  functions?: string[];
  details?: string;
  subsections?: {
    title: string;
    description: string;
  }[];
}

const SBU: React.FC = () => {
  const [expandedParent, setExpandedParent] = useState<string>("Bidang");

  const menu = [
    {
      parent: "Sekretariat",
      children: [
        // isi kalau sudah ada data sekretariat
      ],
    },
    {
      parent: "Bidang",
      children: [
        {
          key: "bidang-diseminasi",
          label: "Bidang Diseminasi Informasi Dan Komunikasi Publik",
        },
        {
          key: "bidang-sarana",
          label: "Bidang Sarana dan Prasarana TIK & Persandian",
        },
        {
          key: "bidang-pengembangan",
          label: "Bidang Pengembangan e-Government",
        },
        {
          key: "bidang-statistik",
          label: "Bidang Statistik dan Pemberdayaan TIK",
        },
      ],
    },
    {
      parent: "UPT",
      children: [
        {
          key: "upt-pengelola",
          label: "UPT Pengelola Ruang Kendali Kota",
        },
      ],
    },
  ];

  const [activeSection, setActiveSection] = useState<string>(
    "bidang-pengembangan"
  );

  const sections: Record<string, SectionData> = {
    "bidang-diseminasi": {
      title: "Bidang Diseminasi Informasi Dan Komunikasi Publik",
      description:
        "Informasi tentang Bidang Diseminasi Informasi Dan Komunikasi Publik",
      functions: [
      "Perencanaan dan pelaksanaan...",
      "Pengelolaan informasi publik...",
    ],
    },
    "bidang-sarana": {
      title: "Bidang Sarana dan Prasarana TIK & Persandian",
      description:
        "Informasi tentang Bidang Sarana dan Prasarana TIK & Persandian",
      functions: [],
    },
    "bidang-pengembangan": {
      title: "Bidang Pengembangan e-Government",
      description:
        "Menyelenggarakan sebagian tugas Dinas dalam lingkup fasilitas di bidang pengembangan aplikasi e-Government.",
      functions: [
        "Penyelenggaraan pengembangan dan integrasi aplikasi manajemen pemerintahan;",
        "Penyelenggaraan pengembangan dan integrasi aplikasi layanan publik;",
        "Penyelenggaraan pemeliharaan dan implementasi aplikasi.",
      ],
      details:
        "Bidang Pengembangan e-Government terdiri atas 3 seksi yaitu Seksi Pengembangan dan Integrasi Aplikasi Manajemen Pemerintahan, Seksi Pengembangan dan Integrasi Aplikasi Layanan Publik, dan Seksi Pemeliharaan dan Implementasi Aplikasi.",
      subsections: [
        {
          title:
            "Seksi Pengembangan dan Integrasi Aplikasi Manajemen Pemerintahan",
          description:
            "Mempunyai tugas pokok melaksanakan sebagian tugas dan fungsi bidang pengembangan e-Government yang berkenaan dengan pengembangan dan integrasi aplikasi manajemen pemerintahan.",
        },
        {
          title: "Seksi Pengembangan dan Integrasi Aplikasi Layanan Publik",
          description:
            "Mempunyai tugas pokok melaksanakan sebagian tugas dan fungsi bidang pengembangan e-Government yang berkenaan dengan pengembangan dan integrasi aplikasi layanan publik.",
        },
        {
          title: "Seksi Pemeliharaan dan Implementasi Aplikasi",
          description:
            "Mempunyai tugas pokok melaksanakan sebagian tugas dan fungsi bidang pengembangan e-Government yang berkenaan dengan Pemeliharaan dan Implementasi Aplikasi.",
        },
      ],
    },
    "bidang-statistik": {
      title: "Bidang Statistik dan Pemberdayaan TIK",
      description: "Informasi tentang Bidang Statistik dan Pemberdayaan TIK",
      functions: [],
    },
    "upt-pengelola": {
      title: "UPT Pengelola Ruang Kendali Kota",
      description: "Informasi tentang UPT Pengelola Ruang Kendali Kota",
      functions: [],
    },
  };

  return (
    <div className="sbu-wrapper">
      {/* Sidebar */}
      <div className="sidebar">
        <div className="sidebar-title">SBU</div>

        {menu.map((group) => (
          <div className="sidebar-section" key={group.parent}>
            <div
              className="sidebar-section-title d-flex justify-content-between align-items-center"
              style={{ cursor: "pointer" }}
              onClick={() =>
                setExpandedParent(
                  expandedParent === group.parent ? "" : group.parent
                )
              }
            >
              {group.parent}
              <span>{expandedParent === group.parent ? "−" : "+"}</span>
            </div>

            {expandedParent === group.parent &&
              group.children.map((item) => (
                <div
                  key={item.key}
                  className={`sidebar-item ${
                    activeSection === item.key ? "active" : ""
                  }`}
                  onClick={() => setActiveSection(item.key)}
                >
                  {item.label}
                </div>
              ))}
          </div>
        ))}
      </div>

      {/* Content Area */}
      <div className="content-area">
        <h1 className="content-title">{sections[activeSection].title}</h1>

        <div className="content-card">
          <h1 className="content-title">{sections[activeSection].title}</h1>

          {/* TUGAS POKOK */}
          <div className="box">
            <h3>Tugas Pokok</h3>
            <p>{sections[activeSection].description}</p>
          </div>

          {/* FUNGSI */}
          {sections[activeSection].functions?.length > 0 && (
            <div className="box">
              <h3>Fungsi</h3>
              <ol className="fungsi-list">
                {sections[activeSection].functions!.map((func, index) => (
                  <li key={index}>{func}</li>
                ))}
              </ol>
            </div>
          )}

          {/* DETAIL */}
          {sections[activeSection].details && (
            <p style={{ marginTop: "20px" }}>
              {sections[activeSection].details}
            </p>
          )}

          {/* SUBSECTIONS */}
          {sections[activeSection].subsections &&
            sections[activeSection].subsections!.map((sub, i) => (
              <div key={i}>
                <div className="subsection-title">
                  {i + 1}. {sub.title}
                </div>
                <div className="subsection-text">{sub.description}</div>
              </div>
            ))}
        </div>
      </div>
    </div>
  );
};

export default SBU;
