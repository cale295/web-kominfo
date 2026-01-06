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

  const convertToEmbedUrl = (url: string) => {
    if (!url) return "";
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
          const activeVideos = allVideos.filter((v: Video) => v.is_active === "1");

          const featuredVideos = activeVideos
            .filter((v: Video) => v.is_featured === "1")
            .sort((a: Video, b: Video) => Number(a.sorting) - Number(b.sorting));
          
          const primaryVideo = featuredVideos.length > 0 ? featuredVideos[0] : null;

          setMainVideo(primaryVideo);

          let remainingVideos: Video[];
          if (primaryVideo) {
            remainingVideos = activeVideos.filter(
              (v: Video) => v.id_video_layanan !== primaryVideo.id_video_layanan
            );
          } else {
            remainingVideos = activeVideos;
          }
          
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
    <div className="container-fluid min-vh-100 p-3 p-md-5">
      {loading && (
        <div className="d-flex justify-content-center align-items-center min-vh-100">
          <div className="spinner-border" role="status">
            <span className="visually-hidden">Loading...</span>
          </div>
        </div>
      )}

      {!loading && mainVideo === null && otherVideos.length === 0 && (
        <div className="d-flex justify-content-center align-items-center min-vh-100">
          <p>Tidak ada video yang tersedia saat ini.</p>
        </div>
      )}

      {!loading && (mainVideo || otherVideos.length > 0) && (
        <div className="row g-4 h-100">
          {/* VIDEO UTAMA - Besar, 70% layar */}
          {mainVideo && (
            <div className="col-12" style={{ height: "60vh" }}>
              <div className="h-100">
                <div className="ratio ratio-16x9 h-100">
                  <iframe
                    src={convertToEmbedUrl(mainVideo.youtube_url)}
                    title={mainVideo.title}
                    allowFullScreen
                    style={{ borderRadius: "10px" }}
                    className="w-100 h-100"
                  />
                </div>
              </div>
            </div>
          )}

          {/* VIDEO LAINNYA - Kecil, height fix */}
          {otherVideos.length > 0 && (
            <div className="col-12 mt-4">
              <div className="row g-4">
                {otherVideos.map((vid) => (
                  <div
                    key={vid.id_video_layanan}
                    className="col-12 col-md-6 col-lg-4 col-xl-3"
                  >
                    <div style={{ height: "250px" }}> {/* Fixed height */}
                      <div className="ratio ratio-16x9 h-100">
                        <iframe
                          src={convertToEmbedUrl(vid.youtube_url)}
                          title={vid.title}
                          allowFullScreen
                          style={{ borderRadius: "8px" }}
                          className="w-100 h-100"
                        />
                      </div>
                      <p className="mt-2 text-center small">{vid.title}</p>
                    </div>
                  </div>
                ))}
              </div>
            </div>
          )}
        </div>
      )}
    </div>
  );
};

export default Media;