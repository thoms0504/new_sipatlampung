<?php

namespace App\Controllers\PortalUtama;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ModulUtama\UserModel;



class Chat extends BaseController
{
    protected $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    public function index()
    {
        $data = [
            'title' => 'ChatBot | Ruwai Jurai',
            'active' => 'chat',
        ];
        if (isset($_SESSION['id']) == false) {
            session()->setFlashdata('gagal', 'Silahkan login terlebih dahulu.');
            return redirect()->to(base_url('masuk'));
        } else {
            $id = $_SESSION['id'];
            $user = $this->userModel->find($id);
            if ($user['role'] == 'admin') {
                session()->setFlashdata('gagal', 'Hanya Pengguna yang memiliki akses ke halaman ini.');
                return view('admin/chat/index', $data);
            } else {
                session()->setFlashdata('sukses', 'Anda berhasil masuk ke akses ke halaman ini.');
                return view('PortalUtama/modul_utama/chat', $data);
            }
        }
    }
}
