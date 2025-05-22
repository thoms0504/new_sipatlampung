<?php

namespace App\Models\ModulChat;

use CodeIgniter\Model;

class AITrainingModel extends Model
{
    protected $table            = 'ai_training_data';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['publication_id', 'content', 'page_number', 'section', 'keywords'];

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

    public function getTrainingDataByPublication($publicationId)
    {
        return $this->where('publication_id', $publicationId)
                   ->orderBy('page_number', 'ASC')
                   ->findAll();
    }

    public function searchTrainingData($keyword)
    {
        return $this->like('content', $keyword)
                   ->orLike('keywords', $keyword)
                   ->findAll();
    }

    public function saveTrainingData($publicationId, $content, $pageNumber = null, $section = null, $keywords = null)
    {
        return $this->insert([
            'publication_id' => $publicationId,
            'content' => $content,
            'page_number' => $pageNumber,
            'section' => $section,
            'keywords' => $keywords
        ]);
    }
}
