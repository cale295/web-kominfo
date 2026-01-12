import { useState, useEffect } from "react";
import { Triangle, Calendar, Bell, Image, X } from "lucide-react"; 
import "./Agenda.css";
import api from "../../../services/api";

interface AnnouncementItem {
  id: string;
  title: string;
  date: string;
  content?: string;
  link_url?: string;
  image?: string;
}

interface ApiAgendaItem {
  id_agenda: string;
  activity_name: string;
  description: string;
  start_date: string;
  end_date: string; // Pastikan ini ada di response API
  location: string;
  image: string;
  status: string;
}

interface PengumumanItem {
  id_pengumuman: string;
  judul: string;
  content: string;
  featured_image: string;
  link_url: string;
  status: string;
  created_at: string;
  updated_at: string;
}

interface CalendarEvent {
  date: number;
  title: string;
  time: string;
  image?: string;
}

interface BeritaItem {
  id_berita: string;
  judul: string;
  intro: string;
  feat_image: string;
  created_at: string;
  hit: string;
}

interface BeritaUtamaItem {
  id_berita_utama: string;
  id_berita: string;
  jenis: string;
  created_date: string;
  created_by_id: string;
  created_by_name: string;
  status: string;
}

type TabType = "agenda" | "pengumuman";

export default function Agenda() {
  const today = new Date();
  const [currentNewsIndex, setCurrentNewsIndex] = useState(0);
  const [activeTab, setActiveTab] = useState<TabType>("agenda");
  const [currentMonth, setCurrentMonth] = useState(today.getMonth() + 1);
  const [currentYear, setCurrentYear] = useState(today.getFullYear());
  const [selectedDate, setSelectedDate] = useState<number | null>(
    today.getDate()
  );
  const [calendarEvents, setCalendarEvents] = useState<
    Record<number, CalendarEvent[]>
  >({});

  const [loadingAgenda, setLoadingAgenda] = useState<boolean>(true);
  const [errorAgenda, setErrorAgenda] = useState<string | null>(null);
  const [agendaData, setAgendaData] = useState<ApiAgendaItem[]>([]);

  // State untuk Pengumuman
  const [pengumumanData, setPengumumanData] = useState<PengumumanItem[]>([]);
  const [loadingPengumuman, setLoadingPengumuman] = useState<boolean>(false);
  const [errorPengumuman, setErrorPengumuman] = useState<string | null>(null);

  // State untuk Popup Pengumuman
  const [selectedAnnouncement, setSelectedAnnouncement] = useState<AnnouncementItem | null>(null);

  // State untuk Berita Utama
  const [beritaUtamaList, setBeritaUtamaList] = useState<BeritaItem[]>([]);
  const [loadingBerita, setLoadingBerita] = useState<boolean>(true);
  const [errorBerita, setErrorBerita] = useState<string | null>(null);

  const ROOT = api.defaults.baseURL?.replace("/api", "") ?? "";

  const formatDate = (dateString: string) => {
    const options: Intl.DateTimeFormatOptions = {
      day: "numeric",
      month: "long",
      year: "numeric",
      hour: "2-digit",
      minute: "2-digit",
    };
    return new Date(dateString).toLocaleDateString("id-ID", options);
  };

  const formatAnnouncementDate = (dateString: string) => {
    const options: Intl.DateTimeFormatOptions = {
      day: "numeric",
      month: "long",
      year: "numeric",
    };
    return new Date(dateString).toLocaleDateString("id-ID", options);
  };

  // Generate data pengumuman dari agenda (fallback)
  const announcementFromAgenda: AnnouncementItem[] = agendaData
    .filter(
      (agenda) => agenda.status === "active" || agenda.status === "published"
    )
    .map((agenda, index) => ({
      id: `agenda-${index + 1}`,
      title: agenda.activity_name,
      date: formatAnnouncementDate(agenda.start_date),
      content: agenda.description,
      image: agenda.image ? `uploads/agenda/${agenda.image}` : undefined,
      link_url: "#"
    }))
    .slice(0, 7);

  // Generate data pengumuman dari API pengumuman
  const announcementFromPengumuman: AnnouncementItem[] = pengumumanData
    .filter(
      (pengumuman) =>
        pengumuman.status === "1" || 
        pengumuman.status === "active" || 
        pengumuman.status === "published"
    )
    .map((pengumuman) => ({
      id: pengumuman.id_pengumuman,
      title: pengumuman.judul,
      date: formatAnnouncementDate(pengumuman.created_at),
      content: pengumuman.content,
      link_url: pengumuman.link_url,
      image: pengumuman.featured_image,
    }))
    .slice(0, 7);

  const announcementData = pengumumanData.length > 0 
    ? announcementFromPengumuman 
    : announcementFromAgenda;

  // Fetch Berita
  useEffect(() => {
    const fetchBerita = async () => {
      try {
        setLoadingBerita(true);
        const res = await api.get("/berita");
        const data = res?.data?.data;
        if (!data) { setErrorBerita("Data berita tidak ditemukan"); return; }
        const utamaArray: BeritaUtamaItem[] = data.utama || [];
        const beritaUtamaDetailList: BeritaItem[] = [];
        if (utamaArray.length > 0) {
          for (const utamaItem of utamaArray) {
            const idUtama = utamaItem.id_berita;
            const foundInList = data.berita?.find((item: BeritaItem) => item.id_berita === idUtama);
            if (foundInList) { beritaUtamaDetailList.push(foundInList); } else {
              try {
                const detailRes = await api.get(`/berita/${idUtama}`);
                const detailData = detailRes?.data?.data;
                if (detailData) beritaUtamaDetailList.push(detailData);
              } catch (e) { console.error(e); }
            }
          }
        }
        setBeritaUtamaList(beritaUtamaDetailList);
      } catch (error) { setErrorBerita("Gagal memuat data berita"); } finally { setLoadingBerita(false); }
    };
    fetchBerita();
  }, []);

  // --- BAGIAN INI YANG DIMODIFIKASI UNTUK RENTANG WAKTU ---
  // Fetch Agenda
  useEffect(() => {
    const fetchAgenda = async () => {
      try {
        setLoadingAgenda(true);
        const res = await api.get("/agenda");
        const json = res?.data;
        
        if (json.status && Array.isArray(json.data)) {
          const eventsMap: Record<number, CalendarEvent[]> = {};
          setAgendaData(json.data);

          json.data.forEach((item: ApiAgendaItem) => {
            // 1. Ambil Start Date
            const startDate = new Date(item.start_date);
            // 2. Ambil End Date, jika null/kosong gunakan Start Date
            const endDate = item.end_date ? new Date(item.end_date) : new Date(item.start_date);

            // 3. Normalisasi jam ke 00:00:00 agar loop per hari akurat
            const loopDate = new Date(startDate);
            loopDate.setHours(0, 0, 0, 0);

            const loopEnd = new Date(endDate);
            loopEnd.setHours(0, 0, 0, 0);

            // Validasi: jika loopEnd invalid atau lebih kecil dari start, samakan dengan start
            if (isNaN(loopEnd.getTime()) || loopEnd < loopDate) {
               loopEnd.setTime(loopDate.getTime());
            }

            // 4. Loop dari Start sampai End
            while (loopDate <= loopEnd) {
              // Cek apakah tanggal loop berada di bulan & tahun yang sedang ditampilkan
              if (
                loopDate.getMonth() + 1 === currentMonth && 
                loopDate.getFullYear() === currentYear
              ) {
                const day = loopDate.getDate();
                if (!eventsMap[day]) eventsMap[day] = [];
                
                // Masukkan event ke tanggal tersebut
                eventsMap[day].push({
                  date: day,
                  title: item.activity_name,
                  // Gunakan jam asli dari start_date untuk tampilan jam
                  time: startDate.toLocaleTimeString("id-ID", { hour: "2-digit", minute: "2-digit" }),
                  image: item.image,
                });
              }

              // Pindah ke hari berikutnya
              loopDate.setDate(loopDate.getDate() + 1);
            }
          });

          setCalendarEvents(eventsMap);
        } else { setErrorAgenda("Format data tidak sesuai."); }
      } catch (error) { setErrorAgenda("Gagal memuat data agenda."); } finally { setLoadingAgenda(false); }
    };
    fetchAgenda();
  }, [currentMonth, currentYear]);
  // --- AKHIR MODIFIKASI AGENDA ---

  // Fetch Pengumuman
  useEffect(() => {
    const fetchPengumuman = async () => {
      try {
        setLoadingPengumuman(true);
        setErrorPengumuman(null);
        const res = await api.get("/pengumuman");
        const json = res?.data;
        if (json && json.status === 200 && Array.isArray(json.data)) {
          setPengumumanData(json.data);
        } else if (json && json.status === 200 && json.data) {
          setPengumumanData(Array.isArray(json.data) ? json.data : [json.data]);
        } else {
          setPengumumanData([]);
          setErrorPengumuman(json?.message || "Format data tidak sesuai");
        }
      } catch (error: any) {
        setErrorPengumuman(error.response?.data?.message || "Gagal memuat data pengumuman");
        setPengumumanData([]);
      } finally { setLoadingPengumuman(false); }
    };
    fetchPengumuman();
  }, []);

  // --- HELPER FUNCTIONS ---
  const getDaysInMonth = (month: number, year: number) => new Date(year, month, 0).getDate();
  const getFirstDayOfMonth = (month: number, year: number) => new Date(year, month - 1, 1).getDay();

  const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
  const dayNames = ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"];

  const daysInMonth = getDaysInMonth(currentMonth, currentYear);
  const firstDay = getFirstDayOfMonth(currentMonth, currentYear);
  const days = Array(firstDay).fill(null).concat(Array.from({ length: daysInMonth }, (_, i) => i + 1));

  const handlePrevMonth = () => {
    if (currentMonth === 1) { setCurrentMonth(12); setCurrentYear(currentYear - 1); } else setCurrentMonth(currentMonth - 1);
  };

  const handleNextMonth = () => {
    if (currentMonth === 12) { setCurrentMonth(1); setCurrentYear(currentYear + 1); } else setCurrentMonth(currentMonth + 1);
  };

  const selectedEvents = selectedDate ? calendarEvents[selectedDate] ?? [] : [];
  const firstEvent = selectedEvents[0];
  const currentNews = beritaUtamaList[currentNewsIndex];

  const cleanImagePath = (path: string | undefined) => {
    if (!path) return "";
    return `${ROOT}/${path.replace(/^\/+/, "")}`;
  };

  return (
    <div className="container-fluid py-5 position-relative background-white">
      {/* --- POPUP MODAL START --- */}
      {selectedAnnouncement && (
        <div 
          className="position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center"
          style={{ 
            backgroundColor: 'rgba(0,0,0,0.6)', 
            zIndex: 9999,
            backdropFilter: 'blur(4px)'
          }}
          onClick={() => setSelectedAnnouncement(null)} 
        >
          <div 
            className="card border-0 shadow-lg rounded-4 overflow-hidden position-relative animate-pop"
            style={{ maxWidth: '500px', width: '90%', margin: '20px' }}
            onClick={(e) => e.stopPropagation()} 
          >
            <button 
              className="btn btn-sm btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow-sm z-3"
              onClick={() => setSelectedAnnouncement(null)}
              style={{ width: '32px', height: '32px', padding: 0 }}
            >
              <X size={18} />
            </button>

            <a 
              href={selectedAnnouncement.link_url || "#"} 
              target={selectedAnnouncement.link_url && selectedAnnouncement.link_url !== "#" ? "_blank" : "_self"}
              rel="noopener noreferrer"
              className="text-decoration-none text-dark"
              style={{ display: 'block' }}
            >
              <div className="bg-light d-flex align-items-center justify-content-center" style={{ minHeight: '200px', maxHeight: '300px', overflow: 'hidden' }}>
                {selectedAnnouncement.image ? (
                  <img 
                    src={cleanImagePath(selectedAnnouncement.image)} 
                    alt={selectedAnnouncement.title}
                    className="w-100 object-fit-cover"
                  />
                ) : (
                  <div className="text-muted p-5 text-center">
                    <Image size={48} className="mb-2 opacity-50" />
                    <p className="small m-0">Tidak ada gambar</p>
                  </div>
                )}
              </div>

              <div className="p-4">
                <span className="badge bg-primary mb-2">Pengumuman</span>
                <h4 className="fw-bold text-blue mb-2">{selectedAnnouncement.title}</h4>
                <p className="text-secondary small mb-3">{selectedAnnouncement.date}</p>
                
                <div className="text-muted" style={{ fontSize: '0.95rem', lineHeight: '1.5' }}>
                  {selectedAnnouncement.content ? (
                    selectedAnnouncement.content.length > 150 
                      ? selectedAnnouncement.content.substring(0, 150) + "..." 
                      : selectedAnnouncement.content
                  ) : "Lihat detail selengkapnya..."}
                </div>

                <div className="mt-3 text-primary fw-semibold small">
                  Klik untuk info selengkapnya &rarr;
                </div>
              </div>
            </a>
          </div>
        </div>
      )}
      {/* --- POPUP MODAL END --- */}

      <div className="container">
        <div className="row g-4 align-items-stretch">
          {/* News Section */}
          <div className="col">
            <h1 className="fw-bold text-blue mb-3">Berita Utama</h1>
            <div className=" news-card position-relative overflow-hidden">
              {loadingBerita ? (
                <div className="text-center p-5"><p className="text-muted">Memuat berita utama...</p></div>
              ) : errorBerita ? (
                <div className="text-center p-5"><p className="text-danger">{errorBerita}</p></div>
              ) : beritaUtamaList.length > 0 && currentNews ? (
                <>
                  <div className="news-image-container">
                    {currentNews.feat_image ? (
                      <img src={cleanImagePath(currentNews.feat_image)} className="img-fluid w-100 h-100 object-fit-cover" alt={currentNews.judul} />
                    ) : (
                      <div className="d-flex justify-content-center align-items-center bg-primary text-white" style={{ height: "200px" }}><Image size={60} /></div>
                    )}
                  </div>
                  <div className="card-body text-dark d-flex flex-column pt-3">
                    <h2 className="">{currentNews.judul}</h2>
                    <div className="pt-3"><small className="text-secondary">{formatDate(currentNews.created_at)}</small></div>
                  </div>
                  <div className="d-flex justify-content-center gap-2 pb-3">
                    {beritaUtamaList.map((_, i) => (
                      <button key={i} onClick={() => setCurrentNewsIndex(i)} className={`indicator ${i === currentNewsIndex ? "active" : ""}`} />
                    ))}
                  </div>
                </>
              ) : (
                <div className="text-center p-5"><p className="text-muted">Tidak ada berita utama.</p></div>
              )}
            </div>
          </div>

          {/* Right Tabs */}
          <div className="col-lg-8">
            <div className="d-flex flex-wrap gap-3 mb-3">
              <button onClick={() => setActiveTab("agenda")} className={`tab-btn ${activeTab === "agenda" ? "active" : ""}`}>Agenda</button>
              <button onClick={() => setActiveTab("pengumuman")} className={`tab-btn ${activeTab === "pengumuman" ? "active" : ""}`}>Pengumuman</button>
            </div>

            {activeTab === "agenda" ? (
              <div className="card border-0 shadow rounded-4 bg-light overflow-hidden">
                <div className="row g-0 h-100">
                  <div className="col-md-5 d-flex ">
                    <img
                      src={firstEvent?.image ? `${ROOT}/uploads/agenda/${firstEvent.image}` : "assets/agenda-default.jpg"}
                      alt={firstEvent?.title || "Belum Ada Agenda"}
                      className="img-fluid h-100 object-fit-cover rounded-start-4"
                    />
                  </div>
                  <div className="col-md-7 p-4 d-flex flex-column calender-container">
                    <div className="d-flex justify-content-center align-items-center mb-3">
                      <button onClick={handlePrevMonth} className="btn"><Triangle size={18} fill="black" style={{ transform: "rotate(-90deg)" }} /></button>
                      <span className="fw-bold text-blue">{monthNames[currentMonth - 1]} {currentYear}</span>
                      <button onClick={handleNextMonth} className="btn"><Triangle size={18} fill="black" style={{ transform: "rotate(90deg)" }} /></button>
                    </div>

                    {loadingAgenda ? (
                      <div className="text-center text-muted small my-5">Memuat agenda...</div>
                    ) : errorAgenda ? (
                      <div className="text-center text-danger small my-5">{errorAgenda}</div>
                    ) : (
                      <>
                        <div className="calendar-grid mb-3">
                          {dayNames.map((d) => (<div key={d} className="fw-semibold text-center text-blue small">{d}</div>))}
                          {days.map((day, idx) => (
                            <button key={idx} onClick={() => day && setSelectedDate(day)} className={`calendar-day ${(() => {
                                const isToday = day === today.getDate() && currentMonth === today.getMonth() + 1 && currentYear === today.getFullYear();
                                if (!day) return "invisible";
                                if (selectedDate === day) return "selected";
                                if (calendarEvents[day as number]) return "event";
                                if (isToday) return "today";
                                return "";
                              })()}`}>{day}
                            </button>
                          ))}
                        </div>
                        <div className="card bg-primary-subtle border-0 rounded-3 p-3 mt-auto">
                          <div className="d-flex align-items-center justify-content-center gap-2 mb-2">
                            <Calendar size={16} className="text-blue" />
                            <h6 className="mb-0 fw-bold text-blue">Agenda Tanggal {selectedDate}</h6>
                          </div>
                          {selectedEvents && selectedEvents.length > 0 ? (
                            <div className="d-flex flex-column gap-2">
                              {selectedEvents.map((event, index) => (
                                <div key={index} className="d-flex justify-content-between align-items-center border-bottom pb-1">
                                  <p className="fw-semibold mb-0 small">{event.title}</p>
                                  <p className="fw-bold text-blue mb-0 small">{event.time}</p>
                                </div>
                              ))}
                            </div>
                          ) : (
                            <p className="text-muted small mb-0">Tidak ada agenda pada tanggal ini.</p>
                          )}
                        </div>
                      </>
                    )}
                  </div>
                </div>
              </div>
            ) : (
              <div className="card border-0 shadow rounded-4">
                {(loadingAgenda || loadingPengumuman) ? (
                  <div className="text-center p-4"><p className="text-muted">Memuat pengumuman...</p></div>
                ) : errorPengumuman ? (
                  <div className="text-center p-4"><p className="text-danger">{errorPengumuman}</p></div>
                ) : announcementData.length > 0 ? (
                  <>
                    {announcementData.map((a) => (
                      <div
                        key={a.id}
                        onClick={() => setSelectedAnnouncement(a)} 
                        className="p-3 border-bottom hover-bg-light cursor-pointer" 
                        style={{ cursor: 'pointer', transition: 'background 0.2s' }}
                        onMouseEnter={(e) => (e.currentTarget.style.backgroundColor = '#f8f9fa')}
                        onMouseLeave={(e) => (e.currentTarget.style.backgroundColor = 'transparent')}
                      >
                        <div className="d-flex justify-content-between align-items-start">
                          <div className="d-flex align-items-center gap-2">
                            <div>
                              <h6 className="mb-0 fw-semibold">{a.title}</h6>
                              {a.content && (
                                <small className="text-muted d-block mt-1">
                                  {a.content.replace(/<[^>]*>/g, '').substring(0, 100)}...
                                </small>
                              )}
                            </div>
                          </div>
                          <span className="fw-bold text-blue small text-nowrap ms-2">
                            {a.date}
                          </span>
                        </div>
                      </div>
                    ))}
                  </>
                ) : (
                  <div className="text-center p-4">
                    <p className="text-muted">Tidak ada pengumuman.</p>
                  </div>
                )}
              </div>
            )}
          </div>
        </div>
      </div>
    </div>
  );
}