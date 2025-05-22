<?php

namespace App\Controllers\PortalUtama;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Beranda extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Beranda | Sipat Lampung',
            'active' => 'beranda'
        ];
        return view('PortalUtama/modul_utama/index.php',$data);
    
    }
}
