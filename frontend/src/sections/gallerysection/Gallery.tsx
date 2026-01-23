import React, { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import api from "../../services/api";
import "bootstrap/dist/css/bootstrap.min.css";
import "./Gallery.css";

interface Album {
  id_album: string;
  album_name: string;
  description: string;
  cover_image: string;
  created_at: string;
}

interface Photo {
  id_photo: string;
  photo_title: string;
  file_path: string;
  id_album: string;
}

interface PaginationData {
  current_page: number;
  total_pages: number;
  total_items: number;
  has_next: boolean;
  has_prev: boolean;
}

const Gallery: React.FC = () => {
  const [albums, setAlbums] = useState<Album[]>([]);
  const [photos, setPhotos] = useState<Photo[]>([]);
  const [loading, setLoading] = useState(true);
  const [loadingMore, setLoadingMore] = useState(false);
  const [pagination, setPagination] = useState<PaginationData>({
    current_page: 1,
    total_pages: 1,
    total_items: 0,
    has_next: false,
    has_prev: false,
  });
  const navigate = useNavigate();

  const BASE_URL = import.meta.env.VITE_API_URL;
  const ROOT_ALBUM = `${BASE_URL}/uploads/album_covers`;
  const ROOT_GALLERY = `${BASE_URL}/uploads/gallery`;
  const ITEMS_PER_PAGE = 9; // Sesuaikan dengan kebutuhan

  // Fungsi untuk fetch data awal
  const fetchData = async (page = 1, isLoadMore = false) => {
    try {
      if (isLoadMore) {
        setLoadingMore(true);
      } else {
        setLoading(true);
      }

      const [albumRes, photoRes] = await Promise.all([
        api.get(`/album?page=${page}&limit=${ITEMS_PER_PAGE}`),
        api.get("/gallery"),
      ]);

      if (albumRes.data.status) {
        if (isLoadMore) {
          setAlbums(prev => [...prev, ...albumRes.data.data]);
        } else {
          setAlbums(albumRes.data.data);
        }
        
        // Asumsi API mengembalikan data pagination
        if (albumRes.data.pagination) {
          setPagination(albumRes.data.pagination);
        }
      }

      if (photoRes.data.status) {
        setPhotos(photoRes.data.data);
      }
    } catch (error) {
      console.error("Gagal mengambil data gallery:", error);
    } finally {
      setLoading(false);
      setLoadingMore(false);
    }
  };

  // Fungsi untuk fetch data dengan infinite scroll
  const fetchInfiniteData = async (page = 1) => {
    try {
      setLoadingMore(true);
      
      const albumRes = await api.get(`/album?page=${page}&limit=${ITEMS_PER_PAGE}`);
      
      if (albumRes.data.status) {
        setAlbums(prev => [...prev, ...albumRes.data.data]);
        
        if (albumRes.data.pagination) {
          setPagination(albumRes.data.pagination);
        }
      }
    } catch (error) {
      console.error("Gagal mengambil data album:", error);
    } finally {
      setLoadingMore(false);
    }
  };

  useEffect(() => {
    fetchData(1, false);
  }, []);

  // Handle scroll untuk infinite scroll
  useEffect(() => {
    const handleScroll = () => {
      if (
        window.innerHeight + document.documentElement.scrollTop >= 
        document.documentElement.offsetHeight - 100 &&
        !loadingMore && 
        pagination.has_next
      ) {
        fetchInfiniteData(pagination.current_page + 1);
      }
    };

    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, [loadingMore, pagination]);

  const getPhotoCount = (albumId: string) => {
    return photos.filter((photo) => photo.id_album === albumId).length;
  };

  const getAlbumCover = (album: Album) => {
    if (album.cover_image && album.cover_image.trim() !== '') {
      return `${ROOT_ALBUM}/${album.cover_image}`;
    }
    
    const albumPhotos = photos.filter(p => p.id_album === album.id_album);
    if (albumPhotos.length > 0) {
      return `${ROOT_GALLERY}/${albumPhotos[0].file_path}`;
    }
    
    return null;
  };

  const handleAlbumClick = (albumId: string) => {
    navigate(`/gallery/${albumId}`);
  };

  const handleLoadMore = () => {
    if (pagination.has_next && !loadingMore) {
      fetchData(pagination.current_page + 1, true);
    }
  };

  if (loading && albums.length === 0) {
    return (
      <div className="container py-5">
        <div className="text-center">
          <div className="spinner-border text-primary mb-3" role="status">
            <span className="visually-hidden">Loading...</span>
          </div>
          <p className="text-muted">Memuat galeri foto...</p>
        </div>
      </div>
    );
  }

  if (albums.length === 0) {
    return (
      <div className="container py-5">
        <div className="text-center">
          <h3>Tidak Ada Album</h3>
          <p className="text-muted">Belum ada album foto yang tersedia saat ini.</p>
        </div>
      </div>
    );
  }

  return (
    <div className="gallery-wrapper">
      <div className="container-fluid px-3 px-md-5 py-4">
        <div className="text-center mb-5">
          <h1 className="gallery-main-title">GALERI FOTO</h1>
          <p className="gallery-main-subtitle">DINAS KOMUNIKASI DAN INFORMATIKA KOTA TANGERANG</p>
        </div>

        <div className="row g-4">
          {albums.map((album) => {
            const photoCount = getPhotoCount(album.id_album);
            const coverImage = getAlbumCover(album);

            return (
              <div key={album.id_album} className="col-12 col-md-6 col-lg-4">
                <div className="album-card" onClick={() => handleAlbumClick(album.id_album)}>
                  <div className="album-cover">
                    {coverImage ? (
                      <img
                        src={coverImage}
                        alt={album.album_name}
                        loading="lazy"
                        className="album-cover-img"
                      />
                    ) : (
                      <div className="album-placeholder">
                        <svg 
                          width="80" 
                          height="80" 
                          viewBox="0 0 24 24" 
                          fill="none" 
                          stroke="currentColor" 
                          strokeWidth="1.5"
                        >
                          <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                          <circle cx="8.5" cy="8.5" r="1.5"/>
                          <polyline points="21 15 16 10 5 21"/>
                        </svg>
                      </div>
                    )}
                    <div className="album-overlay">
                      <div className="photo-count">
                        <svg 
                          width="20" 
                          height="20" 
                          viewBox="0 0 24 24" 
                          fill="none" 
                          stroke="currentColor" 
                          strokeWidth="2"
                        >
                          <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                          <circle cx="8.5" cy="8.5" r="1.5"/>
                          <polyline points="21 15 16 10 5 21"/>
                        </svg>
                        <span>{photoCount} Foto</span>
                      </div>
                    </div>
                  </div>
                  <div className="album-info">
                    <h3 className="album-title">{album.album_name}</h3>
                    {album.description && (
                      <p className="album-description">{album.description}</p>
                    )}
                    <div className="album-meta">
                      <span className="album-date">
                        {new Date(album.created_at).toLocaleDateString('id-ID', {
                          weekday: 'long',
                          day: 'numeric',
                          month: 'long',
                          year: 'numeric'
                        })}
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            );
          })}
        </div>

        {/* Loading indicator untuk infinite scroll */}
        {loadingMore && (
          <div className="text-center my-4">
            <div className="spinner-border text-primary" role="status">
              <span className="visually-hidden">Loading more...</span>
            </div>
          </div>
        )}

        {/* Tombol Load More (opsional, bisa diganti dengan infinite scroll saja) */}
        {pagination.has_next && !loadingMore && (
          <div className="text-center mt-5">
            <button 
              className="btn btn-primary btn-lg"
              onClick={handleLoadMore}
              disabled={loadingMore}
            >
              Muat Lebih Banyak
            </button>
          </div>
        )}

        {/* Informasi pagination */}
        <div className="text-center mt-3 text-muted">
          <small>
            Menampilkan {albums.length} dari {pagination.total_items} album
          </small>
        </div>
      </div>
    </div>
  );
};

export default Gallery;