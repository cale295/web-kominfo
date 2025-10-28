import React, { useState } from "react";
import "../css/news.css";
import {
  ChevronLeft,
  ChevronRight,
  Calendar,
  Bell,
  Image as ImageIcon,
} from "lucide-react";

interface AnnouncementItem {
  id: number;
  title: string;
  date: string;
}

interface CalendarEvent {
  date: number;
  title: string;
  time: string;
}

interface NewsItem {
  id: number;
  image: string;
  subtitle: string;
  desc: string;
  source: string;
  date: string;
}

type TabType = "agenda" | "pengumuman";

const newsItems: NewsItem[] = [
  {
    id: 1,
    image: "https://picsum.photos/seed/news1/600/300",
    subtitle: "BERITA TERBARU",
    desc: "Optimalkan Pembangunan Infrastruktur, Pemkot Tangerang Perbaiki 40 Ruas Jalan Kota",
    source: "Dinas Pendidikan Kota Tangerang",
    date: "27 Des 2022",
  },
  {
    id: 2,
    image: "https://picsum.photos/seed/news2/600/300",
    subtitle: "PROYEK BARU",
    desc: "Pemerintah Kota Tangerang Luncurkan Program Jalan Pintar Berbasis Teknologi",
    source: "Dinas PU Kota Tangerang",
    date: "3 Jan 2023",
  },
  {
    id: 3,
    image: "https://picsum.photos/seed/news3/600/300",
    subtitle: "BEASISWA DIBUKA",
    desc: "Pemkot Tangerang Buka Program Beasiswa untuk 1000 Pelajar Berprestasi",
    source: "Dinas Pendidikan Kota Tangerang",
    date: "5 Jan 2023",
  },
];

const calendarEvents: Record<number, CalendarEvent> = {
  16: {
    date: 16,
    title: "Car Free Day dalam rangka World Clean Up Day",
    time: "10.00 WIB",
  },
  17: {
    date: 17,
    title: "Culinary Festival Tangerang",
    time: "14.00 WIB",
  },
  25: {
    date: 25,
    title: "Workshop Kewirausahaan",
    time: "09.00 WIB",
  },
  26: {
    date: 26,
    title: "Pameran Seni Lokal",
    time: "16.00 WIB",
  },
  30: {
    date: 30,
    title: "Pelatihan Digital Marketing",
    time: "13.00 WIB",
  },
};

const announcementData: AnnouncementItem[] = [
  {
    id: 1,
    title: "Pengumuman Hasil Seleksi CPNS 2024",
    date: "12 Agu 2024",
  },
  {
    id: 2,
    title: "Pendaftaran Beasiswa D3 dan S1 Tahun Ajaran 2024/2025",
    date: "10 Agu 2024",
  },
  {
    id: 3,
    title: "Pelatihan Pengelolaan Keuangan Desa",
    date: "8 Agu 2024",
  },
  {
    id: 4,
    title: "Pemeliharaan Jalan Raya Merak - Anyer",
    date: "5 Agu 2024",
  },
  {
    id: 5,
    title: "Pembukaan Posko Pengaduan Lebaran",
    date: "29 Mar 2024",
  },
];

