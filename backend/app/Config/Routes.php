<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->group('api', function($routes){
    $routes->resource('users', ['controller' => 'Api\UserControl']);
    $routes->resource('kategori_berita', ['controller' => 'Api\KategoriBeritaController']);
    $routes->resource('berita', ['controller' => 'Api\BeritaController']);
    $routes->resource('galeri_foto', ['controller' => 'Api\GaleriFotoControll']);

    $routes->options('(:any)', 'Home::option');
});
