<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'backend\AuthController::index');

// Login & Logout
$routes->get('/login', 'backend\AuthController::index');
$routes->post('/login', 'backend\AuthController::login');
$routes->get('/logout', 'backend\AuthController::logout');

// Dashboard
$routes->get('/dashboard', 'backend\DashboardController::index');

//Pejabat
$routes->resource('pejabat', ['controller' => 'frontend\PejabatController', 'except' => ['show']]);
$routes->post('pejabat/toggle-status', 'frontend\PejabatController::toggleStatus');

// Berita Kategori Tema
$routes->resource('tema', ['controller' => 'backend\TemaKategoriController', 'except' => ['show']]);
$routes->post('tema/toggle-status', 'backend\TemaKategoriController::toggleStatus');

// Resource Web (non-API)
$routes->resource('manage_user', ['controller' => 'backend\UserController']);


// Kategori Berita
$routes->resource('kategori_berita', ['controller' => 'backend\KategoriBeritaController']);
$routes->post('kategori_berita/toggle-status', 'backend\KategoriBeritaController::toggleStatus');

// Kontak
$routes->resource('kontak', ['controller' => 'frontend\KontakController', 'except' => ['show']]);
$routes->post('kontak/toggle-status', 'frontend\KontakController::toggleStatus');

//program
$routes->resource('program', ['controller' => 'frontend\ProgramController', 'except' => ['show']]);
$routes->post('program/toggle-status', 'frontend\ProgramController::toggleStatus');

//profile
$routes->resource('menu_profile', ['controller' => 'frontend\ProfileController', 'except' => ['show']]);
$routes->post('menu_profile/toggle-status', 'frontend\ProfileController::toggleStatus');

// Agenda
$routes->resource('agenda', ['controller' => 'backend\AgendaController','except' => ['show']]);
$routes->post('agenda/toggle-status', 'backend\AgendaController::toggleStatus');

// Profile
$routes->resource('profile', ['controller' => 'backend\ProfileController', 'except' => ['show']]);
$routes->post('profile/toggle-status', 'backend\ProfileController::toggleStatus');

// Kategori
$routes->resource('kategori', ['controller' => 'backend\KategoriController', 'except' => ['show']]);
$routes->get('kategori/trash', 'backend\KategoriController::trash');
$routes->get('kategori/(:num)/restore', 'backend\KategoriController::restore/$1');
$routes->post('kategori/(:num)/destroyPermanent', 'backend\KategoriController::destroyPermanent/$1');
$routes->post('kategori/toggle-status', 'backend\KategoriController::toggleStatus');


//////////////////////////////////////
//route untuk front end controller////
//////////////////////////////////////
//kontak layanan
$routes->resource('kontak_layanan', ['controller' => 'frontend\KontakLayananController', 'except' => ['show']]);
$routes->post('kontak_layanan/toggle-status', 'frontend\KontakLayananController::toggleStatus');
//kontak Social
$routes->resource('kontak_social', ['controller' => 'frontend\KontakSocialController', 'except' => ['show']]);
$routes->post('kontak_social/toggle-status', 'frontend\KontakSocialController::toggleStatus');
//footer opd
$routes->resource('footer_opd', ['controller' => 'frontend\FooterOpdController', 'except' => ['show']]);
$routes->post('footer_opd/toggle-status', 'frontend\FooterOpdController::toggleStatus');
//footer social
$routes->resource('footer_social', ['controller' => 'frontend\FooterSocialController', 'except' => ['show']]);
$routes->post('footer_social/toggle-status', 'frontend\FooterSocialController::toggleStatus');
// footer statistics
$routes->resource('footer_statistics', ['controller' => 'frontend\FooterStatisticsController', 'except' => ['show']]);
$routes->post('footer_statistics/toggle-status', 'frontend\FooterStatisticsController::toggleStatus');
//home service
$routes->resource('home_service', ['controller' => 'frontend\HomeServiceController', 'except' => ['show']]);
$routes->post('home_service/toggle-status', 'frontend\HomeServiceController::toggleStatus');
//home video 
$routes->resource('home_video_layanan', ['controller' => 'frontend\HomeVideoLayananController', 'except' => ['show']]);
$routes->post('home_video_layanan/toggle-status', 'frontend\HomeVideoLayananController::toggleStatus');
// profil tentang
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
// Daftar Informaisi Publik
$routes->resource('daftar_informasi_publik', ['controller' => 'frontend\DaftarInformasiPublikController', 'except' => ['show']]);
$routes->post('daftar_informasi_publik/toggle-status', 'frontend\DaftarInformasiPublikController::toggleStatus');
// Laporan Kinerja
$routes->resource('laporan_kinerja', ['controller' => 'frontend\LaporanKinerjaController', 'except' => ['show']]);
$routes->post('laporan_kinerja/toggle-status', 'frontend\LaporanKinerjaController::toggleStatus');
// Permohonan Informasi
$routes->resource('permohonan_informasi', ['controller' => 'frontend\PermohonanInformasiController', 'except' => ['show']]);
$routes->post('permohonan_informasi/toggle-status', 'frontend\PermohonanInformasiController::toggleStatus');
// Ip Penyedia
$routes->resource('ip_penyedia', ['controller' => 'frontend\IpPenyediaController', 'except' => ['show']]);
$routes->post('ip_penyedia/toggle-status', 'frontend\IpPenyediaController::toggleStatus');
// Ip Swakelola
$routes->resource('ip_swakelola', ['controller' => 'frontend\IpSwakelolaController', 'except' => ['show']]);
$routes->post('ip_swakelola/toggle-status', 'frontend\IpSwakelolaController::toggleStatus');
// Ppid Permohonan
$routes->resource('ppid_permohonan', ['controller' => 'frontend\PpidPermohonanController', 'except' => ['show']]);
$routes->post('ppid_permohonan/toggle-status', 'frontend\PpidPermohonanController::toggleStatus');
// Agenda Pelatihan
$routes->resource('agenda_pelatihan', ['controller' => 'frontend\AgendaPelatihanController', 'except' => ['show']]);
$routes->post('agenda_pelatihan/toggle-status', 'frontend\AgendaPelatihanController::toggleStatus');
// Ip Kerja Sama Daerah
$routes->resource('ip_kerjasama_daerah', ['controller' => 'frontend\IpKerjasamaDaerahController', 'except' => ['show']]);
$routes->post('ip_kerjasama_daerah/toggle-status', 'frontend\IpKerjasamaDaerahController::toggleStatus');


