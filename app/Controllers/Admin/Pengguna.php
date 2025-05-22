<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use App\Models\ModulUtama\UserModel;
use Aws\Api\Service;

class Pengguna extends BaseController
{

    protected $userModel;

    public function __construct() {
        $this->userModel = new userModel;
    }
    public function index()
    {
        $data = [
            'title' => 'Semua Pengguna | Sipat Lampung',
            'user' => $this->userModel->where('role','user')->findAll(),
            'active' => 'semua_pengguna',
            'validation' => Services::validation(),
        ];
        return view('Admin/ModulUser/index',$data);

    }
}
