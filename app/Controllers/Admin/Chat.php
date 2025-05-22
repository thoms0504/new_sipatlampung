<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ModulUtama\UserModel;
use App\Models\ModulChat\ChatSessionModel;
use App\Models\ModulChat\ChatMessageModel;
use App\Models\ModulChat\PdfModel;
use App\Models\ModulChat\AITrainingModel;
use CodeIgniter\HTTP\ResponseInterface;

class Chat extends BaseController
{
    protected $userModel;
    protected $chatSessionModel;
    protected $chatMessageModel;
    protected $pdfPublicationModel;
    protected $aiTrainingDataModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->chatSessionModel = new ChatSessionModel();
        $this->chatMessageModel = new ChatMessageModel();
        $this->pdfPublicationModel = new PdfModel();
        $this->aiTrainingDataModel = new AITrainingModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $data = [
            'title' => 'Chat Management | Admin',
            'active' => 'chat',
        ];

        if (!isset($_SESSION['id'])) {
            session()->setFlashdata('gagal', 'Silahkan login terlebih dahulu.');
            return redirect()->to(base_url('masuk'));
        }

        $id = $_SESSION['id'];
        $user = $this->userModel->find($id);
        
        if ($user['role'] !== 'admin') {
            session()->setFlashdata('gagal', 'Akses ditolak. Hanya admin yang dapat mengakses halaman ini.');
            return redirect()->to(base_url('chat'));
        }

        // Get chat statistics
        $data['total_sessions'] = $this->chatSessionModel->countAll();
        $data['total_messages'] = $this->chatMessageModel->countAll();
        $data['active_sessions'] = $this->chatSessionModel->where('status', 'active')->countAllResults();
        $data['total_publications'] = $this->pdfPublicationModel->countAll();

        // Get recent sessions
        $data['recent_sessions'] = $this->chatSessionModel
            ->select('chat_sessions.*, users.nama_lengkap')
            ->join('users', 'users.id = chat_sessions.user_id')
            ->orderBy('chat_sessions.updated_at', 'DESC')
            ->limit(10)
            ->findAll();

