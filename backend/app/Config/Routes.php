<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// =========================================================================
// AUTHENTICATION & DASHBOARD
// =========================================================================
$routes->get('/', 'backend\AuthController::index');
$routes->get('/login', 'backend\AuthController::index');
$routes->post('/login', 'backend\AuthController::login');
$routes->get('/logout', 'backend\AuthController::logout');

$routes->get('/dashboard', 'backend\DashboardController::index');

// =========================================================================
// RESOURCE ROUTES (BACKEND & FRONTEND)
// =========================================================================

// Pejabat
$routes->resource('pejabat', ['controller' => 'frontend\PejabatController', 'except' => ['show']]);
$routes->post('pejabat/toggle-status', 'frontend\PejabatController::toggleStatus');

// Berita Kategori Tema
$routes->resource('tema', ['controller' => 'backend\TemaKategoriController', 'except' => ['show']]);
$routes->post('tema/toggle-status', 'backend\TemaKategoriController::toggleStatus');

// User Management
$routes->resource('manage_user', ['controller' => 'backend\UserController']);

// Kategori Berita
$routes->resource('kategori_berita', ['controller' => 'backend\KategoriBeritaController']);
$routes->post('kategori_berita/toggle-status', 'backend\KategoriBeritaController::toggleStatus');



// Program
$routes->resource('program', ['controller' => 'frontend\ProgramController', 'except' => ['show']]);
$routes->post('program/toggle-status', 'frontend\ProgramController::toggleStatus');

// Profile Menu
$routes->resource('menu_profile', ['controller' => 'frontend\ProfileController', 'except' => ['show']]);
$routes->post('menu_profile/toggle-status', 'frontend\ProfileController::toggleStatus');

// Agenda
$routes->resource('agenda', ['controller' => 'backend\AgendaController','except' => ['show']]);
$routes->post('agenda/toggle-status', 'backend\AgendaController::toggleStatus');
$routes->post('agenda/delete/(:num)', 'backend\AgendaController::delete/$1');

// Profile (Backend)
$routes->resource('profile', ['controller' => 'backend\ProfileController', 'except' => ['show']]);
$routes->post('profile/toggle-status', 'backend\ProfileController::toggleStatus');

// Kategori (General)
$routes->resource('kategori', ['controller' => 'backend\KategoriController', 'except' => ['show']]);
$routes->get('kategori/trash', 'backend\KategoriController::trash');
$routes->get('kategori/(:num)/restore', 'backend\KategoriController::restore/$1');
$routes->post('kategori/(:num)/destroyPermanent', 'backend\KategoriController::destroyPermanent/$1');
$routes->post('kategori/toggle-status', 'backend\KategoriController::toggleStatus');


// =========================================================================
// ROUTE FRONTEND SPECIFIC
// =========================================================================

// Catatan: Jika 'Kontak' di atas sudah mencakup layanan & social, 
// route resource 'kontak_layanan' & 'kontak_social' dibawah ini mungkin redundan.
// Namun biarkan aktif jika masih dipakai oleh API atau halaman lain.

//kontak
$routes->resource('kontak', ['controller' => 'frontend\KontakController', 'except' => ['show']]);
$routes->post('kontak/toggle-status', 'frontend\KontakController::toggleStatus');
// Kontak Layanan
$routes->resource('kontak_layanan', ['controller' => 'frontend\KontakLayananController', 'except' => ['show']]);
$routes->post('kontak_layanan/toggle-status', 'frontend\KontakLayananController::toggleStatus');

// Kontak Social
$routes->resource('kontak_social', ['controller' => 'frontend\KontakSocialController', 'except' => ['show']]);
$routes->post('kontak_social/toggle-status', 'frontend\KontakSocialController::toggleStatus');

// Footer OPD
$routes->resource('footer_opd', ['controller' => 'frontend\FooterOpdController', 'except' => ['show']]);
$routes->post('footer_opd/toggle-status', 'frontend\FooterOpdController::toggleStatus');
$routes->get('footer_opd/cekinfo', 'frontend\FooterOpdController::cekinfo');

// Footer Social
$routes->resource('footer_social', ['controller' => 'frontend\FooterSocialController', 'except' => ['show']]);
$routes->post('footer_social/toggle-status', 'frontend\FooterSocialController::toggleStatus');

