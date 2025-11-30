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

  const ROOT_ALBUM = "http://localhost:8080/uploads/album_covers";
  const ROOT_GALLERY = "http://localhost:8080/uploads/gallery";

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
    return <div className="text-center py-5">Memuat gallery...</div>;
  }

  if (albums.length === 0) {
    return <div className="text-center py-5">Tidak ada album tersedia</div>;
  }

  const selectedAlbumData = getSelectedAlbum();
  const filteredPhotos = getFilteredPhotos();

  return (
    <div className="gallery-container">
      <h2 className="gallery-title">Galeri Foto</h2>

      {/* FILTER ALBUM - DESIGN YANG LEBIH BAGUS */}
      <div className="album-filter-section">
        <div className="filter-header">
          <span className="filter-icon">📁</span>
          <h3>Pilih Album</h3>
        </div>
        <select
          value={selectedAlbum}
          onChange={(e) => setSelectedAlbum(e.target.value)}
          className="album-select"
        >
          {albums.map((album) => {
            const photoCount = photos.filter(p => p.id_album === album.id_album).length;
            return (
              <option key={album.id_album} value={album.id_album}>
                {album.album_name} ({photoCount} foto)
              </option>
            );
          })}
        </select>
      </div>

      {/* ALBUM YANG DIPILIH */}
      {selectedAlbumData && (
        <div className="selected-album-container">
          {/* HEADER ALBUM - SAMA DENGAN SEBELUMNYA */}
          <div className="album-header">
            <div className="album-cover-container">
              <img
                src={`${ROOT_ALBUM}/${selectedAlbumData.cover_image}`}
                className="album-cover"
                alt={selectedAlbumData.album_name}
              />
            </div>
            <div className="album-info">
              <h3 className="album-name">{selectedAlbumData.album_name}</h3>
              <p className="album-description">{selectedAlbumData.description}</p>
              <div className="album-stats">
                <span className="photo-count-badge">
                  {filteredPhotos.length} Foto
                </span>
              </div>
            </div>
          </div>

          {/* GRID FOTO - SAMA DENGAN SEBELUMNYA */}
          {filteredPhotos.length > 0 ? (
            <div className="photo-grid">
              {filteredPhotos.map((photo) => (
                <div key={photo.id_photo} className="photo-item">
                  <div className="photo-image-container">
                    <img
                      src={`${ROOT_GALLERY}/${photo.file_path}`}
                      alt={photo.photo_title}
                      className="photo-image"
                    />
                  </div>
                  <p className="photo-title">{photo.photo_title}</p>
                </div>
              ))}
            </div>
          ) : (
            <div className="empty-state">
              <div className="empty-icon">📷</div>
              <p className="empty-text">Belum ada foto di album ini</p>
            </div>
          )}
        </div>
      )}
    </div>
  );
};

export default Gallery;