export default function TangerangNewsApp() {
  const today = new Date();
  const [currentNewsIndex, setCurrentNewsIndex] = useState(0);
  const [activeTab, setActiveTab] = useState<TabType>("agenda");
  const [currentMonth, setCurrentMonth] = useState(today.getMonth() + 1);
  const [currentYear, setCurrentYear] = useState(today.getFullYear());
  const [selectedDate, setSelectedDate] = useState<number | null>(
    today.getDate()
  );

  const getDaysInMonth = (month: number, year: number) => {
    return new Date(year, month, 0).getDate();
  };

  const getFirstDayOfMonth = (month: number, year: number) => {
    return new Date(year, month - 1, 1).getDay();
  };

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
    } else {
      setCurrentMonth(currentMonth - 1);
    }
  };

  const handleNextMonth = () => {
    if (currentMonth === 12) {
      setCurrentMonth(1);
      setCurrentYear(currentYear + 1);
    } else {
      setCurrentMonth(currentMonth + 1);
    }
  };

  const selectedEvent = selectedDate ? calendarEvents[selectedDate] : null;
  const currentNews = newsItems[currentNewsIndex];

  return (
    <div className="app-container">
      <div className="container-xl py-4 py-md-5">
        <div className="row g-4">
          {/* Kolom Kiri - Carousel Berita */}
          <div className="col-12 col-lg-4">
            <h1 className="display-6 text-blue-800 mb-4">Berita Terbaru</h1>

            <div className="card bg-blue-100 rounded-4 overflow-hidden shadow-lg text-white">
              <div className="position-relative bg-blue-800" style={{ height: '200px' }}>
                {currentNews.image ? (
                  <img
                    src={currentNews.image}
                    alt={currentNews.subtitle}
                    className="w-100 h-100 object-cover"
                  />
                ) : (
                  <div className="w-100 h-100 d-flex align-items-center justify-content-center">
                    <ImageIcon className="text-blue-300 opacity-50" size={48} />
                  </div>
                )}
              </div>

              <div className="card-body d-flex flex-column p-4">
                <div className="flex-grow-1">
                  <span className="badge bg-blue-600 text-uppercase fs-6 mb-2">{currentNews.subtitle}</span>
                  <h5 className="card-title text-black mb-3">{currentNews.desc}</h5>
                </div>

                <div className="mt-3">
                  <small className="text-slate-500 d-block">Sumber: {currentNews.source}</small>
                  <small className="text-slate-400">{currentNews.date}</small>
                </div>
              </div>

              <div className="d-flex justify-content-center gap-2 p-4">
                {newsItems.map((_, i) => (
                  <button
                    key={i}
                    onClick={() => setCurrentNewsIndex(i)}
                    className={`rounded-circle border-0 p-0 ${i === currentNewsIndex ? 'active' : ''}`}
                    style={{
                      width: '12px',
                      height: '12px',
                      backgroundColor: i === currentNewsIndex ? '#fbbf24' : '#94a3b8',
                    }}
                    aria-label={`Slide ${i + 1}`}
                  />
                ))}
              </div>
            </div>
          </div>

          {/* Kolom Kanan - Tab Agenda & Pengumuman */}
          <div className="col-12 col-lg-8">
            <div className="d-flex flex-column flex-md-row gap-3 mb-4">
              <button
                onClick={() => setActiveTab("agenda")}
                className={`btn rounded-pill px-4 py-2 fw-bold ${activeTab === "agenda" ? 'btn-primary' : 'btn-outline-primary'}`}
              >
                <Calendar className="me-2" size={18} />
                Agenda
              </button>
              <button
                onClick={() => setActiveTab("pengumuman")}
                className={`btn rounded-pill px-4 py-2 fw-bold ${activeTab === "pengumuman" ? 'btn-primary' : 'btn-outline-primary'}`}
              >
                <Bell className="me-2" size={18} />
                Pengumuman
              </button>
            </div>

            {activeTab === "agenda" ? (
              <div className="card rounded-4 shadow-lg">
                <div className="p-4">
                  <div className="d-flex align-items-center justify-content-between mb-4">
                    <button
                      onClick={handlePrevMonth}
                      className="btn btn-sm btn-light rounded-circle"
                    >
                      <ChevronLeft className="text-blue-600" size={18} />
                    </button>
                    <h5 className="fw-bold text-blue-700 mb-0">{monthNames[currentMonth - 1]} {currentYear}</h5>
                    <button
                      onClick={handleNextMonth}
                      className="btn btn-sm btn-light rounded-circle"
                    >
                      <ChevronRight className="text-blue-600" size={18} />
                    </button>
                  </div>

                  <div className="mb-4">
                    <div className="row g-1 text-center text-blue-600 fw-semibold small mb-2">
                      {dayNames.map((day) => (
                        <div key={day} className="col">
                          <div className="py-2">{day}</div>
                        </div>
                      ))}
                    </div>
                    <div className="row g-1">
                      {days.map((day, idx) => {
                        const isToday =
                          day === today.getDate() &&
                          currentMonth === today.getMonth() + 1 &&
                          currentYear === today.getFullYear();
                        const hasEvent = day && calendarEvents[day];
                        const isSelected = day === selectedDate;

                        return (
                          <div key={idx} className="col">
                            <button
                              onClick={() => day && setSelectedDate(day)}
                              className={`btn w-100 py-2 fs-6 rounded-3 ${
                                day === null
                                  ? 'disabled text-muted'
                                  : isSelected
                                    ? 'btn-success text-white'
                                    : hasEvent
                                      ? 'btn-warning text-white'
                                      : isToday
                                        ? 'btn-info text-white'
                                        : 'btn-outline-blue text-blue-600'
                              }`}
                              style={{ minHeight: '40px' }} // Tinggi tetap agar sejajar
                            >
                              {day}
                            </button>
                          </div>
                        );
                      })}
                    </div>
                  </div>

                  <div className="bg-blue-50 rounded-3 p-3 border border-blue-100">
                    <h6 className="fw-bold text-blue-700 mb-2">
                      <Calendar className="me-1" size={16} />
                      Agenda Tanggal {selectedDate}
                    </h6>
                    {selectedEvent ? (
                      <>
                        <p className="mb-1">{selectedEvent.title}</p>
                        <p className="text-blue-600 fw-bold">{selectedEvent.time}</p>
                      </>
                    ) : (
                      <p className="text-muted fst-italic">Tidak ada agenda pada tanggal ini.</p>
                    )}
                  </div>
                </div>
              </div>
            ) : (
              <div className="card rounded-4 shadow-lg">
                <div className="list-group list-group-flush">
                  {announcementData.map((item) => (
                    <div key={item.id} className="list-group-item border-0 px-4 py-3 hover-bg-light transition">
                      <div className="d-flex justify-content-between align-items-start">
                        <div>
                          <h6 className="mb-1">{item.title}</h6>
                        </div>
                        <small className="text-blue-600 fw-bold">{item.date}</small>
                      </div>
                    </div>
                  ))}
                </div>
              </div>
            )}
          </div>
        </div>
      </div>
    </div>
  );
}