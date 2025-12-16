/* eslint-disable @typescript-eslint/no-unused-vars */
import React, { useState, useEffect } from "react";
import { Link, useLocation, useNavigate } from "react-router-dom";
import Searchbar from "../../components/searchbar/Searchbar";
import "./css/berita.css";
import api from "../../services/api";
import { Triangle, X, Search } from "lucide-react";

// Interface
interface BeritaItem {
  id_berita: string;
  judul: string;
  slug: string;
  intro: string;
  feat_image: string;
  created_at: string;
  hit: string;
  kategori?: string[];
  kategori_slugs?: string[];
  tags?: string[];
  tags_slugs?: string[];
}

interface Tag {
  id_tags: string;
  nama_tag: string;
  slug: string;
}

interface Kategori {
  id_kategori: string;
  kategori: string;
  slug: string;
  trash: string;
}

interface BeritaUtamaItem {
  id_berita_utama: string;
  id_berita: string;
  jenis: string;
  created_date: string;
  status: string;
}

const Berita: React.FC = () => {
  const location = useLocation();
  const navigate = useNavigate();

  // State Data Global
  const [beritaUtamaList, setBeritaUtamaList] = useState<BeritaItem[]>([]);
  const [beritaPopuler, setBeritaPopuler] = useState<BeritaItem[]>([]);
  const [beritaTerkini, setBeritaTerkini] = useState<BeritaItem[]>([]);
  const [tagPopuler, setTagPopuler] = useState<Tag[]>([]);
  const [allBerita, setAllBerita] = useState<BeritaItem[]>([]);
  const [kategoriList, setKategoriList] = useState<Kategori[]>([]); // Tambah state untuk kategori

  // State untuk Search dan Filter
  const [searchQuery, setSearchQuery] = useState<string>("");
  const [searchResults, setSearchResults] = useState<BeritaItem[]>([]);
  const [isSearching, setIsSearching] = useState<boolean>(false);
  const [hasSearched, setHasSearched] = useState<boolean>(false);
  const [selectedTag, setSelectedTag] = useState<Tag | null>(null);
  const [beritaByTag, setBeritaByTag] = useState<BeritaItem[]>([]);
  const [loadingTag, setLoadingTag] = useState<boolean>(false);
  const [selectedKategori, setSelectedKategori] = useState<Kategori | null>(
    null
  );
  const [loadingKategori, setLoadingKategori] = useState<boolean>(false);
  const [beritaByKategori, setBeritaByKategori] = useState<BeritaItem[]>([]); // Perbaiki typo

  const ROOT = api.defaults.baseURL?.replace("/api", "") ?? "";

  const formatDate = (dateString: string) => {
    const options: Intl.DateTimeFormatOptions = {
      day: "numeric",
      month: "long",
      year: "numeric",
    };
    return new Date(dateString).toLocaleDateString("id-ID", options);
  };

  // Fungsi untuk mendapatkan URL gambar yang benar
  const getImageUrl = (imagePath: string) => {
    if (!imagePath) return "/assets/placeholder-news.jpg";

    if (imagePath.startsWith("http")) {
      return imagePath;
    }

    return `${ROOT}/${imagePath.replace(/^\/+/, "")}`;
  };

  // Filter data berdasarkan search query
  const filterDataBySearch = (
    data: BeritaItem[],
    query: string
  ): BeritaItem[] => {
    if (!query.trim()) return [];

    const lowerQuery = query.toLowerCase().trim();
    return data.filter((berita) => {
      const matchJudul = berita.judul?.toLowerCase().includes(lowerQuery);
      const matchIntro = berita.intro?.toLowerCase().includes(lowerQuery);
      const matchKategori = berita.kategori?.some((kat) =>
        kat?.toLowerCase().includes(lowerQuery)
      );
      const matchTags = berita.tags?.some((tag) =>
        tag?.toLowerCase().includes(lowerQuery)
      );

      return matchJudul || matchIntro || matchKategori || matchTags;
    });
  };

  // =========================================
  // FETCH DATA UTAMA
  // =========================================
  const fetchGeneralData = async () => {
    try {
      const res = await api.get("/berita");
      const data = res?.data?.data;
      if (!data) return;

      const beritaData: BeritaItem[] = data.berita || [];
      setAllBerita(beritaData);

      // Setup Kategori dari API
      if (data.kategori) {
        const filteredKategori = data.kategori.filter(
          (k: Kategori) => k.trash === "0"
        );
        setKategoriList(filteredKategori);
      }

      // Setup Berita Utama (Carousel)
      const utamaArray: BeritaUtamaItem[] = data.utama || [];
      const beritaUtamaDetailList: BeritaItem[] = [];

      if (utamaArray.length > 0) {
        for (const utamaItem of utamaArray) {
          const idUtama = utamaItem.id_berita;
          const foundInList = beritaData.find(
            (item: BeritaItem) => item.id_berita === idUtama
          );
          if (foundInList) {
            beritaUtamaDetailList.push(foundInList);
          } else {
            try {
              const detailRes = await api.get(`/berita/${idUtama}`);
              if (detailRes?.data?.data)
                beritaUtamaDetailList.push(detailRes.data.data);
            } catch (e) {
              console.error(e);
            }
          }
        }
      }
      setBeritaUtamaList(beritaUtamaDetailList);

      // Setup Tag & Populer
      if (data.tag) {
  setTagPopuler(data.tag);
}


      const populer = [...beritaData]
        .sort((a, b) => Number(b.hit) - Number(a.hit))
        .slice(0, 5);
      setBeritaPopuler(populer);

      // Setup Berita Terkini
      const terkini = [...beritaData]
        .sort(
          (a, b) =>
            new Date(b.created_at).getTime() - new Date(a.created_at).getTime()
        )
        .slice(0, 10);
      setBeritaTerkini(terkini);
    } catch (error) {
      console.error("Gagal fetch berita:", error);
    }
  };

  // =========================================
  // FILTER BERITA BERDASARKAN KATEGORI
  // =========================================
  const filterBeritaByKategori = (kategori: Kategori) => {
    setLoadingKategori(true);
    setSelectedKategori(kategori);
    setSelectedTag(null); // Clear tag filter

    // Clear search saat filter by kategori
    setIsSearching(false);
    setSearchQuery("");
    setSearchResults([]);
    setHasSearched(false);

    // Update URL dengan parameter kategori
    navigate(`/berita?kategori=${encodeURIComponent(kategori.slug)}`);

    // Filter berita yang memiliki kategori yang dipilih
    const filteredBerita = allBerita.filter((berita) => {
      if (!berita.kategori || !Array.isArray(berita.kategori)) return false;

      return berita.kategori.some((kategoriString) =>
        kategoriString?.toLowerCase().includes(kategori.kategori?.toLowerCase())
      );
    });

    console.log("📊 Found berita with kategori:", filteredBerita.length);

    // Jika tidak ada data, coba fallback dengan keyword di judul/intro
    if (filteredBerita.length === 0) {
      const filteredByKeyword = allBerita.filter(
        (berita) =>
          berita.judul
            ?.toLowerCase()
            .includes(kategori.kategori?.toLowerCase()) ||
          berita.intro?.toLowerCase().includes(kategori.kategori?.toLowerCase())
      );
      setBeritaByKategori(filteredByKeyword);
    } else {
      setBeritaByKategori(filteredBerita);
    }

    setLoadingKategori(false);
  };

  // =========================================
  // FILTER BERITA BERDASARKAN TAG (Lokal)
  // =========================================
  const filterBeritaByTag = (tag: Tag) => {
  setLoadingTag(true);
  setSelectedTag(tag);
  setSelectedKategori(null); // Clear kategori filter

  // Clear search saat filter by tag
  setIsSearching(false);
  setSearchQuery("");
  setSearchResults([]);
  setHasSearched(false);

  // Filter berita yang memiliki tag yang dipilih
  const filteredBerita = allBerita.filter((berita) => {
    if (!berita.tags || !Array.isArray(berita.tags)) return false;

    return berita.tags.some((tagString) =>
      tagString?.toLowerCase().includes(tag.nama_tag?.toLowerCase())
    );
  });

  console.log("📊 Found berita with tag:", filteredBerita.length);

  // Jika tidak ada data, coba fallback dengan keyword di judul/intro
  if (filteredBerita.length === 0) {
    const filteredByKeyword = allBerita.filter(
      (berita) =>
        berita.judul?.toLowerCase().includes(tag.nama_tag?.toLowerCase()) ||
        berita.intro?.toLowerCase().includes(tag.nama_tag?.toLowerCase())
    );
    setBeritaByTag(filteredByKeyword);
  } else {
    setBeritaByTag(filteredBerita); // ✅ Perbaikan: gunakan filteredBerita bukan filteredByKeyword
  }

  setLoadingTag(false);
};

  // =========================================
  // HANDLE SEARCH
  // =========================================
  const performSearch = (query: string) => {
    const trimmedQuery = query.trim();

    if (!trimmedQuery) {
      setIsSearching(false);
      setSearchResults([]);
      setHasSearched(false);
      return;
    }

    // Clear tag & kategori filter saat search
    setSelectedTag(null);
    setSelectedKategori(null);
    setBeritaByTag([]);
    setBeritaByKategori([]);

    setIsSearching(true);
    setHasSearched(true);

    const filtered = filterDataBySearch(allBerita, trimmedQuery);
    setSearchResults(filtered);
    setIsSearching(false);
  };

  const handleSearchSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    const trimmedQuery = searchQuery.trim();

    if (trimmedQuery) {
      navigate(`/berita?search=${encodeURIComponent(trimmedQuery)}`);
    } else {
      clearSearch();
    }
  };

  const handleSearchChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setSearchQuery(e.target.value);
  };

  // Clear search
  const clearSearch = () => {
    setSearchQuery("");
    setIsSearching(false);
    setSearchResults([]);
    setHasSearched(false);
    navigate("/berita");
  };

  // Clear tag filter
  const clearTagFilter = () => {
    setSelectedTag(null);
    setBeritaByTag([]);
  };

  // Clear kategori filter
  const clearKategoriFilter = () => {
    setSelectedKategori(null);
    setBeritaByKategori([]);
  };

  // Clear semua filter
  const clearAllFilters = () => {
    setSelectedTag(null);
    setSelectedKategori(null);
    setBeritaByTag([]);
    setBeritaByKategori([]);
    setSearchQuery("");
    setIsSearching(false);
    setSearchResults([]);
    setHasSearched(false);
    navigate("/berita");
  };

  // =========================================
  // USE EFFECT
  // =========================================
  useEffect(() => {
    fetchGeneralData();
  }, []);

  useEffect(() => {
    // Handle parameter dari URL
    const searchParams = new URLSearchParams(location.search);
    const kategoriParam = searchParams.get("kategori");
    const searchParam = searchParams.get("search");

    // Jika ada parameter kategori di URL
    if (kategoriParam && allBerita.length > 0 && kategoriList.length > 0) {
      const foundKategori = kategoriList.find(
        (kategori) => kategori.slug === kategoriParam
      );

      if (foundKategori) {
        setSelectedKategori(foundKategori);
        // Panggil filter function
        const filteredBerita = allBerita.filter((berita) => {
          if (!berita.kategori || !Array.isArray(berita.kategori)) return false;
          return berita.kategori.some((kategoriString) =>
            kategoriString
              ?.toLowerCase()
              .includes(foundKategori.kategori?.toLowerCase())
          );
        });
        setBeritaByKategori(filteredBerita);
      }
    }
    // Handle search parameter
    else if (searchParam && allBerita.length > 0) {
      setSearchQuery(searchParam);
      performSearch(searchParam);
    }
    // Reset jika tidak ada parameter
    else if (
      !searchParam &&
      !kategoriParam &&
      (hasSearched || selectedKategori || selectedTag)
    ) {
      setSearchQuery("");
      setSearchResults([]);
      setIsSearching(false);
      setHasSearched(false);
      setSelectedKategori(null);
      setSelectedTag(null);
      setBeritaByKategori([]);
      setBeritaByTag([]);
    }
  }, [location.search, allBerita.length, kategoriList.length]);

  // =========================================
  // RENDER BERITA CARD (Reusable Component)
  // =========================================
  const renderBeritaCard = (item: BeritaItem) => (
    <Link
      to={`/berita/${item.slug}`}
      key={item.id_berita}
      className="berita-terkini-card mb-3 text-decoration-none d-block"
    >
      <div className="berita-terkini-card-body">
        <div className="col-auto">
          <img
            src={getImageUrl(item.feat_image)}
            className="berita-terkini-img"
            alt={item.judul}
            onError={(e) => {
              (e.target as HTMLImageElement).src =
                "/assets/placeholder-news.jpg";
            }}
          />
        </div>
        <div className="berita-terkini-card-item">
          <h6 className="berita-terkini-title">{item.judul}</h6>
          <p className="berita-terkini-intro">{item.intro}</p>
          <div className="berita-terkini-date">
            {formatDate(item.created_at)}
          </div>
        </div>
      </div>
    </Link>
  );

  // =========================================
  // TENTUKAN KONTEN UTAMA YANG DITAMPILKAN
  // =========================================
  const getMainContent = () => {
    // 1. Jika sedang searching
    if (isSearching) {
      return (
        <div className="text-center py-5">
          <div className="spinner-border text-primary" role="status">
            <span className="visually-hidden">Mencari...</span>
          </div>
          <p className="mt-3">Mencari berita...</p>
        </div>
      );
    }

    // 2. Jika ada hasil search
    if (hasSearched) {
      if (searchResults.length === 0) {
        return (
          <div className="alert alert-warning">
            <h6>Tidak ada hasil ditemukan</h6>
            <p className="mb-0">
              Tidak ada berita yang sesuai dengan pencarian "
              <strong>{searchQuery}</strong>"
            </p>
            <small className="text-muted">
              Coba kata kunci lain atau periksa ejaan
            </small>
          </div>
        );
      }
      return searchResults.map(renderBeritaCard);
    }

    // 3. Jika ada tag yang dipilih (filter lokal)
    if (selectedTag) {
      if (loadingTag) {
        return (
          <div className="text-center py-5">
            <div className="spinner-border text-primary" role="status">
              <span className="visually-hidden">Loading...</span>
            </div>
            <p className="mt-3">
              Memuat berita dengan tag {selectedTag.nama_tag}...
            </p>
          </div>
        );
      }

      if (beritaByTag.length === 0) {
        return (
          <div className="alert alert-info">
            <p className="mb-0">
              Tidak ada berita dengan tag{" "}
              <strong>{selectedTag.nama_tag}</strong>.
            </p>
          </div>
        );
      }
      return beritaByTag.map(renderBeritaCard);
    }

    // 4. Jika ada kategori yang dipilih
    if (selectedKategori) {
      if (loadingKategori) {
        return (
          <div className="text-center py-5">
            <div className="spinner-border text-primary" role="status">
              <span className="visually-hidden">Loading...</span>
            </div>
            <p className="mt-3">
              Memuat berita dengan kategori {selectedKategori.kategori}...
            </p>
          </div>
        );
      }

      if (beritaByKategori.length === 0) {
        return (
          <div className="alert alert-info">
            <p className="mb-0">
              Tidak ada berita dengan kategori{" "}
              <strong>{selectedKategori.kategori}</strong>.
            </p>
          </div>
        );
      }
      return beritaByKategori.map(renderBeritaCard);
    }

    // 5. Default: tampilkan berita terkini
    return beritaTerkini.length > 0 ? (
      beritaTerkini.map(renderBeritaCard)
    ) : (
      <p className="text-muted">Memuat berita terkini...</p>
    );
  };

  const getMainContentTitle = () => {
    if (isSearching) return `Mencari: "${searchQuery}"`;
    if (hasSearched && searchResults.length > 0)
      return `Hasil Pencarian: "${searchQuery}" (${searchResults.length} hasil)`;
    if (hasSearched && searchResults.length === 0)
      return `Hasil Pencarian: "${searchQuery}" (0 hasil)`;
    if (selectedTag)
      return `Berita dengan Tag: ${selectedTag.nama_tag} (${beritaByTag.length} hasil)`;
    if (selectedKategori)
      return `Berita dengan Kategori: ${selectedKategori.kategori} (${beritaByKategori.length} hasil)`;
    return "Berita Terkini";
  };

  // Check if we're in filter mode
  const isFilterMode = hasSearched || selectedTag || selectedKategori;

  // =========================================
  // RENDER
  // =========================================
  return (
    <div className="container-fluid my-5 berita-container">
      {/* Search Bar */}
      <div className="d-flex justify-content-end mb-4">
        <Searchbar />
      </div>

      {/* Filter Indicator */}
      {(selectedTag || selectedKategori || hasSearched) && (
        <div className="row mb-4">
          <div className="col-12">
            <div className="alert alert-info d-flex justify-content-between align-items-center">
              <span>
                {selectedTag &&
                  `Menampilkan berita dengan tag: ${selectedTag.nama_tag}`}
                {selectedKategori &&
                  `Menampilkan berita dengan kategori: ${selectedKategori.kategori}`}
                {hasSearched &&
                  !selectedTag &&
                  !selectedKategori &&
                  `Menampilkan hasil pencarian: "${searchQuery}"`}
              </span>
              <button
                className="btn btn-sm btn-outline-secondary"
                onClick={clearAllFilters}
              >
                <X size={16} /> Clear Filter
              </button>
            </div>
          </div>
        </div>
      )}

      {/* Main Grid Layout */}
      <div className="row g-4">
        {/* Layout sebelum filter */}
        {!isFilterMode && (
          <>
            {/* Berita Utama - Top Left */}
            <div className="col-lg-8">
              <h5 className="section-title">
                <Triangle className="icon-triangle" /> Berita Utama
              </h5>

              {beritaUtamaList.length > 0 ? (
                <div
                  id="carouselBeritaUtama"
                  className="carousel slide"
                  data-bs-ride="carousel"
                >
                  <div className="carousel-indicators">
                    {beritaUtamaList.map((_, index) => (
                      <button
                        key={index}
                        type="button"
                        data-bs-target="#carouselBeritaUtama"
                        data-bs-slide-to={index}
                        className={index === 0 ? "active" : ""}
                        aria-current={index === 0 ? "true" : "false"}
                      ></button>
                    ))}
                  </div>

                  <div className="carousel-inner">
                    {beritaUtamaList.map((item, index) => (
                      <Link
                        key={item.id_berita}
                        to={`/berita/${item.slug}`}
                        className={`carousel-item ${
                          index === 0 ? "active" : ""
                        }`}
                        style={{ textDecoration: "none" }}
                      >
                        <img
                          src={getImageUrl(item.feat_image)}
                          className="d-block w-100 carousel-image"
                          alt={item.judul}
                          onError={(e) => {
                            (e.target as HTMLImageElement).src =
                              "/assets/placeholder-news.jpg";
                          }}
                        />
                        <div className="carousel-caption-custom">
                          <h5 className="caption-title">{item.judul}</h5>
                          <p className="caption-date">
                            {formatDate(item.created_at)}
                          </p>
                        </div>
                      </Link>
                    ))}
                  </div>

                  <button
                    className="carousel-control-prev"
                    type="button"
                    data-bs-target="#carouselBeritaUtama"
                    data-bs-slide="prev"
                  >
                    <span
                      className="carousel-control-prev-icon"
                      aria-hidden="true"
                    ></span>
                  </button>
                  <button
                    className="carousel-control-next"
                    type="button"
                    data-bs-target="#carouselBeritaUtama"
                    data-bs-slide="next"
                  >
                    <span
                      className="carousel-control-next-icon"
                      aria-hidden="true"
                    ></span>
                  </button>
                </div>
              ) : (
                <p className="text-muted">Memuat berita utama...</p>
              )}
            </div>

            {/* Berita Populer - Top Right */}
            <div className="col-lg-4">
              <h5 className="section-title">
                <Triangle className="icon-triangle" /> Berita Populer
              </h5>
              <div className="berita-populer-card">
                <ul className="list-unstyled berita-populer-list">
                  {beritaPopuler.length > 0 ? (
                    beritaPopuler.map((item, index) => (
                      <li key={item.id_berita} className="berita-populer-item">
                        <Link
                          to={`/berita/${item.slug}`}
                          className="berita-populer-link text-decoration-none"
                        >
                          <span className="berita-number">{index + 1}#</span>
                          <div className="berita-content">
                            <span className="berita-title text-break">
                              {item.judul}
                            </span>
                            <span className="berita-date">
                              dibaca {item.hit} kali
                            </span>
                          </div>
                        </Link>
                      </li>
                    ))
                  ) : (
                    <li className="text-muted">Memuat...</li>
                  )}
                </ul>
                <Link to="/berita/populer" className="btn-link-more">
                  Lihat berita populer lainnya
                </Link>
              </div>
            </div>

            {/* Berita Terkini - Bottom Left */}
            <div className="col-lg-8">
              <h5 className="section-title">
                <Triangle className="icon-triangle" /> Berita Terkini
              </h5>
              <div style={{ maxHeight: "850px", overflowY: "auto" }}>
                {beritaTerkini.length > 0 ? (
                  beritaTerkini.map(renderBeritaCard)
                ) : (
                  <p className="text-muted">Memuat berita terkini...</p>
                )}
              </div>
            </div>

            {/* Tag Populer - Bottom Right */}
            <div className="col-lg-4">
              <h5 className="section-title">
                <Triangle className="icon-triangle" /> Tag Paling Dicari
              </h5>
              <div className="tag-populer-card">
                <ul className="list-unstyled tag-populer-list">
                  {tagPopuler.length > 0 ? (
                    tagPopuler.map((tag, index) => (
                      <li key={tag.id_tags} className="tag-populer-item">
                        <button
                          onClick={() => filterBeritaByTag(tag)}
                          className={`tag-populer-link ${
                            selectedTag?.id_tags === tag.id_tags ? "active" : ""
                          }`}
                          style={{
                            background: "none",
                            border: "none",
                            width: "100%",
                            textAlign: "left",
                            cursor: "pointer",
                            padding: "0.5rem",
                          }}
                        >
                          <span className="tag-number">#{index + 1}</span>
                          <span className="tag-name">{tag.nama_tag}</span>
                        </button>
                      </li>
                    ))
                  ) : (
                    <p className="text-muted small">Memuat tag...</p>
                  )}
                </ul>
              </div>
            </div>
          </>
        )}

        {/* Layout sesudah filter */}
        {isFilterMode && (
          <>
            {/* Berita Terkini/Results - Left Side (Full Height) */}
            <div className="col-lg-8">
              <h5 className="section-title">
                <Triangle className="icon-triangle" />
                {getMainContentTitle()}
              </h5>
              <div style={{ maxHeight: "800px", overflowY: "auto" }}>
                {getMainContent()}
              </div>
            </div>

            {/* Sidebar - Right Side */}
            <div className="col-lg-4">
              {/* Berita Populer - Top Right */}
              <div className="mb-4">
                <h5 className="section-title">
                  <Triangle className="icon-triangle" /> Berita Populer
                </h5>
                <div className="berita-populer-card">
                  <ul className="list-unstyled berita-populer-list">
                    {beritaPopuler.length > 0 ? (
                      beritaPopuler.map((item, index) => (
                        <li
                          key={item.id_berita}
                          className="berita-populer-item"
                        >
                          <Link
                            to={`/berita/${item.slug}`}
                            className="berita-populer-link text-decoration-none"
                          >
                            <span className="berita-number">{index + 1}#</span>
                            <div className="berita-content">
                              <span className="berita-title text-break">
                                {item.judul}
                              </span>
                              <span className="berita-date">
                                dibaca {item.hit} kali
                              </span>
                            </div>
                          </Link>
                        </li>
                      ))
                    ) : (
                      <li className="text-muted">Memuat...</li>
                    )}
                  </ul>
                  <Link to="/berita/populer" className="btn-link-more">
                    Lihat berita populer lainnya
                  </Link>
                </div>
              </div>

              {/* Tag Populer - Bottom Right */}
              <div>
                <h5 className="section-title">
                  <Triangle className="icon-triangle" /> Tag Paling Dicari
                </h5>
                <div className="tag-populer-card">
                  <ul className="list-unstyled tag-populer-list">
                    {tagPopuler.length > 0 ? (
                      tagPopuler.map((tag, index) => (
                        <li key={tag.id_tags} className="tag-populer-item">
                          <button
                            onClick={() => filterBeritaByTag(tag)}
                            className={`tag-populer-link ${
                              selectedTag?.id_tags === tag.id_tags
                                ? "active"
                                : ""
                            }`}
                            style={{
                              background: "none",
                              border: "none",
                              width: "100%",
                              textAlign: "left",
                              cursor: "pointer",
                              padding: "0.5rem",
                            }}
                          >
                            <span className="tag-number">#{index + 1}</span>
                            <span className="tag-name">{tag.nama_tag}</span>
                          </button>
                        </li>
                      ))
                    ) : (
                      <p className="text-muted small">Memuat tag...</p>
                    )}
                  </ul>
                </div>
              </div>
            </div>
          </>
        )}
      </div>
    </div>
  );
};

export default Berita;
