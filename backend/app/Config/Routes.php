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
$routes->get('berita/show/(:num)', 'backend\BeritaController::show/$1');
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


    //dokumen
    $routes->get('dokument', 'Api\ApiDokumentController::index');
    $routes->get('dokument/(:num)', 'Api\ApiDokumenController::show/$1');
    
    //berita
    $routes->get('berita', 'Api\ApiBeritaController::index');
    $routes->get('berita/(:num)', 'Api\ApiBeritaController::show/$1');

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
