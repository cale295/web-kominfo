/* eslint-disable @typescript-eslint/no-unused-vars */
import React, { useState, useEffect, useRef, useCallback } from "react";
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
  tanggal: string;
  hit: string;
  kategori?: string[];
  kategori_slugs?: string[];
  tags?: string[];
  tags_slugs?: string[];
  tags_hits?: string[];
}

interface Tag {
  id_tags: string;
  nama_tag: string;
  slug: string;
  hit?: string;
}

// Interface untuk ApiTag (untuk data dari API yang mungkin punya properti berbeda)
interface ApiTag {
  id_tags?: string;
  id_tags_berita?: string; // Properti alternatif
  nama_tag?: string;
  slug?: string;
  hit?: string;
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

interface ApiResponse {
  status: boolean;
  message: string;
  data: {
    utama?: BeritaItem[];
    berita?: BeritaItem[];
    kategori?: Kategori[];
    tag?: Tag[];
  };
  tag_info?: {
    id_tags: string;
    nama_tag: string;
    slug: string;
    hit: string;
  };
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
  const [kategoriList, setKategoriList] = useState<Kategori[]>([]);

  // State untuk Search dan Filter
  const [searchQuery, setSearchQuery] = useState<string>("");
  const [searchResults, setSearchResults] = useState<BeritaItem[]>([]);
  const [isSearching, setIsSearching] = useState<boolean>(false);
  const [hasSearched, setHasSearched] = useState<boolean>(false);
  const [selectedTag, setSelectedTag] = useState<Tag | null>(null);
  const [beritaByTag, setBeritaByTag] = useState<BeritaItem[]>([]);
  const [loadingTag, setLoadingTag] = useState<boolean>(false);
  const [selectedKategori, setSelectedKategori] = useState<Kategori | null>(
    null,
  );
  const [loadingKategori, setLoadingKategori] = useState<boolean>(false);
  const [beritaByKategori, setBeritaByKategori] = useState<BeritaItem[]>([]);

  // State untuk Lazy Loading Berita Terkini
  const [page, setPage] = useState<number>(1);
  const [loadingMore, setLoadingMore] = useState<boolean>(false);
  const [hasMore, setHasMore] = useState<boolean>(true);
  const [initialBeritaTerkini, setInitialBeritaTerkini] = useState<
    BeritaItem[]
  >([]);
  const observerTarget = useRef<HTMLDivElement>(null);

  const ROOT = api.defaults.baseURL?.replace("/api", "") ?? "";
  const ITEMS_PER_PAGE = 10;

