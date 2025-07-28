<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ModulQnA\JawabanModel;
use App\Models\ModulQnA\PertanyaanModel;
use App\Models\ModulUtama\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class QNA extends BaseController
{
    protected $pertanyaaModel;
    protected $JawabanModel;
    protected $userModel;

    public function __construct()
    {
        $this->pertanyaaModel = new PertanyaanModel();
        $this->JawabanModel = new JawabanModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $userModel = new UserModel();
        $pertanyaanModel = new PertanyaanModel();
        $jawabanModel = new JawabanModel();

        // Ambil data dari tabel users dan pertanyaan
        $users = $userModel->findAll();
        $pertanyaan = $pertanyaanModel->orderBy('created_at', 'DESC')->findAll();

        // Siapkan array untuk data yang akan dikirim ke view
        $data = [
            'title' => 'Seputar Pertanyaan | Ruwai Jurai',
            'pertanyaan' => [],
            'active' => 'daftarQnA'
        ];

        // Gabungkan data berdasarkan id_penanya dan hitung jumlah like
        foreach ($pertanyaan as $p) {
            foreach ($users as $u) {
                if ($p['id_penanya'] == $u['id']) {
                    // Hitung jumlah like dari tabel jawaban berdasarkan id_pertanyaan
                    $likes_jawaban = $jawabanModel->where('id_pertanyaan', $p['id_pertanyaan'])->selectSum('likes')->get()->getRow()->likes;

                    // Tambahkan data ke array
                    $data['pertanyaan'][] = [
                        'nama' => $u['nama_lengkap'],
                        'judul' => $p['judul'],
                        'deskripsi' => $p['deskripsi'],
                        'like_pertanyaan' => $p['likes'],
                        'file_attachment' => $p['file_attachment'] ?? null,
                        'file_type' => $p['file_type'] ?? null,
                        'file_size' => $p['file_size'] ?? null,
                        'likes_jawaban' => $likes_jawaban ?? 0,
                        'status' => $p['status'],
                        'id_pertanyaan' => $p['id_pertanyaan'],
                        'created_at' => $p['created_at'],
                        'report_count' => $p['report_count']
                    ];
                }
            }
        }

        // Kirim data ke view
        return view('Admin/ModulQnA/index', $data);
    }
    // Fungsi untuk membuat tabel manajemen report pertanyaan




    public function hapusPertanyaan($id_pertanyaan)
    {
        $pertanyaanModel = new PertanyaanModel();
        $jawabanModel = new JawabanModel();

        // Ambil data pertanyaan untuk mendapatkan info file
        $pertanyaan = $pertanyaanModel->find($id_pertanyaan);

        if (!$pertanyaan) {
            session()->setFlashdata('error', 'Pertanyaan tidak ditemukan.');
            return redirect()->to(base_url('/admin/qna'));
        }

        // Hapus file attachment jika ada
        if (!empty($pertanyaan['file_attachment'])) {
            $pertanyaanModel->deleteFileAttachment($pertanyaan['file_attachment']);
        }

        // Hapus jawaban terkait berdasarkan id_pertanyaan
        $jawabanModel->where('id_pertanyaan', $id_pertanyaan)->delete();

        // Hapus pertanyaan
        $pertanyaanModel->delete($id_pertanyaan);

        session()->setFlashdata('sukses', 'Pertanyaan berhasil dihapus.');
        return redirect()->to(base_url('/admin/qna'));
    }
}
