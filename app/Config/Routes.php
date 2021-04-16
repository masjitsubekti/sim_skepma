<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Home::index');
$routes->get('/', 'Auth::index');
$routes->post('/check_auth', 'Auth::check_auth');
$routes->get('/beranda', 'Home::beranda');

// Master Kelompok Kegiatan 
$routes->get('/master/kelompok-kegiatan', 'KelompokKegiatan::index');
$routes->post('/kelompok-kegiatan/read-data/(:num)', 'KelompokKegiatan::read_data/$1');
$routes->post('/kelompok-kegiatan/load-modal', 'KelompokKegiatan::load_modal');
$routes->post('/kelompok-kegiatan/save', 'KelompokKegiatan::save');
$routes->post('/kelompok-kegiatan/delete', 'KelompokKegiatan::delete');

// Master Kegiatan
$routes->get('/master/kegiatan', 'Kegiatan::index');
$routes->post('/kegiatan/read-data/(:num)', 'Kegiatan::readData/$1');
$routes->post('/kegiatan/load-modal', 'Kegiatan::loadModal');
$routes->post('/kegiatan/save', 'Kegiatan::save');
$routes->post('/kegiatan/delete', 'Kegiatan::delete');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