        return view('Admin/chat/index', $data);
    }

    public function sessions()
    {
        $data = [
            'title' => 'Chat Sessions | Admin',
            'active' => 'chat',
        ];

        if (!$this->checkAdminAccess()) {
            return redirect()->to(base_url('masuk'));
        }

        // Get all sessions with user info
        $data['sessions'] = $this->chatSessionModel
            ->select('chat_sessions.*, users.nama_lengkap, users.email')
            ->join('users', 'users.id = chat_sessions.user_id')
            ->orderBy('chat_sessions.updated_at', 'DESC')
            ->findAll();

        return view('Admin/chat/sessions', $data);
    }

    public function viewSession($sessionId)
    {
        if (!$this->checkAdminAccess()) {
            return redirect()->to(base_url('masuk'));
        }

        $session = $this->chatSessionModel
            ->select('chat_sessions.*, users.nama_lengkap, users.email')
            ->join('users', 'users.id = chat_sessions.user_id')
            ->find($sessionId);

        if (!$session) {
            session()->setFlashdata('gagal', 'Sesi chat tidak ditemukan.');
            return redirect()->to(base_url('admin/chat/sessions'));
        }

        $data = [
            'title' => 'View Session | Admin',
            'active' => 'chat',
            'session' => $session,
            'messages' => $this->chatMessageModel->getSessionMessages($sessionId)
        ];

        return view('Admin/chat/view_session', $data);
    }

    public function publications()
    {
        $data = [
            'title' => 'PDF Publications | Admin',
            'active' => 'chat',
        ];

        if (!$this->checkAdminAccess()) {
            return redirect()->to(base_url('masuk'));
        }

        $data['publications'] = $this->pdfPublicationModel
            ->select('pdf_publications.*, users.nama_lengkap as uploaded_by_name')
            ->join('users', 'users.id = pdf_publications.uploaded_by')
            ->orderBy('pdf_publications.created_at', 'DESC')
            ->findAll();

        return view('Admin/chat/publications', $data);
    }

    public function uploadPublication()
    {
        $data = [
            'title' => 'Upload Publication | Admin',
            'active' => 'chat',
        ];

        if (!$this->checkAdminAccess()) {
            return redirect()->to(base_url('masuk'));
        }

        return view('Admin/chat/upload_publication', $data);
    }

    public function savePublication()
    {
        if (!$this->checkAdminAccess()) {
            return redirect()->to(base_url('masuk'));
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'title' => 'required|min_length[3]|max_length[255]',
            'description' => 'permit_empty|max_length[1000]',
            'category' => 'permit_empty|max_length[100]',
            'tags' => 'permit_empty|max_length[500]',
            'pdf_file' => 'uploaded[pdf_file]|max_size[pdf_file,10240]|ext_in[pdf_file,pdf]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            session()->setFlashdata('gagal', 'Validasi gagal: ' . implode(', ', $validation->getErrors()));
            return redirect()->back()->withInput();
        }

        $file = $this->request->getFile('pdf_file');
        
        if ($file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $filePath = 'uploads/publications/';
            
            // Create directory if not exists
            if (!is_dir(WRITEPATH . $filePath)) {
                mkdir(WRITEPATH . $filePath, 0777, true);
            }
            
            $file->move(WRITEPATH . $filePath, $fileName);

            $publicationData = [
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'file_path' => $filePath . $fileName,
                'file_name' => $fileName,
                'file_size' => $file->getSize(),
                'category' => $this->request->getPost('category'),
                'tags' => $this->request->getPost('tags'),
                'uploaded_by' => session()->get('id')
            ];

            $publicationId = $this->pdfPublicationModel->insert($publicationData);

            if ($publicationId) {
                // Extract text from PDF for AI training (basic implementation)
                $this->extractPdfContent($publicationId, WRITEPATH . $filePath . $fileName);
                
                session()->setFlashdata('sukses', 'Publikasi berhasil diupload dan diproses untuk AI training.');
                return redirect()->to(base_url('admin/chat/publications'));
            }
        }

        session()->setFlashdata('gagal', 'Gagal mengupload file.');
        return redirect()->back()->withInput();
    }

    public function deletePublication($id)
    {
        if (!$this->checkAdminAccess()) {
            return redirect()->to(base_url('masuk'));
        }

        $publication = $this->pdfPublicationModel->find($id);
        
        if (!$publication) {
            session()->setFlashdata('gagal', 'Publikasi tidak ditemukan.');
            return redirect()->to(base_url('admin/chat/publications'));
        }

        // Delete file
        if (file_exists(WRITEPATH . $publication['file_path'])) {
            unlink(WRITEPATH . $publication['file_path']);
        }

        // Delete from database (will cascade delete training data)
        if ($this->pdfPublicationModel->delete($id)) {
            session()->setFlashdata('sukses', 'Publikasi berhasil dihapus.');
        } else {
            session()->setFlashdata('gagal', 'Gagal menghapus publikasi.');
        }

        return redirect()->to(base_url('admin/chat/publications'));
    }

    public function trainingData()
    {
        $data = [
            'title' => 'AI Training Data | Admin',
            'active' => 'chat',
        ];

        if (!$this->checkAdminAccess()) {
            return redirect()->to(base_url('masuk'));
        }

        $data['training_data'] = $this->aiTrainingDataModel
            ->select('ai_training_data.*, pdf_publications.title as publication_title')
            ->join('pdf_publications', 'pdf_publications.id = ai_training_data.publication_id')
            ->orderBy('ai_training_data.created_at', 'DESC')
            ->findAll();

        return view('admin/chat/training_data', $data);
    }

    public function analytics()
    {
        $data = [
            'title' => 'Chat Analytics | Admin',
            'active' => 'chat',
        ];

        if (!$this->checkAdminAccess()) {
            return redirect()->to(base_url('masuk'));
        }

        // Get analytics data
        $data['daily_messages'] = $this->getDailyMessageStats();
        $data['popular_topics'] = $this->getPopularTopics();
        $data['user_engagement'] = $this->getUserEngagementStats();

        return view('admin/chat/analytics', $data);
    }

    private function checkAdminAccess()
    {
        if (!isset($_SESSION['id'])) {
            session()->setFlashdata('gagal', 'Silahkan login terlebih dahulu.');
            return false;
        }

        $id = $_SESSION['id'];
        $user = $this->userModel->find($id);
        
        if ($user['role'] !== 'admin') {
            session()->setFlashdata('gagal', 'Akses ditolak. Hanya admin yang dapat mengakses halaman ini.');
            return false;
        }

        return true;
    }

    private function extractPdfContent($publicationId, $filePath)
    {
        // Basic PDF text extraction - you might want to use a more sophisticated library
        try {
            // For now, save a placeholder - implement actual PDF parsing here
            $content = "Konten PDF akan diekstrak menggunakan library PDF parser yang sesuai.";
            
            $this->aiTrainingDataModel->saveTrainingData(
                $publicationId,
                $content,
                1,
                'Extracted Content',
                'pdf, publikasi, data'
            );
        } catch (\Exception $e) {
            log_message('error', 'PDF extraction failed: ' . $e->getMessage());
        }
    }

    private function getDailyMessageStats()
    {
        $db = \Config\Database::connect();
        $query = $db->query("
            SELECT DATE(created_at) as date, COUNT(*) as count 
            FROM chat_messages 
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
            GROUP BY DATE(created_at)
            ORDER BY date
        ");
        
        return $query->getResultArray();
    }

    private function getPopularTopics()
    {
        // Simple implementation - you can enhance this
        $db = \Config\Database::connect();
        $query = $db->query("
            SELECT 
                CASE 
                    WHEN LOWER(message) LIKE '%data%' OR LOWER(message) LIKE '%statistik%' THEN 'Data & Statistik'
                    WHEN LOWER(message) LIKE '%ekonomi%' THEN 'Ekonomi'
                    WHEN LOWER(message) LIKE '%demografi%' OR LOWER(message) LIKE '%penduduk%' THEN 'Demografi'
                    WHEN LOWER(message) LIKE '%sosial%' THEN 'Sosial'
                    ELSE 'Lainnya'
                END as topic,
                COUNT(*) as count
            FROM chat_messages 
            WHERE message_type = 'user'
            AND created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
            GROUP BY topic
            ORDER BY count DESC
        ");
        
        return $query->getResultArray();
    }

    private function getUserEngagementStats()
    {
        $db = \Config\Database::connect();
        $query = $db->query("
            SELECT 
                u.nama_lengkap,
                COUNT(DISTINCT cs.id) as total_sessions,
                COUNT(cm.id) as total_messages,
                MAX(cm.created_at) as last_activity
            FROM users u
            LEFT JOIN chat_sessions cs ON u.id = cs.user_id
            LEFT JOIN chat_messages cm ON cs.id = cm.session_id AND cm.message_type = 'user'
            WHERE u.role = 'user'
            GROUP BY u.id, u.nama_lengkap
            HAVING total_messages > 0
            ORDER BY total_messages DESC
            LIMIT 10
        ");
        
        return $query->getResultArray();
    }
}
