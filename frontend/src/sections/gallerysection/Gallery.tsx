import React, { useEffect, useState } from "react";
import api from "../../services/api";
import "./Gallery.css";

interface Album {
  id_album: string;
  album_name: string;
  description: string;
  cover_image: string;
}

interface Photo {
  id_photo: string;
  photo_title: string;
  file_path: string;
  id_album: string;
}

const Gallery: React.FC = () => {
  const [albums, setAlbums] = useState<Album[]>([]);
  const [photos, setPhotos] = useState<Photo[]>([]);
  const [selectedAlbum, setSelectedAlbum] = useState<string>("");
  const [loading, setLoading] = useState(true);

  const BASE_URL = import.meta.env.VITE_API_URL;
  const ROOT_ALBUM = `${BASE_URL}/uploads/album_covers`;
  const ROOT_GALLERY = `${BASE_URL}/uploads/gallery`;

  const fetchData = async () => {
    try {
      setLoading(true);
      const [albumRes, photoRes] = await Promise.all([
        api.get("/album"),
        api.get("/gallery"),
      ]);

      if (albumRes.data.status) {
        const albumsData = albumRes.data.data;
        setAlbums(albumsData);
        if (albumsData.length > 0 && !selectedAlbum) {
          setSelectedAlbum(albumsData[0].id_album);
        }
      }

      if (photoRes.data.status) {
        setPhotos(photoRes.data.data);
      }
    } catch (error) {
      console.error("Gagal mengambil data gallery:", error);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchData();
  }, []);

  const getFilteredPhotos = () => {
    if (!selectedAlbum) return [];
    return photos.filter((photo) => photo.id_album === selectedAlbum);
  };

  const getSelectedAlbum = () => {
    return albums.find((a) => a.id_album === selectedAlbum);
  };

  if (loading) {
    return (
      <div className="loading-container">
        <div className="loading-spinner"></div>
        <p>Memuat galeri foto...</p>
      </div>
    );
  }

  if (albums.length === 0) {
    return (
      <div className="empty-state">
        <h3>Tidak Ada Album</h3>
        <p>Belum ada album foto yang tersedia saat ini.</p>
      </div>
    );
  }

  const selectedAlbumData = getSelectedAlbum();
  const filteredPhotos = getFilteredPhotos();

  return (
    <div className="gallery-container">
      <div className="gallery-header">
        <h1 className="gallery-title">Galeri Foto</h1>
        <p className="gallery-subtitle">Dokumentasi kegiatan pemerintahan</p>
      </div>

      <div className="album-selector">
        <div className="selector-header">
          <h3>Pilih Album</h3>
        </div>
        <select
          value={selectedAlbum}
          onChange={(e) => setSelectedAlbum(e.target.value)}
          className="album-select"
        >
          {albums.map((album) => (
            <option key={album.id_album} value={album.id_album}>
              {album.album_name} ({photos.filter(p => p.id_album === album.id_album).length} foto)
            </option>
          ))}
        </select>
      </div>

      {selectedAlbumData && (
        <div className="album-content">
          <div className="album-info">
            <div className="album-cover-container">
              <img
                src={`${ROOT_ALBUM}/${selectedAlbumData.cover_image}`}
                alt={selectedAlbumData.album_name}
                className="album-cover"
                loading="lazy"
              />
            </div>
            <div className="album-details">
              <h2>{selectedAlbumData.album_name}</h2>
              <p className="album-description">{selectedAlbumData.description}</p>
              <div className="album-meta">
                <span className="photo-count">
                  {filteredPhotos.length} foto dalam album ini
                </span>
              </div>
            </div>
          </div>

          <div className="photos-section">
            <div className="section-header">
              <h3>Dokumentasi</h3>
            </div>

            {filteredPhotos.length > 0 ? (
              <div className="photo-grid">
                {filteredPhotos.map((photo) => (
                  <div key={photo.id_photo} className="photo-card">
                    <div className="photo-image-container">
                      <img
                        src={`${ROOT_GALLERY}/${photo.file_path}`}
                        alt={photo.photo_title}
                        className="photo-image"
                        loading="lazy"
                      />
                    </div>
                    <div className="photo-info">
                      <p className="photo-title">{photo.photo_title}</p>
                    </div>
                  </div>
                ))}
              </div>
            ) : (
              <div className="no-photos">
                <p>Belum ada foto di album ini</p>
              </div>
            )}
          </div>
        </div>
      )}
    </div>
  );
};

export default Gallery;