<?php

namespace App\Controllers\PortalUtama;

use App\Controllers\BaseController;
use App\Models\ModulUtama\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;


class Profil extends BaseController
{
    protected $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Edit Profil | Sipat Lampung',
            'active' => 'profil',
            'user' => $this->userModel->where('id', session()->get('id'))->first(),
        ];
        return view('PortalUtama/profil/index', $data);
    }

    public function edit()
    {
        $data = [
            'title' => 'Edit Profil | Sipat Lampung',
            'active' => 'profil',
            'validation' => Services::validation(),
            'user' => $this->userModel->where('id', session()->get('id'))->first(),
        ];
        return view('PortalUtama/profil/edit', $data);
    }

    public function update()
    {
        $data = $this->userModel->getUser(session()->get('id'));
        $input = [
            'id' => session()->get('id'),
            'nama_lengkap' => $this->request->getVar('nama_lengkap'),
            'username' => $this->request->getVar('username'),
            'email' => $this->request->getVar('email'),
        ];
        // cek username sebelumnya
        if($data['username'] == $input['username']){
            $usernameRules = ['rules' => 'required', 'errors' => [
                'required' => 'Nama Pengguna harus diisi',
            ]];
        } else {
            $usernameRules = ['rules' => 'required|is_unique[users.username]', 'errors' => [
                'required' => 'Nama Pengguna harus diisi',
                'is_unique' => 'Nama Pengguna sudah digunakan',
            ]];
        }
        // cek email sebelumnya
        if ($data['email'] == $input['email']) {
            $emailRules = ['rules' => 'required|valid_email', 'errors' => [
                'required' => 'Email harus diisi',
                'valid_email' => 'Email tidak valid',
            ]];
        } else {
            $emailRules = ['rules' => 'required|valid_email|is_unique[users.email]', 'errors' => [
                'required' => 'Email harus diisi',
                'valid_email' => 'Email tidak valid',
                'is_unique' => 'Email sudah digunakan',
            ]];
        }
        // validasi input
        if (!$this->validate([
            'nama_lengkap' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama lengkap harus diisi.',
                ]
            ],
            'username' => $usernameRules,
            'email' => $emailRules,
        ])) {
            session()->setFlashdata('gagal', 'Terdapat isian yang salah');
            return redirect()->to('/profil/edit')->withInput();
        } else {
            $this->userModel->save($input);
            $data = $this->userModel->getUser(session()->get('id'));
            session()->set('akun_nama_lengkap', $data['nama_lengkap']);
            session()->set('akun_email', $data['email']);
            session()->set('akun_username', $data['username']);
            session()->setFlashdata('sukses', 'Profil berhasil diperbarui');
            return redirect()->to('/profil');
        }
    }

    public function formKataSandi()
    {
        $data = [
            'title' => 'Ubah Kata Sandi | Sipat Lampung',
            'active' => 'profil',
            'validation' => Services::validation(),
            'user' => $this->userModel->where('id', session()->get('id'))->first(),
        ];
        return view('PortalUtama/profil/changepassword', $data);
    }

    public function ubahKataSandi()
    {
        $data = $this->userModel->getUser(session()->get('id'));
        $input = [
            'id' => session()->get('id'),
            'old_password' => $this->request->getVar('old_password'),
            'new_password' => $this->request->getVar('new_password'),
            'confirm_password' => $this->request->getVar('confirm_password'),
        ];
        echo $data['password'];
        if ($data['password'] != '') {
            if (!password_verify($input['old_password'], $data['password'])) {
                session()->setFlashdata('gagal', 'Kata sandi lama salah.');
                return redirect()->to('/profil/changepassword');
            }
        }
        // validasi input
        if (!$this->validate([
            'new_password' => [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Kata sandi harus diisi.',
                    'min_length' => 'Kata sandi minimal 8 karakter.',
                ]
            ],
            'confirm_password' => [
                'rules' => 'required|matches[new_password]',
                'errors' => [
                    'required' => 'Konfirmasi kata sandi harus diisi.',
                    'matches' => 'Konfirmasi kata sandi tidak sama.',
                ]
            ],
        ])) {
            session()->setFlashdata('gagal', 'Terdapat isian yang salah.');
            return redirect()->to('/profil/changepassword')->withInput();
        } else {
            $this->userModel->where('id', session()->get('akun_id'))->set(['password' => password_hash($input['new_password'], PASSWORD_DEFAULT)])->update();
            session()->setFlashdata('sukses', 'Kata sandi berhasil diperbarui');
            return redirect()->to('/profil');
        }
    }
}