  // Helper function untuk check filter mode
  const isFilterMode = hasSearched || selectedTag || selectedKategori;

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
    query: string,
  ): BeritaItem[] => {
    if (!query.trim()) return [];

    const lowerQuery = query.toLowerCase().trim();
    return data.filter((berita) => {
      const matchJudul = berita.judul?.toLowerCase().includes(lowerQuery);
      const matchIntro = berita.intro?.toLowerCase().includes(lowerQuery);
      const matchKategori = berita.kategori?.some((kat) =>
        kat?.toLowerCase().includes(lowerQuery),
      );
      const matchTags = berita.tags?.some((tag) =>
        tag?.toLowerCase().includes(lowerQuery),
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
      const filteredKategori = (data.kategori as Kategori[]).filter(
        (k: Kategori) => k.trash === "0",
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
          (item: BeritaItem) => item.id_berita === idUtama,
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

    // Setup Tag & Populer - PERBAIKAN DI SINI
    if (data.tag) {
      // Gunakan ApiTag sebagai tipe
      const tagsWithHit = (data.tag as ApiTag[]).map((tag: ApiTag) => ({
        id_tags: tag.id_tags || tag.id_tags_berita || "",
        nama_tag: tag.nama_tag || "",
        slug: tag.slug || "",
        hit: tag.hit || "0",
      }));
      setTagPopuler(tagsWithHit);
    }

    const populer = [...beritaData]
      .sort((a, b) => Number(b.hit) - Number(a.hit))
      .slice(0, 5);
    setBeritaPopuler(populer);

    // Setup Berita Terkini (Initial 10 items)
    const sortedBerita = [...beritaData].sort(
      (a, b) => new Date(b.tanggal).getTime() - new Date(a.tanggal).getTime(),
    );
    setInitialBeritaTerkini(sortedBerita);

    // Set initial berita terkini (first page)
    const initialItems = sortedBerita.slice(0, ITEMS_PER_PAGE);
    setBeritaTerkini(initialItems);
    setHasMore(sortedBerita.length > ITEMS_PER_PAGE);
    setPage(1);
  } catch (error) {
    console.error("Gagal fetch berita:", error);
  }
};

  // =========================================
  // FETCH TAG POPULER DARI API
  // =========================================
 const fetchPopularTags = async () => {
   try {
     const response = await api.get("/berita/tags/popular");
     if (response.data && response.data.data) {
       // Gunakan ApiTag sebagai tipe
       const tags = (response.data.data as ApiTag[]).map((tag: ApiTag) => ({
         id_tags: tag.id_tags || tag.id_tags_berita || "",
         nama_tag: tag.nama_tag || "",
         slug: tag.slug || "",
         hit: tag.hit || "0",
       }));
       setTagPopuler(tags);
     }
   } catch (error) {
     console.error("Error fetching popular tags:", error);
   }
 };

  // =========================================
  // FILTER BERITA BERDASARKAN TAG DENGAN API
  // =========================================
const filterBeritaByTag = async (tag: Tag) => {
  console.log("🚀 filterBeritaByTag dipanggil untuk:", tag.nama_tag, tag.slug);

  setLoadingTag(true);
  setSelectedTag(tag);
  setSelectedKategori(null);

  // Clear search saat filter by tag
  setIsSearching(false);
  setSearchQuery("");
  setSearchResults([]);
  setHasSearched(false);

  // Update URL dengan parameter tag
  navigate(`/berita?tag=${encodeURIComponent(tag.slug)}`);

  try {
    // Panggil API untuk mendapatkan berita berdasarkan tag
    console.log("📡 Mengirim request ke:", `/berita/tag/${tag.slug}`);

    const response = await api.get(`/berita/tag/${tag.slug}`);

    console.log("✅ Response dari API:", response.data);

    if (response.data && response.data.data) {
      // Data dari API sudah termasuk berita dengan tag tersebut
      setBeritaByTag(response.data.data);

      // Cek tag_info
      if (response.data.tag_info) {
        console.log("🏷️ Tag info setelah update:", response.data.tag_info);
        console.log("Hit count baru:", response.data.tag_info.hit);
      }

      console.log(
        `✅ Berita dengan tag "${tag.nama_tag}":`,
        response.data.data.length,
      );
    } else {
      console.log("⚠️ Response tidak memiliki data");
      // Fallback ke filter lokal jika API gagal
      const filteredBerita = allBerita.filter((berita) => {
        if (!berita.tags || !Array.isArray(berita.tags)) return false;
        return berita.tags.some((tagString) =>
          tagString?.toLowerCase().includes(tag.nama_tag?.toLowerCase()),
        );
      });
      setBeritaByTag(filteredBerita);
    }
  } catch (error) {
    // HAPUS `: any`
    console.error("❌ Error fetching berita by tag:", error);

    // Tampilkan error detail
    if (error instanceof Error && "response" in error) {
      const err = error as any;
      console.error("Response error:", err.response?.data);
      console.error("Status:", err.response?.status);
    }

    // Fallback ke filter lokal
    const filteredBerita = allBerita.filter((berita) => {
      if (!berita.tags || !Array.isArray(berita.tags)) return false;
      return berita.tags.some((tagString) =>
        tagString?.toLowerCase().includes(tag.nama_tag?.toLowerCase()),
      );
    });
    setBeritaByTag(filteredBerita);
  }

  setLoadingTag(false);
};

  // =========================================
  // FILTER BERITA BERDASARKAN KATEGORI
  // =========================================
  const filterBeritaByKategori = (kategori: Kategori) => {
    setLoadingKategori(true);
    setSelectedKategori(kategori);
    setSelectedTag(null);

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
        kategoriString
          ?.toLowerCase()
          .includes(kategori.kategori?.toLowerCase()),
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
          berita.intro
            ?.toLowerCase()
            .includes(kategori.kategori?.toLowerCase()),
      );
      setBeritaByKategori(filteredByKeyword);
    } else {
      setBeritaByKategori(filteredBerita);
    }

    setLoadingKategori(false);
  };

  // =========================================
  // LAZY LOADING BERITA TERKINI
  // =========================================
  const loadMoreBerita = useCallback(async () => {
    if (loadingMore || !hasMore || isFilterMode) return;

    setLoadingMore(true);

    // Simulate API delay
    await new Promise((resolve) => setTimeout(resolve, 500));

    const nextPage = page + 1;
    const startIndex = page * ITEMS_PER_PAGE;
    const endIndex = startIndex + ITEMS_PER_PAGE;

    const moreBerita = initialBeritaTerkini.slice(startIndex, endIndex);

    if (moreBerita.length > 0) {
      setBeritaTerkini((prev) => [...prev, ...moreBerita]);
      setPage(nextPage);
      setHasMore(endIndex < initialBeritaTerkini.length);
    } else {
      setHasMore(false);
    }

    setLoadingMore(false);
  }, [page, loadingMore, hasMore, initialBeritaTerkini, isFilterMode]);

  // Setup Intersection Observer untuk lazy loading
  useEffect(() => {
    if (!observerTarget.current || !hasMore || isFilterMode || loadingMore)
      return;

    const observer = new IntersectionObserver(
      (entries) => {
        if (entries[0].isIntersecting && hasMore) {
          loadMoreBerita();
        }
      },
      { threshold: 0.1, rootMargin: "100px" },
    );

    const currentTarget = observerTarget.current;
    observer.observe(currentTarget);

    return () => {
      if (currentTarget) observer.unobserve(currentTarget);
    };
  }, [loadMoreBerita, hasMore, isFilterMode, loadingMore]);

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
    fetchPopularTags();
  }, []);

  useEffect(() => {
    // Handle parameter dari URL
    const searchParams = new URLSearchParams(location.search);
    const kategoriParam = searchParams.get("kategori");
    const searchParam = searchParams.get("search");
    const tagParam = searchParams.get("tag");

    // Jika ada parameter tag di URL
    if (tagParam && tagPopuler.length > 0) {
      const foundTag = tagPopuler.find((tag) => tag.slug === tagParam);

      if (foundTag) {
        // Panggil fungsi filter berita by tag
        filterBeritaByTag(foundTag);
        return; // Keluar agar tidak eksekusi kode di bawah
      }
    }
    // Jika ada parameter kategori di URL
    else if (kategoriParam && allBerita.length > 0 && kategoriList.length > 0) {
      const foundKategori = kategoriList.find(
        (kategori) => kategori.slug === kategoriParam,
      );

      if (foundKategori) {
        setSelectedKategori(foundKategori);
        // Panggil filter function
        const filteredBerita = allBerita.filter((berita) => {
          if (!berita.kategori || !Array.isArray(berita.kategori)) return false;
          return berita.kategori.some((kategoriString) =>
            kategoriString
              ?.toLowerCase()
              .includes(foundKategori.kategori?.toLowerCase()),
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
      !tagParam &&
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
  }, [
    location.search,
    allBerita.length,
    kategoriList.length,
    tagPopuler.length,
  ]);

  // =========================================
  // RENDER BERITA CARD (Reusable Component)
  // =========================================
  const renderBeritaCard = (item: BeritaItem, index: number) => (
    <Link
      to={`/berita/${item.slug}`}
      key={`${item.id_berita}-${index}`}
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
          <div className="berita-terkini-date">{formatDate(item.tanggal)}</div>
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
      return searchResults.map((item, index) => renderBeritaCard(item, index));
    }

    // 3. Jika ada tag yang dipilih
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
      return beritaByTag.map((item, index) => renderBeritaCard(item, index));
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
      return beritaByKategori.map((item, index) =>
        renderBeritaCard(item, index),
      );
    }

    // 5. Default: tampilkan berita terkini dengan lazy loading
    if (beritaTerkini.length > 0) {
      return (
        <>
          {beritaTerkini.map((item, index) => renderBeritaCard(item, index))}

          {/* Loading indicator */}
          {loadingMore && (
            <div className="text-center py-4">
              <div
                className="spinner-border text-primary spinner-border-sm"
                role="status"
              >
                <span className="visually-hidden">Memuat lebih banyak...</span>
              </div>
              <p className="text-muted mt-2 small">Memuat berita...</p>
            </div>
          )}

          {/* Observer target untuk lazy loading */}
          {hasMore && !loadingMore && (
            <div ref={observerTarget} style={{ height: "20px" }}></div>
          )}

          {/* End of content message */}
          {!hasMore && beritaTerkini.length > 0 && (
            <div className="text-center py-4">
              <p className="text-muted small">
                Menampilkan semua {beritaTerkini.length} berita
              </p>
            </div>
          )}
        </>
      );
    }

    return <p className="text-muted">Memuat berita terkini...</p>;
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

  // =========================================
  // RENDER TAG LIST
  // =========================================
  // =========================================
  // RENDER TAG LIST DENGAN SORTING BERDASARKAN HIT
  // =========================================
  const renderTagList = () => {
    if (tagPopuler.length === 0) {
      return <p className="text-muted small">Memuat tag...</p>;
    }

    // 1. URUTKAN TAG BERDASARKAN HIT (tertinggi ke terendah)
    const sortedTags = [...tagPopuler].sort((a, b) => {
      // Convert hit ke number, default 0 jika null/undefined
      const hitA = parseInt(a.hit as string) || 0;
      const hitB = parseInt(b.hit as string) || 0;

      // DESC: tertinggi ke terendah
      return hitB - hitA;
    });

    // 2. RENDER TAG YANG SUDAH DIURUTKAN
    return sortedTags.map((tag, index) => {
      const tagId = tag.id_tags || `tag-${index}`;
      const isSelected = selectedTag?.id_tags === tagId;
      const hitCount = parseInt(tag.hit as string) || 0;

      return (
        <li key={tagId} className="tag-populer-item">
          <button
            onClick={() => filterBeritaByTag(tag)}
            className={`tag-populer-link ${isSelected ? "active" : ""}`}
            style={{
              background: "none",
              border: "none",
              width: "100%",
              textAlign: "left",
              cursor: "pointer",
              padding: "0.5rem",
            }}
            disabled={loadingTag && isSelected}
          >
            <span className="tag-number">#{index + 1}</span>
            <span className="tag-name">{tag.nama_tag}</span>
            {loadingTag && isSelected && (
              <span className="ms-2">
                <div
                  className="spinner-border spinner-border-sm text-primary"
                  role="status"
                >
                  <span className="visually-hidden">Loading...</span>
                </div>
              </span>
            )}
            {/* Tambah indikator hit count */}
            <span className="tag-hit-count ms-2">
              <small className="text-muted">
                ({hitCount.toLocaleString()} {hitCount === 1 ? "kali" : "kali"})
              </small>
            </span>
          </button>
        </li>
      );
    });
  };

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
      {isFilterMode && (
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
                            {formatDate(item.tanggal)}
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
              <div
                className="berita-terkini-scroll-container"
                style={{
                  maxHeight: "850px",
                  overflowY: "auto",
                  position: "relative",
                }}
              >
                {getMainContent()}
              </div>
            </div>

            {/* Tag Populer - Bottom Right */}
            <div className="col-lg-4">
              <h5 className="section-title">
                <Triangle className="icon-triangle" /> Tag Paling Dicari
              </h5>
              <div className="tag-populer-card">
                <ul className="list-unstyled tag-populer-list">
                  {renderTagList()}
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
              <div className="berita-terkini-scroll-container">
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
                    {renderTagList()}
                  </ul>
                </div>
              </div>
            </div>
          </>
        )}
      </div>
    </div>
  );
};;

export default Berita;
