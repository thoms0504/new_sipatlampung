<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ModulQnA\JawabanModel;
use App\Models\ModulQnA\PertanyaanModel;
use App\Models\ModulRepo\RepoModel;

class Dasbor extends BaseController
{
    protected $jawabanModel;
    protected $pertanyaanModel;
    protected $repoModel;

    public function __construct()
    {
        $this->jawabanModel = new JawabanModel();
        $this->pertanyaanModel = new PertanyaanModel();
        $this->repoModel = new RepoModel();
    }

    public function index()
    {
        // FUNGSI DARI JAWABAN MODEL
        $judulPertanyaan = $this->pertanyaanModel->getAllJudul();
        $deskripsiPertanyaan = $this->pertanyaanModel->getAllDeskripsi();

        $allTextJP = '';
        foreach ($judulPertanyaan as $item){
            $allTextJP .= ' ' . $item['judul'];
        }

        $allText = '';
        foreach ($deskripsiPertanyaan as $item){
            $allText .= ' ' . $item['deskripsi'];
        }


        // FUNGSI DARI JAWABAN MODEL
        $jumlahLikePerBulan = $this->jawabanModel->getJumlahLikePerBulan();
        $jumlahLikeBulanIni = $this->jawabanModel->getJumlahLikeBulanIni();
        $jumlahLikeTahunIni = $this->jawabanModel->getJumlahLikeTahunIni();
        $jumlahJawabanBulanIni = $this->jawabanModel->getJumlahJawabanBulanIni();
        $jumlahJawabanTahunIni = $this->jawabanModel->getJumlahJawabanTahunIni();
        $daftarTahunjawaban = $this->jawabanModel->getDaftarTahunjawaban();
        $tahunDefaultJ = !empty($daftarTahunjawaban) ? $daftarTahunjawaban[0]['tahun'] : date('Y');
        $trenjawaban = $this->jawabanModel->getTrenJawabanPerBulan($tahunDefaultJ);
        $jumlahJawabanAOT = $this->jawabanModel->getJumlahJawabanAOT();
        $jumlahTotalLikes = $this->jawabanModel->getJumlahTotalLikes();

        // FUNGSI DARI PERTANYAAN MODEL
        $jumlahPertanyaanBulanIni = $this->pertanyaanModel->getJumlahPertanyaanBulanIni();
        $jumlahPertanyaanTahunIni = $this->pertanyaanModel->getJumlahPertanyaanTahunIni();
        $jumlahPertanyaanBelumDijawab = $this->pertanyaanModel->getJumlahPertanyaanBelumDijawab();
        $daftarTahunpertanyaan = $this->pertanyaanModel->getDaftarTahunpertanyaan();
        $tahunDefaultP = !empty($daftarTahunpertanyaan) ? $daftarTahunpertanyaan[0]['tahun'] : date('Y');
        $trenPertanyaan = $this->pertanyaanModel->getTrenPertanyaanPerBulan($tahunDefaultP);
        $jumlahPertanyaanAOT = $this->pertanyaanModel->getJumlahPertanyaanAOT();

        $data = [
            'title' => 'Dashboard | Sipat Lampung',
            'active' => 'dasbor',
            // Data dari JawabanModel
            'judul_pertanyaan' => $judulPertanyaan,
            'total_likes' => $jumlahTotalLikes,
            'all_textJP' => $allTextJP,
            'all_text' => $allText,
            'jumlah_like_per_bulan' => $jumlahLikePerBulan,
            'jumlah_like_bulan_ini' => $jumlahLikeBulanIni,
            'jumlah_like_tahun_ini' => $jumlahLikeTahunIni,
            'jumlah_jawaban_bulan_ini' => $jumlahJawabanBulanIni,
            'daftarTahunjawaban' => $daftarTahunjawaban,
            'trenjawaban' => $trenjawaban,
            'tahunDefaultJ' => $tahunDefaultJ,
            'jumlahJawabanAOT' => $jumlahJawabanAOT,

            // Data dari PertanyaanModel
            'jumlah_pertanyaan_bulan_ini' => $jumlahPertanyaanBulanIni,
            'jumlah_pertanyaan_tahun_ini' => $jumlahPertanyaanTahunIni,
            'jumlah_pertanyaan_belum_dijawab' => $jumlahPertanyaanBelumDijawab,
            'daftarTahunpertanyaan' => $daftarTahunpertanyaan,
            'trenPertanyaan' => $trenPertanyaan,
            'tahunDefaultP' => $tahunDefaultP,
            'pertanyaan_terbaru' => $this->pertanyaanModel->getPertanyaanTerbaru(3),
            'jumlahpertanyaanAOT' => $jumlahPertanyaanAOT,
        ];

        return view('Admin/dasbor', $data);
    }

