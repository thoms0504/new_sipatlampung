<?php

namespace App\Models;

use CodeIgniter\Model;

class JawabanReportModel extends Model
{
    protected $table            = 'jawabanreports';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'id_jawaban',
        'id_user',
        'alasan',
        'created_at',
        'updated_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'id_jawaban' => 'required|integer',
        'id_user'    => 'required|integer',
        'alasan'     => 'required|string|max_length[255]',
    ];

    protected $validationMessages   = [
        'id_jawaban' => [
            'required' => 'ID jawaban harus diisi.',
            'integer'  => 'ID jawaban harus berupa angka.',
        ],
        'id_user' => [
            'required' => 'ID pengguna harus diisi.',
            'integer'  => 'ID pengguna harus berupa angka.',
        ],
        'alasan' => [
            'required' => 'Alasan harus diisi.',
            'string'   => 'Alasan harus berupa teks.',
            'max_length' => 'Alasan tidak boleh lebih dari 255 karakter.',
        ],
    ];
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
}
