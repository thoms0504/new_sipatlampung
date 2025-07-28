<?php

namespace App\Controllers\ModulQnA;

use App\Controllers\BaseController;
use App\Models\ModulQnA\JawabanModel;
use App\Models\ModulQnA\PertanyaanModel;
use App\Models\ModulUtama\UserModel;
use App\Models\ModulQnA\LikeModel;
use App\Models\ModulQnA\PertanyaanLikeModel;
use App\Models\PertanyaanReportModel;
use App\Models\JawabanReportModel;
use Config\Services;
use Codeigniter\Exceptions\PageNotFoundException;
use Config\Database;

class TanyaJawab extends BaseController
{
    protected $pertanyaanModel;
    protected $jawabanModel;
    protected $userModel;
    protected $pertanyaanLikeModel;
    protected $pertanyaanReportModel;
    protected $jawabanReportModel;
    protected $likeModel;

    public function __construct()
    {
        $this->pertanyaanModel = new PertanyaanModel();
        $this->jawabanModel = new JawabanModel();
        $this->pertanyaanLikeModel = new PertanyaanLikeModel();
        $this->pertanyaanReportModel = new PertanyaanReportModel();
        $this->jawabanReportModel = new JawabanReportModel();
        $this->userModel = new UserModel();
        $this->likeModel = new LikeModel();
    }

    public function index()
    {
        $keyword = $this->request->getVar('keyword');
        $selectedTag = $this->request->getVar('tag'); // Parameter untuk filter berdasarkan tag

        if ($keyword || $selectedTag) {
            // Panggil searchWithTags dan langsung chain dengan operasi lainnya
            $pertanyaanQuery = $this->pertanyaanModel->searchWithTags($keyword, $selectedTag);
        } else {
            // Untuk kasus tanpa filter, tetap perlu join untuk konsistensi data
                $pertanyaanQuery = $this->pertanyaanModel
                ->select('pertanyaan.*, users.nama_lengkap, users.avatar, COUNT(jawaban.id_jawaban) as total_jawaban')
                ->join('users', 'users.id = pertanyaan.id_penanya', 'left')
                ->join('jawaban', 'jawaban.id_pertanyaan = pertanyaan.id_pertanyaan', 'left')
                ->groupBy('pertanyaan.id_pertanyaan, users.nama_lengkap, users.avatar');
        }

        $pertanyaanQuery->where('pertanyaan.report_count <=', 5);

        // Ambil semua hashtag yang ada untuk sidebar
        $allHashtags = $this->pertanyaanModel->getAllHashtags();

        helper('text');
        $data = [
            'title' => 'Semua Pertanyaan | Ruwai Jurai',
            'keyword' => $keyword,
            'selectedTag' => $selectedTag,
            'active' => 'qna',
            'pertanyaan' => $pertanyaanQuery->orderBy('pertanyaan.created_at', 'desc')->paginate(10, 'pertanyaan'),
            'pager' => $this->pertanyaanModel->pager,
            'allHashtags' => $allHashtags
        ];
        
        return view('PortalUtama/modul_qna/index', $data);
    }

    public function myQuestions()
    {
        $data = [
            'title' => 'Pertanyaan Saya | Ruwai Jurai',
            'active' => 'qna',
            'pertanyaan' => $this->pertanyaanModel->getQuestionsByUserId(session()->get('id')),
            'validation' => Services::validation()
        ];

        // Periksa apakah pengguna sudah login
        if (!session()->has('id')) {
            session()->setFlashdata("gagal", "Harap masuk terlebih dahulu jika ingin melihat pertanyaan Anda");
            return redirect()->to("/masuk");
        }

        return view('PortalUtama/modul_qna/myquestion', $data);
    }

    public function buatpertanyaan()
    {
        $data = [
            'title' => 'Buat Pertanyaan | Ruwai Jurai',
            'active' => 'qna',
            'validation' => Services::validation()
        ];

        // Periksa apakah pengguna sudah login
        if (!session()->has('id')) {
            session()->setFlashdata("gagal", "Harap masuk terlebih dahulu jika ingin membuat pertanyaan");
            return redirect()->to("/masuk");
        }

        // Periksa apakah pengguna memiliki role 'user'
        if (session()->get('role') != 'user') {
            session()->setFlashdata("gagal", "Hanya pengguna yang memiliki akses fitur ini di portal utama");
            return redirect()->to("/admin/qna");
        }

        return view('PortalUtama/modul_qna/create', $data);
    }