// Footer Statistics
$routes->resource('footer_statistics', ['controller' => 'frontend\FooterStatisticsController', 'except' => ['show']]);
$routes->post('footer_statistics/toggle-status', 'frontend\FooterStatisticsController::toggleStatus');

// Home Service
$routes->resource('home_service', ['controller' => 'frontend\HomeServiceController', 'except' => ['show']]);
$routes->post('home_service/toggle-status', 'frontend\HomeServiceController::toggleStatus');

// Home Video 
$routes->resource('home_video_layanan', ['controller' => 'frontend\HomeVideoLayananController', 'except' => ['show']]);
$routes->post('home_video_layanan/toggle-status', 'frontend\HomeVideoLayananController::toggleStatus');

// Profil Tentang
$routes->resource('profil_tentang', ['controller' => 'frontend\ProfilTentangController', 'except' => ['show']]); 
$routes->post('profil_tentang/toggle-status', 'frontend\ProfilTentangController::toggleStatus');   

// Tugas Fungsi
$routes->resource('tugas_fungsi', ['controller' => 'frontend\TugasFungsiController', 'except' => ['show']]);
$routes->post('tugas_fungsi/toggle-status', 'frontend\TugasFungsiController::toggleStatus');

// Struktur Organisasi
$routes->resource('struktur_organisasi', ['controller' => 'frontend\StrukturOrganisasiController', 'except' => ['show']]);
$routes->post('struktur_organisasi/toggle-status', 'frontend\StrukturOrganisasiController::toggleStatus');

// Pejabat Struktural
$routes->resource('pejabat_struktural', ['controller' => 'frontend\PejabatStrukturalController', 'except' => ['show']]);
$routes->post('pejabat_struktural/toggle-status', 'frontend\PejabatStrukturalController::toggleStatus');

// Informasi Perencanaan
$routes->resource('informasi_perencanaan', ['controller' => 'frontend\InformasiPerencanaanController', 'except' => ['show']]);
$routes->post('informasi_perencanaan/toggle-status', 'frontend\InformasiPerencanaanController::toggleStatus');

// Laporan Keuangan
$routes->resource('laporan_keuangan', ['controller' => 'frontend\LaporanKeuanganController', 'except' => ['show']]);
$routes->post('laporan_keuangan/toggle-status', 'frontend\LaporanKeuanganController::toggleStatus');

// Daftar Informasi Publik
$routes->resource('daftar_informasi_publik', ['controller' => 'frontend\DaftarInformasiPublikController', 'except' => ['show']]);
$routes->post('daftar_informasi_publik/toggle-status', 'frontend\DaftarInformasiPublikController::toggleStatus');

// Laporan Kinerja
$routes->resource('laporan_kinerja', ['controller' => 'frontend\LaporanKinerjaController', 'except' => ['show']]);
$routes->post('laporan_kinerja/toggle-status', 'frontend\LaporanKinerjaController::toggleStatus');

// Permohonan Informasi
$routes->resource('permohonan_informasi', ['controller' => 'frontend\PermohonanInformasiController', 'except' => ['show']]);
$routes->post('permohonan_informasi/toggle-status', 'frontend\PermohonanInformasiController::toggleStatus');

// IP Penyedia & Swakelola
$routes->resource('ip_penyedia', ['controller' => 'frontend\IpPenyediaController', 'except' => ['show']]);
$routes->post('ip_penyedia/toggle-status', 'frontend\IpPenyediaController::toggleStatus');
$routes->resource('ip_swakelola', ['controller' => 'frontend\IpSwakelolaController', 'except' => ['show']]);
$routes->post('ip_swakelola/toggle-status', 'frontend\IpSwakelolaController::toggleStatus');

// PPID Permohonan
$routes->resource('ppid_permohonan', ['controller' => 'frontend\PpidPermohonanController', 'except' => ['show']]);
$routes->post('ppid_permohonan/toggle-status', 'frontend\PpidPermohonanController::toggleStatus');

