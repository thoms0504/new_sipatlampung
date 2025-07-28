<?php

namespace App\Models\ModulQnA;

use CodeIgniter\Model;

class JawabanModel extends Model
{
    protected $table = 'jawaban';
    protected $primaryKey = 'id_jawaban';
    protected $allowedFields = [
        'id_penjawab',
        'id_pertanyaan',
        'isi',
        'file_attachment',
        'file_type',
        'file_size',
        'likes',
        'created_at',
        'updated_at',
        'status', // Tambahkan kolom status
        'report_count', // Tambahkan kolom report_count
        'reason' // Tambahkan kolom reason untuk laporan
    ];

    protected $useTimestamps = true;
    protected $updatedField = 'updated_at';
    protected $createdField = 'created_at';

    // Get answers for a specific question, with sorting option
    public function getAnswersForQuestion($id_pertanyaan, $sort = 'newest')
    {
        $query = $this->select('jawaban.*, users.nama_lengkap, users.avatar')
                      ->join('users', 'users.id = jawaban.id_penjawab')
                      ->where('jawaban.id_pertanyaan', $id_pertanyaan);
        
        if ($sort == 'likes') {
            $query->orderBy('jawaban.likes', 'DESC')
                  ->orderBy('jawaban.created_at', 'DESC');
        } else {
            // Default: sort by newest
            $query->orderBy('jawaban.created_at', 'DESC');
        }
        
        return $query->findAll();
    }

    // Check if user has already liked a answer
    public function hasUserLikedAnswer($id_jawaban, $id_user)
    {
        $db = \Config\Database::connect();
        return $db->table('jawaban_likes')
                 ->where('id_jawaban', $id_jawaban)
                 ->where('id_user', $id_user)
                 ->countAllResults() > 0;
    }

    // Check if user has already answered
    public function hasUserAnswered($id_pertanyaan, $id_penjawab)
    {
        return $this->where([
            'id_pertanyaan' => $id_pertanyaan,
            'id_penjawab' => $id_penjawab
        ])->countAllResults() > 0;
    }

    // Get top answer for a question
    public function getTopAnswer($id_pertanyaan)
    {
        return $this->select('jawaban.*, users.nama_lengkap, users.avatar')
                    ->join('users', 'users.id = jawaban.id_penjawab')
                    ->where('jawaban.id_pertanyaan', $id_pertanyaan)
                    ->orderBy('jawaban.likes', 'DESC')
                    ->first();
    }

