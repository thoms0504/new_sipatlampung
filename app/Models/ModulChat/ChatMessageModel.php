<?php

namespace App\Models\ModulChat;

use CodeIgniter\Model;

class ChatMessageModel extends Model
{
    protected $table            = 'chat_messages';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['session_id', 'sender_id', 'recipient_id', 'message', 'message_type', 'message_status'];

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

    public function getSessionMessages($sessionId)
    {
        return $this->where('session_id', $sessionId)
                   ->orderBy('created_at', 'ASC')
                   ->findAll();
    }

    public function saveMessage($sessionId, $senderId, $recipientId, $message, $messageType = 'user')
    {
        return $this->insert([
            'session_id' => $sessionId,
            'sender_id' => $senderId,
            'recipient_id' => $recipientId,
            'message' => $message,
            'message_type' => $messageType
        ]);
    }

    public function markAsRead($sessionId, $userId)
    {
        return $this->where('session_id', $sessionId)
                   ->where('recipient_id', $userId)
                   ->set('message_status', 1)
                   ->update();
    }
}
