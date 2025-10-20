<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// =========================================================
// API GROUP - WAJIB DILINDUNGI DENGAN FILTER OTENTIKASI (JWT/Token)
// =========================================================
$routes->group('api', function($routes){
    
    // --- 1. Rute Otentikasi/Login (Tidak perlu Filter Auth) ---
    // ASUMSI: Anda memiliki AuthController untuk login dan mendapatkan token
    $routes->post('login', 'Api\AuthController::login');
    $routes->post('register', 'Api\AuthController::register'); // Jika ada
    
    // --- 2. Rute Pengambilan Izin Pengguna (Perlu Filter Auth) ---
    // Rute ini dipanggil frontend untuk mengontrol tampilan menu/tombol
    // Asumsi: Method getUserPermissions ada di AuthController atau UserController
    $routes->get('user/permissions', 'Api\AuthController::getUserPermissions'); 


    // --- 3. Rute CRUD Resource (Wajib Dilindungi dengan Filter Auth dan Filter Hak Akses) ---
    // Di sini, ResourceController Anda harus mewarisi dari BaseApiController
    $routes->resource('users', ['controller' => 'Api\UserControl']);
    $routes->resource('kategori_berita', ['controller' => 'Api\KategoriBeritaController']);
    $routes->resource('berita', ['controller' => 'Api\BeritaController']);
    $routes->resource('galeri_foto', ['controller' => 'Api\GaleriFotoControll']);
    $routes->resource('menu', ['controller' => 'Api\MenuContoller']);
    
    
    // --- 4. Rute Administrasi Hak Akses (Hanya untuk Superadmin) ---
    // Kita asumsikan Controller ini ada di folder Admin dan diakses oleh Superadmin
    $routes->group('admin', function($routes) {
        $routes->resource('hak_akses', ['controller' => 'Api\Admin\HakAksesController']);
    });
    
    // Rute OPTIONS (Jika diperlukan untuk CORS)
    $routes->options('(:any)', 'Home::option');
});