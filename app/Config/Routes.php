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
$routes->post('/logout', 'Auth::logout');
$routes->post('/check_auth', 'Auth::check_auth');
$routes->get('/beranda', 'Home::index', ['filter' => 'auth']);

// Master Kelompok Kegiatan 
$routes->get('/master/kelompok-kegiatan', 'KelompokKegiatan::index', ['filter' => 'auth']);
$routes->post('/kelompok-kegiatan/read-data/(:num)', 'KelompokKegiatan::read_data/$1');
$routes->post('/kelompok-kegiatan/load-modal', 'KelompokKegiatan::load_modal');
$routes->post('/kelompok-kegiatan/save', 'KelompokKegiatan::save');
$routes->post('/kelompok-kegiatan/delete', 'KelompokKegiatan::delete');

// Master Kegiatan
$routes->get('/master/kegiatan', 'Kegiatan::index', ['filter' => 'auth']);
$routes->post('/kegiatan/read-data/(:num)', 'Kegiatan::readData/$1');
$routes->post('/kegiatan/load-modal', 'Kegiatan::loadModal');
$routes->post('/kegiatan/save', 'Kegiatan::save');
$routes->post('/kegiatan/delete', 'Kegiatan::delete');

// Master Detail Kegiatan
$routes->get('/master/kegiatan/detail-kegiatan/(:any)', 'Kegiatan::detailKegiatan/$1', ['filter' => 'auth']);
$routes->post('/kegiatan/read-data-detail/(:num)', 'Kegiatan::readDataDetail/$1');
$routes->post('/kegiatan/load-modal-detail', 'Kegiatan::loadModalDetail');
$routes->post('/kegiatan/save-detail', 'Kegiatan::saveDetail');
$routes->post('/kegiatan/delete-detail', 'Kegiatan::deleteDetail');
$routes->post('/kegiatan/kategori-by-kegiatan', 'Kegiatan::kategoriByIdKegiatan');

$routes->get('/kegiatan-mahasiswa', 'Mahasiswa::index');
$routes->get('/kegiatan/pilih-kelompok', 'Mahasiswa::pilihKelompokKegiatan');
$routes->get('/kegiatan/input-kegiatan/(:any)', 'Mahasiswa::inputKegiatan/$1');

// $routes->group('admin', function($routes){
// 	$routes->get('news', 'NewsAdmin::index');
// 	$routes->get('news/(:segment)/preview', 'NewsAdmin::preview/$1');
//  $routes->add('news/new', 'NewsAdmin::create');
// 	$routes->add('news/(:segment)/edit', 'NewsAdmin::edit/$1');
// 	$routes->get('news/(:segment)/delete', 'NewsAdmin::delete/$1');
// });


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