    public function save()
    {
        // Validasi input
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|min_length[10]|max_length[255]',
                'errors' => [
                    'required' => 'Judul pertanyaan harus diisi',
                    'min_length' => 'Judul pertanyaan minimal 10 karakter',
                    'max_length' => 'Judul pertanyaan maksimal 255 karakter'
                ]
            ],
            'deskripsi' => [
                'rules' => 'required|min_length[10]',
                'errors' => [
                    'required' => 'Deskripsi pertanyaan harus diisi',
                    'min_length' => 'Deskripsi pertanyaan minimal 20 karakter'
                ]
            ],
        ])) {
            // Jika validasi gagal, kembali ke form dengan input sebelumnya dan error
            return redirect()->to('/pertanyaan/create')->withInput()->with('validation', $this->validator);
        }

        // Periksa apakah pengguna sudah login
        if (!session()->has('id')) {
            session()->setFlashdata("gagal", "Harap masuk terlebih dahulu jika ingin membuat pertanyaan");
            return redirect()->to("/masuk");
        }

        // Periksa apakah method request adalah POST
        if ($this->request->getMethod() == 'POST') {
            try {
                // Ambil data pengguna berdasarkan ID dari session
                $penanya = $this->userModel->where('id', session()->get('id'))->first();

                if (!$penanya) {
                    session()->setFlashdata("gagal", "Data pengguna tidak ditemukan");
                    return redirect()->to("/masuk");
                }

                // Handle hashtags - PERBAIKAN UTAMA
                $hashtags = $this->request->getVar('hashtags'); // Sesuai dengan name="hashtags" di form
                $hashtagArray = [];

                if (!empty($hashtags)) {
                    $hashtagArray = array_filter(array_map('trim', explode(',', $hashtags)));
                    // Remove duplicates dan convert ke lowercase
                    $hashtagArray = array_unique(array_map('strtolower', $hashtagArray));
                }



                // Simpan pertanyaan ke database

                $this->pertanyaanModel->save([
                    'id_penanya' => $penanya['id'],
                    'judul' => $this->request->getVar("judul"),
                    'deskripsi' => nl2br($this->request->getVar("deskripsi")), // Tetap gunakan nl2br untuk format HTML
                    'hashtags' => !empty($hashtagArray) ? json_encode($hashtagArray) : null,
                    'file_attachment' => $this->request->getFile("file_attachment") ? $this->request->getFile("file_attachment")->getName() : null,
                    'file_type' => $this->request->getFile("file_attachment") ? $this->request->getFile("file_attachment")->getMimeType() : null,
                    'file_size' => $this->request->getFile("file_attachment") ? $this->request->getFile("file_attachment")->getSize() : null,
                    'status' => 0 // Status default 0 (belum terverifikasi)
                ]);

                $file = $this->request->getFile("file_attachment");
                if ($file && $file->isValid() && !$file->hasMoved()) {
                    // Pindahkan file ke direktori yang diinginkan
                    $file->move('uploads/pertanyaan', $file->getName());
                }
                // Set flashdata untuk pesan sukses
                session()->setFlashdata('sukses', 'Pertanyaan berhasil ditambahkan');
                return redirect()->to("/pertanyaan");
            } catch (\Exception $e) {
                // Log error
                log_message('error', 'Error saving pertanyaan: ' . $e->getMessage());
                session()->setFlashdata("gagal", "Terjadi kesalahan saat menyimpan pertanyaan");
                return redirect()->to('/pertanyaan/create')->withInput();
            }
        }

        return redirect()->to("/pertanyaan");
    }

    public function view($id)
    {
        $pertanyaan = $this->pertanyaanModel->where('id_pertanyaan', $id)->first();

        if (!$pertanyaan) {
            throw new PageNotFoundException("Halaman Tidak Ditemukan");
        }

        // Cek apakah user adalah pemilik pertanyaan
        $owner = false;
        if (isset($_SESSION['id'])) {
            $owner = ($_SESSION['id'] == $pertanyaan['id_penanya']);
        }

        // Ambil parameter sort dari URL
        $sort = $this->request->getVar('sort') ?? 'newest';

        // Ambil jawaban beserta informasi like dengan parameter sort
        $jawaban = $this->jawabanModel->getAnswersWithLikeInfo($id, session()->get('id'), $sort);

        // Ambil pertanyaan dengan informasi like (tanpa parameter sort)
        $pertanyaanWithLike = $this->pertanyaanModel->getQuestionWithLikeInfo($id, session()->get('id'));

        $data = [
            'id_pertanyaan' => $pertanyaan['id_pertanyaan'],
            'title' => 'Pertanyaan | Ruwai Jurai',
            'active' => 'qna',
            'pertanyaan' => $pertanyaan,
            'file_attachment' => $pertanyaan['file_attachment'],
            'file_type' => $pertanyaan['file_type'],
            'file_size' => $pertanyaan['file_size'],
            'owner' => $owner,
            'pertanyaanlike' => $pertanyaanWithLike, // Gunakan data yang sudah diproses
            'penanya' => $this->userModel->where('id', $pertanyaan['id_penanya'])->first(),
            'jawaban' => $jawaban,
            'validation' => Services::validation(),
            'sort' => $sort,
        ];

        return view('PortalUtama/modul_qna/detail', $data);
    }

    public function likeQuestion($id_pertanyaan)
    {
        $this->response->setHeader('Content-Type', 'application/json');

        if (!session()->get('id')) {
            return $this->response->setStatusCode(401)->setJSON([
                'success' => false,
                'message' => 'Silahkan login terlebih dahulu'
            ]);
        }

        try {
            $user_id = session()->get('id');
            $db = \Config\Database::connect();

            // Cek apakah user sudah like pertanyaan ini
            $existingLike = $db->table('pertanyaan_likes')
                ->where('id_pertanyaan', $id_pertanyaan)
                ->where('id_user', $user_id)
                ->get()
                ->getRowArray();

            if ($existingLike) {
                // Unlike - hapus berdasarkan composite key
                $deleteResult = $db->table('pertanyaan_likes')
                    ->where('id_pertanyaan', $id_pertanyaan)
                    ->where('id_user', $user_id)
                    ->delete();

                if (!$deleteResult) {
                    throw new \Exception('Gagal menghapus like');
                }

                $liked = false;
            } else {
                // Like
                $insertResult = $db->table('pertanyaan_likes')
                    ->insert([
                        'id_pertanyaan' => $id_pertanyaan,
                        'id_user' => $user_id,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);

                if (!$insertResult) {
                    throw new \Exception('Gagal menambahkan like');
                }

                $liked = true;
            }

            // Update jumlah like di tabel pertanyaan
            $totalLikes = $db->table('pertanyaan_likes')
                ->where('id_pertanyaan', $id_pertanyaan)
                ->countAllResults();

            $updateResult = $db->table('pertanyaan')
                ->where('id_pertanyaan', $id_pertanyaan)
                ->update(['likes' => $totalLikes]);

            if (!$updateResult) {
                throw new \Exception('Gagal mengupdate jumlah like');
            }

            return $this->response->setJSON([
                'success' => true,
                'liked' => $liked,
                'likes' => $totalLikes
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in likeQuestion: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function getAnswersWithLikeInfo($id_pertanyaan, $id_user = null, $sort = 'newest')
    {
        // Buat query builder untuk mendapatkan jawaban
        $builder = $this->db->table('jawaban');
        $builder->select('jawaban.*, users.nama_lengkap, users.avatar, 
                  (SELECT COUNT(*) FROM jawaban_likes WHERE jawaban_likes.id_jawaban = jawaban.id_jawaban) as total_likes');
        $builder->join('users', 'users.id = jawaban.id_penjawab');
        $builder->where('jawaban.id_pertanyaan', $id_pertanyaan);

        // Tambahkan kondisi untuk mengetahui apakah user sudah like jawaban ini
        if ($id_user) {
            $builder->select('(SELECT COUNT(*) FROM jawaban_likes WHERE jawaban_likes.id_jawaban = jawaban.id_jawaban AND jawaban_likes.id_user = ' . $id_user . ') as has_liked', FALSE);
        } else {
            $builder->select('0 as has_liked');
        }

        // Pengurutan berdasarkan parameter sort
        if ($sort == 'most_liked') {
            // Urutkan berdasarkan jumlah like terbanyak, jika sama gunakan tanggal terbaru
            $builder->orderBy('total_likes', 'DESC');
            $builder->orderBy('jawaban.created_at', 'DESC');
        } else {
            // Default: urutkan berdasarkan tanggal terbaru (newest)
            $builder->orderBy('jawaban.created_at', 'DESC');
        }

        return $builder->get()->getResultArray();
    }

    public function reply($id_pertanyaan)
    {
        // Validasi input
        $validation_rules = [
            'isi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Isi Jawaban anda"
                ]
            ]
        ];

        $files = $this->request->getFiles();
        $has_files = false;

        if (!empty($files['files'])) {
            foreach ($files['files'] as $file) {
                if ($file->isValid() && !$file->hasMoved() && $file->getSize() > 0) {
                    $has_files = true;
                    break;
                }
            }
        }

        // Tambahkan validasi file HANYA jika ada file yang diupload
        if ($has_files) {
            $validation_rules['files'] = [
                'rules' => 'uploaded[files]|max_size[files,10240]|ext_in[files,jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx]',
                'errors' => [
                    'uploaded' => 'Pilih file untuk diupload',
                    'max_size' => 'Ukuran file maksimal 10MB',
                    'ext_in' => 'Format file tidak didukung'
                ]
            ];
        }

        if (!$this->validate($validation_rules)) {
            return redirect()->to("/pertanyaan/$id_pertanyaan")->withInput();
        }

        // Periksa apakah pengguna sudah login
        if (!session()->has('id')) {
            session()->setFlashdata("gagal", "Harap masuk terlebih dahulu jika ingin menjawab pertanyaan");
            return redirect()->to("/masuk");
        }

        // Periksa apakah method request adalah POST
        if ($this->request->getMethod() == 'POST') {
            // Ambil data penjawab dari session
            $penjawab = $this->userModel->where('id', session()->get('id'))->first();

            // Handle file upload
            $file_attachment = null;
            $file_type = null;
            $file_size = null;

            // Pastikan direktori upload ada
            $upload_path = 'uploads/jawaban';
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0755, true);
            }

            $files = $this->request->getFiles();
            if (!empty($files['files'])) {
                foreach ($files['files'] as $file) {
                    if ($file->isValid() && !$file->hasMoved()) {
                        // Ambil informasi file SEBELUM di-move

                        $mime_type = $file->getMimeType();
                        $file_size_temp = $file->getSize();

                        // Generate unique filename
                        $newName = $file->getName();

                        // Pindahkan file ke direktori uploads/jawaban
                        if ($file->move($upload_path, $newName)) {
                            // Untuk multiple files, kita ambil file pertama saja
                            if ($file_attachment === null) {
                                $file_attachment = $newName;
                                $file_type = $mime_type;
                                $file_size = $file_size_temp;
                            }
                        }
                    }
                }
            }

            // Data jawaban baru
            $this->jawabanModel->save([
                'id_penjawab' => $penjawab['id'],
                'id_pertanyaan' => $id_pertanyaan,
                'isi' => nl2br($this->request->getVar("isi")),
                'file_attachment' => $file_attachment,
                'file_type' => $file_type,
                'file_size' => $file_size,
                'likes' => 0 // Default likes = 0
            ]);

            // Update status pertanyaan menjadi terjawab apabila id logged in adalah bukan penanya
            $pertanyaan = $this->pertanyaanModel->find($id_pertanyaan);
            if ($pertanyaan && $pertanyaan['id_penanya'] != session()->get('id')) {
                $this->pertanyaanModel->update($id_pertanyaan, ['status' => 1]);
            }
            
            // Set flashdata untuk pesan sukses
            session()->setFlashdata('sukses', 'Jawaban berhasil ditambahkan');
            return redirect()->to("/pertanyaan/$id_pertanyaan");
        }

        return redirect()->to("/pertanyaan/$id_pertanyaan");
    }

    // Fungsi tambahan untuk like jawaban
    public function likeJawaban($id_jawaban)
    {
        $this->response->setHeader('Content-Type', 'application/json');
        // Cek apakah user sudah login
        if (!session()->get('id')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Silahkan login terlebih dahulu'
            ]);
        }

        try {
            $user_id = session()->get('id');
            $db = \Config\Database::connect();

            // Cek apakah user sudah like jawaban ini
            $existingLike = $db->table('jawaban_likes')
                ->where('id_jawaban', $id_jawaban)
                ->where('id_user', $user_id)
                ->get()
                ->getRowArray();
            if ($existingLike) {
                // Jika sudah like, hapus like
                $deleteResult = $db->table('jawaban_likes')
                    ->where('id_jawaban', $id_jawaban)
                    ->where('id_user', $user_id)
                    ->delete();

                if (!$deleteResult) {
                    throw new \Exception('Gagal menghapus like');
                }

                $liked = false;
            } else {
                // Jika belum like, tambahkan like
                $insertResult = $db->table('jawaban_likes')
                    ->insert([
                        'id_jawaban' => $id_jawaban,
                        'id_user' => $user_id,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);

                if (!$insertResult) {
                    throw new \Exception('Gagal menambahkan like');
                }

                $liked = true;
            }

            // Update jumlah like di tabel jawaban
            $totalLikes = $db->table('jawaban_likes')
                ->where('id_jawaban', $id_jawaban)
                ->countAllResults();
            $updateResult = $db->table('jawaban')
                ->where('id_jawaban', $id_jawaban)
                ->update(['likes' => $totalLikes]);
            if (!$updateResult) {
                throw new \Exception('Gagal mengupdate jumlah like');
            }
            return $this->response->setJSON([
                'success' => true,
                'liked' => $liked,
                'likes' => $totalLikes
            ]);
        } catch (\Throwable $th) {
            log_message('error', 'Error in likeJawaban: ' . $th->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $th->getMessage()
            ]);
        }
        // $userId = session()->get('id');
        // $jawaban = $this->jawabanModel->find($id_jawaban);

        // if (!$jawaban) {
        //     return $this->response->setJSON([
        //         'success' => false,
        //         'message' => 'Jawaban tidak ditemukan'
        //     ]);
        // }

        // // Toggle like menggunakan JawabanModel
        // $result = $this->jawabanModel->toggleLike($id_jawaban, $userId);

        // return $this->response->setJSON([
        //     'success' => true,
        //     'result' => $result
        // ]);
    }


    // Fungsi untuk menghapus jawaban
    public function hapusJawaban($id_jawaban)
    {
        $jawabanModel = new JawabanModel();

        // Dapatkan data jawaban untuk mendapatkan id_pertanyaan sebelum dihapus
        $jawaban = $jawabanModel->find($id_jawaban);

        if ($jawaban) {
            // Simpan id_pertanyaan untuk redirect nantinya
            $id_pertanyaan = $jawaban['id_pertanyaan'];

            // Hapus jawaban berdasarkan id_jawaban
            $jawabanModel->delete($id_jawaban);

            session()->setFlashdata('sukses', 'Jawaban berhasil dihapus.');

            // Redirect ke halaman pertanyaan detail dengan pesan sukses
            return redirect()->to(base_url('/pertanyaan/' . $id_pertanyaan));
        } else {
            session()->setFlashdata('gagal', 'Jawaban tidak ditemukan.');
            return redirect()->to(base_url('/pertanyaan/'));
        }
    }

    // Fungsi untuk mengedit pertanyaan
    public function editPertanyaan($id_pertanyaan)
    {
        $pertanyaan = $this->pertanyaanModel->find($id_pertanyaan);

        if (!$pertanyaan) {
            throw new PageNotFoundException("Pertanyaan tidak ditemukan");
        }

        // Periksa apakah pengguna sudah login
        if (!session()->has('id')) {
            session()->setFlashdata("gagal", "Harap masuk terlebih dahulu jika ingin mengedit pertanyaan");
            return redirect()->to("/masuk");
        }

        // Periksa apakah pengguna adalah penanya
        if (session()->get('id') != $pertanyaan['id_penanya']) {
            session()->setFlashdata("gagal", "Anda tidak memiliki izin untuk mengedit pertanyaan ini");
            return redirect()->to("/pertanyaan/$id_pertanyaan");
        }

        if (!function_exists('br2nl')) {
            function br2nl($string)
            {
                return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string);
            }
        }

        $data = [
            'title' => 'Edit Pertanyaan | Ruwai Jurai',
            'active' => 'qna',
            'pertanyaan' => $pertanyaan,
            'validation' => Services::validation()
        ];

        return view('PortalUtama/modul_qna/edit', $data);
    }



    // Fungsi untuk memperbarui pertanyaan
    public function updatePertanyaan($id_pertanyaan)
    {
        // Validasi input
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|min_length[10]|max_length[255]',
                'errors' => [
                    'required' => 'Judul pertanyaan harus diisi',
                    'min_length' => 'Judul pertanyaan minimal 10 karakter',
                    'max_length' => 'Judul pertanyaan maksimal 255 karakter'
                ]
            ],
            'deskripsi' => [
                'rules' => 'required|min_length[10]',
                'errors' => [
                    'required' => 'Deskripsi pertanyaan harus diisi',
                    'min_length' => 'Deskripsi pertanyaan minimal 20 karakter'
                ]
            ],
        ])) {
            // Jika validasi gagal, kembali ke form dengan input sebelumnya dan error
            return redirect()->to("/pertanyaan/edit/$id_pertanyaan")->withInput()->with('validation', $this->validator);
        }

        // Periksa apakah pengguna sudah login
        if (!session()->has('id')) {
            session()->setFlashdata("gagal", "Harap masuk terlebih dahulu jika ingin mengedit pertanyaan");
            return redirect()->to("/masuk");
        }

        // Periksa apakah pengguna adalah penanya
        $pertanyaan = $this->pertanyaanModel->find($id_pertanyaan);
        if (session()->get('id') != $pertanyaan['id_penanya']) {
            session()->setFlashdata("gagal", "Anda tidak memiliki izin untuk mengedit pertanyaan ini");
            return redirect()->to("/pertanyaan/$id_pertanyaan");
        }

        // Periksa apakah method request adalah POST
        if ($this->request->getMethod() == 'POST') {
            try {
                // Handle hashtags - PERBAIKAN UTAMA
                $hashtags = $this->request->getVar('hashtags'); // Sesuai dengan name="hashtags" di form
                $hashtagArray = [];

                if (!empty($hashtags)) {
                    $hashtagArray = array_filter(array_map('trim', explode(',', $hashtags)));
                    // Remove duplicates dan convert ke lowercase
                    $hashtagArray = array_unique(array_map('strtolower', $hashtagArray));
                }

                // Update data pertanyaan
                $this->pertanyaanModel->update($id_pertanyaan, [
                    'judul' => $this->request->getVar("judul"),
                    'deskripsi' => nl2br($this->request->getVar("deskripsi")), // Tetap gunakan nl2br untuk format HTML
                    'hashtags' => !empty($hashtagArray) ? json_encode($hashtagArray) : null,
                    'file_attachment' => $this->request->getFile("file_attachment") ? $this->request->getFile("file_attachment")->getName() : $pertanyaan['file_attachment'],
                    'file_type' => $this->request->getFile("file_attachment") ? $this->request->getFile("file_attachment")->getMimeType() : $pertanyaan['file_type'],
                    'file_size' => $this->request->getFile("file_attachment") ? $this->request->getFile("file_attachment")->getSize() : $pertanyaan['file_size'],
                ]);

                $file = $this->request->getFile("file_attachment");
                if ($file && $file->isValid() && !$file->hasMoved()) {
                    $file->move('uploads/pertanyaan', $file->getName());
                    // Hapus file lama jika ada
                    if ($pertanyaan['file_attachment']) {
                        $oldFilePath = FCPATH . 'uploads/pertanyaan/' . $pertanyaan['file_attachment'];
                        if (file_exists($oldFilePath)) {
                            unlink($oldFilePath);
                        }
                    }
                }
                // Set flashdata untuk pesan sukses
                session()->setFlashdata('sukses', 'Pertanyaan berhasil diperbarui');
                return redirect()->to("/pertanyaan/$id_pertanyaan");
            } catch (\Exception $e) {
                // Log error
                log_message('error', 'Error updating pertanyaan: ' . $e->getMessage());
                session()->setFlashdata("gagal", "Terjadi kesalahan saat memperbarui pertanyaan");
                return redirect()->to("/pertanyaan/edit/$id_pertanyaan")->withInput();
            }
        }
        // Jika bukan POST, redirect ke halaman pertanyaan
        return redirect()->to("/pertanyaan/$id_pertanyaan");
    }


    // Fungsi untuk menghapus pertanyaan
    public function hapusPertanyaan($id_pertanyaan)
    {

        $pertanyaanModel = new PertanyaanModel();

        // Dapatkan data pertanyaan untuk mendapatkan id_penanya sebelum dihapus
        $pertanyaan = $pertanyaanModel->find($id_pertanyaan);

        // Periksa apakah pengguna sudah login
        if (!session()->has('id')) {
            session()->setFlashdata("gagal", "Harap masuk terlebih dahulu jika ingin menghapus pertanyaan");
            return redirect()->to("/masuk");
        }

        // Periksa apakah pengguna adalah penanya
        if (session()->get('id') != $pertanyaan['id_penanya']) {
            session()->setFlashdata("gagal", "Anda tidak memiliki izin untuk menghapus pertanyaan ini");
            return redirect()->to("/pertanyaan/$id_pertanyaan");
        }

        if ($pertanyaan) {
            // Hapus pertanyaan berdasarkan id_pertanyaan
            $pertanyaanModel->delete($id_pertanyaan);

            session()->setFlashdata('sukses', 'Pertanyaan berhasil dihapus.');

            // Redirect ke halaman daftar pertanyaan dengan pesan sukses
            return redirect()->to(base_url('/pertanyaan'));
        } else {
            session()->setFlashdata('gagal', 'Pertanyaan tidak ditemukan.');
            return redirect()->to(base_url('/pertanyaan'));
        }
    }

    public function getQuestionWithLikeInfo($id_pertanyaan, $id_user = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pertanyaan p');
        $builder->select('p.*, u.nama_lengkap, u.avatar');
        $builder->join('users u', 'p.id_penanya = u.id');
        $builder->where('p.id_pertanyaan', $id_pertanyaan);

        if ($id_user) {
            $builder->select('(SELECT COUNT(*) FROM pertanyaan_likes pl WHERE pl.id_pertanyaan = p.id_pertanyaan AND pl.id_user = ' . $id_user . ') as has_liked');
        }

        return $builder->get()->getRowArray(); // getRowArray() karena hanya satu record
    }

    public function downloadpertanyaan($id)
    {
        // Load model jika belum
        $model = new PertanyaanModel();

        // Ambil data pertanyaan berdasarkan ID
        $pertanyaan = $model->find($id);

        if (!$pertanyaan || empty($pertanyaan['file_attachment'])) {
            return redirect()->back()->with('errors', ['File tidak ditemukan.']);
        }

        // Handle satu file atau multi file
        $fileData = $pertanyaan['file_attachment'];
        $fileName = is_array($fileData) ? $fileData[0]['file_attachment'] ?? '' : $fileData;

        // Lokasi file di server
        $filePath = FCPATH . 'uploads/pertanyaan/' . $fileName;

        if (!file_exists($filePath)) {
            return redirect()->back()->with('errors', ['File tidak ditemukan di server.']);
        }

        return $this->response->download($filePath, null);
    }

    public function downloadjawaban($id)
    {
        // Load model jika belum
        $model = new JawabanModel();

        // Ambil data pertanyaan berdasarkan ID
        $jawaban = $model->find($id);

        if (!$jawaban || empty($jawaban['file_attachment'])) {
            return redirect()->back()->with('errors', ['File tidak ditemukan.']);
        }

        // Handle satu file atau multi file
        $fileData = $jawaban['file_attachment'];
        $fileName = is_array($fileData) ? $fileData[0]['file_attachment'] ?? '' : $fileData;

        // Lokasi file di server
        $filePath = FCPATH . 'uploads/jawaban/' . $fileName;

        if (!file_exists($filePath)) {
            return redirect()->back()->with('errors', ['File tidak ditemukan di server.']);
        }

        return $this->response->download($filePath, null);
    }

    public function searchHashtags()
    {
        // Pastikan request adalah AJAX
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid request']);
        }

        $query = $this->request->getGet('q');

        if (empty($query) || strlen($query) < 1) {
            return $this->response->setJSON([]);
        }

        try {
            // Ambil hashtag yang cocok dengan query
            $hashtags = $this->pertanyaanModel->searchHashtagsLike($query);

            return $this->response->setJSON($hashtags);
        } catch (\Exception $e) {
            log_message('error', 'Error searching hashtags: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Server error']);
        }
    }

    // Fungsi untuk mereport pertanyaan
    public function reportPertanyaan($id_pertanyaan)
    {
        // Set header untuk JSON response
        $this->response->setContentType('application/json');

        // Periksa apakah pengguna sudah login
        if (!session()->has('id')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Harap masuk terlebih dahulu jika ingin melaporkan pertanyaan'
            ]);
        }

        if ($this->request->getMethod() !== 'POST') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Metode request tidak valid'
            ]);
        }

        try {
            // Ambil user_id dari session login saat ini
            $user_id = session()->get('id'); // atau session()->get('user_id') sesuai key session Anda
            
            // Ambil data dari request
            $alasan = $this->request->getPost('alasan');
            if (empty($alasan)) {
                $jsonData = $this->request->getJSON(true);
                $alasan = $jsonData['alasan'] ?? '';
            }
            
            // Validasi input
            $alasan = trim($alasan);
            if (empty($alasan)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Alasan laporan tidak boleh kosong'
                ]);
            }

            if (strlen($alasan) < 5) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Alasan laporan minimal 5 karakter'
                ]);
            }

            // Gunakan query builder langsung untuk cek pertanyaan exists
            $db = \Config\Database::connect();
            
            // Cek apakah pertanyaan exists - coba beberapa kemungkinan tabel dan primary key
            $pertanyaan = null;
            $possible_configs = [
                ['table' => 'pertanyaan', 'pk' => 'id_pertanyaan'],
                ['table' => 'pertanyaan', 'pk' => 'id'],
                ['table' => 'pertanyaans', 'pk' => 'id_pertanyaan'],
                ['table' => 'pertanyaans', 'pk' => 'id'],
                ['table' => 'questions', 'pk' => 'id'],
            ];

            foreach ($possible_configs as $config) {
                try {
                    if ($db->tableExists($config['table'])) {
                        $query = $db->table($config['table'])
                                ->where($config['pk'], $id_pertanyaan)
                                ->get();
                        $result = $query->getRowArray();
                        
                        if ($result) {
                            $pertanyaan = $result;
                            log_message('debug', "Found question in table: {$config['table']} with PK: {$config['pk']}");
                            break;
                        }
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }

            if (!$pertanyaan) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Pertanyaan tidak ditemukan'
                ]);
            }

            // Cek user tidak bisa melaporkan pertanyaan sendiri
            if ($pertanyaan['id_penanya'] == $user_id) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Anda tidak dapat melaporkan pertanyaan yang Anda buat sendiri'
                ]);
            }


            // Cek apakah user sudah pernah melaporkan pertanyaan ini
            $existingReport = $db->table('alasan_report_pertanyaan')
                ->where('id_pertanyaan', $id_pertanyaan)
                ->where('id_user', $user_id) // Gunakan user_id dari session
                ->get()
                ->getRowArray();

            if ($existingReport) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Anda sudah pernah melaporkan pertanyaan ini'
                ]);
            }

            // Opsional: Cek apakah user tidak melaporkan pertanyaan sendiri
            // (Hanya jika Anda ingin mencegah user melaporkan pertanyaan sendiri)
            // Lewati bagian ini jika tidak diperlukan validasi tersebut
            
            // Simpan laporan dengan user_id dari session
            $reportData = [
                'id_pertanyaan' => (int)$id_pertanyaan,
                'id_user' => (int)$user_id, // Gunakan user_id dari session login
                'alasan' => $alasan,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $inserted = $db->table('alasan_report_pertanyaan')->insert($reportData);
            
            if (!$inserted) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Gagal menyimpan laporan ke database'
                ]);
            }

            // Set flashdata untuk halaman
            session()->setFlashdata('sukses', 'Pertanyaan berhasil dilaporkan. Terima kasih atas partisipasi Anda.');

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Pertanyaan berhasil dilaporkan. Terima kasih!'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error in reportPertanyaan: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ]);
        }
    }

    // Fungsi untuk mereport jawaban
    public function reportJawaban($id_jawaban)
    {
        // Set header untuk JSON response
        $this->response->setContentType('application/json');

        // Periksa apakah pengguna sudah login
        if (!session()->has('id')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Harap masuk terlebih dahulu jika ingin melaporkan pertanyaan'
            ]);
        }

        if ($this->request->getMethod() !== 'POST') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Metode request tidak valid'
            ]);
        }

        try {
            // Ambil user_id dari session login saat ini
            $user_id = session()->get('id'); // atau session()->get('user_id') sesuai key session Anda
            
            // Ambil data dari request
            $alasanjawaban = $this->request->getPost('alasanjawaban');
            if (empty($alasanjawaban)) {
                $jsonData = $this->request->getJSON(true);
                $alasanjawaban = $jsonData['alasanjawaban'] ?? '';
            }
            
            // Validasi input
            $alasanjawaban = trim($alasanjawaban);
            if (empty($alasanjawaban)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Alasan laporan tidak boleh kosong'
                ]);
            }

            if (strlen($alasanjawaban) < 5) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Alasan laporan minimal 5 karakter'
                ]);
            }

            // Gunakan query builder langsung untuk cek pertanyaan exists
            $db = \Config\Database::connect();
            
            // Cek apakah pertanyaan exists - coba beberapa kemungkinan tabel dan primary key
            $jawaban = null;
            $possible_configs = [
                ['table' => 'jawaban', 'pk' => 'id_jawaban'],
                ['table' => 'jawaban', 'pk' => 'id'],
                ['table' => 'jawabans', 'pk' => 'id_jawaban'],
                ['table' => 'jawabans', 'pk' => 'id'],
                ['table' => 'answers', 'pk' => 'id'],
            ];

            foreach ($possible_configs as $config) {
                try {
                    if ($db->tableExists($config['table'])) {
                        $query = $db->table($config['table'])
                                ->where($config['pk'], $id_jawaban)
                                ->get();
                        $result = $query->getRowArray();
                        
                        if ($result) {
                            $jawaban = $result;
                            log_message('debug', "Found question in table: {$config['table']} with PK: {$config['pk']}");
                            break;
                        }
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }

            if (!$jawaban) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Pertanyaan tidak ditemukan'
                ]);
            }

            
            // cek user tidak bisa melaporkan jawaban sendiri
            if ($jawaban['id_penjawab'] == $user_id) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Anda tidak dapat melaporkan jawaban yang Anda buat sendiri'
                ]);
            }

            // Cek apakah user sudah pernah melaporka jawaban ini
            $existingReport = $db->table('alasan_report_jawaban')
                ->where('id_jawaban', $id_jawaban)
                ->where('id_user', $user_id) // Gunakan user_id dari session
                ->get()
                ->getRowArray();

            if ($existingReport) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Anda sudah pernah melaporkan jawaban ini'
                ]);
            }

            // Opsional: Cek apakah user tidak melaporkan pertanyaan sendiri
            // (Hanya jika Anda ingin mencegah user melaporkan pertanyaan sendiri)
            // Lewati bagian ini jika tidak diperlukan validasi tersebut
            
            // Simpan laporan dengan user_id dari session
            $reportData = [
                'id_jawaban' => (int)$id_jawaban,
                'id_user' => (int)$user_id, // Gunakan user_id dari session login
                'alasan' => $alasanjawaban,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $inserted = $db->table('alasan_report_jawaban')->insert($reportData);
            
            if (!$inserted) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Gagal menyimpan laporan ke database'
                ]);
            }


            // Set flashdata untuk halaman
            session()->setFlashdata('sukses', 'Jawaban berhasil dilaporkan. Terima kasih atas partisipasi Anda.');

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Jawaban berhasil dilaporkan. Terima kasih!'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error in reportPertanyaan: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ]);
        }
    }

}
