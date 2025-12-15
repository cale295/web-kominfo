import React, { useEffect, useState } from "react";
import api from "../../../services/api";

interface Video {
  id_video_layanan: string;
  youtube_url: string;
  title: string;
  is_featured: string;
  sorting: string;
  is_active: string;
}

const Media: React.FC = () => {
  const [mainVideo, setMainVideo] = useState<Video | null>(null);
  const [otherVideos, setOtherVideos] = useState<Video[]>([]);
  const [loading, setLoading] = useState(true);

  // Convert youtube link to embed link
  const convertToEmbedUrl = (url: string) => {
    if (!url) return "";
    // Regex yang lebih tangguh untuk berbagai format URL YouTube
    const regex = /(?:youtube\.com\/(?:[^\/]+\/.+\/|\w\/\w\/|watch\?.*v=))([^&]+)/;
    const match = url.match(regex);
    const videoId = match ? match[1] : url.split("v=")[1]?.split("&")[0];
    
    return videoId ? `https://www.youtube.com/embed/${videoId}` : "";
  };

  useEffect(() => {
    const fetchVideos = async () => {
      try {
        const res = await api.get("/home_video_layanan");

        if (res.data?.data) {
          const allVideos: Video[] = res.data.data;

          // 1. Filter hanya yang aktif
          const activeVideos = allVideos.filter((v: Video) => v.is_active === "1");

          // 2. Cari Video Utama (featured = 1)
          const featuredVideos = activeVideos
            .filter((v: Video) => v.is_featured === "1")
            .sort((a: Video, b: Video) => Number(a.sorting) - Number(b.sorting));
          
          const primaryVideo = featuredVideos.length > 0 ? featuredVideos[0] : null;

          setMainVideo(primaryVideo);

          // 3. Tentukan Video Lainnya
          let remainingVideos: Video[];
          if (primaryVideo) {
            // Kecualikan video utama dari daftar video lainnya
            remainingVideos = activeVideos.filter(
              (v: Video) => v.id_video_layanan !== primaryVideo.id_video_layanan
            );
          } else {
            // Jika tidak ada video featured, semua video aktif adalah 'otherVideos'
            remainingVideos = activeVideos;
          }
          
          // Urutkan video lainnya berdasarkan sorting
          remainingVideos.sort((a: Video, b: Video) => Number(a.sorting) - Number(b.sorting));

          setOtherVideos(remainingVideos);
        }
      } catch (error) {
        console.error("Gagal fetch video:", error);
      } finally {
        setLoading(false);
      }
    };

    fetchVideos();
  }, []);


  return (
    <div className="container my-5">
      {loading && <p className="text-center">Loading video...</p>}
      
      {!loading && mainVideo === null && otherVideos.length === 0 && (
        <p className="text-center">Tidak ada video yang tersedia saat ini.</p>
      )}

      {/* VIDEO UTAMA (hanya tampil jika mainVideo ada) */}
      {mainVideo && (
        <div className="row mb-4">
          <div className="col-12">
            <h4 className="mb-3">{mainVideo.title}</h4>
            <div className="ratio ratio-16x9">
              <iframe
                src={convertToEmbedUrl(mainVideo.youtube_url)}
                title={mainVideo.title}
                allowFullScreen
                style={{ borderRadius: "20px" }}
              />
            </div>
          </div>
        </div>
      )}

      {/* VIDEO LAINNYA (hanya tampil jika ada otherVideos) */}
      {otherVideos.length > 0 && (
        <div className="row">
          {otherVideos.map((vid) => (
            <div
              key={vid.id_video_layanan}
              className="col-12 col-md-4 mb-4"
            >
              <div className="ratio ratio-16x9">
                <iframe
                  src={convertToEmbedUrl(vid.youtube_url)}
                  title={vid.title}
                  allowFullScreen
                  style={{ borderRadius: "15px" }}
                />
              </div>
              <p className="mt-2 text-center">{vid.title}</p>
            </div>
          ))}
        </div>
      )}
    </div>
  );
};

export default Media;