// berita kategori
$routes->resource('berita_tag', ['controller' => 'backend\BeritaTagController', 'except' => ['show']]);
$routes->post('berita_tag/toggle-status', 'backend\BeritaTagController::toggleStatus');

// Dokumen Kategori
$routes->resource('dokument_kategori', ['controller' => 'backend\DokumenKategoriController', 'except' => ['show']]);
$routes->post('dokument_kategori/toggle-status', 'backend\DokumenKategoriController::toggleStatus');

// Dokumen
$routes->resource('dokument', ['controller' => 'backend\DokumenController', 'except' => ['show']]);
$routes->post('dokument/toggle-status', 'backend\DokumenController::toggleStatus');

// ========================================================
// BERITA ROUTES
// ========================================================
$routes->get('berita', 'backend\BeritaController::index');
$routes->get('berita/show/(:segment)', 'backend\BeritaController::show/$1');
$routes->put('berita/(:num)', 'backend\BeritaController::update/$1');
$routes->get('berita/new', 'backend\BeritaController::new');
$routes->post('berita', 'backend\BeritaController::create');
$routes->get('berita/(:num)/edit', 'backend\BeritaController::edit/$1');
$routes->post('berita/(:num)/update', 'backend\BeritaController::update/$1');
$routes->post('berita/(:num)/delete', 'backend\BeritaController::delete/$1'); // ✅ ini penting
$routes->post('berita/(:num)/destroyPermanent', 'backend\BeritaController::destroyPermanent/$1');
$routes->get('berita/trash', 'backend\BeritaController::trash');
$routes->post('berita/(:num)/restore', 'backend\BeritaController::restore/$1');
$routes->get('/berita/(:num)/log/', 'backend\BeritaController::log/$1');
$routes->post('berita/toggle-status', 'backend\BeritaController::toggleStatus');


//berita Utama
$routes->resource('berita-utama', ['controller' => 'backend\BeritaUtamaController', 'except' => ['show']]);
$routes->post('berita-utama/toggle-status', 'backend\BeritaUtamaController::toggleStatus');


//album
$routes->resource('album', [
    'controller' => 'backend\PhotoAlbumController',
    'except' => ['show']
]);
$routes->post('album/toggle-status', 'backend\PhotoAlbumController::toggleStatus');

// Gallery 
$routes->resource('gallery', ['controller' => 'backend\PhotoGalleryController', 'except' => ['show']]);
$routes->post('gallery/toggle-status', 'backend\PhotoGalleryController::toggleStatus');

