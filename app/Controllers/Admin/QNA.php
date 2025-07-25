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
                        'created_at' => $p['created_at']
                    ];
                }
            }
        }

        // Kirim data ke view
        return view('Admin/ModulQnA/index', $data);
    }

    public function save()
    {
        // Validasi input
        $rules = [
            'judul' => [
                'rules' => 'required|min_length[10]|max_length[255]',
                'errors' => [
                    'required' => 'Judul pertanyaan harus diisi',
                    'min_length' => 'Judul pertanyaan minimal 10 karakter',
                    'max_length' => 'Judul pertanyaan maksimal 255 karakter'
                ]
            ],
            'deskripsi' => [
                'rules' => 'required|min_length[20]',
                'errors' => [
                    'required' => 'Deskripsi pertanyaan harus diisi',
                    'min_length' => 'Deskripsi pertanyaan minimal 20 karakter'
                ]
            ]
        ];

        // Validasi file jika ada
        $file = $this->request->getFile('file_attachment');
        if ($file && $file->isValid()) {
            $rules['file_attachment'] = [
                'rules' => 'uploaded[file_attachment]|max_size[file_attachment,5120]|ext_in[file_attachment,jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx]',
                'errors' => [
                    'uploaded' => 'File harus dipilih',
                    'max_size' => 'Ukuran file maksimal 5MB',
                    'ext_in' => 'Format file harus JPG, PNG, GIF, PDF, DOC, DOCX, XLS, atau XLSX'
                ]
            ];
        }

        if (!$this->validate($rules)) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        // Siapkan data untuk disimpan
        $data = [
            'id_penanya' => session()->get('user_id'), // Asumsi user_id tersimpan di session
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'status' => 0 // Default status belum dijawab
        ];

        // Handle file upload jika ada
        if ($file && $file->isValid()) {
            $uploadResult = $this->pertanyaaModel->handleFileUpload($file);
            if ($uploadResult) {
                $data['file_attachment'] = $uploadResult['file_name'];
                $data['file_type'] = $uploadResult['file_type'];
                $data['file_size'] = $uploadResult['file_size'];
            } else {
                session()->setFlashdata('error', 'Gagal mengupload file');
                return redirect()->back()->withInput();
            }
        }

        // Simpan ke database
        if ($this->pertanyaaModel->save($data)) {
            session()->setFlashdata('success', 'Pertanyaan berhasil dikirim');
            return redirect()->to('/pertanyaan');
        } else {
            session()->setFlashdata('error', 'Gagal menyimpan pertanyaan');
            return redirect()->back()->withInput();
        }
    }

    public function downloadFile($fileName)
    {
        $filePath = WRITEPATH . 'uploads/pertanyaan/' . $fileName;

        if (!file_exists($filePath)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak ditemukan');
        }

        return $this->response->download($filePath, null);
    }

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
