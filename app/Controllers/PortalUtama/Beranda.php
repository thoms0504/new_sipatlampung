<?php

namespace App\Controllers\PortalUtama;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Beranda extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Beranda | Ruwai Jurai',
            'active' => 'beranda'
        ];
        return view('PortalUtama/modul_utama/index.php', $data);
    }
}
