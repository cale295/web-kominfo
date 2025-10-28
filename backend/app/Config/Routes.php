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

// berita
$routes->resource('berita', ['controller' => 'BeritaController']);

// Kategori Berita
$routes->resource('kategori_berita', ['controller' => 'KategoriBeritaController']);

// Agenda
$routes->resource('agenda', ['controller' => 'AgendaController','except' => ['show']]);

// Profile
$routes->resource('profile', ['controller' => 'ProfileController', 'except' => ['show']]);


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
