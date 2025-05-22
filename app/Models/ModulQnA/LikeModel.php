<?php

namespace App\Models\ModulQnA;

use CodeIgniter\Model;

class LikeModel extends Model
{
    protected $table = 'likes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_jawaban', 'id_user'];
    protected $useTimestamps = true;
}
