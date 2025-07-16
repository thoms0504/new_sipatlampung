<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateLikePertanyaan extends Migration
{
    public function up()
    {
        // Tambahkan kolom likes ke tabel pertanyaan
        $fields = [
            'likes' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'after' => 'updated_at'
            ]
        ];
        $this->forge->addColumn('pertanyaan', $fields);

    }

    public function down()
    {
        // Hapus kolom likes dari tabel pertanyaan jika migrasi di-rollback
        $this->forge->dropColumn('pertanyaan', 'likes');
    }
}