// Agenda Pelatihan
$routes->resource('agenda_pelatihan', ['controller' => 'frontend\AgendaPelatihanController', 'except' => ['show']]);
$routes->post('agenda_pelatihan/toggle-status', 'frontend\AgendaPelatihanController::toggleStatus');

// IP Kerjasama Daerah
$routes->resource('ip_kerjasama_daerah', ['controller' => 'frontend\IpKerjasamaDaerahController', 'except' => ['show']]);
$routes->post('ip_kerjasama_daerah/toggle-status', 'frontend\IpKerjasamaDaerahController::toggleStatus');

// Pengumuman
$routes->resource('pengumuman', ['controller' => 'frontend\PengumumanController','except' => ['new', 'show'] ]);
$routes->post('pengumuman/toggle-status', 'frontend\PengumumanController::toggleStatus');


// Pastikan namespace mengarah ke folder 'frontend'
$routes->group('footer_opd', ['namespace' => 'App\Controllers\frontend'], function($routes) {
    
    // Halaman Utama
    $routes->get('/', 'FooterOpdController::index');
    
    // AJAX Switch Status
    $routes->post('toggle_status', 'FooterOpdController::toggleStatus');

    // --------------------------------------------------------
    // TAB 1: IDENTITAS OPD
    // --------------------------------------------------------
    // Perhatikan nama method: createOpd, updateOpd, deleteOpd
    $routes->post('createOpd', 'FooterOpdController::createOpd');
    $routes->put('updateOpd/(:num)', 'FooterOpdController::updateOpd/$1');
    $routes->delete('deleteOpd/(:num)', 'FooterOpdController::deleteOpd/$1');

    // --------------------------------------------------------
    // TAB 2: SOCIAL MEDIA
    // --------------------------------------------------------
    $routes->post('createSocial', 'FooterOpdController::createSocial');
    $routes->put('updateSocial/(:num)', 'FooterOpdController::updateSocial/$1');
    $routes->delete('deleteSocial/(:num)', 'FooterOpdController::deleteSocial/$1');

    // --------------------------------------------------------
    // TAB 3: STATISTICS
    // --------------------------------------------------------
    $routes->post('createStats', 'FooterOpdController::createStats');
    $routes->put('updateStats/(:num)', 'FooterOpdController::updateStats/$1');
    $routes->delete('deleteStats/(:num)', 'FooterOpdController::deleteStats/$1');
});

// =========================================================================
// BERITA & DOKUMEN (BACKEND)
// =========================================================================

// Berita Tag
$routes->resource('berita_tag', ['controller' => 'backend\BeritaTagController', 'except' => ['show']]);
$routes->post('berita_tag/toggle-status', 'backend\BeritaTagController::toggleStatus');

// Dokumen Kategori & Dokumen
$routes->resource('dokument_kategori', ['controller' => 'backend\DokumenKategoriController', 'except' => ['show']]);
$routes->post('dokument_kategori/toggle-status', 'backend\DokumenKategoriController::toggleStatus');
$routes->resource('dokument', ['controller' => 'backend\DokumenController', 'except' => ['show']]);
$routes->post('dokument/toggle-status', 'backend\DokumenController::toggleStatus');

// Berita Custom Routes
$routes->get('berita', 'backend\BeritaController::index');
$routes->get('berita/show/(:segment)', 'backend\BeritaController::show/$1');
$routes->put('berita/(:num)', 'backend\BeritaController::update/$1');
$routes->get('berita/new', 'backend\BeritaController::new');
$routes->post('berita', 'backend\BeritaController::create');
$routes->get('berita/(:num)/edit', 'backend\BeritaController::edit/$1');
$routes->post('berita/(:num)/update', 'backend\BeritaController::update/$1');
$routes->post('berita/(:num)/delete', 'backend\BeritaController::delete/$1'); 
$routes->post('berita/(:num)/destroyPermanent', 'backend\BeritaController::destroyPermanent/$1');
$routes->get('berita/trash', 'backend\BeritaController::trash');
$routes->post('berita/(:num)/restore', 'backend\BeritaController::restore/$1');
$routes->get('/berita/(:num)/log/', 'backend\BeritaController::log/$1');
$routes->post('berita/toggle-status', 'backend\BeritaController::toggleStatus');

