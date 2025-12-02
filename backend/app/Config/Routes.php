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

// Berita Kategori Tema
$routes->resource('tema', ['controller' => 'backend\TemaKategoriController', 'except' => ['show']]);

// Resource Web (non-API)
$routes->resource('manage_user', ['controller' => 'backend\UserController']);

// Kategori Berita
$routes->resource('kategori_berita', ['controller' => 'backend\KategoriBeritaController']);

// Kontak
$routes->resource('kontak', ['controller' => 'frontend\KontakController', 'except' => ['show']]);

//program
$routes->resource('program', ['controller' => 'frontend\ProgramController', 'except' => ['show']]);

//profile
$routes->resource('menu_profile', ['controller' => 'frontend\ProfileController', 'except' => ['show']]);

// Agenda
$routes->resource('agenda', ['controller' => 'backend\AgendaController','except' => ['show']]);

// Profile
$routes->resource('profile', ['controller' => 'backend\ProfileController', 'except' => ['show']]);

// Kategori
$routes->resource('kategori', ['controller' => 'backend\KategoriController', 'except' => ['show']]);
$routes->get('kategori/trash', 'backend\KategoriController::trash');
$routes->get('kategori/(:num)/restore', 'backend\KategoriController::restore/$1');
$routes->post('kategori/(:num)/destroyPermanent', 'backend\KategoriController::destroyPermanent/$1');


//////////////////////////////////////
//route untuk front end controller////
//////////////////////////////////////
//kontak layanan
$routes->resource('kontak_layanan', ['controller' => 'frontend\KontakLayananController', 'except' => ['show']]);
//kontak Social
$routes->resource('kontak_social', ['controller' => 'frontend\KontakSocialController', 'except' => ['show']]);
//footer opd
$routes->resource('footer_opd', ['controller' => 'frontend\FooterOpdController', 'except' => ['show']]);
//footer social
$routes->resource('footer_social', ['controller' => 'frontend\FooterSocialController', 'except' => ['show']]);
// footer statistics
$routes->resource('footer_statistics', ['controller' => 'frontend\FooterStatisticsController', 'except' => ['show']]);
//home service
$routes->resource('home_service', ['controller' => 'frontend\HomeServiceController', 'except' => ['show']]);
//home video 
$routes->resource('home_video_layanan', ['controller' => 'frontend\HomeVideoLayananController', 'except' => ['show']]);
// profil tentang
$routes->resource('profil_tentang', ['controller' => 'frontend\ProfilTentangController', 'except' => ['show']]);    
// Tugas Fungsi
$routes->resource('tugas_fungsi', ['controller' => 'frontend\TugasFungsiController', 'except' => ['show']]);
// Struktur Organisasi
$routes->resource('struktur_organisasi', ['controller' => 'frontend\StrukturOrganisasiController', 'except' => ['show']]);
// Pejabat Struktural
$routes->resource('pejabat_struktural', ['controller' => 'frontend\PejabatStrukturalController', 'except' => ['show']]);
// Informasi Perencanaan
$routes->resource('informasi_perencanaan', ['controller' => 'frontend\InformasiPerencanaanController', 'except' => ['show']]);
// Laporan Keuangan
$routes->resource('laporan_keuangan', ['controller' => 'frontend\LaporanKeuanganController', 'except' => ['show']]);





// berita kategori
$routes->resource('berita_tag', ['controller' => 'backend\BeritaTagController', 'except' => ['show']]);

// Dokumen Kategori
$routes->resource('dokument_kategori', ['controller' => 'backend\DokumenKategoriController', 'except' => ['show']]);

// Dokumen
$routes->resource('dokument', ['controller' => 'backend\DokumenController', 'except' => ['show']]);

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


//berita Utama
$routes->resource('berita-utama', ['controller' => 'backend\BeritaUtamaController', 'except' => ['show']]);


//album
$routes->resource('album', [
    'controller' => 'backend\PhotoAlbumController',
    'except' => ['show']
]);
$routes->get('album/trash', 'backend\PhotoAlbumController::trash');
$routes->get('album/restore/(:num)', 'backend\PhotoAlbumController::restore/$1');
$routes->get('album/destroy/(:num)', 'backend\PhotoAlbumController::destroyPermanent/$1');

// Gallery 
$routes->resource('gallery', ['controller' => 'backend\PhotoGalleryController', 'except' => ['show']]);

// Trash dan restore
$routes->get('gallery/trash', 'backend\PhotoGalleryController::trash');
$routes->get('gallery/restore/(:num)', 'backend\PhotoGalleryController::restore/$1');
$routes->get('gallery/destroy/(:num)', 'backend\PhotoGalleryController::destroyPermanent/$1');




// Banner logo
$routes->resource('banner', ['controller' => 'backend\BannerController', 'except' => ['show']]);
$routes->get('banner/view/(:num)', 'backend\BannerController::view/$1');
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