// Banner logo
$routes->resource('banner', ['controller' => 'backend\BannerController', 'except' => ['show']]);
$routes->get('banner/view/(:num)', 'backend\BannerController::view/$1');
$routes->post('banner/toggle-status', 'backend\BannerController::toggleStatus');
$routes->get('banner/click/(:num)', 'backend\BannerController::click/$1');



//menu 
$routes->resource('menu', ['controller' => 'backend\MenuController']);
$routes->get('menu/toggleStatus/(:num)', 'backend\MenuController::toggleStatus/$1');
$routes->post('menu/toggleStatus/(:num)', 'backend\MenuController::toggleStatus/$1');
$routes->get('menu/edit/(:num)', 'backend\MenuController::edit/$1');
$routes->get('menu/(:num)/edit', 'backend\MenuController::edit/$1');


// ===============================
// ROUTE UNTUK MANAJEMEN HAK AKSES
// ===============================
$routes->get('access_rights', 'backend\AccessRightsController::index', ['filter' => 'roleauth:superadmin']);
$routes->get('access_rights/edit/(:num)', 'backend\AccessRightsController::edit/$1', ['filter' => 'roleauth:superadmin']);
$routes->put('access_rights/update/(:num)', 'backend\AccessRightsController::update/$1', ['filter' => 'roleauth:superadmin']);


