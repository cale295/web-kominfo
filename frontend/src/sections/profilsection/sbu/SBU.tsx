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
  expandedItems: Set<string>;
  setExpandedItems: (fn: (prev: Set<string>) => Set<string>) => void;
}> = ({ item, children, allData, activeId, onSelect, level, expandedItems, setExpandedItems }) => {
  const hasChildren = children.length > 0;
  const isChild = item.deskripsi !== null && item.deskripsi.trim() !== ""; // Jika ada deskripsi = Child
  const isSubparent = hasChildren && !isChild; // Jika tidak ada deskripsi dan punya children = Subparent
  const isExpanded = expandedItems.has(item.id_struktur);

  // Filter children untuk hanya tampilkan yang bukan child (bukan yang punya deskripsi)
  const nonChildChildren = children.filter(
    (child) => !child.deskripsi || child.deskripsi.trim() === "" || 
    allData.some((d) => d.parent_id === child.id_struktur) // atau punya children sendiri
  );

  const handleClick = () => {
    // Toggle expand DAN select untuk tampilkan children
    if (hasChildren) {
      setExpandedItems((prev) => {
        const newSet = new Set(prev);
        if (newSet.has(item.id_struktur)) {
          newSet.delete(item.id_struktur);
        } else {
          newSet.add(item.id_struktur);
        }
        return newSet;
      });
    }
    // Select untuk tampilkan children di content area
    onSelect(item.id_struktur);
  };

  if (level === 0) {
    // Root level (Parent)
    return (
      <div className="sidebar-section">
        <div
          className={`sidebar-section-title d-flex justify-content-between align-items-center ${
            activeId === item.id_struktur ? "active-parent" : ""
          }`}
          style={{ cursor: "pointer" }}
          onClick={handleClick}
        >
          {item.nama}
          {hasChildren && <span>{isExpanded ? "−" : "+"}</span>}
        </div>

        {/* Tampilkan hanya subparent (bukan child yang punya deskripsi) */}
        {isExpanded && nonChildChildren.length > 0 && (
          <div>
            {nonChildChildren.map((child) => {
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
                  expandedItems={expandedItems}
                  setExpandedItems={setExpandedItems}
                />
              );
            })}
          </div>
        )}
      </div>
    );
  }

  // Level 1+ (Subparent saja, tidak tampilkan child)
  return (
    <div>
      <div
        className={`sidebar-item d-flex justify-content-between align-items-center ${
          activeId === item.id_struktur ? "active" : ""
        }`}
        onClick={handleClick}
        style={{ cursor: "pointer" }}
      >
        <span>{item.nama}</span>
        {nonChildChildren.length > 0 && (
          <span style={{ fontSize: "0.85rem" }}>{isExpanded ? "−" : "+"}</span>
        )}
      </div>

      {/* Tampilkan hanya subparent (bukan child) */}
      {isExpanded && nonChildChildren.length > 0 && (
        <div style={{ paddingLeft: "1rem" }}>
          {nonChildChildren.map((child) => {
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
                expandedItems={expandedItems}
                setExpandedItems={setExpandedItems}
              />
            );
          })}
        </div>
      )}
    </div>
  );
};

const SBU: React.FC = () => {
  // State untuk data
  const [data, setData] = useState<StrukturItem[]>([]);
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<string | null>(null);

  // State untuk UI
  const [expandedItems, setExpandedItems] = useState<Set<string>>(new Set());
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

        // Set default view - expand parent pertama dan aktifkan parent pertama
        const firstRoot = sortedData.find((item) => item.parent_id === null);
        if (firstRoot) {
          setExpandedItems(new Set([firstRoot.id_struktur]));
          setActiveSection(firstRoot.id_struktur);
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

  // Get children/subsections of active item (semua children termasuk yang punya deskripsi)
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
              expandedItems={expandedItems}
              setExpandedItems={setExpandedItems}
            />
          );
        })}
      </div>

      {/* Content Area */}
      <div className="content-area">
        <h1 className="content-title">{activeItem.nama}</h1>

        <div className="content-card">
          <h1 className="content-title">{activeItem.nama}</h1>

          {/* KONTEN UTAMA (Deskripsi) - Hanya jika item aktif adalah Child */}
          {activeItem.deskripsi && activeItem.deskripsi.trim() !== "" && (
            <div className="box">
              <h3>Tugas Pokok & Fungsi</h3>
              <div dangerouslySetInnerHTML={{ __html: activeItem.deskripsi }} />
            </div>
          )}

          {/* TAMPILKAN SEMUA CHILDREN - Setiap child dalam 1 card terpisah */}
          {subSections.length > 0 && (
            <div style={{ marginTop: activeItem.deskripsi ? "20px" : "0" }}>
              {subSections.map((sub) => (
                <div key={sub.id_struktur} className="box" style={{ marginBottom: "20px" }}>
                  <h3>{sub.nama}</h3>
                  {sub.deskripsi && sub.deskripsi.trim() !== "" ? (
                    <div dangerouslySetInnerHTML={{ __html: sub.deskripsi }} />
                  ) : (
                    <p style={{ color: "#999", fontStyle: "italic" }}>
                      Tidak ada deskripsi.
                    </p>
                  )}
                </div>
              ))}
            </div>
          )}

          {/* Jika tidak ada deskripsi dan tidak ada children */}
          {!activeItem.deskripsi && subSections.length === 0 && (
            <div style={{ padding: "20px", textAlign: "center", color: "#999" }}>
              Tidak ada konten untuk ditampilkan.
            </div>
          )}
        </div>
      </div>
    </div>
  );
};

export default SBU;