// Berita Utama
$routes->resource('berita-utama', ['controller' => 'backend\BeritaUtamaController', 'except' => ['show']]);
$routes->post('berita-utama/toggle-status', 'backend\BeritaUtamaController::toggleStatus');

// Album & Gallery
$routes->resource('album', ['controller' => 'backend\PhotoAlbumController', 'except' => ['']]);
$routes->get('album/get-photos/(:num)', 'backend\PhotoAlbumController::get_photos/$1');
$routes->post('album/upload_store', 'backend\PhotoAlbumController::upload_store');
$routes->post('album/toggle-status', 'backend\PhotoAlbumController::toggleStatus');
$routes->get('album/(:num)', 'backend\PhotoAlbumController::show/$1');
$routes->post('album/store', 'backend\PhotoAlbumController::store');
$routes->post('photo/toggle/(:num)', 'backend\PhotoGalleryController::toggle/$1');
$routes->delete('photo/delete/(:num)', 'backend\PhotoAlbumController::deletePhoto/$1');

$routes->resource('gallery', ['controller' => 'backend\PhotoGalleryController', 'except' => ['show']]);
$routes->post('gallery/toggle-status', 'backend\PhotoGalleryController::toggleStatus');

// Banner
$routes->resource('banner', ['controller' => 'backend\BannerController', 'except' => ['show']]);
$routes->get('banner/view/(:num)', 'backend\BannerController::view/$1');
$routes->post('banner/toggle-status', 'backend\BannerController::toggleStatus');
$routes->get('banner/click/(:num)', 'backend\BannerController::click/$1');

// Menu
$routes->resource('menu', ['controller' => 'backend\MenuController']);
$routes->get('menu/toggleStatus/(:num)', 'backend\MenuController::toggleStatus/$1');
$routes->post('menu/toggleStatus/(:num)', 'backend\MenuController::toggleStatus/$1');
$routes->get('menu/edit/(:num)', 'backend\MenuController::edit/$1');
$routes->get('menu/(:num)/edit', 'backend\MenuController::edit/$1');

// Hak Akses
$routes->get('access_rights', 'backend\AccessRightsController::index', ['filter' => 'roleauth:superadmin']);
$routes->get('access_rights/edit/(:num)', 'backend\AccessRightsController::edit/$1', ['filter' => 'roleauth:superadmin']);
$routes->put('access_rights/update/(:num)', 'backend\AccessRightsController::update/$1', ['filter' => 'roleauth:superadmin']);
$routes->post('access_rights/store', 'backend\AccessRightsController::store');
$routes->put('access_rights/update/(:num)', 'backend\AccessRightsController::update/$1');

// =========================================================================
// INFORMASI PUBLIK (DOCUMENT FOLDER STRUCTURE)
// =========================================================================
$routes->get('informasi-publik/(:segment)', 'Frontend\DocumentController::index/$1');

// Folder
$routes->get('informasi-publik/(:segment)/folder/create', 'Frontend\DocumentController::create/$1');
$routes->post('informasi-publik/(:segment)/folder/store', 'Frontend\DocumentController::store/$1');

// Dokumen Item
$routes->get('informasi-publik/(:segment)/dokumen/create/(:any)', 'Frontend\DocumentController::createDokumen/$1/$2');
$routes->post('informasi-publik/(:segment)/dokumen/store/(:any)', 'Frontend\DocumentController::storeDokumen/$1/$2');
$routes->get('informasi-publik/(:segment)/edit/(:num)', 'Frontend\DocumentController::edit/$1/$2');
$routes->post('informasi-publik/(:segment)/update/(:num)', 'Frontend\DocumentController::update/$1/$2');
$routes->get('informasi-publik/(:segment)/delete/(:num)', 'Frontend\DocumentController::delete/$1/$2');
$routes->get('informasi-publik/(:segment)/folder/delete/(:any)', 'Frontend\DocumentController::deleteFolder/$1/$2');

