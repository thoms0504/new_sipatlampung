<?php

namespace App\Controllers\ModulQnA;

use App\Controllers\BaseController;
use App\Models\ModulQnA\JawabanModel;
use App\Models\ModulQnA\PertanyaanModel;
use App\Models\ModulUtama\UserModel;
use App\Models\ModulQnA\LikeModel;
use Config\Services;
use Codeigniter\Exceptions\PageNotFoundException;
use Config\Database;

class TanyaJawab extends BaseController
{
    protected $pertanyaanModel;
    protected $jawabanModel;
    protected $userModel;
    protected $likeModel;

    public function __construct()
    {
        $this->pertanyaanModel = new PertanyaanModel();
        $this->jawabanModel = new JawabanModel();
        $this->userModel = new UserModel();
        $this->likeModel = new LikeModel();
    }

    public function index()
    {
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $pertanyaan = $this->pertanyaanModel->search($keyword);
        } else {
            $pertanyaan = $this->pertanyaanModel;
        }
        helper('text');
        $data = [
            'title' => 'Semua Pertanyaan | Sipat Lampung',
            'keyword' => $keyword,
            'active' => 'qna',
            'pertanyaan' => $pertanyaan->orderBy('created_at', 'desc')->paginate(10, 'pertanyaan'),
            'pager' => $pertanyaan->pager,
        ];
        if (isset($_SESSION['id']) && $_SESSION['role'] != 'user') {
            session()->setFlashdata("gagal", "Hanya pengguna yang memiliki akses fitur ini di portal utama");
            return redirect()->to("/admin/qna");
        } else {
            return view('PortalUtama/modul_qna/index', $data);
        }
    }

    public function buatpertanyaan()
    {
        $data = [
            'title' => 'Buat Pertanyaan | Sipat Lampung',
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
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pertanyaan harus diisi'
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi pertanyaan harus diisi'
                ]
            ]
        ])) {
            // Jika validasi gagal, kembali ke form dengan input sebelumnya
            return redirect()->to('/pertanyaan/create')->withInput();
        }

        // Periksa apakah pengguna sudah login
        if (!session()->has('id')) {
            session()->setFlashdata("gagal", "Harap masuk terlebih dahulu jika ingin membuat pertanyaan");
            return redirect()->to("/masuk");
        }

        // Periksa apakah method request adalah POST
        if ($this->request->getMethod() == 'POST') {
            // Ambil data pengguna berdasarkan ID dari session
            $penanya = $this->userModel->where('id', session()->get('id'))->first();

            // Simpan pertanyaan ke database
            $this->pertanyaanModel->save([
                'id_penanya' => $penanya['id'],
                'judul' => $this->request->getVar("judul"),
                'deskripsi' => nl2br($this->request->getVar("deskripsi")),
                'status' => 0
            ]);

            session()->setFlashdata('sukses', 'Pertanyaan berhasil ditambahkan');
            return redirect()->to("/pertanyaan");
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

    // Ambil sorting parameter dari URL (default: newest)
    $sort = $this->request->getGet('sort');
    if (!in_array($sort, ['newest', 'most_liked'])) {
        $sort = 'newest'; // Default sort jika parameter tidak valid
    }

    // Ambil jawaban beserta informasi like (passing parameter sort)
    $jawaban = $this->jawabanModel->getAnswersWithLikeInfo($id, session()->get('id'), $sort);

    $data = [
        'title' => esc($pertanyaan['judul']) . ' | Sipat Lampung',
        'active' => 'qna',
        'pertanyaan' => $pertanyaan,
        'owner' => $owner,
        'penanya' => $this->userModel->where('id', $pertanyaan['id_penanya'])->first(),
        'jawaban' => $jawaban,
        'validation' => Services::validation(),
        'sort' => $sort, // Tambahkan sort ke data untuk view
    ];

    return view('PortalUtama/modul_qna/detail', $data);
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
        if (!$this->validate([
            'isi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Isi Jawaban anda"
                ]
            ]
        ])) {
            return redirect()->to("/pertanyaan/$id_pertanyaan")->withInput();
        }

        // Periksa apakah pengguna sudah login
        if (!session()->has('id')) {
            session()->setFlashdata("gagal", "Harap masuk terlebih dahulu jika ingin menjawab pertanyaan");
            return redirect()->to("/masuk");
        }

        // Ambil data penjawab dari session
        $penjawab = $this->userModel->where('id', session()->get('id'))->first();

        // Data jawaban baru
        $data = [
            'id_penjawab' => $penjawab['id'],
            'id_pertanyaan' => $id_pertanyaan,
            'isi' => nl2br($this->request->getVar("isi")),
            'likes' => 0 // Default likes = 0
        ];

        // Simpan jawaban dan update status pertanyaan
        if ($this->jawabanModel->simpanJawaban($data)) {
            session()->setFlashdata('sukses', 'Jawaban berhasil ditambahkan');
        } else {
            session()->setFlashdata('gagal', 'Terjadi kesalahan saat menyimpan jawaban');
        }

        return redirect()->to("/pertanyaan/$id_pertanyaan");
    }

    // Fungsi tambahan untuk like jawaban
    public function likeJawaban($id_jawaban)
    {
        // Cek apakah user sudah login
        if (!session()->get('id')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Login diperlukan'
            ]);
        }

        $userId = session()->get('id');
        $jawaban = $this->jawabanModel->find($id_jawaban);

        if (!$jawaban) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Jawaban tidak ditemukan'
            ]);
        }

        // Toggle like menggunakan JawabanModel
        $result = $this->jawabanModel->toggleLike($id_jawaban, $userId);

        return $this->response->setJSON([
            'success' => true,
            'result' => $result
        ]);
    }

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
}
