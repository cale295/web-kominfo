import React, { useState } from "react";
import {
  ChevronLeft,
  ChevronRight,
  Calendar,
  Bell,
  Image as ImageIcon,
} from "lucide-react"; // Import ImageIcon dari lucide-react

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
  // tag: string; // Dihapus
  // title: string; // Dihapus
  image: string; // Tambah properti image
  subtitle: string;
  desc: string;
  source: string;
  date: string;
}

type TabType = "agenda" | "pengumuman";

// Data untuk newsItems diubah agar tidak ada `tag` dan `title` lagi, diganti `image`
const newsItems: NewsItem[] = [
  {
    id: 1,
    image: "https://picsum.photos/seed/news1/400/200", // Contoh URL gambar
    subtitle: "DIMULAI HARI INI!",
    desc: "Optimalkan Pembangunan Infrastruktur, Pemkot Tangerang Perbaiki 40 Ruas Jalan Kota",
    source: "Dinas Pendidikan Kota Tangerang",
    date: "Selasa, 27 Desember 2022 16:50 WIB",
  },
  {
    id: 2,
    image: "https://picsum.photos/seed/news2/400/200",
    subtitle: "PROYEK BARU DIMULAI!",
    desc: "Pemerintah Kota Tangerang Luncurkan Program Jalan Pintar Berbasis Teknologi",
    source: "Dinas PU Kota Tangerang",
    date: "Rabu, 3 Januari 2023 09:00 WIB",
  },
  {
    id: 3,
    image: "https://picsum.photos/seed/news3/400/200",
    subtitle: "DIBUKA SEKARANG!",
    desc: "Pemkot Tangerang Buka Program Beasiswa untuk 1000 Pelajar Berprestasi",
    source: "Dinas Pendidikan Kota Tangerang",
    date: "Kamis, 5 Januari 2023 08:30 WIB",
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
    title: "Culinary Day lorem ipsum dolor sit amet",
    time: "10.00 WIB",
  },
  25: {
    date: 25,
    title: "Culinary Day lorem ipsum dolor sit amet",
    time: "10.00 WIB",
  },
  26: {
    date: 26,
    title: "Culinary Day lorem ipsum dolor sit amet",
    time: "10.00 WIB",
  },
  30: {
    date: 30,
    title: "Culinary Day lorem ipsum dolor sit amet",
    time: "10.00 WIB",
  },
};