// =========================================================================
// API ROUTES
// =========================================================================
$routes->group('api', function ($routes) {

    // Umum
    $routes->get('pengumuman', 'Api\ApiPengumumanController::index');
    $routes->get('pengumuman/(:num)', 'Api\ApiPengumumanController::show/$1');
    $routes->get('tugasfungsi', 'Api\ApiTugasFungsiController::index');
    $routes->get('tugasfungsi/(:num)', 'Api\ApiTugasFungsiController::show/$1');
    $routes->get('ip_kerjasama_daerah', 'Api\ApiIpKerjasamaDaerahController::index');
    $routes->get('ip_kerjasama_daerah/(:num)', 'Api\ApiIpKerjasamaDaerahController::show/$1');
    $routes->get('agenda_pelatihan', 'Api\ApiAgendaPelatihanController::index');
    $routes->get('agenda_pelatihan/(:num)', 'Api\ApiAgendaPelatihanController::show/$1');
    $routes->post('ppid_permohonan', 'Api\ApiPpidPermohonanController::create');
    $routes->get('ppid_permohonan/status/(:segment)', 'Api\ApiPpidPermohonanController::checkStatus/$1');
    $routes->get('ip_swakelola', 'Api\ApiIpSwakelolaController::index');
    $routes->get('ip_swakelola/(:num)', 'Api\ApiIpSwakelolaController::show/$1');
    $routes->get('ip_penyedia', 'Api\ApiIpPenyediaController::index');
    $routes->get('ip_penyedia/(:num)', 'Api\ApiIpPenyediaController::show/$1');
    $routes->get('permohonan_informasi', 'Api\ApiPermohonanInformasiController::index');
    $routes->get('permohonan_informasi/(:num)', 'Api\ApiPermohonanInformasiController::show/$1');
    $routes->get('laporan_kinerja', 'Api\ApiLaporanKinerjaController::index');
    $routes->get('laporan_kinerja/(:num)', 'Api\ApiLaporanKinerjaController::show/$1');
    $routes->get('daftar_informasi_publik', 'Api\ApidaftarInformasiPublikController::index');
    $routes->get('daftar_informasi_publik/(:num)', 'Api\ApidaftarInformasiPublikController::show/$1');
    $routes->get('laporan_keuangan', 'Api\ApiLaporanKeuanganController::index');
    $routes->get('laporan_keuangan/(:num)', 'Api\ApiLaporanKeuanganController::show/$1');
    $routes->get('informasi_perencanaan', 'Api\ApiInformasiPerencanaanController::index');
    $routes->get('informasi_perencanaan/(:num)', 'Api\ApiInformasiPerencanaanController::show/$1');
    $routes->get('pejabat_struktural', 'Api\ApiPejabatStrukturalController::index');
    $routes->get('pejabat_struktural/(:num)', 'Api\ApiPejabatStrukturalController::show/$1');
    $routes->get('struktur_organisasi', 'Api\ApiStrukturOrganisasiController::index');
    $routes->get('struktur_organisasi/(:segment)', 'Api\ApiStrukturOrganisasiController::show/$1');
    $routes->get('profil_tentang', 'Api\ApiProfilTentangController::index');
    $routes->get('profil_tentang/(:num)', 'Api\ApiProfilTentangController::show/$1');
    $routes->get('home_video_layanan', 'Api\ApiHomeVideoLayananController::index');
    $routes->get('home_video_layanan/(:num)', 'Api\ApiHomeVideoLayananController::show/$1');
    $routes->get('home_service', 'Api\ApiHomeServiceController::index');
    $routes->get('home_service/(:num)', 'Api\ApiHomeServiceController::show/$1');
    $routes->get('footer_statistics', 'Api\ApiFooterStatisticsController::index');
    $routes->get('footer_social', 'Api\ApiFooterSocialController::index');
    $routes->get('footer_social/(:num)', 'Api\ApiFooterSocialController::show/$1');
    $routes->get('footer_opd', 'Api\ApiFooterOpdController::index');
    $routes->get('footer_opd/(:num)', 'Api\ApiFooterOpdController::show/$1');
    $routes->get('program', 'Api\ApiProgramController::index');
    $routes->get('program/(:segment)', 'Api\ApiProgramController::show/$1');
    

    // Kontak API
    $routes->get('kontak', 'Api\ApiKontakController::index');
    $routes->get('kontak/(:num)', 'Api\ApiKontakController::show/$1');
    $routes->get('kontak_social', 'Api\ApiKontakSocialController::index');
    $routes->get('kontak_social/(:num)', 'Api\ApiKontakSocialController::show/$1');
    $routes->get('kontak_layanan', 'Api\ApiKontakLayananController::index');
    $routes->get('kontak_layanan/(:num)', 'Api\ApiKontakLayananController::show/$1');

    // Profile & Pejabat
    $routes->get('profile', 'Api\ApiProfileController::index');
    $routes->get('profile/(:segment)', 'Api\ApiProfileController::show/$1');
    $routes->get('pejabat', 'Api\ApiPejabatController::index');
    $routes->get('pejabat/(:segment)', 'Api\ApiPejabatController::show/$1');

    // Banner & Dokumen
    $routes->get('banner', 'Api\ApiBannerController::index');
    $routes->get('banner/(:num)', 'Api\ApiBannerController::show/$1');
    $routes->get('dokument', 'Api\ApiDokumentController::index');
    $routes->get('dokument/(:num)', 'Api\ApiDokumentController::show/$1');
    $routes->get('informasi-publik', 'Api\ApiDocumentController::listCategories');

    // 1.b. Get List Folder & Dokumen berdasarkan Slug Kategori
    // Ini menangani: GET api/informasi-publik/transparansi-anggaran
    $routes->get('informasi-publik/(:segment)', 'Api\ApiDocumentController::index/$1');
    
    // 2. Create Folder Baru
    $routes->post('informasi-publik/(:segment)/folder', 'Api\ApiDocumentController::storeFolder/$1');
    
    // 3. Upload Dokumen
    $routes->post('informasi-publik/(:segment)/(:segment)', 'Api\ApiDocumentController::storeDokumen/$1/$2');
    
    // 4. Update Dokumen
    $routes->post('informasi-publik/(:segment)/(:num)/update', 'Api\ApiDocumentController::update/$1/$2');
    
    // 5. Delete Dokumen
    $routes->delete('informasi-publik/(:segment)/(:num)', 'Api\ApiDocumentController::delete/$1/$2');
    
    // Berita
    $routes->get('berita', 'Api\ApiBeritaController::index');
    $routes->get('berita/(:segment)', 'Api\ApiBeritaController::show/$1');
    $routes->get('berita/tag/(:segment)', 'Api\ApiBeritaController::getByTag/$1');
    $routes->get('berita/kategori/(:segment)', 'Api\ApiBeritaController::getByKategori/$1');
    $routes->get('berita/popular/tags', 'Api\BeritaController::popularTags');
    $routes->get('berita/popular/tags/(:num)', 'Api\BeritaController::popularTags/$1');


    // Photo & Album
    $routes->get('album', 'Api\ApiPhotoAlbumController::index');
    $routes->get('album/(:num)', 'Api\ApiPhotoAlbumController::show/$1');
    $routes->get('gallery', 'Api\ApiPhotoGalleryController::index');
    $routes->get('gallery/(:num)', 'Api\ApiPhotoGalleryController::show/$1');
    $routes->get('gallery/album/(:num)', 'Api\ApiPhotoGalleryController::byAlbum/$1');

    // Agenda
    $routes->get('agenda', 'Api\ApiAgendaController::index');   
    $routes->post('agenda', 'Api\ApiAgendaController::create');
    $routes->get('agenda/(:num)', 'Api\ApiAgendaController::show/$1');

    // Auth & Users
    $routes->post('login', 'Api\AuthController::login');
    $routes->post('register', 'Api\AuthController::register');
    $routes->get('user/permissions', 'Api\AuthController::getUserPermissions');

    $routes->resource('users', ['controller' => 'Api\UserController']);
    $routes->resource('kategori_berita', ['controller' => 'Api\KategoriBeritaController']);
    $routes->resource('berita', ['controller' => 'Api\BeritaController']);
    $routes->resource('galeri_foto', ['controller' => 'Api\GaleriFotoController']);
    $routes->resource('menu', ['controller' => 'Api\MenuController']);

    // Admin API
    $routes->group('admin', function($routes) {
        $routes->resource('hak_akses', ['controller' => 'Api\Admin\HakAksesController']);
    });

    // CORS options
    $routes->options('(:any)', 'Home::option');
});