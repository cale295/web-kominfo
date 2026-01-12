import React, { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import api from "../../services/api";
import "bootstrap/dist/css/bootstrap.min.css";
import "./GalleryDetail.css";

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
  deskripsi?: string;
}

const GalleryDetail: React.FC = () => {
  const { id } = useParams<{ id: string }>();
  const navigate = useNavigate();
  const [album, setAlbum] = useState<Album | null>(null);
  const [photos, setPhotos] = useState<Photo[]>([]);
  const [currentPhotoIndex, setCurrentPhotoIndex] = useState(0);
  const [loading, setLoading] = useState(true);

  const BASE_URL = import.meta.env.VITE_API_URL;
  const ROOT_GALLERY = `${BASE_URL}/uploads/gallery`;

  const fetchData = async () => {
    try {
      setLoading(true);
      const [albumRes, photoRes] = await Promise.all([
        api.get("/album"),
        api.get("/gallery"),
      ]);

      if (albumRes.data.status && id) {
        const foundAlbum = albumRes.data.data.find(
          (a: Album) => a.id_album === id
        );
        setAlbum(foundAlbum || null);
      }

      if (photoRes.data.status && id) {
        const albumPhotos = photoRes.data.data.filter(
          (p: Photo) => p.id_album === id
        );
        setPhotos(albumPhotos);
      }
    } catch (error) {
      console.error("Gagal mengambil data gallery:", error);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchData();
  }, [id]);

  const handlePrevPhoto = () => {
    setCurrentPhotoIndex((prev) => (prev > 0 ? prev - 1 : photos.length - 1));
  };

  const handleNextPhoto = () => {
    setCurrentPhotoIndex((prev) => (prev < photos.length - 1 ? prev + 1 : 0));
  };

  const handleThumbnailClick = (index: number) => {
    setCurrentPhotoIndex(index);
  };

  if (loading) {
    return (
      <div className="container py-5">
        <div className="text-center">
          <div className="spinner-border text-primary mb-3" role="status">
            <span className="visually-hidden">Loading...</span>
          </div>
          <p className="text-muted">Memuat detail album...</p>
        </div>
      </div>
    );
  }

  if (!album || photos.length === 0) {
    return (
      <div className="container py-5">
        <div className="text-center">
          <h3>Album Tidak Ditemukan</h3>
          <p className="text-muted">Album ini tidak memiliki foto atau tidak tersedia.</p>
          <button 
            className="btn btn-primary mt-3"
            onClick={() => navigate("/gallery")}
          >
            Kembali ke Galeri
          </button>
        </div>
      </div>
    );
  }

  const currentPhoto = photos[currentPhotoIndex];

  return (
    <div className="gallery-detail-wrapper">
      <div className="container-fluid px-3 px-md-5 py-4">
        {/* Header */}
        <div className="detail-header">
          <button 
            className="btn-back"
            onClick={() => navigate("/gallery")}
          >
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
              <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Kembali
          </button>
          <div className="header-info">
            <h1 className="detail-title">{album.album_name}</h1>
            <p className="detail-meta">
              {new Date(album.created_at).toLocaleDateString('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
              })} WIB
            </p>
          </div>
        </div>

        {/* Main Photo Carousel */}
        <div className="main-photo-container">
          <button 
            className="nav-arrow nav-arrow-left"
            onClick={handlePrevPhoto}
            disabled={photos.length <= 1}
          >
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
              <path d="M15 18l-6-6 6-6"/>
            </svg>
          </button>

          <div className="main-photo">
            <img
              src={`${ROOT_GALLERY}/${currentPhoto.file_path}`}
              alt={currentPhoto.photo_title}
            />
          </div>

          <button 
            className="nav-arrow nav-arrow-right"
            onClick={handleNextPhoto}
            disabled={photos.length <= 1}
          >
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
              <path d="M9 18l6-6-6-6"/>
            </svg>
          </button>
        </div>

        {/* Photo Caption */}
        <div className="photo-caption-box">
          <p className="caption-text">
            {currentPhoto.photo_title}
            {currentPhoto.deskripsi && currentPhoto.deskripsi !== '-' && (
              <span> - {currentPhoto.deskripsi}</span>
            )}
          </p>
        </div>

        {/* Thumbnail Gallery */}
        <div className="thumbnail-gallery">
          <div className="thumbnail-scroll">
            {photos.map((photo, index) => (
              <div
                key={photo.id_photo}
                className={`thumbnail-item ${index === currentPhotoIndex ? 'active' : ''}`}
                onClick={() => handleThumbnailClick(index)}
              >
                <img
                  src={`${ROOT_GALLERY}/${photo.file_path}`}
                  alt={photo.photo_title}
                  loading="lazy"
                />
              </div>
            ))}
          </div>
        </div>
      </div>
    </div>
  );
};

export default GalleryDetail;