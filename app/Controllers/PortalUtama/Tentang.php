<?php

namespace App\Controllers\PortalUtama;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Tentang extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Beranda | Sipat Lampung',
            'active' => 'tentang'
        ];
        return view('PortalUtama/modul_utama/tentang.php',$data);
    }
}
