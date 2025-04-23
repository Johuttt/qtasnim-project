<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// $routes->get('/', 'Login::index');
//Auth
$routes->get('/', 'Auth::index');
$routes->post('login', 'Auth::login');
$routes->get('register', 'Auth::register');
$routes->post('register_action', 'Auth::register_action');
$routes->get('logout', 'Auth::logout');
$routes->get('dashboard','Pertanggungan::dashboard');

$routes->group('api', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->resource('jenis-barang', ['controller' => 'JenisBarangController']);
    $routes->resource('barang', ['controller' => 'BarangController']);
    $routes->resource('stock-history', ['controller' => 'StockHistoryController']);
    $routes->resource('transaksi', ['controller' => 'TransaksiController']);
    $routes->get('transaksi-jenis/compare-jenis-barang', 'TransaksiController::compareJenisBarang');
});

$routes->group('jenis-barang', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('/', 'JenisBarangController::dashboard');
    $routes->get('form', 'JenisBarangController::new');
    $routes->get('edit/(:num)', 'JenisBarangController::edit/$1');
});

$routes->group('barang', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('/', 'BarangController::dashboard');
    $routes->get('form', 'BarangController::new');
    $routes->get('edit/(:num)', 'BarangController::edit/$1');
});

$routes->group('stock-history', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('/', 'StockHistoryController::dashboard');
    $routes->get('form', 'StockHistoryController::new');
});

$routes->group('transaksi', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('/', 'TransaksiController::dashboard');
    $routes->get('form', 'TransaksiController::new');
    $routes->get('edit/(:num)', 'TransaksiController::edit/$1');
});

