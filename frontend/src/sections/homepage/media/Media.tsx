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
  const [videos, setVideos] = useState<Video[]>([]);

  // Convert youtube link to embed link
  const convertToEmbedUrl = (url: string) => {
    if (!url) return "";
    const videoId = url.split("v=")[1]?.split("&")[0];
    return `https://www.youtube.com/embed/${videoId}`;
  };

  useEffect(() => {
    const fetchVideos = async () => {
      try {
        const res = await api.get("/home_video_layanan");

        if (res.data?.data) {
          // Filter hanya yang aktif
          const activeVideos = res.data.data
            .filter((v: Video) => v.is_active === "1")
            .sort((a: Video, b: Video) => Number(a.sorting) - Number(b.sorting));

          setVideos(activeVideos);
        }
      } catch (error) {
        console.error("Gagal fetch video:", error);
      }
    };

    fetchVideos();
  }, []);

  const mainVideo = videos[0];
  const otherVideos = videos.slice(1);

  return (
    <div className="container my-5">
      {/* VIDEO UTAMA */}
      <div className="row mb-4">
        <div className="col-12">
          {mainVideo ? (
            <>
              <h4 className="mb-3">{mainVideo.title}</h4>
              <div className="ratio ratio-16x9">
                <iframe
                  src={convertToEmbedUrl(mainVideo.youtube_url)}
                  title={mainVideo.title}
                  allowFullScreen
                  style={{ borderRadius: "20px" }}
                />
              </div>
            </>
          ) : (
            <p className="text-center">Loading video...</p>
          )}
        </div>
      </div>

      {/* VIDEO LAINNYA */}
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
    </div>
  );
};

export default Media;
