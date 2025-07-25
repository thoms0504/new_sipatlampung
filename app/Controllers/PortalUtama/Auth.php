<?php

namespace App\Controllers\PortalUtama;

use App\Controllers\BaseController;
use App\Models\ModulUtama\UserModel;
use Config\Services;
use Google\Client;
use Google\Service\Oauth2;


class Auth extends BaseController
{
    protected $userModel;
    protected $validation;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->validation = Services::validation();
        helper('cookie');
    }

    // Method untuk mengatur session setelah login berhasil
    protected function _sessionAkun($id, $username, $nama_lengkap, $email, $role, $isLoggedIn)
    {
        $data = [
            'id' => $id,
            'username' => $username,
            'nama_lengkap' => $nama_lengkap,
            'email' => $email,
            'role' => $role,
            'isLoggedIn' => $isLoggedIn
        ];
        session()->set($data);
    }

    // Method untuk menangani proses login
    public function login()
    {
        if (session('username')) {
            return redirect()->to(base_url('admin/dasbor'));
        } else {

            $data = [
                'title' => 'Masuk | Ruwai Jurai',
                'active' => 'masuk'
            ];

            // echo "Method: " . $this->request->getMethod(); // Debugging
            // exit;

            // Jika method adalah POST, proses data login
            if ($this->request->getMethod() === 'POST') {
                $username = $this->request->getVar('username');
                $password = $this->request->getVar('password');
                $rememberMe = $this->request->getVar('rememberMe');

                // Validasi input
                if (!$username || !$password) {
                    session()->setFlashdata('gagal', 'Nama Pengguna dan Kata Sandi wajib diisi.');
                    return redirect()->to('/masuk')->withInput();
                }

                // Ambil data pengguna dari database
                $dataAkun = $this->userModel->getData($username);

                if ($dataAkun) {
                    // Verifikasi password
                    if (password_verify($password, $dataAkun['password'])) {
                        // Cek apakah akun aktif
                        if ($dataAkun['is_active'] == 1) {
                            // Set session
                            $this->_sessionAkun(
                                $dataAkun['id'],
                                $dataAkun['username'],
                                $dataAkun['nama_lengkap'],
                                $dataAkun['email'],
                                $dataAkun['role'],
                                true
                            );

                            // Jika "Remember Me" diaktifkan
                            if ($rememberMe) {
                                set_cookie('cookie_username', $username, 3600 * 24 * 30); // 30 hari
                                set_cookie('cookie_password', $password, 3600 * 24 * 30); // 30 hari (simpan password plaintext TIDAK disarankan)
                            }

                            // Redirect ke halaman dashboard
                            return redirect()->to(base_url('admin/dasbor'));
                        } else {
                            session()->setFlashdata('gagal', 'Akun Anda belum aktif.');
                            return redirect()->to('/masuk');
                        }
                    } else {
                        session()->setFlashdata('gagal', 'Nama Pengguna atau Kata Sandi salah.');
                        return redirect()->to('/masuk')->withInput();
                    }
                } else {
                    session()->setFlashdata('gagal', 'Nama Pengguna atau Kata Sandi salah.');
                    return redirect()->to('/masuk')->withInput();
                }
            }
        }

        // Tampilkan view login jika method bukan POST
        return view('PortalUtama/modul_utama/login', $data);
    }

    // Method untuk logout
    public function logout()
    {
        $this->userModel->updateData([
            'id' => session()->get('id'),
            'remember_token' => null
        ]);

        delete_cookie('remember_token');
        session()->destroy();

        return redirect()->to('/masuk')->with('sukses', 'Berhasil keluar');
    }

    public function googleLogin()
    {
        $clientID = getenv('GOOGLE_CLIENT_ID'); // Ganti dengan Client ID Google Anda
        $clientSecret = getenv('GOOGLE_CLIENT_SECRET'); // Ganti dengan Client Secret Google Anda
        $redirectUri = 'http://localhost:8080/googlelogin'; //Harus sama dengan yang kita daftarkan


        $client = new Client();
        $client->setClientId($clientID);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);
        $client->addScope("email");
        $client->addScope("profile");

        if (isset($_GET['code'])) {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            if (isset($token['access_token'])) {
                $client->setAccessToken($token['access_token']);
                $Oauth = new Oauth2($client);
                $userInfo = $Oauth->userinfo->get();
                $users = new UserModel();
                $data = $users->where('google_id', $userInfo->id)->find();
                if (!$data) {
                    if ($users->insert([
                        'google_id' => $userInfo->id,
                        'email' => $userInfo->email,
                        'nama_lengkap' => $userInfo->name,
                        'username' => $this->_generateUniqueUsername($userInfo->email),
                        'role' => 'user',
                        'is_active' => 1,
                        'avatar' => $userInfo->picture
                    ])) {
                        $data = $users->where('google_id', $userInfo->id)->find();
                        $this->_sessionAkun($data[0]['id'], $data[0]['username'], $data[0]['nama_lengkap'], $data[0]['email'], $data[0]['password'], $data[0]['role'], TRUE);

                        return redirect()->to('/');
                    }
                    return redirect()->back();
                }
                if ($data[0]['is_active'] == 1) {
                    $this->_sessionAkun($data[0]['id'], $data[0]['username'], $data[0]['nama_lengkap'], $data[0]['email'], $data[0]['role'], TRUE);
                    return redirect()->to('/');
                } else {
                    session()->setFlashdata('gagal', 'Akun anda belum aktif');
                    return redirect()->to('/masuk');
                }
            }
        }
        return redirect()->to($client->createAuthUrl());
    }

    private function _generateUniqueUsername($email)
    {
        $username = str_replace('@gmail.com', '', $email);
        $originalUsername = $username;
        $counter = 1;
        $users = new UserModel();

        // Loop sampai menemukan username yang unik
        while ($users->where('username', $username)->first()) {
            $username = $originalUsername . $counter;
            $counter++;
        }

        return $username;
    }
}