    // Toggle like (like or unlike)
    public function toggleLike($id_jawaban, $id_user)
    {
        $db = \Config\Database::connect();
        $db->transStart();
        
        $existingLike = $db->table('jawaban_likes')
                          ->where('id_jawaban', $id_jawaban)
                          ->where('id_user', $id_user)
                          ->get()
                          ->getRow();
        
        if ($existingLike) {
            // Unlike
            $db->table('jawaban_likes')
               ->where('id_jawaban', $id_jawaban)
               ->where('id_user', $id_user)
               ->delete();
            
            $this->set('likes', 'likes - 1', false)
                 ->where('id_jawaban', $id_jawaban)
                 ->update();
            
            $result = 'unliked';
        } else {
            // Like
            $db->table('jawaban_likes')->insert([
                'id_jawaban' => $id_jawaban,
                'id_user' => $id_user,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            
            $this->set('likes', 'likes + 1', false)
                 ->where('id_jawaban', $id_jawaban)
                 ->update();
            
            $result = 'liked';
        }
        
        $db->transComplete();
        return $result;
    }

    // Get total jawaban
    public function getTotalJawaban($id_pertanyaan)
    {
        return $this->where('id_pertanyaan', $id_pertanyaan)
                    ->countAllResults();
    }

    // Get answers with like information for the logged-in user
    public function getAnswersWithLikeInfo($id_pertanyaan, $id_user = null, $sort = 'newest')
{
    $builder = $this->db->table('jawaban j');
    $builder->select('j.*, u.nama_lengkap, u.avatar');
    $builder->join('users u', 'j.id_penjawab = u.id');
    $builder->where('j.id_pertanyaan', $id_pertanyaan);
    
    // Tambahkan sorting berdasarkan parameter
    if ($sort === 'most_liked') {
        $builder->orderBy('j.likes', 'DESC');
    } else {
        $builder->orderBy('j.created_at', 'DESC');
    }
    
    return $builder->get()->getResultArray();
}

    // Increment like count for a jawaban
    public function incrementLikeCount($id_jawaban)
    {
        return $this->set('likes', 'likes + 1', false)
                    ->where('id_jawaban', $id_jawaban)
                    ->update();
    }

    // Decrement like count for a jawaban
    public function decrementLikeCount($id_jawaban)
    {
        return $this->set('likes', 'likes - 1', false)
                    ->where('id_jawaban', $id_jawaban)
                    ->update();
    }

    // Fungsi 1: Mendapatkan jumlah jawaban setiap bulannya pada suatu tahun tertentu
    public function getTrenJawabanPerBulan($tahun)
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

    public function getDaftarTahunjawaban()
    {
        // Ambil daftar tahun unik dari kolom created_at
        return $this->db->table('jawaban')
                        ->select('YEAR(created_at) as tahun')
                        ->groupBy('YEAR(created_at)')
                        ->orderBy('tahun', 'DESC')
                        ->get()
                        ->getResultArray();
    }

    // Fungsi 2: Mendapatkan jumlah like setiap bulannya pada suatu tahun tertentu
    public function getJumlahLikePerBulan()
    {
        // Ambil tahun yang ada di database
        $builder = $this->db->table($this->table);
        $builder->select("YEAR(created_at) as tahun");
        $builder->groupBy("YEAR(created_at)");
        $builder->orderBy("tahun", "DESC");
        $query = $builder->get();

        // Jika tidak ada data, kembalikan array kosong
        if (empty($query->getResultArray())) {
            return [];
        }

        // Ambil tahun terbaru dari database
        $tahun = $query->getRowArray()['tahun'];

        // Query untuk mendapatkan jumlah like per bulan pada tahun tersebut
        $builder = $this->db->table($this->table);
        $builder->select("MONTH(created_at) as bulan, SUM(likes) as jumlah");
        $builder->where("YEAR(created_at)", $tahun);
        $builder->groupBy("MONTH(created_at)");
        $query = $builder->get();

        // Format hasil query ke dalam array asosiatif
        $result = $query->getResultArray();

        // Buat array untuk menyimpan jumlah like per bulan (1-12)
        $jumlahLikePerBulan = array_fill(1, 12, 0);

        // Isi array dengan data dari query
        foreach ($result as $row) {
            $jumlahLikePerBulan[$row['bulan']] = $row['jumlah'];
        }

        return [
            'tahun' => $tahun,
            'data' => $jumlahLikePerBulan
        ];
    }

    // Fungsi 3: Mendapatkan jumlah like pada bulan ini
    public function getJumlahLikeBulanIni()
    {
        $builder = $this->db->table($this->table);
        $builder->select("SUM(likes) as jumlah");
        $builder->where("MONTH(created_at)", date('m'));
        $builder->where("YEAR(created_at)", date('Y'));
        $query = $builder->get();

        return $query->getRowArray()['jumlah'] ?? 0;
    }

    // Fungsi 4: Mendapatkan jumlah like pada tahun ini
    public function getJumlahLikeTahunIni()
    {
        $builder = $this->db->table($this->table);
        $builder->select("SUM(likes) as jumlah");
        $builder->where("YEAR(created_at)", date('Y'));
        $query = $builder->get();

        return $query->getRowArray()['jumlah'] ?? 0;
    }

    // Fungsi 5: Mendapatkan jumlah jawaban pada bulan ini
    public function getJumlahJawabanBulanIni()
    {
        $builder = $this->db->table($this->table);
        $builder->select("COUNT(*) as jumlah");
        $builder->where("MONTH(created_at)", date('m'));
        $builder->where("YEAR(created_at)", date('Y'));
        $query = $builder->get();

        return $query->getRowArray()['jumlah'] ?? 0;
    }

    // Fungsi 6: Mendapatkan jumlah jawaban pada tahun ini
    public function getJumlahJawabanTahunIni()
    {
        $builder = $this->db->table($this->table);
        $builder->select("COUNT(*) as jumlah");
        $builder->where("YEAR(created_at)", date('Y'));
        $query = $builder->get();

        return $query->getRowArray()['jumlah'] ?? 0;
    }

    public function simpanJawaban($data)
    {
        // Mulai transaksi database (opsional, untuk memastikan konsistensi)
        $this->db->transStart();

        // Simpan jawaban ke tabel jawaban
        $this->insert($data);

        // Update status pertanyaan di tabel pertanyaan
        $pertanyaanModel = new \App\Models\ModulQnA\PertanyaanModel();
        $pertanyaanModel->updateStatusPertanyaan($data['id_pertanyaan'], 1);

        // Selesaikan transaksi
        $this->db->transComplete();

        // Kembalikan true jika transaksi berhasil
        return $this->db->transStatus();
    }

    public function getDaftarTahunlike()
    {
        // Ambil daftar tahun unik dari kolom created_at
        return $this->db->table('jawaban')
                        ->select('YEAR(created_at) as tahun')
                        ->groupBy('YEAR(created_at)')
                        ->orderBy('tahun', 'DESC')
                        ->get()
                        ->getResultArray();
    }
    public function getJumlahJawabanAOT(){
        $builder = $this->db->table($this->table);
        $builder->select("COUNT(*) as jumlah");
        $query = $builder->get();

        return $query->getRowArray()['jumlah'];
    }

    public function getJumlahTotalLikes(){
        $builder = $this->db->table($this->table);
        $builder->selectSum('likes');
        $query = $builder->get();
        
        return $query->getRowArray()['likes'];
    }

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
}