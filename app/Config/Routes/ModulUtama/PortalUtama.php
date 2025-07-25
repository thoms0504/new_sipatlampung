<?php  

$routes->get('/', 'PortalUtama\Beranda::index');
$routes->get('tentang', 'PortalUtama\Tentang::index');
$routes->get('/masuk', 'PortalUtama\Auth::login');
$routes->post('/masuk', 'PortalUtama\Auth::login');
$routes->get('keluar', 'PortalUtama\Auth::logout');
$routes->get('/googlelogin', 'PortalUtama\Auth::googleLogin');

$routes->get('/profil', 'PortalUtama\Profil::index', ['filter' => 'isLoggedIn']);
$routes->get('/profil/edit', 'PortalUtama\Profil::edit', ['filter' => 'isLoggedIn']);
$routes->post('/profil/edit', 'PortalUtama\Profil::update', ['filter' => 'isLoggedIn']);
$routes->get('/profil/changepassword', 'PortalUtama\Profil::formKataSandi', ['filter' => 'isLoggedIn']);
$routes->post('/profil/changepassword', 'PortalUtama\Profil::ubahKataSandi', ['filter' => 'isLoggedIn']);

$routes->get('pertanyaan', 'ModulQnA\TanyaJawab::index');
$routes->get('pertanyaan/create', 'ModulQnA\TanyaJawab::buatpertanyaan');
$routes->get('pertanyaan/(:num)', 'ModulQnA\TanyaJawab::view/$1');
$routes->post('pertanyaan/save', 'ModulQnA\TanyaJawab::save');
$routes->delete('pertanyaan/(:num)', 'ModulQnA\TanyaJawab::hapuspertanyaan/$1');
$routes->post('pertanyaan/reply/(:num)', 'ModulQnA\TanyaJawab::reply/$1');
$routes->get('pertanyaan/edit/(:segment)', 'ModulQnA\TanyaJawab::editpertanyaan/$1');
$routes->post('pertanyaan/update/(:num)', 'ModulQnA\TanyaJawab::updatepertanyaan/$1');
$routes->post('pertanyaan/like/(:num)', 'ModulQnA\TanyaJawab::likeJawaban/$1');
$routes->post('pertanyaan/like-question/(:num)', 'ModulQnA\TanyaJawab::likeQuestion/$1');
$routes->get('pertanyaan/download/(:num)', 'ModulQnA\TanyaJawab::downloadpertanyaan/$1');
$routes->get('jawaban/download/(:num)', 'ModulQnA\TanyaJawab::downloadjawaban/$1');
$routes->get('pertanyaan/search-hashtags', 'ModulQnA\TanyaJawab::searchHashtags');

$routes->delete('jawaban/(:num)', 'ModulQnA\TanyaJawab::hapusJawaban/$1');

$routes->get('chat', 'PortalUtama\Chat::index', ['filter' => 'isLoggedIn']);
$routes->post('chat/send', 'PortalUtama\Chat::send');



?>
