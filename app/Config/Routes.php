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
$routes->post('/dashboard/status-kegiatan', 'Home::getDataDashboard');

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

// Kegiatan Mahasiswa
$routes->get('/kegiatan-mahasiswa', 'Mahasiswa::index');
$routes->get('/mhs/tambah-kegiatan', 'Mahasiswa::tambahKegiatan');
$routes->get('/mhs/ubah-kegiatan/(:any)', 'Mahasiswa::ubahKegiatan/$1');
$routes->post('/mhs/save-kegiatan-mahasiswa', 'Mahasiswa::saveKegiatan');
$routes->post('/mhs/delete-kegiatan-mahasiswa', 'Mahasiswa::deleteKegiatan');
$routes->post('/mhs/read-data/(:num)', 'Mahasiswa::readData/$1');
$routes->get('/mhs/poin-skepma', 'Mahasiswa::poinSkepma');
$routes->post('/dokumen/preview', 'Mahasiswa::previewDokumen');
$routes->get('/dokumen/download/(:any)', 'Mahasiswa::downloadFile/$1');

// Dosen
$routes->get('/dosen/kegiatan-mahasiswa', 'Dosen::index');
$routes->get('/dosen/daftar-mahasiswa', 'Dosen::daftarMhs');
$routes->get('/mhs/detail/(:any)', 'Dosen::detailKegiatanMhs/$1');
$routes->get('/mhs/daftar-kegiatan/(:any)', 'Dosen::daftarKegiatanMhs/$1');
$routes->post('/mhs/read-data-kegiatan/(:num)', 'Dosen::readDataKegiatanMhs/$1');
$routes->post('/dosen/read-data-kegiatan/(:num)', 'Dosen::readDataPengajuanKegiatan/$1');
$routes->post('/dosen/read-data-mhs/(:num)', 'Dosen::readDataMhs/$1');
$routes->post('/dosen/verifikasi-kegiatan', 'Dosen::updateStatus');
// User
$routes->get('/setting/user', 'User::index', ['filter' => 'auth']);
$routes->post('/user/read-data/(:num)', 'User::read_data/$1');
$routes->post('/user/load-modal', 'User::load_modal');
$routes->post('/user/save', 'User::save');
$routes->post('/user/delete', 'User::delete');
// Role Permission
$routes->get('/setting/role-permission', 'MenuUser::index', ['filter' => 'auth']);
$routes->post('/menu-user/read-data/(:num)', 'MenuUser::read_data/$1');
$routes->post('/menu-user/load-modal', 'MenuUser::load_modal');
$routes->post('/menu-user/save', 'MenuUser::save');
$routes->post('/menu-user/delete', 'MenuUser::delete');
$routes->post('/menu-user/sub-menu', 'MenuUser::get_sub_menu');
// Laporan
$routes->get('/laporan', 'Report::index', ['filter' => 'auth']);
$routes->get('/report/laporan-skepma', 'Report::export_lap_skepma');
// $routes->get('/report/laporan-rekap-kegiatan', 'Report::export_laporan_skepma');

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
