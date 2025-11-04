<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'AuthController::index');

// Login & Logout
$routes->get('/login', 'AuthController::index');
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');

// Dashboard
$routes->get('/dashboard', 'DashboardController::index');

// Berita Kategori Tema
$routes->resource('tema', ['controller' => 'TemaKategoriController', 'except' => ['show']]);

// Resource Web (non-API)
$routes->resource('manage_user', ['controller' => 'UserController']);

// Kategori Berita
$routes->resource('kategori_berita', ['controller' => 'KategoriBeritaController']);

// Agenda
$routes->resource('agenda', ['controller' => 'AgendaController','except' => ['show']]);

// Profile
$routes->resource('profile', ['controller' => 'ProfileController', 'except' => ['show']]);

// Kategori
$routes->resource('kategori', ['controller' => 'KategoriController', 'except' => ['show']]);
$routes->get('kategori/trash', 'KategoriController::trash');
$routes->get('kategori/(:num)/restore', 'KategoriController::restore/$1');
$routes->post('kategori/(:num)/destroyPermanent', 'KategoriController::destroyPermanent/$1');


// berita kategori
$routes->resource('berita_tag', ['controller' => 'BeritaTagController', 'except' => ['show']]);
$routes->get('berita_tag/trash', 'BeritaTagController::trash');
$routes->get('berita_tag/(:num)/restore', 'BeritaTagController::restore/$1');
$routes->delete('berita_tag/(:num)/destroyPermanent', 'BeritaTagController::destroyPermanent/$1');

// BERITA ROUTES (manual agar tidak bentrok)
$routes->get('berita', 'BeritaController::index');
$routes->get('berita/create', 'BeritaController::create');
$routes->post('berita', 'BeritaController::store');

$routes->get('berita/trash', 'BeritaController::trash');
$routes->get('berita/(:num)/restore', 'BeritaController::restore/$1');
$routes->delete('berita/(:num)/destroyPermanent', 'BeritaController::destroyPermanent/$1');

$routes->get('berita/(:segment)/edit', 'BeritaController::edit/$1');
$routes->put('berita/(:segment)', 'BeritaController::update/$1');
$routes->delete('berita/(:segment)', 'BeritaController::delete/$1');
$routes->get('berita/(:segment)', 'BeritaController::show/$1');


//album
$routes->resource('album', [
    'controller' => 'PhotoAlbumController',
    'except' => ['show']
]);
$routes->get('album/trash', 'PhotoAlbumController::trash');
$routes->get('album/restore/(:num)', 'PhotoAlbumController::restore/$1');
$routes->get('album/destroy/(:num)', 'PhotoAlbumController::destroyPermanent/$1');

// Gallery manual routes
$routes->get('gallery', 'PhotoGalleryController::index');
$routes->get('gallery/create', 'PhotoGalleryController::create');
$routes->post('gallery', 'PhotoGalleryController::store');
$routes->get('gallery/edit/(:num)', 'PhotoGalleryController::edit/$1');
$routes->post('gallery/update/(:num)', 'PhotoGalleryController::update/$1');
$routes->get('gallery/delete/(:num)', 'PhotoGalleryController::delete/$1');

// Trash dan restore
$routes->get('gallery/trash', 'PhotoGalleryController::trash');
$routes->get('gallery/restore/(:num)', 'PhotoGalleryController::restore/$1');
$routes->get('gallery/destroy/(:num)', 'PhotoGalleryController::destroyPermanent/$1');








// Banner logo
$routes->resource('banner', ['controller' => 'BannerController', 'except' => ['show']]);
$routes->get('banner/view/(:num)', 'BannerController::view/$1');
$routes->get('banner/click/(:num)', 'BannerController::click/$1');
$routes->get('banner/trash', 'BannerController::trash');
$routes->get('banner/restore/(:num)', 'BannerController::restore/$1'); // restore data
$routes->post('banner/(:num)/restore', 'BannerController::restore/$1');
$routes->get('banner/destroyPermanent/(:num)', 'BannerController::destroyPermanent/$1');






//menu 
$routes->resource('menu', ['controller' => 'MenuController']);
$routes->get('menu/toggleStatus/(:num)', 'MenuController::toggleStatus/$1');
$routes->post('menu/toggleStatus/(:num)', 'MenuController::toggleStatus/$1');
$routes->get('menu/edit/(:num)', 'MenuController::edit/$1');
$routes->get('menu/(:num)/edit', 'MenuController::edit/$1');




// ===============================
// ROUTE UNTUK MANAJEMEN HAK AKSES
// ===============================
$routes->get('access_rights', 'AccessRightsController::index', ['filter' => 'roleauth:superadmin']);
$routes->get('access_rights/edit/(:num)', 'AccessRightsController::edit/$1', ['filter' => 'roleauth:superadmin']);
$routes->put('access_rights/update/(:num)', 'AccessRightsController::update/$1', ['filter' => 'roleauth:superadmin']);




// =========================================================
// API ROUTES
// =========================================================
$routes->group('api', function ($routes) {


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