    public function getDataTrenPertanyaan()
    {
        // Aktivasi debugging
        $debug = true;
        
        // Log file path
        $logFile = WRITEPATH . 'logs/ajax_debug.log';
        
        // Helper function untuk log
        $logDebug = function($message) use ($logFile, $debug) {
            if ($debug) {
                $time = date('Y-m-d H:i:s');
                file_put_contents($logFile, "[$time] $message" . PHP_EOL, FILE_APPEND);
            }
        };
        
        $logDebug("=== AJAX Request Received ===");
        $logDebug("Request Method: " . $this->request->getMethod());
        $logDebug("Is AJAX: " . ($this->request->isAJAX() ? 'Yes' : 'No'));
        
        // Dump semua POST data untuk debugging
        $postData = $this->request->getPost();
        $logDebug("POST Data: " . json_encode($postData));
        
        // Coba ambil dari beberapa sumber
        $tahun = $this->request->getPost('tahun');
        if (empty($tahun)) {
            $tahun = $this->request->getVar('tahun');
        }
        
        // Jika masih kosong, coba dari body
        if (empty($tahun)) {
            $jsonInput = $this->request->getJSON(true);
            $logDebug("JSON Input: " . json_encode($jsonInput));
            $tahun = $jsonInput['tahun'] ?? null;
        }
        
        $logDebug("Tahun yang diterima: " . ($tahun ?? 'NULL'));
        
        // Jika tahun kosong, gunakan tahun saat ini
        if (empty($tahun)) {
            $tahun = date('Y');
            $logDebug("Menggunakan tahun default: $tahun");
        }
        
        // Ambil data tren pertanyaan per bulan
        try {
            $logDebug("Memanggil model dengan tahun: $tahun");
            $data = $this->pertanyaanModel->getTrenPertanyaanPerBulan($tahun);
            $logDebug("Data hasil query: " . json_encode($data));
            
            // Pastikan struktur data sesuai harapan untuk chart
            if (!isset($data['labels']) || !isset($data['data'])) {
                $logDebug("Format data tidak sesuai, normalisasi data");
                
                $labels = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                          'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                $chartData = array_fill(0, 12, 0);
                
                // Jika data adalah array numerik sederhana, konversi ke format yang dibutuhkan
                if (is_array($data)) {
                    foreach ($data as $item) {
                        if (isset($item['bulan']) && isset($item['jumlah'])) {
                            $bulanIndex = (int)$item['bulan'] - 1; 
                            $chartData[$bulanIndex] = (int)$item['jumlah'];
                            $logDebug("Set bulan $bulanIndex = " . $item['jumlah']);
                        }
                    }
                }
                
                $data = [
                    'labels' => $labels,
                    'data' => $chartData
                ];
            }
            
            $logDebug("Final data untuk response: " . json_encode($data));
            return $this->response->setJSON($data);
            
        } catch (\Exception $e) {
            $logDebug("ERROR: " . $e->getMessage());
            return $this->response->setStatusCode(500)
                                ->setJSON([
                                    'error' => $e->getMessage(),
                                    'trace' => $e->getTraceAsString()
                                ]);
        }
    }

    
}