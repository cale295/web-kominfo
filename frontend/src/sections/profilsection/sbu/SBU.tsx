import React, { useState, useEffect } from "react";
import "./SBU.css";
import api from "../../../services/api";

// Interface sesuai response JSON Backend
interface StrukturItem {
  id_struktur: string;
  parent_id: string | null;
  nama: string;
  slug: string;
  deskripsi: string | null;
  sorting: string;
  is_active: string;
}

// Recursive Tree Node Component
const TreeNode: React.FC<{
  item: StrukturItem;
  children: StrukturItem[];
  allData: StrukturItem[];
  activeId: string | null;
  onSelect: (id: string) => void;
  level: number;
  expandedParent: string;
  setExpandedParent: (val: string) => void;
}> = ({ item, children, allData, activeId, onSelect, level, expandedParent, setExpandedParent }) => {
  const hasChildren = children.length > 0;
  const isExpanded = level === 0 ? expandedParent === item.nama : true;

  // Cek apakah ada cucu (grandchildren)
  const hasGrandChildren = children.some(child => {
    return allData.some(d => d.parent_id === child.id_struktur);
  });

  if (level === 0) {
    // Root level - dengan expand/collapse
    return (
      <div className="sidebar-section">
        <div
          className="sidebar-section-title d-flex justify-content-between align-items-center"
          style={{ cursor: "pointer" }}
          onClick={() => {
            // Jika punya children dan ada grandchildren, maka expand/collapse
            // Jika tidak ada grandchildren (langsung child dengan konten), select langsung
            if (hasChildren && hasGrandChildren) {
              setExpandedParent(expandedParent === item.nama ? "" : item.nama);
            } else {
              onSelect(item.id_struktur);
              setExpandedParent(item.nama);
            }
          }}
        >
          {item.nama}
          {hasChildren && hasGrandChildren && (
            <span>{isExpanded ? "−" : "+"}</span>
          )}
        </div>

        {isExpanded && hasChildren && hasGrandChildren && (
          <div>
            {children.map((child) => {
              const grandChildren = allData
                .filter((d) => d.parent_id === child.id_struktur)
                .sort((a, b) => parseInt(a.sorting) - parseInt(b.sorting));

              return (
                <TreeNode
                  key={child.id_struktur}
                  item={child}
                  children={grandChildren}
                  allData={allData}
                  activeId={activeId}
                  onSelect={onSelect}
                  level={level + 1}
                  expandedParent={expandedParent}
                  setExpandedParent={setExpandedParent}
                />
              );
            })}
          </div>
        )}
      </div>
    );
  }

  // Child level (subparent) - clickable untuk menampilkan konten
  return (
    <>
      <div
        className={`sidebar-item ${activeId === item.id_struktur ? "active" : ""}`}
        onClick={() => onSelect(item.id_struktur)}
      >
        {item.nama}
      </div>
    </>
  );
};

const SBU: React.FC = () => {
  // State untuk data
  const [data, setData] = useState<StrukturItem[]>([]);
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<string | null>(null);

  // State untuk UI
  const [expandedParent, setExpandedParent] = useState<string>("");
  const [activeSection, setActiveSection] = useState<string | null>(null);

  // Fetch data dari API
  useEffect(() => {
    const fetchData = async () => {
      try {
        setLoading(true);
        const response = await api.get("/struktur_organisasi");
        const resultData: StrukturItem[] = response.data.data;

        // Sorting berdasarkan field sorting
        const sortedData = resultData.sort((a, b) => parseInt(a.sorting) - parseInt(b.sorting));
        setData(sortedData);

        // Set default view - expand parent pertama dan aktifkan item pertama yang punya konten
        const firstRoot = sortedData.find((item) => item.parent_id === null);
        if (firstRoot) {
          setExpandedParent(firstRoot.nama);
          
          // Cari child pertama dari root pertama
          const firstChild = sortedData.find((item) => item.parent_id === firstRoot.id_struktur);
          
          // Cek apakah firstRoot langsung punya konten atau perlu drill down ke child
          const hasGrandChildren = firstChild && sortedData.some(d => d.parent_id === firstChild.id_struktur);
          
          if (hasGrandChildren && firstChild) {
            // Jika ada grandchildren, aktifkan child pertama
            setActiveSection(firstChild.id_struktur);
          } else {
            // Jika tidak ada grandchildren, aktifkan root
            setActiveSection(firstRoot.id_struktur);
          }
        }

        setLoading(false);
      } catch (err) {
        console.error("Gagal mengambil data struktur:", err);
        setError("Gagal memuat data struktur organisasi.");
        setLoading(false);
      }
    };

    fetchData();
  }, []);

  // Get root items (parent_id === null)
  const rootItems = data
    .filter((item) => item.parent_id === null)
    .sort((a, b) => parseInt(a.sorting) - parseInt(b.sorting));

  // Get active item details
  const activeItem = data.find((item) => item.id_struktur === activeSection);

  // Get children/subsections of active item
  const subSections = data
    .filter((item) => item.parent_id === activeSection)
    .sort((a, b) => parseInt(a.sorting) - parseInt(b.sorting));

  // Render conditions
  if (loading) {
    return <div className="p-5 text-center">Memuat Struktur Organisasi...</div>;
  }

  if (error) {
    return <div className="p-5 text-center text-danger">{error}</div>;
  }

  if (!activeItem) {
    return <div className="p-5 text-center">Data tidak ditemukan.</div>;
  }

  return (
    <div className="sbu-wrapper">
      {/* Sidebar */}
      <div className="sidebar">
        <div className="sidebar-title">SBU</div>

        {rootItems.map((root) => {
          const children = data
            .filter((d) => d.parent_id === root.id_struktur)
            .sort((a, b) => parseInt(a.sorting) - parseInt(b.sorting));

          return (
            <TreeNode
              key={root.id_struktur}
              item={root}
              children={children}
              allData={data}
              activeId={activeSection}
              onSelect={setActiveSection}
              level={0}
              expandedParent={expandedParent}
              setExpandedParent={setExpandedParent}
            />
          );
        })}
      </div>

      {/* Content Area */}
      <div className="content-area">
        <h1 className="content-title">{activeItem.nama}</h1>

        <div className="content-card">
          <h1 className="content-title">{activeItem.nama}</h1>

          {/* TUGAS POKOK / DESKRIPSI */}
          {activeItem.deskripsi && (
            <div className="box">
              <h3>Tugas Pokok & Fungsi</h3>
              <div dangerouslySetInnerHTML={{ __html: activeItem.deskripsi }} />
            </div>
          )}

          {/* SUBSECTIONS - Unit Bawahan (jika ada) */}
          {subSections.length > 0 && (
            <div style={{ marginTop: "20px" }}>
              <h3 style={{ marginBottom: "15px" }}>Unit Bawahan:</h3>
              {subSections.map((sub, i) => (
                <div key={sub.id_struktur}>
                  <div className="subsection-title">
                    {i + 1}. {sub.nama}
                  </div>
                  {sub.deskripsi && (
                    <div 
                      className="subsection-text"
                      dangerouslySetInnerHTML={{ __html: sub.deskripsi }}
                    />
                  )}
                </div>
              ))}
            </div>
          )}
        </div>
      </div>
    </div>
  );
};

export default SBU;