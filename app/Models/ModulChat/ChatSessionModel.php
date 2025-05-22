<?php

namespace App\Models\ModulChat;

use CodeIgniter\Model;

class ChatSessionModel extends Model
{
    protected $table            = 'chat_sessions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'session_title', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getUserSessions($userId)
    {
        return $this->where('user_id', $userId)
                   ->orderBy('updated_at', 'DESC')
                   ->findAll();
    }

    public function createNewSession($userId, $title = 'New Chat Session')
    {
        // Deactivate other sessions for this user
        $this->where('user_id', $userId)->set('status', 'inactive')->update();
        
        // Create new active session
        return $this->insert([
            'user_id' => $userId,
            'session_title' => $title,
            'status' => 'active'
        ]);
    }

    public function activateSession($sessionId, $userId)
    {
        // Deactivate other sessions for this user
        $this->where('user_id', $userId)->set('status', 'inactive')->update();
        
        // Activate selected session
        return $this->update($sessionId, ['status' => 'active']);
    }
}