// =========================================================
// API ROUTES
// =========================================================
$routes->group('api', function ($routes) {

    //tugas fungsi
    $routes->get('tugasfungsi', 'Api\ApiTugasFungsiController::index');
    $routes->get('tugasfungsi/(:num)', 'Api\ApiTugasFungsiController::show/$1');


    // Ip Kerja Sama Daerah
    $routes->get('ip_kerjasama_daerah', 'Api\ApiIpKerjasamaDaerahController::index');
    $routes->get('ip_kerjasama_daerah/(:num)', 'Api\ApiIpKerjasamaDaerahController::show/$1');

    // Agenda Pelatihan
    $routes->get('agenda_pelatihan', 'Api\ApiAgendaPelatihanController::index');
    $routes->get('agenda_pelatihan/(:num)', 'Api\ApiAgendaPelatihanController::show/$1');

    // Ppid Permohonan
    $routes->post('ppid_permohonan', 'Api\ApiPpidPermohonanController::create');
    $routes->get('ppid_permohonan/status/(:segment)', 'Api\ApiPpidPermohonanController::checkStatus/$1');
    

    // Ip Swakelola
    $routes->get('ip_swakelola', 'Api\ApiIpSwakelolaController::index');
    $routes->get('ip_swakelola/(:num)', 'Api\ApiIpSwakelolaController::show/$1');

    // Ip Penyedia
    $routes->get('ip_penyedia', 'Api\ApiIpPenyediaController::index');
    $routes->get('ip_penyedia/(:num)', 'Api\ApiIpPenyediaController::show/$1');

    //Permohonan Informasi
    $routes->get('permohonan_informasi', 'Api\ApiPermohonanInformasiController::index');
    $routes->get('permohonan_informasi/(:num)', 'Api\ApiPermohonanInformasiController::show/$1');

    //Daftar Laporan Kinerja
    $routes->get('laporan_kinerja', 'Api\ApiLaporanKinerjaController::index');
    $routes->get('laporan_kinerja/(:num)', 'Api\ApiLaporanKinerjaController::show/$1');

    //Daftar Informasi Publik
    $routes->get('daftar_informasi_publik', 'Api\ApidaftarInformasiPublikController::index');
    $routes->get('daftar_informasi_publik/(:num)', 'Api\ApidaftarInformasiPublikController::show/$1');

    //Laporan Keuangan
    $routes->get('laporan_keuangan', 'Api\ApiLaporanKeuanganController::index');
    $routes->get('laporan_keuangan/(:num)', 'Api\ApiLaporanKeuanganController::show/$1');


    //Informasi Perencanaan
    $routes->get('informasi_perencanaan', 'Api\ApiInformasiPerencanaanController::index');
    $routes->get('informasi_perencanaan/(:num)', 'Api\ApiInformasiPerencanaanController::show/$1');

    //Pejabat Struktural
    $routes->get('pejabat_struktural', 'Api\ApiPejabatStrukturalController::index');
    $routes->get('pejabat_struktural/(:num)', 'Api\ApiPejabatStrukturalController::show/$1');

    //Struktur Organisasi
    $routes->get('struktur_organisasi', 'Api\ApiStrukturOrganisasiController::index');
    $routes->get('struktur_organisasi/(:segment)', 'Api\ApiStrukturOrganisasiController::show/$1');

    //profil tentang
    $routes->get('profil_tentang', 'Api\ApiProfilTentangController::index');
    $routes->get('profil_tentang/(:num)', 'Api\ApiProfilTentangController::show/$1');

    //home layanan video
    $routes->get('home_video_layanan', 'Api\ApiHomeVideoLayananController::index');
    $routes->get('home_video_layanan/(:num)', 'Api\ApiHomeVideoLayananController::show/$1');

    //home service
    $routes->get('home_service', 'Api\ApiHomeServiceController::index');
    $routes->get('home_service/(:num)', 'Api\ApiHomeServiceController::show/$1');

    //footer_statistics
    $routes->get('footer_statistics', 'Api\ApiFooterStatisticsController::index');
    

    //footer_social
    $routes->get('footer_social', 'Api\ApiFooterSocialController::index');
    $routes->get('footer_social/(:num)', 'Api\ApiFooterSocialController::show/$1');

    //footer_opd
    $routes->get('footer_opd', 'Api\ApiFooterOpdController::index');
    $routes->get('footer_opd/(:num)', 'Api\ApiFooterOpdController::show/$1');

    //program
    $routes->get('program', 'Api\ApiProgramController::index');
    $routes->get('program/(:segment)', 'Api\ApiProgramController::show/$1');

    //kontak
    $routes->get('kontak', 'Api\ApiKontakController::index');
    $routes->get('kontak/(:num)', 'Api\ApiKontakController::show/$1');

    //kontak social
    $routes->get('kontak_social', 'Api\ApiKontakSocialController::index');
    $routes->get('kontak_social/(:num)', 'Api\ApiKontakSocialController::show/$1');

    //kontak layanan
    $routes->get('kontak_layanan', 'Api\ApiKontakLayananController::index');
    $routes->get('kontak_layanan/(:num)', 'Api\ApiKontakLayananController::show/$1');

    //profile
    $routes->get('profile', 'Api\ApiProfileController::index');
    $routes->get('profile/(:segment)', 'Api\ApiProfileController::show/$1');

    //Pejabat
    $routes->get('pejabat', 'Api\ApiPejabatController::index');
    $routes->get('pejabat/(:segment)', 'Api\ApiPejabatController::show/$1');

    //banner
    $routes->get('banner', 'Api\ApiBannerController::index');
    $routes->get('banner/(:num)', 'Api\ApiBannerController::show/$1');
    //dokumen
    $routes->get('dokument', 'Api\ApiDokumentController::index');
    $routes->get('dokument/(:num)', 'Api\ApiDokumenController::show/$1');
    
    //berita
    $routes->get('berita', 'Api\ApiBeritaController::index');
    $routes->get('berita/(:segment)', 'Api\ApiBeritaController::show/$1');
    $routes->get('berita/tag/(:segment)', 'Api\ApiBeritaController::getByTag/$1');
    $routes->get('berita/kategori/(:segment)', 'Api\ApiBeritaController::getByKategori/$1');

    //Photo Album
    $routes->get('album', 'Api\ApiPhotoAlbumController::index');
    $routes->get('album/(:num)', 'Api\ApiPhotoAlbumController::show/$1');

    //galery
    $routes->get('gallery', 'Api\ApiPhotoGalleryController::index');
    $routes->get('gallery/(:num)', 'Api\ApiPhotoGalleryController::show/$1');
    $routes->get('gallery/album/(:num)', 'Api\ApiPhotoGalleryController::byAlbum/$1');

    //Agenda
    $routes->get('agenda', 'Api\ApiAgendaController::index');   
    $routes->post('agenda', 'Api\ApiAgendaController::create');
    $routes->get('agenda/(:num)', 'Api\ApiAgendaController::show/$1');

    // Auth
    $routes->post('login', 'Api\AuthController::login');
    $routes->post('register', 'Api\AuthController::register');

    // User Permissions
    $routes->get('user/permissions', 'Api\AuthController::getUserPermissions');

    // CRUD Resources
    $routes->resource('users', ['controller' => 'Api\UserController']);
    $routes->resource('kategori_berita', ['controller' => 'Api\KategoriBeritaController']);
    $routes->resource('berita', ['controller' => 'Api\BeritaController']);
    $routes->resource('galeri_foto', ['controller' => 'Api\GaleriFotoController']);
    $routes->resource('menu', ['controller' => 'Api\MenuController']);

    // Admin
    $routes->group('admin', function($routes) {
        $routes->resource('hak_akses', ['controller' => 'Api\Admin\HakAksesController']);
    });

    // CORS options
    $routes->options('(:any)', 'Home::option');
});
