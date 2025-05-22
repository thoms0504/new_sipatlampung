<?php 
$routes->group('admin', function($routes){
// Administrator

// Repository
$routes->get('repo/create','Admin\Repo::create_repo');
$routes->post('repo/save','Admin\Repo::save');
$routes->get('repo/edit/(:segment)', 'Admin\Repo::edit/$1');
$routes->post('repo/update/(:segment)', 'Admin\Repo::update/$1');
$routes->get('repo','Admin\Repo::index');
$routes->delete('repo/(:num)', 'Admin\Repo::delete/$1');
$routes->get('repo/(:any)', 'Admin\Repo::detail/$1');

$routes->get('qna','Admin\QNA::index');
$routes->delete('qna/(:num)', 'Admin\QNA::hapusPertanyaan/$1');

$routes->get('zoom-monitoring/create_zoom', 'Admin\Zoom::create_zoom');
$routes->post('zoom-monitoring/create_zoom', 'Admin\Zoom::create_zoom');
$routes->get('zoom-monitoring/edit/(:segment)', 'Admin\Zoom::edit/$1');
$routes->post('zoom-monitoring/update/(:segment)', 'Admin\Zoom::update/$1');



$routes->get('zoom-monitoring', 'Admin\Zoom::index');
$routes->post('zoom-monitoring/getMonthData', 'Admin\Zoom::getMonthData');
$routes->post('zoom-monitoring/getWeekData', 'Admin\Zoom::getWeekData');
$routes->get('zoom-monitoring/delete/(:num)', 'Admin\Zoom::hapusJadwalZoom/$1');
$routes->get('/zoom-monitoring/(:num)', 'Admin\RepoController::viewSchedule/$1');


$routes->get('zoom-monitoring/dasbor', 'ModulZoom\Zoom::index');
// $routes->get('zoom-monitoring/dasbor/calendar', 'ModulZoom\ZoomController::calendar');
// $routes->get('zoom-monitoring/dasbor/calendar/(:num)/(:num)', 'ModulZoom\ZoomController::calendarByMonth/$1/$2');
// $routes->get('zoom-monitoring/dasbor/fixtures/json', 'ModulZoom\ZoomController::getFixturesJson');
// $routes->get('zoom-monitoring/dasbor/detail/(:num)', 'ModulZoom\ZoomController::detail/$1');
// $routes->get('zoom-monitoring/dasbor/team/(:segment)', 'ModulZoom\ZoomController::listByTeam/$1');
// $routes->get('zoom-monitoring/dasbor/today', 'ModulZoom\ZoomController::today');
// $routes->get('zoom-monitoring/dasbor/upcoming', 'ModulZoom\ZoomController::upcoming');
// $routes->get('zoom-monitoring/dasbor/upcoming/(:num)', 'ModulZoom\ZoomController::upcoming/$1');
// $routes->get('zoom-monitoring/dasbor/stats', 'ModulZoom\ZoomController::stats');
// $routes->get('zoom-monitoring/dasbor/api/fixtures', 'ModulZoom\ZoomController::apiGetFixturesByDateRange');




// Tambahkan route untuk endpoint AJAX
$routes->post('dasbor/getDataTrenPertanyaan', 'Admin\Dasbor::getDataTrenPertanyaan');
$routes->post('dasbor/getDataTrenjawaban', 'Admin\Dasbor::getDataTrenJawaban');



$routes->get('user','Admin\Pengguna::index');


});
