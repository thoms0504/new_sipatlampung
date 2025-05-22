<?php

// use CodeIgniter\Router\RouteCollection;
namespace Config;

// /**
//  * @var RouteCollection $routes
//  */
// $routes->get('/', 'Home::index');

$routes = Services::routes();


if (is_file(SYSTEMPATH . 'Config/Routes.php')){
    require SYSTEMPATH . 'Config/Routes.php';

}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Beranda');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);


// $routes->get()
// Portal Utama ModulUtama
require APPPATH . 'Config/Routes/ModulUtama/PortalUtama.php';

require APPPATH . 'Config/Routes/ModulUtama/Admin.php';

$routes->get('masuk', 'PortalUtama\Auth::login');
$routes->post('masuk', 'PortalUtama\Auth::login');

$routes->get('admin/dasbor','Admin\Dasbor::index');
$routes->get('uploads/documents/(:any)', 'Repo::display/$1');
$routes->post('admin/zoom-monitoring/create_zoom', 'Admin\Zoom::tambahzoom');


