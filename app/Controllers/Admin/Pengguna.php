<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use App\Models\ModulUtama\UserModel;

class Pengguna extends BaseController
{
    protected $userModel;

    public function __construct() {
        $this->userModel = new UserModel;
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

    // Method untuk menonaktifkan pengguna
    public function deactivate($id)
    {
        // Validasi input
        if (!$id || !is_numeric($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ID pengguna tidak valid'
            ]);
        }

        // Cek apakah pengguna ada
        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Pengguna tidak ditemukan'
            ]);
        }

        // Cek apakah pengguna yang akan dinonaktifkan adalah admin
        if ($user['role'] === 'admin') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Tidak dapat menonaktifkan admin'
            ]);
        }

        // Nonaktifkan pengguna
        $result = $this->userModel->deactivateUser($id);
        
        if ($result) {
            session()->setFlashdata('sukses', 'Pengguna berhasil dinonaktifkan');
            return redirect()->to('/admin/user');

        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal menonaktifkan pengguna'
            ]);
        }
    }

    // Method untuk mengaktifkan pengguna
    public function activate($id)
    {
        // Validasi  input
        if (!$id || !is_numeric($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ID pengguna tidak valid'
            ]);
        }

        // Cek apakah pengguna ada
        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Pengguna tidak ditemukan'
            ]);
        }

        // Aktifkan pengguna
        $result = $this->userModel->activateUser($id);
        
        if ($result) {
            session()->setFlashdata('sukses', 'Pengguna berhasil diaktifkan');
            return redirect()->to('/admin/user');
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal mengaktifkan pengguna'
            ]);
        }
    }

    // Method untuk toggle status aktif/nonaktif
    public function toggleStatus($id)
    {
        // Validasi input
        if (!$id || !is_numeric($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ID pengguna tidak valid'
            ]);
        }

        // Cek apakah pengguna ada
        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Pengguna tidak ditemukan'
            ]);
        }

        // Cek apakah pengguna yang akan diubah statusnya adalah admin
        if ($user['role'] === 'admin') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Tidak dapat mengubah status admin'
            ]);
        }

        // Toggle status
        $newStatus = $user['is_active'] == 1 ? 0 : 1;
        $result = $this->userModel->update($id, ['is_active' => $newStatus]);
        
        if ($result) {
            $statusText = $newStatus == 1 ? 'diaktifkan' : 'dinonaktifkan';
            return $this->response->setJSON([
                'status' => 'success',
                'message' => "Pengguna berhasil {$statusText}",
                'new_status' => $newStatus
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal mengubah status pengguna'
            ]);
        }
    }

    // Method untuk menghapus pengguna (opsional)
    public function delete($id)
    {
        // Validasi input
        if (!$id || !is_numeric($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ID pengguna tidak valid'
            ]);
        }

        // Cek apakah pengguna ada
        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Pengguna tidak ditemukan'
            ]);
        }

        // Cek apakah pengguna yang akan dihapus adalah admin
        if ($user['role'] === 'admin') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Tidak dapat menghapus admin'
            ]);
        }

        // Hapus pengguna
        $result = $this->userModel->delete($id);
        
        if ($result) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Pengguna berhasil dihapus'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal menghapus pengguna'
            ]);
        }
    }
}