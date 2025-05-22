<?php

namespace App\Models\ModulQnA;

use CodeIgniter\Model;

class PertanyaanModel extends Model
{
    protected $table = 'pertanyaan';
    protected $primaryKey = 'id_pertanyaan';
    protected $allowedFields = [
        'id_penanya', 
        'judul', 
        'deskripsi', 
        'file_attachment',
        'file_type',
        'file_size',
        'status'
    ];

    protected $useTimestamps = true;
    protected $updatedField = 'updated_at';
    protected $createdField = 'created_at';

    // Validate question creation limit
    public function canCreateQuestion($userId, $maxQuestions = 10)
    {
        $userQuestionCount = $this->where('id_penanya', $userId)->countAllResults();
        return $userQuestionCount < $maxQuestions;
    }

    // Search questions
    public function search($keyword)
    {
        return $this->like('judul', $keyword)
                    ->orLike('deskripsi', $keyword)
                    ->orderBy('created_at', 'DESC');
    }

    // Get questions with user details
    public function getQuestionsWithUserDetails()
    {
        return $this->select('pertanyaan.*, users.nama_lengkap as nama_penanya')
                    ->join('users', 'users.id = pertanyaan.id_penanya')
                    ->orderBy('pertanyaan.created_at', 'DESC')
                    ->findAll();
    }

    // Validate file upload
    public function validateFileUpload($file)
    {
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 
                        'application/pdf', 'application/msword', 
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
        
        $maxSize = 5 * 1024 * 1024; // 5MB
        
        if (!$file->isValid()) {
            return ['status' => false, 'message' => 'File tidak valid'];
        }
        
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            return ['status' => false, 'message' => 'Tipe file tidak diizinkan. Hanya gambar (JPG, PNG, GIF) dan dokumen (PDF, DOC, DOCX, XLS, XLSX) yang diperbolehkan.'];
        }
        
        if ($file->getSize() > $maxSize) {
            return ['status' => false, 'message' => 'Ukuran file terlalu besar. Maksimal 5MB.'];
        }
        
        return ['status' => true, 'message' => 'File valid'];
    }

    // Handle file upload
    public function handleFileUpload($file, $uploadPath = 'uploads/pertanyaan/')
    {
        if (!$file->isValid()) {
            return false;
        }

        // Buat direktori jika belum ada
        if (!is_dir(WRITEPATH . $uploadPath)) {
            mkdir(WRITEPATH . $uploadPath, 0755, true);
        }

        // Generate nama file unik
        $fileName = $file->getRandomName();
        
        // Pindahkan file
        if ($file->move(WRITEPATH . $uploadPath, $fileName)) {
            return [
                'file_name' => $fileName,
                'file_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'file_path' => $uploadPath . $fileName
            ];
        }
        
        return false;
    }

    // Get file extension for display
    public function getFileIcon($fileType)
    {
        $icons = [
            'image/jpeg' => 'fas fa-image',
            'image/jpg' => 'fas fa-image',
            'image/png' => 'fas fa-image',
            'image/gif' => 'fas fa-image',
            'application/pdf' => 'fas fa-file-pdf',
            'application/msword' => 'fas fa-file-word',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'fas fa-file-word',
            'application/vnd.ms-excel' => 'fas fa-file-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'fas fa-file-excel'
        ];
        
        return $icons[$fileType] ?? 'fas fa-file';
    }

    // Check if file is image
    public function isImage($fileType)
    {
        $imageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        return in_array($fileType, $imageTypes);
    }

    // Delete file attachment
    public function deleteFileAttachment($fileName, $uploadPath = 'uploads/pertanyaan/')
    {
        $filePath = WRITEPATH . $uploadPath . $fileName;
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        return false;
    }

    public function getTrenPertanyaanPerBulan($tahun)
    {
        $builder = $this->db->table($this->table);
        $query = $builder->select('MONTH(created_at) as bulan, COUNT(*) as jumlah')
                       ->where('YEAR(created_at)', $tahun)
                       ->groupBy('bulan')
                       ->orderBy('bulan')
                       ->get();

        // Untuk debugging
        $sql = $this->db->getLastQuery();
        log_message('debug', "SQL Query: {$sql}");
        
        $result = $query->getResultArray();
        log_message('debug', "Query Result: " . json_encode($result));
        
        // Inisialisasi array untuk 12 bulan
        $data = array_fill(0, 12, 0);
        $labels = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        // Isi data sesuai hasil query
        foreach ($result as $row) {
            $bulanIndex = (int)$row['bulan'] - 1; // Index 0-11 untuk bulan 1-12
            $data[$bulanIndex] = (int)$row['jumlah'];
        }

        $finalData = [
            'labels' => $labels,
            'data' => $data
        ];
        
        return $finalData;
    }

    // Fungsi untuk mendapatkan jumlah pertanyaan pada bulan ini
    public function getJumlahPertanyaanBulanIni()
    {
        // Ambil bulan dan tahun saat ini
        $bulan = date('m'); // Bulan saat ini (format: 01-12)
        $tahun = date('Y'); // Tahun saat ini (format: 2023)

        return $this->where('MONTH(created_at)', $bulan) // Filter berdasarkan bulan
                    ->where('YEAR(created_at)', $tahun)  // Filter berdasarkan tahun
                    ->countAllResults(); // Hitung jumlah hasil
    }

    // Fungsi untuk mendapatkan jumlah pertanyaan pada tahun ini
    public function getJumlahPertanyaanTahunIni()
    {
        $builder = $this->db->table($this->table);
        $builder->select("COUNT(*) as jumlah");
        $builder->where("YEAR(created_at)", date('Y'));
        $query = $builder->get();

        return $query->getRowArray()['jumlah'];
    }

    // Fungsi untuk mengupdate status pertanyaan
    public function updateStatusPertanyaan($id_pertanyaan, $status)
    {
        return $this->update($id_pertanyaan, ['status' => $status]);
    }

    // Fungsi untuk mendapatkan jumlah pertanyaan yang belum dijawab
    public function getJumlahPertanyaanBelumDijawab()
    {
        return $this->where('status', 0)->countAllResults();
    }

    public function getPertanyaanTerbaru($count)
    {
        return $this->db->table('pertanyaan')
            ->join('users', 'users.id = pertanyaan.id_penanya', 'left')
            ->select('pertanyaan.*, users.nama_lengkap, users.id')
            ->orderBy('pertanyaan.created_at', 'DESC')
            ->limit($count)
            ->get()->getResultArray();
    }
    
    public function getDaftarTahunpertanyaan()
    {
        // Ambil daftar tahun unik dari kolom created_at
        return $this->db->table('pertanyaan')
                        ->select('YEAR(created_at) as tahun')
                        ->groupBy('YEAR(created_at)')
                        ->orderBy('tahun', 'DESC')
                        ->get()
                        ->getResultArray();
    }

    public function getJumlahPertanyaanAOT(){
        $builder = $this->db->table($this->table);
        $builder->select("COUNT(*) as jumlah");
        $query = $builder->get();

        return $query->getRowArray()['jumlah'];
    }

    public function getAllJudul(){
        return $this->select('judul')->findAll();
    }
    
    public function getAllDeskripsi(){
        return $this->select('deskripsi')->findAll();
    }
}