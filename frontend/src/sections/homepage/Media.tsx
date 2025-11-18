import React from "react";

const Media: React.FC = () => {
  const youtubeVideos = [
    { id: 1, url: "https://www.youtube.com/embed/dQw4w9WgXcQ" },
    { id: 2, url: "https://www.youtube.com/embed/oHg5SJYRHA0" },
    { id: 3, url: "https://www.youtube.com/embed/oHg5SJYRHA0" },
    { id: 4, url: "https://www.youtube.com/embed/oHg5SJYRHA0" },
    { id: 5, url: "https://www.youtube.com/embed/oHg5SJYRHA0" },
  ];
  const video = youtubeVideos.find((v) => v.id === 1);
  const filteredVideos = youtubeVideos.filter((v) => v.id >= 2);
  return (
    <div className="container my-5">
      <div className="row">
        <div className="col mb-4">
          {video && (
            <div className="ratio ratio-16x9">
              <iframe
                src={video.url}
                title="YouTube video player"
                allowFullScreen
                style={{ borderRadius: "20px" }}
              ></iframe>
            </div>
          )}
        </div>
      </div>
      <div className="row">
        {filteredVideos.map((vid) => (
          <div key={vid.id} className="col mb-4">
            <div className="ratio ratio-16x9">
              <iframe
                src={vid.url}
                title={`YouTube video player ${vid.id}`}
                allowFullScreen
                style={{ borderRadius: "20px" }}
              ></iframe>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
};

export default Media;
