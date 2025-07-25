<?php

namespace App\Controllers\PortalUtama;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Tentang extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Beranda | Ruwai Jurai',
            'active' => 'tentang'
        ];
        return view('PortalUtama/modul_utama/tentang.php', $data);
    }
}
