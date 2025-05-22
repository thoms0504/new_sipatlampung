<?php

namespace App\Models\ModulChat;

use CodeIgniter\Model;

class PdfModel extends Model
{
    protected $table            = 'pdf_publications';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['title', 'description', 'file_path', 'file_name', 'file_size', 'category', 'tags', 'is_active', 'uploaded_by'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'title' => 'required|min_length[3]|max_length[255]',
        'file_path' => 'required',
        'file_name' => 'required',
        'uploaded_by' => 'required|numeric'
    ];
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

    public function getActivePublications()
    {
        return $this->where('is_active', 1)
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }

    public function getPublicationsByCategory($category)
    {
        return $this->where('category', $category)
                   ->where('is_active', 1)
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }

    public function searchPublications($keyword)
    {
        return $this->like('title', $keyword)
                   ->orLike('description', $keyword)
                   ->orLike('tags', $keyword)
                   ->where('is_active', 1)
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }
}
