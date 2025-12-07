import { useState, useEffect } from "react";
import { Triangle, Calendar, Bell, Image } from "lucide-react";
import "./Agenda.css";
import api from "../../../services/api";

interface AnnouncementItem {
  id: number;
  title: string;
  date: string;
}

interface ApiAgendaItem {
  id_agenda: string;
  activity_name: string;
  description: string;
  start_date: string;
  end_date: string;
  location: string;
  image: string;
  status: string;
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

  // Format date untuk pengumuman (tanpa waktu)
  const formatAnnouncementDate = (dateString: string) => {
    const options: Intl.DateTimeFormatOptions = {
      day: "numeric",
      month: "long",
      year: "numeric",
    };
    return new Date(dateString).toLocaleDateString("id-ID", options);
  };

  // Generate data pengumuman dari agenda
  const announcementData: AnnouncementItem[] = agendaData
    .filter(
      (agenda) => agenda.status === "active" || agenda.status === "published"
    )
    .map((agenda, index) => ({
      id: index + 1,
      title: agenda.activity_name,
      date: formatAnnouncementDate(agenda.start_date),
    }))
    .slice(0, 7); // Ambil maksimal 7 pengumuman

  // Fetch Berita Utama dari API
  useEffect(() => {
    const fetchBerita = async () => {
      try {
        setLoadingBerita(true);
        const res = await api.get("/berita");
        const data = res?.data?.data;

        if (!data) {
          setErrorBerita("Data berita tidak ditemukan");
          return;
        }

        const utamaArray: BeritaUtamaItem[] = data.utama || [];
        const beritaUtamaDetailList: BeritaItem[] = [];

        if (utamaArray.length > 0) {
          for (const utamaItem of utamaArray) {
            const idUtama = utamaItem.id_berita;

            const foundInList = data.berita?.find(
              (item: BeritaItem) => item.id_berita === idUtama
            );

            if (foundInList) {
              beritaUtamaDetailList.push(foundInList);
            } else {
              try {
                const detailRes = await api.get(`/berita/${idUtama}`);
                const detailData = detailRes?.data?.data;
                if (detailData) {
                  beritaUtamaDetailList.push(detailData);
                }
              } catch (fetchError) {
                console.error(
                  `Gagal mengambil detail berita utama ${idUtama}:`,
                  fetchError
                );
              }
            }
          }
        }

        setBeritaUtamaList(beritaUtamaDetailList);
      } catch (error) {
        console.error("Gagal fetch berita:", error);
        setErrorBerita("Gagal memuat data berita");
      } finally {
        setLoadingBerita(false);
      }
    };

    fetchBerita();
  }, []);

  // Fetch agenda data from API
  useEffect(() => {
    const fetchAgenda = async () => {
      try {
        setLoadingAgenda(true);
        const res = await api.get("/agenda");
        const json = res?.data;

        if (json.status && Array.isArray(json.data)) {
          const eventsMap: Record<number, CalendarEvent[]> = {};
          const agendaList: ApiAgendaItem[] = json.data;

          // Simpan data agenda untuk digunakan di pengumuman
          setAgendaData(agendaList);

          agendaList.forEach((item: ApiAgendaItem) => {
            const start = new Date(item.start_date);
            const day = start.getDate();

            if (
              start.getMonth() + 1 === currentMonth &&
              start.getFullYear() === currentYear
            ) {
              if (!eventsMap[day]) {
                eventsMap[day] = [];
              }

              eventsMap[day].push({
                date: day,
                title: item.activity_name,
                time: start.toLocaleTimeString("id-ID", {
                  hour: "2-digit",
                  minute: "2-digit",
                }),
                image: item.image,
              });
            }
          });

          setCalendarEvents(eventsMap);
        } else {
          setErrorAgenda("Format data tidak sesuai.");
        }
      } catch (error) {
        console.error(error);
        setErrorAgenda("Gagal memuat data agenda.");
      } finally {
        setLoadingAgenda(false);
      }
    };

    fetchAgenda();
  }, [currentMonth, currentYear]);

  const getDaysInMonth = (month: number, year: number) =>
    new Date(year, month, 0).getDate();
  const getFirstDayOfMonth = (month: number, year: number) =>
    new Date(year, month - 1, 1).getDay();

