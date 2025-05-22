<?php

namespace App\Models\ModulRepo;

use CodeIgniter\Model;

class RepoModel extends Model
{
    protected $table            = 'repo';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['judul','slug','tim','kategori','tgl_upload','file','deskripsi'];
    // Dates
    protected $useTimestamps = false;
    
    public function  getFile($slug = false)
    {
    if ($slug == false){
        return $this->findAll();
    }
    return $this->where(['slug' => $slug])->first();
    }

    public function search($keyword){
        return $this->table('repo')->like('judul',$keyword)->orLike('tim',$keyword);
    }
}