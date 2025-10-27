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

// Resource Web (non-API)
$routes->resource('manage_user', ['controller' => 'UserController']);
$routes->post('manage_user/delete_selected', 'UserController::deleteSelected');
$routes->resource('berita', ['controller' => 'BeritaController']);
$routes->resource('kategori_berita', ['controller' => 'KategoriBeritaController']);

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