const announcementData: AnnouncementItem[] = [
  {
    id: 1,
    title: "Hotline Aduan Dinas Sosial Kota Tangerang",
    date: "01 September 2025",
  },
  { id: 2, title: "Lowongan Mobile App Programmer", date: "01 September 2025" },
  {
    id: 3,
    title: "Hotline Aduan Dinas Sosial Kota Tangerang",
    date: "01 September 2025",
  },
  { id: 4, title: "Lowongan Mobile App Programmer", date: "01 September 2025" },
  {
    id: 5,
    title: "Hotline Aduan Dinas Sosial Kota Tangerang",
    date: "01 September 2025",
  },
  { id: 6, title: "Lowongan Mobile App Programmer", date: "01 September 2025" },
  {
    id: 7,
    title: "Hotline Aduan Dinas Sosial Kota Tangerang",
    date: "01 September 2025",
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
    <div className="bg-gray-50">
      <div className="max-w-7xl mx-auto px-6 py-12">
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
          {/* Left Section - News Carousel */}
          <div className="lg:col-span-1">
            <h1 className="text-4xl text-blue-800 mb-4">Berita Utama</h1>

            <div className="relative">
              <div className="bg-blue-100 rounded-3xl overflow-hidden shadow-2xl flex flex-col min-h-[500px] text-white">
                {/* Bagian Atas - Image Container */}
                <div className="w-full h-48 md:h-56 overflow-hidden relative bg-blue-800 flex items-center justify-center">
                  {currentNews.image ? (
                    <img
                      src={currentNews.image}
                      alt="News Illustration"
                      className="w-full h-full object-cover"
                    />
                  ) : (
                    <ImageIcon className="w-24 h-24 text-blue-300 opacity-50" />
                  )}
                </div>

                {/* Bagian Konten */}
                <div className="p-6 flex flex-col flex-grow">
                  <div className="flex-grow">
                    {/* Subtitle tetap ada */}
                    <p className="text-blue-800 font-bold text-lg mb-2">
                      {currentNews.subtitle}
                    </p>
                    {/* Desc tetap ada */}
                    <p className="text-black text-sm leading-relaxed">
                      {currentNews.desc}
                    </p>
                  </div>

                  {/* Bagian Bawah/Footer Kartu */}
                  <div className="mt-6 pt-4 border-t border-slate-700">
                    <p className="text-slate-400 text-xs font-medium">
                      Sumber: {currentNews.source}
                    </p>
                    <p className="text-slate-500 text-xs mt-1">
                      {currentNews.date}
                    </p>
                  </div>
                </div>

                {/* Indikator Carousel */}
                <div className="flex justify-center gap-2 p-6 pt-2">
                  {newsItems.map((_, i) => (
                    <button
                      key={i}
                      onClick={() => setCurrentNewsIndex(i)}
                      className={`w-2 h-2 rounded-full transition-all duration-300 ${
                        i === currentNewsIndex
                          ? "bg-yellow-400 w-8"
                          : "bg-slate-600 hover:bg-slate-500"
                      }`}
                    />
                  ))}
                </div>
              </div>
            </div>
          </div>

          {/* Right Section - Tabs */}
          <div className="lg:col-span-2">
            {/* Tab Navigation */}
            <div className="flex gap-4 mb-8">
              <button
                onClick={() => setActiveTab("agenda")}
                className={`group px-8 py-3 rounded-2xl font-bold transition-all duration-300 flex items-center gap-2 ${
                  activeTab === "agenda"
                    ? "bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg scale-105"
                    : "border-2 border-blue-400 text-blue-600 hover:border-blue-500 hover:shadow-md"
                }`}
              >
                <Calendar className="w-5 h-5" />
                Agenda
              </button>
              <button
                onClick={() => setActiveTab("pengumuman")}
                className={`group px-8 py-3 rounded-2xl font-bold transition-all duration-300 flex items-center gap-2 ${
                  activeTab === "pengumuman"
                    ? "bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg scale-105"
                    : "border-2 border-blue-400 text-blue-600 hover:border-blue-500 hover:shadow-md"
                }`}
              >
                <Bell className="w-5 h-5" />
                Pengumuman
              </button>
            </div>

            {activeTab === "agenda" ? (
              // Agenda Tab
              <div className="bg-blue-50 rounded-3xl shadow-xl overflow-hidden flex flex-col md:flex-row">
                <div className="md:w-5/12 p-5">
                  <img
                    src="assets/car free.jpeg"
                    alt="Masjid Raya Al-A'zhom Tangerang"
                    className="w-full h-48 md:h-full rounded-xl object-cover"
                  />
                </div>
                <div className="md:w-7/12 p-6 flex flex-col">
                  <div className="flex items-center justify-between mb-4">
                    <button
                      onClick={handlePrevMonth}
                      className="p-1 hover:bg-blue-100 rounded-full transition-colors"
                    >
                      <ChevronLeft className="w-5 h-5 text-blue-600" />
                    </button>
                    <span className="text-lg font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                      {monthNames[currentMonth - 1]} {currentYear}
                    </span>
                    <button
                      onClick={handleNextMonth}
                      className="p-1 hover:bg-blue-100 rounded-full transition-colors"
                    >
                      <ChevronRight className="w-5 h-5 text-blue-600" />
                    </button>
                  </div>
                  <div className="mb-6">
                    <div className="grid grid-cols-7 gap-1 text-xs font-semibold text-blue-600 mb-2">
                      {dayNames.map((day) => (
                        <div
                          key={day}
                          className="w-full h-8 flex items-center justify-center"
                        >
                          {day}
                        </div>
                      ))}
                    </div>
                    <div className="grid grid-cols-7 gap-1">
                      {days.map((day, idx) => (
                        <button
                          key={idx}
                          onClick={() => day && setSelectedDate(day)}
                          className={`w-full h-8 text-xs flex items-center justify-center rounded-full transition-all duration-200 ${(() => {
                            const isToday =
                              day === today.getDate() &&
                              currentMonth === today.getMonth() + 1 &&
                              currentYear === today.getFullYear();
                            if (day === null) return "";
                            if (selectedDate === day)
                              return "bg-gradient-to-br from-emerald-400 to-teal-500 text-white shadow-md scale-110";
                            if (calendarEvents[day as number])
                              return "bg-gradient-to-br from-yellow-400 to-yellow-500 text-white hover:scale-110";
                            if (isToday)
                              return "bg-blue-200 text-blue-700 font-bold";
                            return "text-gray-600 hover:bg-blue-100";
                          })()}`}
                        >
                          {day}
                        </button>
                      ))}
                    </div>
                  </div>
                  <div className="bg-blue-200 rounded-2xl p-4 border border-blue-100 shadow-sm mt-auto">
                    <div className="flex items-center gap-2 mb-3">
                      <Calendar className="w-4 h-4 text-blue-600" />
                      <h3 className="font-bold text-blue-700 text-sm">
                        Agenda Tanggal {selectedDate}
                      </h3>
                    </div>
                    {selectedEvent ? (
                      <div className="overflow-y-auto max-h-24">
                        <p className="text-gray-800 text-sm font-semibold mb-2">
                          {selectedEvent.title}
                        </p>
                        <p className="text-blue-600 font-bold text-base">
                          {selectedEvent.time}
                        </p>
                      </div>
                    ) : (
                      <p className="text-gray-500 text-sm">
                        Tidak ada agenda pada tanggal ini.
                      </p>
                    )}
                  </div>
                </div>
              </div>
            ) : (
              // Pengumuman Tab
              <div className="bg-white rounded-3xl shadow-xl overflow-hidden">
                <div className="divide-y-2 divide-gray-100">
                  {announcementData.map((item) => (
                    <div
                      key={item.id}
                      className="p-6 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-300 group cursor-pointer"
                    >
                      <div className="flex justify-between items-start gap-4">
                        <div className="flex-1">
                          <div className="flex items-center gap-3 mb-2">
                            <div className="w-2 h-2 rounded-full bg-blue-600 group-hover:scale-150 transition-transform" />
                            <h3 className="font-bold text-gray-800 group-hover:text-blue-700 transition-colors">
                              {item.title}
                            </h3>
                          </div>
                        </div>
                        <span className="text-blue-600 font-bold text-sm whitespace-nowrap">
                          {item.date}
                        </span>
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