  const monthNames = [
    "Januari",
    "Februari",
    "Maret",
    "April",
    "Mei",
    "Juni",
    "Juli",
    "Agustus",
    "September",
    "Oktober",
    "November",
    "Desember",
  ];
  const dayNames = ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"];

  const daysInMonth = getDaysInMonth(currentMonth, currentYear);
  const firstDay = getFirstDayOfMonth(currentMonth, currentYear);
  const days = Array(firstDay)
    .fill(null)
    .concat(Array.from({ length: daysInMonth }, (_, i) => i + 1));

  const handlePrevMonth = () => {
    if (currentMonth === 1) {
      setCurrentMonth(12);
      setCurrentYear(currentYear - 1);
    } else setCurrentMonth(currentMonth - 1);
  };

  const handleNextMonth = () => {
    if (currentMonth === 12) {
      setCurrentMonth(1);
      setCurrentYear(currentYear + 1);
    } else setCurrentMonth(currentMonth + 1);
  };

  const selectedEvents = selectedDate ? calendarEvents[selectedDate] ?? [] : [];
  const firstEvent = selectedEvents[0];

  const currentNews = beritaUtamaList[currentNewsIndex];

  return (
    <div className="container-fluid py-5">
      <div className="container">
        <div className="row g-4 align-items-stretch">
          {/* News Section */}
          <div className="col">
            <h1 className="fw-bold text-blue mb-3">Berita Utama</h1>
            <div className="card border-0 shadow news-card position-relative rounded-4 overflow-hidden">
              {loadingBerita ? (
                <div className="text-center p-5">
                  <p className="text-muted">Memuat berita utama...</p>
                </div>
              ) : errorBerita ? (
                <div className="text-center p-5">
                  <p className="text-danger">{errorBerita}</p>
                </div>
              ) : beritaUtamaList.length > 0 && currentNews ? (
                <>
                  <div className="news-image-container">
                    {currentNews.feat_image ? (
                      <img
                        src={`${ROOT}/${currentNews.feat_image.replace(
                          /^\/+/,
                          ""
                        )}`}
                        className="img-fluid w-100 h-100 object-fit-cover"
                        alt={currentNews.judul}
                      />
                    ) : (
                      <div
                        className="d-flex justify-content-center align-items-center bg-primary text-white"
                        style={{ height: "200px" }}
                      >
                        <Image size={60} />
                      </div>
                    )}
                  </div>
                  <div className="card-body text-dark d-flex flex-column">
                    <p className="fw-bold text-blue mb-2">BERITA UTAMA</p>
                    <p className="small">{currentNews.judul}</p>
                    <div className="mt-auto pt-3 border-top">
                      <small className="text-muted d-block">
                        Sumber: Dinas Komunikasi dan Informatika Kota Tangerang
                      </small>
                      <small className="text-secondary">
                        {formatDate(currentNews.created_at)}
                      </small>
                    </div>
                  </div>
                  <div className="d-flex justify-content-center gap-2 pb-3">
                    {beritaUtamaList.map((_, i) => (
                      <button
                        key={i}
                        onClick={() => setCurrentNewsIndex(i)}
                        className={`indicator ${
                          i === currentNewsIndex ? "active" : ""
                        }`}
                      />
                    ))}
                  </div>
                </>
              ) : (
                <div className="text-center p-5">
                  <p className="text-muted">Tidak ada berita utama.</p>
                </div>
              )}
            </div>
          </div>

          {/* Right Tabs */}
          <div className="col-lg-8">
            <div className="d-flex flex-wrap gap-3 mb-3">
              <button
                onClick={() => setActiveTab("agenda")}
                className={`btn tab-btn ${
                  activeTab === "agenda" ? "active" : ""
                }`}
              >
                <Calendar size={18} className="me-2" /> Agenda
              </button>
              <button
                onClick={() => setActiveTab("pengumuman")}
                className={`btn tab-btn ${
                  activeTab === "pengumuman" ? "active" : ""
                }`}
              >
                <Bell size={18} className="me-2" /> Pengumuman
              </button>
            </div>

            {activeTab === "agenda" ? (
              <div className="card border-0 shadow rounded-4 bg-light overflow-hidden">
                <div className="row g-0 h-100">
                  <div className="col-md-5 d-flex ">
                    <img
                      src={
                        firstEvent?.image
                          ? `${ROOT}/uploads/agenda/${firstEvent.image}`
                          : "assets/agenda-default.jpg"
                      }
                      alt={firstEvent?.title || "Belum Ada Agenda"}
                      className="img-fluid h-100 object-fit-cover rounded-start-4"
                    />
                  </div>

                  <div className="col-md-7 p-4 d-flex flex-column calender-container">
                    <div className="d-flex justify-content-center align-items-center mb-3">
                      <button onClick={handlePrevMonth} className="btn">
                        <Triangle
                          size={18}
                          fill="black"
                          style={{ transform: "rotate(-90deg)" }}
                        />
                      </button>
                      <span className="fw-bold text-blue">
                        {monthNames[currentMonth - 1]} {currentYear}
                      </span>
                      <button onClick={handleNextMonth} className="btn">
                        <Triangle
                          size={18}
                          fill="black"
                          style={{ transform: "rotate(90deg)" }}
                        />
                      </button>
                    </div>

                    {loadingAgenda ? (
                      <div className="text-center text-muted small my-5">
                        Memuat agenda...
                      </div>
                    ) : errorAgenda ? (
                      <div className="text-center text-danger small my-5">
                        {errorAgenda}
                      </div>
                    ) : (
                      <>
                        <div className="calendar-grid mb-3">
                          {dayNames.map((d) => (
                            <div
                              key={d}
                              className="fw-semibold text-center text-blue small"
                            >
                              {d}
                            </div>
                          ))}
                          {days.map((day, idx) => (
                            <button
                              key={idx}
                              onClick={() => day && setSelectedDate(day)}
                              className={`calendar-day ${(() => {
                                const isToday =
                                  day === today.getDate() &&
                                  currentMonth === today.getMonth() + 1 &&
                                  currentYear === today.getFullYear();
                                if (!day) return "invisible";
                                if (selectedDate === day) return "selected";
                                if (calendarEvents[day as number])
                                  return "event";
                                if (isToday) return "today";
                                return "";
                              })()}`}
                            >
                              {day}
                            </button>
                          ))}
                        </div>

                        <div className="card bg-primary-subtle border-0 rounded-3 p-3 mt-auto">
                          <div className="d-flex align-items-center justify-content-center gap-2 mb-2">
                            <Calendar size={16} className="text-blue" />
                            <h6 className="mb-0 fw-bold text-blue">
                              Agenda Tanggal {selectedDate}
                            </h6>
                          </div>
                          {selectedEvents && selectedEvents.length > 0 ? (
                            <div className="d-flex flex-column gap-2">
                              {selectedEvents.map((event, index) => (
                                <div
                                  key={index}
                                  className="d-flex justify-content-between align-items-center border-bottom pb-1"
                                >
                                  <p className="fw-semibold mb-0 small">
                                    {event.title}
                                  </p>
                                  <p className="fw-bold text-blue mb-0 small">
                                    {event.time}
                                  </p>
                                </div>
                              ))}
                            </div>
                          ) : (
                            <p className="text-muted small mb-0">
                              Tidak ada agenda pada tanggal ini.
                            </p>
                          )}
                        </div>
                      </>
                    )}
                  </div>
                </div>
              </div>
            ) : (
              <div className="card border-0 shadow rounded-4">
                {loadingAgenda ? (
                  <div className="text-center p-4">
                    <p className="text-muted">Memuat pengumuman...</p>
                  </div>
                ) : errorAgenda ? (
                  <div className="text-center p-4">
                    <p className="text-danger">{errorAgenda}</p>
                  </div>
                ) : announcementData.length > 0 ? (
                  announcementData.map((a) => (
                    <div
                      key={a.id}
                      className="p-3 border-bottom hover-bg-light"
                    >
                      <div className="d-flex justify-content-between align-items-start">
                        <div className="d-flex align-items-center gap-2">
                          <div className="dot bg-primary"></div>
                          <h6 className="mb-0 fw-semibold">{a.title}</h6>
                        </div>
                        <span className="fw-bold text-blue small">
                          {a.date}
                        </span>
                      </div>
                    </div>
                  ))
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
