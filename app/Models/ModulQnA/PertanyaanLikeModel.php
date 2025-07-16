<?php

namespace App\Models\ModulQnA;

use CodeIgniter\Model;

class PertanyaanLikeModel extends Model
{
    protected $table = 'pertanyaan_likes';
    protected $primaryKey = 'id_likes';
    protected $allowedFields = ['id_pertanyaan', 'id_user', 'created_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = false;
}
